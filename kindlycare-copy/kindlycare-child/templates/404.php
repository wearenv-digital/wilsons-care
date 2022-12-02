<?php
/*
 * The template for displaying "Page 404"
*/

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Theme setup section
-------------------------------------------------------------------- */

if ( !function_exists( 'kindlycare_template_404_theme_setup' ) ) {
	add_action( 'kindlycare_action_before_init_theme', 'kindlycare_template_404_theme_setup', 1 );
	function kindlycare_template_404_theme_setup() {
		kindlycare_add_template(array(
			'layout' => '404',
			'mode'   => 'internal',
			'title'  => 'Page 404',
			'theme_options' => array(
				'article_style' => 'stretch'
			)
		));
	}
}

// Template output
if ( !function_exists( 'kindlycare_template_404_output' ) ) {
	function kindlycare_template_404_output() {
		?>
		<article class="post_item post_item_404">
			<div class="post_content">
                <div class="image_page_404"></div>
                <h2 class="page_title"><?php esc_html_e( 'Sorry! Can\'t Find That Page!', 'kindlycare' ); ?><br><?php esc_html_e( 'Error 404!', 'kindlycare' ); ?></h2>
                <p class="page_description"><?php echo sprintf( esc_html__('Can\'t find what you need? Take a moment and', 'kindlycare') ) . '<br>'; echo wp_kses_data( sprintf( __('do a search below or start from our <a href="%s">homepage</a>.', 'kindlycare'), esc_url(home_url('/')) ) );?></p>
				<div class="page_search"><?php if (function_exists('kindlycare_sc_search')) kindlycare_show_layout(kindlycare_sc_search(array('state'=>'fixed', 'title'=>__('Enter keyword', 'kindlycare')))); ?></div>
			</div>
		</article>
		<?php
	}
}
?>