<?php

//////////////////////////////////////////////////////////////
//===========================================================
// mysql.php(Setup)
//===========================================================
// AEF : Advanced Electron Forum 
// Version : 1.0.9
// Inspired by Pulkit and taken over by Electron
// ----------------------------------------------------------
// Started by: Electron, Ronak Gupta, Pulkit Gupta
// Date:       23rd Jan 2006
// Time:       15:00 hrs
// Site:       http://www.anelectron.com/ (Anelectron)
// ----------------------------------------------------------
// Please Read the Terms of use at http://www.anelectron.com
// ----------------------------------------------------------
//===========================================================
// (C)AEF Group All Rights Reserved.
//===========================================================
//////////////////////////////////////////////////////////////


$queries = array();


//$queries[] = "";

if (!empty($utf8)) {

    $queries[] = "ALTER DATABASE " . $database . "
                            CHARACTER SET utf8
                            DEFAULT CHARACTER SET utf8
                            COLLATE utf8_general_ci
                            DEFAULT COLLATE utf8_general_ci";
}

//Apps - Applications #1
$queries[] = "CREATE TABLE " . $dbprefix . "apps (
  `apid` mediumint(8) NOT NULL auto_increment,
  `ap_name` varchar(100) NOT NULL default '',
  `ap_version` varchar(15) NOT NULL default '',
  `installed_time` int(10) NOT NULL default '0',
  `ap_info` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`apid`)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");


//Apps Registry - Applications Registry #2
$queries[] = "CREATE TABLE " . $dbprefix . "apps_registry (
  `apid` mediumint(8) NOT NULL default '0',
  `uid` mediumint(8) NOT NULL default '0',
  `apps_registry` text NOT NULL,
  UNIQUE KEY `apid` (`apid`,`uid`)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");


//Attachment Mimetypes #3
$queries[] = "CREATE TABLE " . $dbprefix . "attachment_mimetypes (
  atmtid smallint(5) NOT NULL auto_increment,
  atmt_ext varchar(20) NOT NULL default '',
  atmt_mimetype varchar(255) NOT NULL default '',
  atmt_icon tinytext NOT NULL,
  atmt_posts tinyint(2) NOT NULL default '0',
  atmt_avatar tinyint(2) NOT NULL default '0',
  atmt_isimage tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (atmtid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Data for Attacment Mimetypes #4
$queries[] = "INSERT INTO " . $dbprefix . "attachment_mimetypes VALUES (1, 'png', 'image/png', 'png.png', 1, 1, 1)";
$queries[] = "INSERT INTO " . $dbprefix . "attachment_mimetypes VALUES (2, 'jpg', 'image/jpeg', 'jpg.png', 1, 1, 1)"; #5
$queries[] = "INSERT INTO " . $dbprefix . "attachment_mimetypes VALUES (3, 'gif', 'image/gif', 'gif.png', 1, 1, 1)"; #6
$queries[] = "INSERT INTO " . $dbprefix . "attachment_mimetypes VALUES (4, 'bmp', 'image/bitmap', 'bmp.png', 1, 1, 1)"; #7
$queries[] = "INSERT INTO " . $dbprefix . "attachment_mimetypes VALUES (5, 'tiff', 'image/tiff', 'tiff.png', 1, 1, 1)"; #8
$queries[] = "INSERT INTO " . $dbprefix . "attachment_mimetypes VALUES (6, 'txt', 'plain/text', 'txt.png', 1, 0, 0)"; #9
$queries[] = "INSERT INTO " . $dbprefix . "attachment_mimetypes VALUES (7, 'jpeg', 'image/jpeg', 'jpg.png', 1, 1, 1)"; #10
$queries[] = "INSERT INTO " . $dbprefix . "attachment_mimetypes VALUES (8, 'doc', 'application/msword', 'doc.png', 1, 0, 0)"; #11
$queries[] = "INSERT INTO " . $dbprefix . "attachment_mimetypes VALUES (9, 'mpg', 'video/mpeg', 'mpg.png', 1, 0, 0)"; #12
$queries[] = "INSERT INTO " . $dbprefix . "attachment_mimetypes VALUES (10, 'zip', 'application/zip', 'zip.png', 1, 0, 0)"; #13
//Attachments #14
$queries[] = "CREATE TABLE " . $dbprefix . "attachments (
  atid mediumint(8) NOT NULL auto_increment,
  at_original_file tinytext NOT NULL,
  at_file tinytext NOT NULL,
  at_mimetype_id smallint(5) NOT NULL default '0',
  at_size int(10) NOT NULL default '0',
  at_fid smallint(5) NOT NULL default '0',
  at_pid int(10) NOT NULL default '0',
  at_downloads int(10) NOT NULL default '0',
  at_time int(10) NOT NULL default '0',
  at_mid mediumint(8) NOT NULL default '0',
  at_width smallint(5) NOT NULL default '0',
  at_height smallint(5) NOT NULL default '0',
  PRIMARY KEY  (atid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Categories #15
$queries[] = "CREATE TABLE " . $dbprefix . "categories (
  cid smallint(5) NOT NULL auto_increment,
  name tinytext NOT NULL,
  `order` smallint(5) NOT NULL default '0',
  collapsable tinyint(2) NOT NULL default '1',
  PRIMARY KEY  (cid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

$queries[] = "INSERT INTO " . $dbprefix . "categories VALUES (1, 'General Stuff', 1, 1)";

//Errors #16
$queries[] = "CREATE TABLE " . $dbprefix . "errors (
  type tinyint(3) NOT NULL default '0',
  id mediumint(5) NOT NULL default '0'
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Forum Permissions #17
$queries[] = "CREATE TABLE " . $dbprefix . "forumpermissions (
  fpfid smallint(5) NOT NULL default '0',
  fpugid mediumint(5) NOT NULL default '0',
  can_post_topic tinyint(2) NOT NULL default '0',
  can_reply tinyint(2) NOT NULL default '0',
  can_vote_polls tinyint(2) NOT NULL default '0',
  can_post_polls tinyint(2) NOT NULL default '0',
  can_attach tinyint(2) NOT NULL default '0',
  can_view_attach tinyint(2) NOT NULL default '0',
  UNIQUE KEY fpfid (fpfid,fpugid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Forums #18
$queries[] = "CREATE TABLE " . $dbprefix . "forums (
  `fid` smallint(5) NOT NULL auto_increment,
  `cat_id` smallint(5) NOT NULL default '0',
  `par_board_id` smallint(5) NOT NULL default '0',
  `forum_order` smallint(5) NOT NULL default '0',
  `member_group` tinytext NOT NULL,
  `fname` tinytext NOT NULL,
  `description` tinytext NOT NULL,
  `fimage` tinytext NOT NULL,
  `fredirect` tinytext NOT NULL,
  `ntopic` mediumint(8) NOT NULL default '0',
  `nposts` mediumint(8) NOT NULL default '0',
  `status` tinyint(3) NOT NULL default '1',
  `prune` tinyint(3) NOT NULL default '0',
  `allow_poll` tinyint(2) NOT NULL default '0',
  `allow_html` tinyint(2) NOT NULL default '0',
  `id_skin` smallint(5) NOT NULL default '0',
  `override_skin` tinyint(2) NOT NULL default '0',
  `inc_mem_posts` tinyint(2) NOT NULL default '1',
  `quick_reply` tinyint(2) NOT NULL default '0',
  `quick_topic` tinyint(2) NOT NULL default '0',
  `f_last_pid` int(10) NOT NULL default '0',
  `frulestitle` tinytext NOT NULL,
  `frules` text NOT NULL,
  `mod_topics` tinyint(2) NOT NULL default '0',
  `mod_posts` tinyint(2) NOT NULL default '0',
  `rss` int(4) NOT NULL default '0',
  `rss_topic` int(4) NOT NULL default '0',
  PRIMARY KEY  (`fid`)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

$queries[] = "INSERT INTO " . $dbprefix . "forums VALUES (1, 1, 0, 1, '-1,0,2,3', 'Generals', 'Talk about anything you like in general!', '', '', 1, 1, 1, 0, 1, 1, 0, 0, 1, 0, 0, '', '', 0, 0, 10, 10, '')"; #20
//Forgot Passwords #21
$queries[] = "CREATE TABLE " . $dbprefix . "fpass (
  fpuid mediumint(8) NOT NULL default '0',
  resetcode varchar(10) NOT NULL default '',
  fptime int(10) NOT NULL default '0',
  UNIQUE KEY fpuid (fpuid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Marked read topics and forums
$queries[] = "CREATE TABLE " . $dbprefix . "mark_read (
  mr_uid mediumint(8) NOT NULL default '0',
  mr_fid smallint(5) NOT NULL default '0',
  mr_time int(10) NOT NULL default '0',
  UNIQUE KEY mr_uid (mr_uid,mr_fid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Moderators
$queries[] = "CREATE TABLE " . $dbprefix . "moderators (
  mod_mem_id mediumint(8) NOT NULL default '0',
  mod_fid smallint(5) NOT NULL default '0',
  UNIQUE KEY mod_mem_id (mod_mem_id,mod_fid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//News
$queries[] = "CREATE TABLE " . $dbprefix . "news (
  `nid` mediumint(8) NOT NULL auto_increment,
  `uid` mediumint(8) NOT NULL default '0',
  `title` tinytext NOT NULL,
  `news` text NOT NULL,
  `time` int(12) NOT NULL default '0',
  `image` tinytext NOT NULL,
  `fullstorylink` tinytext NOT NULL,
  `approved` tinyint(2) NOT NULL default '0',
  `showinticker` int(10) NOT NULL default '0',
  PRIMARY KEY  (`nid`)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Forum Notifications
$queries[] = "CREATE TABLE " . $dbprefix . "notify_forum (
  notify_mid mediumint(8) NOT NULL default '0',
  notify_fid smallint(5) NOT NULL default '0',
  UNIQUE KEY notify_mid (notify_mid,notify_fid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Topic Notifications
$queries[] = "CREATE TABLE " . $dbprefix . "notify_topic (
  notify_mid mediumint(8) NOT NULL default '0',
  notify_tid mediumint(8) NOT NULL default '0',
  UNIQUE KEY notify_mid (notify_mid,notify_tid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Permissions
$queries[] = "CREATE TABLE " . $dbprefix . "permissions (
  `member_group_id` mediumint(8) NOT NULL default '0',
  `view_forum` tinyint(2) NOT NULL default '0',
  `can_post_topic` tinyint(2) NOT NULL default '0',
  `can_reply` tinyint(2) NOT NULL default '0',
  `can_edit_own_topic` tinyint(2) NOT NULL default '0',
  `can_edit_other_topic` tinyint(2) NOT NULL default '0',
  `can_edit_own` tinyint(2) NOT NULL default '0',
  `can_edit_other` tinyint(2) NOT NULL default '0',
  `approve_topics` tinyint(2) NOT NULL default '0',
  `approve_posts` tinyint(2) NOT NULL default '0',
  `can_del_own_post` tinyint(2) NOT NULL default '0',
  `can_del_other_post` tinyint(2) NOT NULL default '0',
  `can_search` tinyint(2) NOT NULL default '0',
  `can_email_mem` tinyint(2) NOT NULL default '0',
  `can_email_friend` tinyint(2) NOT NULL default '0',
  `can_edit_own_profile` tinyint(2) NOT NULL default '0',
  `can_edit_other_profile` tinyint(2) NOT NULL default '0',
  `can_del_own_account` tinyint(2) NOT NULL default '0',
  `can_del_other_account` tinyint(2) NOT NULL default '0',
  `can_ban_user` tinyint(2) NOT NULL default '0',
  `can_del_own_topic` tinyint(2) NOT NULL default '0',
  `can_del_other_topic` tinyint(2) NOT NULL default '0',
  `can_view_poll` tinyint(2) NOT NULL default '0',
  `can_vote_polls` tinyint(2) NOT NULL default '0',
  `can_post_polls` tinyint(2) NOT NULL default '0',
  `can_edit_other_poll` tinyint(2) NOT NULL default '0',
  `can_edit_own_poll` tinyint(2) NOT NULL default '0',
  `add_poll_topic_own` tinyint(2) NOT NULL default '0',
  `add_poll_topic_other` tinyint(2) NOT NULL default '0',
  `can_rem_own_poll` tinyint(2) NOT NULL default '0',
  `can_rem_other_poll` tinyint(2) NOT NULL default '0',
  `can_merge_topics` tinyint(2) NOT NULL default '0',
  `can_merge_posts` tinyint(2) NOT NULL default '0',
  `can_split_topics` tinyint(2) NOT NULL default '0',
  `can_email_topic` tinyint(2) NOT NULL default '0',
  `can_make_sticky` tinyint(2) NOT NULL default '0',
  `can_move_own_topic` tinyint(2) NOT NULL default '0',
  `can_move_other_topic` tinyint(2) NOT NULL default '0',
  `can_lock_own_topic` tinyint(2) NOT NULL default '0',
  `can_lock_other_topic` tinyint(2) NOT NULL default '0',
  `can_announce_topic` tinyint(2) NOT NULL default '0',
  `can_report_post` tinyint(2) NOT NULL default '0',
  `can_report_pm` tinyint(2) NOT NULL default '0',
  `prefix` varchar(80) NOT NULL default '',
  `suffix` varchar(80) NOT NULL default '',
  `can_attach` tinyint(2) NOT NULL default '0',
  `can_view_attach` tinyint(2) NOT NULL default '0',
  `can_remove_attach` tinyint(2) NOT NULL default '0',
  `max_attach` mediumint(8) NOT NULL default '0',
  `notify_new_posts` tinyint(2) NOT NULL default '0',
  `notify_new_topics` tinyint(2) NOT NULL default '0',
  `use_avatar` tinyint(2) NOT NULL default '0',
  `url_avatar` tinyint(2) NOT NULL default '0',
  `upload_avatar` tinyint(2) NOT NULL default '0',
  `hide_online` tinyint(2) NOT NULL default '0',
  `view_active` tinyint(2) NOT NULL default '0',
  `view_anonymous` tinyint(2) NOT NULL default '0',
  `allow_html` tinyint(2) NOT NULL default '0',
  `has_priviliges` tinyint(2) NOT NULL default '0',
  `view_ip` tinyint(2) NOT NULL default '0',
  `can_admin` tinyint(2) NOT NULL default '0',
  `can_use_pm` tinyint(2) NOT NULL default '0',
  `max_stored_pm` mediumint(8) NOT NULL default '0',
  `max_mass_pm` mediumint(8) NOT NULL default '0',
  `view_offline_board` tinyint(2) NOT NULL default '0',
  `can_view_profile` tinyint(2) NOT NULL default '0',
  `view_members` tinyint(2) NOT NULL default '0',
  `view_stats` tinyint(2) NOT NULL default '0',
  `can_submit_news` tinyint(2) NOT NULL default '0',
  `can_approve_news` tinyint(2) NOT NULL default '0',
  `can_edit_news` tinyint(2) NOT NULL default '0',
  `can_delete_news` tinyint(2) NOT NULL default '0',
  `group_message` text NOT NULL,
  `can_shout` tinyint(2) NOT NULL default '0',
  `can_del_shout` tinyint(2) NOT NULL default '0',  
  `view_calendar` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`member_group_id`)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

$queries[] = "INSERT INTO " . $dbprefix . "permissions VALUES (-1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '', 0, 0, 1)";
$queries[] = "INSERT INTO " . $dbprefix . "permissions VALUES (1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '', '', 1, 1, 1, 50000, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, '', 1, 1, 1)";
$queries[] = "INSERT INTO " . $dbprefix . "permissions VALUES (3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '', '', 1, 1, 1, 2048, 1, 1, 1, 1, 1, 1, 1, 0, 0, 1, 1, 0, 1, 150, 0, 0, 1, 1, 1, 1, 0, 0, 0, '', 1, 0, 1)";
$queries[] = "INSERT INTO " . $dbprefix . "permissions VALUES (2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, '', '', 1, 1, 1, 2048, 1, 1, 1, 1, 1, 1, 1, 1, 0, 1, 1, 0, 1, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, '', 1, 1, 1)";
$queries[] = "INSERT INTO " . $dbprefix . "permissions VALUES (-3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', 0, 0, 1)";
$queries[] = "INSERT INTO " . $dbprefix . "permissions VALUES (0, 1, 1, 1, 1, 0, 1, 0, 0, 0, 0, 0, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 1, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1, '', '', 1, 1, 0, 1024, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 1, 200, 5, 0, 1, 1, 1, 1, 0, 0, 0, '', 1, 0, 1)";

//Plugins
$queries[] = "CREATE TABLE " . $dbprefix . "plugins (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plg_name` text COLLATE utf8_unicode_ci NOT NULL,
  `activated` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Personal Messages
$queries[] = "CREATE TABLE " . $dbprefix . "pm (
  pmid mediumint(8) NOT NULL auto_increment,
  pm_from mediumint(8) NOT NULL default '0',
  pm_to mediumint(8) NOT NULL default '0',
  pm_time int(10) NOT NULL default '0',
  pm_read_time int(10) NOT NULL default '0',
  pm_folder tinyint(2) NOT NULL default '0',
  pm_subject tinytext NOT NULL,
  pm_body text NOT NULL,
  pm_track tinyint(2) NOT NULL default '0',
  pm_to_text tinytext NOT NULL,
  PRIMARY KEY  (pmid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Poll Options
$queries[] = "CREATE TABLE " . $dbprefix . "poll_options (
  pooid mediumint(10) NOT NULL auto_increment,
  poo_poid mediumint(8) NOT NULL default '0',
  poo_option tinytext NOT NULL,
  poo_votes smallint(5) NOT NULL default '0',
  PRIMARY KEY  (pooid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Voters
$queries[] = "CREATE TABLE " . $dbprefix . "poll_voters (
  pv_mid mediumint(8) NOT NULL default '0',
  pv_pooid mediumint(10) NOT NULL default '0',
  pv_poid mediumint(8) NOT NULL default '0',
  UNIQUE KEY pv_mid (pv_mid,pv_pooid,pv_poid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Polls
$queries[] = "CREATE TABLE " . $dbprefix . "polls (
  poid mediumint(8) NOT NULL auto_increment,
  poll_qt tinytext NOT NULL,
  poll_mid mediumint(8) NOT NULL default '0',
  poll_locked tinyint(2) NOT NULL default '0',
  poll_tid mediumint(8) NOT NULL default '0',
  poll_expiry int(10) NOT NULL default '0',
  poll_change_vote tinyint(2) NOT NULL default '0',
  poll_started int(10) NOT NULL default '0',
  poll_show_when tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (poid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Posts
$queries[] = "CREATE TABLE " . $dbprefix . "posts (
  `pid` int(10) NOT NULL auto_increment,
  `post_tid` mediumint(8) NOT NULL default '0',
  `p_top_sticky` tinyint(2) NOT NULL default '0',
  `post_fid` smallint(5) NOT NULL default '0',
  `ptime` int(10) NOT NULL default '0',
  `poster_id` mediumint(8) NOT NULL default '0',
  `poster_ip` varchar(20) NOT NULL default '',
  `modtime` int(10) NOT NULL default '0',
  `modifiers_id` mediumint(8) NOT NULL default '0',
  `post` text NOT NULL,
  `use_smileys` tinyint(2) NOT NULL default '1',
  `gposter_name` varchar(80) NOT NULL default '',
  `gposter_email` varchar(80) NOT NULL default '',
  `post_title` varchar(255) NOT NULL default '',
  `num_attachments` tinyint(4) NOT NULL default '0',
  `par_id` int(10) NOT NULL default '0',
  `p_approved` tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (`pid`)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

$queries[] = "INSERT INTO " . $dbprefix . "posts VALUES (1, 1, 0, 1, " . time() . ", -1, '', 0, 0, 'Hi,\r\n\r\n    We would like to thank you for using AEF.\r\nIf you need any assistance  :??:  , feel free to ask us for help at the [url=http://www.anelectron.com/board/]support board[/url].\r\n\r\nThanks and enjoy AEF!!!  ;-D \r\n\r\n', 1, 'AEF Team', 'aef@anelectron.com', '', 0, 0, 1)";

//Marked Board read
$queries[] = "CREATE TABLE " . $dbprefix . "read_board (
  rb_uid mediumint(8) NOT NULL default '0',
  rb_time int(12) NOT NULL default '0',
  UNIQUE KEY rb_uid (rb_uid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Read Forums
$queries[] = "CREATE TABLE " . $dbprefix . "read_forums (
  rf_uid mediumint(8) NOT NULL default '0',
  rf_fid smallint(5) NOT NULL default '0',
  rf_time int(10) NOT NULL default '0',
  UNIQUE KEY rf_uid (rf_uid,rf_fid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Read Topics
$queries[] = "CREATE TABLE " . $dbprefix . "read_topics (
  rt_uid mediumint(8) NOT NULL default '0',
  rt_tid smallint(5) NOT NULL default '0',
  rt_time int(10) NOT NULL default '0',
  UNIQUE KEY rt_uid (rt_uid,rt_tid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//AEF Registry
$queries[] = "CREATE TABLE " . $dbprefix . "registry (
  name varchar(255) NOT NULL default '',
  regval text NOT NULL,
  UNIQUE KEY name (name)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('reserved_names', 'admin\r\nwebmaster\r\nmaster\r\nuser\r\nlocalhost\r\nlord')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('latest_mem', '" . $ad_username . "|1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('num_mem', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('recyclebin', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('mostactive', '1|" . time() . "')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxtopics', '30')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxpostsintopics', '15')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxreplyhot', '15')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxreplyveryhot', '25')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('disableshoutingtopics', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('disableshoutingdesc', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('prenextopic', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('warnoldtopic', '120')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('prefixsticky', 'Sticky:')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('prefixmoved', 'Moved:')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('prefixpolls', 'Poll:')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxtitlechars', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('mintitlechars', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxdescchars', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('mindescchars', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('allow_taf', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxcharposts', '20000')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('mincharposts', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('timepostfromuser', '10')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxemotpost', '15')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maximgspost', '15')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('allowdynimg', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maximgwidthpost', '300')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maximgheightpost', '300')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('removenestedquotes', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('attachsigtopost', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('embedflashinpost', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxflashpost', '5')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxflashwidthinpost', '300')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxflashheightinpost', '300')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('enablepolls', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxpollsintopic', '3')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxoptionspoll', '10')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxpollqtlen', '100')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('censor_words_from', '')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('censor_words_to', '')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maintenance', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('censor_words_case', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('parsebbc', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('autolink', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_hr', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_b', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_i', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_u', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_s', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_left', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_right', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_center', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_size', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_font', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_sup', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_sub', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_color', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_url', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_ftp', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_email', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_img', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_flash', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_code', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_quote', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_php', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_ul', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_ol', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bbc_parseHTML', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('reg_method', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('allow_reg', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('wel_email', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('reg_notify', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('max_pass', '20')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('max_uname', '20')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('min_pass', '4')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('min_uname', '4')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('sec_conf', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('samepc_reg', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('age_limit', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('age_rest_act', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('age_rest_act_address', '')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('age_rest_act_fax', '')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('age_rest_act_tele', '')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('reserved_match_whole', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('reserved_match_insensitive', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('login_failed', '5')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('anon_login', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('fpass_sec_conf', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('userstextlen', '100')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('wwwlen', '150')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('customtitlelen', '30')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('locationlen', '100')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('realnamelen', '100')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('secretqtlen', '200')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('secretansmaxlen', '20')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('secretansminlen', '4')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('usersiglen', '200')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('showavatars', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('avatardir', '" . $server_url . "/avatars')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('avatarurl', '" . $url . "/avatars')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('uploadavatardir', '" . $server_url . "/uploads/avatars')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('uploadavatarurl', '" . $url . "/uploads/avatars')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('uploadavatarmaxsize', '5000')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('avatartypes', 'gif,jpg,png')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('uploadppicdir', '" . $server_url . "/uploads/personalpic')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('uploadppicurl', '" . $url . "/uploads/personalpic')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('uploadppicmaxsize', '5000')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('ppictypes', 'gif,jpg,png,tiff')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('pmon', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('notifynewpm', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('pmusesmileys', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('pmnumshowinfolders', '50')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('pmsaveinsentitems', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('attachmentmode', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('allownewattachment', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('attachmentdir', '" . $server_url . "/uploads/attachments')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxattachmentpost', '3')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxattachsize', '150')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxattachsizepost', '250')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('attachmentshowimage', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('attachmentshowimagemaxwidth', '200')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('attachmentshowimagemaxheight', '200')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('attachmenturl', '" . $url . "/uploads/attachments')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('usesmileys', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maintenance_subject', '')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maintenance_message', '')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('mail', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('mail_user', '')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('mail_pass', '')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('mail_server', '')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('mail_port', '')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('notifications', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('numsubinpage', '30')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('session_timeout', '3600')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('last_active_span', '15')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('only_users', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('stats', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('memhideemail', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('showmemdetails', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxactivelist', '50')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('maxmemberlist', '50')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('theme', 'default')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('theme_id', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('choose_theme', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('version', '1.1.0 preview')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('enablenews', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('enableshoutbox', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('shouts', '10')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('shoutboxtime', '1440')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('countinboardposts', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('subscribeauto', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('enablesig', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('showimgs', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('shoutbox_emot', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('shoutbox_nbbc', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('shoutbox_sbbc', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('language', 'english')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('choose_language', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('smiley_space_boundary', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('users_visited_today', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('av_width', '90')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('av_height', '90')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('ppic_width', '90')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('ppic_height', '90')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('last_posts_reply', '10')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('recent_posts', '8')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('who_read_topic', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('show_groups', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('change_username', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('rss_recent', '10')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('smart_redirect', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('report_posts', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('charset', '" . (empty($utf8) ? 'ISO-8859-1' : 'UTF-8') . "')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('title_in_link', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('seo', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('timezone', '0')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('tickednews', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('todaysnews', '1')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('newsperpage', '12')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('bannedip', '')";
$queries[] = "INSERT INTO " . $dbprefix . "registry VALUES ('keywords', '')";

//Sessions
$queries[] = "CREATE TABLE " . $dbprefix . "sessions (
  sid varchar(32) NOT NULL default '',
  uid mediumint(8) NOT NULL default '0',
  time int(12) NOT NULL default '0',
  data text NOT NULL,
  ip varchar(20) NOT NULL default '',
  last_activity tinytext NOT NULL,
  activity text NOT NULL,
  viewing_board smallint(5) NOT NULL default '0',
  viewing_topic mediumint(8) NOT NULL default '0',
  anonymous tinyint(2) NOT NULL default '0',
  UNIQUE KEY sid (sid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Shouts
$queries[] = "CREATE TABLE " . $dbprefix . "shouts (
  shid int(10) NOT NULL auto_increment,
  shtime int(10) NOT NULL default '0',
  shuid mediumint(8) NOT NULL default '0',
  shtext text NOT NULL,
  shucolor text NOT NULL,
  PRIMARY KEY  (shid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Smileys
$queries[] = "CREATE TABLE " . $dbprefix . "smileys (
  smid smallint(5) NOT NULL auto_increment,
  smcode varchar(40) NOT NULL default '',
  smfile varchar(40) NOT NULL default '',
  smtitle varchar(40) NOT NULL default '',
  smorder smallint(5) NOT NULL default '0',
  smstatus tinyint(2) NOT NULL default '0',
  smfolder varchar(70) NOT NULL default '',
  PRIMARY KEY  (smid),
  UNIQUE KEY smcode (smcode),
  UNIQUE KEY smcode_2 (smcode)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

$queries[] = "INSERT INTO " . $dbprefix . "smileys VALUES (0, ':)', 'smile.png', 'Smile', 1, 0, 'cutemoticons')";
$queries[] = "INSERT INTO " . $dbprefix . "smileys VALUES (0, ':D', 'bigsmile.png', 'Big Smile', 2, 0, 'cutemoticons')";
$queries[] = "INSERT INTO " . $dbprefix . "smileys VALUES (0, ':angel:', 'angel.png', 'Angel', 3, 0, 'cutemoticons')";
$queries[] = "INSERT INTO " . $dbprefix . "smileys VALUES (0, ':-x', 'crossedlips.png', 'Crossed Lips', 0, 0, 'cutemoticons')";
$queries[] = "INSERT INTO " . $dbprefix . "smileys VALUES (0, ':cry:', 'cry.png', 'Cry', 0, 0, 'cutemoticons')";
$queries[] = "INSERT INTO " . $dbprefix . "smileys VALUES (0, ':kiss:', 'kiss.png', 'Kiss', 0, 0, 'cutemoticons')";
$queries[] = "INSERT INTO " . $dbprefix . "smileys VALUES (0, ':nerd:', 'nerd.png', 'Nerd', 0, 0, 'cutemoticons')";
$queries[] = "INSERT INTO " . $dbprefix . "smileys VALUES (0, ':neu:', 'neutral.png', 'Neutral', 0, 0, 'cutemoticons')";
$queries[] = "INSERT INTO " . $dbprefix . "smileys VALUES (0, ':??:', 'ooh.png', 'Question ??', 0, 0, 'cutemoticons')";
$queries[] = "INSERT INTO " . $dbprefix . "smileys VALUES (0, ':-(', 'sad.png', 'Sad', 0, 0, 'cutemoticons')";
$queries[] = "INSERT INTO " . $dbprefix . "smileys VALUES (0, ':squi:', 'squigglemouth.png', 'Squiggle mouth', 0, 0, 'cutemoticons')";
$queries[] = "INSERT INTO " . $dbprefix . "smileys VALUES (0, ':P', 'tongue.png', 'Sticking tongue out', 0, 0, 'cutemoticons')";
$queries[] = "INSERT INTO " . $dbprefix . "smileys VALUES (0, ';-D', 'wink.png', 'Wink', 0, 0, 'cutemoticons')";
$queries[] = "INSERT INTO " . $dbprefix . "smileys VALUES (0, ':xd:', 'xd.png', 'XD', 0, 0, 'cutemoticons')";

//Stats
$queries[] = "CREATE TABLE " . $dbprefix . "stats (
  timestamp int(12) NOT NULL default '0',
  users mediumint(8) NOT NULL default '0',
  topics mediumint(8) NOT NULL default '0',
  posts mediumint(8) NOT NULL default '0',
  active mediumint(8) NOT NULL default '0',
  pageviews int(10) NOT NULL default '0',
  UNIQUE KEY timestamp (timestamp)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Theme registry
$queries[] = "CREATE TABLE " . $dbprefix . "theme_registry (
  `thid` mediumint(8) NOT NULL default '0',
  `uid` mediumint(8) NOT NULL default '0',
  `theme_registry` text NOT NULL,
  UNIQUE KEY `thid` (`thid`,`uid`)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

$queries[] = "INSERT INTO " . $dbprefix . "theme_registry VALUES (1, 0, 'a:15:{s:4:\"name\";s:8:\"Electron\";s:4:\"path\";s:54:\"" . $server_url . "/themes/default\";s:3:\"url\";s:35:\"" . $url . "/themes/default\";s:6:\"images\";s:43:\"" . $url . "/themes/default/images/\";s:7:\"wysiwyg\";i:1;s:11:\"fixshoutbox\";i:0;s:8:\"showdock\";i:1;s:9:\"headerimg\";s:0:\"\";s:9:\"headerads\";s:0:\"\";s:13:\"headernavtree\";i:1;s:14:\"shownumqueries\";i:1;s:14:\"showntimetaken\";i:1;s:9:\"copyright\";s:0:\"\";s:9:\"footerads\";s:0:\"\";s:13:\"footernavtree\";i:0;}')";

//Themes
$queries[] = "CREATE TABLE " . $dbprefix . "themes (
  `thid` mediumint(5) NOT NULL auto_increment,
  `th_name` varchar(100) NOT NULL default '',
  `th_folder` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`thid`)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

$queries[] = "INSERT INTO " . $dbprefix . "themes VALUES (1, 'Electron', 'default')";

//Topics
$queries[] = "CREATE TABLE " . $dbprefix . "topics (
  tid mediumint(8) NOT NULL auto_increment,
  topic mediumtext NOT NULL,
  t_description mediumtext NOT NULL,
  t_bid smallint(5) NOT NULL default '0',
  t_status tinyint(2) NOT NULL default '1',
  n_posts smallint(5) NOT NULL default '0',
  n_views smallint(5) NOT NULL default '0',
  type_image mediumint(3) NOT NULL default '0',
  t_mem_id mediumint(8) NOT NULL default '0',
  poll_id mediumint(8) NOT NULL default '0',
  t_sticky tinyint(2) NOT NULL default '0',
  first_post_id int(10) NOT NULL default '0',
  last_post_id int(10) NOT NULL default '0',
  mem_id_last_post mediumint(8) NOT NULL default '0',
  has_attach smallint(5) NOT NULL default '0',
  t_approved tinyint(2) NOT NULL default '0',
  PRIMARY KEY  (tid)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

$queries[] = "INSERT INTO " . $dbprefix . "topics VALUES (1, 'Welcome to AEF', '', 1, 1, 0, 0, 6, -1, 0, 0, 1, 0, 0, 0, 1)";

//User Groups
$queries[] = "CREATE TABLE " . $dbprefix . "user_groups (
  member_group mediumint(5) NOT NULL auto_increment,
  mem_gr_name varchar(80) NOT NULL default '',
  mem_gr_colour varchar(20) NOT NULL default '',
  post_count mediumint(8) NOT NULL default '0',
  image_name varchar(30) NOT NULL default '',
  image_count mediumint(5) NOT NULL default '0',
  max_pm mediumint(5) NOT NULL default '0',
  PRIMARY KEY  (member_group)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

$queries[] = "INSERT INTO " . $dbprefix . "user_groups VALUES (-3, 'Banned', '#000000', -1, 'banned.gif', 1, 0)";
$queries[] = "INSERT INTO " . $dbprefix . "user_groups VALUES (-1, 'Guest', '#000000', -1, 'guests.png', 1, 0)";
$queries[] = "INSERT INTO " . $dbprefix . "user_groups VALUES (1, 'Administrator', '#FF0000', -1, 'admin.gif', 7, 0)";
$queries[] = "INSERT INTO " . $dbprefix . "user_groups VALUES (2, 'Universal Moderator', '#0000FF', -1, 'unimod.gif', 6, 0)";
$queries[] = "INSERT INTO " . $dbprefix . "user_groups VALUES (3, 'Moderator', '#339933', -1, 'mod.gif', 5, 0)";
$queries[] = "INSERT INTO " . $dbprefix . "user_groups VALUES (4, 'Newbie', '#000000', 0, 'member.gif', 1, 0)";
$queries[] = "INSERT INTO " . $dbprefix . "user_groups VALUES (5, 'Working Newbie', '#000000', 50, 'member.gif', 2, 0)";
$queries[] = "INSERT INTO " . $dbprefix . "user_groups VALUES (6, 'Working Member', '#000000', 100, 'member.gif', 3, 0)";
$queries[] = "INSERT INTO " . $dbprefix . "user_groups VALUES (7, 'Elite Member', '#000000', 250, 'member.gif', 4, 0)";
$queries[] = "INSERT INTO " . $dbprefix . "user_groups VALUES (8, 'Super Member', '#000000', 500, 'member.gif', 5, 0)";
$queries[] = "INSERT INTO " . $dbprefix . "user_groups VALUES (0, 'Member', '#000000', -1, 'member.gif', 2, 0)";
//A small bug catch for the Member Group
$queries[] = "UPDATE " . $dbprefix . "user_groups SET member_group = '0' WHERE mem_gr_name = 'Member'";


//Users
$queries[] = "CREATE TABLE " . $dbprefix . "users (
  `id` mediumint(8) NOT NULL auto_increment,
  `username` varchar(80) NOT NULL default '',
  `password` varchar(32) NOT NULL default '',
  `salt` varchar(5) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `r_time` int(12) NOT NULL default '0',
  `r_ip` varchar(20) NOT NULL default '',
  `cookpass` varchar(32) NOT NULL default '',
  `lastlogin` int(12) NOT NULL default '0',
  `lastlogin_1` int(12) NOT NULL default '0',
  `posts` mediumint(8) NOT NULL default '0',
  `u_member_group` mediumint(5) NOT NULL default '0',
  `realname` tinytext NOT NULL,
  `pm` smallint(5) NOT NULL default '0',
  `unread_pm` smallint(5) NOT NULL default '0',
  `users_text` tinytext NOT NULL,
  `gender` tinyint(2) NOT NULL default '0',
  `birth_date` date NOT NULL default '0000-00-00',
  `customtitle` varchar(100) NOT NULL default '',
  `location` varchar(255) NOT NULL default '',
  `www` tinytext NOT NULL,
  `timezone` varchar(6) NOT NULL default '0',
  `gmail` varchar(255) NOT NULL default '',
  `icq` varchar(255) NOT NULL default '',
  `aim` varchar(255) NOT NULL default '',
  `yim` varchar(255) NOT NULL default '',
  `msn` varchar(255) NOT NULL default '',
  `sig` text NOT NULL,
  `avatar` tinytext NOT NULL,
  `avatar_type` tinyint(2) NOT NULL default '0',
  `avatar_width` tinyint(4) NOT NULL default '0',
  `avatar_height` tinyint(4) NOT NULL default '0',
  `ppic` tinytext NOT NULL,
  `ppic_type` tinyint(2) NOT NULL default '0',
  `ppic_width` tinyint(4) NOT NULL default '0',
  `ppic_height` tinyint(4) NOT NULL default '0',
  `timeformat` varchar(80) NOT NULL default '',
  `secret_question` tinytext NOT NULL,
  `secret_answer` tinytext NOT NULL,
  `user_theme` mediumint(5) NOT NULL default '1',
  `act_status` tinyint(2) NOT NULL default '0',
  `activation_code` varchar(10) NOT NULL default '',
  `validation_code` varchar(32) NOT NULL default '',
  `total_time_loggedin` int(12) NOT NULL default '0',
  `warns` tinyint(2) NOT NULL default '0',
  `last_warned` int(10) NOT NULL default '0',
  `language` varchar(50) NOT NULL default '0',
  `temp_ban` int(10) NOT NULL default '0',
  `temp_ban_time` int(10) NOT NULL default '0',
  `temp_ban_ug` mediumint(5) NOT NULL default '0',
  `adminemail` tinyint(2) NOT NULL default '0',
  `hideemail` tinyint(2) NOT NULL default '0',
  `subscribeauto` tinyint(2) NOT NULL default '0',
  `sendnewreply` tinyint(2) NOT NULL default '0',
  `pm_email_notify` tinyint(2) NOT NULL default '0',
  `pm_notify` tinyint(2) NOT NULL default '0',
  `saveoutgoingpm` tinyint(2) NOT NULL default '0',
  `showsigs` tinyint(2) NOT NULL default '0',
  `showavatars` tinyint(2) NOT NULL default '0',
  `showsmileys` tinyint(2) NOT NULL default '0',
  `autofastreply` tinyint(2) NOT NULL default '0',
  `showimgs` tinyint(2) NOT NULL default '0',
  `i_am_anon` tinyint(2) NOT NULL default '0',
  `user_settings` text NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM" . (empty($utf8) ? '' : " DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci");

//Admin Account
$queries[] = "INSERT INTO " . $dbprefix . "users
                SET username = '$ad_username',
                password = '$ad_pass',
                salt = '$salt',
                email = '$ad_email',
                r_time = '" . time() . "',
                r_ip = '" . $_SERVER['REMOTE_ADDR'] . "',
                u_member_group = '1',
                act_status = '1'";

function make_mysql($queries_r) {

    global $conn, $error;

    foreach ($queries_r as $k => $q) {

        $result = mysql_query($q, $conn);

        if (!$result) {

            //Didnt get anyresult - DIE
            $error[] = 'Could not make the query numbered : ' . $k . '<br />MySQL Error No : ' . mysql_errno($conn) . '<br />MySQL Error : ' . mysql_error($conn) . ' </br >query : </br >' . $q;

            return false;
        }
    }

    return true;
}

?>
