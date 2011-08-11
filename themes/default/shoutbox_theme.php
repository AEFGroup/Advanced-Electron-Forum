<?php

/////////////////////////////////////
// This just handles the Java Script
/////////////////////////////////////
/////////////////////////////////
// 0 - shoutid
// 1 - time
// 2 - user id
// 3 - username
// 4 - shout text
/////////////////////////////////

function showshout_theme() {

    global $theme, $globals, $logged_in, $user, $shouts;

    header("Cache-Control: no-cache, must-revalidate");

    if (empty($shouts)) {

        echo 'false';
    } else {

        foreach ($shouts as $sk => $sv) {

            $sv['shtime'] = datify($sv['shtime']);

            $sv['shtext'] = trim($sv['shtext']);

            $shouts[$sk] = 'new Array(\'' . $sv['shid'] . '\', \'' . $sv['shtime'] . '\', \'' . $sv['shuid'] . '\', \'' . $sv['username'] . '\', \'' . $sv['shtext'] . '\', \'' . $sv['shucolor'] . '\')';
        }

        echo 'new Array(' . implode(', ', $shouts) . ');';
    }
}

function addshout_theme() {

    global $theme, $globals, $logged_in, $user, $addedshout;

    header("Cache-Control: no-cache, must-revalidate");

    //If did not add the shout then ...
    if (empty($addedshout)) {

        echo 'false';

        //Added
    } else {

        echo 'true';
    }
}

function deleteshout_theme() {

    global $theme, $globals, $logged_in, $user, $deletedshout;

    header("Cache-Control: no-cache, must-revalidate");

    //If did not delete the shout then ...
    if (empty($deletedshout)) {

        echo 'false';

        //Deleted
    } else {

        echo 'true';
    }
}

?>