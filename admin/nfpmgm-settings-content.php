<?php
//if this file is called directly, die.
if(!defined('ABSPATH')) die('please, do not call this page directly');
	
//with this function we will define the NutsForPress menu page content
if(!function_exists('nfpmgm_settings_content')) {
	
	function nfpmgm_settings_content() {

		//create steps for 
		$nfpmgm_jpeg_compression_intput_values = array();
		
		$nfpmgm_jpeg_compression_value = 60;
		$nfpmgm_jpeg_compression_step = 1;
		
		while($nfpmgm_jpeg_compression_value <= 100) {

			$nfpmgm_jpeg_compression_selected = '';
			$nfpmgm_jpeg_compression_text = (string)$nfpmgm_jpeg_compression_value;
			
			if($nfpmgm_jpeg_compression_value === 82) {
					
				$nfpmgm_jpeg_compression_selected = 'selected';
				$nfpmgm_jpeg_compression_text .= ' ('.__('WP default','nutsforpress').')';
					
			}

			$nfpmgm_jpeg_compression_intput_values[$nfpmgm_jpeg_compression_step]['option-value'] = $nfpmgm_jpeg_compression_value;
			$nfpmgm_jpeg_compression_intput_values[$nfpmgm_jpeg_compression_step]['option-text'] = $nfpmgm_jpeg_compression_text;
			$nfpmgm_jpeg_compression_intput_values[$nfpmgm_jpeg_compression_step]['option-selected'] = $nfpmgm_jpeg_compression_selected;
					
			$nfpmgm_jpeg_compression_step++;
			$nfpmgm_jpeg_compression_value++;
			
		}	
	
		$nfpmgm_settings_content = array(
		
			array(
			
				'container-title'	=> __('Resize images on upload','nutsforpress'),
				
				'container-id'		=> 'nfpmgm_image_size_container',
				'container-class' 	=> 'nfpmgm-image-size-container',
				'input-name'		=> 'nfproot_image_size',
				'add-to-settings'	=> 'global',
				'data-save'			=> 'nfpmgm',
				'input-id'			=> 'nfpmgm_image_size',
				'input-class'		=> 'nfpmgm-image-size',
				'input-description'	=> __('If switched on, images will be resized to the size defined here, preserving the original full size image','nutsforpress'),
				'arrow-before'		=> true,
				'after-input'		=> '',
				'input-type' 		=> 'switch',
				'input-value'		=> '1',
				
				'childs'			=> array(

					array(
					
						'container-title'	=> __('Image size','nutsforpress'),
						
						'container-id'		=> 'nfpmgm_image_size_threshold_container',
						'container-class' 	=> 'nfpmgm-image-size-threshold-container',					
						'input-name' 		=> 'nfproot_image_size_threshold',
						'add-to-settings'	=> 'global',
						'data-save'			=> 'nfpmgm',
						'input-id' 			=> 'nfpmgm_image_size_threshold',
						'input-class'		=> 'nfpmgm-image-size-threshold',
						'input-description' => __('Images bigger than the size set will be resized on upload and on thumbnails rebuild, preserving the original full size image','nutsforpress'),
						'arrow-before'		=> false,
						'after-input'		=> '',
						'input-type' 		=> 'dropdown',
						'input-value'		=> array(

							array(
						
								'option-value' 		=> 1280,
								'option-text' 		=> '1280px',
								'option-selected' 	=> ''
								
							),
							
							array(
						
								'option-value' 		=> 1440,
								'option-text' 		=> '1440px',
								'option-selected' 	=> ''
								
							),
							
							array(
						
								'option-value' 		=> 1600,
								'option-text' 		=> '1600px',
								'option-selected' 	=> ''
								
							),

							array(
						
								'option-value' 		=> 1920,
								'option-text' 		=> '1920px',
								'option-selected' 	=> ''
								
							),
							
							array(
						
								'option-value' 		=> 2048,
								'option-text' 		=> '2048px',
								'option-selected' 	=> ''
								
							),
														
							array(
						
								'option-value' 		=> 2560,
								'option-text' 		=> '2560px ('.__('WP default','nutsforpress').')',
								'option-selected' 	=> 'selected'
								
							),

							array(
						
								'option-value' 		=> 3840,
								'option-text' 		=> '3840px',
								'option-selected' 	=> ''
								
							),
							
						),
						
					),
					
					array(

						'container-title'	=> __('Skip GIF','nutsforpress'),
						
						'container-id'		=> 'nfpmgm_image_size_skip_gif_container',
						'container-class' 	=> 'nfpmgm-image-size-skip-gif-container',					
						'input-name' 		=> 'nfproot_image_size_skip_gif',
						'add-to-settings'	=> 'global',
						'data-save'			=> 'nfpmgm',
						'input-id' 			=> 'nfpmgm_image_size_skip_gif',
						'input-class'		=> 'nfpmgm-image-size-skip-gif',
						'input-description' => __('If switched on, GIF images will be skipped from resizing, in order to avoid risk of spoil their native animation','nutsforpress'),
						'arrow-before'		=> false,
						'after-input'		=> '',
						'input-type' 		=> 'checkbox',
						'input-value'		=> '1'

					),						
				
				),
				
			),
			
			array(

				'container-title'	=> __('Compress JPEG on upload','nutsforpress'),
				
				'container-id'		=> 'nfpmgm_jpeg_compression_container',
				'container-class' 	=> 'nfpmgm-jpeg-compression-container',
				'input-name'		=> 'nfproot_jpeg_compression',
				'add-to-settings'	=> 'global',
				'data-save'			=> 'nfpmgm',
				'input-id'			=> 'nfpmgm_jpeg_compression',
				'input-class'		=> 'nfpmgm-jpeg-compression',
				'input-description'	=> __('If switched on, JPEG images will be compressed to the quality defined here, preserving the original full quality image','nutsforpress'),
				'arrow-before'		=> true,
				'after-input'		=> '',
				'input-type' 		=> 'switch',
				'input-value'		=> '1',
			
				'childs'			=> array(

					array(
					
						'container-title'	=> __('JPEG quality','nutsforpress'),
						
						'container-id'		=> 'nfpmgm_jpeg_compression_quality_container',
						'container-class' 	=> 'nfpmgm-jpeg-compression-quality-container',					
						'input-name' 		=> 'nfproot_jpeg_compression_quality',
						'add-to-settings'	=> 'global',
						'data-save'			=> 'nfpmgm',
						'input-id' 			=> 'nfpmgm_jpeg_compression_quality',
						'input-class'		=> 'nfpmgm-jpeg-compression-quality',
						'input-description' => __('This quality level will be used to compress JPEG images on upload and on thumbnails rebuild','nutsforpress'),
						'arrow-before'		=> false,
						'after-input'		=> '',
						'input-type' 		=> 'dropdown',
						'input-value'		=> $nfpmgm_jpeg_compression_intput_values,
						
					),
				
				),
				
			),
			
			array(

				'container-title'	=> __('Bulk rebuild thumbnails','nutsforpress'),
				
				'container-id'		=> 'nfpmgm_rebuild_thumbnails_container',
				'container-class' 	=> 'nfpmgm-rebuild-thumbnails-container',
				'input-name'		=> 'nfproot_rebuild_thumbnails',
				'add-to-settings'	=> false,
				'data-save'			=> 'nfpmgm',
				'input-id'			=> 'nfpmgm_rebuild_thumbnails',
				'input-class'		=> 'nfpmgm-rebuild-thumbnails',
				'input-description'	=> '',
				'arrow-before'		=> true,
				'after-input'		=> array(
				
					array(
					
						'type' 		=> 'paragraph',
						'id' 		=> 'nfpmgm_rebuild_thumbnails_description',
						'class' 	=> 'nfproot-after-input nfpmgm-rebuild-thumbnails-description',
						'hidden' 	=> false,
						'content' 	=> __('Click on the arrow to display the bulk rebuild thumbnails functions','nutsforpress'),
						'value'		=> ''
					
					),
				
				),
				'input-type' 		=> 'arrow',
				'input-value'		=> '1',

				'childs'			=> array(

					array(
					
						'container-id'		=> 'nfpmgm_rebuild_thumbnails_button_container',
						'container-class' 	=> 'nfpmgm-rebuild-thumbnails-button-container',					
						'input-name' 		=> 'nfproot_rebuild_thumbnails_button',
						'add-to-settings'	=> false,
						'data-save'			=> 'nfpmgm',
						'input-id' 			=> 'nfpmgm_rebuild_thumbnails_button',
						'input-class'		=> 'nfpmgm-rebuild-thumbnails-button',
						'input-description' => '',
						'arrow-before'		=> false,
						'after-input'		=> array(
						
							array(
							
								'type' 		=> 'paragraph',
								'id' 		=> 'nfpmgm_preparing_thumbnails_rebuild',
								'class' 	=> 'nfproot-after-input nfproot-after-input-bold nfpmgm-preparing-thumbnails-rebuild',
								'hidden' 	=> true,
								'content' 	=> __('Calculating media to treat','nutsforpress'),
								'value'		=> ''
							
							),
						
							array(
							
								'type' 		=> 'paragraph',
								'id' 		=> 'nfpmgm_executing_thumbnails_rebuild',
								'class' 	=> 'nfproot-after-input nfproot-after-input-bold nfpmgm-executing-thumbnails-rebuild',
								'hidden' 	=> true,
								'content' 	=> __('Now treating media','nutsforpress').' <span class="nfpmgm-executing-current-thumbnail"></span> '.__('of','nutsforpress').' <span class="nfpmgm-executing-total-thumbnail"></span>',
								'value'		=> ''
							
							),
							
							array(
							
								'type' 		=> 'paragraph',
								'id' 		=> 'nfpmgm_ending_thumbnails_rebuild',
								'class' 	=> 'nfproot-after-input nfproot-after-input-bold nfpmgm-ending-thumbnails-rebuild',
								'hidden' 	=> true,
								'content' 	=> __('Job Completed','nutsforpress'),
								'value'		=> ''
							
							),
						
						),
						
						'input-type' 		=> 'button',
						'input-value'		=> __('Bulk rebuild thumbnails','nutsforpress'),					

					),				
					
					array(
					
						'container-title'	=> __('Rebuild all the images thumbnails','nutsforpress'),
						
						'container-id'		=> 'nfpmgm_rebuild_all_thumbnails_container',
						'container-class' 	=> 'nfpmgm-rebuild-all-thumbnails-container',					
						'input-name' 		=> 'nfproot_rebuild_all_thumbnails',
						'add-to-settings'	=> false,
						'data-save'			=> 'nfpmgm',
						'input-id' 			=> 'nfpmgm_rebuild_all_thumbnails',
						'input-class'		=> 'nfpmgm-rebuild-all-thumbnails',
						'input-description' => __('If switched on, all the thumbnails will be rebuilt, not only the ones with different size or compression','nutsforpress'),
						'arrow-before'		=> false,
						'after-input'		=> '',
						'input-type' 		=> 'checkbox',
						'input-value'		=> '1'					

					),	
					
					array(

						'container-title'	=> __('Add missing PDF preview thumbnails','nutsforpress'),
						
						'container-id'		=> 'nfpmgm_rebuild_pdf_thumbnails_container',
						'container-class' 	=> 'nfpmgm-rebuild-pdf-thumbnails-container',					
						'input-name' 		=> 'nfproot_rebuild_pdf_thumbnails',
						'add-to-settings'	=> false,
						'data-save'			=> 'nfpmgm',
						'input-id' 			=> 'nfpmgm_rebuild_pdf_thumbnails',
						'input-class'		=> 'nfpmgm-rebuild-pdf-thumbnails',
						'input-description' => __('If switched on, thumbnails will be added to PDF documents that have lost them','nutsforpress'),
						'arrow-before'		=> false,
						'after-input'		=> '',
						'input-type' 		=> 'checkbox',
						'input-value'		=> '1'		

					),
					
				),
				
			),
				
		);
						
		return $nfpmgm_settings_content;
		
	}
	
} else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpmgm_settings_content" already exists');
	
}