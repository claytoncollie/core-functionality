<?php

/**
 * Custom Taxonomy - TECHNIQUE
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.claytoncollie.com
 * @since      1.0.0
 *
 * @package    Core_Functionality
 * @subpackage Core_Functionality/admin/partials
**/
// Register Custom Taxonomy
function rc_taxonomy_technique() {

	$labels = array(
		'name'                       => _x( 'Techniques', 'Taxonomy General Name', 'rc' ),
		'singular_name'              => _x( 'Technique', 'Taxonomy Singular Name', 'rc' ),
		'menu_name'                  => __( 'Techniques', 'rc' ),
		'all_items'                  => __( 'All Items', 'rc' ),
		'parent_item'                => __( 'Parent Item', 'rc' ),
		'parent_item_colon'          => __( 'Parent Item:', 'rc' ),
		'new_item_name'              => __( 'New Item Name', 'rc' ),
		'add_new_item'               => __( 'Add New Item', 'rc' ),
		'edit_item'                  => __( 'Edit Item', 'rc' ),
		'update_item'                => __( 'Update Item', 'rc' ),
		'view_item'                  => __( 'View Item', 'rc' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'rc' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'rc' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'rc' ),
		'popular_items'              => __( 'Popular Items', 'rc' ),
		'search_items'               => __( 'Search Items', 'rc' ),
		'not_found'                  => __( 'Not Found', 'rc' ),
	);
	$rewrite = array(
		'slug'                       => 'technique',
		'with_front'                 => true,
		'hierarchical'               => false,
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => false,
		'show_tagcloud'              => false,
		'query_var'            		 => true,
		'rewrite'                    => $rewrite,
	);
	register_taxonomy( 'rc_technique', array( 'post' ), $args );

}
add_action( 'init', 'rc_taxonomy_technique', 0 );