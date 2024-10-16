<?php

namespace Chrysalis\T3;

defined( 'ABSPATH' ) || exit;

/**
 * This class is responsible for mocking a WordPress theme to enable the theme_mod system and others.
 */
class Theme {
	/**
	 * Initializes the class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  void
	 */
	public function initialize(): void {
		// Setup theme functions.
		add_action( 'after_setup_theme', array( $this, 'theme_support' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Setup theme support.
	 *
	 * @return void
	 */
	public function theme_support(): void {
		add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery', 'link', 'audio', 'video', 'quote', 'chat' ) );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'custom-header' );
		add_theme_support( 'header-text' );
		add_theme_support( 'custom-logo' );
	}

	/**
	 * Enqueue theme styles and scripts.
	 *
	 * @return void
	 */
	public function enqueue_scripts(): void {
		wp_enqueue_style( 'tumblr3-style', TUMBLR3_URL . 'assets/css/build/index.css', array(), TUMBLR3_METADATA['Version'] );
	}
}
