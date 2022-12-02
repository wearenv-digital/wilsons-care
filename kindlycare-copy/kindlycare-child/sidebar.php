<?php
/**
 * The Sidebar containing the main widget areas.
 */

$sidebar_show   = kindlycare_get_custom_option('show_sidebar_main');
$sidebar_scheme = kindlycare_get_custom_option('sidebar_main_scheme');
$sidebar_name   = kindlycare_get_custom_option('sidebar_main');

if (!kindlycare_param_is_off($sidebar_show) && is_active_sidebar($sidebar_name)) {
	kindlycare_profiler_add_point(esc_html__('Before Sidebar', 'kindlycare'));
	?>
	<div class="sidebar widget_area scheme_<?php echo esc_attr($sidebar_scheme); ?>" role="complementary">
		<div class="sidebar_inner widget_area_inner">
			<?php
			ob_start();
			do_action( 'before_sidebar' );
			if (($reviews_markup = kindlycare_storage_get('reviews_markup')) != '') {
				echo '<aside class="column-1_1 widget widget_reviews">' . trim($reviews_markup) . '</aside>';
			}
			kindlycare_storage_set('current_sidebar', 'main');
			if ( !dynamic_sidebar($sidebar_name) ) {
				// Put here html if user no set widgets in sidebar
			}
			do_action( 'after_sidebar' );
			$out = ob_get_contents();
			ob_end_clean();
			kindlycare_show_layout(chop(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $out)));
			?>
		</div>
	</div> <!-- /.sidebar -->
	<?php
	kindlycare_profiler_add_point(esc_html__('After Sidebar', 'kindlycare'));
}
?>