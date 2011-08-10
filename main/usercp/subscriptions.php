<?php

//////////////////////////////////////////////////////////////
//===========================================================
// subscriptions.php(usercp)
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


if (!load_lang('usercp/subscriptions')) {

    return false;
}

//The name of the file
$theme['init_theme'] = 'usercp/subscriptions';

//The name of the Page
$theme['init_theme_name'] = $l['subsc_usercp_subscriptions'];

//Array of functions to initialize
$theme['init_theme_func'] = array('topicsub_theme',
    'forumsub_theme');

///////////////////////////////////////////////////
// This function will show Your Topic Subscriptions
///////////////////////////////////////////////////

function topicsub() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $subscriptions, $count, $tree;

    //Is it even on
    if (!$globals['notifications']) {

        reporterror($l['subsc_error'], $l['subsc_error_exp']);

        return false;
    }


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $tidarray = array();

    $tids = array();

    $tree[] = array('l' => $globals['index_url'] . 'act=usercp&ucpact=topicsub',
        'txt' => $l['subsc_notifications']);

    $tree[] = array('l' => $globals['index_url'] . 'act=usercp&ucpact=topicsub',
        'txt' => $l['subsc_topic_notifications']);

    //Count the subscriptions that you have
    $qresult = makequery("SELECT COUNT(nt.notify_tid) AS count
            FROM " . $dbtables['notify_topic'] . " nt
            WHERE nt.notify_mid = '" . $user['id'] . "'");

    if (mysql_num_rows($qresult) < 1) {

        //Show a major error and return
        reporterror($l['subsc_no page found'], $l['subsc_no page found_exp']);

        return false;
    }

    $row = mysql_fetch_assoc($qresult);

    $count = (empty($row['count']) ? 1 : $row['count']);

    //If the user has asked to unsubscribe something
    if (isset($_POST['unsubseltsub'])) {

        //The User might have not selected anything
        if (empty($_POST['list'])) {

            //Redirect
            redirect('act=usercp&ucpact=topicsub');
        }

        $tidarray = $_POST['list'];

        foreach ($tidarray as $tk => $tv) {

            //It must be Numeric
            if (is_numeric($tv)) {

                $tids[] = $tv;
            }
        }

        array_multisort($tids);

        $tids_str = implode(', ', $tids);

        ////////////////////////////////////
        // Finally lets QUERY to Unsubscribe
        ////////////////////////////////////

        $qresult = makequery("DELETE FROM " . $dbtables['notify_topic'] . "
                        WHERE notify_mid = '" . $user['id'] . "'
                        AND notify_tid IN ($tids_str)", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['subsc_unsubscription_error'], $l['subsc_unsubscription_error_topic_exp1']);

            return false;
        }

        //Redirect
        redirect('act=usercp&ucpact=topicsub'); //IE 7 #redirect not working

        return true;
    }


    //Check the Topic Subscription Page
    $page = get_page('tsubpg', $globals['numsubinpage']);


    //Get the PM in the Inbox of this user.
    $qresult = makequery("SELECT nt.*, t.topic
            FROM " . $dbtables['notify_topic'] . " nt
            LEFT JOIN " . $dbtables['topics'] . " t ON (nt.notify_tid = t.tid)
            WHERE nt.notify_mid = '" . $user['id'] . "'
            ORDER BY nt.notify_tid ASC
            LIMIT $page, " . $globals['numsubinpage']);

    if (mysql_num_rows($qresult) < 1) {

        //If it is not the first page - then you specified an invalid link
        if ($page > 0) {

            //Show a major error and return
            reporterror($l['subsc_no page found'], $l['subsc_unsubscription_error_topic_exp2']);

            return false;
        }
    } else {

        for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

            $subscriptions[$i] = mysql_fetch_assoc($qresult);
        }
    }


    $theme['call_theme_func'] = 'topicsub_theme';
}

//End of function
///////////////////////////////////////////////////
// This function will show Your Topic Subscriptions
///////////////////////////////////////////////////

function forumsub() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $subscriptions, $count, $tree;

    //Is it even on
    if (!$globals['notifications']) {

        reporterror($l['subsc_error'], $l['subsc_error_exp']);

        return false;
    }


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $fidarray = array();

    $fids = array();

    $tree[] = array('l' => $globals['index_url'] . 'act=usercp&ucpact=topicsub',
        'txt' => $l['subsc_notifications']);

    $tree[] = array('l' => $globals['index_url'] . 'act=usercp&ucpact=forumsub',
        'txt' => $l['subsc_forum_notifications']);

    //Count the subscriptions that you have
    $qresult = makequery("SELECT COUNT(nf.notify_fid) AS count
            FROM " . $dbtables['notify_forum'] . " nf
            WHERE nf.notify_mid = '" . $user['id'] . "'");

    if (mysql_num_rows($qresult) < 1) {

        //Show a major error and return
        reporterror($l['subsc_no page found'], $l['subsc_no page found_exp']);

        return false;
    }

    $row = mysql_fetch_assoc($qresult);

    $count = (empty($row['count']) ? 1 : $row['count']);

    //If the user has asked to unsubscribe something
    if (isset($_POST['unsubselfsub'])) {

        //The User might have not selected anything
        if (empty($_POST['list'])) {

            //Redirect
            redirect('act=usercp&ucpact=forumsub');
        }

        $fidarray = $_POST['list'];

        foreach ($fidarray as $fk => $fv) {

            //It must be Numeric
            if (is_numeric($fv)) {

                $fids[] = $fv;
            }
        }

        array_multisort($fids);

        $fids_str = implode(', ', $fids);

        ////////////////////////////////////
        // Finally lets QUERY to Unsubscribe
        ////////////////////////////////////

        $qresult = makequery("DELETE FROM " . $dbtables['notify_forum'] . "
                        WHERE notify_mid = '" . $user['id'] . "'
                        AND notify_fid IN ($fids_str)", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['subsc_unsubscription_error'], $l['subsc_unsubscription_error_forum_exp1']);

            return false;
        }

        //Redirect
        redirect('act=usercp&ucpact=forumsub'); //IE 7 #redirect not working

        return true;
    }


    //Check the Topic Subscription Page
    $page = get_page('fsubpg', $globals['numsubinpage']);


    //Get the Subscriptions
    $qresult = makequery("SELECT nf.*, f.fname
            FROM " . $dbtables['notify_forum'] . " nf
            LEFT JOIN " . $dbtables['forums'] . " f ON (nf.notify_fid = f.fid)
            WHERE nf.notify_mid = '" . $user['id'] . "'
            ORDER BY nf.notify_fid ASC
            LIMIT $page, " . $globals['numsubinpage']);

    if (mysql_num_rows($qresult) < 1) {

        //If it is not the first page - then you specified an invalid link
        if ($page > 0) {

            //Show a major error and return
            reporterror($l['subsc_no page found'], $l['subsc_unsubscription_error_forum_exp']);

            return false;
        }
    } else {

        for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

            $subscriptions[$i] = mysql_fetch_assoc($qresult);
        }
    }

    $theme['call_theme_func'] = 'forumsub_theme';
}

//End of function
?>
