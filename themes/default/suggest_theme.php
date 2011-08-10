<?php

function suggest_theme() {

    global $theme, $globals, $logged_in, $user, $usernames;

    if (empty($usernames)) {

        echo 'false';
    } else {

        echo 'new Array(\'' . implode('\', \'', $usernames) . '\');';
    }
}

?>