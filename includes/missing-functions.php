<?php

defined( 'ABSPATH' ) || exit;

/**
 * WordPress does not support playcount tracking for attached audio files.
 * This would need to be implemented as a custom meta field on the attachment.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#audio-posts
 */
add_shortcode( 'tag_playcount', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_formattedplaycount', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_playcountwithlabel', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'block_playcount', 'tumblr3_block_functionality_missing' );

/**
 * WordPress doesn't support a panorama post format out of the box.
 * Could this be safely mapped to the Image post format?
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#panorama-posts
 */
add_shortcode( 'block_panorama', 'tumblr3_block_functionality_missing' );
add_shortcode( 'tag_photourl-panorama', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_photowidth-panorama', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_photoheight-panorama', 'tumblr3_tag_functionality_missing' );

/**
 * WordPress doesn't have a following system for noting other blogs you follow.
 * Previously we had the "links" CPT that was used for making blogrolls.
 * Perhaps we could bring that back?
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#following
 */
add_shortcode( 'block_sharefollowing', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_followingpage', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_following', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_followed', 'tumblr3_block_functionality_missing' );
add_shortcode( 'tag_followedname', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_followedtitle', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_followedurl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_followedportraiturl', 'tumblr3_tag_functionality_missing' );

/**
 * WordPress doesn't have a highligted posts system.
 * Perhaps we could just use the sticky posts system?
 * This seems to exist purely to fulfill a widget in Optica and loads Photo posts only.
 *
 * @see https://github.tumblr.net/Tumblr/tumblr/blob/5e69aae5fd71f2a151078abf11a4d146d3aa6bd7/app/controllers/tumblelog.php#L4778
 */
add_shortcode( 'block_hashighlightedposts', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_highlightedposts', 'tumblr3_block_functionality_missing' );

/**
 * WordPress does not have a related tags system.
 * On Tumblr this appears to be handled by Redis.
 *
 * @see https://github.tumblr.net/Tumblr/tumblr/blob/12a34ac17d5a80eaec05b486f670fc80214d083d/app/controllers/tumblelog/utils/ThemeItemHelper.php#L551
 */
add_shortcode( 'block_hasrelatedtags', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_relatedtags', 'tumblr3_block_functionality_missing' );

/**
 * WordPress does not have a featured tags system.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#featured-tags
 */
add_shortcode( 'block_hasfeaturedtags', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_featuredtags', 'tumblr3_block_functionality_missing' );

/**
 * WordPress does not have a related posts system by default.
 * Jetpack has a related posts module, perhaps we could integrate with that?
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#related-posts
 */
add_shortcode( 'block_relatedposts', 'tumblr3_block_functionality_missing' );

/**
 * WordPress does not have a native submission system.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#submissions
 */
add_shortcode( 'block_submissionsenabled', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_submission', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_submitpage', 'tumblr3_block_functionality_missing' );
add_shortcode( 'tag_submitlabel', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_submitter', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_submitterurl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_submitterportraiturl', 'tumblr3_tag_functionality_missing' );

/**
 * WordPress does not support question/answer systems.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#answer-posts
 */
add_shortcode( 'block_askenabled', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_askpage', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_answerer', 'tumblr3_block_functionality_missing' );
add_shortcode( 'tag_question', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_asker', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_askerportraiturl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_answerer', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_answererportraiturl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_asklabel', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_answer', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_replies', 'tumblr3_tag_functionality_missing' );

/**
 * WordPress does not support likes.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#likes
 */
add_shortcode( 'block_likes', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_nolikes', 'tumblr3_block_functionality_missing' );
add_shortcode( 'tag_likebutton', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_likes', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'block_haslikedposts', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_likedposts', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_likespage', 'tumblr3_block_functionality_missing' );

/**
 * WordPress does not support reblogs.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#reblogs
 */
add_shortcode( 'tag_reblogurl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogparentname', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogparenttitle', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogparenturl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogparentportraiturl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogrootname', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogroottitle', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogrooturl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogrootportraiturl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogbutton', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'block_reblogs', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_rebloggedfrom', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_isoriginalentry', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_isactive', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_isdeactivated', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_haspermalink', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_hasnopermalink', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_hasavatar', 'tumblr3_block_functionality_missing' );
add_shortcode( 'tag_username', 'tumblr3_tag_functionality_missing' );

/**
 * WordPress doesn't have a day by day archive system,
 * but date archives are available and traverse with the regular pagination block.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#day-pages
 */
add_shortcode( 'block_daypagination', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_previousdaypage', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_nextdaypage', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_newdaydate', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_samedaydate', 'tumblr3_block_functionality_missing' );
add_shortcode( 'tag_previousdaypage', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_nextdaypage', 'tumblr3_tag_functionality_missing' );

/**
 * WordPress does not support content sources.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#content-sources
 */
add_shortcode( 'tag_blacklogourl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_logowidth', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_logoheight', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_sourceurl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_sourcetitle', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'block_contentsource', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_sourcelogo', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_nosourcelogo', 'tumblr3_block_functionality_missing' );

/**
 * These tags/blocks are extremely specific to Tumblr and are not supported by WordPress.
 * Tags here will never be supported by WordPress. Unlike other sections which may be supported in the future.
 */
add_shortcode( 'tag_posttypographystyles', 'tumblr3_tag_posttypographystyles' );
add_shortcode( 'tag_newpoststyles', 'tumblr3_tag_posttypographystyles' );
add_shortcode( 'tag_postnotesurl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_mobileappheaders', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'block_showadsonthispage', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_newcta', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_nuopticablogcardsenabled', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_nuopticablogcardsdisabled', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_supplylogging', 'tumblr3_block_functionality_missing' ); // https://github.tumblr.net/Tumblr/tumblr/blob/12a34ac17d5a80eaec05b486f670fc80214d083d/app/controllers/tumblelog/utils/ThemeItemHelper.php#L75
add_shortcode( 'tag_positions', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'block_actions', 'tumblr3_block_functionality_missing' ); // https://github.tumblr.net/Tumblr/tumblr/blob/12a34ac17d5a80eaec05b486f670fc80214d083d/app/controllers/tumblelog/utils/ThemeItemHelper.php#L1061
