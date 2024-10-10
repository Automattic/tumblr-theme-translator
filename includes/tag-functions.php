<?php

defined( 'ABSPATH' ) || exit;

/**
 * All non-supported tags are assigned here.
 *
 * @return string Nothing, this tag is not supported.
 */
function tumblr3_tag_functionality_missing(): string {
	return '';
}

/**
 * The display shape of your avatar ("circle" or "square").
 *
 * @return string Either "circle" or "square".
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_avatarshape(): string {
	return esc_html( get_theme_mod( 'avatar_shape', 'circle' ) );
}
add_shortcode( 'tag_avatarshape', 'tumblr3_tag_avatarshape' );

/**
 * The background color of your blog.
 *
 * @return string The background colour in HEX format.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_backgroundcolor(): string {
	return '#' . sanitize_hex_color_no_hash( get_theme_mod( 'background_color', '#fff' ) );
}
add_shortcode( 'tag_backgroundcolor', 'tumblr3_tag_backgroundcolor' );

/**
 * The accent color of your blog.
 *
 * @return string The accent colour in HEX format.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_accentcolor(): string {
	return '#' . sanitize_hex_color_no_hash( get_theme_mod( 'accent_color', '#0073aa' ) );
}
add_shortcode( 'tag_accentcolor', 'tumblr3_tag_accentcolor' );

/**
 * The title color of your blog.
 *
 * @return string The title colour in HEX format.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_titlecolor(): string {
	return '#' . sanitize_hex_color_no_hash( get_theme_mod( 'header_textcolor', '#000' ) );
}
add_shortcode( 'tag_titlecolor', 'tumblr3_tag_titlecolor' );

/**
 * Get the title font theme option.
 *
 * @return string The title fontname.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_titlefont(): string {
	return esc_html( get_theme_mod( 'title_font', 'Arial' ) );
}
add_shortcode( 'tag_titlefont', 'tumblr3_tag_titlefont' );

/**
 * The weight of your title font ("normal" or "bold").
 *
 * @return string Either "bold" or "normal".
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_titlefontweight(): string {
	return esc_html( get_theme_mod( 'title_font_weight', 'bold' ) );
}
add_shortcode( 'tag_titlefontweight', 'tumblr3_tag_titlefontweight' );

/**
 * Get the header image theme option.
 *
 * @return string Either "remove-header" or the URL of the header image.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_headerimage(): string {
	return get_theme_mod( 'header_image', 'remove-header' );
}
add_shortcode( 'tag_headerimage', 'tumblr3_tag_headerimage' );

/**
 * Get either a post title, or the blog title.
 *
 * @return string The title of the post or the blog.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_title(): string {
	$context = tumblr3_get_parse_context();

	// Consume global context and return the appropriate title.
	return ( isset( $context['theme'] ) ) ? get_bloginfo( 'name' ) : get_the_title();
}
add_shortcode( 'tag_title', 'tumblr3_tag_title' );
add_shortcode( 'tag_posttitle', 'tumblr3_tag_title' );

/**
 * The post content.
 *
 * @return string The content of the post with filters applied.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_body(): string {
	return apply_filters( 'the_content', get_the_content() );
}
add_shortcode( 'tag_body', 'tumblr3_tag_body' );

/**
 * The blog description, or subtitle.
 *
 * @return string The blog description.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_description(): string {
	return wp_kses_post( get_bloginfo( 'description' ) );
}
add_shortcode( 'tag_description', 'tumblr3_tag_description' );

/**
 * Attribute safe blog description.
 *
 * @return string The blog description with HTML entities encoded.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_metadescription(): string {
	return esc_attr( get_bloginfo( 'description' ) );
}
add_shortcode( 'tag_metadescription', 'tumblr3_tag_metadescription' );

/**
 * The homepage URL of the blog.
 *
 * @return string The URL of the blog.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_blogurl(): string {
	return esc_url( home_url( '/' ) );
}
add_shortcode( 'tag_blogurl', 'tumblr3_tag_blogurl' );

/**
 * The RSS feed URL of the blog.
 *
 * @return string The URL of the blog RSS feed.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_rss(): string {
	return esc_url( get_feed_link() );
}
add_shortcode( 'tag_rss', 'tumblr3_tag_rss' );

/**
 * The site favicon image URL.
 *
 * @return string The URL of the site favicon.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_favicon(): string {
	return esc_url( get_site_icon_url() );
}
add_shortcode( 'tag_favicon', 'tumblr3_tag_favicon' );

/**
 * The portrait URL of the blog, uses the custom logo if set.
 *
 * @param array $atts The attributes of the shortcode.
 * @return string The URL of the blog portrait.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_portraiturl( $atts ): string {
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
 * Returns the custom CSS option of the theme.
 *
 * @return string The custom CSS of the theme.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_customcss(): string {
	return esc_html( wp_get_custom_css() );
}
add_shortcode( 'tag_customcss', 'tumblr3_tag_customcss' );

/**
 * Identical to {PostTitle}, but will automatically generate a summary if a title doesn't exist.
 *
 * @return string The post title or summary.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_postsummary(): string {
	$title = get_the_title();
	return ( '' === $title ) ? $title : get_the_excerpt();
}
add_shortcode( 'tag_postsummary', 'tumblr3_tag_postsummary' );

/**
 * Character limited version of {PostSummary} that is suitable for Twitter.
 *
 * @return string The post summary limited to 280 characters.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_tweetsummary(): string {
	return esc_html( substr( tumblr3_tag_postsummary(), 0, 280 ) );
}
add_shortcode( 'tag_tweetsummary', 'tumblr3_tag_tweetsummary' );
add_shortcode( 'tag_mailsummary', 'tumblr3_tag_tweetsummary' );

/**
 * Various contextual uses, typically outputs a post permalink.
 *
 * @return string The URL of the post.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_url(): string {
	$context = tumblr3_get_parse_context();

	// Handle the jump pagination context for this tag.
	if ( isset( $context['jumppagination'] ) ) {
		return '/page/' . intval( $context['jumppagination'] );
	}

	return get_permalink();
}
add_shortcode( 'tag_url', 'tumblr3_tag_url' );
add_shortcode( 'tag_permalink', 'tumblr3_tag_url' );
add_shortcode( 'tag_relativepermalink', 'tumblr3_tag_url' );
add_shortcode( 'tag_shorturl', 'tumblr3_tag_url' );
add_shortcode( 'tag_embedurl', 'tumblr3_tag_url' );

/**
 * Typically a page title, used in a page loop e.g navigation.
 *
 * @todo This tag is also used in legacy chat posts.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_label(): string {
	return wp_kses_post( get_the_title() );
}
add_shortcode( 'tag_label', 'tumblr3_tag_label' );

/**
 * tagsasclasses outputs the tags of a post as HTML-safe classes.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tagsasclasses(): string {
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
add_shortcode( 'tag_tagsasclasses', 'tumblr3_tagsasclasses' );

/**
 * Label in post footer indicating this is a pinned post.
 *
 * @return string The label for a pinned post.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_pinnedpostlabel(): string {
	return esc_html( TUMBLR3_LANG['Pinned Post'] );
}
add_shortcode( 'tag_pinnedpostlabel', 'tumblr3_tag_pinnedpostlabel' );

/**
 * Gets the previous post URL (single post pagination)
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_previouspost(): string {
	return esc_url( get_permalink( get_adjacent_post( false, '', true ) ) );
}
add_shortcode( 'tag_previouspost', 'tumblr3_tag_previouspost' );

/**
 * Gets the next post URL (single post pagination)
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_nextpost(): string {
	return esc_url( get_permalink( get_adjacent_post( false, '', false ) ) );
}
add_shortcode( 'tag_nextpost', 'tumblr3_tag_nextpost' );

/**
 * Gets the previous posts page URL (pagination)
 *
 * @return string|null
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_previouspage(): string|null {
	return esc_url( get_next_posts_page_link() );
}
add_shortcode( 'tag_previouspage', 'tumblr3_tag_previouspage' );

/**
 * Gets the next posts page URL (pagination)
 *
 * @return string|null
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_nextpage(): string|null {
	return esc_url( get_previous_posts_page_link() );
}
add_shortcode( 'tag_nextpage', 'tumblr3_tag_nextpage' );

/**
 * Gets the current page value (pagination)
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_currentpage(): string {
	return get_query_var( 'paged' );
}
add_shortcode( 'tag_currentpage', 'tumblr3_tag_currentpage' );

/**
 * The pagenumber tag inside jump pagination.
 *
 * @return string
 */
function tumblr3_tag_pagenumber(): string {
	$context = tumblr3_get_parse_context();
	return isset( $context['jumppagination'] ) ? (string) $context['jumppagination'] : '';
}
add_shortcode( 'tag_pagenumber', 'tumblr3_tag_pagenumber' );

/**
 * Gets the query total pages (pagination)
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_totalpages(): string {
	global $wp_query;
	return $wp_query->max_num_pages;
}
add_shortcode( 'tag_totalpages', 'tumblr3_tag_totalpages' );

/**
 * Displays the span of years your blog has existed.
 *
 * @return string
 *
 * @todo find a way to get the install date of the blog.
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_copyrightyears(): string {
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
add_shortcode( 'tag_copyrightyears', 'tumblr3_tag_copyrightyears' );

/**
 * The numeric ID for a post.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_postid(): string {
	return esc_attr( get_the_ID() );
}
add_shortcode( 'tag_postid', 'tumblr3_tag_postid' );

/**
 * The name of the current legacy post type.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_posttype(): string {
	$format = get_post_format();
	return ( $format ) ? $format : 'text';
}
add_shortcode( 'tag_posttype', 'tumblr3_tag_posttype' );

/**
 * Current tag name in a loop.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_tag(): string {
	$context = tumblr3_get_parse_context();

	// Check if we are in a tag context.
	if ( ! isset( $context['term'] ) || ! is_a( $context['term'], 'WP_Term' ) ) {
		return '';
	}

	return $context['term']->name;
}
add_shortcode( 'tag_tag', 'tumblr3_tag_tag' );

/**
 * Current tag name in a loop.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_urlsafetag(): string {
	$context = tumblr3_get_parse_context();

	// Check if we are in a tag context.
	if ( ! isset( $context['term'] ) || ! is_a( $context['term'], 'WP_Term' ) ) {
		return '';
	}

	return rawurlencode( $context['term']->name );
}
add_shortcode( 'tag_urlsafetag', 'tumblr3_tag_urlsafetag' );

/**
 * Current tag url in a loop.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_tagurl(): string {
	$context = tumblr3_get_parse_context();

	// Check if we are in a tag context.
	if ( ! isset( $context['term'] ) || ! is_a( $context['term'], 'WP_Term' ) ) {
		return '';
	}

	return get_term_link( $context['term'] );
}
add_shortcode( 'tag_tagurl', 'tumblr3_tag_tagurl' );
add_shortcode( 'tag_tagurlchrono', 'tumblr3_tag_tagurl' );

/**
 * The total number of comments on a post.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_notecount(): string {
	return get_comment_number();
}
add_shortcode( 'tag_notecount', 'tumblr3_tag_notecount' );

/**
 * The total number of comments on a post in text form.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_notecountwithlabel(): string {
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
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_postnotes( $atts ): string {
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
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_searchquery(): string {
	return esc_html( get_search_query() );
}
add_shortcode( 'tag_searchquery', 'tumblr3_tag_searchquery' );

/**
 * The current search query URL encoded.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_urlsafesearchquery(): string {
	return rawurlencode( get_search_query() );
}
add_shortcode( 'tag_urlsafesearchquery', 'tumblr3_tag_urlsafesearchquery' );

/**
 * The found posts count of the search result.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_searchresultcount(): string {
	global $wp_query;
	return $wp_query->found_posts;
}
add_shortcode( 'tag_searchresultcount', 'tumblr3_tag_searchresultcount' );

/**
 * Quote post content.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_quote(): string {
	$context = tumblr3_get_parse_context();

	// Test if the current context is a quote post and has a source.
	if ( isset( $context['quote'] ) && is_array( $context['quote'] ) && isset( $context['quote']['quote'] ) ) {
		return $context['quote']['quote'];
	}

	// Empty string if no quote block is found.
	return '';
}
add_shortcode( 'tag_quote', 'tumblr3_tag_quote' );

/**
 * Quote post source.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_source(): string {
	$context = tumblr3_get_parse_context();

	// Test if the current context is a quote post and has a source.
	if ( isset( $context['quote'] ) && is_array( $context['quote'] ) && isset( $context['quote']['source'] ) ) {
		return $context['quote']['source'];
	}

	return '';
}
add_shortcode( 'tag_source', 'tumblr3_tag_source' );

/**
 * Quote content length.
 * "short", "medium", "long"
 *
 * @return string
 *
 * @see https://github.tumblr.net/Tumblr/tumblr/blob/046755128a6d61010fcaf4459f8efdc895140ad0/app/models/post.php#L7459
 */
function tumblr3_tag_length(): string {
	$context = tumblr3_get_parse_context();

	// Test if the current context is a quote post and has a length.
	if ( isset( $context['quote'] ) && is_array( $context['quote'] ) && isset( $context['quote']['length'] ) ) {
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
add_shortcode( 'tag_length', 'tumblr3_tag_length' );

/**
 * @todo Understand what Tumblr outputs in this tag.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_posttypographystyles(): string {
	return '<style></style>';
}
add_shortcode( 'tag_posttypographystyles', 'tumblr3_tag_posttypographystyles' );
add_shortcode( 'tag_newpoststyles', 'tumblr3_tag_posttypographystyles' );

/**
 * Returns the day of the month without leading zeros.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_dayofmonth(): string {
	return get_the_date( 'j' );
}
add_shortcode( 'tag_dayofmonth', 'tumblr3_tag_dayofmonth' );

/**
 * Returns the day of the month with leading zeros.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_dayofmonthwithzero(): string {
	return get_the_date( 'd' );
}
add_shortcode( 'tag_dayofmonthwithzero', 'tumblr3_tag_dayofmonthwithzero' );

/**
 * Returns the full name of the day of the week.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_dayofweek(): string {
	return get_the_date( 'l' );
}
add_shortcode( 'tag_dayofweek', 'tumblr3_tag_dayofweek' );

/**
 * Returns the abbreviated name of the day of the week.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_shortdayofweek(): string {
	return get_the_date( 'D' );
}
add_shortcode( 'tag_shortdayofweek', 'tumblr3_tag_shortdayofweek' );

/**
 * Returns the day of the week as a number (1 for Monday, 7 for Sunday).
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_dayofweeknumber(): string {
	return get_the_date( 'N' );
}
add_shortcode( 'tag_dayofweeknumber', 'tumblr3_tag_dayofweeknumber' );

/**
 * Returns the English ordinal suffix for the day of the month.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_dayofmonthsuffix(): string {
	return get_the_date( 'S' );
}
add_shortcode( 'tag_dayofmonthsuffix', 'tumblr3_tag_dayofmonthsuffix' );

/**
 * Returns the day of the year (1 to 365).
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_dayofyear(): string {
	return get_the_date( 'z' ) + 1; // Adding 1 because PHP date 'z' is zero-indexed
}
add_shortcode( 'tag_dayofyear', 'tumblr3_tag_dayofyear' );

/**
 * Returns the week of the year (1 to 53).
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_weekofyear(): string {
	return get_the_date( 'W' );
}
add_shortcode( 'tag_weekofyear', 'tumblr3_tag_weekofyear' );

/**
 * Returns the full name of the current month.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_month(): string {
	return get_the_date( 'F' );
}
add_shortcode( 'tag_month', 'tumblr3_tag_month' );

/**
 * Returns the abbreviated name of the current month.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_shortmonth(): string {
	return get_the_date( 'M' );
}
add_shortcode( 'tag_shortmonth', 'tumblr3_tag_shortmonth' );

/**
 * Returns the numeric representation of the month without leading zeros.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_monthnumber(): string {
	return get_the_date( 'n' );
}
add_shortcode( 'tag_monthnumber', 'tumblr3_tag_monthnumber' );

/**
 * Returns the numeric representation of the month with leading zeros.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_monthnumberwithzero(): string {
	return get_the_date( 'm' );
}
add_shortcode( 'tag_monthnumberwithzero', 'tumblr3_tag_monthnumberwithzero' );

/**
 * Returns the full numeric representation of the year (e.g., 2024).
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_year(): string {
	return get_the_date( 'Y' );
}
add_shortcode( 'tag_year', 'tumblr3_tag_year' );

/**
 * Returns the last two digits of the year (e.g., 24 for 2024).
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_shortyear(): string {
	return get_the_date( 'y' );
}
add_shortcode( 'tag_shortyear', 'tumblr3_tag_shortyear' );

/**
 * Returns lowercase 'am' or 'pm' based on the time.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_ampm(): string {
	return get_the_date( 'a' );
}
add_shortcode( 'tag_ampm', 'tumblr3_tag_ampm' );

/**
 * Returns uppercase 'AM' or 'PM' based on the time.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_capitalampm(): string {
	return get_the_date( 'A' );
}
add_shortcode( 'tag_capitalampm', 'tumblr3_tag_capitalampm' );

/**
 * Returns the hour in 12-hour format without leading zeros.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_12hour(): string {
	return get_the_date( 'g' );
}
add_shortcode( 'tag_12hour', 'tumblr3_tag_12hour' );

/**
 * Returns the hour in 24-hour format without leading zeros.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_24hour(): string {
	return get_the_date( 'G' );
}
add_shortcode( 'tag_24hour', 'tumblr3_tag_24hour' );

/**
 * Returns the hour in 12-hour format with leading zeros.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_12hourwithzero(): string {
	return get_the_date( 'h' );
}
add_shortcode( 'tag_12hourwithzero', 'tumblr3_tag_12hourwithzero' );

/**
 * Returns the hour in 24-hour format with leading zeros.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_24hourwithzero(): string {
	return get_the_date( 'H' );
}
add_shortcode( 'tag_24hourwithzero', 'tumblr3_tag_24hourwithzero' );

/**
 * Returns the minutes with leading zeros.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_minutes(): string {
	return get_the_date( 'i' );
}
add_shortcode( 'tag_minutes', 'tumblr3_tag_minutes' );

/**
 * Returns the seconds with leading zeros.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_seconds(): string {
	return get_the_date( 's' );
}
add_shortcode( 'tag_seconds', 'tumblr3_tag_seconds' );

/**
 * Returns the Swatch Internet Time (.beats).
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_beats(): string {
	$now = new DateTime( null, new DateTimeZone( 'UTC' ) );
	return '@' . floor( ( $now->format( 'G' ) * 3600 + $now->format( 'i' ) * 60 + $now->format( 's' ) + 3600 ) / 86.4 );
}
add_shortcode( 'tag_beats', 'tumblr3_tag_beats' );

/**
 * Returns the Unix timestamp of the post.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_timestamp(): string {
	return get_the_date( 'U' );
}
add_shortcode( 'tag_timestamp', 'tumblr3_tag_timestamp' );

/**
 * Returns the time difference between the post date and now, in human-readable format.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_timeago(): string {
	$post_time    = get_the_time( 'U' );
	$current_time = current_time( 'timestamp' );
	$time_diff    = human_time_diff( $post_time, $current_time );
	return sprintf( '%s ago', $time_diff );
}
add_shortcode( 'tag_timeago', 'tumblr3_tag_timeago' );
