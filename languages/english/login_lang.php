<?php

//////////////////////////////////////////////////////////////
//===========================================================
// locktopic.php(languages/english)
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


$l['logged_in_title'] = 'Already Logged In';
$l['logged_in'] = 'You are already logged in to the forum. You may go to the Main Forum Index and use the Boards Facilities.<br />If you wish to Log Out please click <a href="'.$globals['index_url'].'act=logout">here</a><br /><br />Thank You!';

/////////////////////////////////////////////////////////
//Function mainlogin() strings - The Actual Login Page
/////////////////////////////////////////////////////////

function mainlogin_lang(){

global $l, $globals; 

$l['exceeded_attempts_title'] = 'Too Many Attempts';
$l['exceeded_attempts'] = 'As you have made &aefv-1; failed attempts to Sign In you will not be allowed to log in.';

$l['no_username'] = 'You did not enter your username.';
$l['no_password'] = 'You did not enter your password.';
$l['wrong_username'] = 'The username you entered does not exist.';//The username does not exist
$l['wrong_password'] = 'Username and password do not match.';
$l['no_maintenance_permission'] = 'Your account is not allowed to view this Board in Maintenance Mode.';

$l['validation_required_title'] = 'Validation Required';
$l['validation_required'] = 'Sorry, we were unable to Sign you in because you have not validated your email address. Please follow the instructions send to you in an email.<br /><br />If you have not recieved an activation code please click <a href="'.$globals['index_url'].'act=register&regact=resendact">here</a>.';

$l['approval_pending_title'] = 'Admin Approval Pending';
$l['approval_pending'] = 'Sorry, we were unable to sign you in because your account has not been approved by the Administrator. You will be notified at once when the Administrator approves of your account.<br /><br />If you have any queries contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['coppa_approval_title'] = 'Admin Approval Pending';
$l['coppa_approval'] = 'Sorry, we were unable to sign you in because your account has not been approved by the Administrator. Your account will be approved by the Administrator on recieving consent from your parents to join the Forums. You will be notified at once when the Administrator approves of your account.<br /><br />If you have any queries contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['sign_in_error_title'] = 'Sign In Error';
$l['sign_in_error'] = 'Sorry, we were unable to Sign you in because the connection with the Database failed. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

//Theme strings
$l['<title>'] = 'Login';
$l['maintenance_mode'] = 'Maintenance Mode';
$l['forgot_username'] = 'I\'ve forgotten my username';
$l['forgot_username_desc'] = 'If you have forgotten your username for your account on this board we can email your username.';//A small description
$l['forgot_password'] = 'Forgot my password';
$l['forgot_password_desc'] = 'You can reset your password by answering your secret question Or we can send you another password to login into your account.';
$l['sign_up'] = 'Sign Up';
$l['sign_up_desc'] = 'Haven\'t registered for an account yet ? What were you doing all time !';
$l['resend_activation'] = 'Resend Activation Code';
$l['resend_activation_desc']  = 'If you have not recieved your activation code yet, please request for another one.';
$l['sign_in_heading'] = 'Sign In to your Account';
$l['remember_me'] = 'Remember me on this computer.';
$l['anon_sign_in'] = 'Sign In anonymously.';
$l['sign_in'] = 'Sign In';

}//End of function

//////////////////////////////////////////////////
//Function fpass() strings - Forgot Password Page
//////////////////////////////////////////////////

function fpass_lang(){

global $l, $globals; 

$l['fpass'] = 'Forgot Password';//For 'You are here'
$l['no_username'] = 'You did not enter your username.';
$l['space_in_username'] = 'Usernames cannot contain white spaces.';
$l['wrong_username'] = 'The username you entered does not exist.';//The username does not exist

$l['reset_password_set_title'] = 'Reset Password Error';
$l['reset_password_set'] = 'The reset password instructions have already been mailed to the user account you specified. Please Check your email box.<br /><br />Thankyou!';

$l['no_security_code'] = 'You did not enter the Security Code.';
$l['wrong_security_code'] = 'The Security Code does not match.';
$l['no_secret_answer'] = 'There is no secret question and answer set for the specified account.';

$l['new_password_error_title'] = 'New Password Error';
$l['new_password_error'] = 'Sorry, we were unable to reset your password because the connection with the Database failed. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

//Reset Password Mail
$l['reset_password_mail_subject'] = 'Reset your password for '.$globals['sn'];
$l['reset_password_mail'] = 'Hello &aefv-1;,

We have recieved a request to reset your password as you have forgotten it.
To do so please visit the following link:

'.$globals['mail_url'].'act=login&logact=reset&rcode=&aefv-2;

If clicking the link above does not work, copy and paste the URL in a
new browser window instead.

When you visit that page, you will be allowed to enter your new password.
If you have not requested to reset your password please ignore this email and the link will expire and become useless after 24 hours.

Thankyou!

The '.$globals['sn'].' Team
'.$globals['url'].'/

Reset code: &aefv-2;';

//The message that will be shown after instructions are mailed
$l['reset_pass_mailsent_title'] = 'Reset Password Mail Sent';
$l['reset_pass_mailsent'] = 'A mail has been sent to your email address with instructions for resetting your account password. Please follow the instructions and the link given.<br /><br />When you visit that link, you will be allowed to enter your new password. The link will expire and become useless after 24 hours.<br /><br />Thankyou!';

//Theme strings
$l['<title>'] = 'Forgot Password';
$l['give_username'] = 'Please give the username';
$l['security_code'] = 'Security Code';
$l['security_code_exp'] = 'Type the characters you see in the picture below.';//A small text
$l['answer_question'] = 'Answer the question to reset your password immediately.';
$l['submit'] = 'Submit';

}//End of function


//////////////////////////////////////////////////////////
//Function answer() strings - Answer Secret Question Page
//////////////////////////////////////////////////////////

function answer_lang(){

global $l, $globals; 

$l['answering_question'] = 'Answering Secret Question';

$l['error_retrieving_qt_ans_title'] = 'New Password Error';
$l['error_retrieving_qt_ans'] = 'Sorry, there were some errors while retrieving the question and answer of the account. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

$l['no_answer'] = 'You did not enter your answer.';
$l['wrong_answer'] = 'The answers do not match.';

//Theme strings
$l['<title>'] = 'Answer the Question';
$l['answer_question_below'] = 'Answer the following question to reset your password:';
$l['answer'] = 'Answer :';
$l['submit_answer'] = 'Submit Answer';

}//End of function


/////////////////////////////////////////////////////
//Function reset_pass() strings - Reset Password Page
/////////////////////////////////////////////////////

function reset_pass_lang(){

global $l, $globals; 

$l['reseting_password'] = 'Resetting Password';//You are here

$l['wrong_reset_code_title'] = 'Reset Password Error';
$l['wrong_reset_code'] = 'The reset code you have provided is invalid. Please check the email sent to you. If you have any problem please contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>';

$l['reset_code_expired_title'] = 'Reset Code Expired';
$l['reset_code_expired'] = 'The reset code you have provided has expired and is now invalid. Please reset your password again and follow the link at your earliest convenience but within 24 hours. If you have any problem please contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>';

$l['no_new_password'] = 'You did not enter your new password.';
$l['password_too_big'] = 'Your Password length cannot be greater than &aefv-1; characters.';
$l['password_too_small'] = 'Your Password length cannot be less than &aefv-1; characters.';
$l['no_confirm_password'] = 'You did not enter the confirmation password.';
$l['passwords_dont_match'] = 'Your Passwords do not match each other.';

$l['delete_code_error_title'] = 'Reset Code Error';
$l['delete_code_error'] = 'Your password was reset successfully but there were errors deleting the Reset Code. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

//The message that will be shown after the password has been changed successfully
$l['reset_pass_success_title'] = 'Reset Password Successful';
$l['reset_pass_success'] = 'Your password has been reset successfully. You may now <a href="'.$globals['index_url'].'act=login">Sign In</a> to your account and start posting in the forums.<br /><br />Thankyou!';

//Theme strings
$l['<title>'] = 'Reset your password';
$l['reset_password_heading'] = 'Reset your account password';
$l['new_password'] = 'New Password';
$l['password_conf'] = 'Password Confirmation';
$l['submit_pass'] = 'Submit Password';

}//End of function


//////////////////////////////////////////////////
//Function fuser() strings - Forgot Username Page
//////////////////////////////////////////////////

function fuser_lang(){

global $l, $globals; 

$l['fuser'] = 'Forgot Username';
$l['no_email'] = 'You did not enter your email address.';
$l['invalid_email'] = 'The email is not in proper format.';
$l['no_security_code'] = 'You did not enter the Security Code.';
$l['wrong_security_code'] = 'The Security Code does not match.';
$l['email_not_found'] = 'There is no such email in our system.';

//Reset Username Mail
$l['reset_username_mail_subject'] = $globals['sn'].' Username Assistance';
$l['reset_username_mail'] = 'Hello,

We have recieved a request to remind you your username for your account at '.$globals['sn'].'.

Your username is : &aefv-1;

To sign in, visit the link below.

'.$globals['index_url'].'act=login
If clicking the link above does not work, copy and paste the URL in a
new browser window instead.

Thankyou!

The '.$globals['sn'].' Team
'.$globals['url'].'/';

//The message that will be shown after instructions are mailed
$l['fuser_mailsent_title'] = 'Username Assistance Mail Sent';
$l['fuser_mailsent'] = 'An email has been sent to <b>&aefv-1;</b> containing your username for your account at '.$globals['sn'].'.<br /><br />If you have any problems or queries regarding your account please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.<br /><br />
Thankyou!';

//Theme strings
$l['<title>'] = 'Forgot Username';
$l['give_email'] = 'Please give the email';
$l['email'] = 'Email';
$l['security_code'] = 'Security Code';
$l['security_code_exp'] = 'Type the characters you see in the picture below.';//A small text
$l['submit'] = 'Submit';

}//End of function

?>