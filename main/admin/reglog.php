<?php

//////////////////////////////////////////////////////////////
//===========================================================
// reglog.php(Admin)
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


function reglog(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

	if(!load_lang('admin/reglog')){
		
		return false;
			
	}

	//The name of the file
	$theme['init_theme'] = 'admin/reglog';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Admin Center - Registraion and Login Settings';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('regset_theme',
									'agerest_theme',
									'reserved_theme',
									'logset_theme');
	
	//My activity
	$globals['last_activity'] = 'arl';
	

	//If a second Admin act is set then go by that
	if(isset($_GET['seadact']) && trim($_GET['seadact'])!==""){
	
		$seadact = inputsec(htmlizer(trim($_GET['seadact'])));
	
	}else{
	
		$seadact = "";
		
	}
	

	//The switch handler
	switch($seadact){
	
		//The form for editing Registration Settings
		default:
		case 'regset':	
		regset();
		break;
		
		//The form for Age Restriction Settings
		case 'agerest':	
		agerest();
		break;
		
		//Set the reserved names
		case 'reserved':	
		reserved();
		break;
		
		//The form for editing Login Settings
		case 'logset':	
		logset();
		break;
		
	}

}



//Function to manage registration settings
function regset(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error;
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$allow_reg = 0;
	
	$reg_method = 0;//Registration methods 1,2,3
	
	$wel_email = 0;//Send a welcome email after Registration
	
	$reg_notify = 0;//After Registration Admin to be notified or No
	
	$max_pass = 0;//Registration Maximum Pass Length
	
	$max_uname = 0;//Registration Maximum Username Length
	
	$min_pass = 0;//Registration Minimum Pass Length
	
	$min_uname = 0;//Registration Minimum Username Length
	
	$sec_conf = 0;//To ask for a security confirmation code for registration
	
	$samepc_reg = 0;//Uses cookies of 1 day to stop multiple registration from same PC
	
	
	if(isset($_POST['editregset'])){
	
		//Are new registrations allowed ?
		if(isset($_POST['allow_reg'])){
			
			$allow_reg = 1;
			
		}
		
		
		//Welcome email
		if(isset($_POST['wel_email'])){
			
			$wel_email = 1;
			
		}
		
		//Notify Admin about registration
		if(isset($_POST['reg_notify'])){
			
			$reg_notify = 1;
			
		}
		
		//Security Confirmation
		if(isset($_POST['sec_conf'])){
			
			$sec_conf = 1;
			
		}
		
		
		//Same PC registration
		if(isset($_POST['samepc_reg'])){
			
			$samepc_reg = 1;
			
		}
		
		
		//Which method do you want?
		if(!(isset($_POST['reg_method'])) || (trim($_POST['reg_method']) == "")){
		
			$error[] = $l['no_reg_method'];
			
		}else{
		
			$reg_method = (int) inputsec(htmlizer(trim($_POST['reg_method'])));
			
			if(!in_array($reg_method, array(1,2,3))){
			
				$error[] = $l['reg_method_invalid'];
			
			}
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'regset_theme';
			return false;		
		}
		
		
		//Check the Max Username length
		if(!(isset($_POST['max_uname'])) || (trim($_POST['max_uname']) == "")){
			
			$error[] = $l['no_max_username_length'];
			
		}else{
		
			$max_uname = (int) inputsec(htmlizer(trim($_POST['max_uname'])));
			
		}
		
		//Check the Min Username length
		if(!(isset($_POST['min_uname'])) || (trim($_POST['min_uname']) == "")){
			
			$error[] = $l['no_min_username_length'];
			
		}else{
		
			$min_uname = (int) inputsec(htmlizer(trim($_POST['min_uname'])));
			
		}
		
		
		//Check the Max password length
		if(!(isset($_POST['max_pass'])) || (trim($_POST['max_pass']) == "")){
			
			$error[] = $l['no_max_pass_length'];
			
		}else{
		
			$max_pass = (int) inputsec(htmlizer(trim($_POST['max_pass'])));
			
		}
		
		//Check the Min password length
		if(!(isset($_POST['min_pass'])) || (trim($_POST['min_pass']) == "")){
			
			$error[] = $l['no_min_pass_length'];
			
		}else{
		
			$min_pass = (int) inputsec(htmlizer(trim($_POST['min_pass'])));
			
		}
		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'regset_theme';
			return false;		
		}
		
		
		
		//The array containing the REG SETTING Changes
		$regsetchanges = array('allow_reg' => $allow_reg,
						'reg_method' => $reg_method,
						'wel_email' => $wel_email,
						'reg_notify' => $reg_notify,
						'max_pass' => $max_pass,
						'max_uname' => $max_uname,
						'min_pass' => $min_pass,
						'min_uname' => $min_uname,
						'sec_conf' => $sec_conf,
						'samepc_reg' => $samepc_reg
						);
		
		/*foreach($logsetchanges as $k => $v){
		
			$str[] = "('$k', '$v')";
		
		}
		
		$qresult = makequery("INSERT INTO `registry` ( `name` , `regval` )
		VALUES ".implode(', ', $str));
		
		echo mysql_affected_rows($conn);*/
		
		if(!modify_registry($regsetchanges)){
		
			return false;
			
		}
		
		//Redirect
		redirect('act=admin&adact=reglog&seadact=regset');
		
		return true;
		
	
	}else{
	
		$theme['call_theme_func'] = 'regset_theme';
		
	}


}//End of function


//Function to age restriction settings
function agerest(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error;
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$age_limit = 0;//Registration age limit
	
	$age_rest_act = 0;//What to do on age Restriction(1,2)
	
	$age_rest_act_address = '';//Address to which form should be sent(Implies Rest Act 1)
	
	$age_rest_act_fax = '';//Fax No. to which form should be faxed(Implies Rest Act 1)
	
	$age_rest_act_tele = '';//Phone No for queries and doubts(Implies Rest Act 1)
	
	
	if(isset($_POST['editagerestset'])){
	
		//Check the age required
		if(!(isset($_POST['age_limit'])) || (trim($_POST['age_limit']) == "")){
			
			$error[] = $l['no_Age_limit'];
			
		}else{
		
			$age_limit = (int) inputsec(htmlizer(trim($_POST['age_limit'])));
			
		}
		
		//Which method do you want?
		if(!(isset($_POST['age_rest_act'])) || (trim($_POST['age_rest_act']) == "")){
		
			$error[] = $l['no_reg_method'];
			
		}else{
		
			$age_rest_act = (int) inputsec(htmlizer(trim($_POST['age_rest_act'])));
			
			if(!in_array($age_rest_act, array(1,2))){
			
				$error[] = $l['reg_method_invalid'];
			
			}
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'agerest_theme';
			return false;		
		}
		
		
		//Check the address
		if(isset($_POST['age_rest_act_address']) && trim($_POST['age_rest_act_address']) != ""){
		
			$age_rest_act_address = inputsec(htmlizer($_POST['age_rest_act_address']));
			
		}
		
		//Check the fax
		if(isset($_POST['age_rest_act_fax']) && trim($_POST['age_rest_act_fax']) != ""){
		
			$age_rest_act_fax = inputsec(htmlizer($_POST['age_rest_act_fax']));
			
		}
		
		
		//Check the telephone number
		if(isset($_POST['age_rest_act_tele']) && trim($_POST['age_rest_act_tele']) != ""){
		
			$age_rest_act_tele = inputsec(htmlizer($_POST['age_rest_act_tele']));
			
		}
		
				
		//The array containing the SETTING Changes
		$agerestchanges = array('age_limit' => $age_limit,
								'age_rest_act' => $age_rest_act,
								'age_rest_act_address' => $age_rest_act_address,
								'age_rest_act_fax' => $age_rest_act_fax,
								'age_rest_act_tele' => $age_rest_act_tele
								);
								
		if(!modify_registry($agerestchanges)){
		
			return false;
			
		}
		
		//Redirect
		redirect('act=admin&adact=reglog&seadact=agerest');
		
		return true;
		
	
	}else{
	
		$theme['call_theme_func'] = 'agerest_theme';
		
	}


}//End of function




//Function to set reserved usernames
function reserved(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error;
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$reserved_names = '';
	
	$reserved_match_whole = 0;//Match Whole words
	
	$reserved_match_insensitive = 0;//Make the matching insensitive
	
	
	if(isset($_POST['editreserved'])){
		
		//Check the reserved names
		if(isset($_POST['reserved_names']) && trim($_POST['reserved_names']) !== ""){
		
			$reserved_names = inputsec(htmlizer(trim($_POST['reserved_names'])));
			
		}
		
		//Match whole words
		if(isset($_POST['reserved_match_whole'])){
			
			$reserved_match_whole = 1;
			
		}
		
		
		//Case sensitive
		if(isset($_POST['reserved_match_insensitive'])){
			
			$reserved_match_insensitive = 1;
			
		}
		
		
				
		//The array containing the SETTING Changes
		$reservedchanges = array('reserved_names' => $reserved_names,
								'reserved_match_whole' => $reserved_match_whole,
								'reserved_match_insensitive' => $reserved_match_insensitive
								);
		
		if(!modify_registry($reservedchanges)){
		
			return false;
			
		}
		
		//Redirect
		redirect('act=admin&adact=reglog&seadact=reserved');
		
		return true;
		
	
	}else{
	
		$theme['call_theme_func'] = 'reserved_theme';
		
	}


}//End of function


//Function to set logset usernames
function logset(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error;
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$anon_login = 0;//Allow users to login Anonymously
	
	$login_failed = 0;//No.of attempts after which the guest is not allowed to login(0 disables it)
	
	$fpass_sec_conf = 0;//Forgot password or username security code
	
	$smart_redirect = 0;//Smart Redirect
	
	if(isset($_POST['editlogset'])){
		
		//Check the Max Number of Characters in a topics description
		if(!(isset($_POST['login_failed'])) || (trim($_POST['login_failed']) == "")){
			
			$error[] = $l['no_max_num_failed_login'];
			
		}else{
		
			$login_failed = (int) inputsec(htmlizer(trim($_POST['login_failed'])));
			
		}
		
		//Allow Anonymous Logins
		if(isset($_POST['anon_login'])){
			
			$anon_login = 1;
			
		}
		
		
		//Security confirmation
		if(isset($_POST['fpass_sec_conf'])){
			
			$fpass_sec_conf = 1;
			
		}
		
		//Smart Redirect
		if(isset($_POST['smart_redirect'])){
			
			$smart_redirect = 1;
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'logset_theme';
			return false;		
		}
		
				
		//The array containing the SETTING Changes
		$logsetchanges = array('login_failed' => $login_failed,
								'anon_login' => $anon_login,
								'fpass_sec_conf' => $fpass_sec_conf,
								'smart_redirect' => $smart_redirect
								);		
		
		
		if(!modify_registry($logsetchanges)){
		
			return false;
			
		}
		
		//Redirect
		redirect('act=admin&adact=reglog&seadact=logset');
		
		return true;
		
	
	}else{
	
		$theme['call_theme_func'] = 'logset_theme';
		
	}


}//End of function


?>
