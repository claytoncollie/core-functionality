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

		$user_contact['twitter']   = esc_html__( 'Twitter', 'core-functionality' );
		$user_contact['facebook']  = esc_html__( 'Facebook', 'core-functionality' );
		$user_contact['instagram'] = esc_html__( 'Instagram', 'core-functionality' );
		$user_contact['pinterest'] = esc_html__( 'Pinterest', 'core-functionality' );

		return $user_contact;

	}


}
