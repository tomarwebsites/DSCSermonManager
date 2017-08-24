<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              blog-online.org.uk
 * @since             1.0.0
 * @package           Sermon_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       sermons
 * Plugin URI:        blog-online.org.uk/sermon_plugin
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Tom Nicholas
 * Author URI:        blog-online.org.uk
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       sermon-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-sermon-manager-activator.php
 */
function activate_sermon_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sermon-manager-activator.php';
	Sermon_Manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-sermon-manager-deactivator.php
 */
function deactivate_sermon_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-sermon-manager-deactivator.php';
	Sermon_Manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_sermon_manager' );
register_deactivation_hook( __FILE__, 'deactivate_sermon_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-sermon-manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_sermon_manager() {

	$plugin = new Sermon_Manager();
	$plugin->run();

}
run_sermon_manager();
