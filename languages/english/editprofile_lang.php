<?php

//////////////////////////////////////////////////////////////
//===========================================================
// editprofile_lang.php(languages/english)
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


$l['cant_edit_profile_title'] = 'No Permissions';
$l['cant_edit_profile'] = 'Sorry, you do not have the permissions to edit the profiles of other members on the Board. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_user_specified_title'] = 'No User Specified';
$l['no_user_specified'] = 'Sorry, we were unable to process your request because no member id was specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_user_found_title'] = 'No User Found';
$l['no_user_found'] = 'Sorry, we were unable to process your request because there is no such member on the Board. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['cant_edit_other_admin_title'] = 'Cannot Edit';
$l['cant_edit_other_admin'] = 'Sorry, we were unable to process your request because an Admin cannot edit the profile of another admin except the Root Admin. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['editing_profile'] = 'Editing the profile of ';

//Posting Errors
$l['no_username'] = 'You did not enter the username for this user.';
$l['max_name_length_crossed'] = 'The username length cannot be greater than '.$globals['max_uname'].' characters.';
$l['min_name_length_crossed']  = 'The username length cannot be less than '.$globals['min_uname'].' characters.';
$l['space_in_name'] = 'Usernames cannot contain white spaces.';
$l['name_in_use'] = 'The username <b>&aefv-1;</b> is already in use.';
$l['reserved_names'] = 'The username cannot contain the word(s) &aefv-1;.';
$l['no_email'] = 'You did not enter the users email address.';
$l['email_too_big'] = 'The email address is too large.';
$l['invalid_email'] = 'The email address is invalid.';
$l['email_in_use'] = 'The email address you specified is already in use.';
$l['no_user_group'] = 'You did not select the user group.';
$l['invalid_user_group'] = 'The User Group that you submitted is invalid.';
$l['root_admin_user_group'] = 'The Root admins user group cannot be changed.';
$l['root_admin_ug_other_admin'] = 'Only the Root Admin can change the user group of another Admin.';
$l['root_admin_make_admin'] = 'Only the Root Admin can make another Admin.';
$l['big_realname'] = 'The real name cannot be greater than '.$globals['realnamelen'].' Chararcters.';
$l['big_custom_title'] = 'The Custom title cannot be greater than '.$globals['customtitlelen'].' Characters.';
$l['big_location'] = 'The Location cannot be greater than '.$globals['locationlen'].' Characters.';
$l['invalid_gender'] = 'The Gender value is incorrect.';
$l['big_private_text'] = 'The Private Text cannot be greater than '.$globals['userstextlen'].' Characters.';
$l['invalid_icq'] = 'The ICQ Information is invalid.';
$l['invalid_yim'] = 'The YIM Information is invalid.';
$l['invalid_msn'] = 'The MSN Information is invalid.';
$l['invalid_aim'] = 'The AIM Information is invalid.';
$l['big_www'] = 'The URL you specified cannot be greater than '.$globals['wwwlen'].' Chararcters.';
$l['big_signature'] = 'The Signature cannot be greater than '.$globals['usersiglen'].' Chararcters.';

//Theme Strings
$l['<title>'] = 'Edit the Profile of';
$l['edit_heading'] = 'Edit Profile of';
$l['members_username'] = 'Username';
$l['email_address'] = 'Email Address';
$l['email_address_exp'] = 'Enter members email address here.';
$l['user_group'] = 'User Group';
$l['user_group_exp'] = 'Enter members user group.';
$l['real_name'] = 'Real Name';
$l['real_name_exp'] = 'This name will be visible in the Profile.';
$l['custom_title'] = 'Custom Title';
$l['location'] = 'Location';
$l['location_exp'] = 'Enter the users Location.';
$l['gender'] = 'Gender';
$l['gender_exp'] = 'Select the users Gender.';
$l['male'] = 'Male';
$l['female'] = 'Female';
$l['private_text'] = 'Private Text';
$l['private_text_exp'] = 'This text will appear in the users posts alongwith the Member Group, Posts etc.';
$l['icq'] = 'ICQ';
$l['yim'] = 'YIM';
$l['msn'] = 'MSN';
$l['aim'] = 'AIM';
$l['www'] = 'WWW';
$l['signature'] = 'Signature';
$l['signature_exp'] = 'The signature will be displayed at the end of every post and PM of this user.';
$l['submit_button'] = 'Edit Profile';


?>