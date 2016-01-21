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
add_filter('manage_posts_columns', 'rc_columns_head');
function rc_columns_head($defaults) {
    //Unset default columns
	unset($defaults['title']);
    unset($defaults['author']);
	unset($defaults['categories']);
	unset($defaults['tags']);
    unset($defaults['comments']);
	unset($defaults['date']);
	unset($defaults['taxonomy-rc_form']);
	unset($defaults['taxonomy-rc_firing']);
	unset($defaults['taxonomy-rc_technique']);
	unset($defaults['taxonomy-rc_row']);
	unset($defaults['taxonomy-rc_column']);
	
	//add columns with new order
	$defaults['featured_image']  = 'Featured Image';
	$defaults['title'] = 'Title';
	$defaults['author'] = 'Artist';
	$defaults['rc_form_object_prefix'] = __( 'Prefix', 'rc' );
	$defaults['object_id'] = 'ID';
	$defaults['date'] = 'Date';
	$defaults['taxonomy-rc_form'] = 'Form';
	$defaults['taxonomy-rc_firing'] = 'Firing';
	$defaults['taxonomy-rc_technique'] = 'Technique';
	$defaults['taxonomy-rc_row'] = 'Row';
	$defaults['taxonomy-rc_column'] = 'Column';
	$defaults['height'] = 'Height';
	$defaults['width'] = 'Width';
	$defaults['length'] = 'Length';
  
    return $defaults;
}

 
// Content for columns
add_action('manage_posts_custom_column', 'rc_columns_content', 10, 2);
function rc_columns_content($column_name,$term_id) {
	
    
	if ($column_name == 'featured_image') {
        $post_featured_image = get_the_post_thumbnail( get_the_ID() , array(75,75));
       
	    echo $post_featured_image;
    }
	
	if ($column_name == 'rc_form_object_prefix') {
		
		// load all 'rc_form' terms for the post
		$terms = get_the_terms( get_the_ID(), 'rc_form');
		
		// we will use the first term to load ACF data from
		if( !empty($terms) ) {
			
			$term = array_pop($terms);
		
			$prefix = get_field('rc_form_object_prefix', $term );
		
			echo $prefix;
		}

    }
	
	if ($column_name == 'object_id') {
        $object_id = get_field('object_id', get_the_ID() );
       
	    echo $object_id;
    }
	
	if ($column_name == 'height') {
        $column = get_field('height', get_the_ID() );
       
	    echo $column;
    }
	
	if ($column_name == 'width') {
        $column = get_field('width', get_the_ID() );
       
	    echo $column;
    }
	
	if ($column_name == 'length') {
        $column = get_field('length', get_the_ID() );
       
	    echo $column;
    }
		
}

// Add sortable for number column
add_filter( 'manage_edit-post_sortable_columns', 'rc_post_id_column_sortable' );
function rc_post_id_column_sortable( $sortable ){
    $sortable[ 'object_id' ] = 'object_id';
    return $sortable;
}

// REmove category drop down on post edit.php screen
add_action( 'load-edit.php', 'rc_no_category_dropdown' );
function rc_no_category_dropdown() {
    add_filter( 'wp_dropdown_cats', '__return_false' );
}

// Filter - FORM
add_action( 'restrict_manage_posts', 'rc_add_taxonomy_filters_form' );
function rc_add_taxonomy_filters_form() {
	global $typenow;
 
	// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
	$taxonomies = array('rc_form', 'rc_firing', 'rc_technique', 'rc_row', 'rc_column');
 
	// must set this to the post type you want the filter(s) displayed on
	if( $typenow == 'post' ){
 
		foreach ($taxonomies as $tax_slug) {
			$tax_obj = get_taxonomy($tax_slug);
			$tax_name = $tax_obj->labels->name;
			$terms = get_terms($tax_slug);
			$current_tax_slug = isset( $_GET[$tax_slug] ); 
			$_GET[$tax_slug] = false;
			if(count($terms) > 0) {
				echo '<select name='.$tax_slug.' id='.$tax_slug.' class="postform">';
				echo '<option value="">Show All '.$tax_name.'</option>';
				foreach ($terms as $term) { 
					echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>'; 
				}
				echo '</select>';
			}
		}
	}
}


