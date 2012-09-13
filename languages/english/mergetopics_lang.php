<?php

//////////////////////////////////////////////////////////////
//===========================================================
// mergetopics_lang.php(languages/english)
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


$l['no_forum_specified_title'] = 'No Forum specified';
$l['no_forum_specified'] = 'Sorry, we were unable to process your request because no destination forum was specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_forum_found_title'] = 'No forum found';
$l['no_forum_found'] = 'The forum you specified either does not exists or you are not authorised to view the same. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_merge_permissions_title'] = 'Access Denied';
$l['no_merge_permissions'] = 'Sorry, you are not allowed to merge the topics as you do not have the permissions to do so. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_topic_specified_title'] = 'No Topic specified';
$l['no_topic_specified'] = 'Sorry, we were unable to process your request because no topic id was specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['invalid_topic_specified_title'] = 'Invalid topic specified';
$l['invalid_topic_specified'] = 'Sorry, we were unable to process your request because these topic(s) - \'&aefv-1;\' are invalid. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_topic_found_title'] = 'No Topic Found';
$l['no_topic_found'] = 'Sorry, we were unable to process your request because the topics you are trying to merge were not found in the database. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['some_topic_not_found_title'] = 'Some Topics Not Found';
$l['some_topic_not_found'] = 'Sorry, we were unable to process your request because some of the topics were not found in the database. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['one_topic_specified_title'] = 'One topic specified';
$l['one_topic_specified'] = 'Sorry, we were unable to process your request because one topic cannot be merged with itself. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['not_same_forum_title'] = 'Invalid topics specified';
$l['not_same_forum'] = 'Sorry, we were unable to process your request because you are not allowed to merge topics of different forums. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['too_many_polls_title'] = 'Too many polls';
$l['too_many_polls'] = 'Sorry, we were unable to process your request because the merged topics can have only one poll.';

$l['no_post_found_title'] = 'No Post Found';
$l['no_post_found'] = 'Sorry, we were unable to process your request because the post(s) of the topic(s) were not found in the database. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['merging_topics'] = 'Merging topics';//For the 'You are here'

//Posting Errors
$l['no_title_selected'] = 'You did not select the topic title for the merged topic.';
$l['invalid_title_selected'] = 'The title you selected for the merged topic is invalid.';
$l['no_starter'] = 'You did not select the topic starter for the merged topic.';
$l['invalid_starter'] = 'The topic\'s starter you selected for the merged topic is invalid.';


$l['topic_update_error_title'] = 'Merge Error';
$l['topic_update_error'] = 'There were some errors in updating the merged topic. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

//Delete unrequired posts error
$l['del_unrequired_topic_error_title'] = 'Merge Error';
$l['del_unrequired_topic_error'] = 'There were some errors in deleting the topics that were not required, while merging the topics. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_posts_error_title'] = 'Merge Error';
$l['update_posts_error'] = 'There were some errors in updating the posts of the merged topics. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_forum_error_title'] = 'Merge Error';
$l['update_forum_error'] = 'The topics were merged but there were some errors in updating the forums. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_dest_forum_error_title'] = 'Merge Error';
$l['update_dest_forum_error'] = 'The topics were merged but there were some errors in updating the destination forum. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

//Theme Strings
$l['<title>'] = 'Merge Topics';
$l['mergetopics_heading'] = 'Merging Topics';
$l['merge_title'] = 'Title';
$l['merge_starter'] = 'Merged Topics Starter';
$l['merge_destination'] = 'Destination Forum';
$l['merge_submit_button'] = 'Merge Topics';

?>