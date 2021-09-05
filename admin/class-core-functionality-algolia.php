<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.claytoncollie.com
 * @since      1.2.0
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
class Core_Functionality_Algolia {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.2.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.2.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.2.0
	 * @param    string $plugin_name     The name of this plugin.
	 * @param    string $version         The version of this plugin.
	 */
	public function __construct( string $plugin_name, string $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Replaces the default gravatar URL with their custom photo from the user profile.
	 *
	 * @param array  $record Record data.
	 * @param object $item User meta.
	 *
	 * @return array
	 *
	 * @since 1.2.0
	 */
	public function avatar_url( array $record, object $item ) : array {

		$avatar_id = get_field( 'artist_photo', "user_{$item->ID}" );

		if ( ! empty( $avatar_id ) ) {

			$record['avatar_url'] = wp_get_attachment_url( $avatar_id );

		}

		return $record;

	}

	/**
	 * Get all image sizes into the index.
	 *
	 * @return array
	 *
	 * @since 1.2.0
	 */
	public function images_sizes() : array {
		return get_intermediate_image_sizes();
	}

	/**
	 * Remove certain post types from the index
	 *
	 * @return array
	 *
	 * @since 1.2.0
	 */
	public function post_types_blacklist() : array {
		return array(
			'nav_menu_item',
			'amn_smtp',
			'oembed_cache',
			'customize_changeset',
			'custom_css',
			'user_request',
			'attachment',
			'revision',
			'wp_block',
			'acf-field',
			'acf-field-group',
			'shop_order',
			'shop_order_refund',
			'shop_coupon',
			'deprecated_log',
			'wp_stream_alerts',
			'page',
			'post',
			'scheduled-action',
			'wp_template',
		);
	}

	/**
	 * Remove certain taxonomies from the index
	 *
	 * @return array
	 *
	 * @since 1.2.0
	 */
	public function taxonomies_blacklist() : array {
		return array(
			'nav_menu',
			'link_category',
			'category',
			'post_format',
			'rc_row',
			'rc_location',
			'rc_column',
			'rc_technique',
			'rc_form',
			'rc_firing',
			'post_tag',
			'rc_result',
			'action-group',
			'wp_theme',
		);
	}

	/**
	 * Define the additional attributes of Algolia.
	 *
	 * @param array   $attributes Default attributes.
	 * @param WP_Post $post WP_Post object.
	 *
	 * @return array
	 *
	 * @since 1.2.0
	 */
	public function index_attributes( array $attributes, WP_Post $post ) : array {

		$prefix = '';
		$id     = '';

		$terms = get_the_terms( $post, 'rc_form' );

		if ( ! empty( $terms ) ) {
			foreach ( $terms as $term ) {
				$prefix = get_field( 'rc_form_object_prefix', 'rc_form_' . $term->term_id );
			}
		}

		$object_id = get_post_meta( $post->ID, 'object_id', true );

		if ( ! empty( $object_id ) ) {
			$id = $object_id;
		}

		$attributes['rc_id'] = $prefix . $id;

		return $attributes;

	}

	/**
	 * Define the sorting and filtering settings for Algolia.
	 *
	 * @param array $settings Default settings.
	 *
	 * @return array
	 *
	 * @since 1.2.0
	 */
	public function index_settings( array $settings ) : array {

		$settings = array(
			'attributesToIndex'     => array(
				'unordered(post_title)',
				'unordered(rc_id)',
				'unordered(post_author.display_name)',
				'unordered(taxonomies)',
			),
			'attributesForFaceting' => array(
				'searchable(post_author.display_name)',
				'searchable(taxonomies)',
			),
		);

		return $settings;

	}

	/**
	 * Exclude certain post types from search results
	 *
	 * @param array  $args Arguments.
	 * @param string $post_type Post type.
	 *
	 * @return array
	 *
	 * @since 1.5.0
	 */
	public function exclude_from_search( array $args, string $post_type ) : array {

		if ( 'page' === $post_type ) {
			$args['exclude_from_search'] = true;
		}

		return $args;

	}

	/**
	 * Register and unregister assets.
	 *
	 * @return void
	 *
	 * @since 1.5.0
	 */
	public function register_scripts() {

		// Remove instantsearch version 1 that comes bundled with plugin.
		wp_deregister_script( 'algolia-instantsearch' );

		// Add instantsearch version 4 so we can use new widgets.
		wp_register_script( 'algolia-instantsearch', plugin_dir_url( __DIR__ ) . 'assets/js/instantsearch.production.min.js', array( 'jquery', 'underscore', 'wp-util' ), $this->version, false );

	}

}
