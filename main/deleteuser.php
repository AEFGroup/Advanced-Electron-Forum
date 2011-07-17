<?php

//////////////////////////////////////////////////////////////
//===========================================================
// deleteuser.php
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


function deleteuser(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $uid, $member, $error, $tree;

	//Load the Language File
	if(!load_lang('deleteuser')){
	
		return false;
		
	}
	
	//The name of the file
	$theme['init_theme'] = 'deleteuser';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Delete a user';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('deleteuser_theme');
	
		
	/////////////////////////////////////////
	//This section is only for permitted users
	if(!$user['can_del_other_account']){
	
		//Show a major error and return
		reporterror($l['cant_delete_user_title'], $l['cant_delete_user']);
			
		return false;
	
	}
	/////////////////////////////////////////
	
		
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$uid = 0;
	
	$member = array();
			
	$error = array();
	
	
	//Which user is it?
	if(isset($_GET['uid']) && strlen(trim($_GET['uid'])) > 0){
	
		$uid = (int) inputsec(htmlizer(trim($_GET['uid'])));
	
	}else{
	
		//Show a major error and return
		reporterror($l['no_user_specified_title'], $l['no_user_specified']);
			
		return false;
	
	}
	
	
	//Select the users profile	
	$qresult = makequery("SELECT u.id, u.username, ug.*
			FROM ".$dbtables['users']." u
			LEFT JOIN ".$dbtables['user_groups']." ug ON (ug.member_group = u.u_member_group)
			WHERE u.id = '$uid'");
			
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror($l['no_user_found_title'], $l['no_user_found']);
		
		return false;
		
	}
	
	$member = mysql_fetch_assoc($qresult);
	
	
	//Make some checks
	//Is it the user no. 1
	if($member['id'] == 1){
	
		//Show a major error and return
		reporterror($l['cant_delete_root_admin_title'], $l['cant_delete_root_admin']);
		
		return false;
	
	}
	
		
	//Am i an Admin and is some one other than ROOT ADMIN is trying to ban me
	if($member['member_group'] == 1 && $user['id'] != 1){
	
		//Show a major error and return
		reporterror($l['cant_delete_other_admin_title'], $l['cant_delete_other_admin']);
		
		return false;
	
	}
	
		
	$tree = array();//Board tree for users location
	$tree[] = array('l' => $globals['index_url'],
					'txt' => $l['index']);
	$tree[] = array('l' => $globals['index_url'].'act=deleteuser&uid='.$uid,
					'txt' => $member['username'],
					'prefix' => $l['deleting_user']);
	
	/////////////////////////////
	// What are you doing dude?
	/////////////////////////////
	
	$globals['last_activity'] = 'du';
	
	//He is viewing the profile
	$globals['activity_id'] = $member['id'];
	
	$globals['activity_text'] = $member['username'];
	
	//So its in for sure
	if(isset($_POST['deleteuser'])){
		
		//Delete the user
		if(!deletemember(array($uid))){
		
			$error[] = $l['delete_user_error'];
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'deleteuser_theme';
			return false;		
		}
		
		//Delete the 
		if(isset($_POST['deletetopicsposts'])){
		
			//Left for next version
		
		}
		
		//Redirect
		redirect('');
		
		return true;
	
	}else{
	
		$theme['call_theme_func'] = 'deleteuser_theme';	
	
	}
	
	
}


//Deletes all
function deletemember($id_array){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
	
	//Make them unique also
	$id_array = array_unique($id_array);
	
	array_multisort($id_array);
	
	$uid_str = implode(', ', $id_array);
	
	///////////////////////////
	// DELETE the USER Account
	///////////////////////////
	
	$qresult = makequery("DELETE FROM ".$dbtables['users']." 
				WHERE id IN ($uid_str)", false);

	if(mysql_affected_rows($conn) < 1){
							
		return false;
		
	}else{
		
		//fpass table
		$qresult = makequery("DELETE FROM ".$dbtables['fpass']." 
				WHERE fpuid IN ($uid_str)", false);
				
		//mark_read table
		$qresult = makequery("DELETE FROM ".$dbtables['mark_read']." 
				WHERE mr_uid IN ($uid_str)", false);
				
		//moderators table
		$qresult = makequery("DELETE FROM ".$dbtables['moderators']." 
				WHERE mod_mem_id IN ($uid_str)", false);
	
		/*//news table - Left out for the time being
		$qresult = makequery("DELETE FROM ".$dbtables['news']." 
				WHERE uid IN ($uid_str)", false);*/
				
		//notify_forum table
		$qresult = makequery("DELETE FROM ".$dbtables['notify_forum']." 
				WHERE notify_mid IN ($uid_str)", false);
		
		//notify_topic table
		$qresult = makequery("DELETE FROM ".$dbtables['notify_topic']."
				WHERE notify_mid IN ($uid_str)", false);
		
		//pm table - Presently we are deleting it all
		$qresult = makequery("DELETE FROM ".$dbtables['pm']."
				WHERE pm_from IN ($uid_str) 
				AND pm_to IN ($uid_str)", false);
				
		//read_board table
		$qresult = makequery("DELETE FROM ".$dbtables['read_board']." 
				WHERE rb_uid IN ($uid_str)", false);
		
		//read_forums table
		$qresult = makequery("DELETE FROM ".$dbtables['read_forums']." 
				WHERE rf_uid IN ($uid_str)", false);
		
		//read_topics table
		$qresult = makequery("DELETE FROM ".$dbtables['read_topics']." 
				WHERE rt_uid IN ($uid_str)", false);
				
		//sessions table - important if the user is logged in at the time of deleting
		$qresult = makequery("DELETE FROM ".$dbtables['sessions']." 
				WHERE uid IN ($uid_str)", false);
		
		
		//The Latest Member bug fix on DELETE
		$latest_tmp = explode('|', $globals['latest_mem']);
		
		$latest_mem = $latest_tmp[count($latest_tmp)-1];
		
		if(in_array($latest_mem, $id_array)){
		
			//Bring out the latest member
			$qresult = makequery("SELECT id, username FROM ".$dbtables['users']."
					".($globals['reg_method'] == 1 ? "" : "WHERE act_status = '1'")."
					ORDER BY id DESC
					LIMIT 0, 1");
					
			if(mysql_num_rows($qresult) > 0){
	
				$new_latest = mysql_fetch_assoc($qresult);
				
				$qresult = makequery("UPDATE ".$dbtables['registry']." 
					SET regval = '".$new_latest['username']."|".$new_latest['id']."' 
					WHERE name = 'latest_mem'");
				
			}
		
		}		
		
		return true;
	
	}

}

?>