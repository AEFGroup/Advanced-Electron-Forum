<?php

//////////////////////////////////////////////////////////////
//===========================================================
// forum_functions_lang.php(languages/english/functions)
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


///////////////////////////////////////////////////////////
//Function read_forum_fn() strings - Marks a forum as read
///////////////////////////////////////////////////////////

function read_forum_fn_lang(){

global $l, $globals; 

$l['read_forum_error_title'] = 'Read Forum Error';
$l['read_forum_error'] = 'Sorry, we were unable to update that you have read the forum as the connection with the database failed. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

}


/////////////////////////////////////////////////////////////////////
//Function is_mod_fn() strings - Checks a user is a Moderator or not
/////////////////////////////////////////////////////////////////////

function is_mod_fn_lang(){

global $l, $globals; 

$l['load_moderator_error_title'] = 'Moderator Error';
$l['load_moderator_error'] = 'Could not load the moderators permission set from the system. Please contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.';

}

?>