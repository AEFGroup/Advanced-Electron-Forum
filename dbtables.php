<?php

if(!defined('AEF'))
{
die('Hacking Attempt');
}


$dbtables = array('users' => $globals['dbprefix'].'users',//The users table.
'themes' => $globals['dbprefix'].'themes',
'theme_registry' => $globals['dbprefix'].'theme_registry',
'user_groups' => $globals['dbprefix'].'user_groups',//The User Groups table.
'permissions' => $globals['dbprefix'].'permissions',//The permission as per groups.
'forums' => $globals['dbprefix'].'forums',
'forumpermissions' => $globals['dbprefix'].'forumpermissions',
'categories' => $globals['dbprefix'].'categories',
'topics' => $globals['dbprefix'].'topics',
'posts' => $globals['dbprefix'].'posts',
'moderators' => $globals['dbprefix'].'moderators',
'smileys' => $globals['dbprefix'].'smileys',
'notify_forum' => $globals['dbprefix'].'notify_forum',
'notify_topic' => $globals['dbprefix'].'notify_topic',
'read_board' => $globals['dbprefix'].'read_board',
'read_forums' => $globals['dbprefix'].'read_forums',
'read_topics' => $globals['dbprefix'].'read_topics',
'mark_read' => $globals['dbprefix'].'mark_read',
'polls' => $globals['dbprefix'].'polls',
'poll_options' => $globals['dbprefix'].'poll_options',
'poll_voters' => $globals['dbprefix'].'poll_voters',
'pm' => $globals['dbprefix'].'pm',
'registry' => $globals['dbprefix'].'registry',
'sessions' => $globals['dbprefix'].'sessions',
'fpass' => $globals['dbprefix'].'fpass',
'stats' => $globals['dbprefix'].'stats',
'attachments' => $globals['dbprefix'].'attachments',
'attachment_mimetypes' => $globals['dbprefix'].'attachment_mimetypes',
'news' => $globals['dbprefix'].'news',
'apps' => $globals['dbprefix'].'apps',
'apps_registry' => $globals['dbprefix'].'apps_registry',
'shouts' => $globals['dbprefix'].'shouts',
'errors' => $globals['dbprefix'].'errors'
);

?>