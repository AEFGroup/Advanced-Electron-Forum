<?php

//////////////////////////////////////////////////////////////
//===========================================================
// news.php
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

//////////////////////////////////////
// Shows the statistics of the board
//////////////////////////////////////


function news() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $tree;

    //Load the Language File
    if (!load_lang('news')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'news';

    //The name of the Page
    $theme['init_theme_name'] = 'News';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('shownews_theme',
        'submitnews_theme',
        'editnews_theme');


    //Is news enabled
    if (empty($globals['enablenews'])) {

        //Show a major error and return
        reporterror($l['news_disabled_title'], $l['news_disabled']);

        return false;
    }

    $tree = array(); //Board tree for users location
    $tree[] = array('l' => $globals['index_url'],
        'txt' => $l['index']);
    $tree[] = array('l' => $globals['index_url'] . 'act=news',
        'txt' => $l['news']);

    if (isset($_GET['nact']) && trim($_GET['nact']) !== "") {

        $nact = inputsec(htmlizer(trim($_GET['nact'])));
    } else {

        $nact = '';
    }

    switch ($nact) {

        //Show all the news
        default:
            shownews();
            break;

        case 'submitnews':
            submitnews();
            break;

        case 'editnews':
            editnews();
            break;

        case 'approvenews':
            approvenews();
            break;

        case 'deletenews':
            deletenews();
            break;
    }
}

function shownews() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $news, $page, $numarticles;

    //Call the Language function
    shownews_lang();

    $news = array();

    $numarticles = 0;

    //Quick Moderation jumper
    if (isset($_POST['withselected']) && !empty($_POST['nids']) && is_array($_POST['nids'])) {

        $nids = implode(',', $_POST['nids']);

        $withselected = inputsec(htmlizer(trim($_POST['withselected'])));

        switch ($withselected) {

            case 'delete':
                $redirect = 'act=news&nact=deletenews&nid=' . $nids;
                break;

            case 'approve':
                $redirect = 'act=news&nact=approvenews&&do=1&nid=' . $nids;
                break;

            case 'unapprove':
                $redirect = 'act=news&nact=approvenews&&do=0&nid=' . $nids;
                break;
        }

        if (!empty($redirect)) {

            redirect($redirect);

            return true;
        }
    }

    //Checks the Page to see
    $page = get_page('npg', $globals['newsperpage']);

    if (!empty($_GET['nid'])) {

        $nid = inputsec(htmlizer(trim($_GET['nid'])));

        npg($nid); //Find the Page number - It will pass it to $_GET['npg']

        $page = get_page('npg', $globals['newsperpage']);
    }

    //Seeing the news
    $globals['last_activity'] = 'news';

    //Bring the number of articles
    $qresult = makequery("SELECT COUNT(nid) AS numarticles FROM " . $dbtables['news']);

    if (mysql_num_rows($qresult) > 0) {

        $temp = mysql_fetch_assoc($qresult);

        $numarticles = $temp['numarticles'];
    }

    //Bring the news out
    $qresult = makequery("SELECT n.*, u.username FROM " . $dbtables['news'] . " n
            LEFT JOIN " . $dbtables['users'] . " u ON (n.uid = u.id)
            " . ($user['can_approve_news'] ? "" : "WHERE approved = '1'" ) .
            "ORDER BY n.nid DESC
            LIMIT $page, " . $globals['newsperpage']);

    //Where are the boards ?
    if (mysql_num_rows($qresult) > 0) {

        //The loop to draw out the rows
        for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

            $row = mysql_fetch_assoc($qresult);

            //Is it by a guest
            if (empty($row['username'])) {

                $row['username'] = 'Guest';
            }

            //Special bbc
            $row['news'] = parse_special_bbc($row['news']);

            //Format the text
            $row['news'] = format_text($row['news']);

            //Break it up
            $row['news'] = parse_br($row['news']);

            $news[$row['nid']] = $row;

            unset($row);
        }//End of main for loop
        //Free the resources
        @mysql_free_result($qresult);
    }

    $theme['call_theme_func'] = 'shownews_theme';
}

function submitnews() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $tree, $postcodefield, $error;

    //Call the Language function
    submitnews_lang();

    //Can you submit news articles
    if (empty($user['can_submit_news'])) {

        //Show a major error and return
        reporterror($l['no_permission_title'], $l['no_permission']);

        return false;
    }

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $uid = ($logged_in ? $user['id'] : -1);

    $title = '';

    $news = '';

    $time = time();

    $image = '';

    $fullstorylink = '';

    $approved = $user['can_approve_news'];

    $showinticker = 0;

    $error = array();

    $tree[] = array('l' => $globals['index_url'] . 'act=news&nact=submitnews',
        'txt' => $l['submit_news']);

    //My activity
    $globals['last_activity'] = 'subn';

    ///////////////////////////////////////
    // Create a 16 bit random code for POST
    // DATA REFRESH Problem to be solved.
    ///////////////////////////////////////

    if (empty($AEF_SESS['postcode']) || !is_array($AEF_SESS['postcode'])) {

        $AEF_SESS['postcode'] = array();
    }

    $postcodefield = '<input type="hidden" value="' . generateRandStr(16) . '" name="postcode" />';


    if (isset($_POST['submitnews'])) {

        //Is postcode posted
        if (!(isset($_POST['postcode'])) || strlen(trim($_POST['postcode'])) < 16) {

            $error[] = $l['no_security_code'];
        } else {

            $postedcode = inputsec(strtolower(htmlizer(trim($_POST['postcode']))));

            //////////////////////////////////
            // This is a very important thing
            // to check for automated registrations
            //////////////////////////////////

            if (in_array($postedcode, $AEF_SESS['postcode'])) {

                $error[] = $l['wrong_security_code'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'submitnews_theme';
            return false;
        }


        //The Title field
        if (!(isset($_POST['title'])) || strlen(trim($_POST['title'])) < 1) {

            $error[] = $l['no_title'];
        } else {

            $title = inputsec(htmlizer(trim($_POST['title'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'submitnews_theme';
            return false;
        }


        //The News article
        if (!(isset($_POST['news'])) || strlen(trim($_POST['news'])) < 1) {

            $error[] = $l['no_news'];
        } else {

            $news = inputsec(htmlizer(trim($_POST['news'])));
        }


        //The Full Story Link
        if (!empty($_POST['fullstorylink'])) {

            $fullstorylink = inputsec(htmlizer(trim($_POST['fullstorylink'])));
        }

        //The Image Link
        if (!empty($_POST['image'])) {

            $image = inputsec(htmlizer(trim($_POST['image'])));
        }

        //Show in the news ticker
        if (isset($_POST['showinticker'])) {

            $showinticker = 1;
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'submitnews_theme';
            return false;
        }


        ///////////////////////
        // INSERT the news now
        ///////////////////////

        $qresult = makequery("INSERT INTO " . $dbtables['news'] . "
                        SET uid = '$uid',
                        title = '$title',
                        news = '$news',
                        time = '$time',
                        image = '$image',
                        fullstorylink = '$fullstorylink',
                        approved = '$approved',
                        showinticker = '$showinticker'");

        $nid = mysql_insert_id($conn);

        if (empty($nid)) {

            reporterror($l['submit_news_error_title'], $l['submit_news_error']);

            return false;
        }

        //Store that this code was successful
        $AEF_SESS['postcode'][] = $postedcode;

        //Redirect
        redirect('act=news');

        return true;
    } else {

        $theme['call_theme_func'] = 'submitnews_theme';
    }
}

function editnews() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $tree, $error, $newsarticle;

    //Call the Language function
    editnews_lang();

    //Can you edit news articles
    if (empty($user['can_edit_news'])) {

        //Show a major error and return
        reporterror($l['no_edit_permission_title'], $l['no_edit_permission']);

        return false;
    }


    if (isset($_GET['nid']) && trim($_GET['nid']) !== "") {

        $nid = (int) inputsec(htmlizer(trim($_GET['nid'])));
    } else {

        //Show a major error and return
        reporterror($l['no_news_specified_title'], $l['no_news_specified']);

        return false;
    }

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $title = '';

    $news = '';

    $image = '';

    $fullstorylink = '';

    $showinticker = 0;

    $error = array();

    //Bring the topic out
    $qresult = makequery("SELECT * FROM " . $dbtables['news'] . "
            WHERE nid = '$nid'");

    if (mysql_num_rows($qresult) < 1) {

        //Show a major error and return
        reporterror($l['no_news_found_title'], $l['no_news_found']);

        return false;
    }

    //Fetch the topic
    $newsarticle = mysql_fetch_assoc($qresult);

    //Free the resources
    @mysql_free_result($qresult);

    //My activity
    $globals['last_activity'] = 'editn';

    //He is editing this news article
    $globals['activity_id'] = $newsarticle['nid'];

    $globals['activity_text'] = $newsarticle['title'];


    $tree[] = array('l' => $globals['index_url'] . 'act=news&nact=editnews&nid=' . $newsarticle['nid'],
        'txt' => $l['editin_news']);


    if (isset($_POST['editnews'])) {

        //The Title field
        if (!(isset($_POST['title'])) || strlen(trim($_POST['title'])) < 1) {

            $error[] = $l['no_title'];
        } else {

            $title = inputsec(htmlizer(trim($_POST['title'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editnews_theme';
            return false;
        }


        //The News article
        if (!(isset($_POST['news'])) || strlen(trim($_POST['news'])) < 1) {

            $error[] = $l['no_news'];
        } else {

            $news = inputsec(htmlizer(trim($_POST['news'])));
        }


        //The Full Story Link
        if (!empty($_POST['fullstorylink'])) {

            $fullstorylink = inputsec(htmlizer(trim($_POST['fullstorylink'])));
        }

        //The Image Link
        if (!empty($_POST['image'])) {

            $image = inputsec(htmlizer(trim($_POST['image'])));
        }

        //Show in the news ticker
        if (isset($_POST['showinticker'])) {

            $showinticker = 1;
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editnews_theme';
            return false;
        }


        ///////////////////////
        // INSERT the news now
        ///////////////////////

        $qresult = makequery("UPDATE " . $dbtables['news'] . "
                        SET title = '$title',
                        news = '$news',
                        image = '$image',
                        fullstorylink = '$fullstorylink',
                        showinticker = '$showinticker'
                        WHERE nid = '$nid'", false);

        //Redirect
        redirect('act=news#n' . $nid);

        return true;
    } else {

        $theme['call_theme_func'] = 'editnews_theme';
    }
}

function approvenews() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    //Call the Language function
    approvenews_lang();

    //Can he APPROVE the news
    if (empty($user['can_approve_news'])) {

        //Show a major error and return
        reporterror($l['no_approve_permission_title'], $l['no_approve_permission']);

        return false;
    }

    if (isset($_GET['do']) && trim($_GET['do']) !== "") {

        $do = (int) inputsec(htmlizer(trim($_GET['do'])));

        if (!($do == 1 || $do == 0)) {

            //Show a major error and return
            reporterror($l['invalid_action_specified_title'], $l['invalid_action_specified']);

            return false;
        }
    } else {

        //Show a major error and return
        reporterror($l['no_action_specified_title'], $l['no_action_specified']);

        return false;
    }


    if (isset($_GET['nid']) && trim($_GET['nid']) !== "") {

        $get_nids = inputsec(htmlizer(trim($_GET['nid'])));

        $nids = explode(',', $get_nids);
    } else {

        //Show a major error and return
        reporterror($l['no_news_specified_title'], $l['no_news_specified']);

        return false;
    }

    //Clean the pids
    foreach ($nids as $k => $v) {

        //Make it integer
        $nids[$k] = (int) trim($v);

        //Check if it is valid
        if (empty($nids[$k])) {

            $invalid[] = trim($v);
        }
    }


    //Did we get some invalid ones
    if (!empty($invalid)) {

        //Show a major error and return
        reporterror($l['invalid_news_specified_title'], lang_vars($l['invalid_news_specified'], array(implode(', ', $invalid))));

        return false;
    }

    //Make them unique also
    $nids = array_unique($nids);

    array_multisort($nids);

    $nids_str = implode(', ', $nids);


    ///////////////////
    // DELETE the news
    ///////////////////

    $qresult = makequery("UPDATE " . $dbtables['news'] . "
                    SET approved = '$do'
                    WHERE nid IN ($nids_str)", false);

    //How many were deleted ?
    $did = mysql_affected_rows($conn);

    if (empty($did) && $do == 0) {

        reporterror($l['unapprove_error_title'], $l['unapprove_error']);

        return false;
    }

    if (empty($did) && $do == 1) {

        reporterror($l['approve_error_title'], $l['approve_error']);

        return false;
    }

    //Looks like everything went well
    //Redirect
    redirect('act=news');

    return true;
}

function deletenews() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    //Call the Language function
    deletenews_lang();

    //Can he DELETE the news
    if (empty($user['can_delete_news'])) {

        //Show a major error and return
        reporterror($l['no_delete_permission_title'], $l['no_delete_permission']);

        return false;
    }

    if (isset($_GET['nid']) && trim($_GET['nid']) !== "") {

        $get_nids = inputsec(htmlizer(trim($_GET['nid'])));

        $nids = explode(',', $get_nids);
    } else {

        //Show a major error and return
        reporterror($l['no_news_specified_title'], $l['no_news_specified']);

        return false;
    }

    //Clean the pids
    foreach ($nids as $k => $v) {

        //Make it integer
        $nids[$k] = (int) trim($v);

        //Check if it is valid
        if (empty($nids[$k])) {

            $invalid[] = trim($v);
        }
    }


    //Did we get some invalid ones
    if (!empty($invalid)) {

        //Show a major error and return
        reporterror($l['invalid_news_specified_title'], lang_vars($l['invalid_news_specified'], array(implode(', ', $invalid))));

        return false;
    }

    //Make them unique also
    $nids = array_unique($nids);

    array_multisort($nids);

    $nids_str = implode(', ', $nids);


    ///////////////////
    // DELETE the news
    ///////////////////

    $qresult = makequery("DELETE FROM " . $dbtables['news'] . "
                    WHERE nid IN ($nids_str)", false);

    //How many were deleted ?
    $deleted = mysql_affected_rows($conn);

    if (empty($deleted)) {

        reporterror($l['delete_error_title'], $l['delete_error']);

        return false;
    }

    //Looks like everything went well
    //Redirect
    redirect('act=news');

    return true;
}

function newslinks() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    $news = array();

    $where = array();

    //Show unapproved or not
    if (!$user['can_approve_news'])
        $where['approved'] = "approved = '1'";

    //Show ticked news
    if ($globals['tickednews'])
        $where['news'] = "showinticker = '1'";

    //Show todays news as well
    if ($globals['todaysnews'])
        $where['news'] = "(" . (empty($where['news']) ? '' : $where['news'] . " OR ") . "DATE_FORMAT(FROM_UNIXTIME(time), '%Y%m%d') = '" . datify(time(), false, true, 'Ymd') . "')";

    //Are we to show some news!
    if (empty($where['news'])) {

        return $news;
    }

    //Bring the news out
    $qresult = makequery("SELECT nid, title, approved FROM " . $dbtables['news'] . "
            " . (empty($where) ? "" : "WHERE " . implode(' AND ', $where) ) . "
            ORDER BY nid DESC");

    //Where are the boards ?
    if (mysql_num_rows($qresult) > 0) {

        //The loop to draw out the rows
        for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

            $row = mysql_fetch_assoc($qresult);

            $news[$row['nid']] = $row;

            unset($row);
        }//End of main for loop
        //Free the resources
        @mysql_free_result($qresult);
    }

    return $news;
}

//Calculate the News page number.
function npg($nid) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    $rownum = 0;

    $qresult = makequery("SELECT nid FROM " . $dbtables['news'] . "
                    ORDER BY nid DESC");

    for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

        $row = mysql_fetch_assoc($qresult);

        if ($nid == $row['nid']) {

            $rownum = $i;

            break;
        }
    }

    //Free the resources
    @mysql_free_result($qresult);

    $npg = ($rownum / $globals['newsperpage']);

    $npg = ceil($npg);

    $_GET['npg'] = $npg;
}

?>
