<?php

//////////////////////////////////////////////////////////////
//===========================================================
// newtopic.php
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
// 2 - Moved Link(Implies Locked)
///////////////////////////////////

/* Work to be done

  2) Announce a Topic

  Ending - Work to be done */


function newtopic() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $fid, $postcodefield, $error, $smileys, $emoticons, $popup_emoticons, $tid, $board, $tree, $preview;

    //Load the Language File
    if (!load_lang('newtopic')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'newtopic';

    //The name of the Page
    $theme['init_theme_name'] = 'New Topic';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('newtopic_theme');

    //My activity
    $globals['last_activity'] = 'nt';


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

    $mem_id_last_post = 0;

    $has_attach = 0;

    //Post VARS
    $post_tid = 0;

    //$p_top_sticky = 0;//Not required anymore

    $ptime = time();

    $poster_ip = $_SERVER['REMOTE_ADDR']; //IP Address of Poster

    $post = '';

    $use_smileys = 0;

    $gposter_name = '';

    $gposter_email = '';

    $post_title = '';

    $num_attachments = 0;

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

    $tree = array(); //Board tree for users location
    $tree[] = array('l' => $globals['index_url'],
        'txt' => $l['index']);


    if (isset($_GET['forum']) && trim($_GET['forum']) !== "" && is_numeric(trim($_GET['forum']))) {

        $fid = (int) inputsec(htmlizer(trim($_GET['forum'])));
    } else {

        //Show a major error and return
        reporterror($l['no_forum_specified_title'], $l['no_forum_specified']);

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

    //He is viewing this forum
    $globals['activity_id'] = $board['fid'];

    $globals['activity_text'] = $board['fname'];


    //Is the board locked
    if (!($board['status'] != 0 || ($board['status'] == 0 && $user['has_priviliges']))) {

        //Show a major error and return
        reporterror($l['forum_locked_title'], $l['forum_locked']);

        return false;
    }

    //If he has the permissions to post
    if (!($user['can_post_topic'] || $board['can_post_topic'])) {

        //Show a major error and return
        reporterror($l['no_topic_permissions_title'], $l['no_topic_permissions']);

        return false;
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
    $tree[] = array('l' => $globals['index_url'] . 'act=topic&forum=' . $fid,
        'txt' => $l['starting_newtopic']);


    //The forums theme
    forum_theme();


    ///////////////////////////////////////
    // Create a 16 bit random code for POST
    // DATA REFRESH Problem to be solved.
    ///////////////////////////////////////

    if (empty($AEF_SESS['postcode']) || !is_array($AEF_SESS['postcode'])) {

        $AEF_SESS['postcode'] = array();
    }

    $postcodefield = '<input type="hidden" value="' . generateRandStr(16) . '" name="postcode" />';

    //Are we to use smileys ?
    if ($globals['usesmileys'] && showsmileys()) {

        if (!getsmileys()) {

            return false;
        }
    }


    //If the user is submitting the post
    if (isset($_POST['submittopic']) || isset($_POST['previewtopic'])) {

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

        //When was the last time you posted
        if (!empty($AEF_SESS['last_post'])) {

            if ((time() - $AEF_SESS['last_post']) < $globals['timepostfromuser']) {

                $error[] = $l['last_post_time'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'newtopic_theme';
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
                    $theme['call_theme_func'] = 'newtopic_theme';
                    return false;
                }

                //Check in the Database
                if (usernameindb($gposter_name)) {

                    $error[] = lang_vars($l['name_in_use'], array($gposter_name));
                }


                $reserved = explode("\n", $globals['reserved_names']);
                $reserved_count = count($reserved);

                for ($i = 0; $i < $reserved_count; $i++) {

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
                $theme['call_theme_func'] = 'newtopic_theme';
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
                $theme['call_theme_func'] = 'newtopic_theme';
                return false;
            }
        }


        //Check if the damn Title field exists.
        if (!(isset($_POST['toptitle'])) || strlen(trim($_POST['toptitle'])) < 1) {

            $error[] = $l['no_title'];
        } else {

            $topic = inputsec(htmlizer(trim($_POST['toptitle'])));

            $topic = checktitle($topic);
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'newtopic_theme';
            return false;
        }


        //If description field isset
        if (isset($_POST['topdesc']) && strlen(trim($_POST['topdesc'])) > 0) {

            $t_description = inputsec(htmlizer(trim($_POST['topdesc'])));

            $t_description = checkdescription($t_description);
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'newtopic_theme';
            return false;
        }


        // Check the post itself
        if (!(isset($_POST['toppost'])) || strlen(trim($_POST['toppost'])) < 1) {

            $error[] = $l['empty_post'];
        } else {

            //We are not trimming for smileys
            $post = inputsec(htmlizer($_POST['toppost']));

            $post = checkpost($post);
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'newtopic_theme';
            return false;
        }


        //Topic Icons / Type Images
        if (isset($_POST['topic_icon']) && (strlen(trim($_POST['topic_icon'])) > 0) && is_numeric(trim($_POST['topic_icon']))) {

            $type_image = inputsec(htmlizer(trim($_POST['topic_icon'])));
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

            if ($user['can_lock_own_topic']) {

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
        if (isset($_POST['postpoll']) && $globals['enablepolls'] && $board['allow_poll']) {

            if ($user['can_post_polls'] || $board['can_post_polls']) {

                $postpoll = 1;
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'newtopic_theme';
            return false;
        }

        /* Ending - Checking the Options of the Posted Topic. */

        //Is the user asking for a preview
        if (isset($_POST['previewtopic'])) {

            //Are sigs to be shown
            $showsigs = ($logged_in ? ( $user['showsigs'] == 1 ? true : ($user['showsigs'] == 2 ? false : $globals['attachsigtopost']) ) : $globals['attachsigtopost']);

            $showavatars = ($logged_in ? ( $user['showavatars'] == 1 ? true : ($user['showavatars'] == 2 ? false : $globals['showavatars']) ) : $globals['showavatars']);

            $showsmileys = showsmileys();

            $preview['title'] = $topic;

            $preview['description'] = $t_description;

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
            $theme['call_theme_func'] = 'newtopic_theme';
            return true;
        }
        
        //Ok, we do some Akismet checks now.

        if ($globals['enable_akismet'] == 1) {

            $akismet = akismetclass();

            $akismet->setCommentAuthor($logged_in ? $user['username'] : $gposter_name);

            $akismet->setCommentAuthorEmail($logged_in ? $user['email'] : $gposter_email);

            if ($logged_in) {
                if (!empty($user['www'])) {
                    $akismet->setCommentAuthorURL($user['www']);
                }
            }

            $akismet->setCommentType('post');

            $akismet->setCommentContent($post);

            $akismet->setUserIP($poster_ip);

            if ($akismet->isCommentSpam()) {
                reporterror($l['akismet_error_title'], $l['akismet_error']);
                return false;
            }
        }

        /////////////////////////////////
        // Finally lets start the queries
        // Effects of a new topic :
        // 1 - Put in topics table
        // 2 - Put in posts table
        // 3 - Update topics table for
        //       first_post_id
        // 4 - Update users post count
        // 5 - Update forums topic count
        // 6 - Update forums post count
        /////////////////////////////////
        //////////////////////////
        // INSERT the topic first
        //////////////////////////

        $qresult = makequery("INSERT INTO " . $dbtables['topics'] . "
                        SET topic = '$topic',
                        t_description = '$t_description',
                        t_bid = '$fid',
                        t_status = '$t_status',
                        type_image = '$type_image',
                        t_mem_id = '$t_mem_id',
                        mem_id_last_post = '$t_mem_id',
                        t_sticky = '$t_sticky'");

        $tid = mysql_insert_id($conn);

        if (empty($tid)) {

            reporterror($l['insert_topic_error_title'], $l['insert_topic_error']);

            return false;
        }



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
                        post_title = '$post_title'");

        $pid = mysql_insert_id($conn);

        if (empty($pid)) {

            reporterror($l['topic_post_error_title'], $l['topic_post_error']);

            return false;
        }


        /////////////////////////////////////////////
        // UPDATE the topics table for first_post_id
        /////////////////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['topics'] . "
                        SET first_post_id = '$pid',
                        last_post_id = '$pid'
                        WHERE tid = '$tid'", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['update_topic_error_title'], $l['update_topic_error']);

            return false;
        }

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
        }


        //////////////////////////////////////////
        // UPDATE the forums topic and post count
        //////////////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                        SET ntopic = ntopic + 1,
                        nposts = nposts + 1,
                        f_last_pid = '$pid'
                        WHERE fid = '" . $board['fid'] . "'", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['update_forum_error_title'], $l['update_forum_error']);

            return false;
        }

        //Increase the stats for todays topic and post count
        $globals['newpost'] = 1;

        $globals['newtopic'] = 1;


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

        //Store that this code was successful
        $AEF_SESS['postcode'][] = $postedcode;

        //Store the last post time
        $AEF_SESS['last_post'] = time();

        if ($globals['notifications']) {

            //Send Notifications
            $qresult = makequery("SELECT u.email
                        FROM " . $dbtables['notify_forum'] . " nf
                        LEFT JOIN " . $dbtables['users'] . " u ON (u.id = nf.notify_mid)
                        WHERE notify_fid = '" . $board['fid'] . "'");

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
                mysql_free_result($qresult);

                $mail[0]['to'] = $globals['board_email'];
                $mail[0]['subject'] = lang_vars($l['new_topic_mail_subject'], array($board['fname']));
                $mail[0]['bcc'] = $notifyemails;
                $mail[0]['message'] = lang_vars($l['new_topic_mail'], array($topic, $board['fname'], $tid, $board['fid']));

                //Pass all Mails to the Mail sending function
                aefmail($mail);
            }
        }


        //Are we to post a poll?
        if ($postpoll) {

            $AEF_SESS['postpoll'] = $tid;

            $AEF_SESS['postpoll_t'] = $topic;

            //Redirect
            redirect('act=postpoll');
        } else {

            //Redirect
            redirect('tid=' . $tid . '');
        }


        return true;
    } else {

        $theme['call_theme_func'] = 'newtopic_theme';
    }
}
