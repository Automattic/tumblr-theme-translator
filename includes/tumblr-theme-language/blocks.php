<?php

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
			'fn' => 'tumblr3_block_postsummary',
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
			'fn' => 'tumblr3_block_submissionsenabled',
		),
		'block:AskEnabled'                => array(
			'fn' => 'tumblr3_block_askenabled',
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
			'fn' => 'tumblr3_block_panorama',
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
			'fn' => 'tumblr3_block_post1',
		),
		'block:Post2'                     => array(
			'fn' => 'tumblr3_block_post2',
		),
		'block:Post3'                     => array(
			'fn' => 'tumblr3_block_post3',
		),
		'block:Post4'                     => array(
			'fn' => 'tumblr3_block_post4',
		),
		'block:Post5'                     => array(
			'fn' => 'tumblr3_block_post5',
		),
		'block:Post6'                     => array(
			'fn' => 'tumblr3_block_post6',
		),
		'block:Post7'                     => array(
			'fn' => 'tumblr3_block_post7',
		),
		'block:Post8'                     => array(
			'fn' => 'tumblr3_block_post8',
		),
		'block:Post9'                     => array(
			'fn' => 'tumblr3_block_post9',
		),
		'block:Post10'                    => array(
			'fn' => 'tumblr3_block_post10',
		),
		'block:Post11'                    => array(
			'fn' => 'tumblr3_block_post11',
		),
		'block:Post12'                    => array(
			'fn' => 'tumblr3_block_post12',
		),
		'block:Post13'                    => array(
			'fn' => 'tumblr3_block_post13',
		),
		'block:Post14'                    => array(
			'fn' => 'tumblr3_block_post14',
		),
		'block:Post15'                    => array(
			'fn' => 'tumblr3_block_post15',
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
			'fn' => 'tumblr3_block_reblog',
		),
		'block:RebloggedFromReblog'       => array(
			'fn' => 'tumblr3_block_rebloggedfromreblog',
		),
		'block:NotReblog'                 => array(
			'fn' => 'tumblr3_block_notreblog',
		),
		'block:RebloggedFrom'             => array(
			'fn' => 'tumblr3_block_rebloggedfrom',
		),
		'block:Reblogs'                   => array(
			'fn' => 'tumblr3_block_reblogs',
		),
		'block:IsActive'                  => array(
			'fn' => 'tumblr3_block_isactive',
		),
		'block:IsDeactivated'             => array(
			'fn' => 'tumblr3_block_isdeactivated',
		),
		'block:HasPermalink'              => array(
			'fn' => 'tumblr3_block_haspermalink',
		),
		'block:HasAvatar'                 => array(
			'fn' => 'tumblr3_block_hasavatar',
		),
		'block:isOriginalEntry'           => array(
			'fn' => 'tumblr3_block_isoriginalentry',
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
			'fn' => 'tumblr3_block_host',
		),
		'block:Thumbnail'                 => array(
			'fn' => 'tumblr3_block_thumbnail',
		),
		'block:Description'               => array(
			'fn' => 'tumblr3_block_description',
		),
		'block:Author'                    => array(
			'fn' => 'tumblr3_block_author',
		),
		'block:Excerpt'                   => array(
			'fn' => 'tumblr3_block_excerpt',
		),
		'block:Lines'                     => array(
			'fn' => 'tumblr3_block_lines',
		),
		'block:Label'                     => array(
			'fn' => 'tumblr3_block_label',
		),
		'block:AudioEmbed'                => array(
			'fn' => 'tumblr3_block_audioembed',
		),
		'block:AudioPlayer'               => array(
			'fn' => 'tumblr3_block_audioplayer',
		),
		'block:PlayCount'                 => array(
			'fn' => 'tumblr3_block_playcount',
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
			'fn' => 'tumblr3_block_videothumbnails',
		),
		'block:Answerer'                  => array(
			'fn' => 'tumblr3_block_answerer',
		),
		'block:Date'                      => array(
			'fn' => 'tumblr3_block_body',
		),
		'block:NewDayDate'                => array(
			'fn' => 'tumblr3_block_newdaydate',
		),
		'block:SameDayDate'               => array(
			'fn' => 'tumblr3_block_samedaydate',
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
			'fn' => 'tumblr3_block_submission',
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
			'fn' => 'tumblr3_block_daypagination',
		),
		'block:PreviousDayPage'           => array(
			'fn' => 'tumblr3_block_previousdaypage',
		),
		'block:NextDayPage'               => array(
			'fn' => 'tumblr3_block_nextdaypage',
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
			'fn' => 'tumblr3_block_hasfeaturedtags',
		),
		'block:FeaturedTags'              => array(
			'fn' => 'tumblr3_block_featuredtags',
		),
		'block:Following'                 => array(
			'fn' => '__return_empty_string',
		),
		'block:Followed'                  => array(
			'fn' => '__return_empty_string',
		),
		'block:Likes'                     => array(
			'fn' => 'tumblr3_block_likes',
		),
		'block:NoLikes'                   => array(
			'fn' => 'tumblr3_block_nolikes',
		),
		'block:RelatedPosts'              => array(
			'fn' => 'tumblr3_block_relatedposts',
		),
		'block:AskPage'                   => array(
			'fn' => 'tumblr3_block_askpage',
		),
		'block:SubmitPage'                => array(
			'fn' => 'tumblr3_block_submitpage',
		),
		'block:LikesPage'                 => array(
			'fn' => 'tumblr3_block_likespage',
		),
		'block:FollowingPage'             => array(
			'fn' => 'tumblr3_block_followingpage',
		),
		'block:ShareFollowing'            => array(
			'fn' => 'tumblr3_block_sharefollowing',
		),
		'block:English'                   => array(
			'fn' => 'tumblr3_block_english',
		),
		'block:German'                    => array(
			'fn' => 'tumblr3_block_german',
		),
		'block:French'                    => array(
			'fn' => 'tumblr3_block_french',
		),
		'block:Italian'                   => array(
			'fn' => 'tumblr3_block_italian',
		),
		'block:Japanese'                  => array(
			'fn' => 'tumblr3_block_japanese',
		),
		'block:Turkish'                   => array(
			'fn' => 'tumblr3_block_turkish',
		),
		'block:Spanish'                   => array(
			'fn' => 'tumblr3_block_spanish',
		),
		'block:Russian'                   => array(
			'fn' => 'tumblr3_block_russian',
		),
		'block:Polish'                    => array(
			'fn' => 'tumblr3_block_polish',
		),
		'block:PortuguesePT'              => array(
			'fn' => 'tumblr3_block_portuguesept',
		),
		'block:PortugueseBR'              => array(
			'fn' => 'tumblr3_block_portuguesebr',
		),
		'block:Dutch'                     => array(
			'fn' => 'tumblr3_block_dutch',
		),
		'block:Korean'                    => array(
			'fn' => 'tumblr3_block_korean',
		),
		'block:ChineseSimplified'         => array(
			'fn' => 'tumblr3_block_chinesesimplified',
		),
		'block:ChineseTraditional'        => array(
			'fn' => 'tumblr3_block_chinesetraditional',
		),
		'block:ChineseHK'                 => array(
			'fn' => 'tumblr3_block_chinesehk',
		),
		'block:Indonesian'                => array(
			'fn' => 'tumblr3_block_indonesian',
		),
		'block:Hindi'                     => array(
			'fn' => 'tumblr3_block_hindi',
		),
		'block:StretchHeaderImage'        => array(
			'fn' => 'tumblr3_block_stretchheaderimage',
		),
		'block:NoStretchHeaderImage'      => array(
			'fn' => 'tumblr3_block_nostretchheaderimage',
		),
		'block:ShowAdsOnThisPage'         => array(
			'fn' => 'tumblr3_block_showadsonthispage',
		),
		'block:HasNoPermalink'            => array(
			'fn' => 'tumblr3_block_hasnopermalink',
		),
		'block:HasHighlightedPosts'       => array(
			'fn' => 'tumblr3_block_hashighlightedposts',
		),
		'block:HighlightedPosts'          => array(
			'fn' => 'tumblr3_block_highlightedposts',
		),
		'block:HasLikedPosts'             => array(
			'fn' => 'tumblr3_block_haslikedposts',
		),
		'block:LikedPosts'                => array(
			'fn' => 'tumblr3_block_likedposts',
		),
		'block:NewCta'                    => array(
			'fn' => 'tumblr3_block_newcta',
		),
		'block:Actions'                   => array(
			'fn' => 'tumblr3_block_actions',
		),
		'block:SupplyLogging'             => array(
			'fn' => 'tumblr3_block_supplylogging',
		),
		'block:NuOpticaBlogCardsEnabled'  => array(
			'fn' => 'tumblr3_block_nuopticablogcardsenabled',
		),
		'block:NuOpticaBlogCardsDisabled' => array(
			'fn' => 'tumblr3_block_nuopticablogcardsdisabled',
		),
		'block:HasRelatedTags'            => array(
			'fn' => 'tumblr3_block_hasrelatedtags',
		),
		'block:RelatedTags'               => array(
			'fn' => 'tumblr3_block_relatedtags',
		),
		'block:Twitter'                   => array(
			'fn' => 'tumblr3_block_twitter',
		),
		'block:LivePhoto'                 => array(
			'fn' => 'tumblr3_block_livephoto',
		),
		'block:NoFollowing'               => array(
			'fn' => 'tumblr3_block_nofollowing',
		),
		'block:Blogs'                     => array(
			'fn' => 'tumblr3_block_blogs',
		),
		'block:Permalink'                 => array(
			'fn' => 'tumblr3_block_permalinkpage',
		),
	)
);
