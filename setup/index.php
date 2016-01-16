<?php

//////////////////////////////////////////////////////////////
//===========================================================
// index.php(setup)
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
error_reporting(0);

define('AEF', 1);

$path = dirname(dirname(__FILE__));

$setup_path = dirname(__FILE__);

$url = 'http://' . (empty($_SERVER['HTTP_HOST']) ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST']) . substr($_SERVER['PHP_SELF'], 0, -16);

$error = array();

$warning = array();

//Lets load the theme functions
include_once($setup_path . '/theme.php');

include_once($path . '/main/functions.php');


//check requirements SILENTLY and only warn user if something is REALLY wrong !
check_requirements();

if (isset($_GET['act']) && trim($_GET['act']) !== "") {
    $act = trim($_GET['act']);
} else {
    $act = '';
}

    switch ($act) {

        default:
            startsetup(); //Theme file
            break;

        case 'db':
            database_setup();
            break;
        //The form asking for all requirements
        case 'setup':
            setup();
            break;

        //Just a message
        case 'aftersetup':
            aftersetup();
            break;

        //Remove Setup folder
        case 'removesetup':
            removesetup();
            break;
    }

function database_setup(){
    global $chmod_issue, $server, $database, $user, $password, $dbprefix, $utf8, $path, $error;

    if(isset($_POST['db'])){
        //////////////////
        // MySQL Settings
        //////////////////
        //Check the MySQL Host/ Server Name - Can be empty
        if (!(isset($_POST['server'])) || strlen(trim($_POST['server'])) < 1) {

            $error[] = 'You did not enter the MySQL Host / Server Name.';
        } else {

            $server = inputsec(htmlizer(trim($_POST['server'])));
        }


        //The MySQL Database Name
        if (!(isset($_POST['database'])) || strlen(trim($_POST['database'])) < 1) {

            $error[] = 'You did not enter the MySQL Database name.';
        } else {

            $database = inputsec(htmlizer(trim($_POST['database'])));
        }


        //The MySQL Username - Can be empty
        if (isset($_POST['user'])) {

            $user = inputsec(htmlizer(trim($_POST['user'])));
        }


        //The MySQL Password - Can be empty
        if (isset($_POST['password'])) {

            $password = inputsec(htmlizer(trim($_POST['password'])));
        }


        //The MySQL Table Prefix - Can be empty
        if (isset($_POST['dbprefix'])) {

            $dbprefix = inputsec(htmlizer(trim($_POST['dbprefix'])));
        }

        //The Charset
        if (isset($_POST['utf8'])) {

            $utf8 = true;
        }

        //Try to connect to MySQL
        $conn = @mysql_connect($server, $user, $password);

        if (!empty($conn)) {

            if (!(mysql_select_db($database, $conn))) {

                $error[] = 'The MySQL Database could not be selected.';
            }
            //using a prefix doesn't mean its not already used, test about that
            elseif(mysql_query("SELECT * FROM `".$dbprefix."registry`") === TRUE){
                $error[] = 'The database Prefix is already used.';
            }
        } else {

            $error[] = 'The MySQL Connection could not be established.';
        }


        if(!empty($error)){
            die(db_theme());
        }

        //we are good, now check chmod issues
        if($chmod_issue === TRUE){
            die(not_writable_theme());
        }
        //oh, we are permitted to modify the file, DO it and proceed
        modify_universal(array(
            'server_url' => array($path, 0),
            'mainfiles' => array($path . '/main', 0),
            'themesdir' => array($path . '/themes', 0),
            'user' => array($user, 0),
            'password' => array($password, 0),
            'database' => array($database, 0),
            'dbprefix' => array($dbprefix, 0),
            'server' => array($server, 0),
            'installed' => array(TRUE, 0)));

        if(!empty($error)){
            die(db_theme());
        }
        //we are good, now redirect to the normal setup
        header("Location: ?act=setup");
    }
    db_theme();
}

function setup() {

    global $error, $url, $path, $conn;

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////
    $cookie_name = 'AEFCookies' . mt_rand(1000, 9999);

    if (isset($_POST['setup'])) {

        //////////////////
        // Board Settings
        //////////////////
        //Check the Board Name
        if (!(isset($_POST['sn'])) || strlen(trim($_POST['sn'])) < 1) {

            $error[] = 'You did not enter your Board\'s Name.';
        } else {

            $sn = inputsec(htmlizer(trim($_POST['sn'])));
        }


        //Check the Board Email
        if (!(isset($_POST['board_email'])) || strlen(trim($_POST['board_email'])) < 1) {

            $error[] = 'You did not enter your Board\'s Email address.';
        } else {

            $board_email = inputsec(htmlizer(trim($_POST['board_email'])));

            //We must check its validity
            if (!emailvalidation($board_email)) {

                $error[] = 'The Board\'s Email address you entered is invalid .';
            }
        }

        //on error call the form
        if (!empty($error)) {
            setup_theme();
            die();
        }


        //////////////////
        // Admin Account
        //////////////////
        //The Admin Username
        if (!(isset($_POST['ad_username'])) || strlen(trim($_POST['ad_username'])) < 1) {

            $error[] = 'You did not enter the Admins Username.';
        } else {

            $ad_username = inputsec(htmlizer(trim($_POST['ad_username'])));

            if (preg_match("/\s/i", $ad_username)) {

                $error[] = 'Usernames cannot contain white spaces.';
            }
        }


        //The Admin Password
        if (!(isset($_POST['ad_pass'])) || strlen(trim($_POST['ad_pass'])) < 1) {

            $error[] = 'You did not enter the password for the Admins account.';
        } else {

            $ad_pass = inputsec(htmlizer(trim($_POST['ad_pass'])));

            $salt = generateRandStr(4);

            $ad_pass = md5($salt . $ad_pass);
        }

        //The Admin Confirm Password
        if (!(isset($_POST['ad_pass_conf'])) || strlen(trim($_POST['ad_pass_conf'])) < 1) {

            $error[] = 'You did not enter the confirmation password.';
        } else {

            $ad_pass_conf = inputsec(htmlizer(trim($_POST['ad_pass_conf'])));

            $ad_pass_conf = md5($salt . $ad_pass_conf);

            //Check does it match the password
            if ($ad_pass_conf != $ad_pass) {

                $error[] = 'Your Passwords do not match each other.';
            }
        }


        //The Admin Email
        if (!(isset($_POST['ad_email'])) || strlen(trim($_POST['ad_email'])) < 1) {

            $error[] = 'You did not enter the email address for the Admins account.';
        } else {

            $ad_email = inputsec(htmlizer(trim($_POST['ad_email'])));

            //Max Length
            if (strlen($ad_email) > 100) {

                $error[] = 'The Admin email address is too large.';
            }

            //Also confirm its validity
            if (!emailvalidation($ad_email)) {

                $error[] = 'The Admin email address is invalid.';
            }
        }

        //on error call the form
        if (!empty($error)) {
            setup_theme();
            die();
        }

        require($path . '/universal.php');
        $conn = mysql_connect($globals['server'], $globals['user'], $globals['password']);
        mysql_select_db($globals['database'], $conn) or die("Unable to select database");
        $dbprefix = $globals['dbprefix'];

        //If we have reached here everything is fine from the inputs
        include_once($path . '/setup/mysql.php');



        //Load the MySQL File
        if (!function_exists('make_mysql')) {

            $error[] = 'The MySQL File could not be located.';
        }

        //on error call the form
        if (!empty($error)) {
            setup_theme();
            die();
        }

        //Now everything is left up to us
        if (!make_mysql($queries)) {

            //on error call the form
            if (!empty($error)) {
                setup_theme();
                die();
            }
        }

        
        header("Location: " . $url . "/setup/index.php?act=aftersetup");
    } else {

        setup_theme();
        die();
    }
}

//Modifies the universal.php
function modify_universal($array) {

    global $path, $error;

    $filename = $path . '/universal.php';

    @include_once($path . '/universal.php');

    // Let's make sure the file exists and is writable first.
    if (is_writable($filename)) {

        //If writable get contents
        $file = implode('', @file($filename));

        //Replace the required things
        foreach ($array as $k => $v) {

            //If it is of the $globals['key'] = 0;
            if ($array[$k][1]) {

                $file = str_replace('$globals[\'' . $k . '\'] = ' . $globals[$k] . ';', '$globals[\'' . $k . '\'] = ' . $array[$k][0] . ';', $file);

                //ElseIf it is of the $globals['key'] = 'text';
            } else {

                //For locations these errors happen && substr_count('\\', $globals[$k])
                if (!empty($globals[$k]) &&
                        substr_count($globals[$k], '\\') > 1 &&
                        substr_count($globals[$k], '\\\\') < 1) {

                    $globals[$k] = addslashes($globals[$k]);
                }

                $file = str_replace('$globals[\'' . $k . '\'] = \'' . $globals[$k] . '\';', '$globals[\'' . $k . '\'] = \'' . $array[$k][0] . '\';', $file);
            }
        }//End the foreach loop

        //Open the file for editing
        if (!$handle = @fopen($filename, 'wb')) {

            $error[] = 'The universal.php could not be opened for editing.';

            return false;
        }

        // Write $filec to our opened file.
        if (@fwrite($handle, $file) === FALSE) {

            $error[] = 'The universal.php file could not be edited.';

            return false;
        }

        fclose($handle);
    } else {

        $error[] = 'The universal.php file is not writable.';

        return false;
    }

    return true;
}

//End of function

function removesetup() {

    global $setup_path;

    $files = fn_filelist($setup_path . '/', 1, 0, 'all');

    foreach ($files as $k => $v) {

        if (file_exists($k)
                && is_file($k)
                && @filetype($k) == "file") {

            if (!@unlink($k)) {

                die('<h3>There were errors in deleting the setup files.<br />Please remove them for safety reasons.</h3>');
            }
        }
    }

    //Remove the images folder
    @rmdir($setup_path . '/images');

    //Delete the folder
    @rmdir($setup_path);

    echo '<h3>Setup files were deleted successfully.</h3>';
}

function fn_filelist($startdir="./", $searchSubdirs=1, $directoriesonly=0, $maxlevel="all", $level=1) {
    //list the directory/file names that you want to ignore
    $ignoredDirectory[] = ".";
    $ignoredDirectory[] = "..";
    $ignoredDirectory[] = "_vti_cnf";
    global $directorylist;    //initialize global array
    if (is_dir($startdir)) {
        if ($dh = opendir($startdir)) {
            while (($file = readdir($dh)) !== false) {
                if (!(array_search($file, $ignoredDirectory) > -1)) {
                    if (filetype($startdir . $file) == "dir") {

                        //build your directory array however you choose;
                        //add other file details that you want.

                        $directorylist[$startdir . $file]['level'] = $level;
                        $directorylist[$startdir . $file]['dir'] = 1;
                        $directorylist[$startdir . $file]['name'] = $file;
                        $directorylist[$startdir . $file]['path'] = $startdir;
                        if ($searchSubdirs) {
                            if ((($maxlevel) == "all") or ($maxlevel > $level)) {
                                fn_filelist($startdir . $file . "/", $searchSubdirs, $directoriesonly, $maxlevel, $level + 1);
                            }
                        }
                    } else {
                        if (!$directoriesonly) {

                            //  echo substr(strrchr($file, "."), 1);
                            //if you want to include files; build your file array 
                            //however you choose; add other file details that you want.
                            $directorylist[$startdir . $file]['level'] = $level;
                            $directorylist[$startdir . $file]['dir'] = 0;
                            $directorylist[$startdir . $file]['name'] = $file;
                            $directorylist[$startdir . $file]['path'] = $startdir;
                        }
                    }
                }
            }
            closedir($dh);
        }
    }
    return($directorylist);
}

function check_requirements(){
    global $path, $warning, $chmod_issue;
    //first we check if the board is already installed and/or the lock file exist
    if(file_exists($path . '/universal.php')){
        //well the file really exists and we should think more about what will happen next
        require_once($path . '/universal.php');
        //now check if the board is installed and not to interrupt during install
        if($globals['installed'] == 1 ){
            //the board is installed so we got a problem here
            //but maybe there are no tables
            $conn = mysql_connect($globals['server'], $globals['user'], $globals['password']);
            mysql_select_db($globals['database'], $conn) or die("Unable to select database");
            //check if the tables do exist
            if(mysql_query("SELECT * FROM `".$globals['dbprefix']."registry`") === TRUE){
                //hacker ?
                die(locked_theme());
            }
        }
    }
    //Is the universal file writable ?
    if (!is_writable($path . '/universal.php') && @!chmod($path . '/universal.php', 0777)) {
        //show a warning that the file is not writable but the wizard will finish anyway
        $warning[] = 'The universal.php file is not writable and the installation wizard could not CHMOD.<br />
        Please CHMOD it to 0777 for the setup of your AEF board. You may later revert it back to 0655.<br />';
        $chmod_issue = TRUE;

    }
    //now what about the PHP version and other *cough* smaller *cough* modifications ?
    $php = (phpversion() < '5.0.0' ? 'bad' : 'good' );
    $mysql = (mysql_get_server_info() < '4.0' ? 'bad' : 'good');

}
