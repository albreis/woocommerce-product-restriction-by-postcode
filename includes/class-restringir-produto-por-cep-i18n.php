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
 * @package    Restringir_Produto_Por_Cep
 * @subpackage Restringir_Produto_Por_Cep/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Restringir_Produto_Por_Cep
 * @subpackage Restringir_Produto_Por_Cep/includes
 * @author     ER Soluções Web LTDA <contato@ersolucoesweb.com.br>
 */
class Restringir_Produto_Por_Cep_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'restringir-produto-por-cep',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
