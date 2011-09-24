<?php

//////////////////////////////////////////////////////////////
//===========================================================
// sessions.php
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

/////////////////////////////////
// IF a Session is found what
// should happen :
// 1 - Load the session.
// 2 - Try and set a cookie if a
//     previous attempt has not
//     been made.
/////////////////////////////////
/////////////////////////////////
// Checks for a existing session
/////////////////////////////////

function check_session() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS;
    global $isbot;

    //echo 'Called check_session';

    $isbot = is_bot();

    if (!empty($isbot) && $isbot < -100) {

        return bot_session_id($isbot);
    }

    if (isset($_COOKIE[$globals['cookie_name']]['aefsid']) &&
            strlen(trim($_COOKIE[$globals['cookie_name']]['aefsid'])) == 32) {

        $id = inputsec(htmlizer(trim($_COOKIE[$globals['cookie_name']]['aefsid'])));

        if (preg_match('~^[A-Za-z0-9]{32}$~', $id) == 0) {

            //Return False
            return 0;
        } else {

            //Return Session ID
            return $id;
        }

        //May be in the GET
        //'as' - AEF Session
    } elseif (isset($_GET['as'])) {

        $id = inputsec(htmlizer(trim($_GET['as'])));

        if (preg_match('~^[A-Za-z0-9]{32}$~', $id) == 0) {

            //Return False
            return 0;
        } else {

            //Return Session ID
            return $id;
        }

        //No Session found
    } else {

        //Return False
        return 0;
    }
}

//End of function
///////////////////////////
// Registers a new session
///////////////////////////

function register_session() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $l;
    global $isbot;

    if (!empty($isbot) && $isbot < -100) {

        return register_bot_session($isbot);
    }

    $id = strtolower(generateRandStr(32));

    ////////////////////////////////
    // INSERT in the session Table
    ////////////////////////////////

    $qresult = makequery("INSERT INTO " . $dbtables['sessions'] . "
                    SET sid = '$id',
                    uid = '-1',
                    time = '" . time() . "',
                    data = '',
                    ip = '" . ($_SERVER['REMOTE_ADDR']) . "'");

    if (mysql_affected_rows($conn) < 1) {

        reporterror($l['register_guest_error_title'], $l['register_guest_error']);

        return false;
    }

    //Define CONSTANT Session ID
    define('AS_ID', $id);

    //Define CONSTANT USER ID
    define('AS_UID', -1);

    //Now lets try and set a COOKIE of AEF Session ID
    setcookie($globals['cookie_name'] . '[aefsid]', $id, 0, '/');

    //Also we need to modify the index_url
    $globals['index_url'] = $globals['index_url'] . 'as=' . $id . '&';

    return true;
}

//End of function
///////////////////////////////
// Loads a existing session or
// starts a new one
///////////////////////////////

function load_session() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS;
    global $isbot;

    $id = check_session();

    //If a ID is found
    if ($id) {

        $qresult = makequery("SELECT * FROM " . $dbtables['sessions'] . "
                    WHERE sid = '$id'");

        //Did not find any such session
        if ((mysql_num_rows($qresult) < 1)) {

            //Free the resources for the next query
            mysql_free_result($qresult);

            //Register a session
            if (!register_session()) {

                return false;
            }

            //Found it
        } else {

            $row = mysql_fetch_assoc($qresult);

            //Define CONSTANT Session ID
            define('AS_ID', $id);

            //Define CONSTANT Session ID
            define('AS_UID', $row['uid']);

            //Am i anonymous
            $globals['i_am_anon'] = $row['anonymous'];

            if (!empty($row['data'])) {

                $data = aefunserialize($row['data']);

                if (!empty($data)) {

                    foreach ($data as $k => $v) {

                        //Build the Array
                        $AEF_SESS[$k] = $v;
                    }
                }
            }

            //Now we need to know how to propagate the Session ID
            //Cookies not found
            if (!isset($_COOKIE[$globals['cookie_name']]['aefsid']) && empty($isbot)) {

                //Modify the index_url
                $globals['index_url'] = $globals['index_url'] . 'as=' . $id . '&';
            }

            //Free the resources
            mysql_free_result($qresult);
        }

        //No AEF Session found
    } else {

        //Register a session
        if (!register_session()) {

            return false;
        }
    }

    return true;
}

//End of function
///////////////////////////////
// Saves all the AEF_SESS VARS
// in the Database.
// Also track the daily statistics
///////////////////////////////

function save_session() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS;


    ////////////////////////////////////
    // Track the Boards daily statistics
    ////////////////////////////////////

    if ($globals['stats']) {

        //Get the second of the day start
        $timestamp = mktime(0, 0, 0);

        //First try to update
        $qresult = makequery("UPDATE " . $dbtables['stats'] . "
                SET pageviews = pageviews + 1
                " . (empty($globals['newuser']) ? "" : ", users = users + 1") . "
                " . (empty($globals['newtopic']) ? "" : ", topics = topics + 1") . "
                " . (empty($globals['newpost']) ? "" : ", posts = posts + 1") . "
                " . (empty($globals['activetoday']) ? "" : ", active = " . $globals['activetoday']) . "
                WHERE timestamp = '$timestamp'", false);

        //Did it UPDATE
        if (mysql_affected_rows($conn) < 1) {

            ////////////////////////////////////
            // INSERT it then for the first time
            ////////////////////////////////////
            //First try to update
            $qresult = makequery("INSERT INTO " . $dbtables['stats'] . "
                SET timestamp = '$timestamp',
                pageviews = pageviews + 1,
                users = '" . (empty($globals['newuser']) ? 0 : $globals['newuser']) . "',
                topics = '" . (empty($globals['newtopic']) ? 0 : $globals['newtopic']) . "',
                posts = '" . (empty($globals['newpost']) ? 0 : $globals['newpost']) . "',
                active = '" . (empty($globals['activetoday']) ? 0 : $globals['activetoday']) . "'");
        }
    }


    $id = AS_ID;

    $uid = ((defined('AS_LUID')) ? AS_LUID : AS_UID);

    //echo $uid;

    $data = process_as_data();

    //////////////////////////
    // UPDATE the AEF SESSION
    //////////////////////////
    //Make the QUERY
    $qresult = makequery("UPDATE " . $dbtables['sessions'] . "
                SET time = '" . time() . "',
                data = '$data',
                ip = '" . ($_SERVER['REMOTE_ADDR']) . "',
                last_activity = '" . $globals['last_activity'] . "',
                activity = '" . $globals['activity_id'] . "|" . $globals['activity_text'] . "',
                anonymous = '" . $globals['i_am_anon'] . "'
                WHERE sid = '$id'
                AND uid = '$uid'", false);


    return true;
}

//End of function
///////////////////////////////
// Returns a String of AEF_SESS
// VARS to be stored in DB.
///////////////////////////////

function process_as_data() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS;

    if (!empty($AEF_SESS) && is_array($AEF_SESS)) {

        $data = addslashes(serialize($AEF_SESS));
    } else {

        $data = '';
    }

    return $data;
}

//End of function
/////////////////////////////
// Destroys a unused session
/////////////////////////////

function destroy_session() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS;


    $qresult = makequery("DELETE FROM " . $dbtables['sessions'] . "
                        WHERE time < " . (time() - $globals['session_timeout']), false);


    return true;
}

//End of function
//////////////////////////////////////
// Determines that the user is a
// recognised bot
// Returns the bots name if recognised
// Otherwise false
//////////////////////////////////////

function bots() {

    return array(-101 => array('Google', -101, 'Google'),
        -102 => array('Yahoo', -102, 'Yahoo'),
        -103 => array('Alexa', -103, 'ia_archiver'),
        -104 => array('Cuill', -104, 'cuill'),
        -105 => array('Omgili', -105, 'omgilibot'),
        -106 => array('MSN', -106, 'msnbot'),
        -107 => array('Speedy Spider', -107, 'Speedy Spider'),
        -108 => array('Bilgi', -108, 'BilgiBot'),
        -109 => array('Baidu', -109, 'Baiduspider'),
        -110 => array('Gigabot', -110, 'Gigabot'),
        -111 => array('Lycos', -111, 'Lycos'),
        -112 => array('Alta Vista', -112, 'Scooter'),
        -113 => array('Ask Jeeves', -113, 'Ask Jeeves'),
        -114 => array('Rediff', -114, 'RedBot'),
    //-115 => array('FireFox', -115, 'Firefox')//Test Purposes
    );
}

function is_bot() {

    global $conn, $dbtables, $globals;

    $bots = bots();

    $bot = '';

    $useragent = $_SERVER['HTTP_USER_AGENT'];

    //Is the UserAgent even there
    if (empty($useragent)) {

        return false;
    } else {

        foreach ($bots as $v) {

            if (substr_count($useragent, $v[2])) {

                //Return the ID
                return $v[1];
            }
        }
    }
}

function bot_session_id($botid) {

    $bots = bots();

    return strtolower(substr($bots[$botid][0] . '-' . $_SERVER['REMOTE_ADDR'], 0, 32));
}

function botname($botid) {

    $bots = bots();

    if (!empty($bots[$botid])) {

        return $bots[$botid][0];
    }
}

function register_bot_session($botid) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS;

    $id = bot_session_id($botid);

    ////////////////////////////////
    // INSERT in the session Table
    ////////////////////////////////

    $qresult = makequery("INSERT INTO " . $dbtables['sessions'] . "
                    SET sid = '$id',
                    uid = '$botid',
                    time = '" . time() . "',
                    data = '',
                    ip = '" . ($_SERVER['REMOTE_ADDR']) . "'");

    if (mysql_affected_rows($conn) < 1) {

        reporterror($l['register_guest_error_title'], $l['register_guest_error']);

        return false;
    }

    //Define CONSTANT Session ID
    define('AS_ID', $id);

    //Define CONSTANT USER ID
    define('AS_UID', $botid);

    return true;
}

?>
