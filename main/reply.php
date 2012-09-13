<?php

//////////////////////////////////////////////////////////////
//===========================================================
// reply.php
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

function reply() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $fid, $postcodefield, $error, $smileys, $emoticons, $popup_emoticons, $tid, $board, $title, $topic, $i_started, $tree, $quotetxt, $qpid, $last_posts, $preview;

    //Load the Language File
    if (!load_lang('reply')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'reply';

    //The name of the Page
    $theme['init_theme_name'] = 'Reply';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('reply_theme');

    //My activity
    $globals['last_activity'] = 'nr';


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////
    //Topic VARS
    $tid = 0;

    $topic = '';

    $t_description = '';

    $fid = 0; //t_bid

    $t_status = 1;

    $type_image = 0; //0 for nothing

    $t_mem_id = ($logged_in ? $user['id'] : -1);

    $poll_id = 0;

    $t_sticky = 0;

    $first_post_id = 0;

    $last_post_id = 0;

    $mem_id_last_post = ($logged_in ? $user['id'] : -1);

    $has_attach = 0;

    //Post VARS
    $post_tid = 0;

    //$p_top_sticky = 0;Not required anymore

    $ptime = time();

    $poster_ip = $_SERVER['REMOTE_ADDR']; //IP Address of Poster

    $post = '';

    $use_smileys = 0;

    $gposter_name = '';

    $gposter_email = '';

    $post_title = '';

    $num_attachments = 0;

    $par_id = 0;

    //Forum Vars
    $f_last_pid = 0;

    //A error handler ARRAY
    $error = array();

    //Other VARS
    $notifytopic = 0;

    $use_smileys = 0;

    $t_sticky = 0;

    $announcetopic = 0;

    $postpoll = 0;

    $quotetxt = '';

    $last_posts = array();

    $tree = array(); //Board tree for users location
    $tree[] = array('l' => $globals['index_url'],
        'txt' => $l['index']);


    if (isset($_GET['topid']) && trim($_GET['topid']) !== "" && is_numeric(trim($_GET['topid']))) {

        $tid = (int) inputsec(htmlizer(trim($_GET['topid'])));
    } else {

        //Show a major error and return
        reporterror($l['no_topic_specified_title'], $l['no_topic_specified']);

        return false;
    }

    //Bring the topic
    $qresult = makequery("SELECT t.*
            FROM " . $dbtables['topics'] . " t
            WHERE t.tid='$tid'
            LIMIT 0 , 1");

    if (mysql_num_rows($qresult) < 1) {

        //Show a major error and return
        reporterror($l['no_topic_found_title'], $l['no_topic_found']);

        return false;
    }

    $topic = mysql_fetch_assoc($qresult);

    //Free the resources
    @mysql_free_result($qresult);

    $title = $topic['topic'];

    $fid = $topic['t_bid'];

    $t_sticky = $topic['t_sticky'];

    $t_status = $topic['t_status'];

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


    //Is the board locked
    if (!($board['status'] != 0 || ($board['status'] == 0 && $user['has_priviliges']))) {

        //Show a major error and return
        reporterror($l['forum_locked_title'], $l['forum_locked']);

        return false;
    }


    //Is the topic locked
    if (!($topic['t_status'] != 0 || ($topic['t_status'] == 0 && $user['has_priviliges']))) {

        //Show a major error and return
        reporterror($l['topic_locked_title'], $l['topic_locked']);

        return false;
    }


    //Is the topic a moved topics link(then that means a locked one)
    if (!($topic['t_status'] != 2 || ($topic['t_status'] == 2 && $user['has_priviliges']))) {

        //Show a major error and return
        reporterror($l['topic_locked_title'], $l['topic_locked']);

        return false;
    }


    //Who started this topic?
    if ($logged_in) {

        if ($topic['t_mem_id'] == $user['id']) {

            $i_started = true;
        } else {

            $i_started = false;
        }
    } else {

        $i_started = false;
    }


    //If he has the permissions to post
    if (!($user['can_reply'] || $board['can_reply'])) {

        //Show a major error and return
        reporterror($l['no_reply_permissions_title'], $l['no_reply_permissions']);

        return false;
    }


    if (isset($_GET['pid']) && trim($_GET['pid']) !== "" && is_numeric(trim($_GET['pid']))) {

        $qpid = (int) inputsec(htmlizer(trim($_GET['pid'])));

        if (!empty($qpid)) {

            $qresult = makequery("SELECT p.post, p.ptime, u.username
            FROM " . $dbtables['posts'] . " p
            LEFT JOIN " . $dbtables['users'] . " u ON (u.id = p.poster_id)
            WHERE p.pid = '$qpid'
            LIMIT 0 , 1");

            if (mysql_num_rows($qresult) > 0) {

                $quoted = mysql_fetch_assoc($qresult);

                $quotetxt = '[quote poster=' . $quoted['username'] . ' date=' . $quoted['ptime'] . ']' . $quoted['post'] . '[/quote]';
            }
        }
    }


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


    //Add the topic also
    $tree[] = array('l' => $globals['index_url'] . 'tid=' . $tid,
        'txt' => $topic['topic'],
        'prefix' => $l['replying_in']);

    //The forums theme
    forum_theme();

    //Show the last posts
    if (!empty($globals['last_posts_reply'])) {

        //Bring the last posts
        $qresult = makequery("SELECT DISTINCT p.*, per.allow_html, u.id, u.username
                FROM " . $dbtables['posts'] . " p
                LEFT JOIN " . $dbtables['users'] . " u ON (u.id = p.poster_id)
                LEFT JOIN " . $dbtables['permissions'] . " per ON (per.member_group_id =
                                                                u.u_member_group)
                WHERE p.post_tid = '$tid'
                ORDER BY ptime DESC
                LIMIT 0, " . $globals['last_posts_reply']);

        if (mysql_num_rows($qresult) < 1) {

            //Show a major error and return
            reporterror($l['no_last_posts_title'], $l['no_last_posts']);

            return false;
        }

        $post_count = $topic['n_posts'];

        //Get the posts
        for ($p = 0; $p < mysql_num_rows($qresult); $p++) {

            $row = mysql_fetch_assoc($qresult);

            $row['post_count'] = $post_count;

            $post_count--;

            //Format the text
            $row['post'] = format_text($row['post']);

            //Links and all
            $row['post'] = parse_special_bbc($row['post'], $row['allow_html']);

            //Add the brakes
            $row['post'] = parse_br($row['post']);

            // Smileys are so cheerfull
            if ($globals['usesmileys'] && showsmileys()) {

                if ($row['use_smileys']) {

                    $row['post'] = smileyfy($row['post']);
                }
            }

            //The date
            $row['pdate'] = datify($row['ptime']);

            $last_posts[$row['pid']] = $row;
        }
    }

    ///////////////////////////////////////
    // Create a 16 bit random code for POST
    // DATA REFRESH Problem to be solved.
    ///////////////////////////////////////

    if (empty($AEF_SESS['postcode']) || !is_array($AEF_SESS['postcode'])) {

        $AEF_SESS['postcode'] = array();
    }

    $postcodefield = '<input type="hidden" value="' . generateRandStr(16) . '" name="postcode" />';

    //Are we to use smileys ?
    if ($globals['usesmileys']) {

        if (!getsmileys()) {

            return false;
        }
    }

    //If the user is submitting the post
    if (isset($_POST['submitpost']) || isset($_POST['previewpost'])) {

        //Is postcode posted
        if (!(isset($_POST['postcode'])) || strlen(trim($_POST['postcode'])) < 16) {

            $error[] = $l['no_security_code'];
        } else {

            $postedcode = inputsec(strtolower(htmlizer(trim($_POST['postcode']))));

            //////////////////////////////////
            // This is a very important thing
            // to check for automated posting
            //////////////////////////////////

            if (in_array($postedcode, $AEF_SESS['postcode'])) {

                $error[] = $l['wrong_security_code'];
            }
        }

        //When was the last time you posted
        if (!empty($AEF_SESS['last_post'])) {

            if ((time() - $AEF_SESS['last_post']) < $globals['timepostfromuser']) {

                $error[] = $l['last_post_time'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'reply_theme';
            return false;
        }

        //For Guests their names and email is important
        if (!$logged_in) {

            //The name field
            if (!(isset($_POST['gposter_name'])) || strlen(trim($_POST['gposter_name'])) < 1) {

                $error[] = $l['guest_no_name'];
            } else {

                $gposter_name = inputsec(htmlizer(trim($_POST['gposter_name'])));

                $len = aefstrlen($gposter_name);

                //Max Length
                if ($len > $globals['max_uname']) {

                    $error[] = lang_vars($l['max_name_length_crossed'], array($globals['max_uname']));
                }

                //Min Length
                if ($len < $globals['min_uname']) {

                    $error[] = lang_vars($l['min_name_length_crossed'], array($globals['min_uname']));
                }

                if (preg_match("/\s/i", $gposter_name)) {

                    $error[] = $l['space_in_name'];
                }

                //on error call the form
                if (!empty($error)) {
                    $theme['call_theme_func'] = 'reply_theme';
                    return false;
                }

                //Check in the Database
                if (usernameindb($gposter_name)) {

                    $error[] = lang_vars($l['name_in_use'], array($gposter_name));
                }


                $reserved = explode("\n", $globals['reserved_names']);

                for ($i = 0; $i < count($reserved); $i++) {

                    if (!empty($reserved[$i])) {

                        $reserved[$i] = trim($reserved[$i]);

                        $pattern = '/' . (($globals['reserved_match_whole']) ? '\b' : '') . $reserved[$i] . (($globals['reserved_match_whole']) ? '\b' : '') . '/' . (($globals['reserved_match_insensitive']) ? 'i' : '');

                        if (preg_match($pattern, $gposter_name)) {

                            $error[] = lang_vars($l['reserved_names'], array($reserved[$i]));

                            break;
                        }
                    }
                }
            }

            //on error call the form
            if (!empty($error)) {
                $theme['call_theme_func'] = 'reply_theme';
                return false;
            }


            //The email address
            if (!(isset($_POST['gposter_email'])) || strlen(trim($_POST['gposter_email'])) < 1) {

                $error[] = $l['guest_no_email'];
            } else {

                $gposter_email = inputsec(htmlizer(trim($_POST['gposter_email'])));

                //////////////////////////////////
                // Email must undergo following
                // restriction checks
                // 1 - Max Length(for DB)
                // 2 - Email In Data Base
                // 3 - Email Expression
                //////////////////////////////////
                //Max Length
                if (aefstrlen($gposter_email) > 100) {

                    $error[] = $l['guest_email_big'];
                }

                //Also confirm its validity
                if (!emailvalidation($gposter_email)) {

                    $error[] = $l['guest_email_invalid'];
                }

                //Check is it there in the Data Base
                if (emailindb($gposter_email)) {

                    $error[] = $l['email_in_use'];
                }
            }

            //on error call the form
            if (!empty($error)) {
                $theme['call_theme_func'] = 'reply_theme';
                return false;
            }
        }


        //Check if the damn field Title exists.
        if (!(isset($_POST['posttitle'])) || strlen(trim($_POST['posttitle'])) < 1) {

            $post_title = $topic['topic'];
        } else {

            $post_title = inputsec(htmlizer(trim($_POST['posttitle'])));

            $post_title = checktitle($post_title);
        }

        //check the post itself
        if (!(isset($_POST['post'])) || trim($_POST['post']) == "") {

            $error[] = $l['empty_post'];
        } else {

            //We are not trimming for smileys
            $post = inputsec(htmlizer($_POST['post']));

            $post = checkpost($post);
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'reply_theme';
            return false;
        }


        /* Checking the Options of the Posted Topic. */

        //Check the smileys
        if (isset($_POST['usesmileys'])) {

            $use_smileys = 1;
        }


        //Is the topic to be made sticky
        if (isset($_POST['makesticky'])) {

            if ($user['can_make_sticky']) {

                $t_sticky = 1;
            }
        }


        //Is the topic to be LOCKED ?
        if (isset($_POST['locktopic'])) {

            if (($i_started && $user['can_lock_own_topic']) ||
                    (!$i_started && $user['can_lock_other_topic'])) {

                $t_status = 0;
            }
        }


        //Announcing is tough
        if (isset($_POST['announcetopic'])) {

            if ($user['can_announce_topic']) {

                $announcetopic = 1;
            }
        }


        // Notify/Subscribe the poster ?
        if ($logged_in && isset($_POST['notifytopic']) && $globals['notifications']) {

            if ($user['notify_new_posts']) {

                $notifytopic = 1;
            }
        }


        // Post a poll ?
        if (isset($_POST['addpoll']) && $globals['enablepolls'] && $board['allow_poll'] &&
                empty($topic['poll_id'])) {

            if (($i_started && $user['add_poll_topic_own']) ||
                    (!$i_started && $user['add_poll_topic_other'])) {

                $postpoll = 1;
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'reply_theme';
            return false;
        }

        /* Ending - Checking the Options of the Posted Topic. */


        //Is there a parent defined
        if (isset($_GET['par_id'])) {

            $par_id = (int) inputsec(htmlizer(trim($_GET['par_id'])));
        }


        //Is the user asking for a preview
        if (isset($_POST['previewpost'])) {

            //Are sigs to be shown
            $showsigs = ($logged_in ? ( $user['showsigs'] == 1 ? true : ($user['showsigs'] == 2 ? false : $globals['attachsigtopost']) ) : $globals['attachsigtopost']);

            $showavatars = ($logged_in ? ( $user['showavatars'] == 1 ? true : ($user['showavatars'] == 2 ? false : $globals['showavatars']) ) : $globals['showavatars']);

            $showsmileys = showsmileys();

            $preview['title'] = $post_title;

            if (!$logged_in) {

                $preview['username'] = $gposter_name;

                $preview['gposter_email'] = $gposter_email;

                //Logged in
            } else {

                $preview['username'] = $user['username'];
            }

            //Is avatars allowed globally
            if (!empty($user['avatar']) && $globals['showavatars'] && $showavatars) {

                $avatar = array('avatar' => $user['avatar'],
                    'avatar_type' => $user['avatar_type'],
                    'avatar_width' => $user['avatar_width'],
                    'avatar_height' => $user['avatar_height']
                );

                $preview['avatarurl'] = urlifyavatar(100, $avatar);
            }

            //If user wants to see sig
            if ($globals['enablesig'] && $showsigs && !empty($user['sig'])) {

                $preview['sig'] = $user['sig'];

                $preview['sig'] = parse_special_bbc($preview['sig']);

                $preview['sig'] = format_text($preview['sig']);

                $preview['sig'] = parse_br($preview['sig']);

                //What about smileys in sigs
                if ($globals['usesmileys'] && $showsmileys) {

                    $preview['sig'] = smileyfy($preview['sig']);
                }
            }

            $preview['pdate'] = datify(time());

            $preview['post_count'] = $topic['n_posts'] + 1;

            $preview['post'] = stripslashes($post);

            //////////////////////////////////////////
            // BBC is quite a headache and puts a load
            //////////////////////////////////////////
            //Format the text
            $preview['post'] = format_text($preview['post']);

            //Links and all
            $preview['post'] = parse_special_bbc($preview['post'], $user['allow_html']);

            //Add the brakes
            $preview['post'] = parse_br($preview['post']);

            //Smileys are so cheerfull
            if ($globals['usesmileys'] && $showsmileys) {

                if ($use_smileys) {

                    $preview['post'] = smileyfy($preview['post']);
                }
            }

            //Return
            $theme['call_theme_func'] = 'reply_theme';
            return true;
        }


        /////////////////////////////////
        // Finally lets start the queries
        // Effects of a new topic :
        // 1 - Put in posts table
        // 2 - Update topics table for
        //       last_post_id
        // 3 - Update users post count
        // 4 - Update forums post count
        /////////////////////////////////
        ///////////////////////
        // INSERT the post now
        ///////////////////////

        $qresult = makequery("INSERT INTO " . $dbtables['posts'] . "
                        SET post_tid = '$tid',
                        post_fid = '$fid',
                        ptime = '$ptime',
                        poster_id = '$t_mem_id',
                        poster_ip = '$poster_ip',
                        post = '$post',
                        use_smileys = '$use_smileys',
                        gposter_name = '$gposter_name',
                        gposter_email = '$gposter_email',
                        post_title = '$post_title',
                        par_id = '$par_id'");

        $pid = mysql_insert_id($conn);

        if (empty($pid)) {

            reporterror($l['reply_error_title'], $l['reply_error']);

            return false;
        }

        //Free the resources
        @mysql_free_result($qresult);


        /////////////////////////////////////////////
        // UPDATE the topics table for last_post_id
        /////////////////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['topics'] . "
                        SET t_status = $t_status,
                        n_posts = n_posts + 1,
                        t_sticky = $t_sticky,
                        last_post_id = '$pid',
                        mem_id_last_post = '$mem_id_last_post'
                        WHERE tid = '$tid'", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['update_topic_error_title'], $l['update_topic_error']);

            return false;
        }

        //Free the resources
        @mysql_free_result($qresult);


        ///////////////////////////////
        // UPDATE the users post count
        ///////////////////////////////
        //Not for guests and should we increase
        if ($logged_in && $board['inc_mem_posts']) {

            $qresult = makequery("UPDATE " . $dbtables['users'] . "
                            SET posts = posts + 1
                            WHERE id = '" . $user['id'] . "'", false);

            if (mysql_affected_rows($conn) < 1) {

                reporterror($l['update_users_error_title'], $l['update_users_error']);

                return false;
            }

            //Free the resources
            @mysql_free_result($qresult);
        }


        ////////////////////////////////
        // UPDATE the forums post count
        ////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                        SET nposts = nposts + 1,
                        f_last_pid = '$pid'
                        WHERE fid = '" . $board['fid'] . "'", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['update_forum_error_title'], $l['update_forum_error']);

            return false;
        }

        //Free the resources
        @mysql_free_result($qresult);


        //Increase the stats for todays post count
        $globals['newpost'] = 1;


        ///////////////////////////////
        // Save the user read the topic
        ///////////////////////////////

        if (!read_topic($tid, time())) {

            return false;
        }

        ///////////////////////////////
        // Save the user read the forum
        ///////////////////////////////

        if (!read_forum($board['fid'], time())) {

            return false;
        }


        //Are we to notify
        if ($notifytopic) {

            //////////////////////////////////
            // REPLACE the users row if there
            //////////////////////////////////

            $qresult = makequery("REPLACE INTO " . $dbtables['notify_topic'] . "
                            SET notify_mid = '" . $user['id'] . "',
                            notify_tid = '$tid'");

            if (mysql_affected_rows($conn) < 1) {

                reporterror($l['subscription_error_title'], $l['subscription_error']);

                return false;
            }
        }


        //What about attachments ?
        if (!(empty($_FILES['attachments']['tmp_name']) &&
                empty($_FILES['attachments']['name']) &&
                empty($_FILES['attachments']['size']))) {

            //Are new attachments allowed ?s
            if (!$globals['allownewattachment']) {

                reporterror($l['attachments_not_allowed_title'], $l['attachments_not_allowed']);

                return false;
            } else {

                if (!attach($board['fid'], $tid, $pid)) {

                    return false;
                }
            }
        }


        //Calculate the topic page number.
        $n_posts = ($topic['n_posts'] + 2); //One for the new reply and other for first topic post

        $tpg = ($n_posts / $globals['maxpostsintopics']);

        $tpg = ceil($tpg);

        //Store that this code was successful
        $AEF_SESS['postcode'][] = $postedcode;

        //Store the last post time
        $AEF_SESS['last_post'] = time();

        if ($globals['notifications']) {

            //Send Notifications
            $qresult = makequery("SELECT u.email
                        FROM " . $dbtables['notify_topic'] . " nt
                        LEFT JOIN " . $dbtables['users'] . " u ON (u.id = nt.notify_mid)
                        WHERE notify_tid = '$tid'");

            //////////////////////////////////////
            // Note :  There may not even be a
            // single notification to send .
            //////////////////////////////////////
            //Found some recievers
            if (mysql_num_rows($qresult) > 0) {

                $notifyemails = array();

                for ($i = 0; $i < mysql_num_rows($qresult); $i++) {

                    $row = mysql_fetch_assoc($qresult);

                    //We dont have to send to the poster
                    if (!($row['email'] == ($logged_in ? $user['email'] : ''))) {

                        $notifyemails[] = $row['email'];
                    }
                }

                //Free the resources
                @mysql_free_result($qresult);

                $mail[0]['to'] = $globals['board_email'];
                $mail[0]['subject'] = lang_vars($l['new_reply_mail_subject'], array($title));
                $mail[0]['bcc'] = $notifyemails;
                $mail[0]['message'] = lang_vars($l['new_reply_mail'], array($title, ($logged_in ? $user['username'] : 'a Guest'),
                    $tid, $tpg, $pid));

                //Pass all Mails to the Mail sending function
                aefmail($mail);
            }
        }


        //Are we to post a poll?
        if ($postpoll) {

            $AEF_SESS['postpoll'] = $tid;

            $AEF_SESS['postpoll_t'] = $topic['topic'];

            //Redirect
            redirect('act=postpoll');
        } else {

            //Redirect
            redirect('tid=' . $tid . '&tpg=' . $tpg . '#p' . $pid); //IE 7 #redirect not working
        }


        return true;


        //The user is visiting this page for the first time so show the Form.
    } else {

        $theme['call_theme_func'] = 'reply_theme';
    }
}

