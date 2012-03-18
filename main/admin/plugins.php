<?php

//////////////////////////////////////////////////////////////
//===========================================================
// conpan.php(Admin)
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

//some needed administration functions !
require_once('admin_functions.php');

function plugins() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    if (!load_lang('admin/plugins')) {

        return false;
    }
    
    //The name of the file
    $theme['init_theme'] = 'admin/plugins';

    //The name of the Page
    $theme['init_theme_name'] = $l['list_page_title'];
    $theme['init_theme_func'] = '';
    $theme['call_theme_func'] = 'list_plugins';
    
}

?>
