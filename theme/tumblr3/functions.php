<?php
/**
 * Tumblr3 functions and definitions
 *
 * @package Tumblr3
 */
defined( 'ABSPATH' ) || exit;

/**
 * Setup theme support.
 *
 * @return void
 */
function tumblr3_theme_support(): void {
	global $content_width;

	if ( ! isset( $content_width ) ) {
		$content_width = 600;
	}

	add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery', 'link', 'audio', 'video', 'quote', 'chat' ) );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'custom-background' );
	add_theme_support( 'custom-header' );
	add_theme_support( 'header-text' );
	add_theme_support( 'custom-logo' );
}
add_action( 'after_setup_theme', 'tumblr3_theme_support' );

/**
 * Enqueue theme styles and scripts.
 *
 * @return void
 */
function tumblr3_enqueue_scripts(): void {
	wp_enqueue_style( 'tumblr3-style', TUMBLR3_URL . 'assets/css/build/index.css', array(), TUMBLR3_METADATA['Version'] );
}
add_action( 'wp_enqueue_scripts', 'tumblr3_enqueue_scripts' );
