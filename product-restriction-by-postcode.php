<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://ersolucoesweb.com.br
 * @since             1.0.0
 * @package           Product_Restriction_By_Postcode
 *
 * @wordpress-plugin
 * Plugin Name:       Product Restriction By Postcode
 * Plugin URI:        https://ersolucoesweb.com.br/product-restriction-by-postcode
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            ER Soluções Web LTDA
 * Author URI:        https://ersolucoesweb.com.br
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       product-restriction-by-postcode
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

include 'acf.php';

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PRODUCT_RESTRICTION_BY_POSTCODE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-product-restriction-by-postcode-activator.php
 */
function activate_product_restriction_by_postcode() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-product-restriction-by-postcode-activator.php';
	Product_Restriction_By_Postcode_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-product-restriction-by-postcode-deactivator.php
 */
function deactivate_product_restriction_by_postcode() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-product-restriction-by-postcode-deactivator.php';
	Product_Restriction_By_Postcode_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_product_restriction_by_postcode' );
register_deactivation_hook( __FILE__, 'deactivate_product_restriction_by_postcode' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-product-restriction-by-postcode.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

session_start();
// if(isset($_SESSION['product_restriction_by_postcode'])) {
// 	unset($_SESSION['product_restriction_by_postcode']);
// }
function product_restriction_by_postcode_save_postcode() {
	$data = json_decode(file_get_contents('php://input'));
	$_SESSION['product_restriction_by_postcode'] = $data->postcode;
	WC()->customer->set_shipping_postcode(wc_clean($data->postcode));
	WC()->customer->set_billing_postcode(wc_clean($data->postcode));
	wp_send_json( $data );
}
function run_product_restriction_by_postcode() {

	$plugin = new Product_Restriction_By_Postcode();

	add_action('wp_footer', function(){
		include 'templates/popup.php';
	});

	add_action('wp_ajax_nopriv_save_postcode', 'product_restriction_by_postcode_save_postcode');
	add_action('wp_ajax_save_postcode', 'product_restriction_by_postcode_save_postcode');


	add_action('wp', function(){
		global $wpdb, $post;
		if(is_product()) {
			if(isset($_SESSION['product_restriction_by_postcode'])) {
				$postcode = (int)$_SESSION['product_restriction_by_postcode'];
				$sql = "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '{$post->ID}' AND meta_key LIKE 'faixas_de_cep_%_de' AND {$postcode} >= meta_value AND meta_value != '' AND meta_value IS NOT NULL";
				$de = $wpdb->get_col($sql);
				$sql = "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '{$post->ID}' AND meta_key LIKE 'faixas_de_cep_%_ate' AND {$postcode} <= meta_value AND meta_value != '' AND meta_value IS NOT NULL";
				$ate = $wpdb->get_col($sql);
				$sql = "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '{$post->ID}' AND meta_key LIKE 'ceps_especificos_%_cep' AND {$postcode} = meta_value AND meta_value != '' AND meta_value IS NOT NULL";
				$cep = $wpdb->get_col($sql);
				$restricted = (count($de) && count($ate)) || count($cep);
				if($restricted) {
					define('RESTRICTED', $restricted);
					remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
					add_action('woocommerce_single_product_summary', function(){
						include 'templates/restriction.php';
					}, 31);
				}
			}
		}
	} );


	$plugin->run();

}
run_product_restriction_by_postcode();