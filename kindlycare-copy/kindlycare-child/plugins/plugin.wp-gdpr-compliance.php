<?php
/* WP GDPR Compliance support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('kindlycare_wp_gdpr_compliance_theme_setup')) {
    add_action( 'kindlycare_action_before_init_theme', 'kindlycare_wp_gdpr_compliance_theme_setup', 1 );
    function kindlycare_wp_gdpr_compliance_theme_setup() {
        if (is_admin()) {
            add_filter( 'kindlycare_filter_required_plugins', 'kindlycare_wp_gdpr_compliance_required_plugins' );
        }
    }
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'kindlycare_exists_wp_gdpr_compliance' ) ) {
    function kindlycare_exists_wp_gdpr_compliance() {
        return defined( 'WP_GDPR_Compliance_VERSION' );
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'kindlycare_wp_gdpr_compliance_required_plugins' ) ) {
    //add_filter('kindlycare_filter_required_plugins',    'kindlycare_wp_gdpr_compliance_required_plugins');
    function kindlycare_wp_gdpr_compliance_required_plugins($list=array()) {
        if (in_array('wp_gdpr_compliance', (array)kindlycare_storage_get('required_plugins')))
            $list[] = array(
                'name'         => esc_html__('WP GDPR Compliance', 'kindlycare'),
                'slug'         => 'wp-gdpr-compliance',
                'required'     => false
            );
        return $list;
    }
}
