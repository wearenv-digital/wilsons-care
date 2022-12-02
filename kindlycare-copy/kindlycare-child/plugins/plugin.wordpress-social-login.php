<?php
/* WordPress Social Login support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('kindlycare_wordpress_social_login_theme_setup')) {
	add_action( 'kindlycare_action_before_init_theme', 'kindlycare_wordpress_social_login_theme_setup', 1 );
	function kindlycare_wordpress_social_login_theme_setup() {
		if (is_admin()) {
			add_filter( 'kindlycare_filter_required_plugins',				'kindlycare_wordpress_social_login_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'kindlycare_wordpress_social_login_required_plugins' ) ) {
	//Handler of add_filter('kindlycare_filter_required_plugins',	'kindlycare_wordpress_social_login_required_plugins');
	function kindlycare_wordpress_social_login_required_plugins($list=array()) {
		if (in_array('wordpress-social-login', kindlycare_storage_get('required_plugins'))) {
            $list[] = array(
                'name' 		=> 'WordPress Social Login',
                'slug' 		=> 'wordpress-social-login',
                'required' 	=> false
                );
		}
		return $list;
	}
}
?>