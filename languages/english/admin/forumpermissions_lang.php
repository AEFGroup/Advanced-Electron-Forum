<?php

/////////////////////////////////////////////////////////////////
//===============================================================
// index_lang.php(languages/english/admin)
//===============================================================
// AEF : Advanced Electron Forum 
// Version : 1.0.9
// Inspired by Pulkit and taken over by Electron
// Extract text from admin files by oxlo (16th January 2008).
// --------------------------------------------------------------
// Started by: Electron, Ronak Gupta, Pulkit Gupta
// Date:       23rd Jan 2006
// Time:       15:00 hrs
// Site:       http://www.anelectron.com/ (Anelectron)
// --------------------------------------------------------------
// Please Read the Terms of use at http://www.anelectron.com
// --------------------------------------------------------------
//===============================================================
// (C)AEF Group All Rights Reserved.
//===============================================================
/////////////////////////////////////////////////////////////////

$l['no_forum'] = 'No forum specified';
$l['no_forum_exp'] = 'Sorry, we were unable to process your request because  you did not specify the forum which you wish to edit. Please go back and select the forum you wish to edit.';
$l['no_user_group'] = 'No user group specified';
$l['no_user_group_exp'] = 'Sorry, we were unable to process your request because you did not specify the user group which you wish to edit. Please go back and select the user group you wish to edit.';
$l['processing_problem'] = 'Processing Problem';
$l['processing_problem_exp'] = 'Sorry, we were unable to process your request because the forum permissions could noot be loaded.';
$l['invalid_user_group'] = 'Invalid User Group';
$l['invalid_user_group_exp'] = 'Sorry, we were unable to process your request because  there is no forum permissions for the specified user group and forum. If you would like to create a forum permission for the same, please click <a href="'.$globals['index_url'].'act=admin&adact=fpermissions&seadact=createfpermissions&fpfid=&aefv-1;&fpug=&aefv-2;">here</a>.';
$l['del_perm_error'] = 'Delete Forum Permission Error';
$l['del_perm_error_exp'] = 'There were some errors in deleting the specified forum permission set.';
$l['no_forum_posted'] = 'The Forum was not Posted.';
$l['invalid_forum_posted'] = 'The Forum that you submitted is invalid.';
$l['no_group_posted'] = 'The User Group was not Posted.';
$l['group_perm_created'] = 'The User Group that you submitted is already created for this forum.';
$l['user_group_invalid'] = 'The User Group that you submitted is invalid.';
$l['create_perm_error'] = 'Forum Permission Set Error';
$l['create_perm_error_exp'] = 'There were some errors in creating the Forum Permission Set for the Forum <b>'.$board['fname'].'</b>.';


// Theme Strings
$l['forum_perm'] = 'Forum Permission Options';
$l['forum_perm_exp'] = 'In this section you can create, edit and delete special forum permission sets for different user groups. A user group like guests could be given permissions to post in selected forums if they dont have the global permissions to post. But a user group having a global permission to post could still post even if he does not have the forum permissions and is permitted to view the forum.<br />Also if forum permissions for a user group are not created the global permissions of that group will be applied. Please Click on the User Group Name besides the Forum Name to edit it.';
$l['cp_forum_perm'] = 'Administration Center - Manage Forum Permissions';
$l['edit_forum'] = 'Edit Forum Permissions';
$l['short'] = '--';

$l['cp_edit_forum'] = 'Administration Center - Edit Forum Permissions';
$l['start_topics'] = 'Start Topics:';
$l['start_topics_exp'] = 'With this a user will be able to start a new topic in this forum.';
$l['reply_topics'] = 'Reply to Topics:';
$l['reply_topics_exp'] = 'Should the group be allowed to post in topics in this forum.';
$l['vote_polls'] = 'Vote in Polls:';
$l['vote_polls_exp'] = 'Should the group be allowed to vote in polls in this forum.';
$l['start_polls'] = 'Start Polls:';
$l['start_polls_exp'] = 'Should the group be allowed to start polls in this forum.';
$l['attach_files'] = 'Can Attach files:';
$l['attach_files_exp'] = 'Should the group be allowed to attach files while posting in this forum.';
$l['download_attach'] = 'Can Download Attachments:';
$l['download_attach_exp'] = 'Should the group be allowed to Download Attachments in this forum.';
$l['submit_changes'] = 'Submit Changes';
$l['delete_perm'] = 'Delete Permission Set';

$l['cp_edit_forum'] = 'Administration Center - Edit Forum Permissions';
$l['cp_create_forum'] = 'Administration Center - Create Forum Permissions';
$l['create_forum_perm'] = 'Create Forum Permissions';
$l['forum'] = 'Forum:';
$l['forum_exp'] = 'Choose the forum to which this Permission Set will apply.';
$l['user_group'] = 'User Group:';
$l['user_group_exp'] = 'Choose the User Group to which this Permission Set will apply.';


?>