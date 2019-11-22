<?php
/*
 * Plugin Name: WooCommerce Custom Product Data Fields
 * Plugin URI: http://risbl.co/wp/woocommerce-custom-product-data-fields-plugin/
 * Description: Simple framework which will help you to build extra product data fields, e.g. secondary product title, vendor info, custom message for individual product, etc.
 * Version: 1.0.2
 * Author: Kharis Sulistiyono
 * Author URI: http://kharisulistiyo.github.io
 * Requires at least: 3.1
 * Tested up to: 4.4.1
 *
 * Text Domain: wc_cpdf
 * Domain Path: /lang/
 *
 * Copyright: @ 2016 Kharis Sulistiyono.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


// Required minimum version of WordPress.
if ( ! function_exists( 'wc_productdata_options_wp_required' ) ) {
	function wc_productdata_options_wp_required() {
		global $wp_version;
		$plugin      = plugin_basename( __FILE__ );
		$plugin_data = get_plugin_data( __FILE__, false );

		if ( version_compare( $wp_version, "3.3", "<" ) ) {
			if ( is_plugin_active( $plugin ) ) {
				deactivate_plugins( $plugin );
				wp_die( "'" . $plugin_data['Name'] . "' requires WordPress 3.3 or higher, and has been deactivated! Please upgrade WordPress and try again.<br /><br />Back to <a href='" . admin_url() . "'>WordPress Admin</a>." );
			}
		}
	}
}
add_action( 'admin_init', 'wc_productdata_options_wp_required' );

// Checks if the WooCommerce plugins is installed and active.
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	require_once dirname( __FILE__ ) . '/class-wc-product-data-fields.php';

}
