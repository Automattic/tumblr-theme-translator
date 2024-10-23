<?php

defined( 'ABSPATH' ) || exit;

/**
 * This should not load on front-end views.
 * Effectively, this shortcode strips unwanted HTML.
 * This is the desired outcome, so not marking as a missing block.
 *
 * @return string Nothing, this is intentionally blank on the front-end.
 */
function tumblr3_block_options(): string {
	return '';
}

function tumblr3_block_if( $atts, $content, $name ): string {
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
function tumblr3_block_groupmembers( $atts, $content = '' ): string {
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
function tumblr3_block_groupmember( $atts, $content = '' ): string {
	$context = tumblr3_get_parse_context();
	$plugin  = tumblr3_get_plugin_instance();
	$output  = '';

	if ( isset( $context['groupmembers'] ) ) {
		$authors = $context['groupmembers'];

		// Loop over each blog author.
		foreach ( $authors as $author ) {
			tumblr3_set_parse_context( 'groupmember', $author );
			$output .= $plugin->parser->parse_fragment( $content );
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
function tumblr3_block_twitter( $atts, $content = '' ): string {
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
function tumblr3_block_body( $atts, $content = '' ): string {
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
function tumblr3_block_stretchheaderimage( $atts, $content = '' ): string {
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
function tumblr3_block_nostretchheaderimage( $atts, $content = '' ): string {
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
function tumblr3_block_showavatar( $atts, $content = '' ): string {
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
function tumblr3_block_hideavatar( $atts, $content = '' ): string {
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
function tumblr3_block_showtitle( $atts, $content = '' ): string {
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
function tumblr3_block_hidetitle( $atts, $content = '' ): string {
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
function tumblr3_block_showdescription( $atts, $content = '' ): string {
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
function tumblr3_block_hidedescription( $atts, $content = '' ): string {
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
function tumblr3_block_more( $atts, $content = '' ): string {
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
function tumblr3_block_description( $atts, $content = '' ): string {
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
function tumblr3_block_posts( $atts, $content = '' ): string {
	$output = '';
	$plugin = tumblr3_get_plugin_instance();

	tumblr3_set_parse_context( 'posts', true );

	// Use the content inside this shortcode as a template for each post.
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();

			$output .= $plugin->parser->parse_fragment( $content );
		}
	}

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
function tumblr3_block_noposts( $atts, $content = '' ): string {
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
function tumblr3_block_tags( $atts, $content = '' ): string {
	$output = '';
	$terms  = wp_get_post_terms( get_the_ID() );
	$plugin = tumblr3_get_plugin_instance();

	foreach ( $terms as $term ) {
		tumblr3_set_parse_context( 'term', $term );
		$output .= $plugin->parser->parse_fragment( $content );
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
function tumblr3_block_pages( $atts, $content = '' ): string {
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
		$output .= $plugin->parser->parse_fragment( $content );
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
function tumblr3_block_searchpage( $atts, $content = '' ): string {
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
function tumblr3_block_nosearchresults( $atts, $content = '' ): string {
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
function tumblr3_block_searchresults( $atts, $content = '' ): string {
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
function tumblr3_block_hidefromsearchenabled( $atts, $content = '' ): string {
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
function tumblr3_block_tagpage( $atts, $content = '' ): string {
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
function tumblr3_block_permalinkpage( $atts, $content = '' ): string {
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
function tumblr3_block_indexpage( $atts, $content = '' ): string {
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
function tumblr3_block_homepage( $atts, $content = '' ): string {
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
function tumblr3_block_title( $atts, $content = '' ): string {
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
function tumblr3_block_pagination( $atts, $content = '' ): string {
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
function tumblr3_block_jumppagination( $atts, $content = '' ): string {
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
			$output .= $plugin->parser->parse_fragment( $content );
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
function tumblr3_block_currentpage( $atts, $content = '' ): string {
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
function tumblr3_block_jumppage( $atts, $content = '' ): string {
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
function tumblr3_block_posttitle( $atts, $content = '' ): string {
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
function tumblr3_block_haspages( $atts, $content = '' ): string {
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
function tumblr3_block_showheaderimage( $atts, $content = '' ): string {
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
function tumblr3_block_hideheaderimage( $atts, $content = '' ): string {
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
function tumblr3_block_notreblog( $atts, $content = '' ): string {
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
function tumblr3_block_hastags( $atts, $content = '' ): string {
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
function tumblr3_block_postnotes( $atts, $content = '' ): string {
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
function tumblr3_block_notecount( $atts, $content = '' ): string {
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
function tumblr3_block_text( $atts, $content = '' ): string {
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
function tumblr3_block_quote( $atts, $content = '' ): string {
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
function tumblr3_block_source( $atts, $content = '' ): string {
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
function tumblr3_block_chat( $atts, $content = '' ): string {
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
function tumblr3_block_link( $atts, $content = '' ): string {
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
function tumblr3_block_audio( $atts, $content = '' ): string {
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
function tumblr3_block_audioplayer( $atts, $content = '' ): string {
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
function tumblr3_block_externalaudio( $atts, $content = '' ): string {
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
function tumblr3_block_albumart( $atts, $content = '' ): string {
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
function tumblr3_block_trackname( $atts, $content = '' ): string {
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
function tumblr3_block_artist( $atts, $content = '' ): string {
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
function tumblr3_block_album( $atts, $content = '' ): string {
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
function tumblr3_block_video( $atts, $content = '' ): string {
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
function tumblr3_block_videothumbnail( $atts, $content = '' ): string {
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
function tumblr3_block_photo( $atts, $content = '' ): string {
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
function tumblr3_block_linkurl( $atts, $content = '' ): string {
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
function tumblr3_block_highres( $atts, $content = '' ): string {
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
function tumblr3_block_exif( $atts, $content = '' ): string {
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
function tumblr3_block_camera( $atts, $content = '' ): string {
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
function tumblr3_block_aperture( $atts, $content = '' ): string {
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
function tumblr3_block_exposure( $atts, $content = '' ): string {
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
function tumblr3_block_focallength( $atts, $content = '' ): string {
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
function tumblr3_block_answer( $atts, $content = '' ): string {
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
function tumblr3_block_photoset( $atts, $content = '' ): string {
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
function tumblr3_block_photos( $atts, $content = '' ): string {
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
function tumblr3_block_thumbnail( $atts, $content = '' ): string {
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
function tumblr3_block_caption( $atts, $content = '' ): string {
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
function tumblr3_block_daypage( $atts, $content = '' ): string {
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
function tumblr3_block_previouspage( $atts, $content = '' ): string {
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
function tumblr3_block_nextpage( $atts, $content = '' ): string {
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
function tumblr3_block_permalinkpagination( $atts, $content = '' ): string {
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
function tumblr3_block_previouspost( $atts, $content = '' ): string {
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
function tumblr3_block_nextpost( $atts, $content = '' ): string {
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
function tumblr3_block_pinnedpostlabel( $atts, $content = '' ): string {
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
function tumblr3_block_language( $atts, $content, $shortcode_name ): string {
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

function tumblr3_block_language_not( $atts, $content, $shortcode_name ): string {
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
function tumblr3_block_post_n( $atts, $content, $shortcode_name ): string {
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
function tumblr3_block_odd( $atts, $content = '' ): string {
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
function tumblr3_block_even( $atts, $content = '' ): string {
	global $wp_query;

	// Check if in the loop and if the current post index is even
	return ( in_the_loop() && ( $wp_query->current_post % 2 ) === 0 ) ? $content : '';
}
