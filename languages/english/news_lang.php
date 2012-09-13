<?php

//////////////////////////////////////////////////////////////
//===========================================================
// news_lang.php(languages/english)
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


$l['news_disabled_title'] = 'News Disabled';
$l['news_disabled'] = 'News system is disabled on this board. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['news'] = 'News';

///////////////////////////////////////////////
//Function shownews() strings - The News Page
///////////////////////////////////////////////

function shownews_lang(){

global $l, $globals; 

//Theme Strings
$l['<title>'] = 'News';
$l['submitted_by'] = 'Submitted by';
$l['on'] = 'on';
$l['unapproved'] = 'Unapproved';
$l['edit'] = 'Edit';
$l['approve'] = 'Approve';
$l['unapprove'] = 'Unapprove';
$l['delete'] = 'Delete';
$l['full_story'] = 'Full story';
$l['delete_news'] = 'Delete News';
$l['approve_news'] = 'Approve News';
$l['unapprove_news'] = 'Unapprove News';
$l['submit_go'] = 'Go';
$l['no_news_articles'] = 'There are no news articles present in the database.';
$l['page_jump_title'] = 'Type the page to jump to';
$l['ticked'] = 'Shown in Ticker';

}//End of function


/////////////////////////////////////////////////
//Function submitnews() strings - To submit news
/////////////////////////////////////////////////

function submitnews_lang(){

global $l, $globals; 

$l['no_permission_title'] = 'Error';
$l['no_permission'] = 'You are not allowed to submit news articles on this board. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['submit_news'] = 'Submit News';

//A code to avoid refresh
$l['no_security_code'] = 'The Hidden Submit Code was not posted or is in wrong format.';
$l['wrong_security_code'] = 'Oops...the Security Confirmation Code did not match! You might have double clicked or refreshed the page.';

$l['no_title'] = 'The news title was left empty.';
$l['no_news'] = 'The news article was left empty.';

$l['submit_news_error_title'] = 'Submit News Error';
$l['submit_news_error'] = 'There were some problems while submitting the news article. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

//Theme Strings
$l['<title>'] = 'Submit News';
$l['approval_note'] = '<b>Note: </b> Your news will be visible only when it is approved by the Admins.<br /><br />';
$l['submitnews_heading'] = 'Submit News';
$l['news_title'] = 'Title';
$l['news_article'] = 'News Article';
$l['full_story_link'] = 'Full Story Link';
$l['news_image'] = 'Image';
$l['submit_button'] = 'Submit News';
$l['showinticker'] = 'Show in Ticker';

}//End of function


///////////////////////////////////////////////////////
//Function editnews() strings - To edit a news article
///////////////////////////////////////////////////////

function editnews_lang(){

global $l, $globals; 

$l['no_edit_permission_title'] = 'Error';
$l['no_edit_permission'] = 'You are not allowed to edit news articles on this board. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_news_specified_title'] = 'No News specified';
$l['no_news_specified'] = 'Sorry, we were unable to process your request because no News id was specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_news_found_title'] = 'No News Found';
$l['no_news_found'] = 'Sorry, we were unable to process your request because the news you specified was not found in the database. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['editin_news'] = 'Editing News';

$l['no_title'] = 'The news title was left empty.';
$l['no_news'] = 'The news article was left empty.';

//Theme Strings
$l['<title>'] = 'Edit News';
$l['editnews_heading'] = 'Edit News';
$l['news_title'] = 'Title';
$l['news_article'] = 'News Article';
$l['full_story_link'] = 'Full Story Link';
$l['news_image'] = 'Image';
$l['submit_button'] = 'Edit News';
$l['showinticker'] = 'Show in Ticker';

}//End of function


/////////////////////////////////////////////////////////
//Function approvenews() strings - Approve news articles
/////////////////////////////////////////////////////////

function approvenews_lang(){

global $l, $globals; 

$l['no_approve_permission_title'] = 'Access Denied';
$l['no_approve_permission'] = 'Sorry, you are not allowed to approve or unapprove news(s) as you do not have the permissions to do so. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_action_specified_title'] = 'No Action specified';
$l['no_action_specified'] = 'Sorry, we were unable to process your request because no action was specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['invalid_action_specified_title'] = 'Invalid Action specified';
$l['invalid_action_specified'] = 'Sorry, we were unable to process your request because an invalid action was specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_news_specified_title'] = 'No News specified';
$l['no_news_specified'] = 'Sorry, we were unable to process your request because the news(s) id was not specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['invalid_news_specified_title'] = 'Invalid News specified';
$l['invalid_news_specified'] = 'Sorry, we were unable to process your request because the news(s) - \'&aefv-1;\' you are trying to delete are invalid. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['approve_error_title'] = 'Approve error';
$l['approve_error'] = 'There were some errors in approving the news(s). Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['unapprove_error_title'] = 'Unapprove error';
$l['unapprove_error'] = 'There were some errors in unapproving the news(s). Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

}//End of function


/////////////////////////////////////////////////////////
//Function deletenews() strings - Approve news articles
/////////////////////////////////////////////////////////

function deletenews_lang(){

global $l, $globals; 

$l['no_delete_permission_title'] = 'Access Denied';
$l['no_delete_permission'] = 'Sorry, you are not allowed to delete news(s) as you do not have the permissions to do so. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_news_specified_title'] = 'No News specified';
$l['no_news_specified'] = 'Sorry, we were unable to process your request because the news(s) id was not specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['invalid_news_specified_title'] = 'Invalid News specified';
$l['invalid_news_specified'] = 'Sorry, we were unable to process your request because the news(s) - \'&aefv-1;\' you are trying to delete are invalid. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['delete_error_title'] = 'Delete error';
$l['delete_error'] = 'There were some errors in deleting the news(s). Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

}//End of function

?>