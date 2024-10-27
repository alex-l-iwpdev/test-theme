<?php
/**
 * Functions theme file.
 *
 * @package iwpdev/test-theme
 */

/**
 * Add parent style.
 *
 * @return void
 */
function enqueue_parent_styles():void {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', '', '1.0', 'all' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );


require_once __DIR__ . '/vendor/autoload.php';


