<?php
/* Woocommerce support functions
------------------------------------------------------------------------------- */

// Theme init
if (!function_exists('kindlycare_woocommerce_theme_setup')) {
	add_action( 'kindlycare_action_before_init_theme', 'kindlycare_woocommerce_theme_setup', 1 );
	function kindlycare_woocommerce_theme_setup() {

		if (kindlycare_exists_woocommerce()) {
			add_action('kindlycare_action_add_styles', 				'kindlycare_woocommerce_frontend_scripts' );

			// Detect current page type, taxonomy and title (for custom post_types use priority < 10 to fire it handles early, than for standard post types)
			add_filter('kindlycare_filter_get_blog_type',				'kindlycare_woocommerce_get_blog_type', 9, 2);
			add_filter('kindlycare_filter_get_blog_title',			'kindlycare_woocommerce_get_blog_title', 9, 2);
			add_filter('kindlycare_filter_get_current_taxonomy',		'kindlycare_woocommerce_get_current_taxonomy', 9, 2);
			add_filter('kindlycare_filter_is_taxonomy',				'kindlycare_woocommerce_is_taxonomy', 9, 2);
			add_filter('kindlycare_filter_get_stream_page_title',		'kindlycare_woocommerce_get_stream_page_title', 9, 2);
			add_filter('kindlycare_filter_get_stream_page_link',		'kindlycare_woocommerce_get_stream_page_link', 9, 2);
			add_filter('kindlycare_filter_get_stream_page_id',		'kindlycare_woocommerce_get_stream_page_id', 9, 2);
			add_filter('kindlycare_filter_detect_inheritance_key',	'kindlycare_woocommerce_detect_inheritance_key', 9, 1);
			add_filter('kindlycare_filter_detect_template_page_id',	'kindlycare_woocommerce_detect_template_page_id', 9, 2);
			add_filter('kindlycare_filter_orderby_need',				'kindlycare_woocommerce_orderby_need', 9, 2);

			add_filter('kindlycare_filter_list_post_types', 			'kindlycare_woocommerce_list_post_types', 10, 1);

			add_action('kindlycare_action_shortcodes_list', 			'kindlycare_woocommerce_reg_shortcodes', 20);
			if (function_exists('kindlycare_exists_visual_composer') && kindlycare_exists_visual_composer())
				add_action('kindlycare_action_shortcodes_list_vc',	'kindlycare_woocommerce_reg_shortcodes_vc', 20);

			if (is_admin()) {
				add_filter( 'kindlycare_filter_importer_options',				'kindlycare_woocommerce_importer_set_options' );
				add_action( 'kindlycare_action_importer_after_import_posts',	'kindlycare_woocommerce_importer_after_import_posts', 10, 1 );
				add_action( 'kindlycare_action_importer_params',				'kindlycare_woocommerce_importer_show_params', 10, 1 );
				add_action( 'kindlycare_action_importer_import',				'kindlycare_woocommerce_importer_import', 10, 2 );
				add_action( 'kindlycare_action_importer_import_fields',		'kindlycare_woocommerce_importer_import_fields', 10, 1 );
				add_action( 'kindlycare_action_importer_export',				'kindlycare_woocommerce_importer_export', 10, 1 );
				add_action( 'kindlycare_action_importer_export_fields',		'kindlycare_woocommerce_importer_export_fields', 10, 1 );
			}
		}

		if (is_admin()) {
			add_filter( 'kindlycare_filter_importer_required_plugins',		'kindlycare_woocommerce_importer_required_plugins', 10, 2 );
			add_filter( 'kindlycare_filter_required_plugins',					'kindlycare_woocommerce_required_plugins' );
		}
	}
}

if ( !function_exists( 'kindlycare_woocommerce_settings_theme_setup2' ) ) {
	add_action( 'kindlycare_action_before_init_theme', 'kindlycare_woocommerce_settings_theme_setup2', 3 );
	function kindlycare_woocommerce_settings_theme_setup2() {
		if (kindlycare_exists_woocommerce()) {
			// Add WooCommerce pages in the Theme inheritance system
			kindlycare_add_theme_inheritance( array( 'woocommerce' => array(
				'stream_template' => 'blog-woocommerce',		// This params must be empty
				'single_template' => 'single-woocommerce',		// They are specified to enable separate settings for blog and single wooc
				'taxonomy' => array('product_cat'),
				'taxonomy_tags' => array('product_tag'),
				'post_type' => array('product'),
				'override' => 'page'
				) )
			);

			// Add WooCommerce specific options in the Theme Options

			kindlycare_storage_set_array_before('options', 'partition_service', array(

				"partition_woocommerce" => array(
					"title" => esc_html__('WooCommerce', 'kindlycare'),
					"icon" => "iconadmin-basket",
					"type" => "partition"),

				"info_wooc_1" => array(
					"title" => esc_html__('WooCommerce products list parameters', 'kindlycare'),
					"desc" => esc_html__("Select WooCommerce products list's style and crop parameters", 'kindlycare'),
					"type" => "info"),

				"shop_mode" => array(
					"title" => esc_html__('Shop list style',  'kindlycare'),
					"desc" => esc_html__("WooCommerce products list's style: thumbs or list with description", 'kindlycare'),
					"std" => "thumbs",
					"divider" => false,
					"options" => array(
						'thumbs' => esc_html__('Thumbs', 'kindlycare'),
						'list' => esc_html__('List', 'kindlycare')
					),
					"type" => "checklist"),

				"show_mode_buttons" => array(
					"title" => esc_html__('Show style buttons',  'kindlycare'),
					"desc" => esc_html__("Show buttons to allow visitors change list style", 'kindlycare'),
					"std" => "yes",
					"options" => kindlycare_get_options_param('list_yes_no'),
					"type" => "switch"),

				"shop_loop_columns" => array(
					"title" => esc_html__('Shop columns',  'kindlycare'),
					"desc" => esc_html__("How many columns used to show products on shop page", 'kindlycare'),
					"std" => "3",
					"step" => 1,
					"min" => 1,
					"max" => 6,
					"type" => "spinner"),

				"show_currency" => array(
					"title" => esc_html__('Show currency selector', 'kindlycare'),
					"desc" => esc_html__('Show currency selector in the user menu', 'kindlycare'),
					"std" => "yes",
					"options" => kindlycare_get_options_param('list_yes_no'),
					"type" => "switch"),

				"show_cart" => array(
					"title" => esc_html__('Show cart button', 'kindlycare'),
					"desc" => esc_html__('Show cart button in the user menu', 'kindlycare'),
					"std" => "shop",
					"options" => array(
						'hide'   => esc_html__('Hide', 'kindlycare'),
						'always' => esc_html__('Always', 'kindlycare'),
						'shop'   => esc_html__('Only on shop pages', 'kindlycare')
					),
					"type" => "checklist"),

				"crop_product_thumb" => array(
					"title" => esc_html__("Crop product's thumbnail",  'kindlycare'),
					"desc" => esc_html__("Crop product's thumbnails on search results page or scale it", 'kindlycare'),
					"std" => "no",
					"options" => kindlycare_get_options_param('list_yes_no'),
					"type" => "switch")

				)
			);

		}
	}
}

// WooCommerce hooks
if (!function_exists('kindlycare_woocommerce_theme_setup3')) {
	add_action( 'kindlycare_action_after_init_theme', 'kindlycare_woocommerce_theme_setup3' );
	function kindlycare_woocommerce_theme_setup3() {

		if (kindlycare_exists_woocommerce()) {

			add_action(    'woocommerce_before_subcategory_title',		'kindlycare_woocommerce_open_thumb_wrapper', 9 );
			add_action(    'woocommerce_before_shop_loop_item_title',	'kindlycare_woocommerce_open_thumb_wrapper', 9 );

			add_action(    'woocommerce_before_subcategory_title',		'kindlycare_woocommerce_open_item_wrapper', 20 );
			add_action(    'woocommerce_before_shop_loop_item_title',	'kindlycare_woocommerce_open_item_wrapper', 20 );

			add_action(    'woocommerce_after_subcategory',				'kindlycare_woocommerce_close_item_wrapper', 20 );
			add_action(    'woocommerce_after_shop_loop_item',			'kindlycare_woocommerce_close_item_wrapper', 20 );

			add_action(    'woocommerce_after_shop_loop_item_title',	'kindlycare_woocommerce_after_shop_loop_item_title', 7);

			add_action(    'woocommerce_after_subcategory_title',		'kindlycare_woocommerce_after_subcategory_title', 10 );

			// Wrap category title into link
			remove_action( 'woocommerce_shop_loop_subcategory_title',   'woocommerce_template_loop_category_title', 10 );
			add_action(    'woocommerce_shop_loop_subcategory_title',   'kindlycare_woocommerce_shop_loop_subcategory_title', 9, 1);

		}

		if (kindlycare_is_woocommerce_page()) {

			remove_action( 'woocommerce_sidebar', 						'woocommerce_get_sidebar', 10 );					// Remove WOOC sidebar

			remove_action( 'woocommerce_before_main_content',			'woocommerce_output_content_wrapper', 10);
			add_action(    'woocommerce_before_main_content',			'kindlycare_woocommerce_wrapper_start', 10);

			remove_action( 'woocommerce_after_main_content',			'woocommerce_output_content_wrapper_end', 10);
			add_action(    'woocommerce_after_main_content',			'kindlycare_woocommerce_wrapper_end', 10);

			add_action(    'woocommerce_show_page_title',				'kindlycare_woocommerce_show_page_title', 10);

			remove_action( 'woocommerce_single_product_summary',		'woocommerce_template_single_title', 5);
			add_action(    'woocommerce_single_product_summary',		'kindlycare_woocommerce_show_product_title', 5 );

			add_action(    'woocommerce_before_shop_loop', 				'kindlycare_woocommerce_before_shop_loop', 10 );

			remove_action( 'woocommerce_after_shop_loop',				'woocommerce_pagination', 10 );
			add_action(    'woocommerce_after_shop_loop',				'kindlycare_woocommerce_pagination', 10 );

			add_action(    'woocommerce_product_meta_end',				'kindlycare_woocommerce_show_product_id', 10);

			add_filter(    'woocommerce_output_related_products_args',	'kindlycare_woocommerce_output_related_products_args' );

			add_filter(    'woocommerce_product_thumbnails_columns',	'kindlycare_woocommerce_product_thumbnails_columns' );



			add_filter(    'get_product_search_form',					'kindlycare_woocommerce_get_product_search_form' );

			add_filter(    'post_class',								'kindlycare_woocommerce_loop_shop_columns_class' );
			add_action(    'the_title',									'kindlycare_woocommerce_the_title');

			kindlycare_enqueue_popup();
		}
	}
}



// Check if WooCommerce installed and activated
if ( !function_exists( 'kindlycare_exists_woocommerce' ) ) {
	function kindlycare_exists_woocommerce() {
		return class_exists('Woocommerce');
		//return function_exists('is_woocommerce');
	}
}

// Return true, if current page is any woocommerce page
if ( !function_exists( 'kindlycare_is_woocommerce_page' ) ) {
	function kindlycare_is_woocommerce_page() {
		$rez = false;
		if (kindlycare_exists_woocommerce()) {
			if (!kindlycare_storage_empty('pre_query')) {
				$id = kindlycare_storage_get_obj_property('pre_query', 'queried_object_id', 0);
				$rez = kindlycare_storage_call_obj_method('pre_query', 'get', 'post_type')=='product'
						|| $id==wc_get_page_id('shop')
						|| $id==wc_get_page_id('cart')
						|| $id==wc_get_page_id('checkout')
						|| $id==wc_get_page_id('myaccount')
						|| kindlycare_storage_call_obj_method('pre_query', 'is_tax', 'product_cat')
						|| kindlycare_storage_call_obj_method('pre_query', 'is_tax', 'product_tag')
						|| kindlycare_storage_call_obj_method('pre_query', 'is_tax', get_object_taxonomies('product'));

			} else
				$rez = is_shop() || is_product() || is_product_category() || is_product_tag() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page();
		}
		return $rez;
	}
}

// Filter to detect current page inheritance key
if ( !function_exists( 'kindlycare_woocommerce_detect_inheritance_key' ) ) {
	//Handler of add_filter('kindlycare_filter_detect_inheritance_key',	'kindlycare_woocommerce_detect_inheritance_key', 9, 1);
	function kindlycare_woocommerce_detect_inheritance_key($key) {
		if (!empty($key)) return $key;
		return kindlycare_is_woocommerce_page() ? 'woocommerce' : '';
	}
}

// Filter to detect current template page id
if ( !function_exists( 'kindlycare_woocommerce_detect_template_page_id' ) ) {
	//Handler of add_filter('kindlycare_filter_detect_template_page_id',	'kindlycare_woocommerce_detect_template_page_id', 9, 2);
	function kindlycare_woocommerce_detect_template_page_id($id, $key) {
		if (!empty($id)) return $id;
		if ($key == 'woocommerce_cart')				$id = get_option('woocommerce_cart_page_id');
		else if ($key == 'woocommerce_checkout')	$id = get_option('woocommerce_checkout_page_id');
		else if ($key == 'woocommerce_account')		$id = get_option('woocommerce_account_page_id');
		else if ($key == 'woocommerce')				$id = get_option('woocommerce_shop_page_id');
		return $id;
	}
}

// Filter to detect current page type (slug)
if ( !function_exists( 'kindlycare_woocommerce_get_blog_type' ) ) {
	//Handler of add_filter('kindlycare_filter_get_blog_type',	'kindlycare_woocommerce_get_blog_type', 9, 2);
	function kindlycare_woocommerce_get_blog_type($page, $query=null) {
		if (!empty($page)) return $page;

		if (is_shop()) 					$page = 'woocommerce_shop';
		else if ($query && $query->get('post_type')=='product' || is_product())		$page = 'woocommerce_product';
		else if ($query && $query->get('product_tag')!='' || is_product_tag())		$page = 'woocommerce_tag';
		else if ($query && $query->get('product_cat')!='' || is_product_category())	$page = 'woocommerce_category';
		else if (is_cart())				$page = 'woocommerce_cart';
		else if (is_checkout())			$page = 'woocommerce_checkout';
		else if (is_account_page())		$page = 'woocommerce_account';
		else if (is_woocommerce())		$page = 'woocommerce';
		return $page;
	}
}

// Filter to detect current page title
if ( !function_exists( 'kindlycare_woocommerce_get_blog_title' ) ) {
	//Handler of add_filter('kindlycare_filter_get_blog_title',	'kindlycare_woocommerce_get_blog_title', 9, 2);
	function kindlycare_woocommerce_get_blog_title($title, $page) {
		if (!empty($title)) return $title;

		if ( kindlycare_strpos($page, 'woocommerce')!==false ) {
			if ( $page == 'woocommerce_category' ) {
				$term = get_term_by( 'slug', get_query_var( 'product_cat' ), 'product_cat', OBJECT);
				$title = $term->name;
			} else if ( $page == 'woocommerce_tag' ) {
				$term = get_term_by( 'slug', get_query_var( 'product_tag' ), 'product_tag', OBJECT);
				$title = esc_html__('Tag:', 'kindlycare') . ' ' . esc_html($term->name);
			} else if ( $page == 'woocommerce_cart' ) {
				$title = esc_html__( 'Your cart', 'kindlycare' );
			} else if ( $page == 'woocommerce_checkout' ) {
				$title = esc_html__( 'Checkout', 'kindlycare' );
			} else if ( $page == 'woocommerce_account' ) {
				$title = esc_html__( 'Account', 'kindlycare' );
			} else if ( $page == 'woocommerce_product' ) {
				$title = kindlycare_get_post_title();
			} else if (($page_id=get_option('woocommerce_shop_page_id')) > 0) {
				$title = kindlycare_get_post_title($page_id);
			} else {
				$title = esc_html__( 'Shop', 'kindlycare' );
			}
		}

		return $title;
	}
}

// Filter to detect stream page title
if ( !function_exists( 'kindlycare_woocommerce_get_stream_page_title' ) ) {
	//Handler of add_filter('kindlycare_filter_get_stream_page_title',	'kindlycare_woocommerce_get_stream_page_title', 9, 2);
	function kindlycare_woocommerce_get_stream_page_title($title, $page) {
		if (!empty($title)) return $title;
		if (kindlycare_strpos($page, 'woocommerce')!==false) {
			if (($page_id = kindlycare_woocommerce_get_stream_page_id(0, $page)) > 0)
				$title = kindlycare_get_post_title($page_id);
			else
				$title = esc_html__('Shop', 'kindlycare');
		}
		return $title;
	}
}

// Filter to detect stream page ID
if ( !function_exists( 'kindlycare_woocommerce_get_stream_page_id' ) ) {
	//Handler of add_filter('kindlycare_filter_get_stream_page_id',	'kindlycare_woocommerce_get_stream_page_id', 9, 2);
	function kindlycare_woocommerce_get_stream_page_id($id, $page) {
		if (!empty($id)) return $id;
		if (kindlycare_strpos($page, 'woocommerce')!==false) {
			$id = get_option('woocommerce_shop_page_id');
		}
		return $id;
	}
}

// Filter to detect stream page link
if ( !function_exists( 'kindlycare_woocommerce_get_stream_page_link' ) ) {
	//Handler of add_filter('kindlycare_filter_get_stream_page_link',	'kindlycare_woocommerce_get_stream_page_link', 9, 2);
	function kindlycare_woocommerce_get_stream_page_link($url, $page) {
		if (!empty($url)) return $url;
		if (kindlycare_strpos($page, 'woocommerce')!==false) {
			$id = kindlycare_woocommerce_get_stream_page_id(0, $page);
			if ($id) $url = get_permalink($id);
		}
		return $url;
	}
}

// Filter to detect current taxonomy
if ( !function_exists( 'kindlycare_woocommerce_get_current_taxonomy' ) ) {
	//Handler of add_filter('kindlycare_filter_get_current_taxonomy',	'kindlycare_woocommerce_get_current_taxonomy', 9, 2);
	function kindlycare_woocommerce_get_current_taxonomy($tax, $page) {
		if (!empty($tax)) return $tax;
		if ( kindlycare_strpos($page, 'woocommerce')!==false ) {
			$tax = 'product_cat';
		}
		return $tax;
	}
}

// Return taxonomy name (slug) if current page is this taxonomy page
if ( !function_exists( 'kindlycare_woocommerce_is_taxonomy' ) ) {
	//Handler of add_filter('kindlycare_filter_is_taxonomy',	'kindlycare_woocommerce_is_taxonomy', 9, 2);
	function kindlycare_woocommerce_is_taxonomy($tax, $query=null) {
		if (!empty($tax))
			return $tax;
		else
			return $query!==null && $query->get('product_cat')!='' || is_product_category() ? 'product_cat' : '';
	}
}

// Return false if current plugin not need theme orderby setting
if ( !function_exists( 'kindlycare_woocommerce_orderby_need' ) ) {
	//Handler of add_filter('kindlycare_filter_orderby_need',	'kindlycare_woocommerce_orderby_need', 9, 1);
	function kindlycare_woocommerce_orderby_need($need) {
		if ($need == false || kindlycare_storage_empty('pre_query'))
			return $need;
		else {
			return kindlycare_storage_call_obj_method('pre_query', 'get', 'post_type')!='product'
					&& kindlycare_storage_call_obj_method('pre_query', 'get', 'product_cat')==''
					&& kindlycare_storage_call_obj_method('pre_query', 'get', 'product_tag')=='';
		}
	}
}

// Add custom post type into list
if ( !function_exists( 'kindlycare_woocommerce_list_post_types' ) ) {
	//Handler of add_filter('kindlycare_filter_list_post_types', 	'kindlycare_woocommerce_list_post_types', 10, 1);
	function kindlycare_woocommerce_list_post_types($list) {
		$list['product'] = esc_html__('Products', 'kindlycare');
		return $list;
	}
}



// Enqueue WooCommerce custom styles
if ( !function_exists( 'kindlycare_woocommerce_frontend_scripts' ) ) {
	//Handler of add_action( 'kindlycare_action_add_styles', 'kindlycare_woocommerce_frontend_scripts' );
	function kindlycare_woocommerce_frontend_scripts() {
		if (kindlycare_is_woocommerce_page() || kindlycare_get_custom_option('show_cart')=='always')
			if (file_exists(kindlycare_get_file_dir('css/plugin.woocommerce.css')))
				wp_enqueue_style( 'kindlycare-plugin.woocommerce-style',  kindlycare_get_file_url('css/plugin.woocommerce.css'), array(), null );
	}
}

// Replace standard WooCommerce function
/*
if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {
	function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
		global $post;
		if ( has_post_thumbnail() ) {
			$s = wc_get_image_size( $size );
			return kindlycare_get_resized_image_tag($post->ID, $s['width'], kindlycare_get_theme_option('crop_product_thumb')=='no' ? null :  $s['height']);
			//return get_the_post_thumbnail( $post->ID, array($s['width'], $s['height']) );
		} else if ( wc_placeholder_img_src() )
			return wc_placeholder_img( $size );
	}
}
*/

// Before main content
if ( !function_exists( 'kindlycare_woocommerce_wrapper_start' ) ) {
	//remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	//Handler of add_action('woocommerce_before_main_content', 'kindlycare_woocommerce_wrapper_start', 10);
	function kindlycare_woocommerce_wrapper_start() {
		if (is_product() || is_cart() || is_checkout() || is_account_page()) {
			?>
			<article class="post_item post_item_single post_item_product">
			<?php
		} else {
			?>
			<div class="list_products shop_mode_<?php echo !kindlycare_storage_empty('shop_mode') ? kindlycare_storage_get('shop_mode') : 'thumbs'; ?>">
			<?php
		}
	}
}

// After main content
if ( !function_exists( 'kindlycare_woocommerce_wrapper_end' ) ) {
	//remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
	//Handler of add_action('woocommerce_after_main_content', 'kindlycare_woocommerce_wrapper_end', 10);
	function kindlycare_woocommerce_wrapper_end() {
		if (is_product() || is_cart() || is_checkout() || is_account_page()) {
			?>
			</article>	<!-- .post_item -->
			<?php
		} else {
			?>
			</div>	<!-- .list_products -->
			<?php
		}
	}
}

// Check to show page title
if ( !function_exists( 'kindlycare_woocommerce_show_page_title' ) ) {
	//Handler of add_action('woocommerce_show_page_title', 'kindlycare_woocommerce_show_page_title', 10);
	function kindlycare_woocommerce_show_page_title($defa=true) {
		return kindlycare_get_custom_option('show_page_title')=='no';
	}
}

// Check to show product title
if ( !function_exists( 'kindlycare_woocommerce_show_product_title' ) ) {
	//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
	//Handler of add_action( 'woocommerce_single_product_summary', 'kindlycare_woocommerce_show_product_title', 5 );
	function kindlycare_woocommerce_show_product_title() {
		if (kindlycare_get_custom_option('show_post_title')=='yes' || kindlycare_get_custom_option('show_page_title')=='no') {
			wc_get_template( 'single-product/title.php' );
		}
	}
}

// Add list mode buttons
if ( !function_exists( 'kindlycare_woocommerce_before_shop_loop' ) ) {
	//Handler of add_action( 'woocommerce_before_shop_loop', 'kindlycare_woocommerce_before_shop_loop', 10 );
	function kindlycare_woocommerce_before_shop_loop() {
		if (kindlycare_get_custom_option('show_mode_buttons')=='yes') {
            echo '<div class="mode_buttons"><form action="' . esc_url(kindlycare_get_current_url()) . '" method="post">'
				. '<input type="hidden" name="kindlycare_shop_mode" value="'.esc_attr(kindlycare_storage_get('shop_mode')).'" />'
				. '<a href="#" class="woocommerce_thumbs icon-th" title="'.esc_attr__('Show products as thumbs', 'kindlycare').'"></a>'
				. '<a href="#" class="woocommerce_list icon-th-list" title="'.esc_attr__('Show products as list', 'kindlycare').'"></a>'
				. '</form></div>';
		}
	}
}


// Open thumbs wrapper for categories and products
if ( !function_exists( 'kindlycare_woocommerce_open_thumb_wrapper' ) ) {
	//Handler of add_action( 'woocommerce_before_subcategory_title', 'kindlycare_woocommerce_open_thumb_wrapper', 9 );
	//Handler of add_action( 'woocommerce_before_shop_loop_item_title', 'kindlycare_woocommerce_open_thumb_wrapper', 9 );
	function kindlycare_woocommerce_open_thumb_wrapper($cat='') {
		kindlycare_storage_set('in_product_item', true);
		?>
		<div class="post_item_wrap">
			<div class="post_featured">
				<div class="post_thumb">
					<a class="hover_icon hover_icon_link" href="<?php echo esc_url(is_object($cat) ? get_term_link($cat->slug, 'product_cat') : get_permalink()); ?>">
		<?php
	}
}

// Open item wrapper for categories and products
if ( !function_exists( 'kindlycare_woocommerce_open_item_wrapper' ) ) {
	//Handler of add_action( 'woocommerce_before_subcategory_title', 'kindlycare_woocommerce_open_item_wrapper', 20 );
	//Handler of add_action( 'woocommerce_before_shop_loop_item_title', 'kindlycare_woocommerce_open_item_wrapper', 20 );
	function kindlycare_woocommerce_open_item_wrapper($cat='') {
		?>
				</a>
			</div>
		</div>
		<div class="post_content">
		<?php
	}
}

// Close item wrapper for categories and products
if ( !function_exists( 'kindlycare_woocommerce_close_item_wrapper' ) ) {
	//Handler of add_action( 'woocommerce_after_subcategory', 'kindlycare_woocommerce_close_item_wrapper', 20 );
	//Handler of add_action( 'woocommerce_after_shop_loop_item', 'kindlycare_woocommerce_close_item_wrapper', 20 );
	function kindlycare_woocommerce_close_item_wrapper($cat='') {
		?>
			</div>
		</div>
		<?php
		kindlycare_storage_set('in_product_item', false);
	}
}

// Add excerpt in output for the product in the list mode
if ( !function_exists( 'kindlycare_woocommerce_after_shop_loop_item_title' ) ) {
	//Handler of add_action( 'woocommerce_after_shop_loop_item_title', 'kindlycare_woocommerce_after_shop_loop_item_title', 7);
	function kindlycare_woocommerce_after_shop_loop_item_title() {
		if (kindlycare_storage_get('shop_mode') == 'list') {
		    $excerpt = apply_filters('the_excerpt', get_the_excerpt());
			echo '<div class="description">'.trim($excerpt).'</div>';
		}
	}
}

// Add excerpt in output for the product in the list mode
if ( !function_exists( 'kindlycare_woocommerce_after_subcategory_title' ) ) {
	//Handler of add_action( 'woocommerce_after_subcategory_title', 'kindlycare_woocommerce_after_subcategory_title', 10 );
	function kindlycare_woocommerce_after_subcategory_title($category) {
		if (kindlycare_storage_get('shop_mode') == 'list')
			echo '<div class="description">' . trim($category->description) . '</div>';
	}
}

// Add Product ID for single product
if ( !function_exists( 'kindlycare_woocommerce_show_product_id' ) ) {
	//Handler of add_action( 'woocommerce_product_meta_end', 'kindlycare_woocommerce_show_product_id', 10);
	function kindlycare_woocommerce_show_product_id() {
		global $post, $product;
		echo '<span class="product_id">'.esc_html__('Product ID: ', 'kindlycare') . '<span>' . ($post->ID) . '</span></span>';
	}
}

// Redefine number of related products
if ( !function_exists( 'kindlycare_woocommerce_output_related_products_args' ) ) {
	//Handler of add_filter( 'woocommerce_output_related_products_args', 'kindlycare_woocommerce_output_related_products_args' );
	function kindlycare_woocommerce_output_related_products_args($args) {
		$ppp = $ccc = 0;
		if (kindlycare_param_is_on(kindlycare_get_custom_option('show_post_related'))) {
			$ccc_add = in_array(kindlycare_get_custom_option('body_style'), array('fullwide', 'fullscreen')) ? 1 : 0;
			$ccc =  kindlycare_get_custom_option('post_related_columns');
			$ccc = $ccc > 0 ? $ccc : (kindlycare_param_is_off(kindlycare_get_custom_option('show_sidebar_main')) ? 3+$ccc_add : 2+$ccc_add);
			$ppp = kindlycare_get_custom_option('post_related_count');
			$ppp = $ppp > 0 ? $ppp : $ccc;
		}
		$args['posts_per_page'] = $ppp;
		$args['columns'] = $ccc;
		return $args;
	}
}

// Number columns for product thumbnails
if ( !function_exists( 'kindlycare_woocommerce_product_thumbnails_columns' ) ) {
	//Handler of add_filter( 'woocommerce_product_thumbnails_columns', 'kindlycare_woocommerce_product_thumbnails_columns' );
	function kindlycare_woocommerce_product_thumbnails_columns($cols) {
		return 4;
	}
}

// Add column class into product item in shop streampage
if ( !function_exists( 'kindlycare_woocommerce_loop_shop_columns_class' ) ) {
	//Handler of add_filter( 'post_class', 'kindlycare_woocommerce_loop_shop_columns_class' );
    function kindlycare_woocommerce_loop_shop_columns_class($class, $class2='', $cat='') {
        if (!is_product() && !is_cart() && !is_checkout() && !is_account_page()) {
            $cols = function_exists('wc_get_default_products_per_row') ? wc_get_default_products_per_row() : 2;
            $class[] = ' column-1_' . $cols;
        }
        return $class;
    }
}


// Search form
if ( !function_exists( 'kindlycare_woocommerce_get_product_search_form' ) ) {
	//Handler of add_filter( 'get_product_search_form', 'kindlycare_woocommerce_get_product_search_form' );
	function kindlycare_woocommerce_get_product_search_form($form) {
		return '
		<form role="search" method="get" class="search_form" action="' . esc_url(home_url('/')) . '">
			<input type="text" class="search_field" placeholder="' . esc_attr__('Search for products &hellip;', 'kindlycare') . '" value="' . get_search_query() . '" name="s" title="' . esc_attr__('Search for products:', 'kindlycare') . '" /><button class="search_button icon-search" type="submit"></button>
			<input type="hidden" name="post_type" value="product" />
		</form>
		';
	}
}

// Wrap product title into link
if ( !function_exists( 'kindlycare_woocommerce_the_title' ) ) {
	//Handler of add_filter( 'the_title', 'kindlycare_woocommerce_the_title' );
	function kindlycare_woocommerce_the_title($title) {
		if (kindlycare_storage_get('in_product_item') && get_post_type()=='product') {
			$title = '<a href="'.get_permalink().'">'.($title).'</a>';
		}
		return $title;
	}
}

// Wrap category title into link
if ( !function_exists( 'kindlycare_woocommerce_shop_loop_subcategory_title' ) ) {
	//Handler of the add_filter( 'woocommerce_shop_loop_subcategory_title', 'kindlycare_woocommerce_shop_loop_subcategory_title' );
	function kindlycare_woocommerce_shop_loop_subcategory_title($category) {
		$category->name = sprintf('<a href="%s">%s</a>', esc_url(get_term_link($category->slug, 'product_cat')), $category->name);
		?>
        <h2 class="woocommerce-loop-category__title">
			<?php
			echo trim($category->name);

			if ( $category->count > 0 ) {
				echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . esc_html( $category->count ) . ')</mark>', $category ); // WPCS: XSS ok.
			}
			?>
        </h2>
		<?php
	}
}

// Show pagination links
if ( !function_exists( 'kindlycare_woocommerce_pagination' ) ) {
	//Handler of add_filter( 'woocommerce_after_shop_loop', 'kindlycare_woocommerce_pagination', 10 );
	function kindlycare_woocommerce_pagination() {
		$style = kindlycare_get_custom_option('blog_pagination');
		kindlycare_show_pagination(array(
			'class' => 'pagination_wrap pagination_' . esc_attr($style),
			'style' => $style,
			'button_class' => '',
			'first_text'=> '',
			'last_text' => '',
			'prev_text' => '',
			'next_text' => '',
			'pages_in_group' => $style=='pages' ? 10 : 20
			)
		);
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'kindlycare_woocommerce_required_plugins' ) ) {
	//Handler of add_filter('kindlycare_filter_required_plugins',	'kindlycare_woocommerce_required_plugins');
	function kindlycare_woocommerce_required_plugins($list=array()) {
		if (in_array('woocommerce', kindlycare_storage_get('required_plugins')))
			$list[] = array(
					'name' 		=> 'WooCommerce',
					'slug' 		=> 'woocommerce',
					'required' 	=> false
				);

		return $list;
	}
}



// One-click import support
//------------------------------------------------------------------------

// Check WooC in the required plugins
if ( !function_exists( 'kindlycare_woocommerce_importer_required_plugins' ) ) {
	//Handler of add_filter( 'kindlycare_filter_importer_required_plugins',	'kindlycare_woocommerce_importer_required_plugins', 10, 2 );
	function kindlycare_woocommerce_importer_required_plugins($not_installed='', $list='') {
		//if (in_array('woocommerce', kindlycare_storage_get('required_plugins')) && !kindlycare_exists_woocommerce() )
		if (kindlycare_strpos($list, 'woocommerce')!==false && !kindlycare_exists_woocommerce() )
			$not_installed .= '<br>WooCommerce';
		return $not_installed;
	}
}

// Set options for one-click importer
if ( !function_exists( 'kindlycare_woocommerce_importer_set_options' ) ) {
	//Handler of add_filter( 'kindlycare_filter_importer_options',	'kindlycare_woocommerce_importer_set_options' );
	function kindlycare_woocommerce_importer_set_options($options=array()) {
		if ( in_array('woocommerce', kindlycare_storage_get('required_plugins')) && kindlycare_exists_woocommerce() ) {
			if (is_array($options['files']) && count($options['files']) > 0) {
				foreach ($options['files'] as $k => $v) {
                    $options['files'][$k]['file_with_woocommerce'] = str_replace('name.ext', 'woocommerce.txt', $v['file_with_']);
				}
			}
			// Add slugs to export options for this plugin
			$options['additional_options'][]	= 'shop_%';
			$options['additional_options'][]	= 'woocommerce_%';
		}
		return $options;
	}
}

// Setup WooC pages after import posts complete
if ( !function_exists( 'kindlycare_woocommerce_importer_after_import_posts' ) ) {
	//Handler of add_action( 'kindlycare_action_importer_after_import_posts',	'kindlycare_woocommerce_importer_after_import_posts', 10, 1 );
	function kindlycare_woocommerce_importer_after_import_posts($importer) {
		$wooc_pages = array(						// Options slugs and pages titles for WooCommerce pages
			'woocommerce_shop_page_id' 				=> 'Shop',
			'woocommerce_cart_page_id' 				=> 'Cart',
			'woocommerce_checkout_page_id' 			=> 'Checkout',
			'woocommerce_pay_page_id' 				=> 'Checkout &#8594; Pay',
			'woocommerce_thanks_page_id' 			=> 'Order Received',
			'woocommerce_myaccount_page_id' 		=> 'My Account',
			'woocommerce_edit_address_page_id'		=> 'Edit My Address',
			'woocommerce_view_order_page_id'		=> 'View Order',
			'woocommerce_change_password_page_id'	=> 'Change Password',
			'woocommerce_logout_page_id'			=> 'Logout',
			'woocommerce_lost_password_page_id'		=> 'Lost Password'
		);
		foreach ($wooc_pages as $woo_page_name => $woo_page_title) {
			$woopage = get_page_by_title( $woo_page_title );
			if ($woopage->ID) {
				update_option($woo_page_name, $woopage->ID);
			}
		}
		// We no longer need to install pages
		delete_option( '_wc_needs_pages' );
		delete_transient( '_wc_activation_redirect' );
	}
}

// Add checkbox to the one-click importer
if ( !function_exists( 'kindlycare_woocommerce_importer_show_params' ) ) {
    //Handler of add_action( 'kindlycare_action_importer_params',	'kindlycare_woocommerce_importer_show_params', 10, 1 );
    function kindlycare_woocommerce_importer_show_params($importer) {
        $importer->show_importer_params(array(
            'slug' => 'woocommerce',
            'title' => esc_html__('Import WooCommerce', 'kindlycare'),
            'part' => 0
        ));
    }
}

// Import posts
if ( !function_exists( 'kindlycare_woocommerce_importer_import' ) ) {
    //Handler of add_action( 'kindlycare_action_importer_import',	'kindlycare_woocommerce_importer_import', 10, 2 );
    function kindlycare_woocommerce_importer_import($importer, $action) {
        if ( $action == 'import_woocommerce' ) {
            $importer->response['start_from_id'] = 0;
            $importer->import_dump('woocommerce', esc_html__('WooCommerce meta', 'kindlycare'));
            delete_transient( 'wc_attribute_taxonomies' );
        }
    }
}

// Display import progress
if ( !function_exists( 'kindlycare_woocommerce_importer_import_fields' ) ) {
    //Handler of add_action( 'kindlycare_action_importer_import_fields',	'kindlycare_woocommerce_importer_import_fields', 10, 1 );
    function kindlycare_woocommerce_importer_import_fields($importer) {
        $importer->show_importer_fields(array(
            'slug' => 'woocommerce',
            'title' => esc_html__('WooCommerce meta', 'kindlycare')
        ));
    }
}

// Export posts
if ( !function_exists( 'kindlycare_woocommerce_importer_export' ) ) {
    //Handler of add_action( 'kindlycare_action_importer_export',	'kindlycare_woocommerce_importer_export', 10, 1 );
    function kindlycare_woocommerce_importer_export($importer) {
        kindlycare_fpc(kindlycare_get_file_dir('core/core.importer/export/woocommerce.txt'), serialize( array(
                "woocommerce_attribute_taxonomies"				=> $importer->export_dump("woocommerce_attribute_taxonomies"),
                "woocommerce_downloadable_product_permissions"	=> $importer->export_dump("woocommerce_downloadable_product_permissions"),
                "woocommerce_order_itemmeta"					=> $importer->export_dump("woocommerce_order_itemmeta"),
                "woocommerce_order_items"						=> $importer->export_dump("woocommerce_order_items"),
                "woocommerce_termmeta"							=> $importer->export_dump("woocommerce_termmeta")
            ) )
        );
    }
}

// Display exported data in the fields
if ( !function_exists( 'kindlycare_woocommerce_importer_export_fields' ) ) {
    //Handler of add_action( 'kindlycare_action_importer_export_fields',	'kindlycare_woocommerce_importer_export_fields', 10, 1 );
    function kindlycare_woocommerce_importer_export_fields($importer) {
        $importer->show_exporter_fields(array(
            'slug' => 'woocommerce',
            'title' => esc_html__('WooCommerce', 'kindlycare')
        ));
    }
}



// Register shortcodes to the internal builder
//------------------------------------------------------------------------
if ( !function_exists( 'kindlycare_woocommerce_reg_shortcodes' ) ) {
	//Handler of add_action('kindlycare_action_shortcodes_list', 'kindlycare_woocommerce_reg_shortcodes', 20);
	function kindlycare_woocommerce_reg_shortcodes() {

		// WooCommerce - Cart
		kindlycare_sc_map("woocommerce_cart", array(
			"title" => esc_html__("Woocommerce: Cart", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show Cart page", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array()
			)
		);

		// WooCommerce - Checkout
		kindlycare_sc_map("woocommerce_checkout", array(
			"title" => esc_html__("Woocommerce: Checkout", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show Checkout page", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array()
			)
		);

		// WooCommerce - My Account
		kindlycare_sc_map("woocommerce_my_account", array(
			"title" => esc_html__("Woocommerce: My Account", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show My Account page", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array()
			)
		);

		// WooCommerce - Order Tracking
		kindlycare_sc_map("woocommerce_order_tracking", array(
			"title" => esc_html__("Woocommerce: Order Tracking", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show Order Tracking page", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array()
			)
		);

		// WooCommerce - Shop Messages
		kindlycare_sc_map("shop_messages", array(
			"title" => esc_html__("Woocommerce: Shop Messages", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show shop messages", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array()
			)
		);

		// WooCommerce - Product Page
		kindlycare_sc_map("product_page", array(
			"title" => esc_html__("Woocommerce: Product Page", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: display single product page", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"sku" => array(
					"title" => esc_html__("SKU", 'kindlycare'),
					"desc" => wp_kses_data( __("SKU code of displayed product", 'kindlycare') ),
					"value" => "",
					"type" => "text"
				),
				"id" => array(
					"title" => esc_html__("ID", 'kindlycare'),
					"desc" => wp_kses_data( __("ID of displayed product", 'kindlycare') ),
					"value" => "",
					"type" => "text"
				),
				"posts_per_page" => array(
					"title" => esc_html__("Number", 'kindlycare'),
					"desc" => wp_kses_data( __("How many products showed", 'kindlycare') ),
					"value" => "1",
					"min" => 1,
					"type" => "spinner"
				),
				"post_type" => array(
					"title" => esc_html__("Post type", 'kindlycare'),
					"desc" => wp_kses_data( __("Post type for the WP query (leave 'product')", 'kindlycare') ),
					"value" => "product",
					"type" => "text"
				),
				"post_status" => array(
					"title" => esc_html__("Post status", 'kindlycare'),
					"desc" => wp_kses_data( __("Display posts only with this status", 'kindlycare') ),
					"value" => "publish",
					"type" => "select",
					"options" => array(
						"publish" => esc_html__('Publish', 'kindlycare'),
						"protected" => esc_html__('Protected', 'kindlycare'),
						"private" => esc_html__('Private', 'kindlycare'),
						"pending" => esc_html__('Pending', 'kindlycare'),
						"draft" => esc_html__('Draft', 'kindlycare')
						)
					)
				)
			)
		);

		// WooCommerce - Product
		kindlycare_sc_map("product", array(
			"title" => esc_html__("Woocommerce: Product", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: display one product", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"sku" => array(
					"title" => esc_html__("SKU", 'kindlycare'),
					"desc" => wp_kses_data( __("SKU code of displayed product", 'kindlycare') ),
					"value" => "",
					"type" => "text"
				),
				"id" => array(
					"title" => esc_html__("ID", 'kindlycare'),
					"desc" => wp_kses_data( __("ID of displayed product", 'kindlycare') ),
					"value" => "",
					"type" => "text"
					)
				)
			)
		);

		// WooCommerce - Best Selling Products
		kindlycare_sc_map("best_selling_products", array(
			"title" => esc_html__("Woocommerce: Best Selling Products", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show best selling products", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"per_page" => array(
					"title" => esc_html__("Number", 'kindlycare'),
					"desc" => wp_kses_data( __("How many products showed", 'kindlycare') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'kindlycare'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
					)
				)
			)
		);

		// WooCommerce - Recent Products
		kindlycare_sc_map("recent_products", array(
			"title" => esc_html__("Woocommerce: Recent Products", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show recent products", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"per_page" => array(
					"title" => esc_html__("Number", 'kindlycare'),
					"desc" => wp_kses_data( __("How many products showed", 'kindlycare') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'kindlycare'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'kindlycare'),
						"title" => esc_html__('Title', 'kindlycare')
					)
				),
				"order" => array(
					"title" => esc_html__("Order", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => kindlycare_get_sc_param('ordering')
					)
				)
			)
		);

		// WooCommerce - Related Products
		kindlycare_sc_map("related_products", array(
			"title" => esc_html__("Woocommerce: Related Products", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show related products", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"posts_per_page" => array(
					"title" => esc_html__("Number", 'kindlycare'),
					"desc" => wp_kses_data( __("How many products showed", 'kindlycare') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'kindlycare'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'kindlycare'),
						"title" => esc_html__('Title', 'kindlycare')
						)
					)
				)
			)
		);

		// WooCommerce - Featured Products
		kindlycare_sc_map("featured_products", array(
			"title" => esc_html__("Woocommerce: Featured Products", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show featured products", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"per_page" => array(
					"title" => esc_html__("Number", 'kindlycare'),
					"desc" => wp_kses_data( __("How many products showed", 'kindlycare') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'kindlycare'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'kindlycare'),
						"title" => esc_html__('Title', 'kindlycare')
					)
				),
				"order" => array(
					"title" => esc_html__("Order", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => kindlycare_get_sc_param('ordering')
					)
				)
			)
		);

		// WooCommerce - Top Rated Products
		kindlycare_sc_map("featured_products", array(
			"title" => esc_html__("Woocommerce: Top Rated Products", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show top rated products", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"per_page" => array(
					"title" => esc_html__("Number", 'kindlycare'),
					"desc" => wp_kses_data( __("How many products showed", 'kindlycare') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'kindlycare'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'kindlycare'),
						"title" => esc_html__('Title', 'kindlycare')
					)
				),
				"order" => array(
					"title" => esc_html__("Order", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => kindlycare_get_sc_param('ordering')
					)
				)
			)
		);

		// WooCommerce - Sale Products
		kindlycare_sc_map("featured_products", array(
			"title" => esc_html__("Woocommerce: Sale Products", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: list products on sale", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"per_page" => array(
					"title" => esc_html__("Number", 'kindlycare'),
					"desc" => wp_kses_data( __("How many products showed", 'kindlycare') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'kindlycare'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'kindlycare'),
						"title" => esc_html__('Title', 'kindlycare')
					)
				),
				"order" => array(
					"title" => esc_html__("Order", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => kindlycare_get_sc_param('ordering')
					)
				)
			)
		);

		// WooCommerce - Product Category
		kindlycare_sc_map("product_category", array(
			"title" => esc_html__("Woocommerce: Products from category", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: list products in specified category(-ies)", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"per_page" => array(
					"title" => esc_html__("Number", 'kindlycare'),
					"desc" => wp_kses_data( __("How many products showed", 'kindlycare') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'kindlycare'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'kindlycare'),
						"title" => esc_html__('Title', 'kindlycare')
					)
				),
				"order" => array(
					"title" => esc_html__("Order", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => kindlycare_get_sc_param('ordering')
				),
				"category" => array(
					"title" => esc_html__("Categories", 'kindlycare'),
					"desc" => wp_kses_data( __("Comma separated category slugs", 'kindlycare') ),
					"value" => '',
					"type" => "text"
				),
				"operator" => array(
					"title" => esc_html__("Operator", 'kindlycare'),
					"desc" => wp_kses_data( __("Categories operator", 'kindlycare') ),
					"value" => "IN",
					"type" => "checklist",
					"size" => "medium",
					"options" => array(
						"IN" => esc_html__('IN', 'kindlycare'),
						"NOT IN" => esc_html__('NOT IN', 'kindlycare'),
						"AND" => esc_html__('AND', 'kindlycare')
						)
					)
				)
			)
		);

		// WooCommerce - Products
		kindlycare_sc_map("products", array(
			"title" => esc_html__("Woocommerce: Products", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: list all products", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"skus" => array(
					"title" => esc_html__("SKUs", 'kindlycare'),
					"desc" => wp_kses_data( __("Comma separated SKU codes of products", 'kindlycare') ),
					"value" => "",
					"type" => "text"
				),
				"ids" => array(
					"title" => esc_html__("IDs", 'kindlycare'),
					"desc" => wp_kses_data( __("Comma separated ID of products", 'kindlycare') ),
					"value" => "",
					"type" => "text"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'kindlycare'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'kindlycare'),
						"title" => esc_html__('Title', 'kindlycare')
					)
				),
				"order" => array(
					"title" => esc_html__("Order", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => kindlycare_get_sc_param('ordering')
					)
				)
			)
		);

		// WooCommerce - Product attribute
		kindlycare_sc_map("product_attribute", array(
			"title" => esc_html__("Woocommerce: Products by Attribute", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show products with specified attribute", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"per_page" => array(
					"title" => esc_html__("Number", 'kindlycare'),
					"desc" => wp_kses_data( __("How many products showed", 'kindlycare') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'kindlycare'),
					"desc" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'kindlycare'),
						"title" => esc_html__('Title', 'kindlycare')
					)
				),
				"order" => array(
					"title" => esc_html__("Order", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => kindlycare_get_sc_param('ordering')
				),
				"attribute" => array(
					"title" => esc_html__("Attribute", 'kindlycare'),
					"desc" => wp_kses_data( __("Attribute name", 'kindlycare') ),
					"value" => "",
					"type" => "text"
				),
				"filter" => array(
					"title" => esc_html__("Filter", 'kindlycare'),
					"desc" => wp_kses_data( __("Attribute value", 'kindlycare') ),
					"value" => "",
					"type" => "text"
					)
				)
			)
		);

		// WooCommerce - Products Categories
		kindlycare_sc_map("product_categories", array(
			"title" => esc_html__("Woocommerce: Product Categories", 'kindlycare'),
			"desc" => wp_kses_data( __("WooCommerce shortcode: show categories with products", 'kindlycare') ),
			"decorate" => false,
			"container" => false,
			"params" => array(
				"number" => array(
					"title" => esc_html__("Number", 'kindlycare'),
					"desc" => wp_kses_data( __("How many categories showed", 'kindlycare') ),
					"value" => 4,
					"min" => 1,
					"type" => "spinner"
				),
				"columns" => array(
					"title" => esc_html__("Columns", 'kindlycare'),
					"desc" => wp_kses_data( __("How many columns per row use for categories output", 'kindlycare') ),
					"value" => 4,
					"min" => 2,
					"max" => 4,
					"type" => "spinner"
				),
				"orderby" => array(
					"title" => esc_html__("Order by", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "date",
					"type" => "select",
					"options" => array(
						"date" => esc_html__('Date', 'kindlycare'),
						"title" => esc_html__('Title', 'kindlycare')
					)
				),
				"order" => array(
					"title" => esc_html__("Order", 'kindlycare'),
					"desc" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
					"value" => "desc",
					"type" => "switch",
					"size" => "big",
					"options" => kindlycare_get_sc_param('ordering')
				),
				"parent" => array(
					"title" => esc_html__("Parent", 'kindlycare'),
					"desc" => wp_kses_data( __("Parent category slug", 'kindlycare') ),
					"value" => "",
					"type" => "text"
				),
				"ids" => array(
					"title" => esc_html__("IDs", 'kindlycare'),
					"desc" => wp_kses_data( __("Comma separated ID of products", 'kindlycare') ),
					"value" => "",
					"type" => "text"
				),
				"hide_empty" => array(
					"title" => esc_html__("Hide empty", 'kindlycare'),
					"desc" => wp_kses_data( __("Hide empty categories", 'kindlycare') ),
					"value" => "yes",
					"type" => "switch",
					"options" => kindlycare_get_sc_param('yes_no')
					)
				)
			)
		);
	}
}



// Register shortcodes to the VC builder
//------------------------------------------------------------------------
if ( !function_exists( 'kindlycare_woocommerce_reg_shortcodes_vc' ) ) {
	//Handler of add_action('kindlycare_action_shortcodes_list_vc', 'kindlycare_woocommerce_reg_shortcodes_vc');
	function kindlycare_woocommerce_reg_shortcodes_vc() {

		if (false && function_exists('kindlycare_exists_woocommerce') && kindlycare_exists_woocommerce()) {

			// WooCommerce - Cart
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "woocommerce_cart",
				"name" => esc_html__("Cart", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show cart page", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_wooc_cart',
				"class" => "trx_sc_alone trx_sc_woocommerce_cart",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array(
					array(
						"param_name" => "dummy",
						"heading" => esc_html__("Dummy data", 'kindlycare'),
						"description" => wp_kses_data( __("Dummy data - not used in shortcodes", 'kindlycare') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );

			class WPkindlycareShortCode_Woocommerce_Cart extends KINDLYCARE_VC_ShortCodeAlone {}


			// WooCommerce - Checkout
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "woocommerce_checkout",
				"name" => esc_html__("Checkout", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show checkout page", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_wooc_checkout',
				"class" => "trx_sc_alone trx_sc_woocommerce_checkout",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array(
					array(
						"param_name" => "dummy",
						"heading" => esc_html__("Dummy data", 'kindlycare'),
						"description" => wp_kses_data( __("Dummy data - not used in shortcodes", 'kindlycare') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );

			class WPkindlycareShortCode_Woocommerce_Checkout extends KINDLYCARE_VC_ShortCodeAlone {}


			// WooCommerce - My Account
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "woocommerce_my_account",
				"name" => esc_html__("My Account", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show my account page", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_wooc_my_account',
				"class" => "trx_sc_alone trx_sc_woocommerce_my_account",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array(
					array(
						"param_name" => "dummy",
						"heading" => esc_html__("Dummy data", 'kindlycare'),
						"description" => wp_kses_data( __("Dummy data - not used in shortcodes", 'kindlycare') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );

			class WPkindlycareShortCode_Woocommerce_My_Account extends KINDLYCARE_VC_ShortCodeAlone {}


			// WooCommerce - Order Tracking
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "woocommerce_order_tracking",
				"name" => esc_html__("Order Tracking", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show order tracking page", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_wooc_order_tracking',
				"class" => "trx_sc_alone trx_sc_woocommerce_order_tracking",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array(
					array(
						"param_name" => "dummy",
						"heading" => esc_html__("Dummy data", 'kindlycare'),
						"description" => wp_kses_data( __("Dummy data - not used in shortcodes", 'kindlycare') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );

			class WPkindlycareShortCode_Woocommerce_Order_Tracking extends KINDLYCARE_VC_ShortCodeAlone {}


			// WooCommerce - Shop Messages
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "shop_messages",
				"name" => esc_html__("Shop Messages", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show shop messages", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_wooc_shop_messages',
				"class" => "trx_sc_alone trx_sc_shop_messages",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => false,
				"params" => array(
					array(
						"param_name" => "dummy",
						"heading" => esc_html__("Dummy data", 'kindlycare'),
						"description" => wp_kses_data( __("Dummy data - not used in shortcodes", 'kindlycare') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );

			class WPkindlycareShortCode_Shop_Messages extends KINDLYCARE_VC_ShortCodeAlone {}


			// WooCommerce - Product Page
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "product_page",
				"name" => esc_html__("Product Page", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: display single product page", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_product_page',
				"class" => "trx_sc_single trx_sc_product_page",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "sku",
						"heading" => esc_html__("SKU", 'kindlycare'),
						"description" => wp_kses_data( __("SKU code of displayed product", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "id",
						"heading" => esc_html__("ID", 'kindlycare'),
						"description" => wp_kses_data( __("ID of displayed product", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "posts_per_page",
						"heading" => esc_html__("Number", 'kindlycare'),
						"description" => wp_kses_data( __("How many products showed", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "post_type",
						"heading" => esc_html__("Post type", 'kindlycare'),
						"description" => wp_kses_data( __("Post type for the WP query (leave 'product')", 'kindlycare') ),
						"class" => "",
						"value" => "product",
						"type" => "textfield"
					),
					array(
						"param_name" => "post_status",
						"heading" => esc_html__("Post status", 'kindlycare'),
						"description" => wp_kses_data( __("Display posts only with this status", 'kindlycare') ),
						"class" => "",
						"value" => array(
							esc_html__('Publish', 'kindlycare') => 'publish',
							esc_html__('Protected', 'kindlycare') => 'protected',
							esc_html__('Private', 'kindlycare') => 'private',
							esc_html__('Pending', 'kindlycare') => 'pending',
							esc_html__('Draft', 'kindlycare') => 'draft'
						),
						"type" => "dropdown"
					)
				)
			) );

			class WPkindlycareShortCode_Product_Page extends KINDLYCARE_VC_ShortCodeSingle {}



			// WooCommerce - Product
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "product",
				"name" => esc_html__("Product", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: display one product", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_product',
				"class" => "trx_sc_single trx_sc_product",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "sku",
						"heading" => esc_html__("SKU", 'kindlycare'),
						"description" => wp_kses_data( __("Product's SKU code", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "id",
						"heading" => esc_html__("ID", 'kindlycare'),
						"description" => wp_kses_data( __("Product's ID", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );

			class WPkindlycareShortCode_Product extends KINDLYCARE_VC_ShortCodeSingle {}


			// WooCommerce - Best Selling Products
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "best_selling_products",
				"name" => esc_html__("Best Selling Products", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show best selling products", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_best_selling_products',
				"class" => "trx_sc_single trx_sc_best_selling_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", 'kindlycare'),
						"description" => wp_kses_data( __("How many products showed", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'kindlycare'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					)
				)
			) );

			class WPkindlycareShortCode_Best_Selling_Products extends KINDLYCARE_VC_ShortCodeSingle {}



			// WooCommerce - Recent Products
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "recent_products",
				"name" => esc_html__("Recent Products", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show recent products", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_recent_products',
				"class" => "trx_sc_single trx_sc_recent_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", 'kindlycare'),
						"description" => wp_kses_data( __("How many products showed", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"

					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'kindlycare'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'kindlycare') => 'date',
							esc_html__('Title', 'kindlycare') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip(kindlycare_get_sc_param('ordering')),
						"type" => "dropdown"
					)
				)
			) );

			class WPkindlycareShortCode_Recent_Products extends KINDLYCARE_VC_ShortCodeSingle {}



			// WooCommerce - Related Products
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "related_products",
				"name" => esc_html__("Related Products", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show related products", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_related_products',
				"class" => "trx_sc_single trx_sc_related_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "posts_per_page",
						"heading" => esc_html__("Number", 'kindlycare'),
						"description" => wp_kses_data( __("How many products showed", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'kindlycare'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'kindlycare') => 'date',
							esc_html__('Title', 'kindlycare') => 'title'
						),
						"type" => "dropdown"
					)
				)
			) );

			class WPkindlycareShortCode_Related_Products extends KINDLYCARE_VC_ShortCodeSingle {}



			// WooCommerce - Featured Products
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "featured_products",
				"name" => esc_html__("Featured Products", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show featured products", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_featured_products',
				"class" => "trx_sc_single trx_sc_featured_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", 'kindlycare'),
						"description" => wp_kses_data( __("How many products showed", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'kindlycare'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'kindlycare') => 'date',
							esc_html__('Title', 'kindlycare') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip(kindlycare_get_sc_param('ordering')),
						"type" => "dropdown"
					)
				)
			) );

			class WPkindlycareShortCode_Featured_Products extends KINDLYCARE_VC_ShortCodeSingle {}



			// WooCommerce - Top Rated Products
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "top_rated_products",
				"name" => esc_html__("Top Rated Products", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show top rated products", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_top_rated_products',
				"class" => "trx_sc_single trx_sc_top_rated_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", 'kindlycare'),
						"description" => wp_kses_data( __("How many products showed", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'kindlycare'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'kindlycare') => 'date',
							esc_html__('Title', 'kindlycare') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip(kindlycare_get_sc_param('ordering')),
						"type" => "dropdown"
					)
				)
			) );

			class WPkindlycareShortCode_Top_Rated_Products extends KINDLYCARE_VC_ShortCodeSingle {}



			// WooCommerce - Sale Products
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "sale_products",
				"name" => esc_html__("Sale Products", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: list products on sale", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_sale_products',
				"class" => "trx_sc_single trx_sc_sale_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", 'kindlycare'),
						"description" => wp_kses_data( __("How many products showed", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'kindlycare'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'kindlycare') => 'date',
							esc_html__('Title', 'kindlycare') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip(kindlycare_get_sc_param('ordering')),
						"type" => "dropdown"
					)
				)
			) );

			class WPkindlycareShortCode_Sale_Products extends KINDLYCARE_VC_ShortCodeSingle {}



			// WooCommerce - Product Category
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "product_category",
				"name" => esc_html__("Products from category", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: list products in specified category(-ies)", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_product_category',
				"class" => "trx_sc_single trx_sc_product_category",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", 'kindlycare'),
						"description" => wp_kses_data( __("How many products showed", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'kindlycare'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'kindlycare') => 'date',
							esc_html__('Title', 'kindlycare') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip(kindlycare_get_sc_param('ordering')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "category",
						"heading" => esc_html__("Categories", 'kindlycare'),
						"description" => wp_kses_data( __("Comma separated category slugs", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "operator",
						"heading" => esc_html__("Operator", 'kindlycare'),
						"description" => wp_kses_data( __("Categories operator", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('IN', 'kindlycare') => 'IN',
							esc_html__('NOT IN', 'kindlycare') => 'NOT IN',
							esc_html__('AND', 'kindlycare') => 'AND'
						),
						"type" => "dropdown"
					)
				)
			) );

			class WPkindlycareShortCode_Product_Category extends KINDLYCARE_VC_ShortCodeSingle {}



			// WooCommerce - Products
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "products",
				"name" => esc_html__("Products", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: list all products", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_products',
				"class" => "trx_sc_single trx_sc_products",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "skus",
						"heading" => esc_html__("SKUs", 'kindlycare'),
						"description" => wp_kses_data( __("Comma separated SKU codes of products", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("IDs", 'kindlycare'),
						"description" => wp_kses_data( __("Comma separated ID of products", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'kindlycare'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'kindlycare') => 'date',
							esc_html__('Title', 'kindlycare') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip(kindlycare_get_sc_param('ordering')),
						"type" => "dropdown"
					)
				)
			) );

			class WPkindlycareShortCode_Products extends KINDLYCARE_VC_ShortCodeSingle {}




			// WooCommerce - Product Attribute
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "product_attribute",
				"name" => esc_html__("Products by Attribute", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show products with specified attribute", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_product_attribute',
				"class" => "trx_sc_single trx_sc_product_attribute",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "per_page",
						"heading" => esc_html__("Number", 'kindlycare'),
						"description" => wp_kses_data( __("How many products showed", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'kindlycare'),
						"description" => wp_kses_data( __("How many columns per row use for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'kindlycare') => 'date',
							esc_html__('Title', 'kindlycare') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip(kindlycare_get_sc_param('ordering')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "attribute",
						"heading" => esc_html__("Attribute", 'kindlycare'),
						"description" => wp_kses_data( __("Attribute name", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "filter",
						"heading" => esc_html__("Filter", 'kindlycare'),
						"description" => wp_kses_data( __("Attribute value", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );

			class WPkindlycareShortCode_Product_Attribute extends KINDLYCARE_VC_ShortCodeSingle {}



			// WooCommerce - Products Categories
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "product_categories",
				"name" => esc_html__("Product Categories", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: show categories with products", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_product_categories',
				"class" => "trx_sc_single trx_sc_product_categories",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "number",
						"heading" => esc_html__("Number", 'kindlycare'),
						"description" => wp_kses_data( __("How many categories showed", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "4",
						"type" => "textfield"
					),
					array(
						"param_name" => "columns",
						"heading" => esc_html__("Columns", 'kindlycare'),
						"description" => wp_kses_data( __("How many columns per row use for categories output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "orderby",
						"heading" => esc_html__("Order by", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array(
							esc_html__('Date', 'kindlycare') => 'date',
							esc_html__('Title', 'kindlycare') => 'title'
						),
						"type" => "dropdown"
					),
					array(
						"param_name" => "order",
						"heading" => esc_html__("Order", 'kindlycare'),
						"description" => wp_kses_data( __("Sorting order for products output", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => array_flip(kindlycare_get_sc_param('ordering')),
						"type" => "dropdown"
					),
					array(
						"param_name" => "parent",
						"heading" => esc_html__("Parent", 'kindlycare'),
						"description" => wp_kses_data( __("Parent category slug", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "date",
						"type" => "textfield"
					),
					array(
						"param_name" => "ids",
						"heading" => esc_html__("IDs", 'kindlycare'),
						"description" => wp_kses_data( __("Comma separated ID of products", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "hide_empty",
						"heading" => esc_html__("Hide empty", 'kindlycare'),
						"description" => wp_kses_data( __("Hide empty categories", 'kindlycare') ),
						"class" => "",
						"value" => array("Hide empty" => "1" ),
						"type" => "checkbox"
					)
				)
			) );

			class WPkindlycareShortCode_Products_Categories extends KINDLYCARE_VC_ShortCodeSingle {}

			/*

			// WooCommerce - Add to cart
			//-------------------------------------------------------------------------------------

			vc_map( array(
				"base" => "add_to_cart",
				"name" => esc_html__("Add to cart", 'kindlycare'),
				"description" => wp_kses_data( __("WooCommerce shortcode: Display a single product price + cart button", 'kindlycare') ),
				"category" => esc_html__('WooCommerce', 'kindlycare'),
				'icon' => 'icon_trx_add_to_cart',
				"class" => "trx_sc_single trx_sc_add_to_cart",
				"content_element" => true,
				"is_container" => false,
				"show_settings_on_create" => true,
				"params" => array(
					array(
						"param_name" => "id",
						"heading" => esc_html__("ID", 'kindlycare'),
						"description" => wp_kses_data( __("Product's ID", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "sku",
						"heading" => esc_html__("SKU", 'kindlycare'),
						"description" => wp_kses_data( __("Product's SKU code", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "quantity",
						"heading" => esc_html__("Quantity", 'kindlycare'),
						"description" => wp_kses_data( __("How many item add", 'kindlycare') ),
						"admin_label" => true,
						"class" => "",
						"value" => "1",
						"type" => "textfield"
					),
					array(
						"param_name" => "show_price",
						"heading" => esc_html__("Show price", 'kindlycare'),
						"description" => wp_kses_data( __("Show price near button", 'kindlycare') ),
						"class" => "",
						"value" => array("Show price" => "true" ),
						"type" => "checkbox"
					),
					array(
						"param_name" => "class",
						"heading" => esc_html__("Class", 'kindlycare'),
						"description" => wp_kses_data( __("CSS class", 'kindlycare') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					),
					array(
						"param_name" => "style",
						"heading" => esc_html__("CSS style", 'kindlycare'),
						"description" => wp_kses_data( __("CSS style for additional decoration", 'kindlycare') ),
						"class" => "",
						"value" => "",
						"type" => "textfield"
					)
				)
			) );

			class WPkindlycareShortCode_Add_To_Cart extends KINDLYCARE_VC_ShortCodeSingle {}
			*/
		}
	}
}

/* Fixed */
remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
remove_action('woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10);
remove_action('woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10);
?>