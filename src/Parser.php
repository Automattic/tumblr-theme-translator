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

	private int $offset = 0;

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

		// Lowercase all keys for easier matching.
		$this->tags   = array_change_key_case( $this->tags, CASE_LOWER );
		$this->blocks = array_change_key_case( $this->blocks, CASE_LOWER );
		$this->lang   = array_change_key_case( $this->lang, CASE_LOWER );

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

	private function get_regex_pattern() {
		return '\{([a-zA-Z0-9][a-zA-Z0-9\\-\/=" ]*|font\:[a-zA-Z0-9 ]+|text\:[a-zA-Z0-9 ]+|select\:[a-zA-Z0-9 ]+|image\:[a-zA-Z0-9 ]+|color\:[a-zA-Z0-9 ]+|RGBcolor\:[a-zA-Z0-9 ]+|lang\:[a-zA-Z0-9- ]+|[\/]?block\:[a-zA-Z0-9]+( [a-zA-Z0-9=" ]+)*)\}';
	}

	public function parse_theme( $html ) {
		// Count matches.
		$count = 0;

		// Normalize the theme HTML wherever possible.
		$this->html = preg_replace_callback(
			'/' . $this->get_regex_pattern() . '/i',
			function ( $matches ) use ( &$count, &$all_tags ) {
				++$count;
				$matches[0] = strtolower( str_replace( '{/', '{', $matches[0] ) );
				$all_tags[] = $matches[0];
				return $matches[0];
			},
			$html
		);

		// Parse through each found tag.
		$this->parse_next_tag( $this->html );

		return $this->html;
	}

	public function parse_next_tag( $html ) {
		preg_match( '/' . $this->get_regex_pattern() . '/i', $html, $matches, PREG_OFFSET_CAPTURE, $this->offset );

		// If we don't find any matches, we're done.
		if ( empty( $matches ) ) {
			$this->html = $html;
			return;
		}

		// Sanely name match variables.
		$tag        = $matches[0][0];
		$normal     = $matches[1][0];
		$tag_offset = $matches[0][1];
		$args       = array();

		// Increment the offset each time we find a new tag.
		$this->offset = $tag_offset;

		// If this tag isn't recognised, move the offset past it.
		if ( false ) {
			$this->offset += strlen( $tag );
		}

		// Is this a theme option?
		foreach ( $this->options as $option ) {
			if ( strpos( $normal, $option ) === 0 ) {

				$content = get_theme_mod( tumblr3_normalize_option_name( $tag ) );

				$this->parse_next_tag(
					substr_replace(
						$html,
						$content,
						$tag_offset,
						strlen( $tag )
					)
				);

				return;
			}
		}

		$this->parse_next_tag(
			substr_replace(
				$html,
				'hi',
				$tag_offset,
				strlen( $tag )
			)
		);
	}

	/**
	 * This should not load on front-end views.
	 * Effectively, this shortcode strips unwanted HTML.
	 * This is the desired outcome, so not marking as a missing block.
	 *
	 * @return string Nothing, this is intentionally blank on the front-end.
	 */
	public function tumblr3_block_options(): string {
		return '';
	}

	public function tumblr3_block_if( $atts, $content, $name ): string {
		$type        = ( 0 === strpos( $name, '{block:ifnot' ) ) ? 'ifnot' : 'if';
		$option_name = substr( $name, strlen( '{block:' . $type ) + 1, -1 );

		return ( get_theme_mod( $option_name ) === ( 'if' === $type ) ) ? $content : '';
	}

	/**
	 * Returns parsed content if the blog has more than one post author.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_groupmembers( $atts, $content = '' ): string {
		// Get all users who have published posts
		$authors = get_users(
			array(
				'has_published_posts' => array( 'post' ),
			)
		);
		$output  = '';

		// Check if there is more than one author
		if ( count( $authors ) > 1 ) {
			tumblr3_set_parse_context( 'groupmembers', $authors );
			$output = $content;
			tumblr3_set_parse_context( 'theme', true );
		}

		return $output;
	}

	/**
	 * Loops over all group members and parses shortcodes within the block.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_groupmember( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();
		$plugin  = tumblr3_get_plugin_instance();
		$output  = '';

		if ( isset( $context['groupmembers'] ) ) {
			$authors = $context['groupmembers'];

			// Loop over each blog author.
			foreach ( $authors as $author ) {
				tumblr3_set_parse_context( 'groupmember', $author );
				$output .= $content;
			}

			tumblr3_set_parse_context( 'theme', true );
		}

		return $output;
	}

	/**
	 * Outputs content if the twitter username theme set is not empty.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_twitter( $atts, $content = '' ): string {
		return ( '' !== get_theme_mod( 'twitter_username', '' ) ) ? $content : '';
	}

	/**
	 * Conditional check for if we're in the loop.
	 * This catches a bunch of blocks that should only render in the loop.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_body( $atts, $content = '' ): string {
		return ( in_the_loop() ) ? $content : '';
	}

	/**
	 * Outputs content if we should stretch the header image.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_stretchheaderimage( $atts, $content = '' ): string {
		return ( get_theme_mod( 'stretch_header_image', true ) ) ? $content : '';
	}

	/**
	 * Outputs content if we should not stretch the header image.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_nostretchheaderimage( $atts, $content = '' ): string {
		return ( get_theme_mod( 'stretch_header_image', true ) ) ? '' : $content;
	}

	/**
	 * Output content if we've chosen to show the site avatar.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_showavatar( $atts, $content = '' ): string {
		return ( get_theme_mod( 'show_avatar', true ) ) ? $content : '';
	}

	/**
	 * Output content if we've chosen to hide the site avatar.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_hideavatar( $atts, $content = '' ): string {
		return ( get_theme_mod( 'show_avatar', true ) ) ? '' : $content;
	}

	/**
	 * Output content if we've chosen to show the site title and description.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_showtitle( $atts, $content = '' ): string {
		return display_header_text() ? $content : '';
	}

	/**
	 * Output content if we've chosen to hide the site title and description.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_hidetitle( $atts, $content = '' ): string {
		return display_header_text() ? '' : $content;
	}

	/**
	 * Output content if we've chosen to show the site description.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_showdescription( $atts, $content = '' ): string {
		return display_header_text() ? $content : '';
	}

	/**
	 * Output content if we've chosen to hide the site description.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_hidedescription( $atts, $content = '' ): string {
		return display_header_text() ? '' : $content;
	}

	/**
	 * Rendered on index pages for posts with Read More breaks.
	 *
	 * @todo Test if the post has a read-more tag, currently this is always true if we're in the loop.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_more( $atts, $content = '' ): string {
		return in_the_loop() ? $content : '';
	}

	/**
	 * Rendered if the post has an excerpt.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_description( $atts, $content = '' ): string {
		return has_excerpt() ? $content : '';
	}

	/**
	 * The main posts loop.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_posts( $atts, $content = '' ): string {
		$output = '';
		$plugin = tumblr3_get_plugin_instance();

		tumblr3_set_parse_context( 'posts', true );

		// Use the content inside this shortcode as a template for each post.
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();

				$output .= $content;
			}
		}

		wp_reset_postdata();

		tumblr3_set_parse_context( 'theme', true );

		return $output;
	}

	/**
	 * Conditional if there are no posts.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_noposts( $atts, $content = '' ): string {
		return have_posts() ? '' : $content;
	}

	/**
	 * Post tags loop.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_tags( $atts, $content = '' ): string {
		$output = '';
		$terms  = wp_get_post_terms( get_the_ID() );
		$plugin = tumblr3_get_plugin_instance();

		foreach ( $terms as $term ) {
			tumblr3_set_parse_context( 'term', $term );
			$output .= $content;
		}

		tumblr3_set_parse_context( 'theme', true );

		return $output;
	}

	/**
	 * Rendered for each custom page.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_pages( $atts, $content = '' ): string {
		$output = '';
		$plugin = tumblr3_get_plugin_instance();

		$pages_query = get_posts(
			array(
				'post_type'      => 'page',
				'posts_per_page' => -1,
				'fields'         => 'ids',
			)
		);

		// Use the content inside this shortcode as a template for each post.
		foreach ( $pages_query as $page_id ) {
			tumblr3_set_parse_context( 'page', $page_id );
			$output .= $content;
		}

		tumblr3_set_parse_context( 'theme', true );

		return $output;
	}

	/**
	 * Boolean check for if we're on a search page.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_searchpage( $atts, $content = '' ): string {
		return is_search() ? $content : '';
	}

	/**
	 * Render content if there are no search results.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_nosearchresults( $atts, $content = '' ): string {
		global $wp_query;

		return ( is_search() && 0 === $wp_query->found_posts ) ? $content : '';
	}

	/**
	 * Render content if there are search results.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_searchresults( $atts, $content = '' ): string {
		global $wp_query;

		return ( is_search() && $wp_query->found_posts > 0 ) ? $content : '';
	}

	/**
	 * Render content if this site is not currently public.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_hidefromsearchenabled( $atts, $content = '' ): string {
		return ( '1' !== get_option( 'blog_public' ) ) ? $content : '';
	}

	/**
	 * Boolean check for if we're on a taxonomy page.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_tagpage( $atts, $content = '' ): string {
		return ( is_tag() || is_category() ) ? $content : '';
	}

	/**
	 * Boolean check for if we're on a single post or page.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_permalinkpage( $atts, $content = '' ): string {
		return ( is_page() || is_single() ) ? $content : '';
	}



	/**
	 * Boolean check for if we're on the home page.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_indexpage( $atts, $content = '' ): string {
		return is_home() ? $content : '';
	}

	/**
	 * Boolean check for if we're on the "front page".
	 * (This changes depending on settings chosen inside WordPress).
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_homepage( $atts, $content = '' ): string {
		return is_front_page() ? $content : '';
	}

	/**
	 * Sets the global parse context so we know we're outputting a post title.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_title( $atts, $content = '' ): string {
		tumblr3_set_parse_context( 'title', true );
		return $content;
	}

	/**
	 * If the current page is able to pagination, render the content.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_pagination( $atts, $content = '' ): string {
		return ( get_next_posts_page_link() || get_previous_posts_page_link() ) ? $content : '';
	}

	/**
	 * The Jump pagination block.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_jumppagination( $atts, $content = '' ): string {
		$plugin = tumblr3_get_plugin_instance();

		// Parse shortcode attributes.
		$atts = shortcode_atts(
			array(
				'length' => '5',
			),
			$atts,
			'block_jumppagination'
		);

		$output = '';

		if ( $atts['length'] > 0 ) {
			for ( $i = 1; $i <= $atts['length']; $i++ ) {
				tumblr3_set_parse_context( 'jumppagination', $i );
				$output .= $content;
			}
		}

		tumblr3_set_parse_context( 'theme', true );

		return $output;
	}

	/**
	 * The currentpage block inside jumppagination.
	 * Renders only if the current page is equal to the context.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_currentpage( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();
		$var     = get_query_var( 'paged' );
		$paged   = $var ? $var : 1;

		return ( isset( $context['jumppagination'] ) && $paged === $context['jumppagination'] ) ? $content : '';
	}

	/**
	 * The jumppage block inside jumppagination.
	 * Render if the current page is not equal to the context.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_jumppage( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();
		$var     = get_query_var( 'paged' );
		$paged   = $var ? $var : 1;

		return ( isset( $context['jumppagination'] ) && $paged !== $context['jumppagination'] ) ? $content : '';
	}

	/**
	 * Boolean check for if we're on a single post or page.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_posttitle( $atts, $content = '' ): string {
		return is_single() ? tumblr3_block_title( $content ) : '';
	}

	/**
	 * Rendered if you have defined any custom pages.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_haspages( $atts, $content = '' ): string {
		$pages_query = get_posts(
			array(
				'post_type'      => 'page',
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);

		return ( ! empty( $pages_query ) ) ? $content : '';
	}

	/**
	 * Rendered if you have "Show header image" enabled.
	 *
	 * @todo This.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_showheaderimage( $atts, $content = '' ): string {
		return ( 'remove-header' !== get_theme_mod( 'header_image', 'remove-header' ) ) ? $content : '';
	}

	/**
	 * Rendered if you have "Show header image" disabled.
	 *
	 * @todo This.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_hideheaderimage( $atts, $content = '' ): string {
		return ( 'remove-header' === get_theme_mod( 'header_image', 'remove-header' ) ) ? $content : '';
	}

	/**
	 * If a post is not a reblog, render the content.
	 *
	 * @todo This should be conditional, but WordPress doesn't currently support reblogs so it's static.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_notreblog( $atts, $content = '' ): string {
		return $content;
	}

	/**
	 * Rendered if the post has tags.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_hastags( $atts, $content = '' ): string {
		return ( has_tag() ) ? $content : '';
	}

	/**
	 * Rendered if the post has comments or comments open.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_postnotes( $atts, $content = '' ): string {
		return ( is_single() || is_page() ) && ( get_comments_number() || comments_open() ) ? $content : '';
	}

	/**
	 * Rendered if the post has at least one comment.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_notecount( $atts, $content = '' ): string {
		return ( comments_open() || get_comments_number() > 0 ) ? $content : '';
	}

	/**
	 * Rendered for legacy Text posts and NPF posts.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_text( $atts, $content = '' ): string {
		return ( false === get_post_format() ) ? $content : '';
	}

	/**
	 * Rendered for legacy quote posts, or the WordPress quote post format.
	 * Post logic is handled here, and then passed to the global context.
	 * Tags inside the quote block are handed data from the global context.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_quote( $atts, $content = '' ): string {
		global $post;

		// Don't parse all blocks if the post format is not quote.
		if ( 'quote' !== get_post_format() ) {
			return '';
		}

		$blocks = parse_blocks( $post->post_content );
		$output = '';
		$source = '';

		// Handle all blocks in the post content.
		foreach ( $blocks as $block ) {

			// Stop on the first quote block.
			if ( 'core/quote' === $block['blockName'] ) {
				$processor = new CupcakeLabs\T3\Processor( $block['innerHTML'] );

				// Set bookmarks to extract HTML positions.
				while ( $processor->next_tag(
					array(
						'tag_name'    => 'CITE',
						'tag_closers' => 'visit',
					)
				) ) {
					$processor->is_tag_closer() ? $processor->set_bookmark( 'CITE-CLOSE' ) : $processor->set_bookmark( 'CITE-OPEN' );
				}

				// Get the processor bookmarks.
				$offset_open  = $processor->get_bookmark( 'CITE-OPEN' );
				$offset_close = $processor->get_bookmark( 'CITE-CLOSE' );

				// Extract the source from the quote block.
				if ( is_a( $offset_open, 'WP_HTML_Span' ) && is_a( $offset_close, 'WP_HTML_Span' ) ) {
					$source = substr( $block['innerHTML'], $offset_open->start, $offset_close->start + $offset_close->length - $offset_open->start );
				}

				// Rebuild the quote block content. CITE does not live in an innerBlock.
				foreach ( $block['innerBlocks'] as $inner_block ) {
					$output .= $inner_block['innerHTML'];
				}

				// Only parse the first quote block.
				break;
			}
		}

		// Set the current context.
		tumblr3_set_parse_context(
			'quote',
			array(
				'quote'  => wp_kses(
					$output,
					array(
						'br'     => array(),
						'span'   => array(),
						'strong' => array(),
						'em'     => array(),
					)
				),
				'source' => $source,
				'length' => strlen( $output ),
			)
		);

		// Parse the content of the quote block before resetting the context.
		$content = $content;

		tumblr3_set_parse_context( 'theme', true );

		return $content;
	}

	/**
	 * Tests for a source in the quote post format.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_source( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();

		// Test if the current context is a quote post and has a source.
		if ( isset( $context['quote'], $context['quote']['source'] ) && ! empty( $context['quote']['source'] ) ) {
			return $content;
		}

		// Return nothing if no source is found.
		return '';
	}

	/**
	 * Rendered for chat posts.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_chat( $atts, $content = '' ): string {
		return ( 'chat' === get_post_format() ) ? $content : '';
	}

	/**
	 * Rendered for link posts.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_link( $atts, $content = '' ): string {
		return ( 'link' === get_post_format() ) ? $content : '';
	}

	/**
	 * Rendered for audio posts.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_audio( $atts, $content = '' ): string {
		global $post;

		// Don't parse all blocks if the post format is not quote.
		if ( 'audio' !== get_post_format() ) {
			return '';
		}

		$blocks    = parse_blocks( $post->post_content );
		$player    = '';
		$trackname = '';
		$artist    = '';
		$album     = '';
		$media_id  = null;

		// Handle all blocks in the post content.
		foreach ( $blocks as $block ) {

			// Stop on the first audio block.
			if ( 'core/audio' === $block['blockName'] ) {
				$media_id = isset( $block['attrs']['id'] ) ? $block['attrs']['id'] : 0;

				$processor = new CupcakeLabs\T3\Processor( $block['innerHTML'] );

				// Set bookmarks to extract HTML positions.
				while ( $processor->next_tag(
					array(
						'tag_name'    => 'AUDIO',
						'tag_closers' => 'visit',
					)
				) ) {
					// Check if we're in a closer or opener and handle accordingly.
					if ( $processor->is_tag_closer() ) {
						$processor->set_bookmark( 'AUDIO-CLOSE' );
					} else {
						$processor->add_class( 'tumblr_audio_player' );
						$processor->set_bookmark( 'AUDIO-OPEN' );
					}
				}

				// Get the processor bookmarks.
				$offset_open  = $processor->get_bookmark( 'AUDIO-OPEN' );
				$offset_close = $processor->get_bookmark( 'AUDIO-CLOSE' );

				// Extract the player from the quote block.
				if ( is_a( $offset_open, 'WP_HTML_Span' ) && is_a( $offset_close, 'WP_HTML_Span' ) ) {
					$player = substr( $processor->get_updated_html(), $offset_open->start, $offset_close->start + $offset_close->length - $offset_open->start );
				}

				break;
			}
		}

		// Extract metadata from the media ID.
		if ( is_int( $media_id ) ) {
			$meta      = wp_get_attachment_metadata( $media_id );
			$trackname = isset( $meta['title'] ) ? $meta['title'] : '';
			$artist    = isset( $meta['artist'] ) ? $meta['artist'] : '';
			$album     = isset( $meta['album'] ) ? $meta['album'] : '';
		}

		// Set the current context.
		tumblr3_set_parse_context(
			'audio',
			array(
				'player'    => $player,
				'art'       => get_the_post_thumbnail_url(),
				'trackname' => $trackname,
				'artist'    => $artist,
				'album'     => $album,
				'media_id'  => $media_id,
			)
		);

		// Parse the content of the quote block before resetting the context.
		$content = $content;

		tumblr3_set_parse_context( 'theme', true );

		return $content;
	}

	/**
	 * Rendered for audio posts with an audioplayer block.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_audioplayer( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();

		return ( isset( $context['audio']['player'] ) && ! empty( $context['audio']['player'] ) ) ? $content : '';
	}



	/**
	 * Rendered for audio posts with an external audio block.
	 * Calculated as meaning the media ID is 0, which means it's an external audio file.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_externalaudio( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();

		return ( isset( $context['audio']['media_id'] ) && 0 === $context['audio']['media_id'] ) ? $content : '';
	}

	/**
	 * Rendered for audio posts with a featured image set.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_albumart( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();

		return ( isset( $context['audio']['player'] ) && ! empty( $context['audio']['player'] ) ) ? $content : '';
	}

	/**
	 * Rendered for audio posts with a track name set.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_trackname( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();

		return ( isset( $context['audio']['trackname'] ) && '' !== $context['audio']['trackname'] ) ? $content : '';
	}

	/**
	 * Rendered for audio posts with an artist name set.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_artist( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();

		return ( isset( $context['audio']['artist'] ) && '' !== $context['audio']['artist'] ) ? $content : '';
	}

	/**
	 * Rendered for audio posts with an album name set.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_album( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();

		return ( isset( $context['audio']['album'] ) && '' !== $context['audio']['album'] ) ? $content : '';
	}

	/**
	 * Rendered for video posts.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_video( $atts, $content = '' ): string {
		global $post;

		// Don't parse all blocks if the post format is not quote.
		if ( 'video' !== get_post_format() ) {
			return '';
		}

		$blocks    = parse_blocks( $post->post_content );
		$media_id  = null;
		$thumbnail = '';

		// Handle all blocks in the post content.
		foreach ( $blocks as $block ) {

			// Stop on the first video block.
			if ( 'core/video' === $block['blockName'] ) {
				$processor = new CupcakeLabs\T3\Processor( $block['innerHTML'] );

				// Set bookmarks to extract HTML positions.
				while ( $processor->next_tag(
					array(
						'tag_name'    => 'VIDEO',
						'tag_closers' => 'visit',
					)
				) ) {
					// Check if we're in a closer or opener and handle accordingly.
					if ( $processor->is_tag_closer() ) {
						$processor->set_bookmark( 'VIDEO-CLOSE' );
					} else {
						$processor->set_bookmark( 'VIDEO-OPEN' );
						$thumbnail = $processor->get_attribute( 'poster' );
					}
				}

				// Get the processor bookmarks.
				$offset_open  = $processor->get_bookmark( 'VIDEO-OPEN' );
				$offset_close = $processor->get_bookmark( 'VIDEO-CLOSE' );

				// Extract the player from the quote block.
				if ( is_a( $offset_open, 'WP_HTML_Span' ) && is_a( $offset_close, 'WP_HTML_Span' ) ) {
					$player = substr( $block['innerHTML'], $offset_open->start, $offset_close->start + $offset_close->length - $offset_open->start );
				}

				break;
			}

			// No video block found, check for an embed block instead.
			if ( 'core/embed' === $block['blockName'] ) {
				$player = wp_oembed_get( $block['attrs']['url'] );

				break;
			}
		}

		// Set the current context.
		tumblr3_set_parse_context(
			'video',
			array(
				'player'    => $player,
				'thumbnail' => $thumbnail,
			)
		);

		// Parse the content of the quote block before resetting the context.
		$content = $content;

		tumblr3_set_parse_context( 'theme', true );

		return $content;
	}

	/**
	 * Rendered for video posts with a video player and video thumbnail.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_videothumbnail( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();

		return ( isset( $context['video']['thumbnail'] ) && ! empty( $context['video']['thumbnail'] ) ) ? $content : '';
	}

	/**
	 * Rendered for photo and panorama posts.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_photo( $atts, $content = '' ): string {
		global $post;

		// Don't parse all blocks if the post format is not quote.
		if ( 'image' !== get_post_format() ) {
			return '';
		}

		$blocks        = parse_blocks( $post->post_content );
		$highres       = false;
		$highres_sizes = array( 'large', 'full' );
		$image_id      = 0;
		$link_dest     = 'none';
		$caption       = '';
		$lightbox      = false;

		// Handle all blocks in the post content.
		foreach ( $blocks as $key => $block ) {
			if ( 'core/image' === $block['blockName'] ) {
				$highres   = isset( $block['attrs']['sizeSlug'] ) ? in_array( $block['attrs']['sizeSlug'], $highres_sizes, true ) : false;
				$image_id  = $block['attrs']['id'];
				$link_dest = isset( $block['attrs']['linkDestination'] ) ? $block['attrs']['linkDestination'] : 'none';
				$lightbox  = isset( $block['attrs']['lightbox'] );

				/**
				 * In Image (Photo) posts, the caption tag is for the rest of the post content.
				 *
				 * @see https://www.tumblr.com/docs/en/custom_themes#photo-posts:~:text=%7BCaption%7D%20for%20legacy%20Photo%20and%20Photoset%20posts
				 */
				unset( $blocks[ $key ] );

				// Only parse the first image block.
				break;
			}
		}

		// Set the current context.
		tumblr3_set_parse_context(
			'image',
			array(
				'highres'  => $highres,
				'image'    => $image_id,
				'link'     => $link_dest,
				'lightbox' => $lightbox,
				'caption'  => serialize_blocks( $blocks ),
				'data'     => wp_get_attachment_metadata( $image_id, true ),
			)
		);

		// Parse the content of the quote block before resetting the context.
		$content = $content;

		tumblr3_set_parse_context( 'theme', true );

		return $content;
	}

	/**
	 * Rendered for photo and panorama posts which have a link set on the image.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_linkurl( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();

		if ( ! isset( $context['image']['link'] ) ) {
			return '';
		}

		return ( true === $context['image']['lightbox'] || 'none' !== $context['image']['link'] ) ? $content : '';
	}

	/**
	 * Rendered for photo and panorama posts which have the image size set as "large" or "fullsize".
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_highres( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();

		return ( isset( $context['image']['highres'] ) && true === $context['image']['highres'] ) ? $content : '';
	}

	/**
	 * Rendered render content if the image has exif data.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_exif( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();

		return ( isset( $context['image']['data'] ) && ! empty( $context['image']['data']['image_meta'] ) ) ? $content : '';
	}

	/**
	 * Conditionally load content based on if the image has camera exif data.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_camera( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();

		if ( ! isset( $context['image']['data']['image_meta']['camera'] ) ) {
			return '';
		}

		$camera = $context['image']['data']['image_meta']['camera'];

		return ( empty( $camera ) || '0' === $camera ) ? '' : $content;
	}

	/**
	 * Conditionally load content based on if the image has lens exif data.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_aperture( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();

		if ( ! isset( $context['image']['data']['image_meta']['aperture'] ) ) {
			return '';
		}

		$aperture = $context['image']['data']['image_meta']['aperture'];

		return ( empty( $aperture ) || '0' === $aperture ) ? '' : $content;
	}

	/**
	 * Conditionally load content based on if the image has focal length exif data.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_exposure( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();

		if ( ! isset( $context['image']['data']['image_meta']['shutter_speed'] ) ) {
			return '';
		}

		$exposure = $context['image']['data']['image_meta']['shutter_speed'];

		return ( empty( $exposure ) || '0' === $exposure ) ? '' : $content;
	}

	/**
	 * Conditionally load content based on if the image has focal length exif data.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_focallength( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();

		if ( ! isset( $context['image']['data']['image_meta']['focal_length'] ) ) {
			return '';
		}

		$focal_length = $context['image']['data']['image_meta']['focal_length'];

		return ( empty( $focal_length ) || '0' === $focal_length ) ? '' : $content;
	}

	/**
	 * Rendered for answer (aside) posts.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_answer( $atts, $content = '' ): string {
		return ( 'aside' === get_post_format() ) ? $content : '';
	}

	/**
	 * Rendered for photoset (gallery) posts.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_photoset( $atts, $content = '' ): string {
		global $post;

		// Don't parse all blocks if the post format is not quote.
		if ( 'gallery' !== get_post_format() ) {
			return '';
		}

		$blocks     = parse_blocks( $post->post_content );
		$gallery    = '';
		$caption    = '';
		$photocount = 0;
		$photos     = array();

		// Handle all blocks in the post content.
		foreach ( $blocks as $key => $block ) {
			if ( 'core/gallery' === $block['blockName'] ) {
				$photocount = count( $block['innerBlocks'] );
				$photos     = $block['innerBlocks'];

				// Capture the gallery block.
				$gallery = serialize_block( $block );

				/**
				 * In Gallery posts, the caption tag is for the rest of the post content.
				 *
				 * @see https://www.tumblr.com/docs/en/custom_themes#photo-posts:~:text=%7BCaption%7D%20for%20legacy%20Photo%20and%20Photoset%20posts
				 */
				unset( $blocks[ $key ] );

				// Only parse the first quote block.
				break;
			}
		}

		// Set the current context.
		tumblr3_set_parse_context(
			'gallery',
			array(
				'gallery'    => $gallery,
				'photocount' => $photocount,
				'caption'    => serialize_blocks( $blocks ),
				'photos'     => $photos,
			)
		);

		// Parse the content of the quote block before resetting the context.
		$content = $content;

		tumblr3_set_parse_context( 'theme', true );

		return $content;
	}

	/**
	 * Render each photo in a photoset (gallery) post.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_photos( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();
		$output  = '';

		if ( ! isset( $context['gallery']['photos'] ) || empty( $context['gallery']['photos'] ) ) {
			return '';
		}

		foreach ( $context['gallery']['photos'] as $block ) {
			$highres_sizes = array( 'large', 'full' );
			$highres       = isset( $block['attrs']['sizeSlug'] ) ? in_array( $block['attrs']['sizeSlug'], $highres_sizes, true ) : false;
			$image_id      = $block['attrs']['id'];
			$link_dest     = isset( $block['attrs']['linkDestination'] ) ? $block['attrs']['linkDestination'] : 'none';
			$lightbox      = isset( $block['attrs']['lightbox'] );

			// Set the current context.
			tumblr3_set_parse_context(
				'image',
				array(
					'highres'  => $highres,
					'image'    => $image_id,
					'link'     => $link_dest,
					'lightbox' => $lightbox,
					'data'     => wp_get_attachment_metadata( $image_id, true ),
				)
			);

			// Parse the content of the quote block before resetting the context.
			$output .= $content;
		}

		return $output;
	}

	/**
	 * Rendered for link posts with a thumbnail image set.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_thumbnail( $atts, $content = '' ): string {
		return has_post_thumbnail() ? $content : '';
	}

	/**
	 * Rendered for photoset (gallery) posts with caption content.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_caption( $atts, $content = '' ): string {
		$context = tumblr3_get_parse_context();
		$format  = get_post_format();

		if ( ! isset( $context[ $format ]['caption'] ) ) {
			return '';
		}

		return $content;
	}

	/**
	 * Rendered for legacy Text posts and NPF posts.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_daypage( $atts, $content = '' ): string {
		return ( is_day() ) ? $content : '';
	}

	/**
	 * Rendered if older posts are available.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_previouspage( $atts, $content = '' ): string {
		return ( get_next_posts_link() ) ? $content : '';
	}

	/**
	 * Rendered if newer posts are available.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_nextpage( $atts, $content = '' ): string {
		return ( get_previous_posts_link() ) ? $content : '';
	}

	/**
	 * Boolean check for if we're on a single post or page.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_permalinkpagination( $atts, $content = '' ): string {
		return is_single() ? $content : '';
	}

	/**
	 * Check if there's a previous adjacent post.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_previouspost( $atts, $content = '' ): string {
		return ( get_previous_post() ) ? $content : '';
	}

	/**
	 * Check if there's a next adjacent post.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_nextpost( $atts, $content = '' ): string {
		return ( get_next_post() ) ? $content : '';
	}

	/**
	 * Rendered if the post has been marked as sticky.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_pinnedpostlabel( $atts, $content = '' ): string {
		return is_sticky() ? $content : '';
	}

	/**
	 * Render content if the current language is equal to the specified language.
	 *
	 * @param array  $atts           The attributes of the shortcode.
	 * @param string $content        The content of the shortcode.
	 * @param string $shortcode_name The name of the shortcode.
	 *
	 * @return string The parsed content or an empty string.
	 */
	public function tumblr3_block_language( $atts, $content, $shortcode_name ): string {
		// Map shortcodes to their respective locales
		$language_map = array(
			'{block:english}'            => 'en_US',
			'{block:german}'             => 'de_DE',
			'{block:french}'             => 'fr_FR',
			'{block:italian}'            => 'it_IT',
			'{block:turkish}'            => 'tr_TR',
			'{block:spanish}'            => 'es_ES',
			'{block:russian}'            => 'ru_RU',
			'{block:japanese}'           => 'ja_JP',
			'{block:polish}'             => 'pl_PL',
			'{block:portuguesept}'       => 'pt_PT',
			'{block:portuguesebr}'       => 'pt_BR',
			'{block:dutch}'              => 'nl_NL',
			'{block:korean}'             => 'ko_KR',
			'{block:chinesesimplified}'  => 'zh_CN',
			'{block:chinesetraditional}' => 'zh_TW',
			'{block:chinesehk}'          => 'zh_HK',
			'{block:indonesian}'         => 'id_ID',
			'{block:hindi}'              => 'hi_IN',
		);

		// Get the current locale
		$current_locale = get_locale();

		// Check if the shortcode name matches a defined language and compare it with the current locale
		if ( isset( $language_map[ $shortcode_name ] ) && $language_map[ $shortcode_name ] === $current_locale ) {
			return $content;
		}

		return '';
	}

	public function tumblr3_block_language_not( $atts, $content, $shortcode_name ): string {
		// Map shortcodes to their respective locales
		$language_map = array(
			'{block:notenglish}'            => 'en_US',
			'{block:notgerman}'             => 'de_DE',
			'{block:notfrench}'             => 'fr_FR',
			'{block:notitalian}'            => 'it_IT',
			'{block:notturkish}'            => 'tr_TR',
			'{block:notspanish}'            => 'es_ES',
			'{block:notrussian}'            => 'ru_RU',
			'{block:notjapanese}'           => 'ja_JP',
			'{block:notpolish}'             => 'pl_PL',
			'{block:notportuguesept}'       => 'pt_PT',
			'{block:notportuguesebr}'       => 'pt_BR',
			'{block:notdutch}'              => 'nl_NL',
			'{block:notkorean}'             => 'ko_KR',
			'{block:notchinesesimplified}'  => 'zh_CN',
			'{block:notchinesetraditional}' => 'zh_TW',
			'{block:notchinesehk}'          => 'zh_HK',
			'{block:notindonesian}'         => 'id_ID',
			'{block:nothindi}'              => 'hi_IN',
		);

		// Get the current locale
		$current_locale = get_locale();

		// Check if the shortcode name matches a defined language and compare it with the current locale
		if ( isset( $language_map[ $shortcode_name ] ) && $language_map[ $shortcode_name ] !== $current_locale ) {
			return $content;
		}

		return '';
	}

	/**
	 * Rendered if this is post number N (0 - 15) in the loop.
	 *
	 * @param array  $atts           The attributes of the shortcode.
	 * @param string $content        The content of the shortcode.
	 * @param string $shortcode_name The name of the shortcode.
	 *
	 * @return string The parsed content or an empty string.
	 */
	public function tumblr3_block_post_n( $atts, $content, $shortcode_name ): string {
		global $wp_query;

		// Extract the post number from the shortcode name (assuming 'block_postN' where N is a number)
		if ( preg_match( '/{block:post(\d+)/', $shortcode_name, $matches ) ) {
			$post_number = (int) $matches[1] - 1; // Subtract 1 because the index is 0-based

			// Check if in the loop and if the current post is the post number N
			if ( in_the_loop() && $wp_query->current_post === $post_number ) {
				return $content;
			}
		}

		return '';
	}

	/**
	 * Render content if the current post is an odd post in the loop.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_odd( $atts, $content = '' ): string {
		global $wp_query;

		// Check if in the loop and if the current post index is odd
		return ( in_the_loop() && ( $wp_query->current_post % 2 ) !== 0 ) ? $content : '';
	}

	/**
	 * Render content if the current post is an even post in the loop.
	 *
	 * @param array  $atts    The attributes of the shortcode.
	 * @param string $content The content of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_block_even( $atts, $content = '' ): string {
		global $wp_query;

		// Check if in the loop and if the current post index is even
		return ( in_the_loop() && ( $wp_query->current_post % 2 ) === 0 ) ? $content : '';
	}

		/**
	 * Outputs target attribute for links.
	 *
	 * @return string
	 */
	public function tumblr3_tag_target(): string {
		return get_theme_mod( 'target_blank' ) ? 'target="_blank"' : '';
	}

	/**
	 * Returns the NPF JSON string of the current post.
	 *
	 * @todo Rafael is writing a PHP parser for NPF.
	 *
	 * @return string Nothing, this tag is currently not supported.
	 */
	public function tumblr3_tag_npf(): string {
		return '';
	}

	/**
	 * The author name of the current post.
	 *
	 * @return string Post author name.
	 */
	public function tumblr3_tag_postauthorname(): string {
		return get_the_author();
	}

	/**
	 * Returns the group member display name.
	 *
	 * @return string Username or empty.
	 */
	public function tumblr3_tag_groupmembername(): string {
		$context = tumblr3_get_parse_context();

		if ( isset( $context['groupmember'] ) && is_a( $context['groupmember'], 'WP_User' ) ) {
			return $context['groupmember']->user_nicename;
		}

		return '';
	}

	/**
	 * The URL of the group members posts page.
	 *
	 * @return string The URL of the group member.
	 */
	public function tumblr3_tag_groupmemberurl(): string {
		$context = tumblr3_get_parse_context();

		if ( isset( $context['groupmember'] ) && is_a( $context['groupmember'], 'WP_User' ) ) {
			return get_author_posts_url( $context['groupmember']->ID );
		}

		return '';
	}

	/**
	 * Gets the group member portrait URL.
	 *
	 * @param array $atts Shortcode attributes.
	 *
	 * @return string The URL of the group member avatar.
	 */
	public function tumblr3_tag_groupmemberportraiturl( $atts ): string {
		// Parse shortcode attributes.
		$atts = shortcode_atts(
			array(
				'size' => '',
			),
			$atts,
			'tag_groupmemberportraiturl'
		);

		$context = tumblr3_get_parse_context();

		if ( isset( $context['groupmember'] ) && is_a( $context['groupmember'], 'WP_User' ) ) {
			$groupmember_avatar = get_avatar_url(
				$context['groupmember']->ID,
				array(
					'size' => $atts['size'],
				)
			);

			if ( ! $groupmember_avatar ) {
				return '';
			}

			return esc_url( $groupmember_avatar );
		}

		return '';
	}

	/**
	 * The blog title of the post author.
	 *
	 * @return string
	 */
	public function tumblr3_tag_postauthortitle(): string {
		return esc_attr( get_bloginfo( 'name' ) );
	}




	/**
	 * The URL of the post author.
	 *
	 * @return string URL to the author archive.
	 */
	public function tumblr3_tag_postauthorurl(): string {
		return esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
	}

	/**
	 * The portrait URL of the post author.
	 *
	 * @param array $atts The attributes of the shortcode.
	 *
	 * @return string The URL of the author portrait.
	 */
	public function tumblr3_tag_postauthorportraiturl( $atts ): string {
		// Parse shortcode attributes.
		$atts = shortcode_atts(
			array(
				'size' => '',
			),
			$atts,
			'tag_postauthorportraiturl'
		);

		$author_id = get_the_author_meta( 'ID' );
		$author    = get_user_by( 'ID', $author_id );

		if ( ! $author ) {
			return '';
		}

		$author_avatar = get_avatar_url(
			$author_id,
			array(
				'size' => $atts['size'],
			)
		);

		if ( ! $author_avatar ) {
			return '';
		}

		return esc_url( $author_avatar );
	}

	/**
	 * Outputs the twitter username theme option.
	 *
	 * @return string Attribute safe twitter username.
	 */
	public function tumblr3_tag_twitterusername(): string {
		return esc_attr( get_theme_mod( 'twitter_username' ) );
	}

	/**
	 * The current state of a page in nav.
	 * E.g is this the current page?
	 *
	 * @return string
	 */
	public function tumblr3_tag_currentstate(): string {
		return get_the_permalink() === home_url( add_query_arg( null, null ) ) ? 'current-page' : '';
	}

	/**
	 * The display shape of your avatar ("circle" or "square").
	 *
	 * @return string Either "circle" or "square".
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_avatarshape(): string {
		return esc_html( get_theme_mod( 'avatar_shape', 'circle' ) );
	}

	/**
	 * The background color of your blog.
	 *
	 * @return string The background colour in HEX format.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_backgroundcolor(): string {
		return '#' . sanitize_hex_color_no_hash( get_theme_mod( 'background_color', '#fff' ) );
	}

	/**
	 * The accent color of your blog.
	 *
	 * @return string The accent colour in HEX format.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_accentcolor(): string {
		return '#' . sanitize_hex_color_no_hash( get_theme_mod( 'accent_color', '#0073aa' ) );
	}

	/**
	 * The title color of your blog.
	 *
	 * @return string The title colour in HEX format.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_titlecolor(): string {
		return '#' . sanitize_hex_color_no_hash( get_theme_mod( 'header_textcolor', '#000' ) );
	}

	/**
	 * Get the title font theme option.
	 *
	 * @return string The title fontname.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_titlefont(): string {
		return esc_html( get_theme_mod( 'title_font', 'Arial' ) );
	}

	/**
	 * The weight of your title font ("normal" or "bold").
	 *
	 * @return string Either "bold" or "normal".
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_titlefontweight(): string {
		return esc_html( get_theme_mod( 'title_font_weight', 'bold' ) );
	}

	/**
	 * Get the header image theme option.
	 *
	 * @return string Either "remove-header" or the URL of the header image.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_headerimage(): string {
		return get_theme_mod( 'header_image', 'remove-header' );
	}

	/**
	 * Get either a post title, or the blog title.
	 *
	 * @return string The title of the post or the blog.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_title(): string {
		$context = tumblr3_get_parse_context();

		// Consume global context and return the appropriate title.
		return ( isset( $context['theme'] ) ) ? get_bloginfo( 'name' ) : get_the_title();
	}

	/**
	 * The post content.
	 *
	 * @return string The content of the post with filters applied.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_body(): string {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- WP core function.
		return apply_filters( 'the_content', get_the_content() );
	}

	/**
	 * The post content.
	 *
	 * @return string The content of the post with filters applied.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_excerpt(): string {
		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- WP core function.
		return wp_strip_all_tags( apply_filters( 'the_content', get_the_content() ) );
	}



	/**
	 * The blog description, or subtitle.
	 *
	 * @return string The blog description.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_description(): string {
		$context = tumblr3_get_parse_context();

		// This tag is used as the_content for audio posts.
		if ( isset( $context['audio'] ) ) {
			$blocks = parse_blocks( get_the_content() );

			// Remove audio blocks from the content.
			foreach ( $blocks as $key => $block ) {
				if ( 'core/audio' === $block['blockName'] ) {
					unset( $blocks[ $key ] );
				}
			}

			// Re-build the content without audio blocks.
			// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- WP core function.
			return apply_filters( 'the_content', serialize_blocks( $blocks ) );
		}

		// By default, return the blog description.
		return wp_kses_post( get_bloginfo( 'description' ) );
	}

	/**
	 * Attribute safe blog description.
	 *
	 * @return string The blog description with HTML entities encoded.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_metadescription(): string {
		return esc_attr( get_bloginfo( 'description' ) );
	}

	/**
	 * The homepage URL of the blog.
	 *
	 * @return string The URL of the blog.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_blogurl(): string {
		return esc_url( home_url( '/' ) );
	}

	/**
	 * The RSS feed URL of the blog.
	 *
	 * @return string The URL of the blog RSS feed.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_rss(): string {
		return esc_url( get_feed_link() );
	}

	/**
	 * The site favicon image URL.
	 *
	 * @return string The URL of the site favicon.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_favicon(): string {
		return esc_url( get_site_icon_url() );
	}

	/**
	 * The portrait URL of the blog, uses the custom logo if set.
	 *
	 * @param array $atts The attributes of the shortcode.
	 *
	 * @return string The URL of the blog portrait.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_portraiturl( $atts ): string {
		// Parse shortcode attributes.
		$atts = shortcode_atts(
			array(
				'size' => '',
			),
			$atts,
			'tag_portraiturl'
		);

		if ( ! has_custom_logo() ) {
			return '';
		}

		$custom_logo_id  = get_theme_mod( 'custom_logo' );
		$custom_logo_src = wp_get_attachment_image_src(
			$custom_logo_id,
			array(
				$atts['size'],
				$atts['size'],
			)
		);

		if ( ! $custom_logo_src ) {
			return '';
		}

		return esc_url( $custom_logo_src[0] );
	}

	/**
	 * Returns the custom CSS option of the theme.
	 *
	 * @return string The custom CSS of the theme.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_customcss(): string {
		return esc_html( wp_get_custom_css() );
	}

	/**
	 * Identical to {PostTitle}, but will automatically generate a summary if a title doesn't exist.
	 *
	 * @return string The post title or summary.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_postsummary(): string {
		$title = get_the_title();
		return ( '' === $title ) ? $title : get_the_excerpt();
	}

	/**
	 * Character limited version of {PostSummary} that is suitable for Twitter.
	 *
	 * @return string The post summary limited to 280 characters.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_tweetsummary(): string {
		return esc_html( substr( tumblr3_tag_postsummary(), 0, 280 ) );
	}

	/**
	 * Various contextual uses, typically outputs a post permalink.
	 *
	 * @return string The URL of the post.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_url(): string {
		$context = tumblr3_get_parse_context();

		// Handle the jump pagination context for this tag.
		if ( isset( $context['jumppagination'] ) ) {
			return '/page/' . intval( $context['jumppagination'] );
		}

		if ( isset( $context['page'] ) ) {
			return get_permalink( $context['page'] );
		}

		return get_permalink();
	}

	/**
	 * Typically a page title, used in a page loop e.g navigation.
	 *
	 * @todo This tag is also used in legacy chat posts.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_label(): string {
		$context = tumblr3_get_parse_context();

		return isset( $context['page'] ) ? wp_kses_post( get_the_title( $context['page'] ) ) : wp_kses_post( get_the_title() );
	}

	/**
	 * Tagsasclasses outputs the tags of a post as HTML-safe classes.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_tagsasclasses(): string {
		$tags = get_the_tags();

		if ( ! $tags || is_wp_error( $tags ) ) {
			return '';
		}

		$classes = array();
		foreach ( $tags as $tag ) {
			$classes[] = esc_attr( $tag->name );
		}

		return implode( ' ', $classes );
	}

	/**
	 * Label in post footer indicating this is a pinned post.
	 *
	 * @return string The label for a pinned post.
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_pinnedpostlabel(): string {
		return esc_html( 'Pinned Post' );
	}

	/**
	 * Gets the previous post URL (single post pagination)
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_previouspost(): string {
		return esc_url( get_permalink( get_adjacent_post( false, '', true ) ) );
	}

	/**
	 * Gets the next post URL (single post pagination)
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_nextpost(): string {
		return esc_url( get_permalink( get_adjacent_post( false, '', false ) ) );
	}

	/**
	 * Gets the previous posts page URL (pagination)
	 *
	 * @return string|null
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_previouspage(): string|null {
		return esc_url( get_next_posts_page_link() );
	}

	/**
	 * Gets the next posts page URL (pagination)
	 *
	 * @return string|null
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_nextpage(): string|null {
		return esc_url( get_previous_posts_page_link() );
	}

	/**
	 * Gets the current page value (pagination)
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_currentpage(): string {
		return get_query_var( 'paged' );
	}

	/**
	 * The pagenumber tag inside jump pagination.
	 *
	 * @return string
	 */
	public function tumblr3_tag_pagenumber(): string {
		$context = tumblr3_get_parse_context();
		return isset( $context['jumppagination'] ) ? (string) $context['jumppagination'] : '';
	}

	/**
	 * Gets the query total pages (pagination)
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_totalpages(): string {
		global $wp_query;
		return $wp_query->max_num_pages;
	}

	/**
	 * Displays the span of years your blog has existed.
	 *
	 * @return string
	 *
	 * @todo find a way to get the install date of the blog.
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_copyrightyears(): string {
		// Get the oldest post.
		$oldest_post = get_posts(
			array(
				'numberposts' => 1,
				'orderby'     => 'date',
				'order'       => 'ASC',
				'fields'      => 'ids',
			)
		);

		if ( empty( $oldest_post ) ) {
			return '';
		}

		return get_the_date( 'Y', $oldest_post[0] ) . '-' . gmdate( 'Y' );
	}

	/**
	 * The numeric ID for a post.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_postid(): string {
		return esc_attr( get_the_ID() );
	}

	/**
	 * The name of the current legacy post type.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_posttype(): string {
		$format = get_post_format();
		return ( $format ) ? $format : 'text';
	}

	/**
	 * Current tag name in a loop.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_tag(): string {
		$context = tumblr3_get_parse_context();

		// Check if we are in a tag context.
		if ( ! isset( $context['term'] ) || ! is_a( $context['term'], 'WP_Term' ) ) {
			return '';
		}

		return $context['term']->name;
	}

	/**
	 * Current tag name in a loop.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_urlsafetag(): string {
		$context = tumblr3_get_parse_context();

		// Check if we are in a tag context.
		if ( ! isset( $context['term'] ) || ! is_a( $context['term'], 'WP_Term' ) ) {
			return '';
		}

		return rawurlencode( $context['term']->name );
	}

	/**
	 * Current tag url in a loop.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_tagurl(): string {
		$context = tumblr3_get_parse_context();

		// Check if we are in a tag context.
		if ( ! isset( $context['term'] ) || ! is_a( $context['term'], 'WP_Term' ) ) {
			return '';
		}

		return get_term_link( $context['term'] );
	}

	/**
	 * The total number of comments on a post.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_notecount(): string {
		return get_comments_number();
	}

	/**
	 * The total number of comments on a post in text form.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_notecountwithlabel(): string {
		return get_comments_number_text();
	}

	/**
	 * The post comments.
	 *
	 * @todo We need to match the output of tumblr post notes for styling consistency.
	 *
	 * @param array $atts The attributes of the shortcode.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_postnotes( $atts ): string {
		// Parse shortcode attributes.
		$atts = shortcode_atts(
			array(
				'size' => '',
			),
			$atts,
			'tag_postnotes'
		);

		ob_start();

		comments_template();

		$comments = ob_get_contents();
		ob_end_clean();

		return $comments;
	}

	/**
	 * The current search query.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_searchquery(): string {
		return esc_html( get_search_query() );
	}

	/**
	 * The current search query URL encoded.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_urlsafesearchquery(): string {
		return rawurlencode( get_search_query() );
	}

	/**
	 * The found posts count of the search result.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_searchresultcount(): string {
		global $wp_query;
		return $wp_query->found_posts;
	}

	/**
	 * Quote post content.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_quote(): string {
		$context = tumblr3_get_parse_context();

		// Test if the current context is a quote post and has a source.
		if ( isset( $context['quote'], $context['quote']['quote'] ) ) {
			return $context['quote']['quote'];
		}

		// Empty string if no quote block is found.
		return '';
	}

	/**
	 * Quote post source.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_source(): string {
		$context = tumblr3_get_parse_context();

		// Test if the current context is a quote post and has a source.
		if ( isset( $context['quote'], $context['quote']['source'] ) ) {
			return $context['quote']['source'];
		}

		return '';
	}

	/**
	 * Quote content length.
	 * "short", "medium", "long"
	 *
	 * @return string
	 *
	 * @see https://github.tumblr.net/Tumblr/tumblr/blob/046755128a6d61010fcaf4459f8efdc895140ad0/app/models/post.php#L7459
	 */
	public function tumblr3_tag_length(): string {
		$context = tumblr3_get_parse_context();

		// Test if the current context is a quote post and has a length.
		if ( isset( $context['quote'], $context['quote']['length'] ) ) {
			$length = $context['quote']['length'];

			if ( $length < 100 ) {
				return 'short';
			} elseif ( $length < 250 ) {
				return 'medium';
			}
		}

		// Default to long.
		return 'long';
	}

	/**
	 * Audioplayer HTML.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_audioplayer(): string {
		$context = tumblr3_get_parse_context();

		// Test if the current context is an audio post and has a player.
		if ( isset( $context['audio'], $context['audio']['player'] ) ) {
			return $context['audio']['player'];
		}

		return '';
	}





	/**
	 * Album art URL, uses the featured image if available.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_albumarturl(): string {
		$context = tumblr3_get_parse_context();

		// Test if the current context is an audio post and has a player.
		if ( isset( $context['audio'], $context['audio']['art'] ) ) {
			return $context['audio']['art'];
		}

		return '';
	}

	/**
	 * Renders the audio player track name.
	 *
	 * @return string
	 */
	public function tumblr3_tag_trackname(): string {
		$context = tumblr3_get_parse_context();

		// Test if the current context is an audio post and has a player.
		if ( isset( $context['audio'], $context['audio']['trackname'] ) ) {
			return $context['audio']['trackname'];
		}

		return '';
	}

	/**
	 * Renders the audio player artist name.
	 *
	 * @return string
	 */
	public function tumblr3_tag_artist(): string {
		$context = tumblr3_get_parse_context();

		// Test if the current context is an audio post and has a player.
		if ( isset( $context['audio'], $context['audio']['artist'] ) ) {
			return $context['audio']['artist'];
		}

		return '';
	}

	/**
	 * Renders the audio player album name.
	 *
	 * @return string
	 */
	public function tumblr3_tag_album(): string {
		$context = tumblr3_get_parse_context();

		// Test if the current context is an audio post and has a player.
		if ( isset( $context['audio'], $context['audio']['album'] ) ) {
			return $context['audio']['album'];
		}

		return '';
	}

	/**
	 * Renders the audio player media URL if it's external.
	 *
	 * @return string
	 */
	public function tumblr3_tag_externalaudiourl(): string {
		$context = tumblr3_get_parse_context();

		// Test if the current context is an audio post and has a player.
		if ( isset( $context['audio'], $context['audio']['player'] ) ) {
			$processor = new CupcakeLabs\T3\Processor( $context['audio']['player'] );

			while ( $processor->next_tag( 'AUDIO' ) ) {
				$src = $processor->get_attribute( 'SRC' );

				if ( $src ) {
					return esc_url( $src );
				}
			}
		}

		return '';
	}

	/**
	 * Renders the post gallery if one was found.
	 *
	 * @return string
	 */
	public function tumblr3_tag_photoset(): string {
		$context = tumblr3_get_parse_context();

		// Return nothing if no gallery is found.
		if ( ! isset( $context['gallery']['gallery'] ) || empty( $context['gallery']['gallery'] ) ) {
			return '';
		}

		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- WP core function.
		return apply_filters( 'the_content', $context['gallery']['gallery'] );
	}

	/**
	 * Renders the post gallery layout if one was found.
	 *
	 * @return string
	 */
	public function tumblr3_tag_photosetlayout(): string {
		return tumblr3_tag_photocount();
	}

	/**
	 * Renders the post gallery photo count if one was found.
	 *
	 * @return string
	 */
	public function tumblr3_tag_photocount(): string {
		$context = tumblr3_get_parse_context();

		// Return nothing if no gallery is found.
		if ( ! isset( $context['gallery']['photocount'] ) ) {
			return '';
		}

		return esc_html( $context['gallery']['photocount'] );
	}

	/**
	 * Renders the post gallery caption if one was found.
	 *
	 * @return string
	 */
	public function tumblr3_tag_caption(): string {
		$context = tumblr3_get_parse_context();
		$format  = get_post_format();

		if ( ! isset( $context[ $format ], $context[ $format ]['caption'] ) ) {
			return '';
		}

		// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedHooknameFound -- WP core function.
		return apply_filters( 'the_content', $context[ $format ]['caption'] );
	}

	/**
	 * Renders the post image URL if one was found.
	 *
	 * @param array  $atts           The attributes of the shortcode.
	 * @param string $content        The content of the shortcode.
	 * @param string $shortcode_name The name of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_tag_photourl( $atts, $content, $shortcode_name ): string {
		// Parse shortcode attributes.
		$atts = shortcode_atts(
			array(
				'size' => '',
			),
			$atts,
			$shortcode_name
		);

		$context = tumblr3_get_parse_context();

		// Return nothing if no gallery is found.
		if ( ! isset( $context['image']['image'] ) ) {
			return '';
		}

		$src = wp_get_attachment_image_src( $context['image']['image'] );

		return ( false === $src ) ? '' : esc_url( $src[0] );
	}

	/**
	 * Renders the post image thumbnail URL if one was found.
	 *
	 * @param array  $atts           The attributes of the shortcode.
	 * @param string $content        The content of the shortcode.
	 * @param string $shortcode_name The name of the shortcode.
	 *
	 * @return string
	 */
	public function tumblr3_tag_thumbnail( $atts, $content, $shortcode_name ): string {
		$sizes = array(
			'{thumbnail}'         => 'thumbnail',
			'{thumbnail-highres}' => 'full',
		);

		return get_the_post_thumbnail_url( get_the_id(), $sizes[ $shortcode_name ] );
	}

	/**
	 * Renders the post image link URL if one was found.
	 *
	 * @todo Hook up lightbox and custom link contexts.
	 *
	 * @return string
	 */
	public function tumblr3_tag_linkurl(): string {
		$context = tumblr3_get_parse_context();

		if ( ! isset( $context['image']['link'] ) ) {
			return '';
		}

		// Links to attachment pages.
		if ( 'attachment' === $context['image']['link'] || 'media' === $context['image']['link'] ) {
			return get_permalink( $context['image']['image'] );
		}

		// Links to a custom URL.
		if ( 'custom' === $context['image']['link'] ) {
			return $context['image']['custom'];
		}

		// Links to lightbox.
		if ( true === $context['image']['lightbox'] ) {
			return wp_get_attachment_image_src( $context['image']['image'] )[0];
		}

		return '';
	}

	/**
	 * Renders the post image link open tag conditionally.
	 *
	 * @uses tumblr3_tag_linkurl()
	 * @return string
	 */
	public function tumblr3_tag_linkopentag(): string {
		$context = tumblr3_get_parse_context();

		return ( isset( $context['image']['link'] ) && 'none' !== $context['image']['link'] ) ? '<a href="' . tumblr3_tag_linkurl() . '">' : '';
	}

	/**
	 * Renders the post image link close tag conditionally.
	 *
	 * @return string
	 */
	public function tumblr3_tag_linkclosetag(): string {
		$context = tumblr3_get_parse_context();

		return ( isset( $context['image']['link'] ) && 'none' !== $context['image']['link'] ) ? '</a>' : '';
	}

	/**
	 * Renders the post image camera exif data if found.
	 *
	 * @return string
	 */
	public function tumblr3_tag_camera(): string {
		$context = tumblr3_get_parse_context();

		return isset( $context['image']['data']['image_meta']['camera'] ) ? esc_html( $context['image']['data']['image_meta']['camera'] ) : '';
	}

	/**
	 * Renders the post image lens exif data if found.
	 *
	 * @return string
	 */
	public function tumblr3_tag_aperture(): string {
		$context = tumblr3_get_parse_context();

		return isset( $context['image']['data']['image_meta']['aperture'] ) ? esc_html( $context['image']['data']['image_meta']['aperture'] ) : '';
	}

	/**
	 * Renders the post image focal length exif data if found.
	 *
	 * @return string
	 */
	public function tumblr3_tag_focallength(): string {
		$context = tumblr3_get_parse_context();

		return isset( $context['image']['data']['image_meta']['focal_length'] ) ? esc_html( $context['image']['data']['image_meta']['focal_length'] ) : '';
	}

	/**
	 * Renders the post image shutter speed exif data if found.
	 *
	 * @return string
	 */
	public function tumblr3_tag_exposure(): string {
		$context = tumblr3_get_parse_context();

		return isset( $context['image']['data']['image_meta']['shutter_speed'] ) ? esc_html( $context['image']['data']['image_meta']['shutter_speed'] ) : '';
	}

	/**
	 * Renders the post image alt text if one was found.
	 *
	 * @return string
	 */
	public function tumblr3_tag_photoalt(): string {
		$context = tumblr3_get_parse_context();

		if ( ! isset( $context['image']['image'] ) ) {
			return '';
		}

		return esc_attr( get_post_meta( $context['image']['image'], '_wp_attachment_image_alt', true ) );
	}

	/**
	 * Renders the post image width if one was found.
	 *
	 * @return string
	 */
	public function tumblr3_tag_photowidth(): string {
		$context = tumblr3_get_parse_context();

		if ( ! isset( $context['image']['data'], $context['image']['data']['width'] ) ) {
			return '';
		}

		return (string) $context['image']['data']['width'];
	}

	/**
	 * Renders the post image height if one was found.
	 *
	 * @return string
	 */
	public function tumblr3_tag_photoheight(): string {
		$context = tumblr3_get_parse_context();

		if ( ! isset( $context['image']['data'], $context['image']['data']['height'] ) ) {
			return '';
		}

		return (string) $context['image']['data']['height'];
	}

	/**
	 * Renders the post video player.
	 *
	 * @return string
	 */
	public function tumblr3_tag_video(): string {
		$context = tumblr3_get_parse_context();

		// Test if the current context is a video post and has a player.
		if ( isset( $context['video'], $context['video']['player'] ) ) {
			return $context['video']['player'];
		}

		return '';
	}

	/**
	 * Renders the post video thumbnail URL.
	 *
	 * @return string
	 */
	public function tumblr3_tag_videothumbnailurl(): string {
		$context = tumblr3_get_parse_context();

		// Test if the current context is a video post and has a player.
		if ( isset( $context['video'], $context['video']['thumbnail'] ) ) {
			return $context['video']['thumbnail'];
		}

		return '';
	}

	/**
	 * The link post type title (This is also the link URL).
	 *
	 * @return string
	 */
	public function tumblr3_tag_name(): string {
		return get_the_title( get_the_ID() );
	}

	/**
	 * Renders the link post host url.
	 *
	 * @return string
	 */
	public function tumblr3_tag_host(): string {
		$url = wp_http_validate_url( get_the_title() );

		// If this wasn't a valid URL, return an empty string.
		if ( false === $url ) {
			return '';
		}

		$parsed_url = wp_parse_url( $url );

		// Return the host of the URL.
		return $parsed_url['host'];
	}

	/**
	 * Returns the day of the month without leading zeros.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_dayofmonth(): string {
		return get_the_date( 'j' );
	}

	/**
	 * Returns the day of the month with leading zeros.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_dayofmonthwithzero(): string {
		return get_the_date( 'd' );
	}

	/**
	 * Returns the full name of the day of the week.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_dayofweek(): string {
		return get_the_date( 'l' );
	}

	/**
	 * Returns the abbreviated name of the day of the week.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_shortdayofweek(): string {
		return get_the_date( 'D' );
	}

	/**
	 * Returns the day of the week as a number (1 for Monday, 7 for Sunday).
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_dayofweeknumber(): string {
		return get_the_date( 'N' );
	}

	/**
	 * Returns the English ordinal suffix for the day of the month.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_dayofmonthsuffix(): string {
		return get_the_date( 'S' );
	}

	/**
	 * Returns the day of the year (1 to 365).
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_dayofyear(): string {
		return get_the_date( 'z' ) + 1; // Adding 1 because PHP date 'z' is zero-indexed
	}

	/**
	 * Returns the week of the year (1 to 53).
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_weekofyear(): string {
		return get_the_date( 'W' );
	}

	/**
	 * Returns the full name of the current month.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_month(): string {
		return get_the_date( 'F' );
	}

	/**
	 * Returns the abbreviated name of the current month.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_shortmonth(): string {
		return get_the_date( 'M' );
	}

	/**
	 * Returns the numeric representation of the month without leading zeros.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_monthnumber(): string {
		return get_the_date( 'n' );
	}

	/**
	 * Returns the numeric representation of the month with leading zeros.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_monthnumberwithzero(): string {
		return get_the_date( 'm' );
	}

	/**
	 * Returns the full numeric representation of the year (e.g., 2024).
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_year(): string {
		return get_the_date( 'Y' );
	}

	/**
	 * Returns the last two digits of the year (e.g., 24 for 2024).
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_shortyear(): string {
		return get_the_date( 'y' );
	}

	/**
	 * Returns lowercase 'am' or 'pm' based on the time.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_ampm(): string {
		return get_the_date( 'a' );
	}

	/**
	 * Returns uppercase 'AM' or 'PM' based on the time.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_capitalampm(): string {
		return get_the_date( 'A' );
	}

	/**
	 * Returns the hour in 12-hour format without leading zeros.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_12hour(): string {
		return get_the_date( 'g' );
	}

	/**
	 * Returns the hour in 24-hour format without leading zeros.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_24hour(): string {
		return get_the_date( 'G' );
	}

	/**
	 * Returns the hour in 12-hour format with leading zeros.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_12hourwithzero(): string {
		return get_the_date( 'h' );
	}

	/**
	 * Returns the hour in 24-hour format with leading zeros.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_24hourwithzero(): string {
		return get_the_date( 'H' );
	}

	/**
	 * Returns the minutes with leading zeros.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_minutes(): string {
		return get_the_date( 'i' );
	}

	/**
	 * Returns the seconds with leading zeros.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_seconds(): string {
		return get_the_date( 's' );
	}

	/**
	 * Returns the Swatch Internet Time (.beats).
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_beats(): string {
		$now = new DateTime( '', new DateTimeZone( 'UTC' ) );
		return '@' . floor( ( $now->format( 'G' ) * 3600 + $now->format( 'i' ) * 60 + $now->format( 's' ) + 3600 ) / 86.4 );
	}

	/**
	 * Returns the Unix timestamp of the post.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_timestamp(): string {
		return get_the_date( 'U' );
	}

	/**
	 * Returns the time difference between the post date and now, in human-readable format.
	 *
	 * @return string
	 *
	 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
	 */
	public function tumblr3_tag_timeago(): string {
		$post_time    = get_the_time( 'U' );
		$current_time = current_time( 'timestamp' );
		$time_diff    = human_time_diff( $post_time, $current_time );
		return sprintf( '%s ago', $time_diff );
	}
}
