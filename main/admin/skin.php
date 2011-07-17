<?php

//////////////////////////////////////////////////////////////
//===========================================================
// skin.php(Admin)
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


function skin(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

	if(!load_lang('admin/skin')){
		
		return false;
			
	}

	//The name of the file
	$theme['init_theme'] = 'admin/skin';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Admin Center - Board Themes';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('manskin_theme',
									'import_theme',
									'uninstall_theme',
									'settings_theme');
	
	//My activity
	$globals['last_activity'] = 'ask';
	

	//If a second Admin act is set then go by that
	if(isset($_GET['seadact']) && trim($_GET['seadact'])!==""){
	
		$seadact = inputsec(htmlizer(trim($_GET['seadact'])));
	
	}else{
	
		$seadact = "";
		
	}
	

	//The switch handler
	switch($seadact){
	
		//Manage Skins
		default:
		case 'manskin':	
		manskin();
		break;
		
		//Import a skin
		case 'import':	
		import();
		break;
		
		//Uninstall a skin
		case 'uninstall':	
		uninstall();
		break;
		
		//Edit settings of a skin
		case 'settings':	
		settings();
		break;
		
	}

}


//Function to manage skins
function manskin(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $themes;
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$themes = array();
	
	$theme_ = '';//Just the name of the FOLDER (no slashes) if user has a theme put it in this.
	
	$theme_id = 0;//The boards theme id
	
	$choose_theme = 0;//Allow users to choose theme

	
	///////////////////////////
	//Get the installed Themes
	///////////////////////////
	
	$qresult = makequery("SELECT * FROM ".$dbtables['themes']);
	
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror($l['no_themes_found'], $l['problem_boards_theme']);
		
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
	
	
	if(isset($_POST['editskin'])){
	
		//Which skin do you want?
		if(!(isset($_POST['theme_id'])) || (trim($_POST['theme_id']) == "")){
		
			$error[] = $l['no_default_theme'];
			
		}else{
		
			$theme_id = (int) inputsec(htmlizer(trim($_POST['theme_id'])));
			
			if(!in_array($theme_id, $themeids)){
			
				$error[] = $l['theme_invalid'];
			
			}
			
			//Whats the folder name
			$theme_ = $themes[$theme_id]['th_folder'];
			
		}
		
		//can users choose their theme
		if(isset($_POST['choose_theme'])){
			
			$choose_theme = 1;
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'manskin_theme';
			return false;		
		}
		
		
		//The array containing the SKIN SETTING Changes
		$manskin = array('theme' => $theme_,
						'theme_id' => $theme_id,						
						'choose_theme' => $choose_theme,
						);
		
		if(!modify_registry($manskin, 0)){
		
			return false;
			
		}
		
		//Redirect
		redirect('act=admin&adact=skin&seadact=manskin');
		
		return true;
		
	}elseif(isset($_POST['resetpaths'])){
	
		//Whats the path ?
		if(!(isset($_POST['path'])) || (trim($_POST['path']) == "")){
		
			$error[] = $l['no_path'];
			
		}else{
		
			$path = inputsec(htmlizer(trim($_POST['path'])));
				
			$path = rtrim($path, '\\/');
			
		}
		
		
		//Whats the URL ?
		if(!(isset($_POST['url'])) || (trim($_POST['url']) == "")){
		
			$error[] = $l['no_url'];
			
		}else{
		
			$url = inputsec(htmlizer(trim($_POST['url'])));
				
			$url = rtrim($url, '\\/');
			
		}
		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'manskin_theme';
			return false;		
		}
		
		
		//Bring out only the Board theme registry and not users
		$qresult = makequery("SELECT * FROM ".$dbtables['theme_registry']."
							WHERE uid = 0");
		
		$thregistry = array();
		
		for($i = 1; $i <= mysql_num_rows($qresult); $i++){
			
			$row = mysql_fetch_assoc($qresult);
			
			$thregistry[$row['thid']] = aefunserialize($row['theme_registry']);
		
		}
			
		//Did something even comeout
		if(empty($thregistry)){
		
			$error[] = $l['no_url'];
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'manskin_theme';
			return false;		
		}
		
		
		//r_print($thregistry);
		
		//Lets start building the new base Path and URL
		foreach($thregistry as $k => $v){
		
			$thregistry[$k]['path'] = $path.'/'.basename($thregistry[$k]['path']);
			
			$thregistry[$k]['url'] = $url.'/'.basename($thregistry[$k]['url']);
			
			//Serialize
			$serialized_registry = serialize($thregistry[$k]);
		
			if(empty($serialized_registry)){
			
				$error[] = $l['errors_resetting'];
				
				//on error call the form
				if(!empty($error)){
					$theme['call_theme_func'] = 'manskin_theme';
					return false;		
				}
			
			}else{
			
				//////////////////////////////
				// REPLACE the Theme Registry
				//////////////////////////////
				
				$qresult = makequery("REPLACE INTO ".$dbtables['theme_registry']."
								SET theme_registry = '$serialized_registry',
								thid = '".$k."',
								uid = 0");
								
			}
			
			unset($serialized_registry);
		
		}
		
		//r_print($thregistry);
		
		//Redirect
		redirect('act=admin&adact=skin&seadact=manskin');
		
		return true;
	
	}else{
	
		$theme['call_theme_func'] = 'manskin_theme';
		
	}


}//End of function


//Function to install skins
function import(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error;
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$th_path = '';
	
	$registry = '';
	
	$importtype = 0;
	
	$weburl = '';
	
	$filepath = '';
	
	$compressedfile = '';//compressed file of a theme (zip, tgz, tbz2, tar)
		
	if(isset($_POST['importskin'])){
	
		//r_print($_POST);
		//r_print($_FILES);
		
		if(empty($_POST['importtype']) || !in_array($_POST['importtype'], array(1,2,3,4))){
		
			$error[] = $l['no_action'];
		
		}else{
		
			$importtype = inputsec(htmlizer(trim($_POST['importtype'])));
		
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'import_theme';
			return false;		
		}
		
		if($importtype == 1){
		
			//Which folder is it?
			if(!(isset($_POST['folderpath'])) || (trim($_POST['folderpath']) == "")){
			
				$error[] = $l['no_folder'];
				
			}else{
			
				$th_path = inputsec(htmlizer(trim($_POST['folderpath'])));
				
				$th_path = rtrim($th_path, '\\/');
							
			}
			
			//on error call the form
			if(!empty($error)){
				$theme['call_theme_func'] = 'import_theme';
				return false;		
			}
		
		//From a web file
		}elseif($importtype == 2){
			
			//Whats the URL ?
			if(!(isset($_POST['weburl'])) || (trim($_POST['weburl']) == "")){
			
				$error[] = $l['no_url_compressed'];
				
			}else{
			
				$weburl = inputsec(htmlizer(trim($_POST['weburl'])));
			
				//Check its a Valid Link atleast
				if (!preg_match('/^(http|https|ftp):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(:(\d+))?\//i', $weburl)) {
				
					$error[] = $l['url_invalid'];
				
				}else{
					
					$compressedfile = $globals['themesdir'].'/'.basename($weburl);
					
					if(!get_web_file($weburl, $compressedfile)){
				
						$error[] = $l['errors_installing'];
				
					}
				
				}
							
			}
			
			//on error call the form
			if(!empty($error)){
				$theme['call_theme_func'] = 'import_theme';
				return false;		
			}
				
		//From a file on the server
		}elseif($importtype == 3){
		
			//Which folder is it?
			if(!(isset($_POST['filepath'])) || (trim($_POST['filepath']) == "")){
			
				$error[] = $l['no_local path'];
				
			}else{
			
				$filepath = inputsec(htmlizer(trim($_POST['filepath'])));
				
				$compressedfile = $filepath;
							
			}
			
			//on error call the form
			if(!empty($error)){
				$theme['call_theme_func'] = 'import_theme';
				return false;		
			}
		
		//From a file on the computer
		}elseif($importtype == 4){
		
			if(empty($_FILES['uploadtheme']['tmp_name']) &&
			   empty($_FILES['uploadtheme']['name']) &&
			   empty($_FILES['uploadtheme']['size']))
			{
			
				$error[] = $l['no_theme_file_given'];
			
			}else{
			
				$tempfile = $_FILES['uploadtheme']['tmp_name'];
				
				$filename = $globals['themesdir'].'/'.$_FILES['uploadtheme']['name'];
				
				//Lets move the Theme File
				if(!(@move_uploaded_file($tempfile, $filename))){
				
					$error[] = $l['errors_uploading'];
				
				}
			
			}
			
			//on error call the form
			if(!empty($error)){
				$theme['call_theme_func'] = 'import_theme';
				return false;		
			}
			
			$compressedfile = $filename;
		
		}
		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'import_theme';
			return false;		
		}
		
		
		//Are we to decompress first
		if(!empty($compressedfile)){
		
			if(!decompress($compressedfile, $globals['themesdir'], 0)){
			
				$error[] = $l['no_decompress'];
			
			}else{
				
				$temp = pathinfo($compressedfile);
				
				//Since it decompressed it means the extension, basename is there
				$temp['filename'] = aefsubstr($temp['basename'], 0, aefstrlen($temp['basename'])-aefstrlen($temp['extension'])-1);
				
				//The name of the ZIP file should be the same as the name of the folder
				$th_path = aefaddslashes($globals['themesdir']).'/'.$temp['filename'];
			
			}
		
		}
		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'import_theme';
			return false;		
		}
		
		if(empty($th_path)){
		
			$error[] = $l['illegal_errors'];
		
		}
		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'import_theme';
			return false;		
		}
		
		
		//Alright so everything is fine
		$registry = checktheme($th_path);
		
		if(empty($registry)){
		
			$error[] = $l['errors_in_registry'];
		
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'import_theme';
			return false;		
		}
		
		
		$serialized_registry = serialize($registry);
		
		////////////////////
		// INSERT the Theme
		////////////////////
		
		$qresult = makequery("INSERT INTO ".$dbtables['themes']."
						SET th_name = '".$registry['name']."'");

		
		$thid = mysql_insert_id($conn);
				
		if( empty($thid) ){
			
			reporterror($l['install_error'], $l['install_error_exp']);
			
			return false;
			
		}
		
		
		///////////////////////////////
		// INSERT the Theme's Registry
		///////////////////////////////
		
		$qresult = makequery("INSERT INTO ".$dbtables['theme_registry']."
						SET thid = '".$thid."',
						uid = 0,
						theme_registry = '$serialized_registry'");
						
		if(mysql_affected_rows($conn) < 1){
			
			reporterror($l['install_error'], $l['install_error_exp']);
			
			return false;
			
		}
		
		
		//Redirect
		redirect('act=admin&adact=skin&seadact=settings&theme_id='.$thid);
		
		return true;
	
	}else{
	
		$theme['call_theme_func'] = 'import_theme';
		
	}

	
}


//Function to uninstall skins
function uninstall(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $themes;
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$themes = array();
	
	$theme_ = '';//Just the name of the FOLDER (no slashes) if user has a theme put it in this.
	
	$theme_id = 0;//The boards theme id

	
	///////////////////////////
	//Get the installed Themes
	///////////////////////////
	
	$qresult = makequery("SELECT * FROM ".$dbtables['themes']);
	
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror($l['no_themes_found'], $l['problem_boards_theme']);
		
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
	
	
	if(isset($_POST['uninstallskin'])){
	
		//Which skin do you want to uninstall?
		if(!(isset($_POST['theme_id'])) || (trim($_POST['theme_id']) == "")){
		
			$error[] = $l['no_uninstalled_subm'];
			
		}else{
		
			$theme_id = (int) inputsec(htmlizer(trim($_POST['theme_id'])));
			
			if(!in_array($theme_id, $themeids)){
			
				$error[] = $l['no_uninstalled_exist'];
			
			}
			
			//Not the default
			if($theme_id == 1){
			
				$error[] = $l['no_default_uninstall'];
			
			}
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'uninstall_theme';
			return false;		
		}
		
		///////////////////
		// DELETE the theme
		///////////////////
	
		$qresult = makequery("DELETE FROM ".$dbtables['themes']." 
					WHERE thid = '$theme_id'", false);
					
		/////////////////////////////
		// DELETE the theme_registry
		/////////////////////////////
	
		$qresult = makequery("DELETE FROM ".$dbtables['theme_registry']." 
					WHERE thid = '$theme_id'", false);
		
		
		////////////////////
		// UPDATE the users
		////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['users']."
						SET user_theme = '0'
						WHERE user_theme = '$theme_id'", false);		
		
		
		//Redirect
		redirect('act=admin&adact=skin&seadact=uninstall');
		
		return true;
		
	}else{
	
		$theme['call_theme_func'] = 'uninstall_theme';
		
	}


}//End of function


//Function to edit a skins settings
function settings(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $theme_registry, $themes;
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$themes = array();
	
	$theme_registry = array();
	
	$registry = array();
	
	$name = '';
	
	
	///////////////////////////
	//Get the installed Themes
	///////////////////////////
	
	$qresult = makequery("SELECT thid, th_name, th_folder FROM ".$dbtables['themes']);
	
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror($l['no_themes_found'], $l['problem_boards_theme']);
		
		return false;
		
	}
	
	//The loop to draw out the rows
	for($i=1; $i <= mysql_num_rows($qresult); $i++){
		
		$row = mysql_fetch_assoc($qresult);
		
		$themes[$row['thid']] = $row;
						
	}
	
	//Free the resources
	@mysql_free_result($qresult);
	
	
	//Checks the theme_id is set or no
	if(empty($_GET['theme_id']) || trim($_GET['theme_id']) == "" || !is_numeric(trim($_GET['theme_id']))){
	
		//Show a major error and return
		reporterror($l['no_theme_specified'], $l['no_theme_specified_exp']);
			
		return false;
	
	}else{
	
		$thid = (int) inputsec(htmlizer(trim($_GET['theme_id'])));
	
	}	
	
	$theme_registry = theme_registry($thid);
	
	//r_print($theme_registry);
	
	//Is theme registry proper
	if(empty($theme_registry)){
	
		//Show a major error and return
		reporterror($l['error_theme'], $l['error_theme_exp']);
			
		return false;
	
	}
	
	$name = (empty($theme_registry['general']['name']['value']) ? '' : $theme_registry['general']['name']['value']);
		
	if(isset($_POST['editsettings'])){
	
		//r_print($_POST);
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
		
		
		//UPDATE The name if not changed/empty
		if(!empty($registry['name'])){
		
			$qresult = makequery("UPDATE ".$dbtables['themes']."
						SET th_name = '".$registry['name']."'
						WHERE thid = '$thid'");
		
		//There must be a name
		}else{
		
			$registry['name'] = (empty($name) ? 'Unknown' : $name);
		
		}
		
		
		$serialized_registry = serialize($registry);
		
		//////////////////////////////
		// REPLACE the Theme Registry
		//////////////////////////////
		
		$qresult = makequery("REPLACE INTO ".$dbtables['theme_registry']."
						SET theme_registry = '$serialized_registry',
						thid = '$thid',
						uid = 0");
		
		//Redirect
		redirect('act=admin&adact=skin&seadact=manskin');
		
		return true;
	
	}else{
	
		$theme['call_theme_func'] = 'settings_theme';
	
	}

}

//Just checks the name by incluing the theme_settings.php
function checktheme($path){

global $globals;
	
	$registry = array();
	
	//Set the path
	$registry['path'] = $path;
	
	//Also the URL
	$registry['url'] = str_replace(addslashes($globals['server_url']), addslashes($globals['url']), $path);	
	
	//Registry File Path
	$regitryfile = $path.'/theme_registry.php';
	
	//Check the file exists
	if(!(file_exists($regitryfile) && is_file($regitryfile) && @filetype($regitryfile) == "file")){
	 
		return false;
		
	}else{
		
		@include_once($regitryfile);// The theme_registry.php file
		
	}
	 
	//Make a array of only the values
	foreach($theme['registry'] as $rk => $rv){
	
		foreach($theme['registry'][$rk] as $k => $v){
			
			$registry[$k] = $theme['registry'][$rk][$k]['value'];
		
		}
	
	}
	
	//The name is compulsory
	if(empty($registry['name'])){
	
		return false;
	
	}
	
	return $registry;
	
}


?>