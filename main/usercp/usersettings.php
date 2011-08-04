<?php

//////////////////////////////////////////////////////////////
//===========================================================
// usersettings.php(usercp)
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


if(!load_lang('usercp/usersettings')){
    
    return false;
        
}

//The name of the file
$theme['init_theme'] = 'usercp/usersettings';

//The name of the Page
$theme['init_theme_name'] = $l['uset_usercp_set'];

//Array of functions to initialize
$theme['init_theme_func'] = array('emailpmset_theme',
								'forumset_theme',
								'themeset_theme');



//////////////////////////////////////
// A simple function to edit the Users
// Email and PM Settings
// Value Meanings
// 0 - Use Default
// 1 - I want it(Implies Universal Set)
// 2 - I dont want it
//////////////////////////////////////

function emailpmset(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $tree;

	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=forumset',
					'txt' => $l['uset_set']);
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=emailpmset',
					'txt' => $l['uset_email_pm_set']);
	
	//The user is Posting some Personal Picture
	if(isset($_POST['editemailpmset'])){
		
		
		/////////////////////////////
		// Define the necessary VARS
		/////////////////////////////
		
		
		$adminemail = ((empty($_POST['adminemail'])) ? 0 : ($_POST['adminemail'] == 1 ? 1 : ($_POST['adminemail'] == 2 ? 2 : 0)));//Recieve Email Notifications from Administrator
		
		$hideemail = ((empty($_POST['hideemail'])) ? 0 : ($_POST['hideemail'] == 1 ? 1 : ($_POST['hideemail'] == 2 ? 2 : 0)));//Hide Email from members
		
		$subscribeauto = ((empty($_POST['subscribeauto'])) ? 0 : ($_POST['subscribeauto'] == 1 ? 1 : ($_POST['subscribeauto'] == 2 ? 2 : 0)));//On Replying or starting a Topic subscribe to it.
		
		$sendnewreply = ((empty($_POST['sendnewreply'])) ? 0 : ($_POST['sendnewreply'] == 1 ? 1 : ($_POST['sendnewreply'] == 2 ? 2 : 0)));//If subscribed then send just the notification or the post also.
		
		$pm_email_notify = ((empty($_POST['pm_email_notify'])) ? 0 : ($_POST['pm_email_notify'] == 1 ? 1 : ($_POST['pm_email_notify'] == 2 ? 2 : 0)));//Notify New PM by email.
		
		$pm_notify = ((empty($_POST['pm_notify'])) ? 0 : ($_POST['pm_notify'] == 1 ? 1 : ($_POST['pm_notify'] == 2 ? 2 : 0)));//Notify me about new PM when I visit the board.
		
		$saveoutgoingpm = ((empty($_POST['saveoutgoingpm'])) ? 0 : ($_POST['saveoutgoingpm'] == 1 ? 1 : ($_POST['saveoutgoingpm'] == 2 ? 2 : 0)));//Save a copy of every outgoing PM in my inbox.
		
		
		///////////////////////////////
		// Finally UPDATE the Users A/c
		///////////////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['users']." 
				SET adminemail = '$adminemail', 
				hideemail = '$hideemail',
				subscribeauto = '$subscribeauto',
				sendnewreply = '$sendnewreply',
				pm_email_notify = '$pm_email_notify',
				pm_notify = '$pm_notify',
				saveoutgoingpm = '$saveoutgoingpm'
				WHERE id = '".$user['id']."'", false);
		
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['uset_update_error'] ,$l['uset_update_error_exp']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		//Redirect
		redirect('act=usercp');
	
	//Show the form
	}elseif(isset($_POST['defaultemailpmset'])){
	
		///////////////////////////////
		// UPDATE the Users A/c
		///////////////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['users']." 
				SET adminemail = '0', 
				hideemail = '0',
				subscribeauto = '0',
				sendnewreply = '0',
				pm_email_notify = '0',
				pm_notify = '0',
				saveoutgoingpm = '0'
				WHERE id = '".$user['id']."'", false);
		
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['uset_update_error'] ,$l['uset_update_error_exp']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		//Redirect
		redirect('act=usercp');
	
	}else{
	
		$theme['call_theme_func'] = 'emailpmset_theme';
	
	}//End of Main IF
	

}//End of function



//////////////////////////////////////
// A simple function to edit the Users
// Forum Settings
// Value Meanings
// 0 - Use Default
// 1 - I want it(Implies Universal Set)
// 2 - I dont want it
//////////////////////////////////////

function forumset(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $themes, $tree, $lang_folders;

	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=forumset',
					'txt' => $l['uset_set']);

	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=forumset',
					'txt' => $l['uset_forum_set']);
					
	$lang_folders = array();
	
	$folders = filelist($globals['server_url'].'/languages/', 0, 1);
	
	foreach($folders as $k => $v){
	
		$lang_folders[$v['name']] = $v['name'];
	
	}

	///////////////////////////
	//Get the installed Themes
	///////////////////////////
	
	$qresult = makequery("SELECT * FROM ".$dbtables['themes']);
	
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror($l['uset_no_themes_found'] ,$l['uset_problem_boards_theme']);
		
		return false;
		
	}
	
	//The loop to draw out the rows
	for($i=1; $i <= mysql_num_rows($qresult); $i++){
		
		$row = mysql_fetch_assoc($qresult);
		
		$themes[$row['thid']] = $row;
		
		$themeids[] = $row['thid'];
						
	}
	
	//Free the resources
	@mysql_free_result($qresult);
	

	//The user is Posting some Personal Picture
	if(isset($_POST['editforumset'])){
		
		
		/////////////////////////////
		// Define the necessary VARS
		/////////////////////////////
		
		
		//Check the theme
		if(!(isset($_POST['user_theme'])) || (trim($_POST['user_theme']) == "") && !empty($globals['choose_theme'])){
		
			$error[] = $l['uset_forum_theme_no_posted_exp'];
			
		}else{
		
			$id_skin = (int) inputsec(htmlizer(trim($_POST['user_theme'])));
			
			//If the selected theme is not the forum default then check
			if(($id_skin != 0) && !in_array($id_skin, $themeids)){
			
				$error[] = $l['uset_forum_theme_invalid_exp'];
			
			}
			
			$user_theme = $id_skin;
			
		}
		
		//Check the Time Zone
		if(!(isset($_POST['timezone'])) || strlen(trim($_POST['timezone'])) < 1){
		
			$error[] = $l['no_time_zone'];
			
		}else{				
			
			$timezone = inputsec(htmlizer(trim($_POST['timezone'])));
			
			$valid_timezones = array(-12, -11, -10, -9, -8, -7, -6, -5, -4, -3.5, -3, -2, -1, '+0',
									1, 2, 3, 3.5, 4, 4.5, 5, 5.5, 6, 7, 8, 9, 9.5, 10, 11, 12, 0);
			
			if(!in_array($timezone, $valid_timezones)){
			
				$error[] = $l['uset_timezoner_invalid_exp'];
			
			}
			
		}
		
		//The language
		if(!(isset($_POST['language'])) || (trim($_POST['language']) == "")){
			
			$error[] = $l['uset_no_board_language_exp'];
			
		}else{
		
			$language = inputsec(htmlizer(trim($_POST['language'])));
			
			if(!in_array($language, $lang_folders)){
			
				$error[] = $l['uset_language_no_exist_exp'];
			
			}
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'forumset_theme';
			return false;		
		}
		
		$showsigs = ((empty($_POST['showsigs'])) ? 0 : ($_POST['showsigs'] == 1 ? 1 : ($_POST['showsigs'] == 2 ? 2 : 0)));//Show me sigs or not
		
		$showavatars = ((empty($_POST['showavatars'])) ? 0 : ($_POST['showavatars'] == 1 ? 1 : ($_POST['showavatars'] == 2 ? 2 : 0)));//Show avatars or not
		
		$showsmileys = ((empty($_POST['showsmileys'])) ? 0 : ($_POST['showsmileys'] == 1 ? 1 : ($_POST['showsmileys'] == 2 ? 2 : 0)));//Show the smileys or not
		
		$autofastreply = ((empty($_POST['autofastreply'])) ? 0 : ($_POST['autofastreply'] == 1 ? 1 : ($_POST['autofastreply'] == 2 ? 2 : 0)));//Show me the fast reply option as on / off if enabled
		
		$showimgs = ((empty($_POST['showimgs'])) ? 0 : ($_POST['showimgs'] == 1 ? 1 : ($_POST['showimgs'] == 2 ? 2 : 0)));//Show the images in the posts or PM's
		
		$i_am_anon = ((empty($_POST['i_am_anon'])) ? 0 : ($_POST['i_am_anon'] == 1 ? 1 : ($_POST['i_am_anon'] == 2 ? 2 : 0)));//When i log-in should i be anonymous		
		
		
		///////////////////////////////
		// Finally UPDATE the Users A/c
		///////////////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['users']." 
				SET user_theme = '$user_theme',
				showsigs = '$showsigs', 
				showavatars = '$showavatars',
				showsmileys = '$showsmileys',
				autofastreply = '$autofastreply',
				showimgs = '$showimgs',
				i_am_anon = '$i_am_anon',
				timezone = '$timezone',
				language = '$language'
				WHERE id = '".$user['id']."'", false);
		
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['uset_update_error'] ,$l['uset_update_error_exp']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		//Redirect
		redirect('act=usercp');
	
	//Show the form
	}elseif(isset($_POST['defaultforumset'])){
	
		///////////////////////////////
		// UPDATE the Users A/c
		///////////////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['users']." 
				SET user_theme = '0',
				showsigs = '0', 
				showavatars = '0',
				showsmileys = '0',
				autofastreply = '0',
				showimgs = '0',
				i_am_anon = '0',
				language = ''
				WHERE id = '".$user['id']."'", false);
		
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['uset_update_error'] ,$l['uset_update_error_exp']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		//Redirect
		redirect('act=usercp');
	
	}else{
	
		$theme['call_theme_func'] = 'forumset_theme';
	
	}//End of Main IF
	

}//End of function


//Function to edit a skins settings for a user
function themeset(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $theme_registry, $themes, $tree;

	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=forumset',
					'txt' => $l['uset_set']);
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=themeset&theme_id='.$globals['theme_id'],
					'txt' => $l['uset_theme_set']);
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$themes = array();
	
	$theme_registry = array();
	
	$registry = array();
	
	
	//Checks the theme_id is set or no
	if(empty($_GET['theme_id']) || trim($_GET['theme_id']) == "" || !is_numeric(trim($_GET['theme_id']))){
	
		//Show a major error and return
		reporterror($l['uset_no_theme_specified'] ,$l['uset_no_theme_specified_exp']);
			
		return false;
	
	}else{
	
		$thid = (int) inputsec(htmlizer(trim($_GET['theme_id'])));
	
	}	
	
	$theme_registry = theme_registry($thid, true);

	
	//Is theme registry proper
	if(empty($theme_registry) && !is_array($theme_registry)){
	
		//Show a major error and return
		reporterror($l['uset_error'] ,$l['uset_errors_loading_exp']);
			
		return false;
	
	}
	
	
	if(isset($_POST['editthemeset'])){

		foreach($theme_registry as $rk => $rv){
		
		foreach($theme_registry[$rk] as $k => $v){
		
			if($v['type'] == 'text' || $v['type'] == 'textarea'){
			
				if(isset($_POST[$k])){
					
					$theme_registry[$rk][$k]['value'] = inputsec(htmlizer(trim($_POST[$k])));
				
				}else{
				
					$theme_registry[$rk][$k]['value'] = '';
				
				}
			
			//Its a checkbox
			}else{
			
				if(isset($_POST[$k])){
				
					$theme_registry[$rk][$k]['value'] = 1;
				
				}else{
				
					$theme_registry[$rk][$k]['value'] = 0;
				
				}
			
			}
			
			//Store the registry
			$registry[$k] = $theme_registry[$rk][$k]['value'];
		
		}//End of loop 2
		
		}//End of loop 1
		
		$serialized_registry = serialize($registry);
		
		//////////////////////////////
		// REPLACE the Theme Registry
		//////////////////////////////
		
		$qresult = makequery("REPLACE INTO ".$dbtables['theme_registry']."
						SET theme_registry = '$serialized_registry',
						thid = '$thid',
						uid = ".$user['id']);
		
		//Redirect
		redirect('act=usercp');
		
		return true;
	
	}elseif(isset($_POST['defaultthemeset'])){
	
		//////////////////////////////
		// DELETE the Theme Registry
		//////////////////////////////
		
		$qresult = makequery("DELETE FROM ".$dbtables['theme_registry']."
						WHERE thid = '$thid' AND
						uid = ".$user['id']);
		
		//Redirect
		redirect('act=usercp');
		
		return true;
	
	}else{
	
		$theme['call_theme_func'] = 'themeset_theme';
	
	}

}
