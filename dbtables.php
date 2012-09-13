<?php

//////////////////////////////////////////////////////////////
//===========================================================
// dbtables.php
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

$dbtables = array(
    'users' => $globals['dbprefix'] . 'users',
    'themes' => $globals['dbprefix'] . 'themes',
    'theme_registry' => $globals['dbprefix'] . 'theme_registry',
    'user_groups' => $globals['dbprefix'] . 'user_groups',
    'permissions' => $globals['dbprefix'] . 'permissions',
    'forums' => $globals['dbprefix'] . 'forums',
    'forumpermissions' => $globals['dbprefix'] . 'forumpermissions',
    'categories' => $globals['dbprefix'] . 'categories',
    'topics' => $globals['dbprefix'] . 'topics',
    'posts' => $globals['dbprefix'] . 'posts',
    'moderators' => $globals['dbprefix'] . 'moderators',
    'smileys' => $globals['dbprefix'] . 'smileys',
    'notify_forum' => $globals['dbprefix'] . 'notify_forum',
    'notify_topic' => $globals['dbprefix'] . 'notify_topic',
    'read_board' => $globals['dbprefix'] . 'read_board',
    'read_forums' => $globals['dbprefix'] . 'read_forums',
    'read_topics' => $globals['dbprefix'] . 'read_topics',
    'mark_read' => $globals['dbprefix'] . 'mark_read',
    'polls' => $globals['dbprefix'] . 'polls',
    'poll_options' => $globals['dbprefix'] . 'poll_options',
    'poll_voters' => $globals['dbprefix'] . 'poll_voters',
    'pm' => $globals['dbprefix'] . 'pm',
    'registry' => $globals['dbprefix'] . 'registry',
    'sessions' => $globals['dbprefix'] . 'sessions',
    'fpass' => $globals['dbprefix'] . 'fpass',
    'stats' => $globals['dbprefix'] . 'stats',
    'attachments' => $globals['dbprefix'] . 'attachments',
    'attachment_mimetypes' => $globals['dbprefix'] . 'attachment_mimetypes',
    'news' => $globals['dbprefix'] . 'news',
    'apps' => $globals['dbprefix'] . 'apps',
    'apps_registry' => $globals['dbprefix'] . 'apps_registry',
    'shouts' => $globals['dbprefix'] . 'shouts',
    'errors' => $globals['dbprefix'] . 'errors'
);
?>
