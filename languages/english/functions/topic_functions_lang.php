<?php

//////////////////////////////////////////////////////////////
//===========================================================
// topic_functions_lang.php(languages/english/functions)
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


/////////////////////////////////////////////////////////////
//Function checktitle_fn() strings - Checks title of a topic
/////////////////////////////////////////////////////////////

function checktitle_fn_lang(){

global $l, $globals; 

$l['title_too_long'] = 'The Topic\'s title length cannot be more than '.$globals['maxtitlechars'].' characters.';
$l['title_too_short'] = 'The Topic\'s title length cannot be less than '.$globals['mintitlechars'].' Characters.';

}


/////////////////////////////////////////////////////////////////////////
//Function checkdescription_fn() strings - Checks description of a topic
/////////////////////////////////////////////////////////////////////////

function checkdescription_fn_lang(){

global $l, $globals; 

$l['desc_too_long'] = 'The Topic\'s description length cannot be more than '.$globals['maxdescchars'].' characters.';
$l['desc_too_short'] = 'The Topic\'s description length cannot be less than '.$globals['mindescchars'].' Characters.';

}


///////////////////////////////////////////////////////////////
//Function checkpost_fn() strings - Checks the post of a topic
///////////////////////////////////////////////////////////////

function checkpost_fn_lang(){

global $l, $globals; 

$l['post_too_big'] = 'The Topic\'s post length cannot be more than '.$globals['maxcharposts'].' Characters.';
$l['post_too_small'] = 'The Topic\'s post length cannot be less than '.$globals['mincharposts'].' Characters.';
$l['too_many_smileys'] = 'A topic cannot have more than '.$globals['maxemotpost'].' smileys.';
$l['too_many_images'] = 'A topic cannot have more than '.$globals['maximgspost'].' images.';
$l['too_many_flash'] = 'A topic cannot have more than '.$globals['maxflashpost'].' flash objects embedded.';

}


/////////////////////////////////////////////////////////////////////////
//Function read_topic_fn() strings - Checks description of a topic
/////////////////////////////////////////////////////////////////////////

function read_topic_fn_lang(){

global $l, $globals; 

$l['read_topic_error_title'] = 'Read Topic Error';
$l['read_topic_error'] = 'Sorry, we were unable to update that you have read the topic as the connection with the database failed. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

}

?>