<?php

//////////////////////////////////////////////////////////////
//===========================================================
// locktopic.php
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

///////////////////////////////////
// Topics Status Number Meanings
// 0 - Locked
// 1 - Normal
// 2 - Moved Link(Cannot be Unlocked)
///////////////////////////////////

function locktopic() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $fid, $postcodefield, $error, $smileys, $emoticons, $popup_emoticons, $tid, $board, $post_title, $post, $i_started, $attachments;

    //Load the Language File
    if (!load_lang('locktopic')) {

        return false;
    }

    /* //The name of the file
      $theme['init_theme'] = 'locktopic';

      //The name of the Page
      $theme['init_theme_name'] = 'Lock Topics Theme';

      //Array of functions to initialize
      $theme['init_theme_func'] = array('locktopic_theme'); */

    //My activity
    $globals['last_activity'] = 'lt';


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////
    //A error handler ARRAY
    $error = array();

    //Other VARS

    $topic = '';

    $fids = array();

    $do = '';

    $get_tids = '';

    $invalid = array(); //Some invalid tid

    $tids_str = ''; //Clean string of ids

    $tids = array();

    $topics = array();

    $updated = 0;


    //What are we to do?
    if (isset($_GET['do']) && trim($_GET['do']) !== "" &&
            ( trim($_GET['do']) == 0 || trim($_GET['do']) == 1 )) {

        $do = (int) trim($_GET['do']);
    } else {

        //Show a major error and return
        reporterror($l['no_action_specified_title'], $l['no_action_specified']);

        return false;
    }


    if (isset($_GET['topid']) && trim($_GET['topid']) !== "") {

        $get_tids = inputsec(htmlizer(trim($_GET['topid'])));

        $tids = explode(',', $get_tids);
    } else {

        //Show a major error and return
        reporterror($l['no_topic_specified_title'], $l['no_topic_specified']);

        return false;
    }


    //Clean the tids
    foreach ($tids as $k => $v) {

        //Make it integer
        $tids[$k] = (int) trim($v);

        //Check if it is valid
        if (empty($tids[$k])) {

            $invalid[] = trim($v);
        }
    }


    //Did we get some invalid ones
    if (!empty($invalid)) {

        //Show a major error and return
        reporterror($l['invalid_topic_title'], lang_vars($l['invalid_topic'], array(implode(', ', $invalid))));

        return false;
    }

    //Make them unique also
    $tids = array_unique($tids);

    array_multisort($tids);

    $tids_str = implode(', ', $tids);


    //Bring the topic out
    $qresult = makequery("SELECT * FROM " . $dbtables['topics'] . "
            WHERE tid IN ($tids_str)");

    if (mysql_num_rows($qresult) < 1) {

        //Show a major error and return
        reporterror($l['no_topic_found_title'], $l['no_topic_found']);

        return false;

        //Are the number of topics less than the pids
    } elseif (mysql_num_rows($qresult) != count($tids)) {

        //Show a major error and return
        reporterror($l['some_topic_not_found_title'], $l['some_topic_not_found']);

        return false;
    }

    for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

        $row = mysql_fetch_assoc($qresult);

        $fid = $row['t_bid'];

        $fids[] = $row['t_bid'];

        //If they are of the same status no use to update
        if (($do == 1 && $row['t_status'] == 1) || ($do == 0 && $row['t_status'] == 0)) {

            continue;
        }

        $topics[$row['tid']] = $row;
    }

    //Free the resources
    mysql_free_result($qresult);


    //Check are they of the same forum or no
    if (count(array_unique($fids)) > 1) {

        //Show a major error and return
        reporterror($l['not_same_forum_title'], $l['not_same_forum']);

        return false;
    }


    //Load the board
    if (!default_of_nor(false)) {

        return false;
    }


    $its_board_level = '';

    //This is to find which forum is it that the user is viewing
    foreach ($forums as $c => $cv) {

        //The main forum loop
        foreach ($forums[$c] as $f => $v) {

            if ($forums[$c][$f]['fid'] == $fid) {

                $board = $forums[$c][$f];

                $its_board_level = $forums[$c][$f]['board_level'];

                break;
            }
        }
    }//End of main loop
    //Did we find any board
    if (empty($board)) {

        //Show a major error and return
        reporterror($l['no_forum_title'], $l['no_forum']);

        return false;
    }


    //Are we to redirect
    if (!empty($board['fredirect'])) {

        //Redirect
        header("Location: " . $board['fredirect']);

        return true;
    }


    //Is he a Moderator then load his permissions
    if (!is_mod()) {

        return false;
    }


    //He is viewing this forum and posting in this
    $globals['viewing_board'] = $board['fid'];


    foreach ($topics as $tk => $tv) {

        //Who started this post?
        if ($logged_in) {

            if ($topics[$tk]['t_mem_id'] == $user['id']) {

                $i_started = true;
            } else {

                $i_started = false;
            }
        } else {

            $i_started = false;
        }


        //Can he Lock/Unlock the post
        if (!(($i_started && $user['can_lock_own_topic']) ||
                (!$i_started && $user['can_lock_other_topic']))) {

            //Show a major error and return
            reporterror($l['no_lock_permission_title'], $l['no_lock_permission']);

            return false;
        }

        unset($i_started);
    }


    ////////////////////
    // UPDATE the topics
    ////////////////////

    $qresult = makequery("UPDATE " . $dbtables['topics'] . "
                    SET t_status = '$do'
                    WHERE tid IN ($tids_str)", false);

    //How many were updated ?
    $updated = $updated + mysql_affected_rows($conn);


    //Free the resources
    mysql_free_result($qresult);


    //Unlock the topics
    if ($do) {

        //Were things unlocked
        if ($updated != count($topics)) {

            reporterror($l['unlock_error_title'], $l['unlock_error']);

            return false;
        }

        //Lock Topics
    } else {

        //Were things locked
        if ($updated != count($topics)) {

            reporterror($l['lock_error_title'], $l['lock_error']);

            return false;
        }

        //Free the resources
        mysql_free_result($qresult);
    }


    //Looks like everything went well
    //Redirect

    if (count($tids) == 1) {

        redirect('tid=' . $tids[0]);
    } else {

        redirect('fid=' . $fid); //IE 7 #redirect not working
    }

    return true;
}

?>
