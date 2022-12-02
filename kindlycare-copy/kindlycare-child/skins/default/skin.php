<?php
/**
 * Skin file for the theme.
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }

// Theme init
if (!function_exists('kindlycare_action_skin_theme_setup')) {
	add_action( 'kindlycare_action_init_theme', 'kindlycare_action_skin_theme_setup', 1 );
	function kindlycare_action_skin_theme_setup() {

		// Add skin fonts in the used fonts list
		add_filter('kindlycare_filter_used_fonts',			'kindlycare_filter_skin_used_fonts');
		// Add skin fonts (from Google fonts) in the main fonts list (if not present).
		add_filter('kindlycare_filter_list_fonts',			'kindlycare_filter_skin_list_fonts');

		// Add skin stylesheets
		add_action('kindlycare_action_add_styles',			'kindlycare_action_skin_add_styles');
		// Add skin inline styles
		add_filter('kindlycare_filter_add_styles_inline',		'kindlycare_filter_skin_add_styles_inline');
		// Add skin responsive styles
		add_action('kindlycare_action_add_responsive',		'kindlycare_action_skin_add_responsive');
		// Add skin responsive inline styles
		add_filter('kindlycare_filter_add_responsive_inline',	'kindlycare_filter_skin_add_responsive_inline');

		// Add skin scripts
		add_action('kindlycare_action_add_scripts',			'kindlycare_action_skin_add_scripts');
		// Add skin scripts inline
		add_filter('kindlycare_action_add_scripts_inline',	'kindlycare_action_skin_add_scripts_inline');

		// Add skin less files into list for compilation
		add_filter('kindlycare_filter_compile_less',			'kindlycare_filter_skin_compile_less');


		/* Color schemes
		
		// Accenterd colors
		accent1			- theme accented color 1
		accent1_hover	- theme accented color 1 (hover state)
		accent2			- theme accented color 2
		accent2_hover	- theme accented color 2 (hover state)		
		accent3			- theme accented color 3
		accent3_hover	- theme accented color 3 (hover state)		
		
		// Headers, text and links
		text			- main content
		text_light		- post info
		text_dark		- headers
		inverse_text	- text on accented background
		inverse_light	- post info on accented background
		inverse_dark	- headers on accented background
		inverse_link	- links on accented background
		inverse_hover	- hovered links on accented background
		
		// Block's border and background
		bd_color		- border for the entire block
		bg_color		- background color for the entire block
		bg_image, bg_image_position, bg_image_repeat, bg_image_attachment  - first background image for the entire block
		bg_image2,bg_image2_position,bg_image2_repeat,bg_image2_attachment - second background image for the entire block
		
		// Alternative colors - highlight blocks, form fields, etc.
		alter_text		- text on alternative background
		alter_light		- post info on alternative background
		alter_dark		- headers on alternative background
		alter_link		- links on alternative background
		alter_hover		- hovered links on alternative background
		alter_bd_color	- alternative border
		alter_bd_hover	- alternative border for hovered state or active field
		alter_bg_color	- alternative background
		alter_bg_hover	- alternative background for hovered state or active field 
		alter_bg_image, alter_bg_image_position, alter_bg_image_repeat, alter_bg_image_attachment - background image for the alternative block
		
		*/

		// Add color schemes
		kindlycare_add_color_scheme('original', array(

			'title'					=> esc_html__('Original', 'kindlycare'),

			// Accent colors
			'accent1'				=> '#34b8dd',
			'accent1_hover'			=> '#88cb6f',
			
			// Headers, text and links colors
			'text'					=> '#8496a2',
			'text_light'			=> '#8496a2',
			'text_dark'				=> '#3a5668',
			'inverse_text'			=> '#ffffff',
			'inverse_light'			=> '#ffffff',
			'inverse_dark'			=> '#ffffff',
			'inverse_link'			=> '#2e4b5f',
			'inverse_hover'			=> '#34b8dd',

			// Whole block border and background
			'bd_color'				=> '#c8cfd8',
			'bg_color'				=> '#ffffff',
			'bg_image'				=> '',
			'bg_image_position'		=> 'left top',
			'bg_image_repeat'		=> 'repeat',
			'bg_image_attachment'	=> 'scroll',
			'bg_image2'				=> '',
			'bg_image2_position'	=> 'left top',
			'bg_image2_repeat'		=> 'repeat',
			'bg_image2_attachment'	=> 'scroll',
		
			// Alternative blocks (submenu items, form's fields, etc.)
			'alter_text'			=> '#3a5668',
			'alter_light'			=> '#d8d8d8',
			'alter_dark'			=> '#2e4b5f',
			'alter_link'			=> '#ff8787',
			'alter_hover'			=> '#34b8dd',
			'alter_bd_color'		=> '#e2e2e2',
			'alter_bd_hover'		=> '#3a5668',
			'alter_bg_color'		=> '#f4f7f9',
			'alter_bg_hover'		=> '#263642',
            'alter_bg_image'			=> kindlycare_get_file_url('images/image_404.png'),
            'alter_bg_image_position'	=> 'center center',
            'alter_bg_image_repeat'		=> 'no-repeat',
            'alter_bg_image_attachment'	=> 'scroll',
			)
		);

//		// Add color schemes
		kindlycare_add_color_scheme('color_2', array(

			'title'					=> esc_html__('Color 2', 'kindlycare'),

			// Accent colors
                'accent1'				=> '#65abb3',
                'accent1_hover'			=> '#88cb6f',

                // Headers, text and links colors
                'text'					=> '#8496a2',
                'text_light'			=> '#8496a2',
                'text_dark'				=> '#3a5668',
                'inverse_text'			=> '#ffffff',
                'inverse_light'			=> '#ffffff',
                'inverse_dark'			=> '#ffffff',
                'inverse_link'			=> '#2e4b5f',
                'inverse_hover'			=> '#65abb3',

                // Whole block border and background
                'bd_color'				=> '#c8cfd8',
                'bg_color'				=> '#ffffff',
                'bg_image'				=> '',
                'bg_image_position'		=> 'left top',
                'bg_image_repeat'		=> 'repeat',
                'bg_image_attachment'	=> 'scroll',
                'bg_image2'				=> '',
                'bg_image2_position'	=> 'left top',
                'bg_image2_repeat'		=> 'repeat',
                'bg_image2_attachment'	=> 'scroll',

                // Alternative blocks (submenu items, form's fields, etc.)
                'alter_text'			=> '#3a5668',
                'alter_light'			=> '#d8d8d8',
                'alter_dark'			=> '#2e4b5f',
                'alter_link'			=> '#ff8787',
                'alter_hover'			=> '#65abb3',
                'alter_bd_color'		=> '#e2e2e2',
                'alter_bd_hover'		=> '#3a5668',
                'alter_bg_color'		=> '#f4f7f9',
                'alter_bg_hover'		=> '#263642',
                'alter_bg_image'			=> kindlycare_get_file_url('images/image_404.png'),
                'alter_bg_image_position'	=> 'center center',
                'alter_bg_image_repeat'		=> 'no-repeat',
                'alter_bg_image_attachment'	=> 'scroll',
			)
		);

		// Add color schemes
		kindlycare_add_color_scheme('color_3', array(

			'title'					=> esc_html__('Color 3', 'kindlycare'),

			// Accent colors
                'accent1'				=> '#fb7844',
                'accent1_hover'			=> '#88cb6f',

                // Headers, text and links colors
                'text'					=> '#8496a2',
                'text_light'			=> '#8496a2',
                'text_dark'				=> '#3a5668',
                'inverse_text'			=> '#ffffff',
                'inverse_light'			=> '#ffffff',
                'inverse_dark'			=> '#ffffff',
                'inverse_link'			=> '#2e4b5f',
                'inverse_hover'			=> '#fb7844',

                // Whole block border and background
                'bd_color'				=> '#c8cfd8',
                'bg_color'				=> '#ffffff',
                'bg_image'				=> '',
                'bg_image_position'		=> 'left top',
                'bg_image_repeat'		=> 'repeat',
                'bg_image_attachment'	=> 'scroll',
                'bg_image2'				=> '',
                'bg_image2_position'	=> 'left top',
                'bg_image2_repeat'		=> 'repeat',
                'bg_image2_attachment'	=> 'scroll',

                // Alternative blocks (submenu items, form's fields, etc.)
                'alter_text'			=> '#3a5668',
                'alter_light'			=> '#d8d8d8',
                'alter_dark'			=> '#2e4b5f',
                'alter_link'			=> '#ff8787',
                'alter_hover'			=> '#fb7844',
                'alter_bd_color'		=> '#e2e2e2',
                'alter_bd_hover'		=> '#3a5668',
                'alter_bg_color'		=> '#f4f7f9',
                'alter_bg_hover'		=> '#263642',
                'alter_bg_image'			=> kindlycare_get_file_url('images/image_404.png'),
                'alter_bg_image_position'	=> 'center center',
                'alter_bg_image_repeat'		=> 'no-repeat',
                'alter_bg_image_attachment'	=> 'scroll',
			)
		);

        // Add color schemes
		kindlycare_add_color_scheme('color_4', array(

			'title'					=> esc_html__('Color 4', 'kindlycare'),

			// Accent colors
                'accent1'				=> '#efc739',
                'accent1_hover'			=> '#88cb6f',

                // Headers, text and links colors
                'text'					=> '#8496a2',
                'text_light'			=> '#8496a2',
                'text_dark'				=> '#3a5668',
                'inverse_text'			=> '#ffffff',
                'inverse_light'			=> '#ffffff',
                'inverse_dark'			=> '#ffffff',
                'inverse_link'			=> '#2e4b5f',
                'inverse_hover'			=> '#efc739',

                // Whole block border and background
                'bd_color'				=> '#c8cfd8',
                'bg_color'				=> '#ffffff',
                'bg_image'				=> '',
                'bg_image_position'		=> 'left top',
                'bg_image_repeat'		=> 'repeat',
                'bg_image_attachment'	=> 'scroll',
                'bg_image2'				=> '',
                'bg_image2_position'	=> 'left top',
                'bg_image2_repeat'		=> 'repeat',
                'bg_image2_attachment'	=> 'scroll',

                // Alternative blocks (submenu items, form's fields, etc.)
                'alter_text'			=> '#3a5668',
                'alter_light'			=> '#d8d8d8',
                'alter_dark'			=> '#2e4b5f',
                'alter_link'			=> '#ff8787',
                'alter_hover'			=> '#efc739',
                'alter_bd_color'		=> '#e2e2e2',
                'alter_bd_hover'		=> '#3a5668',
                'alter_bg_color'		=> '#f4f7f9',
                'alter_bg_hover'		=> '#263642',
                'alter_bg_image'			=> kindlycare_get_file_url('images/image_404.png'),
                'alter_bg_image_position'	=> 'center center',
                'alter_bg_image_repeat'		=> 'no-repeat',
                'alter_bg_image_attachment'	=> 'scroll',
			)
		);

		/* Font slugs:
		h1 ... h6	- headers
		p			- plain text
		link		- links
		info		- info blocks (Posted 15 May, 2015 by John Doe)
		menu		- main menu
		submenu		- dropdown menus
		logo		- logo text
		button		- button's caption
		input		- input fields
		*/

		// Add Custom fonts
        kindlycare_add_custom_font('p', array(
            'title'			=> esc_html__('Text', 'kindlycare'),
            'description'	=> '',
            'font-family'	=> 'OpenSans',
            'font-size' 	=> '14px',
            'font-weight'	=> '400',
            'font-style'	=> '',
            'line-height'	=> '1.5em',
            'margin-top'	=> '',
            'margin-bottom'	=> '1em'
            )
        );
		kindlycare_add_custom_font('h1', array(
			'title'			=> esc_html__('Heading 1', 'kindlycare'),
			'description'	=> '',
			'font-family'	=> 'Vollkorn',
			'font-size' 	=> '3.571rem',
			'font-weight'	=> '500',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '',
			'margin-bottom'	=> ''
			)
		);
		kindlycare_add_custom_font('h2', array(
			'title'			=> esc_html__('Heading 2', 'kindlycare'),
			'description'	=> '',
			'font-family'	=> 'Vollkorn',
			'font-size' 	=> '2.857rem',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '',
			'margin-bottom'	=> ''
			)
		);
		kindlycare_add_custom_font('h3', array(
			'title'			=> esc_html__('Heading 3', 'kindlycare'),
			'description'	=> '',
			'font-family'	=> 'Vollkorn',
			'font-size' 	=> '2.571rem',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '',
			'margin-bottom'	=> ''
			)
		);
		kindlycare_add_custom_font('h4', array(
			'title'			=> esc_html__('Heading 4', 'kindlycare'),
			'description'	=> '',
			'font-family'	=> 'Vollkorn',
			'font-size' 	=> '2.143rem',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '',
			'margin-bottom'	=> ''
			)
		);
		kindlycare_add_custom_font('h5', array(
			'title'			=> esc_html__('Heading 5', 'kindlycare'),
			'description'	=> '',
			'font-family'	=> 'Vollkorn',
			'font-size' 	=> '1.786rem',
			'font-weight'	=> '400',
			'font-style'	=> '',
			'line-height'	=> '1.3em',
			'margin-top'	=> '',
			'margin-bottom'	=> ''
			)
		);
		kindlycare_add_custom_font('h6', array(
			'title'			=> esc_html__('Heading 6', 'kindlycare'),
			'description'	=> '',
			'font-family'	=> 'Vollkorn',
			'font-size' 	=> '1.5rem',
			'font-weight'	=> '500',
			'font-style'	=> '',
			'line-height'	=> '1.4em',
			'margin-top'	=> '',
			'margin-bottom'	=> ''
			)
		);
        kindlycare_add_custom_font('logo', array(
            'title'			=> esc_html__('Logo', 'kindlycare'),
            'description'	=> '',
            'font-family'	=> '',
            'font-size' 	=> '1.5rem',
            'font-weight'	=> '500',
            'font-style'	=> '',
            'line-height'	=> '0.8em'
            )
        );
        kindlycare_add_custom_font('menu', array(
            'title'			=> esc_html__('Main menu items', 'kindlycare'),
            'description'	=> '',
            'font-family'	=> 'Lato',
            'font-size' 	=> '0.857rem',
            'font-weight'	=> '700',
            'font-style'	=> '',
            'line-height'	=> '1em'
            )
        );
        kindlycare_add_custom_font('submenu', array(
            'title'			=> esc_html__('Dropdown menu items', 'kindlycare'),
            'description'	=> '',
            'font-family'	=> 'Lato',
            'font-size' 	=> '0.857rem',
            'font-weight'	=> '700',
            'font-style'	=> '',
            'line-height'	=> '1em'
            )
        );
		kindlycare_add_custom_font('link', array(
			'title'			=> esc_html__('Links', 'kindlycare'),
			'description'	=> '',
			'font-family'	=> ''
			)
		);
		kindlycare_add_custom_font('info', array(
			'title'			=> esc_html__('Post info', 'kindlycare'),
			'description'	=> '',
			'font-family'	=> ''
			)
		);
		kindlycare_add_custom_font('button', array(
			'title'			=> esc_html__('Buttons', 'kindlycare'),
			'description'	=> '',
			'font-family'	=> 'Lato'
			)
		);
		kindlycare_add_custom_font('input', array(
			'title'			=> esc_html__('Input fields', 'kindlycare'),
			'description'	=> '',
			'font-family'	=> ''
			)
		);

	}
}





//------------------------------------------------------------------------------
// Skin's fonts
//------------------------------------------------------------------------------

// Add skin fonts in the used fonts list
if (!function_exists('kindlycare_filter_skin_used_fonts')) {
	//Handler of add_filter('kindlycare_filter_used_fonts', 'kindlycare_filter_skin_used_fonts');
	function kindlycare_filter_skin_used_fonts($theme_fonts) {
		$theme_fonts['Lato'] = 1;
		$theme_fonts['OpenSans'] = 1;
		$theme_fonts['Vollkorn'] = 1;
		return $theme_fonts;
	}
}

// Add skin fonts (from Google fonts) in the main fonts list (if not present).
// To use custom font-face you not need add it into list in this function
// How to install custom @font-face fonts into the theme?
// All @font-face fonts are located in "theme_name/css/font-face/" folder in the separate subfolders for the each font. Subfolder name is a font-family name!
// Place full set of the font files (for each font style and weight) and css-file named stylesheet.css in the each subfolder.
// Create your @font-face kit by using Fontsquirrel @font-face Generator (http://www.fontsquirrel.com/fontface/generator)
// and then extract the font kit (with folder in the kit) into the "theme_name/css/font-face" folder to install
if (!function_exists('kindlycare_filter_skin_list_fonts')) {
	//Handler of add_filter('kindlycare_filter_list_fonts', 'kindlycare_filter_skin_list_fonts');
	function kindlycare_filter_skin_list_fonts($list) {
		// Example:
		// if (!isset($list['Advent Pro'])) {
		//		$list['Advent Pro'] = array(
		//			'family' => 'sans-serif',																						// (required) font family
		//			'link'   => 'Advent+Pro:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic',	// (optional) if you use Google font repository
		//			'css'    => kindlycare_get_file_url('/css/font-face/Advent-Pro/stylesheet.css')									// (optional) if you use custom font-face
		//			);
		// }
		if (!isset($list['Lato']))	$list['Lato'] = array('family'=>'sans-serif');
        if (!isset($list['OpenSans']))	    $list['OpenSans'] = array('family'=>'sans-serif', 'link'=>'Open+Sans:400,700');
        if (!isset($list['Vollkorn']))	    $list['Vollkorn'] = array('family'=>'serif', 'link'=>'Vollkorn:400,500,700');
		return $list;
	}
}



//------------------------------------------------------------------------------
// Skin's stylesheets
//------------------------------------------------------------------------------
// Add skin stylesheets
if (!function_exists('kindlycare_action_skin_add_styles')) {
	//Handler of add_action('kindlycare_action_add_styles', 'kindlycare_action_skin_add_styles');
	function kindlycare_action_skin_add_styles() {
		// Add stylesheet files
		wp_enqueue_style( 'kindlycare-skin-style', kindlycare_get_file_url('skin.css'), array(), null );
		if (file_exists(kindlycare_get_file_dir('skin.customizer.css')))
			wp_enqueue_style( 'kindlycare-skin-customizer-style', kindlycare_get_file_url('skin.customizer.css'), array(), null );
	}
}

// Add skin inline styles
if (!function_exists('kindlycare_filter_skin_add_styles_inline')) {
	//Handler of add_filter('kindlycare_filter_add_styles_inline', 'kindlycare_filter_skin_add_styles_inline');
	function kindlycare_filter_skin_add_styles_inline($custom_style) {
		// Todo: add skin specific styles in the $custom_style to override
		//       rules from style.css and shortcodes.css
		// Example:
		//		$scheme = kindlycare_get_custom_option('body_scheme');
		//		if (empty($scheme)) $scheme = 'original';
		//		$clr = kindlycare_get_scheme_color('accent1');
		//		if (!empty($clr)) {
		// 			$custom_style .= '
		//				a,
		//				.bg_tint_light a,
		//				.top_panel .content .search_wrap.search_style_regular .search_form_wrap .search_submit,
		//				.top_panel .content .search_wrap.search_style_regular .search_icon,
		//				.search_results .post_more,
		//				.search_results .search_results_close {
		//					color:'.esc_attr($clr).';
		//				}
		//			';
		//		}
		return $custom_style;	
	}
}

// Add skin responsive styles
if (!function_exists('kindlycare_action_skin_add_responsive')) {
	//Handler of add_action('kindlycare_action_add_responsive', 'kindlycare_action_skin_add_responsive');
	function kindlycare_action_skin_add_responsive() {
		$suffix = kindlycare_param_is_off(kindlycare_get_custom_option('show_sidebar_outer')) ? '' : '-outer';
		if (file_exists(kindlycare_get_file_dir('skin.responsive'.($suffix).'.css'))) 
			wp_enqueue_style( 'theme-skin-responsive-style', kindlycare_get_file_url('skin.responsive'.($suffix).'.css'), array(), null );
	}
}

// Add skin responsive inline styles
if (!function_exists('kindlycare_filter_skin_add_responsive_inline')) {
	//Handler of add_filter('kindlycare_filter_add_responsive_inline', 'kindlycare_filter_skin_add_responsive_inline');
	function kindlycare_filter_skin_add_responsive_inline($custom_style) {
		return $custom_style;	
	}
}

// Add skin.less into list files for compilation
if (!function_exists('kindlycare_filter_skin_compile_less')) {
	//Handler of add_filter('kindlycare_filter_compile_less', 'kindlycare_filter_skin_compile_less');
	function kindlycare_filter_skin_compile_less($files) {
		if (file_exists(kindlycare_get_file_dir('skin.less'))) {
		 	$files[] = kindlycare_get_file_dir('skin.less');
		}
		return $files;	
	}
}



//------------------------------------------------------------------------------
// Skin's scripts
//------------------------------------------------------------------------------

// Add skin scripts
if (!function_exists('kindlycare_action_skin_add_scripts')) {
	//Handler of add_action('kindlycare_action_add_scripts', 'kindlycare_action_skin_add_scripts');
	function kindlycare_action_skin_add_scripts() {
		if (file_exists(kindlycare_get_file_dir('skin.js')))
			wp_enqueue_script( 'theme-skin-script', kindlycare_get_file_url('skin.js'), array(), null, true );
		if (kindlycare_get_theme_option('show_theme_customizer') == 'yes' && file_exists(kindlycare_get_file_dir('skin.customizer.js')))
			wp_enqueue_script( 'theme-skin-customizer-script', kindlycare_get_file_url('skin.customizer.js'), array(), null, true );
	}
}

// Add skin scripts inline
if (!function_exists('kindlycare_action_skin_add_scripts_inline')) {
    //Handler of add_filter('kindlycare_action_add_scripts_inline', 'kindlycare_action_skin_add_scripts_inline');
    function kindlycare_action_skin_add_scripts_inline($vars=array()) {
        // Todo: add skin specific script's vars
        return $vars;
    }
}
?>