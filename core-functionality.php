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
 * Plugin URI:        https://github.com/claytoncollie/Core-Functionality
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.1.0
 * Author:            Clayton Collie
 * Author URI:        http://www.claytoncollie.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       core-functionality
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-core-functionality-activator.php
 */
function activate_core_functionality() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-core-functionality-activator.php';
	Core_Functionality_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-core-functionality-deactivator.php
 */
function deactivate_core_functionality() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-core-functionality-deactivator.php';
	Core_Functionality_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_core_functionality' );
register_deactivation_hook( __FILE__, 'deactivate_core_functionality' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-core-functionality.php';


add_action( 'plugins_loaded', 'run_core_functionality', 10 );
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_core_functionality() {

	$plugin = new Core_Functionality();
	$plugin->run();

}