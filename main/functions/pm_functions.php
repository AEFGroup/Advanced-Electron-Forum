<?php

//////////////////////////////////////////////////////////////
//===========================================================
// pm_functions.php(functions)
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

////////////////////////////////////
// This is the fuction that actually
// sends the PM to the users
// Parameters:
// 1) $to - To whom is it addressed
// 2) $subject - Subject of the PM
// 3) $body - The body of the PM
// 4) $track - Whether to track it
// 5) $saveinsentitems - Save it or no.
////////////////////////////////////

function sendpm_fn($to, $subject, $body, $track, $saveinsentitems) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    ////////////////////////
    // INSERT the PM first
    ////////////////////////

    $time = time();

    //Make the QUERY
    $qresult = makequery("INSERT INTO " . $dbtables['pm'] . "
            SET pm_from = '" . $user['id'] . "',
            pm_to = '$to',
            pm_time = '$time',
            pm_subject = '$subject',
            pm_body = '$body',
            pm_track = '$track'");

    $pmid = mysql_insert_id($conn);

    if (empty($pmid)) {

        return false;
    }

    ////////////////////////////////
    // UPDATE The Recievers PM count
    ////////////////////////////////
    //Make the QUERY
    $qresult = makequery("UPDATE " . $dbtables['users'] . "
            SET pm = pm + 1 ,
            unread_pm = unread_pm + 1
            WHERE id = '$to'", false);


    //Were things deleted
    if (mysql_affected_rows($conn) < 1) {

        return false;
    }


    /////////////////////////////////
    // If the user has asked to save
    // it in the 'Sent Items Folder'.
    /////////////////////////////////

    if ($saveinsentitems) {

        ///////////////////////////////
        // INSERT the PM to Save first
        // Sent Items Folder ID is '1'
        ///////////////////////////////
        //Make the QUERY
        $qresult = makequery("INSERT INTO " . $dbtables['pm'] . "
                SET pm_from = '" . $user['id'] . "',
                pm_to = '$to',
                pm_time = '$time',
                pm_subject = '$subject',
                pm_body = '$body',
                pm_track = '$track',
                pm_folder = '1'");


        $pmid_s = mysql_insert_id($conn);

        if (empty($pmid_s)) {

            return false;
        }


        ////////////////////////////////
        // UPDATE The Senders PM count
        ////////////////////////////////
        //Make the QUERY
        $qresult = makequery("UPDATE " . $dbtables['users'] . "
                SET pm = pm + 1
                WHERE id = '" . $user['id'] . "'", false);

        //Were things deleted
        if (mysql_affected_rows($conn) < 1) {

            return false;
        }
    }//End of if($saveinsentitems)
}

//End of function
?>