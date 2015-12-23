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
function rc_columns_content($column_name, $post_ID) {
    
	if ($column_name == 'featured_image') {
        $post_featured_image = get_the_post_thumbnail($post_ID, array(75));
       
	    echo $post_featured_image;
    }
	
	if ($column_name == 'object_id') {
        $object_id = get_field('object_id', $post_id);
       
	    echo $object_id;
    }
	
	if ($column_name == 'height') {
        $column = get_field('height', $post_id);
       
	    echo $column;
    }
	
	if ($column_name == 'width') {
        $column = get_field('width', $post_id);
       
	    echo $column;
    }
	
	if ($column_name == 'length') {
        $column = get_field('length', $post_id);
       
	    echo $column;
    }
		
}
