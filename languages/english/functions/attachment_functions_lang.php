<?php

//////////////////////////////////////////////////////////////
//===========================================================
// attachment_functions_lang.php(languages/english/functions)
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


////////////////////////////////////////////////////////////
//Function attach_fn() strings - Attaches a file to a topic
////////////////////////////////////////////////////////////

function attach_fn_lang(){

global $l, $globals; 

$l['load_mime_error_title'] = 'Attachment error';
$l['load_mime_error'] = 'Sorry, we were unable to upload your attachments in this topic as the mimetypes of allowed files could not be loaded. The topic/post was however entered properly. If you wish to go to the topic please click <a href="'.$globals['index_url'].'tid=&aefv-1;">here</a>. <br /><br />Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['upload_error_title'] = 'Attachment error';
$l['upload_error'] = 'Sorry, we were unable to upload your attachments in this topic because the file <b>&aefv-1;</b> was not properly uploaded to the system. The topic/post was however entered properly. If you wish to go to the topic please click <a href="'.$globals['index_url'].'tid=&aefv-2;">here</a>. <br /><br />If you have any queries please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['file_not_allowed_title'] = 'Attachment error';
$l['file_not_allowed'] = 'Sorry, we were unable to upload your attachments in this topic because the filetype of the file <b>&aefv-1;</b> is not permitted to be uploaded. The topic/post was however entered properly. If you wish to go to the topic please click <a href="'.$globals['index_url'].'tid=&aefv-2;">here</a>. <br /><br />If you have any queries please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['attachment_too_big_title'] = 'Attachment Size Error';
$l['attachment_too_big'] = 'Sorry, we were unable to upload your attachments in this topic because the size of the file <b>&aefv-1;</b> is more than the allowed size per attachment of '.$globals['maxattachsize'].'. The topic/post was however entered properly. If you wish to go to the topic please click <a href="'.$globals['index_url'].'tid=&aefv-2;">here</a>. <br /><br />If you have any queries please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['attachments_size_big_title'] = 'Attachments Size Error';
$l['attachments_size_big'] = 'Sorry, we were unable to upload your attachments in this topic because the size of the files exceeded the allowed size per post of '.$globals['maxattachsizepost'].'. The topic was however entered properly. If you wish to go to the topic please click <a href="'.$globals['index_url'].'tid=&aefv-1;">here</a>. <br /><br />If you have any queries please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['update_post_error_title'] = 'Update Post Error';
$l['update_post_error'] = 'Sorry, we were unable to update the post for the attachments. The topic/post was however entered properly and the attachments were also saved. If you wish to go to the topic please click <a href="'.$globals['index_url'].'tid=&aefv-1;">here</a>. <br /><br />Please contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_topic_error_title'] = 'Update Topic Error';
$l['update_topic_error'] = 'Sorry, we were unable to update the topic for the attachments. The topic/post was however entered properly and the attachments were also saved. If you wish to go to the topic please click <a href="'.$globals['index_url'].'tid=&aefv-1;">here</a>. <br /><br />Please contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['attach_error_title'] = 'Attachment error';
$l['attach_error'] = 'Sorry, we were unable to upload the file(s) <b>&aefv-1;</b>. The topic/post was however entered properly and the attachments were also saved. If you wish to go to the topic please click <a href="'.$globals['index_url'].'tid=&aefv-2;">here</a>. <br /><br />Please contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

}


////////////////////////////////////////////////////////////////
//Function dettach_fn() strings - De-Attaches a file from a topic
/////////////////////////////////////////////////////////////////

function dettach_fn_lang(){

global $l, $globals; 

$l['update_post_error_title'] = 'Update Post Error';
$l['update_post_error'] = 'Sorry, we were unable to update the post for the attachments. The topic/post was however entered properly and the attachments were also deleted. If you wish to go to the topic please click <a href="'.$globals['index_url'].'tid=&aefv-1;">here</a>. <br /><br />Please contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_topic_error_title'] = 'Update Topic Error';
$l['update_topic_error'] = 'Sorry, we were unable to update the topic for the attachments. The topic/post was however entered properly and the attachments were also deleted. If you wish to go to the topic please click <a href="'.$globals['index_url'].'tid=&aefv-1;">here</a>. <br /><br />Please contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['dettach_error_title'] = 'Dettach error';
$l['dettach_error'] = 'Sorry, we were unable to delete the file(s) <b>&aefv-1;</b>. The topic/post was however entered properly. If you wish to go to the topic please click <a href="'.$globals['index_url'].'tid=&aefv-2;">here</a>. <br /><br />Please contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

}

?>