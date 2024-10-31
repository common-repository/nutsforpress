<?php
 //if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//STYLES AND SCRIPTS

//admin styles
if(!function_exists('nfpmgm_styles_and_scripts')){
	
	function nfpmgm_styles_and_scripts() {
				
		//thumbnails rebuild script and ajax		
		wp_enqueue_script('nfpmgm-thumbnails-rebuild', NFPMGM_BASE_URL.'admin/includes/js/nfpmgm-thumbnails-rebuild.js', array('jquery'), '', true );
		wp_localize_script('nfpmgm-thumbnails-rebuild', 'nfpmgm_thumbnails_rebuild_object', array(
		
			'nfpmgm_thumbnails_rebuild_url' => admin_url('admin-ajax.php'),
			'nfpmgm_thumbnails_rebuild_nonce' => wp_create_nonce('nfpmgm-thumbnails-rebuild-nonce')
			
		));
		
	}
			
} else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpmgm_styles_and_scripts" already exists');
	
}