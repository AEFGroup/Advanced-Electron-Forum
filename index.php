<?php

//////////////////////////////////////////////////////////////
//===========================================================
// index.php
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

define('AEF', 1);

$user = array();
$theme = array();

//This causes some probems
ini_set('magic_quotes_runtime', 0);
ini_set('magic_quotes_sybase', 0);

//Set a error reporting to zero
error_reporting(E_ALL);

//fix errors regarding timezone
if (!ini_get('date.timezone')) {
    ini_set('date.timezone', 'Europe/Berlin');
}

//All imp info like DB username & pass.
include_once('universal.php');

//Some globals vars
include_once('globals.php');

//check if the script is installed or not - SAFAD
if ($globals['installed'] == 0)
    die(header('Location: setup/index.php'));

//Make the connection
$conn = mysql_connect($globals['server'], $globals['user'], $globals['password']);
mysql_select_db($globals['database'], $conn) or die("Unable to select database");

//A array of DB Tables prefixed with the prefix
include_once($globals['server_url'] . '/dbtables.php');

//The necessary functions to run the Board
include_once($globals['mainfiles'] . '/functions.php');

//include the csrf protection (thanks csrf magic library <3)
include_once($globals['mainfiles'] . '/csrf_protection.php');
//plugins
include_once($globals['mainfiles'] . '/plugin.php');
initiate_plugins();

//ob_start('aefoutput_buffer');
//Will be available in future versions
//set_error_handler('errorhandler');

$start_time = microtime_float(); //the clocks ticking
//////////////////////////////////////////
// Some settings are there in the registry
//////////////////////////////////////////

$qresult = makequery("SELECT r.*
        FROM " . $dbtables['registry'] . " r");


if ((mysql_num_rows($qresult) > 0)) {

    for ($i = 0; $i < mysql_num_rows($qresult); $i++) {

        $row = mysql_fetch_assoc($qresult);

        $globals[$row['name']] = $row['regval'];
    }
}

//Free the resources
@mysql_free_result($qresult);

SEO();

//This is required for UTF-8
if ($globals['charset'] == 'UTF-8')
    mysql_query('SET NAMES utf8');

if (isset($_GET['tid']) && trim($_GET['tid']) !== "") {
    $act = 'tid';
    $tid = trim($_GET['tid']);
} elseif (isset($_GET['fid']) && trim($_GET['fid']) !== "") {
    $act = 'fid';
    $fid = trim($_GET['fid']);
} elseif (isset($_GET['mid']) && trim($_GET['mid']) !== "") {
    $act = 'mid';
} elseif (isset($_GET['act']) && trim($_GET['act']) !== "") {
    $act = trim($_GET['act']);
} else {
    $act = "";
}

header("Content-Type:text/html; charset=" . $globals['charset']);

//Load the Functions Language File - This will be from the default Lang Folder
load_lang('index');

//Load Session File
include_once($globals['mainfiles'] . '/sessions.php');

//Checks a user is logged in
include_once($globals['mainfiles'] . '/checklogin.php');

//Is the user Logged In
$logged_in = checklogin();

//ReLoad the Functions Language File as per the users choice
load_lang('index');

//Check the BANNED IPs
BANNED();

//The URL for W3C Validation - Even present before loading themes
$globals['ind'] = str_replace('&', '&amp;', $globals['index_url']);

////////////////////////////////////////
// Is the user allowed to see the forum
////////////////////////////////////////

if ($logged_in && !$user['view_forum'] && $act != 'logout') {

    //Report Error
    reporterror($l['cant_view_forum_title'], $l['cant_view_forum']);
}


/////////////////////////////////////
// Are we under going maintainenance
// then only Admins are allowed
/////////////////////////////////////

if ($globals['maintenance'] && !$user['view_offline_board']) {

    //During maintainenace what is to be allowed
    if (!in_array($act, array('login', 'sec_conf_image'))) {

        //Redirect to log in
        redirect('act=login');
    }
}


/////////////////////////////////////
// IF only users allowed to view the
// forum then allow registration and
// login activities.
/////////////////////////////////////

if ($globals['only_users'] && !$logged_in) {

    //What is to be allowed in such times
    if (!in_array($act, array('login', 'register', 'sec_conf_image'))) {

        //Redirect to log in
        redirect('act=login');
    }
}

//this part is copied from another project of mine and it was inspired from SMF, thank you both (SAFAD and SMF) +P
$actionsArray = array(
    '' => array('MainIndex.php', 'MainIndex'),
    'admin' => array('admin/index.php'),
    'news' => array('news.php', 'news'),
    'mid' => array('profile.php', 'profile'),
    'deleteuser' => array('delete.php', 'deleteuser'),
    'ban' => array('ban.php', 'ban'),
    'editprofile' => array('editprofile.php', 'editprofile'),
    'members' => array('members.php', 'members'),
    'active' => array('active.php', 'active'),
    /* 'stats'               => array('stats.php', 'stats'), */
    'unread' => array('unread.php', 'unread'),
    'search' => array('search.php', 'search'),
    'downloadattach' => array('attachments.php', 'download'),
    'markread' => array('markread.php', 'markread'),
    'register' => array('register.php', 'register'),
    'login' => array('login.php', 'login'),
    'logout' => array('logout.php', 'logout'),
    'sec_conf_image' => array('imagemaker.php', 'regimagemaker'),
    'fid' => array('topics.php', 'topics'),
    'notify' => array('notify.php', 'notify'),
    'tid' => array('posts.php', 'posts'),
    'locktopic' => array('locktopic.php', 'locktopic'),
    'pintopic' => array('pintopic.php', 'pintopic'),
    'edittopic' => array('edittopic.php', 'edittopic'),
    'mergetopics' => array('mergetopics.php', 'mergetopics'),
    'edit' => array('editpost.php', 'editpost'),
    'mergeposts' => array('mergeposts.php', 'mergeposts'),
    'delete' => array('delete.php', 'delete'),
    'removepoll' => array('poll.php', 'removepoll'),
    'editpoll' => array('poll.php', 'editpoll'),
    'postpoll' => array('poll.php', 'postpoll'),
    'tellafriend' => array('tellafriend.php', 'tellafriend'),
    'topic' => array('newtopic.php', 'newtopic'),
    'deletetopic' => array('deletetopic.php', 'deletetopic'),
    'movetopic' => array('movetopic.php', 'movetopic'),
    'post' => array('reply.php', 'reply'),
    'usercp' => array('usercp/index.php', 'usercp'),
    'suggest' => array('suggest.php', 'suggest'),
    'shoutbox' => array('shoutbox.php', 'shoutbox'),
    'feeds' => array('feeds.php', 'feeds'),
    'calendar' => array('calendar.php', 'calendar'),
    'report' => array('report.php', 'report'),
    'active' => array('active.php', 'active'),
    'active' => array('active.php', 'active'),
);

if (isset($act)) {
    //check first if the file really exists
    if (isset($actionsArray[$act][0]) && file_exists($globals['mainfiles'] . '/' . $actionsArray[$act][0])) {
        //include the file
        include_once $globals['mainfiles'] . '/' . $actionsArray[$act][0];
        //execute the function
        if (!empty($actionsArray[$act][1])) {
            $actionsArray[$act][1]();
        }
    }
}

//We must try to save the session
save_session();

//I Finished first
$end_time = microtime_float();

//Clean For XSS and Extra Slashes('\') if magic_quotes_gpc is ON
$_GET = cleanVARS($_GET);
$_POST = cleanVARS($_POST);


///////////////////////////
// Load the theme settings
///////////////////////////

load_theme_settings($globals['theme_id']);

//The URL for W3C Validation
$globals['ind'] = str_replace('&', '&amp;', $globals['index_url']);

///////////////////////////////////////
// Load the theme's headers and footers
///////////////////////////////////////

if (!empty($load_hf) && init_theme('hf', 'Headers and Footers')) {

    //Finally the file is loaded
    if (init_theme_func(array('aefheader',
                'aeffooter',
                'error_handle',
                'majorerror',
                'message'), 'Headers and Footers')) {

        $globals['hf_loaded'] = 1;
    }
}


/////////////////////////////////////////////////////
// Load the Admin Center theme's headers and footers
/////////////////////////////////////////////////////

if (!empty($load_ahf) && init_theme('admin/adminhf', 'Admin Center Headers and Footers')) {

    //Finally the file is loaded
    init_theme_func(array('adminhead', 'adminfoot'), 'Admin Center Headers and Footers');
}


///////////////////////////////////////
// Load the UserCP headers and footers
///////////////////////////////////////

if (!empty($load_uhf) && init_theme('usercp/usercphf', 'UserCP Headers and Footers')) {

    //Finally the file is loaded
    init_theme_func(array('usercphead', 'usercpfoot'), 'UserCP Headers and Footers');
}


//Are we to load any theme or just pass
if (!empty($theme['init_theme']) && empty($errormessage)
        && empty($messagetext) && empty($redirect) && $globals['hf_loaded']) {

    //Initialize the theme
    if (init_theme($theme['init_theme'], $theme['init_theme_name'])) {

        //Initialize the Theme function
        if (init_theme_func($theme['init_theme_func'], $theme['init_theme_name'])) {

            /////////////////////////
            // Load all other things
            /////////////////////////
            //Load the news if there
            if ($globals['enablenews']) {

                include_once($globals['mainfiles'] . '/news.php');

                $newslinks = newslinks();
            }

            call_user_func($theme['call_theme_func']);
        }
    }
}


////////////////////////////////////////
// Check is some error triggered before
////////////////////////////////////////

if (!empty($errormessage)) {

    if ($globals['hf_loaded']) {

        //Call Major Error
        majorerror($errortitle, $errormessage, $errorheading);
    } else {

        echo $errormessage;
    }
}

if (!empty($messagetext) && empty($errormessage)) {

    if ($globals['hf_loaded']) {

        //Show Message
        message($messagetitle, $messageheading, $messageicon, $messagetext);
    } else {

        echo $messagetext;
    }
}

@ob_end_flush();

mysql_close($conn);

die();
?>
