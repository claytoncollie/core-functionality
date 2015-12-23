<?php

/**
 * Clean up the Wordpress HEAD
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.claytoncollie.com
 * @since      1.0.0
 *
 * @package    Core_Functionality
 * @subpackage Core_Functionality/admin/partials
**/

// Remove feed links
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);

// Remove Shortlink URL
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Remove rsd link
remove_action( 'wp_head', 'rsd_link' );                    

// Remove Windows Live Writer
remove_action( 'wp_head', 'wlwmanifest_link' );                       

// Index link
remove_action( 'wp_head', 'index_rel_link' );                         

// Previous link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );            

// Start link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );             

// Links for adjacent posts
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); 

// Remove WP version
remove_action( 'wp_head', 'wp_generator' ); 

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Remove pingback
add_filter( 'xmlrpc_methods', 'remove_xmlrpc_pingback_ping' );
function remove_xmlrpc_pingback_ping( $methods ) {
   unset( $methods['pingback.ping'] );
   return $methods;
}