<?php

//////////////////////////////////////////////////////////////
//===========================================================
// index.php(usercp)
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

if (!load_lang('usercp/index')) {

    return false;
}

function usercp() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $tree, $load_uhf, $ucpact;

    $load_uhf = true;

    /////////////////////////////////////////
    //This section is only for users
    if (!$logged_in) {

        //Show a major error and return
        reporterror($l['no_perms'], $l['only_reglog']);

        return false;
    }
    /////////////////////////////////////////
    //My activity
    $globals['last_activity'] = 'ucp';

    $tree = array(); //Board tree for users location
    $tree[] = array('l' => $globals['index_url'],
        'txt' => $l['index']);
    $tree[] = array('l' => $globals['index_url'] . 'act=usercp',
        'txt' => $l['cpuser']);

    //Check the Unread
    unreadcheck();

    //If a second User CP act has been set
    if (isset($_GET['ucpact']) && trim($_GET['ucpact']) !== "") {

        $ucpact = inputsec(htmlizer(trim($_GET['ucpact'])));
    } else {

        $ucpact = "";
    }

    //The switch handler
    switch ($ucpact) {

        /* User Account Related */

        case 'profile' :
            include_once($globals['mainfiles'] . '/usercp/account.php');
            profile();
            break;

        case 'account' :
            include_once($globals['mainfiles'] . '/usercp/account.php');
            account();
            break;

        case 'signature' :
            include_once($globals['mainfiles'] . '/usercp/account.php');
            signature();
            break;

        case 'avatar' :
            include_once($globals['mainfiles'] . '/usercp/account.php');
            avatar();
            break;

        case 'personalpic' :
            include_once($globals['mainfiles'] . '/usercp/account.php');
            personalpic();
            break;

        /* Subscriptions */

        case 'topicsub' :
            include_once($globals['mainfiles'] . '/usercp/subscriptions.php');
            topicsub();
            break;

        case 'forumsub' :
            include_once($globals['mainfiles'] . '/usercp/subscriptions.php');
            forumsub();
            break;

        /* User Settings */

        case 'emailpmset' :
            include_once($globals['mainfiles'] . '/usercp/usersettings.php');
            emailpmset();
            break;

        case 'forumset' :
            include_once($globals['mainfiles'] . '/usercp/usersettings.php');
            forumset();
            break;

        case 'themeset' :
            include_once($globals['mainfiles'] . '/usercp/usersettings.php');
            themeset();
            break;

        /* PM System stuff */

        case 'showpm' :
            include_once($globals['mainfiles'] . '/usercp/pm.php');
            showpm(0);
            $theme['call_theme_func'] = 'showpm_theme';
            break;

        case 'showsentpm' :
            include_once($globals['mainfiles'] . '/usercp/pm.php');
            showpm(1);
            $theme['call_theme_func'] = 'showpm_theme';
            break;

        case 'inbox' :
            include_once($globals['mainfiles'] . '/usercp/pm.php');
            inbox();
            $theme['call_theme_func'] = 'inbox_theme';
            break;

        case 'sentitems' :
            include_once($globals['mainfiles'] . '/usercp/pm.php');
            sentitems();
            $theme['call_theme_func'] = 'sentitems_theme';
            break;

        case 'drafts' :
            include_once($globals['mainfiles'] . '/usercp/pm.php');
            drafts();
            $theme['call_theme_func'] = 'drafts_theme';
            break;

        case 'trackpm' :
            include_once($globals['mainfiles'] . '/usercp/pm.php');
            trackpm();
            $theme['call_theme_func'] = 'trackpm_theme';
            break;

        case 'writepm' :
            include_once($globals['mainfiles'] . '/usercp/pm.php');
            writepm();
            break;

        case 'searchpm' :
            include_once($globals['mainfiles'] . '/usercp/pm.php');
            searchpm();
            break;

        case 'sendsaved' :
            include_once($globals['mainfiles'] . '/usercp/pm.php');
            sendsaved();
            break;

        case 'prunepm' :
            include_once($globals['mainfiles'] . '/usercp/pm.php');
            prunepm();
            break;

        case 'emptyfolders' :
            include_once($globals['mainfiles'] . '/usercp/pm.php');
            emptyfolders();
            break;

        case 'delpm' :
            include_once($globals['mainfiles'] . '/usercp/pm.php');
            delpm();
            break;

        /* Default UserCP Index */
        default :
            include_once($globals['mainfiles'] . '/usercp/usercpindex.php');
            usercpindex();
            break;
    }
}

function checkpmon() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    /////////////////////////////
    // Check the PM system is ON.
    // Also is the user allowed.
    /////////////////////////////

    if (!$globals['pmon']) {

        reporterror($l['pm_disabled'], $l['pm_disabled_exp']);

        return false;
    }


    if (!$user['can_use_pm']) {

        reporterror($l['no_perms'], $l['no_perms_exp']);

        return false;
    }
}

//End of function
///////////////////////////////////////
// This function will check unread PM's
// If they are not equal with users table
// It will update it accordingly
///////////////////////////////////////

function unreadcheck() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    if ($globals['pmon'] || $user['can_use_pm']) {

        //Get the PM the user has requested to Reply.
        $qresult = makequery("SELECT COUNT(*) AS unread
                    FROM " . $dbtables['pm'] . "
                    WHERE pm_to = '" . $user['id'] . "'
                    AND pm_folder = '0'
                    AND pm_read_time = '0'");


        if (mysql_num_rows($qresult) < 1) {

            //Didnt get anyresult - Show a major error and return
            reporterror($l['ilegal_op'], $l['ilegal_op_exp']);

            return false;
        }

        $row = mysql_fetch_assoc($qresult);

        $unread = $row['unread'];

        //If the unread in the users table is not equal to counted unread PM - UPDATE
        if ($user['unread_pm'] != $unread) {

            $qresult = makequery("UPDATE " . $dbtables['users'] . "
                    SET unread_pm = '$unread'
                    WHERE id = '" . $user['id'] . "'", false);

            if (mysql_affected_rows($conn) < 1) {

                reporterror($l['up_pm_count_error'], $l['up_pm_count_error_exp']);

                return false;
            }

            //Free the resources
            @mysql_free_result($qresult);
        }
    }
}

?>
