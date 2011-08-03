<?php



//////////////////////////////////////////////////////////////
//===========================================================
// editprofile.php
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


/////////////////////////////////////////////
// Edits the profile of the requested member
/////////////////////////////////////////////


function editprofile(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $member, $tree, $error, $user_group;

	//Load the Language File
	if(!load_lang('editprofile')){
	
		return false;
		
	}
	
	//The name of the file
	$theme['init_theme'] = 'editprofile';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Edit Profile Theme';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('editprofile_theme');
	
	
	/////////////////////////////////////////
	//This section is only for users
	if(empty($user['can_edit_other_profile'])){
	
		//Show a major error and return
		reporterror($l['cant_edit_profile_title'], $l['cant_edit_profile']);
			
		return false;
	
	}
	/////////////////////////////////////////
	
	
	if(!empty($_GET['uid']) && trim($_GET['uid']) && is_numeric(trim($_GET['uid']))){
	
		$uid = (int) inputsec(htmlizer(trim($_GET['uid'])));
		
	}else{
	
		//Show a major error and return
		reporterror($l['no_user_specified_title'], $l['no_user_specified']);
			
		return false;
		
	}
	
	//Select the users profile	
	$qresult = makequery("SELECT u.id, u.username, u.email, u.r_time, u.lastlogin, u.posts,
			u.realname, u.users_text, u.gender, u.birth_date, u.customtitle, u.location, u.www, 
			u.timezone, u.gmail, u.icq, u.aim, u.yim, u.msn, u.sig, u.avatar, u.avatar_type, 
			u.avatar_width, u.avatar_height, u.ppic, u.ppic_type, u.ppic_width, u.ppic_height, 
			u.hideemail, u.u_member_group, ug.*
			FROM ".$dbtables['users']." u
			LEFT JOIN ".$dbtables['user_groups']." ug ON (ug.member_group = u.u_member_group)
			WHERE u.id = '$uid'");
			
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror($l['no_user_found_title'], $l['no_user_found']);
		
		return false;
		
	}
	
	$member = mysql_fetch_assoc($qresult);
	
	//Well lets see for the time being bunk it
	/*//No one can edit their own profile from here
	if($member['id'] == $user['id']){
	
		//Show a major error and return
		reporterror('Cannot Edit', 'Sorry, we were unable to process your request because a user cannot edit their profile from here. If you want to edit your profile please go to your <a href="'.$globals['index_url'].'act=usercp&ucpact=profile">User CP</a>. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.');
		
		return false;
	
	}*/
		
	//Am i an Admin and not is some one other than ROOT ADMIN is trying to ban me
	if($member['member_group'] == 1 && $user['id'] != 1){
	
		//Show a major error and return
		reporterror($l['cant_edit_other_admin_title'], $l['cant_edit_other_admin']);
		
		return false;
	
	}
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	//A error handler ARRAY
	$error = array();	
	
	$username = '';
	
	$email = '';
	
	$u_member_group = 0;
	
	$realname = '';
	
	$title = '';//Custom Title	
	
	$location = '';//Location	
	
	$gender = 0;//Gender	
	
	$privatetext = '';//Private Text
		
	$icq = '';//ICQ
	
	$yim = '';//YIM	
	
	$msn = '';//MSN	
	
	$aim = '';//AIM	
	
	$www = '';//WWW
	
	$sig = '';//Sig
	
	$tree = array();//Board tree for users location
	$tree[] = array('l' => $globals['index_url'],
					'txt' => $l['index']);
	$tree[] = array('l' => $globals['index_url'].'act=editprofile&uid='.$uid,
					'txt' => $member['username'],
					'prefix' => $l['editing_profile']);
					
	
	/////////////////////////////
	// What are you doing dude?
	/////////////////////////////
	
	$globals['last_activity'] = 'edpro';
	
	//He is viewing the profile
	$globals['activity_id'] = $member['id'];
	
	$globals['activity_text'] = $member['username'];
	
	
	/////////////////////////////////////////
	//Which member groups are allowed to view
	/////////////////////////////////////////
	
	//Get the user groups
	if(!membergroups()){
	
		return false;
	
	}
		
	
	if(isset($_POST['editprofile'])){
	
		//The username
		if(!(isset($_POST['username'])) || strlen(trim($_POST['username'])) < 1){
		
			$error[] = $l['no_username'];
			
		}else{
			
			$username = inputsec(htmlizer(trim($_POST['username'])));
			
			$len = aefstrlen($username);
			
			//Max Length
			if($len > $globals['max_uname']){
			
				$error[] = $l['max_name_length_crossed'];
			
			}
			
			//Min Length
			if($len < $globals['min_uname']){
			
				$error[] = $l['min_name_length_crossed'];
			
			}
			
			if(preg_match("/\s/i", $username)){
			
				$error[] = $l['space_in_name'];
			
			}
			
			//If the username is different
			if($username != $member['username']){
			
				//Check in the Database
				if(usernameindb($username)){
				
					$error[] = lang_vars($l['name_in_use'], array($username));
				
				}
			
			}			
			
			
			$reserved = explode("\n", $globals['reserved_names']);
			
			for($i = 0; $i < count($reserved); $i++){
		
				if(!empty($reserved[$i])){
					
					$reserved[$i] = trim($reserved[$i]);
					
					$pattern = '/'.(($globals['reserved_match_whole'])?'\b':'').preg_quote($reserved[$i], '/').(($globals['reserved_match_whole'])?'\b':'').'/'.(($globals['reserved_match_insensitive'])?'i':'');
					
					if(preg_match($pattern, $username)){
					
						$error[] = lang_vars($l['reserved_names'], array($reserved[$i]));
						
						break;
					
					}
				
				}
		
			}
			
		}
				
			
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'editprofile_theme';
			return false;		
		}
		
		//The email
		if(!(isset($_POST['email'])) || strlen(trim($_POST['email'])) < 1){
		
			$error[] = $l['no_email'];
			
		}else{
			
			$email = inputsec(htmlizer(trim($_POST['email'])));
			
			//////////////////////////////////
			// Email must undergo following
			// restriction checks
			// 1 - Max Length(for DB)
			// 2 - Email In Data Base
			// 3 - Email Expression
			//////////////////////////////////	
			
			//Max Length
			if(aefstrlen($email) > 100){
			
				$error[] = $l['email_too_big'];
			
			}			
			
			//Also confirm its validity
			if(!emailvalidation($email)){
	
				$error[] = $l['invalid_email'];
			
			}
						
			//If email is different
			if($email != $member['email']){
				
				//Check is it there in the Data Base
				if(emailindb($email)){
	
					$error[] = $l['email_in_use'];
				
				}
				
			}
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'editprofile_theme';
			return false;		
		}
		
		//The usergroup
		if(!(isset($_POST['u_member_group'])) || strlen(trim($_POST['u_member_group'])) < 1){
		
			$error[] = $l['no_user_group'];
			
		}else{
			
			$u_member_group = (int) inputsec(htmlizer(trim($_POST['u_member_group'])));
			
			if(!in_array($u_member_group, array_keys($user_group))){
			
				$error[] = $l['invalid_user_group'];
			
			}
			
			//Root admins user group cannot be changed
			if($member['id'] == 1 && $u_member_group != 1){
			
				$error[] = $l['root_admin_user_group'];
			
			}
			
			//For a admin only root admin can change user group - Actually not required
			if($member['member_group'] == 1 && $u_member_group != 1 && $user['id'] != 1){
			
				$error[] = $l['root_admin_ug_other_admin'];
			
			}
			
			
			//Only root admin can change user group to ADMIN
			if($member['member_group'] != 1 && $u_member_group == 1 && $user['id'] != 1){
			
				$error[] = $l['root_admin_make_admin'];
			
			}
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'editprofile_theme';
			return false;		
		}
		
		//Check the Real Name
		if(isset($_POST['realname']) && (trim($_POST['realname']) != "")){
		
			$realname = inputsec(htmlizer(trim($_POST['realname'])));
			
			//Check the MaxLength
			if(aefstrlen($realname) > $globals['realnamelen']){
				
				$error[] = $l['big_realname'];
				
			}
		
		}
		
		
		//Check the Title if any
		if(isset($_POST['title']) && (trim($_POST['title']) != "")){
		
			$title = inputsec(htmlizer(trim($_POST['title'])));
			
			//Check maxlength in $globals (Cannot be more than 100)
			if(aefstrlen($title) > $globals['customtitlelen']){
				
				$error[] = $l['big_custom_title'];
				
			}
		
		}
		
		
		//Check the Location if any
		if(isset($_POST['location']) && (trim($_POST['location']) != "")){
		
			$location = inputsec(htmlizer(trim($_POST['location'])));
			
			//Check maxlength in $globals - (Cannot be more than 255)
			if(aefstrlen($location) > $globals['locationlen']){
				
				$error[] = $l['big_location'];
				
			}
		
		}
		
		
		//Check the Gender if POSTED
		if(isset($_POST['gender']) && (trim($_POST['gender']) != "")){
		
			$gender = (int) inputsec(htmlizer(trim($_POST['gender'])));
			
			//Check is valid or no
			if(!in_array($gender, array(0, 1, 2))){
				
				$error[] = $l['invalid_gender'];
				
			}
		
		}
			
		
		//Check the Private Text if any
		if(isset($_POST['privatetext']) && (trim($_POST['privatetext']) != "")){
		
			$privatetext = inputsec(htmlizer(trim($_POST['privatetext'])));
			
			//You can add maxlength later in $globals
			if(aefstrlen($privatetext) > $globals['userstextlen']){
				
				$error[] = $l['big_private_text'];
				
			}
		
		}
		
		
		//Check the ICQ
		if(isset($_POST['icq']) && (trim($_POST['icq']) != "")){
		
			$icq = inputsec(htmlizer(trim($_POST['icq'])));
			
			//You can add maxlength later in $globals
			if(aefstrlen($icq) > 255){
				
				$error[] = $l['invalid_icq'];
				
			}
		
		}
		
		
		//Check the YIM
		if(isset($_POST['yim']) && (trim($_POST['yim']) != "")){
		
			$yim = inputsec(htmlizer(trim($_POST['yim'])));
			
			//You can add maxlength later in $globals
			if(aefstrlen($yim) > 255){
				
				$error[] = $l['invalid_yim'];
				
			}
		
		}
		
		
		//Check the MSN
		if(isset($_POST['msn']) && (trim($_POST['msn']) != "")){
		
			$msn = inputsec(htmlizer(trim($_POST['msn'])));
			
			//You can add maxlength later in $globals
			if(aefstrlen($msn) > 255){
				
				$error[] = $l['invalid_msn'];
				
			}
		
		}
		
		
		//Check the AIM
		if(isset($_POST['aim']) && (trim($_POST['aim']) != "")){
		
			$aim = inputsec(htmlizer(trim($_POST['aim'])));
			
			//You can add maxlength later in $globals
			if(aefstrlen($aim) > 255){
				
				$error[] = $l['invalid_aim'];
				
			}
		
		}
		
		
		//Check the WWW
		if(isset($_POST['www']) && (trim($_POST['www']) != "")){
		
			$www = inputsec(htmlizer(trim($_POST['www'])));
			
			//You can add maxlength later in $globals
			if(aefstrlen($www) > $globals['wwwlen']){
				
				$error[] = $l['big_www'];
				
			}
		
		}
		
		//Check the Sig
		if(isset($_POST['sig']) && (trim($_POST['sig']) != "")){
		
			//Dont trim for smileys
			$sig = inputsec(htmlizer($_POST['sig']));
			
			//Check the MaxLength
			if(aefstrlen($sig) > $globals['usersiglen']){
					
				$error[] = $l['big_signature'];
					
			}
		
		}		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'editprofile_theme';
			return false;
		}
		
		
		
		/////////////////////////////////
		// Finally make the UPDATE QUERY
		/////////////////////////////////
				
		$qresult = makequery("UPDATE ".$dbtables['users']." 
				SET username = '$username',
				email = '$email',
				u_member_group = '$u_member_group',
				realname = '$realname',
				customtitle = '$title',
				location = '$location',
				gender = '$gender',
				users_text = '$privatetext',
				icq = '$icq',
				yim = '$yim',
				msn = '$msn',
				aim = '$aim',
				www = '$www',
				sig = '$sig'
				WHERE id = '".$member['id']."'", false);
				
		//Redirect
		redirect('mid='.$uid);
	
	}else{
	
		$theme['call_theme_func'] = 'editprofile_theme';
	
	}
	

}

?>
