<?php

//////////////////////////////////////////////////////////////
//===========================================================
// index.php(usercp)
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

    if(!load_lang('usercp/account')){
    
        return false;
        
    }

//The name of the file
$theme['init_theme'] = 'usercp/account';

//The name of the Page
$theme['init_theme_name'] = 'UserCP Account Related';

//Array of functions to initialize
$theme['init_theme_func'] = array('profile_theme',
								'account_theme',
								'signature_theme',
								'avatar_theme',
								'personalpic_theme');


function profile(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $tree;
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=profile',
					'txt' => $l['acc_profile']);
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=profile',
					'txt' => $l['acc_general']);
	
	//A error handler ARRAY
	$error = array();
	
	//Date Vars
	$dobyear = 0000;			
	$dobmonth = 00;			
	$dobday = 00;
	
	//Custom Title
	$title = '';
	
	//Location
	$location = '';
	
	//Gender
	$gender = 0;
	
	//Private Text
	$privatetext = '';
	
	//ICQ
	$icq = '';
	
	//YIM
	$yim = '';
	
	//MSN
	$msn = '';
	
	//AIM
	$aim = '';
	
	//GMail
	$gmail = '';
	
	//WWW
	$www = '';
	
	//Do some exploding for the user
	$dob = explode('-', $user['birth_date']);
	
	$user['dobyear'] = $dob[0];
	$user['dobmonth'] = $dob[1];
	$user['dobday'] = $dob[2];	
	
	
	if(isset($_POST['editprofile'])){		
				
		//Check the Date of Birth
		if( (isset($_POST['dobyear']) && trim($_POST['dobyear']) != "") &&
			(isset($_POST['dobmonth']) && trim($_POST['dobmonth']) != "")  &&
			(isset($_POST['dobday']) && trim($_POST['dobday']) != "") ){			
			
			
			//The Year Check
			if(is_numeric($_POST['dobyear']) && strlen(trim($_POST['dobyear'])) == 4){
				
				$dobyear = (int) inputsec(htmlizer(trim($_POST['dobyear'])));
				
				if($dobyear && ($dobyear < 1900 || $dobyear > 2006)){
				
					$error[] = $l['acc_year_invalid'];
				
				}
			
			}else{
			
				$error[] = $l['acc_year_invalid'];
			
			}
						
			
			//The Month Check
			if(is_numeric($_POST['dobmonth']) && strlen(trim($_POST['dobmonth'])) <= 2){
				
				$dobmonth = (int) inputsec(htmlizer(trim($_POST['dobmonth'])));
				
				if($dobmonth && ($dobmonth < 1 || $dobmonth > 12)){
				
					$error[] = $l['acc_month_invalid'];
				
				}
			
			}else{
			
				$error[] = $l['acc_month_invalid'];
			
			}
			
			
			
			//The Day Check
			if(is_numeric($_POST['dobday']) && strlen(trim($_POST['dobday'])) <= 2){
				
				$dobday = (int) inputsec(htmlizer(trim($_POST['dobday'])));
				
				if($dobday && ($dobday < 1 || $dobday > 31)){
				
					$error[] = $l['acc_day_invalid'];
				
				}
			
			}else{
			
				$error[] = $l['acc_day_invalid'];
			
			}
					
			
			
		}else{
		
			$dobyear = 0000;
			
			$dobmonth = 00;
			
			$dobday = 00;
			
		}
		
		//echo $dobyear, $dobmonth, $dobday;
		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'profile_theme';
			return false;		
		}
		
		
		//Check the Title if any
		if(isset($_POST['title']) && (trim($_POST['title']) != "")){
		
			$title = inputsec(htmlizer(trim($_POST['title'])));
			
			//Check maxlength in $globals (Cannot be more than 100)
			if(aefstrlen($title) > $globals['customtitlelen']){
				
				$error[] = $l['acc_cust_title_greater'];
				
			}
		
		}
		
		
		//Check the Location if any
		if(isset($_POST['location']) && (trim($_POST['location']) != "")){
		
			$location = inputsec(htmlizer(trim($_POST['location'])));
			
			//Check maxlength in $globals - (Cannot be more than 255)
			if(aefstrlen($location) > $globals['locationlen']){
				
				$error[] = $l['acc_locat_greater'];
				
			}
		
		}
		
		
		//Check the Gender if POSTED
		if(isset($_POST['gender']) && (trim($_POST['gender']) != "")){
		
			$gender = (int) inputsec(htmlizer(trim($_POST['gender'])));
			
			//Check is valid or no
			if(!in_array($gender, array(0, 1, 2))){
				
				$error[] = $l['acc_gender_incorrect'];
				
			}
		
		}
			
		
		//Check the Private Text if any
		if(isset($_POST['privatetext']) && (trim($_POST['privatetext']) != "")){
		
			$privatetext = inputsec(htmlizer(trim($_POST['privatetext'])));
			
			//You can add maxlength later in $globals
			if(aefstrlen($privatetext) > $globals['userstextlen']){
				
				$error[] = $l['acc_privtxt_greater'];
				
			}
		
		}
		
		
		//Check the ICQ
		if(isset($_POST['icq']) && (trim($_POST['icq']) != "")){
		
			$icq = inputsec(htmlizer(trim($_POST['icq'])));
			
			//You can add maxlength later in $globals
			if(aefstrlen($icq) > 255){
				
				$error[] = $l['acc_icq_invalid'];
				
			}
		
		}
		
		
		//Check the YIM
		if(isset($_POST['yim']) && (trim($_POST['yim']) != "")){
		
			$yim = inputsec(htmlizer(trim($_POST['yim'])));
			
			//You can add maxlength later in $globals
			if(aefstrlen($yim) > 255){
				
				$error[] = $l['acc_yim_invalid'];
				
			}
		
		}
		
		
		//Check the MSN
		if(isset($_POST['msn']) && (trim($_POST['msn']) != "")){
		
			$msn = inputsec(htmlizer(trim($_POST['msn'])));
			
			//You can add maxlength later in $globals
			if(aefstrlen($msn) > 255){
				
				$error[] = $l['acc_msn_invalid'];
				
			}
		
		}
		
		
		//Check the AIM
		if(isset($_POST['aim']) && (trim($_POST['aim']) != "")){
		
			$aim = inputsec(htmlizer(trim($_POST['aim'])));
			
			//You can add maxlength later in $globals
			if(aefstrlen($aim) > 255){
				
				$error[] = $l['acc_aim_invalid'];
				
			}
		
		}
		
		//Check the GMail
		if(isset($_POST['gmail']) && (trim($_POST['gmail']) != "")){
		
			$gmail = inputsec(htmlizer(trim($_POST['gmail'])));
			
			//You can add maxlength later in $globals
			if(aefstrlen($gmail) > 255){
				
				$error[] = $l['acc_gmail_invalid'];
				
			}
		
		}
				
		//Check the WWW
		if(isset($_POST['www']) && (trim($_POST['www']) != "")){
		
			$www = inputsec(htmlizer(trim($_POST['www'])));
			
			if(!preg_match('/^(http|https|ftp):\/\//i', $www)){
			
				$error[] = $l['acc_url_invalid'];
			
			}
			
			//You can add maxlength later in $globals
			if(aefstrlen($www) > $globals['wwwlen']){
				
				$error[] = $l['acc_url_greater'];
				
			}
		
		}
		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'profile_theme';
			return false;
		}
		
		
		/*echo 'Year :'.$dobyear.'<br />';			
		echo 'Month:'.$dobmonth.'<br />';			
		echo 'Day :'.$dobday.'<br />';
		echo 'Title :'.$title.'<br />';
		echo 'Location :'.$location.'<br />';
		echo 'Gender :'.$gender.'<br />';		
		echo 'Private Text :'.$privatetext.'<br />';
		echo 'ICQ :'.$icq.'<br />';
		echo 'YIM :'.$yim.'<br />';
		echo 'MSN :'.$msn.'<br />';
		echo 'AIM :'.$aim.'<br />';
		echo 'WWW :'.$www.'<br />';*/
		
		
		/////////////////////////////////
		// Finally make the UPDATE QUERY
		/////////////////////////////////
				
		$qresult = makequery("UPDATE ".$dbtables['users']." 
				SET birth_date = '$dobyear-$dobmonth-$dobday',
				customtitle = '$title',
				location = '$location',
				gender = '$gender',
				users_text = '$privatetext',
				icq = '$icq',
				yim = '$yim',
				msn = '$msn',
				aim = '$aim',
				gmail = '$gmail',
				www = '$www'
				WHERE id = '".$user['id']."'", false);
		
				
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['acc_upd_error'] ,$l['acc_errors_upd_profile']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);			
		
		
		//Redirect
		redirect('act=usercp');//IE 7 #redirect not working
		
		return true;
		
	}else{
	
		$theme['call_theme_func'] = 'profile_theme';
	
	}
		

}



//////////////////////////////////////////
// This function is for Account Settings
//////////////////////////////////////////

function account(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $tree;
		
	

	/////////////////////////////////////
	// Things Included in this form are :
	// 1) Real Name
	// 2) Password Editing
	// 3) Email Editing
	// 4) Secret Question and Answer
	// 5) If permissions Edit Post count
	/////////////////////////////////////
		
		
	///////////////////////////////
	// Define the necessary VARS
	///////////////////////////////
	
	$realname = '';//Real name VAR
	
	$username = $user['username'];//Username
	
	$newpass = '';//New Pass if the user gas set it
	
	$confnewpass = '';//Just to confirm the New Password for typing errors.
	
	$secretqt = '';//The secret question
	
	$answer = '';//The answer to the Secret Question
	
	$email = $user['email'];//The Email of the user
	
	$currentpass = '';//The users current password - Is Compulsory
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=profile',
					'txt' => $l['acc_profile']);
		
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=account',
					'txt' => $l['acc_acc_acc']);
		
	if(isset($_POST['editaccount'])){		
		
				
		/////////////////////////////////
		// Current Password is very much
		// necessary before processing 
		/////////////////////////////////
		
		if(!(isset($_POST['currentpass'])) || strlen(trim($_POST['currentpass'])) == 0){
			
			$error[] = $l['acc_no_curr_pass'];
		
		}else{
			
			$currentpass = inputsec(htmlizer(trim($_POST['currentpass'])));
			
			$currentpass = md5($user['salt'].$currentpass);
			
			//Check if it matches our current password
			if($currentpass !== $user['password']){
			
				$error[] = $l['acc_curr_pass_wrong'];
			
			}
			
		}
		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'account_theme';
			return false;
		}
		
		
		//Check the Real Name
		if(isset($_POST['realname']) && (trim($_POST['realname']) != "")){
		
			$realname = inputsec(htmlizer(trim($_POST['realname'])));
			
			//Check the MaxLength
			if(aefstrlen($realname) > $globals['realnamelen']){
				
				$error[] = $l['acc_name_greater'];
				
			}
		
		}
		
		
		//The username
		if(isset($_POST['username']) && strlen(trim($_POST['username'])) > 0 && $globals['change_username']){
			
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
			
				$error[] = $l['acc_uname_spaces'];
			
			}
			
			//If the username is different
			if($username != $user['username']){
			
				//Check in the Database
				if(usernameindb($username)){
				
					$error[] = $l['acc_uname_use'];
				
				}
			
			}
			
			
			$reserved = explode("\n", $globals['reserved_names']);
			
			for($i = 0; $i < count($reserved); $i++){
		
				if(!empty($reserved[$i])){
					
					$reserved[$i] = trim($reserved[$i]);
					
					$pattern = '/'.(($globals['reserved_match_whole'])?'\b':'').preg_quote($reserved[$i], '/').(($globals['reserved_match_whole'])?'\b':'').'/'.(($globals['reserved_match_insensitive'])?'i':'');
					
					if(preg_match($pattern, $username)){
					
						$error[] = $l['acc_uname_words'];
						
						break;
					
					}
				
				}
		
			}
			
		}
				
			
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'account_theme';
			return false;		
		}		
		
		
		//Check the New Password
		if(isset($_POST['newpass']) && (trim($_POST['newpass']) != "")){
		
			$newpass = inputsec(htmlizer(trim($_POST['newpass'])));
			
			//Check Max Length
			if(aefstrlen($newpass) > $globals['max_pass']){
				
				$error[] = $l['acc_pass_greater'];
				
			}
			
			//Check Min Length
			if(aefstrlen($newpass) < $globals['min_pass']){
				
				$error[] = $l['acc_pass_less'];
				
			}
			
			//Now we have to HTML Entity it and encrypt it
			$newpass =  md5($user['salt'].$newpass);
			
			
			//Check the New Password Confirmation Match
			if(!isset($_POST['confirmnewpass']) || (trim($_POST['confirmnewpass']) == "")){
			
				$error[] = $l['acc_no_conf_new_pass'];
			
			//Get and Check the Confirmed one with the New Password
			}else{
			
				$confnewpass = inputsec(htmlizer(trim($_POST['confirmnewpass'])));
				
				$confnewpass =  md5($user['salt'].$confnewpass);
			
				if($confnewpass != $newpass){
				
					$error[] = $l['acc_pass_diferent'];
				
				}//End of if($confnewpass != $newpass)
			
			}//End of if(!isset($_POST['confirmnewpass']) || (trim($_POST['co....
		
		}//End of if(isset($_POST['newpass']) && (trim($_POST['newpass']) != ""))
		
				
		
		//Check the Secret Question and Answer
		if(isset($_POST['secretqt']) && (trim($_POST['secretqt']) != "")){
		
			$secretqt = inputsec(htmlizer(trim($_POST['secretqt'])));
			
			//Check the MaxLength
			if(aefstrlen($secretqt) > $globals['secretqtlen']){
				
				$error[] = $l['acc_sec_qt_greater'];
				
			}
			
			//Check the Min Length
			if(aefstrlen($secretqt) < 15){
				
				$error[] = $l['acc_sec_qt_less'];
				
			}
			
			///////////////////////////////////
			// The answer is always encrypted
			// If it is set change else dont
			///////////////////////////////////
							
			//He wants to change
			if(isset($_POST['answer']) && (trim($_POST['answer']) != "")){
								
				$answer = inputsec(htmlizer(trim($_POST['answer'])));
			
				//Check the MaxLength
				if(aefstrlen($answer) > $globals['secretansmaxlen']){
					
					$error[] = $l['acc_sec_answ_greater'];
					
				}
				
				//Check the Min Length
				if(aefstrlen($answer) < $globals['secretansminlen']){
					
					$error[] = $l['acc_sec_answ_less'];
					
				}
				
				
				//MD5 the answer with the salt
				$answer = md5($user['salt'].$answer);
				
			
			}//End of if(isset($_POST['answer']) && (trim($_POST['answer']) != ""))
		
		
			//Check is the user giving his QT and ANS for the first time
			if(empty($user['secret_question']) && empty($answer)){
			
				$error[] = $l['acc_no_sec_answ'];
			
			}//End of if(empty($user['secret_answer']) && empty($answer))
		
		
		}//End of if(isset($_POST['secretqt']) && (trim($_POST['secretqt']) != ""))
		
		
		
		//Check the Email
		if(isset($_POST['email']) && (trim($_POST['email']) != "")){
						
			$email = inputsec(htmlizer(trim($_POST['email'])));			
			
			
			//////////////////////////////////
			// Email must undergo following
			// restriction checks
			// 1 - Max Length(for DB)
			// 2 - Email In Data Base
			// 3 - Email Expression
			//////////////////////////////////	
			
			if($user['email'] != $email){
			
				//Max Length
				if(aefstrlen($email) > 100){
				
					$error[] = $l['acc_email_large'];
				
				}			
				
				//Also confirm its validity
				if(!emailvalidation($email)){
		
					$error[] = $l['acc_email_invalid'];
				
				}
							
				//Check is it there in the Data Base
				if(emailindb($email)){
		
					$error[] = $l['acc_email_in_use'];
				
				}
			
			}
						
			
			///////////////////////////////////////////
			// Later put the option to verify the email
			// if the Admin has set so.
			///////////////////////////////////////////
			
				
		}
		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'account_theme';
			return false;
		}
				
		
		/*echo 'Real Name :'.$realname.'<br />';			
		echo 'New Password:'.$newpass.'<br />';			
		echo 'Confirm New Password :'.$confnewpass.'<br />';
		echo 'Secret Question :'.$secretqt.'<br />';
		echo 'Answer :'.$answer.'<br />';
		echo 'Email :'.$email.'<br />';		
		echo 'Current Pass :'.$currentpass.'<br />';*/
		
		
		
		/////////////////////////////////
		// Finally make the UPDATE QUERY
		/////////////////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['users']." 
				SET realname = '$realname',
				".((empty($globals['change_username'])) ? "" : "username='$username',")."				
				".((empty($newpass)) ? "" : "password='$newpass',")."
				secret_question = '$secretqt',
				".((empty($answer)) ? "" : "secret_answer='$answer',")."
				email = '$email'
				WHERE id = '".$user['id']."'", false);
		
		/*if(mysql_affected_rows($conn) < 1){
				
			reporterror('Update Error' ,'There were some errors in updating your Account Settings. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.');
			
			return false;
			
		}*/
		
		//Free the resources
		@mysql_free_result($qresult);
		
		//Redirect
		redirect('act=usercp');
		
		
	}else{
	
		$theme['call_theme_func'] = 'account_theme';
				
	}


}//End of function


////////////////////////////////////
// This funtion edits the users sig
////////////////////////////////////

function signature(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $tree;

	//Are we to use smileys ?
	if($globals['usesmileys']){
	
		if(!getsmileys()){
		
			return false;
		
		}
	
	}
	
	
	///////////////////////////////
	// Define the necessary VARS
	///////////////////////////////
		
	$signature = '';//Signature VAR
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=profile',
					'txt' => $l['acc_profile']);
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=signature',
					'txt' => $l['acc_acc_sig']);
	
	if(isset($_POST['editsig'])){		
		
		//Check the Sig was posted
		if(!(isset($_POST['signature'])) || strlen(trim($_POST['signature'])) < 1){
		
			$error[] = $l['acc_no_sig'];
			
		}else{
			
			//Dont trim for smileys
			$signature = inputsec(htmlizer($_POST['signature']));
			//echo $signature;
			
			//Check the MaxLength
			if(aefstrlen($signature) > $globals['usersiglen']){
					
				$error[] = $l['acc_sig_greater'];
					
			}
			
		}
				
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'signature_theme';
			return false;
		}
		
		
		/////////////////////////////////
		// Finally make the UPDATE QUERY
		/////////////////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['users']." 
				SET sig = '$signature'
				WHERE id = '".$user['id']."'", false);
		
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['acc_upd_error'] ,$l['acc_errors_upd_sig']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		//Redirect
		redirect('act=usercp');
		
	
	}else{

		$theme['call_theme_func'] = 'signature_theme';
	
	}


}//End of function





//////////////////////////////////////
// This funtion edits the users avatar
// Avatar types:
// 1)Forum Gallery - 1
// 2)URL by user - 2
// 3)Upload - 3
//////////////////////////////////////

function avatar(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $avatargallery, $tree;
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=profile',
					'txt' => $l['acc_profile']);
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=avatar',
					'txt' => $l['acc_acc_avatar']);
					
	//Get the files in Avatars Folder
	$avatargallery = getdirfiles($globals['avatardir']."/",1,0, array('png', 'gif', 'jpg'));
			
	//The user is Posting some avatar
	if(isset($_POST['editavatar'])){
		
		
		/////////////////////////////
		// Define the necessary VARS
		/////////////////////////////
		
		$avatartype = 0;//The type of avatar selected
		
		$avatar = '';//The actual avatar
		
		$avatarwidth = 0;//The avatar width
		
		$avatarheight = 0;//The Avatar Height		
		
	
		//Check the Avatar Type was posted
		if(!(isset($_POST['avatartype'])) || strlen(trim($_POST['avatartype'])) < 1){
		
			$error[] = $l['acc_no_avatar_type'];
			
		}else{
		
			$avatartype = (int) inputsec(htmlizer(trim($_POST['avatartype'])));
						
			if(!in_array($avatartype , array(1,2,3))){
			
				$error[] = $l['acc_avatar_type_invalid'];
			
			}			
		
		}
		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'avatar_theme';
			return false;		
		}
		
		
		//If it is the Avatar Gallery
		if($avatartype == 1){
		
		
			//Check the Avatar Selected in the Gallery
			if(!(isset($_POST['avatargalfile'])) || strlen(trim($_POST['avatargalfile'])) < 1){
			
				$error[] = $l['acc_no_avatar_gall'];
				
			}else{
			
				$avatar = inputsec(htmlizer(trim($_POST['avatargalfile'])));
				
				$avfile = $globals['avatardir']."/".$avatar;
				
				/*echo file_exists($avfile);
				echo is_file($avfile);
				echo filetype($avfile);
				echo $avfile;*/
				
				//Check whether it exists in our gallery
				if( !(file_exists($avfile) && is_file($avfile) && filetype($avfile) == "file") ){
				
					$error[] = $l['acc_avatar_gall_invalid'];
				
				}else{
				
					/////////////////////////////////////////////////
					//Check the dimensions are right and not too much
					/////////////////////////////////////////////////				
					
					//The error reposting is to be stopped by '@'
					$avsize = @getimagesize($avfile);
					/*echo '<pre>';
					print_r($avsize);
					echo '</pre>';*/
					
					//The avatar width
					if( ($avsize[0] < 1) || ($avsize[1] < 1) ){
					
						$error[] = $l['acc_no_img_in_gall'];
					
					}else{
					
						//The avatar width
						if($avsize[0] > $globals['av_width']){
							
							$error[] = $l['acc_img_width_greater'];				
						
						}else{
						
							$avatarwidth = $avsize[0];
						
						}
						
						
						//The avatar height
						if($avsize[1] > $globals['av_height']){
							
							$error[] = $l['acc_img_height_greater'];				
						
						}else{
						
							$avatarheight = $avsize[1];
						
						}
						
					}				
				
				}
					
			}	
			
			//on error call the form
			if(!empty($error)){
				$theme['call_theme_func'] = 'avatar_theme';
				return false;		
			}
			
			//We must delete the old uploaded avatar file if it is there
			delfileavatar();
			
		
		//If it is a URL Avatar
		}elseif($avatartype == 2){
		
		
			//Check the URL is mentioned
			if(!(isset($_POST['urlavatar'])) || strlen(trim($_POST['urlavatar'])) < 1){
			
				$error[] = $l['acc_no_url_online_img'];
				
			}else{
			
				$avatar = inputsec(htmlizer(trim($_POST['urlavatar'])));
				
				//Check its a Valid Link atleast
				if (!preg_match('/^(http|https|ftp):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(:(\d+))?\//i', $avatar)) {
				
					$error[] = $l['acc_url_online_img_invalid'];
				
				}else{
				
					/////////////////////////////////////////////////
					//Check the dimensions are right and not too much
					/////////////////////////////////////////////////
										
					$allow_url_open = (int) ini_get('allow_url_fopen');
					
					//Are we allowed to open URL
					if(empty($allow_url_open)){
					
						$avatarwidth = 90;
						
						$avatarheight = 90;
					
					}else{
					
						//Encode the spaces - PHP can't take it
						$avatartemp = str_replace(' ', '%20', $avatar);
						
						//The error reposting is to be stopped by '@'
						$avsize = @getimagesize($avatartemp);
						/*echo '<pre>';
						print_r($avsize);
						echo '</pre>';*/
						
						//The avatar width
						if( ($avsize[0] < 1) || ($avsize[1] < 1) ){
						
							$error[] = $l['acc_no_img_avatar_url'];
						
						}else{
						
													
							//The avatar width
							if($avsize[0] > $globals['av_width']){
								
								$error[] = $l['acc_upl_img_width_greater'];				
							
							}else{
							
								$avatarwidth = $avsize[0];
							
							}
							
							
							//The avatar height
							if($avsize[1] > $globals['av_height']){
								
								$error[] = $l['acc_upl_img_height_greater'];				
							
							}else{
							
								$avatarheight = $avsize[1];
							
							}
							
							//Later we need to add a file size check
							
						}
					
					}//End of allow_url_open
				
				}
				
			}
			
			
			//on error call the form
			if(!empty($error)){
				$theme['call_theme_func'] = 'avatar_theme';
				return false;		
			}
			
			//We must delete the old uploaded avatar file if it is there
			delfileavatar();
		
		//If Avatar is to be uploaded
		}elseif($avatartype == 3){
		
			/*echo '<pre>';
			print_r($_FILES);
			echo '</pre>';*/
			
			
			/////////////////////////////////////////////
			// First check if the $_FILES is empty dont
			// do any changes. 
			/////////////////////////////////////////////
			
			if(empty($_FILES['uploadavatar']['tmp_name']) &&
			   empty($_FILES['uploadavatar']['name']) &&
			   empty($_FILES['uploadavatar']['size']))
			{
				
				//Check was it previously an Uploaded avatar
				if($user['avatar_type'] != 3){
				
					$error[] = $l['acc_no_avatar_upl'];
				
				}else{
				
					$avatartype = 3;//The type of avatar selected
			
					$avatar = $user['avatar'];//The actual avatar
					
					$avatarwidth = $user['avatar_width'];//The avatar width
					
					$avatarheight = $user['avatar_height'];//The Avatar Height
					
				}
			
			//There is a new file
			}else{
			
			$avatartemp = $_FILES['uploadavatar']['tmp_name'];
			
			
			//Check the extensions
			$uploadavarray = explode('.', $_FILES['uploadavatar']['name']);
			
			$avext = $uploadavarray[count($uploadavarray)-1];
			//echo $avext;
			
			$allowedext = explode(',', $globals['avatartypes']);
			
			//The file is not allowed
			if(!in_array($avext, $allowedext)){
			
				$error[] = $l['acc_filetype_no_allow'];			

			}
			
						
			$avatar = 'av_'.$user['id'].'.'.$avext;
			
			
			//on error call the form
			if(!empty($error)){
				$theme['call_theme_func'] = 'avatar_theme';
				return false;		
			}
			
			
			/////////////////////////////////////////////////
			//Check the dimensions are right and not too much
			//This also checks if it is a Image or not
			/////////////////////////////////////////////////				
				
			//The error reposting is to be stopped by '@'
			$avsize = @getimagesize($avatartemp);
			/*echo '<pre>';
			print_r($avsize);
			echo '</pre>';*/
			
			//Check is it a image
			if( ($avsize[0] < 1) || ($avsize[1] < 1) ){
			
				$error[] = $l['acc_file_no_img'];
			
			//Do the necessary Checkings and Processing.
			}else{
			
			
				//The avatar width
				if($avsize[0] > $globals['av_width']){
					
					$error[] = $l['acc_upl_img_avatar_width_greater'];				
				
				}else{
				
					$avatarwidth = $avsize[0];
				
				}
				
				
				//The avatar height
				if($avsize[1] > $globals['av_height']){
					
					$error[] = $l['acc_upl_img_avatar_height_greater'];				
				
				}else{
				
					$avatarheight = $avsize[1];
				
				}
				
				
				//Lets check the size of the dam file
				if($_FILES['uploadavatar']['size'] > $globals['uploadavatarmaxsize']){
				
					$error[] = $l['acc_upl_img_avatar_size_greater'];
				
				}
				
				
				//on error call the form
				if(!empty($error)){
					$theme['call_theme_func'] = 'avatar_theme';
					return false;		
				}
				
				
				//We must delete the old file first if it is there
				delfileavatar();
				
				
				//Finally lets move the Avatar File
				if(!(@move_uploaded_file($avatartemp, $globals['uploadavatardir'].'/'.$avatar))){
				
					$error[] = $l['acc_img_no_upl'];
				
				}
				
			
			}//End of if( ($avsize[0] < 1) || ($avsize[1] < 1) )
			
			
			}//End of IF the avatar is to be changed
			
		
		//Else Big Error Dude - (Actually Impossible)
		}else{
		
			$error[] = $l['acc_errors_avatar_selected'];
		
		}
		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'avatar_theme';
			return false;		
		}
		
		/////////////////////////////////
		// Finally make the UPDATE QUERY
		/////////////////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['users']." 
				SET avatar = '$avatar', 
				avatar_type = '$avatartype',
				avatar_width = '$avatarwidth',
				avatar_height = '$avatarheight'
				WHERE id = '".$user['id']."'", false);
		
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['acc_upd_error'] ,$l['acc_errors_updat_avatar']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		//Redirect
		redirect('act=usercp');
	
	//The user wants to delete his avatar
	}elseif(isset($_POST['removeavatar'])){
	
		$qresult = makequery("UPDATE ".$dbtables['users']." 
				SET avatar = '', 
				avatar_type = '0',
				avatar_width = '0',
				avatar_height = '0'
				WHERE id = '".$user['id']."'", false);
		
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['acc_upd_error'] ,$l['acc_errors_updat_avatar']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		//We must delete the old file first if it is there
		delfileavatar();
		
		//Redirect
		redirect('act=usercp');
	
	//Show the form
	}else{
	
		$theme['call_theme_func'] = 'avatar_theme';
	
	}
	

}//End of function



/////////////////////////////////////////////
// This deletes the avatar file on change of
// an avatar to another type or on upload of
// another avatar.
/////////////////////////////////////////////


function delfileavatar(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
	
	//Delete only if the avatar type was three
	if($user['avatar_type'] == 3){
		
		//echo $globals['uploadavatardir'].'\\'.$user['avatar'];
		@unlink($globals['uploadavatardir'].'/'.$user['avatar']);
	
	}
	
}//End of function


/////////////////////////////////////////////
// This deletes the PPic file on change of
// an PPic to another type or on upload of
// another PPic.
/////////////////////////////////////////////


function delfileppic(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
	
	//Delete only if the avatar type was three
	if($user['ppic_type'] == 2){
		
		//echo $globals['uploadppicdir'].'\\'.$user['ppic'];
		@unlink($globals['uploadppicdir'].'/'.$user['ppic']);
	
	}
	
}//End of function



/////////////////////////////////////////
// This edits the users Personal Picture
// Personal Picture types:
// 1)URL by user - 1
// 2)Upload - 2
/////////////////////////////////////////

function personalpic(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $tree;
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=profile',
					'txt' => $l['acc_profile']);
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=personalpic',
					'txt' => $l['acc_acc_perpic']);
	
	//The user is Posting some Personal Picture
	if(isset($_POST['editppic'])){
		
		
		/////////////////////////////
		// Define the necessary VARS
		/////////////////////////////
		
		$ppictype = 0;//The type of Personal Picture selected
		
		$ppic = '';//The actual Personal Picture
		
		$ppicwidth = 0;//The Personal Picture width
		
		$ppicheight = 0;//The Personal Picture Height		
		
		
		//Check the Personal Picture Type was posted
		if(!(isset($_POST['ppictype'])) || strlen(trim($_POST['ppictype'])) < 1){
		
			$error[] = $l['acc_no_perpic_type'];
			
		}else{
		
			$ppictype = (int) inputsec(htmlizer(trim($_POST['ppictype'])));
			
			if(!in_array($ppictype , array(1,2))){
			
				$error[] = $l['acc_perpic_type_invalid'];
			
			}			
		
		}
		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'personalpic_theme';
			return false;		
		}
		
		
		//If it is a URL Personal Pic
		if($ppictype == 1){
		
		
			//Check the URL is mentioned
			if(!(isset($_POST['urlppic'])) || strlen(trim($_POST['urlppic'])) < 1){
			
				$error[] = $l['acc_no_url_online_img'];
				
			}else{
			
				$ppic = inputsec(htmlizer(trim($_POST['urlppic'])));
								
				//Check its a Valid Link atleast
				if (!preg_match('/^(http|https|ftp):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(:(\d+))?\//i', $ppic)) {
				
					$error[] = $l['acc_perpic_url_online_invalid'];
				
				}else{
				
					/////////////////////////////////////////////////
					//Check the dimensions are right and not too much
					/////////////////////////////////////////////////
					
					$allow_url_open = (int) ini_get('allow_url_fopen');
					
					//Are we allowed to open URL
					if(empty($allow_url_open)){
					
						$ppicwidth = 90;
						
						$ppicheight = 90;
					
					}else{
					
						//Encode the spaces - PHP can't take it
						$ppictemp = str_replace(' ', '%20', $ppic);
						
						//The error reposting is to be stopped by '@'
						$ppsize = @getimagesize($ppictemp);
						/*echo '<pre>';
						print_r($ppsize);
						echo '</pre>';*/
						
						//The Personal Picture width
						if( ($ppsize[0] < 1) || ($ppsize[1] < 1) ){
						
							$error[] = $l['acc_url_no_img'];
						
						}else{
						
													
							//The Personal Picture width
							if($ppsize[0] > $globals['ppic_width']){
								
								$error[] = $l['acc_img_perpic_width_greater'];				
							
							}else{
							
								$ppicwidth = $ppsize[0];
							
							}
							
							
							//The Personal Picture height
							if($ppsize[1] > $globals['ppic_height']){
								
								$error[] = $l['acc_img_perpic_height_greater'];				
							
							}else{
							
								$ppicheight = $ppsize[1];
							
							}
							
							//Later we need to add a file size check
							
						}
				
					}//End of allow_url_open
					
				}
				
			}
			
			
			//on error call the form
			if(!empty($error)){
				$theme['call_theme_func'] = 'personalpic_theme';
				return false;		
			}
			
			//We must delete the old uploaded Personal Pic file if it is there
			delfileppic();
		
		//If Personal Pic is to be uploaded
		}elseif($ppictype == 2){
		
			/*echo '<pre>';
			print_r($_FILES);
			echo '</pre>';*/
			
			
			/////////////////////////////////////////////
			// First check if the $_FILES is empty dont
			// do any changes. 
			/////////////////////////////////////////////
			
			if(empty($_FILES['uploadppic']['tmp_name']) &&
			   empty($_FILES['uploadppic']['name']) &&
			   empty($_FILES['uploadppic']['size']))
			{
			
				//Check was it previously an Uploaded avatar
				if($user['ppic_type'] != 2){
				
					$error[] = $l['acc_no_perpic_file_upl'];
				
				}else{
				
					$ppictype = 2;//The type of Per selected
			
					$ppic = $user['ppic'];//The actual Personal Picture
					
					$ppicwidth = $user['ppic_width'];//The Personal Picture width
					
					$ppicheight = $user['ppic_height'];//The Personal Picture Height
					
				}
			
			//There is a new file
			}else{
			
			$ppictemp = $_FILES['uploadppic']['tmp_name'];
			
			
			//Check the extensions
			$uploadpparray = explode('.', $_FILES['uploadppic']['name']);
			
			$ppext = $uploadpparray[count($uploadpparray)-1];
			//echo $ppext;
			
			$allowedext = explode(',', $globals['ppictypes']);
			
			//The file is not allowed
			if(!in_array($ppext, $allowedext)){
			
				$error[] = $l['acc_filetype_no_allow'];
			
			}
			
						
			$ppic = 'pp_'.$user['id'].'.'.$ppext;
			
			
			//on error call the form
			if(!empty($error)){
				$theme['call_theme_func'] = 'personalpic_theme';
				return false;		
			}
			
			
			/////////////////////////////////////////////////
			//Check the dimensions are right and not too much
			//This also checks if it is a Image or not
			/////////////////////////////////////////////////				
				
			//The error reposting is to be stopped by '@'
			$ppsize = @getimagesize($ppictemp);
			/*echo '<pre>';
			print_r($ppsize);
			echo '</pre>';*/
			
			//Check is it a image
			if( ($ppsize[0] < 1) || ($ppsize[1] < 1) ){
			
				$error[] = $l['acc_file_no_img'];
			
			//Do the necessary Checkings and Processing.
			}else{
			
			
				//The Personal Picture width
				if($ppsize[0] > $globals['ppic_width']){
					
					$error[] = $l['acc_img_perpic_width_greater'];				
				
				}else{
				
					$ppicwidth = $ppsize[0];
				
				}
				
				
				//The Personal Picture height
				if($ppsize[1] > $globals['ppic_height']){
					
					$error[] = $l['acc_img_perpic_height_greater'];				
				
				}else{
				
					$ppicheight = $ppsize[1];
				
				}
				
				
				//Lets check the size of the dam file
				if($_FILES['uploadppic']['size'] > $globals['uploadppicmaxsize']){
				
					$error[] = $l['acc_upl_img_perpic_size_greater'];
				
				}
				
				
				//on error call the form
				if(!empty($error)){
					$theme['call_theme_func'] = 'personalpic_theme';
					return false;		
				}
				
				
				//We must delete the old file first if it is there
				delfileppic();
				
				
				//Finally lets move the Personal Picture File
				if(!(@move_uploaded_file($ppictemp, $globals['uploadppicdir'].'/'.$ppic))){
				
					$error[] = $l['acc_no_upl_img'];
				
				}
				
			
			}//End of if( ($ppsize[0] < 1) || ($ppsize[1] < 1) )
			
			
			}//End of IF the Personal Pic is to be changed
			
		
		//Else Big Error Dude - (Actually Impossible)
		}else{
		
			$error[] = $l['acc_errors_perpic_selected'];
		
		}
		
		
		
		$qresult = makequery("UPDATE ".$dbtables['users']." 
				SET ppic = '$ppic', 
				ppic_type = '$ppictype',
				ppic_width = '$ppicwidth',
				ppic_height = '$ppicheight'
				WHERE id = '".$user['id']."'", false);
		
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['acc_upd_error'] ,$l['acc_errors_updat_perpic']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
				
		//Redirect
		redirect('act=usercp');
	
	//The user wants to delete his Personal Picture
	}elseif(isset($_POST['removeppic'])){
	
		$qresult = makequery("UPDATE ".$dbtables['users']." 
				SET ppic = '', 
				ppic_type = '0',
				ppic_width = '0',
				ppic_height = '0'
				WHERE id = '".$user['id']."'", false);
		
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['acc_upd_error'] ,$l['acc_errors_updat_perpic']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		//We must delete the old file first if it is there
		delfileppic();
		
		//Redirect
		redirect('act=usercp');
	
	//Show the form
	}else{
	
		$theme['call_theme_func'] = 'personalpic_theme';
	
	}//End of Main IF

}//End of function


?>