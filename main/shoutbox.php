<?php

//////////////////////////////////////////////////////////////
//===========================================================
// shoutbox.php
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

////////////////////////
// Handles the shoutbox
////////////////////////

function shoutbox() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    //The name of the file
    $theme['init_theme'] = 'shoutbox';

    //The name of the Page
    $theme['init_theme_name'] = 'Shoutbox Theme';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('showshout_theme');

    if (empty($globals['enableshoutbox'])) {

        return false;
    }

    //Stop the output buffer
    $globals['stop_buffer_process'] = true;

    //Perform a session cleanup time tracker
    if (empty($AEF_SESS['dest_shouts'])) {

        $AEF_SESS['dest_shouts'] = time();
    }


    if (!empty($globals['shoutboxtime']) && (time() - $AEF_SESS['dest_shouts']) > 15 * 60) {

        //Perform a Cleanup
        $qresult = makequery("DELETE FROM " . $dbtables['shouts'] . "
                    WHERE shtime <  " . (time() - ($globals['shoutboxtime'] * 60)));

        //Update the destroy time
        $AEF_SESS['dest_shouts'] = time();
    }


    //If a shoutact act has been set
    if (isset($_GET['shoutact']) && trim($_GET['shoutact']) !== "") {

        $shoutact = trim($_GET['shoutact']);
    } else {

        $shoutact = "";
    }

    //The switch handler
    switch ($shoutact) {

        default:
        case 'showshout':
            showshout();
            break;

        case 'addshout':
            addshout();
            break;

        case 'deleteshout':
            deleteshout();
            break;
    }
}

function showshout() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $shouts;

    $shouts = array();

    $theme['call_theme_func'] = 'showshout_theme';

    //Can he not shout then dont show
    if (empty($user['can_shout'])) {

        return false;
    }


    if (!empty($_GET['last']) && is_numeric(trim($_GET['last']))) {

        $last = (int) inputsec(htmlizer(trim($_GET['last'])));
    } else {

        $last = -1; //-1 is used due to arrays
    }

    //IF it is a reload or first-load return the number of shouts set
    if ($last == -1) {

        $qresult = makequery("SELECT sh.*, u.username
                    FROM " . $dbtables['shouts'] . " sh
                    LEFT JOIN " . $dbtables['users'] . " u ON (sh.shuid = u.id)
                    ORDER BY sh.shid DESC
                    LIMIT 0, " . $globals['shouts']);
    } else {

        $qresult = makequery("SELECT sh.*, u.username
                    FROM " . $dbtables['shouts'] . " sh
                    LEFT JOIN " . $dbtables['users'] . " u ON (sh.shuid = u.id)
                    WHERE sh.shid > " . $last . "
                    ORDER BY sh.shid DESC");
    }


    for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

        $row = mysql_fetch_assoc($qresult);

        //Is the shout by a guest
        if ($row['shuid'] == -1) {

            $row['username'] = 'Guest';
        }

        //Is normal bbc allowed
        if (!empty($globals['shoutbox_nbbc'])) {

            $row['shtext'] = format_text($row['shtext']);
        }

        //Is special bbc allowed
        if (!empty($globals['shoutbox_sbbc'])) {

            $row['shtext'] = parse_special_bbc($row['shtext']);
        }

        //Are smileys allowed(Takes a query)
        if (!empty($globals['shoutbox_emot'])) {

            $row['shtext'] = smileyfy($row['shtext']);
        }

        $row['shtext'] = parse_br($row['shtext']);

        //We must addslashes
        foreach ($row as $k => $v) {

            $row[$k] = addslashes($v);
        }

        $shouts[$row['shid']] = $row;

        unset($row);
    }

    $shouts = array_reverse($shouts, true);
}

function addshout() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $addedshout;

    $addedshout = false;

    $shouts = array();

    $theme['call_theme_func'] = 'addshout_theme';

    //Can he shout
    if (empty($user['can_shout'])) {

        return false;
    }

    if (isset($_GET['shout']) && trim($_GET['shout']) != "") {

        $shout = inputsec(htmlizer($_GET['shout']));
    } else {
        return false;
    }

    $uid = (empty($logged_in) ? -1 : $user['id']);
    
    $uColorRef = makequery("SELECT mem_gr_colour FROM " . $dbtables['user_groups'] . " WHERE member_group = " . $user['u_member_group'] . " LIMIT 1");

    if (mysql_num_rows($uColorRef) == 0) {
        return false;
    }
    
    $assoc = mysql_fetch_assoc($uColorRef);
    
    $color = $assoc['mem_gr_colour'];
    
    @mysql_free_result($uColorRef); 
    
    $qresult = makequery("INSERT INTO " . $dbtables['shouts'] . "
                    SET shtime = " . time() . ",
                    shuid = '$uid',
                    shtext = '$shout',
                    shucolor = '$color'");

    $shid = mysql_insert_id($conn);

    //Return true if added
    if (!empty($shid)) {

        $addedshout = true;
    }
}

function deleteshout() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $deletedshout;

    $deletedshout = false;

    $shouts = array();

    $theme['call_theme_func'] = 'deleteshout_theme';

    //Can he delete shout
    if (empty($user['can_del_shout'])) {

        return false;
    }

    if (isset($_GET['shoutid']) && trim($_GET['shoutid']) !== "") {

        $get_shoutids = inputsec(htmlizer(trim($_GET['shoutid'])));

        $shoutids = explode(',', $get_shoutids);
    } else {

        return false;
    }

    //Clean the $shoutids
    foreach ($shoutids as $k => $v) {

        //Make it integer
        $shoutids[$k] = (int) trim($v);
    }

    //Make them unique also
    $shoutids = array_unique($shoutids);

    array_multisort($shoutids);

    //DELETE
    $qresult = makequery("DELETE FROM " . $dbtables['shouts'] . "
                    WHERE shid IN (" . implode(', ', $shoutids) . ")");


    //Save the shout box
    if (mysql_affected_rows($conn) > 0) {

        $deletedshout = true;
    }
}

?>
