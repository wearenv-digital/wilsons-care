<?php
/**
 * Single post
 */
get_header(); 

$single_style = kindlycare_storage_get('single_style');
if (empty($single_style)) $single_style = kindlycare_get_custom_option('single_style');

while ( have_posts() ) { the_post();
	kindlycare_show_post_layout(
		array(
			'layout' => $single_style,
			'sidebar' => !kindlycare_param_is_off(kindlycare_get_custom_option('show_sidebar_main')),
			'content' => kindlycare_get_template_property($single_style, 'need_content'),
			'terms_list' => kindlycare_get_template_property($single_style, 'need_terms')
		)
	);
}

get_footer();
?>