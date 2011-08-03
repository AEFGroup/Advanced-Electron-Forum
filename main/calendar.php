<?php

//////////////////////////////////////////////////////////////
//===========================================================
// index.php
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

function calendar(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $tree;

	if(!load_lang('calendar')){
	
		return false;
		
	}
	
	//The name of the file
	$theme['init_theme'] = 'calendar';
		
	//The name of the Page
	$theme['init_theme_name'] = 'Calendar Theme';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('monthview_theme');
	
	//My activity
	$globals['last_activity'] = 'cal';
	
	/////////////////////////////////
	// Are you allowed to see the calendar
	if(empty($user['view_calendar'])){
	
		reporterror($l['cant_view_title'], $l['cant_view']);
		
		return false;
	
	}
	/////////////////////////////////
	
	$tree = array();//Board tree for users location
	$tree[] = array('l' => $globals['index_url'],
					'txt' => $l['index']);
	$tree[] = array('l' => $globals['index_url'].'act=calendar',
					'txt' => $l['calendar']);
	
	//If a second Register act has been set
	if(isset($_GET['calact']) && trim($_GET['calact'])!==""){
	
		$calact = trim($_GET['calact']);
		
	}else{
	
		$calact = "";
		
	}
	
	//The switch handler
	switch($calact){
		
		default :
		monthview();
		break;	
	
	}
									
}


function monthview(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $tree, $days, $month, $year, $date, $birthdays, $today;
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$birthdays = array();
	
	$events = array();
	
	if(isset($_GET['date']) && trim($_GET['date'])!=="" && is_numeric(trim($_GET['date'])) && strlen(trim($_GET['date'])) == 8){
	
		$date = (int) inputsec(htmlizer(trim($_GET['date'])));
					
		$year = substr($date, 0, 4);
		
		$month = substr($date, 4, 2);
		
		$day =  substr($date, 6, 2);
		
		//Check the Year and Month
		if(!($year > 1969 && $year < 2038 && $month > 0 && $month <= 12 && $day > 0 && $day <= 31)){
		
			$date = 0;
		
		}
				
	}
	
	if(empty($date)){
	
		$date = datify(time(), false, true, 'Ymd');
		
	}
			
	$year = substr($date, 0, 4);
	
	$month = substr($date, 4, 2);
	
	$day =  substr($date, 6, 2);
	
	$today = datify(time(), false, true, 'Ymd');
	
	//Get the number of days
	$days = datify(mktime(0, 0, 0, $month, $day, $year), false, false, 't');
	
	//Add it to the tree
	$tree[] = array('l' => $globals['index_url'].'act=calendar&date='.datify(mktime(0, 0, 0, $month, 1, $year), false, false, 'Ymd'),
					'txt' => $l['months'][$month].' '.$year);	
	
	/////////////////////////////////////////
	// Are there any birthdays in this month?
	/////////////////////////////////////////
	
	$qresult = makequery("SELECT id, birth_date, username, DAY(birth_date) AS day, 
					MONTH(birth_date) AS month, YEAR(birth_date) AS year
					FROM ".$dbtables['users']." 
					WHERE birth_date != '0000-00-00'
					AND MONTH(birth_date) = '$month'");
	
	for($i = 0; $i < mysql_num_rows($qresult); $i++){
	
		$row = mysql_fetch_assoc($qresult);
		
		$row['age'] = $year - $row['year'];
		
		$birthdays[$row['day']][$row['id']] = $row;
							
	}
	
	//r_print($birthdays);
	
	$theme['call_theme_func'] = 'monthview_theme';

}


?>
