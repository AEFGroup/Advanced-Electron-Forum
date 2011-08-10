<?php

//////////////////////////////////////////////////////////////
//===========================================================
// edittopic.php
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

//Load the Language File
load_lang('edittopic');

function edittopic() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $fid, $error, $board, $topic, $tree;

    //Load the Language File
    if (!load_lang('edittopic')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'edittopic';

    //The name of the Page
    $theme['init_theme_name'] = 'Edit Topic Theme';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('edittopic_theme');

    //My activity
    $globals['last_activity'] = 'et';


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////
    //Topic VARS
    $tid = 0;

    $title = '';

    $t_description = '';

    $type_image = 0;

    //Other VARS
    $fid = 0;

    $tree = array(); //Board tree for users location
    $tree[] = array('l' => $globals['index_url'],
        'txt' => $l['index']);

    if (isset($_GET['topid']) && trim($_GET['topid']) !== "") {

        $tid = (int) inputsec(htmlizer(trim($_GET['topid'])));
    } else {

        //Show a major error and return
        reporterror($l['no_topic_specified_title'], $l['no_topic_specified']);

        return false;
    }

    //Bring the topic out
    $qresult = makequery("SELECT * FROM " . $dbtables['topics'] . "
            WHERE tid = '$tid'");

    if (mysql_num_rows($qresult) < 1) {

        //Show a major error and return
        reporterror($l['no_topic_found_title'], $l['no_topic_found']);

        return false;
    }

    //Fetch the topic
    $topic = mysql_fetch_assoc($qresult);

    $fid = $topic['t_bid'];

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
        reporterror($l['no_forum_found_title'], $l['no_forum_found']);

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

    //He is viewing this topic
    $globals['activity_id'] = $topic['tid'];

    $globals['activity_text'] = $topic['topic'];


    //Lets make the tree
    //First the category
    $tree[] = array('l' => $globals['index_url'] . '#cid' . $board['cat_id'],
        'txt' => $categories[$board['cat_id']]['name']);

    //Now the forums location
    $cid = $board['cat_id'];

    $tree_fid = $board['fid'];

    $temp_r = array();

    //Insert this board in the temp array
    $temp_r[] = $board['fid'];

    while (true) {

        //Does this board have a parent
        if (!empty($forums[$cid]['fid' . $tree_fid]['par_board_id'])) {

            $tree_fid = $forums[$cid]['fid' . $tree_fid]['par_board_id'];

            $temp_r[] = $tree_fid;

            //You dont have a parent
        } else {

            break;
        }
    }

    //Now flip the array
    $temp_r = array_reverse($temp_r);

    foreach ($temp_r as $v) {

        $tree[] = array('l' => $globals['index_url'] . 'fid=' . $v,
            'txt' => $forums[$cid]['fid' . $v]['fname']);
    }

    //Add the topic link
    $tree[] = array('l' => $globals['index_url'] . 'tid=' . $topic['tid'],
        'txt' => $topic['topic']);

    //Add the inner topic link also
    $tree[] = array('l' => $globals['index_url'] . 'act=edittopic&topid=' . $topic['tid'],
        'txt' => $l['editing_topic']);


    //The forums theme
    forum_theme();

    //Who started this post?
    if ($logged_in) {

        if ($topic['t_mem_id'] == $user['id']) {

            $i_started = true;
        } else {

            $i_started = false;
        }
    } else {

        $i_started = false;
    }


    //Can he Lock/Unlock the post
    if (!(($i_started && $user['can_edit_own_topic']) ||
            (!$i_started && $user['can_edit_other_topic']))) {

        //Show a major error and return
        reporterror($l['no_edit_permissions_title'], $l['no_edit_permissions']);

        return false;
    }

    unset($i_started);


    //If the user is submitting the edited topic
    if (isset($_POST['edittopic'])) {

        //Check if the damn Title field exists.
        if (!(isset($_POST['toptitle'])) || strlen(trim($_POST['toptitle'])) < 1) {

            $error[] = $l['no_title'];
        } else {

            $title = inputsec(htmlizer(trim($_POST['toptitle'])));

            $title = checktitle($title);
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'edittopic_theme';
            return false;
        }


        //If description field isset
        if (isset($_POST['topdesc']) && strlen(trim($_POST['topdesc'])) > 0) {

            $t_description = inputsec(htmlizer(trim($_POST['topdesc'])));

            $t_description = checkdescription($t_description);
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'edittopic_theme';
            return false;
        }


        //Topic Icons / Type Images
        if (isset($_POST['topic_icon']) && (strlen(trim($_POST['topic_icon'])) > 0) && is_numeric(trim($_POST['topic_icon']))) {

            $type_image = inputsec(htmlizer(trim($_POST['topic_icon'])));
        }


        //If everything is the same dont try and update
        if ($topic['topic'] != $title || $topic['t_description'] != $t_description || $topic['type_image'] != $type_image) {

            /////////////////////////////////
            // Finally lets start the queries
            // Effects of editing a topic :
            // 1 - UPDATE in topics table
            /////////////////////////////////
            ////////////////////
            // UPDATE the topic
            ////////////////////

            $qresult = makequery("UPDATE " . $dbtables['topics'] . "
                        SET topic = '$title',
                        t_description = '$t_description',
                        type_image = '$type_image'
                        WHERE tid = '$tid'", false);

            //Was the topic info updated
            if (mysql_affected_rows($conn) < 1) {

                reporterror($l['edit_error_title'], $l['edit_error']);

                return false;
            }

            //Free the resources
            @mysql_free_result($qresult);
        }

        //Redirect
        redirect('tid=' . $tid); //IE 7 #redirect not working

        return true;
    } else {

        $theme['call_theme_func'] = 'edittopic_theme';
    }
}

?>
