<?php

//////////////////////////////////////////////////////////////
//===========================================================
// adminlogin.php(Admin)
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

function adminlogin(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error;

	if(!load_lang('admin/adminlogin')){
    
		return false;
			
	}

	if(!empty($AEF_SESS['adtime']) && (time() - $AEF_SESS['adtime']) < (15*60) ){
	
		$AEF_SESS['adtime'] = time();
	
	}else{
	
		//The name of the file
		$theme['init_theme'] = 'admin/adminlogin';
		
		//The name of the Page
		$theme['init_theme_name'] = 'Admin Center - Login';
		
		//Array of functions to initialize
		$theme['init_theme_func'] = array('adminlogin_theme');
		
		if(isset($_POST['adminlogin'])){
		
			//Check the Password is there
			if(!(isset($_POST['adpass'])) || strlen(trim($_POST['adpass'])) < 1){
			
				$error[] = $l['no_password'];
				
			}else{
				
				$password = inputsec(htmlizer(trim($_POST['adpass'])));
				//echo $password;
				
				$pass = md5($user['salt'].$password);
				
				if($pass != $user['password']){
				
					$error[] = $l['password_invalid'];
				
				}else{
				
					$AEF_SESS['adtime'] = time();
					
					return true;
				
				}
				
			}
			
			//on error call the form
			if(!empty($error)){
				$theme['call_theme_func'] = 'adminlogin_theme';
				return false;		
			}
			
		}else{
		
			$theme['call_theme_func'] = 'adminlogin_theme';
		
		}
		
		return false;
	
	}
	
	return true;

}

?>
