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
    $theme['init_theme_func'] = array('fpermissionsmanage_theme');

    //My activity
    $globals['last_activity'] = 'afp';


    //If a scandir(directory)econd Admin act is set then go by that
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

        default :
            fpermissionsmanage();
            //Calling the theme file
            $theme['call_theme_func'] = 'fpermissionsmanage_theme';
            break;
    }
}

function fpermissionsmanage($forum_id = NULL) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $fpermissions, $user_group, $fpfid, $fpugid;

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////
    if (!membergroups()) {

        //Show a major error and return
        reporterror($l['ugr_no_ugroups'], $l['ugr_no_ugroups_found']);

        return false;
    }
    $fpermissions = array();


    if (!default_of_nor(true, false)) {

        return false;
    }
    if(!is_null($forum_id)){
        $fpfid = (int) $forum_id;
    }else{
        $fpfid = (int) inputsec(htmlizer(trim($_GET['forum'])));    
    }
    

    ///////////////////////////////////
    // Get the whole forum permissions
    ///////////////////////////////////

    $qresult = makequery("SELECT fp.*, ug.*
                        FROM " . $dbtables['forumpermissions'] . " AS fp 
                        LEFT JOIN " . $dbtables['user_groups'] . " AS ug ON (ug.member_group = fp.fpugid)
                        WHERE fp.fpfid = '" . $fpfid . "'", true);

    if (mysql_num_rows($qresult) > 0) {

        for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

            $row = mysql_fetch_assoc($qresult);

            $fpermissions[$row['fpfid']][$row['fpugid']] = $row;

        }
    }

    //Free the resources
    mysql_free_result($qresult);
    return true;
}

function editfpermissions() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $fpermissions, $fpfid, $fpugid;

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////
    $can_post_topic = 0;
    $can_reply = 0;
    $can_vote_polls = 0;
    $can_post_polls = 0;
    $can_attach = 0;
    $can_view_attach = 0;
    
        //Is the forum id specified
        if (isset($_POST['forum_id']) && trim($_POST['forum_id']) !== "" && is_numeric(trim($_POST['forum_id']))) {

            $fpfid = (int) inputsec(htmlizer(trim($_POST['forum_id'])));
        } else {

            //Show a major error and return
            reporterror($l['no_forum'], $l['no_forum_exp']);

            return false;
        }


        //Is the user group id specified
        if (isset($_POST['group_id']) && trim($_POST['group_id']) !== "" && is_numeric(trim($_POST['group_id']))) {

            $fpugid = (int) inputsec(htmlizer(trim($_POST['group_id'])));
        } else {

            //Show a major error and return
            reporterror($l['no_user_group'], $l['no_user_group_exp']);

            return false;
        }


        //Load all the permissions
        if (!fpermissionsmanage($fpfid)) {

            //Show a major error and return
            reporterror($l['processing_problem'], $l['processing_problem_exp']);

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
            
            //Is the submitted user group valid
            if (empty($fpermissions[$fpfid][$fpugid])) {
                //Create new forum Permissions !
                $qresult = makequery("INSERT INTO " . $dbtables['forumpermissions'] . "
                    SET    can_post_topic = '$can_post_topic',
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
                //Redirect
                redirect('act=admin&adact=fpermissions&forum='.$fpfid);

                return true;
            }

            //////////////////////////////////////////////
            // Finally lets UPDATE the Forum Permissions
            //////////////////////////////////////////////

            $qresult = makequery("UPDATE " . $dbtables['forumpermissions'] . "
                    SET    can_post_topic = '$can_post_topic',
                    can_reply = '$can_reply',
                    can_vote_polls = '$can_vote_polls',
                    can_post_polls = '$can_post_polls',
                    can_attach = '$can_attach',
                    can_view_attach = '$can_view_attach'
                    WHERE fpfid = '$fpfid'
                    AND fpugid = '$fpugid'
                    LIMIT 1", false);

            //Redirect
            redirect('act=admin&adact=fpermissions&forum='.$fpfid);

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

            //Redirect
            redirect('act=admin&adact=fpermissions&forum='.$fpfid);

            return true;
        }
    
}