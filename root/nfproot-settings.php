<?php
//if this file is called directly, die.
if(!defined('ABSPATH')) die('please, do not call this page directly');

//with this function we will create the NutsForPress menu page
if(!function_exists('nfproot_settings')) {
	
	function nfproot_settings() {	
		
		add_menu_page(
		
			'NutsForPress',
			'NutsForPress',
			'manage_options',
			'nfproot-settings',
			'nfproot_settings_callback',
			'dashicons-marker'
			
		);
		
	}
	
} 

//do not add errors here, since it is expected that this function is invoked more than once
	
//with this function we will define the NutsForPress menu page content
if(!function_exists('nfproot_settings_callback')) {
	
	function nfproot_settings_callback() {	
	
		//get NutsForPress setting
		global $nfproot_plugins_settings;
		
		if(!empty($nfproot_plugins_settings)) {

			?>
			
			<div class="wrap nfproot-settings-wrap">
				
				<h1>NutsForPress</h1>
				<h2>Plugins</h2>
				<p>
				<ul>
			
			<?php
			
			foreach($nfproot_plugins_settings as $nfproot_root_setting_key => $nfproot_root_setting_value) {
				
				?>
					
				<li>
				
					<a href="admin.php?page=<?php echo esc_attr($nfproot_root_setting_value['slug']); ?>" 
					title="<?php echo esc_attr($nfproot_root_setting_value['name']); ?>" 
					alt="<?php echo esc_attr($nfproot_root_setting_value['name']); ?>">
					<?php echo esc_attr($nfproot_root_setting_value['name']); ?>
					</a>
				
				</li>
				
				<?php
								
			}
			
			?>
				</ul>
				</p>
				
				<div style="margin-top:150px">
				
					<h4>More <a href="https://wordpress.org/plugins/search/nutsforpress/" title="NutsForPress Plugins" alt="NutsForPress Plugins" target="_blank">NutsForPress Plugins</a></h4>
				
				</div>
			
			</div>
		
		<?php
			
		}
				
	}
	
} 

//do not add errors here, since it is expected that this function is invoked more than once