<?php

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'kindlycare_template_no_search_theme_setup' ) ) {
	add_action( 'kindlycare_action_before_init_theme', 'kindlycare_template_no_search_theme_setup', 1 );
	function kindlycare_template_no_search_theme_setup() {
		kindlycare_add_template(array(
			'layout' => 'no-search',
			'mode'   => 'internal',
			'title'  => esc_html__('No search results found', 'kindlycare')
		));
	}
}

// Template output
if ( !function_exists( 'kindlycare_template_no_search_output' ) ) {
	function kindlycare_template_no_search_output($post_options, $post_data) {
		?>
		<article class="post_item">
			<div class="post_content">
				<h2 class="post_title"><?php echo sprintf(esc_html__('Search: %s', 'kindlycare'), get_search_query()); ?></h2>
				<p><?php esc_html_e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'kindlycare' ); ?></p>
				<p><?php echo wp_kses_data( sprintf(__('Go back, or return to <a href="%s">%s</a> home page to choose a new page.', 'kindlycare'), esc_url(home_url('/')), get_bloginfo()) ); ?>
				<br><?php esc_html_e('Please report any broken links to our team.', 'kindlycare'); ?></p>
				<?php if (function_exists('kindlycare_sc_search'))  kindlycare_show_layout(kindlycare_sc_search(array('state'=>"fixed"))); ?>
			</div>	<!-- /.post_content -->
		</article>	<!-- /.post_item -->
		<?php
	}
}
?>