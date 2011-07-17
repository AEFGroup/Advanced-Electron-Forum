<?php

//////////////////////////////////////////////////////////////
//===========================================================
// ban_lang.php(languages/english)
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


$l['cant_ban_title'] = 'No Permissions';
$l['cant_ban'] = 'Sorry, you do not have permissions to ban any user. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_action_specified_title'] = 'No Action Specified';
$l['no_action_specified'] = 'You did not specify any action to perform on the user. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_user_specified_title'] = 'No User Specified';
$l['no_user_specified'] = 'You did not specify any user to be banned. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_user_found_title'] = 'No User Found';
$l['no_user_found'] = 'Sorry, we were unable to process your request because there is no such member on the Board. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';


//////////////////////////////////////////
//Function putban() strings - Bans a User
//////////////////////////////////////////

function putban_lang(){

global $l, $globals;

$l['cant_ban_root_admin_title'] = 'Cannot Ban';
$l['cant_ban_root_admin'] = 'Sorry, we were unable to process your request because the Root Admin cannot be Banned. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['cant_ban_yourself_title'] = 'Cannot Ban';
$l['cant_ban_yourself'] = 'Sorry, we were unable to process your request because a user cannot be Banned by themselves. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['cant_ban_other_admin_title'] = 'Cannot Ban';
$l['cant_ban_other_admin'] = 'Sorry, we were unable to process your request because an Admin cannot ban another admin except the Root Admin. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['banning_user'] = 'Banning user ';
$l['no_days'] = 'You did not enter the Number of days to ban the user for.';
$l['invalid_days'] = 'The number of days you specified is invalid.';

$l['ban_error_title'] = 'Ban Error';
$l['ban_error'] = 'There were some errors while banning the user. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

//Theme Strings
$l['<title>'] = 'Ban a User';
$l['ban_heading'] = 'Ban user';
$l['user'] = 'User';
$l['num_days'] = 'Number of Days';
$l['submit_button'] = 'Ban User';

}


////////////////////////////////////////////
//Function liftban() strings - UnBans a User
////////////////////////////////////////////

function liftban_lang(){

global $l, $globals;

$l['cant_unban_yourself_title'] = 'Cannot Lift Ban';
$l['cant_unban_yourself'] = 'Sorry, we were unable to process your request because a user cannot Remove their Ban by themselves. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['cant_unban_other_admin_title'] = 'Cannot Remove Ban';
$l['cant_unban_other_admin'] = 'Sorry, we were unable to process your request because an Admin cannot remove ban of another admin except the Root Admin. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['unban_error_title'] = 'Remove Ban Error';
$l['unban_error'] = 'There were some errors while removing the ban of the user. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

}


?>