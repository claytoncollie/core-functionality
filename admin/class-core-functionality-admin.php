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
class Core_Functionality_Admin {

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
	 * Define plugins that can take automatic updates.
	 *
	 * @param bool   $update Should we update.
	 * @param object $item Items to update.
	 *
	 * @return bool
	 *
	 * @since 1.8.0
	 */
	public function plugins_to_auto_update( ?bool $update, object $item ) : bool {

		$plugins = array(
			'core-functionality',
		);

		if ( in_array( $item->slug, $plugins, true ) ) {
			return true;
		}

		return false;

	}

	/**
	 * Enabling the Gutenberg editor all post types except post.
	 *
	 * @param bool   $can_edit  Whether to use the Gutenberg editor.
	 * @param string $post_type Name of WordPress post type.
	 *
	 * @return bool
	 *
	 * @since 1.2.0
	 */
	public function gutenberg_support( bool $can_edit, string $post_type ) : bool {

		if ( in_array( $post_type, array( 'post' ), true ) ) {
			$can_edit = false;
		}

		return $can_edit;

	}

	/**
	 * Change save path for Advanced Custom Fields local json files
	 *
	 * @param string $path Default directory.
	 *
	 * @return string
	 *
	 * @since 1.2.0
	 */
	public function acf_local_json_save_location( string $path ) : string {
		$path = plugin_dir_path( __DIR__ ) . '/acf-json';
		return $path;
	}

	/**
	 * Change load path for Advannced Custom Fields local json files.
	 *
	 * @param array $paths Default directories.
	 *
	 * @return array
	 *
	 * @since 1.2.0
	 */
	public function acf_local_json_load_location( array $paths ) : array {
		unset( $paths[0] );
		$paths[] = plugin_dir_path( __DIR__ ) . '/acf-json';
		return $paths;
	}

	/**
	 * Cleans out unsed HTML on wp_head
	 *
	 * @since    1.0.0
	 */
	public function clean_header() {

		// Remove feed links.
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );

		// Remove Shortlink URL.
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

		// Remove rsd link.
		remove_action( 'wp_head', 'rsd_link' );

		// Remove Windows Live Writer.
		remove_action( 'wp_head', 'wlwmanifest_link' );

		// Index link.
		remove_action( 'wp_head', 'index_rel_link' );

		// Previous link.
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

		// Start link.
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );

		// Links for adjacent posts.
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

		// Remove WP version.
		remove_action( 'wp_head', 'wp_generator' );

		// REMOVE WP EMOJI.
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );

	}

	/**
	 * Remove XMLRPC pingback
	 *
	 * @param array $methods XMLRPC methods.
	 *
	 * @return array
	 *
	 * @since    1.0.0
	 */
	public function remove_xmlrpc_pingback_ping( array $methods ) : array {
		unset( $methods['pingback.ping'] );
		return $methods;
	}

	/**
	 * Remove menus for non-administrators
	 *
	 * @since    1.0.0
	 */
	public function remove_admin_menus() {

		$user = wp_get_current_user();

		if ( ! current_user_can( 'activate_plugins' ) ) {

			global $menu;

			$restricted = array(
				esc_html__( 'Links', 'core-functionality' ),
				esc_html__( 'Appearance', 'core-functionality' ),
				esc_html__( 'Tools', 'core-functionality' ),
				esc_html__( 'Settings', 'core-functionality' ),
				esc_html__( 'Comments', 'core-functionality' ),
				esc_html__( 'Plugins', 'core-functionality' ),
			);

			end( $menu );

			while ( prev( $menu ) ) {

				$value = explode( ' ', $menu[ key( $menu ) ][0] );

				if ( in_array( null !== $value[0] ? $value[0] : '', $restricted, true ) ) {

					unset( $menu[ key( $menu ) ] );

				}
			}
		}
	}

	/**
	 * Remove category drop down on edit.php
	 *
	 * @since    1.0.0
	 */
	public function no_category_dropdown() {
		add_filter( 'wp_dropdown_cats', '__return_false' );
	}

	/**
	 * Add drop down for custom taxonomies
	 *
	 * @since    1.0.0
	 */
	public function add_taxonomy_filters_form() {

		global $typenow;

		// An array of all the taxonomyies you want to display. Use the taxonomy name or slug.
		$taxonomies = array(
			'rc_form',
			'rc_firing',
			'rc_technique',
			'rc_column',
			'rc_row',
			'rc_location',
			'rc_result',
		);

		// Must set this to the post type you want the filter(s) displayed on.
		if ( 'post' === $typenow ) {

			foreach ( $taxonomies as $tax_slug ) {

				$tax_obj = get_taxonomy( $tax_slug );

				$tax_name = $tax_obj->labels->name;

				$terms = get_terms( $tax_slug );

				$current_tax_slug = isset( $_GET[ $tax_slug ] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended

				$_GET[ $tax_slug ] = false;

				if ( count( $terms ) > 0 ) {

					printf(
						'<select name=%s id=%s class="postform">',
						esc_attr( $tax_slug ),
						esc_attr( $tax_slug )
					);

					printf(
						'<option value="">%s %s</option>',
						esc_html__( 'Show All', 'core-functionality' ),
						esc_html( $tax_name )
					);

					foreach ( $terms as $term ) {

						printf(
							'<option value=%s %s>%s (%s)</option>',
							esc_attr( $term->slug ),
							$_GET[ $tax_slug ] === $term->slug ? ' selected="selected"' : '', // phpcs:ignore WordPress.Security.NonceVerification.Recommended
							esc_html( $term->name ),
							intval( $term->count )
						);

					}

					echo '</select>';

				}
			}
		}
	}

	/**
	 * Add featured image to RSS feed item.
	 *
	 * @param string $content RSS content.
	 * @return string
	 * @since 1.1.0
	 */
	public function add_image_to_rss( string $content ) : string {

		if ( has_post_thumbnail( get_the_ID() ) ) {

			$content = sprintf(
				'<a href="%s">%s</a>',
				get_permalink( get_the_ID() ),
				get_the_post_thumbnail(
					get_the_ID(),
					'archive-image'
				)
			);

		}

		return $content;

	}

	/**
	 * Write the post name to use custom field data and the taxonomt term meta.
	 *
	 * @param string $post_id Post ID.
	 * @return void
	 * @since 1.6.0
	 */
	public function field_as_post_name( string $post_id ) {

		$object_id = get_field( 'object_id', $post_id );

		$prefix = $this->get_taxonomy_term_prefix( $post_id );

		if ( ! empty( $object_id ) && ! empty( $prefix ) ) {

			wp_update_post(
				array(
					'ID'        => absint( $post_id ),
					'post_name' => esc_html( $prefix . $object_id ),
				)
			);

		}

	}

	/**
	 * Returns the prefix for a taxonomy term.
	 *
	 * @param string $post_id Post ID.
	 * @return string
	 * @since 1.6.0
	 */
	public function get_taxonomy_term_prefix( string $post_id ) : string {

		$prefix = '';
		$terms  = get_the_terms( $post_id, 'rc_form' );

		if ( ! empty( $terms ) ) {
			foreach ( $terms as $term ) {
				$term_id = $term->term_id;
			}
		}

		if ( ! empty( $term_id ) ) {
			$prefix = get_term_meta( $term_id, 'rc_form_object_prefix', true );
		}

		return $prefix;
	}

	/**
	 * Remove metaboxes from post edit screen
	 *
	 * @return void
	 * @since 1.17.0
	 */
	public function remove_meta_box() {
		remove_meta_box( 'members-cp', 'post', 'advanced' );
	}

}
