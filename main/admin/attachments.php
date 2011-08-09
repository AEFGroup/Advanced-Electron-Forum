<?php

//////////////////////////////////////////////////////////////
//===========================================================
// attachments.php(Admin)
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

function attachments() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    if (!load_lang('admin/attachments')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'admin/attachments';

    //The name of the Page
    $theme['init_theme_name'] = 'Admin Center - Attachment Settings';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('attset_theme',
        'attmime_theme');

    //My activity
    $globals['last_activity'] = 'aatt';


    //If a second Admin act is set then go by that
    if (isset($_GET['seadact']) && trim($_GET['seadact']) !== "") {

        $seadact = inputsec(htmlizer(trim($_GET['seadact'])));
    } else {

        $seadact = "";
    }


    //The switch handler
    switch ($seadact) {

        //The form for editing Attachment Settings
        default:
        case 'attset':
            attset();
            break;

        //The form for viewing Attachment Mimetypes
        case 'attmime':
            attmime();
            break;

        //The form for editing Mimetypes
        case 'editmime':
            editmime();
            break;

        //The form for deleting Mimetypes
        case 'delmime':
            delmime();
            break;

        //The form for adding Mimetypes
        case 'addmime':
            addmime();
            break;
    }
}

//Function to manage Attachment settings
function attset() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $error, $addslashes;


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $error = array();

    $addslashes = true;

    $attachmentmode = 0; //The Mode 0,1(Allows to download attachment if 1)

    $allownewattachment = 0; //0,1

    $attachmentdir = ''; //The upload Directory where attachments are stored

    $attachmenturl = ''; //Attachment URL used for images

    $maxattachmentpost = 0; //Max number of attachments allowed per post

    $maxattachsize = 0; //Max attachment size per attachment(in KB's)

    $maxattachsizepost = 0; //Max attachment size per post(cumulative)

    $attachmentshowimage = 0; //Show the image if attachment is image

    $attachmentshowimagemaxwidth = 0; //If image attachments are to be shown max width

    $attachmentshowimagemaxheight = 0; //If image attachments are to be shown max height	


    if (isset($_POST['editattset'])) {

        //Enable Downloads
        if (isset($_POST['attachmentmode'])) {

            $attachmentmode = 1;
        }

        //Allow new attachments
        if (isset($_POST['allownewattachment'])) {

            $allownewattachment = 1;
        }

        //Check the attachment directory
        if (!(isset($_POST['attachmentdir'])) || (trim($_POST['attachmentdir']) == "")) {

            $error[] = $l['no_attach_directory'];
        } else {

            $attachmentdir = inputsec(htmlizer(trim($_POST['attachmentdir'])));

            $attachmentdir = rtrim($attachmentdir, '/\\');
        }

        //Check the attachment URL
        if (!(isset($_POST['attachmenturl'])) || (trim($_POST['attachmenturl']) == "")) {

            $error[] = $l['no_attach_url'];
        } else {

            $attachmenturl = inputsec(htmlizer(trim($_POST['attachmenturl'])));

            $attachmenturl = rtrim($attachmenturl, '/\\');
        }

        //Check the maximum number of attachments per post
        if (!(isset($_POST['maxattachmentpost'])) || (trim($_POST['maxattachmentpost']) == "")) {

            $error[] = $l['no_max_num'];
        } else {

            $maxattachmentpost = (int) inputsec(htmlizer(trim($_POST['maxattachmentpost'])));
        }

        //Check the max attach size
        if (!(isset($_POST['maxattachsize'])) || (trim($_POST['maxattachsize']) == "")) {

            $error[] = $l['no_max_size_of_attach'];
        } else {

            $maxattachsize = (int) inputsec(htmlizer(trim($_POST['maxattachsize'])));
        }

        //Check the max attach size per post
        if (!(isset($_POST['maxattachsizepost'])) || (trim($_POST['maxattachsizepost']) == "")) {

            $error[] = $l['no_max_size_per_post'];
        } else {

            $maxattachsizepost = (int) inputsec(htmlizer(trim($_POST['maxattachsizepost'])));
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'attset_theme';
            return false;
        }


        //Show image attachments in posts
        if (isset($_POST['attachmentshowimage'])) {

            $attachmentshowimage = 1;
        }


        if (!(isset($_POST['attachmentshowimagemaxwidth'])) || (trim($_POST['attachmentshowimagemaxwidth']) == "")) {

            $error[] = $l['no_max_width'];
        } else {

            $attachmentshowimagemaxwidth = (int) inputsec(htmlizer(trim($_POST['attachmentshowimagemaxwidth'])));
        }


        if (!(isset($_POST['attachmentshowimagemaxheight'])) || (trim($_POST['attachmentshowimagemaxheight']) == "")) {

            $error[] = $l['no_max_height'];
        } else {

            $attachmentshowimagemaxheight = (int) inputsec(htmlizer(trim($_POST['attachmentshowimagemaxheight'])));
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'attset_theme';
            return false;
        }


        //The array containing the ATTACHMENT SETTING Changes
        $attsetchanges = array('attachmentmode' => $attachmentmode,
            'allownewattachment' => $allownewattachment,
            'attachmentdir' => $attachmentdir,
            'maxattachmentpost' => $maxattachmentpost,
            'maxattachsize' => $maxattachsize,
            'maxattachsizepost' => $maxattachsizepost,
            'attachmentshowimage' => $attachmentshowimage,
            'attachmentshowimagemaxwidth' => $attachmentshowimagemaxwidth,
            'attachmentshowimagemaxheight' => $attachmentshowimagemaxheight,
            'attachmenturl' => $attachmenturl
        );


        if (!modify_registry($attsetchanges)) {

            return false;
        }

        //Redirect
        redirect('act=admin&adact=attach&seadact=attset');

        return true;
    } else {

        $theme['call_theme_func'] = 'attset_theme';
    }
}

//End of function
//Function to show Attachment MIME Types
function attmime() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $mimetypes;


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $mimetypes = array();

    //Get the Mimetypes
    $qresult = makequery("SELECT * FROM " . $dbtables['attachment_mimetypes']);

    if (mysql_num_rows($qresult) > 0) {

        for ($i = 0; $i < mysql_num_rows($qresult); $i++) {

            $row = mysql_fetch_assoc($qresult);

            $mimetypes[$row['atmtid']] = $row;
        }
    }

    $theme['call_theme_func'] = 'attmime_theme';
}

//End of function
//Function to edit mime types
function editmime() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $error, $mimetype;


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $error = array();

    $mimetype = array();

    $atmt_ext = '';

    $atmt_mimetype = '';

    $atmt_icon = '';

    $atmt_posts = 0;

    $atmt_avatar = 0;

    $atmt_isimage = 0;

    if (!empty($_GET['atmtid']) && trim($_GET['atmtid']) && is_numeric(trim($_GET['atmtid']))) {

        $atmtid = (int) inputsec(htmlizer(trim($_GET['atmtid'])));
    } else {

        //Redirect
        redirect('act=admin&adact=attach&seadact=attmime');

        return false;
    }


    //Get the Mimetypes
    $qresult = makequery("SELECT * FROM " . $dbtables['attachment_mimetypes'] . "
						WHERE atmtid = '$atmtid'");


    if (mysql_num_rows($qresult) < 1) {

        //Redirect
        redirect('act=admin&adact=attach&seadact=attmime');

        return false;
    } else {

        $mimetype = mysql_fetch_assoc($qresult);
    }


    if (isset($_POST['editmime'])) {

        //Check the extension
        if (!(isset($_POST['atmt_ext'])) || (trim($_POST['atmt_ext']) == "")) {

            $error[] = $l['no_file_type'];
        } else {

            $atmt_ext = inputsec(htmlizer(trim($_POST['atmt_ext'])));
        }

        //Check the Mime Type
        if (!(isset($_POST['atmt_mimetype'])) || (trim($_POST['atmt_mimetype']) == "")) {

            $error[] = $l['no_mimetype'];
        } else {

            $atmt_mimetype = inputsec(htmlizer(trim($_POST['atmt_mimetype'])));
        }

        //Check the file type icon
        if (!(isset($_POST['atmt_icon'])) || (trim($_POST['atmt_icon']) == "")) {

            $error[] = $l['no_file_type_icon'];
        } else {

            $atmt_icon = inputsec(htmlizer(trim($_POST['atmt_icon'])));

            $iconsize = @getimagesize($globals['server_url'] . '/mimetypes/' . $atmt_icon);

            //Check is it there
            if (($iconsize[0] < 1) || ($iconsize[1] < 1)) {

                $error[] = $l['no_file_type_icon_found'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editmime_theme';
            return false;
        }


        //Allow in posts ?
        if (isset($_POST['atmt_posts'])) {

            $atmt_posts = 1;
        }


        //Allow for avatars ?
        if (isset($_POST['atmt_avatar'])) {

            $atmt_avatar = 1;
        }


        //Is it an image ?
        if (isset($_POST['atmt_isimage'])) {

            $atmt_isimage = 1;
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'editmime_theme';
            return false;
        }

        ///////////////////////
        // UPDATE the Mimetype
        ///////////////////////

        $qresult = makequery("UPDATE " . $dbtables['attachment_mimetypes'] . " 
						SET atmt_ext = '$atmt_ext',
						atmt_mimetype = '$atmt_mimetype',
						atmt_icon = '$atmt_icon',
						atmt_posts = '$atmt_posts',
						atmt_avatar = '$atmt_avatar',
						atmt_isimage = '$atmt_isimage'
						WHERE atmtid = '$atmtid'", false);


        //Redirect
        redirect('act=admin&adact=attach&seadact=attmime');

        return true;
    } else {

        $theme['call_theme_func'] = 'editmime_theme';
    }
}

//Function to delete mime types
function delmime() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $error;


    if (!empty($_GET['atmtid']) && trim($_GET['atmtid']) && is_numeric(trim($_GET['atmtid']))) {

        $atmtid = (int) inputsec(htmlizer(trim($_GET['atmtid'])));
    } else {

        //Redirect
        redirect('act=admin&adact=attach&seadact=attmime');

        return false;
    }


    ///////////////////////
    // DELETE the Mimetype
    ///////////////////////

    $qresult = makequery("DELETE FROM " . $dbtables['attachment_mimetypes'] . " 
					WHERE atmtid = '$atmtid'", false);


    //Free the resources
    @mysql_free_result($qresult);


    //Redirect
    redirect('act=admin&adact=attach&seadact=attmime');

    return true;
}

//Function to add mime types
function addmime() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $error;


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $error = array();

    $atmt_ext = '';

    $atmt_mimetype = '';

    $atmt_icon = '';

    $atmt_posts = 0;

    $atmt_avatar = 0;

    $atmt_isimage = 0;

    if (isset($_POST['addmime'])) {

        //Check the extension
        if (!(isset($_POST['atmt_ext'])) || (trim($_POST['atmt_ext']) == "")) {

            $error[] = $l['no_file_type'];
        } else {

            $atmt_ext = inputsec(htmlizer(trim($_POST['atmt_ext'])));
        }

        //Check the Mime Type
        if (!(isset($_POST['atmt_mimetype'])) || (trim($_POST['atmt_mimetype']) == "")) {

            $error[] = $l['no_mimetype'];
        } else {

            $atmt_mimetype = inputsec(htmlizer(trim($_POST['atmt_mimetype'])));
        }

        //Check the file type icon
        if (!(isset($_POST['atmt_icon'])) || (trim($_POST['atmt_icon']) == "")) {

            $error[] = $l['no_file_type_icon'];
        } else {

            $atmt_icon = inputsec(htmlizer(trim($_POST['atmt_icon'])));

            $iconsize = @getimagesize($globals['server_url'] . '/mimetypes/' . $atmt_icon);

            //Check is it there
            if (($iconsize[0] < 1) || ($iconsize[1] < 1)) {

                $error[] = $l['no_file_type_icon_found'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'addmime_theme';
            return false;
        }

        //Allow in posts ?
        if (isset($_POST['atmt_posts'])) {

            $atmt_posts = 1;
        }


        //Allow for avatars ?
        if (isset($_POST['atmt_avatar'])) {

            $atmt_avatar = 1;
        }


        //Is it an image ?
        if (isset($_POST['atmt_isimage'])) {

            $atmt_isimage = 1;
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'addmime_theme';
            return false;
        }


        ///////////////////////
        // INSERT the Mimetype
        ///////////////////////

        $qresult = makequery("INSERT INTO " . $dbtables['attachment_mimetypes'] . "
						SET atmt_ext = '$atmt_ext',
						atmt_mimetype = '$atmt_mimetype',
						atmt_icon = '$atmt_icon',
						atmt_posts = '$atmt_posts',
						atmt_avatar = '$atmt_avatar',
						atmt_isimage = '$atmt_isimage'");

        $atmtid = mysql_insert_id($conn);

        if (empty($atmtid)) {

            reporterror($l['add_attach_type_error'], $l['errors_adding_new_attach_type']);

            return false;
        }


        //Redirect
        redirect('act=admin&adact=attach&seadact=attmime');

        return true;
    } else {

        $theme['call_theme_func'] = 'addmime_theme';
    }
}

?>
