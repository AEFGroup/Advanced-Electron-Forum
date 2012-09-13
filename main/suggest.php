<?php

//////////////////////////////////////////////////////////////
//===========================================================
// suggest.php
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

///////////////////////////////////////
// Suggests the usernames of the board
///////////////////////////////////////


function suggest() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $usernames;

    //The name of the file
    $theme['init_theme'] = 'suggest';

    //The name of the Page
    $theme['init_theme_name'] = 'Suggest';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('suggest_theme');

    $theme['call_theme_func'] = 'suggest_theme';

    //Stop the output buffer
    $globals['stop_buffer_process'] = true;

    //Are stats enabled
    if (empty($logged_in)) {

        return false;
    }


    if (!empty($_GET['q']) && trim($_GET['q']) != '') {

        $q = inputsec(htmlizer(trim($_GET['q'])));

        //Replace spaces and special characters
        $q = preg_replace(array('/%/', '/_/', '/\s/'), array('\\%', '\_', '%'), $q);
    } else {

        return false;
    }


    //Select the users profile    
    $qresult = makequery("SELECT username FROM " . $dbtables['users'] . "
            WHERE username LIKE '%$q%'
            LIMIT 0,10");

    if (mysql_num_rows($qresult) < 1) {

        return false;
    }

    $usernames = array();

    for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

        $row = mysql_fetch_assoc($qresult);

        $usernames[] = $row['username'];
    }
}

?>
