<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://ersolucoesweb.com.br
 * @since      1.0.0
 *
 * @package    Product_Restriction_By_Postcode
 * @subpackage Product_Restriction_By_Postcode/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Product_Restriction_By_Postcode
 * @subpackage Product_Restriction_By_Postcode/includes
 * @author     ER Soluções Web LTDA <contato@ersolucoesweb.com.br>
 */
class Product_Restriction_By_Postcode_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'product-restriction-by-postcode',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
