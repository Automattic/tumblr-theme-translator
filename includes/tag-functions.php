<?php

defined( 'ABSPATH' ) || exit;

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_backgroundcolor( $atts, $content = '' ): string {
	return '#' . ltrim( get_theme_mod( 'background_color', '#fff' ), '#' );
}
add_shortcode( 'tag_backgroundcolor', 'tumblr3_tag_backgroundcolor' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_accentcolor( $atts, $content = '' ): string {
	return '#' . ltrim( get_theme_mod( 'accent_color', '#555' ), '#' );
}
add_shortcode( 'tag_accentcolor', 'tumblr3_tag_accentcolor' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_titlecolor( $atts, $content = '' ): string {
	return '#' . ltrim( get_theme_mod( 'header_textcolor', '#000' ), '#' );
}
add_shortcode( 'tag_titlecolor', 'tumblr3_tag_titlecolor' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_headerimage( $atts, $content = '' ): string {
	return get_theme_mod( 'header_image', '' );
}
add_shortcode( 'tag_headerimage', 'tumblr3_tag_headerimage' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_title( $atts, $content = '' ): string {
	global $tumblr3_parse_context;

	// Consume global context and return the appropriate title.
	return ( 'theme' === $tumblr3_parse_context ) ? get_bloginfo( 'name' ) : get_the_title();
}
add_shortcode( 'tag_title', 'tumblr3_tag_title' );
add_shortcode( 'tag_posttitle', 'tumblr3_tag_title' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_body( $atts, $content = '' ): string {
	return get_the_content();
}
add_shortcode( 'tag_body', 'tumblr3_tag_body' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_description( $atts, $content = '' ): string {
	return get_bloginfo( 'description' );
}
add_shortcode( 'tag_description', 'tumblr3_tag_description' );

/**
 * Undocumented function
 *
 * @param string $context
 * @param array $attributes
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_metadescription( $atts, $content = '' ): string {
	return esc_attr( get_the_excerpt() );
}
add_shortcode( 'tag_metadescription', 'tumblr3_tag_metadescription' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_blogurl( $atts, $content = '' ): string {
	return esc_url( home_url( '/' ) );
}
add_shortcode( 'tag_blogurl', 'tumblr3_tag_blogurl' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_rss( $atts, $content = '' ): string {
	return esc_url( get_feed_link() );
}
add_shortcode( 'tag_rss', 'tumblr3_tag_rss' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_favicon( $atts, $content = '' ): string {
	return esc_url( get_site_icon_url() );
}
add_shortcode( 'tag_favicon', 'tumblr3_tag_favicon' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_portraiturl( $atts, $content = '' ): string {
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
add_shortcode( 'tag_portraiturl', 'tumblr3_tag_portraiturl' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_customcss( $atts, $content = '' ): string {
	return esc_html( wp_get_custom_css() );
}
add_shortcode( 'tag_customcss', 'tumblr3_tag_customcss' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_postsummary( $atts, $content = '' ): string {
	$title = get_the_title();
	return ( '' === $title ) ? $title : get_the_excerpt();
}
add_shortcode( 'tag_postsummary', 'tumblr3_tag_postsummary' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_url( $atts, $content = '' ): string {
	return get_permalink();
}
add_shortcode( 'tag_url', 'tumblr3_tag_url' );
add_shortcode( 'tag_permalink', 'tumblr3_tag_url' );
add_shortcode( 'tag_relativepermalink', 'tumblr3_tag_url' );
add_shortcode( 'tag_shorturl', 'tumblr3_tag_url' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_label( $atts, $content = '' ): string {
	return get_the_title();
}
add_shortcode( 'tag_label', 'tumblr3_tag_label' );

/**
 * Displays the span of years your blog has existed.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @todo find a way to get the install date of the blog.
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_copyrightyears( $atts, $content = '' ): string {
	return '';
}
add_shortcode( 'tag_copyrightyears', 'tumblr3_tag_copyrightyears' );

/**
 * The numeric ID for a post.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_postid( $atts, $content = '' ): string {
	return get_the_ID();
}
add_shortcode( 'tag_postid', 'tumblr3_tag_postid' );

/**
 * The name of the current legacy post type.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_posttype( $atts, $content = '' ): string {
	$format = get_post_format();
	return ( $format ) ? $format : 'text';
}
add_shortcode( 'tag_posttype', 'tumblr3_tag_posttype' );

/**
 * Current tag name in a loop.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_tag( $atts, $content = '' ): string {
	global $tumblr3_parse_context;

	// Check if we are in a tag context.
	if ( ! is_a( $tumblr3_parse_context, 'WP_Term' ) ) {
		return '';
	}

	return $tumblr3_parse_context->name;
}
add_shortcode( 'tag_tag', 'tumblr3_tag_tag' );

/**
 * Current tag name in a loop.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_urlsafetag( $atts, $content = '' ): string {
	global $tumblr3_parse_context;

	// Check if we are in a tag context.
	if ( ! is_a( $tumblr3_parse_context, 'WP_Term' ) ) {
		return '';
	}

	return rawurlencode( $tumblr3_parse_context->name );
}
add_shortcode( 'tag_urlsafetag', 'tumblr3_tag_urlsafetag' );

/**
 * Current tag url in a loop.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_tagurl( $atts, $content = '' ): string {
	global $tumblr3_parse_context;

	// Check if we are in a tag context.
	if ( ! is_a( $tumblr3_parse_context, 'WP_Term' ) ) {
		return '';
	}

	return get_term_link( $tumblr3_parse_context );
}
add_shortcode( 'tag_tagurl', 'tumblr3_tag_tagurl' );
add_shortcode( 'tag_tagurlchrono', 'tumblr3_tag_tagurl' );

/**
 * Current tag url in a loop.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_notecount( $atts, $content = '' ): string {
	return get_comment_number();
}
add_shortcode( 'tag_notecount', 'tumblr3_tag_notecount' );

/**
 * Current tag url in a loop.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_notecountwithlabel( $atts, $content = '' ): string {
	return get_comments_number_text();
}
add_shortcode( 'tag_notecountwithlabel', 'tumblr3_tag_notecountwithlabel' );

/**
 * The post comments.
 *
 * @todo Comments template should be in the theme.
 * We need to match the output of tumblr post notes for styling consistency.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_postnotes( $atts, $content = '' ): string {
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
add_shortcode( 'tag_postnotes', 'tumblr3_tag_postnotes' );

/**
 * The current search query.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_searchquery( $atts, $content = '' ): string {
	return get_search_query();
}
add_shortcode( 'tag_searchquery', 'tumblr3_tag_searchquery' );

/**
 * The current search query URL encoded.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_urlsafesearchquery( $atts, $content = '' ): string {
	return rawurlencode( get_search_query() );
}
add_shortcode( 'tag_urlsafesearchquery', 'tumblr3_tag_urlsafesearchquery' );

/**
 * The found posts count of the search result.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_searchresultcount( $atts, $content = '' ): string {
	global $wp_query;
	return $wp_query->found_posts;
}
add_shortcode( 'tag_searchresultcount', 'tumblr3_tag_searchresultcount' );

/**
 * Quote post content.
 *
 * @todo This.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_quote( $atts, $content = '' ): string {
	$post_content = get_the_content();
	$processor    = new WP_HTML_Tag_Processor( $post_content );

	// Find the first blockquote in the post content.
	while ( $processor->next_tag( 'BLOCKQUOTE' ) ) {

		// If a blockquote was found, return its content.
		return wp_strip_all_tags( $processor->get_updated_html() );
	}

	// No blockquote found, return nothing.
	return '';
}
add_shortcode( 'tag_quote', 'tumblr3_tag_quote' );

/**
 * Quote post source.
 *
 * @todo This.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_source( $atts, $content = '' ): string {
	$processor = WP_HTML_Processor::create_fragment( get_the_content() );

	// Find the first blockquote in the post content.
	while ( $processor->next_tag( array( 'breadcrumbs' => array( 'BLOCKQUOTE', 'CITE' ) ) ) ) {
		return $processor->get_modifiable_text();
	}

	// No Cite found, return nothing.
	return '';
}
add_shortcode( 'tag_source', 'tumblr3_tag_source' );

/**
 * Avatar shape.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_avatarshape( $atts, $content = '' ): string {
	return get_theme_mod( 'avatar_shape', 'circle' );
}
add_shortcode( 'tag_avatarshape', 'tumblr3_tag_avatarshape' );

/**
 * The answer section of an ask post. {answer} and {replies} do the same thing.
 *
 * @todo This needs hooking up to a question/answer system.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_answer( $atts, $content = '' ): string {
	return 'The answer.';
}
add_shortcode( 'tag_answer', 'tumblr3_tag_answer' );
add_shortcode( 'tag_replies', 'tumblr3_tag_answer' );

/**
 *
 *
 * @todo Understand what Tumblr outputs in this tag.
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_posttypographystyles( $atts, $content = '' ): string {
	return '<style></style>';
}
add_shortcode( 'tag_posttypographystyles', 'tumblr3_tag_posttypographystyles' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_dayofmonth( $atts, $content = '' ): string {
	return date( 'j' );
}
add_shortcode( 'tag_dayofmonth', 'tumblr3_tag_dayofmonth' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_dayofmonthwithzero( $atts, $content = '' ): string {
	return date( 'd' );
}
add_shortcode( 'tag_dayofmonthwithzero', 'tumblr3_tag_dayofmonthwithzero' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_dayofweek( $atts, $content = '' ): string {
	return date( 'l' );
}
add_shortcode( 'tag_dayofweek', 'tumblr3_tag_dayofweek' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_shortdayofweek( $atts, $content = '' ): string {
	return date( 'D' );
}
add_shortcode( 'tag_shortdayofweek', 'tumblr3_tag_shortdayofweek' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_dayofweeknumber( $atts, $content = '' ): string {
	return date( 'N' );
}
add_shortcode( 'tag_dayofweeknumber', 'tumblr3_tag_dayofweeknumber' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_dayofmonthsuffix( $atts, $content = '' ): string {
	return date( 'S' );
}
add_shortcode( 'tag_dayofmonthsuffix', 'tumblr3_tag_dayofmonthsuffix' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_dayofyear( $atts, $content = '' ): string {
	return date( 'z' ) + 1; // Adding 1 because PHP date 'z' is zero-indexed
}
add_shortcode( 'tag_dayofyear', 'tumblr3_tag_dayofyear' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_weekofyear( $atts, $content = '' ): string {
	return date( 'W' );
}
add_shortcode( 'tag_weekofyear', 'tumblr3_tag_weekofyear' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_month( $atts, $content = '' ): string {
	return date( 'F' );
}
add_shortcode( 'tag_month', 'tumblr3_tag_month' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_shortmonth( $atts, $content = '' ): string {
	return date( 'M' );
}
add_shortcode( 'tag_shortmonth', 'tumblr3_tag_shortmonth' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_monthnumber( $atts, $content = '' ): string {
	return date( 'n' );
}
add_shortcode( 'tag_monthnumber', 'tumblr3_tag_monthnumber' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_monthnumberwithzero( $atts, $content = '' ): string {
	return date( 'm' );
}
add_shortcode( 'tag_monthnumberwithzero', 'tumblr3_tag_monthnumberwithzero' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_year( $atts, $content = '' ): string {
	return date( 'Y' );
}
add_shortcode( 'tag_year', 'tumblr3_tag_year' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_shortyear( $atts, $content = '' ): string {
	return date( 'y' );
}
add_shortcode( 'tag_shortyear', 'tumblr3_tag_shortyear' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_ampm( $atts, $content = '' ): string {
	return date( 'a' );
}
add_shortcode( 'tag_ampm', 'tumblr3_tag_ampm' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_capitalampm( $atts, $content = '' ): string {
	return date( 'A' );
}
add_shortcode( 'tag_capitalampm', 'tumblr3_tag_capitalampm' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_12hour( $atts, $content = '' ): string {
	return date( 'g' );
}
add_shortcode( 'tag_12hour', 'tumblr3_tag_12hour' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_24hour( $atts, $content = '' ): string {
	return date( 'G' );
}
add_shortcode( 'tag_24hour', 'tumblr3_tag_24hour' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_12hourwithzero( $atts, $content = '' ): string {
	return date( 'h' );
}
add_shortcode( 'tag_12hourwithzero', 'tumblr3_tag_12hourwithzero' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_24hourwithzero( $atts, $content = '' ): string {
	return date( 'H' );
}
add_shortcode( 'tag_24hourwithzero', 'tumblr3_tag_24hourwithzero' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_minutes( $atts, $content = '' ): string {
	return date( 'i' );
}
add_shortcode( 'tag_minutes', 'tumblr3_tag_minutes' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_seconds( $atts, $content = '' ): string {
	return date( 's' );
}
add_shortcode( 'tag_seconds', 'tumblr3_tag_seconds' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_beats( $atts, $content = '' ): string {
	$now = new DateTime( null, new DateTimeZone( 'UTC' ) );
	return '@' . floor( ( $now->format( 'G' ) * 3600 + $now->format( 'i' ) * 60 + $now->format( 's' ) + 3600 ) / 86.4 );
}
add_shortcode( 'tag_beats', 'tumblr3_tag_beats' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_timestamp( $atts, $content = '' ): string {
	return date( 'U' );
}
add_shortcode( 'tag_timestamp', 'tumblr3_tag_timestamp' );

/**
 * Undocumented function
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_timeago( $atts, $content = '' ): string {
	$post_time    = get_the_time( 'U' );
	$current_time = current_time( 'timestamp' );
	$time_diff    = human_time_diff( $post_time, $current_time );
	return sprintf( '%s ago', $time_diff );
}
add_shortcode( 'tag_timeago', 'tumblr3_tag_timeago' );
