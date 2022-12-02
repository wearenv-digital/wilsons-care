<?php
/**
 * KindlyCare Framework: return lists
 *
 * @package kindlycare
 * @since kindlycare 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }



// Return styles list
if ( !function_exists( 'kindlycare_get_list_styles' ) ) {
	function kindlycare_get_list_styles($from=1, $to=2, $prepend_inherit=false) {
		$list = array();
		for ($i=$from; $i<=$to; $i++)
			$list[$i] = sprintf(esc_html__('Style %d', 'kindlycare'), $i);
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return list of the shortcodes margins
if ( !function_exists( 'kindlycare_get_list_margins' ) ) {
	function kindlycare_get_list_margins($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_margins'))=='') {
			$list = array(
				'null'		=> esc_html__('0 (No margin)',	'kindlycare'),
				'tiny'		=> esc_html__('Tiny',		'kindlycare'),
				'small'		=> esc_html__('Small',		'kindlycare'),
				'medium'	=> esc_html__('Medium',		'kindlycare'),
				'large'		=> esc_html__('Large',		'kindlycare'),
				'huge'		=> esc_html__('Huge',		'kindlycare'),
				'tiny-'		=> esc_html__('Tiny (negative)',	'kindlycare'),
				'small-'	=> esc_html__('Small (negative)',	'kindlycare'),
				'medium-'	=> esc_html__('Medium (negative)',	'kindlycare'),
				'large-'	=> esc_html__('Large (negative)',	'kindlycare'),
				'huge-'		=> esc_html__('Huge (negative)',	'kindlycare')
				);
			$list = apply_filters('kindlycare_filter_list_margins', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_margins', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return list of the animations
if ( !function_exists( 'kindlycare_get_list_animations' ) ) {
	function kindlycare_get_list_animations($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_animations'))=='') {
			$list = array(
				'none'			=> esc_html__('- None -',	'kindlycare'),
				'bounced'		=> esc_html__('Bounced',		'kindlycare'),
				'flash'			=> esc_html__('Flash',		'kindlycare'),
				'flip'			=> esc_html__('Flip',		'kindlycare'),
				'pulse'			=> esc_html__('Pulse',		'kindlycare'),
				'rubberBand'	=> esc_html__('Rubber Band',	'kindlycare'),
				'shake'			=> esc_html__('Shake',		'kindlycare'),
				'swing'			=> esc_html__('Swing',		'kindlycare'),
				'tada'			=> esc_html__('Tada',		'kindlycare'),
				'wobble'		=> esc_html__('Wobble',		'kindlycare')
				);
			$list = apply_filters('kindlycare_filter_list_animations', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_animations', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return list of the line styles
if ( !function_exists( 'kindlycare_get_list_line_styles' ) ) {
	function kindlycare_get_list_line_styles($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_line_styles'))=='') {
			$list = array(
				'solid'	=> esc_html__('Solid', 'kindlycare'),
				'dashed'=> esc_html__('Dashed', 'kindlycare'),
				'dotted'=> esc_html__('Dotted', 'kindlycare'),
				'double'=> esc_html__('Double', 'kindlycare'),
				'image'	=> esc_html__('Image', 'kindlycare')
				);
			$list = apply_filters('kindlycare_filter_list_line_styles', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_line_styles', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return list of the enter animations
if ( !function_exists( 'kindlycare_get_list_animations_in' ) ) {
	function kindlycare_get_list_animations_in($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_animations_in'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',			'kindlycare'),
				'bounceIn'			=> esc_html__('Bounce In',			'kindlycare'),
				'bounceInUp'		=> esc_html__('Bounce In Up',		'kindlycare'),
				'bounceInDown'		=> esc_html__('Bounce In Down',		'kindlycare'),
				'bounceInLeft'		=> esc_html__('Bounce In Left',		'kindlycare'),
				'bounceInRight'		=> esc_html__('Bounce In Right',	'kindlycare'),
				'fadeIn'			=> esc_html__('Fade In',			'kindlycare'),
				'fadeInUp'			=> esc_html__('Fade In Up',			'kindlycare'),
				'fadeInDown'		=> esc_html__('Fade In Down',		'kindlycare'),
				'fadeInLeft'		=> esc_html__('Fade In Left',		'kindlycare'),
				'fadeInRight'		=> esc_html__('Fade In Right',		'kindlycare'),
				'fadeInUpBig'		=> esc_html__('Fade In Up Big',		'kindlycare'),
				'fadeInDownBig'		=> esc_html__('Fade In Down Big',	'kindlycare'),
				'fadeInLeftBig'		=> esc_html__('Fade In Left Big',	'kindlycare'),
				'fadeInRightBig'	=> esc_html__('Fade In Right Big',	'kindlycare'),
				'flipInX'			=> esc_html__('Flip In X',			'kindlycare'),
				'flipInY'			=> esc_html__('Flip In Y',			'kindlycare'),
				'lightSpeedIn'		=> esc_html__('Light Speed In',		'kindlycare'),
				'rotateIn'			=> esc_html__('Rotate In',			'kindlycare'),
				'rotateInUpLeft'	=> esc_html__('Rotate In Down Left','kindlycare'),
				'rotateInUpRight'	=> esc_html__('Rotate In Up Right',	'kindlycare'),
				'rotateInDownLeft'	=> esc_html__('Rotate In Up Left',	'kindlycare'),
				'rotateInDownRight'	=> esc_html__('Rotate In Down Right','kindlycare'),
				'rollIn'			=> esc_html__('Roll In',			'kindlycare'),
				'slideInUp'			=> esc_html__('Slide In Up',		'kindlycare'),
				'slideInDown'		=> esc_html__('Slide In Down',		'kindlycare'),
				'slideInLeft'		=> esc_html__('Slide In Left',		'kindlycare'),
				'slideInRight'		=> esc_html__('Slide In Right',		'kindlycare'),
				'zoomIn'			=> esc_html__('Zoom In',			'kindlycare'),
				'zoomInUp'			=> esc_html__('Zoom In Up',			'kindlycare'),
				'zoomInDown'		=> esc_html__('Zoom In Down',		'kindlycare'),
				'zoomInLeft'		=> esc_html__('Zoom In Left',		'kindlycare'),
				'zoomInRight'		=> esc_html__('Zoom In Right',		'kindlycare')
				);
			$list = apply_filters('kindlycare_filter_list_animations_in', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_animations_in', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return list of the out animations
if ( !function_exists( 'kindlycare_get_list_animations_out' ) ) {
	function kindlycare_get_list_animations_out($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_animations_out'))=='') {
			$list = array(
				'none'				=> esc_html__('- None -',	'kindlycare'),
				'bounceOut'			=> esc_html__('Bounce Out',			'kindlycare'),
				'bounceOutUp'		=> esc_html__('Bounce Out Up',		'kindlycare'),
				'bounceOutDown'		=> esc_html__('Bounce Out Down',		'kindlycare'),
				'bounceOutLeft'		=> esc_html__('Bounce Out Left',		'kindlycare'),
				'bounceOutRight'	=> esc_html__('Bounce Out Right',	'kindlycare'),
				'fadeOut'			=> esc_html__('Fade Out',			'kindlycare'),
				'fadeOutUp'			=> esc_html__('Fade Out Up',			'kindlycare'),
				'fadeOutDown'		=> esc_html__('Fade Out Down',		'kindlycare'),
				'fadeOutLeft'		=> esc_html__('Fade Out Left',		'kindlycare'),
				'fadeOutRight'		=> esc_html__('Fade Out Right',		'kindlycare'),
				'fadeOutUpBig'		=> esc_html__('Fade Out Up Big',		'kindlycare'),
				'fadeOutDownBig'	=> esc_html__('Fade Out Down Big',	'kindlycare'),
				'fadeOutLeftBig'	=> esc_html__('Fade Out Left Big',	'kindlycare'),
				'fadeOutRightBig'	=> esc_html__('Fade Out Right Big',	'kindlycare'),
				'flipOutX'			=> esc_html__('Flip Out X',			'kindlycare'),
				'flipOutY'			=> esc_html__('Flip Out Y',			'kindlycare'),
				'hinge'				=> esc_html__('Hinge Out',			'kindlycare'),
				'lightSpeedOut'		=> esc_html__('Light Speed Out',		'kindlycare'),
				'rotateOut'			=> esc_html__('Rotate Out',			'kindlycare'),
				'rotateOutUpLeft'	=> esc_html__('Rotate Out Down Left',	'kindlycare'),
				'rotateOutUpRight'	=> esc_html__('Rotate Out Up Right',		'kindlycare'),
				'rotateOutDownLeft'	=> esc_html__('Rotate Out Up Left',		'kindlycare'),
				'rotateOutDownRight'=> esc_html__('Rotate Out Down Right',	'kindlycare'),
				'rollOut'			=> esc_html__('Roll Out',		'kindlycare'),
				'slideOutUp'		=> esc_html__('Slide Out Up',		'kindlycare'),
				'slideOutDown'		=> esc_html__('Slide Out Down',	'kindlycare'),
				'slideOutLeft'		=> esc_html__('Slide Out Left',	'kindlycare'),
				'slideOutRight'		=> esc_html__('Slide Out Right',	'kindlycare'),
				'zoomOut'			=> esc_html__('Zoom Out',			'kindlycare'),
				'zoomOutUp'			=> esc_html__('Zoom Out Up',		'kindlycare'),
				'zoomOutDown'		=> esc_html__('Zoom Out Down',	'kindlycare'),
				'zoomOutLeft'		=> esc_html__('Zoom Out Left',	'kindlycare'),
				'zoomOutRight'		=> esc_html__('Zoom Out Right',	'kindlycare')
				);
			$list = apply_filters('kindlycare_filter_list_animations_out', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_animations_out', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return classes list for the specified animation
if (!function_exists('kindlycare_get_animation_classes')) {
	function kindlycare_get_animation_classes($animation, $speed='normal', $loop='none') {
		// speed:	fast=0.5s | normal=1s | slow=2s
		// loop:	none | infinite
		return kindlycare_param_is_off($animation) ? '' : 'animated '.esc_attr($animation).' '.esc_attr($speed).(!kindlycare_param_is_off($loop) ? ' '.esc_attr($loop) : '');
	}
}


// Return list of categories
if ( !function_exists( 'kindlycare_get_list_categories' ) ) {
	function kindlycare_get_list_categories($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_categories'))=='') {
			$list = array();
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'parent'                   => '',
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '',
				'include'                  => '',
				'number'                   => '',
				'taxonomy'                 => 'category',
				'pad_counts'               => false );
			$taxonomies = get_categories( $args );
			if (is_array($taxonomies) && count($taxonomies) > 0) {
				foreach ($taxonomies as $cat) {
					$list[$cat->term_id] = $cat->name;
				}
			}
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_categories', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return list of taxonomies
if ( !function_exists( 'kindlycare_get_list_terms' ) ) {
	function kindlycare_get_list_terms($prepend_inherit=false, $taxonomy='category') {
		if (($list = kindlycare_storage_get('list_taxonomies_'.($taxonomy)))=='') {
			$list = array();
			if ( is_array($taxonomy) || taxonomy_exists($taxonomy) ) {
				$terms = get_terms( $taxonomy, array(
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => 0,
					'hierarchical'             => 1,
					'exclude'                  => '',
					'include'                  => '',
					'number'                   => '',
					'taxonomy'                 => $taxonomy,
					'pad_counts'               => false
					)
				);
			} else {
				$terms = kindlycare_get_terms_by_taxonomy_from_db($taxonomy);
			}
			if (!is_wp_error( $terms ) && is_array($terms) && count($terms) > 0) {
				foreach ($terms as $cat) {
					$list[$cat->term_id] = $cat->name;	// . ($taxonomy!='category' ? ' /'.($cat->taxonomy).'/' : '');
				}
			}
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_taxonomies_'.($taxonomy), $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list of post's types
if ( !function_exists( 'kindlycare_get_list_posts_types' ) ) {
	function kindlycare_get_list_posts_types($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_posts_types'))=='') {
			/* 
			// This way to return all registered post types
			$types = get_post_types();
			if (in_array('post', $types)) $list['post'] = esc_html__('Post', 'kindlycare');
			if (is_array($types) && count($types) > 0) {
				foreach ($types as $t) {
					if ($t == 'post') continue;
					$list[$t] = kindlycare_strtoproper($t);
				}
			}
			*/
			// Return only theme inheritance supported post types
			$list = apply_filters('kindlycare_filter_list_post_types', array());
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_posts_types', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return list post items from any post type and taxonomy
if ( !function_exists( 'kindlycare_get_list_posts' ) ) {
	function kindlycare_get_list_posts($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish',
			'taxonomy'			=> 'category',
			'taxonomy_value'	=> '',
			'posts_per_page'	=> -1,
			'orderby'			=> 'post_date',
			'order'				=> 'desc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));

		$hash = 'list_posts_'.($opt['post_type']).'_'.($opt['taxonomy']).'_'.($opt['taxonomy_value']).'_'.($opt['orderby']).'_'.($opt['order']).'_'.($opt['return']).'_'.($opt['posts_per_page']);
		if (($list = kindlycare_storage_get($hash))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'kindlycare');
			$args = array(
				'post_type' => $opt['post_type'],
				'post_status' => $opt['post_status'],
				'posts_per_page' => $opt['posts_per_page'],
				'ignore_sticky_posts' => true,
				'orderby'	=> $opt['orderby'],
				'order'		=> $opt['order']
			);
			if (!empty($opt['taxonomy_value'])) {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $opt['taxonomy'],
						'field' => (int) $opt['taxonomy_value'] > 0 ? 'id' : 'slug',
						'terms' => $opt['taxonomy_value']
					)
				);
			}
			$posts = get_posts( $args );
			if (is_array($posts) && count($posts) > 0) {
				foreach ($posts as $post) {
					$list[$opt['return']=='id' ? $post->ID : $post->post_title] = $post->post_title;
				}
			}
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set($hash, $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return list pages
if ( !function_exists( 'kindlycare_get_list_pages' ) ) {
	function kindlycare_get_list_pages($prepend_inherit=false, $opt=array()) {
		$opt = array_merge(array(
			'post_type'			=> 'page',
			'post_status'		=> 'publish',
			'posts_per_page'	=> -1,
			'orderby'			=> 'title',
			'order'				=> 'asc',
			'return'			=> 'id'
			), is_array($opt) ? $opt : array('post_type'=>$opt));
		return kindlycare_get_list_posts($prepend_inherit, $opt);
	}
}


// Return list of registered users
if ( !function_exists( 'kindlycare_get_list_users' ) ) {
	function kindlycare_get_list_users($prepend_inherit=false, $roles=array('administrator', 'editor', 'author', 'contributor', 'shop_manager')) {
		if (($list = kindlycare_storage_get('list_users'))=='') {
			$list = array();
			$list['none'] = esc_html__("- Not selected -", 'kindlycare');
			$args = array(
				'orderby'	=> 'display_name',
				'order'		=> 'ASC' );
			$users = get_users( $args );
			if (is_array($users) && count($users) > 0) {
				foreach ($users as $user) {
					$accept = true;
					if (is_array($user->roles)) {
						if (is_array($user->roles) && count($user->roles) > 0) {
							$accept = false;
							foreach ($user->roles as $role) {
								if (in_array($role, $roles)) {
									$accept = true;
									break;
								}
							}
						}
					}
					if ($accept) $list[$user->user_login] = $user->display_name;
				}
			}
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_users', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return slider engines list, prepended inherit (if need)
if ( !function_exists( 'kindlycare_get_list_sliders' ) ) {
	function kindlycare_get_list_sliders($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_sliders'))=='') {
			$list = array(
				'swiper' => esc_html__("Posts slider (Swiper)", 'kindlycare')
			);
			$list = apply_filters('kindlycare_filter_list_sliders', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_sliders', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return slider controls list, prepended inherit (if need)
if ( !function_exists( 'kindlycare_get_list_slider_controls' ) ) {
	function kindlycare_get_list_slider_controls($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_slider_controls'))=='') {
			$list = array(
				'no'		=> esc_html__('None', 'kindlycare'),
				'side'		=> esc_html__('Side', 'kindlycare'),
				'bottom'	=> esc_html__('Bottom', 'kindlycare'),
				'pagination'=> esc_html__('Pagination', 'kindlycare')
				);
			$list = apply_filters('kindlycare_filter_list_slider_controls', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_slider_controls', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return slider controls classes
if ( !function_exists( 'kindlycare_get_slider_controls_classes' ) ) {
	function kindlycare_get_slider_controls_classes($controls) {
		if (kindlycare_param_is_off($controls))	$classes = 'sc_slider_nopagination sc_slider_nocontrols';
		else if ($controls=='bottom')			$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_bottom';
		else if ($controls=='pagination')		$classes = 'sc_slider_pagination sc_slider_pagination_bottom sc_slider_nocontrols';
		else									$classes = 'sc_slider_nopagination sc_slider_controls sc_slider_controls_side';
		return $classes;
	}
}

// Return list with popup engines
if ( !function_exists( 'kindlycare_get_list_popup_engines' ) ) {
	function kindlycare_get_list_popup_engines($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_popup_engines'))=='') {
			$list = array(
				"pretty"	=> esc_html__("Pretty photo", 'kindlycare'),
				"magnific"	=> esc_html__("Magnific popup", 'kindlycare')
				);
			$list = apply_filters('kindlycare_filter_list_popup_engines', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_popup_engines', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return menus list, prepended inherit
if ( !function_exists( 'kindlycare_get_list_menus' ) ) {
	function kindlycare_get_list_menus($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_menus'))=='') {
			$list = array();
			$list['default'] = esc_html__("Default", 'kindlycare');
			$menus = wp_get_nav_menus();
			if (is_array($menus) && count($menus) > 0) {
				foreach ($menus as $menu) {
					$list[$menu->slug] = $menu->name;
				}
			}
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_menus', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return custom sidebars list, prepended inherit and main sidebars item (if need)
if ( !function_exists( 'kindlycare_get_list_sidebars' ) ) {
	function kindlycare_get_list_sidebars($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_sidebars'))=='') {
			if (($list = kindlycare_storage_get('registered_sidebars'))=='') $list = array();
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_sidebars', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return sidebars positions
if ( !function_exists( 'kindlycare_get_list_sidebars_positions' ) ) {
	function kindlycare_get_list_sidebars_positions($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_sidebars_positions'))=='') {
			$list = array(
				'none'  => esc_html__('Hide',  'kindlycare'),
				'left'  => esc_html__('Left',  'kindlycare'),
				'right' => esc_html__('Right', 'kindlycare')
				);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_sidebars_positions', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return sidebars class
if ( !function_exists( 'kindlycare_get_sidebar_class' ) ) {
	function kindlycare_get_sidebar_class() {
		$sb_main = kindlycare_get_custom_option('show_sidebar_main');
		$sb_outer = kindlycare_get_custom_option('show_sidebar_outer');
		return (kindlycare_param_is_off($sb_main) ? 'sidebar_hide' : 'sidebar_show sidebar_'.($sb_main))
				. ' ' . (kindlycare_param_is_off($sb_outer) ? 'sidebar_outer_hide' : 'sidebar_outer_show sidebar_outer_'.($sb_outer));
	}
}

// Return body styles list, prepended inherit
if ( !function_exists( 'kindlycare_get_list_body_styles' ) ) {
	function kindlycare_get_list_body_styles($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_body_styles'))=='') {
			$list = array(
				'boxed'	=> esc_html__('Boxed',		'kindlycare'),
				'wide'	=> esc_html__('Wide',		'kindlycare')
				);
			if (kindlycare_get_theme_setting('allow_fullscreen')) {
				$list['fullwide']	= esc_html__('Fullwide',	'kindlycare');
				$list['fullscreen']	= esc_html__('Fullscreen',	'kindlycare');
			}
			$list = apply_filters('kindlycare_filter_list_body_styles', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_body_styles', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return skins list, prepended inherit
if ( !function_exists( 'kindlycare_get_list_skins' ) ) {
	function kindlycare_get_list_skins($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_skins'))=='') {
			$list = kindlycare_get_list_folders("skins");
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_skins', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list folders inside specified folder in the child theme dir (if exists) or main theme dir
if (!function_exists('kindlycare_get_list_folders')) {
    function kindlycare_get_list_folders($folder, $only_names=true) {
        $dir = kindlycare_get_folder_dir($folder);
        $url = kindlycare_get_folder_url($folder);
        $list = array();
        if ( is_dir($dir) ) {
            $hdir = @opendir( $dir );
            if ( $hdir ) {
                while (($file = readdir( $hdir ) ) !== false ) {
                    if ( substr($file, 0, 1) == '.' || !is_dir( ($dir) . '/' . ($file) ) )
                        continue;
                    $key = $file;
                    $list[$key] = $only_names ? kindlycare_strtoproper($key) : ($url) . '/' . ($file);
                }
                @closedir( $hdir );
            }
        }
        return $list;
    }
}

// Return templates list, prepended inherit
if ( !function_exists( 'kindlycare_get_list_templates' ) ) {
	function kindlycare_get_list_templates($mode='') {
		if (($list = kindlycare_storage_get('list_templates_'.($mode)))=='') {
			$list = array();
			$tpl = kindlycare_storage_get('registered_templates');
			if (is_array($tpl) && count($tpl) > 0) {
				foreach ($tpl as $k=>$v) {
					if ($mode=='' || in_array($mode, explode(',', $v['mode'])))
						$list[$k] = !empty($v['icon']) 
									? $v['icon'] 
									: (!empty($v['title']) 
										? $v['title'] 
										: kindlycare_strtoproper($v['layout'])
										);
				}
			}
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_templates_'.($mode), $list);
		}
		return $list;
	}
}

// Return blog styles list, prepended inherit
if ( !function_exists( 'kindlycare_get_list_templates_blog' ) ) {
	function kindlycare_get_list_templates_blog($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_templates_blog'))=='') {
			$list = kindlycare_get_list_templates('blog');
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_templates_blog', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return blogger styles list, prepended inherit
if ( !function_exists( 'kindlycare_get_list_templates_blogger' ) ) {
	function kindlycare_get_list_templates_blogger($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_templates_blogger'))=='') {
			$list = kindlycare_array_merge(kindlycare_get_list_templates('blogger'), kindlycare_get_list_templates('blog'));
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_templates_blogger', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return single page styles list, prepended inherit
if ( !function_exists( 'kindlycare_get_list_templates_single' ) ) {
	function kindlycare_get_list_templates_single($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_templates_single'))=='') {
			$list = kindlycare_get_list_templates('single');
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_templates_single', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return header styles list, prepended inherit
if ( !function_exists( 'kindlycare_get_list_templates_header' ) ) {
	function kindlycare_get_list_templates_header($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_templates_header'))=='') {
			$list = kindlycare_get_list_templates('header');
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_templates_header', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return form styles list, prepended inherit
if ( !function_exists( 'kindlycare_get_list_templates_forms' ) ) {
	function kindlycare_get_list_templates_forms($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_templates_forms'))=='') {
			$list = kindlycare_get_list_templates('forms');
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_templates_forms', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return article styles list, prepended inherit
if ( !function_exists( 'kindlycare_get_list_article_styles' ) ) {
	function kindlycare_get_list_article_styles($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_article_styles'))=='') {
			$list = array(
				"boxed"   => esc_html__('Boxed', 'kindlycare'),
				"stretch" => esc_html__('Stretch', 'kindlycare')
				);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_article_styles', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return post-formats filters list, prepended inherit
if ( !function_exists( 'kindlycare_get_list_post_formats_filters' ) ) {
	function kindlycare_get_list_post_formats_filters($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_post_formats_filters'))=='') {
			$list = array(
				"no"      => esc_html__('All posts', 'kindlycare'),
				"thumbs"  => esc_html__('With thumbs', 'kindlycare'),
				"reviews" => esc_html__('With reviews', 'kindlycare'),
				"video"   => esc_html__('With videos', 'kindlycare'),
				"audio"   => esc_html__('With audios', 'kindlycare'),
				"gallery" => esc_html__('With galleries', 'kindlycare')
				);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_post_formats_filters', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return portfolio filters list, prepended inherit
if ( !function_exists( 'kindlycare_get_list_portfolio_filters' ) ) {
	function kindlycare_get_list_portfolio_filters($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_portfolio_filters'))=='') {
			$list = array(
				"hide"		=> esc_html__('Hide', 'kindlycare'),
				"tags"		=> esc_html__('Tags', 'kindlycare'),
				"categories"=> esc_html__('Categories', 'kindlycare')
				);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_portfolio_filters', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return hover styles list, prepended inherit
if ( !function_exists( 'kindlycare_get_list_hovers' ) ) {
	function kindlycare_get_list_hovers($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_hovers'))=='') {
			$list = array();
			$list['circle effect1']  = esc_html__('Circle Effect 1',  'kindlycare');
			$list['circle effect2']  = esc_html__('Circle Effect 2',  'kindlycare');
			$list['circle effect3']  = esc_html__('Circle Effect 3',  'kindlycare');
			$list['circle effect4']  = esc_html__('Circle Effect 4',  'kindlycare');
			$list['circle effect5']  = esc_html__('Circle Effect 5',  'kindlycare');
			$list['circle effect6']  = esc_html__('Circle Effect 6',  'kindlycare');
			$list['circle effect7']  = esc_html__('Circle Effect 7',  'kindlycare');
			$list['circle effect8']  = esc_html__('Circle Effect 8',  'kindlycare');
			$list['circle effect9']  = esc_html__('Circle Effect 9',  'kindlycare');
			$list['circle effect10'] = esc_html__('Circle Effect 10',  'kindlycare');
			$list['circle effect11'] = esc_html__('Circle Effect 11',  'kindlycare');
			$list['circle effect12'] = esc_html__('Circle Effect 12',  'kindlycare');
			$list['circle effect13'] = esc_html__('Circle Effect 13',  'kindlycare');
			$list['circle effect14'] = esc_html__('Circle Effect 14',  'kindlycare');
			$list['circle effect15'] = esc_html__('Circle Effect 15',  'kindlycare');
			$list['circle effect16'] = esc_html__('Circle Effect 16',  'kindlycare');
			$list['circle effect17'] = esc_html__('Circle Effect 17',  'kindlycare');
			$list['circle effect18'] = esc_html__('Circle Effect 18',  'kindlycare');
			$list['circle effect19'] = esc_html__('Circle Effect 19',  'kindlycare');
			$list['circle effect20'] = esc_html__('Circle Effect 20',  'kindlycare');
			$list['square effect1']  = esc_html__('Square Effect 1',  'kindlycare');
			$list['square effect2']  = esc_html__('Square Effect 2',  'kindlycare');
			$list['square effect3']  = esc_html__('Square Effect 3',  'kindlycare');
	//		$list['square effect4']  = esc_html__('Square Effect 4',  'kindlycare');
			$list['square effect5']  = esc_html__('Square Effect 5',  'kindlycare');
			$list['square effect6']  = esc_html__('Square Effect 6',  'kindlycare');
			$list['square effect7']  = esc_html__('Square Effect 7',  'kindlycare');
			$list['square effect8']  = esc_html__('Square Effect 8',  'kindlycare');
			$list['square effect9']  = esc_html__('Square Effect 9',  'kindlycare');
			$list['square effect10'] = esc_html__('Square Effect 10',  'kindlycare');
			$list['square effect11'] = esc_html__('Square Effect 11',  'kindlycare');
			$list['square effect12'] = esc_html__('Square Effect 12',  'kindlycare');
			$list['square effect13'] = esc_html__('Square Effect 13',  'kindlycare');
			$list['square effect14'] = esc_html__('Square Effect 14',  'kindlycare');
			$list['square effect15'] = esc_html__('Square Effect 15',  'kindlycare');
			$list['square effect_dir']   = esc_html__('Square Effect Dir',   'kindlycare');
			$list['square effect_shift'] = esc_html__('Square Effect Shift', 'kindlycare');
			$list['square effect_book']  = esc_html__('Square Effect Book',  'kindlycare');
			$list['square effect_more']  = esc_html__('Square Effect More',  'kindlycare');
			$list['square effect_fade']  = esc_html__('Square Effect Fade',  'kindlycare');
			$list = apply_filters('kindlycare_filter_portfolio_hovers', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_hovers', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return list of the blog counters
if ( !function_exists( 'kindlycare_get_list_blog_counters' ) ) {
	function kindlycare_get_list_blog_counters($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_blog_counters'))=='') {
			$list = array(
				'views'		=> esc_html__('Views', 'kindlycare'),
				'likes'		=> esc_html__('Likes', 'kindlycare'),
				'rating'	=> esc_html__('Rating', 'kindlycare'),
				'comments'	=> esc_html__('Comments', 'kindlycare')
				);
			$list = apply_filters('kindlycare_filter_list_blog_counters', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_blog_counters', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list of the item sizes for the portfolio alter style, prepended inherit
if ( !function_exists( 'kindlycare_get_list_alter_sizes' ) ) {
	function kindlycare_get_list_alter_sizes($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_alter_sizes'))=='') {
			$list = array(
					'1_1' => esc_html__('1x1', 'kindlycare'),
					'1_2' => esc_html__('1x2', 'kindlycare'),
					'2_1' => esc_html__('2x1', 'kindlycare'),
					'2_2' => esc_html__('2x2', 'kindlycare'),
					'1_3' => esc_html__('1x3', 'kindlycare'),
					'2_3' => esc_html__('2x3', 'kindlycare'),
					'3_1' => esc_html__('3x1', 'kindlycare'),
					'3_2' => esc_html__('3x2', 'kindlycare'),
					'3_3' => esc_html__('3x3', 'kindlycare')
					);
			$list = apply_filters('kindlycare_filter_portfolio_alter_sizes', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_alter_sizes', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return extended hover directions list, prepended inherit
if ( !function_exists( 'kindlycare_get_list_hovers_directions' ) ) {
	function kindlycare_get_list_hovers_directions($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_hovers_directions'))=='') {
			$list = array(
				'left_to_right' => esc_html__('Left to Right',  'kindlycare'),
				'right_to_left' => esc_html__('Right to Left',  'kindlycare'),
				'top_to_bottom' => esc_html__('Top to Bottom',  'kindlycare'),
				'bottom_to_top' => esc_html__('Bottom to Top',  'kindlycare'),
				'scale_up'      => esc_html__('Scale Up',  'kindlycare'),
				'scale_down'    => esc_html__('Scale Down',  'kindlycare'),
				'scale_down_up' => esc_html__('Scale Down-Up',  'kindlycare'),
				'from_left_and_right' => esc_html__('From Left and Right',  'kindlycare'),
				'from_top_and_bottom' => esc_html__('From Top and Bottom',  'kindlycare')
			);
			$list = apply_filters('kindlycare_filter_portfolio_hovers_directions', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_hovers_directions', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return list of the label positions in the custom forms
if ( !function_exists( 'kindlycare_get_list_label_positions' ) ) {
	function kindlycare_get_list_label_positions($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_label_positions'))=='') {
			$list = array(
				'top'		=> esc_html__('Top',		'kindlycare'),
				'bottom'	=> esc_html__('Bottom',		'kindlycare'),
				'left'		=> esc_html__('Left',		'kindlycare'),
				'over'		=> esc_html__('Over',		'kindlycare')
			);
			$list = apply_filters('kindlycare_filter_label_positions', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_label_positions', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return list of the bg image positions
if ( !function_exists( 'kindlycare_get_list_bg_image_positions' ) ) {
	function kindlycare_get_list_bg_image_positions($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_bg_image_positions'))=='') {
			$list = array(
				'left top'	   => esc_html__('Left Top', 'kindlycare'),
				'center top'   => esc_html__("Center Top", 'kindlycare'),
				'right top'    => esc_html__("Right Top", 'kindlycare'),
				'left center'  => esc_html__("Left Center", 'kindlycare'),
				'center center'=> esc_html__("Center Center", 'kindlycare'),
				'right center' => esc_html__("Right Center", 'kindlycare'),
				'left bottom'  => esc_html__("Left Bottom", 'kindlycare'),
				'center bottom'=> esc_html__("Center Bottom", 'kindlycare'),
				'right bottom' => esc_html__("Right Bottom", 'kindlycare')
			);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_bg_image_positions', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return list of the bg image repeat
if ( !function_exists( 'kindlycare_get_list_bg_image_repeats' ) ) {
	function kindlycare_get_list_bg_image_repeats($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_bg_image_repeats'))=='') {
			$list = array(
				'repeat'	=> esc_html__('Repeat', 'kindlycare'),
				'repeat-x'	=> esc_html__('Repeat X', 'kindlycare'),
				'repeat-y'	=> esc_html__('Repeat Y', 'kindlycare'),
				'no-repeat'	=> esc_html__('No Repeat', 'kindlycare')
			);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_bg_image_repeats', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return list of the bg image attachment
if ( !function_exists( 'kindlycare_get_list_bg_image_attachments' ) ) {
	function kindlycare_get_list_bg_image_attachments($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_bg_image_attachments'))=='') {
			$list = array(
				'scroll'	=> esc_html__('Scroll', 'kindlycare'),
				'fixed'		=> esc_html__('Fixed', 'kindlycare'),
				'local'		=> esc_html__('Local', 'kindlycare')
			);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_bg_image_attachments', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}


// Return list of the bg tints
if ( !function_exists( 'kindlycare_get_list_bg_tints' ) ) {
	function kindlycare_get_list_bg_tints($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_bg_tints'))=='') {
			$list = array(
				'white'	=> esc_html__('White', 'kindlycare'),
				'light'	=> esc_html__('Light', 'kindlycare'),
				'dark'	=> esc_html__('Dark', 'kindlycare')
			);
			$list = apply_filters('kindlycare_filter_bg_tints', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_bg_tints', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return custom fields types list, prepended inherit
if ( !function_exists( 'kindlycare_get_list_field_types' ) ) {
	function kindlycare_get_list_field_types($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_field_types'))=='') {
			$list = array(
				'text'     => esc_html__('Text',  'kindlycare'),
				'textarea' => esc_html__('Text Area','kindlycare'),
				'password' => esc_html__('Password',  'kindlycare'),
				'radio'    => esc_html__('Radio',  'kindlycare'),
				'checkbox' => esc_html__('Checkbox',  'kindlycare'),
				'select'   => esc_html__('Select',  'kindlycare'),
				'date'     => esc_html__('Date','kindlycare'),
				'time'     => esc_html__('Time','kindlycare'),
				'button'   => esc_html__('Button','kindlycare')
			);
			$list = apply_filters('kindlycare_filter_field_types', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_field_types', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return Google map styles
if ( !function_exists( 'kindlycare_get_list_googlemap_styles' ) ) {
	function kindlycare_get_list_googlemap_styles($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_googlemap_styles'))=='') {
			$list = array(
				'default' => esc_html__('Default', 'kindlycare')
			);
			$list = apply_filters('kindlycare_filter_googlemap_styles', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_googlemap_styles', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return iconed classes list
if ( !function_exists( 'kindlycare_get_list_icons' ) ) {
	function kindlycare_get_list_icons($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_icons'))=='') {
			$list = kindlycare_parse_icons_classes(kindlycare_get_file_dir("css/fontello/css/fontello-codes.css"));
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_icons', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return socials list
if ( !function_exists( 'kindlycare_get_list_socials' ) ) {
	function kindlycare_get_list_socials($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_socials'))=='') {
			$list = kindlycare_get_list_images("images/socials", "png");
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_socials', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list with 'Yes' and 'No' items
if ( !function_exists( 'kindlycare_get_list_yesno' ) ) {
	function kindlycare_get_list_yesno($prepend_inherit=false) {
		$list = array(
			'yes' => esc_html__("Yes", 'kindlycare'),
			'no'  => esc_html__("No", 'kindlycare')
		);
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list with 'On' and 'Of' items
if ( !function_exists( 'kindlycare_get_list_onoff' ) ) {
	function kindlycare_get_list_onoff($prepend_inherit=false) {
		$list = array(
			"on" => esc_html__("On", 'kindlycare'),
			"off" => esc_html__("Off", 'kindlycare')
		);
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list with 'Show' and 'Hide' items
if ( !function_exists( 'kindlycare_get_list_showhide' ) ) {
	function kindlycare_get_list_showhide($prepend_inherit=false) {
		$list = array(
			"show" => esc_html__("Show", 'kindlycare'),
			"hide" => esc_html__("Hide", 'kindlycare')
		);
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list with 'Ascending' and 'Descending' items
if ( !function_exists( 'kindlycare_get_list_orderings' ) ) {
	function kindlycare_get_list_orderings($prepend_inherit=false) {
		$list = array(
			"asc" => esc_html__("Ascending", 'kindlycare'),
			"desc" => esc_html__("Descending", 'kindlycare')
		);
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list with 'Horizontal' and 'Vertical' items
if ( !function_exists( 'kindlycare_get_list_directions' ) ) {
	function kindlycare_get_list_directions($prepend_inherit=false) {
		$list = array(
			"horizontal" => esc_html__("Horizontal", 'kindlycare'),
			"vertical" => esc_html__("Vertical", 'kindlycare')
		);
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list with item's shapes
if ( !function_exists( 'kindlycare_get_list_shapes' ) ) {
	function kindlycare_get_list_shapes($prepend_inherit=false) {
		$list = array(
			"round"  => esc_html__("Round", 'kindlycare'),
			"square" => esc_html__("Square", 'kindlycare')
		);
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list with item's sizes
if ( !function_exists( 'kindlycare_get_list_sizes' ) ) {
	function kindlycare_get_list_sizes($prepend_inherit=false) {
		$list = array(
			"tiny"   => esc_html__("Tiny", 'kindlycare'),
			"small"  => esc_html__("Small", 'kindlycare'),
			"medium" => esc_html__("Medium", 'kindlycare'),
			"large"  => esc_html__("Large", 'kindlycare')
		);
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list with slider (scroll) controls positions
if ( !function_exists( 'kindlycare_get_list_controls' ) ) {
	function kindlycare_get_list_controls($prepend_inherit=false) {
		$list = array(
			"hide" => esc_html__("Hide", 'kindlycare'),
			"side" => esc_html__("Side", 'kindlycare'),
			"bottom" => esc_html__("Bottom", 'kindlycare')
		);
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list with float items
if ( !function_exists( 'kindlycare_get_list_floats' ) ) {
	function kindlycare_get_list_floats($prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'kindlycare'),
			"left" => esc_html__("Float Left", 'kindlycare'),
			"right" => esc_html__("Float Right", 'kindlycare')
		);
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list with alignment items
if ( !function_exists( 'kindlycare_get_list_alignments' ) ) {
	function kindlycare_get_list_alignments($justify=false, $prepend_inherit=false) {
		$list = array(
			"none" => esc_html__("None", 'kindlycare'),
			"left" => esc_html__("Left", 'kindlycare'),
			"center" => esc_html__("Center", 'kindlycare'),
			"right" => esc_html__("Right", 'kindlycare')
		);
		if ($justify) $list["justify"] = esc_html__("Justify", 'kindlycare');
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list with horizontal positions
if ( !function_exists( 'kindlycare_get_list_hpos' ) ) {
	function kindlycare_get_list_hpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['left'] = esc_html__("Left", 'kindlycare');
		if ($center) $list['center'] = esc_html__("Center", 'kindlycare');
		$list['right'] = esc_html__("Right", 'kindlycare');
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list with vertical positions
if ( !function_exists( 'kindlycare_get_list_vpos' ) ) {
	function kindlycare_get_list_vpos($prepend_inherit=false, $center=false) {
		$list = array();
		$list['top'] = esc_html__("Top", 'kindlycare');
		if ($center) $list['center'] = esc_html__("Center", 'kindlycare');
		$list['bottom'] = esc_html__("Bottom", 'kindlycare');
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return sorting list items
if ( !function_exists( 'kindlycare_get_list_sortings' ) ) {
	function kindlycare_get_list_sortings($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_sortings'))=='') {
			$list = array(
				"date" => esc_html__("Date", 'kindlycare'),
				"title" => esc_html__("Alphabetically", 'kindlycare'),
				"views" => esc_html__("Popular (views count)", 'kindlycare'),
				"comments" => esc_html__("Most commented (comments count)", 'kindlycare'),
				"author_rating" => esc_html__("Author rating", 'kindlycare'),
				"users_rating" => esc_html__("Visitors (users) rating", 'kindlycare'),
				"random" => esc_html__("Random", 'kindlycare')
			);
			$list = apply_filters('kindlycare_filter_list_sortings', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_sortings', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list with columns widths
if ( !function_exists( 'kindlycare_get_list_columns' ) ) {
	function kindlycare_get_list_columns($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_columns'))=='') {
			$list = array(
				"none" => esc_html__("None", 'kindlycare'),
				"1_1" => esc_html__("100%", 'kindlycare'),
				"1_2" => esc_html__("1/2", 'kindlycare'),
				"1_3" => esc_html__("1/3", 'kindlycare'),
				"2_3" => esc_html__("2/3", 'kindlycare'),
				"1_4" => esc_html__("1/4", 'kindlycare'),
				"3_4" => esc_html__("3/4", 'kindlycare'),
				"1_5" => esc_html__("1/5", 'kindlycare'),
				"2_5" => esc_html__("2/5", 'kindlycare'),
				"3_5" => esc_html__("3/5", 'kindlycare'),
				"4_5" => esc_html__("4/5", 'kindlycare'),
				"1_6" => esc_html__("1/6", 'kindlycare'),
				"5_6" => esc_html__("5/6", 'kindlycare'),
				"1_7" => esc_html__("1/7", 'kindlycare'),
				"2_7" => esc_html__("2/7", 'kindlycare'),
				"3_7" => esc_html__("3/7", 'kindlycare'),
				"4_7" => esc_html__("4/7", 'kindlycare'),
				"5_7" => esc_html__("5/7", 'kindlycare'),
				"6_7" => esc_html__("6/7", 'kindlycare'),
				"1_8" => esc_html__("1/8", 'kindlycare'),
				"3_8" => esc_html__("3/8", 'kindlycare'),
				"5_8" => esc_html__("5/8", 'kindlycare'),
				"7_8" => esc_html__("7/8", 'kindlycare'),
				"1_9" => esc_html__("1/9", 'kindlycare'),
				"2_9" => esc_html__("2/9", 'kindlycare'),
				"4_9" => esc_html__("4/9", 'kindlycare'),
				"5_9" => esc_html__("5/9", 'kindlycare'),
				"7_9" => esc_html__("7/9", 'kindlycare'),
				"8_9" => esc_html__("8/9", 'kindlycare'),
				"1_10"=> esc_html__("1/10", 'kindlycare'),
				"3_10"=> esc_html__("3/10", 'kindlycare'),
				"7_10"=> esc_html__("7/10", 'kindlycare'),
				"9_10"=> esc_html__("9/10", 'kindlycare'),
				"1_11"=> esc_html__("1/11", 'kindlycare'),
				"2_11"=> esc_html__("2/11", 'kindlycare'),
				"3_11"=> esc_html__("3/11", 'kindlycare'),
				"4_11"=> esc_html__("4/11", 'kindlycare'),
				"5_11"=> esc_html__("5/11", 'kindlycare'),
				"6_11"=> esc_html__("6/11", 'kindlycare'),
				"7_11"=> esc_html__("7/11", 'kindlycare'),
				"8_11"=> esc_html__("8/11", 'kindlycare'),
				"9_11"=> esc_html__("9/11", 'kindlycare'),
				"10_11"=> esc_html__("10/11", 'kindlycare'),
				"1_12"=> esc_html__("1/12", 'kindlycare'),
				"5_12"=> esc_html__("5/12", 'kindlycare'),
				"7_12"=> esc_html__("7/12", 'kindlycare'),
				"10_12"=> esc_html__("10/12", 'kindlycare'),
				"11_12"=> esc_html__("11/12", 'kindlycare')
			);
			$list = apply_filters('kindlycare_filter_list_columns', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_columns', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return list of locations for the dedicated content
if ( !function_exists( 'kindlycare_get_list_dedicated_locations' ) ) {
	function kindlycare_get_list_dedicated_locations($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_dedicated_locations'))=='') {
			$list = array(
				"default" => esc_html__('As in the post defined', 'kindlycare'),
				"center"  => esc_html__('Above the text of the post', 'kindlycare'),
				"left"    => esc_html__('To the left the text of the post', 'kindlycare'),
				"right"   => esc_html__('To the right the text of the post', 'kindlycare'),
				"alter"   => esc_html__('Alternates for each post', 'kindlycare')
			);
			$list = apply_filters('kindlycare_filter_list_dedicated_locations', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_dedicated_locations', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return post-format name
if ( !function_exists( 'kindlycare_get_post_format_name' ) ) {
	function kindlycare_get_post_format_name($format, $single=true) {
		$name = '';
		if ($format=='gallery')		$name = $single ? esc_html__('gallery', 'kindlycare') : esc_html__('galleries', 'kindlycare');
		else if ($format=='video')	$name = $single ? esc_html__('video', 'kindlycare') : esc_html__('videos', 'kindlycare');
		else if ($format=='audio')	$name = $single ? esc_html__('audio', 'kindlycare') : esc_html__('audios', 'kindlycare');
		else if ($format=='image')	$name = $single ? esc_html__('image', 'kindlycare') : esc_html__('images', 'kindlycare');
		else if ($format=='quote')	$name = $single ? esc_html__('quote', 'kindlycare') : esc_html__('quotes', 'kindlycare');
		else if ($format=='link')	$name = $single ? esc_html__('link', 'kindlycare') : esc_html__('links', 'kindlycare');
		else if ($format=='status')	$name = $single ? esc_html__('status', 'kindlycare') : esc_html__('statuses', 'kindlycare');
		else if ($format=='aside')	$name = $single ? esc_html__('aside', 'kindlycare') : esc_html__('asides', 'kindlycare');
		else if ($format=='chat')	$name = $single ? esc_html__('chat', 'kindlycare') : esc_html__('chats', 'kindlycare');
		else						$name = $single ? esc_html__('standard', 'kindlycare') : esc_html__('standards', 'kindlycare');
		return apply_filters('kindlycare_filter_list_post_format_name', $name, $format);
	}
}

// Return post-format icon name (from Fontello library)
if ( !function_exists( 'kindlycare_get_post_format_icon' ) ) {
	function kindlycare_get_post_format_icon($format) {
		$icon = 'icon-';
		if ($format=='gallery')		$icon .= 'pictures';
		else if ($format=='video')	$icon .= 'video';
		else if ($format=='audio')	$icon .= 'note';
		else if ($format=='image')	$icon .= 'picture';
		else if ($format=='quote')	$icon .= 'quote';
		else if ($format=='link')	$icon .= 'link';
		else if ($format=='status')	$icon .= 'comment';
		else if ($format=='aside')	$icon .= 'doc-text';
		else if ($format=='chat')	$icon .= 'chat';
		else						$icon .= 'book-open';
		return apply_filters('kindlycare_filter_list_post_format_icon', $icon, $format);
	}
}

// Return fonts styles list, prepended inherit
if ( !function_exists( 'kindlycare_get_list_fonts_styles' ) ) {
	function kindlycare_get_list_fonts_styles($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_fonts_styles'))=='') {
			$list = array(
				'i' => esc_html__('I','kindlycare'),
				'u' => esc_html__('U', 'kindlycare')
			);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_fonts_styles', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return Google fonts list
if ( !function_exists( 'kindlycare_get_list_fonts' ) ) {
	function kindlycare_get_list_fonts($prepend_inherit=false) {
		if (($list = kindlycare_storage_get('list_fonts'))=='') {
			$list = array();
			$list = kindlycare_array_merge($list, kindlycare_get_list_font_faces());
			// Google and custom fonts list:
			//$list['Advent Pro'] = array(
			//		'family'=>'sans-serif',																						// (required) font family
			//		'link'=>'Advent+Pro:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic',	// (optional) if you use Google font repository
			//		'css'=>kindlycare_get_file_url('/css/font-face/Advent-Pro/stylesheet.css')									// (optional) if you use custom font-face
			//		);
			$list = kindlycare_array_merge($list, array(
				'Advent Pro' => array('family'=>'sans-serif'),
				'Alegreya Sans' => array('family'=>'sans-serif'),
				'Arimo' => array('family'=>'sans-serif'),
				'Asap' => array('family'=>'sans-serif'),
				'Averia Sans Libre' => array('family'=>'cursive'),
				'Averia Serif Libre' => array('family'=>'cursive'),
				'Bree Serif' => array('family'=>'serif',),
				'Cabin' => array('family'=>'sans-serif'),
				'Cabin Condensed' => array('family'=>'sans-serif'),
				'Caudex' => array('family'=>'serif'),
				'Comfortaa' => array('family'=>'cursive'),
				'Cousine' => array('family'=>'sans-serif'),
				'Crimson Text' => array('family'=>'serif'),
				'Cuprum' => array('family'=>'sans-serif'),
				'Dosis' => array('family'=>'sans-serif'),
				'Economica' => array('family'=>'sans-serif'),
				'Exo' => array('family'=>'sans-serif'),
				'Expletus Sans' => array('family'=>'cursive'),
				'Karla' => array('family'=>'sans-serif'),
				'Lato' => array('family'=>'sans-serif'),
				'Lekton' => array('family'=>'sans-serif'),
				'Lobster Two' => array('family'=>'cursive'),
				'Maven Pro' => array('family'=>'sans-serif'),
				'Merriweather' => array('family'=>'serif'),
				'Montserrat' => array('family'=>'sans-serif'),
				'Neuton' => array('family'=>'serif'),
				'Noticia Text' => array('family'=>'serif'),
				'Old Standard TT' => array('family'=>'serif'),
				'Open Sans' => array('family'=>'sans-serif'),
				'Orbitron' => array('family'=>'sans-serif'),
				'Oswald' => array('family'=>'sans-serif'),
				'Overlock' => array('family'=>'cursive'),
				'Oxygen' => array('family'=>'sans-serif'),
				'Philosopher' => array('family'=>'serif'),
				'PT Serif' => array('family'=>'serif'),
				'Puritan' => array('family'=>'sans-serif'),
				'Raleway' => array('family'=>'sans-serif'),
				'Roboto' => array('family'=>'sans-serif'),
				'Roboto Slab' => array('family'=>'sans-serif'),
				'Roboto Condensed' => array('family'=>'sans-serif'),
				'Rosario' => array('family'=>'sans-serif'),
				'Share' => array('family'=>'cursive'),
				'Signika' => array('family'=>'sans-serif'),
				'Signika Negative' => array('family'=>'sans-serif'),
				'Source Sans Pro' => array('family'=>'sans-serif'),
				'Tinos' => array('family'=>'serif'),
				'Ubuntu' => array('family'=>'sans-serif'),
				'Vollkorn' => array('family'=>'serif')
				)
			);
			$list = apply_filters('kindlycare_filter_list_fonts', $list);
			if (kindlycare_get_theme_setting('use_list_cache')) kindlycare_storage_set('list_fonts', $list);
		}
		return $prepend_inherit ? kindlycare_array_merge(array('inherit' => esc_html__("Inherit", 'kindlycare')), $list) : $list;
	}
}

// Return Custom font-face list
if ( !function_exists( 'kindlycare_get_list_font_faces' ) ) {
    function kindlycare_get_list_font_faces($prepend_inherit=false) {
        static $list = false;
        if (is_array($list)) return $list;
        $list = array();
	    $dir = kindlycare_get_folder_dir("css/font-face");
	    if (is_dir($dir)) {
	    	$hdir = @ opendir( $dir);
	    	if ( $hdir ) {
	    		while (($file = readdir( $hdir )) !== false ) {
	    			$pi = pathinfo(( $dir ) . '/' . ($file));
	    			if ( substr($file, 0, 1) == '.' || ! is_dir(($dir) . '/' . ($file)))
	    				continue;
	    			$css = file_exists(($dir) . '/' . ($file) . '/' . ($file) . '.css')
					    ? kindlycare_get_file_url("css/font-face" . ($file) . '/' . ($file) . '.css')
					    : (file_exists($dir) . '/' . ($file) . '/stylesheet.css' )
					        ? kindlycare_get_file_url ("css/font-face/".($file).'/stylesheet.css')
						    : '';
					if ($css != '')
						$list[$file] = array('css' => $css);
			    }
			    @closedir( $hdir);
	    	}
        }
        return $list;
    }
}



?>