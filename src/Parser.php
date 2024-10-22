<?php

namespace CupcakeLabs\T3;

use CupcakeLabs\T3\Processor;

defined( 'ABSPATH' ) || exit;

/**
 * This class is responsible for parsing the Tumblr theme HTML content.
 */
class Parser {
	/**
	 * The current parser context.
	 *
	 * @var array
	 */
	private array $context = array();

	/**
	 * The known Tumblr tags.
	 *
	 * @var array
	 */
	private array $tags = array();

	/**
	 * The known Tumblr blocks.
	 *
	 * @var array
	 */
	private array $blocks = array();

	/**
	 * The known Tumblr language tags.
	 *
	 * @var array
	 */
	private array $lang = array();

	/**
	 * The known Tumblr options.
	 *
	 * @var array
	 */
	private array $options = array();

	/**
	 * The known Tumblr modifiers.
	 *
	 * @var array
	 */
	private array $modifiers = array();

	/**
	 * Initializes the Parser class.
	 *
	 * @since   1.0.0
	 * @version 1.0.0
	 *
	 * @return  void
	 */
	public function initialize(): void {
		// Setup the known Tumblr tags.
		$this->tags      = require_once TUMBLR3_PATH . 'includes/tumblr-theme-language/tags.php';
		$this->blocks    = require_once TUMBLR3_PATH . 'includes/tumblr-theme-language/blocks.php';
		$this->lang      = require_once TUMBLR3_PATH . 'includes/tumblr-theme-language/lang.php';
		$this->options   = require_once TUMBLR3_PATH . 'includes/tumblr-theme-language/options.php';
		$this->modifiers = require_once TUMBLR3_PATH . 'includes/tumblr-theme-language/modifiers.php';

		$this->set_parse_context( 'theme', true );

		// Hook this parser into the theme output.
		add_filter( 'tumblr3_theme_output', array( $this, 'parse_fragment' ), 10 );
	}

	/**
	 * Parse the main theme HTML.
	 *
	 * @param string $theme The theme HTML straight from Tumblr.
	 *
	 * @return string The modified theme HTML.
	 */
	public function parse_fragment( string $html ): string {

		// Find all tags in the theme.
		$content_map = $this->find_tags( $html );

		// Verify the content map.
		$content_map = $this->verify_option_tags( $content_map );
		$content_map = $this->verify_lang_tags( $content_map );
		$content_map = $this->verify_block_tags( $content_map );
		$content_map = $this->verify_tag_tags( $content_map );

		// Cleanup leftover unverified tags from REGEX.
		$content_map = $this->clean_unverified_tags( $content_map );

		//echo '<pre>';
		//print_r( $this->context );
		//print_r( $content_map );
		//echo '</pre>';

		// Modify the theme HTML to be hydrated with WordPress tags.
		return $this->perform_replacements( $html, $content_map );
	}

	/**
	 * Set the current parse context.
	 *
	 * @return void
	 */
	public function set_parse_context( $key, $value ): void {
		$this->context = array( $key => $value );
	}

	/**
	 * Get the current parse context.
	 *
	 * @return array|null|string The current parse context.
	 */
	public function get_parse_context() {
		return $this->context;
	}

	/**
	 * Check if a tag is a closer.
	 *
	 * @param string $tag The tag to check.
	 *
	 * @return bool True if the tag is a closer, false otherwise.
	 */
	private function is_closer( $tag ): bool {
		return strpos( $tag, '/' ) === 0;
	}

	/**
	 * Rebuild a tag with the correct syntax.
	 *
	 * @param array  $content The content to rebuild.
	 * @param string $type    The type of tag to rebuild.
	 *
	 * @return string The rebuilt tag.
	 */
	private function rebuild_tag( $content, $type = 'tag' ): string {
		if ( 'option' === $type ) {
			$content['tag'] = str_replace( ' ', '', $content['tag'] );
		}

		return '{' . $content['tag'] . '}';
	}

	/**
	 * Find all tags in the theme.
	 *
	 * @return array The content map.
	 */
	private function find_tags( $html ): array {
		$content_map = array();

		// Find all tags in the theme.
		preg_match_all( '/\{([^\s}][^(#}]*)\}/', $html, $matches );

		// If we have matches, lowercase them and store them in the content map.
		if ( isset( $matches[1], $matches[1] ) ) {
			$lowercase_matches = array_map( 'strtolower', $matches[1] );

			foreach ( $lowercase_matches as $key => $match ) {
				// Remove any modifiers from the tag.
				// @todo bring the modifer logic back in.
				$match = explode( ' ', $match )[0];

				$content_map[] = array(
					'closer'       => $this->is_closer( $match ),
					'tag'          => $this->is_closer( $match ) ? ltrim( $match, '/' ) : $match,
					'original'     => $matches[0][ $key ],
					'original_raw' => explode( ' ', trim( $matches[0][ $key ], '{}' ) )[0],
					'verified'     => false,
				);
			}
		}

		return $content_map;
	}

	/**
	 * Verify the content map by checking for valid option tags.
	 *
	 * @return void
	 */
	private function verify_option_tags( $content_map ): array {
		// Loop through each option prefix.
		foreach ( $this->options as $option_name ) {
			// Loop through each content map item.
			foreach ( $content_map as $key => $content ) {
				// Skip if the content has already been verified.
				if ( $content['verified'] ) {
					continue;
				}

				if ( 0 === strpos( $content['tag'], $option_name ) ) {
					$content_map[ $key ]['verified'] = ( 'block:if' === $option_name ) ? 'block' : 'option';
					$content_map[ $key ]['tag']      = $this->rebuild_tag( $content, 'option' );
				}
			}
		}

		return $content_map;
	}

	/**
	 * Verify the content map by checking for valid lang tags.
	 *
	 * @return void
	 */
	private function verify_lang_tags( $content_map ): array {
		$lang_array = array_map( 'strtolower', array_keys( $this->lang ) );

		foreach ( $content_map as $key => $content ) {
			// Skip if the content has already been verified.
			if ( $content['verified'] ) {
				continue;
			}

			// Skip if the content doesn't have a lang tag.
			if ( false === strpos( $content['tag'], 'lang:' ) ) {
				continue;
			}

			$lang_tag = substr( $content['tag'], 5 );

			if ( in_array( $lang_tag, $lang_array, true ) ) {
				$content_map[ $key ]['verified'] = 'lang';
				$content_map[ $key ]['tag']      = $this->rebuild_tag( $content );
			}
		}

		return $content_map;
	}

	/**
	 * Verify the content map by checking for valid block tags.
	 *
	 * @return void
	 */
	private function verify_block_tags( $content_map ): array {
		$block_array  = array_map( 'strtolower', array_keys( $this->blocks ) );
		$block_values = array_values( $this->blocks );

		foreach ( $content_map as $key => $content ) {
			// Skip if the content has already been verified.
			if ( $content['verified'] ) {
				continue;
			}

			if ( in_array( $content['tag'], $block_array, true ) ) {
				// What function verified this block?
				$content_map[ $key ]['verified'] = 'block';

				// Where does the block live in our array?
				$index = array_search( $content['tag'], $block_array, true );

				// Rebuild the block with the correct syntax.
				$content_map[ $key ]['tag'] = $this->rebuild_tag( $content, 'block' );

				// Store the block function for later use if this isn't a closer.
				if ( ! $content['closer'] && isset( $block_values[ $index ]['fn'] ) ) {
					$content_map[ $key ]['fn'] = $block_values[ $index ]['fn'];
				}
			}
		}

		return $content_map;
	}

	/**
	 * Verify the content map by checking for valid tag tags.
	 *
	 * @return void
	 */
	private function verify_tag_tags( $content_map ): array {
		$tag_array  = array_map( 'strtolower', array_keys( $this->tags ) );
		$tag_values = array_values( $this->tags );

		foreach ( $content_map as $key => $content ) {
			// Skip if the content has already been verified.
			if ( $content['verified'] ) {
				continue;
			}

			if ( in_array( $content['tag'], $tag_array, true ) ) {
				// What function verified this tag?
				$content_map[ $key ]['verified'] = 'tag';

				// Where does the tag live in our array?
				$index = array_search( $content['tag'], $tag_array, true );

				// Rebuild the tag with the correct syntax.
				$content_map[ $key ]['tag'] = $this->rebuild_tag( $content );

				// Get the function name from a case-insensitive array.
				if ( isset( $tag_values[ $index ]['fn'] ) ) {
					$content_map[ $key ]['fn'] = $tag_values[ $index ]['fn'];
				}
			}
		}

		return $content_map;
	}

	/**
	 * Clean up the content map by removing unverified tags.
	 *
	 * @return void
	 */
	private function clean_unverified_tags( $content_map ): array {
		foreach ( $content_map as $key => $content ) {
			if ( ! $content['verified'] ) {
				unset( $content_map[ $key ] );
			}
		}

		return $content_map;
	}

	/**
	 * Perform replacements on the theme HTML.
	 * Runs through the content map and replaces tags with their WordPress data.
	 *
	 * @return void
	 */
	private function perform_replacements( $html, $content_map ): string {
		$skip_keys = array();

		foreach ( $content_map as $key => $content ) {
			// Skip if this key is flagged as parsed witihin a looper.
			if ( in_array( $key, $skip_keys, true ) ) {
				continue;
			}

			switch ( $content['verified'] ) {
				case 'tag':
					$html = $this->perform_tag_replacement( $html, $content_map, $key );
					break;
				case 'block':
					$args = $this->perform_block_replacement( $html, $content_map, $key );
					$html = $args['html'];

					if ( isset( $args['looper'] ) && $args['looper'] ) {
						for ( $i = $args['key_start']; $i <= $args['key_end']; $i++ ) {
							$skip_keys[] = $i;
						}
					}
					break;
				case 'lang':
					$html = $this->perform_lang_replacement( $html, $content_map, $key );
					break;
				case 'option':
					$html = $this->perform_option_replacement( $html, $content_map, $key );
					break;
			}

			$content_map[ $key ]['parsed'] = true;
		}

		//echo '<pre>';
		//print_r( $content_map );
		//echo '</pre>';

		return $html;
	}

	/**
	 * Perform a tag replacement.
	 *
	 * @param string $key The key in the content map to replace.
	 *
	 * @return void
	 */
	private function perform_tag_replacement( $html, $content_map, $key ): string {
		$args = $content_map[ $key ];

		// There's no function for this tag, skip it.
		if ( ! function_exists( $args['fn'] ) ) {
			return $html;
		}

		// Find the first instance of this original, unmodified tag in the theme HTML.
		$tag_start_position = strpos( $html, $args['original'] );

		// If a start position can't be found, skip this tag.
		if ( false === $tag_start_position ) {
			return $html;
		}

		// Get the hydrated content for this tag.
		$tag_content = call_user_func( $args['fn'], $args['tag'] );

		// Replace the tag in the theme HTML with the hydrated content.
		return substr_replace( $html, $tag_content, $tag_start_position, strlen( $args['original'] ) );
	}

	/**
	 * Perform a block replacement.
	 *
	 * @param string $key The key in the content map to replace.
	 *
	 * @return void
	 */
	private function perform_block_replacement( $html, $content_map, $key ): array {
		$args = $content_map[ $key ];

		// If this block is a closer, skip it, it will be handled by the opener.
		if ( $args['closer'] ) {
			return array(
				'html' => $html,
			);
		}

		if ( 0 === strpos( $args['tag'], '{block:if' ) ) {
			$args['fn'] = 'tumblr3_block_if';
		}

		$closer_count = 1;
		$found_closer = 0;
		$closer_key   = 0;

		// If there's no function for this block, skip it.
		if ( ! function_exists( $args['fn'] ) ) {
			return array(
				'html' => $html,
			);
		}

		// Find the first position of this block in the theme HTML.
		$block_start_position = strpos( $html, $args['original'] );

		// If a start position can't be found, skip this block.
		if ( false === $block_start_position ) {
			return array(
				'html' => $html,
			);
		}

		// Loop through the content map to find the closer for this block.
		foreach ( $content_map as $map_key => $map_content ) {
			// Skip if the map key is less than the current key, we don't parse backwards.
			if ( $map_key <= $key ) {
				continue;
			}

			// We found another opener of the same tag, now we need the nth closer.
			if ( $map_content['tag'] === $args['tag'] && ! $map_content['closer'] ) {
				++$closer_count;
				continue;
			}

			// We found a closer of the same tag.
			if ( $map_content['tag'] === $args['tag'] && $map_content['closer'] ) {
				++$found_closer;

				// If we found the correct closer, break the loop.
				if ( $found_closer === $closer_count ) {
					$closer_key         = $map_key;
					$block_end_position = strpos( $html, $map_content['original'] ) + strlen( $map_content['original'] );
					break;
				}
			}
		}

		// If a block end position can't be found, skip this block.
		if ( ! isset( $block_end_position ) ) {
			return array(
				'html' => $html,
			);
		}

		// Get the hydrated content for this block.
		$block_content = call_user_func(
			$args['fn'],
			$args['tag'],
			substr(
				$html,
				$block_start_position + strlen( $args['original'] ),
				$block_end_position - ( $block_start_position + strlen( $args['original'] ) ) - ( strlen( $args['original'] ) + 1 )
			),
			$args['tag']
		);

		// Replace the block in the theme HTML with the hydrated content.
		return array(
			'html'      => substr_replace( $html, $block_content, $block_start_position, $block_end_position - $block_start_position ),
			'looper'    => isset( $this->blocks[ $args['original_raw'] ]['looper'] ),
			'key_start' => $key,
			'key_end'   => $closer_key,
		);
	}

	/**
	 * Replace language tags in the theme HTML.
	 *
	 * @param int $key The key in the content map to replace.
	 * @return void
	 */
	private function perform_lang_replacement( $html, $content_map, $key ): string {
		$args = $content_map[ $key ];

		// Find the first instance of this original, unmodified tag in the theme HTML.
		$tag_start_position = strpos( $html, $args['original'] );

		// If a start position can't be found, skip this tag.
		if ( false === $tag_start_position ) {
			return $html;
		}

		// Get the hydrated content for this tag.
		$tag_content = $this->lang[ substr( $args['original_raw'], 5 ) ];

		// Replace the tag in the theme HTML with the hydrated content.
		return substr_replace( $html, $tag_content, $tag_start_position, strlen( $args['original'] ) );
	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $html
	 * @param [type] $content_map
	 * @param [type] $key
	 * @return string
	 */
	private function perform_option_replacement( $html, $content_map, $key ): string {
		$args = $content_map[ $key ];

		// Find the first instance of this original, unmodified tag in the theme HTML.
		$tag_start_position = strpos( $html, $args['original'] );

		// If a start position can't be found, skip this tag.
		if ( false === $tag_start_position ) {
			return $html;
		}

		// Get the hydrated content for this tag.
		$tag_content = get_theme_mod( tumblr3_normalize_option_name( $args['tag'] ) );

		// Replace the tag in the theme HTML with the hydrated content.
		return substr_replace( $html, $tag_content, $tag_start_position, strlen( $args['original'] ) );
	}
}
