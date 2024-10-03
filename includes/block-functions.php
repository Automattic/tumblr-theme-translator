<?php

defined( 'ABSPATH' ) || exit;

/**
 * This should not load on front-end views.
 * Effectively, this shortcode strips unwanted HTML.
 * This is the desired outcome, so not marking as a missing block.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_options( $atts, $content = '' ): string {
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
 * Undocumented function
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
 * Undocumented function
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
 * Undocumented function
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
 * Undocumented function
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
 * Undocumented function
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
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_showtitle( $atts, $content = '' ): string {
	if ( ! display_header_text() ) {
		return '';
	}

	return tumblr3_do_shortcode( $content );
}
add_shortcode( 'block_showtitle', 'tumblr3_block_showtitle' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_hidetitle( $atts, $content = '' ): string {
	if ( display_header_text() ) {
		return '';
	}

	return tumblr3_do_shortcode( $content );
}
add_shortcode( 'block_hidetitle', 'tumblr3_block_hidetitle' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_showdescription( $atts, $content = '' ): string {
	if ( ! display_header_text() ) {
		return '';
	}

	return tumblr3_do_shortcode( $content );
}
add_shortcode( 'block_showdescription', 'tumblr3_block_showdescription' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_hidedescription( $atts, $content = '' ): string {
	if ( display_header_text() ) {
		return '';
	}

	return tumblr3_do_shortcode( $content );
}
add_shortcode( 'block_hidedescription', 'tumblr3_block_hidedescription' );

/**
 * Undocumented function
 *
 * @todo Test if the post has a read-more tag.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_more( $atts, $content = '' ): string {
	if ( ! in_the_loop() ) {
		return '';
	}

	return tumblr3_do_shortcode( $content );
}
add_shortcode( 'block_more', 'tumblr3_block_more' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_description( $atts, $content = '' ): string {
	if ( ! has_excerpt() ) {
		return '';
	}

	return tumblr3_do_shortcode( $content );
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
	global $tumblr3_parse_context;

	$tumblr3_parse_context = 'posts';
	$output                = '';

	// Use the content inside this shortcode as a template for each post.
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();

			$output .= tumblr3_do_shortcode( $content );
		}
	}

	$tumblr3_parse_context = 'theme';

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
	global $tumblr3_parse_context;

	$output = '';
	$terms  = wp_get_post_terms( get_the_ID() );

	foreach ( $terms as $term ) {
		$tumblr3_parse_context = $term;
		$output               .= tumblr3_do_shortcode( $content );
	}

	$tumblr3_parse_context = 'theme';

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
	global $tumblr3_parse_context;

	$tumblr3_parse_context = 'pages';
	$output                = '';

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

	$tumblr3_parse_context = 'theme';

	return $output;
}
add_shortcode( 'block_pages', 'tumblr3_block_pages' );

/**
 * Undocumented function
 *
 * @param [type] $atts
 * @param string $content
 * @return void
 */
function tumblr3_block_searchpage( $atts, $content = '' ): string {
	if ( is_search() ) {
		return tumblr3_do_shortcode( $content );
	}

	return '';
}
add_shortcode( 'block_searchpage', 'tumblr3_block_searchpage' );

/**
 * Undocumented function
 *
 * @param [type] $atts
 * @param string $content
 * @return void
 */
function tumblr3_block_nosearchresults( $atts, $content = '' ): string {
	global $wp_query;

	if ( is_search() && 0 === $wp_query->found_posts ) {
		return tumblr3_do_shortcode( $content );
	}

	return '';
}
add_shortcode( 'block_nosearchresults', 'tumblr3_block_nosearchresults' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_tagpage( $atts, $content = '' ): string {
	if ( is_tag() || is_category() ) {
		return tumblr3_do_shortcode( $content );
	}

	return '';
}
add_shortcode( 'block_tagpage', 'tumblr3_block_tagpage' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_permalinkpage( $atts, $content = '' ): string {
	if ( is_page() || is_single() ) {
		return tumblr3_do_shortcode( $content );
	}

	return '';
}
add_shortcode( 'block_permalinkpage', 'tumblr3_block_permalinkpage' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_indexpage( $atts, $content = '' ): string {
	if ( is_home() ) {
		return tumblr3_do_shortcode( $content );
	}

	return '';
}
add_shortcode( 'block_indexpage', 'tumblr3_block_indexpage' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_homepage( $atts, $content = '' ): string {
	if ( is_front_page() ) {
		return tumblr3_do_shortcode( $content );
	}

	return '';
}
add_shortcode( 'block_homepage', 'tumblr3_block_homepage' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_title( $atts, $content = '' ): string {
	global $tumblr3_parse_context;

	// Set the context to 'title' for the title block.
	$tumblr3_parse_context = 'title';
	$content               = tumblr3_do_shortcode( $content );
	$tumblr3_parse_context = 'theme';

	return $content;
}
add_shortcode( 'block_title', 'tumblr3_block_title' );

/**
 * Undocumented function
 *
 * @todo This should be conditional as to if there's any other post pages available, e.g /page/2/
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_pagination( $atts, $content = '' ): string {
	global $tumblr3_parse_context;

	// Set the context to pagination for everything wrapped in here.
	$tumblr3_parse_context = 'pagination';
	$content               = tumblr3_do_shortcode( $content );
	$tumblr3_parse_context = 'theme';

	return $content;
}
add_shortcode( 'block_pagination', 'tumblr3_block_pagination' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_posttitle( $atts, $content = '' ): string {
	if ( ! is_single() ) {
		return '';
	}

	// Pass this off to the title block to avoid duplication.
	return tumblr3_block_title( $content );
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
	return '';
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
	return '';
}
add_shortcode( 'block_hideheaderimage', 'tumblr3_block_hideheaderimage' );

/**
 * If a post is not a reblog, render the content.
 *
 * @todo This should be conditional, but WordPress doesn't currently support reblogs.
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
function tumblr3_block_postnotes( $atts, $content = '' ): string {
	return ( get_comments_number() || comments_open() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_postnotes', 'tumblr3_block_postnotes' );

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
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_quote( $atts, $content = '' ): string {
	global $tumblr3_parse_context;

	$tumblr3_parse_context = 'quote';
	$content               = ( 'quote' === get_post_format() ) ? tumblr3_do_shortcode( $content ) : '';
	$tumblr3_parse_context = 'theme';

	return $content;
}
add_shortcode( 'block_quote', 'tumblr3_block_quote' );

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
 * Render content if the current language is English.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_english( $atts, $content = '' ): string {
	return ( 'en_US' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_english', 'tumblr3_block_english' );

/**
 * Render content if the current language is German.
 */
function tumblr3_block_german( $atts, $content = '' ): string {
	return ( 'de_DE' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_german', 'tumblr3_block_german' );

/**
 * Render content if the current language is French.
 */
function tumblr3_block_french( $atts, $content = '' ): string {
	return ( 'fr_FR' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_french', 'tumblr3_block_french' );

/**
 * Render content if the current language is Italian.
 */
function tumblr3_block_italian( $atts, $content = '' ): string {
	return ( 'it_IT' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_italian', 'tumblr3_block_italian' );

/**
 * Render content if the current language is Japanese.
 */
function tumblr3_block_japanese( $atts, $content = '' ): string {
	return ( 'ja' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_japanese', 'tumblr3_block_japanese' );

/**
 * Render content if the current language is Turkish.
 */
function tumblr3_block_turkish( $atts, $content = '' ): string {
	return ( 'tr_TR' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_turkish', 'tumblr3_block_turkish' );

/**
 * Render content if the current language is Spanish.
 */
function tumblr3_block_spanish( $atts, $content = '' ): string {
	return ( 'es_ES' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_spanish', 'tumblr3_block_spanish' );

/**
 * Render content if the current language is Russian.
 */
function tumblr3_block_russian( $atts, $content = '' ): string {
	return ( 'ru_RU' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_russian', 'tumblr3_block_russian' );

/**
 * Render content if the current language is Polish.
 */
function tumblr3_block_polish( $atts, $content = '' ): string {
	return ( 'pl_PL' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_polish', 'tumblr3_block_polish' );

/**
 * Render content if the current language is Portuguese (Portugal).
 */
function tumblr3_block_portuguesept( $atts, $content = '' ): string {
	return ( 'pt_PT' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_portuguesept', 'tumblr3_block_portuguesept' );

/**
 * Render content if the current language is Portuguese (Brazil).
 */
function tumblr3_block_portuguesebr( $atts, $content = '' ): string {
	return ( 'pt_BR' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_portuguesebr', 'tumblr3_block_portuguesebr' );

/**
 * Render content if the current language is Dutch.
 */
function tumblr3_block_dutch( $atts, $content = '' ): string {
	return ( 'nl_NL' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_dutch', 'tumblr3_block_dutch' );

/**
 * Render content if the current language is Korean.
 */
function tumblr3_block_korean( $atts, $content = '' ): string {
	return ( 'ko_KR' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_korean', 'tumblr3_block_korean' );

/**
 * Render content if the current language is Chinese (Simplified).
 */
function tumblr3_block_chinesesimplified( $atts, $content = '' ): string {
	return ( 'zh_CN' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_chinesesimplified', 'tumblr3_block_chinesesimplified' );

/**
 * Render content if the current language is Chinese (Traditional).
 */
function tumblr3_block_chinesetraditional( $atts, $content = '' ): string {
	return ( 'zh_TW' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_chinesetraditional', 'tumblr3_block_chinesetraditional' );

/**
 * Render content if the current language is Chinese (Hong Kong).
 */
function tumblr3_block_chinesehk( $atts, $content = '' ): string {
	return ( 'zh_HK' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_chinesehk', 'tumblr3_block_chinesehk' );

/**
 * Render content if the current language is Indonesian.
 */
function tumblr3_block_indonesian( $atts, $content = '' ): string {
	return ( 'id_ID' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_indonesian', 'tumblr3_block_indonesian' );

/**
 * Render content if the current language is Hindi.
 */
function tumblr3_block_hindi( $atts, $content = '' ): string {
	return ( 'hi_IN' === get_locale() ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_hindi', 'tumblr3_block_hindi' );

/**
 * Rendered if this is post number 1 in the loop.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_post1( $atts, $content = '' ): string {
	global $wp_query;

	// Check if in the loop and if the current post is post number 1 (index 0)
	return ( in_the_loop() && 0 === $wp_query->current_post ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_post1', 'tumblr3_block_post1' );

/**
 * Rendered if this is post number 2 in the loop.
 */
function tumblr3_block_post2( $atts, $content = '' ): string {
	global $wp_query;

	return ( in_the_loop() && 1 === $wp_query->current_post ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_post2', 'tumblr3_block_post2' );

/**
 * Rendered if this is post number 3 in the loop.
 */
function tumblr3_block_post3( $atts, $content = '' ): string {
	global $wp_query;

	return ( in_the_loop() && 2 === $wp_query->current_post ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_post3', 'tumblr3_block_post3' );

/**
 * Rendered if this is post number 4 in the loop.
 */
function tumblr3_block_post4( $atts, $content = '' ): string {
	global $wp_query;

	return ( in_the_loop() && 3 === $wp_query->current_post ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_post4', 'tumblr3_block_post4' );

/**
 * Rendered if this is post number 5 in the loop.
 */
function tumblr3_block_post5( $atts, $content = '' ): string {
	global $wp_query;

	return ( in_the_loop() && 4 === $wp_query->current_post ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_post5', 'tumblr3_block_post5' );

/**
 * Rendered if this is post number 6 in the loop.
 */
function tumblr3_block_post6( $atts, $content = '' ): string {
	global $wp_query;

	return ( in_the_loop() && 5 === $wp_query->current_post ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_post6', 'tumblr3_block_post6' );

/**
 * Rendered if this is post number 7 in the loop.
 */
function tumblr3_block_post7( $atts, $content = '' ): string {
	global $wp_query;

	return ( in_the_loop() && 6 === $wp_query->current_post ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_post7', 'tumblr3_block_post7' );

/**
 * Rendered if this is post number 8 in the loop.
 */
function tumblr3_block_post8( $atts, $content = '' ): string {
	global $wp_query;

	return ( in_the_loop() && 7 === $wp_query->current_post ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_post8', 'tumblr3_block_post8' );

/**
 * Rendered if this is post number 9 in the loop.
 */
function tumblr3_block_post9( $atts, $content = '' ): string {
	global $wp_query;

	return ( in_the_loop() && 8 === $wp_query->current_post ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_post9', 'tumblr3_block_post9' );

/**
 * Rendered if this is post number 10 in the loop.
 */
function tumblr3_block_post10( $atts, $content = '' ): string {
	global $wp_query;

	return ( in_the_loop() && 9 === $wp_query->current_post ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_post10', 'tumblr3_block_post10' );

/**
 * Rendered if this is post number 11 in the loop.
 */
function tumblr3_block_post11( $atts, $content = '' ): string {
	global $wp_query;

	return ( in_the_loop() && 10 === $wp_query->current_post ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_post11', 'tumblr3_block_post11' );

/**
 * Rendered if this is post number 12 in the loop.
 */
function tumblr3_block_post12( $atts, $content = '' ): string {
	global $wp_query;

	return ( in_the_loop() && 11 === $wp_query->current_post ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_post12', 'tumblr3_block_post12' );

/**
 * Rendered if this is post number 13 in the loop.
 */
function tumblr3_block_post13( $atts, $content = '' ): string {
	global $wp_query;

	return ( in_the_loop() && 12 === $wp_query->current_post ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_post13', 'tumblr3_block_post13' );

/**
 * Rendered if this is post number 14 in the loop.
 */
function tumblr3_block_post14( $atts, $content = '' ): string {
	global $wp_query;

	return ( in_the_loop() && 13 === $wp_query->current_post ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_post14', 'tumblr3_block_post14' );

/**
 * Rendered if this is post number 15 in the loop.
 */
function tumblr3_block_post15( $atts, $content = '' ): string {
	global $wp_query;

	return ( in_the_loop() && 14 === $wp_query->current_post ) ? tumblr3_do_shortcode( $content ) : '';
}
add_shortcode( 'block_post15', 'tumblr3_block_post15' );

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
