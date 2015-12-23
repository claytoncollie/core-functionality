<?php

/**
 * Modify user contact methods
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.claytoncollie.com
 * @since      1.0.0
 *
 * @package    Core_Functionality
 * @subpackage Core_Functionality/admin/partials
**/

function rc_modify_user_contact_methods( $user_contact ){
  /* Remove user contact methods */
  unset($user_contact['aim']);
  unset($user_contact['jabber']);
  unset($user_contact['yim']);
  unset($user_contact['gplus']);

  $user_contact['twitter'] = 'Twitter';
  $user_contact['facebook'] = 'Facebook';
  $user_contact['instagram'] = 'Instagram';
  $user_contact['pinterest'] = 'Pinterest';

  return $user_contact;
}
add_filter( 'user_contactmethods', 'rc_modify_user_contact_methods' );