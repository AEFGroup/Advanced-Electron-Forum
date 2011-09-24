<?php

//////////////////////////////////////////////////////////////
//===========================================================
// forums.php(Admin)
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

function forums() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    if (!load_lang('admin/forums')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'admin/forums';

    //The name of the Page
    $theme['init_theme_name'] = 'Admin Center - Manage Forums';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('forum_global',
        'forummanage_theme',
        'editforum_theme',
        'createforum_theme');

    //My activity
    $globals['last_activity'] = 'af';


    //If a second Admin act is set then go by that
    if (isset($_GET['seadact']) && trim($_GET['seadact']) !== "") {

        $seadact = inputsec(htmlizer(trim($_GET['seadact'])));
    } else {

        $seadact = "";
    }

    //The switch handler
    switch ($seadact) {

        //The form for editing a Category
        case 'editforum':
            editforum();
            break;

        //The form for creating a new Category
        case 'createforum':
            createforum();
            break;

        //The form for creating a new Category
        case 'deleteforum':
            deleteforum();
            break;

        //The form for reordering forums
        case 'forumreorder':
            forumreorder();
            break;

        //This is for handling all AJAX Calls
        case 'ajax':
            $echo = ajax_getneworder();
            header("Cache-Control: no-cache, must-revalidate");
            echo $echo;
            break;


        default :
            if (!default_of_nor(true, false)) {

                return false;
            }
            $theme['call_theme_func'] = 'forummanage_theme';
            break;
    }
}

//This fuction is to edit a forum
function editforum() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $board, $samelevel, $member_group, $mother_options, $currentmother, $order_of_boards, $error, $user_group, $themes, $children;

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $fid = 0;

    $board = array();

    $cat = 0;

    $orderoptions = array();

    $error = array();

    $samelevel = array();

    $member_group = array();

    $members = array();

    $mother_options = array();

    $order_of_boards = array();

    $order = array();

    $currentmother = '';

    $mother = '';

    $themeids = array();

    //Forum vars
    $cat_id = 0;

    $par_board_id = 0;

    $forum_order = 0;

    $fmember_group = '';

    $fname = '';

    $description = '';

    $fimage = '';

    $fredirect = '';

    $status = 0;

    $prune = 0;

    $allow_poll = 0;

    $allow_html = 0;

    $id_skin = 0;

    $override_skin = 0;

    $inc_mem_posts = 0;

    $quick_reply = 0;

    $frulestitle = '';

    $frules = '';

    $mod_topics = 0;

    $mod_posts = 0;

    $rss = 0;

    $rss_topic = 0;

    if (isset($_GET['editforum']) && trim($_GET['editforum']) !== "" && is_numeric(trim($_GET['editforum']))) {

        $fid = (int) inputsec(htmlizer(trim($_GET['editforum'])));
    } else {

        //Show a major error and return
        reporterror($l['no_forum'], $l['no_forum_exp']);

        return false;
    }


    //Get the categories and forums
    if (!default_of_nor(false, false)) {

        return false;
    }

    //Beneath all VARS are to handle and store the IN_Boards of the editing forum
    $its_in_boards = array();

    $its_board_level = 0;

    $trap_in = false;

    //This is to find which forum is it that the user is viewing
    foreach ($forums as $c => $cv) {

        //The main forum loop
        foreach ($forums[$c] as $f => $v) {

            if ($forums[$c][$f]['board_level'] == $its_board_level ||
                    $forums[$c][$f]['board_level'] < $its_board_level) {

                $trap_in = false;
            }

            if ($trap_in) {

                $its_in_boards[$forums[$c][$f]['fid']] = $forums[$c][$f];
            }

            if ($forums[$c][$f]['fid'] == $fid) {

                $board = $forums[$c][$f];

                $cat = $c;

                $its_board_level = $forums[$c][$f]['board_level'];

                $trap_in = true;
            }
        }
    }//End of main loop


    if (empty($board)) {

        //Show a major error and return
        reporterror($l['no_forum_found'], $l['no_forum_found_exp']);

        return false;
    }


    //The current mother
    $currentmother = (empty($board['board_level']) ? 'c' . $board['cat_id'] : 'i' . $board['par_board_id']);


    ////////////////////////////////////
    // Find the orders that can be given
    ////////////////////////////////////

    foreach ($forums[$cat] as $f => $fv) {

        //If it is a main level board
        if (!($board['board_level'])) {

            if ($forums[$cat][$f]['board_level'] == $board['board_level']) {

                //put the forums having the same board level and the same forum_order
                $samelevel[$f] = array('fid' => $forums[$cat][$f]['fid'],
                    'order' => $forums[$cat][$f]['forum_order']);
            }

            //Ok so it is not directly under a Category but a In Board
        } else {

            if ($forums[$cat][$f]['board_level'] == $board['board_level'] && $forums[$cat][$f]['par_board_id'] == $board['par_board_id']) {

                //put the forums having the same board level and the same forum_order
                $samelevel[$f] = array('fid' => $forums[$cat][$f]['fid'],
                    'order' => $forums[$cat][$f]['forum_order']);
            }
        }
    }


    /////////////////////////////////////
    // Find the mothers that can be given
    /////////////////////////////////////

    foreach ($categories as $c => $cv) {

        $mother_options[] = array('c' . $categories[$c]['cid'], $categories[$c]['name']);

        if (isset($forums[$c])) {

            foreach ($forums[$c] as $f => $fv) {

                $dasher = "";

                for ($t = 0; $t < $forums[$c][$f]['board_level']; $t++) {

                    $dasher .= "&nbsp;&nbsp;&nbsp;&nbsp;";
                }

                $matched = false;

                foreach ($its_in_boards as $i => $iv) {

                    if ($forums[$c][$f]['fid'] == $its_in_boards[$i]['fid']) {

                        $matched = true;
                    }
                }

                if ($forums[$c][$f]['fid'] != $board['fid'] && !$matched) {

                    $mother_options[] = array('i' . $forums[$c][$f]['fid'],
                        $dasher . '|--' . $forums[$c][$f]['fname']);
                }
            }
        }
    }


    /////////////////////////////////////////
    //Which member groups are allowed to view
    /////////////////////////////////////////
    //Get the user groups
    if (!membergroups()) {

        return false;
    }

    $member_group = array('all' => array(),
        'presentlyallowed' => array(),
    );

    //All non-post user groups
    $member_group['all'] = $user_group;

    //Unset the Admins user group
    unset($member_group['all'][1]);

    $user_group_ids = array_keys($member_group['all']);

    $presentlyall = explode(',', $board['member_group']);
    $presentlyall_count = count($presentlyall);

    for ($i = 0; $i < $presentlyall_count; $i++) {

        $member_group['presentlyallowed'][$presentlyall[$i]] = $presentlyall[$i];
    }


    ///////////////////////////
    //Get the installed Themes
    ///////////////////////////

    $qresult = makequery("SELECT * FROM " . $dbtables['themes']);

    if (mysql_num_rows($qresult) < 1) {

        //Show a major error and return
        reporterror($l['no_themes_found'], $l['no_themes_found_exp']);

        return false;
    }

    //The loop to draw out the rows
    for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

        $row = mysql_fetch_assoc($qresult);

        $themes[$row['thid']] = $row;

        $themeids[] = $row['thid'];
    }

    //Free the resources
    mysql_free_result($qresult);



    if (isset($_POST['editboard'])) {

        //Check the Parent is set
        if (!(isset($_POST['editmother'])) || (trim($_POST['editmother']) == "")) {

            $error[] = $l['no_mother_posted'];
        } else {

            $mother = inputsec(htmlizer(trim($_POST['editmother'])));
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editforum_theme';
            return false;
        }


        //Check the Order is Set.
        if (!(isset($_POST['forder'])) || (trim($_POST['forder']) == "")) {

            $error[] = $l['forum_order_missing'];
        } else {

            $forum_order = (int) inputsec(htmlizer(trim($_POST['forder'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editforum_theme';
            return false;
        }


        //Check the Status is Set.
        if (!(isset($_POST['fstatus'])) || (trim($_POST['fstatus']) == "")) {

            $error[] = $l['no_forum_status'];
        } else {

            $status = (int) inputsec(htmlizer(trim($_POST['fstatus'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editforum_theme';
            return false;
        }


        //Check the Forum Name is Set.
        if (!(isset($_POST['fname'])) || (trim($_POST['fname']) == "")) {

            $error[] = $l['no_forum_name'];
        } else {

            $fname = inputsec(htmlizer(trim($_POST['fname'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editforum_theme';
            return false;
        }


        //Check the Forum Description is Set.
        if (isset($_POST['fdesc'])) {

            $description = inputsec(htmlizer(trim($_POST['fdesc'])));
        }


        //Check the theme
        if (!(isset($_POST['ftheme'])) || (trim($_POST['ftheme']) == "")) {

            $error[] = $l['no_forums_theme'];
        } else {

            $id_skin = (int) inputsec(htmlizer(trim($_POST['ftheme'])));

            //If the selected theme is not the forum default then check
            if (($id_skin != 0) && !in_array($id_skin, $themeids)) {

                $error[] = $l['forums_theme_invalid'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editforum_theme';
            return false;
        }


        //Check the Forum redirect Option.
        if (isset($_POST['fredirect'])) {

            $fredirect = inputsec(trim($_POST['fredirect']));
        }


        //Check the Forum image is given.
        if (isset($_POST['fimage'])) {

            $fimage = inputsec(trim($_POST['fimage']));
        }


        //Check the Forum rules title is given.
        if (isset($_POST['frulestitle'])) {

            $frulestitle = inputsec(htmlizer(trim($_POST['frulestitle'])));
        }


        //Check the Forum rules is given.
        if (isset($_POST['frules'])) {

            $frules = inputsec(htmlizer(trim($_POST['frules'])));
        }


        //Allowed Members Var
        $invalidug = array();

        if (!empty($_POST['member']) && is_array($_POST['member'])) {

            $members = array_keys($_POST['member']);

            foreach ($members as $m) {

                //Is it a valid group
                if (!in_array($m, $user_group_ids)) {

                    $invalidug[] = $m;
                }
            }

            //Are ther invalid users
            if (!empty($invalidug)) {

                $error[] = $l['groups_having_ids'] . implode(', ', $invalidug) . $l['do_not_exist'];
            } else {

                $fmember_group = implode(',', $members);
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editforum_theme';
            return false;
        }



        //Check if Increase Member Post Count is Set.
        if (isset($_POST['inc_mem_posts'])) {

            $inc_mem_posts = 1;
        }


        //Check if Override Skin Option is Set.
        if (isset($_POST['override_skin'])) {

            $override_skin = 1;
        }


        //Check if Polls is to be enabled or not.
        if (isset($_POST['allow_poll'])) {

            $allow_poll = 1;
        }

        //Check if HTML for Member Gorups having permissions is to be enabled or not.
        if (isset($_POST['allow_html'])) {

            $allow_html = 1;
        }


        //Check if Quick Reply Box is to be enabled or not.
        if (isset($_POST['quick_reply'])) {

            $quick_reply = 1;
        }

        $quick_topic = checkbox('quick_topic');

        //Check if topics are to be moderated.
        if (isset($_POST['mod_topics'])) {

            $mod_topics = 1;
        }

        //Check if posts are to be moderated.
        if (isset($_POST['mod_posts'])) {

            $mod_posts = 1;
        }

        //Check if RSS Feeds for recent posts are there.
        if (isset($_POST['rss'])) {

            $rss = (int) inputsec(htmlizer(trim($_POST['rss'])));
        }

        //Check if RSS Feeds for a topic are there.
        if (isset($_POST['rss_topic'])) {

            $rss_topic = (int) inputsec(htmlizer(trim($_POST['rss_topic'])));
        }


        //If the mother is a Category.
        if (preg_match('/c/i', $mother)) {

            $temp = explode('c', $mother);

            //The New Category ID
            $cat_id = (int) $temp[1];

            unset($temp);

            //Oh so you want to make it a In Board
        } elseif (preg_match('/i/i', $mother)) {

            $temp = explode('i', $mother);

            $par_board_id = (int) $temp[1];

            unset($temp);

            //Find the New Mother
            foreach ($forums as $c => $cv) {

                //The main forum loop
                foreach ($forums[$c] as $f => $v) {

                    if ($forums[$c][$f]['fid'] == $par_board_id) {

                        $in_board_of = $forums[$c][$f];

                        break;
                    }
                }
            }//End of main loop

            $cat_id = $in_board_of['cat_id'];
        }


        //Has the Mother been changed
        if ($currentmother != $mother) {

            $mother_changed = true;

            $default = neworder($mother) + 1;
        } else {

            $mother_changed = false;

            $default = neworder($mother);
        }

        //This is a small change to solve the Forced Ads issue
        if (empty($forum_order)) {

            $forum_order = $default;
        }

        if ($forum_order > $default) {

            $error[] = $l['submitted_order_greater'];
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editforum_theme';
            return false;
        }

        /////////////////////////////////
        // Finally lets UPDATE the Forum
        /////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                    SET    cat_id = '$cat_id',
                    par_board_id = '$par_board_id',
                    forum_order = '$forum_order',
                    member_group = '$fmember_group',
                    fname = '$fname',
                    description = '$description',
                    fimage = '$fimage',
                    fredirect = '$fredirect',
                    status = '$status',
                    allow_poll = '$allow_poll',
                    allow_html = '$allow_html',
                    id_skin = '$id_skin',
                    override_skin = '$override_skin',
                    inc_mem_posts = '$inc_mem_posts',
                    quick_reply = '$quick_reply',
                    quick_topic = '$quick_topic',
                    frulestitle = '$frulestitle',
                    frules = '$frules',
                    mod_topics = '$mod_topics',
                    mod_posts = '$mod_posts',
                    rss = '$rss',
                    rss_topic = '$rss_topic'
                    WHERE fid = '$fid'
                    LIMIT 1", false);

        /* if(mysql_affected_rows($conn) < 1){

          reporterror('Edit Forum Error' ,'There were some errors in updating the submitted information of the forum <b>'.$board['fname'].'</b>.');

          return false;

          } */


        /////////////////////////////////
        // If there are any changes then
        // UPDATE its In Boards parents.
        /////////////////////////////////
        //Update only if the old Parent is not the same.
        if ($mother_changed) {

            foreach ($its_in_boards as $i => $iv) {

                $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                        SET    cat_id = '$cat_id'
                        WHERE fid = '" . $its_in_boards[$i]['fid'] . "'
                        LIMIT 1", false);
            }
        }


        /////////////////////////////////
        // If there are any changes then
        // UPDATE the Boards where it
        // was located previously.
        /////////////////////////////////
        //If changes are to be made
        if ($mother_changed) {

            reorderchildren($board['par_board_id'], $board['cat_id']);
        }



        /////////////////////////////////
        // If there are any changes then
        // UPDATE the Boards where it
        // is going to go.
        /////////////////////////////////

        $edit_field = 'forum_order';

        //If MOTHER has Changed && DEFAULT ORDER is not same as POSTED Order OR
        if ($mother_changed && $default != $forum_order) {

            //If POSTED Order is LESS than the DEFAULT ORDER
            if ($forum_order < $default) {

                //A for loop to reorder the rest
                for ($o = $forum_order; $o < $default; $o++) {

                    //Find the Child of the new parent whose order was the submitted one
                    foreach ($children as $ch => $chv) {

                        if ($chv[$edit_field] == $o) {

                            $orderfid = $chv['fid'];
                        }
                    }

                    $neworder = $o + 1;

                    $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                                SET " . $edit_field . " = '$neworder'
                                WHERE fid = '$orderfid'
                                LIMIT 1", false);

                    if (mysql_affected_rows($conn) < 1) {

                        reporterror($l['edit_forum_error'], $l['edit_forum_error_exp1']);

                        return false;
                    }

                    //Free the resources
                    mysql_free_result($qresult);
                }
            }

            //If MOTHER has NOT Changed && OLD ORDER is not same as POSTED Order
        } elseif ((!($mother_changed)) && ($board[$edit_field] != $forum_order)) {

            //If POSTED Order is LESS than the OLD ORDER
            if ($forum_order < $board[$edit_field]) {

                //A for loop to reorder the rest
                for ($o = $forum_order; $o < $board[$edit_field]; $o++) {

                    //Find the Child of the new parent whose order was the submitted one
                    foreach ($children as $ch => $chv) {

                        if ($chv[$edit_field] == $o) {

                            $orderfid = $chv['fid'];
                        }
                    }

                    $neworder = $o + 1;

                    $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                                SET " . $edit_field . " = '$neworder'
                                WHERE fid = '$orderfid'
                                LIMIT 1", false);

                    if (mysql_affected_rows($conn) < 1) {

                        reporterror($l['edit_forum_error'], $l['edit_forum_error_exp2']);

                        return false;
                    }

                    //Free the resources
                    mysql_free_result($qresult);
                }//End of for loop
            } elseif ($forum_order > $board[$edit_field]) {

                //A for loop to reorder the rest
                for ($o = ($board[$edit_field] + 1); $o <= $forum_order; $o++) {

                    //Find the Child of the new parent whose order was the submitted one
                    foreach ($children as $ch => $chv) {

                        if ($chv[$edit_field] == $o) {

                            $orderfid = $chv['fid'];
                        }
                    }

                    $neworder = $o - 1;

                    $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                                SET " . $edit_field . " = '$neworder'
                                WHERE fid = '$orderfid'
                                LIMIT 1", false);

                    if (mysql_affected_rows($conn) < 1) {

                        reporterror($l['edit_forum_error'], $l['edit_forum_error_exp2']);

                        return false;
                    }

                    //Free the resources
                    mysql_free_result($qresult);
                }
            }//End of if($forum_order < $default)
        }


        //Redirect
        redirect('act=admin&adact=forums');

        return true;
    } else {

        //Calling the theme file
        $theme['call_theme_func'] = 'editforum_theme';
    }
}

//End of function

function createforum() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $board, $samelevel, $member_group, $mother_options, $currentmother, $order_of_boards, $error, $user_group, $themes, $children, $postcodefield;

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $fid = 0;

    $board = array();

    $cat = 0;

    $orderoptions = array();

    $error = array();

    $samelevel = array();

    $member_group = array();

    $members = array();

    $mother_options = array();

    $order_of_boards = array();

    $order = array();

    $currentmother = '';

    $mother = '';

    $forum_order = 0;

    $themeids = array();

    //Forum vars
    $cat_id = 0;

    $par_board_id = 0;

    $forum_order = 0;

    $fmember_group = '';

    $fname = '';

    $description = '';

    $fimage = '';

    $fredirect = '';

    $status = 0;

    $prune = 0;

    $allow_poll = 0;

    $allow_html = 0;

    $id_skin = 0;

    $override_skin = 0;

    $inc_mem_posts = 0;

    $quick_reply = 0;

    $frulestitle = '';

    $frules = '';

    $mod_topics = 0;

    $mod_posts = 0;

    $rss = 0;

    $rss_topic = 0;


    //Get the categories and forums
    if (!default_of_nor(false, false)) {

        return false;
    }


    /////////////////////////////////////
    // Find the mothers that can be given
    /////////////////////////////////////

    foreach ($categories as $c => $cv) {

        $mother_options[] = array('c' . $categories[$c]['cid'], $categories[$c]['name']);

        if (isset($forums[$c])) {

            foreach ($forums[$c] as $f => $fv) {

                $dasher = "";

                for ($t = 0; $t < $forums[$c][$f]['board_level']; $t++) {

                    $dasher .= "&nbsp;&nbsp;&nbsp;&nbsp;";
                }


                $mother_options[] = array('i' . $forums[$c][$f]['fid'],
                    $dasher . '|--' . $forums[$c][$f]['fname']);
            }
        }
    }

    /////////////////////////////////////////
    //Which member groups are allowed to view
    /////////////////////////////////////////
    //Get the user groups
    if (!membergroups()) {

        return false;
    }

    $member_group = array('all' => array(),
        'presentlyallowed' => array(),
    );

    //All non-post user groups
    $member_group['all'] = $user_group;

    //Unset the Admins user group
    unset($member_group['all'][1]);

    $user_group_ids = array_keys($member_group['all']);


    ///////////////////////////
    //Get the installed Themes
    ///////////////////////////

    $qresult = makequery("SELECT * FROM " . $dbtables['themes']);

    if (mysql_num_rows($qresult) < 1) {

        //Show a major error and return
        reporterror($l['no_themes_found'], $l['no_themes_found_exp']);

        return false;
    }

    //The loop to draw out the rows
    for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

        $row = mysql_fetch_assoc($qresult);

        $themes[$row['thid']] = $row;

        $themeids[] = $row['thid'];
    }

    //Free the resources
    mysql_free_result($qresult);


    ///////////////////////////////////////
    // Create a 16 bit random code for POST
    // DATA REFRESH Problem to be solved.
    ///////////////////////////////////////

    if (empty($AEF_SESS['postcode']) || !is_array($AEF_SESS['postcode'])) {

        $AEF_SESS['postcode'] = array();
    }

    $postcodefield = '<input type="hidden" value="' . generateRandStr(16) . '" name="postcode" />';


    //If the form is posted
    if (isset($_POST['createboard'])) {

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

                $error[] = $l['sec_code_unmatched'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'createforum_theme';
            return false;
        }


        //Check the Parent is set
        if (!(isset($_POST['fmother'])) || (trim($_POST['fmother']) == "")) {

            $error[] = $l['no_mother_posted'];
        } else {

            $mother = inputsec(htmlizer(trim($_POST['fmother'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'createforum_theme';
            return false;
        }


        //Check the Order is Set.
        if (!(isset($_POST['forder'])) || (trim($_POST['forder']) == "")) {

            $error[] = $l['forum_order_missing'];
        } else {

            $forum_order = (int) inputsec(htmlizer(trim($_POST['forder'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'createforum_theme';
            return false;
        }


        //Check the Status is Set.
        if (!(isset($_POST['fstatus'])) || (trim($_POST['fstatus']) == "")) {

            $error[] = $l['no_forum_status'];
        } else {

            $status = (int) inputsec(htmlizer(trim($_POST['fstatus'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'createforum_theme';
            return false;
        }


        //Check the Forum Name is Set.
        if (!(isset($_POST['fname'])) || (trim($_POST['fname']) == "")) {

            $error[] = $l['no_forum_name'];
        } else {

            $fname = inputsec(htmlizer(trim($_POST['fname'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'createforum_theme';
            return false;
        }


        //Check the Forum Description is Set.
        if (isset($_POST['fdesc'])) {

            $description = inputsec(htmlizer(trim($_POST['fdesc'])));
        }


        //Check the theme
        if (!(isset($_POST['ftheme'])) || (trim($_POST['ftheme']) == "")) {

            $error[] = $l['no_forums_theme'];
        } else {

            $id_skin = (int) inputsec(htmlizer(trim($_POST['ftheme'])));

            //If the selected theme is not the forum default then check
            if (($id_skin != 0) && !in_array($id_skin, $themeids)) {

                $error[] = $l['forums_theme_invalid'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'createforum_theme';
            return false;
        }


        //Check the Forum redirect Option.
        if (isset($_POST['fredirect'])) {

            $fredirect = inputsec(trim($_POST['fredirect']));
        }


        //Check the Forum image is given.
        if (isset($_POST['fimage'])) {

            $fimage = inputsec(trim($_POST['fimage']));
        }


        //Check the Forum rules title is given.
        if (isset($_POST['frulestitle'])) {

            $frulestitle = inputsec(htmlizer(trim($_POST['frulestitle'])));
        }


        //Check the Forum rules is given.
        if (isset($_POST['frules'])) {

            $frules = inputsec(htmlizer(trim($_POST['frules'])));
        }


        //Allowed Members Var
        $invalidug = array();

        if (!empty($_POST['member']) && is_array($_POST['member'])) {

            $members = array_keys($_POST['member']);

            foreach ($members as $m) {

                //Is it a valid group
                if (!in_array($m, $user_group_ids)) {

                    $invalidug[] = $m;
                }
            }

            //Are ther invalid users
            if (!empty($invalidug)) {

                $error[] = $l['groups_having_ids'] . implode(', ', $invalidug) . $l['do_not_exist'];
            } else {

                $fmember_group = implode(',', $members);
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'createforum_theme';
            return false;
        }



        //Check if Increase Member Post Count is Set.
        if (isset($_POST['inc_mem_posts'])) {

            $inc_mem_posts = 1;
        }


        //Check if Override Skin Option is Set.
        if (isset($_POST['override_skin'])) {

            $override_skin = 1;
        }


        //Check if Polls is to be enabled or not.
        if (isset($_POST['allow_poll'])) {

            $allow_poll = 1;
        }

        //Check if HTML for Member Gorups having permissions is to be enabled or not.
        if (isset($_POST['allow_html'])) {

            $allow_html = 1;
        }


        //Check if Quick Reply Box is to be enabled or not.
        if (isset($_POST['quick_reply'])) {

            $quick_reply = 1;
        }

        $quick_topic = checkbox('quick_topic');

        //Check if topics are to be moderated.
        if (isset($_POST['mod_topics'])) {

            $mod_topics = 1;
        }

        //Check if posts are to be moderated.
        if (isset($_POST['mod_posts'])) {

            $mod_posts = 1;
        }

        //Check if RSS Feeds for recent posts are there.
        if (isset($_POST['rss'])) {

            $rss = (int) inputsec(htmlizer(trim($_POST['rss'])));
        }

        //Check if RSS Feeds for a topic are there.
        if (isset($_POST['rss_topic'])) {

            $rss_topic = (int) inputsec(htmlizer(trim($_POST['rss_topic'])));
        }


        //If the mother is a Category.
        if (preg_match('/c/i', $mother)) {

            $temp = explode('c', $mother);

            //The New Category ID
            $cat_id = (int) $temp[1];

            unset($temp);


            //Oh so you want to make it a In Board
        } elseif (preg_match('/i/i', $mother)) {

            $temp = explode('i', $mother);

            $par_board_id = (int) $temp[1];

            unset($temp);

            //Find the New Mother
            foreach ($forums as $c => $cv) {

                //The main forum loop
                foreach ($forums[$c] as $f => $v) {

                    if ($forums[$c][$f]['fid'] == $par_board_id) {

                        $in_board_of = $forums[$c][$f];

                        break;
                    }
                }
            }//End of main loop

            $cat_id = $in_board_of['cat_id'];
        }


        //! has to be added as it is to be entered
        $default = neworder($mother) + 1;

        //This is a small change to solve the Forced Ads issue
        if (empty($forum_order)) {

            $forum_order = $default;
        }

        if ($forum_order > $default) {

            $error[] = $l['submitted_order_greater'];
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'createforum_theme';
            return false;
        }

        /////////////////////////////////
        // Finally lets UPDATE the Forum
        /////////////////////////////////

        $qresult = makequery("INSERT INTO " . $dbtables['forums'] . "
                    SET    cat_id = '$cat_id',
                    par_board_id = '$par_board_id',
                    forum_order = '$forum_order',
                    member_group = '$fmember_group',
                    fname = '$fname',
                    description = '$description',
                    fimage = '$fimage',
                    fredirect = '$fredirect',
                    status = '$status',
                    allow_poll = '$allow_poll',
                    allow_html = '$allow_html',
                    id_skin = '$id_skin',
                    override_skin = '$override_skin',
                    inc_mem_posts = '$inc_mem_posts',
                    quick_reply = '$quick_reply',
                    quick_topic = '$quick_topic',
                    frulestitle = '$frulestitle',
                    frules = '$frules',
                    mod_topics = '$mod_topics',
                    mod_posts = '$mod_posts',
                    rss = '$rss',
                    rss_topic = '$rss_topic'", false);

        $fid = mysql_insert_id($conn);

        if (empty($fid)) {

            reporterror($l['create_forum_error'], $l['inserting_submitted_info']);

            return false;
        }

        /////////////////////////////////
        // If there are any changes then
        // UPDATE the Boards where it
        // is going to go.
        /////////////////////////////////

        $edit_field = 'forum_order';

        //If POSTED Order is LESS than the DEFAULT ORDER
        if ($forum_order < $default) {

            //A for loop to reorder the rest
            for ($o = $forum_order; $o < $default; $o++) {

                //Find the Child of the new parent whose order was the submitted one
                foreach ($children as $ch => $chv) {

                    if ($chv[$edit_field] == $o) {

                        $orderfid = $chv['fid'];
                    }
                }

                $neworder = $o + 1;

                $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                            SET " . $edit_field . " = '$neworder'
                            WHERE fid = '$orderfid'
                            LIMIT 1", false);

                if (mysql_affected_rows($conn) < 1) {

                    reporterror($l['create_forum_error'], $l['updating_new_forums_parents']);

                    return false;
                }

            }
        }

        //Store that this code was successful
        $AEF_SESS['postcode'][] = $postedcode;

        //Redirect
        redirect('act=admin&adact=forums');

        return true;
    } else {

        //Calling the theme file
        $theme['call_theme_func'] = 'createforum_theme';
    }
}

function ajax_getneworder() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $children;

    if (!(isset($_GET['motherforum'])) || trim($_GET['motherforum']) == "") {

        return false;
    } else {

        $motherforumid = inputsec(htmlizer(trim($_GET['motherforum'])));
    }

    if (!default_of_nor(false, false)) {

        return false;
    }

    $count = neworder($motherforumid) + 1;

    //Set the Buffering off
    $globals['stop_buffer_process'] = true;

    $theme['call_theme_func'] = 'ajax_getneworder_theme';

    return $count;
}

//End of function
////////////////////////////////////////
// Returns the Number of boards in the
// given parent / mother.
////////////////////////////////////////

function neworder($motherforumid) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $children;

    $children = array();

    //If the mother is a Category.
    if (preg_match('/c/i', $motherforumid)) {

        foreach ($forums as $c => $cv) {

            //The main forum loop
            foreach ($forums[$c] as $f => $v) {

                //If the category id mathces and it is not a In board
                if ('c' . $forums[$c][$f]['cat_id'] == $motherforumid &&
                        !($forums[$c][$f]['in_board'])) {

                    $children[$forums[$c][$f]['fid']] = $forums[$c][$f];
                }
            }
        }//End of main loop
        //It is a inboard
    } elseif (preg_match('/i/i', $motherforumid)) {

        //Beneath all VARS are to handle and store the IN_Boards of the Parent forum
        $its_in_boards = array();

        $its_board_level = 0;

        $trap_in = false;

        //This is to find which forum is it that the user is viewing
        foreach ($forums as $c => $cv) {

            //The main forum loop
            foreach ($forums[$c] as $f => $v) {

                if ($forums[$c][$f]['board_level'] == $its_board_level ||
                        $forums[$c][$f]['board_level'] < $its_board_level) {

                    $trap_in = false;
                }

                if ($trap_in) {

                    $its_in_boards[] = $forums[$c][$f];
                }

                if ('i' . $forums[$c][$f]['fid'] == $motherforumid) {

                    $board = $forums[$c][$f];

                    $cat = $c;

                    $its_board_level = $forums[$c][$f]['board_level'];

                    $trap_in = true;
                }
            }
        }//End of main loop
        //Board Level to trap
        $the_board_level = $its_board_level + 1;
        $its_in_boards_count = count($its_in_boards);

        //A final loop
        for ($i = 0; $i < $its_in_boards_count; $i++) {

            if ($its_in_boards[$i]['board_level'] == $the_board_level) {

                $children[$its_in_boards[$i]['fid']] = $its_in_boards[$i];
            }
        }
    }//End of IF...ELSEIF Condition

    return count($children);
}

//End of Function
//Deletes a forum
function deleteforum() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $board, $samelevel, $mother_options, $mother_options_in, $error, $postcodefield;


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $fid = 0;

    $board = array();

    $error = array();

    $samelevel = array();

    $postcodefield = '';

    $mother_options = array();

    $mother_options_in = array();

    $forum_ids = array();

    $deltop = 0;

    $shifttopto = 0;

    $shiftinto = '';


    //Get the forums ID
    if (isset($_GET['forum']) && trim($_GET['forum']) !== "" && is_numeric(trim($_GET['forum']))) {

        $fid = (int) inputsec(htmlizer(trim($_GET['forum'])));
    } else {

        //Show a major error and return
        reporterror($l['no_forum'], $l['no_forum_delete']);

        return false;
    }


    //Get the categories and forums
    if (!default_of_nor(false, false)) {

        return false;
    }

    //Beneath all VARS are to handle and store the IN_Boards of the editing forum
    $its_in_boards = array();

    $its_board_level = 0;

    $trap_in = false;

    //This is to find which forum is it that the user is viewing
    foreach ($forums as $c => $cv) {

        //The main forum loop
        foreach ($forums[$c] as $f => $v) {

            if ($forums[$c][$f]['fid'] == $fid) {

                $board = $forums[$c][$f];
            }
        }
    }//End of main loop


    if (empty($board)) {

        //Show a major error and return
        reporterror($l['no_forum_found'], $l['no_forum_found_exp']);

        return false;
    }


    /////////////////////////////////////
    // Find the mothers that can be given
    // For the inboards
    /////////////////////////////////////

    foreach ($categories as $c => $cv) {

        $mother_options[] = array('c' . $categories[$c]['cid'], $categories[$c]['name']);

        if (isset($forums[$c])) {

            foreach ($forums[$c] as $f => $fv) {

                $dasher = "";

                for ($t = 0; $t < $forums[$c][$f]['board_level']; $t++) {

                    $dasher .= "&nbsp;&nbsp;&nbsp;&nbsp;";
                }

                $matched = false;

                foreach ($its_in_boards as $i => $iv) {

                    if ($forums[$c][$f]['fid'] == $its_in_boards[$i]['fid']) {

                        $matched = true;
                    }
                }

                if ($forums[$c][$f]['fid'] != $board['fid'] && !$matched) {

                    $mother_options[] = array('i' . $forums[$c][$f]['fid'],
                        $dasher . '|--' . $forums[$c][$f]['fname']);
                }
            }
        }
    }



    //Lets Process
    if (isset($_POST['deleteforum'])) {

        /* //Will be added in next versions
          //Are we to delete or shift
          if(!(isset($_POST['deltop'])) || (trim($_POST['deltop']) == "")){

          $error[] = 'Are we to Delete or Shift the Topics.';

          }else{

          $deltop = (int) inputsec(htmlizer(trim($_POST['deltop'])));

          if(!in_array($deltop, array(1, 2))){

          $error[] = 'The Delete/Shift Topic option is Invalid.';

          }

          }


          //on error call the form
          if(!empty($error)){
          $theme['call_theme_func'] = 'deleteforum_theme';
          return false;
          }



          if($deltop == 2){

          //Are we to delete or shift
          if(!(isset($_POST['shifttopto'])) || (trim($_POST['shifttopto']) == "")){

          $error[] = 'The forum to which the topics are to be shifted was not submitted.';

          }else{

          $shifttopto =(int)inputsec(htmlizer(trim($_POST['shifttopto'])));

          if(!in_array($shifttopto, $forum_ids)){

          $error[] = 'The forum to which the topics are to be shifted is Invalid.';

          }

          }

          }

          //on error call the form
          if(!empty($error)){
          $theme['call_theme_func'] = 'deleteforum_theme';
          return false;
          }
         */

        if (!empty($board['in_boards'])) {

            //Are we to delete or shift
            if (!(isset($_POST['shiftinto'])) || (trim($_POST['shiftinto']) == "")) {

                $error[] = $l['no_in_boards_shifted'];
            } else {

                $shiftinto = inputsec(htmlizer(trim($_POST['shiftinto'])));

                //If the mother is a Category.
                if (preg_match('/c/i', $shiftinto)) {

                    //The New Category ID
                    $cat_id = (int) substr($shiftinto, 1);

                    $par_board_id = 0;

                    if (!in_array($cat_id, array_keys($categories))) {

                        $error[] = $l['parent_category_invalid'];
                    }

                    //Oh so you want to make it a In Board
                } elseif (preg_match('/i/i', $shiftinto)) {

                    //The New parent board ID
                    $par_board_id = (int) substr($shiftinto, 1);

                    //This is to find which forum is it that the user is viewing
                    foreach ($forums as $c => $cv) {

                        //The main forum loop
                        foreach ($forums[$c] as $f => $v) {

                            if ($forums[$c][$f]['fid'] == $par_board_id) {

                                $cat_id = $c;

                                break 2;
                            }
                        }
                    }//End of main loop

                    if (empty($cat_id)) {

                        $error[] = $l['parent_forum_invalid'];
                    }
                }
            }

            //on error call the form
            if (!empty($error)) {
                $theme['call_theme_func'] = 'deleteforum_theme';
                return false;
            }

            //A dummy to just insert in the end(Will be proper when parent is reordered)
            $forum_order = 10000;

            foreach ($board['in_boards'] as $k => $v) {

                //UPDATE the In-Boards
                $qresult = makequery("UPDATE " . $dbtables['forums'] . " SET
                            par_board_id = '$par_board_id',
                            cat_id = '$cat_id',
                            forum_order = '$forum_order'
                            WHERE fid = '" . $board['in_boards'][$k]['fid'] . "'
                            LIMIT 1", false);

                $forum_order = $forum_order + 1;
            }

            //Reorder those Children
            reorderchildren($par_board_id, $cat_id);
        }

        //////////////////
        //Now lets DELETE
        //////////////////

        if (!delete_forums(array($fid))) {

            //Show a major error and return
            reporterror($l['delete_forum_error'], $l['errors_deleting']);

            return false;
        }

        //Finally Just reorder the parent
        reorderchildren($board['par_board_id'], $board['cat_id']);

        //Redirect
        redirect('act=admin&adact=forums');

        return true;
    } else {

        //Calling the theme file
        $theme['call_theme_func'] = 'deleteforum_theme';
    }
}

//Function to reorder the smileys
function forumreorder() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $mother_options, $reoforums, $error;

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $error = array();

    $forumreordered = array();

    $reoforums = array();


    if (!default_of_nor(false, false)) {

        return false;
    }


    /////////////////////////////////////
    // Find the Parents that can be given
    /////////////////////////////////////

    foreach ($categories as $c => $cv) {

        if (isset($forums[$c])) {

            $mother_options[] = array('c' . $categories[$c]['cid'], $categories[$c]['name']);

            foreach ($forums[$c] as $f => $fv) {

                $dasher = "";

                for ($t = 0; $t < $forums[$c][$f]['board_level']; $t++) {

                    $dasher .= "&nbsp;&nbsp;&nbsp;&nbsp;";
                }

                $mother_options[] = array('i' . $forums[$c][$f]['fid'],
                    $dasher . '|--' . $forums[$c][$f]['fname']);
            }
        }
    }


    //Is the parent selected
    if (isset($_GET['parent']) && trim($_GET['parent']) != "") {

        $parent_ = $parent = inputsec(htmlizer(trim($_GET['parent'])));

        //If the mother is a Category.
        if (preg_match('/c/i', $parent)) {

            //The Parent ID
            $parent = (int) substr($parent, 1);

            if (empty($forums[$parent]) || count($forums[$parent]) < 2) {

                $error[] = $l['parent_insufficient_children'];
            } else {

                foreach ($forums[$parent] as $k => $v) {

                    //Only 0 level boards
                    if ($forums[$parent][$k]['board_level'] == 0) {

                        $reoforums[$forums[$parent][$k]['fid']] = $forums[$parent][$k]['fname'];
                    }
                }
            }

            //Oh so you want to make it a In Board
        } elseif (preg_match('/i/i', $parent)) {

            //The Parent ID
            $parent = (int) substr($parent, 1);

            //This is to find which parent is required
            foreach ($forums as $c => $cv) {

                //The main forum loop
                foreach ($forums[$c] as $f => $v) {

                    if ($forums[$c][$f]['fid'] == $parent) {

                        $board = $forums[$c][$f];
                    }
                }
            }//End of main loop

            if (empty($board) || empty($board['in_boards']) || count($board['in_boards']) < 2) {

                $error[] = $l['parent_insufficient_children'];
            } else {

                foreach ($board['in_boards'] as $k => $v) {

                    $reoforums[$board['in_boards'][$k]['fid']] = $board['in_boards'][$k]['fname'];
                }
            }
        }
    }


    if (isset($_POST['forumreorder'])) {

        //Check the code
        if (empty($_POST['for']) || !is_array($_POST['for'])) {

            $error[] = $l['no_forum_order'];
        } else {

            $forumreordered = $_POST['for'];

            if (count($forumreordered) != count($reoforums)) {

                $error[] = $l['forum order_incorrect'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'forumreorder_theme';
            return false;
        }

        foreach ($forumreordered as $k => $v) {

            //Was every key correct
            if (!in_array($k, array_keys($reoforums))) {

                $error[] = $l['forums_reordering_invalid'];

                break;
            }

            $forumreordered[$k] = (int) $v;
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'forumreorder_theme';
            return false;
        }


        if (count(array_unique($forumreordered)) != count($reoforums)) {

            $error[] = $l['forum order_incorrect'];
        }

        //r_print($forumreordered);
        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'forumreorder_theme';
            return false;
        }

        //r_print($forumreordered);

        foreach ($forumreordered as $k => $v) {

            $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                        SET `forum_order` = '$v'
                        WHERE fid = '$k'", false);
        }

        //Redirect
        redirect('act=admin&adact=forums&seadact=forumreorder&parent=' . $parent_);

        return true;
    } else {

        $theme['call_theme_func'] = 'forumreorder_theme';
    }
}

/* What each function does:-

  function default_of() -
  Removes and Puts all the catgories in an array $categories and
  all its boards whether a particular Category has a board or not
  in an array $forums according to the order of the category.
  So the fianl array of all the boards looks like $forums[$o].
  Also the inboards are Spliced after the Parent Board in order.
  All boards are HAVING INDEXES of the form $forums[$o][fid.id] (No dot).

  function ajax_getneworder() -
  This function will return the number of Boards a Parent has
  and will add one by default as this will be to add a
  new Board to the SUBMITTED Parent.
  It is basically used for handling AJAX and uses function neworder()
  to calculate the order.

  function neworder() -
  This function will return the number of Boards a Parent has
  and will add one by default as this will be to add a
  new Board to the SUBMITTED Parent.
  It will be used by the AJAX handling function and
  the EDIT and CREATE Forum Functions to check the SUBMITTED ORDER
  of the SUBMITTED PARENT.

 */
?>
