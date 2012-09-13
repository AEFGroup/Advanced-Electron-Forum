<?php

//////////////////////////////////////////////////////////////
//===========================================================
// search.php
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
// This is for searching within topics
//////////////////////////////////////


function search() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $mother_options, $forum_ids, $tree;

    //Load the Language File
    if (!load_lang('search')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'search';

    //The name of the Page
    $theme['init_theme_name'] = 'Search Topics';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('search_theme',
        'results_theme');

    /////////////////////////////////////////
    //This section is only for users
    if (!$user['can_search']) {

        //Show a major error and return
        reporterror($l['cant_search_title'], $l['cant_search']);

        return false;
    }
    /////////////////////////////////////////
    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $forum_ids = array();
    $forum_ids[] = 0;

    $mother_options = array();

    $globals['last_activity'] = 's';

    $tree = array(); //Board tree for users location
    $tree[] = array('l' => $globals['index_url'],
        'txt' => $l['index']);
    $tree[] = array('l' => $globals['index_url'] . 'act=search',
        'txt' => $l['search']);

    //If a second User CP act has been set
    if (isset($_GET['sact']) && trim($_GET['sact']) !== "") {

        $sact = inputsec(htmlizer(trim($_GET['sact'])));
    } else {

        $sact = "";
    }


    //Load the board
    if (!default_of_nor(false)) {

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

                $mother_options[$forums[$c][$f]['fid']] = array($forums[$c][$f]['fid'],
                    $dasher . (($forums[$c][$f]['board_level'] != 0) ? '|--' : '') . $forums[$c][$f]['fname']);

                $forum_ids[] = $forums[$c][$f]['fid'];
            }
        }
    }

    //The switch handler
    switch ($sact) {

        case 'results' :
            results();
            break;

        default :
            $theme['call_theme_func'] = 'search_theme';
            break;
    }
}

function results() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $categories, $forums, $found, $count, $mother_options, $error, $count, $showas, $forum_ids;
    global $fids_str, $user_group, $post_group;

    //Call the Language function
    results_lang();

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $error = array();

    $found = array(); //Array of returned results

    $fids = array();

    //Checks the Page to see
    $page = get_page('spg', $globals['maxtopics']);


    //We have been ordered to search
    if (isset($_GET['within'])) {

        //It must have all these words
        if (isset($_GET['allwords']) && trim($_GET['allwords']) !== "") {

            $allwords = inputsec(htmlizer(trim($_GET['allwords'])));

            //Replace spaces and special characters
            $allwords = preg_replace(array('/%/', '/_/', '/\s/'), array('\\%', '\_', '%'), $allwords);
        }

        //With an exact phrase
        if (isset($_GET['exactphrase']) && trim($_GET['exactphrase']) !== "") {

            $exactphrase = inputsec(htmlizer(trim($_GET['exactphrase'])));

            //Replace special characters
            $exactphrase = preg_replace(array('/%/', '/_/'), array('\\%', '\_'), $exactphrase);
        }

        //With atleast one of the words
        if (isset($_GET['atleastone']) && trim($_GET['atleastone']) !== "") {

            $atleastone = inputsec(htmlizer(trim($_GET['atleastone'])));

            //Replace special characters
            $atleastone = preg_replace(array('/%/', '/_/'), array('\\%', '\_'), $atleastone);

            $atleastone_r = array();

            //Create the array
            $temp_r = explode(' ', $atleastone);

            //clean the array for white spaces
            foreach ($temp_r as $v) {

                $v = trim($v);

                if (!empty($v)) {

                    $atleastone_r[] = $v;
                }
            }
        }

        //Without the words
        if (isset($_GET['without']) && trim($_GET['without']) !== "") {

            $without = inputsec(htmlizer(trim($_GET['without'])));

            //Replace spaces and special characters
            $without = preg_replace(array('/%/', '/_/', '/\s/'), array('\\%', '\_', '%'), $without);
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'search_theme';
            return false;
        }


        //Who started or posted it
        if (isset($_GET['starter']) && trim($_GET['starter']) !== "") {

            $starter = inputsec(htmlizer(trim($_GET['starter'])));
        }


        //Is there something to search for
        if (empty($allwords) && empty($exactphrase) && empty($atleastone_r) && empty($without) &&
                empty($starter)) {

            $error[] = $l['no_query'];
        }


        //Within the posts or titles
        if (isset($_GET['within']) && trim($_GET['within']) == "1") {

            $within = 1;
        } elseif (isset($_GET['within']) && trim($_GET['within']) == "2") {

            $within = 2;
        } else {

            $error[] = $l['no_within'];
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'search_theme';
            return false;
        }


        //Which forum to search within
        if (empty($_GET['forums'])) {

            $error[] = $l['no_where'];
        } else {

            if (!is_array($_GET['forums'])) {

                $_GET['forums'] = trim($_GET['forums']);

                $_GET['forums'] = explode(',', $_GET['forums']);
            }

            foreach ($_GET['forums'] as $f) {

                $f = trim($f);

                if (!in_array($f, $forum_ids)) {

                    $error[] = $l['invalid_where'];

                    break;
                } else {

                    $fids[$f] = $f;
                }
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'search_theme';
            return false;
        }


        //Show as what
        if (isset($_GET['showas']) && trim($_GET['showas']) == "1") {

            $showas = 1;
        } elseif (isset($_GET['showas']) && trim($_GET['showas']) == "2") {

            $showas = 2;
        } else {

            $error[] = $l['no_showas'];
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'search_theme';
            return false;
        }


        //Make the text for the atleast one words
        if (!empty($atleastone_r)) {

            $temp_txt = array();

            foreach ($atleastone_r as $like) {

                $temp_txt[] = ($within == 1 ? "p.post" : "t.topic") . " LIKE '%" . $like . "%'";
            }

            $atleastone_txt = "AND (" . implode(" OR ", $temp_txt) . ")";
        }


        //Also which forum to look within
        if (in_array(0, $fids)) {

            $fids_str = implode(', ', $forum_ids);
        } else {

            $fids_str = implode(', ', $fids);
        }


        //Search within posts
        if ($within == 1) {

            //Get the number of pages of the searched results
            $qresult = makequery("SELECT COUNT(p.post_tid) AS pages
                    FROM " . $dbtables['posts'] . " p
                    LEFT JOIN " . $dbtables['topics'] . " t ON (t.tid = p.post_tid)
                    LEFT JOIN " . $dbtables['users'] . " ts ON (ts.id = t.t_mem_id)
                    LEFT JOIN " . $dbtables['users'] . " u ON (u.id = p.poster_id)
                    WHERE t.t_bid IN ($fids_str)
                    " . (empty($allwords) ? '' : "AND p.post LIKE '%" . $allwords . "%'") . "
                    " . (empty($exactphrase) ? '' : "AND p.post LIKE '%" . $exactphrase . "%'") . "
                    " . (empty($atleastone_txt) ? '' : $atleastone_txt) . "
                    " . (empty($without) ? '' : "AND p.post NOT LIKE '%" . $without . "%'") . "
                    " . (empty($starter) ? '' : "AND (ts.username = '$starter'
                                                                OR u.username = '$starter')") . "
                    GROUP BY p.post_tid");

            $count = mysql_num_rows($qresult);

            //Get the posts that match the conditions
            $qresult = makequery("SELECT MAX( p.pid ) AS maxpid
                    FROM " . $dbtables['posts'] . " p
                    LEFT JOIN " . $dbtables['topics'] . " t ON (t.tid = p.post_tid)
                    LEFT JOIN " . $dbtables['users'] . " ts ON (ts.id = t.t_mem_id)
                    LEFT JOIN " . $dbtables['users'] . " u ON (u.id = p.poster_id)
                    WHERE t.t_bid IN ($fids_str)
                    " . (empty($allwords) ? '' : "AND p.post LIKE '%" . $allwords . "%'") . "
                    " . (empty($exactphrase) ? '' : "AND p.post LIKE '%" . $exactphrase . "%'") . "
                    " . (empty($atleastone_txt) ? '' : $atleastone_txt) . "
                    " . (empty($without) ? '' : "AND p.post NOT LIKE '%" . $without . "%'") . "
                    " . (empty($starter) ? '' : "AND (ts.username = '$starter'
                                                                OR u.username = '$starter')") . "
                    GROUP BY p.post_tid
                    ORDER BY maxpid DESC
                    LIMIT $page, " . $globals['maxtopics']);

            if (mysql_num_rows($qresult) < 1) {

                //If it is not the first page - then you specified an invalid link
                if ($page > 0) {

                    //Show a major error and return
                    reporterror($l['no_page_found_title'], $l['no_page_found']);

                    return false;
                } elseif ($page == 0) {

                    $error[] = $l['no_results'];

                    $theme['call_theme_func'] = 'search_theme';

                    return false;
                }
            }

            //Ok continue we found some posts
            for ($i = 0; $i < mysql_num_rows($qresult); $i++) {

                $row = mysql_fetch_assoc($qresult);

                $pids[] = $row['maxpid'];
            }

            unset($row);

            //Free the resources
            @mysql_free_result($qresult);

            $ins = implode(',', $pids);

            //Get the posts that match the conditions
            $qresult = makequery("SELECT DISTINCT t.tid, t.topic, t.t_description, t.n_posts,
                    t.n_views, t.t_mem_id, t.poll_id, t.t_status, t.t_sticky, t.type_image,
                    t.has_attach, ts.username AS starter, p.pid, p.ptime, p.poster_id, u.username,
                    u.posts, f.fid, f.fname, p.post
                    FROM " . $dbtables['posts'] . " p
                    LEFT JOIN " . $dbtables['topics'] . " t ON (t.tid = p.post_tid)
                    LEFT JOIN " . $dbtables['users'] . " ts ON (ts.id = t.t_mem_id)
                    LEFT JOIN " . $dbtables['users'] . " u ON (u.id = p.poster_id)
                    LEFT JOIN " . $dbtables['forums'] . " f ON (f.fid = t.t_bid)
                    WHERE p.pid IN ($ins)
                    ORDER BY p.pid DESC");


            //Search within title
        } else {

            //Get the number of pages of the searched results
            $qresult = makequery("SELECT COUNT(p.post_tid) AS pages
                    FROM " . $dbtables['posts'] . " p
                    LEFT JOIN " . $dbtables['topics'] . " t ON (t.tid = p.post_tid)
                    LEFT JOIN " . $dbtables['users'] . " ts ON (ts.id = t.t_mem_id)
                    LEFT JOIN " . $dbtables['users'] . " u ON (u.id = p.poster_id)
                    WHERE t.t_bid IN ($fids_str)
                    " . (empty($allwords) ? '' : "AND t.topic LIKE '%" . $allwords . "%'") . "
                    " . (empty($exactphrase) ? '' : "AND t.topic LIKE '%" . $exactphrase . "%'") . "
                    " . (empty($atleastone_txt) ? '' : $atleastone_txt) . "
                    " . (empty($without) ? '' : "AND t.topic NOT LIKE '%" . $without . "%'") . "
                    " . (empty($starter) ? '' : "AND u.username = '$starter'") . "
                    GROUP BY p.post_tid");

            $count = mysql_num_rows($qresult);

            //Select the MAX pid that match the conditions
            $qresult = makequery("SELECT MAX( p.pid ) AS maxpid
                    FROM " . $dbtables['posts'] . " p
                    LEFT JOIN " . $dbtables['topics'] . " t ON (t.tid = p.post_tid)
                    LEFT JOIN " . $dbtables['users'] . " ts ON (ts.id = t.t_mem_id)
                    LEFT JOIN " . $dbtables['users'] . " u ON (u.id = p.poster_id)
                    WHERE t.t_bid IN ($fids_str)
                    " . (empty($allwords) ? '' : "AND t.topic LIKE '%" . $allwords . "%'") . "
                    " . (empty($exactphrase) ? '' : "AND t.topic LIKE '%" . $exactphrase . "%'") . "
                    " . (empty($atleastone_txt) ? '' : $atleastone_txt) . "
                    " . (empty($without) ? '' : "AND t.topic NOT LIKE '%" . $without . "%'") . "
                    " . (empty($starter) ? '' : "AND u.username = '$starter'") . "
                    GROUP BY p.post_tid
                    ORDER BY maxpid DESC
                    LIMIT $page, " . $globals['maxtopics']);

            if (mysql_num_rows($qresult) < 1) {

                //If it is not the first page - then you specified an invalid link
                if ($page > 0) {

                    //Show a major error and return
                    reporterror($l['no_page_found_title'], $l['no_page_found']);

                    return false;
                } elseif ($page == 0) {

                    $error[] = $l['no_results'];

                    $theme['call_theme_func'] = 'search_theme';

                    return false;
                }
            }

            //Ok continue we found some posts
            for ($i = 0; $i < mysql_num_rows($qresult); $i++) {

                $row = mysql_fetch_assoc($qresult);

                $pids[] = $row['maxpid'];
            }

            unset($row);

            //Free the resources
            @mysql_free_result($qresult);

            $ins = implode(',', $pids);

            //Get the posts having topic that match the conditions
            $qresult = makequery("SELECT DISTINCT t.tid, t.topic, t.t_description, t.n_posts,
                    t.n_views, t.t_mem_id, t.poll_id, t.t_status, t.t_sticky, t.type_image,
                    t.has_attach, ts.username AS starter, p.pid, p.ptime, p.poster_id, u.username,
                    u.posts, f.fid, f.fname, p.post
                    FROM " . $dbtables['posts'] . " p
                    LEFT JOIN " . $dbtables['topics'] . " t ON (t.tid = p.post_tid)
                    LEFT JOIN " . $dbtables['users'] . " ts ON (ts.id = t.t_mem_id)
                    LEFT JOIN " . $dbtables['users'] . " u ON (u.id = p.poster_id)
                    LEFT JOIN " . $dbtables['forums'] . " f ON (f.fid = t.t_bid)
                    WHERE p.pid IN ($ins)
                    ORDER BY p.pid DESC");
        }


        //Was something found
        if (mysql_num_rows($qresult) > 0) {

            for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

                $row = mysql_fetch_assoc($qresult);

                $row['ptime'] = datify($row['ptime']);

                $found[$row['pid']] = $row;
            }

            if ($showas == 1) {

                foreach ($found as $f => $fv) {

                    //The last page calculation
                    $tmp = ceil(($found[$f]['n_posts'] + 1) / $globals['maxpostsintopics']);
                    //echo $tmp;
                    //Push it in the array
                    @$found[$f]['last_page'] = $tmp;



                    /////////////////////////////
                    // Show the number of pages
                    /////////////////////////////

                    if ($tmp > 1) {

                        $top_pages = array();

                        for ($i = 1; $i <= (($tmp > 5) ? 5 : $tmp); $i++) {

                            $top_pages[] = '<a href="' . $globals['index_url'] . 'tid=' . $found[$f]['tid'] . '&tpg=' . $i . '" >' . $i . '</a>';
                        }

                        if ($tmp > 5) {

                            $top_pages[] = ' . . . ';

                            $top_pages[] = '<a href="' . $globals['index_url'] . 'tid=' . $found[$f]['tid'] . '&tpg=' . $tmp . '" >' . $tmp . '</a>';
                        }

                        $found[$f]['pages'] = implode(' ', $top_pages);
                    }


                    /////////////////////////////////
                    // Decide about the topic icons
                    // It is a four digit number.
                    // Meaning of number by position
                    // 1 - Hot(1) or Normal(0)
                    // 2 - Poll(1) or Topic(0)
                    /////////////////////////////////
                    //Is it a hot or a normal topic
                    if ($found[$f]['n_posts'] >= $globals['maxreplyhot']) {

                        $found[$f]['type'] = '1';
                    } else {

                        $found[$f]['type'] = '0';
                    }


                    //Is it a poll or just a topic
                    if ($found[$f]['poll_id']) {

                        $found[$f]['type'] .= '1';
                    } else {

                        $found[$f]['type'] .= '0';
                    }


                    //Is it locked or no
                    if ($found[$f]['t_status'] == 0) {

                        $found[$f]['type'] = 'closed';
                    }


                    //Is it stickied
                    if ($found[$f]['t_sticky']) {

                        $found[$f]['type'] = 'pinned';
                    }


                    //But if it is moved just moved
                    if ($found[$f]['t_status'] == 2) {

                        $found[$f]['type'] = 'moved';
                    }


                    /////////////////////////////
                    // Give the necessary prefix
                    /////////////////////////////
                    //Is it a poll or just a topic
                    if ($found[$f]['poll_id']) {

                        $found[$f]['t_prefix'] = $globals['prefixpolls'];
                    }


                    //Is it stickied
                    if ($found[$f]['t_sticky']) {

                        $found[$f]['t_prefix'] = $globals['prefixsticky'];
                    }


                    //But if it is moved just moved
                    if ($found[$f]['t_status'] == 2) {

                        $found[$f]['t_prefix'] = $globals['prefixmoved'];
                    }


                    //If a post is made by a guest then no username will be there
                    if (empty($found[$f]['username'])) {

                        $found[$f]['username'] = $l['guest'];
                    }
                }
            } elseif ($showas == 2) {

                //Bring the Member Group
                if (!membergroups()) {

                    return false;
                }

                foreach ($found as $f => $fv) {

                    //Format the text
                    $found[$f]['post'] = format_text($found[$f]['post']);

                    //Links and all
                    $found[$f]['post'] = parse_special_bbc($found[$f]['post']);

                    //Add the brakes
                    $found[$f]['post'] = parse_br($found[$f]['post']);

                    //Is there any username present
                    if (empty($found[$f]['username'])) {

                        $found[$f]['is_guest'] = 1;

                        //Has it been posted by any guest
                        if (empty($found[$f]['gposter_name'])) {

                            $found[$f]['username'] = $user_group[-1]['mem_gr_name'];
                        } else {

                            $found[$f]['username'] = $found[$f]['gposter_name'];
                        }
                    }
                }
            }

            $theme['call_theme_func'] = 'results_theme';

            return true;
        } else {

            $error[] = $l['no_results'];

            $theme['call_theme_func'] = 'search_theme';

            return false;
        }
    } else {

        redirect('act=search'); //IE 7 #redirect not working

        return true;
    }
}

?>