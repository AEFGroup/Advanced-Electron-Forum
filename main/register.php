<?php

//////////////////////////////////////////////////////////////
//===========================================================
// register.php
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

if (!defined('AEF')) {

    die('Hacking Attempt');
}

/////////////////////////
// Registration methods
// 1 - Immediate
// 2 - Email Validation
// 3 - By Admins
/////////////////////////
////////////////////////////////////
// Age Restrictions Handling
// 1 - Reject the application
// 2 - Parents/Guardians permissions
////////////////////////////////////
/////////////////////////////////////
// SESSION VARS that are being used
// 1 - passed_age_rest
// 2 - validation_code
// 3 - agreed_coppa
/////////////////////////////////////
///////////////////////////////////////
// When Approval is required by Admin.
// (Implies act_status 3,4)
// Things to do:
// 1 - UPDATE Latest Member
// 2 - UPDATE Member Count
// 3 - If Welcome email send
// 4 - Die showing a message
///////////////////////////////////////
/////////////////////////////////
// Function that determines what
// to do on a act
/////////////////////////////////

function register() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $tree;

    //Load the Language File
    if (!load_lang('register')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'register';

    //The name of the Page
    $theme['init_theme_name'] = 'Register';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('mainregister_theme',
        'validate_theme',
        'age_theme',
        'coppa_theme',
        'resendact_theme');



    /////////////////////////////////
    // This is not for users
    if ($logged_in) {

        reporterror($l['registered_title'], $l['registered']);

        return false;
    }
    /////////////////////////////////

    $tree = array(); //Board tree for users location
    $tree[] = array('l' => $globals['index_url'],
        'txt' => $l['index']);
    $tree[] = array('l' => $globals['index_url'] . 'act=register',
        'txt' => $l['register']);

    //My activity
    $globals['last_activity'] = 'r';

    //If a second Register act has been set
    if (isset($_GET['regact']) && trim($_GET['regact']) !== "") {

        $regact = trim($_GET['regact']);
    } else {

        $regact = "";
    }

    //The switch handler
    switch ($regact) {

        case 'validate' :
            validate(); //Validates an email address
            break;

        case 'age':
            age(); //Age Asking form
            break;

        case 'coppa':
            coppa(); //COPPA POLICY form
            break;

        case 'coppaform':
            coppaform(); //COPPA POLICY Parents form - Pending
            break;

        case 'resendact':
            resendact(); //For resending activation code
            break;

        default :
            mainregister();
            break;
    }
}

//End of function

function mainregister() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error;

    //Call the Language function
    mainregister_lang();

    //Is registration allowed
    if (!$globals['allow_reg']) {

        reporterror($l['registration_disabled_title'], $l['registration_disabled']);

        return false;
    }


    if ($globals['samepc_reg'] && isset($_COOKIE[$globals['cookie_name']]['reg'])) {

        reporterror($l['same_pc_registration_title'], $l['same_pc_registration']);

        return false;
    }


    //Age Restriction
    if ($globals['age_limit']) {

        //echo 'Age Restriction.';

        if ($globals['age_rest_act'] == 1) {

            //If the SESSION is not there redirect it to the age page
            if (!(isset($AEF_SESS['passed_age_rest']))) {

                //Redirect
                redirect('act=register&regact=age');
            }
        } elseif ($globals['age_rest_act'] == 2) {

            //If the SESSION is not there redirect it to the age page
            if (!(isset($AEF_SESS['agreed_coppa']) && isset($AEF_SESS['act_status']))) {

                //Redirect
                redirect('act=register&regact=age');
            }
        }
    }


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $username = '';

    $password = '';

    $salt = '';

    $email = '';

    $r_time = time();

    $r_ip = $_SERVER['REMOTE_ADDR'];

    $timezone = 0;

    $act_status = ((isset($AEF_SESS['act_status']) && ($globals['age_rest_act'] == 2)) ? $AEF_SESS['act_status'] : $globals['reg_method']);

    //echo $act_status;
    //Activation Code
    $activation_code = strtolower(generateRandStr(10));

    //Old one to be used for processing
    $validation_code = (isset($AEF_SESS['validation_code']) ? $AEF_SESS['validation_code'] : '');

    //Validation only if Security Confirmation Required
    if ($globals['sec_conf']) {

        //Every time a new Validation Code is generated after trapping old Value
        $AEF_SESS['validation_code'] = strtolower(generateRandStr(5));
    }


    if (isset($_POST['register'])) {

        //Check the Username is there
        if (!(isset($_POST['username'])) || strlen(trim($_POST['username'])) < 1) {

            $error[] = $l['no_username'];
        } else {

            //////////////////////////////////
            // Username must undergo following
            // restriction checks
            // 1 - In Data Base
            // 2 - Reserved Names
            // 3 - Min-Max Length
            //////////////////////////////////

            $username = inputsec(htmlizer(trim($_POST['username'])));
            //echo $username;

            $len = aefstrlen($username);

            //Max Length
            if ($len > $globals['max_uname']) {

                $error[] = lang_vars($l['max_name_length_crossed'], array($globals['max_uname']));
            }

            //Min Length
            if ($len < $globals['min_uname']) {

                $error[] = lang_vars($l['min_name_length_crossed'], array($globals['min_uname']));
            }

            if (preg_match("/\s/i", $username)) {

                $error[] = $l['space_in_name'];
            }

            //on error call the form
            if (!empty($error)) {
                $theme['call_theme_func'] = 'mainregister_theme';
                return false;
            }

            //Check in the Database
            if (usernameindb($username)) {

                $error[] = lang_vars($l['name_in_use'], array($username));
            }


            $reserved = explode("\n", $globals['reserved_names']);

            $reserved_count = count($reserved);
            for ($i = 0; $i < $reserved_count; $i++) {

                if (!empty($reserved[$i])) {

                    $reserved[$i] = trim($reserved[$i]);

                    $pattern = '/' . (($globals['reserved_match_whole']) ? '\b' : '') . preg_quote($reserved[$i], '/') . (($globals['reserved_match_whole']) ? '\b' : '') . '/' . (($globals['reserved_match_insensitive']) ? 'i' : '');

                    if (preg_match($pattern, $username)) {

                        $error[] = lang_vars($l['reserved_names'], array($reserved[$i]));

                        break;
                    }
                }
            }
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'mainregister_theme';
            return false;
        }


        //Check the Password is there
        if (!(isset($_POST['password'])) || strlen(trim($_POST['password'])) < 1) {

            $error[] = $l['no_password'];
        } else {

            //////////////////////////////////
            // Password must undergo following
            // restriction checks
            // 1 - Min-Max Length
            //////////////////////////////////

            $password = inputsec(htmlizer(trim($_POST['password'])));
            //echo $username;

            $len = aefstrlen($password);

            //Max Length
            if ($len > $globals['max_pass']) {

                $error[] = lang_vars($l['password_too_big'], array($globals['max_pass']));
            }

            //Min Length
            if ($len < $globals['min_pass']) {

                $error[] = lang_vars($l['password_too_small'], array($globals['min_pass']));
            }

            //For the email to go
            $pass = $password;

            $salt = generateRandStr(4);

            $password = md5($salt . $password);

            //echo $password;
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'mainregister_theme';
            return false;
        }


        //Check the Confirm Password is there
        if (!(isset($_POST['conf_password'])) || strlen(trim($_POST['conf_password'])) < 1) {

            $error[] = $l['no_confirm_password'];
        } else {


            $conf_password = inputsec(htmlizer(trim($_POST['conf_password'])));

            $conf_password = md5($salt . $conf_password);

            //Check does it match the password
            if ($conf_password != $password) {

                $error[] = $l['passwords_dont_match'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'mainregister_theme';
            return false;
        }


        //Check the Email is there
        if (!(isset($_POST['email'])) || strlen(trim($_POST['email'])) < 1) {

            $error[] = $l['no_email'];
        } else {


            $email = inputsec(htmlizer(trim($_POST['email'])));

            //////////////////////////////////
            // Email must undergo following
            // restriction checks
            // 1 - Max Length(for DB)
            // 2 - Email In Data Base
            // 3 - Email Expression
            //////////////////////////////////
            //Max Length
            if (aefstrlen($email) > 100) {

                $error[] = $l['email_too_big'];
            }

            //Also confirm its validity
            if (!emailvalidation($email)) {

                $error[] = $l['invalid_email'];
            }

            //Check is it there in the Data Base
            if (emailindb($email)) {

                $error[] = $l['email_in_use'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'mainregister_theme';
            return false;
        }


        //Is secuirty code to be checked
        if ($globals['sec_conf'] && (extension_loaded('gd') || extension_loaded('GD'))) {

            //Check the Security Confirmation Code
            if (!(isset($_POST['sec_conf'])) || strlen(trim($_POST['sec_conf'])) < 1) {

                $error[] = $l['no_security_code'];
            } else {


                $sec_conf = inputsec(strtolower(htmlizer(trim($_POST['sec_conf']))));

                //////////////////////////////////
                // This is a very important thing
                // to check for automated registrations
                //////////////////////////////////

                if ($sec_conf != $validation_code) {

                    $error[] = $l['wrong_security_code'];
                }
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'mainregister_theme';
            return false;
        }


        //Check the Time Zone
        if (!(isset($_POST['timezone'])) || strlen(trim($_POST['timezone'])) < 1) {

            $error[] = $l['no_time_zone'];
        } else {


            $timezone = inputsec(htmlizer(trim($_POST['timezone'])));

            $valid_timezones = array(-12, -11, -10, -9, -8, -7, -6, -5, -4, -3.5, -3, -2, -1, '+0',
                1, 2, 3, 3.5, 4, 4.5, 5, 5.5, 6, 7, 8, 9, 9.5, 10, 11, 12, 0);

            if (!in_array($timezone, $valid_timezones)) {

                $error[] = $l['invalid_time_zone'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'mainregister_theme';
            return false;
        }


        //The Registering User has to agree to the Terms and Rules
        if (!(isset($_POST['iagree']))) {

            $error[] = $l['no_agreement'];
        }
        
        //Ok, we do some Akismet checks now.

        if ($globals['enable_akismet'] == 1) {

            $akismet = akismetclass();

            $akismet->setCommentAuthor($username);

            $akismet->setCommentAuthorEmail($email);

            $akismet->setCommentType('registration');

            $akismet->setUserIP($password);

            if ($akismet->isCommentSpam()) {
                $error[] = $l['akismet_error'];
            }
        }
        
        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'mainregister_theme';
            return false;
        }



        ///////////////////////////////////////
        // Effects of a New Registration
        // 1 - Put in users table
        // 2 - Increase the members count by 1
        // 3 - Put as Latest Member
        ///////////////////////////////////////
        ////////////////////////////////
        // INSERT the users row in table
        ////////////////////////////////

        $qresult = makequery("INSERT INTO " . $dbtables['users'] . "
                        SET username = '$username',
                        password = '$password',
                        salt = '$salt',
                        email = '$email',
                        r_time = '$r_time',
                        r_ip = '$r_ip',
                        u_member_group = '0',
                        timezone = '$timezone',
                        act_status = '$act_status',
                        activation_code = '$activation_code',
                        validation_code = '$validation_code'");

        $uid = mysql_insert_id($conn);

        if (empty($uid)) {

            reporterror($l['registration_error_title'], $l['registration_error']);

            return false;
        }




        ///////////////////////////////////////
        // Based on different methods slight
        // changes are there in processing
        ///////////////////////////////////////
        //Immediate
        if ($act_status == 1) {


            ////////////////////////////////
            // Following Effects are there
            // 1 - UPDATE Latest Member
            // 2 - UPDATE Member Count
            // 3 - If Welcome email send
            // 4 - Return showing a message
            ////////////////////////////////
            //Set it for tracking the statistics
            $globals['newuser'] = 1;

            //Make the QUERY
            $qresult = makequery("UPDATE " . $dbtables['registry'] . "
                        SET regval = '$username|$uid'
                        WHERE name = 'latest_mem'");

            if (mysql_affected_rows($conn) < 1) {

                reporterror($l['update_board_error_title'], $l['update_board_error']);

                return false;
            }

            //Free the resources
            mysql_free_result($qresult);


            ////////////////////////////////
            // UPDATE The Total Member Count
            ////////////////////////////////
            //Make the QUERY
            $qresult = makequery("UPDATE " . $dbtables['registry'] . "
                        SET regval = '" . (((int) $globals['num_mem']) + 1) . "'
                        WHERE name = 'num_mem'");

            if (mysql_affected_rows($conn) < 1) {

                reporterror($l['update_board_error_title'], $l['update_board_error']);

                return false;
            }

            //Free the resources
            mysql_free_result($qresult);


            //Welcome Email
            if ($globals['wel_email']) {

                $mail[0]['to'] = $email;
                $mail[0]['subject'] = $l['welcome_mail_subject'];
                $mail[0]['message'] = lang_vars($l['welcome_mail'], array($username, $activation_code));
                //Pass it to the Mail sending function(Done Below)
            }


            $messagetitle = $l['successful_message_title'];

            $message = lang_vars($l['successful_message'], array($username));

            $messageheading = $l['successful_message_title'];

            //Email Validation
        } elseif ($act_status == 2) {

            ////////////////////////////////
            // Following Effects are there
            // 1 - Send the Email
            // 2 - Die showing a message
            ////////////////////////////////
            //Validation for Email
            $mail[0]['to'] = $email;
            $mail[0]['subject'] = $l['activate_account_mail_subject'];
            $mail[0]['message'] = lang_vars($l['activate_account_mail'], array($username, $uid, $activation_code));
            //Pass it to the Mail sending function(Done Below)

            $messagetitle = $l['activate_message_title'];

            $message = lang_vars($l['activate_message'], array($username, $email));

            $messageheading = $l['activate_message_title'];


            //Admin Approval
        } elseif ($act_status == 3) {

            ////////////////////////////////
            // Following Effects are there
            // 1 - Send an Email
            // 2 - Die showing a message
            ////////////////////////////////
            //Informatory Email
            $mail[0]['to'] = $email;
            $mail[0]['subject'] = $l['approval_required_mail_subject'];
            $mail[0]['message'] = lang_vars($l['approval_required_mail'], array($username, $uid, $activation_code));
            //Pass it to the Mail sending function(Done Below)

            $messagetitle = $l['approval_message_title'];

            $message = lang_vars($l['approval_message'], array($username, $email));

            $messageheading = $l['approval_message_title'];

            //COPPA
        } elseif ($act_status == 4) {

            ////////////////////////////////
            // Following Effects are there
            // 1 - Send an Email
            // 2 - Die showing a message
            ////////////////////////////////
            //Informatory Email
            $mail[0]['to'] = $email;
            $mail[0]['subject'] = $l['coppa_mail_subject'];
            $mail[0]['message'] = lang_vars($l['coppa_mail'], array($username, $uid, $activation_code));
            //Pass it to the Mail sending function(Done Below)

            $messagetitle = $l['coppa_message_title'];

            $message = lang_vars($l['coppa_message'], array($username, $email));

            $messageheading = $l['coppa_message_title'];
        }


        //Should we Notify the Admin
        if ($globals['reg_notify']) {

            //Make the QUERY
            $qresult = makequery("SELECT email
                        FROM " . $dbtables['users'] . "
                        WHERE id = '1'");

            if (!$qresult || (mysql_num_rows($qresult) < 1)) {

                reporterror($l['load_admin_email_error_title'], $l['load_admin_email_error']);

                return false;
            }

            $temp = mysql_fetch_assoc($qresult);

            $adminemail = $temp['email'];

            //Email    VARS
            $mail[1]['to'] = $adminemail; //echo $adminemail;
            $mail[1]['subject'] = $l['admin_mail_subject'];
            $mail[1]['message'] = lang_vars($l['admin_mail'], array($username));
        }

        //Set a COOKIE for a Day so as to prevent multiple registration
        setcookie($globals['cookie_name'] . '[reg]', "1", (time() + (24 * 60 * 60)));


        //Pass all Mails to the Mail sending function
        aefmail($mail);

        //Give a message
        reportmessage($messagetitle, $messageheading, '', $message);

        return true;
    } else {

        //Show the form
        $theme['call_theme_func'] = 'mainregister_theme';
    }
}

//End of function
////////////////////////////////////
// Asks the age for the registration
// and sets the Session passed_age_rest
////////////////////////////////////

function age() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error, $tree;

    //Call the Language function
    age_lang();

    $tree[] = array('l' => $globals['index_url'] . 'act=admin&adact=reglog&seadact=agerest',
        'txt' => $l['enter_age']);

    //Is registration allowed
    if (!$globals['allow_reg']) {

        reporterror($l['registration_disabled_title'], $l['registration_disabled']);

        return false;
    }


    //Age Restriction
    if (!$globals['age_limit']) {

        //Redirect
        redirect('act=register');
    }

    if (isset($_POST['reg_age'])) {

        //Check the Month was entered
        if (!(isset($_POST['month'])) || strlen(trim($_POST['month'])) < 1) {

            $error[] = $l['no_month'];
        } else {

            $month = (int) trim($_POST['month']);
        }

        //Check the Day was entered
        if (!(isset($_POST['day'])) || strlen(trim($_POST['day'])) < 1) {

            $error[] = $l['no_day'];
        } else {

            $day = (int) trim($_POST['day']);
        }

        //Check the Year was entered
        if (!(isset($_POST['year'])) || strlen(trim($_POST['year'])) < 1) {

            $error[] = $l['no_year'];
        } else {

            $year = (int) trim($_POST['year']);

            if (($year > date("Y", time())) || ($year < 1900)) {

                $error[] = $l['invalid_year'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'age_theme';
            return false;
        }


        $age = getage($year . '-' . $month . '-' . $day);

        //If the age is invalid
        if ($age < $globals['age_limit']) {

            //Reject it
            if ($globals['age_rest_act'] == 1) {

                reporterror($l['reject_title'], $l['reject']);

                return false;
            } elseif ($globals['age_rest_act'] == 2) {

                //Redirect
                redirect('act=register&regact=coppa');
            }

            //Everything is just fine
        } else {

            //Set Session Var
            if ($globals['age_rest_act'] == 1) {

                $AEF_SESS['passed_age_rest'] = 1;
            } elseif ($globals['age_rest_act'] == 2) {

                $AEF_SESS['act_status'] = $globals['reg_method'];

                $AEF_SESS['agreed_coppa'] = 1;
            }

            //Redirect
            redirect('act=register');
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'age_theme';
            return false;
        }
    } else {

        $theme['call_theme_func'] = 'age_theme';
    }
}

//End of function
/////////////////
// Coppa Policy
/////////////////

function coppa() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error, $tree;

    //Call the Language function
    coppa_lang();

    $tree[] = array('l' => $globals['index_url'] . 'act=register&regact=coppa',
        'txt' => $l['coppa_policy']);

    //Is registration allowed
    if (!$globals['allow_reg']) {

        reporterror($l['registration_disabled_title'], $l['registration_disabled']);

        return false;
    }


    //Age Restriction
    if (!$globals['age_limit']) {

        //Redirect
        redirect('act=register');
    }


    if (isset($_POST['agreed_coppa'])) {

        if (isset($_POST['iagree'])) {

            $AEF_SESS['act_status'] = 4;

            $AEF_SESS['agreed_coppa'] = 1;

            //Redirect
            redirect('act=register');
        } else {

            reporterror($l['coppa_policy_disagreed_title'], $l['coppa_policy_disagreed']);

            return false;
        }
    } else {

        $theme['call_theme_func'] = 'coppa_theme';
    }
}

//End of function
///////////////////////////////
// Validates the email account
///////////////////////////////

function validate() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error, $tree;

    //Call the Language function
    validate_lang();

    $tree[] = array('l' => $globals['index_url'] . 'act=admin&adact=reglog&seadact=agerest',
        'txt' => $l['validate_email']);

    if (isset($_GET['u']) && isset($_GET['code']) && !(strlen(trim($_GET['u'])) < 1) && !(strlen(trim($_GET['code'])) < 1)) {

        $u = inputsec(htmlizer(trim($_GET['u'])));

        $code = inputsec(htmlizer(trim($_GET['code'])));


        //Make the QUERY
        $qresult = makequery("SELECT id, username, email, act_status, activation_code
                    FROM " . $dbtables['users'] . "
                    WHERE id = '$u' AND activation_code = '$code'");

        if (mysql_num_rows($qresult) < 1) {

            reporterror($l['invalid_id_code_title'], $l['invalid_id_code']);

            return false;
        }

        $row = mysql_fetch_assoc($qresult);

        //Is it already activated
        if ($row['act_status'] == 1) {

            reporterror($l['already_activated_title'], $l['already_activated']);

            return false;
        }


        //Can we activate it
        if ($row['act_status'] != 2) {

            reporterror($l['wrong_status_title'], $l['wrong_status']);

            return false;
        }


        $username = $row['username'];

        $email = $row['email'];


        //It seems everything is fine otherwise
        //UPDATE the act_status to 1
        $qresult = makequery("UPDATE " . $dbtables['users'] . "
                    SET act_status = '1'
                    WHERE id = '$u'
                    AND activation_code = '$code'");

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['activation_error_title'], $l['activation_error']);

            return false;
        }


        ////////////////////////////////
        // Following Effects are there
        // 1 - UPDATE Latest Member
        // 2 - UPDATE The Total Member Count
        // 2 - If Welcome email send
        // 3 - Die showing a message
        ////////////////////////////////
        //Set it for tracking the statistics
        $globals['newuser'] = 1;

        //Make the QUERY
        $qresult = makequery("UPDATE " . $dbtables['registry'] . "
                    SET regval = '$username|$u'
                    WHERE name = 'latest_mem'");


        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['update_board_error_title'], $l['update_board_error']);

            return false;
        }

        //Free the resources
        mysql_free_result($qresult);


        ////////////////////////////////
        // UPDATE The Total Member Count
        ////////////////////////////////
        //Make the QUERY
        $qresult = makequery("UPDATE " . $dbtables['registry'] . "
                    SET regval = '" . (((int) $globals['num_mem']) + 1) . "'
                    WHERE name = 'num_mem'");

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['update_board_error_title'], $l['update_board_error']);

            return false;
        }

        //Free the resources
        mysql_free_result($qresult);


        //Welcome Email
        if ($globals['wel_email']) {

            $mail[0]['to'] = $email;
            $mail[0]['subject'] = $l['welcome_mail_subject'];
            $mail[0]['message'] = lang_vars($l['welcome_mail'], array($username, $code, $u));
            //Pass all Mails to the Mail sending function
            aefmail($mail);
        }


        $messagetitle = $l['successful_message_title'];

        $message = lang_vars($l['successful_message'], array($username));

        $messageheading = $l['successful_message_title'];


        //Show a message and die
        reportmessage($messagetitle, $messageheading, '', $message);

        return true;
    } else {

        $theme['call_theme_func'] = 'validate_theme';
    }
}

//End of function
////////////////////////////////////
// Resend the activation code as I
// didnt recieve the email
////////////////////////////////////

function resendact() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error, $tree;

    //Call the Language function
    resendact_lang();

    $tree[] = array('l' => $globals['index_url'] . 'act=register&regact=resendact',
        'txt' => $l['resend_activation']);

    if (isset($_POST['resendact'])) {

        //Check the Username is there
        if (!(isset($_POST['username'])) || strlen(trim($_POST['username'])) < 1) {

            $error[] = $l['no_username'];
        } else {

            $username = inputsec(htmlizer(trim($_POST['username'])));


            //Check in the Database
            $qresult = makequery("SELECT id, email, act_status, activation_code
                        FROM " . $dbtables['users'] . "
                        WHERE username = '$username'");

            if (!$qresult || (mysql_num_rows($qresult) < 1)) {

                //Not Found
                $error[] = lang_vars($l['wrong_username'], array($username));

                //on error call the form
                if (!empty($error)) {
                    $theme['call_theme_func'] = 'resendact_theme';
                    return false;
                }
            } else {

                //Found
                $row = mysql_fetch_assoc($qresult);

                //Is it already activated
                if ($row['act_status'] == 1) {

                    reporterror($l['already_activated_title'], $l['already_activated']);

                    return false;
                }


                //Can we activate it
                if ($row['act_status'] != 2) {

                    reporterror($l['activation_not_required_title'], $l['activation_not_required']);

                    return false;
                }
            }

            //Free the resources
            mysql_free_result($qresult);
        }

        //Ok so no error found - Lets process
        //Lets send the email
        $mail[0]['to'] = $row['email'];
        $mail[0]['subject'] = $l['resend_mail_subject'];
        $mail[0]['message'] = lang_vars($l['resend_mail'], array($row['id'], $row['activation_code']));

        //Pass all Mails to the Mail sending function
        aefmail($mail);

        //Give a message
        reportmessage($l['activation_sent_message_title'], $l['activation_sent_message_title'], '', $l['activation_sent_message']);

        return true;
    } else {

        $theme['call_theme_func'] = 'resendact_theme';
    }
}

//End of function
//////////////
// COPPA form
//////////////

function coppaform() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error, $tree;

    //Call the Language function
    coppaform_lang();

    $theme['call_theme_func'] = 'coppaform_theme';
}

//End of function
?>
