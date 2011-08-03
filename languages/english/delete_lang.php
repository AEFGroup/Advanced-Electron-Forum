<?php

//////////////////////////////////////////////////////////////
//===========================================================
// delete.php(languages/english)
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


$l['no_post_specified_title'] = 'No post specified';
$l['no_post_specified'] = 'Sorry, we were unable to process your request because the post(s) you are trying to delete was not specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['invalid_post_title'] = 'Invalid post specified';
$l['invalid_post'] = 'Sorry, we were unable to process your request because the post(s) - \'&aefv-1;\' you are trying to delete are invalid. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_post_found_title'] = 'No Post Found';
$l['no_post_found'] = 'Sorry, we were unable to process your request because the post(s) you are trying to delete were not found in the database. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['some_post_not_found_title'] = 'Some Posts Not Found';
$l['some_post_not_found'] = 'Sorry, we were unable to process your request because some of the post(s) you are trying to delete were not found in the database. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['not_same_topic_title'] = 'Invalid posts specified';
$l['not_same_topic'] = 'Sorry, we were unable to process your request because the post(s) you are trying to delete are not of the same topic. You can delete several posts at the same time only if they belong to the same topic. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['delete_error_title'] = 'Delete Error';
$l['delete_error'] = 'Sorry, but some errors ocurred while trying to delete the post(s). Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['first_topic_post_title'] = 'Delete Error';
$l['first_topic_post'] = 'Sorry, the first post of a topic cannot be deleted. However you can remove the topic. To remove the topic please click \'Remove Topic\' Link in the topic.';

$l['no_forum_title'] = 'No forum found';
$l['no_forum'] = 'The forum you specified either does not exists or you are not authorised to view the same. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_delete_permission_title'] = 'No Delete Permissions';
$l['no_delete_permission'] = 'Sorry, you are not allowed to delete some of the post(s) as you do not have the permissions to do so. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';


$l['recyclebin_error_title'] = 'Delete Error';
$l['recyclebin_error'] = 'Sorry, but some errors ocurred while trying to move the post(s) in the recycle bin. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_topic_error_title'] = 'Delete Error';
$l['update_topic_error'] = 'The post(s) were deleted from the system but there were some errors in updating the topic information. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_users_error_title'] = 'Delete Error';
$l['update_users_error'] = 'The post(s) were deleted from the topic but there were some errors in updating the users post count. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_forum_error_title'] = 'Delete Error';
$l['update_forum_error'] = 'The post(s) were deleted from the topic but there were some errors in updating the forum. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_recyclebin_error_title'] = 'Delete Error';
$l['update_recyclebin_error'] = 'The post was deleted from the topic but there were some errors in updating the recycle bin forum. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';


?>