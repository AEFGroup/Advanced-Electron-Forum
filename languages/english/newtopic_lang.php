<?php

//////////////////////////////////////////////////////////////
//===========================================================
// newtopic_lang.php(languages/english)
//===========================================================
// AEF : Advanced Electron Forum
// Version : 1.0.10
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


$l['no_forum_specified_title'] = 'No forum specified';
$l['no_forum_specified'] = 'Sorry, we were unable to process your request because the forum was not specified. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.';

$l['no_forum_found_title'] = 'No forum found';
$l['no_forum_found'] = 'The forum you specified either does not exists or you are not authorised to view the same. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.';

$l['forum_locked_title'] = 'Forum Locked';
$l['forum_locked'] = 'This forum is locked and you are not authorised to start a new topic in this forum. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.';

$l['no_topic_permissions_title'] = 'No Authority';
$l['no_topic_permissions'] = 'You do not have the permissions to start a new topic in this forum. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.';

$l['starting_newtopic'] = 'Starting new topic'; //For the 'You are here'

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
$l['no_title'] = 'The title field was empty.';
$l['empty_post'] = 'The post was empty.';

$l['insert_topic_error_title'] = 'New Topic Error';
$l['insert_topic_error'] = 'There were some errors while creating this new topic. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

$l['topic_post_error_title'] = 'New Topic Error';
$l['topic_post_error'] = 'There were some errors while creating the posts for the new topic. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

$l['update_topic_error_title'] = 'New Topic Error';
$l['update_topic_error'] = 'The topic was created but there were some errors in updating the topic. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

$l['update_users_error_title'] = 'New Topic Error';
$l['update_users_error'] = 'The topic was created but there were some errors in updating the users post count. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

$l['update_forum_error_title'] = 'New Topic Error';
$l['update_forum_error'] = 'The topic was inserted in the system but there were some errors. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

$l['subscription_error_title'] = 'Subscription error';
$l['subscription_error'] = 'Sorry, we were unable to subscribe to the topic because the connection with the database failed. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

//If new attachments are not allowed
$l['attachments_not_allowed_title'] = 'Attachment error';
$l['attachments_not_allowed'] = 'Sorry, we were unable to upload your attachments in this topic as new attachments have been disabled on the board. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.';

//New Topic Mail
$l['new_topic_mail_subject'] = 'New topic started in - &aefv-1;';
$l['new_topic_mail'] = 'Hello member,

A new topic - &aefv-1; - has been started in &aefv-2; forum of ' . $globals['sn'] . '.

To visit the topic please click the below link:
' . $globals['mail_url'] . 'tid=&aefv-3;

To unsubscribe please click the link below:
' . $globals['mail_url'] . 'act=notify&nact=unsubforum&nfid=&aefv-4;

The ' . $globals['sn'] . ' Team.
' . $globals['url'] . '/';

//Theme Strings
$l['<title>'] = 'Start a New Topic';
$l['newtopic_heading'] = 'Start a Topic';
$l['your_name'] = 'Your Name'; //For Guests
$l['your_email'] = 'Your Email'; //Guests Email
$l['newtopic_title'] = 'Title';
$l['newtopic_desc'] = 'Description';
$l['newtopic_text_formatting'] = 'Text Formatting';
$l['newtopic_post'] = 'Post';
$l['newtopic_topic_icons'] = 'Topic Icons';
$l['topic_icons_none'] = 'None'; //A text for No topic Icons
$l['newtopic_options'] = 'Options';
$l['options_enable_smileys'] = '<b>Enable</b> Smileys';
$l['options_sticky_topic'] = '<b>Sticky</b> this Topic';
$l['options_lock_topic'] = '<b>Lock</b> this Topic';
$l['options_announce_topic'] = '<b>Announce</b> this Topic';
$l['options_notify_topic'] = '<b>Notify</b> Replies to this Topic';
$l['options_post_poll'] = '<b>Post</b> a Poll';
$l['newtopic_attachments'] = 'Attachments';
$l['newtopic_submit_button'] = 'Post Topic';

$l['newtopic_prewiew_button'] = 'Preview Topic';
$l['preview_title'] = 'Preview (Remember, your topic has not been posted yet) :';
$l['posted_on'] = 'Posted on';
$l['this_preview'] = 'This is a preview';
$l['prefix_group'] = 'Group:';
$l['prefix_post_group'] = 'Post Group:';
$l['prefix_posts'] = 'Posts:';
$l['prefix_status'] = 'Status:';
$l['online'] = 'Online';
$l['offline'] = 'Offline';
?>