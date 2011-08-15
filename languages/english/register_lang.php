<?php

//////////////////////////////////////////////////////////////
//===========================================================
// register_lang.php(languages/english)
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


$l['registered_title'] = 'Already Registered';
$l['registered'] = 'You are already a registered user of the forum. Users are not allowed to register again. You may go to the Main Forum Index and use the Boards Facilities.<br />If you wish to Log Out please click <a href="' . $globals['index_url'] . 'act=logout">here</a><br /><br />Thank You!';

$l['registration_disabled_title'] = 'Registration Disabled';
$l['registration_disabled'] = 'Registration Has been disabled on the forum. Inconvenience is regretted.';

/////////////////////////////////////////////////////////
//Function mainregister() strings - The Registration Page
/////////////////////////////////////////////////////////

function mainregister_lang() {

    global $l, $globals;

    $l['same_pc_registration_title'] = 'Same PC Registration';
    $l['same_pc_registration'] = 'You are not allowed to register several times from the same computer.';

    $l['no_username'] = 'You did not enter your desired username.';
    $l['max_name_length_crossed'] = 'Your username length cannot be greater than &aefv-1; characters.';
    $l['min_name_length_crossed'] = 'Your username length cannot be less than &aefv-1; characters.';
    $l['space_in_name'] = 'Usernames cannot contain white spaces.';
    $l['name_in_use'] = 'The username <b>&aefv-1;</b> is already in use.';
    $l['reserved_names'] = 'Your username cannot contain the word(s) &aefv-1;.';
    $l['no_password'] = 'You did not enter your password.';
    $l['password_too_big'] = 'Your Password length cannot be greater than &aefv-1; characters.';
    $l['password_too_small'] = 'Your Password length cannot be less than &aefv-1; characters.';
    $l['no_confirm_password'] = 'You did not enter the confirmation password.';
    $l['passwords_dont_match'] = 'Your Passwords do not match each other.';
    $l['no_email'] = 'You did not enter your email address.';
    $l['email_too_big'] = 'Your Email Address is too large.';
    $l['invalid_email'] = 'The email is not in proper format.';
    $l['email_in_use'] = 'The email address you specified is already in use.';
    $l['no_security_code'] = 'You did not enter the Security Code.';
    $l['wrong_security_code'] = 'The Security Code does not match.';
    $l['no_time_zone'] = 'You did not select your Time Zone.';
    $l['invalid_time_zone'] = 'The Time Zone you selected is invalid.';
    $l['no_agreement'] = 'You did not agree to the Boards Terms and Rules.';

    $l['registration_error_title'] = 'Registration Error';
    $l['registration_error'] = 'There were some errors while registering you on the board. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

    $l['akismet_error'] = 'The account you are trying to register has been detected as a spammer. If this is wrong, please contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';
    
    $l['update_board_error_title'] = 'Registration Error';
    $l['update_board_error'] = 'There were some errors while updating the Board about your registration. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

//Immediate Registration
    $l['welcome_mail_subject'] = 'Welcome to ' . $globals['sn'];
    $l['welcome_mail'] = 'Congratulations on creating your brand new ' . $globals['sn'] . ' account, &aefv-1;.

You may now login to your account at ' . $globals['index_url'] . 'act=login
and start Posting into threads and topics on the Forum.
Alternatively, you may change your Account Settings or
Profile through the UserCP at ' . $globals['index_url'] . 'act=usercp

Please keep this email for your records, as it contains an
important activation code that you may need should you ever
encounter problems or forget your password.

Enjoy!

The ' . $globals['sn'] . ' Team

' . $globals['url'] . '/

Activation code: &aefv-2;';

//The message that will be shown after email are mailed
    $l['successful_message_title'] = 'Registration Successful';
    $l['successful_message'] = 'Thank you, &aefv-1;. Your Account has been sucessfully registered.<br /><br />

        You may now <a href="' . $globals['index_url'] . 'act=login">login</a> to your account and start Posting into threads and topics on the Forum.
        Alternatively, you may change your <a href="' . $globals['index_url'] . 'act=usercp&ucpact=account">Account Settings</a> or <a href="' . $globals['index_url'] . 'act=usercp&ucpact=profile">Profile</a> through the <a href="' . $globals['index_url'] . 'act=usercp">UserCP</a>.<br /><br />

        We hope you enjoy your time here on the ' . $globals['sn'] . ' Forums.';


//Activate Your Account Email
    $l['activate_account_mail_subject'] = 'Activate Account';
    $l['activate_account_mail'] = 'Dear &aefv-1;,

Thank you for registering an account at ' . $globals['sn'] . '.

Before you can use your account you must activate it.
Click on the link below to activate your account:

' . $globals['index_url'] . 'act=register&regact=validate&u=&aefv-2;&code=&aefv-3;

If the above link does not work, you will need to copy and paste the link into your web browser, or type it in by hand.

If you are still having problems signing up, please contact us at ' . $globals['board_email'] . '

Thankyou!

The ' . $globals['sn'] . ' Team
' . $globals['url'] . '/

Activation code: &aefv-3;
User ID: &aefv-2;';

//The message that will be shown after instructions are mailed
    $l['activate_message_title'] = 'Activation Required';
    $l['activate_message'] = 'Thank you, &aefv-1;, for registering an account.<br /><br />

        Before you can use your account you must activate it. An Email containing instructions for activating your account has been sent to &aefv-2;. Please follow the instructions.
        After activating the account you will be able to post on the forums.<br /><br />

        Thankyou!';

//Approval Required Email
    $l['approval_required_mail_subject'] = 'Admin Approval Required';
    $l['approval_required_mail'] = 'Dear &aefv-1;,

Thank you for registering an account at ' . $globals['sn'] . '.

Before you can use your account the Admin must activate it.
You will be notified by the Admin when your account will be approved.

If you are having any queries, please contact us at ' . $globals['board_email'] . '

Thankyou!

The ' . $globals['sn'] . ' Team
' . $globals['url'] . '/

Activation code: &aefv-3;
User ID:  &aefv-2;';

//The message that will be shown after instructions are mailed
    $l['approval_message_title'] = 'Admin Approval Required';
    $l['approval_message'] = 'Thank you, &aefv-1;, for registering an account.<br /><br />

        Before you can use your account the Admin must activate it. An Email will be sent to &aefv-2; once the Admin approves it.<br />
        After your account is approved you will be able to post on the forums.<br /><br />

        Thankyou!';


//COPPA Approval Required Email
    $l['coppa_mail_subject'] = 'Parents Consent Required.';
    $l['coppa_mail'] = 'Dear &aefv-1;,

Thank you for registering an account at ' . $globals['sn'] . '.

Before you can use your account the Admin must activate it.
Your account will be approved when consent is recieved from your parents.
You will be notified by the Admin on approval of your account.

If you are having any queries, please contact us at ' . $globals['board_email'] . '

Thankyou!

The ' . $globals['sn'] . ' Team
' . $globals['url'] . '/

Activation code: &aefv-3;
User ID: &aefv-2;';

//The message that will be shown after instructions are mailed
    $l['coppa_message_title'] = 'Parents Consent Required';
    $l['coppa_message'] = 'Thank you, &aefv-1;, for registering an account.<br /><br />

        Before you can use your account the Admin must activate it. Your account will be approved when consent is recieved from your parents. An Email will be sent to &aefv-2; once the Admin approves it.<br />
        After your account is approved you will be able to post on the forums.<br /><br />

        Thankyou!';


//Admin Email
    $l['load_admin_email_error_title'] = 'Registration Error';
    $l['load_admin_email_error'] = 'You were registered on the Board but there were some errors in loading the admins email address. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

//Admin Email
    $l['admin_mail_subject'] = 'New Registration Notification';
    $l['admin_mail'] = 'Dear Admin,

This email is to inform you that a new member, &aefv-1;, has registered at ' . $globals['sn'] . '.
Please do the needful.

Thankyou!';

//Theme strings
    $l['<title>'] = 'Register';
    $l['register_heading'] = 'Register an Account';
    $l['username'] = 'Username';
    $l['username_exp'] = 'Enter your desired Username.';
    $l['password'] = 'Password';
    $l['password_exp'] = 'Please enter a password for your user account.';
    $l['confirm_password'] = 'Confirm Password';
    $l['confirm_password_exp'] = 'Please enter your password again.';
    $l['email_address'] = 'Email Address';
    $l['email_address_exp'] = 'Please enter a valid email address for your account.';
    $l['confirmation_code'] = 'Confirmation Code';
    $l['confirmation_code_exp'] = 'Please enter the characters in the image on the left for Security Reasons.';
    $l['time_zone'] = 'Time Zone';
    $l['time_zone_exp'] = 'Please select your Timezone.';
    $l['registration_terms_header'] = 'Registration Terms and Rules';
    $l['registration_terms'] = '1) Spamming is not allowed here.<br /><br />

2) This is not a warez site! Links/Requests to warez and/or illegal material (porn, cracks, serials, etc..) , discussion of circumventing activation/timebombs/keygens or any other illegal activity will not be tolerated.<br /><br />

3) You are expected to be mature when discussing in threads. Racism, pornography, threatening, profanity, or excessive vulgarity will not be tolerated.<br /><br />

4) Post threads in the right place. If you have any questions or are confused on any matter please feel free to ask the Board Management.';
    $l['i_agree'] = 'I Agree';
    $l['submit_button'] = 'Register';
}

//End of function
//////////////////////////////////////////
//Function age() strings - COPPA Age Form
//////////////////////////////////////////

function age_lang() {

    global $l, $globals;

    $l['enter_age'] = 'Enter Age';
    $l['no_month'] = 'The Month was not entered.';
    $l['no_day'] = 'The Day was not entered.';
    $l['no_year'] = 'The Year was not entered.';
    $l['invalid_year'] = 'The Year entered is invalid.'; //Less than 1900 A.D.

    $l['reject_title'] = 'Age Restricted Board';
    $l['reject'] = 'Sorry, we are unable to register you on the Board because of age restrictions.';

//Theme strings
    $l['<title>'] = 'Enter Your Age';
    $l['age_heading'] = 'Enter Your Age';
    $l['date_of_birth'] = 'Date of Birth';
    $l['date_of_birth_exp'] = 'Please enter your Date of Birth.';
    $l['month'] = 'Month';
    $l['day'] = 'Day';
    $l['year'] = 'Year';
    $l['submit_button'] = 'Submit';
}

//End of function
//////////////////////////////////////////////
//Function coppa() strings - Shows the Policy
//////////////////////////////////////////////

function coppa_lang() {

    global $l, $globals;

    $l['coppa_policy'] = 'COPPA Policy';

    $l['coppa_policy_disagreed_title'] = 'Age Restricted Board';
    $l['coppa_policy_disagreed'] = 'Sorry, we are unable to register you on the Board because you have disagreed to abide by the Board Rules.';

//Theme strings
    $l['<title>'] = 'COPPA Policy';
    $l['coppa_heading'] = 'Age Restricted Board';
    $l['coppa_policy_heading'] = 'Forum COPPA Policy';
    $l['coppa_terms'] = 'Since you fall below the age of ' . $globals['age_limit'] . ', it is a legal requirement for this Board to recieve your parent\'s or guardians consent. Please print the <a href="' . $globals['index_url'] . 'act=register&regact=coppaform">Permission Form</a> and have it mailed or faxed to the Board Admin.';
    $l['i_agree'] = 'I Agree';
    $l['submit_button'] = 'Submit';
}

//End of function
////////////////////////////////////////////////////////
//Function validate() strings - Validates Email Address
////////////////////////////////////////////////////////

function validate_lang() {

    global $l, $globals;

    $l['validate_email'] = 'Validate Account Email'; //You are here

    $l['invalid_id_code_title'] = 'Activation Error';
    $l['invalid_id_code'] = 'The User ID or the activation code is Invalid. If you have followed a valid link please contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

    $l['already_activated_title'] = 'Already Activated';
    $l['already_activated'] = 'Your account has already been activated. Please try to <a href="' . $globals['index_url'] . 'act=login">LogIn</a> and use your Account.<br /><br />Thank You';

    $l['wrong_status_title'] = 'Wrong Activation Status';
    $l['wrong_status'] = 'Sorry, we were unable to activate your account on the Board because it cannot be activated by Validation. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

    $l['activation_error_title'] = 'Activation Error';
    $l['activation_error'] = 'There were some errors while updating your account. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.';

    $l['update_board_error_title'] = 'Activation Error';
    $l['update_board_error'] = 'There were some errors in updating the board about your account. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.(Latest Member)';


//Welcome Email
    $l['welcome_mail_subject'] = 'Welcome to ' . $globals['sn'];
    $l['welcome_mail'] = 'Congratulations on creating your brand new ' . $globals['sn'] . ' account, &aefv-1;.

You may now login to your account at ' . $globals['index_url'] . 'act=login
and start Posting into threads and topics on the Forum.
Alternatively, you may change your Account Settings or
Profile through the UserCP at ' . $globals['index_url'] . 'act=usercp

Please keep this email for your records, as it contains an
important activation code that you may need should you ever
encounter problems or forget your password.

Enjoy!

The ' . $globals['sn'] . ' Team

' . $globals['url'] . '/

Activation code: &aefv-2;
User ID: &aefv-3;';

//The message that will be shown after email are mailed
    $l['successful_message_title'] = 'Activation Successful';
    $l['successful_message'] = 'Thank you, &aefv-1;. Your Account has been sucessfully activated.<br /><br />

    You may now <a href="' . $globals['index_url'] . 'act=login">login</a> to your account and start Posting into threads and topics on the Forum.
    Alternatively, you may change your <a href="' . $globals['index_url'] . 'act=usercp&ucpact=account">Account Settings</a> or <a href="' . $globals['index_url'] . 'act=usercp&ucpact=profile">Profile</a> through the <a href="' . $globals['index_url'] . 'act=usercp">UserCP</a>.<br /><br />

    We hope you enjoy your time here on the ' . $globals['sn'] . ' Forums.';

//Theme strings
    $l['<title>'] = 'Validate Email Address';
    $l['activation_heading'] = 'Enter Your Activation Code';
    $l['user_id'] = 'User ID';
    $l['user_id_exp'] = 'Please enter the User ID of your account.';
    $l['activation_code'] = 'Activation Code';
    $l['activation_code_exp'] = 'Please enter the activation code you recieved in your email.';
    $l['submit_button'] = 'Submit';
}

//End of function
////////////////////////////////////////////////////////
//Function resendact() strings - Resend Activation Code
////////////////////////////////////////////////////////

function resendact_lang() {

    global $l, $globals;

    $l['resend_activation'] = 'Resend Activation Code'; //You are here
    $l['no_username'] = 'You did not enter your Username.';
    $l['wrong_username'] = 'The Username <b>&aefv-1;</b> does not exist.';

    $l['already_activated_title'] = 'Already Activated';
    $l['already_activated'] = 'Your account has already been activated. Please try to <a href="' . $globals['index_url'] . 'act=login">LogIn</a> and use your Account.<br /><br />Thank You';

    $l['activation_not_required_title'] = 'Resend Activation Code Error';
    $l['activation_not_required'] = 'You do not need to validate your email address as it will be activated by the Administrator. If you have any problems or queries please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.';

//Reset Username Mail
    $l['resend_mail_subject'] = 'Your Activation Code';
    $l['resend_mail'] = 'Hello,

We have recieved a request to resend you your activation code for your account at ' . $globals['sn'] . '.

Before you can use your account you must activate it.
Click on the link below to activate your account:

' . $globals['index_url'] . 'act=register&regact=validate&u=&aefv-1;&code=&aefv-2;

If the above link does not work, you will need to copy and paste the link into your web browser, or type it in by hand.

If you are still having problems signing up, please contact us at ' . $globals['board_email'] . '

Thankyou!

The ' . $globals['sn'] . ' Team
' . $globals['url'] . '/

Activation code: &aefv-2;
User ID: &aefv-1;';


//The message that will be shown after instructions are mailed
    $l['activation_sent_message_title'] = 'Activation Code Sent';
    $l['activation_sent_message'] = 'An email has been sent containing your account activation code and instructions on activating your account. Before you can use your account you must activate it.<br /><br />If you have any problems or queries regarding your account please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.<br /><br />
Thankyou!';


//Theme strings
    $l['<title>'] = 'Resend Activation Code';
    $l['resend_heading'] = 'Resend Activation Code';
    $l['username'] = 'Username';
    $l['username_exp'] = 'Please enter your account username.';
    $l['submit_button'] = 'Submit';
}

//End of function
//////////////////////////////////////////////
//Function coppaform() strings - Shows the Policy
//////////////////////////////////////////////

function coppaform_lang() {

    global $l, $globals;

//Theme strings
    $l['<title>'] = 'Permission Form';
    $l['address'] = 'Address';
    $l['telephone'] = 'Telephone';
    $l['fax'] = 'Fax';
    $l['date'] = 'Date';
    $l['subject'] = 'Subject: Permission to register on ' . $globals['sn'] . '.';
    $l['body'] = 'Sir/Madam,<br /><br />
I _________________ (name), the _______________ (relation) give permission for my child ________________ (child name) to become a registered member of the Board - ' . $globals['sn'] . ', with the username - _________________.<br /><br />

I understand that the information that the child has supplied is correct. I also understand that certain personal information entered by my child may be shown to other users of the forum.<br /><br />

Signature - <br /><br />
_________________ (Parent/Guardian Signature)<br /><br />
';
}

//End of function
?>