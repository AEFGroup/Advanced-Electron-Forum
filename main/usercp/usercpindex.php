<?php

//////////////////////////////////////////////////////////////
//===========================================================
// usercpindex.php(usercp)
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

if(!defined('AEF')){

	die('Hacking Attempt');

}


function usercpindex(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
	
	if(!load_lang('usercp/usercpindex')){
		
		return false;
			
	}
	
	//The name of the file
	$theme['init_theme'] = 'usercp/usercpindex';
	
	//The name of the Page
	$theme['init_theme_name'] = 'User Control Panel';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('usercpindex_theme');
	
	$theme['call_theme_func'] = 'usercpindex_theme';
	
	return true;

}


?>
