<?php
/* Gutenberg support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('kindlycare_gutenberg_theme_setup')) {
    add_action( 'kindlycare_action_before_init_theme', 'kindlycare_gutenberg_theme_setup', 1 );
    function kindlycare_gutenberg_theme_setup() {
        if (is_admin()) {
            add_filter( 'kindlycare_filter_required_plugins', 'kindlycare_gutenberg_required_plugins' );
        }
    }
}

// Check if Instagram Widget installed and activated
if ( !function_exists( 'kindlycare_exists_gutenberg' ) ) {
    function kindlycare_exists_gutenberg() {
        return function_exists( 'the_gutenberg_project' ) && function_exists( 'register_block_type' );
    }
}

// Filter to add in the required plugins list
if ( !function_exists( 'kindlycare_gutenberg_required_plugins' ) ) {
    //add_filter('kindlycare_filter_required_plugins',    'kindlycare_gutenberg_required_plugins');
    function kindlycare_gutenberg_required_plugins($list=array()) {
        if (in_array('gutenberg', (array)kindlycare_storage_get('required_plugins')))
            $list[] = array(
                'name'         => esc_html__('Gutenberg', 'kindlycare'),
                'slug'         => 'gutenberg',
                'required'     => false
            );
        return $list;
    }
}