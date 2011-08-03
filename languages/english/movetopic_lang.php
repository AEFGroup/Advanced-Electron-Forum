<?php

//////////////////////////////////////////////////////////////
//===========================================================
// movetopics_lang.php(languages/english)
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


$l['no_topic_specified_title'] = 'No Topic specified';
$l['no_topic_specified'] = 'Sorry, we were unable to process your request because no topic id was specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['invalid_topic_specified_title'] = 'Invalid topic specified';
$l['invalid_topic_specified'] = 'Sorry, we were unable to process your request because these topic(s) - \'&aefv-1;\' are invalid. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_topic_found_title'] = 'No Topic Found';
$l['no_topic_found'] = 'Sorry, we were unable to process your request because the topic(s) you are trying to move were not found in the database. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['some_topic_not_found_title'] = 'Some Topics Not Found';
$l['some_topic_not_found'] = 'Sorry, we were unable to process your request because some of the topic(s) were not found in the database. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['not_same_forum_title'] = 'Invalid topics specified';
$l['not_same_forum'] = 'Sorry, we were unable to process your request because the topic(s) you are trying to move are not of the same forum. You can move several topics at the same time only if they belong to the same forum. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_forum_found_title'] = 'No forum found';
$l['no_forum_found'] = 'The forum you specified either does not exists or you are not authorised to view the same. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_move_permissions_title'] = 'Access Denied';
$l['no_move_permissions'] = 'Sorry, you are not allowed to move some of the topic(s) as you do not have the permissions to do so. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_post_found_title'] = 'No Post Found';
$l['no_post_found'] = 'Sorry, we were unable to process your request because the posts of the topic(s) were not found in the database. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['moving_topics'] = 'Moving topic';//For the 'You are here'

//Posting Errors
$l['no_forum_selected'] = 'You did not select the forum to which the topic(s) are to be shifted.';
$l['invalid_forum_selected'] = 'The Forum that you submitted is invalid.';
$l['same_forum_error'] = 'You cannot move the topics to the forum where they already are.';
$l['no_moved_link_text'] = 'You did not enter any text for the Moved Link.';

$l['topic_update_error_title'] = 'Moving Error';
$l['topic_update_error'] = 'There were some errors in updating the topics(s). Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_posts_error_title'] = 'Moving Error';
$l['update_posts_error'] = 'There were some errors in moving the post(s) of the topic(s). Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_forum_error_title'] = 'Moving Error';
$l['update_forum_error'] = 'The topic(s) were moved but there were some errors in updating the forum. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_dest_forum_error_title'] = 'Moving Error';
$l['update_dest_forum_error'] = 'The topic(s) were moved but there were some errors in updating the destination forum. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['link_topic_error_title'] = 'Move Topic Error';
$l['link_topic_error'] = 'The topic(s) were moved but there were some errors in leaving a moved link. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['link_topic_post_error_title'] = 'Move Topic Error';
$l['link_topic_post_error'] = 'The topic(s) were moved but there were some errors while creating the post for the moved link. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';


//Theme Strings
$l['<title>'] = 'Move Topic(s)';
$l['movetopics_heading'] = 'Moving Topic(s)';
$l['move_to'] = 'Move the Topic(s) to';
$l['move_leave_link'] = 'Leave a Moved Link';
$l['move_link_text'] = 'Text in the \'Moved Topic\' Link';
$l['move_link_text_text'] = 'This topic has been moved to {board}.
Please click the link below to visit the topic:

{link}';//Dont remove - {board} {link}
$l['move_submit_button'] = 'Move Topic(s)';

?>