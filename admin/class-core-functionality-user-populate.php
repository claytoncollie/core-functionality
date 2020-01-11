<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.claytoncollie.com
 * @since      1.14.0
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
class Core_Functionality_User_Populate {

	/**
	 * The User ID.
	 *
	 * @var boolean $user_id User ID.
	 * @since 1.14.0
	 * @access private
	 */
	private $user_id = false;

	/**
	 * Default options.
	 *
	 * @var array $options All options.
	 * @since 1.14.0
	 * @access private
	 */
	private $options = array(
		'gf_form_id'                     => 1, // the gravity form.
		'acf_field_id'                   => 'field_546d0ad42e7f0', // The ACF Gallery field id.
		'gf_images_field_id'             => 27, // The Gravity Forms gallery field id.
		'gf_author_field_id'             => 23, // The Gravity Forms author id.
		'gf_author_conditional_field_id' => 19, // The Gravity Forms conditional author field id ("yes" if existing author).
		'gf_author_avatar_field_id'      => 22,
		'acf_avatar_field_id'            => 'field_55b4095067ec4',
	);

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.14.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.14.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.14.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( string $plugin_name, string $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Set the User ID.
	 *
	 * @param string $user_id User ID.
	 * @param array  $config Configuration options.
	 * @param array  $entry Entry data.
	 * @param string $user_pass User password.
	 *
	 * @return void
	 *
	 * @since 1.14.0
	 */
	public function add_custom_user_meta( $user_id, $config, $entry, $user_pass ) {
		if ( isset( $entry[ $this->options['gf_author_conditional_field_id'] ] ) && $entry[ $this->options['gf_author_conditional_field_id'] ] != 'Yes' && isset( $entry[ $this->options['gf_author_avatar_field_id'] ] ) && ! empty( $entry[ $this->options['gf_author_avatar_field_id'] ] ) ) {
			$this->user_id = $user_id;
		}
	}

	/**
	 * Gravity Forms User Populate.
	 *
	 * Populates the field with a list of users.
	 *
	 * @param array $form Form data.
	 *
	 * @return array
	 *
	 * @since 1.14.0
	 */
	public function populate_user_email_list( $form ) {

		// Add filter to fields, populate the list.
		foreach ( $form['fields'] as &$field ) {

			// If the field is not a dropdown and not the specific class, move onto the next one.
			// This acts as a quick means to filter arguments until we find the one we want.
			if ( 'select' !== $field['type'] || $this->options['gf_author_field_id'] !== $field['id'] ) {
				continue;
			}

			$choices = array(
				array(
					'text'  => 'Select a User',
					'value' => ' ',
				),
			);

			$args = array(
				'orderby' => 'user_nicename',
				'fields'  => array( 'id', 'display_name', 'user_email' ),
			);

			$wp_user_query = new WP_User_Query( $args );

			$users = $wp_user_query->get_results();

			if ( ! empty( $users ) ) {
				foreach ( $users as $user ) {
					// Make sure the user has an email address, safeguard against users can be imported without email addresses.
					// Also, make sure the user is at least able to edit posts (i.e., not a subscriber). Look at: http://codex.wordpress.org/Roles_and_Capabilities for more ideas.
					if ( ! empty( $user->user_email ) && user_can( $user->id, 'edit_posts' ) ) {
						$choices[] = array(
							'text'  => $user->display_name,
							'value' => $user->id,
						);
					}
				}
			}
			$field['choices'] = $choices;
		}

		return $form;
	}

	/**
	 * Attach images to post gallery meta & author.
	 *
	 * @param array $entry Entry data.
	 * @param array $form Form data.
	 *
	 * @return void
	 *
	 * @since 1.14.0
	 */
	public function set_post_fields( $entry, $form ) {

		if ( isset( $entry['post_id'] ) ) {
			$post = get_post( $entry['post_id'] );
		} else {
			return;
		}

		if ( is_null( $post ) ) {
			return;
		}

		// Set Post Author, if existing author is chosen.
		if ( isset( $entry[ $this->options['gf_author_conditional_field_id'] ] ) && $entry[ $this->options['gf_author_conditional_field_id'] ] == 'Yes' && isset( $entry[ $this->options['gf_author_field_id'] ] ) && ! empty( $entry[ $this->options['gf_author_field_id'] ] ) ) {

			// Set post author to author field.
			// Verify that the id is a valid author.
			if ( get_user_by( 'id', $entry[ $this->options['gf_author_field_id'] ] ) ) {
				$post->post_author = $entry[ $this->options['gf_author_field_id'] ];
			}

			// If it's an existing author, make sure the avatar image is added to the media library.
		} elseif ( isset( $entry[ $this->options['gf_author_conditional_field_id'] ] ) && $entry[ $this->options['gf_author_conditional_field_id'] ] != 'Yes' && isset( $entry[ $this->options['gf_author_avatar_field_id'] ] ) && ! empty( $entry[ $this->options['gf_author_avatar_field_id'] ] ) ) {

			// Add new post author image to media library and set simple local avatar.
			$author_image = $this->get_image_id( $entry[ $this->options['gf_author_avatar_field_id'] ], null );
			if ( $author_image && $this->user_id ) {
				update_field( $this->options['acf_avatar_field_id'], $author_image, 'user_' . $this->user_id );
			}
		}

		// Clean up images upload and create array for gallery field.
		if ( isset( $entry[ $this->options['gf_images_field_id'] ] ) ) {
			$images = stripslashes( $entry[ $this->options['gf_images_field_id'] ] );
			$images = json_decode( $images, true );
			if ( ! empty( $images ) && is_array( $images ) ) {
				$gallery = array();
				foreach ( $images as $key => $value ) {
					$image_id = $this->get_image_id( $value, $post->ID );
					if ( $image_id ) {
						$gallery[] = $image_id;
					}
				}
			}
		}

		// Update gallery field with array.
		if ( ! empty( $gallery ) ) {
			update_field( $this->options['acf_field_id'], $gallery, $post->ID );
		}

		// Updating post.
		wp_update_post( $post );
	}

	/**
	 * Create the image and return the new media upload id.
	 *
	 * @param string $image_url Image URL.
	 * @param string $parent_post_id Post ID of parent object.
	 *
	 * @since 1.14.0
	 * @see http://codex.wordpress.org/Function_Reference/wp_insert_attachment#Example
	 */
	public function get_image_id( $image_url, $parent_post_id = null ) {

		if ( ! isset( $image_url ) ) {
			return false;
		}

		// Cache info on the wp uploads dir.
		$wp_upload_dir = wp_upload_dir();

		// Get the file path.
		$path = wp_parse_url( $image_url );

		// File base name.
		$file_base_name = basename( $image_url );

		// Full path.
		if ( defined( 'GFUP_SUB_DIRECTORY' ) && GFUP_SUB_DIRECTORY === true ) {
			$home_path = dirname( dirname( dirname( dirname( dirname( __FILE__ ) ) ) ) );
		} else {
			$home_path = dirname( dirname( dirname( dirname( __FILE__ ) ) ) );
		}
		$home_path          = untrailingslashit( $home_path );
		$uploaded_file_path = $home_path . $path;

		// Check the type of file. We'll use this as the 'post_mime_type'.
		$filetype = wp_check_filetype( $file_base_name, null );

		if ( ! empty( $filetype ) && is_array( $filetype ) ) {

			// Create attachment title.
			$post_title = preg_replace( '/\.[^.]+$/', '', $file_base_name );

			// Prepare an array of post data for the attachment.
			$attachment = array(
				'guid'           => $wp_upload_dir['url'] . '/' . basename( $uploaded_file_path ),
				'post_mime_type' => $filetype['type'],
				'post_title'     => esc_attr( $post_title ),
				'post_content'   => '',
				'post_status'    => 'inherit',
			);

			// Set the post parent id if there is one.
			if ( ! is_null( $parent_post_id ) ) {
				$attachment['post_parent'] = $parent_post_id;
			}

			// Insert the attachment.
			$attach_id = wp_insert_attachment( $attachment, $uploaded_file_path );

			if ( ! is_wp_error( $attach_id ) ) {
				// Generate wp attachment meta data.
				if ( file_exists( ABSPATH . 'wp-admin/includes/image.php' ) && file_exists( ABSPATH . 'wp-admin/includes/media.php' ) ) {
					require_once ABSPATH . 'wp-admin/includes/image.php';
					require_once ABSPATH . 'wp-admin/includes/media.php';

					$attach_data = wp_generate_attachment_metadata( $attach_id, $uploaded_file_path );
					wp_update_attachment_metadata( $attach_id, $attach_data );
				} // end if file exists check
			}

			return $attach_id;

		} else {
			return false;
		}
	}

}
