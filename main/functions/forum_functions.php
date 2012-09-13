<?php

//////////////////////////////////////////////////////////////
//===========================================================
// forum_functions.php(functions)
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


//Load the Language File
if (!load_lang('functions/forum_functions')) {

    return false;
}

function getcatsandforums_fn($newposts = true, $get_mod = true) {

    global $globals, $theme, $dbtables, $conn, $categories, $forums, $user, $in_board, $logged_in;

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $ins = ''; //Just for the query

    $read_board = 0;

    $categories = array(); //The array holding the categories which have a board

    $forums = array(); //The array holding boards that are viewable

    $forum_r = array(); //TEMP array holding boards that are viewable

    $mods = array(); //The array holding boards moderators

    $is_mod = array();

    ///////////////////////////////////
    // Get the Moderators of the forums
    ///////////////////////////////////

    if ($get_mod) {

        $qresult = makequery("SELECT m.*, u.username, u.id , f.fid , c.order
                    FROM " . $dbtables['moderators'] . " m, " . $dbtables['users'] . " u,
                    " . $dbtables['forums'] . " f, " . $dbtables['categories'] . " c
                    WHERE m.mod_mem_id = u.id AND mod_fid = f.fid AND f.cat_id = c.cid");


        if (mysql_num_rows($qresult) > 0) {

            //The loop to draw out the rows
            for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

                $moderators[$i] = mysql_fetch_assoc($qresult);
            }

            //We have to build an array of the Moderators
            for ($i = 1; $i <= count($moderators); $i++) {

                $modfid = 'fid' . $moderators[$i]['mod_fid'];

                if ($logged_in) {

                    if ($moderators[$i]['mod_mem_id'] == $user['id']) {

                        $is_mod[$modfid] = true;
                    }
                }

                if (isset($mods[$modfid])) {

                    $mods[$modfid][] = $moderators[$i];
                } else {

                    $mods[$modfid] = array();

                    $mods[$modfid][] = $moderators[$i];
                }
            }
        }

        //Free the resources
        @mysql_free_result($qresult);
    }//End of if($get_mod)
    //Get out the boards according to the user
    $qresult = makequery("SELECT cat.*, f.*, fp.*, t.*, p.*, u.username
        " . (($logged_in) ? ", rf.*, rb.rb_time" : "") . ", th.th_folder
        FROM " . $dbtables['categories'] . " cat
        LEFT JOIN " . $dbtables['forums'] . " f ON (cat.cid = f.cat_id)
        LEFT JOIN " . $dbtables['forumpermissions'] . " fp ON (fp.fpfid = f.fid
                    " . (($logged_in) ? "AND fp.fpugid = " . $user['member_group'] . "" : "") . ")
        LEFT JOIN " . $dbtables['posts'] . " p ON (p.post_fid = f.fid AND p.pid = f.f_last_pid)
        LEFT JOIN " . $dbtables['topics'] . " t ON (p.post_tid = t.tid)
        LEFT JOIN " . $dbtables['users'] . " u ON (p.poster_id = u.id)
        " . (($logged_in) ? "LEFT JOIN " . $dbtables['read_forums'] . " rf ON (f.fid = rf.rf_fid
                                                                        AND rf.rf_uid = '" . $user['id'] . "')
        LEFT JOIN " . $dbtables['read_board'] . " rb ON (rb.rb_uid = '" . $user['id'] . "')" : "") . "
        LEFT JOIN " . $dbtables['themes'] . " th ON (th.thid = f.id_skin)
        ORDER BY cat.order ASC , f.par_board_id ASC , f.forum_order ASC");

    //Where are the boards ?
    if (mysql_num_rows($qresult) < 1) {

        return false;
    }


    //The loop to draw out the rows
    for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

        $row = mysql_fetch_assoc($qresult);

        //Build the Categories
        if (empty($categories[$row['cid']])) {

            $categories[$row['cid']] = array('cid' => $row['cid'],
                'name' => $row['name'],
                'order' => $row['order'],
                'collapsable' => $row['collapsable'],
            );
        }//end of if condition

        unset($row['name']);
        unset($row['collapsable']);


        //Add to the total posts
        $globals['tot_posts'] = $globals['tot_posts'] + (int) $row['nposts'];

        //Add to the total topics
        $globals['tot_topics'] = $globals['tot_topics'] + (int) $row['ntopic'];

        $cansee = true;

        //If he is not a admin and not even a moderator only then check
        if (!$user['can_admin'] && empty($is_mod['fid' . $row['fid']])) {

            //Gets the array of members allowed to view
            $all_mem = explode(',', $row['member_group']);

            if (!in_array($user['member_group'], $all_mem)) {

                $cansee = false;
            }
        }


        //Make a forums array if he can see the board
        if (!empty($row['fid']) && $cansee) {

            $forum_r[$row['fid']] = $row;
        }

        unset($row);
    }//End of main for loop
    //Free the resources
    mysql_free_result($qresult);

    $parents = array();

    //Make the parents
    foreach ($forum_r as $fk => $fv) {

        //If the par is not empty and its not the first post and it is a post in this topic
        if (!empty($forum_r[$fk]['par_board_id']) && in_array($forum_r[$fk]['par_board_id'], array_keys($forum_r))) {

            $parents[$forum_r[$fk]['par_board_id']][] = $fk;

            //No parent was found - Push(If cant see parents no children also)
        } elseif (empty($forum_r[$fk]['par_board_id'])) {

            $parents[0][] = $fk;
        }


        //Insert the moderators
        if (isset($mods['fid' . $forum_r[$fk]['fid']])) {

            @$forum_r[$fk]['moderators'] = $mods['fid' . $forum_r[$fk]['fid']];
        }

        $read = 1;

        //Are there any posts
        if (!empty($forum_r[$fk]['pid'])) {

            if ($logged_in) {

                $tmp_r = array($forum_r[$fk]['ptime']);

                //If a particular forum is read
                if (isset($forum_r[$fk]['rf_time']) &&
                        !empty($forum_r[$fk]['rf_time'])) {

                    $tmp_r[] = $forum_r[$fk]['rf_time'];
                }


                //If the whole board is read
                if (isset($forum_r[$fk]['rb_time']) &&
                        !empty($forum_r[$fk]['rb_time'])) {

                    $tmp_r[] = $forum_r[$fk]['rb_time'];
                }

                if ((max($tmp_r) == $forum_r[$fk]['ptime']) &&
                        ($forum_r[$fk]['poster_id'] != $user['id'])) {

                    $read = 0;
                }
            }
        }

        $forum_r[$fk]['is_read'] = $read;


        //Make a place for the final total posts
        $forum_r[$fk]['ft_posts'] = $forum_r[$fk]['nposts'];

        $forum_r[$fk]['ft_topic'] = $forum_r[$fk]['ntopic'];
    }//End the for loop

    $r_fid = array();

    foreach ($parents as $par => $kid) {
        if (!empty($par)) {
            $kid = array_reverse($kid);
        }
        foreach ($kid as $k => $v) {
            //If there is a parent found in the forums - Array Splice
            if (in_array('fid' . $par, array_keys($r_fid))) {
                //Insert in between
                array_insert($r_fid, find_pos($r_fid, 'fid' . $par), array('fid' . $v => $v));
                //No parent was found - Push
            } else {
                $r_fid['fid' . $v] = $v;
            }
        }
    }
    $in_board = array();

    foreach ($r_fid as $k => $v) {

        $level = 0;

        $par = $forum_r[$v]['par_board_id'];

        //Find the level
        while (true) {

            if (!empty($par) && in_array($par, array_keys($forum_r))) {

                $par = $forum_r[$par]['par_board_id'];

                $level = $level + 1;
            } else {

                $forum_r[$v]['board_level'] = $level;

                break;
            }
        }


        //Is it a inboard - Backward Compatibilty
        if ($level > 0) {

            $forum_r[$v]['in_board'] = 1;

            $in_board[$v] = $forum_r[$v];
        } else {

            $forum_r[$v]['in_board'] = 0;
        }

        //Check is the Category ID even there
        if (empty($forums[$forum_r[$v]['cid']])) {

            $forums[$forum_r[$v]['cid']] = array();
        }

        $forums[$forum_r[$v]['cid']]['fid' . $forum_r[$v]['fid']] = $forum_r[$v];
    }

    if (!empty($in_board)) {

        ///////////////////////////////////
        // We have to Insert the In Boards
        ///////////////////////////////////

        foreach ($in_board as $i => $iv) {

            $parentid = 'fid' . $in_board[$i]['par_board_id'];

            $n = $in_board[$i]['cat_id'];

            //If the board is viewable
            if (isset($forums[$n][$parentid])) {

                if (!array_key_exists('in_boards', $forums[$n][$parentid])) {

                    $forums[$n][$parentid]['in_boards'] = array();
                }

                $forums[$n][$parentid]['in_boards'][$in_board[$i]['fid']] = $in_board[$i];

                //Should we add the post count to the parent
                if ($globals['countinboardposts']) {

                    $forums[$n][$parentid]['ft_posts'] += $in_board[$i]['nposts'];

                    $forums[$n][$parentid]['ft_topic'] += $in_board[$i]['ntopic'];
                }
            }
        }
    }

    return true;
}

///////////////////////////////////////
// Deletes the array of Forum id given
// Note: 1) Assumes the Forum exists
///////////////////////////////////////

function delete_forums_fn($fids) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    //Make them unique also
    $fids = array_unique($fids);

    array_multisort($fids);

    $fids_str = implode(', ', $fids);

    if (empty($fids)) {

        return false;
    }


    ////////////////////
    //DELETE the Forums
    ////////////////////

    $qresult = makequery("DELETE FROM " . $dbtables['forums'] . "
                    WHERE fid IN ($fids_str)", false);

    //How many were deleted ?
    $deleted = mysql_affected_rows($conn);

    if ($deleted != count($fids)) {

        return false;
    }


    //Bring the topics of the forums out
    $qresult = makequery("SELECT tid
            FROM " . $dbtables['topics'] . "
            WHERE t_bid IN ($fids_str)");

    //Were there any topics
    if (mysql_num_rows($qresult) > 0) {

        $topics = array();

        for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

            $row = mysql_fetch_assoc($qresult);

            $topics[] = $row['tid'];
        }

        //Free the resources
        @mysql_free_result($qresult);


        ////////////////////
        //DELETE the Topics
        ////////////////////

        if (!delete_topics($topics, array('update_forum_topic_post_count' => false,
                    'reduce_user_post_count' => true))) {

            return false;
        }
    }


    ////////////////////////////////
    // DELETE the Forum Permissions
    ////////////////////////////////

    $qresult = makequery("DELETE FROM " . $dbtables['forumpermissions'] . "
                    WHERE fpfid IN ($fids_str)", false);


    ////////////////////////////////////////
    // DELETE the Marked Read Forum History
    ////////////////////////////////////////

    $qresult = makequery("DELETE FROM " . $dbtables['mark_read'] . "
                    WHERE mr_fid IN ($fids_str)", false);


    /////////////////////////
    // DELETE the Moderators
    /////////////////////////

    $qresult = makequery("DELETE FROM " . $dbtables['moderators'] . "
                    WHERE mod_fid IN ($fids_str)", false);


    ////////////////////////////
    // DELETE the notifications
    ////////////////////////////

    $qresult = makequery("DELETE FROM " . $dbtables['notify_forum'] . "
                    WHERE notify_fid IN ($fids_str)", false);


    //Looks like everything went well
    return true;
}

///////////////////////////////////////
// Reorders the first level In-Boards
// of Forum id given and the Category
// given
///////////////////////////////////////

function reorderchildren_fn($par, $cat) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    ////////////////////////
    // SELECT the In-Boards
    ////////////////////////

    $qresult = makequery("SELECT fid
                    FROM " . $dbtables['forums'] . "
                    WHERE par_board_id = '$par'
                    AND cat_id = '$cat'
                    ORDER BY forum_order ASC");

    //Did we find some children
    if (mysql_num_rows($qresult) < 1) {

        return false;
    }

    //The loop to draw out the rows
    for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

        $row = mysql_fetch_assoc($qresult);

        $fids[$i] = $row['fid'];

        unset($row);
    }//End of main for loop
    ////////////////////////
    // UPDATE the In-Boards
    ////////////////////////
    //The loop to draw out the rows
    for ($i = 1; $i <= count($fids); $i++) {

        $qresult = makequery("UPDATE " . $dbtables['forums'] . " SET
                            forum_order = '$i'
                            WHERE fid = '" . $fids[$i] . "'
                            LIMIT 1", false);
    }//End of main for loop

    return true;
}

//Marks that the user has read the forum
function read_forum_fn($fid, $view_time) {

    global $logged_in, $dbtables, $globals, $user, $conn, $l, $board, $tid;

    //Call the Language function
    read_forum_fn_lang();

    //REPLACE that the user has read the FORUM
    if ($logged_in) {

        //Well we just need to make a query
        /////////////////////////////////
        // REPLACE the users row in table
        /////////////////////////////////

        $qresult = makequery("REPLACE INTO " . $dbtables['read_forums'] . "
                    SET rf_uid = '" . $user['id'] . "',
                    rf_fid = '$fid',
                    rf_time = '$view_time'", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['read_forum_error_title'], $l['read_forum_error']);

            return false;
        }

        return true;
    } else {

        return true;
    }//End of if($logged_in)
}

//Checks whether the moderator is_mod
function is_mod_fn() {

    global $logged_in, $dbtables, $globals, $user, $conn, $l, $board;

    //Call the Language function
    is_mod_fn_lang();

    ///////////////////////////////////////////
    // We need to check is the user
    // a moderator of this board.
    // If it is load the moderator permissions
    ///////////////////////////////////////////

    $is_mod = false;

    if ($logged_in) {

        if (!empty($board['moderators'])) {

            foreach ($board['moderators'] as $m => $mv) {

                if ($mv['mod_mem_id'] == $user['id']) {

                    $is_mod = true;

                    break;
                }
            }
        }
    }


    //If he is a moderator and not admin load the Moderator Forum and User Permissions
    if ($is_mod && !$user['can_admin']) {

        //First take out the Forum Permissions
        $qresult = makequery("SELECT * FROM " . $dbtables['forumpermissions'] . "
                    WHERE fpfid = '" . $board['fid'] . "'
                    AND fpugid = '3'");

        if (mysql_num_rows($qresult) > 0) {

            $forumpermissions = mysql_fetch_assoc($qresult);

            //Free the resources
            @mysql_free_result($qresult);

            //Lets merge the user array
            $board = array_merge($board, $forumpermissions);
        }

        //Then take out the User Permissions
        $qresult = makequery("SELECT ug.*, p.*
            FROM " . $dbtables['user_groups'] . " ug
            LEFT JOIN " . $dbtables['permissions'] . " p ON (p.member_group_id = '3')
            WHERE ug.member_group = '3'");

        if (mysql_num_rows($qresult) < 1) {

            //Show a major error and return
            reporterror($l['load_moderator_error_title'], $l['load_moderator_error']);

            return false;
        } else {

            $permissions = mysql_fetch_assoc($qresult);

            //Free the resources
            @mysql_free_result($qresult);

            //Lets merge the user array
            $user = array_merge($user, $permissions);

            return true;
        }
    } else {

        return true;
    }
}

function board_fn($fid) {

    global $globals, $theme, $dbtables, $conn, $categories, $forums, $user, $logged_in;

    if (empty($forums)) {

        //Load the board
        if (!default_of_nor(false, false)) {

            return false;
        }
    }

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

    return $board;
}

//RETURNs the last post of a forum
function last_post_forum_fn($fid) {

    global $logged_in, $dbtables, $globals, $user, $conn, $l, $board;

    //SELECT the Last post of that FORUM
    $qresult = makequery("SELECT * FROM " . $dbtables['posts'] . "
                    WHERE post_fid = '$fid'
                    ORDER BY pid DESC
                    LIMIT 0, 1");

    if (mysql_num_rows($qresult) < 1) {
        return array('pid' => 0);
    }

    $row = mysql_fetch_assoc($qresult);

    return $row;
}

?>
