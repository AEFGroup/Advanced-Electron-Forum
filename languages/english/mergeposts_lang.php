<?php

//////////////////////////////////////////////////////////////
//===========================================================
// mergeposts_lang.php(languages/english)
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
$l['no_post_specified'] = 'Sorry, we were unable to process your request because the post(s) you are trying to merge were not specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['invalid_post_specified_title'] = 'Invalid post specified';
$l['invalid_post_specified'] = 'Sorry, we were unable to process your request because the post(s) - \'&aefv-1;\' you are trying to merge are invalid. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_post_found_title'] = 'No Post Found';
$l['no_post_found'] = 'Sorry, we were unable to process your request because the post(s) you are trying to merge were not found in the database. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['some_post_not_found_title'] = 'Some Posts Not Found';
$l['some_post_not_found'] = 'Sorry, we were unable to process your request because some of the post(s) were not found in the database. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['one_post_specified_title'] = 'One post specified';
$l['one_post_specified'] = 'Sorry, we were unable to process your request because one post cannot be merged with itself. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['not_same_topic_title'] = 'Invalid posts specified';
$l['not_same_topic'] = 'Sorry, we were unable to process your request because the post(s) are not of the same topic. You can merge several posts at the same time only if they belong to the same topic. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_forum_found_title'] = 'No forum found';
$l['no_forum_found'] = 'The forum you specified either does not exists or you are not authorised to view the same. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_merge_permissions_title'] = 'Access Denied';
$l['no_merge_permissions'] = 'Sorry, you are not allowed to merge the post(s) as you do not have the permissions to do so. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['merging_post'] = 'Merging Posts';//For the 'You are here'

//Posting Errors
$l['no_time_selected'] = 'You did not select the time for the merged post.';
$l['invalid_time_selected'] = 'The time selected for the merged post is invalid.';
$l['no_poster'] = 'You did not select the poster for the merged post.';
$l['invalid_poster'] = 'The poster selected for the merged post is invalid.';
$l['empty_post'] = 'The post was empty.';

$l['merge_error_title'] = 'Merge Error';
$l['merge_error'] = 'There were some errors in merging the posts. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

//Delete unrequired posts error
$l['del_unrequired_posts_error_title'] = 'Merge Error';
$l['del_unrequired_posts_error'] = 'There were some errors in deleting the post(s) that were not required, while merging the posts. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_topic_error_title'] = 'Merge Error';
$l['update_topic_error'] = 'The post(s) were merged but there were some errors in updating the topic information. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_forum_error_title'] = 'Merge Error';
$l['update_forum_error'] = 'The post(s) were merged but there were some errors in updating the forum. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

//Theme Strings
$l['<title>'] = 'Merge Posts';
$l['mergeposts_heading'] = 'Merging Posts';
$l['merged_posts_time'] = 'Merged Posts Time';
$l['merged_posts_poster'] = 'Merged Posts Poster';
$l['merge_title'] = 'Title';
$l['merge_text_formatting'] = 'Text Formatting';
$l['merge_post'] = 'Post';
$l['merge_options'] = 'Options';
$l['options_enable_smileys'] = '<b>Enable</b> Smileys';
$l['merge_submit_button'] = 'Merge Posts';

?>