<?php

//////////////////////////////////////////////////////////////
//===========================================================
// admin_functions.php(Admin)
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

//Modifies the universal.php
function modify_universal($array) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    $filename = $globals['server_url'] . '/universal.php';

    // Let's make sure the file exists and is writable first.
    if (is_writable($filename)) {

        //If writable get contents
        $file = implode('', file($filename));

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
        if (!$handle = fopen($filename, 'wb')) {

            reporterror($l['Error'], $l['universal_no_open']);

            return false;
        }

        // Write $filec to our opened file.
        if (fwrite($handle, $file) === FALSE) {

            reporterror($l['Error'], $l['universal_no_edit']);

            return false;
        }

        fclose($handle);
    } else {

        reporterror($l['Error'], $l['universal_no_writable']);

        return false;
    }

    return true;
}

//End of function

/* $temparr = array('url' => array('http://127.0.0.1/aef', 0),
  'board_email' => array('pulgup1@gmail.com', 0),
  'maintenance' => array(1, 1)
  );

  modify_universal($temparr); */

//Modifies the registry
function modify_registry($array, $compare = 1) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $addslashes;

    foreach ($array as $k => $v) {

        //Check if the $globals[key] actually exists - Internal Working
        if (!isset($globals[$k])) {

            //Show a major error and return
            reporterror($l['no_global_key'], $l['global_key_invalid']);

            return false;
        }

        if (!empty($addslashes)) {

            $globals[$k] = addslashes($globals[$k]);
        }

        //Check if there is a change
        if ($compare && $globals[$k] == $v) {

            continue;
        }

        ////////////////////////////////////
        // Finally lets UPDATE the Registry
        ////////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['registry'] . "
                            SET regval = '$v'
                            WHERE name = '$k'", false);

        if (mysql_affected_rows($conn) < 1 && $compare) {

            reporterror($l['registry_update_error'], $l['errors_updating_registry']);

            return false;
        }

        //Free the resources
        @mysql_free_result($qresult);
    }//End of Loop
    //If everyting went fine
    return true;
}

?>
