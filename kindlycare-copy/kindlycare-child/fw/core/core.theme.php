<?php
/**
 * KindlyCare Framework: Theme specific actions
 *
 * @package	kindlycare
 * @since	kindlycare 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'kindlycare_core_theme_setup' ) ) {
	add_action( 'kindlycare_action_before_init_theme', 'kindlycare_core_theme_setup', 11 );
	function kindlycare_core_theme_setup() {


		
		// Editor custom stylesheet - for user
		add_editor_style(kindlycare_get_file_url('css/editor-style.css'));	
		
		// Make theme available for translation
		// Translations can be filed in the /languages directory
		load_theme_textdomain( 'kindlycare', kindlycare_get_folder_dir('languages') );


		/* Front and Admin actions and filters:
		------------------------------------------------------------------------ */

		if ( !is_admin() ) {
			
			/* Front actions and filters:
			------------------------------------------------------------------------ */
	
			// Filters wp_title to print a neat <title> tag based on what is being viewed
			if (floatval(get_bloginfo('version')) < "4.1") {
				add_action('wp_head',						'kindlycare_wp_title_show');
				add_filter('wp_title',						'kindlycare_wp_title_modify', 10, 2);
			}

			// Add main menu classes
			//Handler of add_filter('wp_nav_menu_objects', 			'kindlycare_add_mainmenu_classes', 10, 2);
	
			// Prepare logo text
			add_filter('kindlycare_filter_prepare_logo_text',	'kindlycare_prepare_logo_text', 10, 1);
	
			// Add class "widget_number_#' for each widget
			add_filter('dynamic_sidebar_params', 			'kindlycare_add_widget_number', 10, 1);
	
			// Enqueue scripts and styles
			add_action('wp_enqueue_scripts', 				'kindlycare_core_frontend_scripts');
			add_action('wp_footer',		 					'kindlycare_core_frontend_scripts_inline', 9);
			add_filter('kindlycare_action_add_scripts_inline','kindlycare_core_add_scripts_inline');

			// Prepare theme core global variables
			add_action('kindlycare_action_prepare_globals',	'kindlycare_core_prepare_globals');
		}

		// Frontend editor: Save post data
		add_action('wp_ajax_frontend_editor_save',		'kindlycare_callback_frontend_editor_save');


		// Frontend editor: Delete post
		add_action('wp_ajax_frontend_editor_delete', 	'kindlycare_callback_frontend_editor_delete');


		// Register theme specific nav menus
		kindlycare_register_theme_menus();

		// Register theme specific sidebars
		kindlycare_register_theme_sidebars();
	}
}




/* Theme init
------------------------------------------------------------------------ */

// Init theme template
function kindlycare_core_init_theme() {
	if (kindlycare_storage_get('theme_inited')===true) return;
	kindlycare_storage_set('theme_inited', true);

	if (!is_admin()) kindlycare_profiler_add_point(esc_html__('After WP INIT actions', 'kindlycare'), false);

	// Load custom options from GET and post/page/cat options
	if (isset($_GET['set']) && $_GET['set']==1) {
		foreach ($_GET as $k=>$v) {
			if (kindlycare_get_theme_option($k, null) !== null) {
				setcookie($k, $v, 0, '/');
				$_COOKIE[$k] = $v;
			}
		}
	}

	// Get custom options from current category / page / post / shop / event
	kindlycare_load_custom_options();

	// Load skin
	$skin = sanitize_file_name(kindlycare_get_custom_option('theme_skin'));
	kindlycare_storage_set('theme_skin', $skin);
	if ( file_exists(kindlycare_get_file_dir('skins/'.($skin).'/skin.php')) ) {
		get_template_part(kindlycare_get_file_slug('skins/'.($skin).'/skin.php'));
	}

	// Fire init theme actions (after skin and custom options are loaded)
	do_action('kindlycare_action_init_theme');

	// Prepare theme core global variables
	do_action('kindlycare_action_prepare_globals');

	// Fire after init theme actions
	do_action('kindlycare_action_after_init_theme');
	kindlycare_profiler_add_point(esc_html__('After Theme Init', 'kindlycare'));
}


// Prepare theme global variables
if ( !function_exists( 'kindlycare_core_prepare_globals' ) ) {
	function kindlycare_core_prepare_globals() {
		if (!is_admin()) {
			// Logo text and slogan
			kindlycare_storage_set('logo_text', apply_filters('kindlycare_filter_prepare_logo_text', kindlycare_get_custom_option('logo_text')));
			kindlycare_storage_set('logo_slogan', get_bloginfo('description'));
			
			// Logo image and icons from skin
			$logo        = kindlycare_get_logo_icon('logo');
			$logo_side   = kindlycare_get_logo_icon('logo_side');
			$logo_fixed  = kindlycare_get_logo_icon('logo_fixed');
			$logo_footer = kindlycare_get_logo_icon('logo_footer');
			kindlycare_storage_set('logo', $logo);
			kindlycare_storage_set('logo_icon',   kindlycare_get_logo_icon('logo_icon'));
			kindlycare_storage_set('logo_side',   $logo_side   ? $logo_side   : $logo);
			kindlycare_storage_set('logo_fixed',  $logo_fixed  ? $logo_fixed  : $logo);
			kindlycare_storage_set('logo_footer', $logo_footer ? $logo_footer : $logo);
	
			$shop_mode = '';
			if (kindlycare_get_custom_option('show_mode_buttons')=='yes')
				$shop_mode = kindlycare_get_value_gpc('kindlycare_shop_mode');
			if (empty($shop_mode))
				$shop_mode = kindlycare_get_custom_option('shop_mode', '');
			if (empty($shop_mode) || !is_archive())
				$shop_mode = 'thumbs';
			kindlycare_storage_set('shop_mode', $shop_mode);
		}
	}
}


// Return url for the uploaded logo image or (if not uploaded) - to image from skin folder
if ( !function_exists( 'kindlycare_get_logo_icon' ) ) {
	function kindlycare_get_logo_icon($slug) {
		$mult = kindlycare_get_retina_multiplier();
		$logo_icon = '';
		if ($mult > 1) 			$logo_icon = kindlycare_get_custom_option($slug.'_retina');
		if (empty($logo_icon))	$logo_icon = kindlycare_get_custom_option($slug);
		return $logo_icon;
	}
}


// Display logo image with text and slogan (if specified)
if ( !function_exists( 'kindlycare_show_logo' ) ) {
	function kindlycare_show_logo($logo_main=true, $logo_fixed=false, $logo_footer=false, $logo_side=false, $logo_text=true, $logo_slogan=true) {
		if ($logo_main===true)		$logo_main   = kindlycare_storage_get('logo');
		if ($logo_fixed===true)		$logo_fixed  = kindlycare_storage_get('logo_fixed');
		if ($logo_footer===true)	$logo_footer = kindlycare_storage_get('logo_footer');
		if ($logo_side===true)		$logo_side   = kindlycare_storage_get('logo_side');
		if ($logo_text===true)		$logo_text   = kindlycare_storage_get('logo_text');
		if ($logo_slogan===true)	$logo_slogan = kindlycare_storage_get('logo_slogan');
		if ($logo_main || $logo_fixed || $logo_footer || $logo_side || $logo_text) {
		?>
		<div class="logo">
			<a href="<?php echo esc_url(home_url('/')); ?>"><?php
				if (!empty($logo_main)) {
					$attr = kindlycare_getimagesize($logo_main);
                    $alt = basename($logo_main);
                    $alt = substr($alt,0,strlen($alt) - 4);
                    echo '<img src="'.esc_url($logo_main).'" class="logo_main" alt="'.esc_html($alt).'"'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
				}
				if (!empty($logo_fixed)) {
					$attr = kindlycare_getimagesize($logo_fixed);
                    $alt = basename($logo_fixed);
                    $alt = substr($alt,0,strlen($alt) - 4);
					echo '<img src="'.esc_url($logo_fixed).'" class="logo_fixed" alt="'.esc_html($alt).'"'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
				}
				if (!empty($logo_footer)) {
					$attr = kindlycare_getimagesize($logo_footer);
                    $alt = basename($logo_footer);
                    $alt = substr($alt,0,strlen($alt) - 4);
					echo '<img src="'.esc_url($logo_footer).'" class="logo_footer" alt="'.esc_html($alt).'"'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
				}
				if (!empty($logo_side)) {
					$attr = kindlycare_getimagesize($logo_side);
                    $alt = basename($logo_side);
                    $alt = substr($alt,0,strlen($alt) - 4);
					echo '<img src="'.esc_url($logo_side).'" class="logo_side" alt="'.esc_html($alt).'"'.(!empty($attr[3]) ? ' '.trim($attr[3]) : '').'>';
				}
				echo !empty($logo_text) ? '<div class="logo_text">'.trim($logo_text).'</div>' : '';
				echo !empty($logo_slogan) ? '<br><div class="logo_slogan">' . esc_html($logo_slogan) . '</div>' : '';
			?></a>
		</div>
		<?php 
		}
	} 
}


// Add menu locations
if ( !function_exists( 'kindlycare_register_theme_menus' ) ) {
	function kindlycare_register_theme_menus() {
		register_nav_menus(apply_filters('kindlycare_filter_add_theme_menus', array(
			'menu_main'		=> esc_html__('Main Menu', 'kindlycare'),
			'menu_user'		=> esc_html__('User Menu', 'kindlycare'),
			'menu_footer'	=> esc_html__('Footer Menu', 'kindlycare'),
			'menu_side'		=> esc_html__('Side Menu', 'kindlycare')
		)));
	}
}


// Register widgetized area
if ( !function_exists( 'kindlycare_register_theme_sidebars' ) ) {
    add_action('widgets_init', 'kindlycare_register_theme_sidebars');
    function kindlycare_register_theme_sidebars($sidebars=array()) {
        if (!is_array($sidebars)) $sidebars = array();
        // Custom sidebars
        $custom = kindlycare_get_theme_option('custom_sidebars');
        if (is_array($custom) && count($custom) > 0) {
            foreach ($custom as $i => $sb) {
                if (trim(chop($sb))=='') continue;
                $sidebars['sidebar_custom_'.($i)]  = $sb;
            }
        }
        $sidebars = apply_filters( 'kindlycare_filter_add_theme_sidebars', $sidebars );
        $registered = kindlycare_storage_get('registered_sidebars');
        if (!is_array($registered)) $registered = array();
        if (is_array($sidebars) && count($sidebars) > 0) {
            foreach ($sidebars as $id=>$name) {
                if (isset($registered[$id])) continue;
                $registered[$id] = $name;
                register_sidebar( array_merge( array(
                        'name'          => $name,
                        'id'            => $id
                    ),
                        kindlycare_storage_get('widgets_args')
                    )
                );
            }
        }
        kindlycare_storage_set('registered_sidebars', $registered);
    }
}





/* Front actions and filters:
------------------------------------------------------------------------ */

//  Enqueue scripts and styles
if ( !function_exists( 'kindlycare_core_frontend_scripts' ) ) {
	function kindlycare_core_frontend_scripts() {
		
		// Modernizr will load in head before other scripts and styles
		// Use older version (from photostack)
		wp_enqueue_script( 'modernizr', kindlycare_get_file_url('js/photostack/modernizr.min.js'), array(), null, false );
		
		// Enqueue styles
		//-----------------------------------------------------------------------------------------------------
		
		// Prepare custom fonts
		$fonts = kindlycare_get_list_fonts(false);
		$theme_fonts = array();
		$custom_fonts = kindlycare_get_custom_fonts();
		if (is_array($custom_fonts) && count($custom_fonts) > 0) {
			foreach ($custom_fonts as $s=>$f) {
				if (!empty($f['font-family']) && !kindlycare_is_inherit_option($f['font-family'])) $theme_fonts[$f['font-family']] = 1;
			}
		}
		// Prepare current skin fonts
		$theme_fonts = apply_filters('kindlycare_filter_used_fonts', $theme_fonts);
		// Link to selected fonts
		if (is_array($theme_fonts) && count($theme_fonts) > 0) {
			$google_fonts = '';
			foreach ($theme_fonts as $font=>$v) {
				if (isset($fonts[$font])) {
					$font_name = ($pos=kindlycare_strpos($font,' ('))!==false ? kindlycare_substr($font, 0, $pos) : $font;
					if (!empty($fonts[$font]['css'])) {
						$css = $fonts[$font]['css'];
						wp_enqueue_style( 'kindlycare-font-'.str_replace(' ', '-', $font_name).'-style', $css, array(), null );
					} else {
                        // Attention! Using '%7C' instead '|' damage loading second+ fonts
                        $google_fonts .= ($google_fonts ? '|' : '')
							. (!empty($fonts[$font]['link']) ? $fonts[$font]['link'] : str_replace(' ', '+', $font_name).':300,300italic,400,400italic,700,700italic');
					}
				}
			}
            if ($google_fonts) {
                /*
                Translators: If there are characters in your language that are not supported
                by chosen font(s), translate this to 'off'. Do not translate into your own language.
                */
                $google_fonts_enabled = ( 'off' !== _x( 'on', 'Google fonts: on or off', 'kindlycare' ) );
                if ( $google_fonts_enabled ) {
                    wp_enqueue_style( 'kindlycare-font-google_fonts-style', add_query_arg( 'family', $google_fonts . '&subset=' . kindlycare_get_theme_option('fonts_subset'), "//fonts.googleapis.com/css" ), array(), null );

                }
            }
		}
		
		// Fontello styles must be loaded before main stylesheet
		wp_enqueue_style( 'fontello-style',  kindlycare_get_file_url('css/fontello/css/fontello.css'),  array(), null);
		//wp_enqueue_style( 'kindlycare-fontello-animation-style', kindlycare_get_file_url('css/fontello/css/animation.css'), array(), null);

		// Main stylesheet
		wp_enqueue_style( 'kindlycare-main-style', get_stylesheet_uri(), array(), null );
		
		// Animations
		if (kindlycare_get_theme_option('css_animation')=='yes' && (kindlycare_get_theme_option('animation_on_mobile')=='yes' || !wp_is_mobile()) && !kindlycare_vc_is_frontend())
			wp_enqueue_style( 'kindlycare-animation-style',	kindlycare_get_file_url('css/core.animation.css'), array(), null );

		// Theme skin stylesheet
		do_action('kindlycare_action_add_styles');
		
		// Theme customizer stylesheet and inline styles
		kindlycare_enqueue_custom_styles();

		// Responsive
		if (kindlycare_get_theme_option('responsive_layouts') == 'yes') {
			$suffix = kindlycare_param_is_off(kindlycare_get_custom_option('show_sidebar_outer')) ? '' : '-outer';
			wp_enqueue_style( 'kindlycare-responsive-style', kindlycare_get_file_url('css/responsive'.($suffix).'.css'), array(), null );
			do_action('kindlycare_action_add_responsive');
			if (kindlycare_get_custom_option('theme_skin')!='') {
				$css = apply_filters('kindlycare_filter_add_responsive_inline', '');
				if (!empty($css)) wp_add_inline_style( 'kindlycare-responsive-style', $css );
			}
		}

		// Disable loading JQuery UI CSS
		//global $wp_styles, $wp_scripts;
		//$wp_styles->done[]	= 'jquery-ui';
		//$wp_styles->done[]	= 'date-picker-css';
		wp_deregister_style('jquery_ui');
		wp_deregister_style('date-picker-css');


		// Enqueue scripts	
		//----------------------------------------------------------------------------------------------------------------------------
		
		// Load separate theme scripts
		wp_enqueue_script( 'superfish', kindlycare_get_file_url('js/superfish.js'), array('jquery'), null, true );
		if (kindlycare_get_theme_option('menu_slider')=='yes') {
			wp_enqueue_script( 'kindlycare-slidemenu-script', kindlycare_get_file_url('js/jquery.slidemenu.js'), array('jquery'), null, true );
			//wp_enqueue_script( 'kindlycare-jquery-easing-script', kindlycare_get_file_url('js/jquery.easing.js'), array('jquery'), null, true );
		}

		if ( is_single() && kindlycare_get_custom_option('show_reviews')=='yes' ) {
			wp_enqueue_script( 'kindlycare-core-reviews-script', kindlycare_get_file_url('js/core.reviews.js'), array('jquery'), null, true );
		}

		wp_enqueue_script( 'kindlycare-core-utils-script',	kindlycare_get_file_url('js/core.utils.js'), array('jquery'), null, true );
		wp_enqueue_script( 'kindlycare-core-init-script',	kindlycare_get_file_url('js/core.init.js'), array('jquery'), null, true );
		wp_enqueue_script( 'kindlycare-theme-init-script',	kindlycare_get_file_url('js/theme.init.js'), array('jquery'), null, true );

		// Media elements library	
		if (kindlycare_get_theme_option('use_mediaelement')=='yes') {
			wp_enqueue_style ( 'mediaelement' );
			wp_enqueue_style ( 'wp-mediaelement' );
			wp_enqueue_script( 'mediaelement' );
			wp_enqueue_script( 'wp-mediaelement' );
		} else {
			wp_deregister_style('mediaelement');
			wp_deregister_style('wp-mediaelement');
		}
		
		// Video background
		if (kindlycare_get_custom_option('show_video_bg') == 'yes' && kindlycare_get_custom_option('video_bg_youtube_code') != '') {
			wp_enqueue_script( 'video-bg-script', kindlycare_get_file_url('js/jquery.tubular.1.0.js'), array('jquery'), null, true );
		}

		// Google map
		if ( kindlycare_get_custom_option('show_googlemap')=='yes' ) {
            $api_key = kindlycare_get_theme_option('api_google');
            wp_enqueue_script( 'googlemap', kindlycare_get_protocol().'://maps.google.com/maps/api/js'.($api_key ? '?key='.$api_key : ''), array(), null, true );
			wp_enqueue_script( 'kindlycare-googlemap-script', kindlycare_get_file_url('js/core.googlemap.js'), array(), null, true );
		}

			
		// Social share buttons
		if (is_singular() && !kindlycare_storage_get('blog_streampage') && kindlycare_get_custom_option('show_share')!='hide') {
			wp_enqueue_script( 'kindlycare-social-share-script', kindlycare_get_file_url('js/social/social-share.js'), array('jquery'), null, true );
		}

		// Comments
		if ( is_singular() && !kindlycare_storage_get('blog_streampage') && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply', false, array(), null, true );
		}

		// Custom panel
		if (kindlycare_get_theme_option('show_theme_customizer') == 'yes') {
			if (file_exists(kindlycare_get_file_dir('core/core.customizer/front.customizer.css')))
				wp_enqueue_style(  'kindlycare-customizer-style',  kindlycare_get_file_url('core/core.customizer/front.customizer.css'), array(), null );
			if (file_exists(kindlycare_get_file_dir('core/core.customizer/front.customizer.js')))
				wp_enqueue_script( 'kindlycare-customizer-script', kindlycare_get_file_url('core/core.customizer/front.customizer.js'), array(), null, true );
		}
		
		//Debug utils
		if (kindlycare_get_theme_option('debug_mode')=='yes') {
			wp_enqueue_script( 'kindlycare-core-debug-script', kindlycare_get_file_url('js/core.debug.js'), array(), null, true );
		}

		// Theme skin script
		do_action('kindlycare_action_add_scripts');
	}
}

//  Enqueue Swiper Slider scripts and styles
if ( !function_exists( 'kindlycare_enqueue_slider' ) ) {
	function kindlycare_enqueue_slider($engine='all') {
		if ($engine=='all' || $engine=='swiper') {
			wp_enqueue_style(  'swiperslider-style', 			kindlycare_get_file_url('js/swiper/swiper.css'), array(), null );
			wp_enqueue_script( 'swiperslider-script', 			kindlycare_get_file_url('js/swiper/swiper.js'), array(), null, true );
			// jQuery version conflict with Revolution Slider
			//wp_enqueue_script( 'kindlycare-swiperslider-script', 			kindlycare_get_file_url('js/swiper/swiper.jquery.js'), array(), null, true );
		}
	}
}

//  Enqueue Photostack gallery
if ( !function_exists( 'kindlycare_enqueue_polaroid' ) ) {
	function kindlycare_enqueue_polaroid() {
		wp_enqueue_style(  'polaroid-style', 	kindlycare_get_file_url('js/photostack/component.css'), array(), null );
		wp_enqueue_script( 'classie-script',		kindlycare_get_file_url('js/photostack/classie.js'), array(), null, true );
		wp_enqueue_script( 'polaroid-script',	kindlycare_get_file_url('js/photostack/photostack.js'), array(), null, true );
	}
}

//  Enqueue Messages scripts and styles
if ( !function_exists( 'kindlycare_enqueue_messages' ) ) {
	function kindlycare_enqueue_messages() {
		wp_enqueue_style(  'kindlycare-messages-style',		kindlycare_get_file_url('js/core.messages/core.messages.css'), array(), null );
		wp_enqueue_script( 'kindlycare-messages-script',	kindlycare_get_file_url('js/core.messages/core.messages.js'),  array('jquery'), null, true );
	}
}

//  Enqueue Portfolio hover scripts and styles
if ( !function_exists( 'kindlycare_enqueue_portfolio' ) ) {
	function kindlycare_enqueue_portfolio($hover='') {
		wp_enqueue_style( 'kindlycare-portfolio-style',  kindlycare_get_file_url('css/core.portfolio.css'), array(), null );
		if (kindlycare_strpos($hover, 'effect_dir')!==false)
			wp_enqueue_script( 'hoverdir', kindlycare_get_file_url('js/hover/jquery.hoverdir.js'), array(), null, true );
	}
}

//  Enqueue Charts and Diagrams scripts and styles
if ( !function_exists( 'kindlycare_enqueue_diagram' ) ) {
	function kindlycare_enqueue_diagram($type='all') {
		if ($type=='all' || $type=='pie') wp_enqueue_script( 'kindlycare-diagram-chart-script',	kindlycare_get_file_url('js/diagram/chart.min.js'), array(), null, true );
		if ($type=='all' || $type=='arc') wp_enqueue_script( 'kindlycare-diagram-raphael-script',	kindlycare_get_file_url('js/diagram/diagram.raphael.min.js'), array(), 'no-compose', true );
	}
}

// Enqueue Theme Popup scripts and styles
// Link must have attribute: data-rel="popup" or data-rel="popup[gallery]"
if ( !function_exists( 'kindlycare_enqueue_popup' ) ) {
	function kindlycare_enqueue_popup($engine='') {
		if ($engine=='pretty' || (empty($engine) && kindlycare_get_theme_option('popup_engine')=='pretty')) {
			wp_enqueue_style(  'prettyphoto-style',	kindlycare_get_file_url('js/prettyphoto/css/prettyPhoto.css'), array(), null );
			wp_enqueue_script( 'prettyphoto-script',	kindlycare_get_file_url('js/prettyphoto/jquery.prettyPhoto.min.js'), array('jquery'), 'no-compose', true );
		} else if ($engine=='magnific' || (empty($engine) && kindlycare_get_theme_option('popup_engine')=='magnific')) {
			wp_enqueue_style(  'magnific-style',	kindlycare_get_file_url('js/magnific/magnific-popup.css'), array(), null );
			wp_enqueue_script( 'magnific-script',kindlycare_get_file_url('js/magnific/jquery.magnific-popup.min.js'), array('jquery'), '', true );
		} else if ($engine=='internal' || (empty($engine) && kindlycare_get_theme_option('popup_engine')=='internal')) {
			kindlycare_enqueue_messages();
		}
	}
}

//  Add inline scripts in the footer hook
if ( !function_exists( 'kindlycare_core_frontend_scripts_inline' ) ) {
    //Handler of add_action('wp_footer', 'kindlycare_core_frontend_scripts_inline', 9);
    function kindlycare_core_frontend_scripts_inline() {
        $vars = kindlycare_storage_get('js_vars');
        if (empty($vars) || !is_array($vars)) $vars = array();
        wp_localize_script('kindlycare-core-init-script', 'KINDLYCARE_STORAGE', apply_filters('kindlycare_action_add_scripts_inline', $vars));
        $code = kindlycare_storage_get('js_code');
        if (!empty($code)) {
            $st = '<';
            $ct = '/';
            $et = '>';
            kindlycare_show_layout($code, "{$st}script{$et}jQuery(document).ready(function(){", "});{$st}{$ct}script{$et}");
        }
    }
}

//  Add property="stylesheet" into all tags <link> in the footer
if (!function_exists('kindlycare_core_add_property_to_link')) {
	//Handler of add_filter('style_loader_tag', 'kindlycare_core_add_property_to_link', 10, 3);
	function kindlycare_core_add_property_to_link($link, $handle='', $href='') {
		return str_replace('<link ', '<link property="stylesheet" ', $link);
	}
}

//  Add inline scripts in the footer
//  Add inline scripts in the footer
if (!function_exists('kindlycare_core_add_scripts_inline')) {
    function kindlycare_core_add_scripts_inline($vars = array()) {

        $msg = kindlycare_get_system_message(true);
        if (!empty($msg['message'])) kindlycare_enqueue_messages();

        // AJAX posts counter
        $vars['use_ajax_views_counter'] = is_singular() && kindlycare_get_theme_option('use_ajax_views_counter')=='yes';
        if (is_singular() && kindlycare_get_theme_option('use_ajax_views_counter')=='yes') {
            $vars['post_id'] = (int) get_the_ID();
            $vars['views'] = (int) kindlycare_get_post_views(get_the_ID()) + 1;
        }

        // AJAX parameters
        $vars['ajax_url'] = esc_url(admin_url('admin-ajax.php'));
        $vars['ajax_nonce'] = esc_attr(wp_create_nonce(admin_url('admin-ajax.php')));

        // Site base url
        $vars['site_url'] = esc_url(get_site_url());

        // VC frontend edit mode
        $vars['vc_edit_mode'] = function_exists('kindlycare_vc_is_frontend') && kindlycare_vc_is_frontend();

        // Theme base font
        $vars['theme_font'] = kindlycare_get_custom_font_settings('p', 'font-family');

        // Theme skin
        $vars['theme_skin'] = esc_attr(kindlycare_get_custom_option('theme_skin'));
        $vars['theme_skin_color'] = kindlycare_get_scheme_color('text_dark');
        $vars['theme_skin_bg_color'] = kindlycare_get_scheme_color('bg_color');

        // Slider height
        $vars['slider_height'] = max(100, kindlycare_get_custom_option('slider_height'));

        // System message
        $vars['system_message']    = $msg;

        // User logged in
        $vars['user_logged_in']    = is_user_logged_in();

        // Show table of content for the current page
        $vars['toc_menu'] = kindlycare_get_custom_option('menu_toc');
        $vars['toc_menu_home'] = kindlycare_get_custom_option('menu_toc')!='hide' && kindlycare_get_custom_option('menu_toc_home')=='yes';
        $vars['toc_menu_top'] = kindlycare_get_custom_option('menu_toc')!='hide' && kindlycare_get_custom_option('menu_toc_top')=='yes';

        // Fix main menu
        $vars['menu_fixed'] = kindlycare_get_theme_option('menu_attachment')=='fixed';

        // Use responsive version for main menu
        $vars['menu_mobile'] = kindlycare_get_theme_option('responsive_layouts') == 'yes' ? max(0, (int) kindlycare_get_theme_option('menu_mobile')) : 0;
        $vars['menu_slider'] = kindlycare_get_theme_option('menu_slider')=='yes';

        // Menu cache is used
        $vars['menu_cache']    = kindlycare_get_theme_option('use_menu_cache')=='yes';

        // Right panel demo timer
        $vars['demo_time'] = kindlycare_get_theme_option('show_theme_customizer')=='yes' ? max(0, (int) kindlycare_get_theme_option('customizer_demo')) : 0;

        // Video and Audio tag wrapper
        $vars['media_elements_enabled'] = kindlycare_get_theme_option('use_mediaelement')=='yes';

        // Use AJAX search
        $vars['ajax_search_enabled'] = kindlycare_get_theme_option('use_ajax_search')=='yes';
        $vars['ajax_search_min_length']    = min(3, kindlycare_get_theme_option('ajax_search_min_length'));
        $vars['ajax_search_delay'] = min(200, max(1000, kindlycare_get_theme_option('ajax_search_delay')));

        // Use CSS animation
        $vars['css_animation'] = kindlycare_get_theme_option('css_animation')=='yes';
        $vars['menu_animation_in'] = kindlycare_get_theme_option('menu_animation_in');
        $vars['menu_animation_out'] = kindlycare_get_theme_option('menu_animation_out');

        // Popup windows engine
        $vars['popup_engine'] = kindlycare_get_theme_option('popup_engine');

        // E-mail mask
        $vars['email_mask'] = '^([a-zA-Z0-9_\\-]+\\.)*[a-zA-Z0-9_\\-]+@[a-z0-9_\\-]+(\\.[a-z0-9_\\-]+)*\\.[a-z]{2,6}$';

        // Messages max length
        $vars['contacts_maxlength']    = intval(kindlycare_get_theme_option('message_maxlength_contacts'));
        $vars['comments_maxlength']    = intval(kindlycare_get_theme_option('message_maxlength_comments'));

        // Remember visitors settings
        $vars['remember_visitors_settings']    = kindlycare_get_theme_option('remember_visitors_settings')=='yes';

        // Internal vars - do not change it!
        // Flag for review mechanism
        $vars['admin_mode'] = false;
        // Max scale factor for the portfolio and other isotope elements before relayout
        $vars['isotope_resize_delta'] = 0.3;
        // jQuery object for the message box in the form
        $vars['error_message_box'] = null;
        // Waiting for the viewmore results
        $vars['viewmore_busy'] = false;
        $vars['video_resize_inited'] = false;
        $vars['top_panel_height'] = 0;

        return $vars;
    }
}


//  Enqueue Custom styles (main Theme options settings)
if ( !function_exists( 'kindlycare_enqueue_custom_styles' ) ) {
	function kindlycare_enqueue_custom_styles() {
		// Custom stylesheet
		$custom_css = '';	//kindlycare_get_custom_option('custom_stylesheet_url');
		wp_enqueue_style( 'kindlycare-custom-style', $custom_css ? $custom_css : kindlycare_get_file_url('css/custom-style.css'), array(), null );
		// Custom inline styles
		wp_add_inline_style( 'kindlycare-custom-style', kindlycare_prepare_custom_styles() );
	}
}

// Show content with the html layout (if not empty)
if (!function_exists('kindlycare_show_layout')) {
    function kindlycare_show_layout($str, $before = '', $after = '')
    {
        if ($str != '') {
            printf("%s%s%s", $before, $str, $after);
        }
    }
}

// Add class "widget_number_#' for each widget
if ( !function_exists( 'kindlycare_add_widget_number' ) ) {
	//Handler of add_filter('dynamic_sidebar_params', 'kindlycare_add_widget_number', 10, 1);
	function kindlycare_add_widget_number($prm) {
		if (is_admin()) return $prm;
		static $num=0, $last_sidebar='', $last_sidebar_id='', $last_sidebar_columns=0, $last_sidebar_count=0, $sidebars_widgets=array();
		$cur_sidebar = kindlycare_storage_get('current_sidebar');
		if (empty($cur_sidebar)) $cur_sidebar = 'undefined';
		if (count($sidebars_widgets) == 0)
			$sidebars_widgets = wp_get_sidebars_widgets();
		if ($last_sidebar != $cur_sidebar) {
			$num = 0;
			$last_sidebar = $cur_sidebar;
			$last_sidebar_id = $prm[0]['id'];
			$last_sidebar_columns = max(0, (int) kindlycare_get_custom_option('sidebar_'.($cur_sidebar).'_columns'));
			$last_sidebar_count = count($sidebars_widgets[$last_sidebar_id]);
		}
		$num++;
		$prm[0]['before_widget'] = str_replace(' class="', ' class="widget_number_'.esc_attr($num).($last_sidebar_columns > 0 ? ' column-1_'.esc_attr($last_sidebar_columns) : '').' ', $prm[0]['before_widget']);
		return $prm;
	}
}


// Show <title> tag under old WP (version < 4.1)
if ( !function_exists( 'kindlycare_wp_title_show' ) ) {
	//Handler of add_action('wp_head', 'kindlycare_wp_title_show');
	function kindlycare_wp_title_show() {
		?><title><?php wp_title( '|', true, 'right' ); ?></title><?php
	}
}

// Filters wp_title to print a neat <title> tag based on what is being viewed.
if ( !function_exists( 'kindlycare_wp_title_modify' ) ) {
	//Handler of add_filter( 'wp_title', 'kindlycare_wp_title_modify', 10, 2 );
	function kindlycare_wp_title_modify( $title, $sep ) {
		global $page, $paged;
		if ( is_feed() ) return $title;
		// Add the blog name
		$title .= get_bloginfo( 'name' );
		// Add the blog description for the home/front page.
		if ( is_home() || is_front_page() ) {
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description )
				$title .= " $sep $site_description";
		}
		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 )
			$title .= " $sep " . sprintf( esc_html__( 'Page %s', 'kindlycare' ), max( $paged, $page ) );
		return $title;
	}
}

// Add main menu classes
if ( !function_exists( 'kindlycare_add_mainmenu_classes' ) ) {
	//Handler of add_filter('wp_nav_menu_objects', 'kindlycare_add_mainmenu_classes', 10, 2);
	function kindlycare_add_mainmenu_classes($items, $args) {
		if (is_admin()) return $items;
		if ($args->menu_id == 'mainmenu' && kindlycare_get_theme_option('menu_colored')=='yes' && is_array($items) && count($items) > 0) {
			foreach($items as $k=>$item) {
				if ($item->menu_item_parent==0) {
					if ($item->type=='taxonomy' && $item->object=='category') {
						$cur_tint = kindlycare_taxonomy_get_inherited_property('category', $item->object_id, 'bg_tint');
						if (!empty($cur_tint) && !kindlycare_is_inherit_option($cur_tint))
							$items[$k]->classes[] = 'bg_tint_'.esc_attr($cur_tint);
					}
				}
			}
		}
		return $items;
	}
}


// Save post data from frontend editor
if ( !function_exists( 'kindlycare_callback_frontend_editor_save' ) ) {
	function kindlycare_callback_frontend_editor_save() {

		if ( !wp_verify_nonce( kindlycare_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			die();
		$response = array('error'=>'');

		parse_str($_REQUEST['data'], $output);
		$post_id = $output['frontend_editor_post_id'];

		if ( kindlycare_get_theme_option("allow_editor")=='yes' && (current_user_can('edit_posts', $post_id) || current_user_can('edit_pages', $post_id)) ) {
			if ($post_id > 0) {
				$title   = stripslashes($output['frontend_editor_post_title']);
				$content = stripslashes($output['frontend_editor_post_content']);
				$excerpt = stripslashes($output['frontend_editor_post_excerpt']);
				$rez = wp_update_post(array(
					'ID'           => $post_id,
					'post_content' => $content,
					'post_excerpt' => $excerpt,
					'post_title'   => $title
				));
				if ($rez == 0) 
					$response['error'] = esc_html__('Post update error!', 'kindlycare');
			} else {
				$response['error'] = esc_html__('Post update error!', 'kindlycare');
			}
		} else
			$response['error'] = esc_html__('Post update denied!', 'kindlycare');
		
		echo json_encode($response);
		die();
	}
}

// Delete post from frontend editor
if ( !function_exists( 'kindlycare_callback_frontend_editor_delete' ) ) {
	function kindlycare_callback_frontend_editor_delete() {

		if ( !wp_verify_nonce( kindlycare_get_value_gp('nonce'), admin_url('admin-ajax.php') ) )
			die();

		$response = array('error'=>'');
		
		$post_id = $_REQUEST['post_id'];

		if ( kindlycare_get_theme_option("allow_editor")=='yes' && (current_user_can('delete_posts', $post_id) || current_user_can('delete_pages', $post_id)) ) {
			if ($post_id > 0) {
				$rez = wp_delete_post($post_id);
				if ($rez === false) 
					$response['error'] = esc_html__('Post delete error!', 'kindlycare');
			} else {
				$response['error'] = esc_html__('Post delete error!', 'kindlycare');
			}
		} else
			$response['error'] = esc_html__('Post delete denied!', 'kindlycare');

		echo json_encode($response);
		die();
	}
}


// Prepare logo text
if ( !function_exists( 'kindlycare_prepare_logo_text' ) ) {
	function kindlycare_prepare_logo_text($text) {
		$text = str_replace(array('[', ']'), array('<span class="theme_accent">', '</span>'), $text);
		$text = str_replace(array('{', '}'), array('<strong>', '</strong>'), $text);
		return $text;
	}
}
?>