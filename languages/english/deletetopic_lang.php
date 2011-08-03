<?php

//////////////////////////////////////////////////////////////
//===========================================================
// deletetopic.php(languages/english)
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

$l['invalid_topic_title'] = 'Invalid topic specified';
$l['invalid_topic'] = 'Sorry, we were unable to process your request because these topic(s) - \''.implode(', ', $invalid).'\' are invalid. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_topic_found_title'] = 'No Topic Found';
$l['no_topic_found'] = 'Sorry, we were unable to process your request because the topic(s) you are trying to delete were not found in the database. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['some_topic_not_found_title'] = 'Some topic(s) Not Found';
$l['some_topic_not_found'] = 'Sorry, we were unable to process your request because some of the topic(s) were not found in the database. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['not_same_forum_title'] = 'Invalid Topic specified';
$l['not_same_forum'] = 'Sorry, we were unable to process your request because the topic(s) you are trying to delete are not of the same forum. You can delete several topics at the same time only if they belong to the same forum. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_forum_title'] = 'No forum found';
$l['no_forum'] = 'The forum you specified either does not exists or you are not authorised to view the same. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_delete_permission_title'] = 'No Delete Permissions';
$l['no_delete_permission'] = 'Sorry, you are not allowed to delete some of the topic(s) as you do not have the permissions to do so. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_posts_found_title'] = 'No Posts Found';
$l['no_posts_found'] = 'Sorry, we were unable to process your request because the posts of the topic(s) you are trying to delete were not found in the database. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['recyclebin_error_title'] = 'Delete Error';
$l['recyclebin_error'] = 'Sorry, but some errors ocurred while trying to move the topic(s) in the recycle bin. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_forum_error_title'] = 'Delete Error';
$l['update_forum_error'] = 'The post(s) were deleted from the topic but there were some errors in updating the forum. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_recyclebin_error_title'] = 'Delete Error';
$l['update_recyclebin_error'] = 'The post was deleted from the topic but there were some errors in updating the recycle bin forum. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['delete_error_title'] = 'Delete Error';
$l['delete_error'] = 'There were some errors in deleting the topics(s). Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['delete_posts_error_title'] = 'Delete Error';
$l['delete_posts_error'] = 'There were some errors in deleting the post(s). Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

?>