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
class Core_Functionality_User_Profile {

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
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( string $plugin_name, string $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Clean up Genesus filed from user profile page.
	 *
	 * @return void
	 *
	 * @since 1.14.0
	 */
	public function genesis_clean_up() {
		// User profile options.
		remove_action( 'show_user_profile', 'genesis_user_options_fields' );
		remove_action( 'edit_user_profile', 'genesis_user_options_fields' );
		// User archive settings.
		remove_action( 'show_user_profile', 'genesis_user_archive_fields' );
		remove_action( 'edit_user_profile', 'genesis_user_archive_fields' );
		// SEO options.
		remove_action( 'show_user_profile', 'genesis_user_seo_fields' );
		remove_action( 'edit_user_profile', 'genesis_user_seo_fields' );
		// Layout options.
		remove_action( 'show_user_profile', 'genesis_user_layout_fields' );
		remove_action( 'edit_user_profile', 'genesis_user_layout_fields' );
	}

	/**
	 * Custom contact methods for each user profile
	 *
	 * @param array $user_contact Contact methods.
	 *
	 * @return array
	 *
	 * @since    1.0.0
	 */
	public function modify_user_contact_methods( array $user_contact ) : array {

		unset( $user_contact['aim'] );
		unset( $user_contact['jabber'] );
		unset( $user_contact['yim'] );
		unset( $user_contact['gplus'] );
		unset( $user_contact['myspace'] );
		unset( $user_contact['linkedin'] );
		unset( $user_contact['soundcloud'] );
		unset( $user_contact['tumblr'] );
		unset( $user_contact['youtube'] );
		unset( $user_contact['wikipedia'] );

		return $user_contact;

	}

	/**
	 * Update user meta when user edit page is saved.
	 *
	 * @since 1.4.0
	 *
	 * @param int $user_id User ID.
	 * @return void Return early if current user can not edit users, or no meta fields submitted.
	 */
	public function update_user_meta_artist_filter( $user_id ) {

		if ( ! current_user_can( 'edit_users', $user_id ) ) {
			return;
		}

		$field = get_field( 'artist_filter', $user_id );

		if ( empty( $field ) ) {

			$user_id = str_replace( 'user_', '', $user_id );

			$name = get_user_meta( $user_id, 'last_name', true );

			if ( empty( $name ) ) {
				$name = get_user_meta( $user_id, 'first_name', true );
			}

			$letter = mb_substr( $name, 0, 1 );
			$letter = strtolower( $letter );

			update_user_meta( $user_id, 'artist_filter', $letter );

		}

	}


}
