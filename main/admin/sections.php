<?php

//////////////////////////////////////////////////////////////
//===========================================================
// sections.php(Admin)
//===========================================================
// AEF : Advanced Electron Forum
// Version : 1.1
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

function core(){
	 global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    if (!load_lang('admin/sections')) {
        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'admin/sections';

    //The name of the Page
    $theme['init_theme_name'] = 'Admin Center - Core Center';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('core_section',
                                    'options_center_theme',
                                    'plugins_center_theme');

    $theme['call_theme_func'] = 'core_section';

    //If a second Admin act is set then go by that
    if (isset($_GET['seadact']) && trim($_GET['seadact']) !== "") {

        $seadact = inputsec(htmlizer(trim($_GET['seadact'])));
    } else {

        $seadact = "";
    }

    $actionsArray = array(
        'optionscenter' => array('', 'options_center'),
        'pluginscenter' => array('', 'plugins_center'),
        'themescenter' => array('', 'themes_center'),
        'languagescenter' => array('', 'languages_center'),
    );

    if (!empty($seadact)) {
            $actionsArray[$seadact][1]();
    }
}

function external(){
     global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    if (!load_lang('admin/sections')) {
        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'admin/sections';

    //The name of the Page
    $theme['init_theme_name'] = 'Admin Center - External Center';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('external_section',
                                    'themes_center_theme',
                                    'languages_center_theme');

    $theme['call_theme_func'] = 'external_section';



    //If a second Admin act is set then go by that
    if (isset($_GET['seadact']) && trim($_GET['seadact']) !== "") {

        $seadact = inputsec(htmlizer(trim($_GET['seadact'])));
    } else {

        $seadact = "";
    }

    $actionsArray = array(
        'themescenter' => array('', 'themes_center'),
        'languagescenter' => array('', 'languages_center'),
    );

    if (!empty($seadact)) {
            $actionsArray[$seadact][1]();
    }
}

function content(){
     global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    if (!load_lang('admin/sections')) {
        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'admin/sections';

    //The name of the Page
    $theme['init_theme_name'] = 'Admin Center - Content Center';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('content_section');

    $theme['call_theme_func'] = 'content_section';



    //If a second Admin act is set then go by that
    if (isset($_GET['seadact']) && trim($_GET['seadact']) !== "") {

        $seadact = inputsec(htmlizer(trim($_GET['seadact'])));
    } else {

        $seadact = "";
    }

    $actionsArray = array(
        'themescenter' => array('', 'themes_center'),
        'languagescenter' => array('', 'languages_center'),
    );

    if (!empty($seadact)) {
            $actionsArray[$seadact][1]();
    }
}

function options_center(){
    global $theme;
    $theme['call_theme_func'] = 'options_center_theme';

}

function plugins_center(){
    global $theme;
    $theme['call_theme_func'] = 'plugins_center_theme';

}

function languages_center(){
    global $theme;
    $theme['call_theme_func'] = 'languages_center_theme';

}

function themes_center(){
    global $theme;
    $theme['call_theme_func'] = 'themes_center_theme';

}