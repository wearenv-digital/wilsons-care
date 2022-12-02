<?php
/**
 * Attachment page
 */
get_header(); 

while ( have_posts() ) { the_post();

	// Move kindlycare_set_post_views to the javascript - counter will work under cache system
	if (kindlycare_get_custom_option('use_ajax_views_counter')=='no') {
		kindlycare_set_post_views(get_the_ID());
	}

	kindlycare_show_post_layout(
		array(
			'layout' => 'attachment',
			'sidebar' => !kindlycare_param_is_off(kindlycare_get_custom_option('show_sidebar_main'))
		)
	);

}

get_footer();
?>