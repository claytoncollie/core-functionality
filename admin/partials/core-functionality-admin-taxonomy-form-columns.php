<?php

/**
 * Custom columns for posts
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.claytoncollie.com
 * @since      1.0.0
 *
 * @package    Core_Functionality
 * @subpackage Core_Functionality/admin/partials
**/

// Column names
add_filter('manage_edit-rc_form_columns', 'add_feature_group_column' );
function add_feature_group_column( $defaults ){
	//Unset default columns
	unset($defaults['name']);
    unset($defaults['description']);
	unset($defaults['slug']);
	unset($defaults['posts']);
    
	// Add columns back in proper order
	$defaults['name'] = 'Name';
	$defaults['rc_form_object_prefix'] = __( 'Prefix', 'rc' );
	$defaults['slug'] = 'Slug';
	$defaults['posts'] = 'Count';

    return $defaults;
}

// Show term meta -> object prefix
add_filter('manage_rc_form_custom_column', 'rc_form_prefix_column_content',10,3);
function rc_form_prefix_column_content($content,$column_name,$term_id){
    
	switch ($column_name) {
        case 'rc_form_object_prefix':

			$prefix = get_field('rc_form_object_prefix', 'rc_form_' . $term_id );

            $content = $prefix;
            break;
        default:
            break;
    }
	
    return $content;
}

// Make column sortable
add_filter( 'manage_edit-rc_form_sortable_columns', 'rc_form_prefix_column_sortable' );
function rc_form_prefix_column_sortable( $sortable ){
    $sortable[ 'rc_form_object_prefix' ] = 'rc_form_object_prefix';
    return $sortable;
}

