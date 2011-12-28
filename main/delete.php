<?php

//////////////////////////////////////////////////////////////
//===========================================================
// delete.php
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

//Deletes Posts
function delete() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $fid, $postcodefield, $error, $smileys, $emoticons, $popup_emoticons, $tid, $board, $post_title, $post, $i_started, $attachments;

    //Load the Language File
    if (!load_lang('delete')) {

        return false;
    }

    /* //The name of the file
      $theme['init_theme'] = 'delete';

      //The name of the Page
      $theme['init_theme_name'] = 'Delete Post';

      //Array of functions to initialize
      $theme['init_theme_func'] = array('delete_theme'); */

    //My activity
    $globals['last_activity'] = 'dr';


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////
    //Post VARS
    $modtime = time();

    $modifiers_id = ($logged_in ? $user['id'] : -1);

    $post = '';

    $use_smileys = 0;

    $gposter_name = '';

    $gposter_email = '';

    $post_title = '';

    $num_attachments = 0;

    //A error handler ARRAY
    $error = array();

    //If a new topic is created
    $topic = '';

    $t_status = 0;

    $type_image = 0;

    $t_mem_id = ($logged_in ? $user['id'] : '-1');

    //Other VARS
    $announcetopic = 0;

    $invalid = array(); //Some invalid pid

    $get_pids = '';

    $pids_str = ''; //Clean string of ids

    $pids = array();

    $posts = array();

    $posters = array(); //Users who posted and not guests

    $deleted = 0;


    if (isset($_GET['pid']) && trim($_GET['pid']) !== "") {

        $get_pids = inputsec(htmlizer(trim($_GET['pid'])));

        $pids = explode(',', $get_pids);
    } else {

        //Show a major error and return
        reporterror($l['no_post_specified_title'], $l['no_post_specified']);

        return false;
    }


    //Clean the pids
    foreach ($pids as $k => $v) {

        //Make it integer
        $pids[$k] = (int) trim($v);

        //Check if it is valid
        if (empty($pids[$k])) {

            $invalid[] = $pids[$k];
        }
    }


    //Did we get some invalid ones
    if (!empty($invalid)) {

        //Show a major error and return
        reporterror($l['invalid_post_title'], lang_vars($l['invalid_post'], array(implode(', ', $invalid))));

        return false;
    }

    //Make them unique also
    $pids = array_unique($pids);

    array_multisort($pids);

    $pids_str = implode(', ', $pids);


    //Bring the post out
    $qresult = makequery("SELECT t.*, p.*
            FROM " . $dbtables['posts'] . " p
            LEFT JOIN " . $dbtables['topics'] . " t ON (t.tid = p.post_tid)
            WHERE p.pid IN ($pids_str)");

    if (mysql_num_rows($qresult) < 1) {

        //Show a major error and return
        reporterror($l['no_post_found_title'], $l['no_post_found']);

        return false;

        //Are the number of posts less than the pids
    } elseif (mysql_num_rows($qresult) != count($pids)) {

        //Show a major error and return
        reporterror($l['some_post_not_found_title'], $l['some_post_not_found']);

        return false;
    }

    for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

        $row = mysql_fetch_assoc($qresult);

        $posts[$row['pid']] = $row;

        $fid = $row['post_fid'];

        $tid = $row['post_tid'];

        $tids[] = $row['post_tid'];

        //The users who posted and no guests
        if ($row['poster_id'] != -1) {

            if (empty($posters[$row['poster_id']])) {

                $posters[$row['poster_id']]['id'] = $row['poster_id'];

                $posters[$row['poster_id']]['count'] = 1;
            } else {

                $posters[$row['poster_id']]['count'] = $posters[$row['poster_id']]['count'] + 1;
            }
        }

        //Does any post has an attachment
        if ($row['num_attachments']) {

            $num_attachments = $num_attachments + $row['num_attachments'];
        }

        //What should the new topic be if it is recycled
        $topic = $row['topic'];


        //Now we check for spam
        if (isset($_GET['type'])) {
            if ($_GET['type'] == "spam") {
                //It's spam.
                //Get akismet
                $akismet = akismetclass();

                if ($row['poster_id'] != -1) { //Only use Akismet for members :S
                    //TODO Akismet here for guests too
                    $uresult = makequery("SELECT u.*
                                            FROM " . $dbtables['users'] . " u
                                            WHERE u.id = " . $row['poster_id']);

                    if (mysql_num_rows($uresult) == 1) {

                        $_user = mysql_fetch_assoc($qresult);

                        $akismet->setCommentAuthor($_user['username']);

                        $akismet->setUserIP($_user['r_ip']);

                        $akismet->setCommentAuthorEmail($_user['email']);

                        $akismet->setCommentAuthorURL($_user['www']);

                        $akismet->setCommentType("post");

                        $akismet->setCommentContent($row['post']);
                        
                        $akismet->submitSpam();
                    }
                }
            }
        }
    }


    //Free the resources
    mysql_free_result($qresult);


    //Check are they of the same topic or no
    if (count(array_unique($tids)) > 1) {

        //Show a major error and return
        reporterror($l['not_same_topic_title'], $l['not_same_topic']);

        return false;
    }


    ////////////////////////////////
    // Now we got to check whether
    // this is the first post
    ////////////////////////////////

    $qresult = makequery("SELECT pid FROM " . $dbtables['posts'] . "
                    WHERE post_tid = '$tid'
                    ORDER BY pid ASC
                    LIMIT 0, 1");

    if (mysql_num_rows($qresult) < 1) {

        reporterror($l['delete_error_title'], $l['delete_error']);

        return false;
    }

    $row = mysql_fetch_assoc($qresult);

    $firstpid = $row['pid'];


    //Free the resources
    mysql_free_result($qresult);


    //Oh boy you cant delete the first post
    if (in_array($firstpid, $pids)) {

        reporterror($l['first_topic_post_title'], $l['first_topic_post']);

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

    //The topic the user is Reading Currently
    $globals['viewing_topic'] = $tid;


    foreach ($posts as $pk => $pv) {

        //Who started this post?
        if ($logged_in) {

            if ($posts[$pk]['poster_id'] == $user['id']) {

                $i_started = true;
            } else {

                $i_started = false;
            }
        } else {

            $i_started = false;
        }


        //Can he DELETE the post
        if (!(($i_started && $user['can_del_own_post']) ||
                (!$i_started && $user['can_del_other_post']))) {

            //Show a major error and return
            reporterror($l['no_delete_permission_title'], $l['no_delete_permission']);

            return false;
        }

        unset($i_started);
    }

    //return false;
    //If we have reached here it means he can delete it now
    //////////////////////////////////
    // There are two possiblities:
    // 1) Actual Delete
    // 2) Recycle Bin Delete
    //////////////////////////////////
    //Recycle Bin Delete
    if ($globals['recyclebin'] && $board['fid'] != $globals['recyclebin']) {

        /////////////////////////////////
        // Finally lets start the queries
        // Effects of recycling a post :
        // 1 - CREATE a new topic
        // 2 - UPDATE from posts table
        // 3 - Update topics table for
        //       last_post_id and -n post
        // 4 - Update users post count
        // 5 - Update forums post count
        //     a)From where it is going
        //     b)Where it is going(topic also)
        // 6 - Update attachments
        /////////////////////////////////
        ////////////////////
        // INSERT the topic
        ////////////////////

        $qresult = makequery("INSERT INTO " . $dbtables['topics'] . "
                        SET topic = '$topic',
                        t_bid = '" . $globals['recyclebin'] . "',
                        t_status = '$t_status',
                        n_posts = '" . (count($posts) - 1) . "',
                        type_image = '$type_image',
                        t_mem_id = '$t_mem_id',
                        first_post_id = '" . $pids[0] . "',
                        last_post_id = '" . $pids[count($pids) - 1] . "',
                        mem_id_last_post = '" . $posts[$pids[count($pids) - 1]]['poster_id'] . "',
                        has_attach = '" . $num_attachments . "'");

        $ntid = mysql_insert_id($conn);

        if (empty($ntid)) {

            reporterror($l['recyclebin_error_title'], $l['recyclebin_error']);

            return false;
        }

        ////////////////////
        // UPDATE the posts
        ////////////////////

        $qresult = makequery("UPDATE " . $dbtables['posts'] . "
                        SET post_tid = '" . $ntid . "',
                        post_fid = '" . $globals['recyclebin'] . "'
                        WHERE pid IN ($pids_str)", false);

        //How many were deleted(recycled) ?
        $deleted = $deleted + mysql_affected_rows($conn);

        //Were things deleted
        if ($deleted != count($posts)) {

            reporterror($l['recyclebin_error_title'], $l['recyclebin_error']);

            return false;
        }

        //GET the Last Pid
        $lastpost = last_post_topic($tid);

        ////////////////////////////////////////////
        // UPDATE the topics table for last_post_id
        // and -n(n number of posts) post
        ////////////////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['topics'] . "
                        SET n_posts = n_posts - " . $deleted . ",
                        has_attach = has_attach - " . $num_attachments . ",
                        last_post_id = " . $lastpost['pid'] . ",
                        mem_id_last_post = " . $lastpost['poster_id'] . "
                        WHERE tid = '$tid'", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['update_topic_error_title'], $l['update_topic_error']);

            return false;
        }

        //Free the resources
        mysql_free_result($qresult);



        ///////////////////////////////
        // UPDATE the users post count
        ///////////////////////////////
        //Not for guests and should we increase
        if ($board['inc_mem_posts']) {

            //Loop through the posters as there may be many
            foreach ($posters as $po => $pov) {

                $qresult = makequery("UPDATE " . $dbtables['users'] . "
                                SET posts = posts - " . $pov['count'] . "
                                WHERE id = '" . $pov['id'] . "'", false);

                if (mysql_affected_rows($conn) < 1) {

                    reporterror($l['update_users_error_title'], $l['update_users_error']);

                    return false;
                }
            }
        }


        //GET the Last Pid from where its going
        $lastpost = last_post_forum($board['fid']);

        ////////////////////////////////
        // UPDATE the forums post count
        //  a)From where it is going
        ////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                        SET nposts = nposts - " . $deleted . ",
                        f_last_pid = " . $lastpost['pid'] . "
                        WHERE fid = '" . $board['fid'] . "'", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['update_forum_error_title'], $l['update_forum_error']);

            return false;
        }

        //GET the Last Pid TO where its going
        $lastpost = last_post_forum($globals['recyclebin']);

        ////////////////////////////////
        // UPDATE the forums post count
        //  b)Where it is going(topic also)
        ////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                        SET nposts = nposts + " . $deleted . ",
                        ntopic = ntopic + 1,
                        f_last_pid = " . $lastpost['pid'] . "
                        WHERE fid = '" . $globals['recyclebin'] . "'", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['update_recyclebin_error_title'], $l['update_recyclebin_error']);

            return false;
        }

        //////////////////////
        // Update attachments
        //////////////////////

        if (!empty($num_attachments)) {

            $qresult = makequery("UPDATE " . $dbtables['attachments'] . "
                        SET at_fid = '" . $globals['recyclebin'] . "'
                        WHERE at_pid IN ($pids_str)", false);
        }


        //Actual Delete and also to delete from recycle bin
    } else {

        /////////////////////////////////
        // Finally lets start the queries
        // Effects of deleting a post :
        // 1 - Delete from posts table
        // 2 - Update topics table for
        //       last_post_id and -n post
        // 3 - Update users post count
        // 4 - Update forums post count
        // 5 - Remove Attachments
        /////////////////////////////////
        ///////////////////
        // DELETE the post
        ///////////////////

        $qresult = makequery("DELETE FROM " . $dbtables['posts'] . "
                        WHERE pid IN ($pids_str)", false);

        //How many were deleted ?
        $deleted = mysql_affected_rows($conn);

        if ($deleted != count($posts)) {

            reporterror($l['delete_error_title'], $l['delete_error']);

            return false;
        }

        //GET the Last Pid
        $lastpost = last_post_topic($tid);

        ////////////////////////////////////////////
        // UPDATE the topics table for last_post_id
        // and -n(n number of posts) post
        ////////////////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['topics'] . "
                        SET n_posts = n_posts - " . $deleted . ",
                        last_post_id = " . $lastpost['pid'] . ",
                        mem_id_last_post = " . $lastpost['poster_id'] . "
                        WHERE tid = '$tid'", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['update_topic_error_title'], $l['update_topic_error']);

            return false;
        }

        ///////////////////////////////
        // UPDATE the users post count
        ///////////////////////////////
        //Not for guests and should we increase
        if ($board['inc_mem_posts']) {

            //Looop through the posters as there may be many
            foreach ($posters as $po => $pov) {

                $qresult = makequery("UPDATE " . $dbtables['users'] . "
                                SET posts = posts - " . $pov['count'] . "
                                WHERE id = '" . $pov['id'] . "'", false);

                if (mysql_affected_rows($conn) < 1) {

                    reporterror($l['update_users_error_title'], $l['update_users_error']);

                    return false;
                }

            }
        }

        //GET the Last Pid from where its going
        $lastpost = last_post_forum($board['fid']);

        ////////////////////////////////
        // UPDATE the forums post count
        ////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                        SET nposts = nposts - " . $deleted . ",
                        f_last_pid = " . $lastpost['pid'] . "
                        WHERE fid = '" . $board['fid'] . "'", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['update_forum_error_title'], $l['update_forum_error']);

            return false;
        }

        //////////////////////
        // Remove Attachments
        //////////////////////

        if (!empty($num_attachments)) {

            //Get the attachments
            $qresult = makequery("SELECT at.*, mt.atmt_icon, mt.atmt_isimage
                    FROM " . $dbtables['attachments'] . " at
                    LEFT JOIN " . $dbtables['attachment_mimetypes'] . " mt ON (at.at_mimetype_id = mt.atmtid)
                    WHERE at.at_pid IN ($pids_str)
                    ORDER BY at_pid ASC");

            //There may be no such attachments
            //Are there any attachments
            if (mysql_num_rows($qresult) > 0) {

                $atids = array();

                $all_at = array();

                for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

                    $row = mysql_fetch_assoc($qresult);

                    $at_size = substr(($row['at_size'] / 1024), 0, 5);

                    $atids[] = $row['atid'];

                    $all_at[$row['atid']] = $row;
                }

                //5th param is false as the post has already been deleted
                //3rd param of $pid is dummy and will not affect
                if (!dettach($board['fid'], $tid, 0, $all_at, false)) {

                    return false;
                }
            }
        }
    }


    //Looks like everything went well
    //Redirect
    redirect('tid=' . $tid); //IE 7 #redirect not working

    return true;
}

?>
