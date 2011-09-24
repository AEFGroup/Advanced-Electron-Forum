<?php

//////////////////////////////////////////////////////////////
//===========================================================
// recyclebin.php
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

function recyclebin() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $mother_options, $forums, $categories, $error;

    if (!load_lang('admin/recyclebin')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'admin/recyclebin';

    //The name of the Page
    $theme['init_theme_name'] = 'Admin Center - Recycle Bin Settings';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('recyclebin_global',
        'recyclebin_theme');

    //My activity
    $globals['last_activity'] = 'arb';

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $rbfid = 0;

    if (!default_of_nor(true, false)) {

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


    //Lets process
    if (isset($_POST['setrecyclebin'])) {

        //Check the Forum is set
        if (!(isset($_POST['rbfid'])) || (trim($_POST['rbfid']) == "")) {

            $error[] = $l['forum_no_posted'];
        } else {

            $rbfid = (int) inputsec(htmlizer(trim($_POST['rbfid'])));

            if (!empty($rbfid) && !in_array($rbfid, $forum_ids)) {

                $error[] = $l['forum_invalid'];
            }
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'createfpermissions_theme';
            return false;
        }


        ////////////////////////////////////
        // Finally lets UPDATE the Registry
        ////////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['registry'] . "
                    SET    regval = '$rbfid'
                    WHERE name = 'recyclebin'
                    LIMIT 1", false);

        /////////////////////////////////
        // UPDATE the recycle bin forum
        /////////////////////////////////
        //////////////////////////////////
        // NOTE : This is done for the
        // reason that when deleting a
        // topic or post the users post
        // count should not be deducted
        // as it is already reduced.
        //////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                    SET    inc_mem_posts = '0'
                    WHERE fid = '$rbfid'", false);

        ////////////////////////////////////
        // UPDATE the old recycle bin forum
        ////////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['forums'] . "
                    SET    inc_mem_posts = '1'
                    WHERE fid = '" . $globals['recyclebin'] . "'", false);


        //Redirect
        redirect('act=admin');

        return true;
    } else {

        $theme['call_theme_func'] = 'recyclebin_theme';
    }
}
