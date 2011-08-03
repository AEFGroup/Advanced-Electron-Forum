<?php

//////////////////////////////////////////////////////////////
//===========================================================
// stats.php
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


//////////////////////////////////////
// Shows the statistics of the board
//////////////////////////////////////


function stats(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $tree;

	//The name of the file
	$theme['init_theme'] = 'stats';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Board Statistics';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('stats_theme');
	
	
	//Are stats enabled
	if(empty($globals['stats'])){
	
		//Show a major error and return
		reporterror('Stats Disabled' ,'Sorry, the maintainence of statistics has been disabled on this board. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.');
			
		return false;
	
	}					
	
	/////////////////////////////////////////
	//This section is only for permitted users
	if(!$user['view_stats']){
	
		//Show a major error and return
		reporterror('No Permissions' ,'Sorry, you do not have permissions to view this section of the Board. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.');
			
		return false;
	
	}
	/////////////////////////////////////////
	
	//He is viewing stats
	$globals['last_activity'] = 'st';
	
	//Remaining
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////

	$from = 0;
	
	$to = 0;
	
	$error = array();
		
	$tree = array();//Board tree for users location
	$tree[] = array('l' => $globals['index_url'],
					'txt' => 'Index');
	$tree[] = array('l' => $globals['index_url'].'act=stats',
					'txt' => 'Board Statistics',
					'prefix' => 'Viewing ');
	
	
	//From
	if( (isset($_POST['fd']) && strlen(trim($_POST['fd'])) > 0) || 
	(isset($_POST['fm']) && strlen(trim($_POST['fm'])) > 0) || 
	(isset($_POST['fy']) && strlen(trim($_POST['fy'])) > 0) ){
		
		//Day
		if(isset($_POST['fd']) && strlen(trim($_POST['fd'])) > 0){
		
			$fd = inputsec(htmlizer(trim($_GET['fd'])));
		
		}else{
		
			$error[] = 'You did not enter the day of the From Date.';
		
		}
		
		//Month
		if(isset($_POST['fm']) && strlen(trim($_POST['fm'])) > 0){
		
			$fm = inputsec(htmlizer(trim($_GET['fm'])));
		
		}else{
		
			$error[] = 'You did not enter the month of the From Date.';
		
		}
		
		
		//Year
		if(isset($_POST['fy']) && strlen(trim($_POST['fy'])) > 0){
		
			$fy = inputsec(htmlizer(trim($_GET['fy'])));
		
		}else{
		
			$error[] = 'You did not enter the year of the From Date.';
		
		}
		
		
		
	}
	
	//To
	if(!(isset($_POST['td'])) || strlen(trim($_POST['td'])) < 1 || 
	!(isset($_POST['tm'])) || strlen(trim($_POST['tm'])) < 1 || 
	!(isset($_POST['ty'])) || strlen(trim($_POST['ty'])) < 1 ){
	
		$error = 'You did not enter the TO Date Properly.';
		
	}else{
	
		$td = dc(trim($_POST['td']));
		$tm = dc(trim($_POST['tm']));
		$ty = trim($_POST['ty']);
		
		$to = $ty.$tm.$td;;
	
	}
	
	
	$theme['call_theme_func'] = 'stats_theme';


}

?>
