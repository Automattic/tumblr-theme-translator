<?php

defined( 'ABSPATH' ) || exit;

/**
 * All non-supported blocks are assigned here.
 *
 * @return string Nothing, this block is not supported.
 */
function tumblr3_block_functionality_missing(): string {
	return '';
}

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
add_shortcode( 'block_options', 'tumblr3_block_options' );
add_shortcode( 'block_hidden', 'tumblr3_block_options' );

/**
 * Boolean check for theme options.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_if_theme_option( $atts, $content = '' ): string {
	// Parse shortcode attributes.
	$atts = shortcode_atts(
		array(
			'name' => '',
		),
		$atts,
		'block_if_theme_option'
	);

	// Don't render if the name attribute is empty.
	if ( '' === $atts['name'] ) {
		return '';
	}

	return ( get_theme_mod( $atts['name'] ) ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_if_theme_option', 'tumblr3_block_if_theme_option' );

/**
 * Boolean check for theme options.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_ifnot_theme_option( $atts, $content = '' ): string {
	// Parse shortcode attributes.
	$atts = shortcode_atts(
		array(
			'name' => '',
		),
		$atts,
		'block_ifnot_theme_option'
	);

	// Don't render if the name attribute is empty.
	if ( '' === $atts['name'] ) {
		return '';
	}

	return ( ! get_theme_mod( $atts['name'] ) ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_ifnot_theme_option', 'tumblr3_block_ifnot_theme_option' );

/**
 * Conditional check for if we're in the loop.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_body( $atts, $content = '' ): string {
	return ( in_the_loop() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_body', 'tumblr3_block_body' );
add_shortcode( 'block_date', 'tumblr3_block_body' );
add_shortcode( 'block_postsummary', 'tumblr3_block_body' );

/**
 * Outputs content if we should stretch the header image.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_stretchheaderimage( $atts, $content = '' ): string {
	return ( get_theme_mod( 'stretch_header_image', true ) ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_stretchheaderimage', 'tumblr3_block_stretchheaderimage' );

/**
 * Outputs content if we should not stretch the header image.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_nostretchheaderimage( $atts, $content = '' ): string {
	return ( get_theme_mod( 'stretch_header_image', true ) ) ? '' : tumblr3_do_shortcode( $content );
}
add_shortcode( 'block_nostretchheaderimage', 'tumblr3_block_nostretchheaderimage' );

/**
 * Output content if we've chosen to show the site avatar.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_showavatar( $atts, $content = '' ): string {
	return ( get_theme_mod( 'show_avatar', true ) ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_showavatar', 'tumblr3_block_showavatar' );

/**
 * Output content if we've chosen to hide the site avatar.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_hideavatar( $atts, $content = '' ): string {
	return ( get_theme_mod( 'show_avatar', true ) ) ? '' : tumblr3_do_shortcode( $content );
}
add_shortcode( 'block_hideavatar', 'tumblr3_block_hideavatar' );

/**
 * Output content if we've chosen to show the site title and description.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_showtitle( $atts, $content = '' ): string {
	return display_header_text() ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_showtitle', 'tumblr3_block_showtitle' );

/**
 * Output content if we've chosen to hide the site title and description.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_hidetitle( $atts, $content = '' ): string {
	return display_header_text() ? '' : tumblr3_do_shortcode( $content );
}
add_shortcode( 'block_hidetitle', 'tumblr3_block_hidetitle' );

/**
 * Output content if we've chosen to show the site description.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_showdescription( $atts, $content = '' ): string {
	return display_header_text() ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_showdescription', 'tumblr3_block_showdescription' );

/**
 * Output content if we've chosen to hide the site description.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_hidedescription( $atts, $content = '' ): string {
	return display_header_text() ? '' : tumblr3_do_shortcode( $content );
}
add_shortcode( 'block_hidedescription', 'tumblr3_block_hidedescription' );

/**
 * Rendered on index pages for posts with Read More breaks.
 *
 * @todo Test if the post has a read-more tag, currently this is always true if we're in the loop.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_more( $atts, $content = '' ): string {
	return in_the_loop() ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_more', 'tumblr3_block_more' );

/**
 * Rendered if the post has an excerpt.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_description( $atts, $content = '' ): string {
	return has_excerpt() ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_description', 'tumblr3_block_description' );

/**
 * The main posts loop.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_posts( $atts, $content = '' ): string {
	tumblr3_set_parse_context( 'posts', true );
	$output = '';

	// Use the content inside this shortcode as a template for each post.
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();

			$output .= tumblr3_do_shortcode( $content );
		}
	}

	tumblr3_set_parse_context( 'theme', true );

	return $output;
}
add_shortcode( 'block_posts', 'tumblr3_block_posts' );

/**
 * Conditional if there are no posts.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_noposts( $atts, $content = '' ): string {
	return have_posts() ? '' : tumblr3_do_shortcode( $content );
}
add_shortcode( 'block_noposts', 'tumblr3_block_noposts' );

/**
 * Post tags loop.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_tags( $atts, $content = '' ): string {
	$output = '';
	$terms  = wp_get_post_terms( get_the_ID() );

	foreach ( $terms as $term ) {
		tumblr3_set_parse_context( 'term', $term );
		$output .= tumblr3_do_shortcode( $content );
	}

	tumblr3_set_parse_context( 'theme', true );

	return $output;
}
add_shortcode( 'block_tags', 'tumblr3_block_tags' );

/**
 * Rendered for each custom page.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_pages( $atts, $content = '' ): string {
	$output = '';

	$pages_query = new WP_Query(
		array(
			'post_type'      => 'page',
			'posts_per_page' => -1,
		)
	);

	// Use the content inside this shortcode as a template for each post.
	if ( $pages_query->have_posts() ) {
		while ( $pages_query->have_posts() ) {
			$pages_query->the_post();

			$output .= tumblr3_do_shortcode( $content );
		}
	}

	wp_reset_postdata();

	return $output;
}
add_shortcode( 'block_pages', 'tumblr3_block_pages' );

/**
 * Boolean check for if we're on a search page.
 *
 * @param array $atts
 * @param string $content
 * @return string
 */
function tumblr3_block_searchpage( $atts, $content = '' ): string {
	return is_search() ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_searchpage', 'tumblr3_block_searchpage' );

/**
 * Render content if there are no search results.
 *
 * @param array $atts
 * @param string $content
 * @return string
 */
function tumblr3_block_nosearchresults( $atts, $content = '' ): string {
	global $wp_query;

	return ( is_search() && 0 === $wp_query->found_posts ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_nosearchresults', 'tumblr3_block_nosearchresults' );

/**
 * Render content if this site is not currently public.
 *
 * @param array $atts
 * @param string $content
 * @return string
 */
function tumblr3_block_hidefromsearchenabled( $atts, $content = '' ): string {
	return ( '1' !== get_option( 'blog_public' ) ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_hidefromsearchenabled', 'tumblr3_block_hidefromsearchenabled' );

/**
 * Boolean check for if we're on a taxonomy page.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_tagpage( $atts, $content = '' ): string {
	return ( is_tag() || is_category() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_tagpage', 'tumblr3_block_tagpage' );

/**
 * Boolean check for if we're on a single post or page.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_permalinkpage( $atts, $content = '' ): string {
	return ( is_page() || is_single() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_permalinkpage', 'tumblr3_block_permalinkpage' );

/**
 * Boolean check for if we're on the home page.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_indexpage( $atts, $content = '' ): string {
	return is_home() ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_indexpage', 'tumblr3_block_indexpage' );

/**
 * Boolean check for if we're on the "front page".
 * (This changes depending on settings chosen inside WordPress).
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_homepage( $atts, $content = '' ): string {
	return is_front_page() ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_homepage', 'tumblr3_block_homepage' );

/**
 * Sets the global parse context so we know we're outputting a post title.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_title( $atts, $content = '' ): string {
	tumblr3_set_parse_context( 'title', true );
	$content = tumblr3_do_shortcode( $content );
	tumblr3_set_parse_context( 'theme', true );

	return $content;
}
add_shortcode( 'block_title', 'tumblr3_block_title' );

/**
 * If the current page is able to pagination, render the content.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_pagination( $atts, $content = '' ): string {
	return ( get_next_posts_page_link() || get_previous_posts_page_link() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_pagination', 'tumblr3_block_pagination' );

/**
 * The Jump pagination block.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_jumppagination( $atts, $content = '' ): string {
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
			$output .= tumblr3_do_shortcode( $content );
		}
	}

	tumblr3_set_parse_context( 'theme', true );

	return $output;
}
add_shortcode( 'block_jumppagination', 'tumblr3_block_jumppagination' );

/**
 * The currentpage block inside jumppagination.
 * Renders only if the current page is equal to the context.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_currentpage( $atts, $content = '' ): string {
	$context = tumblr3_get_parse_context();
	$var     = get_query_var( 'paged' );
	$paged   = $var ? $var : 1;

	return ( isset( $context['jumppagination'] ) && $paged === $context['jumppagination'] ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_currentpage', 'tumblr3_block_currentpage' );

/**
 * The jumppage block inside jumppagination.
 * Render if the current page is not equal to the context.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_jumppage( $atts, $content = '' ): string {
	$context = tumblr3_get_parse_context();
	$var     = get_query_var( 'paged' );
	$paged   = $var ? $var : 1;

	return ( isset( $context['jumppagination'] ) && $paged !== $context['jumppagination'] ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_jumppage', 'tumblr3_block_jumppage' );

/**
 * Boolean check for if we're on a single post or page.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_posttitle( $atts, $content = '' ): string {
	return is_single() ? tumblr3_block_title( $content ) : '';
}
add_shortcode( 'block_posttitle', 'tumblr3_block_posttitle' );

/**
 * Rendered if you have defined any custom pages.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
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

	return ( ! empty( $pages_query ) ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_haspages', 'tumblr3_block_haspages' );

/**
 * Rendered if you have "Show header image" enabled.
 *
 * @todo This.
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_showheaderimage( $atts, $content = '' ): string {
	return ( 'remove-header' !== get_theme_mod( 'header_image', 'remove-header' ) ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_showheaderimage', 'tumblr3_block_showheaderimage' );

/**
 * Rendered if you have "Show header image" disabled.
 *
 * @todo This.
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_hideheaderimage( $atts, $content = '' ): string {
	return ( 'remove-header' === get_theme_mod( 'header_image', 'remove-header' ) ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_hideheaderimage', 'tumblr3_block_hideheaderimage' );

/**
 * If a post is not a reblog, render the content.
 *
 * @todo This should be conditional, but WordPress doesn't currently support reblogs so it's static.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_notreblog( $atts, $content = '' ): string {
	return tumblr3_do_shortcode( $content );
}
add_shortcode( 'block_notreblog', 'tumblr3_block_notreblog' );

/**
 * Rendered if the post has tags.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_hastags( $atts, $content = '' ): string {
	return ( has_tag() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_hastags', 'tumblr3_block_hastags' );

/**
 * Rendered if the post has comments or comments open.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_post_notes( $atts, $content = '' ): string {
	return is_single() && ( get_comments_number() || comments_open() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_postnotes', 'tumblr3_block_post_notes' );

/**
 * Rendered if the post has at least one comment.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_notecount( $atts, $content = '' ): string {
	return ( get_comments_number() > 0 ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_notecount', 'tumblr3_block_notecount' );

/**
 * Rendered for legacy Text posts and NPF posts.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_text( $atts, $content = '' ): string {
	return ( false === get_post_format() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_text', 'tumblr3_block_text' );

/**
 * Rendered for legacy quote posts, or the WordPress quote post format.
 * Post logic is handled here, and then passed to the global context.
 * Tags inside the quote block are handed data from the global context.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
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

			// Parse the content of the blocks inside the quote.
			foreach ( $block['innerBlocks'] as $inner_block ) {

				// Remove any found cite block and pass to the global context.
				$output .= preg_replace_callback(
					'/<cite\b[^>]*>(.*?)<\/cite>/',
					function ( $matches ) use ( &$source ) {
						if ( isset( $matches[1] ) ) {
							$source = $matches[1];
						}

						return '';
					},
					$inner_block['innerHTML']
				);
			}

			// Only parse the first quote block.
			break;
		}
	}

	// Set the current context.
	tumblr3_set_parse_context(
		'quote',
		array(
			'quote'  => $output,
			'source' => $source,
			'length' => strlen( $output ),
		)
	);

	// Parse the content of the quote block before resetting the context.
	$content = tumblr3_do_shortcode( $content );

	tumblr3_set_parse_context( 'theme', true );

	return $content;
}
add_shortcode( 'block_quote', 'tumblr3_block_quote' );

/**
 * Tests for a source in the quote post format.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_source( $atts, $content = '' ): string {
	$context = tumblr3_get_parse_context();

	// Test if the current context is a quote post and has a source.
	if ( isset( $context['quote'], $context['quote']['source'] ) && ! empty( $context['quote']['source'] ) ) {
		return tumblr3_do_shortcode( $content );
	}

	// Return nothing if no source is found.
	return '';
}
add_shortcode( 'block_source', 'tumblr3_block_source' );

/**
 * Rendered for chat posts.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_chat( $atts, $content = '' ): string {
	return ( 'chat' === get_post_format() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_chat', 'tumblr3_block_chat' );

/**
 * Rendered for link posts.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_link( $atts, $content = '' ): string {
	return ( 'link' === get_post_format() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_link', 'tumblr3_block_link' );

/**
 * Rendered for audio posts.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_audio( $atts, $content = '' ): string {
	return ( 'audio' === get_post_format() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_audio', 'tumblr3_block_audio' );

/**
 * Rendered for video posts.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_video( $atts, $content = '' ): string {
	return ( 'video' === get_post_format() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_video', 'tumblr3_block_video' );

/**
 * Rendered for photo and panorama posts.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_photo( $atts, $content = '' ): string {
	return ( 'image' === get_post_format() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_photo', 'tumblr3_block_photo' );
add_shortcode( 'block_panorama', 'tumblr3_block_photo' );

/**
 * Rendered for answer (aside) posts.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_answer( $atts, $content = '' ): string {
	return ( 'aside' === get_post_format() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_answer', 'tumblr3_block_answer' );

/**
 * Rendered for photoset (gallery) posts.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_photoset( $atts, $content = '' ): string {
	return ( 'gallery' === get_post_format() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_photoset', 'tumblr3_block_photoset' );

/**
 * Rendered for legacy Text posts and NPF posts.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_daypage( $atts, $content = '' ): string {
	return ( is_day() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_daypage', 'tumblr3_block_daypage' );

/**
 * Rendered if older posts are available.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_previouspage( $atts, $content = '' ): string {
	return ( get_next_posts_link() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_previouspage', 'tumblr3_block_previouspage' );

/**
 * Rendered if newer posts are available.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_nextpage( $atts, $content = '' ): string {
	return ( get_previous_posts_link() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_nextpage', 'tumblr3_block_nextpage' );

/**
 * Boolean check for if we're on a single post or page.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_permalinkpagination( $atts, $content = '' ): string {
	return is_single() ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_permalinkpagination', 'tumblr3_block_permalinkpagination' );

/**
 * Check if there's a previous adjacent post.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_previouspost( $atts, $content = '' ): string {
	return ( get_previous_post() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_previouspost', 'tumblr3_block_previouspost' );

/**
 * Check if there's a next adjacent post.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_nextpost( $atts, $content = '' ): string {
	return ( get_next_post() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_nextpost', 'tumblr3_block_nextpost' );

/**
 * Rendered if the post has been marked as sticky.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_pinnedpostlabel( $atts, $content = '' ): string {
	return is_sticky() ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_pinnedpostlabel', 'tumblr3_block_pinnedpostlabel' );

/**
 * Render content if the current language is equal to the specified language.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @param string $shortcode_name The name of the shortcode.
 * @return string The parsed content or an empty string.
 */
function tumblr3_block_language( $atts, $content = '', $shortcode_name ): string {
	// Map shortcodes to their respective locales
	$language_map = array(
		'block_english'            => 'en_US',
		'block_german'             => 'de_DE',
		'block_french'             => 'fr_FR',
		'block_italian'            => 'it_IT',
		'block_turkish'            => 'tr_TR',
		'block_spanish'            => 'es_ES',
		'block_russian'            => 'ru_RU',
		'block_japanese'           => 'ja_JP',
		'block_polish'             => 'pl_PL',
		'block_portuguesept'       => 'pt_PT',
		'block_portuguesebr'       => 'pt_BR',
		'block_dutch'              => 'nl_NL',
		'block_korean'             => 'ko_KR',
		'block_chinesesimplified'  => 'zh_CN',
		'block_chinesetraditional' => 'zh_TW',
		'block_chinesehk'          => 'zh_HK',
		'block_indonesian'         => 'id_ID',
		'block_hindi'              => 'hi_IN',
	);

	// Get the current locale
	$current_locale = get_locale();

	// Check if the shortcode name matches a defined language and compare it with the current locale
	if ( isset( $language_map[ $shortcode_name ] ) && $language_map[ $shortcode_name ] === $current_locale ) {
		return tumblr3_do_shortcode( $content );
	}

	return '';
}
add_shortcode( 'block_english', 'tumblr3_block_language' );
add_shortcode( 'block_german', 'tumblr3_block_language' );
add_shortcode( 'block_french', 'tumblr3_block_language' );
add_shortcode( 'block_italian', 'tumblr3_block_language' );
add_shortcode( 'block_turkish', 'tumblr3_block_language' );
add_shortcode( 'block_spanish', 'tumblr3_block_language' );
add_shortcode( 'block_russian', 'tumblr3_block_language' );
add_shortcode( 'block_japanese', 'tumblr3_block_language' );
add_shortcode( 'block_polish', 'tumblr3_block_language' );
add_shortcode( 'block_portuguesept', 'tumblr3_block_language' );
add_shortcode( 'block_portuguesebr', 'tumblr3_block_language' );
add_shortcode( 'block_dutch', 'tumblr3_block_language' );
add_shortcode( 'block_korean', 'tumblr3_block_language' );
add_shortcode( 'block_chinesesimplified', 'tumblr3_block_language' );
add_shortcode( 'block_chinesetraditional', 'tumblr3_block_language' );
add_shortcode( 'block_chinesehk', 'tumblr3_block_language' );
add_shortcode( 'block_indonesian', 'tumblr3_block_language' );
add_shortcode( 'block_hindi', 'tumblr3_block_language' );

/**
 * Rendered if this is post number N (0 - 15) in the loop.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @param string $shortcode_name The name of the shortcode.
 * @return string The parsed content or an empty string.
 */
function tumblr3_block_post_n( $atts, $content = '', $shortcode_name ): string {
	global $wp_query;

	// Extract the post number from the shortcode name (assuming 'block_postN' where N is a number)
	if ( preg_match( '/block_post(\d+)/', $shortcode_name, $matches ) ) {
		$post_number = (int) $matches[1] - 1; // Subtract 1 because the index is 0-based

		// Check if in the loop and if the current post is the post number N
		if ( in_the_loop() && $wp_query->current_post === $post_number ) {
			return tumblr3_do_shortcode( $content );
		}
	}

	return '';
}
add_shortcode( 'block_post1', 'tumblr3_block_post_n' );
add_shortcode( 'block_post2', 'tumblr3_block_post_n' );
add_shortcode( 'block_post3', 'tumblr3_block_post_n' );
add_shortcode( 'block_post4', 'tumblr3_block_post_n' );
add_shortcode( 'block_post5', 'tumblr3_block_post_n' );
add_shortcode( 'block_post6', 'tumblr3_block_post_n' );
add_shortcode( 'block_post7', 'tumblr3_block_post_n' );
add_shortcode( 'block_post8', 'tumblr3_block_post_n' );
add_shortcode( 'block_post9', 'tumblr3_block_post_n' );
add_shortcode( 'block_post10', 'tumblr3_block_post_n' );
add_shortcode( 'block_post11', 'tumblr3_block_post_n' );
add_shortcode( 'block_post12', 'tumblr3_block_post_n' );
add_shortcode( 'block_post13', 'tumblr3_block_post_n' );
add_shortcode( 'block_post14', 'tumblr3_block_post_n' );
add_shortcode( 'block_post15', 'tumblr3_block_post_n' );

/**
 * Render content if the current post is an odd post in the loop.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_odd( $atts, $content = '' ): string {
	global $wp_query;

	// Check if in the loop and if the current post index is odd
	return ( in_the_loop() && ( $wp_query->current_post % 2 ) !== 0 ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_odd', 'tumblr3_block_odd' );

/**
 * Render content if the current post is an even post in the loop.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_even( $atts, $content = '' ): string {
	global $wp_query;

	// Check if in the loop and if the current post index is even
	return ( in_the_loop() && ( $wp_query->current_post % 2 ) === 0 ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_even', 'tumblr3_block_even' );
