<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'kindlycare_template_date_theme_setup' ) ) {
	add_action( 'kindlycare_action_before_init_theme', 'kindlycare_template_date_theme_setup', 1 );
	function kindlycare_template_date_theme_setup() {
		kindlycare_add_template(array(
			'layout' => 'date',
			'mode'   => 'blogger',
			'title'  => esc_html__('Blogger layout: Timeline', 'kindlycare')
			));
	}
}

// Template output
if ( !function_exists( 'kindlycare_template_date_output' ) ) {
	function kindlycare_template_date_output($post_options, $post_data) {
		if (kindlycare_param_is_on($post_options['scroll'])) kindlycare_enqueue_slider();
		kindlycare_template_set_args('reviews-summary', array(
			'post_options' => $post_options,
			'post_data' => $post_data
		));
		get_template_part(kindlycare_get_file_slug('templates/_parts/reviews-summary.php'));
		$reviews_summary = kindlycare_storage_get('reviews_summary');
		?>
		
		<div class="post_item sc_blogger_item
			<?php if ($post_options['number'] == $post_options['posts_on_page'] && !kindlycare_param_is_on($post_options['loadmore'])) echo ' sc_blogger_item_last';
				//. (kindlycare_param_is_on($post_options['scroll']) ? ' sc_scroll_slide swiper-slide' : ''); ?>" 
			<?php echo 'horizontal'==$post_options['dir'] ? ' style="width:'.(100/$post_options['posts_on_page']).'%"' : ''; ?>>
			<div class="sc_blogger_date">
				<span class="day_month"><?php kindlycare_show_layout($post_data['post_date_part1']); ?></span>
				<span class="year"><?php kindlycare_show_layout($post_data['post_date_part2']); ?></span>
			</div>

			<div class="post_content">
				<h6 class="post_title sc_title sc_blogger_title">
					<?php echo (!isset($post_options['links']) || $post_options['links'] ? '<a href="' . esc_url($post_data['post_link']) . '">' : ''); ?>
					<?php kindlycare_show_layout($post_data['post_title']); ?>
					<?php echo (!isset($post_options['links']) || $post_options['links'] ? '</a>' : ''); ?>
				</h6>
				
				<?php kindlycare_show_layout($reviews_summary); ?>
	
				<?php if (kindlycare_param_is_on($post_options['info'])) { ?>
				<div class="post_info">
					<span class="post_info_item post_info_posted_by"><?php esc_html_e('by', 'kindlycare'); ?> <a href="<?php echo esc_url($post_data['post_author_url']); ?>" class="post_info_author"><?php echo esc_html($post_data['post_author']); ?></a></span>
					<span class="post_info_item post_info_counters">
						<?php echo 'comments'==$post_options['orderby'] || 'comments'==$post_options['counters'] ? esc_html__('Comments', 'kindlycare') : esc_html__('Views', 'kindlycare'); ?>
						<span class="post_info_counters_number"><?php echo 'comments'==$post_options['orderby'] || 'comments'==$post_options['counters'] ? esc_html($post_data['post_comments']) : esc_html($post_data['post_views']); ?></span>
					</span>
				</div>
				<?php } ?>

			</div>	<!-- /.post_content -->
		
		</div>		<!-- /.post_item -->

		<?php
		if ($post_options['number'] == $post_options['posts_on_page'] && kindlycare_param_is_on($post_options['loadmore'])) {
		?>
			<div class="load_more<?php //echo esc_attr(kindlycare_param_is_on($post_options['scroll']) && $post_options['dir'] == 'vertical' ? ' sc_scroll_slide swiper-slide' : ''); ?>"<?php echo 'horizontal'==$post_options['dir'] ? ' style="width:'.(100/$post_options['posts_on_page']).'%"' : ''; ?>></div>
		<?php
		}
	}
}
?>