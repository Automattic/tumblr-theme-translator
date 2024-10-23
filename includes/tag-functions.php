<?php

defined( 'ABSPATH' ) || exit;

/**
 * Outputs target attribute for links.
 *
 * @return string
 */
function tumblr3_tag_target(): string {
	return get_theme_mod( 'target_blank' ) ? 'target="_blank"' : '';
}

/**
 * Returns the NPF JSON string of the current post.
 *
 * @todo Rafael is writing a PHP parser for NPF.
 *
 * @return string Nothing, this tag is currently not supported.
 */
function tumblr3_tag_npf(): string {
	return '';
}

/**
 * The author name of the current post.
 *
 * @return string Post author name.
 */
function tumblr3_tag_postauthorname(): string {
	return get_the_author();
}

/**
 * Returns the group member display name.
 *
 * @return string Username or empty.
 */
function tumblr3_tag_groupmembername(): string {
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
function tumblr3_tag_groupmemberurl(): string {
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
function tumblr3_tag_groupmemberportraiturl( $atts ): string {
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
function tumblr3_tag_postauthortitle(): string {
	return esc_attr( get_bloginfo( 'name' ) );
}




/**
 * The URL of the post author.
 *
 * @return string URL to the author archive.
 */
function tumblr3_tag_postauthorurl(): string {
	return esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );
}

/**
 * The portrait URL of the post author.
 *
 * @param array $atts The attributes of the shortcode.
 *
 * @return string The URL of the author portrait.
 */
function tumblr3_tag_postauthorportraiturl( $atts ): string {
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
function tumblr3_tag_twitterusername(): string {
	return esc_attr( get_theme_mod( 'twitter_username' ) );
}

/**
 * The current state of a page in nav.
 * E.g is this the current page?
 *
 * @return string
 */
function tumblr3_tag_currentstate(): string {
	return get_the_permalink() === home_url( add_query_arg( null, null ) ) ? 'current-page' : '';
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

/**
 * The post content.
 *
 * @return string The content of the post with filters applied.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_body(): string {
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
function tumblr3_tag_excerpt(): string {
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
function tumblr3_tag_description(): string {
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
function tumblr3_tag_metadescription(): string {
	return esc_attr( get_bloginfo( 'description' ) );
}

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

/**
 * The portrait URL of the blog, uses the custom logo if set.
 *
 * @param array $atts The attributes of the shortcode.
 *
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
function tumblr3_tag_label(): string {
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
function tumblr3_tag_tagsasclasses(): string {
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
function tumblr3_tag_pinnedpostlabel(): string {
	return esc_html( 'Pinned Post' );
}

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

/**
 * The pagenumber tag inside jump pagination.
 *
 * @return string
 */
function tumblr3_tag_pagenumber(): string {
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
function tumblr3_tag_totalpages(): string {
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

/**
 * The total number of comments on a post.
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_notecount(): string {
	return get_comments_number();
}

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
function tumblr3_tag_source(): string {
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
function tumblr3_tag_length(): string {
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
function tumblr3_tag_audioplayer(): string {
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
function tumblr3_tag_albumarturl(): string {
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
function tumblr3_tag_trackname(): string {
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
function tumblr3_tag_artist(): string {
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
function tumblr3_tag_album(): string {
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
function tumblr3_tag_externalaudiourl(): string {
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
function tumblr3_tag_photoset(): string {
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
function tumblr3_tag_photosetlayout(): string {
	return tumblr3_tag_photocount();
}

/**
 * Renders the post gallery photo count if one was found.
 *
 * @return string
 */
function tumblr3_tag_photocount(): string {
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
function tumblr3_tag_caption(): string {
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
function tumblr3_tag_photourl( $atts, $content, $shortcode_name ): string {
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
function tumblr3_tag_thumbnail( $atts, $content, $shortcode_name ): string {
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
function tumblr3_tag_linkurl(): string {
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
function tumblr3_tag_linkopentag(): string {
	$context = tumblr3_get_parse_context();

	return ( isset( $context['image']['link'] ) && 'none' !== $context['image']['link'] ) ? '<a href="' . tumblr3_tag_linkurl() . '">' : '';
}

/**
 * Renders the post image link close tag conditionally.
 *
 * @return string
 */
function tumblr3_tag_linkclosetag(): string {
	$context = tumblr3_get_parse_context();

	return ( isset( $context['image']['link'] ) && 'none' !== $context['image']['link'] ) ? '</a>' : '';
}

/**
 * Renders the post image camera exif data if found.
 *
 * @return string
 */
function tumblr3_tag_camera(): string {
	$context = tumblr3_get_parse_context();

	return isset( $context['image']['data']['image_meta']['camera'] ) ? esc_html( $context['image']['data']['image_meta']['camera'] ) : '';
}

/**
 * Renders the post image lens exif data if found.
 *
 * @return string
 */
function tumblr3_tag_aperture(): string {
	$context = tumblr3_get_parse_context();

	return isset( $context['image']['data']['image_meta']['aperture'] ) ? esc_html( $context['image']['data']['image_meta']['aperture'] ) : '';
}

/**
 * Renders the post image focal length exif data if found.
 *
 * @return string
 */
function tumblr3_tag_focallength(): string {
	$context = tumblr3_get_parse_context();

	return isset( $context['image']['data']['image_meta']['focal_length'] ) ? esc_html( $context['image']['data']['image_meta']['focal_length'] ) : '';
}

/**
 * Renders the post image shutter speed exif data if found.
 *
 * @return string
 */
function tumblr3_tag_exposure(): string {
	$context = tumblr3_get_parse_context();

	return isset( $context['image']['data']['image_meta']['shutter_speed'] ) ? esc_html( $context['image']['data']['image_meta']['shutter_speed'] ) : '';
}

/**
 * Renders the post image alt text if one was found.
 *
 * @return string
 */
function tumblr3_tag_photoalt(): string {
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
function tumblr3_tag_photowidth(): string {
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
function tumblr3_tag_photoheight(): string {
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
function tumblr3_tag_video(): string {
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
function tumblr3_tag_videothumbnailurl(): string {
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
function tumblr3_tag_name(): string {
	return get_the_title( get_the_ID() );
}

/**
 * Renders the link post host url.
 *
 * @return string
 */
function tumblr3_tag_host(): string {
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
function tumblr3_tag_dayofmonth(): string {
	return get_the_date( 'j' );
}

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

/**
 * Returns the Swatch Internet Time (.beats).
 *
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_beats(): string {
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
function tumblr3_tag_timestamp(): string {
	return get_the_date( 'U' );
}

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
