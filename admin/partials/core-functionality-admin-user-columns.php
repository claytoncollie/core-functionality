<?php

/**
 * Custom columns for all users admin screen
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.claytoncollie.com
 * @since      1.0.0
 *
 * @package    Core_Functionality
 * @subpackage Core_Functionality/admin/partials
**/

add_filter('manage_users_columns', 'rc_user_column');
function rc_user_column($columns) {
   
    $columns['photo'] = 'Photo';
	$columns['website'] = 'Website';
	
    return $columns;
}

add_action('manage_users_custom_column',  'rc_user_column_content', 10, 3);
function rc_user_column_content($value, $column_name, $user_id) {

	$user_info = get_userdata( $user_id );
	
	$attachment_id = get_field( 'artist_photo', 'user_'.$user_id );
	$size = "artist-image"; 
	$author_avatar = wp_get_attachment_image_src( $attachment_id, $size );
    
	if ( 'website' == $column_name ) {
		$output .= '<a target="_blank" href="';
        
		$output .= ($user_info->user_url);
		
		$output .= '">'.($user_info->user_url).'</a>';
    
	return $output;

	}
	
	if ( 'photo' == $column_name ) {

		$output .= '<img src="'.$author_avatar[0].'" style="max-height: 100px;">';
           
	return $output;

	}
}