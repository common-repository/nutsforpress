<?php
 //if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('nfpmgm_size_actions')){

	function nfpmgm_size_actions($nfpmgm_current_attachment_id) {
		
		//get options 
		global $nfproot_current_language_settings;

		//if resizing is enabled and nfproot_image_size_threshold is an admitted value
		if(

			!empty($nfproot_current_language_settings['nfpmgm']['nfproot_image_size']) && !empty($nfproot_current_language_settings['nfpmgm']['nfproot_image_size_threshold']) 
			
				&& $nfproot_current_language_settings['nfpmgm']['nfproot_image_size'] === '1'
				&& is_numeric($nfproot_current_language_settings['nfpmgm']['nfproot_image_size_threshold'])
				&& (int)$nfproot_current_language_settings['nfpmgm']['nfproot_image_size_threshold'] >= 1280
				&& (int)$nfproot_current_language_settings['nfpmgm']['nfproot_image_size_threshold'] <= 3840				
					
		) {
			
			$nfpmgm_current_attachment_mime_type = get_post_mime_type($nfpmgm_current_attachment_id);
			
			//disable big_image_size_threshold filter
			add_filter('big_image_size_threshold', '__return_false');
						
			//skip big_image_size_threshold filter, since attachment is a GIF image
			if(
			
				!empty($nfpmgm_current_attachment_mime_type)
				&& $nfpmgm_current_attachment_mime_type === 'image/gif'
				&& !empty($nfproot_current_language_settings['nfpmgm']['nfproot_image_size_skip_gif'])
				&& $nfproot_current_language_settings['nfpmgm']['nfproot_image_size_skip_gif'] === '1'

			){
				// should we write the post meta even if image is a GIF?
				if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: attachment is a GIF and GIF images are set to be excluded from big_image_size_threshold');}
				
			} else {
				
				$nfpmgm_image_target_size = $nfproot_current_language_settings['nfpmgm']['nfproot_image_size_threshold'];
				
				//add custom big_image_size_threshold filter
				add_filter('big_image_size_threshold', function() use ($nfpmgm_image_target_size) {return $nfpmgm_image_target_size;});
				
				if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: big_image_size_threshold filter is set to '.$nfpmgm_image_target_size);}
			
				//add _nfproot_image_size_value post meta only if attachment is an image
				if(
			
					!empty($nfpmgm_current_attachment_mime_type) 
					&& explode('/', $nfpmgm_current_attachment_mime_type)[0] === 'image'
				
				) {	
					//add a post meta to ease thumbnail rebuild 
					update_post_meta($nfpmgm_current_attachment_id, '_nfproot_image_size_value', $nfpmgm_image_target_size);
					
					if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: setting to post '.$nfpmgm_current_attachment_id.' the _nfproot_image_size_value post meta with value '.$nfpmgm_image_target_size);}
		
				} else {
					
					if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: attachment is not an image, skipping the add of _nfproot_image_size_value post meta');}
					
				}
				
			}
			
		} else {
			
			// should we write the post meta even if resize is not enable?
			if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: size treatment is not enabled, nothing will be done by this plugin');}
			
		}
		
	}
		
} else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpmgm_size_actions" already exists');

}