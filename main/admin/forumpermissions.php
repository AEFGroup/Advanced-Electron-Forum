<?php

//////////////////////////////////////////////////////////////
//===========================================================
// forumpermissions.php
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

function forumpermissions() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    if (!load_lang('admin/forumpermissions')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'admin/forumpermissions';

    //The name of the Page
    $theme['init_theme_name'] = 'Admin Center - Manage Forum Permissions';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('fpermissions_global',
        'fpermissionsmanage_theme',
        'editfpermissions_theme',
        'createfpermissions_theme');

    //My activity
    $globals['last_activity'] = 'afp';


    //If a second Admin act is set then go by that
    if (isset($_GET['seadact']) && trim($_GET['seadact']) !== "") {

        $seadact = inputsec(htmlizer(trim($_GET['seadact'])));
    } else {

        $seadact = "";
    }

    //The switch handler
    switch ($seadact) {

        //The form for editing a Category
        case 'editfpermissions':
            editfpermissions();
            break;

        //The form for creating a new Category
        case 'createfpermissions':
            createfpermissions();
            break;

        default :
            fpermissionsmanage();
            //Calling the theme file
            $theme['call_theme_func'] = 'fpermissionsmanage_theme';
            break;
    }
}

function fpermissionsmanage() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $fpermissions;

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $fpermissions = array();


    if (!default_of_nor(true, false)) {

        return false;
    }


    ///////////////////////////////////
    // Get the whole forum permissions
    ///////////////////////////////////

    $qresult = makequery("SELECT fp.*, ug.mem_gr_name
						FROM " . $dbtables['forumpermissions'] . " fp
						LEFT JOIN " . $dbtables['user_groups'] . " ug ON (ug.member_group = fp.fpugid)", true);

    if (mysql_num_rows($qresult) > 0) {

        for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

            $row = mysql_fetch_assoc($qresult);

            $fpermissions[$row['fpfid']][$row['fpugid']] = $row;
        }
    }

    //Free the resources
    @mysql_free_result($qresult);

    return true;
}

function editfpermissions() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $fpermissions, $fpfid, $fpugid;

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $fpfid = 0;

    $fpugid = 0;

    $can_post_topic = 0;

    $can_reply = 0;

    $can_vote_polls = 0;

    $can_post_polls = 0;

    $can_attach = 0;

    $can_view_attach = 0;

    //Is the forum id specified
    if (isset($_GET['fpfid']) && trim($_GET['fpfid']) !== "" && is_numeric(trim($_GET['fpfid']))) {

        $fpfid = (int) inputsec(htmlizer(trim($_GET['fpfid'])));
    } else {

        //Show a major error and return
        reporterror($l['no_forum'], $l['no_forum_exp']);

        return false;
    }


    //Is the user group id specified
    if (isset($_GET['fpug']) && trim($_GET['fpug']) !== "" && is_numeric(trim($_GET['fpug']))) {

        $fpugid = (int) inputsec(htmlizer(trim($_GET['fpug'])));
    } else {

        //Show a major error and return
        reporterror($l['no_user_group'], $l['no_user_group_exp']);

        return false;
    }


    //Load all the permissions
    if (!fpermissionsmanage()) {

        //Show a major error and return
        reporterror($l['processing_problem'], $l['processing_problem_exp']);

        return false;
    }


    //Is the submitted user group valid
    if (empty($fpermissions[$fpfid][$fpugid])) {

        //Show a major error and return
        reporterror($l['invalid_user_group'], lang_vars($l['invalid_user_group_exp'], array($fpfid, $fpugid)));

        return false;
    }


    //Alright lets process
    if (isset($_POST['editfpermissions'])) {

        //Start Topics
        if (isset($_POST['can_post_topic'])) {

            $can_post_topic = 1;
        }


        //Reply to Topics
        if (isset($_POST['can_reply'])) {

            $can_reply = 1;
        }


        //Vote in Poll
        if (isset($_POST['can_vote_polls'])) {

            $can_vote_polls = 1;
        }


        //Start Polls
        if (isset($_POST['can_post_polls'])) {

            $can_post_polls = 1;
        }


        //Attach Files
        if (isset($_POST['can_attach'])) {

            $can_attach = 1;
        }


        //Can download Attachments
        if (isset($_POST['can_view_attach'])) {

            $can_view_attach = 1;
        }


        //////////////////////////////////////////////
        // Finally lets UPDATE the Forum Permissions
        //////////////////////////////////////////////	

        $qresult = makequery("UPDATE " . $dbtables['forumpermissions'] . "
					SET	can_post_topic = '$can_post_topic',
					can_reply = '$can_reply',
					can_vote_polls = '$can_vote_polls',
					can_post_polls = '$can_post_polls',
					can_attach = '$can_attach',
					can_view_attach = '$can_view_attach'
					WHERE fpfid = '$fpfid'
					AND fpugid = '$fpugid'
					LIMIT 1", false);

        /* if(mysql_affected_rows($conn) < 1){

          reporterror('Edit Forum Error' ,'There were some errors in updating the submitted information of the forum <b>'.$board['fname'].'</b>.');

          return false;

          } */

        //Free the resources
        @mysql_free_result($qresult);


        //Redirect
        redirect('act=admin&adact=fpermissions');

        return true;
    } elseif (isset($_POST['deletefpermissions'])) {


        //////////////////////////////////////
        // Lets DELETE the Forum Permissions
        //////////////////////////////////////	

        $qresult = makequery("DELETE FROM " . $dbtables['forumpermissions'] . "
					WHERE fpfid = '$fpfid'
					AND fpugid = '$fpugid'
					LIMIT 1", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['del_perm_error'], $l['del_perm_error_exp']);

            return false;
        }

        //Free the resources
        @mysql_free_result($qresult);

        //Redirect
        redirect('act=admin&adact=fpermissions');

        return true;
    } else {

        //Calling the theme file
        $theme['call_theme_func'] = 'editfpermissions_theme';
    }
}

function createfpermissions() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $fpermissions, $fpfid, $fpugid, $categories, $forums, $user_group, $error, $mother_options;

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $fpfid = 0;

    $fpugid = 0;

    $can_post_topic = 0;

    $can_reply = 0;

    $can_vote_polls = 0;

    $can_post_polls = 0;

    $can_attach = 0;

    $can_view_attach = 0;

    $error = array();

    $mother_options = array();

    $forum_ids = array();

    $valid_ug = array();


    //Load all the permissions
    if (!fpermissionsmanage()) {

        //Show a major error and return
        reporterror($l['processing_problem'], $l['processing_problem_exp']);

        return false;
    }


    /////////////////////////////////////
    // Find the Forums that can be given
    /////////////////////////////////////

    foreach ($categories as $c => $cv) {

        if (isset($forums[$c])) {

            foreach ($forums[$c] as $f => $fv) {

                $dasher = "";

                for ($t = 1; $t < $forums[$c][$f]['board_level']; $t++) {

                    $dasher .= "&nbsp;&nbsp;&nbsp;&nbsp;";
                }

                $mother_options[] = array($forums[$c][$f]['fid'],
                    $dasher . (($forums[$c][$f]['board_level'] != 0) ? '|--' : '') . $forums[$c][$f]['fname']);

                $forum_ids[] = $forums[$c][$f]['fid'];
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


    $valid_ug = array_keys($user_group);


    //Alright lets process
    if (isset($_POST['createfpermissions'])) {


        //Check the Forum is set
        if (!(isset($_POST['fpfid'])) || (trim($_POST['fpfid']) == "")) {

            $error[] = $l['no_forum_posted'];
        } else {

            $fpfid = (int) inputsec(htmlizer(trim($_POST['fpfid'])));

            if (!in_array($fpfid, $forum_ids)) {

                $error[] = $l['invalid_forum_posted'];
            }
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'createfpermissions_theme';
            return false;
        }


        //Check the User Group is set
        if (!(isset($_POST['fpugid'])) || (trim($_POST['fpugid']) == "")) {

            $error[] = $l['no_group_posted'];
        } else {

            $fpugid = (int) inputsec(htmlizer(trim($_POST['fpugid'])));


            //Check is the user group already created
            if (!empty($fpermissions[$fpfid][$fpugid])) {

                $error[] = $l['group_perm_created'];
            }

            if (!in_array($fpugid, $valid_ug)) {

                $error[] = $l['user_group_invalid'];
            }
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'createfpermissions_theme';
            return false;
        }


        //Start Topics
        if (isset($_POST['can_post_topic'])) {

            $can_post_topic = 1;
        }


        //Reply to Topics
        if (isset($_POST['can_reply'])) {

            $can_reply = 1;
        }


        //Vote in Poll
        if (isset($_POST['can_vote_polls'])) {

            $can_vote_polls = 1;
        }


        //Start Polls
        if (isset($_POST['can_post_polls'])) {

            $can_post_polls = 1;
        }


        //Attach Files
        if (isset($_POST['can_attach'])) {

            $can_attach = 1;
        }


        //Can download Attachments
        if (isset($_POST['can_view_attach'])) {

            $can_view_attach = 1;
        }


        //////////////////////////////////////////////
        // Finally lets INSERT the Forum Permissions
        //////////////////////////////////////////////	

        $qresult = makequery("INSERT INTO " . $dbtables['forumpermissions'] . "
					SET	can_post_topic = '$can_post_topic',
					can_reply = '$can_reply',
					can_vote_polls = '$can_vote_polls',
					can_post_polls = '$can_post_polls',
					can_attach = '$can_attach',
					can_view_attach = '$can_view_attach',
					fpfid = '$fpfid',
					fpugid = '$fpugid'", true);


        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['create_perm_error'], $l['create_perm_error_exp']);

            return false;
        }

        //Free the resources
        @mysql_free_result($qresult);


        //Redirect
        redirect('act=admin&adact=fpermissions');

        return true;
    } else {

        //Calling the theme file
        $theme['call_theme_func'] = 'createfpermissions_theme';
    }
}

?>
