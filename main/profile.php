<?php

//////////////////////////////////////////////////////////////
//===========================================================
// profile.php
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

/////////////////////////////////////////////
// Shows the profile of the requested member
/////////////////////////////////////////////


function profile() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $member, $smileys, $smileycode, $smileyimages, $tree;

    //Load the Language File
    if (!load_lang('profile')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'profile';

    //The name of the Page
    $theme['init_theme_name'] = 'Profile Theme';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('profile_theme');

    /////////////////////////////////////////
    //This section is only for users
    if (!$user['can_view_profile']) {

        //Show a major error and return
        reporterror($l['cant_view_profile_title'], $l['cant_view_profile']);

        return false;
    }
    /////////////////////////////////////////

    if (!empty($_GET['mid']) && trim($_GET['mid']) && is_numeric(trim($_GET['mid']))) {

        $mid = (int) inputsec(htmlizer(trim($_GET['mid'])));
    } else {

        //Show a major error and return
        reporterror($l['no_member_specified_title'], $l['no_member_specified']);

        return false;
    }


    //Select the users profile
    $qresult = makequery("SELECT u.id, u.username, u.email, u.r_time, u.lastlogin, u.lastlogin_1,
            u.posts, u.realname, u.users_text, u.gender, u.birth_date, u.customtitle, u.location,
            u.www, u.timezone, u.gmail, u.icq, u.aim, u.yim, u.msn, u.sig, u.avatar, u.avatar_type,
            u.avatar_width, u.avatar_height, u.ppic, u.ppic_type, u.ppic_width, u.ppic_height,
            u.hideemail, u.u_member_group, ug.*
            FROM " . $dbtables['users'] . " u
            LEFT JOIN " . $dbtables['user_groups'] . " ug ON (ug.member_group = u.u_member_group)
            WHERE u.id = '$mid'");

    if (mysql_num_rows($qresult) < 1) {

        //Show a major error and return
        reporterror($l['no_member_found_title'], $l['no_member_found']);

        return false;
    }

    $member = mysql_fetch_assoc($qresult);

    $tree = array(); //Board tree for users location
    $tree[] = array('l' => $globals['index_url'],
        'txt' => $l['index']);
    $tree[] = array('l' => $globals['index_url'] . 'mid=' . $mid,
        'txt' => $member['username'],
        'prefix' => $l['viewing_prefix']);

    /////////////////////////////
    // What are you doing dude?
    /////////////////////////////

    $globals['last_activity'] = 'pro';

    //He is viewing the profile
    $globals['activity_id'] = $member['id'];

    $globals['activity_text'] = $member['username'];


    //Is avatars allowed globally
    if (!empty($member['avatar']) && $globals['showavatars']) {

        $avatar = array('avatar' => $member['avatar'],
            'avatar_type' => $member['avatar_type'],
            'avatar_width' => $member['avatar_width'],
            'avatar_height' => $member['avatar_height']
        );

        $member['avatarurl'] = urlifyavatar(100, $avatar);
    }


    //Load the personal pictures
    if (!empty($member['ppic'])) {

        $ppic = array('ppic' => $member['ppic'],
            'ppic_type' => $member['ppic_type'],
            'ppic_width' => $member['ppic_width'],
            'ppic_height' => $member['ppic_height']
        );

        $member['ppicurl'] = urlifyppic(100, $ppic);
    }


    //Hide the members email if set
    if ($member['hideemail'] == 1) {

        $member['email'] = '';
    }


    $showsmileys = ($logged_in ? ( $user['showsmileys'] == 1 ? true : ($user['showsmileys'] == 2 ? false : $globals['usesmileys']) ) : $globals['usesmileys']);

    //Are we to use smileys ?
    if ($globals['usesmileys'] && $showsmileys) {

        if (!getsmileys()) {

            return false;
        }
    }

    $member['sig'] = parse_special_bbc($member['sig']);

    $member['sig'] = format_text($member['sig']);

    $member['sig'] = parse_br($member['sig']);

    //What about smileys in sigs
    if ($globals['usesmileys'] && $showsmileys) {

        $member['sig'] = smileyfy($member['sig']);
    }

    $theme['call_theme_func'] = 'profile_theme';
}

?>
