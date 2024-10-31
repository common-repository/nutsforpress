<?php
 //if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//WPML integration: copy original _nfproot_image_size_threshold_value and _nfproot_jpeg_compression_value postmeta to duplicates
if(!function_exists('nfpmgm_wpml_attachment_duplicate')){

	function nfpmgm_wpml_attachment_duplicate($nfpmgm_original_image_id, $nfpmgm_duplicated_image_id) {
				
		//get original post meta
		$nfpmgm_original_image_size_threshold_value_meta = get_post_meta($nfpmgm_original_image_id, '_nfproot_image_size_threshold_value', true);
		$nfpmgm_original_jpeg_compression_value_meta = get_post_meta($nfpmgm_original_image_id, '_nfproot_jpeg_compression_value', true);
		
		//duplicate _nfproot_image_size_threshold_value post meta
		if(!empty($nfpmgm_original_image_size_threshold_value_meta)) {
			
			update_post_meta($nfpmgm_duplicated_image_id, '_nfproot_image_size_threshold_value', $nfpmgm_original_image_size_threshold_value_meta);
			
			if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: _nfproot_image_size_threshold_value post meta had been replicated for post id '.$nfpmgm_duplicated_image_id);}

		}
		
		//duplicate _nfproot_jpeg_compression_value post meta
		if(!empty($nfpmgm_original_jpeg_compression_value_meta)) {
			
			update_post_meta($nfpmgm_duplicated_image_id, '_nfproot_jpeg_compression_value', $nfpmgm_original_jpeg_compression_value_meta);
			
			if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: _nfproot_jpeg_compression_value post meta had been replicated for post id '.$nfpmgm_duplicated_image_id);}

		}	

	}

} else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpmgm_wpml_attachment_duplicate" already exists');
	
}