<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.claytoncollie.com
 * @since      1.0.0
 *
 * @package    Core_Functionality
 * @subpackage Core_Functionality/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Core_Functionality
 * @subpackage Core_Functionality/includes
 * @author     Clayton Collie <clayton.collie@gmail.com>
 */
class Core_Functionality {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Core_Functionality_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'core-functionality';
		$this->version     = '1.4.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Core_Functionality_Loader. Orchestrates the hooks of the plugin.
	 * - Core_Functionality_i18n. Defines internationalization functionality.
	 * - Core_Functionality_Admin. Defines all hooks for the admin area.
	 * - Core_Functionality_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-core-functionality-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-core-functionality-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-core-functionality-admin.php';

		/**
		 * The class responsible for defining all actions that occur related to Algolia Search.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-core-functionality-algolia.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-core-functionality-comments.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-core-functionality-taxonomy.php';

		$this->loader = new Core_Functionality_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Core_Functionality_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Core_Functionality_I18n();

		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$admin    = new Core_Functionality_Admin( $this->get_plugin_name(), $this->get_version() );
		$algolia  = new Core_Functionality_Algolia( $this->get_plugin_name(), $this->get_version() );
		$comments = new Core_Functionality_Comments( $this->get_plugin_name(), $this->get_version() );
		$taxonomy = new Core_Functionality_Taxonomy( $this->get_plugin_name(), $this->get_version() );

		if ( isset( $admin ) ) {
			$this->loader->add_filter( 'use_block_editor_for_post_type', $admin, 'gutenberg_support', 10, 2 );
			$this->loader->add_filter( 'acf/settings/save_json', $admin, 'acf_local_json_save_location' );
			$this->loader->add_filter( 'acf/settings/load_json', $admin, 'acf_local_json_load_location' );
			$this->loader->add_action( 'admin_menu', $admin, 'remove_sub_menus' );
			$this->loader->add_action( 'init', $admin, 'unregister_taxonomy' );
			$this->loader->add_action( 'init', $admin, 'clean_header' );
			$this->loader->add_filter( 'xmlrpc_methods', $admin, 'remove_xmlrpc_pingback_ping' );
			$this->loader->add_action( 'admin_init', $admin, 'remove_dashboard_widgets' );
			$this->loader->add_action( 'wp_dashboard_setup', $admin, 'custom_dashboard_widgets' );
			$this->loader->add_action( 'admin_menu', $admin, 'remove_admin_menus' );
			$this->loader->add_action( 'manage_posts_columns', $admin, 'post_column_titles' );
			$this->loader->add_action( 'manage_posts_custom_column', $admin, 'post_column_content', 10, 2 );
			$this->loader->add_filter( 'manage_edit-post_sortable_columns', $admin, 'post_id_column_sortable' );
			$this->loader->add_action( 'load-edit.php', $admin, 'no_category_dropdown' );
			$this->loader->add_action( 'restrict_manage_posts', $admin, 'add_taxonomy_filters_form' );
			$this->loader->add_filter( 'manage_users_columns', $admin, 'user_column_titles' );
			$this->loader->add_action( 'manage_users_custom_column', $admin, 'user_column_content', 10, 3 );
			$this->loader->add_action( 'user_contactmethods', $admin, 'modify_user_contact_methods' );
			$this->loader->add_filter( 'manage_edit-rc_form_columns', $admin, 'form_taxonomy_column_title' );
			$this->loader->add_filter( 'manage_rc_form_custom_column', $admin, 'form_taxonomy_column_content', 10, 3 );
			$this->loader->add_filter( 'the_excerpt_rss', $admin, 'add_image_to_rss' );
			$this->loader->add_filter( 'the_content_feed', $admin, 'add_image_to_rss' );
		}

		if ( isset( $algolia ) ) {
			$this->loader->add_filter( 'algolia_user_record', $algolia, 'avatar_url', 10, 2 );
			$this->loader->add_filter( 'algolia_post_images_sizes', $algolia, 'images_sizes' );
			$this->loader->add_filter( 'algolia_post_types_blacklist', $algolia, 'post_types_blacklist' );
			$this->loader->add_filter( 'algolia_taxonomies_blacklist', $algolia, 'taxonomies_blacklist' );
			$this->loader->add_filter( 'algolia_post_shared_attributes', $algolia, 'index_attributes', 10, 2 );
			$this->loader->add_filter( 'algolia_searchable_post_shared_attributes', $algolia, 'index_attributes', 10, 2 );
			$this->loader->add_filter( 'algolia_posts_index_settings', $algolia, 'index_settings' );
			$this->loader->add_filter( 'algolia_searchable_posts_index_settings', $algolia, 'index_settings' );
		}

		if ( isset( $comments ) ) {
			$this->loader->add_action( 'admin_init', $comments, 'update_options_page' );
			$this->loader->add_action( 'admin_init', $comments, 'disable_comments_post_types_support' );
			$this->loader->add_action( 'wp_before_admin_bar_render', $comments, 'remove_admin_bar_link' );
			$this->loader->add_filter( 'comments_array', $comments, 'disable_comments_hide_existing_comments', 10, 2 );
			$this->loader->add_action( 'admin_menu', $comments, 'disable_comments_admin_menu' );
			$this->loader->add_action( 'admin_init', $comments, 'disable_comments_admin_menu_redirect' );
			$this->loader->add_action( 'admin_init', $comments, 'disable_comments_dashboard' );
			$this->loader->add_action( 'init', $comments, 'disable_comments_admin_bar' );
			$this->loader->add_action( 'init', $comments, 'disable_comments_and_pings' );
			$this->loader->add_action( 'widgets_init', $comments, 'disable_comments_widget' );
			$this->loader->add_action( 'admin_head', $comments, 'hide_dashboard_bits' );
		}

		if ( isset( $taxonomy ) ) {
			$this->loader->add_action( 'init', $taxonomy, 'taxonomy_column' );
			$this->loader->add_action( 'init', $taxonomy, 'taxonomy_firing' );
			$this->loader->add_action( 'init', $taxonomy, 'taxonomy_form' );
			$this->loader->add_action( 'init', $taxonomy, 'taxonomy_location' );
			$this->loader->add_action( 'init', $taxonomy, 'taxonomy_row' );
			$this->loader->add_action( 'init', $taxonomy, 'taxonomy_technique' );
		}

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Core_Functionality_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
