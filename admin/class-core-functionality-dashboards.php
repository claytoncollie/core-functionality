<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.claytoncollie.com
 * @since      1.11.0
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
class Core_Functionality_Dashboards {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.11.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.11.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.11.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( string $plugin_name, string $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Dashboard widgets
	 *
	 * @since    1.11.0
	 */
	public function remove_dashboard_widgets() {

		remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
		remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );

		// Remove Yoast SEO metabox.
		remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );

		// Remove WP Engine metabox.
		remove_meta_box( 'wpe_dify_news_feed', 'dashboard', 'normal' );

		// Remove welcome panel on dashboard.
		remove_action( 'welcome_panel', 'wp_welcome_panel' );

		// Gravity Forms.
		remove_meta_box( 'rg_forms_dashboard', 'dashboard', 'normal' );

	}

	/**
	 * Custom dashboard
	 *
	 * @since    1.11.0
	 */
	public function custom_dashboard_widgets() {

		global $wp_meta_boxes;

		wp_add_dashboard_widget(
			'rc_introduction',
			esc_html__( 'Introduction', 'core-functionality' ),
			array( $this, 'introduction' )
		);

		wp_add_dashboard_widget(
			'rc_object_id',
			esc_html__( 'Latest ID', 'core-functionality' ),
			array( $this, 'object_id' )
		);

		wp_add_dashboard_widget(
			'rc_object_status',
			esc_html__( 'Status', 'core-functionality' ),
			array( $this, 'object_status' )
		);

		wp_add_dashboard_widget(
			'rc_total_cost',
			esc_html__( 'Cost', 'core-functionality' ),
			array( $this, 'total_cost' )
		);

	}

	/**
	 * Set the dashboard widget order for all users.
	 *
	 * @return void
	 *
	 * @aince 1.11.0
	 */
	public function set_dashboard_meta_order() {

		$user_id = get_current_user_id();

		if ( ! empty( $user_id ) ) {

			$meta_value = array(
				'normal'  => 'rc_introduction',
				'side'    => 'rc_object_id',
				'column3' => 'rc_object_status,rc_total_cost',
			);

			update_user_meta( $user_id, 'meta-box-order_dashboard', $meta_value );

		}

	}

	/**
	 * Introduction Widget
	 *
	 * @return void
	 *
	 * @since    1.11.0
	 */
	public function introduction() {

		$pages = array(
			'checkin' => __( 'For when a piece is first entered into the collection and needs the bare minimum amount of information along with a quick photo.', 'core-functionality' ),
			'pending' => __( 'For when a piece is checked into the collection and needs to move out of the kitchen and into the storage area. Most pieces on this page only have a photo and an artist name.', 'core-functionality' ),
			'manage'  => __( 'For when entering a complete object into the collection. Use for after a pieces has all of their photos taken and all infomation compiled. Use this page if you cannot find it on the PENDING page listed above.', 'core-functionality' ),
		);

		if ( ! empty( $pages ) ) {

			foreach ( $pages as $path => $description ) {

				$page = get_page_by_path( $path, OBJECT, 'page' );

				if ( ! empty( $page ) ) {
					printf(
						'<section style="display:block;margin-bottom:2em";><p>%s</p><a href="%s" target="_blank" class="button button-primary button-large">%s</a></section>',
						esc_html( $description ),
						esc_url( get_permalink( $page ) ),
						esc_html( get_the_title( $page ) )
					);
				}
			}
		}

	}

	/**
	 * Display the latest 10 pieces so we know where to start our next part.
	 *
	 * @return void
	 *
	 * @since 1.11.0
	 */
	public function object_id() {

		$terms = get_terms(
			array(
				'taxonomy'   => 'rc_form',
				'hide_empty' => false,
			)
		);

		if ( ! empty( $terms ) ) {

			foreach ( $terms as $term ) {

				$posts = array();

				$query = new WP_Query(
					array(
						'post_type'   => 'post',
						'post_status' => 'any',
						'nopaging'    => true,
						'tax_query'   => array(
							array(
								'taxonomy' => 'rc_form',
								'field'    => 'slug',
								'terms'    => esc_html( $term->slug ),
							),
						),
					)
				);

				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
						$query->the_post();

						$object_id = get_field( 'object_id', get_the_ID() );

						if ( ! empty( $object_id ) ) {
							$posts[] .= $object_id;
						}
					}
					wp_reset_postdata();

					if ( ! empty( $posts ) ) {

						// Sort descending.
						rsort( $posts );

						// Grab fist 10 elements.
						$posts = array_slice( $posts, 0, 10, true );

						printf( '%s: <strong>%s</strong><hr>', esc_html( $term->name ), esc_html( implode( ', ', $posts ) ) );

					}
				}
			}
		}
	}

	/**
	 * Display all posts broken out by post status
	 *
	 * @return void
	 *
	 * @since 1.17.0
	 */
	public function object_status() {

		$statuses = array(
			array(
				'label'    => __( 'Published', 'core-functionality' ),
				'callback' => wp_count_posts()->publish,
			),
			array(
				'label'    => __( 'Draft', 'core-functionality' ),
				'callback' => wp_count_posts()->draft,
			),
			array(
				'label'    => __( 'Pending', 'core-functionality' ),
				'callback' => wp_count_posts()->pending,
			),
			array(
				'label'    => __( 'Archived', 'core-functionality' ),
				'callback' => wp_count_posts()->archive,
			),
		);

		if ( ! empty( $statuses ) ) {

			printf(
				'<table class="widefat striped"><thead><tr><td><strong>%s</strong></td><td><strong>%s</strong></td></tr></thead>',
				esc_html__( 'Status', 'core-functionality' ),
				esc_html__( 'Count', 'core-functionality' )
			);

			foreach ( $statuses as $status ) {
				printf(
					'<tr><td>%s</td><td>%s</td></tr>',
					esc_html( $status['label'] ),
					esc_html( $status['callback'] )
				);
			}

			echo '</table>';

		}

	}

	/**
	 * Display the total cost of each taxonomy term.
	 *
	 * @return void
	 *
	 * @since 1.17.0
	 */
	public function total_cost() {

		$terms = get_terms(
			array(
				'taxonomy'   => 'rc_form',
				'hide_empty' => false,
			)
		);

		if ( ! empty( $terms ) ) {

			printf(
				'<table class="widefat striped"><thead><tr><td><strong>%s</strong></td><td><strong>%s</strong></td></tr></thead>',
				esc_html__( 'Form', 'core-functionality' ),
				esc_html__( 'Cost', 'core-functionality' )
			);

			printf(
				'<tr><td>%s</td><td>$%s</td></tr>',
				esc_html__( 'Collection', 'core-functionality' ),
				esc_html( $this->get_total_purchase_price() )
			);

			foreach ( $terms as $term ) {
				printf(
					'<tr><td>%s</td><td>$%s</td></tr>',
					esc_html( $term->name ),
					esc_html( $this->get_taxonomy_purchase_price( absint( $term->term_id ) ) )
				);
			}

			echo '</table>';

		}

	}

	/**
	 * Get the total purchase price for a single taxonomy term.
	 *
	 * Returns as a float in money format for the USD.
	 *
	 * @param integer $term_id Term ID.
	 * @param string  $taxonomy Taxonomy slug.
	 *
	 * @return float
	 *
	 * @since 1.17.0
	 */
	public function get_taxonomy_purchase_price( int $term_id, string $taxonomy = 'rc_form' ) : float {
		$output = '0';
		$total  = array();

		$query = new \WP_Query(
			array(
				'post_type' => 'post',
				'nopaging'  => true,
				'tax_query' => array(
					array(
						'taxonomy' => esc_html( $taxonomy ),
						'field'    => 'term_id',
						'terms'    => absint( $term_id ),
					),
				),
			)
		);

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();

				$price = get_field( 'rc_object_purchace_price' );

				if ( ! empty( $price ) ) {
					$total[] .= $price;
				}
			}
			wp_reset_postdata();

			$output = array_sum( $total );
		}

		return money_format( '%i', floatval( $output ) );
	}

	/**
	 * Get the total collection purchase price from all taxonomies.
	 *
	 * @return float
	 *
	 * @since 1.17.0
	 */
	public function get_total_purchase_price() : float {
		$output = array();
		$terms  = get_terms( 'rc_form' );

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$output[] .= $this->get_taxonomy_purchase_price( absint( $term->term_id ) );
			}

			$output = array_sum( $output );
		}

		return money_format( '%i', floatval( $output ) );
	}

}
