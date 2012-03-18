<?php

//////////////////////////////////////////////////////////////
//===========================================================
// active.php
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

//////////////////////////////////
// The online people on the board
//////////////////////////////////
//////////////////////////////////////////////
// Activity abbreveiations meanings
// l - login
// r - registeration
// mi - Main Index
// f - Viewing forum
// t - Viewing a topic
// taf - Emailing a topic
// nt - New Topic
// nr - New Reply
// pp - post a poll
// ep - edit a poll
// er - edit a reply
// mp - merge posts
// et - edit topic
// dt - delete topic(s)
// dr - delete reply/replies
// mt - Move Topic
// met - MErge Topics
// lt - lock/unlock topic(s)
// pt - pin/unpin topic(s)
// ai - Admin Center Index
// ac - Admin Center Categories
// af - Admin Center Forums
// afp - Admin Center Forum Permissions
// amod - Admin Center Moderators
// arb - Admin Center Recycle Bin
// atpp - Admin Center Topics, Posts and Poll settings
// aus - Admin Center User Settings
// arl - Admin Center Registration & Login Set
// aapp - Admin Center Manage Approvals
// aatt - Admin Center Attachment Settings
// aug - Admin Center Manage User Groups
// acp - Admin Ceter Control Panel
// ask - Admin Ceter Skin Manager
// ucp - Using the User CP
// up - Unread Posts
// pro - Viewing Profile of username
// acl - Active Users list
// s - Search
// ml - Member List
// st - Board Statistics
// bu - Ban user
// ubu - UnBan user
// du - Delete user
// edpro - Edit profile of
// subn - Submit News
// editn - Edit News
// news - Seeing the news
// rp - Report Posts
//////////////////////////////////////////////


function active() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $active, $count, $tree;

    //Load the Language File
    if (!load_lang('active')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'active';

    //The name of the Page
    $theme['init_theme_name'] = 'Active Users Theme';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('active_theme');


    /////////////////////////////////////////
    //This section is only for permitted users
    if (!$user['view_active']) {

        //Show a major error and return
        reporterror($l['cant_view_active_title'], $l['cant_view_active']);

        return false;
    }
    /////////////////////////////////////////
    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $active = array();

    $tree = array(); //Board tree for users location
    $tree[] = array('l' => $globals['index_url'],
        'txt' => $l['index']);
    $tree[] = array('l' => $globals['index_url'] . 'act=active',
        'txt' => $l['active_users'],
        'prefix' => $l['viewing_prefix_acl']);

    //He is viewing unread posts
    $globals['last_activity'] = 'acl';

    //Checks the Page to see
    $page = get_page('acpg', $globals['maxactivelist']);

    //Active time limit
    $activetime = time() - ($globals['last_active_span'] * 60);

    //Get the Number of pages that can be formed
    $qresult = makequery("SELECT COUNT(*) AS pages
                FROM " . $dbtables['sessions'] . " s
                LEFT JOIN " . $dbtables['users'] . " u ON (s.uid = u.id)
                LEFT JOIN " . $dbtables['forums'] . " f ON (f.fid = s.viewing_board)
                LEFT JOIN " . $dbtables['topics'] . " t ON (t.tid = s.viewing_topic)
                WHERE s.time > '$activetime'
                GROUP BY s.uid, s.ip");

    $count = mysql_num_rows($qresult);

    //Free the resources
    mysql_free_result($qresult);

    //Get the Pids of the page.
    $qresult = makequery("SELECT s.uid, s.time, s.ip, s.last_activity, s.activity, s.anonymous,
                u.id, u.username, t.tid, t.topic, f.fid, f.fname, ug.mem_gr_colour
                FROM " . $dbtables['sessions'] . " s
                LEFT JOIN " . $dbtables['users'] . " u ON (s.uid = u.id)
                LEFT JOIN " . $dbtables['forums'] . " f ON (f.fid = s.viewing_board)
                LEFT JOIN " . $dbtables['topics'] . " t ON (t.tid = s.viewing_topic)
                LEFT JOIN " . $dbtables['user_groups'] . " ug ON (u.u_member_group = ug.member_group)
                WHERE s.time > '$activetime'
                GROUP BY s.uid, s.ip
                ORDER BY s.time DESC
                LIMIT $page, " . $globals['maxactivelist']);


    if (mysql_num_rows($qresult) < 1) {

        //If it is not the first page - then you specified an invalid link
        if ($page > 0) {

            //Show a major error and return
            reporterror($l['no_page_acl_title'], $l['no_page_acl']);

            return false;
        }

        //Lets bring out the list
    } else {

        for ($i = 0; $i < mysql_num_rows($qresult); $i++) {

            $row = mysql_fetch_assoc($qresult);

            //The time thingy
            $row['time'] = datify($row['time'], false, true, 'h:i:s A');

            $temp = explode('|', $row['activity']);

            //This is a slow update adjustment
            if ($logged_in && ($row['id'] == $user['id'])) {

                $row['last_activity'] = 'acl';
            }

            //What about the anonymous people
            if ($row['anonymous'] == 1 && !$user['view_anonymous']) {

                $row['username'] = $l['anonymous_username'];
                $row['id'] = 0;
            }

            //Check for Bots
            if ($row['uid'] < -100) {

                $botname = botname($row['uid']);

                if (!empty($botname)) {

                    $row['username'] = $botname;
                }
            }


            $act_id = $temp['0'];

            $act_text = (empty($temp['1']) ? '' : $temp['1']);

            unset($temp);

            switch ($row['last_activity']) {

                //Login
                case 'l':
                    $row['activity'] = $l['activity_login'];
                    break;

                //Registration
                case 'r':
                    $row['activity'] = $l['activity_registering'];
                    break;

                //Main Index
                case 'mi':
                    $row['activity'] = $l['activity_main_index'];
                    break;

                //Viewing forum
                case 'f':
                    $row['activity'] = lang_vars($l['activity_viewing_forum'], array($act_id, $act_text));
                    break;

                //Viewing topic
                case 't':
                    $row['activity'] = lang_vars($l['activity_viewing_topic'], array($act_id, $act_text));
                    break;

                //Telling a friend
                case 'taf':
                    $row['activity'] = lang_vars($l['activity_tell_a_friend'], array($act_id, $act_text));
                    break;

                //New Topic
                case 'nt':
                    $row['activity'] = lang_vars($l['activity_new_topic'], array($act_id, $act_text));
                    break;

                //New Reply
                case 'nr':
                    $row['activity'] = lang_vars($l['activity_new_reply'], array($act_id, $act_text));
                    break;

                //Posting a poll
                case 'pp':
                    $row['activity'] = lang_vars($l['activity_adding_poll'], array($act_id, $act_text));
                    break;

                //Editing a poll
                case 'ep':
                    $row['activity'] = lang_vars($l['activity_editing_poll'], array($act_id, $act_text));
                    break;

                //Editing a reply
                case 'er':
                    $row['activity'] = lang_vars($l['activity_editing_post'], array($act_id, $act_text));
                    break;

                //Merging posts
                case 'mp':
                    $row['activity'] = lang_vars($l['activity_merging_posts'], array($act_id, $act_text));
                    break;

                //Editing a topic
                case 'et':
                    $row['activity'] = lang_vars($l['activity_editing_topic'], array($act_id, $act_text));
                    break;

                //Deleing topic(s)
                case 'dt':
                    $row['activity'] = $l['activity_deleting_topic'];
                    break;

                //Deleing replies
                case 'dr':
                    $row['activity'] = $l['activity_deleting_post'];
                    break;

                //Moving topics
                case 'mt':
                    $row['activity'] = $l['activity_moving_topic'];
                    break;

                //Merging topics
                case 'met':
                    $row['activity'] = $l['activity_merging_topic'];
                    break;

                //lock/unlock topic
                case 'lt':
                    $row['activity'] = $l['activity_locking_topic'];
                    break;

                //pin/unpin topic
                case 'pt':
                    $row['activity'] = $l['activity_pinning_topic'];
                    break;

                //Admin Index
                case 'ai':
                    $row['activity'] = $l['activity_admin_index'];
                    break;

                //Admin Center Categories
                case 'ac':
                    $row['activity'] = $l['activity_editing_categories'];
                    break;

                //Admin Center forum
                case 'af':
                    $row['activity'] = $l['activity_editing_forums'];
                    break;

                //Admin Center Forum Permissions
                case 'afp':
                    $row['activity'] = $l['activity_forum_permissions'];
                    break;

                //Admin Center Moderators
                case 'amod':
                    $row['activity'] = $l['activity_moderators'];
                    break;

                //Admin Center Recycle Bin
                case 'arb':
                    $row['activity'] = $l['activity_recylebin'];
                    break;

                //Admin Center Topics, Posts and Poll settings
                case 'atpp':
                    $row['activity'] = $l['activity_tpp_settings'];
                    break;

                //Admin Center User settings
                case 'aus':
                    $row['activity'] = $l['activity_user_settings'];
                    break;

                //User CP
                case 'ucp':
                    $row['activity'] = $l['activity_user_cp'];
                    break;

                //Unread Posts
                case 'up':
                    $row['activity'] = $l['activity_unread'];
                    break;

                //Viewing profile
                case 'pro':
                    $row['activity'] = lang_vars($l['activity_viewing_profile'], array($act_id, $act_text));
                    break;

                //Viewing Active users list
                case 'acl':
                    $row['activity'] = $l['activity_active_users'];
                    break;

                //Admin Center Registration & Login Set
                case 'arl':
                    $row['activity'] = $l['activity_reg_log_settings'];
                    break;

                //Admin Center Manage Approvals
                case 'aapp':
                    $row['activity'] = $l['activity_approvals'];
                    break;

                //Admin Center Attachment Settings
                case 'aatt':
                    $row['activity'] = $l['activity_attach_settings'];
                    break;

                //Admin Center Manage User Groups
                case 'aug':
                    $row['activity'] = $l['activity_man_user_groups'];
                    break;

                //Admin Ceter Control Panel
                case 'acp':
                    $row['activity'] = $l['activity_admin_cp'];
                    break;

                //Admin Ceter Skin Manager
                case 'ask':
                    $row['activity'] = $l['activity_man_skins'];
                    break;

                //Search
                case 's':
                    $row['activity'] = $l['activity_searching'];
                    break;

                //Member List
                case 'ml':
                    $row['activity'] = $l['activity_member_list'];
                    break;

                //Ban user
                case 'bu':
                    $row['activity'] = $l['activity_banning'];
                    break;

                //UnBan user
                case 'ubu':
                    $row['activity'] = $l['activity_removing_ban'];
                    break;

                //Delete user
                case 'du':
                    $row['activity'] = $l['activity_deleting_user'];
                    break;

                //Edit profile of
                case 'edpro':
                    $row['activity'] = $l['activity_editing_user'];
                    break;

                //Submit News
                case 'subn':
                    $row['activity'] = $l['activity_submit_news'];
                    break;

                //Editing News
                case 'editn':
                    $row['activity'] = $l['activity_edit_news'];
                    break;

                //Seeing the news
                case 'news':
                    $row['activity'] = $l['activity_news'];
                    break;

                default:
                    $row['activity'] = $l['activity_default'];
                    break;
            }

            //Can he view ip addresses
            if (!$user['view_ip']) {

                unset($row['ip']);
            }

            $active[] = $row;
        }
    }

    $theme['call_theme_func'] = 'active_theme';
}

?>
