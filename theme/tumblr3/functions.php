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

/**
 * Add a new query variable for Tumblr search.
 *
 * @param array $vars Registered query variables.
 *
 * @return array
 */
function tumblr3_add_tumblr_search_var( $vars ): array {
	$vars[] = 'q';
	return $vars;
}
add_filter( 'query_vars', 'tumblr3_add_tumblr_search_var' );

/**
 * Redirect Tumblr search to core search.
 *
 * @param WP_Query $query The main query.
 * @return void
 */
function tumblr3_redirect_tumblr_search( $query ): void {
	// Check if it's the main query and not in the admin area
	if ( $query->is_main_query() && ! is_admin() ) {

		// If 'q' is set, redirect to the core search page.
		if ( isset( $query->query_vars['q'] ) ) {
			wp_safe_redirect( home_url( '/?s=' . $query->query_vars['q'] ) );
			exit;
		}
	}
}
add_action( 'pre_get_posts', 'tumblr3_redirect_tumblr_search' );
