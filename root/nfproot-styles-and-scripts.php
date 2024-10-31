<?php
 //if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//STYLES AND SCRIPTS

//admin styles
if(!function_exists('nfproot_styles_and_scripts')){
	
	function nfproot_styles_and_scripts() {
		
		///default styles and scripts
		wp_enqueue_style('nfproot-style', plugins_url().'/'.plugin_basename( __DIR__ ).'/css/nfproot-style.css');
		wp_enqueue_script('nfproot-script', plugins_url().'/'.plugin_basename( __DIR__ ).'/js/nfproot-script.js', array('jquery'), '', true );
		
		//save options script and ajax
		wp_enqueue_script('nfproot-save-settings', plugins_url().'/'.plugin_basename( __DIR__ ).'/js/nfproot-save-settings.js', array('jquery'), '', true );		
		wp_localize_script('nfproot-save-settings', 'nfproot_save_settings_object', array( 
		
			'nfproot_save_settings_url' 	=> admin_url('admin-ajax.php'),
			'nfproot_save_settings_nonce' 	=> wp_create_nonce('nfproot-save-settings-nonce')
			
		));
		
	}
			
} 

//do not add errors here, since it is expected that this function is invoked more than once