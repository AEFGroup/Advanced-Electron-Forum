<?php

//////////////////////////////////////////////////////////////
//===========================================================
// editpost.php
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
load_lang('editpost');

function editpost() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $fid, $user_group, $post_group, $postcodefield, $error, $smileys, $emoticons, $popup_emoticons, $tid, $board, $post_title, $post, $i_started, $attachments, $tree, $preview;

    //Load the Language File
    if (!load_lang('editpost')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'editpost';

    //The name of the Page
    $theme['init_theme_name'] = 'Edit Post';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('editpost_theme');

    //My activity
    $globals['last_activity'] = 'er';


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
    $modtime = time();

    $modifiers_id = ($logged_in ? $user['id'] : -1);

    $post = '';

    $use_smileys = 0;

    $gposter_name = '';

    $gposter_email = '';

    $post_title = '';

    $num_attachments = 0;

    $attachments = array();

    //A error handler ARRAY
    $error = array();

    //Other VARS
    $announcetopic = 0;

    $tree = array(); //Board tree for users location
    $tree[] = array('l' => $globals['index_url'],
        'txt' => $l['index']);


    if (isset($_GET['pid']) && trim($_GET['pid']) !== "" && is_numeric(trim($_GET['pid']))) {

        $pid = (int) inputsec(htmlizer(trim($_GET['pid'])));
    } else {

        //Show a major error and return
        reporterror($l['no_post_specified_title'], $l['no_post_specified']);

        return false;
    }

    //Bring the post out
    $qresult = makequery("SELECT t.*, p.*, u.username, u.u_member_group, u.sig, u.avatar,
            u.avatar_type, u.avatar_width, u.avatar_height, u.posts, ug.*
            FROM " . $dbtables['posts'] . " p
            LEFT JOIN " . $dbtables['topics'] . " t ON (t.tid = p.post_tid)
            LEFT JOIN " . $dbtables['users'] . " u ON (p.poster_id = u.id)
            LEFT JOIN " . $dbtables['user_groups'] . " ug ON (u.u_member_group = ug.member_group)
            WHERE p.pid='$pid'
            LIMIT 0 , 1");

    if (mysql_num_rows($qresult) < 1) {

        //Show a major error and return
        reporterror($l['no_post_found_title'], $l['no_post_found']);

        return false;
    }

    $post = mysql_fetch_assoc($qresult);

    //Free the resources
    mysql_free_result($qresult);

    $fid = $post['post_fid'];

    //$t_sticky = $post['p_top_sticky'];//Not required anymore

    $post_title = $post['post_title'];

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
    $globals['activity_id'] = $post['post_tid'];

    $globals['activity_text'] = $post['topic'];


    //Who started this topic?
    if ($logged_in) {

        if ($post['poster_id'] == $user['id']) {

            $i_started = true;
        } else {

            $i_started = false;
        }
    } else {

        $i_started = false;
    }


    //Can he EDIT the post
    if (!(($i_started && $user['can_edit_own']) ||
            (!$i_started && $user['can_edit_other']))) {

        //Show a major error and return
        reporterror($l['no_edit_permissions_title'], $l['no_edit_permissions']);

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


    //Add the topic link
    $tree[] = array('l' => $globals['index_url'] . 'tid=' . $post['tid'],
        'txt' => $post['topic']);

    //Add the inner topic link also
    $tree[] = array('l' => $globals['index_url'] . 'act=edit&pid=' . $post['pid'],
        'txt' => $l['editing_post']);


    //The forums theme
    forum_theme();


    if (!empty($post['num_attachments']) && $user['can_remove_attach'] &&
            ($user['can_view_attach'] || $board['can_view_attach'])) {

        //Get the attachments
        $qresult = makequery("SELECT at.*, mt.atmt_icon, mt.atmt_isimage
                FROM " . $dbtables['attachments'] . " at
                LEFT JOIN " . $dbtables['attachment_mimetypes'] . " mt ON (at.at_mimetype_id = mt.atmtid)
                WHERE at.at_pid = '$pid'
                ORDER BY at_pid ASC");

        //There may be no such attachments
        //Are there any attachments
        if (mysql_num_rows($qresult) > 0) {

            $atids = array();

            $attachments = array();

            for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

                $row = mysql_fetch_assoc($qresult);

                $atids[] = $row['atid'];

                $attachments[$row['atid']] = $row;

                $attachments[$row['atid']]['at_size'] = substr(($row['at_size'] / 1024), 0, 5);
            }
        }
    }


    //Are we to use smileys ?
    if ($globals['usesmileys']) {

        if (!getsmileys()) {

            return false;
        }
    }


    //If the user is submitting the edited post
    if (isset($_POST['editpost']) || isset($_POST['previewpost'])) {

        //For Guests their names and email is important
        if (!empty($post['gposter_name'])) {

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
                    $theme['call_theme_func'] = 'editpost_theme';
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
                $theme['call_theme_func'] = 'editpost_theme';
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
                $theme['call_theme_func'] = 'editpost_theme';
                return false;
            }
        }

        //Check if the damn field Title exists.
        if (!(isset($_POST['posttitle'])) || strlen(trim($_POST['posttitle'])) < 1) {

            $post_title = $post_title;
        } else {

            $post_title = inputsec(htmlizer(trim($_POST['posttitle'])));

            $post_title = checktitle($post_title);
        }

        //check the post itself
        if (!(isset($_POST['post'])) || trim($_POST['post']) == "") {

            $error[] = $l['empty_post'];
        } else {

            //We are not trimming for smileys
            $post_ = inputsec(htmlizer($_POST['post']));

            $post_ = checkpost($post_);
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editpost_theme';
            return false;
        }


        /* Checking the Options of the Posted Topic. */

        //Check the smileys
        if (isset($_POST['usesmileys'])) {

            $use_smileys = 1;
        }


        //Announcing is tough
        if (isset($_POST['announcetopic'])) {

            if ($user['can_announce_topic']) {

                $announcetopic = 1;
            }
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editpost_theme';
            return false;
        }

        /* Ending - Checking the Options of the Posted Topic. */

        //Is the user asking for a preview
        if (isset($_POST['previewpost'])) {

            //Are sigs to be shown
            $showsigs = ($logged_in ? ( $user['showsigs'] == 1 ? true : ($user['showsigs'] == 2 ? false : $globals['attachsigtopost']) ) : $globals['attachsigtopost']);

            $showavatars = ($logged_in ? ( $user['showavatars'] == 1 ? true : ($user['showavatars'] == 2 ? false : $globals['showavatars']) ) : $globals['showavatars']);

            $showsmileys = showsmileys();

            //Bring the Member Group
            if (!membergroups()) {

                return false;
            }

            $preview['title'] = $post_title;

            //Is there any username present
            if (empty($post['username'])) {

                $post['mem_gr_name'] = $user_group[-1]['mem_gr_name'];

                $post['image_name'] = $user_group[-1]['image_name'];

                $post['image_count'] = $user_group[-1]['image_count'];

                $post['mem_gr_colour'] = $user_group[-1]['mem_gr_colour'];

                $post['is_guest'] = 1;

                //Has it been posted by any guest
                if (empty($post['gposter_name'])) {

                    $post['username'] = $user_group[-1]['mem_gr_name'];

                    $post['gposter_email'] = '';
                } else {

                    $post['username'] = $post['gposter_name'];

                    $post['gposter_email'] = $post['gposter_email'];
                }
            }

            //If there is a new guest editor
            if (!empty($gposter_name)) {

                $preview['username'] = $gposter_name;

                $preview['gposter_email'] = $gposter_email;
            }

            $post_group = array_reverse($post_group);

            //Which Post Group Do you Belong ?
            foreach ($post_group as $pgrk => $pgr) {

                if ($post['posts'] >= $pgr['post_count']) {

                    $post['post_gr_name'] = $pgr['mem_gr_name'];
                    break;
                }
            }

            $post['modtime'] = datify(time());

            //Is avatars allowed globally
            if (!empty($post['avatar']) && $globals['showavatars'] && $showavatars) {

                $avatar = array('avatar' => $post['avatar'],
                    'avatar_type' => $post['avatar_type'],
                    'avatar_width' => $post['avatar_width'],
                    'avatar_height' => $post['avatar_height']
                );

                $preview['avatarurl'] = urlifyavatar(100, $avatar);
            }

            //If user wants to see sig
            if ($globals['enablesig'] && $showsigs && !empty($post['sig'])) {

                $preview['sig'] = $post['sig'];

                $preview['sig'] = parse_special_bbc($preview['sig']);

                $preview['sig'] = format_text($preview['sig']);

                $preview['sig'] = parse_br($preview['sig']);

                //What about smileys in sigs
                if ($globals['usesmileys'] && $showsmileys) {

                    $preview['sig'] = smileyfy($preview['sig']);
                }
            }

            $preview['pdate'] = datify($post['ptime']);

            $preview['post'] = stripslashes($post_);

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
            $theme['call_theme_func'] = 'editpost_theme';
            return true;
        }

        //Check if some attacments are to be deleted
        if ($post['num_attachments'] && $user['can_remove_attach']) {

            $tobedel = array();

            $tobedel_at = array();

            //Are there any attachments that were there previously and are still to be there
            if (!empty($_POST['attached'])) {

                $attached = $_POST['attached'];

                foreach ($atids as $at => $av) {

                    if (!in_array($av, $attached)) {

                        $tobedel[] = $av;
                    }
                }
            } else {

                $tobedel = $atids;
            }

            foreach ($tobedel as $k => $v) {

                $tobedel_at[] = $attachments[$v];
            }
        }

        /////////////////////////////////
        // Finally lets start the queries
        // Effects of a new topic :
        // 1 - Update posts table
        // 2 - Update topics table
        /////////////////////////////////
        ///////////////////////
        // UPDATE the post now
        ///////////////////////

        $qresult = makequery("UPDATE " . $dbtables['posts'] . "
                        SET modtime = '$modtime',
                        modifiers_id = '$modifiers_id',
                        post = '$post_',
                        use_smileys = '$use_smileys',
                        gposter_name = '$gposter_name',
                        gposter_email = '$gposter_email',
                        post_title = '$post_title'
                        WHERE pid = '$pid'
                        LIMIT 1", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['edit_error_title'], $l['edit_error']);

            return false;
        }

        //Free the resources
        mysql_free_result($qresult);


        ///////////////////////////////
        // Save the user read the topic
        ///////////////////////////////

        if (!read_topic($post['post_tid'], time())) {

            return false;
        }

        ///////////////////////////////
        // Save the user read the forum
        ///////////////////////////////

        if (!read_forum($board['fid'], time())) {

            return false;
        }


        //What about new attachments ?
        if (!(empty($_FILES['attachments']['tmp_name']) &&
                empty($_FILES['attachments']['name']) &&
                empty($_FILES['attachments']['size']))) {

            //Are new attachments allowed ?s
            if (!$globals['allownewattachment']) {

                reporterror($l['attachments_not_allowed_title'], $l['attachments_not_allowed']);

                return false;
            } else {

                if (!attach($board['fid'], $post['post_tid'], $pid)) {

                    return false;
                }
            }
        }


        //Are we to delete any attachments
        if (!empty($tobedel)) {

            if (!dettach($board['fid'], $post['post_tid'], $pid, $tobedel_at)) {

                return false;
            }
        }


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


        //Calculate the topic page number.
        $qresult = makequery("SELECT pid FROM " . $dbtables['posts'] . "
                        WHERE post_tid = '" . $post['post_tid'] . "'
                        ORDER BY pid ASC");

        if (mysql_num_rows($qresult) < 1) {

            reporterror($l['redirect_error_title'], $l['redirect_error']);

            return false;
        }

        for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

            $row = mysql_fetch_assoc($qresult);

            $pids[$i] = $row['pid'];
        }

        //Free the resources
        mysql_free_result($qresult);


        //Find the post number that this post is of its topic
        $post_num = array_search($pid, $pids);

        $tpg = ($post_num / $globals['maxpostsintopics']);

        $tpg = ceil($tpg);


        //Redirect
        redirect('tid=' . $post['post_tid'] . '&tpg=' . $tpg . '#p' . $pid); //IE 7 #redirect not working

        return true;


        //The user is visiting this page for the first time so show the Form.
    } else {

        $theme['call_theme_func'] = 'editpost_theme';
    }
}

?>
