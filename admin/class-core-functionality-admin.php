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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		// Add website to All Users list view
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/core-functionality-admin-user-columns.php';

		// Clean up the HEADER section
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/core-functionality-admin-clean-header.php';

		// Change post columns
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/core-functionality-admin-post-columns.php';

		// Modify admin dashboard
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/core-functionality-admin-dashboard.php';

		// Modify user contact methods
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/core-functionality-admin-user-contact-fields.php';

		// Disable comments functionality
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/core-functionality-admin-comments.php';
		
		// Taxonomy - FORM
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/core-functionality-admin-taxonomy-form.php';
		
		// Taxonomy - FIRING
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/core-functionality-admin-taxonomy-firing.php';
		
		// Taxonomy - TECHNIQUE
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/core-functionality-admin-taxonomy-technique.php';
		
		// Taxonomy - ROW
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/core-functionality-admin-taxonomy-row.php';
		
		// Taxonomy - COLUMN
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/core-functionality-admin-taxonomy-column.php';
		
		// Remove categories and tags from admin section
		add_action('admin_menu', 'my_remove_sub_menus');
		function my_remove_sub_menus() {
			remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');
			remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
		}

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Core_Functionality_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Core_Functionality_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/core-functionality-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Core_Functionality_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Core_Functionality_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		//wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/core-functionality-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	
}

