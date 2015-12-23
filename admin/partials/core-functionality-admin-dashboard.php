<?php

/**
 * Clean up dashboard
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.claytoncollie.com
 * @since      1.0.0
 *
 * @package    Core_Functionality
 * @subpackage Core_Functionality/admin/partials
**/

add_action('wp_dashboard_setup', 'cf_remove_dashboard_widgets' );
function cf_remove_dashboard_widgets() {
	global $wp_meta_boxes;

	if(!current_user_can('manage_options')) {
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	}	
}


// Add widget for non admin
add_action('wp_dashboard_setup', 'cf_custom_dashboard_widgets');
function cf_custom_dashboard_widgets() {
	global $wp_meta_boxes;

	if(!current_user_can('manage_options')) {
		wp_add_dashboard_widget('custom_help_widget', 'Welcome to the Rosenfield Collection', 'cf_custom_dashboard_help');
	}
}

function cf_custom_dashboard_help() {
	echo '<p>Hi there! This is where you can access your personal profile.  Select the Profile link on the left to change the spelling of your name, email address, website address, social media links or your profile photo.</p><p>Need extra help or want to report a problem with the website?</p><p> Contact the team at <a href="mailto:info@rosenfieldcollection.com">info@rosenfieldcollection.com</a> </p>';
}

