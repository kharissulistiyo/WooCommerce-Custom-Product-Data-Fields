<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

/**
 * @class        WC_Product_Data_Fields
 * @version        1.0.2
 * @category    Class
 * @author        Kharis Sulistiyono
 */

if ( ! class_exists( 'WC_Product_Data_Fields' ) ) {

	class WC_Product_Data_Fields {

		public static $plugin_prefix;
		public static $plugin_url;
		public static $plugin_path;
		public static $plugin_basefile;

		private $options_data = false;

		/**
		 * Constructor
		 */
		public function __construct() {

			WC_Product_Data_Fields::$plugin_prefix   = 'wc_productdata_options_';
			WC_Product_Data_Fields::$plugin_basefile = plugin_basename( __FILE__ );
			WC_Product_Data_Fields::$plugin_url      = plugin_dir_url( WC_Product_Data_Fields::$plugin_basefile );
			WC_Product_Data_Fields::$plugin_path     = trailingslashit( dirname( __FILE__ ) );
			add_action( 'woocommerce_init', array( &$this, 'init' ) );

		}


		/**
		 * enqueue_scripts function.
		 *
		 * @access public
		 * @return void
		 */
		public function enqueue_scripts() {

			wp_enqueue_style( 'wcpdf-main-css', plugins_url( 'assets/css/wcpdf-main.css', __FILE__ ), array(), '1.0.2' );
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wcpdf-main-js', plugins_url( 'assets/js/wcpdf-main.js', __FILE__ ), array(
				'jquery',
				'wp-color-picker',
				'jquery-ui-datepicker'
			), '', true );

		}

		/**
		 * Gets saved data
		 * It is used for displaying the data value in template file
		 * @return array
		 */
		public function get_value( $post_id, $field_id ) {

			$meta_value = get_post_meta( $post_id, 'wc_productdata_options', true );
			$meta_value = $meta_value[0];

			return ( isset( $meta_value[ $field_id ] ) ) ? $meta_value[ $field_id ] : '';

		}


		/**
		 * Init WooCommerce Custom Product Data Fields extension once we know WooCommerce is active
		 *
		 * @return void
		 */
		public function init() {

			add_action( 'woocommerce_product_write_panel_tabs', array( $this, 'product_write_panel_tab' ) );
			add_action( 'woocommerce_product_write_panels', array( $this, 'product_write_panel' ) );
			add_action( 'woocommerce_process_product_meta', array( $this, 'product_save_data' ), 10, 2 );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		}


		/**
		 * Create fields via hook
		 * @return null if no hook applied
		 */
		public function wc_cpdf_fields() {

			return apply_filters( 'wc_cpdf_init', null );

		}


		/**
		 * Adds a new tab to the Product Data postbox in the admin product interface
		 *
		 * @return string
		 */
		public function product_write_panel_tab() {

			$fields = $this->wc_cpdf_fields();

			if ( $fields == null ) {
				return;
			}

			foreach ( $fields as $key => $fields_array ) {

				foreach ( $fields_array as $field ) {
					if ( isset( $field['tab_name'] ) && $field['tab_name'] != '' ) {
						$href = "#" . $key;
						echo "<li class=" . $key . "><a href=" . $href . ">" . $field['tab_name'] . "</a></li>";
					}
				}

			}


		}


		/**
		 * Adds the panel to the Product Data postbox in the product interface
		 *
		 * @return string
		 */
		public function product_write_panel() {

			global $post;

			// Pull the field data out of the database
			$available_fields   = array();
			$available_fields[] = maybe_unserialize( get_post_meta( $post->ID, 'wc_productdata_options', true ) );

			if ( $available_fields ) {

				// Display fields panel
				foreach ( $available_fields as $available_field ) {

					$fields = $this->wc_cpdf_fields();

					if ( $fields == null ) {
						return;
					}


					foreach ( $fields as $key => $fields_array ) {

						echo '<div id="' . $key . '" class="panel woocommerce_options_panel wc_cpdf_tab">';

						foreach ( $fields_array as $field ) {

							if ( ! isset( $field['tab_name'] )  ) {

								WC_Product_Data_Fields::wc_product_data_options_fields( $field );

							}

						}

						echo '</div>';

					}


				}

			}


		}


		/**
		 * Create Fields
		 *
		 * @param $field array
		 *
		 * @return string
		 */
		public function wc_product_data_options_fields( $field ) {
			global $thepostid, $post, $woocommerce;

			$fieldtype = isset( $field['type'] ) ? $field['type'] : '';
			$field_id  = isset( $field['id'] ) ? $field['id'] : '';

			$thepostid = empty( $thepostid ) ? $post->ID : $thepostid;


			$options_data = maybe_unserialize( get_post_meta( $thepostid, 'wc_productdata_options', true ) );

			switch ( $fieldtype ) {

				case 'text':
					$thepostid              = empty( $thepostid ) ? $post->ID : $thepostid;
					$field['placeholder']   = isset( $field['placeholder'] ) ? $field['placeholder'] : '';
					$field['class']         = isset( $field['class'] ) ? $field['class'] : 'short';
					$field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
					$field['value']         = isset( $field['value'] ) ? $field['value'] : get_post_meta( $thepostid, $field['id'], true );
					$field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];
					$field['type']          = isset( $field['type'] ) ? $field['type'] : 'text';

					$inputval = isset( $options_data[0][ $field_id ] ) ? $options_data[0][ $field_id ] : '';

					echo '<p class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '"><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label><input type="' . esc_attr( $field['type'] ) . '" class="' . esc_attr( $field['class'] ) . '" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $inputval ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '"' . ( isset( $field['style'] ) ? ' style="' . $field['style'] . '"' : '' ) . ' /> ';

					if ( ! empty( $field['description'] ) ) {

						if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
							echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . esc_url( WC()->plugin_url() ) . '/assets/images/help.png" height="16" width="16" />';
						} else {
							echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
						}

					}

					echo '</p>';
					break;

				case 'number':
					$thepostid              = empty( $thepostid ) ? $post->ID : $thepostid;
					$field['placeholder']   = isset( $field['placeholder'] ) ? $field['placeholder'] : '';
					$field['class']         = isset( $field['class'] ) ? $field['class'] : 'short';
					$field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
					$field['value']         = isset( $field['value'] ) ? $field['value'] : get_post_meta( $thepostid, $field['id'], true );
					$field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];
					$field['type']          = isset( $field['type'] ) ? $field['type'] : 'text';

					$inputval = isset( $options_data[0][ $field_id ] ) ? $options_data[0][ $field_id ] : '';

					echo '<p class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '"><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label><input type="' . esc_attr( $field['type'] ) . '" class="' . esc_attr( $field['class'] ) . '" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $inputval ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '"' . ( isset( $field['style'] ) ? ' style="' . $field['style'] . '"' : '' ) . ' /> ';

					if ( ! empty( $field['description'] ) ) {

						if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
							echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . esc_url( WC()->plugin_url() ) . '/assets/images/help.png" height="16" width="16" />';
						} else {
							echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
						}

					}

					echo '</p>';
					break;

				case 'textarea':
					if ( ! $thepostid ) {
						$thepostid = $post->ID;
					}
					if ( ! isset( $field['placeholder'] ) ) {
						$field['placeholder'] = '';
					}
					if ( ! isset( $field['class'] ) ) {
						$field['class'] = 'short';
					}
					if ( ! isset( $field['value'] ) ) {
						$field['value'] = get_post_meta( $thepostid, $field['id'], true );
					}

					$inputval = isset( $options_data[0][ $field_id ] ) ? $options_data[0][ $field_id ] : '';

					echo '<p class="form-field ' . $field['id'] . '_field"><label for="' . $field['id'] . '">' . $field['label'] . '</label><textarea class="' . $field['class'] . '" name="' . $field['id'] . '" id="' . $field['id'] . '" placeholder="' . $field['placeholder'] . '" rows="2" cols="20"' . ( isset( $field['style'] ) ? ' style="' . $field['style'] . '"' : '' ) . '">' . esc_textarea( $inputval ) . '</textarea>';

					if ( ! empty( $field['description'] ) ) {

						if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
							echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . esc_url( WC()->plugin_url() ) . '/assets/images/help.png" height="16" width="16" />';
						} else {
							echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
						}

					}

					echo '</p>';
					break;


				case 'checkbox':
					$thepostid              = empty( $thepostid ) ? $post->ID : $thepostid;
					$field['class']         = isset( $field['class'] ) ? $field['class'] : 'checkbox';
					$field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
					$field['value']         = isset( $options_data[0][ $field_id ] ) ? $options_data[0][ $field_id ] : '';
					$field['cbvalue']       = isset( $field['cbvalue'] ) ? $field['cbvalue'] : 'yes';
					$field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];

					echo '<p class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '"><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label><input type="checkbox" class="' . esc_attr( $field['class'] ) . '" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['cbvalue'] ) . '" ' . checked( $field['value'], $field['cbvalue'], false ) . ' /> ';

					if ( ! empty( $field['description'] ) ) {

						if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
							echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . esc_url( WC()->plugin_url() ) . '/assets/images/help.png" height="16" width="16" />';
						} else {
							echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
						}

					}

					echo '</p>';
					break;

				case 'select':
					$thepostid              = empty( $thepostid ) ? $post->ID : $thepostid;
					$field['class']         = isset( $field['class'] ) ? $field['class'] : 'select short';
					$field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
					$field['value']         = isset( $options_data[0][ $field_id ] ) ? $options_data[0][ $field_id ] : '';

					echo '<p class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '"><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label><select id="' . esc_attr( $field['id'] ) . '" name="' . esc_attr( $field['id'] ) . '" class="' . esc_attr( $field['class'] ) . '">';

					foreach ( $field['options'] as $key => $value ) {

						echo '<option value="' . esc_attr( $key ) . '" ' . selected( esc_attr( $field['value'] ), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';

					}

					echo '</select> ';

					if ( ! empty( $field['description'] ) ) {

						if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
							echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . esc_url( WC()->plugin_url() ) . '/assets/images/help.png" height="16" width="16" />';
						} else {
							echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
						}

					}
					echo '</p>';
					break;


				case 'radio':
					$thepostid              = empty( $thepostid ) ? $post->ID : $thepostid;
					$field['class']         = isset( $field['class'] ) ? $field['class'] : 'select short';
					$field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
					$field['value']         = isset( $options_data[0][ $field_id ] ) ? $options_data[0][ $field_id ] : '';
					$field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];

					echo '<fieldset class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '"><legend style="float:left; width:150px;">' . wp_kses_post( $field['label'] ) . '</legend><ul class="wc-radios" style="width: 25%; float:left;">';

					foreach ( $field['options'] as $key => $value ) {

						echo '<li style="padding-bottom: 3px; margin-bottom: 0;"><label style="float:none; width: auto; margin-left: 0;"><input
                  		name="' . esc_attr( $field['name'] ) . '"
                  		value="' . esc_attr( $key ) . '"
                  		type="radio"
                  		class="' . esc_attr( $field['class'] ) . '"
                  		' . checked( esc_attr( $field['value'] ), esc_attr( $key ), false ) . '
                  		/> ' . esc_html( $value ) . '</label>
              	</li>';
					}
					echo '</ul>';

					if ( ! empty( $field['description'] ) ) {

						if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
							echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . esc_url( WC()->plugin_url() ) . '/assets/images/help.png" height="16" width="16" />';
						} else {
							echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
						}

					}

					echo '</fieldset>';
					break;


				case 'hidden':
					$thepostid      = empty( $thepostid ) ? $post->ID : $thepostid;
					$field['value'] = isset( $field['value'] ) ? $field['value'] : $options_data[0][ $field_id ];
					$field['class'] = isset( $field['class'] ) ? $field['class'] : '';

					echo '<input type="hidden" class="' . esc_attr( $field['class'] ) . '" name="' . esc_attr( $field['id'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) . '" /> ';

					break;


				case 'multiselect':

					global $wc_cpdf;

					if ( ! $thepostid ) {
						$thepostid = $post->ID;
					}
					if ( ! isset( $field['placeholder'] ) ) {
						$field['placeholder'] = '';
					}
					if ( ! isset( $field['class'] ) ) {
						$field['class'] = 'short';
					}
					if ( ! isset( $field['value'] ) ) {
						$field['value'] = get_post_meta( $thepostid, $field['id'], true );
					}

					$inputval = isset( $options_data[0][ $field_id ] ) ? $options_data[0][ $field_id ] : '';

					$html = '<p class="form-field ' . $field['id'] . '_field"><label for="' . $field['id'] . '">' . $field['label'] . '</label>';

					$html .= '';

					$html .= '<select multiple="multiple" class="multiselect wc-enhanced-select ' . $field['class'] . '" name="' . esc_attr( $field['id'] ) . '[]" style="width: 90%;"  data-placeholder="' . $field['placeholder'] . '">';

					$saved_val = $this->get_value( $thepostid, $field['id'] ) ? $this->get_value( $thepostid, $field['id'] ) : array();

					foreach ( $field['options'] as $key => $value ) {

						$html .= '<option value="' . esc_attr( $key ) . '" ' . selected( in_array( $key, $saved_val ), true, false ) . '>' . esc_html( $value ) . '</option>';

					}

					$html .= '</select>';

					if ( ! empty( $field['description'] ) ) {

						if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
							$html .= '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . esc_url( WC()->plugin_url() ) . '/assets/images/help.png" height="16" width="16" />';
						} else {
							$html .= '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
						}

					}

					$html .= '</p>';

					echo $html;

					break;


				case 'image':

					global $wc_cpdf;

					$saved_image           = $this->get_value( $thepostid, $field['id'] );
					$saved_image_url       = wp_get_attachment_image_src( $saved_image );
					$saved_image_url_thumb = wp_get_attachment_image_src( $saved_image, 'thumbnail', true );

					?>

                    <div class="image-field-wrapper form-field">

                        <div class="image-field-label">

							<?php echo '<span>' . $field['label'] . '</span>'; ?>

                        </div>

                        <div id="image-uploader-meta-box" class="image-field-upload">

                            <div class="preview-image-wrapper">

								<?php if ( $saved_image ) : ?>

                                    <img class="wcpdf_saved_image"
                                         src="<?php echo esc_url( $saved_image_url_thumb[0] ); ?>" alt=""/>
                                    <a href="#"
                                       class="remove_image wcpdf-remove-image"><em><?php echo __( 'Remove', 'wc_cpdf' ); ?></em></a>

								<?php endif; ?>

                            </div>

                            <input class="wcpdf_image_id" type="hidden" name="<?php echo esc_attr( $field['id'] ); ?>"
                                   value="<?php echo ( $saved_image ) ? $saved_image : ''; ?>"/>
                            <input class="wcpdf_image_url" type="hidden"
                                   name="wcpdf_image_url_<?php echo $field['id']; ?>"
                                   value="<?php echo ( $saved_image ) ? $saved_image_url[0] : ''; ?>"/>
                            <a class="wcpdf-uppload-image button" href="#"
                               data-uploader-title="<?php echo __( 'Choose image', 'wc_cpdf' ) ?>"
                               data-uploader-button-text="<?php echo __( 'Choose image', 'wc_cpdf' ) ?>"><?php echo __( 'Choose image', 'wc_cpdf' ) ?></a>

							<?php
							if ( ! empty( $field['description'] ) ) {

								if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
									echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . esc_url( WC()->plugin_url() ) . '/assets/images/help.png" height="16" width="16" />';
								} else {
									echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
								}

							}
							?>

                        </div>

                    </div><!-- /.image-field-wrapper -->

					<?php

					break;

				case 'gallery':

					global $wc_cpdf;

					$saved_gallery = $this->get_value( $thepostid, $field['id'] );

					?>

                    <div class="image-field-wrapper gallery form-field">

                        <div class="image-field-label">

							<?php echo '<span>' . $field['label'] . '</span>'; ?>

                        </div>

                        <div id="image-uploader-meta-box" class="image-field-upload">

                            <div class="preview-image-wrapper">

								<?php

								if ( is_array( $saved_gallery ) ): foreach ( $saved_gallery as $img_id ) {
									$saved_image_url       = wp_get_attachment_image_src( $img_id );
									$saved_image_url_thumb = wp_get_attachment_image_src( $img_id, 'thumbnail', true );

									?>

                                    <div class="gal-item">
                                        <img class="wcpdf_saved_image"
                                             src="<?php echo esc_url( $saved_image_url_thumb[0] ); ?>" alt=""/>
                                        <a href="#"
                                           class="remove_image wcpdf-remove-image"><em><?php echo __( 'Remove', 'wc_cpdf' ); ?></em></a>
                                        <input type="hidden" name="<?php echo esc_attr( $field['id'] ); ?>[]"
                                               value="<?php echo esc_attr( $img_id ); ?>"/>
                                    </div>

								<?php } endif; ?>

                            </div>

                            <input class="wcpdf_image_id" type="hidden"
                                   data-name="<?php echo esc_attr( $field['id'] ); ?>" name="name-needle" value=""/>
                            <input class="wcpdf_image_url" type="hidden"
                                   name="wcpdf_image_url_<?php echo $field['id']; ?>"
                                   value="<?php echo ( $saved_image ) ? $saved_image_url[0] : ''; ?>"/>
                            <a class="wcpdf-uppload-image-gallery button" href="#"
                               data-uploader-title="<?php echo __( 'Choose images', 'wc_cpdf' ) ?>"
                               data-uploader-button-text="<?php echo __( 'Choose images', 'wc_cpdf' ) ?>"><?php echo __( 'Choose images', 'wc_cpdf' ) ?></a>

							<?php
							if ( ! empty( $field['description'] ) ) {

								if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
									echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . esc_url( WC()->plugin_url() ) . '/assets/images/help.png" height="16" width="16" />';
								} else {
									echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
								}

							}
							?>

                        </div>

                    </div><!-- /.image-field-wrapper -->

					<?php
					break;


				case 'color':

					$thepostid              = empty( $thepostid ) ? $post->ID : $thepostid;
					$field['placeholder']   = isset( $field['placeholder'] ) ? $field['placeholder'] : '';
					$field['class']         = isset( $field['class'] ) ? $field['class'] : 'short';
					$field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
					$field['value']         = isset( $field['value'] ) ? $field['value'] : get_post_meta( $thepostid, $field['id'], true );
					$field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];
					$field['type']          = isset( $field['type'] ) ? $field['type'] : 'text';

					$inputval = isset( $options_data[0][ $field_id ] ) ? $options_data[0][ $field_id ] : '';

					echo '<p class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '"><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label><input type="text" class="' . esc_attr( $field['class'] ) . ' wc_cpdf_colorpicker" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $inputval ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '"' . ( isset( $field['style'] ) ? ' style="' . $field['style'] . '"' : '' ) . ' /> ';

					if ( ! empty( $field['description'] ) ) {

						if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
							echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . esc_url( WC()->plugin_url() ) . '/assets/images/help.png" height="16" width="16" />';
						} else {
							echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
						}

					}

					echo '</p>';

					break;


				case 'datepicker':

					$thepostid              = empty( $thepostid ) ? $post->ID : $thepostid;
					$field['placeholder']   = isset( $field['placeholder'] ) ? $field['placeholder'] : '';
					$field['class']         = isset( $field['class'] ) ? $field['class'] : 'short';
					$field['wrapper_class'] = isset( $field['wrapper_class'] ) ? $field['wrapper_class'] : '';
					$field['value']         = isset( $field['value'] ) ? $field['value'] : get_post_meta( $thepostid, $field['id'], true );
					$field['name']          = isset( $field['name'] ) ? $field['name'] : $field['id'];
					$field['type']          = isset( $field['type'] ) ? $field['type'] : 'text';

					$inputval = isset( $options_data[0][ $field_id ] ) ? $options_data[0][ $field_id ] : '';

					echo '<p class="form-field ' . esc_attr( $field['id'] ) . '_field ' . esc_attr( $field['wrapper_class'] ) . '"><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label><input type="text" class="' . esc_attr( $field['class'] ) . ' wc_cpdf_datepicker" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $inputval ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '"' . ( isset( $field['style'] ) ? ' style="' . $field['style'] . '"' : '' ) . ' /> ';

					if ( ! empty( $field['description'] ) ) {

						if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
							echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . esc_url( WC()->plugin_url() ) . '/assets/images/help.png" height="16" width="16" />';
						} else {
							echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
						}

					}

					echo '</p>';

					break;


				case 'divider':

					echo '<hr class="divider" />';

					break;


			}


		}


		/**
		 * Saves the data inputed into the product boxes, as post meta data
		 * identified by the name 'wc_productdata_options'
		 *
		 * @param int $post_id the post (product) identifier
		 * @param stdClass $post the post (product)
		 *
		 * @return void
		 */
		public function product_save_data( $post_id, $post ) {

			$options_value = array();

			/** field name in pairs array **/
			$data_args = array();
			$fields    = $this->wc_cpdf_fields();

			if ( $fields == null ) {
				return;
			}

			foreach ( $fields as $key => $fields_array ) {

				foreach ( $fields_array as $data ) {
					$name                     = $data['id'];
					$data_args[ $data['id'] ] = maybe_unserialize( $_POST[ $data['id'] ] );
				}

			}

			$options_value[] = $data_args;

			// save the data to the database
			update_post_meta( $post_id, 'wc_productdata_options', $options_value );

		}


	}

}


/**
 * Instantiate Class
 */

$wc_cpdf = new WC_Product_Data_Fields();
