<?php
 //if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//this is called (conditionally) by nfpmgm_admin_actions function that runs on plugins_loaded

//get image size by wp_get_image_editor
if(!function_exists('nfpmgm_get_image_size')){
	
	function nfpmgm_get_image_size($nfpmgm_image_path) {
		
		$nfpmgm_image_editor = wp_get_image_editor($nfpmgm_image_path);
		
		if(is_wp_error($nfpmgm_image_editor)) {
					
			if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: error getting the size of current attachment: wp_get_image_editor function in nfpmgm-thumbnails-rebuid.php throw this error: '.$nfpmgm_image_editor->get_error_message());}
			return;	
			
		}
		
		$nfpmgm_image_size = $nfpmgm_image_editor->get_size();
		$nfpmgm_image_size_width = $nfpmgm_image_size['width'];
		$nfpmgm_image_size_height = $nfpmgm_image_size['height'];
		
		if($nfpmgm_image_size_width >= $nfpmgm_image_size_height) {
			
			$nfpmgm_image_size = $nfpmgm_image_size_width;
			
		} else {
			
			$nfpmgm_image_size = $nfpmgm_image_size_height;
			
		}	

		return $nfpmgm_image_size;
		
	}
	
} else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpmgm_get_image_size" already exists');
	
}

//get plugin options, store them in global variables, so that get_options query is made only onc
if(!function_exists('nfpmgm_thumbnails_rebuild')){

	function nfpmgm_thumbnails_rebuild() {

		//end here if user can't manage options
		if(current_user_can('manage_options') === false) {
			
			return;
			
		}
		
		//check nonce (if fails, dies)
		check_ajax_referer('nfpmgm-thumbnails-rebuild-nonce', 'nfpmgm_thumbnails_rebuild_nonce');	

		if(
			
			isset($_POST['nfpmgm_current_image_id']) 
			&& isset($_POST['nfpmgm_current_image_path'])
			&& isset($_POST['nfpmgm_image_target_quality'])
			&& isset($_POST['nfpmgm_image_target_size'])
			&& isset($_POST['nfpmgm_current_image_type'])
			
		) {
					
			$nfpmgm_current_attachment_id = absint($_POST['nfpmgm_current_image_id']);
			$nfpmgm_current_attachment_path = esc_url_raw($_POST['nfpmgm_current_image_path']);
			$nfpmgm_current_attachment_quality_target = absint($_POST['nfpmgm_image_target_quality']);
			$nfpmgm_current_attachment_size_target = absint($_POST['nfpmgm_image_target_size']);
			$nfpmgm_current_attachment_type = sanitize_text_field($_POST['nfpmgm_current_image_type']);			
			
			//just in case is passed something different than an imaage
			if(
			
				!wp_attachment_is_image($nfpmgm_current_attachment_id) 
				&& $nfpmgm_current_attachment_type !== 'pdf'
				
			) {
				
				//prevent PDF from beeing involved in this job
				if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: attachment id '.$nfpmgm_current_attachment_id.' ignoresd, since is not an image');}
				return;
				
			}
			
			//if the "-scaled" path is passed, skip process
			if(strpos($nfpmgm_current_attachment_path, '-scaled') !== false) {

				//check if the original file exists and, if it exists, switch to its path
				/*if(file_exists(str_replace('-scaled', '', $nfpmgm_current_attachment_path))) {
					
					$nfpmgm_current_attachment_path = str_replace('-scaled', '', $nfpmgm_current_attachment_path);
					
				} else {
					
					if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: involved path '.$nfpmgm_current_attachment_path.' contains the "-scaled" suffix and original file does not exist');}
					return;
				}*/
				
				if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: involved original path '.$nfpmgm_current_attachment_path.' contains the "-scaled" suffix: this should not happen');}
				return;
				
			}
			
			include_once(ABSPATH.'wp-admin/includes/image.php');
			
			//disable jpeg_quality filter
			add_filter('jpeg_quality', '__return_false');				
			
			//add custom jpeg_quality filter
			add_filter('jpeg_quality', function() use ($nfpmgm_current_attachment_quality_target) {return $nfpmgm_current_attachment_quality_target;});
			
			//disable jpeg_quality filter
			add_filter('big_image_size_threshold', '__return_false');				
			
			//add custom jpeg_quality filter
			add_filter('big_image_size_threshold', function() use ($nfpmgm_current_attachment_size_target) {return $nfpmgm_current_attachment_size_target;});	

			//get old metadata
			$nfpmgm_current_meta_data = wp_get_attachment_metadata($nfpmgm_current_attachment_id);
			
			//generate intermediate images and get new metadata
			$nfpmgm_new_meta_data = wp_generate_attachment_metadata($nfpmgm_current_attachment_id, $nfpmgm_current_attachment_path);
		
			//treat the case the "-scaled" file version is not needed anymore: generate a new "-scaled" file version to avoid risk of empty images into content
			if(!empty($nfpmgm_current_meta_data['original_image']) && empty($nfpmgm_new_meta_data['original_image'])) {

				$nfpmgm_image_editor = wp_get_image_editor($nfpmgm_current_attachment_path);

				if(is_wp_error( $nfpmgm_image_editor )) {
					if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: error getting the size of current attachment: wp_get_image_editor function in nfpmgm-thumbnails-rebuid.php throw this error: '.$nfpmgm_image_editor->get_error_message());}
					return;	
				}

				//delete old scaled image
				$nfpmgm_current_attachment_scaled_path = get_attached_file($nfpmgm_current_attachment_id);
				wp_delete_file($nfpmgm_current_attachment_scaled_path);
				
				//generate a new scaled image
				$nfpmgm_scaled_meta_data = $nfpmgm_image_editor->save($nfpmgm_image_editor->generate_filename('scaled'));
				
				$nfpmgm_new_meta_data['original_image'] = wp_basename($nfpmgm_new_meta_data['file']);
				$nfpmgm_new_meta_data['file'] = $nfpmgm_scaled_meta_data['file'];
				
				if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: a new scaled image file is needed, a new one has been built');}
				
				/*
				$nfpmgm_current_attachment_scaled_path = get_attached_file($nfpmgm_current_attachment_id);
				$nfpmgm_current_attachment_new_path = $nfpmgm_new_meta_data['file'];
				
				wp_delete_file($nfpmgm_current_attachment_scaled_path);
				update_attached_file($nfpmgm_current_attachment_id, $nfpmgm_current_attachment_new_path);
				
				if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: old scaled image file with path '.$nfpmgm_current_attachment_scaled_path.' deleted and attached filed changed to '.$nfpmgm_current_attachment_new_path);}
				*/
				
			}			
			
			if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: generating attachments metadata for id '.$nfpmgm_current_attachment_id);}
						
			if(!empty($nfpmgm_new_meta_data)) {

				//deal with attachment duplication created by WPML
				$nfpmgm_get_wpml_active_languages = apply_filters('wpml_active_languages', false);

				//if WPML has active languages
				if(!empty($nfpmgm_get_wpml_active_languages)) {
				  
					//loop into languages
					foreach($nfpmgm_get_wpml_active_languages as $nfpmgm_wpml_language) {
						
						$nfpmgm_wpml_language_code = $nfpmgm_wpml_language['language_code'];
						
						$nfpmgm_image_id_to_work_with_translation_id = apply_filters('wpml_object_id', $nfpmgm_current_attachment_id, 'attachment', false, $nfpmgm_wpml_language_code);
						
						if(!empty($nfpmgm_image_id_to_work_with_translation_id)) {
							
							wp_update_attachment_metadata($nfpmgm_image_id_to_work_with_translation_id, $nfpmgm_new_meta_data);
							
							//update compression value
							update_post_meta($nfpmgm_image_id_to_work_with_translation_id, '_nfproot_jpeg_compression_value', $nfpmgm_current_attachment_quality_target);
							
							//update size value
							update_post_meta($nfpmgm_image_id_to_work_with_translation_id, '_nfproot_image_size_value', $nfpmgm_current_attachment_size_target);	
							
						}
						
					}
									
					if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: updating metadata for id '.$nfpmgm_current_attachment_id. ' and its translations');}
					
				} else {

					wp_update_attachment_metadata($nfpmgm_current_attachment_id, $nfpmgm_new_meta_data);
					if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: updating metadata for id '.$nfpmgm_current_attachment_id);}
					
					//update compression value
					update_post_meta($nfpmgm_current_attachment_id, '_nfproot_jpeg_compression_value', $nfpmgm_current_attachment_quality_target);
					
					//update size value
					update_post_meta($nfpmgm_current_attachment_id, '_nfproot_image_size_value', $nfpmgm_current_attachment_size_target);	
									
				}	


			} else {
				
				if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: not updating metadata for id '.$nfpmgm_current_attachment_id. ' since wp_generate_attachment_metadata returns an empty array');}
				
			}				
			
		} else {		

			$nfpmgm_images_to_deal_with = new WP_Query(

				//post arguments
				array(
				
					'post_type' => 'attachment',
					'posts_per_page' => -1,
					'orderby' => 'ID',
					'order' => 'DESC',						
					//'post_mime_type' => 'image', //changed to 'image/jpeg' because png are no more supported, see https://core.trac.wordpress.org/ticket/48736
					'post_mime_type' => array('image', 'application/pdf'),
					'suppress_filters' => false, //otherwise it loads WPML duplicates media
					'offset' => 0,
					'post_status' => 'inherit',
					'ignore_sticky_posts' => true,
					'no_found_rows' => true,
					'fields' => 'ids'
					
				)
				
			);

			//get image post ids array
			$nfpmgm_images_ids_to_deal_with = $nfpmgm_images_to_deal_with->posts;

			wp_reset_postdata();
			
			$nfpmgm_rebuild_all_thumbnails = false;
			
			if(!empty($_POST['nfpmgm_rebuild_all_thumbnails'])) {
				
				$nfpmgm_rebuild_all_thumbnails = absint($_POST['nfpmgm_rebuild_all_thumbnails']);
				
			}


			$nfpmgm_rebuild_pdf_thumbnails = false;

			if(!empty($_POST['nfpmgm_rebuild_pdf_thumbnails'])) {
				
				$nfpmgm_rebuild_pdf_thumbnails = absint($_POST['nfpmgm_rebuild_pdf_thumbnails']);
				
			}				

			$nfpmgm_images_ids_to_work_with = array();

			//get options 
			global $nfproot_current_language_settings;

			$nfpmgm_image_target_size = 2560;
			
			if(

				$nfproot_current_language_settings !== false 
				&& !empty($nfproot_current_language_settings['nfpmgm']['nfproot_image_size'])
				&& !empty($nfproot_current_language_settings['nfpmgm']['nfproot_image_size_threshold'])
				
			) {

				//get image size to convert to
				$nfpmgm_image_target_size = absint($nfproot_current_language_settings['nfpmgm']['nfproot_image_size_threshold']);	

			}	
			
			$nfpmgm_jpeg_target_quality = 82;

			if(

				$nfproot_current_language_settings !== false 
				&& !empty($nfproot_current_language_settings['nfpmgm']['nfproot_jpeg_compression'])
				&& !empty($nfproot_current_language_settings['nfpmgm']['nfproot_jpeg_compression_quality'])
				
				){

				//get quality to compress to
				$nfpmgm_jpeg_target_quality = absint($nfproot_current_language_settings['nfpmgm']['nfproot_jpeg_compression_quality']);	

			}	
						
			//loop into post id array
			foreach($nfpmgm_images_ids_to_deal_with as $nfpmgm_current_image_id) {
				
				if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: dealing with id: '.$nfpmgm_current_image_id);}
				
				$nfpmgm_current_image_mime_type = get_post_mime_type($nfpmgm_current_image_id);
				
				if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: mime type is: '.$nfpmgm_current_image_mime_type);}
				
				//this is useless since only jpg will be treated, however leave it here for further developments
				if($nfpmgm_current_image_mime_type === 'image/svg+xml'){
					
					if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: skipping image id '.$nfpmgm_current_image_id.' since it is a svg image');}
					continue;
					
				}
				
				if(
				
					$nfpmgm_current_image_mime_type === 'image/gif' 
					&& !empty($nfproot_current_language_settings['nfpmgm']['nfproot_image_size_skip_gif']) 
					&& $nfproot_current_language_settings['nfpmgm']['nfproot_image_size_skip_gif'] === '1'){
					
					if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: skipping image id '.$nfpmgm_current_image_id.' since skip GIF is enabled');}
					continue;
					
				}
				
				$nfpmgm_current_original_image_path = wp_get_original_image_path($nfpmgm_current_image_id);
				$nfpmgm_current_scaled_image_path = get_attached_file($nfpmgm_current_image_id);
				
				if($nfpmgm_current_image_mime_type === 'application/pdf') {
					
					if($nfpmgm_rebuild_pdf_thumbnails === 1) {
					
						if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: dealing with PDF thumbnail regeneration');}
						
						if(!empty($nfpmgm_current_scaled_image_path)) {
							
							$nfpmgm_current_pdf_path = $nfpmgm_current_scaled_image_path;
							$nfpmgm_current_original_image_path = str_replace('.pdf','-pdf.jpg',$nfpmgm_current_scaled_image_path);
							$nfpmgm_current_scaled_image_path = $nfpmgm_current_original_image_path;
												
						} 

						if(
						
							!empty($nfpmgm_current_scaled_image_path)
							&& !empty($nfpmgm_current_original_image_path)
							&& !file_exists($nfpmgm_current_original_image_path)
						
						){
							
							//include into images to treat
							$nfpmgm_images_ids_to_work_with['id'][] = $nfpmgm_current_image_id;
							$nfpmgm_images_ids_to_work_with['path'][] = $nfpmgm_current_pdf_path;
							$nfpmgm_images_ids_to_work_with['quality'][] = $nfpmgm_jpeg_target_quality;
							$nfpmgm_images_ids_to_work_with['size'][] = $nfpmgm_image_target_size;
							$nfpmgm_images_ids_to_work_with['type'][] = 'pdf';
							
							if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: including pdf '.$nfpmgm_current_image_id.' into work_with array, because no thumbnails are found');}
							continue;
							
						} else {
							
							if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: skipping pdf '.$nfpmgm_current_image_id.' because thumbnails alreay exist');}
							continue;
							
						}

					} else {
						
						if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: skipping pdf '.$nfpmgm_current_image_id.' because PDF rebuild it is disabled');}
						continue;
						
					}						

				}
				
				if(	
				
					(
					
						$nfpmgm_current_original_image_path === false 
						|| !file_exists($nfpmgm_current_original_image_path)
						
					) && (
					
						$nfpmgm_current_scaled_image_path === false 
						|| !file_exists($nfpmgm_current_scaled_image_path)					
					
					)
							
				) {			

					if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: error getting the physical file or the full path of the attachment id '.$nfpmgm_current_image_id);}					
					
					continue;
				
				} 	
				
				//treat resolution				
				if($nfpmgm_current_image_mime_type === 'image/jpeg') {
					
					if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: dealing with image compression');}
					
					//get current compression
					$nfpmgm_current_image_quality = absint(get_post_meta($nfpmgm_current_image_id, '_nfproot_jpeg_compression_value', true));
							
					//check if current image compression exists and its value is different than the target
					if(
					
						$nfpmgm_current_image_quality !== $nfpmgm_jpeg_target_quality
						|| $nfpmgm_current_image_quality === false				

					) {

						//include into images to treat
						$nfpmgm_images_ids_to_work_with['id'][] = $nfpmgm_current_image_id;
						$nfpmgm_images_ids_to_work_with['path'][] = $nfpmgm_current_original_image_path;
						$nfpmgm_images_ids_to_work_with['quality'][] = $nfpmgm_jpeg_target_quality;
						$nfpmgm_images_ids_to_work_with['size'][] = $nfpmgm_image_target_size;
						$nfpmgm_images_ids_to_work_with['type'][] = 'jpeg';
						
						if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: including image '.$nfpmgm_current_image_id.' into work_with array, because current compression ('.$nfpmgm_current_image_quality.') is different then the target compression ('.$nfpmgm_jpeg_target_quality.')');}
						
						//stop here the loop
						continue;
					
					} else {
						
						//deal with include all
						if($nfpmgm_rebuild_all_thumbnails === 1) {
													
							//include into images to treat
							$nfpmgm_images_ids_to_work_with['id'][] = $nfpmgm_current_image_id;
							$nfpmgm_images_ids_to_work_with['path'][] = $nfpmgm_current_original_image_path;
							$nfpmgm_images_ids_to_work_with['quality'][] = $nfpmgm_jpeg_target_quality;
							$nfpmgm_images_ids_to_work_with['size'][] = $nfpmgm_image_target_size;
							$nfpmgm_images_ids_to_work_with['type'][] = 'jpeg';
							
							if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: including image '.$nfpmgm_current_image_id.' into work_with array, because all images is set');}
							
							//stop here the loop
							continue;
							
						} else {
							
							if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: skipping image '.$nfpmgm_current_image_id.' into work_with array, because compression is not changed');}
							
						}
						
					}						

				}

				//treat size			
				if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: dealing with image size');}
				
				//get current size
				$nfpmgm_current_image_size = absint(get_post_meta($nfpmgm_current_image_id, '_nfproot_image_size_value', true));
				
				//if _nfproot_image_size_value meta does not exist, calculate image size
				if($nfpmgm_current_image_size === false) {
												
					$nfpmgm_current_image_size = absint(nfpmgm_get_image_size($nfpmgm_current_scaled_image_path));
					
				}
				
				//check if current image size is different than the target 
				if($nfpmgm_current_image_size !== $nfpmgm_image_target_size) {
					
					//before including image, check if we have an original image grater the the target size
					$nfpmgm_original_image_size = absint(nfpmgm_get_image_size($nfpmgm_current_original_image_path));
					
					if($nfpmgm_original_image_size >= $nfpmgm_image_target_size) {
			
						//include into images to treat
						$nfpmgm_images_ids_to_work_with['id'][] = $nfpmgm_current_image_id;
						$nfpmgm_images_ids_to_work_with['path'][] = $nfpmgm_current_original_image_path;
						$nfpmgm_images_ids_to_work_with['quality'][] = $nfpmgm_jpeg_target_quality;
						$nfpmgm_images_ids_to_work_with['size'][] = $nfpmgm_image_target_size;
						$nfpmgm_images_ids_to_work_with['type'][] = 'jpeg';
					
						if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: including image '.$nfpmgm_current_image_id.' into work_with array ('.$nfpmgm_original_image_size.') because its size ('.$nfpmgm_current_image_size.') is different then the target size ('.$nfpmgm_image_target_size.')');}
						
						//stop here the loop
						continue;
						
					} else {
						
						//deal with include all
						if($nfpmgm_rebuild_all_thumbnails === 1) {
							
							//include into images to treat
							$nfpmgm_images_ids_to_work_with['id'][] = $nfpmgm_current_image_id;
							$nfpmgm_images_ids_to_work_with['path'][] = $nfpmgm_current_original_image_path;
							$nfpmgm_images_ids_to_work_with['quality'][] = $nfpmgm_jpeg_target_quality;
							$nfpmgm_images_ids_to_work_with['size'][] = $nfpmgm_image_target_size;
							$nfpmgm_images_ids_to_work_with['type'][] = 'jpeg';
							
							if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: including image '.$nfpmgm_current_image_id.' into work_with array, because all images is set');}
							
							//stop here the loop
							continue;
							
						} else {
						
							if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: skipping image '.$nfpmgm_current_image_id.' into work_with array, because original image is smaller than the target size ');}
						
						}
						
					}
				
				} else {
					
					//deal with include all
					if($nfpmgm_rebuild_all_thumbnails === 1) {
						
						//include into images to treat
						$nfpmgm_images_ids_to_work_with['id'][] = $nfpmgm_current_image_id;
						$nfpmgm_images_ids_to_work_with['path'][] = $nfpmgm_current_original_image_path;
						$nfpmgm_images_ids_to_work_with['quality'][] = $nfpmgm_jpeg_target_quality;
						$nfpmgm_images_ids_to_work_with['size'][] = $nfpmgm_image_target_size;
						$nfpmgm_images_ids_to_work_with['type'][] = 'jpeg';
						
						if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: including image '.$nfpmgm_current_image_id.' into work_with array, because all images is set');}
						
						//stop here the loop
						continue;
						
					} else {
						
						if(NFPMGM_DEBUG === true) {error_log('NUTSFORPRESS: skipping image '.$nfpmgm_current_image_id.' into work_with array, because size is not changed');}
						
					}						
					
				}				


			}
			
			echo json_encode($nfpmgm_images_ids_to_work_with);
			
			wp_die();
		
		}

	}


} else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpmgm_thumbnails_rebuild" already exists');
	
}