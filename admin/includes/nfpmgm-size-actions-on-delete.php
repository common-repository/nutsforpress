<?php
 //if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('nfpmgm_size_actions_on_delete')){

	function nfpmgm_size_actions_on_delete($nfpmgm_current_attachment_id) {

		//get options 
		global $nfproot_current_language_settings;
		
		$nfproot_image_size_value = get_option('_nfproot_image_size_value');
		
		if($nfproot_image_size_value) {
			
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
							
			}
			
		} else {
			
			// image was not resized
			if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: size treatment is not applied on this image, nothing will be done by this plugin');}
			
		}
		
	}
		
} else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpmgm_size_actions_on_delete" already exists');

}