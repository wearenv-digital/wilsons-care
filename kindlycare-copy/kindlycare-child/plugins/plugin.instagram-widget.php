<?php
/* Instagram Widget support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('kindlycare_instagram_widget_theme_setup')) {
	add_action( 'kindlycare_action_before_init_theme', 'kindlycare_instagram_widget_theme_setup', 1 );
	function kindlycare_instagram_widget_theme_setup() {
		if (kindlycare_exists_instagram_widget()) {
			add_action( 'kindlycare_action_add_styles', 						'kindlycare_instagram_widget_frontend_scripts' );
		}
		if (is_admin()) {
			add_filter( 'kindlycare_filter_importer_required_plugins',		'kindlycare_instagram_widget_importer_required_plugins', 10, 2 );
			add_filter( 'kindlycare_filter_required_plugins',					'kindlycare_instagram_widget_required_plugins' );
		}
	}
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'kindlycare_exists_instagram_widget' ) ) {
	function kindlycare_exists_instagram_widget() {
		return function_exists('wpiw_init');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'kindlycare_instagram_widget_required_plugins' ) ) {
	//Handler of add_filter('kindlycare_filter_required_plugins',	'kindlycare_instagram_widget_required_plugins');
	function kindlycare_instagram_widget_required_plugins($list=array()) {
		if (in_array('instagram_widget', kindlycare_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> 'Instagram Widget',
					'slug' 		=> 'wp-instagram-widget',
					'required' 	=> false
				);
		return $list;
	}
}

// Enqueue custom styles
if ( !function_exists( 'kindlycare_instagram_widget_frontend_scripts' ) ) {
	//Handler of add_action( 'kindlycare_action_add_styles', 'kindlycare_instagram_widget_frontend_scripts' );
	function kindlycare_instagram_widget_frontend_scripts() {
		if (file_exists(kindlycare_get_file_dir('css/plugin.instagram-widget.css')))
			wp_enqueue_style( 'kindlycare-plugin.instagram-widget-style',  kindlycare_get_file_url('css/plugin.instagram-widget.css'), array(), null );
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check Instagram Widget in the required plugins
if ( !function_exists( 'kindlycare_instagram_widget_importer_required_plugins' ) ) {
	//Handler of add_filter( 'kindlycare_filter_importer_required_plugins',	'kindlycare_instagram_widget_importer_required_plugins', 10, 2 );
	function kindlycare_instagram_widget_importer_required_plugins($not_installed='', $list='') {
		//if (in_array('instagram_widget', kindlycare_storage_get('required_plugins')) && !kindlycare_exists_instagram_widget() )
		if (kindlycare_strpos($list, 'instagram_widget')!==false && !kindlycare_exists_instagram_widget() )
			$not_installed .= '<br>WP Instagram Widget';
		return $not_installed;
	}
}
?>