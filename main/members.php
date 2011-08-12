<?php

//////////////////////////////////////////////////////////////
//===========================================================
// members.php
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

//////////////////////////////////////
// List of the members of the board
//////////////////////////////////////


function members() {
    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $members, $count, $tree, $group;

    //Load the Language File
    if (!load_lang('members')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'members';

    //The name of the Page
    $theme['init_theme_name'] = 'Registered Members';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('members_theme');


    /////////////////////////////////////////
    //This section is only for permitted users
    if (!$user['view_members']) {

        //Show a major error and return
        reporterror($l['cant_view_members_title'], $l['cant_view_members']);

        return false;
    }
    /////////////////////////////////////////
    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $members = array();

    $where = array();

    $tree = array(); //Board tree for users location
    $tree[] = array('l' => $globals['index_url'],
        'txt' => $l['index']);
    $tree[] = array('l' => $globals['index_url'] . 'act=members',
        'txt' => $l['members_list'],
        'prefix' => $l['viewing_prefix']);

    //He is viewing members list
    $globals['last_activity'] = 'ml';

    //Checks the Page to see
    $page = get_page('mpg', $globals['maxmemberlist']);

    //Array keys to sort the board
    $sort = array(1 => 'u.username', //Username
        2 => 'u.u_member_group', //Member Group ID
        3 => 'u.r_time', //Registration Time
        4 => 'u.posts', //Posts
        5 => 's.time'); //Online time

    $orderby = array(1 => 'ASC',
        2 => 'DESC');


    //Checks to sort the Member List by............
    if (isset($_GET['sortby']) && trim($_GET['sortby']) != "" && is_numeric(trim($_GET['sortby']))) {

        $sortbytmp = (int) inputsec(htmlizer(trim($_GET['sortby'])));

        if (array_key_exists($sortbytmp, $sort)) {

            $sortby = $sort[$sortbytmp];

            $sortbylink = $sortbytmp;
        } else {

            $sortby = $sort[1];
        }
    } else {

        $sortby = $sort[1];
    }


    //ASCENDING or DESCENDING
    if (isset($_GET['order']) && trim($_GET['order']) != "" && is_numeric(trim($_GET['order']))) {

        $ordertmp = (int) inputsec(htmlizer(trim($_GET['order'])));

        if (array_key_exists($ordertmp, $orderby)) {

            $order = $orderby[$ordertmp];
        } else {

            $order = $orderby[1];
        }
    } else {

        $order = $orderby[1];
    }


    //Beginning with
    if (isset($_GET['beg']) && trim($_GET['beg']) != "") {

        $beg = inputsec(htmlizer(trim($_GET['beg'])));

        //Replace spaces and special characters
        $beg = preg_replace(array('/%/', '/_/', '/\s/'), array('\\%', '\_', '%'), $beg);

        $where[] = "u.username LIKE '" . $beg . "%'";
    }


    //Which groups
    if (isset($_GET['group']) && trim($_GET['group']) != "") {

        $group = inputsec(htmlizer(trim($_GET['group'])));

        if ($group >= 0) {

            $where[] = "u.u_member_group = '$group'";
        }
    }

    //Get the Number of pages that can be formed
    $qresult = makequery("SELECT COUNT(id) AS pages
                FROM " . $dbtables['users'] . " u
                " . (empty($where) ? '' : "WHERE " . implode(" AND ", $where)));

    $temp = mysql_fetch_assoc($qresult);

    $count = $temp['pages'];

    //Free the resources
    @mysql_free_result($qresult);


    //Get the Members
    $qresult = makequery("SELECT u.id, u.username, u.posts, u.r_time, ug.mem_gr_name,
                ug.mem_gr_colour, s.time
                FROM " . $dbtables['users'] . " u
                LEFT JOIN " . $dbtables['user_groups'] . " ug ON (ug.member_group = u.u_member_group)
                LEFT JOIN " . $dbtables['sessions'] . " s ON (u.id = s.uid)
                " . (empty($where) ? '' : "WHERE " . implode(" AND ", $where)) . "
                ORDER BY " . $sortby . " " . $order . "
                LIMIT $page, " . $globals['maxmemberlist']);

    if (mysql_num_rows($qresult) < 1) {

        //If it is not the first page - then you specified an invalid link
        if ($page > 0) {

            //Show a major error and return
            reporterror($l['no_page_found_title'], $l['no_page_found']);

            return false;
        }

        //Lets bring out the list
    } else {

        for ($i = 0; $i < mysql_num_rows($qresult); $i++) {

            $row = mysql_fetch_assoc($qresult);

            $members[$row['id']] = $row;
        }
    }

    $theme['call_theme_func'] = 'members_theme';
}

?>
