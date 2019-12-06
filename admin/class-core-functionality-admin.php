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
	 * Remove submenu pages for category and post tag
	 *
	 * @since    1.0.0
	 */
	public function remove_sub_menus() {
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );
	}

	/**
	 * Unset category and post tag taxonomies
	 *
	 * @since    1.0.0
	 */
	public function unregister_taxonomy() {

		global $wp_taxonomies;

		$taxonomies = array( 'category' );

		foreach ( $taxonomies as $taxonomy ) {

			if ( taxonomy_exists( $taxonomy ) ) {

				unset( $wp_taxonomies[ $taxonomy ] );

			}
		}

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
	 * Remove XMLRPC pingback
	 *
	 * @since    1.0.0
	 */
	public function remove_dashboard_widgets() {

		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );

		// Remove Yoast SEO metabox.
		remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );

		// Remove WP Engine metabox.
		remove_meta_box( 'wpe_dify_news_feed', 'dashboard', 'normal' );

		// Remove welcome panel on dashboard.
		remove_action( 'welcome_panel', 'wp_welcome_panel' );

	}


	/**
	 * Custom dashboard
	 *
	 * @since    1.0.0
	 */
	public function custom_dashboard_widgets() {

		global $wp_meta_boxes;

		wp_add_dashboard_widget(
			'custom_help_widget',
			esc_html__( 'Welcome to the Rosenfield Collection', 'core-functionality' ),
			array( $this, 'dashboard_help' )
		);

	}

	/**
	 * Custom dashboard message
	 *
	 * @since    1.0.0
	 */
	public function dashboard_help() {

		printf(
			'<p>%s %s</p><p>%s</p><p>%s</p>',
			esc_html__( 'Hi there! This is where you can access your personal profile.', 'core-functionality' ),
			esc_html__( 'Select the Profile link on the left to change the spelling of your name, email address, website address, social media links or your profile photo.', 'core-functionality' ),
			esc_html__( 'Need extra help or want to report a problem with the website?', 'core-functionality' ),
			wp_kses_post( '<a href="mailto:info@rosenfieldcollection.com">info@rosenfieldcollection.com</a>' )
		);

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
				esc_html__( 'Media', 'core-functionality' ),
				esc_html__( 'Links', 'core-functionality' ),
				esc_html__( 'Appearance', 'core-functionality' ),
				esc_html__( 'Pages', 'core-functionality' ),
				esc_html__( 'Tools', 'core-functionality' ),
				esc_html__( 'Posts', 'core-functionality' ),
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
	 * Post column names
	 *
	 * @param array $defaults All defaults.
	 *
	 * @return array
	 *
	 * @since    1.0.0
	 */
	public function post_column_titles( array $defaults ) : array {

		// Unset default columns.
		unset( $defaults['title'] );
		unset( $defaults['author'] );
		unset( $defaults['categories'] );
		unset( $defaults['tags'] );
		unset( $defaults['comments'] );
		unset( $defaults['date'] );
		unset( $defaults['taxonomy-rc_form'] );
		unset( $defaults['taxonomy-rc_firing'] );
		unset( $defaults['taxonomy-rc_technique'] );
		unset( $defaults['taxonomy-rc_row'] );
		unset( $defaults['taxonomy-rc_column'] );
		unset( $defaults['taxonomy-rc_location'] );

		// Add columns with new order.
		$defaults['featured_image']        = esc_html__( 'Featured Image', 'core-functionality' );
		$defaults['title']                 = esc_html__( 'Title', 'core-functionality' );
		$defaults['author']                = esc_html__( 'Artist', 'core-functionality' );
		$defaults['rc_form_object_prefix'] = esc_html__( 'Prefix', 'core-functionality' );
		$defaults['object_id']             = esc_html__( 'ID', 'core-functionality' );
		$defaults['date']                  = esc_html__( 'Date', 'core-functionality' );
		$defaults['taxonomy-rc_form']      = esc_html__( 'Form', 'core-functionality' );
		$defaults['taxonomy-rc_firing']    = esc_html__( 'Firing', 'core-functionality' );
		$defaults['taxonomy-rc_technique'] = esc_html__( 'Technique', 'core-functionality' );
		$defaults['taxonomy-rc_row']       = esc_html__( 'Row', 'core-functionality' );
		$defaults['taxonomy-rc_column']    = esc_html__( 'Column', 'core-functionality' );
		$defaults['taxonomy-rc_location']  = esc_html__( 'Location', 'core-functionality' );
		$defaults['height']                = esc_html__( 'Height', 'core-functionality' );
		$defaults['width']                 = esc_html__( 'Width', 'core-functionality' );
		$defaults['length']                = esc_html__( 'Length', 'core-functionality' );
		$defaults['gallery']               = esc_html__( 'Gallery', 'core-functionality' );

		return $defaults;

	}


	/**
	 * Post column content
	 *
	 * @param string $column_name Column Name.
	 * @param string $post_id Post ID.
	 *
	 * @since    1.0.0
	 */
	public function post_column_content( string $column_name, string $post_id ) {

		if ( 'featured_image' === $column_name ) {

			if ( has_post_thumbnail( $post_id ) ) {

				the_post_thumbnail( 'thumbnail' );

			}
		}

		if ( 'rc_form_object_prefix' === $column_name ) {

			$terms = get_the_terms( $post_id, 'rc_form' );

			if ( ! empty( $terms ) ) {

				$term = array_pop( $terms );

				$prefix = get_field( 'rc_form_object_prefix', $term );

				if ( $prefix ) {

					echo esc_html( $prefix );

				}
			}
		}

		if ( 'object_id' === $column_name ) {

			$object_id = get_field( 'object_id', $post_id );

			if ( $object_id ) {

				echo esc_html( $object_id );

			}
		}

		if ( 'height' === $column_name ) {

			$height = get_field( 'height', $post_id );

			if ( $height ) {

				echo esc_html( $height );

			}
		}

		if ( 'width' === $column_name ) {

			$width = get_field( 'width', $post_id );

			if ( $width ) {

				echo esc_html( $width );

			}
		}

		if ( 'length' === $column_name ) {

			$length = get_field( 'length', $post_id );

			if ( $length ) {

				echo esc_html( $length );

			}
		}

		if ( 'gallery' === $column_name ) {

			$images = get_field( 'images', $post_id );

			if ( $images ) {

				foreach ( $images as $image ) :

					printf(
						'<img src="%s" style="width: 50px; float: left; margin: 0 5px 5px 0px;"/>',
						esc_url( $image['sizes']['thumbnail'] )
					);

				endforeach;

			}
		}

	}

	/**
	 * Sort the object ID column
	 *
	 * @param array $sortable Sortable columns.
	 *
	 * @return array
	 *
	 * @since    1.0.0
	 */
	public function post_id_column_sortable( array $sortable ) : array {
		$sortable['object_id'] = 'object_id';
		return $sortable;
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
		$taxonomies = array( 'rc_form', 'rc_firing', 'rc_technique', 'rc_row', 'rc_column', 'rc_location' );

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
	 * Custom column titles for users
	 *
	 * @param array $columns All columns.
	 *
	 * @return array
	 *
	 * @since    1.0.0
	 */
	public function user_column_titles( array $columns ) : array {

		$columns['photo']   = esc_html__( 'Photo', 'core-functionality' );
		$columns['website'] = esc_html__( 'Website', 'core-functionality' );

		return $columns;
	}

	/**
	 * Content for user columns
	 *
	 * @param string $value Column content.
	 * @param string $column_name Column name.
	 * @param string $user_id User ID.
	 *
	 * @return string
	 *
	 * @since    1.0.0
	 */
	public function user_column_content( string $value, string $column_name, string $user_id ) : string {

		$user_info     = get_userdata( $user_id );
		$attachment_id = get_field( 'artist_photo', 'user_' . $user_id );
		$author_avatar = wp_get_attachment_image_src( $attachment_id, 'artist-image' );

		if ( 'website' === $column_name ) {

			$value .= sprintf(
				'<a target="_blank" href="%s">%s</a>',
				esc_url( $user_info->user_url ),
				esc_url( $user_info->user_url )
			);

		}

		if ( 'photo' === $column_name ) {

			$value .= sprintf(
				'<img src="%s" style="max-height: 100px;">',
				esc_url( $author_avatar[0] )
			);

		}

		return $value;

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

	/**
	 * Taxonomy column titles for rc_form
	 *
	 * @param array $defaults Column defaults.
	 *
	 * @return array
	 *
	 * @since    1.0.0
	 */
	public function form_taxonomy_column_title( array $defaults ) : array {

		// Unset default columns.
		unset( $defaults['name'] );
		unset( $defaults['description'] );
		unset( $defaults['slug'] );
		unset( $defaults['posts'] );

		// Add columns back in proper order.
		$defaults['name']                  = esc_html__( 'Name', 'core-functionality' );
		$defaults['rc_form_object_prefix'] = esc_html__( 'Prefix', 'core-functionality' );
		$defaults['slug']                  = esc_html__( 'Slug', 'core-functionality' );
		$defaults['posts']                 = esc_html__( 'Count', 'core-functionality' );

		return $defaults;
	}

	/**
	 * Taxonomy column content for rc_form
	 *
	 * @param string $content Column content.
	 * @param string $column_name Column name.
	 * @param string $term_id Taxonomy term id.
	 *
	 * @return string
	 *
	 * @since    1.0.0
	 */
	public function form_taxonomy_column_content( string $content, string $column_name, string $term_id ) : string {

		switch ( $column_name ) {

			case 'rc_form_object_prefix':
				$prefix = get_field( 'rc_form_object_prefix', 'rc_form_' . $term_id );

				if ( $prefix ) {
					$content = $prefix;
				}

				break;

		}

		return $content;

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
					'post_name' => $prefix . $object_id,
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

}
