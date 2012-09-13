<?php

//////////////////////////////////////////////////////////////
//===========================================================
// login.php
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


if (!defined('AEF')) {

    die('Hacking Attempt');
}

///////////////////////////////////////
// In Maintainenacne Mode only
// administrators can login.
///////////////////////////////////////
///////////////////////////////////////
// Activation Status Number Meanings:
// 1 - Fully Activated
// 2 - Email Verification required
// 3 - Admin needs to approve
// 4 - Age restriction approval (COPPA)
///////////////////////////////////////
/////////////////////////////////
// Function that determines what
// to do on a act
/////////////////////////////////

function login() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $isbot, $tree;

    //Load the Language File
    if (!load_lang('login')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'login';

    //The name of the Page
    $theme['init_theme_name'] = 'Login';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('mainlogin_theme',
        'fuser_theme',
        'fpass_theme',
        'answer_theme',
        'reset_theme');

    //Are you a BOT
    if (!empty($isbot)) {

        redirect('');
    }


    /////////////////////////////////
    // This is not for users
    if ($logged_in) {

        reporterror($l['logged_in_title'], $l['logged_in']);

        return false;
    }
    /////////////////////////////////

    $tree = array(); //Board tree for users location
    $tree[] = array('l' => $globals['index_url'],
        'txt' => $l['index']);
    $tree[] = array('l' => $globals['index_url'] . 'act=login',
        'txt' => $l['login']);

    //My activity
    $globals['last_activity'] = 'l';

    //If a second Register act has been set
    if (isset($_GET['logact']) && trim($_GET['logact']) !== "") {

        $logact = trim($_GET['logact']);
    } else {

        $logact = "";
    }

    //The switch handler
    switch ($logact) {

        case 'fuser':
            fuser();
            break;

        case 'fpass':
            fpass();
            break;

        case 'answer':
            answer();
            break;

        case 'reset':
            reset_pass();
            break;

        default :
            mainlogin();
            break;
    }
}

//End of function

function mainlogin() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $error, $AEF_SESS, $theme;

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $username = '';

    $password = '';

    $remember = 0;

    //Call the Language function
    mainlogin_lang();

    //Should we attemp restrict
    if ($globals['login_failed']) {

        $AEF_SESS['login_attempt'] = (isset($AEF_SESS['login_attempt']) ? $AEF_SESS['login_attempt'] : 1);

        //You have tried to much
        if ($AEF_SESS['login_attempt'] >= $globals['login_failed']) {

            reporterror($l['exceeded_attempts_title'], lang_vars($l['exceeded_attempts'], array($AEF_SESS['login_attempt'])));

            return false;
        }
    }


    if (isset($_POST['login'])) {

        //Check the Username is there
        if (!(isset($_POST['username'])) || strlen(trim($_POST['username'])) < 1) {

            $error[] = $l['no_username'];
        } else {

            $username = inputsec(htmlizer(trim($_POST['username'])));
            //echo $username;
        }


        //Check the Password is there
        if (!(isset($_POST['password'])) || strlen(trim($_POST['password'])) < 1) {

            $error[] = $l['no_password'];
        } else {

            $password = inputsec(htmlizer(trim($_POST['password'])));
            //echo $password;
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'mainlogin_theme';
            return false;
        }

        //Bring out the Username
        $qresult = makequery("SELECT id, password, salt, act_status, lastlogin_1
                            FROM " . $dbtables['users'] . "
                            WHERE username = '$username'");

        //Not Found any username
        if (!$qresult || (mysql_num_rows($qresult) < 1)) {

            $error[] = $l['wrong_username'];

            //on error call the form
            if (!empty($error)) {
                $AEF_SESS['login_attempt']++;
                $theme['call_theme_func'] = 'mainlogin_theme';
                return false;
            }
        } else {

            $row = mysql_fetch_assoc($qresult);

            $pass = md5($row['salt'] . $password);

            if ($pass != $row['password']) {

                $error[] = $l['wrong_password'];

                //on error call the form
                if (!empty($error)) {
                    $AEF_SESS['login_attempt']++;
                    $theme['call_theme_func'] = 'mainlogin_theme';
                    return false;
                }
            }
        }//End of Query IF
        //Are we under maintenance mode
        if (!empty($globals['maintenance'])) {

            $qresult = makequery("SELECT p.view_offline_board
                                FROM " . $dbtables['users'] . " u, " . $dbtables['permissions'] . " p
                                WHERE u.username = '$username' AND
                                p.member_group_id = u.u_member_group AND
                                p.view_offline_board = 1");

            //Not Found any username
            if (mysql_num_rows($qresult) < 1) {

                $error[] = $l['no_maintenance_permission'];

                //on error call the form
                if (!empty($error)) {
                    $theme['call_theme_func'] = 'mainlogin_theme';
                    return false;
                }
            }
        }//End of Maintainenace IF
        //////////////////////////////
        // Check the Activation Status
        //////////////////////////////

        if ($globals['reg_method'] != 1) {

            //Email Validation is still required
            if ($row['act_status'] == 2) {

                reporterror($l['validation_required_title'], $l['validation_required']);

                return false;

                //Admin Approval is still required
            } elseif ($row['act_status'] == 3) {

                reporterror($l['approval_pending_title'], $l['approval_pending']);

                return false;
            }

            //We may UPDATE the act_status in this case
        }

        //COPPA - Admin Approval is still required
        if ($row['act_status'] == 4) {

            reporterror($l['coppa_approval_title'], $l['coppa_approval']);

            return false;
        }

        ////////////////////////////////////////////////
        // DEFINE the CONSTANT AS_LUID for the Users ID
        ////////////////////////////////////////////////

        define('AS_LUID', $row['id']);

        ///////////////////////////////////
        // The USER wants to be REMEMBERED
        ///////////////////////////////////

        if (isset($_POST['remember'])) {

            $remember = true;

            $logpass = generateRandStr(32);

            //Set a COOKIE for a YEAR of User ID
            @setcookie($globals['cookie_name'] . '[loguid]', $row['id'], (time() + (60 * 60 * 24 * 365)), '/');

            //Set a COOKIE for a YEAR of CookPass
            @setcookie($globals['cookie_name'] . '[logpass]', $logpass, (time() + (60 * 60 * 24 * 365)), '/');

            //Set a SESSION that we have checked the COOKIES
            $AEF_SESS['cuc'] = time();
        }

        //Is anonymous logins allowed
        if ($globals['anon_login']) {

            //I am a Spy
            if (isset($_POST['anonymously'])) {

                $globals['i_am_anon'] = 1;
            }
        }


        //Make the QUERY
        $qresult = makequery("UPDATE " . $dbtables['users'] . "
                    SET lastlogin = '" . $row['lastlogin_1'] . "',
                    lastlogin_1 = '" . time() . "'
                    " . (($remember) ? ", cookpass = '" . $logpass . "'" : "") . "
                    WHERE id = '" . $row['id'] . "'");

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['sign_in_error_title'], $l['sign_in_error']);

            return false;
        }

        //Free the resources
        mysql_free_result($qresult);


        /////////////////////////////////
        // DELETE the USER SESSIONS for
        // if the user is logged in
        // from somewhere else.
        /////////////////////////////////
        //Make the QUERY
        $qresult = makequery("DELETE FROM " . $dbtables['sessions'] . "
                    WHERE uid = '" . $row['id'] . "'");

        //Free the resources
        mysql_free_result($qresult);

        /////////////////////////////
        //Now lets Sign IN the User
        /////////////////////////////
        //First Lets DELETE the the USERS Guest Session
        $qresult = makequery("DELETE FROM " . $dbtables['sessions'] . "
                    WHERE uid = '-1'
                    AND sid = '" . AS_ID . "'");

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['sign_in_error_title'], $l['sign_in_error']);

            return false;
        }

        //Free the resources
        mysql_free_result($qresult);


        //Process the DATA
        $data = process_as_data();

        //Add the new SESSION ROW
        $qresult = makequery("INSERT INTO " . $dbtables['sessions'] . "
                    SET sid = '" . AS_ID . "',
                    uid = '" . AS_LUID . "',
                    time = '" . time() . "',
                    data = '$data',
                    ip = '" . ($_SERVER['REMOTE_ADDR']) . "',
                    anonymous = '" . $globals['i_am_anon'] . "'");

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['sign_in_error_title'], $l['sign_in_error']);

            return false;
        }

        //Free the resources
        mysql_free_result($qresult);

        $referer = trim($_SERVER['HTTP_REFERER']);

        if (!empty($globals['smart_redirect']) && !empty($referer) && preg_match('/^' . preg_quote($globals['url'], '/') . '/', $referer) && !preg_match('/' . preg_quote('act=login', '/') . '/', $referer)) {

            //Redirect to where you came from
            header("Location: " . $referer);
        } else {

            //Redirect to Index
            redirect('');
        }

        return true;
    } else {

        $theme['call_theme_func'] = 'mainlogin_theme';

        return true;
    }
}

/////////////////////////////////////////
// This is to reset a forgotten password
// Two methods :
// 1 - Answer the secret question
// 2 - Email new password
/////////////////////////////////////////

function fpass() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error, $tree;

    //Call the Language function
    fpass_lang();

    $tree[] = array('l' => $globals['index_url'] . 'act=login&logact=fpass',
        'txt' => $l['fpass']);

    //Old one to be used for processing
    $validation_code = (isset($AEF_SESS['validation_code']) ? $AEF_SESS['validation_code'] : '');

    //Validation only if Security Confirmation Required
    if ($globals['fpass_sec_conf']) {

        //Every time a new Validation Code is generated after trapping old Value
        $AEF_SESS['validation_code'] = strtolower(generateRandStr(5));
    }


    if (isset($_POST['fpass'])) {

        //Check the Username is there
        if (!(isset($_POST['username'])) || strlen(trim($_POST['username'])) < 1) {

            $error[] = $l['no_username'];
        } else {


            $username = inputsec(htmlizer(trim($_POST['username'])));
            //echo $username;

            if (preg_match("/\s/i", $username)) {

                $error[] = $l['space_in_username'];
            }

            //on error call the form
            if (!empty($error)) {
                $theme['call_theme_func'] = 'fpass_theme';
                return false;
            }

            //Check in the Database
            $qresult = makequery("SELECT u.id, u.email, u.salt, u.secret_question,
                        u.secret_answer, fp.*
                        FROM " . $dbtables['users'] . " u
                        LEFT JOIN " . $dbtables['fpass'] . " fp ON (u.id = fp.fpuid)
                        WHERE username = '$username'");

            if (!$qresult || (mysql_num_rows($qresult) < 1)) {

                //Not Found
                $error[] = $l['wrong_username'];
            } else {

                //Found
                $row = mysql_fetch_assoc($qresult);

                //Is it already under Reseting stage
                if (!empty($row['fpuid']) && ($row['fptime'] + (3600 * 24) > time())) {

                    reporterror($l['reset_password_set_title'], $l['reset_password_set']);

                    return false;

                    //Lets DELETE it if it has expired
                } elseif (!empty($row['fpuid']) && !($row['fptime'] + (3600 * 24) > time())) {

                    //DELETE the users resetcode in fpass table
                    $qresult = makequery("DELETE FROM " . $dbtables['fpass'] . "
                                WHERE fpuid = '" . $row['id'] . "'");
                }
            }

            //Free the resources
            mysql_free_result($qresult);
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'fpass_theme';
            return false;
        }


        //Check the Security Confirmation Code
        if ($globals['fpass_sec_conf'] && (!(isset($_POST['sec_conf'])) || strlen(trim($_POST['sec_conf']))) < 1) {

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

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'fpass_theme';
            return false;
        }

        //Should we ask the Question
        if (isset($_POST['answer'])) {

            //Check that has the user set any secret question and answer.
            if (empty($row['secret_question']) || empty($row['secret_answer'])) {

                $error[] = $l['no_secret_answer'];

                //on error call the form
                if (!empty($error)) {
                    $theme['call_theme_func'] = 'fpass_theme';
                    return false;
                }
            }

            //We need to sessionify the users id
            $AEF_SESS['fpid'] = $row['id'];

            //Redirect
            redirect('act=login&logact=answer');

            return true;

            //Send a new password via the email
        } else {

            $resetcode = generateRandStr(10);

            /////////////////////////////
            // INSERT in the fpass Table
            /////////////////////////////

            $qresult = makequery("INSERT INTO " . $dbtables['fpass'] . "
                            SET fpuid = '" . $row['id'] . "',
                            resetcode = '" . $resetcode . "',
                            fptime = '" . time() . "'");

            if (mysql_affected_rows($conn) < 1) {

                reporterror($l['new_password_error_title'], $l['new_password_error']);

                return false;
            }

            //Lets send the email
            $mail[0]['to'] = $row['email'];
            $mail[0]['subject'] = $l['reset_password_mail_subject'];
            $mail[0]['message'] = lang_vars($l['reset_password_mail'], array($username, $resetcode));


            //Pass all Mails to the Mail sending function
            aefmail($mail);

            //Give a message
            reportmessage($l['reset_pass_mailsent_title'], $l['reset_pass_mailsent_title'], '', $l['reset_pass_mailsent']);

            return true;
        }
    } else {

        $theme['call_theme_func'] = 'fpass_theme';
    }
}

////////////////////////////////////////
// This is to answer the secret question
////////////////////////////////////////

function answer() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error, $qt, $tree;

    //Call the Language function
    answer_lang();

    $tree[] = array('l' => $globals['index_url'] . 'act=login&logact=answer',
        'txt' => $l['answering_question']);

    //Has he got the users id
    if (!isset($AEF_SESS['fpid'])) {

        //Redirect
        redirect('act=login&logact=fpass');

        return false;
    }

    //Get the question and answer
    $qresult = makequery("SELECT id, salt, secret_question, secret_answer
                FROM " . $dbtables['users'] . "
                WHERE id = '" . $AEF_SESS['fpid'] . "'");

    if (!$qresult || (mysql_num_rows($qresult) < 1)) {

        //Some error
        reporterror($l['error_retrieving_qt_ans_title'], $l['error_retrieving_qt_ans']);

        return false;
    } else {

        $row = mysql_fetch_assoc($qresult);
    }

    $qt = $row['secret_question'];


    if (isset($_POST['answerqt'])) {

        //Check the answer is there
        if (!(isset($_POST['secretanswer'])) || strlen(trim($_POST['secretanswer'])) < 1) {

            $error[] = $l['no_answer'];
        } else {

            $answer = inputsec(htmlizer(trim($_POST['secretanswer'])));

            $answer = md5($row['salt'] . $answer);

            if ($answer != $row['secret_answer']) {

                $error[] = $l['wrong_answer'];

                //on error call the form
                if (!empty($error)) {
                    $theme['call_theme_func'] = 'answer_theme';
                    return false;
                }
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'answer_theme';
            return false;
        }

        ////////////////////////////
        //OK so everything is right
        ////////////////////////////

        $AEF_SESS['reset_salt'] = $row['salt'];

        //Redirect
        redirect('act=login&logact=reset');

        return true;
    } else {

        $theme['call_theme_func'] = 'answer_theme';
    }
}

////////////////////////////////////
// This is the main function to
// reset a users password. It can
// done only if there is :
// 1 - reset code
//           OR
// 2 - Answer to the secret question
////////////////////////////////////

function reset_pass() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error, $tree;

    //Call the Language function
    reset_pass_lang();

    $tree[] = array('l' => $globals['index_url'] . 'act=login&logact=reset',
        'txt' => $l['reseting_password']);

    $id = 0;

    $salt = '';

    //Is it through the reset code
    if (isset($_GET['rcode']) && strlen(trim($_GET['rcode'])) > 0) {

        $resetcode = inputsec(htmlizer(trim($_GET['rcode'])));

        //Check in the Database
        $qresult = makequery("SELECT u.id, u.salt, fp.*
                    FROM " . $dbtables['fpass'] . " fp
                    LEFT JOIN " . $dbtables['users'] . " u ON (u.id = fp.fpuid)
                    WHERE resetcode = '" . $resetcode . "'");

        if (!$qresult || (mysql_num_rows($qresult) < 1)) {

            //Some error
            reporterror($l['wrong_reset_code_title'], $l['wrong_reset_code']);

            return false;
        } else {

            $row = mysql_fetch_assoc($qresult);

            //Has it expired
            if (!($row['fptime'] + (3600 * 24) > time())) {

                //Some error
                reporterror($l['reset_code_expired_title'], $l['reset_code_expired']);

                return false;
            }

            //Set the id
            $id = $row['id'];

            //The salt
            $salt = $row['salt'];
        }

        //Or is it question and answer
    } elseif (isset($AEF_SESS['reset_salt']) && isset($AEF_SESS['fpid'])) {

        //Set the id
        $id = $AEF_SESS['fpid'];

        //The salt
        $salt = $AEF_SESS['reset_salt'];
    } else {

        //Redirect
        redirect('act=login&logact=fpass');

        return false;
    }

    //Lets process
    if (isset($_POST['reset'])) {

        //Check the Password is there
        if (!(isset($_POST['newpass'])) || strlen(trim($_POST['newpass'])) < 1) {

            $error[] = $l['no_new_password'];
        } else {

            //////////////////////////////////
            // Password must undergo following
            // restriction checks
            // 1 - Min-Max Length
            //////////////////////////////////

            $password = inputsec(htmlizer(trim($_POST['newpass'])));
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

            $password = md5($salt . $password);
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'reset_theme';
            return false;
        }


        //Check the Confirm Password is there
        if (!(isset($_POST['newpassconf'])) || strlen(trim($_POST['newpassconf'])) < 1) {

            $error[] = $l['no_confirm_password'];
        } else {


            $conf_password = inputsec(htmlizer(trim($_POST['newpassconf'])));

            $conf_password = md5($salt . $conf_password);

            //Check does it match the password
            if ($conf_password != $password) {

                $error[] = $l['passwords_dont_match'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'reset_theme';
            return false;
        }

        //////////////////////////////////
        // Lets UPDATE the users password
        //////////////////////////////////
        //Make the QUERY
        $qresult = makequery("UPDATE " . $dbtables['users'] . "
                    SET password = '" . $password . "'
                    WHERE id = '" . $id . "'");

        // Now we are not checking that is it updated because
        // the user might enter the same password resulting in no actual UPDATE

        if (isset($resetcode)) {

            //DELETE the users resetcode in fpass table
            $qresult = makequery("DELETE FROM " . $dbtables['fpass'] . "
                        WHERE fpuid = '" . $id . "'
                        AND resetcode = '" . $resetcode . "'");

            if (mysql_affected_rows($conn) < 1) {

                //Some error
                reporterror($l['delete_code_error_title'], $l['delete_code_error']);

                return false;
            }
        }

        //Give a message
        reportmessage($l['reset_pass_success_title'], $l['reset_pass_success_title'], '', $l['reset_pass_success']);

        return true;
    } else {

        $theme['call_theme_func'] = 'reset_theme';
    }
}

/////////////////////////////////////////
// This is to find a forgotten username
// Requires the email address
/////////////////////////////////////////

function fuser() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error, $tree;

    //Call the Language function
    fuser_lang();

    $tree[] = array('l' => $globals['index_url'] . 'act=login&logact=fuser',
        'txt' => $l['fuser']);


    //Old one to be used for processing
    $validation_code = (isset($AEF_SESS['validation_code']) ? $AEF_SESS['validation_code'] : '');

    //Validation only if Security Confirmation Required
    if ($globals['fpass_sec_conf']) {

        //Every time a new Validation Code is generated after trapping old Value
        $AEF_SESS['validation_code'] = strtolower(generateRandStr(5));
    }


    if (isset($_POST['fuser'])) {

        //Check the Email is there
        if (!(isset($_POST['email'])) || strlen(trim($_POST['email'])) < 1) {

            $error[] = $l['no_email'];
        } else {


            $email = inputsec(htmlizer(trim($_POST['email'])));
            //echo $email;
            //Check is it a valid email
            if (!emailvalidation($email)) {

                $error[] = $l['invalid_email'];
            }

            //on error call the form
            if (!empty($error)) {
                $theme['call_theme_func'] = 'fuser_theme';
                return false;
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'fuser_theme';
            return false;
        }


        //Check the Security Confirmation Code
        if ($globals['fpass_sec_conf'] && (!(isset($_POST['sec_conf'])) || strlen(trim($_POST['sec_conf']))) < 1) {

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

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'fuser_theme';
            return false;
        }

        //Check in the Database
        $qresult = makequery("SELECT id, username, email
                    FROM " . $dbtables['users'] . "
                    WHERE email = '$email'");

        if (!$qresult || (mysql_num_rows($qresult) < 1)) {

            //Not Found
            $error[] = $l['email_not_found'];
        } else {

            //Found
            $row = mysql_fetch_assoc($qresult);
        }

        //Free the resources
        mysql_free_result($qresult);

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'fuser_theme';
            return false;
        }


        //Lets send the email
        $mail[0]['to'] = $email;
        $mail[0]['subject'] = $l['reset_username_mail_subject'];
        $mail[0]['message'] = lang_vars($l['reset_username_mail'], array($row['username']));


        //Pass all Mails to the Mail sending function
        aefmail($mail);

        //Give a message
        reportmessage($l['fuser_mailsent_title'], $l['fuser_mailsent_title'], '', lang_vars($l['fuser_mailsent'], array($email)));

        return true;
    } else {

        $theme['call_theme_func'] = 'fuser_theme';
    }
}

?>
