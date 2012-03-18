<?php

//////////////////////////////////////////////////////////////
//===========================================================
// attachment_functions.php(functions)
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

//Load the Language File
if (!load_lang('functions/attachment_functions')) {

    return false;
}

function attach_fn($fid, $tid, $pid) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    //Call the Language function
    attach_fn_lang();

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $atm = array();

    $allowedext = array();

    $name = array();

    $encname = array();

    $ftemp = array();

    $mimetype = array();

    $size = array();

    $member = ($logged_in ? $user['id'] : '-1');

    $width = array();

    $height = array();

    $upload_error = array(); //Files not uploaded

    $totalsize = 0;

    $uploaded = 0;

    $globals['maxattachsize'] = $globals['maxattachsize'] * 1024;

    $globals['maxattachsizepost'] = $globals['maxattachsizepost'] * 1024;


    /////////////////////////////////
    // SELECT the mime_types allowed
    /////////////////////////////////

    $qresult = makequery("SELECT * FROM " . $dbtables['attachment_mimetypes']);

    //Did we get anything
    if ((mysql_num_rows($qresult) > 0)) {

        for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

            $row = mysql_fetch_assoc($qresult);

            $atm[$row['atmtid']] = $row;

            //Only the ones allowed for posts
            if ($atm[$row['atmtid']]['atmt_posts']) {

                $allowedext[$row['atmtid']] = $atm[$row['atmtid']]['atmt_ext'];
            }
        }
    } else {

        reporterror($l['load_mime_error_title'], lang_vars($l['load_mime_error'], array($tid)));

        return false;
    }

    //Lets loop through the files
    foreach ($_FILES['attachments']['name'] as $k => $v) {

        if (empty($_FILES['attachments']['tmp_name'][$k])) {

            continue;
        }

        //The temporary name assigned
        $ftemp[$k] = $_FILES['attachments']['tmp_name'][$k];

        //The name
        $name[$k] = $_FILES['attachments']['name'][$k];

        $is_uploaded = is_uploaded_file($ftemp[$k]);

        //Is it uploaded properly
        if (empty($is_uploaded)) {

            reporterror($l['upload_error_title'], lang_vars($l['upload_error'], array($name[$k], $tid)));

            return false;
        }

        $ext = get_extension($name[$k]);

        $search = array_search($ext, $allowedext);

        //The file is not allowed
        if (empty($search)) {

            reporterror($l['file_not_allowed_title'], lang_vars($l['file_not_allowed'], array($name[$k], $tid)));

            return false;
        }

        $mimetype[$k] = $search;


        //Encrypted name with which the file will be stored
        $encname[$k] = generateRandStr(32) . '.' . $ext;


        ///////////////////////////////////
        // Size checks for the attachment
        ///////////////////////////////////
        //The size of the file
        $size[$k] = $_FILES['attachments']['size'][$k];

        //Check the size per attachment
        if ($size[$k] > $globals['maxattachsize']) {

            reporterror($l['attachment_too_big_title'], lang_vars($l['attachment_too_big'], array($name[$k], $tid)));

            return false;
        }

        $totalsize += $size[$k];

        //Check the total file size for this post
        if ($totalsize > $globals['maxattachsizepost']) {

            reporterror($l['attachments_size_big_title'], lang_vars($l['attachments_size_big'], array($tid)));

            return false;
        }


        //Is it a image ?
        if ($atm[$mimetype[$k]]['atmt_isimage']) {

            $imagesize = getimagesize($ftemp[$k]);

            $width[$k] = $imagesize[0];

            $height[$k] = $imagesize[1];
        } else {

            $width[$k] = 0;

            $height[$k] = 0;
        }
    }


    //////////////////////////////////////
    // If there were no attachments return
    //////////////////////////////////////

    if (empty($name)) {

        return true;
    }


    //Now lets perform the task of moving and saving in DB
    foreach ($name as $k => $v) {

        //Finally lets move the File
        if (move_uploaded_file($ftemp[$k], $globals['attachmentdir'] . '/' . $encname[$k])) {

            /////////////////////////
            // INSERT the attachment
            /////////////////////////

            $qresult = makequery("INSERT INTO " . $dbtables['attachments'] . "
                    SET at_original_file = '" . $name[$k] . "',
                    at_file = '" . $encname[$k] . "',
                    at_mimetype_id = '" . $mimetype[$k] . "',
                    at_size = '" . $size[$k] . "',
                    at_fid = '$fid',
                    at_pid = '$pid',
                    at_time = '" . time() . "',
                    at_mid = '$member',
                    at_width = '" . $width[$k] . "',
                    at_height = '" . $height[$k] . "'");

            $atid = mysql_insert_id($conn);

            if (empty($atid)) {

                //First delete the file
                unlink($globals['attachmentdir'] . '/' . $name[$k]);

                $upload_error[] = $name[$k];

                //Successful
            } else {

                $uploaded = $uploaded + 1;
            }

            //Could not move the file
        } else {

            $upload_error[] = $name[$k];
        }

        unset($atid);
    }


    /////////////////////////////////////////////
    // UPDATE the posts table for num_attachments
    /////////////////////////////////////////////

    $qresult = makequery("UPDATE " . $dbtables['posts'] . "
                    SET num_attachments = num_attachments + '$uploaded'
                    WHERE pid = '$pid'", false);

    if (mysql_affected_rows($conn) < 1) {

        reporterror($l['update_post_error_title'], lang_vars($l['update_post_error'], array($tid)));

        return false;
    }

    //////////////////////////////////////////
    // UPDATE the topics table for has_attach
    //////////////////////////////////////////

    $qresult = makequery("UPDATE " . $dbtables['topics'] . "
                    SET has_attach = has_attach + '$uploaded'
                    WHERE tid = '$tid'", false);

    if (mysql_affected_rows($conn) < 1) {

        reporterror($l['update_topic_error_title'], lang_vars($l['update_topic_error'], array($tid)));

        return false;
    }

    //If other things went well check for other errors
    if (!empty($upload_error)) {

        reporterror($l['attach_error_title'], lang_vars($l['attach_error'], array(implode(', ', $upload_error), $tid)));

        return false;
    }

    return true;
}

///////////////////////////////////
// Deletes a attachment from posts
// 5th param is for updating post
// for attachments.
///////////////////////////////////

function dettach_fn($fid, $tid, $pid, $attachments, $update = true) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    //Call the Language function
    dettach_fn_lang();

    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $delete_error = array();

    $deleted = 0;

    //Now lets perform the task of moving and saving in DB
    foreach ($attachments as $k => $v) {

        //Finally lets delete the File
        if (unlink($globals['attachmentdir'] . '/' . $v['at_file'])) {

            /////////////////////////
            // DELETE the attachment
            /////////////////////////

            $qresult = makequery("DELETE FROM " . $dbtables['attachments'] . "
                            WHERE atid = '" . $v['atid'] . "'", false);



            if (mysql_affected_rows($conn) < 1) {

                $delete_error[] = $v['at_original_file'];

                //Successful
            } else {

                $deleted++;
            }

            //Could not delete the file
        } else {

            $delete_error[] = $v['at_original_file'];
        }
    }

    if ($update) {

        /////////////////////////////////////////////
        // UPDATE the posts table for num_attachments
        /////////////////////////////////////////////

        $qresult = makequery("UPDATE " . $dbtables['posts'] . "
                    SET num_attachments = num_attachments - '$deleted'
                    WHERE pid = '$pid'", false);

        if (mysql_affected_rows($conn) < 1) {

            reporterror($l['update_post_error_title'], lang_vars($l['update_post_error'], array($tid)));

            return false;
        }
    }//End of $update
    //////////////////////////////////////////
    // UPDATE the topics table for has_attach
    //////////////////////////////////////////

    $qresult = makequery("UPDATE " . $dbtables['topics'] . "
                    SET has_attach = has_attach - '$deleted'
                    WHERE tid = '$tid'", false);

    if (mysql_affected_rows($conn) < 1) {

        reporterror($l['update_topic_error_title'], lang_vars($l['update_topic_error'], array($tid)));

        return false;
    }

    //If other things went well check for other errors
    if (!empty($delete_error)) {

        reporterror($l['dettach_error_title'], lang_vars($l['dettach_error'], array(implode(', ', $delete_error), $tid)));

        return false;
    }

    return true;
}

