<?php

//////////////////////////////////////////////////////////////
//===========================================================
// markread_lang.php(languages/english)
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


/////////////////////////////////////////////////////////
//Function markboard() strings - Marks whole board read
/////////////////////////////////////////////////////////

function markboard_lang(){

global $l, $globals; 

$l['mark_board_error_title'] = 'Mark all read error';
$l['mark_board_error'] = 'There were some errors while marking the whole board as read for you. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

}//End of function


///////////////////////////////////////////////////////
//Function markforum() strings - Marks a forum as read
///////////////////////////////////////////////////////

function markforum_lang(){

global $l, $globals; 

$l['no_forum_specified_title'] = 'No forum specified';
$l['no_forum_specified'] = 'Sorry, we were unable to mark any forum read because the forum was not specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['load_forum_error_title'] = 'Mark as Read Error';
$l['load_forum_error'] = 'Sorry, we were unable to mark any forum as read because there was an error in loading the forums. Please contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['no_forum_found_title'] = 'No forum found';
$l['no_forum_found'] = 'The forum you specified either does not exists or you are not authorised to view the same. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['mark_forum_error_title'] = 'Mark forum read error';
$l['mark_forum_error'] = 'Sorry, we were unable to mark the forum you specified as read because the connection with the database failed. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

}//End of function


//////////////////////////////////////////////////////////
//Function unreadtopic() strings - Marks a topic as unread
//////////////////////////////////////////////////////////

function unreadtopic_lang(){

global $l, $globals; 

$l['no_topic_specified_title'] = 'No topic specified';
$l['no_topic_specified'] = 'Sorry, we were unable to mark any topic as unread because the topic was not specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_topic_found_title'] = 'No topic found';
$l['no_topic_found'] = 'The topic you are trying to Mark as Unread was not found. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['mark_topic_error_title'] = 'Mark topic unread error';
$l['mark_topic_error'] = 'Sorry, we were unable to Mark the topic as Unread . Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

}//End of function

?>