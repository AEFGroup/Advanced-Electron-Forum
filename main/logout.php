<?php

//////////////////////////////////////////////////////////////
//===========================================================
// logout.php
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
// To Logout the User
// 1 - Delete the Cookies
// 2 - Delete the Session
// 3 - Refresh it as a
//     Guest Session
/////////////////////////


function logout() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS;

    //Load the Language File
    if (!load_lang('logout')) {

        return false;
    }

    //Are you even logged in
    if (empty($logged_in)) {

        //Show a major error and return
        reporterror($l['not_logged_in_title'], $l['not_logged_in']);

        return false;
    }

    ///////////////////////
    // DELETE the COOKIES
    ///////////////////////
    //Set a COOKIE for a YEAR of User ID
    setcookie($globals['cookie_name'] . '[loguid]', "", (time() - (60 * 60 * 24 * 365)), '/');

    //Set a COOKIE for a YEAR of CookPass
    setcookie($globals['cookie_name'] . '[logpass]', "", (time() - (60 * 60 * 24 * 365)), '/');


    //Lets DELETE the USERS Session
    $qresult = makequery("DELETE FROM " . $dbtables['sessions'] . "
                WHERE uid = '" . AS_UID . "'
                AND sid = '" . AS_ID . "'");

    if (mysql_affected_rows($conn) < 1) {

        //Show a major error and return
        reporterror($l['delete_session_error_title'], $l['delete_session_error']);

        return false;
    }

    //Process the DATA
    $data = process_as_data();

    //Add the new SESSION ROW
    $qresult = makequery("INSERT INTO " . $dbtables['sessions'] . "
                SET sid = '" . AS_ID . "',
                uid = '-1',
                time = '" . time() . "',
                data = '$data',
                ip = '" . ($_SERVER['REMOTE_ADDR']) . "'");

    if (mysql_affected_rows($conn) < 1) {

        //Show a major error and return
        reporterror($l['guest_session_error_title'], $l['guest_session_error']);

        return false;
    }


    //Redirect to Index
    redirect('');

    return true;
}

?>
