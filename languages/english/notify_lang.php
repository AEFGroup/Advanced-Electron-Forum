<?php

//////////////////////////////////////////////////////////////
//===========================================================
// notify_lang.php(languages/english)
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


//////////////////////////////////////////////////////
//Function notifytopic() strings - Subscribes a topic
//////////////////////////////////////////////////////

function notifytopic_lang(){

global $l, $globals; 

$l['no_topic_specified_title'] = 'No topic specified';
$l['no_topic_specified'] = 'Sorry, we were unable to subscribe to any topic because the topic id was not specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_topic_found_title'] = 'No topic found';
$l['no_topic_found'] = 'There is no such topic in any of the forums. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_forum_found_title'] = 'No forum found';
$l['no_forum_found'] = 'Sorry, we were unable to subscribe to any topic because the forum to which it belongs either does not exist or you are not allowed to view it. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['subscription_error_title'] = 'Subscription error';
$l['subscription_error'] = 'There were some errors while subscribing you to this topic. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

}//End of function


//////////////////////////////////////////////////////
//Function notifyforum() strings - Subscribes a forum
//////////////////////////////////////////////////////

function notifyforum_lang(){

global $l, $globals; 

$l['no_forum_specified_title'] = 'No forum specified';
$l['no_forum_specified'] = 'Sorry, we were unable to subscribe to any forum because the forum was not specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_forum_found_title'] = 'No forum found';
$l['no_forum_found'] = 'Sorry, we were unable to subscribe to any forum because the forum either does not exist or you are not allowed to view it. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['subscription_error_title'] = 'Subscription error';
$l['subscription_error'] = 'There were some errors while subscribing you to this forum. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

}//End of function


///////////////////////////////////////////////////////
//Function unsubtopic() strings - Unsubscribes a topic
///////////////////////////////////////////////////////

function unsubtopic_lang(){

global $l, $globals; 

$l['no_topic_specified_title'] = 'No topic specified';
$l['no_topic_specified'] = 'Sorry, we were unable to unsubscribe to any topic because the topic id was not specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['unsubscription_error_title'] = 'Unsubscription error';
$l['unsubscription_error'] = 'Sorry, we were unable to unsubscribe to the topic you specified because the connection with the database failed. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

}//End of function


///////////////////////////////////////////////////////
//Function unsubforum() strings - Unsubscribes a forum
///////////////////////////////////////////////////////

function unsubforum_lang(){

global $l, $globals; 

$l['no_forum_specified_title'] = 'No forum specified';
$l['no_forum_specified'] = 'Sorry, we were unable to unsubscribe to any forum because the forum was not specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['unsubscription_error_title'] = 'Unsubscription error';
$l['unsubscription_error'] = 'Sorry, we were unable to unsubscribe to the forum you specified because the connection with the database failed. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

}//End of function
?>