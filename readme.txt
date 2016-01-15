=== WooCommerce Custom Product Data Fields ===
Contributors: kharisblank
Tags: ecommerce, e-commerce, commerce, woocommerce, extension, product, tab, framework
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ACYNA5XNUGBUL
Requires at least: 3.1
Tested up to: 3.9.1
Stable tag: 1.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

WooCommerce extension which will help you to build extra product data fields easily.

== Description ==

WooCommerce Custom Product Data Fields is a simple framework which will help you to build extra product data fields easily, e.g. secondary product title, vendor info, custom message for individual product, etc.

You can use this plugin as a library of your ‘brand-new’ WooCommerce Extension.

= Available Fields =

* text
* number
* textarea
* checkbox
* select
* radio
* hidden
* multiselect
* image
* gallery
* colorpicker
* datepicker
* devider

= Defining Your Fields =

<code>
/**
 * WooCommerce product data tab definition
 *
 * @return array
 */

add_action('wc_cpdf_init', 'prefix_custom_product_data_tab_init', 10, 0);
if(!function_exists('prefix_custom_product_data_tab_init')) :

   function prefix_custom_product_data_tab_init(){


     $custom_product_data_fields = array();


     /** First product data tab starts **/
     /** ===================================== */

     $custom_product_data_fields['custom_data_1'] = array(

       array(
             'tab_name'    => __('Custom Data', 'wc_cpdf'),
       ),

       array(
             'id'          => '_mytext',
             'type'        => 'text',
             'label'       => __('Text', 'wc_cpdf'),
             'placeholder' => __('A placeholder text goes here.', 'wc_cpdf'),
             'class'       => 'large',
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'id'          => '_mynumber',
             'type'        => 'number',
             'label'       => __('Number', 'wc_cpdf'),
             'placeholder' => __('Number.', 'wc_cpdf'),
             'class'       => 'short',
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'id'          => '_mytextarea',
             'type'        => 'textarea',
             'label'       => __('Textarea', 'wc_cpdf'),
             'placeholder' => __('A placeholder text goes here.', 'wc_cpdf'),
             'style'       => 'width:70%;height:140px;',
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'id'          => '_mycheckbox',
             'type'        => 'checkbox',
             'label'       => __('Checkbox', 'wc_cpdf'),
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'id'          => '_myselect',
             'type'        => 'select',
             'label'       => __('Select', 'wc_cpdf'),
             'options'     => array(
                 'option_1'  => 'Option 1',
                 'option_2'  => 'Option 2',
                 'option_3'  => 'Option 3'
             ),
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'id'          => '_myradio',
             'type'        => 'radio',
             'label'       => __('Radio', 'wc_cpdf'),
             'options'     => array(
                   'radio_1' => 'Radio 1',
                   'radio_2' => 'Radio 2',
                   'radio_3' => 'Radio 3'
             ),
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'id'         => '_myhidden',
             'type'       => 'hidden',
             'value'      => 'Hidden Value',
       ),

       array(
             'id'         => '_mymultiselect',
             'type'       => 'multiselect',
             'label'      => __('Multiselect', 'wc_cpdf'),
             'placeholder' => __('Multiselect maan!', 'wc_cpdf'),
             'options'     => array(
                   'option_1' => 'Option 1',
                   'option_2' => 'Option 2',
                   'option_3' => 'Option 3',
                   'option_4' => 'Option 4',
                   'option_5' => 'Option 5'
             ),
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
             'class'       => 'medium'
       ),

       // image
       array(
             'id'         => '_myimage',
             'type'       => 'image',
             'label'      => __('Image 1', 'wc_cpdf'),
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'id'         => '_mygallery',
             'type'       => 'gallery',
             'label'      => __('Gallery', 'wc_cpdf'),
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       // Color
       array(
             'id'          => '_mycolor',
             'type'        => 'color',
             'label'       => __('Select color', 'wc_cpdf'),
             'placeholder' => __('A placeholder text goes here.', 'wc_cpdf'),
             'class'       => 'large',
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       // Datepicker

       array(
             'id'          => '_mydatepicker',
             'type'        => 'datepicker',
             'label'       => __('Select date', 'wc_cpdf'),
             'placeholder' => __('A placeholder text goes here.', 'wc_cpdf'),
             'class'       => 'large',
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       ),

       array(
             'type'        => 'divider'
       )

     );

     /** First product data tab ends **/
     /** ===================================== */


     /** Second product data tab starts **/
     /** ===================================== */

     $custom_product_data_fields['custom_data_2'] = array(

       array(
             'tab_name'    => __('Custom Data 2', 'wc_cpdf'),
       ),

       array(
             'id'          => '_mytext_2',
             'type'        => 'text',
             'label'       => __('Text ABCD', 'wc_cpdf'),
             'placeholder' => __('A placeholder text goes here.', 'wc_cpdf'),
             'class'       => 'large',
             'description' => __('Field description.', 'wc_cpdf'),
             'desc_tip'    => true,
       )

     );

     return $custom_product_data_fields;

   }

endif;

</code>


= Getting The Field Value =

<code>
/**
  *
  * $wc_cpdf->get_value($post_id, $field_id);
  * $post_id = (integer) post ID
  * $field_id = (string) unique field ID
  *
 */

global $wc_cpdf;
echo $wc_cpdf->get_value(get_the_ID(), '_mytext');
</code>


Retrieving multiselect value

<pre>
global $wc_cpdf;
$multiselect = $wc_cpdf->get_value($post->ID, '_mymultiselect');
foreach ($multiselect as $value) {
  echo $value;
}
</pre>

Retrieving image value

<pre>
global $wc_cpdf;
$image_id = $wc_cpdf->get_value($post->ID, '_myimage');
$size = 'thumbnail';
$image_attachment = wp_get_attachment_image($image_id, $size);
echo $image_attachment;
</pre>

Retrieving gallery value

<pre>
global $wc_cpdf;
$gallery = $wc_cpdf->get_value($post->ID, '_mygallery');
foreach ($gallery as $image_id) {

  $image_id = $wc_cpdf->get_value($post->ID, '_mygallery');
  $size = 'thumbnail';
  $image_attachment = wp_get_attachment_image($image_id, $size);

  echo $image_attachment;

}
</pre>


This project is also available on [Github](https://github.com/kharissulistiyo/WooCommerce-Custom-Product-Data-Fields).

= More info =

Send me your question to my contacts below:

Mail: [kharisulistiyo(at)gmail(dot)com](mailto:kharisulistiyo@gmail.com)
Twitter:  [@kharissulistiyo](http://twitter.com/kharissulistiyo)

P.S: Don't be worry, I always reply. :)


== Installation ==

1. Upload this plugin to the /wp-content/plugins/ directory.
2. Activate the plugin through the Plugins menu in WordPress.
3. Define your custom product data fields in your theme `functions.php` file. See `fields-init.php` inside this plugin folder.

== Screenshots ==

1. WooCommerce Custom Product Data Fields

== Changelog ==

= 1.0.2 =
* Fix some bugs
* Add multiselect field
* Add image field
* Add image field
* Add gallery field
* Add colorpicker field
* Add datepicker field
* Add devider
* Allow multiple data tabs definition
* Update fields definition function (via hook)

= 1.0 =
* Initial release
