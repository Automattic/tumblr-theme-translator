<?php

defined( 'ABSPATH' ) || exit;

/**
 * All non-supported tags are assigned here.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#basic_variables
 */
function tumblr3_tag_functionality_missing( $atts, $content = '' ): string {
	return '';
}
add_shortcode( 'tag_reblogparentname', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogparenttitle', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogparenturl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogparentportraiturl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogrootname', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogroottitle', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogrooturl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogrootportraiturl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_reblogbutton', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_likebutton', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_likes', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_groupmembername', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_groupmembertitle', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_groupmemberurl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_groupmemberportraiturl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_followedname', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_followedtitle', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_followedurl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_followedportraiturl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_submitlabel', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_asklabel', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_submitter', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_submitterurl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_submitterportraiturl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_postauthorname', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_postauthortitle', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_postauthorurl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_postauthorportraiturl', 'tumblr3_tag_functionality_missing' );
add_shortcode( 'tag_npf', 'tumblr3_tag_functionality_missing' );

/**
 * All non-supported blocks are assigned here.
 *
 * @param array $attributes The attributes of the shortcode.
 * @param string $content The content of the shortcode.
 * @return string
 */
function tumblr3_block_functionality_missing( $atts, $content = '' ): string {
	return '';
}
add_shortcode( 'block_reblogs', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_rebloggedfrom', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_askenabled', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_submissionsenabled', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_likes', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_nolikes', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_sharefollowing', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_submission', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_isactive', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_isdeactivated', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_askpage', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_submitpage', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_likespage', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_followingpage', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_following', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_followed', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_haspermalink', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_hasavatar', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_isoriginalentry', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_groupmembers', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_groupmember', 'tumblr3_block_functionality_missing' );
add_shortcode( 'block_relatedposts', 'tumblr3_block_functionality_missing' );