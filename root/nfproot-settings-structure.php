<?php
//if this file is called directly, die.
if(!defined('ABSPATH')) die('please, do not call this page directly');


if(!function_exists('nfproot_add_to_settings')) {

	function nfproot_add_to_settings($nfproot_add_to_settings) {
		
		if(!empty($nfproot_add_to_settings['add-to-settings'])) {
			
			if($nfproot_add_to_settings['add-to-settings'] === 'global') {
			
				$nfproot_add_to_settings_class = 'nfproot-input-global';
			
			}
			
			else if($nfproot_add_to_settings['add-to-settings'] === 'local') {
			
				$nfproot_add_to_settings_class = 'nfproot-input-local';
			
			} else {
				
				$nfproot_add_to_settings_class = null;
				
			}
				
		} else {
			
			$nfproot_add_to_settings_class = null;
			
		}
		
		return $nfproot_add_to_settings_class;
	
	}

} 

//do not add errors here, since it is expected that this function is invoked more than once

if(!function_exists('nfproot_settings_arrow_before')) {

	function nfproot_settings_arrow_before($nfproot_settings_arrow_before) {

		if(
		
			!empty($nfproot_settings_arrow_before['arrow-before'])
			&& $nfproot_settings_arrow_before['arrow-before'] === true
		
		){
		
			?>

			<span class="nfproot-switching-content-expand dashicons dashicons-arrow-down-alt2"></span>
			<span class="nfproot-switching-content-shrink dashicons dashicons-arrow-up-alt2"></span>
			
			<?php
			
		}
	
	}

} 

//do not add errors here, since it is expected that this function is invoked more than once


if(!function_exists('nfproot_settings_description')) {

	function nfproot_settings_description($nfproot_switch) {
		
		?>
		
		<p class="nfproot-setting-description">
			<?php echo wp_kses_post($nfproot_switch['input-description']); ?>
		</p>

		<?php
	
	}

} 

//do not add errors here, since it is expected that this function is invoked more than once

if(!function_exists('nfproot_add_to_settings_local')) {

	function nfproot_add_to_settings_local() {
		
		?>

		<p class="nfproot-wpml-alert">
			It only applies to the current WPML language
		</p>		

		<?php	
	
	}

} 

//do not add errors here, since it is expected that this function is invoked more than once

if(!function_exists('nfproot_settings_switch')) {

	function nfproot_settings_switch($nfproot_settings_switch, $nfproot_current_language_settings) {
		
		if(
		
			!empty($nfproot_settings_switch['input-type'])
			&& $nfproot_settings_switch['input-type'] === 'switch'
		
		){

			//first of all, let's check if checkbox is selected or not
			$nfproot_settings_switch_checked = null;
			
			if(
				$nfproot_current_language_settings !== false 
				&& !empty($nfproot_current_language_settings[$nfproot_settings_switch['data-save']][$nfproot_settings_switch['input-name']]) 
				&& $nfproot_current_language_settings[$nfproot_settings_switch['data-save']][$nfproot_settings_switch['input-name']] === '1'
				
			) {
				
				$nfproot_settings_switch_checked = 'checked';
				
			}	
			
			?>

			<p style="display:inline">
			<input type="checkbox" 
			name="<?php echo esc_attr($nfproot_settings_switch['input-name']); ?>" 
			class="nfproot-switch nfproot-switching-content <?php echo esc_attr(nfproot_add_to_settings($nfproot_settings_switch)); ?>" 
			id="<?php echo esc_attr($nfproot_settings_switch['input-id']); ?>" 
			value="<?php echo esc_attr($nfproot_settings_switch['input-value']); ?>" 
			data-save="<?php echo esc_attr($nfproot_settings_switch['data-save']); ?>" <?php echo esc_attr($nfproot_settings_switch_checked); ?> />
			<label for="<?php echo esc_attr($nfproot_settings_switch['input-id']); ?>">&nbsp;</label>
			</p>
			
			<?php
			
		}
	
	}

} 

//do not add errors here, since it is expected that this function is invoked more than once

if(!function_exists('nfproot_settings_text_email_password')) {

	function nfproot_settings_text_email_password($nfproot_settings_text_email_password, $nfproot_current_language_settings) {
		
		if(
			$nfproot_current_language_settings !== false 
			&& !empty($nfproot_current_language_settings[$nfproot_settings_text_email_password['data-save']][$nfproot_settings_text_email_password['input-name']])						
			
		) {
			
			$nfproot_input_value = $nfproot_current_language_settings[$nfproot_settings_text_email_password['data-save']][$nfproot_settings_text_email_password['input-name']];
		
		} else {
			
			$nfproot_input_value = $nfproot_settings_text_email_password['input-value'];
			
		}
		
		?>
		
		<p style="display:inline">
		<input type="<?php echo esc_attr($nfproot_settings_text_email_password['input-type']); ?>" 
		name="<?php echo esc_attr($nfproot_settings_text_email_password['input-name']); ?>" 
		class="<?php echo esc_attr(nfproot_add_to_settings($nfproot_settings_text_email_password)); ?> <?php echo esc_attr($nfproot_settings_text_email_password['input-class']); ?>" 
		id="<?php echo esc_attr($nfproot_settings_text_email_password['input-id']); ?>" 
		value="<?php echo esc_attr($nfproot_input_value); ?>" data-save="<?php echo esc_attr($nfproot_settings_text_email_password['data-save']); ?>" />
		<label for="<?php echo esc_attr($nfproot_settings_text_email_password['input-id']); ?>">&nbsp;</label>
		</p>
		
		<?php

	}

} 

//do not add errors here, since it is expected that this function is invoked more than once

if(!function_exists('nfproot_settings_textarea')) {

	function nfproot_settings_textarea($nfproot_settings_textarea, $nfproot_current_language_settings) {
		
		if(
			$nfproot_current_language_settings !== false 
			&& !empty($nfproot_current_language_settings[$nfproot_settings_textarea['data-save']][$nfproot_settings_textarea['input-name']])						
			
		) {
			
			$nfproot_input_value = $nfproot_current_language_settings[$nfproot_settings_textarea['data-save']][$nfproot_settings_textarea['input-name']];
		
		} else {
			
			$nfproot_input_value = $nfproot_settings_textarea['input-value'];
			
		}
		
		?>
		
		<p style="display:inline">
		<textarea name="<?php echo esc_attr($nfproot_settings_textarea['input-name']); ?>" 
		class="<?php echo esc_attr(nfproot_add_to_settings($nfproot_settings_textarea)); ?> <?php echo esc_attr($nfproot_settings_textarea['input-class']); ?>" 
		id="<?php echo esc_attr($nfproot_settings_textarea['input-id']); ?>" 
		data-save="<?php echo esc_attr($nfproot_settings_textarea['data-save']); ?>" /><?php echo esc_textarea($nfproot_input_value); ?></textarea>
		</p>
		
		<?php

	}

} 

//do not add errors here, since it is expected that this function is invoked more than once

if(!function_exists('nfproot_settings_dropdown')) {

	function nfproot_settings_dropdown($nfproot_settings_dropdown, $nfproot_current_language_settings) {

		?>

		<p style="display:inline">
		<select name="<?php echo esc_attr($nfproot_settings_dropdown['input-name']); ?>" 
		class="<?php echo esc_attr(nfproot_add_to_settings($nfproot_settings_dropdown)); ?>" 
		id="<?php echo esc_attr($nfproot_settings_dropdown['input-id']); ?>" 
		data-save="<?php echo esc_attr($nfproot_settings_dropdown['data-save']); ?>">

		<?php

		$nfproot_default_value_selected = true;
		
		if(
			$nfproot_current_language_settings !== false 
			&& !empty($nfproot_current_language_settings[$nfproot_settings_dropdown['data-save']][$nfproot_settings_dropdown['input-name']]) 
			
		) {
			
			$nfproot_default_value_selected = false;
		
		}

		if(!empty($nfproot_settings_dropdown['input-value'])) {
		
			foreach($nfproot_settings_dropdown['input-value'] as $nfproot_settings_dropdown_settings) {
				
				$nfproot_option_selected = null;
				
				if($nfproot_default_value_selected === true) {
					
					$nfproot_option_selected = $nfproot_settings_dropdown_settings['option-selected'];
					
				} else {
					
					if((int)$nfproot_current_language_settings[$nfproot_settings_dropdown['data-save']][$nfproot_settings_dropdown['input-name']] === $nfproot_settings_dropdown_settings['option-value']){
						
						$nfproot_option_selected = 'selected';
						
					}							
					
				}
			
				?>
				
				<option value="<?php echo esc_attr($nfproot_settings_dropdown_settings['option-value']); ?>" <?php echo esc_attr($nfproot_option_selected); ?>>
				<?php echo esc_attr($nfproot_settings_dropdown_settings['option-text']); ?>
				</option>
				
				<?php
				
			}
			
		}


		?>
		</select>
		</p>
		
		<?php
	
	}

} 

//do not add errors here, since it is expected that this function is invoked more than once


if(!function_exists('nfproot_settings_radio')) {

	function nfproot_settings_radio($nfproot_settings_radio, $nfproot_current_language_settings) {

		$nfproot_default_value_selected = true;
		
		if(
			$nfproot_current_language_settings !== false 
			&& !empty($nfproot_current_language_settings[$nfproot_settings_radio['data-save']][$nfproot_settings_radio['input-name']]) 
			
		) {
			
			$nfproot_default_value_selected = false;
		
		}
		
		if(!empty($nfproot_settings_radio['input-value'])){
		
			foreach($nfproot_settings_radio['input-value'] as $nfproot_settings_radio_settings) {
				
				$nfproot_input_checked = null;
				
				if($nfproot_default_value_selected === true) {
					
					$nfproot_input_checked = $nfproot_settings_radio_settings['radio-checked'];
					
				} else {
					
					if($nfproot_current_language_settings[$nfproot_settings_radio['data-save']][$nfproot_settings_radio['input-name']] === $nfproot_settings_radio_settings['radio-value']){
						
						$nfproot_input_checked = 'checked';
						
					}							
					
				}					
			
				?>

				<p>
				<input type="radio" 
				name="<?php echo esc_attr($nfproot_settings_radio['input-name']); ?>" 
				class="<?php echo esc_attr(nfproot_add_to_settings($nfproot_settings_radio)); ?>" 
				id="<?php echo esc_attr($nfproot_settings_radio['input-id']); ?>" 
				value="<?php echo esc_attr($nfproot_settings_radio_settings['radio-value']); ?>" 
				data-save="<?php echo esc_attr($nfproot_settings_radio['data-save']); ?>" <?php echo esc_attr($nfproot_input_checked); ?> />
				<label for="<?php echo esc_attr($nfproot_settings_radio['input-id']); ?>"><?php echo esc_attr($nfproot_settings_radio_settings['radio-text']); ?></label>
				</p>
				
				<?php
				
			}

		}			
	
	}

} 

//do not add errors here, since it is expected that this function is invoked more than once

if(!function_exists('nfproot_settings_checkbox')) {

	function nfproot_settings_checkbox($nfproot_settings_checkbox, $nfproot_current_language_settings) {

		$nfproot_input_checked = null;
		
		if(
			$nfproot_current_language_settings !== false 
			&& !empty($nfproot_current_language_settings[$nfproot_settings_checkbox['data-save']][$nfproot_settings_checkbox['input-name']])
			&& $nfproot_current_language_settings[$nfproot_settings_checkbox['data-save']][$nfproot_settings_checkbox['input-name']] === '1'						
			
		) {
			
			$nfproot_input_checked = 'checked';
		
		}
		
		?>

		<p style="display:inline">
		<input type="checkbox" 
		name="<?php echo esc_attr($nfproot_settings_checkbox['input-name']); ?>" 
		class="nfproot-switch <?php echo esc_attr(nfproot_add_to_settings($nfproot_settings_checkbox)); ?>" 
		id="<?php echo esc_attr($nfproot_settings_checkbox['input-id']); ?>" 
		value="<?php echo esc_attr($nfproot_settings_checkbox['input-value']); ?>" 
		data-save="<?php echo esc_attr($nfproot_settings_checkbox['data-save']); ?>" <?php echo esc_attr($nfproot_input_checked); ?> />
		<label for="<?php echo esc_attr($nfproot_settings_checkbox['input-id']); ?>">&nbsp;</label>
		</p>
		
		<?php		
	
	}

} 

//do not add errors here, since it is expected that this function is invoked more than once

if(!function_exists('nfproot_settings_button')) {

	function nfproot_settings_button($nfproot_settings_button) {

		?>

		<p style="display:inline-block">
		<input type="button" 
		name="<?php echo esc_attr($nfproot_settings_button['input-name']); ?>" 
		class="button button-secondary <?php echo esc_attr(nfproot_add_to_settings($nfproot_settings_button)); ?>" 
		id="<?php echo esc_attr($nfproot_settings_button['input-id']); ?>" 
		value="<?php echo esc_attr($nfproot_settings_button['input-value']); ?>" 
		data-save="<?php echo esc_attr($nfproot_settings_button['data-save']); ?>">
		</p>
		
		<?php		
	
	}

} 

//do not add errors here, since it is expected that this function is invoked more than once

if(!function_exists('nfproot_settings_textonly')) {

	function nfproot_settings_textonly($nfproot_settings_textonly) {

		echo wp_kses_post($nfproot_settings_textonly['input-value']);
	
	}

} 

//do not add errors here, since it is expected that this function is invoked more than once

if(!function_exists('nfproot_settings_after_input')) {

	function nfproot_settings_after_input($nfproot_settings_after_input) {
		
		if(!empty($nfproot_settings_after_input['after-input'])) {
		
			foreach($nfproot_settings_after_input['after-input'] as $nfproot_setting_after_input) {
				
				$nfproot_setting_after_input_style = null;
				if($nfproot_setting_after_input['hidden'] === true) {
					
					$nfproot_setting_after_input_style = 'display:none';
					
				}
				
				if($nfproot_setting_after_input['type'] === 'paragraph') {
					
					?>
					
					<p id="<?php echo esc_attr($nfproot_setting_after_input['id']); ?>" 
					class="<?php echo esc_attr($nfproot_setting_after_input['class']); ?>" style="<?php echo esc_attr($nfproot_setting_after_input_style); ?>">
					
						<?php echo wp_kses_post($nfproot_setting_after_input['content']); ?>
					
					</p>
					
					<?php
					
					
				}
				
				if($nfproot_setting_after_input['type'] === 'button') {
					
					?>
					
					<button 
					id="<?php echo esc_attr($nfproot_setting_after_input['id']); ?>" 
					class="<?php echo esc_attr($nfproot_setting_after_input['class']); ?>" <?php echo esc_attr($nfproot_setting_after_input_style); ?> 
					value="<?php echo esc_attr($nfproot_setting_after_input['value']); ?>">
					<?php echo esc_attr($nfproot_setting_after_input['content']); ?>
					</button>

					
					<?php
					
					
				}				
				
			}

		}		
	
	}

} 

//do not add errors here, since it is expected that this function is invoked more than once

//with this function we will create the Kudu menu page
if(!function_exists('nfproot_settings_structure')) {
	
	function nfproot_settings_structure($nfproot_settings_array) {	
	
		$nfproot_get_wpml_active_languages = apply_filters('wpml_active_languages', false);
		
		if(!empty($nfproot_settings_array)) {
		
			foreach($nfproot_settings_array as $nfproot_switch) {
					
				global $nfproot_current_language_settings;
						
				?>
				
				<h2>
				<span style="margin-right:10px;" class="dashicons dashicons-marker"></span> <span class="nfproot-settings-container-title">
				<?php echo esc_attr($nfproot_switch['container-title']); ?>
				</span></h2>
				<div id="<?php echo esc_attr($nfproot_switch['container-id']); ?>" 
				class="nfproot-settings-container <?php echo esc_attr($nfproot_switch['container-class']); ?>">
				
					<?php
									
					nfproot_settings_arrow_before($nfproot_switch);
					nfproot_settings_switch($nfproot_switch, $nfproot_current_language_settings);					
					nfproot_settings_after_input($nfproot_switch);				
					nfproot_settings_description($nfproot_switch);

					if(!empty($nfproot_get_wpml_active_languages)) {
						
						if(nfproot_add_to_settings($nfproot_switch) === 'nfproot-input-local') {
							
							nfproot_add_to_settings_local();
							
						}
						
					}
					
				if(!empty($nfproot_switch['childs'])){
				
					foreach($nfproot_switch['childs'] as $nfproot_switch_child) {

						?>
						
						<div id="<?php echo esc_attr($nfproot_switch_child['container-id']); ?>" 
						class="nfproot-switch-child <?php echo esc_attr($nfproot_switch_child['container-class']); ?> nfproot-hidden-content">
						
						<?php	
						
						if(!empty($nfproot_switch_child['container-title'])) {
							
							?>
							
							<h4>
							<span class="nfproot-settings-container-title">
							<?php echo esc_attr($nfproot_switch_child['container-title']); ?>
							</span>
							</h4>
							
							<?php
							
							
						}				

						//SWITCH
						if($nfproot_switch_child['input-type'] === 'switch') {										

							nfproot_settings_arrow_before($nfproot_switch_child);
							nfproot_settings_switch($nfproot_switch_child, $nfproot_current_language_settings);					
							nfproot_settings_after_input($nfproot_switch_child);				
							nfproot_settings_description($nfproot_switch_child);

							if(!empty($nfproot_get_wpml_active_languages)) {
								
								if(nfproot_add_to_settings($nfproot_switch_child) === 'nfproot-input-local') {
									
									nfproot_add_to_settings_local();
									
								}
								
							}
							
							if(!empty($nfproot_switch_child['childs'])){
							
								foreach($nfproot_switch_child['childs'] as $nfproot_switch_grandchild) {

									?>
									
									<div id="<?php echo esc_attr($nfproot_switch_grandchild['container-id']); ?>" 
									class="nfproot-switch-child <?php echo esc_attr($nfproot_switch_grandchild['container-class']); ?> nfproot-hidden-content">
									
									<?php	
									
									if(!empty($nfproot_switch_grandchild['container-title'])) {
										
										?>
										
										<h4>
										<span class="nfproot-settings-container-title">
										<?php echo esc_attr($nfproot_switch_grandchild['container-title']); ?>
										</span>
										</h4>
										
										<?php
										
										
									}		
									
									
									//TEXT, EMAIL, PASSWORD
									if($nfproot_switch_grandchild['input-type'] === 'text' || $nfproot_switch_grandchild['input-type'] === 'email' || $nfproot_switch_grandchild['input-type'] === 'password') {										

										nfproot_settings_text_email_password($nfproot_switch_grandchild, $nfproot_current_language_settings);
									
									}
									
									//TEXTAREA
									if($nfproot_switch_grandchild['input-type'] === 'textarea') {										

										nfproot_settings_textarea($nfproot_switch_grandchild, $nfproot_current_language_settings);
									
									}

									//DROPDOWN
									if($nfproot_switch_grandchild['input-type'] === 'dropdown') {
									
										nfproot_settings_dropdown($nfproot_switch_grandchild, $nfproot_current_language_settings);
									
									}
									
									//RADIO BUTTON
									if($nfproot_switch_grandchild['input-type'] === 'radio') {

										nfproot_settings_radio($nfproot_switch_grandchild, $nfproot_current_language_settings);
										
									}
									
									//CHECKBOX
									if($nfproot_switch_grandchild['input-type'] === 'checkbox') {
										
										nfproot_settings_checkbox($nfproot_switch_grandchild, $nfproot_current_language_settings);

									}									
									
									//BUTTON
									if($nfproot_switch_grandchild['input-type'] === 'button') {
										
										nfproot_settings_button($nfproot_switch_grandchild);
									
									}
									
									//TEXT ONLY
									if($nfproot_switch_grandchild['input-type'] === 'textonly') {
										
										nfproot_settings_textonly($nfproot_switch_grandchild);
									
									}
									
									nfproot_settings_after_input($nfproot_switch_grandchild);
									nfproot_settings_description($nfproot_switch_grandchild);
									
									if(!empty($nfproot_get_wpml_active_languages)) {
										
										if(nfproot_add_to_settings($nfproot_switch_grandchild) === 'nfproot-input-local') {
											
											nfproot_add_to_settings_local();
											
										}
										
									}

									?>
									
									</div>
									
									<?php						

								}	
								
							}

							?>
							
							</div>
							
							<?php					
						
						} else {
							
							//TEXT, EMAIL, PASSWORD
							if($nfproot_switch_child['input-type'] === 'text' || $nfproot_switch_child['input-type'] === 'email' || $nfproot_switch_child['input-type'] === 'password') {										

								nfproot_settings_text_email_password($nfproot_switch_child, $nfproot_current_language_settings);
							
							}
							
							//TEXTAREA
							if($nfproot_switch_child['input-type'] === 'textarea') {										

								nfproot_settings_textarea($nfproot_switch_child, $nfproot_current_language_settings);
							
							}

							//DROPDOWN
							if($nfproot_switch_child['input-type'] === 'dropdown') {
							
								nfproot_settings_dropdown($nfproot_switch_child, $nfproot_current_language_settings);
							
							}
							
							//RADIO BUTTON
							if($nfproot_switch_child['input-type'] === 'radio') {

								nfproot_settings_radio($nfproot_switch_child, $nfproot_current_language_settings);
								
							}
							
							//CHECKBOX
							if($nfproot_switch_child['input-type'] === 'checkbox') {
								
								nfproot_settings_checkbox($nfproot_switch_child, $nfproot_current_language_settings);

							}									
							
							//BUTTON
							if($nfproot_switch_child['input-type'] === 'button') {
								
								nfproot_settings_button($nfproot_switch_child);
							
							}
							
							//TEXT ONLY
							if($nfproot_switch_child['input-type'] === 'textonly') {
								
								nfproot_settings_textonly($nfproot_switch_child);
							
							}
							
							nfproot_settings_after_input($nfproot_switch_child);
							nfproot_settings_description($nfproot_switch_child);
							
							if(!empty($nfproot_get_wpml_active_languages)) {
								
								if(nfproot_add_to_settings($nfproot_switch_child) === 'nfproot-input-local') {
									
									nfproot_add_to_settings_local();
									
								}
								
							}
							
							?>
							
							</div>
							
							<?php
							
						}
						
					}
					
				}
				
				?>
				
				</div>
				
				<?php
						
			}

		}			
		
	}
	
} 

//do not add errors here, since it is expected that this function is invoked more than once