<?php
/*
Plugin Name: 	NutsForPress Images and Media
Plugin URI:		https://www.nutsforpress.com/
Description: 	NutsForPress Images and Media is an essential companion for having your images and your meta in perfect order. Images and Media automatically resizes images, compresses JPGs, bulk rebuilds thumbnails and PDF previews. 
Version:     	1.7
Author:			Christian Gatti
Author URI:		https://profiles.wordpress.org/christian-gatti/
License:		GPL-2.0+
License URI:	http://www.gnu.org/licenses/gpl-2.0.txt
Text Domain:	nutsforpress
*/

//if this file is called directly, die.
if(!defined('ABSPATH')) die('please, do not call this page directly');


//DEFINITIONS

if(!defined('NFPROOT_BASE_RELATIVE')) {define('NFPROOT_BASE_RELATIVE', dirname(plugin_basename( __FILE__ )).'/root');}
define('NFPMGM_BASE_PATH', plugin_dir_path( __FILE__ ));
define('NFPMGM_BASE_URL', plugins_url().'/'.plugin_basename( __DIR__ ).'/');
define('NFPMGM_BASE_RELATIVE', dirname( plugin_basename( __FILE__ )));
define('NFPMGM_DEBUG', false);


//NUTSFORPRESS ROOT CONTENT
	
//add NutsForPress parent menu page
require_once NFPMGM_BASE_PATH.'root/nfproot-settings.php';
add_action('admin_menu', 'nfproot_settings');

//add NutsForPress save settings function and make it available through ajax
require_once NFPMGM_BASE_PATH.'root/nfproot-save-settings.php';
add_action('wp_ajax_nfproot_save_settings', 'nfproot_save_settings');

//add NutsForPress saved settings and make them available through the global varibales $nfproot_current_language_settings and $nfproot_options_name
require_once NFPMGM_BASE_PATH.'root/nfproot-saved-settings.php';
add_action('plugins_loaded', 'nfproot_saved_settings');

//register NutsForPress styles and scripts
require_once NFPMGM_BASE_PATH.'root/nfproot-styles-and-scripts.php';
add_action('admin_enqueue_scripts', 'nfproot_styles_and_scripts');
	
//add NutsForPress settings structure that contains nfproot_options_structure function invoked by plugin settings
require_once NFPMGM_BASE_PATH.'root/nfproot-settings-structure.php';


//PLUGIN INCLUDES

//add activate actions
require_once NFPMGM_BASE_PATH.'includes/nfpmgm-plugin-activate.php';
register_activation_hook(__FILE__, 'nfpmgm_plugin_activate');

//add deactivate actions
require_once NFPMGM_BASE_PATH.'includes/nfpmgm-plugin-deactivate.php';
register_deactivation_hook(__FILE__, 'nfpmgm_plugin_deactivate');

//add uninstall actions
require_once NFPMGM_BASE_PATH.'includes/nfpmgm-plugin-uninstall.php';
register_uninstall_hook(__FILE__, 'nfpmgm_plugin_uninstall');

//styles and scripts
require_once NFPMGM_BASE_PATH.'includes/nfpmgm-styles-and-scripts.php';
add_action('admin_enqueue_scripts', 'nfpmgm_styles_and_scripts');


//PLUGIN SETTINGS

//add plugin settings
require_once NFPMGM_BASE_PATH.'admin/nfpmgm-settings.php';
add_action('admin_menu', 'nfpmgm_settings');


//ADMIN INCLUDES CONDITIONALLY

//load rebuild thumbnails ajax functions
require_once NFPMGM_BASE_PATH.'admin/includes/nfpmgm-thumbnails-rebuild.php';
add_action('wp_ajax_nfpmgm_thumbnails_rebuild', 'nfpmgm_thumbnails_rebuild');

//load size actions
require_once NFPMGM_BASE_PATH.'admin/includes/nfpmgm-size-actions.php';
add_action('add_attachment', 'nfpmgm_size_actions');

//load size actions on delete
require_once NFPMGM_BASE_PATH.'admin/includes/nfpmgm-size-actions-on-delete.php';
add_action('delete_attachment', 'nfpmgm_size_actions_on_delete');

//load quality actions
require_once NFPMGM_BASE_PATH.'admin/includes/nfpmgm-quality-actions.php';
add_action('add_attachment', 'nfpmgm_quality_actions');

//deal with WPML post duplication
require_once NFPMGM_BASE_PATH.'admin/includes/nfpmgm-wpml-attachment-duplicate.php';
add_action('wpml_media_create_duplicate_attachment', 'nfpmgm_wpml_attachment_duplicate',10, 2);