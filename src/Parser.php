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
	private array $tags      = array();
	private array $tags_keys = array();

	/**
	 * The known Tumblr blocks.
	 *
	 * @var array
	 */
	private array $blocks      = array();
	private array $blocks_keys = array();

	/**
	 * The known Tumblr language tags.
	 *
	 * @var array
	 */
	private array $lang      = array();
	private array $lang_keys = array();

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

	private array $megatron = array();

	private array $content_map = array();

	private string $html;

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

		$this->tags_keys   = array_map( 'strtolower', array_keys( $this->tags ) );
		$this->blocks_keys = array_map( 'strtolower', array_keys( $this->blocks ) );
		$this->lang_keys   = array_map( 'strtolower', array_keys( $this->lang ) );

		// Build the megatron for verification.
		$this->megatron = array_merge(
			$this->tags_keys,
			$this->blocks_keys,
			$this->lang_keys
		);

		$this->set_parse_context( 'theme', true );

		// Hook this parser into the theme output.
		add_filter( 'tumblr3_theme_output', array( $this, 'parse_theme' ), 10 );
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

	private function debug_output( $output ) {
		echo '<pre>';
		print_r( $output );
		echo '</pre>';
	}

	private function normalize_tag( $tag ) {
		return strtolower( str_replace( array( '{', '}', '/' ), '', $tag ) );
	}

	public function parse_theme( $html ) {
		$this->html = $html;

		// Build the content map.
		$this->build_content_map();

		// Iteratively parse the content map.
		foreach ( $this->content_map as $chunk ) {
			$this->html = ( is_array( $chunk ) ) ? $this->parse_block( $chunk ) : $this->parse_tag( $chunk, $this->html );
		}

		return $this->html;
	}

	public function parse_block( $chunk ) {
		// Get block tags.
		$block_tag  = key( $chunk );
		$block_name = $this->normalize_tag( $block_tag );

		// Extract content HTML from inside the block.
		preg_match( "/$block_tag(.*?)$block_tag/is", $this->html, $matches );
		$original_content = $matches[0];
		$content          = $matches[1];

		// Process the block content.
		$args      = array_values( $this->blocks );
		$block_pos = array_search( $block_name, $this->blocks_keys, true );
		$content   = call_user_func( $args[ $block_pos ]['fn'], array(), $content );

		foreach ( $chunk as $tag ) {
			$content = ( is_array( $tag ) ) ? $this->parse_inner_block( $tag, $content ) : $this->parse_tag( $tag, $content );
		}

		return substr_replace( $this->html, $content, stripos( $this->html, $block_tag ), strlen( $original_content ) );
	}

	public function parse_inner_block( $chunk, $html ) {
		return $html;
	}

	public function parse_tag( $chunk, $html ) {
		$tag = strtolower( trim( $chunk, '{}' ) );

		// What kind of tag is this?
		// This is a lang tag.
		if ( stripos( $tag, 'lang:' ) === 0 ) {
			$args     = array_values( $this->lang );
			$lang_pos = array_search( $tag, $this->lang_keys, true );
			$content  = $args[ $lang_pos ];
			$html_pos = stripos( $html, $chunk );
			return substr_replace( $html, $content, $html_pos, strlen( $chunk ) );
		}

		// This is an option tag.
		foreach ( $this->options as $option ) {
			if ( stripos( $tag, $option ) === 0 ) {
				$content  = get_theme_mod( tumblr3_normalize_option_name( $tag ) );
				$html_pos = stripos( $html, $chunk );
				return substr_replace( $html, $content, $html_pos, strlen( $chunk ) );
			}
		}

		// This is a tag with a modifier.
		foreach ( $this->modifiers as $modifier ) {
			if ( stripos( $tag, $modifier ) === 0 ) {
				$tag = substr( $tag, strlen( $modifier ) ) . ' modifier="' . $modifier . '"';
				$this->debug_output( $tag );
				break;
			}
		}

		// This is a regular tag.
		$tag_pos = array_search( $tag, $this->tags_keys, true );
		if ( $tag_pos ) {
			$args     = array_values( $this->tags );
			$content  = call_user_func( $args[ $tag_pos ]['fn'], array() );
			$html_pos = stripos( $html, $chunk );
			return substr_replace( $html, $content, $html_pos, strlen( $chunk ) );
		}

		return $html;
	}

	/**
	 * Turn the HTML document into a content map array.
	 *
	 * @param string $html
	 *
	 * @return void
	 */
	private function build_content_map() {
		$all_tags = array();

		$this->html = preg_replace_callback(
			'/\{([a-zA-Z0-9][a-zA-Z0-9\\-\/=" ]*|font\:[a-zA-Z0-9 ]+|text\:[a-zA-Z0-9 ]+|select\:[a-zA-Z0-9 ]+|image\:[a-zA-Z0-9 ]+|color\:[a-zA-Z0-9 ]+|RGBcolor\:[a-zA-Z0-9 ]+|lang\:[a-zA-Z0-9- ]+|[\/]?block\:[a-zA-Z0-9]+( [a-zA-Z0-9=" ]+)*)\}/i',
			function ( $matches ) use ( &$all_tags ) {
				$matches[0] = strtolower( str_replace( '/', '', $matches[0] ) );
				$all_tags[] = $matches[0];
				return $matches[0];
			},
			$this->html
		);

		// Catch any tags that fail verification.
		$failures = array();

		// Verify the tags that were found.
		foreach ( $all_tags as $key => $tag ) {
			// Normalize the tag string.
			$tag      = $this->normalize_tag( $tag );
			$verified = false;

			// Does the tag start with a modifier?
			foreach ( $this->modifiers as $modifier ) {
				if ( strpos( $tag, $modifier ) === 0 ) {
					// Assume this tag is good.
					$verified = true;
					break;
				}
			}

			// Does this tag start with an option?
			foreach ( $this->options as $option ) {
				if ( strpos( $tag, $option ) === 0 ) {
					// Assume this tag is good.
					$verified = true;
					break;
				}
			}

			// If the tag is not yet verfied, and not in the megatron, remove it.
			if ( false === $verified && ! in_array( $tag, $this->megatron, true ) ) {
				$failures[] = $tag;
				unset( $all_tags[ $key ] );
				continue;
			}
		}

		// Re-index the array.
		$flat_map = array_values( array_filter( $all_tags ) );

		// Process the flat map into a content tree.
		$index             = 0;
		$count             = count( $flat_map );
		$this->content_map = $this->process_blocks_recursively( $flat_map, $count, $index );
	}

	public function process_blocks_recursively( &$flat_map, &$count, &$index = 0, &$current_block = null ) {
		$result = array();

		while ( $index < $count ) {
			// Get the current Tumblr tag.
			$tag = $flat_map[ $index ];

			// Normalize the tag string for comparison.
			$normal = $this->normalize_tag( $tag );

			// If we have a current block, and the current tag is the closing tag, return the result.
			if ( $current_block && strpos( $normal, $current_block ) === 0 ) {
				return $result;
			}

			// Determine if this is a block tag. Create a nested block by calling the function recursively.
			if ( strpos( $normal, 'block:' ) === 0 ) {
				++$index;

				// Use the new normal tag to set the current block.
				$nested_block = $this->process_blocks_recursively( $flat_map, $count, $index, $normal );
				$result[]     = array( $tag => $nested_block );
			} else {
				// Add a normal tag to the result.
				$result[] = $tag;
			}

			++$index;
		}

		return $result;
	}
}
