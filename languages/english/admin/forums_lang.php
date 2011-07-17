<?php

//////////////////////////////////////////////////////////////
//===========================================================
// forums_lang.php(languages/english)
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
// (c)Electron Inc.
//===========================================================
//////////////////////////////////////////////////////////////


$l['no_forum'] = 'No forum specified';
$l['no_forum_exp'] = 'Sorry, we were unable to process your request because  you did not specify the forum which you wish to edit. Please go back and select the forum you wish to edit.';
$l['no_forum_found'] = 'No forum found';
$l['no_forum_found_exp'] = 'The forum you specified does not exist on the system.';
$l['no_themes_found'] = 'No Themes Found';
$l['no_themes_found_exp'] = 'There is some problem in the boards theme.';
$l['no_mother_posted'] = 'The Mother Was not Posted.';
$l['forum_order_missing'] = 'The Forum order was missing.';
$l['no_forum_status'] = 'The Forum Status was not posted.';
$l['no_forum_name'] = 'The Forum Name was not Posted.';
$l['no_forums_theme'] = 'The Forums theme was not posted.';
$l['groups_having_ids'] = 'The user groups having ids <b>';
$l['do_not_exist'] = '</b> do not exist on the board.';
$l['submitted_order_greater'] = 'Submitted Order is greater than possible.';
$l['edit_forum_error'] = 'Edit Forum Error';
$l['edit_forum_error_exp1'] = 'There were some errors in updating the forums new parents children.';
$l['edit_forum_error_exp2'] = 'There were some errors in updating the orders of the other forums.';
$l['no_security_code'] = 'The Security Code was not posted or is in wrong format.';
$l['sec_code_unmatched'] = 'Oops...the Security Confirmation Code did not match! You might have double clicked or refreshed the page.';
$l['forums_theme_invalid'] = 'The Forums theme you selected is invalid.';
$l['create_forum_error'] = 'Create Forum Error';
$l['inserting_submitted_info'] = 'There were some errors in inserting the submitted information of the forum.';
$l['updating_new_forums_parents'] = 'There were some errors in updating the new forums parents children.';
$l['no_forum_delete'] = 'Sorry, we were unable to process your request because you did not specify the forum which you wish to delete. Please go back and select the forum you wish to delete.';
$l['no_in_boards_shifted'] = 'The forum to which the In Boards are to be shifted was not submitted.';
$l['parent_category_invalid'] = 'The Parent Category you submitted for the In-Boards is invalid.';
$l['parent_forum_invalid'] = 'The Parent Forum you submitted for the In-Boards is invalid.';
$l['delete_forum_error'] = 'Delete forum error';
$l['errors_deleting'] = 'There were some errors while deleting the forum.';
$l['parent_insufficient_children'] = 'The parent you selected has insufficient children.';
$l['no_forum_order'] = 'The forums order was not specified.';
$l['forum order_incorrect'] = 'The number of forum order submitted is incorrect.';
$l['forums_reordering_invalid'] = 'Some of the forums submitted for reordering are invalid.';
$l['forum order_incorrect'] = 'The forum order submitted is incorrect.';


// Theme strings
$l['board_options'] = 'Board Options';
$l['board_options_exp'] = 'This is the central control of Forums. Here you can edit a Forum/Board and also delete them.<br /><b>Please becareful when deleting a Forum/Board as these actions are irreversible.</b><br /> Here you can also choose to edit their order and also select the Member Groups who can see a particular Board.';

$l['cp_manage_forums'] = 'Administration Center - Manage Forums';
$l['edit_boards'] = 'Edit Boards';
$l['edit_edit'] = 'Edit';
$l['edit_delete'] = 'Delete';
$l['short1'] = '-';
$l['short2'] = '--';

$l['cp_edit_forums'] = 'Administration Center - Edit a Forum';
$l['general_options'] = 'General Options';
$l['mother_forums'] = 'Mother Forums:';
$l['select_mother'] = 'Select Mother';
$l['order'] = 'Order:';
$l['refresh_order'] = 'Refreshing Order List ...';
$l['retrieve_data'] = 'Unable to Retrieve Data.';
$l['forum_status'] = 'Forum Status:';
$l['forum_status_exp'] = 'This allows members to post or Locks the Board. Doesn\'t apply to Moderators and Admins.';
$l['active'] = 'Active';
$l['locked'] = 'Locked';
$l['redirect_forum'] = 'Redirect Forum:';
$l['url_redirect'] = 'Enter a URL to which this forum will be redirected to.';
$l['forum_icon'] = 'Forum Icon:';
$l['url_image_forum'] = 'Enter a URL of a image if you want to give this forum a special icon.';
$l['forum_options'] = 'Forum Options';
$l['forum_name'] = 'Name of Forum:';
$l['forum_description'] = 'Forum Description:';
$l['forum_description_exp'] = 'A little description about this Board.<br />You may use HTML.';
$l['deafult_theme'] = 'Deafult Theme :';
$l['deafult_theme_exp'] = 'Choose the default theme for this Board.';
$l['use_board_default'] = 'Use Board Default';
$l['rules_title'] = 'Rules Title:';
$l['rules_title_exp'] = 'The title of the rules if rules are set for the forum.';
$l['forum_rules'] = 'Forum Rules:';
$l['forum_rules_exp'] = 'These rules will be displayed in the forum topic index. You may use HTML and Javascript.';
$l['enable_rss_feeds'] = 'Enable RSS Feeds :';
$l['enable_rss_feeds_exp'] = 'If enabled, recent posts in this forum will have its own RSS Feeds Page. Set the Number of posts to be shown in the feeds. Zero - 0 to disable.';
$l['topic_rss_feeds'] = 'Topic Feeds :';
$l['topic_rss_feeds_exp'] = 'If enabled, the latest posts in a topic will have its own RSS Feeds Page. Set the Number of posts to be shown in the feeds. Zero - 0 to disable.';
$l['member_group_set'] = 'Member Group Settings';
$l['member_groups_allow'] = 'Member Groups Allowed:';
$l['member_groups_allow_exp'] = 'Select the Member Groups that will be allowed to view the forum.';
$l['increase_member_posts'] = 'Increase Member Posts:';
$l['increase_member_posts_exp'] = 'On posting Topics or Replies Should Members post count increase.';
$l['override_theme'] = 'Override Theme:';
$l['override_theme_exp'] = 'If the member has selected his own theme on the Forum then this Option will enforce the theme you selected as default for this Board.';
$l['post_settings'] = 'Post Settings';
$l['allow_polls'] = 'Allow Polls :';
$l['allow_polls_exp'] = 'Should polls be allowed in this board.';
$l['allow_htm'] = 'Allow HTML :';
$l['allow_htm_exp'] = 'Should Members who have Permissions be allowed to post HTML.';
$l['quick_reply'] = 'Quick Reply :';
$l['quick_reply_exp'] = 'This will display a Quick Reply Box at the end of each Topic.';
$l['quick_topic'] = 'Quick Topic :';
$l['quick_topic_exp'] = 'This will display a Quick Topic Box in this forum.';
$l['moderate_topics'] = 'Moderate Topics :';
$l['moderate_topics_exp'] = 'If enabled then every topic in this forum will be visible only when someone having permissions approves it.';
$l['moderate_posts'] = 'Moderate Posts :';
$l['moderate_posts_exp'] = 'If enabled then every post in this forum will be visible only when someone having permissions approves it.';
$l['edit_forum'] = 'Edit Forum';

$l['cp_create_forums'] = 'Administration Center - Create a Forum';
$l['create_forum'] = 'Create Forum';

$l['cp_delete_forums'] = 'Administration Center - Delete a Forum';
$l['deleting_options'] = 'Deleting Options';
$l['delete_forums'] = 'Delete Forums :';
$l['shift_inboards_to'] = 'Shift Inboards to :';
$l['shift_inboards_to_exp'] = 'If there are any In Boards shift them to.';
$l['confirm_delete'] = 'Confirm Delete';

$l['cp_reorder_forums'] = 'Administration Center - Reorder Forums';
$l['reorder_forums'] = 'Reorder Forums';
$l['reorder_forums_exp'] = 'This is the place for changing the Forum order in which they appear throughout the Board. First select the Parent the forums of which you wish to reorder. <b>Drag and Drop</b> the Forum box and put them in the order you like.';
$l['reorder_forum'] = 'Reorder Forum';
$l['select_parent'] = 'Select Parent :';
$l['select_parent_e'] = 'Select Parent';
$l['select_parent_exp'] = 'Select the parent the forums of which you want to reorder. Please select only those Parents which have more than two forums.';
$l['re_rder'] = 'Re Order';

?>