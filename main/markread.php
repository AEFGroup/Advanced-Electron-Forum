<?php

//////////////////////////////////////////////////////////////
//===========================================================
// markallread.php
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

function markread() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    if (!$logged_in) {

        //Redirect to the index
        redirect('');

        return false;
    }

    //Load the Language File
    if (!load_lang('markread')) {

        return false;
    }

    //What to mark
    if (isset($_GET['mark']) && trim($_GET['mark']) !== "") {

        $mark = inputsec(htmlizer(trim($_GET['mark'])));
    } else {

        //Redirect to the index
        redirect('');

        return false;
    }


    //The switch handler
    switch ($mark) {

        case 'board' :
            markboard(); //Mark the entire board as read
            break;

        case 'forum':
            markforum(); //Mark a particular forum as read
            break;

        case 'unreadtopic':
            unreadtopic(); //Mark a particular topic as unread
            break;
    }
}

//End of function

function markboard() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    //Call the Language function
    markboard_lang();

    //Well we just need to make a query
    ////////////////////////////////
    // INSERT the users row in table
    ////////////////////////////////

    $qresult = makequery("REPLACE INTO " . $dbtables['read_board'] . "
                    SET rb_uid = '" . $user['id'] . "',
                    rb_time = '" . time() . "'");

    if (mysql_affected_rows($conn) < 1) {

        reporterror($l['mark_board_error_title'], $l['mark_board_error']);

        return false;
    }

    //Everything went just fine - Redirect to Index
    redirect('');

    return true;
}

//End of function

function markforum() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums;

    //Call the Language function
    markforum_lang();

    //Which forum to mark read ?
    if (isset($_GET['mfid']) && trim($_GET['mfid']) !== "") {

        $mfid = (int) inputsec(htmlizer(trim($_GET['mfid'])));
    } else {

        //Show a major error and return
        reporterror($l['no_forum_specified_title'], $l['no_forum_specified']);

        return false;
    }


    //Load the boards
    if (!default_of_nor(false, false)) {

        //Show a major error and return
        reporterror($l['load_forum_error_title'], $l['load_forum_error']);

        return false;
    }


    //This is to find which forum is it that the user is viewing
    foreach ($forums as $c => $cv) {

        //The main forum loop
        foreach ($forums[$c] as $f => $v) {

            if ($forums[$c][$f]['fid'] == $mfid) {

                $board = $forums[$c][$f];
            }
        }
    }//End of main loop
    //Did we find any forum ??
    if (empty($board)) {

        //Show a major error and return
        reporterror($l['no_forum_found_title'], $l['no_forum_found']);

        return false;
    }

    ////////////////////////////////
    // INSERT the users row in table
    ////////////////////////////////

    $qresult = makequery("REPLACE INTO " . $dbtables['mark_read'] . "
                    SET mr_uid = '" . $user['id'] . "',
                    mr_fid = '$mfid',
                    mr_time = '" . time() . "'");

    if (mysql_affected_rows($conn) < 1) {

        reporterror($l['mark_forum_error_title'], $l['mark_forum_error']);

        return false;
    }

    //Everything went just fine - Redirect to Index
    redirect('fid=' . $mfid);

    return true;
}

//End of function

function unreadtopic() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    //Call the Language function
    unreadtopic_lang();

    //Which forum to mark read ?
    if (isset($_GET['utid']) && trim($_GET['utid']) !== "") {

        $utid = (int) inputsec(htmlizer(trim($_GET['utid'])));
    } else {

        //Show a major error and return
        reporterror($l['no_topic_specified_title'], $l['no_topic_specified']);

        return false;
    }

    $qresult = makequery("SELECT t_bid FROM " . $dbtables['topics'] . "
                    WHERE tid = '$utid'");


    //Couldnt find the topic
    if (mysql_num_rows($qresult) < 1) {

        //Show a major error and return
        reporterror($l['no_topic_found_title'], $l['no_topic_found']);

        return false;
    } else {

        $row = mysql_fetch_assoc($qresult);

        $fid = $row['t_bid'];
    }


    //////////////////////////////////////
    // DELETE the user has read the topic
    //////////////////////////////////////

    $qresult = makequery("DELETE FROM " . $dbtables['read_topics'] . "
                    WHERE rt_uid = '" . $user['id'] . "'
                    AND rt_tid = '$utid'");

    if (mysql_affected_rows($conn) < 1) {

        reporterror($l['mark_topic_error_title'], $l['mark_topic_error']);

        return false;
    }

    //Everything went just fine - Redirect to that forum
    redirect('fid=' . $fid);

    return true;
}

//End of function
?>
