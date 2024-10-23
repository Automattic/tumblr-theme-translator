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
			'fn' => 'tumblr3_tag_title',
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
			'fn' => '__return_empty_string',
		),
		'AskLabel'                => array(
			'fn' => '__return_empty_string',
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
			'fn' => 'tumblr3_tag_url',
		),
		'RelativePermalink'       => array(
			'fn' => 'tumblr3_tag_url',
		),
		'ShortURL'                => array(
			'fn' => 'tumblr3_tag_url',
		),
		'EmbedUrl'                => array(
			'fn' => 'tumblr3_tag_url',
		),
		'PostID'                  => array(
			'fn' => 'tumblr3_tag_postid',
		),
		'TagsAsClasses'           => array(
			'fn' => 'tumblr3_tag_tagsasclasses',
		),
		'PostNotesURL'            => array(
			'fn' => '__return_empty_string',
		),
		'NPF'                     => array(
			'fn' => 'tumblr3_tag_npf',
		),
		'PinnedPostLabel'         => array(
			'fn' => 'tumblr3_tag_pinnedpostlabel',
		),
		'ReblogParentName'        => array(
			'fn' => '__return_empty_string',
		),
		'ReblogParentTitle'       => array(
			'fn' => '__return_empty_string',
		),
		'ReblogParentURL'         => array(
			'fn' => '__return_empty_string',
		),
		'ReblogParentPortraitURL' => array(
			'fn' => '__return_empty_string',
		),
		'ReblogRootName'          => array(
			'fn' => '__return_empty_string',
		),
		'ReblogRootTitle'         => array(
			'fn' => '__return_empty_string',
		),
		'ReblogRootURL'           => array(
			'fn' => '__return_empty_string',
		),
		'ReblogRootPortraitURL'   => array(
			'fn' => '__return_empty_string',
		),
		'Username'                => array(
			'fn' => '__return_empty_string',
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
			'fn' => 'tumblr3_tag_photourl',
		),
		'PhotoURL-HighRes'        => array(
			'fn' => 'tumblr3_tag_photourl',
		),
		'PhotoWidth-HighRes'      => array(
			'fn' => 'tumblr3_tag_photowidth',
		),
		'PhotoHeight-HighRes'     => array(
			'fn' => 'tumblr3_tag_photoheight',
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
			'fn' => '__return_empty_string',
		),
		'PhotoWidth-Panorama'     => array(
			'fn' => '__return_empty_string',
		),
		'PhotoHeight-Panorama'    => array(
			'fn' => '__return_empty_string',
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
			'fn' => 'tumblr3_tag_thumbnail',
		),
		'Author'                  => array(
			'fn' => '__return_empty_string',
		),
		'Excerpt'                 => array(
			'fn' => 'tumblr3_tag_excerpt',
		),
		'Line'                    => array(
			'fn' => '__return_empty_string',
		),
		'UserNumber'              => array(
			'fn' => '__return_empty_string',
		),
		'Alt'                     => array(
			'fn' => '__return_empty_string',
		),
		'AudioEmbed'              => array(
			'fn' => 'tumblr3_tag_audioplayer',
		),
		'AudioPlayer'             => array(
			'fn' => 'tumblr3_tag_audioplayer',
		),
		'RawAudioURL'             => array(
			'fn' => 'tumblr3_tag_externalaudiourl',
		),
		'PlayCount'               => array(
			'fn' => '__return_empty_string',
		),
		'FormattedPlayCount'      => array(
			'fn' => '__return_empty_string',
		),
		'PlayCountWithLabel'      => array(
			'fn' => '__return_empty_string',
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
			'fn' => 'tumblr3_tag_video',
		),
		'VideoThumbnailURL'       => array(
			'fn' => 'tumblr3_tag_videothumbnailurl',
		),
		'Question'                => array(
			'fn' => '__return_empty_string',
		),
		'Answer'                  => array(
			'fn' => '__return_empty_string',
		),
		'Asker'                   => array(
			'fn' => '__return_empty_string',
		),
		'AskerPortraitURL'        => array(
			'fn' => '__return_empty_string',
		),
		'Answerer'                => array(
			'fn' => '__return_empty_string',
		),
		'AnswererPortraitURL'     => array(
			'fn' => '__return_empty_string',
		),
		'Replies'                 => array(
			'fn' => '__return_empty_string',
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
		'PostNotes-16'            => array(
			'fn' => 'tumblr3_tag_postnotes',
		),
		'PostNotes-64'            => array(
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
			'fn' => 'tumblr3_tag_tagurl',
		),
		'SourceURL'               => array(
			'fn' => '__return_empty_string',
		),
		'BlackLogoURL'            => array(
			'fn' => '__return_empty_string',
		),
		'LogoWidth'               => array(
			'fn' => '__return_empty_string',
		),
		'LogoHeight'              => array(
			'fn' => '__return_empty_string',
		),
		'SourceTitle'             => array(
			'fn' => '__return_empty_string',
		),
		'Submitter'               => array(
			'fn' => '__return_empty_string',
		),
		'SubmitterURL'            => array(
			'fn' => '__return_empty_string',
		),
		'SubmitterPortraitURL'    => array(
			'fn' => '__return_empty_string',
		),
		'GroupMemberName'         => array(
			'fn' => 'tumblr3_tag_groupmembername',
		),
		'GroupMemberTitle'        => array(
			'fn' => 'tumblr3_tag_postauthortitle',
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
			'fn' => '__return_empty_string',
		),
		'NextDayPage'             => array(
			'fn' => '__return_empty_string',
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
			'fn' => '__return_empty_string',
		),
		'FollowedTitle'           => array(
			'fn' => '__return_empty_string',
		),
		'FollowedURL'             => array(
			'fn' => '__return_empty_string',
		),
		'FollowedPortraitURL'     => array(
			'fn' => '__return_empty_string',
		),
		'Likes'                   => array(
			'fn' => '__return_empty_string',
		),
		'LikeButton'              => array(
			'fn' => '__return_empty_string',
		),
		'ReblogButton'            => array(
			'fn' => '__return_empty_string',
		),
		'MobileAppHeaders'        => array(
			'fn' => '__return_empty_string',
		),
		'PostTypographyStyles'    => array(
			'fn' => '__return_empty_string',
		),
		'CurrentState'            => array(
			'fn' => 'tumblr3_tag_currentstate',
		),
		'ExternalState'           => array(
			'fn' => 'tumblr3_tag_currentstate',
		),
		'ReblogURL'               => array(
			'fn' => '__return_empty_string',
		),
		'Positions'               => array(
			'fn' => '__return_empty_string',
		),
		'TweetSummary'            => array(
			'fn' => 'tumblr3_tag_tweetsummary',
		),
		'MailSummary'             => array(
			'fn' => 'tumblr3_tag_tweetsummary',
		),
		'NewPostStyles'           => array(
			'fn' => '__return_empty_string',
		),
		'TwitterUsername'         => array(
			'fn' => 'tumblr3_tag_twitterusername',
		),
		'PostBlogName'            => array(
			'fn' => 'tumblr3_tag_postauthortitle',
		),
		'LivePhotoURL'            => array(
			'fn' => '__return_empty_string',
		),
		'LivePhotoStillImageTime' => array(
			'fn' => '__return_empty_string',
		),
		'ShareString'             => array(
			'fn' => 'tumblr3_tag_excerpt',
		),
		'AudioPlayerWhite'        => array(
			'fn' => 'tumblr3_tag_audioplayer',
		),
		'AudioPlayerBlack'        => array(
			'fn' => 'tumblr3_tag_audioplayer',
		),
	)
);
