<?php

//////////////////////////////////////////////////////////////
//===========================================================
// splittopic.php
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

///////////////////////////////////
// What things are to be changed
// 1 - Topics
// 2 - Posts, Users Post Count
// 3 - Attachments
// 4 - Polls,Options and Voters
// 5 - Notifications
// 6 - Read Topics
///////////////////////////////////


function deletetopic() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $fid, $error, $board;

    /* //The name of the file
      $theme['init_theme'] = 'deletetopic';

      //The name of the Page
      $theme['init_theme_name'] = 'Delete Topic Theme';

      //Array of functions to initialize
      $theme['init_theme_func'] = array('deletetopic_theme'); */

    //My activity
    $globals['last_activity'] = 'dt';


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////
    //A error handler ARRAY
    $error = array();

    //Other VARS

    $topic = '';

    $fids = array();

    $get_tids = '';

    $invalid = array(); //Some invalid tid

    $tids_str = ''; //Clean string of ids

    $tids = array();

    $topics = array();

    $deleted = 0;

    $updated = 0;

    $posts = array();

    $pids = array();

    $pids_str = ''; //Clean string of ids

    $n_posts = 0;

    $attachments = array();

    $attach_pids = array(); //Array of pids having attachments

    $poll_tids = array(); //Array of tids having polls

    $polls = array();


    if (isset($_GET['topid']) && trim($_GET['topid']) !== "") {

        $get_tids = inputsec(htmlizer(trim($_GET['topid'])));

        $tids = explode(',', $get_tids);
    } else {

        //Show a major error and return
        reporterror('No Topic specified', 'Sorry, we were unable to process your request because no topic id was specified. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.');

        return false;
    }


    //Clean the tids
    foreach ($tids as $k => $v) {

        //Make it integer
        $tids[$k] = (int) trim($v);

        //Check if it is valid
        if (empty($tids[$k])) {

            $invalid[] = $tids[$k];
        }
    }


    //Did we get some invalid ones
    if (!empty($invalid)) {

        //Show a major error and return
        reporterror('Invalid topic specified', 'Sorry, we were unable to process your request because these topic(s) - \'' . implode(', ', $invalid) . '\' are invalid. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.');

        return false;
    }

    //Make them unique also
    $tids = array_unique($tids);

    array_multisort($tids);

    $tids_str = implode(', ', $tids);


    //Bring the topics out
    $qresult = makequery("SELECT tid, t_bid, n_posts, t_mem_id, poll_id, has_attach
            FROM " . $dbtables['topics'] . "
            WHERE tid IN ($tids_str)");

    if (mysql_num_rows($qresult) < 1) {

        //Show a major error and return
        reporterror('No Topic Found', 'Sorry, we were unable to process your request because the topic(s) you are trying to delete were not found in the database. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.');

        return false;

        //Are the number of topics less than the pids
    } elseif (mysql_num_rows($qresult) != count($tids)) {

        //Show a major error and return
        reporterror('Some topic(s) Not Found', 'Sorry, we were unable to process your request because some of the topic(s) were not found in the database. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.');

        return false;
    }

    for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

        $row = mysql_fetch_assoc($qresult);

        $topics[$row['tid']] = $row;

        $fid = $row['t_bid'];

        $fids[] = $row['t_bid'];

        $n_posts = $n_posts + ($row['n_posts'] + 1);

        //Are there any polls
        if (!empty($row['poll_id'])) {

            $poll_tids[] = $row['tid'];
        }
    }


    //Free the resources
    mysql_free_result($qresult);


    //Check are they of the same forum or no
    if (count(array_unique($fids)) > 1) {

        //Show a major error and return
        reporterror('Invalid posts specified', 'Sorry, we were unable to process your request because the topic(s) you are trying to delete are not of the same forum. You can delete several topics at the same time only if they belong to the same forum. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.');

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
        reporterror('No forum found', 'The forum you specified either does not exists or you are not authorised to view the same. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.');

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


        //Can he delete the topics
        if (!(($i_started && $user['can_del_own_topic']) ||
                (!$i_started && $user['can_del_other_topic']))) {

            //Show a major error and return
            reporterror('Access Denied', 'Sorry, you are not allowed to delete some of the topic(s) as you do not have the permissions to do so. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.');

            return false;
        }

        unset($i_started);
    }


    //Bring the pids out
    $qresult = makequery("SELECT pid, num_attachments
            FROM " . $dbtables['posts'] . "
            WHERE post_tid IN ($tids_str)");

    if (mysql_num_rows($qresult) < 1) {

        //Show a major error and return
        reporterror('No Posts Found', 'Sorry, we were unable to process your request because the posts of the topic(s) you are trying to delete were not found in the database. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.');

        return false;
    }

    //Loop through the pids
    for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

        $row = mysql_fetch_assoc($qresult);

        $posts[$row['pid']] = $row;

        $pids[] = $row['pid'];

        //Are there any attachments
        if ($row['num_attachments'] >= 1) {

            $attach_pids[] = $row['pid'];
        }
    }

    array_multisort($pids);

    $pids_str = implode(', ', $pids);

    //Free the resources
    mysql_free_result($qresult);





    //return false;
    ///////////////////////////////
    // UPDATE the users post count
    ///////////////////////////////
    //Not for guests and should we increase
    if ($board['inc_mem_posts']) {

        //Bring the poster count out
        $qresult = makequery("SELECT poster_id AS id, COUNT(ptime) AS num
                FROM " . $dbtables['posts'] . "
                WHERE post_tid IN ($tids_str) AND poster_id != '-1'
                GROUP BY poster_id");

        $num_rows = mysql_num_rows($qresult);

        $posters = array();

        for ($i = 1; $i <= $num_rows; $i++) {

            $row = mysql_fetch_assoc($qresult);

            $posters[] = $row;

            unset($row);
        }


        //Loop through the posters as there may be many
        foreach ($posters as $pk => $pv) {

            $qresult = makequery("UPDATE " . $dbtables['users'] . "
                            SET posts = posts - " . $pv['num'] . "
                            WHERE id = '" . $pv['id'] . "'", false);

            /* if(mysql_affected_rows($conn) < 1){

              reporterror('Delete Error' ,'The post was deleted from the topic but there were some errors in updating the users post count. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.');

              return false;

              } */
        }

        //Free the resources
        mysql_free_result($qresult);
    }


    //If we have reached here it means he can delete it now
    //////////////////////////////////
    // There are two possiblities:
    // 1) Actual Delete
    // 2) Recycle Bin Delete
    //////////////////////////////////
    //Recycle Bin Delete
    if ($globals['recyclebin'] && $board['fid'] != $globals['recyclebin']) {

        ///////////////////////////////////
        // Finally lets start the queries
        // Effects of recycling a topic :
        // 1 - Update the topics table
        // 2 - Update the posts table
        // 3 - Update the attachments
        // 4 - Update polls,options and voters
        // 5 - Update forums topic, post count
        //     a)From where it is going
        //     b)Where it is going
        ///////////////////////////////////
        /////////////////////
        // UPDATE the topics
        /////////////////////

        $qresult = makequery("UPDATE " . $dbtables['topics'] . "
                        SET t_bid = '" . $globals['recyclebin'] . "',
                        t_status = '0',
                        type_image = '0',
                        t_sticky = '0'
                        WHERE tid IN ($tids_str)", false);

        //How many were deleted ?
        $updated = mysql_affected_rows($conn);

        if ($updated != count($topics)) {

            reporterror('Delete Error', 'There were some errors in recycling the topics(s). Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.');

            return false;
        }

        //Free the resources
        mysql_free_result($qresult);



        ///////////////////
        // UPDATE the post
        ///////////////////

        $qresult = makequery("UPDATE " . $dbtables['posts'] . "
                        SET post_fid = '" . $globals['recyclebin'] . "'
                        WHERE post_tid IN ($tids_str)", false);

        //How many were deleted ?
        $updated_p = mysql_affected_rows($conn);

        if ($updated_p != count($pids)) {

            reporterror('Delete Error', 'There were some errors in recycling the post(s) of the topic(s). Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.');

            return false;
        }

        //Free the resources
        mysql_free_result($qresult);


        //////////////////////////
        // UPDATE the attachments
        //////////////////////////
        //Get out the attachments
        if (!empty($attach_pids)) {

            $at_pids_str = implode(', ', $attach_pids);

            //Bring the atids out
            $qresult = makequery("UPDATE " . $dbtables['attachments'] . "
                    SET at_fid = '" . $globals['recyclebin'] . "'
                    WHERE at_pid IN ($at_pids_str)", false);

            if (mysql_affected_rows($conn) < 1) {

                //A mechanism to report error
            }
        }


        ////////////////////////////////////////
        // UPDATE the polls, options and voters
        ////////////////////////////////////////
        //No need to do so as the polls are dependent on the topics
        //////////////////////////////////////
        // UPDATE the forums topic, post count
        //  a)From where it is going
        //////////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                        SET ntopic = ntopic - " . $updated . ",
                        nposts = nposts - " . $updated_p . "
                        WHERE fid = '" . $board['fid'] . "'", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror('Delete Error', 'The topic(s) were recycled but there were some errors in updating the forum. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.');

            return false;
        }

        //Free the resources
        mysql_free_result($qresult);


        ///////////////////////////////////
        // Update forums topic, post count
        //  b)Where it is going
        ///////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                        SET ntopic = ntopic + " . $updated . ",
                        nposts = nposts + " . $updated_p . "
                        WHERE fid = '" . $globals['recyclebin'] . "'", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror('Delete Error', 'The topic(s) were recycled but there were some errors in updating the recycle bin forum. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.');

            return false;
        }

        //Free the resources
        mysql_free_result($qresult);


        //Actual Delete and also to delete from recycle bin
    } else {

        ///////////////////////////////////
        // Finally lets start the queries
        // 1 - Delete from topics table
        // 2 - Delete from posts table
        // 3 - Delete attachments
        // 4 - Delete polls,options and voters
        // 5 - Delete from notify_topic table
        // 6 - Delete from read_topics table
        // 7 - Update forums topic, post count
        ///////////////////////////////////
        /////////////////////
        // DELETE the topics
        /////////////////////

        $qresult = makequery("DELETE FROM " . $dbtables['topics'] . "
                        WHERE tid IN ($tids_str)", false);

        //How many were deleted ?
        $deleted = mysql_affected_rows($conn);

        if ($deleted != count($topics)) {

            reporterror('Delete Error', 'There were some errors in deleting the topics(s). Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.');

            return false;
        }

        //Free the resources
        mysql_free_result($qresult);




        ///////////////////
        // DELETE the post
        ///////////////////

        $qresult = makequery("DELETE FROM " . $dbtables['posts'] . "
                        WHERE post_tid IN ($tids_str)", false);

        //How many were deleted ?
        $deleted_p = mysql_affected_rows($conn);

        if ($deleted_p != count($pids)) {

            reporterror('Delete Error', 'There were some errors in deleting the post(s). Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.');

            return false;
        }

        //Free the resources
        mysql_free_result($qresult);


        //////////////////////////
        // DELETE the attachments
        //////////////////////////
        //Get out the attachments
        if (!empty($attach_pids)) {

            $at_pids_str = implode(', ', $attach_pids);

            //Bring the atids out
            $qresult = makequery("SELECT atid, at_file
                    FROM " . $dbtables['attachments'] . "
                    WHERE at_pid IN ($at_pids_str)
                    ORDER BY at_pid ASC");

            //Loop through the table
            for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

                $row = mysql_fetch_assoc($qresult);

                $attachments[$row['atid']] = $row;
            }

            if (!delete_attach($attachments)) {

                //Reporting system still to come
            }
        }


        ////////////////////////////////////////
        // DELETE the polls, options and voters
        ////////////////////////////////////////
        //Get out the attachments
        if (!empty($poll_tids)) {

            $po_tids_str = implode(', ', $poll_tids);

            //Bring the poids out
            $qresult = makequery("SELECT poid
                    FROM " . $dbtables['polls'] . "
                    WHERE poll_tid IN ($po_tids_str)
                    ORDER BY poid ASC");

            //Loop through the table
            for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

                $row = mysql_fetch_assoc($qresult);

                $polls[$row['poid']] = $row;
            }

            if (!delete_poll($polls)) {

                //Reporting system still to come
            }
        }


        ////////////////////////////
        // DELETE the notifications
        ////////////////////////////

        $qresult = makequery("DELETE FROM " . $dbtables['notify_topic'] . "
                        WHERE notify_tid IN ($tids_str)", false);


        ////////////////////////////
        // DELETE from read_topics
        ////////////////////////////

        $qresult = makequery("DELETE FROM " . $dbtables['read_topics'] . "
                        WHERE rt_tid IN ($tids_str)", false);


        ///////////////////////////////////////
        // UPDATE the forums topic, post count
        ///////////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                        SET ntopic = ntopic - " . $deleted . ",
                        nposts = nposts - " . $deleted_p . "
                        WHERE fid = '" . $board['fid'] . "'", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror('Delete Error', 'The topic(s) were deleted but there were some errors in updating the forum. Please Contact the <a href="mailto:' . $globals['board_email'] . '">Administrator</a>.');

            return false;
        }

        //Free the resources
        mysql_free_result($qresult);
    }


    //Looks like everything went well
    //Redirect
    redirect('fid=' . $fid); //IE 7 #redirect not working

    return true;
}

//////////////////////////////////////////
// Deletes all attachments that are given
//////////////////////////////////////////

function delete_attach($attachments) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $delete_error = array();

    $atids = array();

    foreach ($attachments as $k => $v) {

        $atids[] = $v['atid'];
    }

    if (empty($atids)) {

        return false;
    }

    $atids_str = implode(', ', $atids);

    /////////////////////////
    // DELETE the attachment
    /////////////////////////

    $qresult = makequery("DELETE FROM " . $dbtables['attachments'] . "
                    WHERE atid IN ($atids_str)", false);



    if (mysql_affected_rows($conn) < 1) {

        //A mechanism to report error
        $delete_error[] = true;
    }


    //Now lets perform the task of moving and saving in DB
    foreach ($attachments as $k => $v) {

        //Finally lets delete the File
        if (!(@unlink($globals['attachmentdir'] . '/' . $v['at_file']))) {

            //A mechanism to report error
            $delete_error[] = true;
        }
    }

    if (empty($delete_error)) {

        return true;
    } else {

        return false;
    }
}

//////////////////////////////////////////
// Deletes all polls , options and voters
//////////////////////////////////////////

function delete_poll($polls) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $delete_error = array();

    $poids = array();

    foreach ($polls as $k => $v) {

        $poids[] = $v['poid'];
    }

    if (empty($poids)) {

        return false;
    }

    $poids_str = implode(', ', $poids);

    ////////////////////
    // DELETE the polls
    ////////////////////

    $qresult = makequery("DELETE FROM " . $dbtables['polls'] . "
                    WHERE poid IN ($poids_str)", false);



    if (mysql_affected_rows($conn) < 1) {

        //A mechanism to report error
        $delete_error[] = true;
    }


    //////////////////////
    // DELETE the options
    //////////////////////

    $qresult = makequery("DELETE FROM " . $dbtables['poll_options'] . "
                    WHERE poo_poid IN ($poids_str)", false);



    if (mysql_affected_rows($conn) < 1) {

        //A mechanism to report error
        $delete_error[] = true;
    }


    //////////////////////
    // DELETE the voters
    //////////////////////

    $qresult = makequery("DELETE FROM " . $dbtables['poll_voters'] . "
                    WHERE pv_poid IN ($poids_str)", false);



    if (mysql_affected_rows($conn) < 1) {

        //A mechanism to report error
        $delete_error[] = true;
    }


    if (empty($delete_error)) {

        return true;
    } else {

        return false;
    }
}

?>
