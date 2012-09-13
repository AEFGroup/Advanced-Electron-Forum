<?php

//////////////////////////////////////////////////////////////
//===========================================================
// poll_lang.php(languages/english)
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


//////////////////////////////////////////////////////
//Function handle_vote() strings - Handles your vote
//////////////////////////////////////////////////////

function handle_vote_lang(){

global $l, $globals; 

$l['no_option_title'] = 'Poll Error';
$l['no_option'] = 'Sorry, we were unable to add your vote to the poll because you did not select any option. Please choose your option and then submit.';

$l['invalid_option_title'] = 'Poll Error';
$l['invalid_option'] = 'Sorry, we were unable to add your vote to the poll because the Option you have choosed does not belong to this poll.';

$l['vote_error_title'] = 'Voting Error';
$l['vote_error'] = 'There were some errors while adding your vote. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_poll_error_title'] = 'Voting Error';
$l['update_poll_error'] = 'There were some errors in adding your vote to the Poll. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['no_vote_permissions_title'] = 'Voting Error';
$l['no_vote_permissions'] = 'You do not have permissions to vote in this poll. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['did_not_vote_title'] = 'Voting Error';
$l['did_not_vote'] = 'You have not even voted in this Poll till now. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['delete_vote_error_title'] = 'Voting Error';
$l['delete_vote_error'] = 'Sorry, we were unable to delete your vote from the poll. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['update_poll_delvote_title'] = 'Voting Error';
$l['update_poll_delvote'] = 'There were some errors in deleting your vote from the Poll. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['cant_delete_vote_title'] = 'Voting Error';
$l['cant_delete_vote'] = 'Sorry, you are not allowed to delete your vote in this poll because you might have not voted or this feature is not enabled. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

}//End of function


//////////////////////////////////////////////////
//Function removepoll() strings - Removes a Poll
//////////////////////////////////////////////////

function removepoll_lang(){

global $l, $globals; 

$l['no_poll_specified_title'] = 'No poll specified';
$l['no_poll_specified'] = 'Sorry, we were unable to perform any action as the Poll ID was not specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_remove_permissions_title'] = 'Access Denied';
$l['no_remove_permissions'] = 'Sorry, you are not allowed to remove the poll as you do not have the permissions to do so. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['remove_poll_error_title'] = 'Remove Poll Error';
$l['remove_poll_error'] = 'Sorry, we were unable to remove the poll. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['remove_options_error_title'] = 'Remove Poll Error';
$l['remove_options_error'] = 'Sorry, we were unable to remove the poll options. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['remove_vote_error_title'] = 'Remove Poll Error';
$l['remove_vote_error'] = 'Sorry, we were unable to remove the poll votes. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_topic_error_title'] = 'Remove Poll Error';
$l['update_topic_error'] = 'Sorry, we were unable to update the topic. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

}//End of function


////////////////////////////////////////////
//Function editpoll() strings - Edit a poll
////////////////////////////////////////////

function editpoll_lang(){

global $l, $globals; 

$l['no_poll_specified_title'] = 'No poll specified';
$l['no_poll_specified'] = 'Sorry, we were unable to perform any action as the Poll was not specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_poll_forum_found_title'] = 'No forum found';
$l['no_poll_forum_found'] = 'The forum you specified either does not exists or you are not authorised to view the same. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_forum_found_title'] = 'No forum found';
$l['no_forum_found'] = 'The forum you specified either does not exists or you are not authorised to view the same. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_edit_permissions_title'] = 'Access Denied';
$l['no_edit_permissions'] = 'Sorry, you are not allowed to edit the poll as you do not have the permissions to do so. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['editing_poll'] = 'Editing Poll';
$l['no_question'] = 'You did not enter the polls question.';
$l['question_too_long'] = 'The polls question cannot have more than &aefv-1; characters.';
$l['no_expiry'] = 'The polls expiry was not set.';
$l['no_show_when'] = 'You did not choose when to show the polls results.';
$l['invalid_show_when'] = 'The option you have choosen to show the polls results is invalid.';
$l['show_after_what_expiry'] = 'You have choosen to show the polls results after the poll expires. But the expiry is not set for the same.';
$l['no_options'] = 'The options of the poll were empty.';
$l['atleast_two_options'] = 'There must be atleast two options for the poll.';

$l['delete_options_error_title'] = 'Edit Poll Error';
$l['delete_options_error'] = 'Sorry, we were unable to delete the old poll options that you left blank. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['insert_options_error_title'] = 'Edit Poll Error';
$l['insert_options_error'] = 'Sorry, we were unable to insert the new poll options. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

//Theme Strings
$l['<title>'] = 'Edit the poll';
$l['edit_poll_heading'] = 'Edit the poll';
$l['poll_question'] = 'Poll Question';
$l['lock_voting'] = 'Lock Voting';
$l['lock_voting_exp'] = 'If enabled then new votes will not be allowed.';
$l['can_change_vote'] = 'Can Change Vote';
$l['can_change_vote_exp'] = 'If enabled then a user who has voted will be allowed to change his vote.';
$l['expires_in'] = 'Expires In';
$l['expires_in_exp'] = 'If set then new votes will not be allowed after the expired time. (Enter number of days)';
$l['show_poll_results'] = 'Show Poll Results';
$l['show_anyone'] = 'To anyone.';
$l['show_after_vote'] = 'After someone has voted.';
$l['show_after_expiry'] = 'After the poll has expired.';
$l['poll_options'] = 'Poll Options';
$l['poll_options_exp'] = 'To remove current options leave them empty.';
$l['additional_options'] = 'Additional Options (Unused):';
$l['submit_button'] = 'Submit';

}//End of function


///////////////////////////////////////////////////////
//Function postpoll() strings - Adds a Poll to a topic
///////////////////////////////////////////////////////

function postpoll_lang(){

global $l, $globals; 

$l['no_topic_specified_title'] = 'Post Poll error';
$l['no_topic_specified'] = 'We cannot start any new poll because the topic ID is missing. If you have any queries please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_poll_forum_found_title'] = 'No forum found';
$l['no_poll_forum_found'] = 'The forum you specified either does not exists or you are not authorised to view the same. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_forum_found_title'] = 'No forum found';
$l['no_forum_found'] = 'The forum you specified either does not exists or you are not authorised to view the same. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['adding_poll'] = 'Adding Poll';
$l['no_question'] = 'You did not enter the polls question.';
$l['question_too_long'] = 'The polls question cannot have more than &aefv-1; characters.';
$l['no_expiry'] = 'The polls expiry was not set.';
$l['no_show_when'] = 'You did not choose when to show the polls results.';
$l['invalid_show_when'] = 'The option you have choosen to show the polls results is invalid.';
$l['show_after_what_expiry'] = 'You have choosen to show the polls results after the poll expires. But the expiry is not set for the same.';
$l['no_options'] = 'The options of the poll were empty.';
$l['atleast_two_options'] = 'There must be atleast two options for the poll.';

$l['add_poll_error_title'] = 'Add Poll Error';
$l['add_poll_error'] = 'There were some errors while adding the poll to the topic. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['insert_options_error_title'] = 'Add Poll Error';
$l['insert_options_error'] = 'Sorry, we were unable to insert the new poll options. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['update_poll_error_title'] = 'Add Poll Error';
$l['update_poll_error'] = 'There was an error in updating the topic for the poll. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

//Theme Strings
$l['<title>'] = 'Post a poll';
$l['add_poll_heading'] = 'Add poll';
$l['poll_question'] = 'Poll Question';
$l['lock_voting'] = 'Lock Voting';
$l['lock_voting_exp'] = 'If enabled then new votes will not be allowed.';
$l['can_change_vote'] = 'Can Change Vote';
$l['can_change_vote_exp'] = 'If enabled then a user who has voted will be allowed to change his vote.';
$l['expires_in'] = 'Expires In';
$l['expires_in_exp'] = 'If set then new votes will not be allowed after the expired time. (Enter number of days)';
$l['show_poll_results'] = 'Show Poll Results';
$l['show_anyone'] = 'To anyone.';
$l['show_after_vote'] = 'After someone has voted.';
$l['show_after_expiry'] = 'After the poll has expired.';
$l['poll_options'] = 'Poll Options';
$l['submit_button'] = 'Add Poll';

}//End of function
?>