<?php
/**
 * WordPress does not support playcount tracking for attached audio files.
 * This would need to be implemented as a custom meta field on the attachment.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#audio-posts
 */

/**
 * WordPress doesn't support a panorama post format out of the box.
 * Could this be safely mapped to the Image post format?
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#panorama-posts
 */

/**
 * WordPress doesn't have a following system for noting other blogs you follow.
 * Previously we had the "links" CPT that was used for making blogrolls.
 * Perhaps we could bring that back?
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#following
 */

/**
 * WordPress doesn't have a highligted posts system.
 * Perhaps we could just use the sticky posts system?
 * This seems to exist purely to fulfill a widget in Optica and loads Photo posts only.
 *
 * @see https://github.tumblr.net/Tumblr/tumblr/blob/5e69aae5fd71f2a151078abf11a4d146d3aa6bd7/app/controllers/tumblelog.php#L4778
 */

/**
 * WordPress does not have a related tags system.
 * On Tumblr this appears to be handled by Redis.
 *
 * @see https://github.tumblr.net/Tumblr/tumblr/blob/12a34ac17d5a80eaec05b486f670fc80214d083d/app/controllers/tumblelog/utils/ThemeItemHelper.php#L551
 */

/**
 * WordPress does not have a featured tags system.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#featured-tags
 */

/**
 * WordPress does not have a related posts system by default.
 * Jetpack has a related posts module, perhaps we could integrate with that?
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#related-posts
 */

/**
 * WordPress does not have a native submission system.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#submissions
 */

/**
 * WordPress does not support question/answer systems.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#answer-posts
 */

/**
 * WordPress does not support likes.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#likes
 */

/**
 * WordPress does not support reblogs.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#reblogs
 */

/**
 * WordPress doesn't have a day by day archive system,
 * but date archives are available and traverse with the regular pagination block.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#day-pages
 */

/**
 * WordPress does not support content sources.
 *
 * @see https://www.tumblr.com/docs/en/custom_themes#content-sources
 */


defined( 'ABSPATH' ) || exit;

return apply_filters(
	'tumblr3_block_names',
	array(
		'block:Hidden'                    => array(
			'fn' => 'tumblr3_block_options',
		),
		'block:Options'                   => array(
			'fn' => 'tumblr3_block_options',
		),
		'block:Body'                      => array(
			'fn' => 'tumblr3_block_body',
		),
		'block:PermalinkPage'             => array(
			'fn' => 'tumblr3_block_permalinkpage',
		),
		'block:IndexPage'                 => array(
			'fn' => 'tumblr3_block_indexpage',
		),
		'block:HomePage'                  => array(
			'fn' => 'tumblr3_block_homepage',
		),
		'block:PostTitle'                 => array(
			'fn' => 'tumblr3_block_posttitle',
		),
		'block:PostSummary'               => array(
			'fn' => 'tumblr3_block_body',
		),
		'block:ShowTitle'                 => array(
			'fn' => 'tumblr3_block_showtitle',
		),
		'block:HideTitle'                 => array(
			'fn' => 'tumblr3_block_hidetitle',
		),
		'block:ShowDescription'           => array(
			'fn' => 'tumblr3_block_showdescription',
		),
		'block:HideDescription'           => array(
			'fn' => 'tumblr3_block_hidedescription',
		),
		'block:ShowAvatar'                => array(
			'fn' => 'tumblr3_block_showavatar',
		),
		'block:HideAvatar'                => array(
			'fn' => 'tumblr3_block_hideavatar',
		),
		'block:ShowHeaderImage'           => array(
			'fn' => 'tumblr3_block_showheaderimage',
		),
		'block:HideHeaderImage'           => array(
			'fn' => 'tumblr3_block_hideheaderimage',
		),
		'block:Pagination'                => array(
			'fn' => 'tumblr3_block_pagination',
		),
		'block:PreviousPage'              => array(
			'fn' => 'tumblr3_block_previouspage',
		),
		'block:NextPage'                  => array(
			'fn' => 'tumblr3_block_nextpage',
		),
		'block:SubmissionsEnabled'        => array(
			'fn' => '__return_empty_string',
		),
		'block:AskEnabled'                => array(
			'fn' => '__return_empty_string',
		),
		'block:JumpPagination'            => array(
			'fn'     => 'tumblr3_block_jumppagination',
			'looper' => true,
		),
		'block:CurrentPage'               => array(
			'fn' => 'tumblr3_block_currentpage',
		),
		'block:JumpPage'                  => array(
			'fn' => 'tumblr3_block_jumppage',
		),
		'block:HasPages'                  => array(
			'fn' => 'tumblr3_block_haspages',
		),
		'block:Pages'                     => array(
			'fn'     => 'tumblr3_block_pages',
			'looper' => true,
		),
		'block:PermalinkPagination'       => array(
			'fn' => 'tumblr3_block_permalinkpagination',
		),
		'block:PreviousPost'              => array(
			'fn' => 'tumblr3_block_previouspost',
		),
		'block:NextPost'                  => array(
			'fn' => 'tumblr3_block_nextpost',
		),
		'block:Posts'                     => array(
			'fn'     => 'tumblr3_block_posts',
			'looper' => true,
		),
		'block:NoPosts'                   => array(
			'fn' => 'tumblr3_block_noposts',
		),
		'block:Text'                      => array(
			'fn' => 'tumblr3_block_text',
		),
		'block:Answer'                    => array(
			'fn' => 'tumblr3_block_answer',
		),
		'block:Photo'                     => array(
			'fn' => 'tumblr3_block_photo',
		),
		'block:Panorama'                  => array(
			'fn' => '__return_empty_string',
		),
		'block:Photoset'                  => array(
			'fn' => 'tumblr3_block_photoset',
		),
		'block:Quote'                     => array(
			'fn' => 'tumblr3_block_quote',
		),
		'block:Link'                      => array(
			'fn' => 'tumblr3_block_link',
		),
		'block:Chat'                      => array(
			'fn' => 'tumblr3_block_chat',
		),
		'block:Audio'                     => array(
			'fn' => 'tumblr3_block_audio',
		),
		'block:Video'                     => array(
			'fn' => 'tumblr3_block_video',
		),
		'block:Post1'                     => array(
			'fn' => 'tumblr3_block_post_n',
		),
		'block:Post2'                     => array(
			'fn' => 'tumblr3_block_post_n',
		),
		'block:Post3'                     => array(
			'fn' => 'tumblr3_block_post_n',
		),
		'block:Post4'                     => array(
			'fn' => 'tumblr3_block_post_n',
		),
		'block:Post5'                     => array(
			'fn' => 'tumblr3_block_post_n',
		),
		'block:Post6'                     => array(
			'fn' => 'tumblr3_block_post_n',
		),
		'block:Post7'                     => array(
			'fn' => 'tumblr3_block_post_n',
		),
		'block:Post8'                     => array(
			'fn' => 'tumblr3_block_post_n',
		),
		'block:Post9'                     => array(
			'fn' => 'tumblr3_block_post_n',
		),
		'block:Post10'                    => array(
			'fn' => 'tumblr3_block_post_n',
		),
		'block:Post11'                    => array(
			'fn' => 'tumblr3_block_post_n',
		),
		'block:Post12'                    => array(
			'fn' => 'tumblr3_block_post_n',
		),
		'block:Post13'                    => array(
			'fn' => 'tumblr3_block_post_n',
		),
		'block:Post14'                    => array(
			'fn' => 'tumblr3_block_post_n',
		),
		'block:Post15'                    => array(
			'fn' => 'tumblr3_block_post_n',
		),
		'block:Odd'                       => array(
			'fn' => 'tumblr3_block_odd',
		),
		'block:Even'                      => array(
			'fn' => 'tumblr3_block_even',
		),
		'block:More'                      => array(
			'fn' => 'tumblr3_block_more',
		),
		'block:PinnedPostLabel'           => array(
			'fn' => 'tumblr3_block_pinnedpostlabel',
		),
		'block:Reblog'                    => array(
			'fn' => '__return_empty_string',
		),
		'block:RebloggedFromReblog'       => array(
			'fn' => '__return_empty_string',
		),
		'block:NotReblog'                 => array(
			'fn' => 'tumblr3_block_notreblog',
		),
		'block:RebloggedFrom'             => array(
			'fn' => '__return_empty_string',
		),
		'block:Reblogs'                   => array(
			'fn' => '__return_empty_string',
		),
		'block:IsActive'                  => array(
			'fn' => '__return_empty_string',
		),
		'block:IsDeactivated'             => array(
			'fn' => '__return_empty_string',
		),
		'block:HasPermalink'              => array(
			'fn' => '__return_empty_string',
		),
		'block:HasAvatar'                 => array(
			'fn' => '__return_empty_string',
		),
		'block:isOriginalEntry'           => array(
			'fn' => '__return_empty_string',
		),
		'block:Title'                     => array(
			'fn' => 'tumblr3_block_title',
		),
		'block:Caption'                   => array(
			'fn' => 'tumblr3_block_caption',
		),
		'block:LinkURL'                   => array(
			'fn' => 'tumblr3_block_linkurl',
		),
		'block:HighRes'                   => array(
			'fn' => 'tumblr3_block_highres',
		),
		'block:Exif'                      => array(
			'fn' => 'tumblr3_block_exif',
		),
		'block:Camera'                    => array(
			'fn' => 'tumblr3_block_camera',
		),
		'block:Aperture'                  => array(
			'fn' => 'tumblr3_block_aperture',
		),
		'block:Exposure'                  => array(
			'fn' => 'tumblr3_block_exposure',
		),
		'block:FocalLength'               => array(
			'fn' => 'tumblr3_block_focallength',
		),
		'block:Photos'                    => array(
			'fn' => 'tumblr3_block_photos',
		),
		'block:Source'                    => array(
			'fn' => 'tumblr3_block_source',
		),
		'block:Host'                      => array(
			'fn' => 'tumblr3_block_body',
		),
		'block:Thumbnail'                 => array(
			'fn' => 'tumblr3_block_thumbnail',
		),
		'block:Description'               => array(
			'fn' => 'tumblr3_block_description',
		),
		'block:Author'                    => array(
			'fn' => '__return_empty_string',
		),
		'block:Excerpt'                   => array(
			'fn' => 'tumblr3_block_body',
		),
		'block:Lines'                     => array(
			'fn' => '__return_empty_string',
		),
		'block:Label'                     => array(
			'fn' => '__return_empty_string',
		),
		'block:AudioEmbed'                => array(
			'fn' => 'tumblr3_block_audioplayer',
		),
		'block:AudioPlayer'               => array(
			'fn' => 'tumblr3_block_audioplayer',
		),
		'block:PlayCount'                 => array(
			'fn' => '__return_empty_string',
		),
		'block:ExternalAudio'             => array(
			'fn' => 'tumblr3_block_externalaudio',
		),
		'block:AlbumArt'                  => array(
			'fn' => 'tumblr3_block_albumart',
		),
		'block:Artist'                    => array(
			'fn' => 'tumblr3_block_artist',
		),
		'block:Album'                     => array(
			'fn' => 'tumblr3_block_album',
		),
		'block:TrackName'                 => array(
			'fn' => 'tumblr3_block_trackname',
		),
		'block:VideoThumbnail'            => array(
			'fn' => 'tumblr3_block_videothumbnail',
		),
		'block:VideoThumbnails'           => array(
			'fn' => 'tumblr3_block_videothumbnail',
		),
		'block:Answerer'                  => array(
			'fn' => '__return_empty_string',
		),
		'block:Date'                      => array(
			'fn' => 'tumblr3_block_body',
		),
		'block:NewDayDate'                => array(
			'fn' => '__return_empty_string',
		),
		'block:SameDayDate'               => array(
			'fn' => '__return_empty_string',
		),
		'block:PostNotes'                 => array(
			'fn' => 'tumblr3_block_postnotes',
		),
		'block:NoteCount'                 => array(
			'fn' => 'tumblr3_block_notecount',
		),
		'block:HasTags'                   => array(
			'fn' => 'tumblr3_block_hastags',
		),
		'block:Tags'                      => array(
			'fn'     => 'tumblr3_block_tags',
			'looper' => true,
		),
		'block:ContentSource'             => array(
			'fn' => '__return_empty_string',
		),
		'block:SourceLogo'                => array(
			'fn' => '__return_empty_string',
		),
		'block:NoSourceLogo'              => array(
			'fn' => '__return_empty_string',
		),
		'block:Submission'                => array(
			'fn' => '__return_empty_string',
		),
		'block:GroupMembers'              => array(
			'fn'     => 'tumblr3_block_groupmembers',
			'looper' => true,
		),
		'block:GroupMember'               => array(
			'fn' => 'tumblr3_block_groupmember',
		),
		'block:DayPage'                   => array(
			'fn' => 'tumblr3_block_daypage',
		),
		'block:DayPagination'             => array(
			'fn' => '__return_empty_string',
		),
		'block:PreviousDayPage'           => array(
			'fn' => '__return_empty_string',
		),
		'block:NextDayPage'               => array(
			'fn' => '__return_empty_string',
		),
		'block:TagPage'                   => array(
			'fn' => 'tumblr3_block_tagpage',
		),
		'block:SearchPage'                => array(
			'fn' => 'tumblr3_block_searchpage',
		),
		'block:SearchResults'             => array(
			'fn' => 'tumblr3_block_searchresults',
		),
		'block:NoSearchResults'           => array(
			'fn' => 'tumblr3_block_nosearchresults',
		),
		'block:HideFromSearchEnabled'     => array(
			'fn' => 'tumblr3_block_hidefromsearchenabled',
		),
		'block:HasFeaturedTags'           => array(
			'fn' => '__return_empty_string',
		),
		'block:FeaturedTags'              => array(
			'fn' => '__return_empty_string',
		),
		'block:Following'                 => array(
			'fn' => '__return_empty_string',
		),
		'block:Followed'                  => array(
			'fn' => '__return_empty_string',
		),
		'block:Likes'                     => array(
			'fn' => '__return_empty_string',
		),
		'block:NoLikes'                   => array(
			'fn' => '__return_empty_string',
		),
		'block:RelatedPosts'              => array(
			'fn' => '__return_empty_string',
		),
		'block:AskPage'                   => array(
			'fn' => '__return_empty_string',
		),
		'block:SubmitPage'                => array(
			'fn' => '__return_empty_string',
		),
		'block:LikesPage'                 => array(
			'fn' => '__return_empty_string',
		),
		'block:FollowingPage'             => array(
			'fn' => '__return_empty_string',
		),
		'block:ShareFollowing'            => array(
			'fn' => '__return_empty_string',
		),
		'block:English'                   => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:German'                    => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:French'                    => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:Italian'                   => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:Japanese'                  => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:Turkish'                   => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:Spanish'                   => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:Russian'                   => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:Polish'                    => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:PortuguesePT'              => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:PortugueseBR'              => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:Dutch'                     => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:Korean'                    => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:ChineseSimplified'         => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:ChineseTraditional'        => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:ChineseHK'                 => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:Indonesian'                => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:Hindi'                     => array(
			'fn' => 'tumblr3_block_language',
		),
		'block:StretchHeaderImage'        => array(
			'fn' => 'tumblr3_block_stretchheaderimage',
		),
		'block:NoStretchHeaderImage'      => array(
			'fn' => 'tumblr3_block_nostretchheaderimage',
		),
		'block:ShowAdsOnThisPage'         => array(
			'fn' => '__return_empty_string',
		),
		'block:HasNoPermalink'            => array(
			'fn' => '__return_empty_string',
		),
		'block:HasHighlightedPosts'       => array(
			'fn' => '__return_empty_string',
		),
		'block:HighlightedPosts'          => array(
			'fn' => '__return_empty_string',
		),
		'block:HasLikedPosts'             => array(
			'fn' => '__return_empty_string',
		),
		'block:LikedPosts'                => array(
			'fn' => '__return_empty_string',
		),
		'block:NewCta'                    => array(
			'fn' => '__return_empty_string',
		),
		'block:Actions'                   => array(
			'fn' => '__return_empty_string',
		),
		'block:SupplyLogging'             => array(
			'fn' => '__return_empty_string',
		),
		'block:NuOpticaBlogCardsEnabled'  => array(
			'fn' => '__return_empty_string',
		),
		'block:NuOpticaBlogCardsDisabled' => array(
			'fn' => '__return_empty_string',
		),
		'block:HasRelatedTags'            => array(
			'fn' => '__return_empty_string',
		),
		'block:RelatedTags'               => array(
			'fn' => '__return_empty_string',
		),
		'block:Twitter'                   => array(
			'fn' => 'tumblr3_block_twitter',
		),
		'block:LivePhoto'                 => array(
			'fn' => '__return_empty_string',
		),
		'block:NoFollowing'               => array(
			'fn' => '__return_empty_string',
		),
		'block:Blogs'                     => array(
			'fn' => '__return_empty_string',
		),
		'block:Permalink'                 => array(
			'fn' => 'tumblr3_block_permalinkpage',
		),
		'block:NotEnglish'                => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotGerman'                 => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotFrench'                 => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotItalian'                => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotJapanese'               => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotTurkish'                => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotSpanish'                => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotRussian'                => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotPolish'                 => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotPortuguesePT'           => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotPortugueseBR'           => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotDutch'                  => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotKorean'                 => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotChineseSimplified'      => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotChineseTraditional'     => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotChineseHK'              => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotIndonesian'             => array(
			'fn' => 'tumblr3_block_language_not',
		),
		'block:NotHindi'                  => array(
			'fn' => 'tumblr3_block_language_not',
		),
	)
);
