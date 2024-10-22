<?php

defined( 'ABSPATH' ) || exit;

return apply_filters(
	'tumblr3_tag_names',
	array(
		'Title'                   => array(
			'fn' => 'tumblr3_tag_title',
		),
		'Description'             => array(
			'fn' => 'tumblr3_tag_description',
		),
		'MetaDescription'         => array(
			'fn' => 'tumblr3_tag_metadescription',
		),
		'BlogURL'                 => array(
			'fn' => 'tumblr3_tag_blogurl',
		),
		'RSS'                     => array(
			'fn' => 'tumblr3_tag_rss',
		),
		'Favicon'                 => array(
			'fn' => 'tumblr3_tag_favicon',
		),
		'CustomCSS'               => array(
			'fn' => 'tumblr3_tag_customcss',
		),
		'PostTitle'               => array(
			'fn' => 'tumblr3_tag_posttitle',
		),
		'PostSummary'             => array(
			'fn' => 'tumblr3_tag_postsummary',
		),
		'PortraitURL'             => array(
			'fn' => 'tumblr3_tag_portraiturl',
		),
		'CopyrightYears'          => array(
			'fn' => 'tumblr3_tag_copyrightyears',
		),
		'TitleFont'               => array(
			'fn' => 'tumblr3_tag_titlefont',
		),
		'TitleFontWeight'         => array(
			'fn' => 'tumblr3_tag_titlefontweight',
		),
		'BackgroundColor'         => array(
			'fn' => 'tumblr3_tag_backgroundcolor',
		),
		'TitleColor'              => array(
			'fn' => 'tumblr3_tag_titlecolor',
		),
		'AccentColor'             => array(
			'fn' => 'tumblr3_tag_accentcolor',
		),
		'HeaderImage'             => array(
			'fn' => 'tumblr3_tag_headerimage',
		),
		'AvatarShape'             => array(
			'fn' => 'tumblr3_tag_avatarshape',
		),
		'PreviousPage'            => array(
			'fn' => 'tumblr3_tag_previouspage',
		),
		'NextPage'                => array(
			'fn' => 'tumblr3_tag_nextpage',
		),
		'CurrentPage'             => array(
			'fn' => 'tumblr3_tag_currentpage',
		),
		'TotalPages'              => array(
			'fn' => 'tumblr3_tag_totalpages',
		),
		'SubmitLabel'             => array(
			'fn' => 'tumblr3_tag_submitlabel',
		),
		'AskLabel'                => array(
			'fn' => 'tumblr3_tag_asklabel',
		),
		'PageNumber'              => array(
			'fn' => 'tumblr3_tag_pagenumber',
		),
		'URL'                     => array(
			'fn' => 'tumblr3_tag_url',
		),
		'Label'                   => array(
			'fn' => 'tumblr3_tag_label',
		),
		'PreviousPost'            => array(
			'fn' => 'tumblr3_tag_previouspost',
		),
		'NextPost'                => array(
			'fn' => 'tumblr3_tag_nextpost',
		),
		'PostType'                => array(
			'fn' => 'tumblr3_tag_posttype',
		),
		'Permalink'               => array(
			'fn' => 'tumblr3_tag_permalink',
		),
		'RelativePermalink'       => array(
			'fn' => 'tumblr3_tag_relativepermalink',
		),
		'ShortURL'                => array(
			'fn' => 'tumblr3_tag_shorturl',
		),
		'EmbedUrl'                => array(
			'fn' => 'tumblr3_tag_embedurl',
		),
		'PostID'                  => array(
			'fn' => 'tumblr3_tag_postid',
		),
		'TagsAsClasses'           => array(
			'fn' => 'tumblr3_tag_tagsasclasses',
		),
		'PostNotesURL'            => array(
			'fn' => 'tumblr3_tag_postnotesurl',
		),
		'NPF'                     => array(
			'fn' => 'tumblr3_tag_npf',
		),
		'PinnedPostLabel'         => array(
			'fn' => 'tumblr3_tag_pinnedpostlabel',
		),
		'ReblogParentName'        => array(
			'fn' => 'tumblr3_tag_reblogparentname',
		),
		'ReblogParentTitle'       => array(
			'fn' => 'tumblr3_tag_reblogparenttitle',
		),
		'ReblogParentURL'         => array(
			'fn' => 'tumblr3_tag_reblogparenturl',
		),
		'ReblogParentPortraitURL' => array(
			'fn' => 'tumblr3_tag_reblogparentportraiturl',
		),
		'ReblogRootName'          => array(
			'fn' => 'tumblr3_tag_reblogrootname',
		),
		'ReblogRootTitle'         => array(
			'fn' => 'tumblr3_tag_reblogroottitle',
		),
		'ReblogRootURL'           => array(
			'fn' => 'tumblr3_tag_reblogrooturl',
		),
		'ReblogRootPortraitURL'   => array(
			'fn' => 'tumblr3_tag_reblogrootportraiturl',
		),
		'Username'                => array(
			'fn' => 'tumblr3_tag_username',
		),
		'Body'                    => array(
			'fn' => 'tumblr3_tag_body',
		),
		'PhotoAlt'                => array(
			'fn' => 'tumblr3_tag_photoalt',
		),
		'Caption'                 => array(
			'fn' => 'tumblr3_tag_caption',
		),
		'LinkURL'                 => array(
			'fn' => 'tumblr3_tag_linkurl',
		),
		'LinkOpenTag'             => array(
			'fn' => 'tumblr3_tag_linkopentag',
		),
		'LinkCloseTag'            => array(
			'fn' => 'tumblr3_tag_linkclosetag',
		),
		'PhotoURL'                => array(
			'fn' => 'tumblr3_tag_photourl',
		),
		'PhotoWidth'              => array(
			'fn' => 'tumblr3_tag_photowidth',
		),
		'PhotoHeight'             => array(
			'fn' => 'tumblr3_tag_photoheight',
		),
		'PhotoURL-75sq'           => array(
			'fn' => 'tumblr3_tag_photourl_75sq',
		),
		'PhotoURL-HighRes'        => array(
			'fn' => 'tumblr3_tag_photourl_highres',
		),
		'PhotoWidth-HighRes'      => array(
			'fn' => 'tumblr3_tag_photowidth_highres',
		),
		'PhotoHeight-HighRes'     => array(
			'fn' => 'tumblr3_tag_photoheight_highres',
		),
		'Camera'                  => array(
			'fn' => 'tumblr3_tag_camera',
		),
		'Aperture'                => array(
			'fn' => 'tumblr3_tag_aperture',
		),
		'Exposure'                => array(
			'fn' => 'tumblr3_tag_exposure',
		),
		'FocalLength'             => array(
			'fn' => 'tumblr3_tag_focallength',
		),
		'PhotoURL-Panorama'       => array(
			'fn' => 'tumblr3_tag_photourl_panorama',
		),
		'PhotoWidth-Panorama'     => array(
			'fn' => 'tumblr3_tag_photowidth_panorama',
		),
		'PhotoHeight-Panorama'    => array(
			'fn' => 'tumblr3_tag_photoheight_panorama',
		),
		'Photoset'                => array(
			'fn' => 'tumblr3_tag_photoset',
		),
		'PhotoCount'              => array(
			'fn' => 'tumblr3_tag_photocount',
		),
		'PhotosetLayout'          => array(
			'fn' => 'tumblr3_tag_photosetlayout',
		),
		'Quote'                   => array(
			'fn' => 'tumblr3_tag_quote',
		),
		'Source'                  => array(
			'fn' => 'tumblr3_tag_source',
		),
		'Length'                  => array(
			'fn' => 'tumblr3_tag_length',
		),
		'Name'                    => array(
			'fn' => 'tumblr3_tag_name',
		),
		'Target'                  => array(
			'fn' => 'tumblr3_tag_target',
		),
		'Host'                    => array(
			'fn' => 'tumblr3_tag_host',
		),
		'Thumbnail'               => array(
			'fn' => 'tumblr3_tag_thumbnail',
		),
		'Thumbnail-HighRes'       => array(
			'fn' => 'tumblr3_tag_thumbnail_highres',
		),
		'Author'                  => array(
			'fn' => 'tumblr3_tag_author',
		),
		'Excerpt'                 => array(
			'fn' => 'tumblr3_tag_excerpt',
		),
		'Line'                    => array(
			'fn' => 'tumblr3_tag_line',
		),
		'UserNumber'              => array(
			'fn' => 'tumblr3_tag_usernumber',
		),
		'Alt'                     => array(
			'fn' => 'tumblr3_tag_alt',
		),
		'AudioEmbed'              => array(
			'fn' => 'tumblr3_tag_audioembed',
		),
		'AudioPlayer'             => array(
			'fn' => 'tumblr3_tag_audioplayer',
		),
		'RawAudioURL'             => array(
			'fn' => 'tumblr3_tag_rawaudiourl',
		),
		'PlayCount'               => array(
			'fn' => 'tumblr3_tag_playcount',
		),
		'FormattedPlayCount'      => array(
			'fn' => 'tumblr3_tag_formattedplaycount',
		),
		'PlayCountWithLabel'      => array(
			'fn' => 'tumblr3_tag_playcountwithlabel',
		),
		'ExternalAudioURL'        => array(
			'fn' => 'tumblr3_tag_externalaudiourl',
		),
		'AlbumArtURL'             => array(
			'fn' => 'tumblr3_tag_albumarturl',
		),
		'Artist'                  => array(
			'fn' => 'tumblr3_tag_artist',
		),
		'Album'                   => array(
			'fn' => 'tumblr3_tag_album',
		),
		'TrackName'               => array(
			'fn' => 'tumblr3_tag_trackname',
		),
		'Video'                   => array(
			'fn' => 'tumblr3_tag_video',
		),
		'VideoEmbed'              => array(
			'fn' => 'tumblr3_tag_videoembed',
		),
		'VideoThumbnailURL'       => array(
			'fn' => 'tumblr3_tag_videothumbnailurl',
		),
		'Question'                => array(
			'fn' => 'tumblr3_tag_question',
		),
		'Answer'                  => array(
			'fn' => 'tumblr3_tag_answer',
		),
		'Asker'                   => array(
			'fn' => 'tumblr3_tag_asker',
		),
		'AskerPortraitURL'        => array(
			'fn' => 'tumblr3_tag_askerportraiturl',
		),
		'Answerer'                => array(
			'fn' => 'tumblr3_tag_answerer',
		),
		'AnswererPortraitURL'     => array(
			'fn' => 'tumblr3_tag_answererportraiturl',
		),
		'Replies'                 => array(
			'fn' => 'tumblr3_tag_replies',
		),
		'DayOfMonth'              => array(
			'fn' => 'tumblr3_tag_dayofmonth',
		),
		'DayOfMonthWithZero'      => array(
			'fn' => 'tumblr3_tag_dayofmonthwithzero',
		),
		'DayOfWeek'               => array(
			'fn' => 'tumblr3_tag_dayofweek',
		),
		'ShortDayOfWeek'          => array(
			'fn' => 'tumblr3_tag_shortdayofweek',
		),
		'DayOfWeekNumber'         => array(
			'fn' => 'tumblr3_tag_dayofweeknumber',
		),
		'DayOfMonthSuffix'        => array(
			'fn' => 'tumblr3_tag_dayofmonthsuffix',
		),
		'DayOfYear'               => array(
			'fn' => 'tumblr3_tag_dayofyear',
		),
		'WeekOfYear'              => array(
			'fn' => 'tumblr3_tag_weekofyear',
		),
		'Month'                   => array(
			'fn' => 'tumblr3_tag_month',
		),
		'ShortMonth'              => array(
			'fn' => 'tumblr3_tag_shortmonth',
		),
		'MonthNumber'             => array(
			'fn' => 'tumblr3_tag_monthnumber',
		),
		'MonthNumberWithZero'     => array(
			'fn' => 'tumblr3_tag_monthnumberwithzero',
		),
		'Year'                    => array(
			'fn' => 'tumblr3_tag_year',
		),
		'ShortYear'               => array(
			'fn' => 'tumblr3_tag_shortyear',
		),
		'AmPm'                    => array(
			'fn' => 'tumblr3_tag_ampm',
		),
		'CapitalAmPm'             => array(
			'fn' => 'tumblr3_tag_capitalampm',
		),
		'12Hour'                  => array(
			'fn' => 'tumblr3_tag_12hour',
		),
		'24Hour'                  => array(
			'fn' => 'tumblr3_tag_24hour',
		),
		'12HourWithZero'          => array(
			'fn' => 'tumblr3_tag_12hourwithzero',
		),
		'24HourWithZero'          => array(
			'fn' => 'tumblr3_tag_24hourwithzero',
		),
		'Minutes'                 => array(
			'fn' => 'tumblr3_tag_minutes',
		),
		'Seconds'                 => array(
			'fn' => 'tumblr3_tag_seconds',
		),
		'Beats'                   => array(
			'fn' => 'tumblr3_tag_beats',
		),
		'Timestamp'               => array(
			'fn' => 'tumblr3_tag_timestamp',
		),
		'TimeAgo'                 => array(
			'fn' => 'tumblr3_tag_timeago',
		),
		'PostNotes'               => array(
			'fn' => 'tumblr3_tag_postnotes',
		),
		'NoteCount'               => array(
			'fn' => 'tumblr3_tag_notecount',
		),
		'NoteCountWithLabel'      => array(
			'fn' => 'tumblr3_tag_notecountwithlabel',
		),
		'Tag'                     => array(
			'fn' => 'tumblr3_tag_tag',
		),
		'URLSafeTag'              => array(
			'fn' => 'tumblr3_tag_urlsafetag',
		),
		'TagURL'                  => array(
			'fn' => 'tumblr3_tag_tagurl',
		),
		'TagURLChrono'            => array(
			'fn' => 'tumblr3_tag_tagurlchrono',
		),
		'SourceURL'               => array(
			'fn' => 'tumblr3_tag_sourceurl',
		),
		'BlackLogoURL'            => array(
			'fn' => 'tumblr3_tag_blacklogourl',
		),
		'LogoWidth'               => array(
			'fn' => 'tumblr3_tag_logowidth',
		),
		'LogoHeight'              => array(
			'fn' => 'tumblr3_tag_logoheight',
		),
		'SourceTitle'             => array(
			'fn' => 'tumblr3_tag_sourcetitle',
		),
		'Submitter'               => array(
			'fn' => 'tumblr3_tag_submitter',
		),
		'SubmitterURL'            => array(
			'fn' => 'tumblr3_tag_submitterurl',
		),
		'SubmitterPortraitURL'    => array(
			'fn' => 'tumblr3_tag_submitterportraiturl',
		),
		'GroupMemberName'         => array(
			'fn' => 'tumblr3_tag_groupmembername',
		),
		'GroupMemberTitle'        => array(
			'fn' => 'tumblr3_tag_groupmembertitle',
		),
		'GroupMemberURL'          => array(
			'fn' => 'tumblr3_tag_groupmemberurl',
		),
		'GroupMemberPortraitURL'  => array(
			'fn' => 'tumblr3_tag_groupmemberportraiturl',
		),
		'PostAuthorName'          => array(
			'fn' => 'tumblr3_tag_postauthorname',
		),
		'PostAuthorTitle'         => array(
			'fn' => 'tumblr3_tag_postauthortitle',
		),
		'PostAuthorURL'           => array(
			'fn' => 'tumblr3_tag_postauthorurl',
		),
		'PostAuthorPortraitURL'   => array(
			'fn' => 'tumblr3_tag_postauthorportraiturl',
		),
		'PreviousDayPage'         => array(
			'fn' => 'tumblr3_tag_previousdaypage',
		),
		'NextDayPage'             => array(
			'fn' => 'tumblr3_tag_nextdaypage',
		),
		'SearchQuery'             => array(
			'fn' => 'tumblr3_tag_searchquery',
		),
		'URLSafeSearchQuery'      => array(
			'fn' => 'tumblr3_tag_urlsafesearchquery',
		),
		'SearchResultCount'       => array(
			'fn' => 'tumblr3_tag_searchresultcount',
		),
		'FollowedName'            => array(
			'fn' => 'tumblr3_tag_followedname',
		),
		'FollowedTitle'           => array(
			'fn' => 'tumblr3_tag_followedtitle',
		),
		'FollowedURL'             => array(
			'fn' => 'tumblr3_tag_followedurl',
		),
		'FollowedPortraitURL'     => array(
			'fn' => 'tumblr3_tag_followedportraiturl',
		),
		'Likes'                   => array(
			'fn' => 'tumblr3_tag_likes',
		),
		'LikeButton'              => array(
			'fn' => 'tumblr3_tag_likebutton',
		),
		'ReblogButton'            => array(
			'fn' => 'tumblr3_tag_reblogbutton',
		),
		'MobileAppHeaders'        => array(
			'fn' => 'tumblr3_tag_mobileappheaders',
		),
		'PostTypographyStyles'    => array(
			'fn' => 'tumblr3_tag_posttypographystyles',
		),
		'CurrentState'            => array(
			'fn' => 'tumblr3_tag_currentstate',
		),
		'ExternalState'           => array(
			'fn' => 'tumblr3_tag_externalstate',
		),
		'ReblogURL'               => array(
			'fn' => 'tumblr3_tag_reblogurl',
		),
		'Positions'               => array(
			'fn' => 'tumblr3_tag_positions',
		),
		'TweetSummary'            => array(
			'fn' => 'tumblr3_tag_tweetsummary',
		),
		'MailSummary'             => array(
			'fn' => 'tumblr3_tag_mailsummary',
		),
		'NewPostStyles'           => array(
			'fn' => '__return_empty_string',
		),
		'TwitterUsername'         => array(
			'fn' => 'tumblr3_tag_twitterusername',
		),
		'PostBlogName'            => array(
			'fn' => 'tumblr3_tag_postblogname',
		),
		'LivePhotoURL'            => array(
			'fn' => 'tumblr3_tag_livephotourl',
		),
		'LivePhotoStillImageTime' => array(
			'fn' => 'tumblr3_tag_livephotostillimagetime',
		),
		'ShareString'             => array(
			'fn' => 'tumblr3_tag_sharestring',
		),
		'AudioPlayerWhite'        => array(
			'fn' => 'tumblr3_tag_audioplayerwhite',
		),
		'AudioPlayerBlack'        => array(
			'fn' => 'tumblr3_tag_audioplayerblack',
		),
	)
);
