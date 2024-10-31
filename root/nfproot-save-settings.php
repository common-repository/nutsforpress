<?php
 //if this file is called directly, abort.
if(!defined('ABSPATH')) die('please, do not call this page directly');

if(!function_exists('nfproot_settings_to_save')) {

	function nfproot_settings_to_save($nfproot_posted_inputs) {	
	
		$nfproot_settings_to_save_values = array();
		
		//loop into posted values
		foreach($nfproot_posted_inputs as $nfproot_posted_input) {
						
			$nfproot_posted_input_name = sanitize_text_field($nfproot_posted_input['name']);
			$nfproot_posted_input_type = sanitize_text_field($nfproot_posted_input['type']);
			$nfproot_posted_input_value = $nfproot_posted_input['value'];
			$nfproot_posted_input_save = sanitize_text_field($nfproot_posted_input['save']);
						
			switch($nfproot_posted_input_type) {
				
				//treat checkbox
				case 'checkbox':
				
					if(
					
						$nfproot_posted_input_value !== '0' 
						&& $nfproot_posted_input_value !== '1'
					) {
						
						$nfproot_settings_to_save_values[$nfproot_posted_input_save][$nfproot_posted_input_name] = '0';						
						
					} else {
						
						$nfproot_settings_to_save_values[$nfproot_posted_input_save][$nfproot_posted_input_name] = $nfproot_posted_input_value;
						
					}
				
				break;
				
				//treat email
				case 'email':
				
					$nfproot_settings_to_save_values[$nfproot_posted_input_save][$nfproot_posted_input_name] = sanitize_email($nfproot_posted_input_value);

				break;	
				
				//treat textarea
				case 'textarea':
				
					$nfproot_settings_to_save_values[$nfproot_posted_input_save][$nfproot_posted_input_name] = base64_decode(htmlentities($nfproot_posted_input_value));

				break;	

				//treat text, dropdown, radio
				default:
				
					$nfproot_settings_to_save_values[$nfproot_posted_input_save][$nfproot_posted_input_name] = sanitize_text_field($nfproot_posted_input_value);
				
			}
			
		}

		return $nfproot_settings_to_save_values;		
		
	}

} 

if(!function_exists('nfproot_save_settings')) {

	function nfproot_save_settings() {	
	
		//end here if user can't manage options
		if(current_user_can('manage_options') === false) {
			
			return;
			
		}
		
		//check nonce (if fails, dies)
		check_ajax_referer('nfproot-save-settings-nonce', 'nfproot_save_settings_nonce');	

		//get post ajax value for global settings
		if(!empty($_POST['nfproot_posted_inputs_global'])) {
			
			$nfproot_posted_inputs_global = map_deep(wp_unslash($_POST['nfproot_posted_inputs_global']), 'sanitize_text_field');
			$nfproot_global_settings_to_save_values = nfproot_settings_to_save($nfproot_posted_inputs_global);
			
		} else {
			
			$nfproot_global_settings_to_save_values = array();
		}
		
		//get post ajax value for local settings
		if(!empty($_POST['nfproot_posted_inputs_local'])) {
			
			$nfproot_posted_inputs_local = map_deep(wp_unslash($_POST['nfproot_posted_inputs_local']), 'sanitize_text_field');
			$nfproot_local_settings_to_save_values = nfproot_settings_to_save($nfproot_posted_inputs_local);
			
		} else {
			
			$nfproot_local_settings_to_save_values = array();
		}

		//if at least one typology of settings has to be saved
		if(!empty($nfproot_global_settings_to_save_values) || !empty($nfproot_local_settings_to_save_values)) {
			
			global $nfproot_root_settings_name;
			global $nfproot_current_language_settings_name;
			global $nfproot_root_settings;
			
			if(empty($nfproot_root_settings)) {
				
				$nfproot_root_settings = array();
				
			}
			
			//save into base settings both the local and the global values (if WPML is not installed, I put all settings in the same place)
			if(empty($nfproot_global_settings_to_save_values)) {
				
				$nfproot_global_and_local_settings_to_save_values = $nfproot_local_settings_to_save_values;
				
			}
			
			else if(empty($nfproot_local_settings_to_save_values)) {
				
				$nfproot_global_and_local_settings_to_save_values = $nfproot_global_settings_to_save_values;
				
			} else {
				
				$nfproot_global_and_local_settings_to_save_values = array_merge_recursive($nfproot_global_settings_to_save_values, $nfproot_local_settings_to_save_values);
				
			}
											
			//add global settings to each language installed and local settings to the current language only (if WPML is installed, I save settings discretionally)
			$nfproot_get_wpml_active_languages = apply_filters('wpml_active_languages', false);
			$nfproot_get_wpml_default_language = apply_filters( 'wpml_default_language', false);

			//if WPML has active and default languages
			if(!empty($nfproot_get_wpml_active_languages) && !empty($nfproot_get_wpml_default_language)) {
			  
				//loop into languages
				foreach($nfproot_get_wpml_active_languages as $nfproot_get_wpml_current_language) {
					
					$nfproot_wpml_current_language_code = $nfproot_get_wpml_current_language['language_code'];
					$nfproot_wpml_current_language_settings_name = $nfproot_root_settings_name.'_'.$nfproot_wpml_current_language_code;
	
					//if loop language is the active one, save local settings and global settings
					if($nfproot_wpml_current_language_settings_name === $nfproot_current_language_settings_name) {

						//get loop language settings
						global $nfproot_current_language_settings;
						
						if(empty($nfproot_current_language_settings)) {
							
							$nfproot_current_language_settings_to_save_values = $nfproot_global_and_local_settings_to_save_values;
							
						} else {

							//merge loop language settings with the new local ones
							$nfproot_current_language_settings_to_save_values = array_replace_recursive(
							
								$nfproot_current_language_settings, 
								$nfproot_global_and_local_settings_to_save_values
								
							);							
							
						}

						update_option($nfproot_wpml_current_language_settings_name, $nfproot_current_language_settings_to_save_values, false);
						
						//if loop language is also the default one, update base settings, so that if WPML is disabled, base settings will meet the default language settings
						if($nfproot_wpml_current_language_code === $nfproot_get_wpml_default_language) {
							
							if(empty($nfproot_root_settings)) {
								
								$nfproot_root_settings_to_save_values = $nfproot_global_and_local_settings_to_save_values;
							
							} else {

								$nfproot_root_settings_to_save_values = array_replace_recursive(
								
									$nfproot_root_settings, 
									$nfproot_global_and_local_settings_to_save_values
									
								);								
								
							}
							


							//update base settings
							update_option($nfproot_root_settings_name, $nfproot_root_settings_to_save_values, false);
							
						}
												
					//save settings in languages different from the active one
					} else {
						
						//get other language settings
						$nfproot_other_language_settings_saved_values = get_option($nfproot_wpml_current_language_settings_name);

						if(empty($nfproot_other_language_settings_saved_values)) {
							
							$nfproot_other_language_settings_to_save_values = $nfproot_global_settings_to_save_values;
							
						} else {
						
							//merge other language settings with the new global ones
							$nfproot_other_language_settings_to_save_values = array_replace_recursive(
							
								$nfproot_other_language_settings_saved_values, 
								$nfproot_global_settings_to_save_values
								
							);
						
						}
						
						update_option($nfproot_wpml_current_language_settings_name, $nfproot_other_language_settings_to_save_values, false);

						//if loop language is not the active one but it is the default one, we need to update global settings
						if($nfproot_wpml_current_language_code === $nfproot_get_wpml_default_language) {
							
							if(empty($nfproot_root_settings)) {
								
								$nfproot_root_settings_to_save_values = $nfproot_global_settings_to_save_values;
							
							} else {
							
								$nfproot_root_settings_to_save_values = array_replace_recursive(
								
									$nfproot_root_settings, 
									$nfproot_global_settings_to_save_values
									
								);
								
							}
							
							//update base settings
							update_option($nfproot_root_settings_name, $nfproot_root_settings_to_save_values, false);
							
						}
						
					}
					
				}	

			//WPML is not active, save normally
			} else {
				
				if(empty($nfproot_root_settings)) {
					
					$nfproot_root_settings_to_save_values = $nfproot_global_and_local_settings_to_save_values;
				
				} else {
				
					$nfproot_root_settings_to_save_values = array_replace_recursive(
					
						$nfproot_root_settings, 
						$nfproot_global_and_local_settings_to_save_values
						
					);
					
				}
				
				update_option($nfproot_root_settings_name, $nfproot_root_settings_to_save_values, false);
				
			}
							
			echo esc_attr(json_encode(true));
					
			wp_die();			
			
		}
		
	}

} 

//do not add errors here, since it is expected that this function is invoked more than once