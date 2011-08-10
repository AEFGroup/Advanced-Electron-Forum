<?php

//////////////////////////////////////////////////////////////
//===========================================================
// MainIndex.php
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

function MainIndex() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $active, $anonymous, $guests, $mostactive, $mostactive_ever, $inboards, $latest_mem, $active, $activebots, $tree, $pm, $newslinks, $online_today, $recent_posts, $user_groups;

    //Load the Language File
    if (!load_lang('MainIndex')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'MainIndex';

    //The name of the Page
    $theme['init_theme_name'] = 'Main Index';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('MainIndex_theme');


    //Have we got the boards and all
    if (default_of_nor()) {

        /////////////////////////////
        // Define the necessary VARS
        /////////////////////////////

        $active = array();

        $activebots = array();

        $anonymous = 0;

        $guests = 0;

        $online_today = array();

        //He is viewing the boards index
        $globals['last_activity'] = 'mi';

        $boardmoderators = array(); //Array of every board moderators

        $inboards = array(); //Array of every boards in_boards

        $visible_forums = array(); //Array of forum ids that are visible

        $recent_posts = array();

        $tree = array(); //Board tree for users location
        $tree[] = array('l' => $globals['index_url'],
            'txt' => $l['index']);

        ////////////////////////
        //Things to do
        // 1 - Unset the unecessary inboards
        // 2 - Calculate the page no. of
        //     every topic in a board
        // 3 - Make the moderators array
        // 4 - Make the in_board array
        // 5 - Datify the timestamp
        // 6 - is it read
        ////////////////////////
        //The main forum loop of a category
        foreach ($forums as $c => $cv) {

            //The main forum loop
            foreach ($forums[$c] as $f => $v) {

                $visible_forums[] = $v['fid'];

                //Are you a main board of the level 0
                if ($forums[$c][$f]['board_level'] != 0) {

                    unset($forums[$c][$f]);

                    continue;
                }

                $forums[$c][$f]['description'] = unhtmlentities($forums[$c][$f]['description']);

                //The last posted topics last page calculation
                $tmp = ceil(($forums[$c][$f]['n_posts'] + 1) / $globals['maxpostsintopics']);
                //echo $tmp;
                //Insert the page number
                array_insert($forums[$c][$f], count($forums[$c][$f]), array('last_page' => $tmp));


                //Datify the time stamp
                array_insert($forums[$c][$f], count($forums[$c][$f]), array('pdate' => datify($forums[$c][$f]['ptime'])));
            }
        }//End of main loop

        if (!empty($globals['recent_posts'])) {

            $visible_forums = implode(', ', $visible_forums);

            //Bring the last posts
            $qresult = makequery("SELECT t.tid, t.topic, t.n_posts, p.pid, p.ptime,
                    u.id, u.username, f.fid, f.fname
                    FROM " . $dbtables['posts'] . " p
                    LEFT JOIN " . $dbtables['topics'] . " t ON (t.tid = p.post_tid)
                    LEFT JOIN " . $dbtables['forums'] . " f ON (f.fid = p.post_fid)
                    LEFT JOIN " . $dbtables['users'] . " u ON (u.id = p.poster_id)
                    WHERE p.post_fid IN (" . (empty($visible_forums) ? 0 : $visible_forums) . ")
                                                                                          AND EXISTS (SELECT * FROM  " . $dbtables['topics'] . " WHERE tid = t.tid)
                    ORDER BY ptime DESC
                    LIMIT 0, " . $globals['recent_posts']);

            if (mysql_num_rows($qresult) > 0) {

                //Get the posts
                for ($p = 0; $p < mysql_num_rows($qresult); $p++) {

                    $row = mysql_fetch_assoc($qresult);

                    $row['last_page'] = ceil(($row['n_posts'] + 1) / $globals['maxpostsintopics']);

                    //The date
                    $row['pdate'] = datify($row['ptime']);

                    $recent_posts[$row['pid']] = $row;
                }
            }
        }

        //Now if the user has an unread PM get the latest
        if ($logged_in && $globals['pmon'] && $user['can_use_pm'] && !empty($user['unread_pm'])
                && $user['pm_notify']) {

            //Get the PM the user has requested to see.
            $qresult = makequery("SELECT pm.*, ug.mem_gr_name, ug.image_name, ug.image_count, u.id,                     u.username AS sender, u.posts, u.u_member_group, s.uid AS status
                    FROM " . $dbtables['pm'] . " pm
                    LEFT JOIN " . $dbtables['users'] . " u ON (pm.pm_from = u.id)
                    LEFT JOIN " . $dbtables['user_groups'] . " ug ON (ug.member_group = u.u_member_group)
                    LEFT JOIN " . $dbtables['sessions'] . " s ON (pm.pm_from = s.uid)
                    WHERE pm.pm_to = '" . $user['id'] . "'
                    AND pm.pm_folder = '0'
                    AND pm.pm_read_time = '0'
                    ORDER BY pm.pm_time DESC
                    LIMIT 0,1");

            if (mysql_num_rows($qresult) > 0) {

                //The array holding the PM
                $pm = mysql_fetch_assoc($qresult);

                //Convert the PM time
                $pm['pm_time'] = datify($pm['pm_time']);

                $pm['pm_body'] = format_text($pm['pm_body']);

                //Links and all
                $pm['pm_body'] = parse_special_bbc($pm['pm_body']);

                //Add the brakes
                $pm['pm_body'] = parse_br($pm['pm_body']);
            }
        }


        //Get the second of the day start
        $timestamp = mktime(0, 0, 0);

        //Active time limit
        $activetime = time() - ($globals['last_active_span'] * 60);

        //Get who is active
        $qresult = makequery("SELECT DISTINCT s.uid, s.ip, u.id, u.username, s.anonymous,
                    ug.mem_gr_colour, st.active
                    FROM " . $dbtables['sessions'] . " s
                    LEFT JOIN " . $dbtables['users'] . " u ON (s.uid = u.id)
                    LEFT JOIN " . $dbtables['user_groups'] . " ug ON (u.u_member_group =
                                                                ug.member_group)
                    LEFT JOIN " . $dbtables['stats'] . " st ON (timestamp = '$timestamp')
                    WHERE s.time > '$activetime'
                    ORDER BY s.time DESC, u.username ASC");

        //Where is everybody ?
        if (mysql_num_rows($qresult) > 0) {

            $totalactive = mysql_num_rows($qresult);

            for ($i = 1; $i <= $totalactive; $i++) {

                $row = mysql_fetch_assoc($qresult);

                //draw out the most number of active users today
                $mostactive = $row['active'];

                //Is the user a Guest
                if (!empty($row['id'])) {

                    //So he is anonymous - should we show him ?
                    if ($row['anonymous'] && !$user['view_anonymous']) {

                        $anonymous = $anonymous + 1;
                    } else {

                        $active[] = $row;
                    }
                } else {

                    $guests = $guests + 1;

                    //Is it a bot
                    if ($row['uid'] < -100) {

                        if (empty($activebots[$row['uid']])) {

                            $activebots[$row['uid']] = 1;
                        } else {

                            $activebots[$row['uid']] += 1;
                        }
                    }
                }
            }
        } else {
            $totalactive = NULL;
        }

        foreach ($activebots as $k => $v) {

            $botname = botname($k);

            if (!empty($botname)) {

                $activebots[$k] = $botname . '(' . $v . ')';
            } else {

                unset($activebots[$k]);
            }
        }


        ////////////////////////////////////
        // Note the following array playing
        // is done because a username may
        // contain '|'(bar) that is exploded.
        ////////////////////////////////////

        $latest_tmp = explode('|', $globals['latest_mem']);

        $latest_mem[1] = $latest_tmp[count($latest_tmp) - 1];

        unset($latest_tmp[count($latest_tmp) - 1]);

        $latest_mem[0] = implode('', $latest_tmp);

        //Are we to track the statistics
        if ($globals['stats']) {

            //Are there more or equal active users right now for today
            if ($totalactive >= $mostactive) {

                //UPDATE the stats table(Done by session handling)
                $globals['activetoday'] = $totalactive;
            }

            //Get the most active ever
            $mostactive_ever = explode('|', $globals['mostactive']);

            //Are there more or equal active users right now then ever before
            if ($totalactive >= (int) $mostactive_ever[0]) {

                //UPDATE the registry
                $qresult = makequery("UPDATE " . $dbtables['registry'] . "
                            SET regval = '$totalactive|" . time() . "'
                            WHERE name = 'mostactive'", false);
            }
        }

        //Who Visited Today
        if (!empty($globals['users_visited_today'])) {

            //Get Who Visited Today
            $qresult = makequery("SELECT DISTINCT u.id, u.username,    ug.mem_gr_colour
                        FROM " . $dbtables['users'] . " u
                        LEFT JOIN " . $dbtables['user_groups'] . " ug ON (u.u_member_group =
                                                                    ug.member_group)
                        WHERE u.lastlogin_1 >= '$timestamp'
                        ORDER BY u.username ASC");

            //Where is everybody ?
            if (mysql_num_rows($qresult) > 0) {

                for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

                    $online_today[] = mysql_fetch_assoc($qresult);
                }
            }
        }

        if (!empty($globals['show_groups'])) {

            //Get the Non Posting Groups
            $qresult = makequery("SELECT DISTINCT member_group, mem_gr_name, mem_gr_colour
                        FROM " . $dbtables['user_groups'] . "
                        WHERE post_count = '-1' AND member_group >= 0
                        ORDER BY member_group ASC");

            //Where is everybody ?
            if (mysql_num_rows($qresult) > 0) {

                for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

                    $row = mysql_fetch_assoc($qresult);

                    $user_groups[$row['member_group']] = $row;
                }
            }
        }

        $theme['call_theme_func'] = 'MainIndex_theme';

        return true;
    } else {

        return false;
    }
}

?>
