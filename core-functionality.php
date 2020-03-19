<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.claytoncollie.com
 * @since             1.0.0
 * @package           Core_Functionality
 *
 * @wordpress-plugin
 * Plugin Name:       Core Functionality
 * Plugin URI:        https://github.com/claytoncollie/rosenfield-collection-plugin
 * Description:       DO NOT REMOVE. This plugin is required for the website to work properly.
 * Version:           1.15.3
 * Author:            Clayton Collie
 * Author URI:        http://www.claytoncollie.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       core-functionality
 * Domain Path:       /languages
 * GitHub Plugin URI: claytoncollie/core-functionality
 * GitHub Plugin URI: https://github.com/claytoncollie/core-functionality
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-core-functionality.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function core_functionality_run() {

	$plugin = new Core_Functionality();
	$plugin->run();

}
core_functionality_run();
