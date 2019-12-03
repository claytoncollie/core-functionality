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
class Core_Functionality_Taxonomy {

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
	 * Taxonomy - Column
	 *
	 * @since    1.0.0
	 */
	public function taxonomy_column() {

		$labels = array(
			'name'                       => _x( 'Columns', 'Taxonomy General Name', 'core-functionality' ),
			'singular_name'              => _x( 'Column', 'Taxonomy Singular Name', 'core-functionality' ),
			'menu_name'                  => __( 'Columns', 'core-functionality' ),
			'all_items'                  => __( 'All Items', 'core-functionality' ),
			'parent_item'                => __( 'Parent Item', 'core-functionality' ),
			'parent_item_colon'          => __( 'Parent Item:', 'core-functionality' ),
			'new_item_name'              => __( 'New Item Name', 'core-functionality' ),
			'add_new_item'               => __( 'Add New Item', 'core-functionality' ),
			'edit_item'                  => __( 'Edit Item', 'core-functionality' ),
			'update_item'                => __( 'Update Item', 'core-functionality' ),
			'view_item'                  => __( 'View Item', 'core-functionality' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'core-functionality' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'core-functionality' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'core-functionality' ),
			'popular_items'              => __( 'Popular Items', 'core-functionality' ),
			'search_items'               => __( 'Search Items', 'core-functionality' ),
			'not_found'                  => __( 'Not Found', 'core-functionality' ),
		);

		$rewrite = array(
			'slug'         => 'column',
			'with_front'   => true,
			'hierarchical' => false,
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'query_var'         => true,
			'rewrite'           => $rewrite,
			'meta_box_cb'       => false,
		);

		register_taxonomy( 'rc_column', array( 'post' ), $args );

	}

	/**
	 * Taxonomy - Firing
	 *
	 * @since    1.0.0
	 */
	public function taxonomy_firing() {

		$labels = array(
			'name'                       => _x( 'Firings', 'Taxonomy General Name', 'core-functionality' ),
			'singular_name'              => _x( 'Firing', 'Taxonomy Singular Name', 'core-functionality' ),
			'menu_name'                  => __( 'Firings', 'core-functionality' ),
			'all_items'                  => __( 'All Items', 'core-functionality' ),
			'parent_item'                => __( 'Parent Item', 'core-functionality' ),
			'parent_item_colon'          => __( 'Parent Item:', 'core-functionality' ),
			'new_item_name'              => __( 'New Item Name', 'core-functionality' ),
			'add_new_item'               => __( 'Add New Item', 'core-functionality' ),
			'edit_item'                  => __( 'Edit Item', 'core-functionality' ),
			'update_item'                => __( 'Update Item', 'core-functionality' ),
			'view_item'                  => __( 'View Item', 'core-functionality' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'core-functionality' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'core-functionality' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'core-functionality' ),
			'popular_items'              => __( 'Popular Items', 'core-functionality' ),
			'search_items'               => __( 'Search Items', 'core-functionality' ),
			'not_found'                  => __( 'Not Found', 'core-functionality' ),
		);

		$rewrite = array(
			'slug'         => 'firing',
			'with_front'   => true,
			'hierarchical' => true,
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'query_var'         => true,
			'rewrite'           => $rewrite,
			'meta_box_cb'       => false,
		);

		register_taxonomy( 'rc_firing', array( 'post' ), $args );

	}

	/**
	 * Taxonomy - Form
	 *
	 * @since    1.0.0
	 */
	public function taxonomy_form() {

		$labels = array(
			'name'                       => _x( 'Forms', 'Taxonomy General Name', 'core-functionality' ),
			'singular_name'              => _x( 'Form', 'Taxonomy Singular Name', 'core-functionality' ),
			'menu_name'                  => __( 'Forms', 'core-functionality' ),
			'all_items'                  => __( 'All Items', 'core-functionality' ),
			'parent_item'                => __( 'Parent Item', 'core-functionality' ),
			'parent_item_colon'          => __( 'Parent Item:', 'core-functionality' ),
			'new_item_name'              => __( 'New Item Name', 'core-functionality' ),
			'add_new_item'               => __( 'Add New Item', 'core-functionality' ),
			'edit_item'                  => __( 'Edit Item', 'core-functionality' ),
			'update_item'                => __( 'Update Item', 'core-functionality' ),
			'view_item'                  => __( 'View Item', 'core-functionality' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'core-functionality' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'core-functionality' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'core-functionality' ),
			'popular_items'              => __( 'Popular Items', 'core-functionality' ),
			'search_items'               => __( 'Search Items', 'core-functionality' ),
			'not_found'                  => __( 'Not Found', 'core-functionality' ),
		);

		$rewrite = array(
			'slug'         => 'form',
			'with_front'   => true,
			'hierarchical' => false,
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'query_var'         => true,
			'rewrite'           => $rewrite,
			'meta_box_cb'       => false,
		);

		register_taxonomy( 'rc_form', array( 'post' ), $args );

	}

	/**
	 * Taxonomy - Location
	 *
	 * @since    1.0.0
	 */
	public function taxonomy_location() {

		$labels = array(
			'name'                       => _x( 'Locations', 'Taxonomy General Name', 'core-functionality' ),
			'singular_name'              => _x( 'Location', 'Taxonomy Singular Name', 'core-functionality' ),
			'menu_name'                  => __( 'Locations', 'core-functionality' ),
			'all_items'                  => __( 'All Items', 'core-functionality' ),
			'parent_item'                => __( 'Parent Item', 'core-functionality' ),
			'parent_item_colon'          => __( 'Parent Item:', 'core-functionality' ),
			'new_item_name'              => __( 'New Item Name', 'core-functionality' ),
			'add_new_item'               => __( 'Add New Item', 'core-functionality' ),
			'edit_item'                  => __( 'Edit Item', 'core-functionality' ),
			'update_item'                => __( 'Update Item', 'core-functionality' ),
			'view_item'                  => __( 'View Item', 'core-functionality' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'core-functionality' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'core-functionality' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'core-functionality' ),
			'popular_items'              => __( 'Popular Items', 'core-functionality' ),
			'search_items'               => __( 'Search Items', 'core-functionality' ),
			'not_found'                  => __( 'Not Found', 'core-functionality' ),
		);

		$rewrite = array(
			'slug'         => 'location',
			'with_front'   => true,
			'hierarchical' => true,
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'query_var'         => true,
			'rewrite'           => $rewrite,
			'meta_box_cb'       => false,
		);

		register_taxonomy( 'rc_location', array( 'post' ), $args );

	}


	/**
	 * Taxonomy - Row
	 *
	 * @since    1.0.0
	 */
	public function taxonomy_row() {

		$labels = array(
			'name'                       => _x( 'Rows', 'Taxonomy General Name', 'core-functionality' ),
			'singular_name'              => _x( 'Row', 'Taxonomy Singular Name', 'core-functionality' ),
			'menu_name'                  => __( 'Rows', 'core-functionality' ),
			'all_items'                  => __( 'All Items', 'core-functionality' ),
			'parent_item'                => __( 'Parent Item', 'core-functionality' ),
			'parent_item_colon'          => __( 'Parent Item:', 'core-functionality' ),
			'new_item_name'              => __( 'New Item Name', 'core-functionality' ),
			'add_new_item'               => __( 'Add New Item', 'core-functionality' ),
			'edit_item'                  => __( 'Edit Item', 'core-functionality' ),
			'update_item'                => __( 'Update Item', 'core-functionality' ),
			'view_item'                  => __( 'View Item', 'core-functionality' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'core-functionality' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'core-functionality' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'core-functionality' ),
			'popular_items'              => __( 'Popular Items', 'core-functionality' ),
			'search_items'               => __( 'Search Items', 'core-functionality' ),
			'not_found'                  => __( 'Not Found', 'core-functionality' ),
		);

		$rewrite = array(
			'slug'         => 'row',
			'with_front'   => true,
			'hierarchical' => false,
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'query_var'         => true,
			'rewrite'           => $rewrite,
			'meta_box_cb'       => false,
		);

		register_taxonomy( 'rc_row', array( 'post' ), $args );

	}

	/**
	 * Taxonomy - Technique
	 *
	 * @since    1.0.0
	 */
	public function taxonomy_technique() {

		$labels = array(
			'name'                       => _x( 'Techniques', 'Taxonomy General Name', 'core-functionality' ),
			'singular_name'              => _x( 'Technique', 'Taxonomy Singular Name', 'core-functionality' ),
			'menu_name'                  => __( 'Techniques', 'core-functionality' ),
			'all_items'                  => __( 'All Items', 'core-functionality' ),
			'parent_item'                => __( 'Parent Item', 'core-functionality' ),
			'parent_item_colon'          => __( 'Parent Item:', 'core-functionality' ),
			'new_item_name'              => __( 'New Item Name', 'core-functionality' ),
			'add_new_item'               => __( 'Add New Item', 'core-functionality' ),
			'edit_item'                  => __( 'Edit Item', 'core-functionality' ),
			'update_item'                => __( 'Update Item', 'core-functionality' ),
			'view_item'                  => __( 'View Item', 'core-functionality' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'core-functionality' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'core-functionality' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'core-functionality' ),
			'popular_items'              => __( 'Popular Items', 'core-functionality' ),
			'search_items'               => __( 'Search Items', 'core-functionality' ),
			'not_found'                  => __( 'Not Found', 'core-functionality' ),
		);

		$rewrite = array(
			'slug'         => 'technique',
			'with_front'   => true,
			'hierarchical' => false,
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'query_var'         => true,
			'rewrite'           => $rewrite,
			'meta_box_cb'       => false,
		);

		register_taxonomy( 'rc_technique', array( 'post' ), $args );

	}


}
