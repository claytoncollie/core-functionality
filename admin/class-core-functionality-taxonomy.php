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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Taxonomy - Column
	 *
	 * @since    1.0.0
	 */
	public function rc_taxonomy_column() {

		$labels = array(
			'name'                       => _x( 'Columns', 'Taxonomy General Name', $this->plugin_name ),
			'singular_name'              => _x( 'Column', 'Taxonomy Singular Name', $this->plugin_name ),
			'menu_name'                  => __( 'Columns', $this->plugin_name ),
			'all_items'                  => __( 'All Items', $this->plugin_name ),
			'parent_item'                => __( 'Parent Item', $this->plugin_name ),
			'parent_item_colon'          => __( 'Parent Item:', $this->plugin_name ),
			'new_item_name'              => __( 'New Item Name', $this->plugin_name ),
			'add_new_item'               => __( 'Add New Item', $this->plugin_name ),
			'edit_item'                  => __( 'Edit Item', $this->plugin_name ),
			'update_item'                => __( 'Update Item', $this->plugin_name ),
			'view_item'                  => __( 'View Item', $this->plugin_name ),
			'separate_items_with_commas' => __( 'Separate items with commas', $this->plugin_name ),
			'add_or_remove_items'        => __( 'Add or remove items', $this->plugin_name ),
			'choose_from_most_used'      => __( 'Choose from the most used', $this->plugin_name ),
			'popular_items'              => __( 'Popular Items', $this->plugin_name ),
			'search_items'               => __( 'Search Items', $this->plugin_name ),
			'not_found'                  => __( 'Not Found', $this->plugin_name ),
		);

		$rewrite = array(
			'slug'         => 'column',
			'with_front'   => true,
			'hierarchical' => false,
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'query_var'         => true,
			'rewrite'           => $rewrite,
		);

		register_taxonomy( 'rc_column', array( 'post' ), $args );

	}

	/**
	 * Taxonomy - Firing
	 *
	 * @since    1.0.0
	 */
	public function rc_taxonomy_firing() {

		$labels = array(
			'name'                       => _x( 'Firings', 'Taxonomy General Name', $this->plugin_name ),
			'singular_name'              => _x( 'Firing', 'Taxonomy Singular Name', $this->plugin_name ),
			'menu_name'                  => __( 'Firings', $this->plugin_name ),
			'all_items'                  => __( 'All Items', $this->plugin_name ),
			'parent_item'                => __( 'Parent Item', $this->plugin_name ),
			'parent_item_colon'          => __( 'Parent Item:', $this->plugin_name ),
			'new_item_name'              => __( 'New Item Name', $this->plugin_name ),
			'add_new_item'               => __( 'Add New Item', $this->plugin_name ),
			'edit_item'                  => __( 'Edit Item', $this->plugin_name ),
			'update_item'                => __( 'Update Item', $this->plugin_name ),
			'view_item'                  => __( 'View Item', $this->plugin_name ),
			'separate_items_with_commas' => __( 'Separate items with commas', $this->plugin_name ),
			'add_or_remove_items'        => __( 'Add or remove items', $this->plugin_name ),
			'choose_from_most_used'      => __( 'Choose from the most used', $this->plugin_name ),
			'popular_items'              => __( 'Popular Items', $this->plugin_name ),
			'search_items'               => __( 'Search Items', $this->plugin_name ),
			'not_found'                  => __( 'Not Found', $this->plugin_name ),
		);

		$rewrite = array(
			'slug'         => 'firing',
			'with_front'   => true,
			'hierarchical' => true,
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'query_var'         => true,
			'rewrite'           => $rewrite,
		);

		register_taxonomy( 'rc_firing', array( 'post' ), $args );

	}

	/**
	 * Taxonomy - Form
	 *
	 * @since    1.0.0
	 */
	public function rc_taxonomy_form() {

		$labels = array(
			'name'                       => _x( 'Forms', 'Taxonomy General Name', $this->plugin_name ),
			'singular_name'              => _x( 'Form', 'Taxonomy Singular Name', $this->plugin_name ),
			'menu_name'                  => __( 'Forms', $this->plugin_name ),
			'all_items'                  => __( 'All Items', $this->plugin_name ),
			'parent_item'                => __( 'Parent Item', $this->plugin_name ),
			'parent_item_colon'          => __( 'Parent Item:', $this->plugin_name ),
			'new_item_name'              => __( 'New Item Name', $this->plugin_name ),
			'add_new_item'               => __( 'Add New Item', $this->plugin_name ),
			'edit_item'                  => __( 'Edit Item', $this->plugin_name ),
			'update_item'                => __( 'Update Item', $this->plugin_name ),
			'view_item'                  => __( 'View Item', $this->plugin_name ),
			'separate_items_with_commas' => __( 'Separate items with commas', $this->plugin_name ),
			'add_or_remove_items'        => __( 'Add or remove items', $this->plugin_name ),
			'choose_from_most_used'      => __( 'Choose from the most used', $this->plugin_name ),
			'popular_items'              => __( 'Popular Items', $this->plugin_name ),
			'search_items'               => __( 'Search Items', $this->plugin_name ),
			'not_found'                  => __( 'Not Found', $this->plugin_name ),
		);

		$rewrite = array(
			'slug'         => 'form',
			'with_front'   => true,
			'hierarchical' => false,
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'query_var'         => true,
			'rewrite'           => $rewrite,
		);

		register_taxonomy( 'rc_form', array( 'post' ), $args );

	}

	/**
	 * Taxonomy - Location
	 *
	 * @since    1.0.0
	 */
	public function rc_taxonomy_location() {

		$labels = array(
			'name'                       => _x( 'Locations', 'Taxonomy General Name', $this->plugin_name ),
			'singular_name'              => _x( 'Location', 'Taxonomy Singular Name', $this->plugin_name ),
			'menu_name'                  => __( 'Locations', $this->plugin_name ),
			'all_items'                  => __( 'All Items', $this->plugin_name ),
			'parent_item'                => __( 'Parent Item', $this->plugin_name ),
			'parent_item_colon'          => __( 'Parent Item:', $this->plugin_name ),
			'new_item_name'              => __( 'New Item Name', $this->plugin_name ),
			'add_new_item'               => __( 'Add New Item', $this->plugin_name ),
			'edit_item'                  => __( 'Edit Item', $this->plugin_name ),
			'update_item'                => __( 'Update Item', $this->plugin_name ),
			'view_item'                  => __( 'View Item', $this->plugin_name ),
			'separate_items_with_commas' => __( 'Separate items with commas', $this->plugin_name ),
			'add_or_remove_items'        => __( 'Add or remove items', $this->plugin_name ),
			'choose_from_most_used'      => __( 'Choose from the most used', $this->plugin_name ),
			'popular_items'              => __( 'Popular Items', $this->plugin_name ),
			'search_items'               => __( 'Search Items', $this->plugin_name ),
			'not_found'                  => __( 'Not Found', $this->plugin_name ),
		);

		$rewrite = array(
			'slug'         => 'location',
			'with_front'   => true,
			'hierarchical' => true,
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'query_var'         => true,
			'rewrite'           => $rewrite,
		);

		register_taxonomy( 'rc_location', array( 'post' ), $args );

	}


	/**
	 * Taxonomy - Row
	 *
	 * @since    1.0.0
	 */
	public function rc_taxonomy_row() {

		$labels = array(
			'name'                       => _x( 'Rows', 'Taxonomy General Name', $this->plugin_name ),
			'singular_name'              => _x( 'Row', 'Taxonomy Singular Name', $this->plugin_name ),
			'menu_name'                  => __( 'Rows', $this->plugin_name ),
			'all_items'                  => __( 'All Items', $this->plugin_name ),
			'parent_item'                => __( 'Parent Item', $this->plugin_name ),
			'parent_item_colon'          => __( 'Parent Item:', $this->plugin_name ),
			'new_item_name'              => __( 'New Item Name', $this->plugin_name ),
			'add_new_item'               => __( 'Add New Item', $this->plugin_name ),
			'edit_item'                  => __( 'Edit Item', $this->plugin_name ),
			'update_item'                => __( 'Update Item', $this->plugin_name ),
			'view_item'                  => __( 'View Item', $this->plugin_name ),
			'separate_items_with_commas' => __( 'Separate items with commas', $this->plugin_name ),
			'add_or_remove_items'        => __( 'Add or remove items', $this->plugin_name ),
			'choose_from_most_used'      => __( 'Choose from the most used', $this->plugin_name ),
			'popular_items'              => __( 'Popular Items', $this->plugin_name ),
			'search_items'               => __( 'Search Items', $this->plugin_name ),
			'not_found'                  => __( 'Not Found', $this->plugin_name ),
		);

		$rewrite = array(
			'slug'         => 'row',
			'with_front'   => true,
			'hierarchical' => false,
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'query_var'         => true,
			'rewrite'           => $rewrite,
		);

		register_taxonomy( 'rc_row', array( 'post' ), $args );

	}

	/**
	 * Taxonomy - Technique
	 *
	 * @since    1.0.0
	 */
	public function rc_taxonomy_technique() {

		$labels = array(
			'name'                       => _x( 'Techniques', 'Taxonomy General Name', $this->plugin_name ),
			'singular_name'              => _x( 'Technique', 'Taxonomy Singular Name', $this->plugin_name ),
			'menu_name'                  => __( 'Techniques', $this->plugin_name ),
			'all_items'                  => __( 'All Items', $this->plugin_name ),
			'parent_item'                => __( 'Parent Item', $this->plugin_name ),
			'parent_item_colon'          => __( 'Parent Item:', $this->plugin_name ),
			'new_item_name'              => __( 'New Item Name', $this->plugin_name ),
			'add_new_item'               => __( 'Add New Item', $this->plugin_name ),
			'edit_item'                  => __( 'Edit Item', $this->plugin_name ),
			'update_item'                => __( 'Update Item', $this->plugin_name ),
			'view_item'                  => __( 'View Item', $this->plugin_name ),
			'separate_items_with_commas' => __( 'Separate items with commas', $this->plugin_name ),
			'add_or_remove_items'        => __( 'Add or remove items', $this->plugin_name ),
			'choose_from_most_used'      => __( 'Choose from the most used', $this->plugin_name ),
			'popular_items'              => __( 'Popular Items', $this->plugin_name ),
			'search_items'               => __( 'Search Items', $this->plugin_name ),
			'not_found'                  => __( 'Not Found', $this->plugin_name ),
		);

		$rewrite = array(
			'slug'         => 'technique',
			'with_front'   => true,
			'hierarchical' => false,
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'query_var'         => true,
			'rewrite'           => $rewrite,
		);

		register_taxonomy( 'rc_technique', array( 'post' ), $args );

	}


}
