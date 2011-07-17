<?php

//////////////////////////////////////////////////////////////
//===========================================================
// users.php(Admin)
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


function users(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

	if(!load_lang('admin/users')){
		
		return false;
			
	}

	//The name of the file
	$theme['init_theme'] = 'admin/users';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Admin Center - User Settings';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('proacc_theme',
									'avaset_theme',
									'ppicset_theme',
									'pmset_theme');
	
	//My activity
	$globals['last_activity'] = 'aus';
	

	//If a second Admin act is set then go by that
	if(isset($_GET['seadact']) && trim($_GET['seadact'])!==""){
	
		$seadact = inputsec(htmlizer(trim($_GET['seadact'])));
	
	}else{
	
		$seadact = "";
		
	}
	

	//The switch handler
	switch($seadact){
	
		//The form for editing Profile and Account Settings
		default:
		case 'proacc':	
		proacc();
		break;
		
		//The form for editing Avatar Settings
		case 'avaset':	
		avaset();
		break;
		
		//The form for editing Personal Picture Settings
		case 'ppicset':	
		ppicset();
		break;
		
		//The form for editing Personal Message Settings
		case 'pmset':	
		pmset();
		break;

		
	}

}





//Function to manage Profile and Account settings
function proacc(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error;
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	//Profile Settings
	$userstextlen = 0;//The users own Text Length
	 
	$wwwlen = 0;//The WWW URL's Length 
	
	$customtitlelen = 0;//Users Custom Title Length (Cannot be more than 100)
	
	$locationlen = 0;//Users Location Length (Cannot be more than 255)
	
	//Account Settings
	$realnamelen = 0;//Users Real Name Max Length
	
	$secretqtlen = 0;//Users Secret Question Length
	
	$secretansmaxlen = 0;//Secret answers Max Length
	
	$secretansminlen = 0;//Secret answers Min Length
	
	$change_username = 0;//Change Username
	
	//Signature Settings
	$enablesig = 0;//Enable Sig
	
	$usersiglen = 0;//Users Sigature Max Length
	
	if(isset($_POST['editproacc'])){
	
		//Check the users own Text Length
		if(!(isset($_POST['userstextlen'])) || (trim($_POST['userstextlen']) == "")){
			
			$error[] = $l['usr_no_utxt_length'];
			
		}else{
		
			$userstextlen = (int) inputsec(htmlizer(trim($_POST['userstextlen'])));
			
		}
		
		//Check the WWW URL's Length 
		if(!(isset($_POST['wwwlen'])) || (trim($_POST['wwwlen']) == "")){
			
			$error[] = $l['usr_no_www_length'] ;
			
		}else{
		
			$wwwlen = (int) inputsec(htmlizer(trim($_POST['wwwlen'])));
			
		}
		
		
		//Check the custom title Length 
		if(!(isset($_POST['customtitlelen'])) || (trim($_POST['customtitlelen']) == "")){
			
			$error[] = $l['usr_no_utitle_length'];
			
		}else{
		
			$customtitlelen = (int) inputsec(htmlizer(trim($_POST['customtitlelen'])));
			
			if($customtitlelen > 100){
			
				$error[] = $l['usr_utitle_length_100'];
			
			}
			
		}
		
		//Check the location Length 
		if(!(isset($_POST['locationlen'])) || (trim($_POST['locationlen']) == "")){
			
			$error[] = $l['usr_no_uloc_length'];
			
		}else{
		
			$locationlen = (int) inputsec(htmlizer(trim($_POST['locationlen'])));
			
			if($locationlen > 255){
			
				$error[] = $l['usr_uloc_length_255'];
			
			}
			
		}		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'proacc_theme';
			return false;		
		}
		
		
		//Check the real name Length 
		if(!(isset($_POST['realnamelen'])) || (trim($_POST['realnamelen']) == "")){
			
			$error[] = $l['usr_no_urname_length'];
			
		}else{
		
			$realnamelen = (int) inputsec(htmlizer(trim($_POST['realnamelen'])));
			
		}
		
		//Check the secret question Length 
		if(!(isset($_POST['secretqtlen'])) || (trim($_POST['secretqtlen']) == "")){
			
			$error[] = $l['usr_no_usec_qt_length'];
			
		}else{
		
			$secretqtlen = (int) inputsec(htmlizer(trim($_POST['secretqtlen'])));
			
		}
		
		//Check the secret answer max Length 
		if(!(isset($_POST['secretansmaxlen'])) || (trim($_POST['secretansmaxlen']) == "")){
			
			$error[] = $l['usr_no_usec_answ_maxlength'] ;
			
		}else{
		
			$secretansmaxlen = (int) inputsec(htmlizer(trim($_POST['secretansmaxlen'])));
			
		}
		
		//Check the secret answer min Length 
		if(!(isset($_POST['secretansminlen'])) || (trim($_POST['secretansminlen']) == "")){
			
			$error[] = $l['usr_no_usec_answ_minlength'];
			
		}else{
		
			$secretansminlen = (int) inputsec(htmlizer(trim($_POST['secretansminlen'])));
			
		}
		
		//Username Change
		if(isset($_POST['change_username'])){
			
			$change_username = 1;
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'proacc_theme';
			return false;		
		}
		
		//Enable signatures
		if(isset($_POST['enablesig'])){
			
			$enablesig = 1;
			
		}
		
		//Check the real name Length 
		if(!(isset($_POST['usersiglen'])) || (trim($_POST['usersiglen']) == "")){
			
			$error[] = $l['usr_no_usig_maxlength'];
			
		}else{
		
			$usersiglen = (int) inputsec(htmlizer(trim($_POST['usersiglen'])));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'proacc_theme';
			return false;		
		}
		
		
		//The array containing the PRO ACC SETTING Changes
		$proaccchanges = array('userstextlen' => $userstextlen,
						'wwwlen' => $wwwlen,
						'customtitlelen' => $customtitlelen,
						'locationlen' => $locationlen,
						'realnamelen' => $realnamelen,
						'secretqtlen' => $secretqtlen,
						'secretansmaxlen' => $secretansmaxlen,
						'secretansminlen' => $secretansminlen,
						'change_username' => $change_username,
						'enablesig' => $enablesig,
						'usersiglen' => $usersiglen
						);
		
		
		if(!modify_registry($proaccchanges)){
		
			return false;
			
		}
		
		//Redirect
		redirect('act=admin&adact=users&seadact=proacc');
		
		return true;
	
	}else{
	
		$theme['call_theme_func'] = 'proacc_theme';
		
	}
	
}

//Function to manage Avatar settings
function avaset(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $addslashes;


	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$addslashes = true;	
	
	$showavatars = 0;//Global settings for posts and PM's
	
	$avatardir = '';//The Avatar Directory
	
	$avatarurl = '';//The Avatar URL
	
	$uploadavatardir = '';//The upload Directory where users upload their own avatars 
	
	$uploadavatarurl = '';//The Uploaded Avatar URL
	
	$uploadavatarmaxsize = 0;//The Size in Bytes
	
	$avatartypes = '';//What types of file to allow
	
	$av_width = 0;//The max width of a users avatar
	
	$av_height = 0;//The max height of a users avatar
	
	if(isset($_POST['editavaset'])){
		
		//Show avatars
		if(isset($_POST['showavatars'])){
			
			$showavatars = 1;
			
		}
		
		//Check the Avatar Directory
		if(!(isset($_POST['avatardir'])) || (trim($_POST['avatardir']) == "")){
			
			$error[] = $l['usr_no_avatar_dir'];
			
		}else{
		
			$avatardir = inputsec(htmlizer(trim($_POST['avatardir'])));
			
			$avatardir = rtrim($avatardir, '/\\');
			
		}
		
		//Check the Avatar URL
		if(!(isset($_POST['avatarurl'])) || (trim($_POST['avatarurl']) == "")){
			
			$error[] = $l['usr_no_avatar_url'];
			
		}else{
		
			$avatarurl = inputsec(htmlizer(trim($_POST['avatarurl'])));
			
			$avatarurl = rtrim($avatarurl, '/\\');
			
		}
		
		//Check the upload avatar dir
		if(!(isset($_POST['uploadavatardir'])) || (trim($_POST['uploadavatardir']) == "")){
			
			$error[] = $l['usr_no_up_avatar_dir'];
			
		}else{
		
			$uploadavatardir = inputsec(htmlizer(trim($_POST['uploadavatardir'])));
			
			$uploadavatardir = rtrim($uploadavatardir, '/\\');
			
		}
		
		
		//Check the upload avatar url
		if(!(isset($_POST['uploadavatarurl'])) || (trim($_POST['uploadavatarurl']) == "")){
			
			$error[] = $l['usr_no_up_avatar_url'];
			
		}else{
		
			$uploadavatarurl = inputsec(htmlizer(trim($_POST['uploadavatarurl'])));
			
			$uploadavatarurl = rtrim($uploadavatarurl, '/\\');
			
		}
				
		
		//Check the upload avatar max size
		if(!(isset($_POST['uploadavatarmaxsize'])) || (trim($_POST['uploadavatarmaxsize']) == "")){
			
			$error[] = $l['usr_no_maxsize_up_avatar'];
			
		}else{
		
			$uploadavatarmaxsize = inputsec(htmlizer(trim($_POST['uploadavatarmaxsize'])));
			
		}
		
		
		//Check the upload avatar types
		if(!(isset($_POST['avatartypes'])) || (trim($_POST['avatartypes']) == "")){
			
			$error[] = $l['usr_no_filetype_up_avatar'];
			
		}else{
		
			$avatartypes = inputsec(htmlizer(trim($_POST['avatartypes'])));
			
		}		
		
		//Check the avatar width
		if(!(isset($_POST['av_width'])) || (trim($_POST['av_width']) == "")){
			
			$error[] = $l['usr_no_avatars_max_width'];
			
		}else{
		
			$av_width = inputsec(htmlizer(trim($_POST['av_width'])));
			
		}	
		
		//Check the avatar height
		if(!(isset($_POST['av_height'])) || (trim($_POST['av_height']) == "")){
			
			$error[] = $l['usr_no_avatars_max_height'];
			
		}else{
		
			$av_height = inputsec(htmlizer(trim($_POST['av_height'])));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'avaset_theme';
			return false;		
		}
	
		
		//The array containing the AVATAR SETTING Changes
		$avasetchanges = array('showavatars' => $showavatars,
						'avatardir' => $avatardir,
						'avatarurl' => $avatarurl,
						'uploadavatardir' => $uploadavatardir,
						'uploadavatarurl' => $uploadavatarurl,
						'uploadavatarmaxsize' => $uploadavatarmaxsize,
						'avatartypes' => $avatartypes,
						'av_width' => $av_width,
						'av_height' => $av_height
						);
		
		if(!modify_registry($avasetchanges)){
		
			return false;
			
		}
		
		//Redirect
		redirect('act=admin&adact=users&seadact=avaset');
		
		return true;
		
		
	}else{
	
		$theme['call_theme_func'] = 'avaset_theme';
		
	}
	
}


//Function to manage Personal Picture settings
function ppicset(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $addslashes;


	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$addslashes = true;	
	
	$uploadppicdir = '';//The upload Directory where users upload their own Personal Pictures
	
	$uploadppicurl = '';//The Uploaded Personal Pic URL
	
	$uploadppicmaxsize = 0;//The Size in Bytes
	
	$ppictypes = '';//What types of file to allow
	
	$ppic_width = 0;//The max width of a users Personal Picture
	
	$ppic_height = 0;//The max height of a users Personal Picture

	if(isset($_POST['editppicset'])){
	
		//Check the upload personal picture dir
		if(!(isset($_POST['uploadppicdir'])) || (trim($_POST['uploadppicdir']) == "")){
			
			$error[] = $l['usr_no_up_perpic_dir'];
			
		}else{
		
			$uploadppicdir = inputsec(htmlizer(trim($_POST['uploadppicdir'])));
			
			$uploadppicdir = rtrim($uploadppicdir, '/\\');
			
		}
		
		
		//Check the upload personal picture url
		if(!(isset($_POST['uploadppicurl'])) || (trim($_POST['uploadppicurl']) == "")){
			
			$error[] = $l['usr_no_up_perpic_url'];
			
		}else{
		
			$uploadppicurl = inputsec(htmlizer(trim($_POST['uploadppicurl'])));
			
			$uploadppicurl = rtrim($uploadppicurl, '/\\');
			
		}
				
		
		//Check the upload personal picture max size
		if(!(isset($_POST['uploadppicmaxsize'])) || (trim($_POST['uploadppicmaxsize']) == "")){
			
			$error[] = $l['usr_no_maxsize_up_perpic'];
			
		}else{
		
			$uploadppicmaxsize = inputsec(htmlizer(trim($_POST['uploadppicmaxsize'])));
			
		}
		
		
		//Check the upload ppic types
		if(!(isset($_POST['ppictypes'])) || (trim($_POST['ppictypes']) == "")){
			
			$error[] = $l['usr_no_filetype_up_perpic'];
			
		}else{
		
			$ppictypes = inputsec(htmlizer(trim($_POST['ppictypes'])));
			
		}
				
		
		//Check the Personal Picture width
		if(!(isset($_POST['ppic_width'])) || (trim($_POST['ppic_width']) == "")){
			
			$error[] = $l['usr_no_perpic_max_width'];
			
		}else{
		
			$ppic_width = inputsec(htmlizer(trim($_POST['ppic_width'])));
			
		}	
		
		//Check the Personal Picture height
		if(!(isset($_POST['ppic_height'])) || (trim($_POST['ppic_height']) == "")){
			
			$error[] = $l['usr_no_perpic_max_height'];
			
		}else{
		
			$ppic_height = inputsec(htmlizer(trim($_POST['ppic_height'])));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'ppicset_theme';
			return false;		
		}
		
		
		//The array containing the PPIC SETTING Changes
		$ppicsetchanges = array('uploadppicdir' => $uploadppicdir,
							'uploadppicurl' => $uploadppicurl,
							'uploadppicmaxsize' => $uploadppicmaxsize,
							'ppictypes' => $ppictypes,
							'ppic_width' => $ppic_width,
							'ppic_height' => $ppic_height
							);
		
		if(!modify_registry($ppicsetchanges)){
		
			return false;
			
		}
		
		//Redirect
		redirect('act=admin&adact=users&seadact=ppicset');
		
		return true;
	
	}else{
	
		$theme['call_theme_func'] = 'ppicset_theme';
		
	}
	
}



//Function to manage Personal Picture settings
function pmset(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error;


	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$pmon = 0;//Allow PM System to be used.
	
	$notifynewpm = 0;//When user logs in Notify him about new PM or no.
	
	$pmusesmileys = 0;//Allow Smileys in PM System.
	
	$pmnumshowinfolders = 0;//The number of PM's to show in every Folder Page
	
	$pmsaveinsentitems = 0;//Save every PM in Sent Items Folder
	
	if(isset($_POST['editpmset'])){
	
		//Enable the PM ?
		if(isset($_POST['pmon'])){
			
			$pmon = 1;
			
		}
		
		//When a user logs in enable him about a new PM
		if(isset($_POST['notifynewpm'])){
			
			$notifynewpm = 1;
			
		}
		
		//Allow smileys to be used
		if(isset($_POST['pmusesmileys'])){
			
			$pmusesmileys = 1;
			
		}
		
		//Save in sent items by default
		if(isset($_POST['pmsaveinsentitems'])){
			
			$pmsaveinsentitems = 1;
			
		}
		
		
		//Check the num of PM to show in folders
		if(!(isset($_POST['pmnumshowinfolders'])) || (trim($_POST['pmnumshowinfolders']) == "")){
			
			$error[] = $l['usr_num_pm_show'];
			
		}else{
		
			$pmnumshowinfolders = (int) inputsec(htmlizer(trim($_POST['pmnumshowinfolders'])));
			
		}		
		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'pmset_theme';
			return false;		
		}
		
		
		//The array containing the PM SETTING Changes
		$pmsetchanges = array('pmon' => $pmon,
						'notifynewpm' => $notifynewpm,
						'pmusesmileys' => $pmusesmileys,
						'pmnumshowinfolders' => $pmnumshowinfolders,
						'pmsaveinsentitems' => $pmsaveinsentitems
						);
		
		if(!modify_registry($pmsetchanges)){
		
			return false;
			
		}
		
		//Redirect
		redirect('act=admin&adact=users&seadact=pmset');
		
		return true;
		
	
	}else{
	
		$theme['call_theme_func'] = 'pmset_theme';
		
	}
	
}


?>