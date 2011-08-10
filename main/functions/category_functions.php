<?php

//////////////////////////////////////////////////////////////
//===========================================================
// forum_functions.php(functions)
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

//////////////////////////////////////////
// Deletes the array of Category id given
//////////////////////////////////////////

function delete_categories_fn($cids) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;


    //Make them unique also
    $cids = array_unique($cids);

    array_multisort($cids);

    $cids_str = implode(', ', $cids);

    if (empty($cids)) {

        return false;
    }


    ////////////////////////
    // DELETE the Categories
    ////////////////////////

    $qresult = makequery("DELETE FROM " . $dbtables['categories'] . "
                    WHERE cid IN ($cids_str)", false);

    //How many were deleted ?
    $deleted = mysql_affected_rows($conn);

    if ($deleted != count($cids)) {

        return false;
    }


    //Bring the forums of these categories out
    $qresult = makequery("SELECT fid
            FROM " . $dbtables['forums'] . "
            WHERE cat_id IN ($cids_str)");

    //Were there any forums
    if (mysql_num_rows($qresult) > 0) {

        $fids = array();

        for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

            $row = mysql_fetch_assoc($qresult);

            $fids[] = $row['fid'];
        }

        //Free the resources
        @mysql_free_result($qresult);


        ////////////////////
        //DELETE the Forums
        ////////////////////

        if (!delete_forums($fids)) {

            return false;
        }
    }

    //Everything went just fine
    return true;
}

?>