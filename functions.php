<?php

defined( 'ABSPATH' ) || exit;

use Chrysalis\T3\Plugin;

/**
 * Returns the plugin's main class instance.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @return  Plugin
 */
function tumblr3_get_plugin_instance(): Plugin {
	return Plugin::get_instance();
}

/**
 * Returns the plugin's slug.
 *
 * @since   1.0.0
 * @version 1.0.0
 *
 * @return  string
 */
function tumblr3_get_plugin_slug(): string {
	return sanitize_key( TUMBLR3_METADATA['TextDomain'] );
}

/**
 * We need a custom do_shortcode implementation because do_shortcodes_in_html_tags()
 * is run before running reguular shortcodes, which means that things like link hrefs
 * get populated before they even have context.
 *
 * @todo nested tags of the same type aren't rendering properly.
 *
 * @param string $content The content to parse.
 * @return string The parsed content.
 */
function tumblr3_do_shortcode( $content ): string {
	global $shortcode_tags;
	static $pattern = null;

	// Avoid generating this multiple times.
	if ( null === $pattern ) {
		$pattern = get_shortcode_regex( array_keys( $shortcode_tags ) );
	}

	$content = preg_replace_callback( "/$pattern/", 'do_shortcode_tag', $content );

	// Always restore square braces so we don't break things like <!--[if IE ]>.
	$content = unescape_invalid_shortcodes( $content );

	return $content;
}

/**
 * Gets the current parse context.
 * Used for informing data tags of their context.
 * Also used for storing data to pass between tags.
 *
 * @return array|null|string The current parse context.
 */
function tumblr3_get_parse_context() {
	global $tumblr3_parse_context;
	return $tumblr3_parse_context;
}

/**
 * Sets the global parse context.
 *
 * @param string $key
 * @param array  $value
 * @return void
 */
function tumblr3_set_parse_context( $key, $value ): void {
	global $tumblr3_parse_context;
	$tumblr3_parse_context = array( $key => $value );
}

/**
 * The main parser in the plugin.
 * This turns a Tumblr .HTML template into something parseable by WordPress.
 * Currently that's [shortcode] syntax, this could change in the future if needed.
 *
 * @param string $content Tumblr theme HTML content.
 * @return string Parsed content.
 */
function tumblr3_theme_parse( $content ): string {
	$tags      = array_map( 'strtolower', array_keys( TUMBLR3_TAGS ) );
	$blocks    = array_map( 'strtolower', array_keys( TUMBLR3_BLOCKS ) );
	$lang      = array_map( 'strtolower', array_keys( TUMBLR3_LANG ) );
	$options   = array_map( 'strtolower', array_keys( TUMBLR3_OPTIONS ) );
	$modifiers = array_map( 'strtolower', TUMBLR3_MODIFIERS );

	// Capture each Tumblr Tag in the page and verify it against our arrays.
	$content = preg_replace_callback(
		'/\{(.*?)\}/',
		function ( $matches ) use ( $tags, $blocks, $lang, $options, $modifiers ) {
			$captured_tag = $matches[0];
			$raw_tag      = strtolower( $matches[1] );
			$trim_tag     = strtolower( explode( ' ', $matches[1] )[0] );
			$attr         = '';

			/**
			 * Convert "IfNot" theme option boolean blocks into a custom shortcode.
			 */
			if ( str_starts_with( ltrim( strtolower( $raw_tag ), '/' ), 'block:ifnot' ) ) {
				$normalized_attr = str_replace(
					array(
						' ',
						'block:ifnot',
					),
					'',
					strtolower( $raw_tag )
				);

				return ( str_starts_with( $raw_tag, '/' ) ) ? '[/block_ifnot_theme_option]' : '[block_ifnot_theme_option name="' . $normalized_attr . '"]';
			}

			/**
			 * Convert "If" theme option boolean blocks into a custom shortcode.
			 */
			if ( str_starts_with( ltrim( strtolower( $raw_tag ), '/' ), 'block:if' ) ) {
				$normalized_attr = str_replace(
					array(
						' ',
						'block:if',
					),
					'',
					strtolower( $raw_tag )
				);

				return ( str_starts_with( $raw_tag, '/' ) ) ? '[/block_if_theme_option]' : '[block_if_theme_option name="' . $normalized_attr . '"]';
			}

			/**
			 * Test for modifiers.
			 */
			$applied_modifier = '';
			foreach ( $modifiers as $modifier ) {
				if ( str_starts_with( $raw_tag, $modifier ) ) {
					$applied_modifier = strtolower( $modifier );
					$raw_tag          = strtolower( substr( $raw_tag, strlen( $modifier ) ) );
					$trim_tag         = strtolower( substr( $trim_tag, strlen( $modifier ) ) );
					break;
				}
			}

			/**
			 * Handle theme options (dynamic tags).
			 *
			 * @todo This system doesn't account for modifiers at the front of tags. This might not be a problem however.
			 */
			foreach ( $options as $option ) {
				if ( str_starts_with( $raw_tag, $option ) ) {
					$option_name = strtolower( str_replace( ' ', '', substr( $raw_tag, strlen( $option ) ) ) );
					$theme_mod   = get_theme_mod( $option_name );

					return $theme_mod ? $theme_mod : $captured_tag;
				}
			}

			// Verify the block against our array.
			// @todo write attribute parser.
			if ( str_starts_with( ltrim( $raw_tag, '/' ), 'block:' ) ) {
				$block_parts = explode( ' ', trim( $raw_tag ) );

				if ( in_array( ltrim( $block_parts[0], '/' ), $blocks, true ) ) {
					return '[' . str_replace( 'block:', 'block_', strtolower( $raw_tag ) ) . ']';
				}

				// False positive.
				return $captured_tag;
			}

			// Is the tag one of the portrait functions? Convert the sizing to an attribute to avoid a function for each size.
			if ( str_ends_with( $trim_tag, '-16' ) ||
			str_ends_with( $trim_tag, '-24' ) ||
			str_ends_with( $trim_tag, '-30' ) ||
			str_ends_with( $trim_tag, '-40' ) ||
			str_ends_with( $trim_tag, '-48' ) ||
			str_ends_with( $trim_tag, '-64' ) ||
			str_ends_with( $trim_tag, '-96' ) ||
			str_ends_with( $trim_tag, '-100' ) ||
			str_ends_with( $trim_tag, '-128' ) ||
			str_ends_with( $trim_tag, '-250' ) ||
			str_ends_with( $trim_tag, '-400' ) ||
			str_ends_with( $trim_tag, '-500' ) ||
			str_ends_with( $trim_tag, '-640' ) ||
			str_ends_with( $trim_tag, '-700' )
			) {
				$split_tag = explode( '-', $trim_tag );

				// Ensure the tag is in the correct format.
				if ( count( $split_tag ) !== 2 ) {
					return $captured_tag;
				}

				$trim_tag = $split_tag[0];
				$attr     = ' size=' . $split_tag[1];
			}

			// Verify the tag against our array of known tags.
			if ( in_array( ltrim( $trim_tag, '/' ), $tags, true ) ) {
				$shortcode         = 'tag_' . strtolower( $trim_tag );
				$attributes        = array_filter( array( $attr, $applied_modifier ? "modifier=\"$applied_modifier\"" : '' ) );
				$attributes_string = implode( ' ', $attributes );
				return "[{$shortcode} {$attributes_string}]";
			}

			// Verify the lang tag against our array of known tags.
			$pos = array_search( substr( $raw_tag, 5 ), $lang, true );

			// If the lang tag is found, return the correct language. Accounts for different return types.
			if ( false !== $pos ) {
				$return_lang = array_values( TUMBLR3_LANG )[ $pos ];
				return ( is_array( $return_lang ) ) ? $return_lang[0] : $return_lang;
			}

			return $captured_tag;
		},
		$content
	);

	return $content;
}

// Currently unused, will likely be used in future development before the final release.
require TUMBLR3_PATH . 'includes/assets.php';

// Include tag and block hydration functions.
require TUMBLR3_PATH . 'includes/missing-functions.php';
require TUMBLR3_PATH . 'includes/block-functions.php';
require TUMBLR3_PATH . 'includes/tag-functions.php';

/**
 * Filter to handle modifiers in shortcode output.
 *
 * @param string $output The shortcode output.
 * @param string $tag    The shortcode name.
 * @param array  $attr   The shortcode attributes.
 * @return string The modified output.
 */
function tumblr3_handle_modifiers( $output, $tag, $attr ) {
	if ( isset( $attr['modifier'] ) ) {
		switch ( $attr['modifier'] ) {
			case 'rgb':
				// Convert hex to RGB
				if ( preg_match( '/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i', $output, $parts ) ) {
					$r      = hexdec( $parts[1] );
					$g      = hexdec( $parts[2] );
					$b      = hexdec( $parts[3] );
					$output = "$r, $g, $b";
				}
				break;
			case 'plaintext':
				$output = wp_strip_all_tags( $output );
				break;
			case 'js':
				$output = wp_json_encode( $output );
				break;
			case 'jsplaintext':
				$output = wp_json_encode( wp_strip_all_tags( $output ) );
				break;
			case 'urlencoded':
				$output = urlencode( $output );
				break;
		}
	}
	return $output;
}
add_filter( 'tumblr3_shortcode_output', 'tumblr3_handle_modifiers', 10, 3 );
