<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.claytoncollie.com
 * @since      1.7.0
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
class Core_Functionality_Checkin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.7.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.7.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The default user ID.
	 *
	 * @since    1.7.0
	 * @access   private
	 * @var      boolean    $user_id    The default user ID.
	 */
	private $user_id = false;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.7.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( string $plugin_name, string $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Populates the field with a list of users.
	 *
	 * @param array $form Form data.
	 *
	 * @return array
	 *
	 * @since 1.7.0
	 */
	public function populate_user_list( $form ) {

		// Add filter to fields, populate the list.
		foreach ( $form['fields'] as &$field ) {

			// If the field is not a dropdown and not the specific class, move onto the next one.
			// This acts as a quick means to filter arguments until we find the one we want.
			if ( 'select' !== $field['type'] || 2 !== $field['id'] ) {
				continue;
			}

			// The first, "select" option.
			$choices = array(
				array(
					'text'  => 'Select a User',
					'value' => ' ',
				),
			);

			$wp_user_query = new WP_User_Query(
				array(
					'orderby' => 'user_nicename',
					'fields'  => array( 'id', 'display_name', 'user_email' ),
				)
			);

			$users = $wp_user_query->get_results();

			if ( ! empty( $users ) ) {
				foreach ( $users as $user ) {
					// Make sure the user has an email address, safeguard against users can be imported without email addresses
					// Also, make sure the user is at least able to edit posts (i.e., not a subscriber). Look at: http://codex.wordpress.org/Roles_and_Capabilities for more ideas.
					if ( ! empty( $user->user_email ) && user_can( $user->id, 'edit_posts' ) ) {
						// Add users to select.
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
	 * Sets the new user's user id
	 *
	 * @param int    $user_id User ID.
	 * @param array  $feed Feed data.
	 * @param array  $entry Entry data.
	 * @param string $user_pass Password.
	 *
	 * @return void
	 *
	 * @since 1.7.0
	 */
	public function add_custom_user_meta( $user_id, $feed, $entry, $user_pass ) {
		if ( isset( $entry[17] ) && 'Yes' !== $entry[17] ) {
			$this->user_id = $user_id;
		}
	}

	/**
	 * Attach images to post gallery meta & author.
	 *
	 * @param array $entry Entry data.
	 * @param array $form Form data.
	 *
	 * @return void
	 *
	 * @since 1.7.0
	 */
	public function set_post_fields( $entry, $form ) {

		if ( isset( $entry['post_id'] ) ) {
			$post = get_post( $entry['post_id'] );
		} else {
			return;
		}

		// Bail if the post don't work.
		if ( is_null( $post ) ) {
			return;
		}

		// Set Post Author, if existing author is chosen.
		if ( isset( $entry[17] ) && 'Yes' === $entry[17] && isset( $entry[2] ) && ! empty( $entry[2] ) ) {

			// Set post author to author field and verify that the id is a valid author.
			if ( get_user_by( 'id', $entry[2] ) ) {
				$post->post_author = $entry[2];
			}
		}

		// Set Post Author, if existing author is chosen.
		if ( isset( $entry[14] ) && ! empty( $entry[14] ) ) {

			$term_id = wp_insert_term( $entry[14], 'rc_location' );

			if ( ! empty( $term_id ) ) {

				$term = get_term( $term_id['term_id'], 'rc_location', ARRAY_A );

				if ( ! empty( $term ) ) {
					wp_set_post_terms( $post->ID, $term['name'], 'rc_location', false );
				}
			}
		} elseif ( isset( $entry[20] ) && ! empty( $entry[20] ) ) {

			$term = get_term( $entry[20], 'rc_location', ARRAY_A );

			if ( is_array( $term ) ) {
				wp_set_post_terms( $post->ID, $term['name'], 'rc_location', false );
			}
		}

		wp_update_post( $post );

	}

}
