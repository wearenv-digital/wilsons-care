<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('kindlycare_booked_theme_setup')) {
	add_action( 'kindlycare_action_before_init_theme', 'kindlycare_booked_theme_setup', 1 );
	function kindlycare_booked_theme_setup() {
		// Register shortcode in the shortcodes list
		if (kindlycare_exists_booked()) {
			add_action('kindlycare_action_add_styles', 					'kindlycare_booked_frontend_scripts');
			add_action('kindlycare_action_shortcodes_list',				'kindlycare_booked_reg_shortcodes');
			if (function_exists('kindlycare_exists_visual_composer') && kindlycare_exists_visual_composer())
				add_action('kindlycare_action_shortcodes_list_vc',		'kindlycare_booked_reg_shortcodes_vc');
			if (is_admin()) {
				add_filter( 'kindlycare_filter_importer_options',			'kindlycare_booked_importer_set_options' );
			}
		}
		if (is_admin()) {
			add_filter( 'kindlycare_filter_importer_required_plugins',	'kindlycare_booked_importer_required_plugins', 10, 2);
			add_filter( 'kindlycare_filter_required_plugins',				'kindlycare_booked_required_plugins' );
		}
	}
}


// Check if plugin installed and activated
if ( !function_exists( 'kindlycare_exists_booked' ) ) {
	function kindlycare_exists_booked() {
		return class_exists('booked_plugin');
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'kindlycare_booked_required_plugins' ) ) {
    //Handler of add_filter('kindlycare_filter_required_plugins',    'kindlycare_booked_required_plugins');
    function kindlycare_booked_required_plugins($list=array()) {
        if (in_array('booked', (array)kindlycare_storage_get('required_plugins'))) {
            $path = kindlycare_get_file_dir('plugins/install/booked.zip');
            if (!empty($path) && file_exists($path)) {
                $list[] = array(
                    'name'         => esc_html__('Booked', 'kindlycare'),
                    'slug'         => 'booked',
                    'source'    => $path,
                    'required'     => false
                );
            }
            $path = kindlycare_get_file_dir( 'plugins/install/booked-calendar-feeds.zip' );
            if ( !empty($path) && file_exists($path) ) {
                $list[] = array(
                    'name'     => esc_html__( 'Booked Calendar Feeds', 'kindlycare' ),
                    'slug'     => 'booked-calendar-feeds',
                    'source'   => $path,
                    'version'  => '1.1.5',
                    'required' => false,
                );
            }
            $path = kindlycare_get_file_dir( 'plugins/install/booked-frontend-agents.zip' );
            if ( !empty($path) && file_exists($path) ) {
                $list[] = array(
                    'name'     => esc_html__( 'Booked Front-End Agents', 'kindlycare' ),
                    'slug'     => 'booked-frontend-agents',
                    'source'   => $path,
                    'version'  => '1.1.15',
                    'required' => false,
                );
            }
            $path = kindlycare_get_file_dir( 'plugins/install/booked-woocommerce-payments.zip' );
            if ( !empty($path) && file_exists($path) ) {
                $list[] = array(
                    'name'     => esc_html__( 'WooCommerce addons - Booked Payments with WooCommerce', 'kindlycare' ),
                    'slug'     => 'booked-woocommerce-payments',
                    'source'   => $path,
                    'version'  => '1.4.9',
                    'required' => false,
                );
            }
        }
        return $list;
    }
}

// Enqueue custom styles
if ( !function_exists( 'kindlycare_booked_frontend_scripts' ) ) {
	//Handler of add_action( 'kindlycare_action_add_styles', 'kindlycare_booked_frontend_scripts' );
	function kindlycare_booked_frontend_scripts() {
		if (file_exists(kindlycare_get_file_dir('css/plugin.booked.css')))
			wp_enqueue_style( 'kindlycare-plugin.booked-style',  kindlycare_get_file_url('css/plugin.booked.css'), array(), null );
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check in the required plugins
if ( !function_exists( 'kindlycare_booked_importer_required_plugins' ) ) {
	//Handler of add_filter( 'kindlycare_filter_importer_required_plugins',	'kindlycare_booked_importer_required_plugins', 10, 2);
	function kindlycare_booked_importer_required_plugins($not_installed='', $list='') {
		//if (in_array('booked', kindlycare_storage_get('required_plugins')) && !kindlycare_exists_booked() )
		if (kindlycare_strpos($list, 'booked')!==false && !kindlycare_exists_booked() )
			$not_installed .= '<br>Booked Appointments';
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'kindlycare_booked_importer_set_options' ) ) {
	//Handler of add_filter( 'kindlycare_filter_importer_options',	'kindlycare_booked_importer_set_options', 10, 1 );
	function kindlycare_booked_importer_set_options($options=array()) {
		if (in_array('booked', kindlycare_storage_get('required_plugins')) && kindlycare_exists_booked()) {
			$options['additional_options'][] = 'booked_%';		// Add slugs to export options for this plugin
		}
		return $options;
	}
}


// Lists
//------------------------------------------------------------------------

// Return booked calendars list, prepended inherit (if need)
if ( !function_exists( 'kindlycare_get_list_booked_calendars' ) ) {
	function kindlycare_get_list_booked_calendars($prepend_inherit=false) {
		return kindlycare_exists_booked() ? kindlycare_get_list_terms($prepend_inherit, 'booked_custom_calendars') : array();
	}
}



// Register plugin's shortcodes
//------------------------------------------------------------------------

// Register shortcode in the shortcodes list
if (!function_exists('kindlycare_booked_reg_shortcodes')) {
	//Handler of add_filter('kindlycare_action_shortcodes_list',	'kindlycare_booked_reg_shortcodes');
	function kindlycare_booked_reg_shortcodes() {
		if (kindlycare_storage_isset('shortcodes')) {

			$booked_cals = kindlycare_get_list_booked_calendars();

			kindlycare_sc_map('booked-appointments', array(
				"title" => esc_html__("Booked Appointments", 'kindlycare'),
				"desc" => esc_html__("Display the currently logged in user's upcoming appointments", 'kindlycare'),
				"decorate" => true,
				"container" => false,
				"params" => array()
				)
			);

			kindlycare_sc_map('booked-calendar', array(
				"title" => esc_html__("Booked Calendar", 'kindlycare'),
				"desc" => esc_html__("Insert booked calendar", 'kindlycare'),
				"decorate" => true,
				"container" => false,
				"params" => array(
					"calendar" => array(
						"title" => esc_html__("Calendar", 'kindlycare'),
						"desc" => esc_html__("Select booked calendar to display", 'kindlycare'),
						"value" => "0",
						"type" => "select",
						"options" => kindlycare_array_merge(array(0 => esc_html__('- Select calendar -', 'kindlycare')), $booked_cals)
					),
					"year" => array(
						"title" => esc_html__("Year", 'kindlycare'),
						"desc" => esc_html__("Year to display on calendar by default", 'kindlycare'),
						"value" => date("Y"),
						"min" => date("Y"),
						"max" => date("Y")+10,
						"type" => "spinner"
					),
					"month" => array(
						"title" => esc_html__("Month", 'kindlycare'),
						"desc" => esc_html__("Month to display on calendar by default", 'kindlycare'),
						"value" => date("m"),
						"min" => 1,
						"max" => 12,
						"type" => "spinner"
					)
				)
			));
		}
	}
}


// Register shortcode in the VC shortcodes list
if (!function_exists('kindlycare_booked_reg_shortcodes_vc')) {
	//Handler of add_filter('kindlycare_action_shortcodes_list_vc',	'kindlycare_booked_reg_shortcodes_vc');
	function kindlycare_booked_reg_shortcodes_vc() {

		$booked_cals = kindlycare_get_list_booked_calendars();

		// Booked Appointments
		vc_map( array(
				"base" => "booked-appointments",
				"name" => esc_html__("Booked Appointments", 'kindlycare'),
				"description" => esc_html__("Display the currently logged in user's upcoming appointments", 'kindlycare'),
				"category" => esc_html__('Content', 'kindlycare'),
				'icon' => 'icon_trx_booked',
				"class" => "trx_sc_single trx_sc_booked_appointments",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array()
			) );
			
		class WPBakeryShortCode_Booked_Appointments extends KINDLYCARE_VC_ShortCodeSingle {}

		// Booked Calendar
		vc_map( array(
				"base" => "booked-calendar",
				"name" => esc_html__("Booked Calendar", 'kindlycare'),
				"description" => esc_html__("Insert booked calendar", 'kindlycare'),
				"category" => esc_html__('Content', 'kindlycare'),
				'icon' => 'icon_trx_booked',
				"class" => "trx_sc_single trx_sc_booked_calendar",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "calendar",
						"heading" => esc_html__("Calendar", 'kindlycare'),
						"description" => esc_html__("Select booked calendar to display", 'kindlycare'),
						"admin_label" => true,
						"class" => "",
						"std" => "0",
						"value" => array_flip(kindlycare_array_merge(array(0 => esc_html__('- Select calendar -', 'kindlycare')), $booked_cals)),
						"type" => "dropdown"
					),
					array(
						"param_name" => "year",
						"heading" => esc_html__("Year", 'kindlycare'),
						"description" => esc_html__("Year to display on calendar by default", 'kindlycare'),
						"admin_label" => true,
						"class" => "",
						"std" => date("Y"),
						"value" => date("Y"),
						"type" => "textfield"
					),
					array(
						"param_name" => "month",
						"heading" => esc_html__("Month", 'kindlycare'),
						"description" => esc_html__("Month to display on calendar by default", 'kindlycare'),
						"admin_label" => true,
						"class" => "",
						"std" => date("m"),
						"value" => date("m"),
						"type" => "textfield"
					)
				)
			) );
			
		class WPBakeryShortCode_Booked_Calendar extends KINDLYCARE_VC_ShortCodeSingle {}

	}
}
?>