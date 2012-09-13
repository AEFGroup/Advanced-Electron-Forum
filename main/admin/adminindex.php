<?php

//////////////////////////////////////////////////////////////
//===========================================================
// adminindex.php
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

function adminindex() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    if (!load_lang('admin/adminindex')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'admin/adminindex';

    //The name of the Page
    $theme['init_theme_name'] = 'Admin Center Index';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('adminindex_theme',
        'credits_theme');

    //My activity
    $globals['last_activity'] = 'ai';

    //If a second Admin act is set then go by that
    if (isset($_GET['seadact']) && trim($_GET['seadact']) !== "") {

        $seadact = inputsec(htmlizer(trim($_GET['seadact'])));
    } else {

        $seadact = "";
    }


    //The switch handler
    switch ($seadact) {

        //Default
        default:
            $theme['call_theme_func'] = 'adminindex_theme';
            break;

        //Credits
        case 'credits':
            $theme['call_theme_func'] = 'credits_theme';
            break;
    }
}

?>
