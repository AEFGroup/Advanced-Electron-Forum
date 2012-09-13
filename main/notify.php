<?php

//////////////////////////////////////////////////////////////
//===========================================================
// notify.php
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

function notify() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    //Load the Language File
    if (!load_lang('notify')) {

        return false;
    }

    if (!$logged_in) {

        //Redirect to the index
        redirect('');

        return false;
    }

    //What to notify , a forum
    if (isset($_GET['nact']) && trim($_GET['nact']) !== "") {

        $notify = inputsec(htmlizer(trim($_GET['nact'])));
    } else {

        //Redirect to the index
        redirect('');

        return false;
    }


    //The switch handler
    switch ($notify) {

        case 'topic' :
            notifytopic(); //Notify me the topic
            break;

        case 'forum':
            notifyforum(); //Notify me the forum
            break;

        case 'unsubtopic' :
            unsubtopic(); //Unsubscribe topic
            break;

        case 'unsubforum':
            unsubforum(); //Unsubscribe forum
            break;
    }
}

//End of function

function notifytopic() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $board;

    //Call the Language function
    notifytopic_lang();

    //Which topic to notify ?
    if (isset($_GET['ntid']) && trim($_GET['ntid']) !== "") {

        $ntid = (int) inputsec(htmlizer(trim($_GET['ntid'])));
    } else {

        //Show a major error and return
        reporterror($l['no_topic_specified_title'], $l['no_topic_specified']);

        return false;
    }

    //Load the boards
    if (!default_of_nor(false)) {

        return false;
    }


    //Bring the topic info
    $qresult = makequery("SELECT t.*
            FROM " . $dbtables['topics'] . " t
            WHERE t.tid = '$ntid'
            LIMIT 0, 1");


    if (mysql_num_rows($qresult) < 1) {

        //Show a major error and return
        reporterror($l['no_topic_found_title'], $l['no_topic_found']);

        return false;
    }

    $topic = mysql_fetch_assoc($qresult);


    //This is to find which forum is it that the user is viewing
    foreach ($forums as $c => $cv) {

        //The main forum loop
        foreach ($forums[$c] as $f => $v) {

            if ($forums[$c][$f]['fid'] == $topic['t_bid']) {

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

    //Is he a Moderator then load his permissions
    if (!is_mod()) {

        return false;
    }

    //Check is the user allowed to even subscribe
    if (!$user['notify_new_posts']) {

        //Redirect to the forum
        redirect('tid=' . $ntid);

        return false;
    }

    //////////////////////////////////
    // REPLACE the users row if there
    //////////////////////////////////

    $qresult = makequery("REPLACE INTO " . $dbtables['notify_topic'] . "
                    SET notify_mid = '" . $user['id'] . "',
                    notify_tid = '$ntid'");

    if (mysql_affected_rows($conn) < 1) {

        reporterror($l['subscription_error_title'], $l['subscription_error']);

        return false;
    }

    //Everything went just fine - Redirect to Index
    redirect('tid=' . $ntid);

    return true;
}

//End of function

function notifyforum() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $board;

    //Call the Language function
    notifyforum_lang();

    //Which forum to notify ?
    if (isset($_GET['nfid']) && trim($_GET['nfid']) !== "") {

        $nfid = (int) inputsec(htmlizer(trim($_GET['nfid'])));
    } else {

        //Show a major error and return
        reporterror($l['no_forum_specified_title'], $l['no_forum_specified']);

        return false;
    }

    //Load the boards
    if (!default_of_nor(false)) {

        return false;
    }


    //This is to find which forum is it that the user is viewing
    foreach ($forums as $c => $cv) {

        //The main forum loop
        foreach ($forums[$c] as $f => $v) {

            if ($forums[$c][$f]['fid'] == $nfid) {

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

    //Is he a Moderator then load his permissions
    if (!is_mod()) {

        return false;
    }

    //Check is the user allowed to even subscribe
    if (!$user['notify_new_topics']) {

        //Redirect to the forum
        redirect('fid=' . $nfid);

        return false;
    }

    //////////////////////////////////
    // REPLACE the users row if there
    //////////////////////////////////

    $qresult = makequery("REPLACE INTO " . $dbtables['notify_forum'] . "
                    SET notify_mid = '" . $user['id'] . "',
                    notify_fid = '$nfid'");

    if (mysql_affected_rows($conn) < 1) {

        reporterror($l['subscription_error_title'], $l['subscription_error']);

        return false;
    }

    //Everything went just fine - Redirect to Index
    redirect('fid=' . $nfid);

    return true;
}

//End of function

function unsubtopic() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $board;

    //Call the Language function
    unsubtopic_lang();

    //Which forum to unsubscribe ?
    if (isset($_GET['ntid']) && trim($_GET['ntid']) !== "") {

        $ntid = (int) inputsec(htmlizer(trim($_GET['ntid'])));
    } else {

        //Show a major error and return
        reporterror($l['no_topic_specified_title'], $l['no_topic_specified']);

        return false;
    }

    //////////////////////////////////
    // DELETE the users row if there
    //////////////////////////////////

    $qresult = makequery("DELETE FROM " . $dbtables['notify_topic'] . "
                    WHERE notify_mid = '" . $user['id'] . "'
                    AND notify_tid = '$ntid'", false);

    if (mysql_affected_rows($conn) < 1) {

        reporterror($l['unsubscription_error_title'], $l['unsubscription_error']);

        return false;
    }

    //Everything went just fine - Redirect to Index
    redirect('tid=' . $ntid);

    return true;
}

//End of function

function unsubforum() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $board;

    //Call the Language function
    unsubforum_lang();

    //Which forum to notify ?
    if (isset($_GET['nfid']) && trim($_GET['nfid']) !== "") {

        $nfid = (int) inputsec(htmlizer(trim($_GET['nfid'])));
    } else {

        //Show a major error and return
        reporterror($l['no_forum_specified_title'], $l['no_forum_specified']);

        return false;
    }

    //////////////////////////////////
    // DELETE the users row if there
    //////////////////////////////////

    $qresult = makequery("DELETE FROM " . $dbtables['notify_forum'] . "
                    WHERE notify_mid = '" . $user['id'] . "'
                    AND notify_fid = '$nfid'");

    if (mysql_affected_rows($conn) < 1) {

        reporterror($l['unsubscription_error_title'], $l['unsubscription_error']);

        return false;
    }

    //Everything went just fine - Redirect to Index
    redirect('fid=' . $nfid);

    return true;
}

//End of function
?>
