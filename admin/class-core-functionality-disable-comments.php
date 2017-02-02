<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.claytoncollie.com
 * @since      1.0.0
 *
 * @package    Core_Functionality
 * @subpackage Core_Functionality/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Core_Functionality
 * @subpackage Core_Functionality/admin
 * @author     Clayton Collie <clayton.collie@gmail.com>
 */
class Core_Functionality_Disable_Comments {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $labels = array(), $rewrite = array(), $args = array() ) {

		$this->plugin_name 	= $plugin_name;
		$this->version 		= $version;

	}

	/*
	 *
	 * Update fields on options-comments.php
	 *
	 */
	public function rc_update_options_page() {

		update_option( 'default_pingback_flag', 'closed' );
		update_option( 'default_ping_status', 'closed' );
		update_option( 'default_comment_status', 'closed' );
		update_option( 'show_avatars', 'closed' );

	}
	
	
	/*
	 *
	 * Disable support for comments and trackbacks in post types
	 *
	 */
	public function rc_disable_comments_post_types_support() {
		
		add_filter( 'comments_open', '__return_false', 20, 2);
		add_filter( 'pings_open', '__return_false', 20, 2);

		$post_types = get_post_types();
		
		foreach ($post_types as $post_type) {

			if( post_type_supports($post_type, 'comments') ) {

				remove_post_type_support($post_type, 'comments');

				remove_post_type_support($post_type, 'trackbacks');

			}

		}

	}

	// remove links/menus from the admin bar
	function rc_remove_admin_bar_link() {
		
		global $wp_admin_bar;

		$wp_admin_bar->remove_menu('comments');
		
	}


	/*
	 *
	 * Hide existing comments
	 *
	 */
	public function rc_disable_comments_hide_existing_comments( $comments ) {
		
		$comments = array();

		return $comments;

	}


	/*
	 *
	 * Remove admin pages
	 *
	 */
	public function rc_disable_comments_admin_menu() {

		// Comments top level page
		remove_menu_page('edit-comments.php');

		// Settings page
		remove_submenu_page( 'options-general.php', 'options-discussion.php' );

	}
	


	/*
	 *
	 * Redirect any user trying to access comments page
	 *
	 */
	public function rc_disable_comments_admin_menu_redirect() {
		
		global $pagenow;
		
		if ( $pagenow == 'comment.php' || $pagenow === 'edit-comments.php' || $pagenow === 'options-discussion.php' ) {

			wp_die( __( 'Comments are closed.' ), '', array( 'response' => 403 ) );

		}

	}



	/*
	 *
	 * Remove comments metabox from dashboard
	 *
	 */
	public function rc_disable_comments_dashboard() {

		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

	}



	/*
	 *
	 * Remove comments links from admin bar
	 *
	 */
	public function rc_disable_comments_admin_bar() {
		
		if ( is_admin_bar_showing() ) {
			
			remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
		
		}
	}

	/*
	 * Remove comments widget
	 *
	 */
	public function rc_disable_comments_widget() {
		
		unregister_widget( 'WP_Widget_Recent_Comments' );

	}
	
	/*
	 * Hides comments link on dashboard
	 *
	 */
	public function rc_hide_dashboard_bits(){
		
		if( 'dashboard' == get_current_screen()->id ) {

			echo '<script>
				jQuery(function($){
					$("#dashboard_right_now .comment-count, #latest-comments").hide();
				 	$("#welcome-panel .welcome-comments").parent().hide();
				});
				</script>';

		}
	}

}