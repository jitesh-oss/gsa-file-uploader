<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.sangergenomics.com
 * @since             1.0.0
 * @package           Gsa_File_Uploader
 *
 * @wordpress-plugin
 * Plugin Name:       GSA File Uploader
 * Plugin URI:        http://www.sangergenomics.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Jitesh
 * Author URI:        http://www.sangergenomics.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       gsa-file-uploader
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
define( 'GSA_FILE_UPLOADER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-gsa-file-uploader-activator.php
 */
function activate_gsa_file_uploader() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gsa-file-uploader-activator.php';
	Gsa_File_Uploader_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-gsa-file-uploader-deactivator.php
 */
function deactivate_gsa_file_uploader() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-gsa-file-uploader-deactivator.php';
	Gsa_File_Uploader_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_gsa_file_uploader' );
register_deactivation_hook( __FILE__, 'deactivate_gsa_file_uploader' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-gsa-file-uploader.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_gsa_file_uploader() {

	$plugin = new Gsa_File_Uploader();
	$plugin->run();

}
run_gsa_file_uploader();

function gsa_upload(){
	if( current_user_can('edit_posts') || current_user_can('lgp_report_down') ) {  
		//stuff here for allowed roles
		include ('main/index.php');
	  } 
	  else {
		echo "You are not authorized to view this page!";
	  }
	
}

add_shortcode( 'gsa-upload', 'gsa_upload'  );