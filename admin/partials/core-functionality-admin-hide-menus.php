<?php

/**
 * Editor/Contributor/Author/Subscriber Menus
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://www.claytoncollie.com
 * @since      1.0.0
 *
 * @package    Core_Functionality
 * @subpackage Core_Functionality/admin/partials
**/

function rc_remove_menus () {
  	
	$user = wp_get_current_user();

	if( !current_user_can('activate_plugins') ) {

		global $menu;
		
	    $restricted = array(__('Media'), __('Links'), __('Appearance'),__('Pages'), __('Tools'), __('Posts'), __('Settings'), __('Comments'), __('Plugins'));
   	 		end ($menu);
    	
		while (prev($menu)){
       
	   		$value = explode(' ',$menu[key($menu)][0]);
        
			if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
    	}
		remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');
		remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
	}
}
add_action('admin_menu', 'rc_remove_menus');