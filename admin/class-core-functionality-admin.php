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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Remove submenu pages for category and post tag
	 *
	 * @since    1.0.0
	 */
	public function remove_sub_menus() {
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=category' );
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
	}

	/**
	 * Unset category and post tag taxonomies
	 *
	 * @since    1.0.0
	 */
	public function unregister_taxonomy() {

		global $wp_taxonomies;

		$taxonomies = array( 'category', 'post_tag' );

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

		// Remove feed links
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );

		// Remove Shortlink URL
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );

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
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );

	}

	/**
	 * Remove XMLRPC pingback
	 *
	 * @since    1.0.0
	 */
	public function remove_xmlrpc_pingback_ping( $methods ) {
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
		// remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );

		// Remove Yoast SEO metabox
		remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );

		// Remove WP Engine metabox
		remove_meta_box( 'wpe_dify_news_feed', 'dashboard', 'normal' );

		// Remove welcome panel on dashboard
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
			__( 'Welcome to the Rosenfield Collection', 'core-functionality' ),
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
			__( 'Hi there! This is where you can access your personal profile.', 'core-functionality' ),
			__( 'Select the Profile link on the left to change the spelling of your name, email address, website address, social media links or your profile photo.', 'core-functionality' ),
			__( 'Need extra help or want to report a problem with the website?', 'core-functionality' ),
			__( 'Contact the team at <a href="mailto:info@rosenfieldcollection.com">info@rosenfieldcollection.com</a>', 'core-functionality' )
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
				__( 'Media' ),
				__( 'Links' ),
				__( 'Appearance' ),
				__( 'Pages' ),
				__( 'Tools' ),
				__( 'Posts' ),
				__( 'Settings' ),
				__( 'Comments' ),
				__( 'Plugins' ),
			);

			end( $menu );

			while ( prev( $menu ) ) {

				$value = explode( ' ', $menu[ key( $menu ) ][0] );

				if ( in_array( $value[0] != null ? $value[0] : '', $restricted ) ) {

					unset( $menu[ key( $menu ) ] );

				}
			}
		}
	}


	/**
	 * Post column names
	 *
	 * @since    1.0.0
	 */
	public function post_column_titles( $defaults ) {

		// Unset default columns
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

		// add columns with new order
		$defaults['featured_image']        = __( 'Featured Image', 'core-functionality' );
		$defaults['title']                 = __( 'Title', 'core-functionality' );
		$defaults['author']                = __( 'Artist', 'core-functionality' );
		$defaults['rc_form_object_prefix'] = __( 'Prefix', 'core-functionality' );
		$defaults['object_id']             = __( 'ID', 'core-functionality' );
		$defaults['date']                  = __( 'Date', 'core-functionality' );
		$defaults['taxonomy-rc_form']      = __( 'Form', 'core-functionality' );
		$defaults['taxonomy-rc_firing']    = __( 'Firing', 'core-functionality' );
		$defaults['taxonomy-rc_technique'] = __( 'Technique', 'core-functionality' );
		$defaults['taxonomy-rc_row']       = __( 'Row', 'core-functionality' );
		$defaults['taxonomy-rc_column']    = __( 'Column', 'core-functionality' );
		$defaults['taxonomy-rc_location']  = __( 'Location', 'core-functionality' );
		$defaults['height']                = __( 'Height', 'core-functionality' );
		$defaults['width']                 = __( 'Width', 'core-functionality' );
		$defaults['length']                = __( 'Length', 'core-functionality' );
		$defaults['gallery']               = __( 'Gallery', 'core-functionality' );

		return $defaults;

	}


	/**
	 * Post column content
	 *
	 * @since    1.0.0
	 */
	public function post_column_content( $column_name, $post_id ) {

		if ( $column_name == 'featured_image' ) {

			if ( has_post_thumbnail( $post_id ) ) {

				the_post_thumbnail( 'thumbnail' );

			}
		}

		if ( $column_name == 'rc_form_object_prefix' ) {

			$terms = get_the_terms( $post_id, 'rc_form' );

			if ( ! empty( $terms ) ) {

				$term = array_pop( $terms );

				$prefix = get_field( 'rc_form_object_prefix', $term );

				if ( $prefix ) {

					echo esc_html( $prefix );

				}
			}
		}

		if ( $column_name == 'object_id' ) {

			$object_id = get_field( 'object_id', $post_id );

			if ( $object_id ) {

				echo esc_html( $object_id );

			}
		}

		if ( $column_name == 'height' ) {

			$height = get_field( 'height', $post_id );

			if ( $height ) {

				echo esc_html( $height );

			}
		}

		if ( $column_name == 'width' ) {

			$width = get_field( 'width', $post_id );

			if ( $width ) {

				echo esc_html( $width );

			}
		}

		if ( $column_name == 'length' ) {

			$length = get_field( 'length', $post_id );

			if ( $length ) {

				echo esc_html( $length );

			}
		}

		if ( $column_name == 'gallery' ) {

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
	 * @since    1.0.0
	 */
	public function post_id_column_sortable( $sortable ) {
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

		// an array of all the taxonomyies you want to display. Use the taxonomy name or slug
		$taxonomies = array( 'rc_form', 'rc_firing', 'rc_technique', 'rc_row', 'rc_column', 'rc_location' );

		// must set this to the post type you want the filter(s) displayed on
		if ( $typenow == 'post' ) {

			foreach ( $taxonomies as $tax_slug ) {

				$tax_obj = get_taxonomy( $tax_slug );

				$tax_name = $tax_obj->labels->name;

				$terms = get_terms( $tax_slug );

				$current_tax_slug = isset( $_GET[ $tax_slug ] );

				$_GET[ $tax_slug ] = false;

				if ( count( $terms ) > 0 ) {

					printf(
						'<select name=%s id=%s class="postform">',
						esc_attr( $tax_slug ),
						esc_attr( $tax_slug )
					);

					printf(
						'<option value="">%s %s</option>',
						__( 'Show All', 'core-functionality' ),
						esc_html( $tax_name )
					);

					foreach ( $terms as $term ) {

						printf(
							'<option value=%s %s>%s (%s)</option>',
							esc_attr( $term->slug ),
							$_GET[ $tax_slug ] == $term->slug ? ' selected="selected"' : '',
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
	 * @since    1.0.0
	 */
	public function user_column_titles( $columns ) {

		$columns['photo']   = __( 'Photo', 'core-functionality' );
		$columns['website'] = __( 'Website', 'core-functionality' );

		return $columns;
	}

	/**
	 * Content for user columns
	 *
	 * @since    1.0.0
	 */
	public function user_column_content( $value, $column_name, $user_id ) {

		$user_info     = get_userdata( $user_id );
		$attachment_id = get_field( 'artist_photo', 'user_' . $user_id );
		$author_avatar = wp_get_attachment_image_src( $attachment_id, 'artist-image' );

		if ( 'website' == $column_name ) {

			$output = sprintf(
				'<a target="_blank" href="%s">%s</a>',
				esc_url( $user_info->user_url ),
				esc_url( $user_info->user_url )
			);

			return $output;

		}

		if ( 'photo' == $column_name ) {

			$output = sprintf(
				'<img src="%s" style="max-height: 100px;">',
				esc_url( $author_avatar[0] )
			);

			return $output;

		}
	}

	/**
	 * Custom contact methods for each user profile
	 *
	 * @since    1.0.0
	 */
	public function modify_user_contact_methods( $user_contact ) {

		unset( $user_contact['aim'] );
		unset( $user_contact['jabber'] );
		unset( $user_contact['yim'] );
		unset( $user_contact['gplus'] );

		$user_contact['twitter']   = __( 'Twitter', 'core-functionality' );
		$user_contact['facebook']  = __( 'Facebook', 'core-functionality' );
		$user_contact['instagram'] = __( 'Instagram', 'core-functionality' );
		$user_contact['pinterest'] = __( 'Pinterest', 'core-functionality' );

		return $user_contact;

	}

	/**
	 * rc_form taxonomy column titles
	 *
	 * @since    1.0.0
	 */
	public function form_taxonomy_column_title( $defaults ) {

		// Unset default columns
		unset( $defaults['name'] );
		unset( $defaults['description'] );
		unset( $defaults['slug'] );
		unset( $defaults['posts'] );

		// Add columns back in proper order
		$defaults['name']                  = __( 'Name', 'core-functionality' );
		$defaults['rc_form_object_prefix'] = __( 'Prefix', 'core-functionality' );
		$defaults['slug']                  = __( 'Slug', 'core-functionality' );
		$defaults['posts']                 = __( 'Count', 'core-functionality' );

		return $defaults;
	}

	/**
	 * rc_form taxonomy column content
	 *
	 * @since    1.0.0
	 */
	public function form_taxonomy_column_content( $content, $column_name, $term_id ) {

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

	function add_image_to_RSS( $content ) {

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




}
