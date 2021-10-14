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
 * @package           Restringir_Produto_Por_Cep
 *
 * @wordpress-plugin
 * Plugin Name:       Restringir produto por CEP
 * Plugin URI:        https://ersolucoesweb.com.br/restringir-produto-por-cep
 * Description:       Restrinja produto por faixa de CEPs ou CEPs específicos
 * Version:           1.0.0
 * Author:            ER Soluções Web LTDA
 * Author URI:        https://ersolucoesweb.com.br
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       restringir-produto-por-cep
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RESTRINGIR_PRODUTO_POR_CEP_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-restringir-produto-por-cep-activator.php
 */
function activate_restringir_produto_por_cep() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-restringir-produto-por-cep-activator.php';
	Restringir_Produto_Por_Cep_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-restringir-produto-por-cep-deactivator.php
 */
function deactivate_restringir_produto_por_cep() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-restringir-produto-por-cep-deactivator.php';
	Restringir_Produto_Por_Cep_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_restringir_produto_por_cep' );
register_deactivation_hook( __FILE__, 'deactivate_restringir_produto_por_cep' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-restringir-produto-por-cep.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function restringir_produto_por_cep_save_postcode() {
    $data = json_decode(file_get_contents('php://input'));
    $data->postcode = preg_replace('/[^\d]+/i', '', $data->postcode);
	WC()->customer->set_shipping_postcode(wc_clean($data->postcode));
	WC()->customer->set_billing_postcode(wc_clean($data->postcode));
	wp_send_json( $data );
}
function run_restringir_produto_por_cep() {
	$plugin = new Restringir_Produto_Por_Cep();
	add_action('wp_footer', function(){
		include 'templates/popup.php';
	});
	add_action('wp_ajax_nopriv_save_postcode', 'restringir_produto_por_cep_save_postcode');
	add_action('wp_ajax_save_postcode', 'restringir_produto_por_cep_save_postcode');
	add_action('wp', function(){
		global $wpdb, $post;
		if(is_product()) {
            $postcode = WC()->customer->get_billing_postcode();
			if($postcode) {
				$sql = "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '{$post->ID}' AND meta_key LIKE '_faixas_de_cep|de|%' AND {$postcode} >= REPLACE(meta_value, '-', '') AND meta_value != '' AND meta_value IS NOT NULL";
				$de = $wpdb->get_col($sql);
				$sql = "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '{$post->ID}' AND meta_key LIKE '_faixas_de_cep|ate|%' AND {$postcode} <= REPLACE(meta_value, '-', '') AND meta_value != '' AND meta_value IS NOT NULL";
				$ate = $wpdb->get_col($sql);
				$sql = "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '{$post->ID}' AND meta_key LIKE '_ceps_especificos|cep|%' AND {$postcode} = REPLACE(meta_value, '-', '') AND meta_value != '' AND meta_value IS NOT NULL";
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
    add_filter('woocommerce_calculated_shipping', function(){
	    WC()->customer->set_billing_postcode(wc_clean($_POST['calc_shipping_postcode']));
	    WC()->customer->set_shipping_postcode(wc_clean($_POST['calc_shipping_postcode']));
    }, 10, 2);
    add_action( 'woocommerce_check_cart_items', function () {
        global $wpdb;
        $items = WC()->cart->get_cart();
        if (count($items)) {
            $postcode = WC()->customer->get_billing_postcode();
            foreach ($items as $item) {
                $postcode = preg_replace('/[^\d]+/i', '', $postcode);
                if ($postcode) {
                    $sql = "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '{$item['product_id']}' AND meta_key LIKE '_faixas_de_cep|de|%' AND {$postcode} >= REPLACE(meta_value, '-', '') AND meta_value != '' AND meta_value IS NOT NULL";
                    $de = $wpdb->get_col($sql);
                    $sql = "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '{$item['product_id']}' AND meta_key LIKE '_faixas_de_cep|ate|%' AND {$postcode} <= REPLACE(meta_value, '-', '') AND meta_value != '' AND meta_value IS NOT NULL";
                    $ate = $wpdb->get_col($sql);
                    $sql = "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = '{$item['product_id']}' AND meta_key LIKE '_ceps_especificos|cep|%' AND {$postcode} = REPLACE(meta_value, '-', '') AND meta_value != '' AND meta_value IS NOT NULL";
                    $cep = $wpdb->get_col($sql);
                    $restricted = (count($de) && count($ate)) || count($cep);
                    if ($restricted) {
                        remove_action( 'woocommerce_proceed_to_checkout','woocommerce_button_proceed_to_checkout', 20);
                        wc_add_notice( sprintf(__("O item %s não está disponível no seu CEP", 'restringir-produto-por-cep' ), $item['data']->get_title()), 'error' );
                    }
                }
            }
        }
    } );
    add_action( 'after_setup_theme', function () {
        require_once( 'vendor/autoload.php' );
        Carbon_Fields\Carbon_Fields::boot();
    });

    add_action( 'carbon_fields_register_fields',  function () {
        require_once( 'vendor/autoload.php' );
        Carbon_Fields\Container::make( 'post_meta', __( 'Restrição por CEP', 'restringir-produto-por-cep' ) )
            ->set_context('carbon_fields_after_title')
            ->where( 'post_type', '=', 'product' ) // only show our new fields on pages
            ->add_fields( array(
                Carbon_Fields\Field::make( 'complex', 'faixas_de_cep', __('Faixas de CEP', 'restringir-produto-por-cep') )
                    ->setup_labels([
                        'singular_name' => __('Faixa de CEP', 'restringir-produto-por-cep'),
                        'plural_name' => __('Faixas de CEP', 'restringir-produto-por-cep'),
                    ])
                	->add_fields( array(
                        Carbon_Fields\Field::make( 'text', 'de', __('De', 'restringir-produto-por-cep') )
                            ->set_width(50)
                            ->set_classes( 'cep' )
                            ->set_attribute('maxLength', 9),
                        Carbon_Fields\Field::make( 'text', 'ate', __('Até', 'restringir-produto-por-cep') )
                            ->set_width(50)
                            ->set_classes( 'cep' )
                            ->set_attribute('maxLength', 9),
                	) ),
            ) )
            ->add_fields( array(
                Carbon_Fields\Field::make( 'complex', 'ceps_especificos', __('CEPs específicos') )
                    ->setup_labels([
                        'singular_name' => __('CEPs', 'restringir-produto-por-cep'),
                        'plural_name' => __('CEP', 'restringir-produto-por-cep'),
                    ])
                	->add_fields( array(
                        Carbon_Fields\Field::make( 'text', 'cep', __('CEP', 'restringir-produto-por-cep') )
                            ->set_width(50)
                            ->set_classes( 'cep' )
                            ->set_attribute('maxLength', 9),
                	) ),
            ) );
    } );
   

	$plugin->run();
}
run_restringir_produto_por_cep();