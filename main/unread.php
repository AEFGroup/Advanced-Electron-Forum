<?php

//////////////////////////////////////////////////////////////
//===========================================================
// unread.php
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

//////////////////////////////////////
// All the unread topics that the user
// has not followed ever or after a
// new reply has been posted.
//////////////////////////////////////


function unread() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $unread, $count, $tree;

    //Load the Language File
    if (!load_lang('unread')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'unread';

    //The name of the Page
    $theme['init_theme_name'] = 'Unread Topics';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('unread_theme');


    /////////////////////////////////////////
    //This section is only for users
    if (!$logged_in) {

        //Show a major error and return
        reporterror($l['cant_view_unread_title'], $l['cant_view_unread']);

        return false;
    }
    /////////////////////////////////////////
    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $unread = array();

    $ins = ''; //Just for the query

    $fids = array();

    $fids_str = ''; //Clean string of ids

    $uid = $user['id'];

    $tree = array(); //Board tree for users location
    $tree[] = array('l' => $globals['index_url'],
        'txt' => $l['index']);
    $tree[] = array('l' => $globals['index_url'] . 'act=unread',
        'txt' => $l['unread_topics']);

    //He is viewing unread posts
    $globals['last_activity'] = 'up';

    //Checks the Page to see
    $page = get_page('uppg', $globals['maxtopics']);

    //Load the board
    if (!default_of_nor()) {

        return false;
    }


    //This is to make an array of permitted forums to view
    foreach ($forums as $c => $cv) {

        //The main forum loop
        foreach ($forums[$c] as $f => $v) {

            $fids[$forums[$c][$f]['fid']] = $forums[$c][$f]['fid'];
        }
    }//End of main loop

    array_multisort($fids);

    $fids_str = implode(', ', $fids);

    //Get the Number of pages that can be formed
    $qresult = makequery("SELECT COUNT(p.post_tid) AS pages
                FROM " . $dbtables['posts'] . " p
                LEFT JOIN " . $dbtables['topics'] . " t ON (t.tid = p.post_tid)
                LEFT JOIN " . $dbtables['read_topics'] . " rt ON (t.tid = rt.rt_tid AND
                                                                rt.rt_uid = '" . $uid . "')
                LEFT JOIN " . $dbtables['mark_read'] . " mr ON (p.post_fid = mr.mr_fid AND
                                                                mr.mr_uid = '" . $uid . "')
                LEFT JOIN " . $dbtables['read_board'] . " rb ON (rb.rb_uid = '" . $uid . "')
                WHERE t.t_bid IN ($fids_str)
                AND (p.ptime > rt.rt_time OR rt.rt_time IS NULL)
                AND (p.ptime > mr.mr_time OR mr.mr_time IS NULL)
                AND (p.ptime > rb.rb_time OR rb.rb_time IS NULL)
                AND t.t_status != 2
                GROUP BY p.post_tid");

    $count = mysql_num_rows($qresult);

    //Get the Pids of the page.
    $qresult = makequery("SELECT MAX( p.pid ) AS maxpid
                FROM " . $dbtables['posts'] . " p
                LEFT JOIN " . $dbtables['topics'] . " t ON (t.tid = p.post_tid)
                LEFT JOIN " . $dbtables['read_topics'] . " rt ON (t.tid = rt.rt_tid AND
                                                                rt.rt_uid = '" . $uid . "')
                LEFT JOIN " . $dbtables['mark_read'] . " mr ON (p.post_fid = mr.mr_fid AND
                                                                mr.mr_uid = '" . $uid . "')
                LEFT JOIN " . $dbtables['read_board'] . " rb ON (rb.rb_uid = '" . $uid . "')
                WHERE t.t_bid IN ($fids_str)
                AND (p.ptime > rt.rt_time OR rt.rt_time IS NULL)
                AND (p.ptime > mr.mr_time OR mr.mr_time IS NULL)
                AND (p.ptime > rb.rb_time OR rb.rb_time IS NULL)
                AND t.t_status != 2
                GROUP BY p.post_tid
                ORDER BY maxpid DESC
                LIMIT $page, " . $globals['maxtopics']);


    if (mysql_num_rows($qresult) < 1) {

        //If it is not the first page - then you specified an invalid link
        if ($page > 0) {

            //Show a major error and return
            reporterror($l['no_page_found_title'], $l['no_page_found']);

            return false;
        }

        //Lets bring out the topics
    } else {

        for ($i = 0; $i < mysql_num_rows($qresult); $i++) {

            $row = mysql_fetch_assoc($qresult);

            $pids[] = $row['maxpid'];
        }

        unset($row);

        //Free the resources
        mysql_free_result($qresult);

        $ins = implode(',', $pids); //echo $ins;
        //Get out the topics in this board
        $qresult = makequery("SELECT t.tid, t.topic, t.n_posts, t.n_views, t.t_mem_id, t.poll_id,
                t.t_status, t.t_sticky, t.type_image, t.has_attach,
                ts.username AS starter,    p.pid, p.ptime, p.poster_id, u.username, f.fid, f.fname
                FROM " . $dbtables['topics'] . " t
                LEFT JOIN " . $dbtables['posts'] . " p ON (t.tid = p.post_tid)
                LEFT JOIN " . $dbtables['users'] . " ts ON (ts.id = t.t_mem_id)
                LEFT JOIN " . $dbtables['users'] . " u ON (u.id = p.poster_id)
                LEFT JOIN " . $dbtables['forums'] . " f ON (f.fid = t.t_bid)
                WHERE p.pid IN (" . $ins . ")
                ORDER BY p.pid DESC");

        if (mysql_num_rows($qresult) < 1) {

            //Show a major error and return
            reporterror($l['load_unread_error_title'], $l['load_unread_error']);

            return false;
        }


        //Alright boys the result is out lets put it in the topics array()
        for ($t = 1; $t <= mysql_num_rows($qresult); $t++) {

            $unread[$t] = mysql_fetch_assoc($qresult);
        }


        //Free the resources
        mysql_free_result($qresult);
    }


    foreach ($unread as $u => $uv) {

        //The date thingy
        $unread[$u]['ptime'] = datify($unread[$u]['ptime']);

        //The last page calculation
        $tmp = ceil(($unread[$u]['n_posts'] + 1) / $globals['maxpostsintopics']);
        //echo $tmp;
        //Push it in the array
        @$unread[$u]['last_page'] = $tmp;

        //Push is_new
        @$unread[$u]['is_new'] = 1;

        /////////////////////////////
        // Show the number of pages
        /////////////////////////////

        if ($tmp > 1) {

            $top_pages = array();

            for ($i = 1; $i <= (($tmp > 5) ? 5 : $tmp); $i++) {

                $top_pages[] = '<a href="' . $globals['index_url'] . 'tid=' . $unread[$u]['tid'] . '&tpg=' . $i . '" >' . $i . '</a>';
            }

            if ($tmp > 5) {

                $top_pages[] = ' . . . ';

                $top_pages[] = '<a href="' . $globals['index_url'] . 'tid=' . $unread[$u]['tid'] . '&tpg=' . $tmp . '" >' . $tmp . '</a>';
            }

            $unread[$u]['pages'] = implode(' ', $top_pages);
        }


        /////////////////////////////////
        // Decide about the topic icons
        // It is a four digit number.
        // Meaning of number by position
        // 1 - Hot(1) or Normal(0)
        // 2 - Poll(1) or Topic(0)
        /////////////////////////////////
        //Is it a hot or a normal topic
        if ($unread[$u]['n_posts'] >= $globals['maxreplyhot']) {

            $unread[$u]['type'] = '1';
        } else {

            $unread[$u]['type'] = '0';
        }


        //Is it a poll or just a topic
        if ($unread[$u]['poll_id']) {

            $unread[$u]['type'] .= '1';
        } else {

            $unread[$u]['type'] .= '0';
        }


        //Is it locked or no
        if ($unread[$u]['t_status'] == 0) {

            $unread[$u]['type'] = 'closed';
        }


        //Is it stickied
        if ($unread[$u]['t_sticky']) {

            $unread[$u]['type'] = 'pinned';
        }


        //But if it is moved just moved
        if ($unread[$u]['t_status'] == 2) {

            $unread[$u]['type'] = 'moved';
        }


        /////////////////////////////
        // Give the necessary prefix
        /////////////////////////////
        //Is it a poll or just a topic
        if ($unread[$u]['poll_id']) {

            $unread[$u]['t_prefix'] = $globals['prefixpolls'];
        }


        //Is it stickied
        if ($unread[$u]['t_sticky']) {

            $unread[$u]['t_prefix'] = $globals['prefixsticky'];
        }


        //But if it is moved just moved
        if ($unread[$u]['t_status'] == 2) {

            $unread[$u]['t_prefix'] = $globals['prefixmoved'];
        }


        //If a post is made by a guest then no username will be there
        if (empty($unread[$u]['username'])) {

            $unread[$u]['username'] = $l['guest'];
        }
    }//End of loop

    $theme['call_theme_func'] = 'unread_theme';
}

?>
