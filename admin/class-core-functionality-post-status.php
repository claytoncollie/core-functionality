<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.claytoncollie.com
 * @since      1.10.0
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
class Core_Functionality_Post_Status {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.10.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.10.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The machine name of the custom post status.
	 *
	 * @var string
	 * @access protected
	 * @since 1.10.0
	 */
	protected $post_status = 'archive';

	/**
	 * Array of post types that the custom post status will be applied to.
	 *
	 * @var array
	 * @access protected
	 * @since 1.10.0
	 */
	protected $post_types = array( 'post' );

	/**
	 * Text used to display the post status when it can be applied to a post.
	 *
	 * @var string
	 * @access protected
	 * @since 1.10.0
	 */
	protected $action_label = 'Archive';

	/**
	 * Text used to display the post status when it has been applied to a post.
	 *
	 * @var string
	 * @access protected
	 * @since 1.10.0
	 */
	protected $applied_label = 'Archived';

	/**
	 * Arguments to pass to register_post_status()
	 *
	 * @var array
	 * @access protected
	 * @since 1.10.0
	 */
	protected $args = array();

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.10.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( string $plugin_name, string $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

		$this->args = array(
			'label'                     => _x( 'Archive', 'Status General Name', 'core-functionality' ),
			'label_count'               => _n_noop( 'Archive (%s)', 'Archives (%s)', 'core-functionality' ), // phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment
			'public'                    => false,
			'protected'                 => true,
			'show_in_admin_all_list'    => true,
			'show_in_admin_status_list' => true,
			'exclude_from_search'       => true,
		);

	}

	/**
	 * Register the custom post status with WordPress.
	 *
	 * @since 1.10.0
	 */
	public function register_post_status() {
		register_post_status( $this->post_status, $this->args );
	}

	/**
	 * Append the custom post type to the post status
	 * dropdown on the edit pages of posts.
	 *
	 * @since 1.10.0
	 */
	public function append_to_post_status_dropdown() {

		global $post;

		$selected = '';
		$label    = '';

		if ( in_array( $post->post_type, $this->post_types, true ) ) {

			if ( $post->post_status === $this->post_status ) {
				$selected = ' selected="selected"';
				$label    = "<span id=\"post-status-display\"> {$this->applied_label}</span>";
			}

			echo "
		  <script>
		  jQuery(document).ready(function ($){
		       $('select#post_status').append('<option value=\"{$this->post_status}\"{$selected}>{$this->action_label}</option>');
		       $('.misc-pub-section label').append('{$label}');
		  });
		  </script>"; // phpcs:ignore WordPress.Security.EscapeOutput.DeprecatedWhitelistCommentFound
		}

	}

	/**
	 * Update the text on edit.php to be more
	 * descriptive of the type of post (text
	 * that labels each post)
	 *
	 * @param array $states Post status states.
	 *
	 * @return array
	 *
	 * @since 1.10.0
	 */
	public function update_post_status( array $states ) : array {

		$status = get_query_var( 'post_status' );

		if ( $status !== $this->post_status && get_post_status() === $this->post_status ) {

			$states[] = esc_html( $this->applied_label );

		}

		return $states;

	}

}
