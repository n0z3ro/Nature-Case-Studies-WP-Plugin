<?php

/**
 * @link              http://n0z3ro.com/
 * @since             1.0.0
 * @package           Nat_case_studies
 *
 * @wordpress-plugin
 * Plugin Name:       Nature Case Studies
 * Plugin URI:        http://naturestudio.us/
 * Description:       Creates the Case Studies post type
 * Version:           1.0.0
 * Author:            Clint Ford
 * Author URI:        http://n0z3ro.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nat_case_studies
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if( ! defined( 'WPINC' ) ) {
	die;
}

define( 'NATURE_CASE_STUDIES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_nat_case_studies() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nat_case_studies-activator.php';
	Nat_case_studies_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
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
 * @since    1.0.0
 */
function run_nat_case_studies() {
	$plugin = new Nat_case_studies();
	$plugin->run();

	//hooks
	add_action('init', 'nat_case_studies_custom_post_type');
	add_action( 'add_meta_boxes', 'nat_custom_meta_boxes' );
	add_action( 'save_post', 'nat_save_meta_box' );
}

function nat_case_studies_custom_post_type() {
	register_post_type('nat_case_studies',
		array(
				'labels' => array(
				'name' => __('Case Studies'),
				'singular_name' => __('Case Study'),
			),
			'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array('slug' => 'case_studies')
		)
	);

	//Custom Taxonomies
	$prj_type_labels = [
		'name' => _x('Project Type', 'taxonomy general name'),
		'singular_name' => _x('Project Type', 'taxonomy singular name'),
		'search_items' => __('Search Project Types'),
		'all_items' => __('All Project Types'),
		'parent_item' => __('Parent Project Type'),
		'parent_item_colon' => __('Parent Project Type:'),
		'edit_item' => __('Edit Project Type'),
		'update_item' => __('Update Project Type'),
		'add_new_item' => __('Add New Project Type'),
		'new_item_name' => __('New Project Type'),
		'menu_name' => __('Project Type'),
	];
	$prj_type_args = [
		'hierarchical' => true,
		'labels' => $prj_type_labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => ['slug' => 'project-type'],
	];
	register_taxonomy('project-type', ['nat_case_studies'], $prj_type_args);

	$ser_labels = [
		'name' => _x('Services', 'taxonomy general name'),
		'singular_name' => _x('Service', 'taxonomy singular name'),
		'search_items' => __('Search Services'),
		'all_items' => __('All Services'),
		'parent_item' => __('Parent Service'),
		'parent_item_colon' => __('Parent Service:'),
		'edit_item' => __('Edit Service'),
		'update_item' => __('Update Service'),
		'add_new_item' => __('Add New Service'),
		'new_item_name' => __('New Service Name'),
		'menu_name' => __('Services'),
	];
	$ser_args = [
		'hierarchical' => true,
		'labels' => $ser_labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => ['slug' => 'service'],
	];
	register_taxonomy('service', ['nat_case_studies'], $ser_args);

	$del_labels = [
		'name' => _x('Deliverables', 'taxonomy general name'),
		'singular_name' => _x('Deliverable', 'taxonomy singular name'),
		'search_items' => __('Search Deliverables'),
		'all_items' => __('All Deliverables'),
		'parent_item' => __('Parent Deliverable'),
		'parent_item_colon' => __('Parent Deliverable:'),
		'edit_item' => __('Edit Deliverable'),
		'update_item' => __('Update Deliverable'),
		'add_new_item' => __('Add New Deliverable'),
		'new_item_name' => __('New Deliverable Name'),
		'menu_name' => __('Deliverables'),
	];
	$del_args = [
		'hierarchical' => true,
		'labels' => $del_labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => ['slug' => 'deliverable'],
	];
	register_taxonomy('deliverable', ['nat_case_studies'], $del_args);

	//fixes permalink 404 errors - DISABLE IN FINAL RELEASE
	flush_rewrite_rules( false );
}

function nat_custom_meta_boxes() {
	//Add Meta Boxes
	add_meta_box( 'project-id-meta-box', __( 'Project Name', 'textdomain' ), 'nat_project_meta', 'nat_case_studies', 'side', 'high' );

	function nat_project_meta( $post ) {
		wp_nonce_field( basename( __FILE__ ), 'nat_nonce' );
		$nat_stored_meta = get_post_meta( $post->ID );
		?>

		<p>
			<input type="text" name="nat-project" id="nat-project" value="<?php if(isset($nat_stored_meta['nat-project'])) echo $nat_stored_meta['nat-project'][0]; ?>" />
		</p>

		<?php
	}
	add_meta_box( 'client-logo-meta-box', __( 'Client Logo', 'textdomain' ), 'nat_logo_meta', 'nat_case_studies', 'side', 'low' );

	function nat_logo_meta( $post ) {
		wp_nonce_field( basename( __FILE__ ), 'nat_nonce' );
		$nat_stored_meta = get_post_meta( $post->ID );
		?>

		<p>
			<input type="text" name="nat-logo" id="nat-logo" value="<?php if(isset($nat_stored_meta['nat-logo'])) echo $nat_stored_meta['nat-logo'][0]; ?>" />
		</p>

		<?php
	}
}

function nat_save_meta_box( $post_id ) {

	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'nat_nonce' ]) && wp_verify_nonce( $_POST[ 'nat_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

	// Exits script depending on save status
	if( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}

	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'nat-project' ])) {
		update_post_meta( $post_id, 'nat-project', sanitize_text_field( $_POST[ 'nat-project' ]));
	}

	if( isset( $_POST[ 'nat-logo' ])) {
		update_post_meta( $post_id, 'nat-logo', sanitize_text_field( $_POST[ 'nat-logo' ]));
	}
}

run_nat_case_studies();
