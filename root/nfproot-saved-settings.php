<?php
//if this file is called directly, die.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('nfproot_saved_settings')) {

	function nfproot_saved_settings() {

		//set root settings as global, so that we can use them in every part of the plugin
		global $nfproot_plugins_settings;
		global $nfproot_plugins_settings_option_name;

		//get root settings		
		$nfproot_plugins_settings_option_name = '_nfproot_plugins_settings';
		$nfproot_plugins_settings = get_option($nfproot_plugins_settings_option_name);		

		//set global (no language) settings as global, so that we can use them in every part of the plugin
		global $nfproot_root_settings;
		global $nfproot_root_settings_name;
		
		//get global settings
		$nfproot_root_settings_name = '_nfproot_settings';
		$nfproot_root_settings = get_option($nfproot_root_settings_name);
		
		//set current language (WPML) settings as global, so that we can use them in every part of the plugin
		global $nfproot_current_language_settings;
		global $nfproot_current_language_settings_name;		

		//get settings by language for a perfect compliance with WPML
		$nfproot_current_site_language = apply_filters( 'wpml_current_language', NULL );
		
		if(!empty($nfproot_current_site_language)) {
			
			$nfproot_current_language_settings_name = '_nfproot_settings_'.$nfproot_current_site_language;
			
		} else {
			
			$nfproot_current_language_settings_name = '_nfproot_settings';
			
		}

		$nfproot_current_language_settings = get_option($nfproot_current_language_settings_name);
		
		if(empty($nfproot_current_language_settings)){
			
			$nfproot_current_language_settings_name = '_nfproot_settings';
			
			$nfproot_current_language_settings = get_option($nfproot_current_language_settings_name);
			
		}
		
	}

}

//do not add errors here, since it is expected that this function is invoked more than once