<?php

//////////////////////////////////////////////////////////////
//===========================================================
// globals.php
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
// (c)Electron Inc.
//===========================================================
//////////////////////////////////////////////////////////////

if(!defined('AEF')){

	die('Hacking Attempt');

}

//URL's
$globals['index_url'] = $globals['url'].'/index.php?';
$globals['index'] = $globals['url'].'/index.php/';//For SEO
$globals['mail_url'] = $globals['index_url'];

/* Topic Icons */
$globals['topic_icons'][1] = array('info.png', 'Information');
$globals['topic_icons'][2] = array('bulb.png', 'New Idea');
$globals['topic_icons'][3] = array('help.png', 'Help');
$globals['topic_icons'][4] = array('question.png', 'Question ?');
$globals['topic_icons'][5] = array('ok.png', 'Ok');
$globals['topic_icons'][6] = array('star.png', 'Star');
$globals['topic_icons'][7] = array('down.png', 'Down');
$globals['topic_icons'][8] = array('left.png', 'Left');
$globals['topic_icons'][9] = array('right.png', 'Right');
$globals['topic_icons'][10] = array('add.png', 'Add');
//$globals['topic_icons'][11] = array('recycled.png', 'Recycled Posts');//Appears for everyone
/* Ending - Topic Icons */


/* Some Global VARS are just used for convenience */
//Should never be changed

$globals['hf_loaded'] = 0;//If the Headers and footers file is loaded
$globals['ahf_loaded'] = 0;//If the Admin Center Headers and footers file is loaded
$globals['queries'] = 0;//Number of queries
$globals['last_activity'] = '';//Last Activity of the user
$globals['viewing_board'] = 0;//The board the user is Viewing Currently - Deprecated
$globals['viewing_topic'] = 0;//The topic the user is Reading Currently - Deprecated
$globals['activity_id'] = 0;//The id of whatever activity the user is doing
$globals['activity_text'] = '';//The text of the activity link
$globals['i_am_anon'] = 0;//I am anonymous
$globals['tot_posts'] = 0;//Total Posts
$globals['tot_topics'] = 0;//Total Topics
$globals['newpost'] = 0;//New posts made by the user - STATS
$globals['newtopic'] = 0;//New topics started by the user - STATS
$globals['activetoday'] = 0;//The MAX users online today - STATS
$globals['newuser'] = 0;//New users registered in this page - STATS

/* Ending - Some Global VARS are just used for convenience */


//COOKIE Array Keys
$cookie = array('reg',//Has just registered
				'loguid',//Login User ID
				'logpass'//Log In Temp Password
				);

?>