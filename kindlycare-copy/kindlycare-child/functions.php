<?php
/**
 * Theme sprecific functions and definitions
 */

/* Theme setup section
------------------------------------------------------------------- */

// Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) ) $content_width = 1170; /* pixels */

// Add theme specific actions and filters
// Attention! Function were add theme specific actions and filters handlers must have priority 1
if ( !function_exists( 'kindlycare_theme_setup' ) ) {
	add_action( 'kindlycare_action_before_init_theme', 'kindlycare_theme_setup', 1 );
	function kindlycare_theme_setup() {

        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );

        // Enable support for Post Thumbnails
        add_theme_support( 'post-thumbnails' );

        // Custom header setup
        add_theme_support( 'custom-header', array('header-text'=>false));

        // Custom backgrounds setup
        add_theme_support( 'custom-background');

        // Supported posts formats
        add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'link', 'quote', 'image', 'status', 'aside', 'chat') );

        // Autogenerate title tag
        add_theme_support('title-tag');

        // Add user menu
        add_theme_support('nav-menus');

        // WooCommerce Support
        add_theme_support( 'woocommerce' );

        // Add wide and full blocks support
        add_theme_support( 'align-wide' );

		// Register theme menus
		add_filter( 'kindlycare_filter_add_theme_menus',		'kindlycare_add_theme_menus' );

		// Register theme sidebars
		add_filter( 'kindlycare_filter_add_theme_sidebars',	    'kindlycare_add_theme_sidebars' );

		// Set options for importer
		add_filter( 'kindlycare_filter_importer_options',		'kindlycare_set_importer_options' );

		// Add theme required plugins
		add_filter( 'kindlycare_filter_required_plugins',		'kindlycare_add_required_plugins' );

		// Add theme specified classes into the body
		add_filter( 'body_class', 'kindlycare_body_classes' );

		// Set list of the theme required plugins
		kindlycare_storage_set('required_plugins', array(
			'booked',
			'essgrids',
			'instagram-widget-by-wpzoom',
			'revslider',
			'trx_utils',
			'visual_composer',
			'woocommerce',
            'wordpress-social-login',
            'wp_gdpr_compliance',
            'contact_form_7'
			)
		);

    }
}

// Add page meta to the head
if (!function_exists('kindlycare_head_add_page_meta')) {
    add_action('wp_head', 'kindlycare_head_add_page_meta', 1);
    function kindlycare_head_add_page_meta() {
        $theme_init =  kindlycare_theme_options();
        ?>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1<?php if (kindlycare_get_theme_option('responsive_layouts')=='yes') echo ', maximum-scale=1'; ?>">
        <meta name="format-detection" content="telephone=no">

        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

        <?php
        // Page preloader options
        kindlycare_page_preloader_style_css();

        if ( !function_exists('has_site_icon') || !has_site_icon() ) {
            $favicon = kindlycare_get_custom_option('favicon');
            if (!$favicon) {
                if ( file_exists(kindlycare_get_file_dir('skins/'.($theme_init['theme_skin']).'/images/favicon.ico')) )
                    $favicon = kindlycare_get_file_url('skins/'.($theme_init['theme_skin']).'/images/favicon.ico');
                if ( !$favicon && file_exists(kindlycare_get_file_dir('favicon.ico')) )
                    $favicon = kindlycare_get_file_url('favicon.ico');
            }
            if ($favicon) {
                ?><link rel="icon" type="image/x-icon" href="<?php echo esc_url($favicon); ?>" /><?php
            }
        }

    }
}


// Add/Remove theme nav menus
if ( !function_exists( 'kindlycare_add_theme_menus' ) ) {
	//Handler of add_filter( 'kindlycare_filter_add_theme_menus', 'kindlycare_add_theme_menus' );
	function kindlycare_add_theme_menus($menus) {
		//For example:
		//$menus['menu_footer'] = esc_html__('Footer Menu', 'kindlycare');
		//if (isset($menus['menu_panel'])) unset($menus['menu_panel']);
		return $menus;
	}
}


// Add theme specific widgetized areas
if ( !function_exists( 'kindlycare_add_theme_sidebars' ) ) {
	//Handler of add_filter( 'kindlycare_filter_add_theme_sidebars',	'kindlycare_add_theme_sidebars' );
	function kindlycare_add_theme_sidebars($sidebars=array()) {
		if (is_array($sidebars)) {
			$theme_sidebars = array(
				'sidebar_main'		=> esc_html__( 'Main Sidebar', 'kindlycare' ),
				'sidebar_footer'	=> esc_html__( 'Footer Sidebar', 'kindlycare' )
			);
			if (function_exists('kindlycare_exists_woocommerce') && kindlycare_exists_woocommerce()) {
				$theme_sidebars['sidebar_cart']  = esc_html__( 'WooCommerce Cart Sidebar', 'kindlycare' );
			}
			$sidebars = array_merge($theme_sidebars, $sidebars);
		}
		return $sidebars;
	}
}


// Add theme required plugins
if ( !function_exists( 'kindlycare_add_required_plugins' ) ) {
	//Handler of add_filter( 'kindlycare_filter_required_plugins',		'kindlycare_add_required_plugins' );
	function kindlycare_add_required_plugins($plugins) {
		$plugins[] = array(
			'name' 		=> 'ThemeREX Utilities',
			'version'	=> '3.1',					// Minimal required version
			'slug' 		=> 'trx_utils',
			'source'	=> kindlycare_get_file_dir('plugins/install/trx_utils.zip'),
			'force_activation'   => false,			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
			'force_deactivation' => true,			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
			'required' 	=> true
		);
		return $plugins;
	}
}


// Add theme specified classes into the body
if ( !function_exists('kindlycare_body_classes') ) {
	//Handler of add_filter( 'body_class', 'kindlycare_body_classes' );
	function kindlycare_body_classes( $classes ) {

		$classes[] = 'kindlycare_body';
		$classes[] = 'body_style_' . trim(kindlycare_get_custom_option('body_style'));
		$classes[] = 'body_' . (kindlycare_get_custom_option('body_filled')=='yes' ? 'filled' : 'transparent');
		$classes[] = 'theme_skin_' . trim(kindlycare_get_custom_option('theme_skin'));
		$classes[] = 'article_style_' . trim(kindlycare_get_custom_option('article_style'));
		
		$blog_style = kindlycare_get_custom_option(is_singular() && !kindlycare_storage_get('blog_streampage') ? 'single_style' : 'blog_style');
		$classes[] = 'layout_' . trim($blog_style);
		$classes[] = 'template_' . trim(kindlycare_get_template_name($blog_style));
		
		$body_scheme = kindlycare_get_custom_option('body_scheme');
		if (empty($body_scheme)  || kindlycare_is_inherit_option($body_scheme)) $body_scheme = 'original';
		$classes[] = 'scheme_' . $body_scheme;

		$top_panel_position = kindlycare_get_custom_option('top_panel_position');
		if (!kindlycare_param_is_off($top_panel_position)) {
			$classes[] = 'top_panel_show';
			$classes[] = 'top_panel_' . trim($top_panel_position);
		} else 
			$classes[] = 'top_panel_hide';
		$classes[] = kindlycare_get_sidebar_class();

		if (kindlycare_get_custom_option('show_video_bg')=='yes' && (kindlycare_get_custom_option('video_bg_youtube_code')!='' || kindlycare_get_custom_option('video_bg_url')!=''))
			$classes[] = 'video_bg_show';

		if (kindlycare_get_theme_option('page_preloader')!='')
			$classes[] = 'preloader';

		return $classes;
	}
}


// Theme init
if ( !function_exists( 'kindlycare_theme_init' ) ) {
    function kindlycare_theme_init(){
        kindlycare_core_init_theme();
        kindlycare_profiler_add_point(esc_html__('Before Theme HTML output', 'kindlycare'));
    }
}

// Theme options
if ( !function_exists( 'kindlycare_theme_options' ) ) {
    function kindlycare_theme_options(){

        $theme_init = array();
        $theme_init['theme_skin'] = sanitize_file_name(kindlycare_get_custom_option('theme_skin'));
        $theme_init['body_scheme'] = kindlycare_get_custom_option('body_scheme');
        if (empty($theme_init['body_scheme']) || kindlycare_is_inherit_option($theme_init['body_scheme'])) $theme_init['body_scheme'] = 'original';
        $theme_init['blog_style'] = kindlycare_get_custom_option(is_singular() && !kindlycare_storage_get('blog_streampage') ? 'single_style' : 'blog_style');
        $theme_init['body_style'] = kindlycare_get_custom_option('body_style');
        $theme_init['article_style'] = kindlycare_get_custom_option('article_style');
        $theme_init['top_panel_style'] = kindlycare_get_custom_option('top_panel_style');
        $theme_init['top_panel_position'] = kindlycare_get_custom_option('top_panel_position');
        $theme_init['top_panel_scheme'] = kindlycare_get_custom_option('top_panel_scheme');
        $theme_init['video_bg_show'] = kindlycare_get_custom_option('show_video_bg') == 'yes' && (kindlycare_get_custom_option('video_bg_youtube_code') != '' || kindlycare_get_custom_option('video_bg_url') != '');

        return $theme_init;
    }
}


// Page preloader options
if ( !function_exists( 'kindlycare_page_preloader_style_css' ) ) {
    function kindlycare_page_preloader_style_css()    {
        if (($preloader = kindlycare_get_theme_option('page_preloader')) != '') {
            $clr = kindlycare_get_scheme_color('bg_color');
            ?>
            <style type="text/css">
                <!--
                #page_preloader {
                    background-color: <?php echo esc_attr($clr); ?>;
                    background-image: url(<?php echo esc_url($preloader); ?>);
                    background-position: center;
                    background-repeat: no-repeat;
                    position: fixed;
                    z-index: 1000000;
                    left: 0;
                    top: 0;
                    right: 0;
                    bottom: 0;
                    opacity: 0.8;
                }
                -->
            </style>
            <?php
        }
    }
}


// Add TOC items 'Home' and "To top"
if ( !function_exists( 'kindlycare_add_toc' ) ) {
    function kindlycare_add_toc()    {
        if (kindlycare_get_custom_option('menu_toc_home')=='yes' && function_exists('kindlycare_sc_anchor'))
            kindlycare_show_layout(kindlycare_sc_anchor(array(
                    'id' => "toc_home",
                    'title' => esc_html__('Home', 'kindlycare'),
                    'description' => esc_html__('{{Return to Home}} - ||navigate to home page of the site', 'kindlycare'),
                    'icon' => "icon-home",
                    'separator' => "yes",
                    'url' => esc_url(home_url('/'))
                )
            ));
        if (kindlycare_get_custom_option('menu_toc_top')=='yes' && function_exists('kindlycare_sc_anchor'))
            kindlycare_show_layout(kindlycare_sc_anchor(array(
                    'id' => "toc_top",
                    'title' => esc_html__('To Top', 'kindlycare'),
                    'description' => esc_html__('{{Back to top}} - ||scroll to top of the page', 'kindlycare'),
                    'icon' => "icon-double-up",
                    'separator' => "yes")
            ));
    }
}


// Set theme specific importer options
if ( !function_exists( 'kindlycare_set_importer_options' ) ) {
	//Handler of add_filter( 'kindlycare_filter_importer_options',	'kindlycare_set_importer_options' );
	function kindlycare_set_importer_options($options=array()) {
		if (is_array($options)) {
			$options['menus'] = array(
				'menu-main'	  => esc_html__('Main menu',    'kindlycare'),
				'menu-user'	  => esc_html__('User menu',    'kindlycare'),
				'menu-footer' => esc_html__('Footer menu',  'kindlycare'),
				'menu-outer'  => esc_html__('Main menu',    'kindlycare')
			);

            // Default demo
            $options['demo_url'] = kindlycare_storage_get('demo_data_url');
            $options['files']['default']['title'] = esc_html__('KindlyCare Demo', 'kindlycare');
            $options['files']['default']['domain_dev'] = '';																	    // Developers domain
            $options['files']['default']['domain_demo']= esc_url(kindlycare_get_protocol().'://kindlycare.ancorathemes.com');	    // Demo-site domain


        }
		return $options;
	}
}

//------------------------------------------------------------------------
// One-click import support
//------------------------------------------------------------------------

// Set theme specific importer options
if ( ! function_exists( 'kindlycare_importer_set_options' ) ) {
    add_filter( 'trx_utils_filter_importer_options', 'kindlycare_importer_set_options', 9 );
    function kindlycare_importer_set_options( $options=array() ) {
        if ( is_array( $options ) ) {
            // Save or not installer's messages to the log-file
            $options['debug'] = false;
            // Prepare demo data
            if ( is_dir( KINDLYCARE_THEME_PATH . 'demo/' ) ) {
                $options['demo_url'] = KINDLYCARE_THEME_PATH . 'demo/';
            } else {
                $options['demo_url'] = esc_url( kindlycare_get_protocol().'://demofiles.ancorathemes.com/kindlycare/' ); // Demo-site domain
            }

            // Required plugins
            $options['required_plugins'] =  array(
                'booked',
                'essential-grid',
                'instagram_widget_by_wpzoom',
                'revslider',
                'trx_utils',
                'js_composer',
                'woocommerce',
                'contact-form-7',
                'wordpress-social-login'
            );

            $options['theme_slug'] = 'kindlycare';

            // Set number of thumbnails to regenerate when its imported (if demo data was zipped without cropped images)
            // Set 0 to prevent regenerate thumbnails (if demo data archive is already contain cropped images)
            $options['regenerate_thumbnails'] = 3;
            // Default demo
            $options['files']['default']['title'] = esc_html__( 'Education Demo', 'kindlycare' );
            $options['files']['default']['domain_dev'] = esc_url(kindlycare_get_protocol().'://kindlycare.dv.ancorathemes.com'); // Developers domain
            $options['files']['default']['domain_demo']= esc_url(kindlycare_get_protocol().'://kindlycare.ancorathemes.com'); // Demo-site domain

        }
        return $options;
    }
}

// Add theme required plugins
if ( !function_exists( 'kindlycare_add_trx_utils' ) ) {
    add_filter( 'trx_utils_active', 'kindlycare_add_trx_utils' );
    function kindlycare_add_trx_utils($enable=true) {
        return true;
    }
}

//remove_filter( 'lostpassword_url', 'wc_lostpassword_url', 10, 1 );

/* Include framework core files
------------------------------------------------------------------- */
// If now is WP Heartbeat call - skip loading theme core files (to reduce server and DB uploads)
// Remove comments below only if your theme not work with own post types and/or taxonomies
//if (!isset($_POST['action']) || $_POST['action']!="heartbeat") {
	get_template_part('fw/loader');
//}
?>