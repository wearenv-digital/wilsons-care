<?php
add function ( 'wp_enqueue_scripts', 'my_theme_enqueue_styles');
function my_theme_enqueue_styles() {
	wp_enqueue_style('child-style',
	get_stylesheet_uri(),
	array('parenthandle'),
	wp_get_theme()-> get('Version'))
}





?>