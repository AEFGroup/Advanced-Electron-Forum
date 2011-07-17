<?php

//////////////////////////////////////////////////////////////
//===========================================================
// checklogin.php
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

////////////////////////////////////////////
// When a user is considered to be logged-in
// 1 - Has Session VAR UID
// 2 - Has a Cookie for login information
////////////////////////////////////////////

////////////////////////////////////////////
// When a user logs in using the form
// 1 - SET Session VAR UID
// 2 - SET Session VAR 'aefsid'
// 3 - If the above two exist then a 
//     user is considered logged in
////////////////////////////////////////////

////////////////////////////////////////////
// When a user logs in using the COOKIES
// 1 - Confirm the COOKIE Pass
// 2 - SET Session VAR UID
// 3 - SET Session VAR 'aefsid'
// 4 - Finally the user is logged-in
////////////////////////////////////////////

////////////////////////////////////////////
// When a GUEST Visits what should happen :
// 1 - Register A Session VAR 'guest'
// 2 - Register A Session VAR 'aefsid'
// 3 - If the above two exist then dont 
//     register a new Session VAR
////////////////////////////////////////////

//////////////////////////////////////////
// BAN meaning
// temp_ban - Period for which banned
// temp_ban_time - Time when the user was 
//					banned
// temp_ban_ug - The original user group
//////////////////////////////////////////


function checklogin(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $errortitle, $errormessage, 
$errorheading, $act, $isbot;
	
	//This is AEF's Session start
	if(!load_session()){
	
		return false;
	
	}
	
	//Perform a session cleanup time tracker
	if(empty($AEF_SESS['dest_sess'])){
	
		$AEF_SESS['dest_sess'] = time();
	
	}
	
	
	if((time() - $AEF_SESS['dest_sess']) > 15*60){
	
		//Perform a Cleanup
		destroy_session();
		
		//Update the destroy time
		$AEF_SESS['dest_sess'] = time();
	
	}
	
	
	//This is to determine whether to go through the checking of the cookies or not
	if(isset($AEF_SESS['cuc']) && ((time() - $AEF_SESS['cuc']) > 15*60) ){
		
		$check = 1;
	
	}elseif(!isset($AEF_SESS['cuc'])){
	
		$check = 1;
	
	}else{
	
		$check = 0;
	
	}

	
	if(isset($_COOKIE[$globals['cookie_name']]['loguid']) && 
		isset($_COOKIE[$globals['cookie_name']]['logpass']) &&
		$check && empty($isbot)){
	
		$loguid = inputsec(htmlizer(trim($_COOKIE[$globals['cookie_name']]['loguid'])));
		
		$logpass = inputsec(htmlizer(trim($_COOKIE[$globals['cookie_name']]['logpass'])));
				
		/*echo $loguid;
		echo $logpass;*/
		
		if(!is_numeric($loguid)){
			
			unset($loguid);
			
		}
		
		if(preg_match('~^[A-Za-z0-9]{32}$~', $logpass) == 0){
			
			unset($logpass);
			
		}
		
		
		//Lets try and process
		if(isset($loguid) && isset($logpass)){
		
			if(!empty($globals['maintenance'])){
		
				$qresult = makequery("SELECT u.id, u.cookpass, u.act_status, u.lastlogin_1, 
								u.i_am_anon
								FROM ".$dbtables['users']." u, ".$dbtables['permissions']." p								
								WHERE u.id = '$loguid' AND 
								u.cookpass = '$logpass' AND
								p.member_group_id = u.u_member_group AND
								p.view_offline_board = 1");
				
				//Match found		
				if(mysql_num_rows($qresult) > 0){	
				
					$row = mysql_fetch_assoc($qresult);
					
					$login = true;
				
				}//End of Query IF
		
			}else{
			
				$qresult = makequery("SELECT id, cookpass, act_status, lastlogin_1, i_am_anon
									FROM ".$dbtables['users']."
									WHERE id = '$loguid'
									AND cookpass = '$logpass'");
									
				//Match found		
				if(mysql_num_rows($qresult) > 0){	
				
					$row = mysql_fetch_assoc($qresult);
					
					$login = true;
				
				}//End of Query IF
				
			}//End of Maintainenace IF
			
			if(isset($login) && $login){
			
				////////////////////////////////////////////////
				// DEFINE the CONSTANT AS_LUID for the Users ID
				////////////////////////////////////////////////
						
				define('AS_LUID', $row['id']);
				
				if($globals['anon_login'] && $row['i_am_anon']){
				
					$globals['i_am_anon'] = 1;
				
				}
				
				
				//Make the QUERY
				$qresult = makequery("UPDATE ".$dbtables['users']."
							SET lastlogin = '".$row['lastlogin_1']."',
							lastlogin_1 = '".time()."'
							WHERE id = '".$row['id']."'");
		
				if(mysql_affected_rows($conn) < 1){
					
					reporterror($l['cookie_login_error_title'], $l['cookie_login_error']);
										
					return false;
					
				}
								
				
				/////////////////////////////////
				// DELETE the USER SESSIONS for
				// if the user is logged in 
				// from somewhere else.
				/////////////////////////////////
				
				//Make the QUERY
				$qresult = makequery("DELETE FROM ".$dbtables['sessions']."
							WHERE uid = '".$row['id']."'");
							
				
				/////////////////////////////
				//Now lets Sign IN the User
				/////////////////////////////
				
				
				//If it is a recheck of COOKIE then Guest session isnt there
				if(empty($AEF_SESS['cuc'])){
				
				
					//First Lets DELETE the USERS Guest Session
					$qresult = makequery("DELETE FROM ".$dbtables['sessions']."
								WHERE uid = '-1'
								AND sid = '".AS_ID."'");
					
					if(mysql_affected_rows($conn) < 1){
						
						reporterror($l['cookie_login_error_title'], $l['cookie_login_error']);
						
						return false;
						
					}
				
				}
				
				
				//Process the DATA
				$data = process_as_data();
				
				//Add the new SESSION ROW
				$qresult = makequery("INSERT INTO ".$dbtables['sessions']." 
							SET sid = '".AS_ID."',
							uid = '".AS_LUID."',
							time = '".time()."',
							data = '$data',
							ip = '".($_SERVER['REMOTE_ADDR'])."',
							anonymous = '".$globals['i_am_anon']."'");
				
				if(mysql_affected_rows($conn) < 1){
					
					reporterror($l['cookie_login_error_title'], $l['cookie_login_error']);
					
					return false;
					
				}
				
			
			}//End of $login IF
		
		}//End of if(isset($loguid) && isset($logpass))
		
		$AEF_SESS['cuc'] = time();
		
	}//End of Main Cookie IF
	
	
	$uid = ((defined('AS_LUID')) ? AS_LUID : AS_UID);
	
	//Guests & Bots
	if($uid == -1 || $uid < -100){
	
		//echo 'Guest';
		
		$qresult = makequery("SELECT ug.*, p.*, s.* 
					FROM ".$dbtables['user_groups']." ug, 
					".$dbtables['permissions']." p, 
					".$dbtables['sessions']." s 
					WHERE p.member_group_id = ug.member_group
					AND ug.member_group = '-1'
					AND s.uid = '$uid' 
					AND s.sid = '".AS_ID."'");
		
		//Return false as is GUEST
		$to_return = false;
		
		//Certain extra fields defined for a user
		
	
	}else{
	
		//echo 'User';
		
		$qresult = makequery("SELECT u.*, ug.*, p.*, s.*, pg.member_group AS post_group, 
			pg.mem_gr_name AS post_gr_name
			FROM ".$dbtables['users']." u
			LEFT JOIN ".$dbtables['user_groups']." ug ON (u.u_member_group = ug.member_group)
			LEFT JOIN ".$dbtables['permissions']." p ON (p.member_group_id = ug.member_group)
			LEFT JOIN ".$dbtables['sessions']." s ON (s.uid = '".$uid."' AND s.sid = '".AS_ID."')
			LEFT JOIN ".$dbtables['user_groups']." pg ON (u.posts >= pg.post_count)
			WHERE u.id = '".$uid."'
			ORDER BY pg.member_group DESC
			LIMIT 0,1");
			
		//Return true as is USER	
		$to_return = true;
	
	}
	
	//Should not be possible though
	if(mysql_num_rows($qresult) < 1){
		
		return false;
		
	}
	
	$user = mysql_fetch_array($qresult);	
	//r_print($user);
	
	//Set the timezone if not there
	$globals['pgtimezone'] = (float) (empty($user['timezone']) ? $globals['timezone'] : $user['timezone']);
	
	//Free the resources
	@mysql_free_result($qresult);
	
	
	///////////////////////////////////////
	// IF a user has finished his temp ban
	///////////////////////////////////////
	
	if(($user['member_group'] == -3) && $user['temp_ban']){
	
		//Have we completed the Trial Period
		if(time() > ($user['temp_ban'] + $user['temp_ban_time'])){
		
			//Make the QUERY
			$qresult = makequery("UPDATE ".$dbtables['users']." 
						SET u_member_group = '".$user['temp_ban_ug']."',
						temp_ban = '0',
						temp_ban_time = 0
						WHERE id = '".$user['id']."'");
	
			if(mysql_affected_rows($conn) < 1){
				
				reporterror($l['cookie_login_error_title'], $l['cookie_login_error']);
				
				return false;
				
			}
			
			//Free the resources
			@mysql_free_result($qresult);
			
			$act = 'error_break';
			
			$to_return = false;
			
			//Redirect again
			redirect('');
		
		}
	
	}
	
	
	//////////////////////////////////////////
	// Load the Theme if user has selected it
	//////////////////////////////////////////
	
	if(isset($user['user_theme']) && $user['user_theme'] && !empty($globals['choose_theme'])){
	
		$globals['theme_id'] = $user['user_theme'];
	
	}
	
	
	//////////////////////////////////////
	// Is a Theme requested using the URL
	//////////////////////////////////////
	
	if(isset($_GET['thid']) && trim($_GET['thid'])!=="" && is_numeric(trim($_GET['thid'])) &&
		!empty($globals['choose_theme']) ){
	
		$globals['theme_id'] = (int) inputsec(htmlizer(trim($_GET['thid'])));
		
		//Also set it to this theme in the index URL
		$globals['index_url'] = $globals['index_url'].'&thid='.$globals['theme_id'].'&';
				
	}
	
	//////////////////
	// A Group Message
	//////////////////
	
	if(!empty($user['group_message'])){
	
		//Special bbc
		$user['group_message'] = parse_special_bbc($user['group_message']);
		
		//Format the text
		$user['group_message'] = format_text($user['group_message']);
		
		//Break it up
		$user['group_message'] = parse_br($user['group_message']);
	
	}
	
		
	return $to_return;

}


?>
