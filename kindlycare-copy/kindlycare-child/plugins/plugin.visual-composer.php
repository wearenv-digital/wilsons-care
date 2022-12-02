<?php
/* WPBakery PageBuilder support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('kindlycare_vc_theme_setup')) {
	add_action( 'kindlycare_action_before_init_theme', 'kindlycare_vc_theme_setup', 1 );
	function kindlycare_vc_theme_setup() {
		if (kindlycare_exists_visual_composer()) {
			if (is_admin()) {
				add_filter( 'kindlycare_filter_importer_options',				'kindlycare_vc_importer_set_options' );
			}
			add_action('kindlycare_action_add_styles',		 				'kindlycare_vc_frontend_scripts' );
		}
		if (is_admin()) {
			add_filter( 'kindlycare_filter_importer_required_plugins',		'kindlycare_vc_importer_required_plugins', 10, 2 );
			add_filter( 'kindlycare_filter_required_plugins',					'kindlycare_vc_required_plugins' );
		}
	}
}

// Check if WPBakery PageBuilder installed and activated
if ( !function_exists( 'kindlycare_exists_visual_composer' ) ) {
	function kindlycare_exists_visual_composer() {
		return class_exists('Vc_Manager');
	}
}

// Check if WPBakery PageBuilder in frontend editor mode
if ( !function_exists( 'kindlycare_vc_is_frontend' ) ) {
	function kindlycare_vc_is_frontend() {
		return (isset($_GET['vc_editable']) && $_GET['vc_editable']=='true')
			|| (isset($_GET['vc_action']) && $_GET['vc_action']=='vc_inline');
		//return function_exists('vc_is_frontend_editor') && vc_is_frontend_editor();
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'kindlycare_vc_required_plugins' ) ) {
	//Handler of add_filter('kindlycare_filter_required_plugins',	'kindlycare_vc_required_plugins');
	function kindlycare_vc_required_plugins($list=array()) {
		if (in_array('visual_composer', kindlycare_storage_get('required_plugins'))) {
			$path = kindlycare_get_file_dir('plugins/install/js_composer.zip');
			if (file_exists($path)) {
				$list[] = array(
					'name' 		=> 'WPBakery PageBuilder',
					'slug' 		=> 'js_composer',
					'source'	=> $path,
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Enqueue VC custom styles
if ( !function_exists( 'kindlycare_vc_frontend_scripts' ) ) {
	//Handler of add_action( 'kindlycare_action_add_styles', 'kindlycare_vc_frontend_scripts' );
	function kindlycare_vc_frontend_scripts() {
		if (file_exists(kindlycare_get_file_dir('css/plugin.visual-composer.css')))
			wp_enqueue_style( 'kindlycare-plugin.visual-composer-style',  kindlycare_get_file_url('css/plugin.visual-composer.css'), array(), null );
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check VC in the required plugins
if ( !function_exists( 'kindlycare_vc_importer_required_plugins' ) ) {
	//Handler of add_filter( 'kindlycare_filter_importer_required_plugins',	'kindlycare_vc_importer_required_plugins', 10, 2 );
	function kindlycare_vc_importer_required_plugins($not_installed='', $list='') {
		//if (in_array('visual_composer', kindlycare_storage_get('required_plugins')) && !kindlycare_exists_visual_composer() && kindlycare_get_value_gp('data_type')=='vc' )
		if (!kindlycare_exists_visual_composer() )		// && kindlycare_strpos($list, 'visual_composer')!==false
			$not_installed .= '<br>WPBakery PageBuilder';
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'kindlycare_vc_importer_set_options' ) ) {
	//Handler of add_filter( 'kindlycare_filter_importer_options',	'kindlycare_vc_importer_set_options' );
	function kindlycare_vc_importer_set_options($options=array()) {
		if ( in_array('visual_composer', kindlycare_storage_get('required_plugins')) && kindlycare_exists_visual_composer() ) {
			// Add slugs to export options for this plugin
			$options['additional_options'][] = 'wpb_js_templates';
		}
		return $options;
	}
}
?>