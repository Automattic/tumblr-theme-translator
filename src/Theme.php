<?php

namespace Chrysalis\T3;

defined( 'ABSPATH' ) || exit;

/**
 * This class is responsible for mocking a WordPress theme.
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
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function theme_support(): void {
		/**
		 * @todo Rename post format labels to match Tumblr, e.g aside === answer.
		 */
		add_theme_support( 'post-formats', array( 'aside', 'image', 'gallery', 'link', 'audio', 'video', 'quote', 'chat' ) );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'custom-header' );
		add_theme_support( 'header-text' );
		add_theme_support( 'custom-logo' );
	}
}
