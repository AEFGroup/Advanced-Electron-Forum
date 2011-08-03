<?php

//////////////////////////////////////////////////////////////
//===========================================================
// banuser.php
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


function ban(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $uid, $member;

	//Load the Language File
	if(!load_lang('ban')){
	
		return false;
		
	}
	
	//The name of the file
	$theme['init_theme'] = 'ban';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Ban a user';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('putban_theme');
	
		
	/////////////////////////////////////////
	//This section is only for permitted users
	if(!$user['can_ban_user']){
	
		//Show a major error and return
		reporterror($l['cant_ban_title'], $l['cant_ban']);
			
		return false;
	
	}
	/////////////////////////////////////////
	
	
	
	//What to do ?
	if(isset($_GET['do']) && strlen(trim($_GET['do'])) > 0){
	
		$do = inputsec(htmlizer(trim($_GET['do'])));
	
	}else{
	
		//Show a major error and return
		reporterror($l['no_action_specified_title'], $l['no_action_specified']);
			
		return false;
	
	}
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$uid = 0;
	
	$member = array();
	
		
	//Which user is it?
	if(isset($_GET['uid']) && strlen(trim($_GET['uid'])) > 0){
	
		$uid = (int) inputsec(htmlizer(trim($_GET['uid'])));
	
	}else{
	
		//Show a major error and return
		reporterror($l['no_user_specified_title'], $l['no_user_specified']);
			
		return false;
	
	}
	
	
	//Select the users profile	
	$qresult = makequery("SELECT u.id, u.username, u.u_member_group, u.temp_ban_ug, ug.*
			FROM ".$dbtables['users']." u
			LEFT JOIN ".$dbtables['user_groups']." ug ON (ug.member_group = u.u_member_group)
			WHERE u.id = '$uid'");
			
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror($l['no_user_found_title'], $l['no_user_found']);
		
		return false;
		
	}
	
	$member = mysql_fetch_assoc($qresult);
	
	switch($do){
	
		case 'put':
		putban();
		break;
		
		case 'lift':
		liftban();
		break;
	
	}
	
}


function putban(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $tree, $member, $uid, $error;

	//Call the Language function
	putban_lang();
		
	//Make some checks
	//Is it the user no. 1
	if($member['id'] == 1){
	
		//Show a major error and return
		reporterror($l['cant_ban_root_admin_title'], $l['cant_ban_root_admin']);
		
		return false;
	
	}
	
	
	
	//No one can ban themselves
	if($member['id'] == $user['id']){
	
		//Show a major error and return
		reporterror($l['cant_ban_yourself_title'], $l['cant_ban_yourself']);
		
		return false;
	
	}
		
	//Am i an Admin and not is some one other than ROOT ADMIN is trying to ban me
	if($member['member_group'] == 1 && $user['id'] != 1){
	
		//Show a major error and return
		reporterror($l['cant_ban_other_admin_title'], $l['cant_ban_other_admin']);
		
		return false;
	
	}
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$days = 0;	
	
	$error = array();
	
	$time = 0;
	
	$tree = array();//Board tree for users location
	$tree[] = array('l' => $globals['index_url'],
					'txt' => $l['index']);
	$tree[] = array('l' => $globals['index_url'].'act=banuser&uid='.$uid,
					'txt' => $member['username'],
					'prefix' => $l['banning_user']);
	
	/////////////////////////////
	// What are you doing dude?
	/////////////////////////////
	
	$globals['last_activity'] = 'bu';
	
	//He is viewing the profile
	$globals['activity_id'] = $member['id'];
	
	$globals['activity_text'] = $member['username'];
	
	
	if(isset($_POST['putban'])){
	
		//For how many days is it?
		if(!(isset($_POST['days'])) || strlen(trim($_POST['days'])) < 1){
		
			$error[] = $l['no_days'];
			
		}else{
			
			$days = (int) inputsec(htmlizer(trim($_POST['days'])));
			
			if(empty($days)){
			
				$error[] = $l['invalid_days'];
			
			}
			
			$time = ($days*60*60*24);
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'putban_theme';
			return false;		
		}
		
		
		///////////////////////////
		// UPDATE the USER Account
		///////////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['users']." 
					SET u_member_group = '-3',
					temp_ban = '$time',
					temp_ban_time = '".time()."',
					temp_ban_ug = '".$member['u_member_group']."'
					WHERE id = '".$member['id']."'");

		if(mysql_affected_rows($conn) < 1){
			
			reporterror($l['ban_error_title'], $l['ban_error']);
								
			return false;
			
		}
		
		//Redirect
		redirect('mid='.$member['id']);
		
		return true;
	
	}else{	
			
		$theme['call_theme_func'] = 'putban_theme';	
	
	}	
	

}


function liftban(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $member, $uid;

	//Call the Language function
	liftban_lang();
	
	//Make some checks
		
	//No one can unban themselves
	if($member['id'] == $user['id']){
	
		//Show a major error and return
		reporterror($l['cant_unban_yourself_title'], $l['cant_unban_yourself']);
		
		return false;
	
	}
		
	//Am i an Admin and not is some one other than ROOT ADMIN is trying to ban me
	if($member['member_group'] == 1 && $user['id'] != 1){
	
		//Show a major error and return
		reporterror($l['cant_unban_other_admin_title'], $l['cant_unban_other_admin']);
		
		return false;
	
	}
	
	
	/////////////////////////////
	// What are you doing dude?
	/////////////////////////////
	
	$globals['last_activity'] = 'ubu';
	
	//He is viewing the profile
	$globals['activity_id'] = $member['id'];
	
	$globals['activity_text'] = $member['username'];
	
		
	///////////////////////////
	// UPDATE the USER Account
	///////////////////////////
	
	$qresult = makequery("UPDATE ".$dbtables['users']." 
				SET u_member_group = '".$member['temp_ban_ug']."',
				temp_ban = '0',
				temp_ban_time = '0',
				temp_ban_ug = '0'
				WHERE id = '".$member['id']."'");

	if(mysql_affected_rows($conn) < 1){
		
		reporterror($l['unban_error_title'], $l['unban_error']);
							
		return false;
		
	}
		
	//Redirect
	redirect('mid='.$member['id']);
	
	return true;
	

}

?>
