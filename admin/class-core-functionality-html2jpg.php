<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.claytoncollie.com
 * @since      1.12.0
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
class Core_Functionality_Html2Jpg {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.12.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.12.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * API Endpoint for conversion service.
	 *
	 * @since    1.12.0
	 * @access   private
	 * @var      string    $endpoint
	 */
	private $endpoint = 'https://hcti.io/v1/image';

	/**
	 * User ID for conversion service.
	 *
	 * @since    1.12.0
	 * @access   private
	 * @var      string    $user_id
	 */
	private $user_id = '00868e7f-e562-4d1d-a6ed-313e1823b76a';

	/**
	 * API key for conversion service.
	 *
	 * @since    1.12.0
	 * @access   private
	 * @var      string    $api_key
	 */
	private $api_key = 'c710d99b-5764-4623-ba6a-827281f00808';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.12.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( string $plugin_name, string $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Define the allowed Layouts
	 *
	 * @return array
	 *
	 * @since 1.12.0
	 */
	public static function allowed_layouts() : array {
		return array(
			'vertical',
			'horizontal',
		);
	}

	/**
	 * Add endpoints for pretty permalinks
	 *
	 * @since  1.12.0
	 */
	public function add_rewrite_endpoint() {

		$types = $this->allowed_layouts();

		if ( ! empty( $types ) && is_array( $types ) ) {
			foreach ( $types as $layout ) {
				add_rewrite_endpoint( $layout, EP_ALL );
			}
		}

	}

	/**
	 * Check the $wp_query to make sure we are on the proper endpoint
	 *
	 * @param mixed  $query WP_Query.
	 * @param string $layout Layout type.
	 * @return bool
	 * @since 1.12.0
	 */
	public function maybe_run( $query, string $layout ) : bool {

		return isset( $query->query_vars[ esc_attr( $layout ) ] );

	}

	/**
	 * Get the file name based on the Layout being requested
	 *
	 * @param string $layout Layout type.
	 * @return string
	 * @since 1.12.0
	 */
	public function get_file_name( string $layout ) : string {

		$output = '';

		$object_id = get_field( 'object_id', get_the_ID() );

		$prefix = $this->get_taxonomy_term_prefix( get_the_ID() );

		if ( ! empty( $object_id ) && ! empty( $prefix ) ) {

			$output .= sprintf(
				'%s.jpg',
				esc_html( uniqid( $prefix . $object_id . '-' . $layout . '-' ) )
			);

		}

		return $output;

	}

	/**
	 * Returns the prefix for a taxonomy term.
	 *
	 * @param string $post_id Post ID.
	 * @return string
	 * @since 1.12.0
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

	/**
	 * Get the HTML layout depending on the endpoint
	 *
	 * @param string $layout Layout type.
	 * @return string
	 * @ince 1.12.0
	 */
	public function layout( string $layout ) : string {

		$output = '';

		$object_id = get_field( 'object_id', get_the_ID() );

		$prefix = $this->get_taxonomy_term_prefix( get_the_ID() );

		if ( ! empty( $object_id ) && ! empty( $prefix ) ) {

			if ( 'vertical' === $layout ) {

				$output .= sprintf(
					'<section style="text-align:center;">%s<h1 style="font-size:40px;margin:0;">%s%s</h1></section>',
					get_the_post_thumbnail(
						get_the_ID(),
						'large',
						array(
							'style' => 'width:150px;height:auto;margin-bottom:20px',
						),
					),
					esc_html( $prefix ),
					esc_html( $object_id )
				);

			} else {

				$output .= sprintf(
					'<section style="display:flex;align-items:center;"><div style="display:inline-block;">%s</div><h1 style="display:inline-block;font-size:40px;margin:0 0 0 20px;">%s%s</h1></section>',
					get_the_post_thumbnail(
						get_the_ID(),
						'large',
						array(
							'style' => 'width:150px;height:auto;margin-left:20px',
						),
					),
					esc_html( $prefix ),
					esc_html( $object_id )
				);

			}
		}

		return $output;

	}

	/**
	 * Contact the remote server to build the image.
	 *
	 * Get a JSON repsonse back and grab the URL value.
	 *
	 * @param string $html HTML to convert.
	 * @return string
	 * @since 1.12.0
	 */
	public function get_remote_response( string $html ) : string {

		$ch = curl_init(); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_init

		curl_setopt( $ch, CURLOPT_URL, $this->endpoint ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt

		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt

		curl_setopt( // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt
			$ch,
			CURLOPT_POSTFIELDS,
			http_build_query(
				array(
					'html' => $html,
				)
			)
		);

		curl_setopt( $ch, CURLOPT_POST, 1 ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt

		curl_setopt( $ch, CURLOPT_USERPWD, $this->user_id . ':' . $this->api_key ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt

		$headers   = array();
		$headers[] = 'Content-Type: application/x-www-form-urlencoded';
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_setopt

		$result = curl_exec( $ch );  // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_exec

		if ( curl_errno( $ch ) ) { // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_errno
			echo wp_kses_post( 'Error:' . curl_error( $ch ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_error
		}
		curl_close( $ch ); // phpcs:ignore WordPress.WP.AlternativeFunctions.curl_curl_close

		$response = json_decode( $result, true );

		return $response['url'];

	}

	/**
	 * Build the document then save to the browser if we are on the proper endpoint.
	 *
	 * @param mixed $query WP_Query.
	 * @since 1.12.0
	 */
	public function save_image( $query ) {

		$types = $this->allowed_layouts();

		if ( ! empty( $types ) && is_array( $types ) ) {

			foreach ( $types as $layout ) {

				if ( $this->maybe_run( $query, $layout ) ) {

					$url = $this->get_remote_response( $this->layout( $layout ) );

					if ( ! empty( $url ) ) {

						header( 'Content-Type: application/octet-stream' );
						header( 'Content-Disposition: attachment; filename=' . $this->get_file_name( $layout ) );

						readfile( $url ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_readfile

					}
				}
			}
		}
	}

}
