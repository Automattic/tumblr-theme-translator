<?php

namespace CupcakeLabs\T3;

defined( 'ABSPATH' ) || exit;

/**
 * Logical node for all integration functionalities.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Hooks {

	/**
	 * Initializes the Hooks.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  void
	 */
	public function initialize(): void {
		add_filter( 'do_shortcode_tag', array( $this, 'tumblr3_handle_modifiers' ), 10, 3 );
		
	}
	/**
	 * Filter to handle modifiers in shortcode output.
	 *
	 * @param string $output The shortcode output.
	 * @param string $tag    The shortcode name.
	 * @param array  $attr   The shortcode attributes.
	 *
	 * @return string The modified output.
	 */
	public function tumblr3_handle_modifiers( $output, $tag, $attr ) {
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
					$output = rawurlencode( $output );
					break;
			}
		}
		return $output;
	}
}
