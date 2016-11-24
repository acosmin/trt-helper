<?php

add_filter('show_admin_bar', '__return_false');

function tester_scripts() {
	wp_enqueue_script( 'tester-lazy', get_template_directory_uri() . '/js/lazy.js', array( 'jquery' ), '1.0.0' );
	wp_enqueue_script( 'tester-init', get_template_directory_uri() . '/js/init.js', array( 'jquery' ), '1.0.0' );

	wp_enqueue_style( 'tester-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'tester_scripts' );
