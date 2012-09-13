<?php

//////////////////////////////////////////////////////////////
//===========================================================
// usergroups.php(Admin)
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

function usergroups() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    if (!load_lang('admin/usergroups')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'admin/usergroups';

    //The name of the Page
    $theme['init_theme_name'] = 'Admin Center - Manage User Groups';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('manug_theme',
        'editug_theme',
        'addug_theme');

    //My activity
    $globals['last_activity'] = 'aug';


    //If a second Admin act is set then go by that
    if (isset($_GET['seadact']) && trim($_GET['seadact']) !== "") {

        $seadact = inputsec(htmlizer(trim($_GET['seadact'])));
    } else {

        $seadact = "";
    }


    //The switch handler
    switch ($seadact) {

        //The form for managing user groups
        default:
        case 'manug':
            manug();
            break;

        case 'editug':
            editug();
            break;

        case 'addug':
            addug();
            break;

        case 'delug':
            delug();
            break;
    }
}

//Function to show user groups
function manug() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $user_group, $post_group;

    if (!membergroups()) {

        //Show a major error and return
        reporterror($l['ugr_no_ugroups'], $l['ugr_no_ugroups_found']);

        return false;
    }

    $theme['call_theme_func'] = 'manug_theme';
}

//End of function
//Function to edit User Groups
function editug() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $error, $user_group;


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $error = array();

    $user_group = array();

    //User Group Settings
    $member_group = 0;

    $mem_gr_name = '';

    $mem_gr_colour = '';

    $post_count = 0;

    $image_name = '';

    $image_count = 0;

    //User Group Permissions
    $ugpermissions = array('view_forum' => 0,
        'can_post_topic' => 0,
        'can_reply' => 0,
        'can_edit_own_topic' => 0,
        'can_edit_other_topic' => 0,
        'can_edit_own' => 0,
        'can_edit_other' => 0,
        'approve_topics' => 0,
        'approve_posts' => 0,
        'can_del_own_post' => 0,
        'can_del_other_post' => 0,
        'can_search' => 0,
        'can_email_mem' => 0,
        'can_email_friend' => 0,
        'can_edit_own_profile' => 0,
        'can_edit_other_profile' => 0,
        'can_del_own_account' => 0,
        'can_del_other_account' => 0,
        'can_ban_user' => 0,
        'can_del_own_topic' => 0,
        'can_del_other_topic' => 0,
        'can_view_poll' => 0,
        'can_vote_polls' => 0,
        'can_post_polls' => 0,
        'can_edit_other_poll' => 0,
        'can_edit_own_poll' => 0,
        'add_poll_topic_own' => 0,
        'add_poll_topic_other' => 0,
        'can_rem_own_poll' => 0,
        'can_rem_other_poll' => 0,
        'can_merge_topics' => 0,
        'can_merge_posts' => 0,
        'can_split_topics' => 0,
        'can_email_topic' => 0,
        'can_make_sticky' => 0,
        'can_move_own_topic' => 0,
        'can_move_other_topic' => 0,
        'can_lock_own_topic' => 0,
        'can_lock_other_topic' => 0,
        'can_announce_topic' => 0,
        'can_report_post' => 0,
        'can_report_pm' => 0,
        'prefix' => '',
        'suffix' => '',
        'can_attach' => 0,
        'can_view_attach' => 0,
        'can_remove_attach' => 0,
        'max_attach' => '',
        'notify_new_posts' => 0,
        'notify_new_topics' => 0,
        'use_avatar' => 0,
        'url_avatar' => 0,
        'upload_avatar' => 0,
        'hide_online' => 0,
        'view_active' => 0,
        'view_anonymous' => 0,
        'allow_html' => 0,
        'has_priviliges' => 0,
        'view_ip' => 0,
        'can_admin' => 0,
        'can_use_pm' => 0,
        'max_stored_pm' => '',
        'max_mass_pm' => '',
        'view_offline_board' => 0,
        'can_view_profile' => 0,
        'view_members' => 0,
        'view_stats' => 0,
        'can_submit_news' => 0,
        'can_approve_news' => 0,
        'can_edit_news' => 0,
        'can_delete_news' => 0,
        'group_message' => '',
        'can_shout' => 0,
        'can_del_shout' => 0,
        'view_calendar' => 0
    );

    //The yes/no ones
    $ugpermissions_yn = array('view_forum' => 0,
        'can_post_topic' => 0,
        'can_reply' => 0,
        'can_edit_own_topic' => 0,
        'can_edit_other_topic' => 0,
        'can_edit_own' => 0,
        'can_edit_other' => 0,
        'approve_topics' => 0,
        'approve_posts' => 0,
        'can_del_own_post' => 0,
        'can_del_other_post' => 0,
        'can_search' => 0,
        'can_email_mem' => 0,
        'can_email_friend' => 0,
        'can_edit_own_profile' => 0,
        'can_edit_other_profile' => 0,
        'can_del_own_account' => 0,
        'can_del_other_account' => 0,
        'can_ban_user' => 0,
        'can_del_own_topic' => 0,
        'can_del_other_topic' => 0,
        'can_view_poll' => 0,
        'can_vote_polls' => 0,
        'can_post_polls' => 0,
        'can_edit_other_poll' => 0,
        'can_edit_own_poll' => 0,
        'add_poll_topic_own' => 0,
        'add_poll_topic_other' => 0,
        'can_rem_own_poll' => 0,
        'can_rem_other_poll' => 0,
        'can_merge_topics' => 0,
        'can_merge_posts' => 0,
        'can_split_topics' => 0,
        'can_email_topic' => 0,
        'can_make_sticky' => 0,
        'can_move_own_topic' => 0,
        'can_move_other_topic' => 0,
        'can_lock_own_topic' => 0,
        'can_lock_other_topic' => 0,
        'can_announce_topic' => 0,
        'can_report_post' => 0,
        'can_report_pm' => 0,
        'can_attach' => 0,
        'can_view_attach' => 0,
        'can_remove_attach' => 0,
        'notify_new_posts' => 0,
        'notify_new_topics' => 0,
        'use_avatar' => 0,
        'url_avatar' => 0,
        'upload_avatar' => 0,
        'hide_online' => 0,
        'view_active' => 0,
        'view_anonymous' => 0,
        'allow_html' => 0,
        'has_priviliges' => 0,
        'view_ip' => 0,
        'can_admin' => 0,
        'can_use_pm' => 0,
        'view_offline_board' => 0,
        'can_view_profile' => 0,
        'view_members' => 0,
        'view_stats' => 0,
        'can_submit_news' => 0,
        'can_approve_news' => 0,
        'can_edit_news' => 0,
        'can_delete_news' => 0,
        'can_shout' => 0,
        'can_del_shout' => 0,
        'view_calendar' => 0
    );

    //The text field ones
    $ugpermissions_inputtext = array('prefix' => '',
        'suffix' => '',
        'max_attach' => 0,
        'max_stored_pm' => 0,
        'max_mass_pm' => 0,
        'group_message' => ''
    );

    /* $qresult = makequery("SHOW COLUMNS FROM ".$dbtables['permissions']);

      if(mysql_num_rows($qresult) > 0){

      for($i = 0; $i < mysql_num_rows($qresult); $i++){

      $row = mysql_fetch_assoc($qresult);

      //echo $row['Field']." = '\".\$ugpermissions['".$row['Field']."'].\"',\n";
      echo '\''.$row['Field'].'\' => 0,'."\n";

      }

      } */


    if (isset($_GET['ugid']) && trim($_GET['ugid']) != '' && is_numeric(trim($_GET['ugid']))) {

        $member_group = (int) inputsec(htmlizer(trim($_GET['ugid'])));
    } else {

        //Redirect
        redirect('act=admin&adact=ug&seadact=manug');

        return false;
    }

    //Get the user group
    $qresult = makequery("SELECT ug.*, p.* FROM " . $dbtables['user_groups'] . " ug
                        LEFT JOIN " . $dbtables['permissions'] . " p ON
                                                        (ug.member_group = p.member_group_id)
                        WHERE member_group = '$member_group'");

    if (mysql_num_rows($qresult) < 1) {

        //Redirect
        redirect('act=admin&adact=ug&seadact=manug');

        return false;
    } else {

        $user_group = mysql_fetch_assoc($qresult);
    }

    if (isset($_POST['editug'])) {

        //Check the name
        if (!(isset($_POST['mem_gr_name'])) || (trim($_POST['mem_gr_name']) == "")) {

            $error[] = $l['ugr_no_ugroup_name'];
        } else {

            $mem_gr_name = inputsec(htmlizer(trim($_POST['mem_gr_name'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editug_theme';
            return false;
        }


        //Check the color
        if (isset($_POST['mem_gr_colour']) && (trim($_POST['mem_gr_colour']) != "")) {

            $mem_gr_colour = inputsec(htmlizer(trim($_POST['mem_gr_colour'])));
        }

        //Check the image file
        if (!(isset($_POST['image_name'])) || (trim($_POST['image_name']) == "")) {

            $error[] = $l['ugr_no_ugroup_image'];
        } else {

            $image_name = inputsec(htmlizer(trim($_POST['image_name'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editug_theme';
            return false;
        }


        //Check the image count
        if (!(isset($_POST['image_count'])) || (trim($_POST['image_count']) == "")) {

            $error[] = $l['ugr_no_ugroup_star'];
        } else {

            $image_count = inputsec(htmlizer(trim($_POST['image_count'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editug_theme';
            return false;
        }


        //Banned, Guests, Members, Admins, Moderators make a exception
        if (!in_array($user_group['member_group'], array(-3, -1, 0, 1, 3))) {

            //Is it post based
            if (isset($_POST['post_based'])) {

                //Check the post count
                if (!(isset($_POST['post_count'])) || (trim($_POST['post_count']) == "") || (trim($_POST['post_count']) == -1)) {

                    $error[] = $l['ugr_no_ugroup_post'];
                } else {

                    $post_count = inputsec(htmlizer(trim($_POST['post_count'])));
                }
            } else {

                $post_count = '-1';
            }
        } else {

            $post_count = '-1';
        }

        //If it is not based on post
        if ($post_count == -1) {

            //If it is not the admin permissions mask
            if ($member_group != 1) {

                //We have to process the permissions
                foreach ($ugpermissions_yn as $k => $v) {

                    //Is it a yes
                    if (isset($_POST[$k]) && trim($_POST[$k]) == 1) {

                        $ugpermissions[$k] = 1;
                    }
                }


                foreach ($ugpermissions_inputtext as $k => $v) {

                    //Take the value
                    if (isset($_POST[$k]) && trim($_POST[$k]) != "") {

                        $ugpermissions[$k] = inputsec(htmlizer(trim($_POST[$k])));
                    }
                }
            }
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editug_theme';
            return false;
        }

        /////////////////////////
        // UPDATE the User Groups
        /////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['user_groups'] . "
                        SET mem_gr_name = '$mem_gr_name',
                        mem_gr_colour = '$mem_gr_colour',
                        post_count = '$post_count',
                        image_name = '$image_name',
                        image_count = '$image_count'
                        WHERE member_group = '$member_group'", false);


        //We should not update the Admin permissions mask
        if ($member_group != 1) {

            $string = "";

            //Build the string
            foreach ($ugpermissions as $k => $v) {

                $string .= $k . " = '" . $v . "',";
            }

            $string = trim($string, ",");

            //What about the permissions
            //Make an update
            if ($user_group['post_count'] == -1 && $post_count == -1) {

                $qresult = makequery("UPDATE " . $dbtables['permissions'] . "
                            SET " . $string . "
                            WHERE member_group_id = '$member_group'", false);


                //Free the resources
                mysql_free_result($qresult);

                //DELETE the permissions set
            } elseif ($user_group['post_count'] == -1 && $post_count != -1) {

                deleteugper($member_group);

                //INSERT the permissions set
            } elseif ($user_group['post_count'] != -1 && $post_count == -1) {

                $qresult = makequery("INSERT INTO " . $dbtables['permissions'] . "
                            SET member_group_id = '$member_group',
                            " . $string);

                $member_group_id = mysql_insert_id($conn);

                if (empty($member_group_id)) {

                    //Show a major error and return
                    reporterror($l['ugr_error'], $l['ugr_errors_inserting_perms']);

                    return false;
                }

                //Free the resources
                mysql_free_result($qresult);
            }
        }//If condition for admin permissions mask
        //Redirect
        redirect('act=admin&adact=ug&seadact=manug');

        return true;
    } else {

        $theme['call_theme_func'] = 'editug_theme';
    }
}

//Justs deletes the permission set and also updates the members in that group to users
function deleteugper($ugid) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    //Delete the permission mask
    $qresult = makequery("DELETE FROM " . $dbtables['permissions'] . "
                    WHERE member_group_id = '$ugid'", false);

    //Free the resources
    mysql_free_result($qresult);


    //UPDATE the users in that group
    $qresult = makequery("UPDATE " . $dbtables['users'] . "
                        SET u_member_group = '0'
                        WHERE u_member_group = '$ugid'", false);


    //Free the resources
    mysql_free_result($qresult);
}

//Function to delete User Group
function delug() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;


    if (isset($_GET['ugid']) && trim($_GET['ugid']) != '' && is_numeric(trim($_GET['ugid']))) {

        $member_group = (int) inputsec(htmlizer(trim($_GET['ugid'])));
    } else {

        //Redirect
        redirect('act=admin&adact=ug&seadact=manug');

        return false;
    }

    //Get the user group
    $qresult = makequery("SELECT * FROM " . $dbtables['user_groups'] . "
                        WHERE member_group = '$member_group'");

    if (mysql_num_rows($qresult) < 1) {

        //Redirect
        redirect('act=admin&adact=ug&seadact=manug');

        return false;
    } else {

        $user_group = mysql_fetch_assoc($qresult);
    }

    //Now you cant delete certain groups
    if (!in_array($user_group['member_group'], array(-3, -1, 0, 1, 3))) {

        /////////////////////////
        // DELETE the User Group
        /////////////////////////

        $qresult = makequery("DELETE FROM " . $dbtables['user_groups'] . "
                        WHERE member_group = '$member_group'", false);


        //Free the resources
        mysql_free_result($qresult);

        //Does it have any permissions
        if ($user_group['post_count'] == -1) {

            deleteugper($member_group);
        }
    } else {

        //Show a major error and return
        reporterror($l['ugr_error'], $l['ugr_no_del_perm']);

        return false;
    }

    //Redirect
    redirect('act=admin&adact=ug&seadact=manug');

    return true;
}

//Function to add User Groups
function addug() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $error, $user_group;


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $error = array();

    $member_group = 0;

    $mem_gr_name = '';

    $mem_gr_colour = '';

    $post_count = 0;

    $image_name = '';

    $image_count = 0;

    //User Group Permissions
    $ugpermissions = array('view_forum' => 0,
        'can_post_topic' => 0,
        'can_reply' => 0,
        'can_edit_own_topic' => 0,
        'can_edit_other_topic' => 0,
        'can_edit_own' => 0,
        'can_edit_other' => 0,
        'approve_topics' => 0,
        'approve_posts' => 0,
        'can_del_own_post' => 0,
        'can_del_other_post' => 0,
        'can_search' => 0,
        'can_email_mem' => 0,
        'can_email_friend' => 0,
        'can_edit_own_profile' => 0,
        'can_edit_other_profile' => 0,
        'can_del_own_account' => 0,
        'can_del_other_account' => 0,
        'can_ban_user' => 0,
        'can_del_own_topic' => 0,
        'can_del_other_topic' => 0,
        'can_view_poll' => 0,
        'can_vote_polls' => 0,
        'can_post_polls' => 0,
        'can_edit_other_poll' => 0,
        'can_edit_own_poll' => 0,
        'add_poll_topic_own' => 0,
        'add_poll_topic_other' => 0,
        'can_rem_own_poll' => 0,
        'can_rem_other_poll' => 0,
        'can_merge_topics' => 0,
        'can_merge_posts' => 0,
        'can_split_topics' => 0,
        'can_email_topic' => 0,
        'can_make_sticky' => 0,
        'can_move_own_topic' => 0,
        'can_move_other_topic' => 0,
        'can_lock_own_topic' => 0,
        'can_lock_other_topic' => 0,
        'can_announce_topic' => 0,
        'can_report_post' => 0,
        'can_report_pm' => 0,
        'prefix' => '',
        'suffix' => '',
        'can_attach' => 0,
        'can_view_attach' => 0,
        'can_remove_attach' => 0,
        'max_attach' => '',
        'notify_new_posts' => 0,
        'notify_new_topics' => 0,
        'use_avatar' => 0,
        'url_avatar' => 0,
        'upload_avatar' => 0,
        'hide_online' => 0,
        'view_active' => 0,
        'view_anonymous' => 0,
        'allow_html' => 0,
        'has_priviliges' => 0,
        'view_ip' => 0,
        'can_admin' => 0,
        'can_use_pm' => 0,
        'max_stored_pm' => '',
        'max_mass_pm' => '',
        'view_offline_board' => 0,
        'can_view_profile' => 0,
        'view_members' => 0,
        'view_stats' => 0,
        'can_submit_news' => 0,
        'can_approve_news' => 0,
        'can_edit_news' => 0,
        'can_delete_news' => 0,
        'group_message' => '',
        'can_shout' => 0,
        'can_del_shout' => 0,
        'view_calendar' => 0
    );

    //The yes/no ones
    $ugpermissions_yn = array('view_forum' => 0,
        'can_post_topic' => 0,
        'can_reply' => 0,
        'can_edit_own_topic' => 0,
        'can_edit_other_topic' => 0,
        'can_edit_own' => 0,
        'can_edit_other' => 0,
        'approve_topics' => 0,
        'approve_posts' => 0,
        'can_del_own_post' => 0,
        'can_del_other_post' => 0,
        'can_search' => 0,
        'can_email_mem' => 0,
        'can_email_friend' => 0,
        'can_edit_own_profile' => 0,
        'can_edit_other_profile' => 0,
        'can_del_own_account' => 0,
        'can_del_other_account' => 0,
        'can_ban_user' => 0,
        'can_del_own_topic' => 0,
        'can_del_other_topic' => 0,
        'can_view_poll' => 0,
        'can_vote_polls' => 0,
        'can_post_polls' => 0,
        'can_edit_other_poll' => 0,
        'can_edit_own_poll' => 0,
        'add_poll_topic_own' => 0,
        'add_poll_topic_other' => 0,
        'can_rem_own_poll' => 0,
        'can_rem_other_poll' => 0,
        'can_merge_topics' => 0,
        'can_merge_posts' => 0,
        'can_split_topics' => 0,
        'can_email_topic' => 0,
        'can_make_sticky' => 0,
        'can_move_own_topic' => 0,
        'can_move_other_topic' => 0,
        'can_lock_own_topic' => 0,
        'can_lock_other_topic' => 0,
        'can_announce_topic' => 0,
        'can_report_post' => 0,
        'can_report_pm' => 0,
        'can_attach' => 0,
        'can_view_attach' => 0,
        'can_remove_attach' => 0,
        'notify_new_posts' => 0,
        'notify_new_topics' => 0,
        'use_avatar' => 0,
        'url_avatar' => 0,
        'upload_avatar' => 0,
        'hide_online' => 0,
        'view_active' => 0,
        'view_anonymous' => 0,
        'allow_html' => 0,
        'has_priviliges' => 0,
        'view_ip' => 0,
        'can_admin' => 0,
        'can_use_pm' => 0,
        'view_offline_board' => 0,
        'can_view_profile' => 0,
        'view_members' => 0,
        'view_stats' => 0,
        'can_submit_news' => 0,
        'can_approve_news' => 0,
        'can_edit_news' => 0,
        'can_delete_news' => 0,
        'can_shout' => 0,
        'can_del_shout' => 0,
        'view_calendar' => 0
    );

    //The text field ones
    $ugpermissions_inputtext = array('prefix' => '',
        'suffix' => '',
        'max_attach' => 0,
        'max_stored_pm' => 0,
        'max_mass_pm' => 0,
        'group_message' => ''
    );

    if (isset($_GET['ugid']) && trim($_GET['ugid']) != '' && is_numeric(trim($_GET['ugid']))) {

        $ugid = (int) inputsec(htmlizer(trim($_GET['ugid'])));
    } else {

        //Redirect
        redirect('act=admin&adact=ug&seadact=manug');

        return false;
    }


    //Get the user group
    $qresult = makequery("SELECT * FROM " . $dbtables['permissions'] . "
                        WHERE member_group_id = '$ugid'");

    if (mysql_num_rows($qresult) < 1) {

        //Redirect
        redirect('act=admin&adact=ug&seadact=manug');

        return false;
    } else {

        $user_group = mysql_fetch_assoc($qresult);
    }


    if (isset($_POST['addug'])) {

        //Check the name
        if (!(isset($_POST['mem_gr_name'])) || (trim($_POST['mem_gr_name']) == "")) {

            $error[] = $l['ugr_no_ugroup_name'];
        } else {

            $mem_gr_name = inputsec(htmlizer(trim($_POST['mem_gr_name'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'addug_theme';
            return false;
        }


        //Check the color
        if (isset($_POST['mem_gr_colour']) && (trim($_POST['mem_gr_colour']) != "")) {

            $mem_gr_colour = inputsec(htmlizer(trim($_POST['mem_gr_colour'])));
        }

        //Check the image file
        if (!(isset($_POST['image_name'])) || (trim($_POST['image_name']) == "")) {

            $error[] = $l['ugr_no_ugroup_image'];
        } else {

            $image_name = inputsec(htmlizer(trim($_POST['image_name'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'addug_theme';
            return false;
        }


        //Check the image count
        if (!(isset($_POST['image_count'])) || (trim($_POST['image_count']) == "")) {

            $error[] = $l['ugr_no_ugroup_star'];
        } else {

            $image_count = inputsec(htmlizer(trim($_POST['image_count'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'addug_theme';
            return false;
        }


        //Is it post based
        if (isset($_POST['post_based'])) {

            //Check the post count
            if (!(isset($_POST['post_count'])) || (trim($_POST['post_count']) == "")) {

                $error[] = $l['ugr_no_ugroup_post'];
            } else {

                $post_count = inputsec(htmlizer(trim($_POST['post_count'])));
            }
        } else {

            $post_count = '-1';
        }


        //If it is not based on post
        if ($post_count == -1) {

            //We have to process the permissions
            foreach ($ugpermissions_yn as $k => $v) {

                //Is it a yes
                if (isset($_POST[$k]) && trim($_POST[$k]) == 1) {

                    $ugpermissions[$k] = 1;
                }
            }


            foreach ($ugpermissions_inputtext as $k => $v) {

                //Take the value
                if (isset($_POST[$k]) && trim($_POST[$k]) != "") {

                    $ugpermissions[$k] = inputsec(htmlizer(trim($_POST[$k])));
                }
            }
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'addug_theme';
            return false;
        }


        /////////////////////////
        // INSERT the User Groups
        /////////////////////////

        $qresult = makequery("INSERT INTO " . $dbtables['user_groups'] . "
                        SET mem_gr_name = '$mem_gr_name',
                        mem_gr_colour = '$mem_gr_colour',
                        post_count = '$post_count',
                        image_name = '$image_name',
                        image_count = '$image_count'");


        $member_group = mysql_insert_id($conn);

        if (empty($member_group)) {

            //Show a major error and return
            reporterror($l['ugr_error'], $l['ugr_errors_inserting_perms']);

            return false;
        }

        //Free the resources
        mysql_free_result($qresult);


        //What about the permissions
        if ($post_count == -1) {

            $string = "";

            //Build the string
            foreach ($ugpermissions as $k => $v) {

                $string .= $k . " = '" . $v . "',";
            }

            $string = trim($string, ",");

            ////////////////////////////
            //INSERT the permissions set
            ////////////////////////////

            $qresult = makequery("INSERT INTO " . $dbtables['permissions'] . "
                        SET member_group_id = '$member_group',
                        " . $string);

            /* $member_group_id = mysql_insert_id($conn);

              if( empty($member_group_id) ){

              //Show a major error and return
              reporterror('Permissions' ,'There were some errors while inserting the Permission Mask.');

              return false;

              }

              //Free the resources
              mysql_free_result($qresult); */
        }

        //Redirect
        redirect('act=admin&adact=ug&seadact=manug');

        return true;
    } else {

        $theme['call_theme_func'] = 'addug_theme';
    }
}

?>
