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
class Core_Functionality_Columns {

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
		unset( $defaults['taxonomy-rc_column'] );
		unset( $defaults['taxonomy-rc_row'] );
		unset( $defaults['taxonomy-rc_location'] );
		unset( $defaults['taxonomy-rc_result'] );

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
		$defaults['taxonomy-rc_column']    = esc_html__( 'Column', 'core-functionality' );
		$defaults['taxonomy-rc_row']       = esc_html__( 'Row', 'core-functionality' );
		$defaults['taxonomy-rc_location']  = esc_html__( 'Location', 'core-functionality' );
		$defaults['taxonomy-rc_result']    = esc_html__( 'Result', 'core-functionality' );
		$defaults['height']                = esc_html__( 'Height', 'core-functionality' );
		$defaults['width']                 = esc_html__( 'Width', 'core-functionality' );
		$defaults['length']                = esc_html__( 'Length', 'core-functionality' );
		$defaults['gallery']               = esc_html__( 'Gallery', 'core-functionality' );
		$defaults['purchase_price']        = esc_html__( 'Purchase Price', 'core-functionality' );
		$defaults['purchase_date']         = esc_html__( 'Purchase Date', 'core-functionality' );

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

				printf(
					'<a href="%s">%s</a>',
					esc_url( get_edit_post_link( $post_id ) ),
					get_the_post_thumbnail(
						$post_id,
						array(
							100,
							100,
						)
					)
				);

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

		if ( 'purchase_price' === $column_name ) {

			$purchase_price = get_field( 'rc_object_purchase_price', $post_id );

			if ( $purchase_price ) {

				echo esc_html( $purchase_price );

			}
		}

		if ( 'purchase_date' === $column_name ) {

			$purchase_date = get_field( 'rc_object_purchase_date', $post_id );

			if ( $purchase_date ) {

				echo esc_html( $purchase_date );

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
	 * Replaces the default gravatar URL with their custom photo from the user profile.
	 *
	 * @param string $url Gravatar URL.
	 * @param mixed  $user_meta User Meta.
	 * @param array  $args Arguments.
	 *
	 * @return string
	 *
	 * @since 1.15.0
	 */
	public function get_avatar_url( string $url, $user_meta, array $args ) : string {

		/**
		 * User meta is a mixed value so we have to see what we get before
		 * sending data to the custom field.
		 */
		if ( is_int( $user_meta ) ) {
			$user_id = $user_meta;
		} elseif ( is_string( $user_meta ) ) {
			$user = get_user_by( 'email', $user_meta );
			if ( ! empty( $user ) && is_object( $user ) ) {
				$user_id = $user->ID;
			} else {
				$user_id = false;
			}
		} elseif ( is_object( $user_meta ) ) {
			$user_id = $user_meta->ID;
		} else {
			$user_if = false;
		}

		if ( ! empty( $user_id ) ) {

			$avatar_id = get_field( 'artist_photo', "user_{$user_id}" );

			if ( ! empty( $avatar_id ) ) {

				$url = wp_get_attachment_url( $avatar_id );

			}
		}

		return $url;

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

		$columns['letter']  = esc_html__( 'Filter', 'core-functionality' );
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

		$user_info = get_userdata( $user_id );
		$letter    = get_field( 'artist_filter', 'user_' . $user_id );

		if ( 'letter' === $column_name ) {

			$value .= sprintf(
				'<a href="%s" target="_blank">%s</a>',
				esc_url(
					add_query_arg(
						'artist_filter',
						$letter,
						get_bloginfo( 'url' ) . '/artists'
					)
				),
				esc_html( ucwords( $letter ) )
			);

		}

		if ( 'website' === $column_name ) {

			$value .= sprintf(
				'<a target="_blank" href="%s">%s</a>',
				esc_url( $user_info->user_url ),
				esc_url( $user_info->user_url )
			);

		}

		return $value;

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

}
