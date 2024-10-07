<?php
/**
 * The Tumblr Theme Translator bootstrap file.
 *
 * @since       1.0.0
 * @version     1.0.0
 * @author      WordPress.com Special Projects
 * @license     GPL-3.0-or-later
 *
 * @noinspection    ALL
 *
 * @wordpress-plugin
 * Plugin Name:             Tumblr Theme Translator
 * Plugin URI:              https://wpspecialprojects.wordpress.com
 * Description:             A scaffold for WP.com Special Projects plugins.
 * Version:                 1.0.0
 * Requires at least:       6.5
 * Tested up to:            6.5
 * Requires PHP:            8.2
 * Author:                  WordPress.com Special Projects
 * Author URI:              https://wpspecialprojects.wordpress.com
 * License:                 GPL v3 or later
 * License URI:             https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:             tumblr3
 * Domain Path:             /languages
 * WC requires at least:    8.8
 * WC tested up to:         8.8
 **/

defined( 'ABSPATH' ) || exit;

// Define plugin constants.
function_exists( 'get_plugin_data' ) || require_once ABSPATH . 'wp-admin/includes/plugin.php';
define( 'TUMBLR3_METADATA', get_plugin_data( __FILE__, false, false ) );

define( 'TUMBLR3_BASENAME', plugin_basename( __FILE__ ) );
define( 'TUMBLR3_PATH', plugin_dir_path( __FILE__ ) );
define( 'TUMBLR3_URL', plugin_dir_url( __FILE__ ) );

// Define tag and block names from Tumblr Theme language.
define( 'TUMBLR3_TAGS', require_once TUMBLR3_PATH . 'includes/tumblr-theme-language/tags.php' );
define( 'TUMBLR3_BLOCKS', require_once TUMBLR3_PATH . 'includes/tumblr-theme-language/blocks.php' );
define( 'TUMBLR3_LANG', require_once TUMBLR3_PATH . 'includes/tumblr-theme-language/lang.php' );
define( 'TUMBLR3_OPTIONS', require_once TUMBLR3_PATH . 'includes/tumblr-theme-language/options.php' );
define( 'TUMBLR3_MODIFIERS', require_once TUMBLR3_PATH . 'includes/tumblr-theme-language/modifiers.php' );

// Load plugin translations so they are available even for the error admin notices.
add_action(
	'init',
	static function () {
		load_plugin_textdomain(
			TUMBLR3_METADATA['TextDomain'],
			false,
			dirname( TUMBLR3_BASENAME ) . TUMBLR3_METADATA['DomainPath']
		);
	}
);

// Load the autoloader.
if ( ! is_file( TUMBLR3_PATH . '/vendor/autoload.php' ) ) {
	add_action(
		'admin_notices',
		static function () {
			$message      = __( 'It seems like <strong>Tumblr Theme Translator</strong> is corrupted. Please reinstall!', 'tumblr3' );
			$html_message = wp_sprintf( '<div class="error notice tumblr3-error">%s</div>', wpautop( $message ) );
			echo wp_kses_post( $html_message );
		}
	);
	return;
}
require_once TUMBLR3_PATH . '/vendor/autoload.php';

/**
 * At this point the plugin is loading correctly.
 *
 * Register a theme directory inside this plugin to load our mock theme.
 */
register_theme_directory( TUMBLR3_PATH . 'theme' );

/**
 * On activation, save the current theme to an option. Then switch to the mock theme.
 */
register_activation_hook(
	__FILE__,
	static function () {
		$theme = get_option( 'template' );
		update_option( 'tumblr3_original_theme', $theme );
		switch_theme( 'tumblr3' );
	}
);

/**
 * On deactivation, switch back to the orignial saved theme and delete the option.
 */
register_deactivation_hook(
	__FILE__,
	static function () {
		$theme = get_option( 'tumblr3_original_theme' );
		switch_theme( $theme );
		delete_option( 'tumblr3_original_theme' );
	}
);

require_once TUMBLR3_PATH . 'functions.php';
add_action( 'plugins_loaded', array( tumblr3_get_plugin_instance(), 'maybe_initialize' ) );
