<?php

/////////////////////////////////////////////////////////////////
//===============================================================
// approvals_lang.php(languages/english/admin)
//===============================================================
// AEF : Advanced Electron Forum 
// Version : 1.0.10
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

$l['action_invalid'] = 'The action you specified is invalid.';
$l['not_select_members'] = 'You did not select any members.';
$l['no_members_found'] = 'No Members Found';
$l['no_members_id_found'] = 'Sorry, we were unable to process your request because no members were found having the user id specified by you.';
$l['error'] = 'Error';
$l['errors_updating'] = 'There were some errors in updating the users activation status.';
$l['subject_mail_activated'] = 'Welcome to ';
$l['body_mail_activated'] = ',
   Congratulations your account at ' . $globals['sn'] . ' has been activated by the Admin.
            
You may now login to your account at ' . $globals['mail_url'] . 'act=login
and start Posting into threads and topics on the Forum.
Alternatively, you may change your Account Settings or 
Profile through the UserCP at ' . $globals['mail_url'] . 'act=usercp

Please keep this email for your records.

Enjoy!

The ' . $globals['sn'] . ' Team

' . $globals['url'] . '/

User ID: ';

$l['errors_deleting'] = 'There were some errors in deleting the users.';
$l['subject_mail_account_deleted'] = 'Account Rejected/Deleted at ';
$l['body_mail_account_deleted'] = ',
   Your account at ' . $globals['sn'] . ' has been deleted/rejected by the Admin.            
You cannot use your account at ' . $globals['sn'] . '.

The ' . $globals['sn'] . ' Team

' . $globals['url'] . '/';

//Theme Strings
$l['cp_validating'] = 'Administration Center - Manage Validating';
$l['manage_validating'] = 'Manage Validating';
$l['members_validate_accounts'] = 'Below is a list of members on the board who are to validate their accounts.';
$l['sort_by'] = 'Sort by: ';
$l['user_id'] = 'User ID';
$l['username'] = 'Username';
$l['email'] = 'Email';
$l['registration_time'] = 'Registration Time';
$l['ascending'] = 'Ascending';
$l['descending'] = 'Descending';
$l['page'] = 'Page : ';
$l['go'] = 'Go';
$l['with_selected'] = 'With Selected : ';
$l['activate'] = 'Activate';
$l['activate_send_mail'] = 'Activate and Send Mail';
$l['delete'] = 'Delete';
$l['delete_send_mail'] = 'Delete and Send Mail';
$l['id'] = 'ID';
$l['registered_on'] = 'Registered On';
$l['no_members_activate_accounts'] = 'There are no members who have to activate their accounts.';

$l['cp_approvals'] = 'Administration Center - Users Awaiting Approval';
$l['users_awaiting_approval'] = 'Users Awaiting Approval';
$l['require_admins_approval'] = 'Below is a list of members on the board who require Admins Approval.';
$l['no_approval_required'] = 'There are no members who require Admin approval.';

$l['cp_coppa'] = 'Administration Center - COPPA Users Awaiting Approval';
$l['coppa_users_awaiting_approval'] = 'COPPA Users Awaiting Approval';
$l['members_require_coppa_admins_approval'] = 'Below is a list of members on the board who require Admins Approval for their age restrictions';
$l['no_members_require_coppa'] = 'There are no members who fall below age and require Admin approval.';
?>