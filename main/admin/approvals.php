<?php

//////////////////////////////////////////////////////////////
//===========================================================
// approvals.php(Admin)
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

function approvals(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;		
	
	if(!load_lang('admin/approvals')){
		
		return false;
			
	}

	//The name of the file
	$theme['init_theme'] = 'admin/approvals';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Admin Center - Manage User Approvals';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('manval_theme',
									'awapp_theme',
									'coppaapp_theme');
	
	//My activity
	$globals['last_activity'] = 'aapp';
	

	//If a second Admin act is set then go by that
	if(isset($_GET['seadact']) && trim($_GET['seadact'])!==""){
	
		$seadact = inputsec(htmlizer(trim($_GET['seadact'])));
	
	}else{
	
		$seadact = "";
		
	}
	

	//The switch handler
	switch($seadact){
	
		//The form for Managing Validating Users
		default:
		case 'manval':	
		manval();		
		break;
		
		//The form for Approving Users
		case 'awapp':	
		awapp();		
		break;
		
		//The form for COPPA Approving Users
		case 'coppaapp':	
		coppaapp();		
		break;
			
	}

}

//Function to manage validating
function manval(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $members, $error, $count;
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$members = array();
	
	$post_uid = array();
	
	//Checks the Page to see
	$page = get_page('mpg', $globals['maxmemberlist']);
	
	//Array keys to sort the list
	$sort = array(1 => 'u.id',//User ID
					2 => 'u.username',//Username
					3 => 'u.email',//Email Address
					4 => 'u.r_time'
					);
						
	$orderby = array(1 => 'ASC',
					2 => 'DESC');
	
		
	//Checks to sort the Member List by............
	if(isset($_GET['sortby']) && trim($_GET['sortby']) != "" && is_numeric(trim($_GET['sortby']))){
		
		$sortbytmp = (int) inputsec(htmlizer(trim($_GET['sortby'])));
		
		if(array_key_exists($sortbytmp, $sort)){
		
			$sortby = $sort[$sortbytmp];
			
			$sortbylink = $sortbytmp;
		
		}else{
		
			$sortby = $sort[1];
		
		}
	
	}else{
		
		$sortby = $sort[1];
		
	}	
	
	//ASCENDING or DESCENDING
	if(isset($_GET['order']) && trim($_GET['order']) != "" && is_numeric(trim($_GET['order']))){
		
		$ordertmp = (int) inputsec(htmlizer(trim($_GET['order'])));
		
		if(array_key_exists($ordertmp, $orderby)){
			
			$order = $orderby[$ordertmp];			
			
		}else{
		
			$order = $orderby[1];
		
		}
	
	}else{
		
		$order = $orderby[1];
		
	}
	
	//Get the Number of pages that can be formed
	$qresult = makequery("SELECT COUNT(*) AS pages
				FROM ".$dbtables['users']." u
				WHERE act_status = '2'");
	
	$temp = mysql_fetch_assoc($qresult);
	
	$count = $temp['pages'];
		
	//Free the resources
	@mysql_free_result($qresult);
	
	//Get out all the members who have to activate their accounts
	$qresult = makequery("SELECT u.id, u.username, u.email, u.r_time
				FROM ".$dbtables['users']." u
				WHERE act_status = '2'
				ORDER BY ".$sortby." ".$order."
				LIMIT $page, ".$globals['maxmemberlist']);
			
	if(mysql_num_rows($qresult) > 0){
	
		for($i = 0; $i < mysql_num_rows($qresult); $i++){
			
			$row = mysql_fetch_assoc($qresult);
			
			$members[$row['id']] = $row;
			
		}
	
	}
	
	//Get the member ids
	$uids = array_keys($members);
	
	
	//Are we told to do something
	if(isset($_POST['dothis'])){
		
		//What are we to do ?
		$dothis = (int) inputsec(htmlizer(trim($_POST['dothis'])));
		
		if(!in_array($dothis, array(1,2,3,4))){
			
			$error[] = $l['action_invalid'];
		
		}
		
		if(isset($_POST['uid']) && is_array($_POST['uid'])){
		
			foreach($_POST['uid'] as $k => $v){
				
				$v = trim($v);
				
				if(!empty($v)){
				
					$post_uid[] = $v;
				
				}
			
			}
			
		}
		
		//Was anything selected
		if(empty($post_uid)){
		
			$error[] = $l['not_select_members'];
		
		}		
				
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'manval_theme';
			return false;		
		}
		
		
		if(!dothis($post_uid, $dothis, 2)){
		
			return false;
		
		}
		
		//Redirect
		redirect('act=admin&adact=approvals&seadact=manval');
		
		return true;
		
		
	}else{	
	
		$theme['call_theme_func'] = 'manval_theme';
	
	}

}


//Function to manage validating
function awapp(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $members, $error, $count;
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$members = array();
	
	$post_uid = array();
	
	//Checks the Page to see
	$page = get_page('mpg', $globals['maxmemberlist']);
	
	//Array keys to sort the list
	$sort = array(1 => 'u.id',//User ID
					2 => 'u.username',//Username
					3 => 'u.email',//Email Address
					4 => 'u.r_time'
					);
						
	$orderby = array(1 => 'ASC',
					2 => 'DESC');
	
		
	//Checks to sort the Member List by............
	if(isset($_GET['sortby']) && trim($_GET['sortby']) != "" && is_numeric(trim($_GET['sortby']))){
		
		$sortbytmp = (int) inputsec(htmlizer(trim($_GET['sortby'])));
		
		if(array_key_exists($sortbytmp, $sort)){
		
			$sortby = $sort[$sortbytmp];
			
			$sortbylink = $sortbytmp;
		
		}else{
		
			$sortby = $sort[1];
		
		}
	
	}else{
		
		$sortby = $sort[1];
		
	}	
	
	//ASCENDING or DESCENDING
	if(isset($_GET['order']) && trim($_GET['order']) != "" && is_numeric(trim($_GET['order']))){
		
		$ordertmp = (int) inputsec(htmlizer(trim($_GET['order'])));
		
		if(array_key_exists($ordertmp, $orderby)){
			
			$order = $orderby[$ordertmp];			
			
		}else{
		
			$order = $orderby[1];
		
		}
	
	}else{
		
		$order = $orderby[1];
		
	}
	
	//Get the Number of pages that can be formed
	$qresult = makequery("SELECT COUNT(*) AS pages
				FROM ".$dbtables['users']." u
				WHERE act_status = '3'");
	
	$temp = mysql_fetch_assoc($qresult);
	
	$count = $temp['pages'];
		
	//Free the resources
	@mysql_free_result($qresult);
	
	//Get out all the members who have to activate their accounts
	$qresult = makequery("SELECT u.id, u.username, u.email, u.r_time
				FROM ".$dbtables['users']." u
				WHERE act_status = '3'
				ORDER BY ".$sortby." ".$order."
				LIMIT $page, ".$globals['maxmemberlist']);
			
	if(mysql_num_rows($qresult) > 0){
	
		for($i = 0; $i < mysql_num_rows($qresult); $i++){
			
			$row = mysql_fetch_assoc($qresult);
			
			$members[$row['id']] = $row;
			
		}
	
	}
	
	//Get the member ids
	$uids = array_keys($members);
	
	
	//Are we told to do something
	if(isset($_POST['dothis'])){
		
		//What are we to do ?
		$dothis = (int) inputsec(htmlizer(trim($_POST['dothis'])));
		
		if(!in_array($dothis, array(1,2,3,4))){
			
			$error[] = $l['action_invalid'];
		
		}
		
		if(isset($_POST['uid']) && is_array($_POST['uid'])){
		
			foreach($_POST['uid'] as $k => $v){
				
				$v = trim($v);
				
				if(!empty($v)){
				
					$post_uid[] = $v;
				
				}
			
			}
			
		}
		
		//Was anything selected
		if(empty($post_uid)){
		
			$error[] = $l['not_select_members'];
		
		}		
				
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'awapp_theme';
			return false;		
		}
		
		
		if(!dothis($post_uid, $dothis, 3)){
		
			return false;
		
		}
		
		//Redirect
		redirect('act=admin&adact=approvals&seadact=awapp');
		
		return true;
		
		
	}else{	
	
		$theme['call_theme_func'] = 'awapp_theme';
	
	}

}


function coppaapp(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $members, $error, $count;
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$members = array();
	
	$post_uid = array();
	
	//Checks the Page to see
	$page = get_page('mpg', $globals['maxmemberlist']);
	
	//Array keys to sort the list
	$sort = array(1 => 'u.id',//User ID
					2 => 'u.username',//Username
					3 => 'u.email',//Email Address
					4 => 'u.r_time'
					);
						
	$orderby = array(1 => 'ASC',
					2 => 'DESC');
	
		
	//Checks to sort the Member List by............
	if(isset($_GET['sortby']) && trim($_GET['sortby']) != "" && is_numeric(trim($_GET['sortby']))){
		
		$sortbytmp = (int) inputsec(htmlizer(trim($_GET['sortby'])));
		
		if(array_key_exists($sortbytmp, $sort)){
		
			$sortby = $sort[$sortbytmp];
			
			$sortbylink = $sortbytmp;
		
		}else{
		
			$sortby = $sort[1];
		
		}
	
	}else{
		
		$sortby = $sort[1];
		
	}	
	
	//ASCENDING or DESCENDING
	if(isset($_GET['order']) && trim($_GET['order']) != "" && is_numeric(trim($_GET['order']))){
		
		$ordertmp = (int) inputsec(htmlizer(trim($_GET['order'])));
		
		if(array_key_exists($ordertmp, $orderby)){
			
			$order = $orderby[$ordertmp];			
			
		}else{
		
			$order = $orderby[1];
		
		}
	
	}else{
		
		$order = $orderby[1];
		
	}
	
	//Get the Number of pages that can be formed
	$qresult = makequery("SELECT COUNT(*) AS pages
				FROM ".$dbtables['users']." u
				WHERE act_status = '4'");
	
	$temp = mysql_fetch_assoc($qresult);
	
	$count = $temp['pages'];
		
	//Free the resources
	@mysql_free_result($qresult);
	
	//Get out all the members who have to activate their accounts
	$qresult = makequery("SELECT u.id, u.username, u.email, u.r_time
				FROM ".$dbtables['users']." u
				WHERE act_status = '4'
				ORDER BY ".$sortby." ".$order."
				LIMIT $page, ".$globals['maxmemberlist']);
			
	if(mysql_num_rows($qresult) > 0){
	
		for($i = 0; $i < mysql_num_rows($qresult); $i++){
			
			$row = mysql_fetch_assoc($qresult);
			
			$members[$row['id']] = $row;
			
		}
	
	}
	
	//Get the member ids
	$uids = array_keys($members);
	
	
	//Are we told to do something
	if(isset($_POST['dothis'])){
		
		//What are we to do ?
		$dothis = (int) inputsec(htmlizer(trim($_POST['dothis'])));
		
		if(!in_array($dothis, array(1,2,3,4))){
			
			$error[] = $l['action_invalid'];
		
		}
		
		if(isset($_POST['uid']) && is_array($_POST['uid'])){
		
			foreach($_POST['uid'] as $k => $v){
				
				$v = trim($v);
				
				if(!empty($v)){
				
					$post_uid[] = $v;
				
				}
			
			}
			
		}
		
		//Was anything selected
		if(empty($post_uid)){
		
			$error[] = $l['not_select_members'];
		
		}		
				
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'coppaapp_theme';
			return false;		
		}
		
		
		if(!dothis($post_uid, $dothis, 4)){
		
			return false;
		
		}
		
		//Redirect
		redirect('act=admin&adact=approvals&seadact=coppaapp');
		
		return true;
		
		
	}else{	
	
		$theme['call_theme_func'] = 'coppaapp_theme';
	
	}

}


//This will activate the account and also send email if required or do the opposite
function dothis($uids, $do, $act_status){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

	$uids_str = implode(', ', $uids);
	
	//Get all the users out
	$qresult = makequery("SELECT u.id, u.username, u.email
				FROM ".$dbtables['users']." u
				WHERE act_status = '$act_status'
				AND u.id IN ($uids_str)");
				
	//This is the clean array we have to use
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror($l['no_members_found'], $l['no_members_id_found']);
		
		return false;
		
	}
	
	//Get them out
	for($i = 1; $i <= mysql_num_rows($qresult); $i++){
	
		$row = mysql_fetch_assoc($qresult);
		
		$users[$row['id']] = $row;
					
	}
	
	//Free the resources
	@mysql_free_result($qresult);
	
	$uid_r = array_keys($users);
	
	//The new cleaned string
	$uids_str = implode(', ', array_keys($users));
	
	
	//Are we to activate
	if($do == 1 || $do == 2){
	
		////////////////////
		// UPDATE the users
		////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['users']."
						SET act_status = '1'
						WHERE id IN ($uids_str)", false);
						
		if(mysql_affected_rows($conn) < count($users)){
				
			reporterror($l['error'], $l['errors_updating']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
	
		
		////////////////////////////
		// UPDATE the latest member
		////////////////////////////
		
		$lastkey = $uid_r[(count($uid_r)-1)];
		
		$latestuser = $users[$lastkey];
		
		//Make the QUERY
		$qresult = makequery("UPDATE ".$dbtables['registry']." 
					SET regval = '".$latestuser['username']."|".$latestuser['id']."' 
					WHERE name = 'latest_mem'");
				

		/*if(mysql_affected_rows($conn) < 1){
			
			reporterror('Activation Error' ,'Sorry, we were unable to activate your account on the Board because the connection with the Database failed.');
			
			return false;
			
		}*/
		
		
		
		////////////////////////////////
		// UPDATE The Total Member Count
		////////////////////////////////
		
		
		//Make the QUERY
		$qresult = makequery("UPDATE ".$dbtables['registry']." 
					SET regval = '".(((int)$globals['num_mem'])+count($users))."' 
					WHERE name = 'num_mem'");

		/*if(mysql_affected_rows($conn) < 1){
			
			reporterror('Activation Error' ,'Sorry, we were unable to activate your account on the Board because the connection with the Database failed. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.');
			
			return false;
			
		}*/
		
		//For the stats
		$globals['newuser'] = count($users);
		
		
		//Send an email
		if($do == 2){
			
			foreach($users as $uk => $uv){
			
			$mail[$uk]['to'] = $uv['email'];
			$mail[$uk]['subject'] = $l['subject_mail_activated'].$globals['sn'];
			$mail[$uk]['message'] = $uv['username'].$l['body_mail_activated'].$uk;

			}
			/*$mail[$uk]['headers'] = 'Reply-To: '.$globals['board_email']."\r\n".
								'X-Mailer: PHP/'.phpversion();*/
			
			//Pass all Mails to the Mail sending function
			aefmail($mail);
		
		}
	
	//We have to delete them
	}elseif($do == 3 || $do == 4){
	
		////////////////////
		// DELETE the users
		////////////////////
		
		$qresult = makequery("DELETE FROM ".$dbtables['users']."
						WHERE id IN ($uids_str)", false);
						
		if(mysql_affected_rows($conn) < count($users)){
				
			reporterror($l['error'], $l['errors_deleting']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		//Send an email
		if($do == 4){
			
			foreach($users as $uk => $uv){
			
			$mail[$uk]['to'] = $uv['email'];
			$mail[$uk]['subject'] = $l['subject_mail_account_deleted'].$globals['sn'];
			$mail[$uk]['message'] = $uv['username'].$l['body_mail_account_deleted'];

			}
			/*$mail[$uk]['headers'] = 'Reply-To: '.$globals['board_email']."\r\n".
								'X-Mailer: PHP/'.phpversion();*/
			
			//Pass all Mails to the Mail sending function
			aefmail($mail);
		
		}
	
	}
	
	
	//Looks like everything went fine
	return true;
	

}

?>
