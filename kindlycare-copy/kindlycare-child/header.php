<?php
/**
 * The Header for our theme.
 */


// Theme init - don't remove next functions! Load custom options
kindlycare_theme_init();
$theme_init =  kindlycare_theme_options();

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo 'scheme_' . esc_attr($theme_init['body_scheme']); ?>">
<head>
	<?php wp_head(); ?>
</head>

<body <?php body_class();?>>

	<?php 
	kindlycare_profiler_add_point(esc_html__('BODY start', 'kindlycare'));
	
	kindlycare_show_layout(kindlycare_get_custom_option('gtm_code'));

	// Page preloader
	if (($preloader = kindlycare_get_theme_option('page_preloader')) != '') {
		?><div id="page_preloader"></div><?php
	}

	do_action( 'before' );

	// Add TOC items 'Home' and "To top"
    kindlycare_add_toc();
	?>

	<?php if ( !kindlycare_param_is_off(kindlycare_get_custom_option('show_sidebar_outer')) ) { ?>
	<div class="outer_wrap">
	<?php } ?>

	<?php get_template_part(kindlycare_get_file_slug('sidebar_outer.php')); ?>

	<?php
		$class = $style = '';
		if (kindlycare_get_custom_option('bg_custom')=='yes' && ($theme_init['body_style']=='boxed' || kindlycare_get_custom_option('bg_image_load')=='always')) {
			if (($img = kindlycare_get_custom_option('bg_image_custom')) != '')
				$style = 'background: url('.esc_url($img).') ' . str_replace('_', ' ', kindlycare_get_custom_option('bg_image_custom_position')) . ' no-repeat fixed;';
			else if (($img = kindlycare_get_custom_option('bg_pattern_custom')) != '')
				$style = 'background: url('.esc_url($img).') 0 0 repeat fixed;';
			else if (($img = kindlycare_get_custom_option('bg_image')) > 0)
				$class = 'bg_image_'.($img);
			else if (($img = kindlycare_get_custom_option('bg_pattern')) > 0)
				$class = 'bg_pattern_'.($img);
			if (($img = kindlycare_get_custom_option('bg_color')) != '')
				$style .= 'background-color: '.($img).';';
		}
	?>

	<div class="body_wrap<?php echo !empty($class) ? ' '.esc_attr($class) : ''; ?>"<?php echo !empty($style) ? ' style="'.esc_attr($style).'"' : ''; ?>>

		<?php
		if ($theme_init['video_bg_show']) {
			$youtube = kindlycare_get_custom_option('video_bg_youtube_code');
			$video   = kindlycare_get_custom_option('video_bg_url');
			$overlay = kindlycare_get_custom_option('video_bg_overlay')=='yes';
			if (!empty($youtube)) {
				?>
				<div class="video_bg<?php echo !empty($overlay) ? ' video_bg_overlay' : ''; ?>" data-youtube-code="<?php echo esc_attr($youtube); ?>"></div>
				<?php
			} else if (!empty($video)) {
				$info = pathinfo($video);
				$ext = !empty($info['extension']) ? $info['extension'] : 'src';
				?>
				<div class="video_bg<?php echo !empty($overlay) ? ' video_bg_overlay' : ''; ?>"><video class="video_bg_tag" width="1280" height="720" data-width="1280" data-height="720" data-ratio="16:9" preload="metadata" autoplay loop src="<?php echo esc_url($video); ?>"><source src="<?php echo esc_url($video); ?>" type="video/<?php echo esc_attr($ext); ?>"></source></video></div>
				<?php
			}
		}
		?>

		<div class="page_wrap">

			<?php
			kindlycare_profiler_add_point(esc_html__('Before Page Header', 'kindlycare'));
			// Top panel 'Above' or 'Over'
			if (in_array($theme_init['top_panel_position'], array('above', 'over'))) {
				kindlycare_show_post_layout(array(
					'layout' => $theme_init['top_panel_style'],
					'position' => $theme_init['top_panel_position'],
					'scheme' => $theme_init['top_panel_scheme']
					), false);
				// Mobile Menu
				get_template_part(kindlycare_get_file_slug('templates/headers/_parts/header-mobile.php'));

				kindlycare_profiler_add_point(esc_html__('After show menu', 'kindlycare'));
			}

			// Slider
			get_template_part(kindlycare_get_file_slug('templates/headers/_parts/slider.php'));
			
			// Top panel 'Below'
			if ($theme_init['top_panel_position'] == 'below') {
				kindlycare_show_post_layout(array(
					'layout' => $theme_init['top_panel_style'],
					'position' => $theme_init['top_panel_position'],
					'scheme' => $theme_init['top_panel_scheme']
					), false);
				// Mobile Menu
				get_template_part(kindlycare_get_file_slug('templates/headers/_parts/header-mobile.php'));

				kindlycare_profiler_add_point(esc_html__('After show menu', 'kindlycare'));
			}

			// Top of page section: page title and breadcrumbs
			$show_title = kindlycare_get_custom_option('show_page_title')=='yes';
			$show_navi = $show_title && is_single() && kindlycare_is_woocommerce_page();
			$show_breadcrumbs = kindlycare_get_custom_option('show_breadcrumbs')=='yes';
			if ($show_title || $show_breadcrumbs) {
				?>
				<div class="top_panel_title top_panel_style_<?php echo esc_attr(str_replace('header_', '', $theme_init['top_panel_style'])); ?> <?php echo (!empty($show_title) ? ' title_present'.  ($show_navi ? ' navi_present' : '') : '') . (!empty($show_breadcrumbs) ? ' breadcrumbs_present' : ''); ?> scheme_<?php echo esc_attr($theme_init['top_panel_scheme']); ?>">
					<div class="top_panel_title_inner top_panel_inner_style_<?php echo esc_attr(str_replace('header_', '', $theme_init['top_panel_style'])); ?> <?php echo (!empty($show_title) ? ' title_present_inner' : '') . (!empty($show_breadcrumbs) ? ' breadcrumbs_present_inner' : ''); ?>">
						<div class="content_wrap">
							<?php
							if ($show_title) {
								if ($show_navi) {
									?><div class="post_navi"><?php 
										previous_post_link( '<span class="post_navi_item post_navi_prev">%link</span>', '%title', true, '', 'product_cat' );
										next_post_link( '<span class="post_navi_item post_navi_next">%link</span>', '%title', true, '', 'product_cat' );
									?></div><?php
								} else {
									?><h1 class="page_title"><?php echo strip_tags(kindlycare_get_blog_title()); ?></h1><?php
								}
							}
							if ($show_breadcrumbs) {
								?><div class="breadcrumbs"><?php if (!is_404()) kindlycare_show_breadcrumbs(); ?></div><?php
							}
							?>
						</div>
					</div>
				</div>
				<?php
			}
			?>

			<div class="page_content_wrap page_paddings_<?php echo esc_attr(kindlycare_get_custom_option('body_paddings')); ?>">

				<?php
				kindlycare_profiler_add_point(esc_html__('Before Page content', 'kindlycare'));
				// Content and sidebar wrapper
				if ($theme_init['body_style']!='fullscreen') kindlycare_open_wrapper('<div class="content_wrap">');

                //*+ Woo content
                if (function_exists('is_shop')) {
                    if (file_exists(kindlycare_get_file_dir('templates/_parts/woo-content.php')) && is_shop()) {
                        get_template_part(kindlycare_get_file_slug('templates/_parts/woo-content.php'));
                    }
                }

				// Main content wrapper
				kindlycare_open_wrapper('<div class="content">');

				?>