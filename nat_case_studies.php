<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://n0z3ro.com/
 * @since             1.0.0
 * @package           Nat_case_studies
 *
 * @wordpress-plugin
 * Plugin Name:       Nature Case Studies
 * Plugin URI:        http://naturestudio.us/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Clint Ford
 * Author URI:        http://n0z3ro.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nat_case_studies
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
define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nat_case_studies-activator.php
 */
function activate_nat_case_studies() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nat_case_studies-activator.php';
	Nat_case_studies_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nat_case_studies-deactivator.php
 */
function deactivate_nat_case_studies() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nat_case_studies-deactivator.php';
	Nat_case_studies_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_nat_case_studies' );
register_deactivation_hook( __FILE__, 'deactivate_nat_case_studies' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nat_case_studies.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nat_case_studies() {

	$plugin = new Nat_case_studies();
	$plugin->run();

}
run_nat_case_studies();
