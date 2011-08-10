<?php

//////////////////////////////////////////////////////////////
//===========================================================
// reply_lang.php(languages/english)
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


$l['no_topic_specified_title'] = 'No topic specified';
$l['no_topic_specified'] = 'Sorry, we were unable to process your request because the topic to which you are trying to reply was not specified. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.';

$l['no_topic_found_title'] = 'No Topic Found';
$l['no_topic_found'] = 'Sorry, we were unable to process your request because the topic was not found in the database. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.';

$l['no_forum_found_title'] = 'No forum found';
$l['no_forum_found'] = 'The forum you specified either does not exists or you are not authorised to view the same. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.';

$l['forum_locked_title'] = 'Forum Locked';
$l['forum_locked'] = 'This forum is locked and you are not authorised to reply in this forum. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.';

$l['topic_locked_title'] = 'Topic Locked';
$l['topic_locked'] = 'This topic is locked and you are not authorised to reply in this forum. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.';

$l['no_reply_permissions_title'] = 'No Authority';
$l['no_reply_permissions'] = 'You do not have the permissions to reply in this topic of this forum. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.';

$l['no_last_posts_title'] = 'Last Posts not found';
$l['no_last_posts'] = 'There were some errors while retrieving the last posts in this topic. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

$l['replying_in'] = 'Replying in '; //For the 'You are here'

$l['no_security_code'] = 'The Topic Post Code was not posted or is in wrong format.'; //A code to avoid refresh
$l['wrong_security_code'] = 'Oops...the Security Confirmation Code did not match! You might have double clicked or refreshed the page.';
$l['last_post_time'] = 'There has to be an interval of ' . $globals['timepostfromuser'] . ' seconds between posts!';

//For guest posters some specific errors
$l['guest_no_name'] = 'You did not enter your name.';
$l['max_name_length_crossed'] = 'Your name length cannot be greater than &aefv-1; characters.';
$l['min_name_length_crossed'] = 'Your name length cannot be less than &aefv-1; characters.';
$l['space_in_name'] = 'Your name cannot contain white spaces.';
$l['name_in_use'] = 'The name <b>&aefv-1;</b> is already in use.';
$l['reserved_names'] = 'Your name cannot contain the word(s) &aefv-1;.';
$l['guest_no_email'] = 'You did not enter your email.';
$l['guest_email_big'] = 'Your Email Address is too large.';
$l['guest_email_invalid'] = 'Your Email Address is invalid.';
$l['email_in_use'] = 'The email address you specified belongs to one of the members.';

//Posting Errors
$l['empty_post'] = 'The post was empty.';

$l['reply_error_title'] = 'Reply Error';
$l['reply_error'] = 'There were some errors while inserting your post into the topic. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

$l['update_topic_error_title'] = 'Reply Error';
$l['update_topic_error'] = 'The post was inserted in the topic but there were some errors in updating the topic. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

$l['update_users_error_title'] = 'Reply Error';
$l['update_users_error'] = 'The post was inserted in the system but there were some errors in updating the users post count. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

$l['update_forum_error_title'] = 'Reply Error';
$l['update_forum_error'] = 'The post was inserted in the system but there were some errors in updating the forum. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

$l['subscription_error_title'] = 'Subscription error';
$l['subscription_error'] = 'Sorry, we were unable to subscribe to the topic because the connection with the database failed. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

//If new attachments are not allowed
$l['attachments_not_allowed_title'] = 'Attachment error';
$l['attachments_not_allowed'] = 'Sorry, we were unable to upload your attachments in this topic as new attachments have been disabled on the board. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.';

//New Reply Mail
$l['new_reply_mail_subject'] = 'New post in topic - &aefv-1;';
$l['new_reply_mail'] = 'Hello member,

A new post has been made in - &aefv-1; - topic by &aefv-2;.

To visit the topic please click the below link:
' . $globals['mail_url'] . 'tid=&aefv-3;&tpg=&aefv-4;#p&aefv-5;

To unsubscribe please click the link below:
' . $globals['mail_url'] . 'act=notify&nact=unsubtopic&ntid=&aefv-3;

The ' . $globals['sn'] . ' Team.
' . $globals['url'] . '/';

//Theme Strings
$l['<title>'] = 'Post New Reply';
$l['reply_heading'] = 'Posting in -';
$l['your_name'] = 'Your Name'; //For Guests
$l['your_email'] = 'Your Email'; //Guests Email
$l['reply_title'] = 'Title';
$l['reply_text_formatting'] = 'Text Formatting';
$l['reply_post'] = 'Post';
$l['reply_options'] = 'Options';
$l['options_enable_smileys'] = '<b>Enable</b> Smileys';
$l['options_sticky_topic'] = '<b>Sticky</b> this Topic';
$l['options_lock_topic'] = '<b>Lock</b> this Topic';
$l['options_announce_topic'] = '<b>Announce</b> this Topic';
$l['options_notify_topic'] = '<b>Notify</b> Replies to this Topic';
$l['options_add_poll'] = '<b>Add</b> a Poll';
$l['reply_attachments'] = 'Attachments';
$l['reply_submit_button'] = 'Submit Post';
$l['last_posts'] = 'Last ' . $globals['last_posts_reply'] . ' posts';
$l['posted_on'] = 'Posted on';
$l['post_num_prefix'] = 'Post';

$l['reply_prewiew_button'] = 'Preview Post';
$l['preview_title'] = 'Preview (Remember, your reply has not been posted yet) :';
$l['this_preview'] = 'This is a preview';
$l['prefix_group'] = 'Group:';
$l['prefix_post_group'] = 'Post Group:';
$l['prefix_posts'] = 'Posts:';
$l['prefix_status'] = 'Status:';
$l['online'] = 'Online';
$l['offline'] = 'Offline';
?>