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
		$this->version     = '1.13.2';

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

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-core-functionality-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-core-functionality-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-core-functionality-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-core-functionality-algolia.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-core-functionality-comments.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-core-functionality-columns.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-core-functionality-taxonomy.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-core-functionality-checkin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-core-functionality-post-status.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-core-functionality-dashboards.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-core-functionality-html2jpg.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-core-functionality-user-populate.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-core-functionality-user-profile.php';

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

		$admin        = new Core_Functionality_Admin( $this->get_plugin_name(), $this->get_version() );
		$algolia      = new Core_Functionality_Algolia( $this->get_plugin_name(), $this->get_version() );
		$comments     = new Core_Functionality_Comments( $this->get_plugin_name(), $this->get_version() );
		$columns      = new Core_Functionality_Columns( $this->get_plugin_name(), $this->get_version() );
		$taxonomy     = new Core_Functionality_Taxonomy( $this->get_plugin_name(), $this->get_version() );
		$checkin      = new Core_Functionality_Checkin( $this->get_plugin_name(), $this->get_version() );
		$status       = new Core_Functionality_Post_Status( $this->get_plugin_name(), $this->get_version() );
		$dashboards   = new Core_Functionality_Dashboards( $this->get_plugin_name(), $this->get_version() );
		$html2jpg     = new Core_Functionality_Html2Jpg( $this->get_plugin_name(), $this->get_version() );
		$user_pop     = new Core_Functionality_User_Populate( $this->get_plugin_name(), $this->get_version() );
		$user_profile = new Core_Functionality_User_Profile( $this->get_plugin_name(), $this->get_version() );

		if ( isset( $admin ) ) {
			$this->loader->add_filter( 'auto_update_plugin', $admin, 'plugins_to_auto_update', 10, 2 );
			$this->loader->add_filter( 'use_block_editor_for_post_type', $admin, 'gutenberg_support', 10, 2 );
			$this->loader->add_filter( 'acf/settings/save_json', $admin, 'acf_local_json_save_location' );
			$this->loader->add_filter( 'acf/settings/load_json', $admin, 'acf_local_json_load_location' );
			$this->loader->add_action( 'init', $admin, 'clean_header' );
			$this->loader->add_filter( 'xmlrpc_methods', $admin, 'remove_xmlrpc_pingback_ping' );
			$this->loader->add_action( 'admin_menu', $admin, 'remove_admin_menus' );
			$this->loader->add_action( 'load-edit.php', $admin, 'no_category_dropdown' );
			$this->loader->add_action( 'restrict_manage_posts', $admin, 'add_taxonomy_filters_form' );
			$this->loader->add_filter( 'the_excerpt_rss', $admin, 'add_image_to_rss' );
			$this->loader->add_filter( 'the_content_feed', $admin, 'add_image_to_rss' );
			$this->loader->add_filter( 'acf/save_post', $admin, 'field_as_post_name', 20 );
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
			$this->loader->add_filter( 'register_post_type_args', $algolia, 'exclude_from_search', 10, 2 );
			$this->loader->add_action( 'wp_enqueue_scripts', $algolia, 'register_scripts', 12 );
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

		if ( isset( $columns ) ) {
			$this->loader->add_action( 'manage_posts_columns', $columns, 'post_column_titles' );
			$this->loader->add_action( 'manage_posts_custom_column', $columns, 'post_column_content', 10, 2 );
			$this->loader->add_filter( 'manage_edit-post_sortable_columns', $columns, 'post_id_column_sortable' );
			$this->loader->add_filter( 'manage_users_columns', $columns, 'user_column_titles' );
			$this->loader->add_action( 'manage_users_custom_column', $columns, 'user_column_content', 10, 3 );
			$this->loader->add_filter( 'manage_edit-rc_form_columns', $columns, 'form_taxonomy_column_title' );
			$this->loader->add_filter( 'manage_rc_form_custom_column', $columns, 'form_taxonomy_column_content', 10, 3 );
		}

		if ( isset( $taxonomy ) ) {
			$this->loader->add_action( 'admin_menu', $taxonomy, 'remove_sub_menus' );
			$this->loader->add_action( 'init', $taxonomy, 'unregister_taxonomy' );
			$this->loader->add_action( 'init', $taxonomy, 'taxonomy_column' );
			$this->loader->add_action( 'init', $taxonomy, 'taxonomy_firing' );
			$this->loader->add_action( 'init', $taxonomy, 'taxonomy_form' );
			$this->loader->add_action( 'init', $taxonomy, 'taxonomy_location', 0 );
			$this->loader->add_action( 'init', $taxonomy, 'taxonomy_row' );
			$this->loader->add_action( 'init', $taxonomy, 'taxonomy_technique' );
			$this->loader->add_action( 'init', $taxonomy, 'taxonomy_result' );
		}

		if ( isset( $checkin ) ) {
			$this->loader->add_filter( 'gform_pre_render_6', $checkin, 'populate_user_list' );
			$this->loader->add_action( 'gform_user_registered', $checkin, 'add_custom_user_meta', 10, 4 );
			$this->loader->add_filter( 'gform_after_submission_6', $checkin, 'set_post_fields', 10, 2 );
		}

		if ( isset( $status ) ) {
			$this->loader->add_action( 'init', $status, 'register_post_status' );
			$this->loader->add_action( 'admin_footer-post.php', $status, 'append_to_post_status_dropdown' );
			$this->loader->add_filter( 'display_post_states', $status, 'update_post_status' );
		}

		if ( isset( $dashboards ) ) {
			$this->loader->add_action( 'admin_init', $dashboards, 'remove_dashboard_widgets' );
			$this->loader->add_action( 'admin_init', $dashboards, 'set_dashboard_meta_order' );
			$this->loader->add_action( 'wp_dashboard_setup', $dashboards, 'custom_dashboard_widgets' );
		}

		if ( isset( $html2jpg ) ) {
			$this->loader->add_action( 'init', $html2jpg, 'add_rewrite_endpoint' );
			$this->loader->add_action( 'wp', $html2jpg, 'save_image' );
		}

		if ( isset( $user_pop ) ) {
			// Gravity form custom dropdown and routing.
			$this->loader->add_filter( 'gform_pre_render_1', $user_pop, 'populate_user_email_list' );
			// Set user id for use after submission.
			$this->loader->add_action( 'gform_user_registered', $user_pop, 'add_custom_user_meta', 10, 4 );
			// Set post author and/or gallery images.
			$this->loader->add_filter( 'gform_after_submission_1', $user_pop, 'set_post_fields', 10, 2 );
		}

		if ( isset( $user_profile ) ) {
			$this->loader->add_action( 'user_contactmethods', $user_profile, 'modify_user_contact_methods' );
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
