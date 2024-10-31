<?php
 //if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//ACTIVATE

//plugin activate function
if(!function_exists('nfpmgm_plugin_activate')){

	function nfpmgm_plugin_activate() {
				
		//get NutsForPress setting
		global $nfproot_plugins_settings;
		
		//define plugin installaton type
		$nfproot_plugins_settings['nfpmgm']['prefix'] = 'nfpmgm';
		$nfproot_plugins_settings['nfpmgm']['slug'] = 'nfpmgm-settings';
		$nfproot_plugins_settings['nfpmgm']['edition'] = 'repository';
		$nfproot_plugins_settings['nfpmgm']['name'] = 'Images and Media';
		
		//update NutsForPress setting
		update_option('_nfproot_plugins_settings', $nfproot_plugins_settings, false);
	
	}
		
}  else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpmgm_plugin_activate" already exists');
	
}