<?php
 //if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('nfpmgm_quality_actions')){

	function nfpmgm_quality_actions($nfpmgm_current_attachment_id) {
		
		//get options 
		global $nfproot_current_language_settings;

		//if compression is enabled and nfproot_jpeg_compression_quality is an admitted value
		if(

			!empty($nfproot_current_language_settings['nfpmgm']['nfproot_jpeg_compression']) && !empty($nfproot_current_language_settings['nfpmgm']['nfproot_jpeg_compression_quality']) 
			
				&& $nfproot_current_language_settings['nfpmgm']['nfproot_jpeg_compression'] === '1'
				&& is_numeric($nfproot_current_language_settings['nfpmgm']['nfproot_jpeg_compression_quality'])
				&& (int)$nfproot_current_language_settings['nfpmgm']['nfproot_jpeg_compression_quality'] >= 60
				&& (int)$nfproot_current_language_settings['nfpmgm']['nfproot_jpeg_compression_quality'] <= 100			

		) {
						
			$nfpmgm_current_attachment_mime_type = get_post_mime_type($nfpmgm_current_attachment_id);
			
			if(
			
				!empty($nfpmgm_current_attachment_mime_type)
				&& $nfpmgm_current_attachment_mime_type === 'image/jpeg'

			){

				//disable jpeg_quality filter
				add_filter('jpeg_quality', '__return_false');	

				$nfpmgm_jpeg_target_compression = $nfproot_current_language_settings['nfpmgm']['nfproot_jpeg_compression_quality'];				
				
				//add custom jpeg_quality filter
				add_filter('jpeg_quality', function() use ($nfpmgm_jpeg_target_compression) {return $nfpmgm_jpeg_target_compression;});
				
				if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: jpeg_quality filter is set to '.$nfpmgm_jpeg_target_compression);}
				
				//add a post meta to ease thumbnail rebuild 
				update_post_meta($nfpmgm_current_attachment_id, '_nfproot_jpeg_compression_value', $nfpmgm_jpeg_target_compression);
				
				if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: setting to post id '.$nfpmgm_current_attachment_id.' the _nfproot_jpeg_compression_value post meta with value '.$nfpmgm_jpeg_target_compression);}

				
			} else {
				
				if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: attachment is an '.$nfpmgm_current_attachment_mime_type.', so jpeg_quality filter is not set');}
				
			}			
			
		} else {
			
			// should we write the post meta even if compression is not enable?
			if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: quality treatment is not enabled, nothing will be done by this plugin');}
			
		}
		
	}
		
} else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpmgm_quality_actions" already exists');

}