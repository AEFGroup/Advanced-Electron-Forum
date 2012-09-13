<?php

//////////////////////////////////////////////////////////////
//===========================================================
// editpost.php(languages/english)
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



$l['no_post_specified_title'] = 'No post specified';
$l['no_post_specified'] = 'Sorry, we were unable to process your request because the post you are trying to edit was not specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_post_found_title'] = 'No Post Found';
$l['no_post_found'] = 'Sorry, we were unable to process your request because the post you are trying to edit was not found in the database. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_forum_found_title'] = 'No forum found';
$l['no_forum_found'] = 'The forum you specified either does not exists or you are not authorised to view the same. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_edit_permissions_title'] = 'Access Denied';
$l['no_edit_permissions'] = 'Sorry, you are not allowed to edit the post as you do not have the permissions to do so. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['editing_post'] = 'Editing post';//For the 'You are here'

$l['no_security_code'] = 'The Topic Post Code was not posted or is in wrong format.';//A code to avoid refresh
$l['wrong_security_code'] = 'The Security Confirmation Code does not match.';

//For guest posters some specific errors
$l['guest_no_name'] = 'You did not enter your name.';
$l['max_name_length_crossed'] = 'Your name length cannot be greater than &aefv-1; characters.';
$l['min_name_length_crossed']  = 'Your name length cannot be less than &aefv-1; characters.';
$l['space_in_name'] = 'Your name cannot contain white spaces.';
$l['name_in_use'] = 'The name <b>&aefv-1;</b> is already in use.';
$l['reserved_names'] = 'Your name cannot contain the word(s) &aefv-1;.';
$l['guest_no_email'] = 'You did not enter your email.';
$l['guest_email_big'] = 'Your Email Address is too large.';
$l['guest_email_invalid'] = 'Your Email Address is invalid.';
$l['email_in_use'] = 'The email address you specified belongs to one of the members.';

//Posting Errors
$l['empty_post'] = 'The post was empty.';

$l['edit_error_title'] = 'Edit Error';
$l['edit_error'] = 'Sorry, we were unable to edit the post because the connection with the Database failed. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

//If new attachments are not allowed
$l['attachments_not_allowed_title'] = 'Attachment error';
$l['attachments_not_allowed'] = 'Sorry, we were unable to upload your attachments in this topic as new attachments have been disabled on the board. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

//Some errors while retrieving data for redirection
$l['redirect_error_title'] = 'Edit Error';
$l['redirect_error'] = 'Sorry, but some errors ocurred while redirecting you to the post. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

//Theme Strings
$l['<title>'] = 'Edit Reply';
$l['editpost_heading'] = 'Editing Post - ';
$l['your_name'] = 'Your Name';//For Guests
$l['your_email'] = 'Your Email';//Guests Email
$l['edit_title'] = 'Title';
$l['edit_text_formatting'] = 'Text Formatting';
$l['edit_post'] = 'Post';
$l['edit_options'] = 'Options';
$l['options_enable_smileys'] = '<b>Enable</b> Smileys';
$l['options_announce_topic'] = '<b>Announce</b> this Topic';
$l['edit_attached_files'] = 'Attached Files';
$l['uncheck_remove_attachments'] = '(Uncheck to remove)';
$l['attachment_kb'] = 'KB';
$l['attachment_downloads'] = 'Downloads: ';
$l['edit_attachments'] = 'Attachments';
$l['edit_submit_button'] = 'Edit Post';

$l['edit_prewiew_button'] = 'Preview Post';
$l['preview_title'] = 'Preview (Remember, your edited post has not been saved yet) :';
$l['this_preview'] = 'This is a preview';
$l['prefix_group'] = 'Group:';
$l['prefix_post_group'] = 'Post Group:';
$l['prefix_posts'] = 'Posts:';
$l['posted_on'] = 'Posted on';
$l['edited_by'] = 'Edited by';

?>