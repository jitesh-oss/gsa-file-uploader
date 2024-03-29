<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.sangergenomics.com
 * @since      1.0.0
 *
 * @package    Gsa_File_Uploader
 * @subpackage Gsa_File_Uploader/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Gsa_File_Uploader
 * @subpackage Gsa_File_Uploader/includes
 * @author     Jitesh <jitesh@nutritionalgenomix.com>
 */
class Gsa_File_Uploader_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'gsa-file-uploader',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
