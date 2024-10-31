<?php
//if this file is called directly, die.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//with this function we will create the NutsForPress menu page
if(!function_exists('nfpmgm_settings')) {
	
	function nfpmgm_settings() {	
		
		global $nfproot_root_settings;
		$nfpmgm_pro = null;
		
		if(
		
			!empty($nfproot_root_settings) 
			&& !empty($nfproot_root_settings['installed_plugins']['nfpmgm']['edition'])
			&& $nfproot_root_settings['installed_plugins']['nfpmgm']['edition'] === 'registered'
			
		) {
			
			$nfpmgm_pro = ' <span class="dashicons dashicons-saved"></span>';
			
		}
		
		add_submenu_page(
	
			'nfproot-settings',
			'Images and Media',
			'Images and Media'.$nfpmgm_pro,
			'manage_options',
			'nfpmgm-settings',
			'nfpmgm_settings_callback'
		
		);
		
		
	}
	
} else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpmgm_base_options" already exists');
	
}
	
//with this function we will define the NutsForPress menu page content
if(!function_exists('nfpmgm_settings_callback')) {
	
	function nfpmgm_settings_callback() {
		
		?>
		
		<div class="wrap nfproot-settings-wrap">
			
			<h1>Images and Media settings</h1>
			
			<div class="nfproot-settings-main-container">
		
				<?php
				
				//include option content page
				require_once NFPMGM_BASE_PATH.'admin/nfpmgm-settings-content.php';
				
				//define contents as result of the function nfpmgm_settings_content
				$nfpmgm_settings_content = nfpmgm_settings_content();
				
				//invoke nfproot_options_structure functions included into /root/options/nfproot-options-structure.php
				nfproot_settings_structure($nfpmgm_settings_content);
				
				?>
				
			</div>
		
		</div>
		
		<?php
		
	}
	
} else {
	
	error_log('NUTSFORPRESS ERROR: function "nfpmgm_settings" already exists');
	
}