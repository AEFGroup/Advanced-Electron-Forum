<?php

//////////////////////////////////////////////////////////////
//===========================================================
// smilies.php(Admin)
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

function smileys() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    if (!load_lang('admin/smileys')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'admin/smileys';

    //The name of the Page
    $theme['init_theme_name'] = 'Admin Center - Registraion and Login Settings';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('smset_theme',
        'smman_theme',
        'smreorder_theme',
        'editsm_theme',
        'addsm_theme');

    //My activity
    $globals['last_activity'] = 'asm';


    //If a second Admin act is set then go by that
    if (isset($_GET['seadact']) && trim($_GET['seadact']) !== "") {

        $seadact = inputsec(htmlizer(trim($_GET['seadact'])));
    } else {

        $seadact = "";
    }


    //The switch handler
    switch ($seadact) {

        //The form for smiley settings
        case 'smset':
            smset();
            break;

        //The form for editing smileys
        case 'editsm':
            editsm();
            break;

        //The form for adding smileys
        case 'addsm':
            addsm();
            break;

        //This is for deleting smileys
        case 'delsm':
            delsm();
            break;

        //For reordering the smileys
        case 'smreorder':
            smreorder();
            break;

        //This is for managing smileys
        default:
        case 'smman':
            smman();
            break;
    }
}

//Function to manage smiley settings
function smset() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $error;


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $error = array();

    $usesmileys = 0;

    $smiley_space_boundary = 0;

    if (isset($_POST['editsmset'])) {

        //Enable Smileys
        if (isset($_POST['usesmileys'])) {

            $usesmileys = 1;
        }

        //Enable Smileys
        if (isset($_POST['smiley_space_boundary'])) {

            $smiley_space_boundary = 1;
        }


        //The array containing the SMILEY SETTING Changes
        $smsetchanges = array('usesmileys' => $usesmileys,
            'smiley_space_boundary' => $smiley_space_boundary);


        if (!modify_registry($smsetchanges)) {

            return false;
        }

        //Redirect
        redirect('act=admin&adact=smileys&seadact=smset');

        return true;
    } else {

        $theme['call_theme_func'] = 'smset_theme';
    }
}

//End of function
//Function to show smileys
function smman() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $smileys;

    getsmileys();

    $theme['call_theme_func'] = 'smman_theme';
}

//End of function
//Function to edit smileys
function editsm() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $error, $smiley, $folders, $smileycode;


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $error = array();

    $smiley = array();

    $smcode_r = array();

    $smcode = '';

    $smtitle = '';

    $smstatus = 1;

    $folders = filelist($globals['server_url'] . '/smileys/', 0, 1, 1);

    /* echo '<pre>';
      print_r($folders);
      echo '</pre>'; */

    getsmileys();


    if (!empty($_GET['smid']) && trim($_GET['smid']) && is_numeric(trim($_GET['smid']))) {

        $smid = (int) inputsec(htmlizer(trim($_GET['smid'])));
    } else {

        //Redirect
        redirect('act=admin&adact=smileys&seadact=smman');

        return false;
    }


    foreach ($smileycode as $sk => $sc) {

        if ($sk != $smid) {

            $smcode_r[] = trim($sc);
        }
    }

    //Get the Mimetypes
    $qresult = makequery("SELECT * FROM " . $dbtables['smileys'] . "
                        WHERE smid = '$smid'");


    if (mysql_num_rows($qresult) < 1) {

        //Redirect
        redirect('act=admin&adact=smileys&seadact=smman');

        return false;
    } else {

        $smiley = mysql_fetch_assoc($qresult);
    }


    if (isset($_POST['editsm'])) {

        //Check the code
        if (!(isset($_POST['smcode'])) || (trim($_POST['smcode']) == "")) {

            $error[] = $l['no_smiley_code'];
        } else {

            $smcode = inputsec(htmlizer(trim($_POST['smcode'])));

            if (in_array($smcode, $smcode_r)) {

                $error[] = $l['smiley_code_use'];
            }
        }


        //Check the folder
        if (!(isset($_POST['smtitle'])) || (trim($_POST['smtitle']) == "")) {

            $error[] = $l['no_smiley_emotion'];
        } else {

            $smtitle = inputsec(htmlizer(trim($_POST['smtitle'])));
        }


        //Display in post form
        if (isset($_POST['smstatus'])) {

            $smstatus = 0;
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editsm_theme';
            return false;
        }


        ///////////////////////
        // UPDATE the Smiley
        ///////////////////////

        $qresult = makequery("UPDATE " . $dbtables['smileys'] . "
                        SET smcode = '$smcode',
                        smtitle = '$smtitle',
                        smstatus = '$smstatus'
                        WHERE smid = '$smid'", false);


        //Free the resources
        @mysql_free_result($qresult);


        //Redirect
        redirect('act=admin&adact=smileys&seadact=smman');

        return true;
    } else {

        $theme['call_theme_func'] = 'editsm_theme';
    }
}

//Function to delete smileys
function delsm() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $error, $smiley;


    if (!empty($_GET['smid']) && trim($_GET['smid']) && is_numeric(trim($_GET['smid']))) {

        $smid = (int) inputsec(htmlizer(trim($_GET['smid'])));
    } else {

        //Redirect
        redirect('act=admin&adact=smileys&seadact=smman');

        return false;
    }

    ///////////////////////
    // DELETE the Smiley
    ///////////////////////

    $qresult = makequery("DELETE FROM " . $dbtables['smileys'] . "
                    WHERE smid = '$smid'", false);


    //Free the resources
    @mysql_free_result($qresult);

    //Redirect
    redirect('act=admin&adact=smileys&seadact=smman');

    return true;
}

//Function to reorder the smileys
function smreorder() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $smileys;

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $error = array();

    $smreordered = array();

    getsmileys();


    if (isset($_POST['smreorder'])) {

        //Check the code
        if (empty($_POST['sm']) || !is_array($_POST['sm'])) {

            $error[] = $l['no_smiley_order'];
        } else {

            $smreordered = $_POST['sm'];

            if (count($smreordered) != count($smileys)) {

                $error[] = $l['number_incorrect'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'smreorder_theme';
            return false;
        }

        foreach ($smreordered as $k => $v) {

            //Was every key correct
            if (!in_array($k, array_keys($smileys))) {

                $error[] = $l['smileys_invalid'];

                break;
            }

            $smreordered[$k] = (int) $v;
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'smreorder_theme';
            return false;
        }


        if (count(array_unique($smreordered)) != count($smileys)) {

            $error[] = $l['sm_order_incorrect'];
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'smreorder_theme';
            return false;
        }

        //r_print($smreordered);

        foreach ($smreordered as $k => $v) {

            $qresult = makequery("UPDATE " . $dbtables['smileys'] . "
                        SET smorder = '$v'
                        WHERE smid = '$k'", false);
        }

        //Redirect
        redirect('act=admin&adact=smileys&seadact=smman');

        return true;
    } else {

        $theme['call_theme_func'] = 'smreorder_theme';
    }
}

//Function to edit mime types
function addsm() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $error, $smiley, $folders, $smileycode;


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $error = array();

    $smiley = array();

    $smcode_r = array();

    $smcode = '';

    $smfile = '';

    $smfolder = '';

    $smtitle = '';

    $smstatus = 1;

    $filemethod = 0;

    $folders = filelist($globals['server_url'] . '/smileys/', 0, 1, 1);

    /* echo '<pre>';
      print_r($folders);
      echo '</pre>'; */

    getsmileys();


    foreach ($smileycode as $sk => $sc) {

        $smcode_r[] = trim($sc);
    }

    if (isset($_POST['addsm'])) {

        //Check the code
        if (!(isset($_POST['smcode'])) || (trim($_POST['smcode']) == "")) {

            $error[] = $l['no_smiley_code'];
        } else {

            $smcode = inputsec(htmlizer(trim($_POST['smcode'])));

            if (in_array($smcode, $smcode_r)) {

                $error[] = $l['smiley_code_use'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'addsm_theme';
            return false;
        }


        //Check the emotion
        if (!(isset($_POST['smtitle'])) || (trim($_POST['smtitle']) == "")) {

            $error[] = $l['no_smiley_emotion'];
        } else {

            $smtitle = inputsec(htmlizer(trim($_POST['smtitle'])));
        }


        //Display in post form
        if (isset($_POST['smstatus'])) {

            $smstatus = 0;
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'addsm_theme';
            return false;
        }


        //Check the folder
        if (!(isset($_POST['smfolder'])) || (trim($_POST['smfolder']) == "")) {

            $error[] = $l['no_smiley folder'];
        } else {

            $smfolder = inputsec(htmlizer(trim($_POST['smfolder'])));

            $smfolder = trim($smfolder, "/\\");

            //Is it a valid folder
            if (!in_array($globals['server_url'] . '/smileys/' . $smfolder, array_keys($folders))) {

                $error[] = $l['smiley_folder_invalid'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'addsm_theme';
            return false;
        }


        if (!(isset($_POST['filemethod'])) || (trim($_POST['filemethod']) == "")) {

            $error[] = $l['file_method'];

            //Use the server file
        } elseif (trim($_POST['filemethod']) == 1) {

            //Check the file name
            if (!(isset($_POST['smfile'])) || (trim($_POST['smfile']) == "")) {

                $error[] = $l['no_smiley_file'];
            } else {

                $smfile = inputsec(htmlizer(trim($_POST['smfile'])));

                $smsize = @getimagesize($globals['server_url'] . '/smileys/' . $smfolder . '/' . $smfile);

                //Check is it there
                if (($smsize[0] < 1) || ($smsize[1] < 1)) {

                    $error[] = $l['no_smiley_file_found'];
                }
            }

            //Upload the file
        } elseif (trim($_POST['filemethod']) == 2) {

            if (empty($_FILES['smfile_u']['tmp_name']) &&
                    empty($_FILES['smfile_u']['name']) &&
                    empty($_FILES['smfile_u']['size'])) {

                $error[] = $l['no_sm_uploaded'];
            } else {

                //Checkmod for safety
                chmod($globals['server_url'] . '/smileys/' . $smfolder, 0644);

                $smfile_temp = $_FILES['smfile_u']['tmp_name'];

                $smsize = @getimagesize($smfile_temp);

                //Check its an image
                if (($smsize[0] < 1) || ($smsize[1] < 1)) {

                    $error[] = $l['sm_uploaded_no_image'];
                }

                $smfile = $_FILES['smfile_u']['name'];

                //Finally lets move the File
                if (!(@move_uploaded_file($smfile_temp, $globals['server_url'] . '/smileys/' . $smfolder . '/' . $smfile))) {

                    $error[] = $l['smiley_image'];
                }
            }
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'addsm_theme';
            return false;
        }



        ///////////////////////
        // INSERT the Smiley
        ///////////////////////

        $qresult = makequery("INSERT INTO " . $dbtables['smileys'] . "
                        SET smcode = '$smcode',
                        smfile = '$smfile',
                        smtitle = '$smtitle',
                        smstatus = '$smstatus',
                        smfolder = '$smfolder'");


        $smid = mysql_insert_id($conn);

        if (empty($smid)) {

            reporterror($l['add_smiley_error'], $l['add_smiley_error_exp']);

            return false;
        }

        //Free the resources
        @mysql_free_result($qresult);


        //Redirect
        redirect('act=admin&adact=smileys&seadact=smman');

        return true;
    } else {

        $theme['call_theme_func'] = 'addsm_theme';
    }
}

?>
