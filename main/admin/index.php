<?php

//////////////////////////////////////////////////////////////
//===========================================================
// index.php(Admin)
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


if (!load_lang('admin/index')) {

    return false;
}
require('admin_functions.php');

//Can he admin
if (!$user['can_admin']) {

    //Show a major error and return
    reporterror($l['no_permissions'], $l['no_view_section']);

    return false;
}

$tree = array(); //Board tree for users location
$tree[] = array('l' => $globals['index_url'],
    'txt' => $l['index']);
$tree[] = array('l' => $globals['index_url'] . 'act=admin',
    'txt' => $l['admin_']);

$load_ahf = true;


//Checks a admin session
include_once($globals['mainfiles'] . '/admin/adminlogin.php');
$admin_logged_in = adminlogin();

if (empty($admin_logged_in)) {

    return false;
}


if (isset($_GET['adact']) && trim($_GET['adact']) !== "") {

    $adact = inputsec(htmlizer(trim($_GET['adact'])));
} else {

    $adact = "";
}

$actionsArray = array(
	'coresection' => array('sections.php', 'core'),
	'externalsection' => array('sections.php', 'external'),
	'contentsection' => array('sections.php', 'content'),
	'memberssection' => array('sections.php', 'members'),
    'plugins' => array('plugins.php', 'plugins'),
    'conpan' => array('conpan.php', 'conpan'),
    'categories' => array('categories.php', 'categories'),
    'forums' => array('forums.php', 'forums'),
    'fpermissions' => array('forumpermissions.php', 'forumpermissions'),
    'moderators' => array('moderators.php', 'moderators'),
    'recyclebin' => array('recyclebin.php', 'recyclebin'),
	'approvals' => array('approvals.php', 'approvals'),
    'users' => array('users.php', 'users'),
    'ug' => array('usergroups.php', 'usergroups'),
    'skin' => array('skin.php', 'skin'),
    'attach' => array('attachments.php', 'attachments'),
    'reglog' => array('reglog.php', 'reglog'),
    'smileys' => array('smileys.php', 'smileys'),
    'tpp' => array('tpp.php', 'tpp'),
    'backup' => array('backup.php', 'backup'),
    '' => array('adminindex.php', 'adminindex'),
    
);

if (isset($adact)) {
    //check first if the file really exists
    if (isset($actionsArray[$adact][0]) && file_exists($globals['mainfiles'] . '/admin/' . $actionsArray[$adact][0])) {
        //include the file
        include_once $globals['mainfiles'] . '/admin/' . $actionsArray[$adact][0];
        //execute the function
        if (!empty($actionsArray[$adact][1])) {
            $actionsArray[$adact][1]();
        }
    }
}

?>
