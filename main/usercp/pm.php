<?php

//////////////////////////////////////////////////////////////
//===========================================================
// pm.php(usercp)
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


if(!load_lang('usercp/pm')){
    
    return false;
        
}


//////////////////////////////////////
// Things to still do with PM System :
// 1) Send Email Notifications
//////////////////////////////////////

/////////////////////////////////////////
// The PM Folder ID's are as follows:
// 0 - Inbox
// 1 - Sent Items
// 2 - Outbox / Drafts
/////////////////////////////////////////



//The name of the file
$theme['init_theme'] = 'usercp/pm';

//The name of the Page
$theme['init_theme_name'] = $l['pm_cpuser_pm'];

//Array of functions to initialize
$theme['init_theme_func'] = array('inbox_theme',
								'sentitems_theme',
								'drafts_theme',
								'writepm_theme',
								'sendsaved_theme',
								'searchpm_theme',
								'trackpm_theme',
								'showpm_theme',
								'prunepm_theme',
								'emptyfolders_theme');


//////////////////////////////////////////////
// This function will show Your Inbox Folder
//////////////////////////////////////////////

function inbox(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $inbox, $foldercount, $tree;
	
	//Check whether the PM system is allowed
	checkpmon();	
	
	//Count the Number of PM's in a Folder
	countpm();
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$pmids = array();//The Fianl PM ID's Array
	
	$pmidarray = array();
	
	$inbox = array();//The array holding the PM's in the Inbox
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=inbox',
					'txt' => $l['pm_messages']);
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=inbox',
					'txt' => $l['pm_inbox']);
	
	//If the user has asked to delete some PM's
	if(isset($_POST['deleteselinbox'])){	
		
		//The User might have not selected any PM's
		if(empty($_POST['list'])){
		
			//Redirect
			redirect('act=usercp&ucpact=inbox');
		
		}
		
		$pmidarray = $_POST['list'];
		
		foreach($pmidarray as $pmk => $pmv){
			
			//It must be Numeric
			if(is_numeric($pmv)){
			
				$pmids[] = $pmv;
			
			}
		
		}
		
		//Finally call the Function to Delete the PM's
		deletepm($pmids, 0);
	
	}
	
	//Check the PM Page
	$page = get_page('pmfpg', $globals['pmnumshowinfolders']);
		
	
	//Get the PM in the Inbox of this user.
	$qresult = makequery("SELECT pm.*, u.username AS sender
			FROM ".$dbtables['pm']." pm 
			LEFT JOIN ".$dbtables['users']." u ON (pm.pm_from = u.id)
			WHERE pm.pm_to = '".$user['id']."'
			AND pm_folder = '0'
			ORDER BY pm.pmid DESC
			LIMIT $page, ".$globals['pmnumshowinfolders']);
			
	if(mysql_num_rows($qresult) < 1){
		
		//If it is not the first page - then you specified an invalid link
		if($page > 0){
	
			//Show a major error and return
			reporterror($l['pm_no page found'] ,$l['pm_no_page_found_exp1']);
				
			return false;
			
		}
	
	}else{	
	
		for($i = 1; $i <= mysql_num_rows($qresult); $i++){
		
			$inbox[$i] = mysql_fetch_assoc($qresult);
		
		}
		
	}

}//End of function



//////////////////////////////////////////////
// This function will show Sent Items Folder
//////////////////////////////////////////////

function sentitems(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $sentitems, $foldercount, $tree;
	
	//Check whether the PM system is allowed
	checkpmon();	
	
	//Count the Number of PM's in a Folder
	countpm();
	

	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$pmids = array();//The Fianl PM ID's Array
	
	$pmidarray = array();
	
	$sentitems = array();//The array holding the sentitems
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=inbox',
					'txt' => $l['pm_messages']);
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=sentitems',
					'txt' => $l['pm_sent_items']);
					
	//If the user has asked to delete some PM's
	if(isset($_POST['deleteselsent'])){

		//The User might have not selected any PM's
		if(empty($_POST['list'])){
		
			//Redirect
			redirect('act=usercp&ucpact=sentitems');
		
		}
		
		$pmidarray = $_POST['list'];
		
		foreach($pmidarray as $pmk => $pmv){
			
			//It must be Numeric
			if(is_numeric($pmv)){
			
				$pmids[] = $pmv;
			
			}
		
		}
		
		//Finally call the Function to Delete the PM's
		deletepm($pmids, 1);		
	
	}
	
	//Check the PM Page
	$page = get_page('pmfpg', $globals['pmnumshowinfolders']);
	
		
	//Get the PM in the sentitems of this user.
	$qresult = makequery("SELECT pm.*, u.username AS reciever
			FROM ".$dbtables['pm']." pm 
			LEFT JOIN ".$dbtables['users']." u ON (pm.pm_to = u.id)
			WHERE pm.pm_from = '".$user['id']."'
			AND pm_folder = '1'
			ORDER BY pm.pmid DESC
			LIMIT $page, ".$globals['pmnumshowinfolders']);
	
	if(mysql_num_rows($qresult) < 1){
		
		//If it is not the first page - then you specified an invalid link
		if($page > 0){
	
			//Show a major error and return
			reporterror($l['pm_no page found'] ,$l['pm_no_page_found_exp2']);
				
			return false;
			
		}
	
	}else{	
	
		for($i = 1; $i <= mysql_num_rows($qresult); $i++){
		
			$sentitems[$i] = mysql_fetch_assoc($qresult);
		
		}
		
	}
		

}//End of function


//////////////////////////////////////////////
// This function will show Your Drafts Folder
//////////////////////////////////////////////

function drafts(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $drafts, $foldercount, $tree;
	
	//Check whether the PM system is allowed
	checkpmon();	
	
	//Count the Number of PM's in a Folder
	countpm();
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$pmids = array();//The Fianl PM ID's Array
	
	$pmidarray = array();
	
	$drafts = array();//The array holding the Drafts
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=inbox',
					'txt' => $l['pm_messages']);
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=drafts',
					'txt' => $l['pm_drafts']);
	
	//If the user has asked to delete some PM's
	if(isset($_POST['deleteseldrafts'])){
		
		//The User might have not selected any PM's
		if(empty($_POST['list'])){
		
			//Redirect
			redirect('act=usercp&ucpact=drafts');
		
		}
		
		$pmidarray = $_POST['list'];
		
		foreach($pmidarray as $pmk => $pmv){
			
			//It must be Numeric
			if(is_numeric($pmv)){
			
				$pmids[] = $pmv;
			
			}
		
		}
		
		//Finally call the Function to Delete the PM's
		deletepm($pmids, 2);
		
	
	}
	
	
	//Check the PM Page
	$page = get_page('pmfpg', $globals['pmnumshowinfolders']);
	
	//Get the PM in the drafts of this user.
	$qresult = makequery("SELECT pm.*
			FROM ".$dbtables['pm']." pm 
			WHERE pm.pm_from = '".$user['id']."'
			AND pm_folder = '2'
			ORDER BY pm.pmid DESC
			LIMIT $page, ".$globals['pmnumshowinfolders']);
	
	if(mysql_num_rows($qresult) < 1){
		
		//If it is not the first page - then you specified an invalid link
		if($page > 0){
	
			//Show a major error and return
			reporterror($l['pm_no page found'] ,$l['pm_no_page_found_exp2']);
				
			return false;
			
		}
	
	}else{	
	
		for($i = 1; $i <= mysql_num_rows($qresult); $i++){
		
			$drafts[$i] = mysql_fetch_assoc($qresult);
		
			$rec = explode('||||', $drafts[$i]['pm_to_text']);
			
			//The Usernames of the recivers
			$drafts[$i]['rec_usernames'] = explode(";", $rec[0]);
			
			//The ID's of the recivers
			$drafts[$i]['rec_id'] = explode(";", $rec[1]);
		
		}
		
	}
	
}//End of function



//////////////////////////////////////////////
// This will show PM's that are being tracked
//////////////////////////////////////////////

function trackpm(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $read, $unread, $tree;

	//Check whether the PM system is allowed
	checkpmon();
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
		
	$read = array();// Array Holding read PM's	
	
	$unread = array();// Array Holding unread PM's
	
	$pmids = array();//The Fianl PM ID's Array
	
	$pmidarray = array();
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=inbox',
					'txt' => $l['pm_messages']);
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=trackpm',
					'txt' => $l['pm_track_pm']);
	
	//If the user has asked to Stop Tracking the read
	if(isset($_POST['stoptrackread'])){
	
		//The User might have not selected any PM's
		if(empty($_POST['list'])){
			
			//Redirect
			redirect('act=usercp&ucpact=trackpm');
		
		}
		
		$pmidarray = $_POST['list'];
		
	}elseif(isset($_POST['stoptrackunread'])){
	
		//The User might have not selected any PM's
		if(empty($_POST['listu'])){
		
			redirect('act=usercp&ucpact=trackpm');
		
		}
		
		$pmidarray = $_POST['listu'];
	
	}
	
	
	if(!empty($pmidarray)){	
	
		foreach($pmidarray as $pmk => $pmv){
				
			//It must be Numeric
			if(is_numeric($pmv)){
				
				$pmids[] = $pmv;
				
			}
			
		}			
				
			
		//Final VAR holding IN Values
		$var = implode(',', $pmids);	
			
		//Make the QUERY
		$qresult = makequery("UPDATE ".$dbtables['pm']." 
					SET pm_track = '0' 
					WHERE pmid IN ($var)
					AND pm_folder = '0'
					AND pm_from = '".$user['id']."'", false);
		
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['pm_tracking_error'] ,$l['pm_tracking_error_exp']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		
		//Redirect
		redirect('act=usercp&ucpact=trackpm');
	
	}
	
	//Get the PM that is Read by reciever first.
	$qresult = makequery("SELECT pm.pmid, pm.pm_to, pm_subject, pm.pm_time, pm.pm_read_time, 
			u.username AS reciever
			FROM ".$dbtables['pm']." pm 
			LEFT JOIN ".$dbtables['users']." u ON (pm.pm_to = u.id)
			WHERE pm.pm_from = '".$user['id']."'
			AND pm.pm_folder = '0'
			AND pm.pm_track = '1'
			AND pm.pm_read_time != '0'
			ORDER BY pm.pm_read_time DESC");
		
	if(mysql_num_rows($qresult) > 0){
			
		for($i = 1; $i <= mysql_num_rows($qresult); $i++){
		
			$read[$i] = mysql_fetch_assoc($qresult);
			
			$read[$i]['pm_read_time'] = datify($read[$i]['pm_read_time']);
		
		}
			
	}
	
	//Free the resources
	@mysql_free_result($qresult);
		
	//Get the PM that is Unread by reciever first.
	$qresult = makequery("SELECT pm.pmid, pm.pm_to, pm_subject, pm.pm_time, pm.pm_read_time, 
			u.username AS reciever
			FROM ".$dbtables['pm']." pm 
			LEFT JOIN ".$dbtables['users']." u ON (pm.pm_to = u.id)
			WHERE pm.pm_from = '".$user['id']."'
			AND pm.pm_folder = '0'
			AND pm.pm_track = '1'
			AND pm.pm_read_time = '0'
			ORDER BY pm.pmid ASC");

	if(mysql_num_rows($qresult) > 0){
			
		//The for loop to draw out the PM's
		for($i = 1; $i <= mysql_num_rows($qresult); $i++){
		
			$unread[$i] = mysql_fetch_assoc($qresult);		
			
			$unread[$i]['pm_time'] = datify($unread[$i]['pm_time']);
		
		}
			
	}
	
}//End of function


//////////////////////////////////////
// This function will take care to Send new PM's.
// It will either send it or save it in the Drafts.
//////////////////////////////////////

function writepm(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $smileys, $emoticons, $popup_emoticons, $postcodefield, $error, $reply, $pmto, $tree;

	//Check whether the PM system is allowed
	checkpmon();
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$reply = array();
	
	$replypm = 0;
	
	$pmrecipients = '';
	
	$recipients = array();
	
	$rec_username = array();
	
	$error = array();
	
	$pmsubject = '';
	
	$trackpm = 0;
			
	$pmsaveinsentitems = 0;
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=inbox',
					'txt' => $l['pm_messages']);
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=writepm',
					'txt' => $l['pm_compose']);
			
	/* If someone is Replying Query the QUOTE */
	
	/////////////////////////////
	// GET Var Name - 'reply=pmid'
	/////////////////////////////
	
	//Get the PM ID
	if(isset($_GET['reply']) && trim($_GET['reply'])!==""){
		
		$replypm = (int) inputsec(htmlizer(trim($_GET['reply'])));
		
	}elseif(isset($_GET['to']) && trim($_GET['to'])!==""){
	
		$pmto = (int) inputsec(htmlizer(trim($_GET['to'])));
	
	}
	
	
	if(!empty($replypm)){
	
		//Get the PM the user has requested to Reply.
		$qresult = makequery("SELECT pm.*, u.id, u.username AS sender
				FROM ".$dbtables['pm']." pm 
				LEFT JOIN ".$dbtables['users']." u ON (pm.pm_from = u.id) 
				WHERE pm.pm_to = '".$user['id']."' 
				AND pmid = '$replypm'
				AND pm_folder = '0'");
		
		if(mysql_num_rows($qresult) < 1){
			
			reporterror($l['pm_reply_error'] ,$l['pm_reply_error_exp']);
			
			return false;
		
		}
			
		//The array holding the PM
		$reply = mysql_fetch_assoc($qresult);
		
		//Free the resources
		@mysql_free_result($qresult);	
			
	}elseif(!empty($pmto)){
	
		//Get the PM the user has requested to Reply.
		$qresult = makequery("SELECT u.username
				FROM ".$dbtables['users']." u
				WHERE u.id = '$pmto'");
		
		if(mysql_num_rows($qresult) > 0){
			
			//The array holding the PM to guy
			$row = mysql_fetch_assoc($qresult);
			
			$pmto = $row['username'];
		
		}
		
		//Free the resources
		@mysql_free_result($qresult);
	
	}
	
	///////////////////////////////////////
	// Create a 16 bit random code for POST
	// DATA REFRESH Problem to be solved.
	///////////////////////////////////////
	
	if(empty($AEF_SESS['postcode']) || !is_array($AEF_SESS['postcode'])){
	
		$AEF_SESS['postcode'] = array();
	
	}
	
	$postcodefield = '<input type="hidden" value="'.generateRandStr(16).'" name="postcode" />';
	
	
	//Are we to use smileys ?
	if($globals['pmusesmileys']){
	
		if(!getsmileys()){
		
			return false;
		
		}
	
	}
	
	if(isset($_POST['pmsubject'])){
		
		//Is postcode posted
		if(!(isset($_POST['postcode'])) || strlen(trim($_POST['postcode'])) < 16){
		
			$error[] = $l['pm_sec_conf_code_no_posted'];
			
		}else{
		
			$postedcode = inputsec(strtolower(htmlizer(trim($_POST['postcode']))));
			
			//////////////////////////////////
			// This is a very important thing
			// to check for automated registrations
			//////////////////////////////////	
			
			if(in_array($postedcode, $AEF_SESS['postcode'])){
			
				$error[] = $l['pm_sec_conf_code_no_match'];
			
			}
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'writepm_theme';
			return false;		
		}
		
		
		//Check if the Recipients field exists.
		if(!(isset($_POST['pmrecipients'])) || trim($_POST['pmrecipients']) == ""){
		
			$error[] = $l['pm_no_specify_recipients'];
			
		}else{
		
			$pmrecipients = inputsec(htmlizer(trim($_POST['pmrecipients'])));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'writepm_theme';
			return false;		
		}
		
		
		//Check if the Subject field exists.
		if(!(isset($_POST['pmsubject'])) || trim($_POST['pmsubject']) == ""){
		
			$error[] = $l['pm_subjet_empty'];
			
		}else{
		
			$pmsubject = inputsec(htmlizer(trim($_POST['pmsubject'])));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'writepm_theme';
			return false;
		}
		
		
		//Check the PM Message itself
		if(!(isset($_POST['pmbody'])) || trim($_POST['pmbody']) == ""){
		
			$error[] = $l['pm_message_empty'];
			
		}else{
			
			//No trimming for the smileys
			$pmbody = inputsec(htmlizer($_POST['pmbody']));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'writepm_theme';
			return false;		
		}
		
		
		/* Check Recipients */
		
		$recipients = check_recipients($pmrecipients);		
		
		if(!empty($error)){
		
			return false;
		
		}
		
		foreach($recipients as $rk => $rv){
		
			$rec_username[] = $recipients[$rk]['username'];
			
			$rec_id[] = $recipients[$rk]['id'];
		
		}
		
		/* Ending - Check Recipients */
		
		
		//The user has selected to send the PM
		if(isset($_POST['sendpm'])){
		
		
			/* Check Additional Options */
			
			///////////////////////////////////
			// Check the following Additional Options : 
			// 1) Track the PM
			// 2) Save a copy in 'Sent Items' Folder
			///////////////////////////////////
			
			//The Track System
			if(isset($_POST['trackpm'])){
			
				$trackpm = 1;
			
			}
			
			
			//The Save a copy in 'Sent Items' Folder
			if(isset($_POST['pmsaveinsentitems'])){
				
				
				///////////////////////////////////////
				//Lets check that do we have sufficient
				// space to save in Sent Items
				///////////////////////////////////////
				
				//Check only if it is LIMITED i.e. not zero
				if($user['max_stored_pm']){
				
					//If I am sending to my self also
					if(in_array($user['username'], $rec_username)){
					
						$req_space = (1 + count($rec_username));
					
					//I am not sending to myself
					}else{
					
						$req_space = count($rec_username);
					
					}//End of IF...ELSEIF in_array
					
					
					//Check the availibility of the required space
					$is_sufficeint = (( ($user['max_stored_pm'] - $user['pm']) >= $req_space ) ? 1 : 0 ) ;
					
					//echo 'Required Space : '.$req_space.'<br />
					//Is Sufficient : '.$is_sufficeint;
					
					if(!$is_sufficeint){
					
						$error[] = $l['pm_no_space_sentitems'];
					
					}
					
					//on error call the form
					if(!empty($error)){
						$theme['call_theme_func'] = 'writepm_theme';
						return false;		
					}
					
					
				}//End of if($user['max_stored_pm'])
				
				
				$pmsaveinsentitems = 1;
			
			}
			
			
			/* Ending - Check Additional Options */
		
		
			/////////////////////////////
			// Finally lets send the PM
			// Use the sendpm function
			/////////////////////////////
			
			foreach($recipients as $rk => $rv){
			
				sendpm($rv['id'], $pmsubject, $pmbody, $trackpm, $pmsaveinsentitems);
			
			}
		
			
		//The user wants to SAVE it
		}elseif(isset($_POST['savepm'])){
		
			////////////////////////
			// INSERT the PM first
			////////////////////////
			
			$time = time();
			
			$temp_rec = implode(";", $rec_username);
			
			$temp_rec_id = implode(";", $rec_id);
			
			//Make the QUERY
			$qresult = makequery("INSERT INTO ".$dbtables['pm']." 
					SET pm_from = '".$user['id']."', 
					pm_time = '$time', pm_subject = '$pmsubject', 
					pm_body = '$pmbody', pm_folder = '2',
					pm_to_text = '$temp_rec||||$temp_rec_id'");
			
			
			$pmid = mysql_insert_id($conn);
				
			if( empty($pmid) ){
				
				reporterror($l['pm_pm_error'] ,$l['pm_pm_error_exp1']);
				
				return false;
				
			}
				
			//Free the resources
			@mysql_free_result($qresult);
			
			////////////////////////////////
			// UPDATE The Senders PM count
			////////////////////////////////
			
			//Make the QUERY
			$qresult = makequery("UPDATE ".$dbtables['users']." 
					SET pm = pm + 1 
					WHERE id = '".$user['id']."'", false);
			
			if(mysql_affected_rows($conn) < 1){
					
				reporterror($l['pm_pm_error'] ,$l['pm_pm_error_exp2']);
				
				return false;
				
			}
			
			//Free the resources
			@mysql_free_result($qresult);
		
		}//End of IF...ELSEIF Save/Send PM
		
		//Store that this code was successful
		$AEF_SESS['postcode'][] = $postedcode;
			
		// Redirecting you to your Inbox
		redirect('act=usercp&ucpact=inbox');
		
		return true;
	
	}else{
	
		//Show the form
		$theme['call_theme_func'] = 'writepm_theme';
	
	}

}



//////////////////////////////////////
// This function will take care to Send Saved PM's.
// It will either send it or Update it in the Drafts.
//////////////////////////////////////
function sendsaved(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $smileys, $emoticons, $popup_emoticons, $postcodefield, $error, $draft, $tree;

	//Check whether the PM system is allowed
	checkpmon();
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$draft = array();
	
	$pmid = 0;
	
	$pmrecipients = '';
	
	$recipients = array();
	
	$rec_username = array();
	
	$error = array();
	
	$pmsubject = '';
	
	$trackpm = 0;
			
	$pmsaveinsentitems = 0;
	
	
	//Get the PM ID
	if(isset($_GET['pmid']) && trim($_GET['pmid'])!==""){
		
		$pmid = (int) inputsec(htmlizer(trim($_GET['pmid'])));

	}else{
	
		//Show a major error and return
		reporterror($l['pm_no_draft_specified'] ,$l['pm_no_draft_exp']);
			
		return false;
		
	}
	
	
	//Get the PM in the drafts of this user.
	$qresult = makequery("SELECT pm.*
			FROM ".$dbtables['pm']." pm 
			WHERE pm.pm_from = '".$user['id']."'
			AND pm.pm_folder = '2'
			AND pm.pmid = '$pmid'");
	
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror($l['pm_draft_no_found'] ,$l['pm_draft_no_found_exp']);
		
		return false;
	
	}
	
	//The array holding the PM
	$draft =  mysql_fetch_assoc($qresult);
			
	//Usernames of Recivers
	$temp_rec_text = explode('||||', $draft['pm_to_text']);
	
	$draft['rec_usernames'] = $temp_rec_text[0];
	
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=inbox',
					'txt' => 'Messages');	
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=sendsaved&pmid='.$draft['pmid'],
					'txt' => 'Sending Drafts');
	
	///////////////////////////////////////
	// Create a 16 bit random code for POST
	// DATA REFRESH Problem to be solved.
	///////////////////////////////////////
	
	//Old one to be used for processing
	$postcode = (isset($AEF_SESS['sspmpostcode']) ? $AEF_SESS['sspmpostcode'] : '');
	
	//Now create a new one
	$AEF_SESS['sspmpostcode'] = generateRandStr(16);
	
	$postcodefield = '<input type="hidden" value="'.$AEF_SESS['sspmpostcode'].'" name="postcode" />';
	
	
	//Are we to use smileys ?
	if($globals['pmusesmileys']){
	
		if(!getsmileys()){
		
			return false;
		
		}
	
	}
	
	
	if(isset($_POST['pmsubject'])){
		
		
		//Is postcode posted
		if(!(isset($_POST['postcode'])) || strlen(trim($_POST['postcode'])) < 16){
		
			$error[] = $l['pm_sec_conf_code_no_posted'];
			
		}else{
		
			$postedcode = inputsec(strtolower(htmlizer(trim($_POST['postcode']))));
			
			//////////////////////////////////
			// This is a very important thing
			// to check for refresh
			//////////////////////////////////	
			
			if(in_array($postedcode, $AEF_SESS['postcode'])){
			
				$error[] = $l['pm_sec_conf_code_no_match'];
			
			}
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'sendsaved_theme';
			return false;		
		}
		
		
		//Check if the Recipients field exists.
		if(!(isset($_POST['pmrecipients'])) || trim($_POST['pmrecipients']) == ""){
		
			$error[] = $l['pm_no_specify_recipients'];
			
		}else{
		
			$pmrecipients = inputsec(htmlizer(trim($_POST['pmrecipients'])));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'sendsaved_theme';
			return false;		
		}
		
		
		//Check if the Subject field exists.
		if(!(isset($_POST['pmsubject'])) || trim($_POST['pmsubject']) == ""){
		
			$error[] = $l['pm_subjet_empty'];
			
		}else{
		
			$pmsubject = inputsec(htmlizer(trim($_POST['pmsubject'])));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'sendsaved_theme';
			return false;		
		}
		
		
		
		//Check the PM Message itself
		if(!(isset($_POST['pmbody'])) || trim($_POST['pmbody']) == ""){
		
			$error[] = $l['pm_message_empty'];
			
		}else{
			
			//No trimming for the smileys
			$pmbody = inputsec(htmlizer($_POST['pmbody']));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'sendsaved_theme';
			return false;		
		}
		
		
		/* Check Recipients */
		
		$recipients = check_recipients($pmrecipients, 'sendsaved_theme');
		
		if(!empty($error)){
		
			return false;
		
		}
	
		foreach($recipients as $rk => $rv){
		
			$rec_username[] = $recipients[$rk]['username'];
			
			$rec_id[] = $recipients[$rk]['id'];
		
		}
		
		/* Ending - Check Recipients */
		
		
		//The user has selected to send the PM
		if(isset($_POST['sendpm'])){
		
			
			/* Check Additional Options */
			
			///////////////////////////////////
			// Check the following Additional Options : 
			// 1) Track the PM
			// 2) Save a copy in 'Sent Items' Folder
			///////////////////////////////////
			
			//The Track System
			if(isset($_POST['trackpm'])){
			
				$trackpm = 1;
			
			}
				
			//The Save a copy in 'Sent Items' Folder
			if(isset($_POST['pmsaveinsentitems'])){
				
				
				/////////////////////////////////////////
				// Lets check that do we have sufficient
				// space to save in Sent Items
				/////////////////////////////////////////
				
				//Check only if it is LIMITED i.e. not zero
				if($user['max_stored_pm']){
				
					//If I am sending to my self also
					if(in_array($user['username'], $rec_username)){
						
						//OLD - $req_space = (1 + count($rec_username));
						//This time we have a PM already as saved
						//First Delete that and Insert new
						//Thats why we dont count it
						$req_space = count($rec_username);
					
					//I am not sending to myself
					}else{
					
						$req_space = count($rec_username);
					
					}//End of IF...ELSEIF in_array
					
					
					//Check the availibility of the required space
					$is_sufficeint = (( ($user['max_stored_pm'] - $user['pm']) >= $req_space ) ? 1 : 0 ) ;
					
					//echo 'Required Space : '.$req_space.'<br />
					//Is Sufficient : '.$is_sufficeint;
										
					if(!$is_sufficeint){
					
						$error[] = $l['pm_no_space_sentitems'];
					
					}
					
					
					//on error call the form
					if(!empty($error)){
						$theme['call_theme_func'] = 'sendsaved_theme';
						return false;		
					}
					
					
				}//End of if($user['max_stored_pm'])
								
				$pmsaveinsentitems = 1;
			
			}
			
			
			/* Ending - Check Additional Options */
		
		
			/////////////////////////////
			// Finally lets send the PM
			// Use the sendpm function
			/////////////////////////////
			
			foreach($recipients as $rk => $rv){
			
				sendpm($rv['id'], $pmsubject, $pmbody, $trackpm, $pmsaveinsentitems);
			
			}
			
			
			////////////////////////////////
			// Delete the Saved PM in Drafts
			////////////////////////////////
			
			//Make the QUERY
			$qresult = makequery("DELETE FROM ".$dbtables['pm']." 
					WHERE pm.pm_from = '".$user['id']."'
					AND pm.pmid = '$pmid'", false);
			
			if(mysql_affected_rows($conn) < 1){
				
				reporterror($l['pm_delete_error'] ,$l['pm_delete_error_exp']);
			
				return false;
				
			}
			
			
			//Free the resources
			@mysql_free_result($qresult);
			
			
			////////////////////////////////
			// UPDATE the Users PM Count
			////////////////////////////////
			
			//Make the QUERY
			$qresult = makequery("UPDATE ".$dbtables['users']." 
					SET pm = pm - 1 
					WHERE id = '".$user['id']."'", false);
			
			if(mysql_affected_rows($conn) < 1){
				
				reporterror($l['pm_delete_error'] ,$l['pm_delete_error_exp']);
			
				return false;
				
			}
							
			//Free the resources
			@mysql_free_result($qresult);
			
			
		//The user wants to SAVE it
		}elseif(isset($_POST['savepm'])){
		
			////////////////////////
			// UPDATE the PM first
			////////////////////////
			
			$time = time();
			
			$temp_rec = implode(";", $rec_username);
			
			$temp_rec_id = implode(";", $rec_id);
			
			//Make the QUERY
			$qresult = makequery("UPDATE ".$dbtables['pm']." 
					SET pm_time = '$time', pm_subject = '$pmsubject', 
					pm_body = '$pmbody', pm_folder = '2',
					pm_to_text = '$temp_rec||||$temp_rec_id'
					WHERE pmid = '$pmid'
					AND pm_from = '".$user['id']."'", false);
			
			if(mysql_affected_rows($conn) < 1){
				
				reporterror($l['pm_saving_error'] ,$l['pm_saving_error_exp']);
			
				return false;
				
			}
							
			//Free the resources
			@mysql_free_result($qresult);

		
		}//End of IF...ELSEIF Save/Send PM
		
		//Store that this code was successful
		$AEF_SESS['postcode'][] = $postedcode;
					
		/////////////////////////////////
		// Redirecting you to your Drafts
		/////////////////////////////////
			
		// Redirecting you to your Inbox
		redirect('act=usercp&ucpact=drafts');
		
		return true;
	
	}else{
	
		//Show the form
		$theme['call_theme_func'] = 'sendsaved_theme';
	
	}

}



///////////////////////////////////
// Check the Recipients of the PM.
// It does the following : 
// 1) Checks all the usernames
// 2) If error calls form and Exits
// 3) Returns array if everthing is fine
///////////////////////////////////

function check_recipients($posted_recievers, $callfunc = 'writepm_theme'){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error;

	$recievers_t = explode(";", $posted_recievers);
	
	/*echo 'Temp Recievers:<br /><pre>';
	print_r($recievers_t);
	echo '</pre>';*/
	
	$recievers = array();
	
	//Just for cleaning
	foreach($recievers_t as $rk => $rv){
			
		//If the Reciever is not null or if the reciever has been added already
		if(!(trim($recievers_t[$rk]) == "")){
		
			$recievers[] = trim($recievers_t[$rk]);
		
		}
	
	}
	
	$recievers = array_unique($recievers);
	
	/*echo '<pre>';
	print_r($recievers);
	echo '</pre>';*/
	
	
	if(empty($recievers)){
	
		$error[] = $l['pm_no_recipents_specified'];
	
	}
	
	//on error call the form
	if(!empty($error)){
		$theme['call_theme_func'] = $callfunc;
		return false;		
	}
	
	
	//A loop to make the OR statement
	foreach($recievers as $rk => $rv){
	
		$or[] = "username='$rv'";
	
	}
	
	$final = implode(" OR ", $or);

	
	$qresult = makequery("SELECT u.id, u.username, u.pm, u.unread_pm, p.max_stored_pm 
			FROM ".$dbtables['users']." u, ".$dbtables['permissions']." p
			WHERE ($final) AND p.member_group_id = u.u_member_group");
	
	if(mysql_num_rows($qresult) < 1){
		
		//There was no result
		$error[] = ''.$l['pm_the_recipents'].''.(implode(",", $recievers)).''.$l['pm_specified_no_exist'].'';
		
	}
	
	//on error call the form
	if(!empty($error)){
		$theme['call_theme_func'] = $callfunc;
		return false;		
	}
	
	
	//Array Holding the Results Queried
	$recipients = array();
	$rec_username = array();
	
	for($i = 0; $i < mysql_num_rows($qresult); $i++){
	
		$recipients[$i] = mysql_fetch_assoc($qresult);
		
		$rec_username[] = $recipients[$i]['username'];
	
	}
	/*echo '<pre>';
	print_r($recipients);
	echo '</pre>';*/
	
	/*echo '<pre>';
	print_r($rec_username);
	echo '</pre>';*/
	
	//Check the number of users that have come out.
	//Ok so they are not equal
	//if(count($recievers) != count($recipients)){
		
	//Array holding Usernames not found
	$not_there = array();
		
	//Check which user wasnt there.
	foreach($recievers as $rk => $rv){
	
		//Check the newly built username array
		if(!(in_array($rv, $rec_username))){
			
			$not_there[] = $rv;
			
		}//End of if(!(in_array($rv, $rec_username)))
		
	}//End of FOREACH Loop
		
	if(!empty($not_there)){
		
		$error[] = $l['pm_the_recipents'].(implode(",", $not_there)).$l['pm_specified_no_exist'];
	
	}
		
	//on error call the form
	if(!empty($error)){
		$theme['call_theme_func'] = $callfunc;
		return false;		
	}
	
	//}//End of if(count($recievers) != count($recipients))
	
	
	/* Check each recipent has sufficient space or no */
	
	///////////////////////////////////////
	// We also have to check the recipients
	// have sufficient space or not.
	///////////////////////////////////////
	
	//An array to hold the Usernames whose PM Inbox is full
	$pm_full = array();
	
	foreach($recipients as $rk => $rv){
		
		//////////////////////////////////
		// We have to check the user MAX
		// allowed PM if it is Not zero as
		// Zero means NO Limit of PM's
		//////////////////////////////////
		
		//IF it is TRUE i.e. NOT 0(ZERO)
		if($rv['max_stored_pm']){
		
			if($rv['pm'] >= $rv['max_stored_pm']){
			
				$pm_full[] = $rv['username'];
			
			}//End of if($rv['pm'] >= $rv['max_stored_pm'])
		
		}//End of if($rv['max_stored_pm'])
	
	}//End of FOREACH Loop
	
	
	if(!empty($pm_full)){
		
		$error[] = $l['pm_the_recipent'].(implode(",", $pm_full)).$l['pm_no_space_recieve_new'];
	
	}
	
	//on error call the form
	if(!empty($error)){
		$theme['call_theme_func'] = $callfunc;
		return false;		
	}
	
	/* Ending - Check each recipent has sufficient space or no */
	
	
	////////////////////////////////////
	// Finally all checking done .
	// So return the recipients array .
	////////////////////////////////////
	
	return $recipients;

}//End of function


////////////////////////////////////////////////
// This function will show Your PM in the Inbox
// Parameters :
// 1) The folder num - To determine pm_from OR
//    pm_to in the query
////////////////////////////////////////////////

function showpm($folder = 0){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $pm, $user_group, $post_group, $smileycode, $smileyimages, $tree;
	
	//Check whether the PM system is allowed
	checkpmon();
	
	
	//Get the PM ID
	if(isset($_GET['pmid']) && trim($_GET['pmid'])!==""){
		
		$pmid = (int) inputsec(htmlizer(trim($_GET['pmid'])));

	}else{
	
		//Show a major error and return
		reporterror($l['pm_no_pm_specified'] ,$l['pm_no_pm_specified_exp']);
			
		return false;
		
	}
	
	
	////////////////////////////////////////
	// When a user wants to see a PM check:
	// 1) The PM belongs to him
	////////////////////////////////////////
	
	//Get the PM the user has requested to see.
	$qresult = makequery("SELECT pm.*, ug.mem_gr_name, ug.image_name, ug.image_count, u.id, 
			u.username AS sender, u.email, u.posts, u.u_member_group,u.users_text,
			u.sig, u.avatar, u.avatar_type, u.avatar_width, u.avatar_height, u.location,
			u.www , u.timezone , u.icq , u.aim , u.yim , u.msn , u.email , u.hideemail,
			s.uid AS status
			FROM ".$dbtables['pm']." pm 
			LEFT JOIN ".$dbtables['users']." u ON (pm.pm_from = u.id) 
			LEFT JOIN ".$dbtables['user_groups']." ug ON (ug.member_group = u.u_member_group)
			LEFT JOIN ".$dbtables['sessions']." s ON (pm.pm_from = s.uid)
			WHERE ".(($folder) ? "pm.pm_from" : "pm.pm_to")." = '".$user['id']."' 
			AND pmid='$pmid'");
	
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror($l['pm_no_pm_found'] ,$l['pm_no_pm_found_exp']);
		
		return false;
		 	
	}
	
	//The array holding the PM
	$pm = mysql_fetch_assoc($qresult);
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=inbox',
					'txt' => $l['pm_messages']);
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=showpm&pmid='.$pm['pmid'],
					'txt' => $pm['pm_subject'],
					'prefix' => $l['pm_viewing_pm']);
	
	/*echo '<pre>';
	print_r($pm);
	echo '</pre>';*/
	//Bring the Member Group
	if(!membergroups()){
	
		return false;
	
	}	
	
	//First Flip the array
	$post_group = array_reverse($post_group);	
	
	$showsmileys = ($logged_in ? ( $user['showsmileys'] == 1 ? true : ($user['showsmileys'] == 2 ? false : $globals['pmusesmileys']) ) : $globals['pmusesmileys']);
	
	//Are sigs to be shown
	$showsigs = ($logged_in ? ( $user['showsigs'] == 1 ? true : ($user['showsigs'] == 2 ? false : $globals['attachsigtopost']) ) : $globals['attachsigtopost']);
	
	//Are avatars to be shown
	$showavatars = ($logged_in ? ( $user['showavatars'] == 1 ? true : ($user['showavatars'] == 2 ? false : $globals['showavatars']) ) : $globals['showavatars']);
	
	//Are we to use smileys ?
	if($globals['pmusesmileys'] && $showsmileys){
	
		if(!getsmileys()){
		
			return false;
		
		}
	
	}
	
	/* Which Post Group Do you Belong ? */
		
	foreach($post_group as $pgrk => $pgr){
		
		if($pm['posts'] >= $pgr['post_count']){
			
			$pm['post_gr_name'] = $pgr['mem_gr_name'];
			break;
			
		}
		
	}
		
	/* Ending - Which Post Group Do you Belong ? */
	
	
	//Convert the PM time
	$pm['pm_time'] = datify($pm['pm_time']);
	
	$pm['pm_body'] = format_text($pm['pm_body']);
	
	//Links and all
	$pm['pm_body'] = parse_special_bbc($pm['pm_body']);
	
	//Add the brakes
	$pm['pm_body'] = parse_br($pm['pm_body']);
	
	//If user wants to see sig
	if($globals['enablesig'] && $showsigs){
	
		$pm['sig'] = parse_special_bbc($pm['sig']);	
		
		$pm['sig'] = format_text($pm['sig']);
		
		$pm['sig'] = parse_br($pm['sig']);
		
		//What about smileys in sigs
		if($globals['pmusesmileys'] && $showsmileys){
		
			$pm['sig'] = smileyfy($pm['sig']);
		
		}		
	
	}else{
	
		unset($pm['sig']);
	
	}
	
	
	// Smileys are so cheerfull
	if($globals['pmusesmileys'] && $showsmileys){		
				
		$pm['pm_body'] = smileyfy($pm['pm_body']);
		
	}
	
		
	//Is avatars allowed globally
	if(!empty($pm['avatar']) && $globals['showavatars'] && $showavatars){
	
		$avatar = array('avatar' => $pm['avatar'],
					'avatar_type' => $pm['avatar_type'],
					'avatar_width' => $pm['avatar_width'],
					'avatar_height' => $pm['avatar_height']
					);
					
		$pm['avatarurl'] = urlifyavatar(100, $avatar);
	
	}
	
	
	if($pm['hideemail'] == 1){
		
		$pm['email'] = '';
	
	}	
	

	//So is it globally allowed to hide
	if($globals['memhideemail'] && $pm['hideemail'] == 1 && !$user['can_admin']){
	
		$pm['email'] = '';		

	}
	
	
	////////////////////////////////////////
	// We also have to UPDATE the Read Time
	// Also Negate New PM in the User A/C
	// This is Only in the Inbox Folder
	////////////////////////////////////////
	
	//Only in the Inbox
	if(!$folder && !$pm['pm_read_time']){
				
		/////////////////////////////
		// UPDATE the PM Read Time
		/////////////////////////////
		
		//The present Time
		$time = time();
		
		//Make the QUERY
		$qresult = makequery("UPDATE ".$dbtables['pm']." 
				SET pm_read_time = '$time' 
				WHERE pmid = '$pmid'
				AND pm_to = '".$user['id']."'", false);
		
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['pm_update_error'] ,$l['pm_viewing_pm_exp1']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
				
		
		////////////////////////////////////////
		// UPDATE Users New PM Count if not read
		////////////////////////////////////////
		
		
		//Make the QUERY
		$qresult = makequery("UPDATE ".$dbtables['users']." 
				SET unread_pm = unread_pm - 1 
				WHERE id = '".$user['id']."'", false);
			
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['pm_update_error'] ,$l['pm_viewing_pm_exp2']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
				
	
	}//End of if($folder == 0)
	

}//End of function


function searchpm(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $pms, $tree;
	
	//Check whether the PM system is allowed
	checkpmon();
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
		
	$search = array('/%/', '/_/', '/\s/');//Array of things that should be replaced for search	
	
	$replace = array('\\%', '\_', '%');//Array of things that replaces
	
	$pms = array();//Array of returned pm's
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=inbox',
					'txt' => $l['pm_messages']);
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=searchpm',
					'txt' => $l['pm_search']);
	
	if(isset($_POST['searchpm'])){
	
		//Get the folder
		if(isset($_POST['folder']) && trim($_POST['folder'])!==""){
			
			$folder = (int) inputsec(htmlizer(trim($_POST['folder'])));
			
			$validfol = array(0, 1, 2);
		
			if(!in_array($folder, $validfol)){
			
				$error[] = $l['pm_folder_search_invalid'];
			
			}
	
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'searchpm_theme';
			return false;
		}
		
		
		//From whom is it (Only Inbox)
		if(isset($_POST['from']) && trim($_POST['from'])!==""){
			
			$from = inputsec(htmlizer(trim($_POST['from'])));
	
		}
		
		
		//To who is it (For Sentitems and Drafts)
		if(isset($_POST['to']) && trim($_POST['to'])!==""){
			
			$to = inputsec(htmlizer(trim($_POST['to'])));
	
		}
		
		
		//The Subject
		if(isset($_POST['subject']) && trim($_POST['subject'])!==""){
			
			$subject = inputsec(htmlizer(trim($_POST['subject'])));
			
			//Replace spaces and special characters
			$subject = preg_replace($search, $replace, $subject);
	
		}
		
		
		//The Words for the body
		if(isset($_POST['hasthewords']) && trim($_POST['hasthewords'])!==""){
			
			$hasthewords = inputsec(htmlizer(trim($_POST['hasthewords'])));
			
			//Replace spaces and special characters
			$hasthewords = preg_replace($search, $replace, $hasthewords);
	
		}
		
		
		//The Words that should not be in the body
		if(isset($_POST['doesnthave']) && trim($_POST['doesnthave'])!==""){
			
			$doesnthave = inputsec(htmlizer(trim($_POST['doesnthave'])));
			
			//Replace spaces and special characters
			$doesnthave = preg_replace($search, $replace, $doesnthave);
	
		}
		
		
		//Has something even be set to find
		if(empty($subject) && empty($hasthewords) && empty($doesnthave) && empty($from) && empty($to)){
		
			$error[] = $l['pm_no_anything_search'];
		
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'searchpm_theme';
			return false;
		}
		
		
		//Search the inbox
		if($folder == 0){
		
			//Get the PM in the from the folder
			$qresult = makequery("SELECT pm.*, f.id, f.username AS sender
					FROM ".$dbtables['pm']." pm 
					LEFT JOIN ".$dbtables['users']." f ON (pm.pm_from = f.id)
					WHERE pm.pm_to = '".$user['id']."'
					AND pm_folder = '0'
					".(empty($subject) ? '' : "AND pm_subject LIKE '%".$subject."%'")."
					".(empty($hasthewords) ? '' : "AND pm_body LIKE '%".$hasthewords."%'")."
					".(empty($doesnthave) ? '' : "AND pm_body NOT LIKE '%".$doesnthave."%'")."
					".(empty($from) ? '' : "AND f.username = '$from'")."
					ORDER BY pm.pmid DESC");
		
		//Search the sent items
		}elseif($folder == 1){
		
			//Get the PM in the sentitems of this user.
			$qresult = makequery("SELECT pm.*, t.id, t.username AS receiver
					FROM ".$dbtables['pm']." pm 
					LEFT JOIN ".$dbtables['users']." t ON (pm.pm_to = t.id)
					WHERE pm.pm_from = '".$user['id']."'
					AND pm_folder = '1'
					".(empty($subject) ? '' : "AND pm_subject LIKE '%".$subject."%'")."
					".(empty($hasthewords) ? '' : "AND pm_body LIKE '%".$hasthewords."%'")."
					".(empty($doesnthave) ? '' : "AND pm_body NOT LIKE '%".$doesnthave."%'")."
					".(empty($to) ? '' : "AND t.username = '$to'")."
					ORDER BY pm.pmid DESC");
		
		//Search the drafts
		}elseif($folder == 2){
		
			//Get the PM in the drafts of this user.
			$qresult = makequery("SELECT pm.*
					FROM ".$dbtables['pm']." pm 
					WHERE pm.pm_from = '".$user['id']."'
					AND pm_folder = '2'
					".(empty($subject) ? '' : "AND pm_subject LIKE '%".$subject."%'")."
					".(empty($hasthewords) ? '' : "AND pm_body LIKE '%".$hasthewords."%'")."
					".(empty($doesnthave) ? '' : "AND pm_body NOT LIKE '%".$doesnthave."%'")."
					".(empty($to) ? '' : "AND pm.pm_to_text LIKE '%".$to."%'")."
					ORDER BY pm.pmid DESC");
		
		}
		
		
		if(mysql_num_rows($qresult) > 0){
		
			for($i = 1; $i <= mysql_num_rows($qresult); $i++){
		
				$row = mysql_fetch_assoc($qresult);
				
				$row['pm_time'] = datify($row['pm_time']);
				
				$pms[$row['pmid']] = $row;
				
				//One extra case
				if($folder == 2){
				
					$rec = explode('||||', $row['pm_to_text']);
			
					//The Usernames of the recivers
					$pms[$row['pmid']]['rec_usernames'] = explode(";", $rec[0]);
					
					//The ID's of the recivers
					$pms[$row['pmid']]['rec_id'] = explode(";", $rec[1]);
				
				}
										
			}		
		
		}else{
		
			$error[] = $l['pm_no_pm_found'];
			
			$theme['call_theme_func'] = 'searchpm_theme';
			
			return false;
		
		}
		
		/*echo '<pre>';
		print_r($pms);
		echo '</pre>';*/
		
		//Free the resources
		@mysql_free_result($qresult);
		
		$theme['call_theme_func'] = 'searchpm_theme';
		
		return true;		
		
	}else{
	
		$theme['call_theme_func'] = 'searchpm_theme';
	
	}
	

}


//////////////////////////////////////////////
// This function will Prune PM's in a Folder
//////////////////////////////////////////////

function prunepm(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $foldercount, $tree;
	
	
	//Check whether the PM system is allowed
	checkpmon();	
	
	//Count the Number of PM's in a Folder
	countpm();
		
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$prunefolder = 0;
	
	$prunedays = 0;
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=inbox',
					'txt' => $l['pm_messages']);
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=prunepm',
					'txt' => $l['pm_prune']);
	
	if(isset($_POST['prunesubmit'])){
		
		//Get the number of days
		if(isset($_POST['prunedays']) && trim($_POST['prunedays'])!==""){
			
			$prunedays = (int) inputsec(htmlizer(trim($_POST['prunedays'])));
	
		}else{
		
			$error[] = $l['pm_no_num_days'];
			
		}
		
		
		//Get the folder id
		if(isset($_POST['prunefolder']) && trim($_POST['prunefolder'])!==""){
			
			$prunefolder = (int) inputsec(htmlizer(trim($_POST['prunefolder'])));
	
		}else{
		
			$error[] = $l['pm_no_prune_folder_specified'];
			
		}
		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'prunepm_theme';
			return false;
		}
			
		
		//////////////////////////////////////
		// Check that the Folder Num is right
		//////////////////////////////////////
		
		$validfol = array(0, 1, 2, 3);
		
		if(!in_array($prunefolder, $validfol)){
		
			$error[] = $l['pm_prune_folder_invalid'];
		
		}
		
		
		//////////////////////////////////////
		// Check that Num of days is positive
		//////////////////////////////////////
		
		if(0 >= $prunedays){
		
			$error[] = $l['pm_num_days_negative'];
		
		}
		
		
		//On error call the form and die.
		if(!empty($error)){
			$theme['call_theme_func'] = 'prunepm_theme';
			return false;
		}
		
		
		//Calculate the time
		$time = (time() - (60*60*24*$prunedays));
		//echo 'Time:'.(time()).'<br /> Calc Time : '.$time;die();
		
		
		///////////////////////////////////////////
		// Different Folders Different Requirements
		// 1) Inbox - pm_to
		// 2) Sent - pm_to and pm_from
		// 3) Drafts - pm_to == 0 and pm_from = user
		///////////////////////////////////////////
		
		//Inbox
		if($prunefolder == 0){
		
			//Delete them
			$qresult = makequery("DELETE FROM ".$dbtables['pm']." 
					WHERE pm_to = '".$user['id']."'
					AND pm_folder = '0'
					AND pm_time < $time", false);
			
			/*if(mysql_affected_rows($conn) < 1){
				
				reporterror('Prune Error' ,'There were some errors in Prunning the Personal Messages in the Inbox Folder. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.');
				
				return false;
				
			}*/
			
			//Affected Rows
			$affectedrows = mysql_affected_rows($conn); 
		
			//Free the resources
			@mysql_free_result($qresult);
					
			//Redirect to which folder
			$redirect = 'inbox';		
						
		//Sent Items
		}elseif($prunefolder == 1){
		
			//Delete them
			$qresult = makequery("DELETE FROM ".$dbtables['pm']." 
					WHERE pm_from = '".$user['id']."'
					AND pm_folder = '1'
					AND pm_time < $time", false);
			
			/*if(mysql_affected_rows($conn) < 1){
				
				reporterror('Prune Error' ,'There were some errors in Prunning the Personal Messages in the Sent Items Folder. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.');
				
				return false;
				
			}*/
			
			//Affected Rows
			$affectedrows = mysql_affected_rows($conn);
		
			//Free the resources
			@mysql_free_result($qresult);
						
			//Redirect to which folder
			$redirect = 'sentitems';
				
		//Drafts
		}elseif($prunefolder == 2){
				
			//Delete them
			$qresult = makequery("DELETE FROM ".$dbtables['pm']." 
					WHERE pm_from = '".$user['id']."'
					AND pm_folder = '2'
					AND pm_time < $time", false);
			
			/*if(mysql_affected_rows($conn) < 1){
				
				reporterror('Prune Error' ,'There were some errors in Prunning the Personal Messages in the Drafts Folder. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.');
				
				return false;
				
			}*/
			
			//Affected Rows
			$affectedrows = mysql_affected_rows($conn);
		
			//Free the resources
			@mysql_free_result($qresult);
			
			//Redirect to which folder
			$redirect = 'drafts';
		
		//All Folders
		}elseif($prunefolder == 3){			
			
			//Set the Num Rows Affected
			$affectedrows = 0; 
			
			$makequery = array();
			
			//Inbox
			$makequery[0] = array("DELETE FROM ".$dbtables['pm']." 
							WHERE pm_to = '".$user['id']."'
							AND pm_folder = '0'
							AND pm_time < $time", $l['pm_no_prune_inbox']);
			
			//Sent Items
			$makequery[1] = array("DELETE FROM ".$dbtables['pm']." 
							WHERE pm_from = '".$user['id']."'
							AND pm_folder = '1'
							AND pm_time < $time", $l['pm_no_prune_sentitems']);
							
			//Drafts
			$makequery[2] = array("DELETE FROM ".$dbtables['pm']." 
							WHERE pm_from = '".$user['id']."'
							AND pm_folder = '2'
							AND pm_time < $time", $l['pm_no_prune_drafts']);
							
			
			//The Loop
			for($i = 0; $i <= 2; $i++){
			
				//Delete them
				$qresult = makequery($makequery[$i][0], false);
												
				//Affected Rows
				$affectedrows = $affectedrows + mysql_affected_rows($conn); 
								
			}//End of loop
			
			//echo $affectedrows;
			
			//Redirect to which folder
			$redirect = 'inbox';
		
		}//End of IF...ELSEIF
		
		
		/////////////////////////////
		// UPDATE the users PM Count
		/////////////////////////////
		
		//Make the QUERY
		$qresult = makequery("UPDATE ".$dbtables['users']." 
				SET pm = pm - $affectedrows 
				WHERE id = '".$user['id']."'", false);
			
		//Redirect
		redirect("act=usercp&ucpact=$redirect");
		
	}else{
		
		//Show the Form
		$theme['call_theme_func'] = 'prunepm_theme';
	
	}
	
	
}//End of function


////////////////////////////////////
// This function will Empty Folders
////////////////////////////////////

function emptyfolders(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $foldercount, $tree;
	
	
	//Check whether the PM system is allowed
	checkpmon();	
	
	//Count the Number of PM's in a Folder
	countpm();
		
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();	
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=inbox',
					'txt' => $l['pm_messages']);
	
	$tree[] = array('l' => $globals['index_url'].'act=usercp&ucpact=emptyfolders',
					'txt' => $l['pm_empty_folders']);
		
	if(isset($_POST['emptyfoldersubmit'])){
		
		//Has any Folder been selected
		if( !isset($_POST['emptyinbox']) && 
			!isset($_POST['emptysentitems']) && 
			!isset($_POST['emptydrafts']) ) {
		
			$error[] = $l['pm_no_folder_selected'];
		
		}
		
		
		//On error call the form and die.
		if(!empty($error)){
			$theme['call_theme_func'] = 'emptyfolders_theme';
			return false;		
		}
		
		
		///////////////////////////////////////////
		// Different Folders Different Requirements
		// 1) Inbox - pm_to
		// 2) Sent - pm_to and pm_from
		// 3) Drafts - pm_to == 0 and pm_from = user
		///////////////////////////////////////////
			
			
		//Set the Num Rows Affected
		$affectedrows = 0; 
		
		$makequery = array();
		
		//Inbox
		$makequery[0] = array("DELETE FROM ".$dbtables['pm']." 
						WHERE pm_to = '".$user['id']."'
						AND pm_folder = '0'", $l['pm_no_empty_inbox'], 0);
		
		//Sent Items
		$makequery[1] = array("DELETE FROM ".$dbtables['pm']." 
						WHERE pm_from = '".$user['id']."'
						AND pm_folder = '1'", $l['pm_no_empty_sentitems'], 0);
						
		//Drafts
		$makequery[2] = array("DELETE FROM ".$dbtables['pm']." 
						WHERE pm_from = '".$user['id']."'
						AND pm_folder = '2'", $l['pm_no_empty_drafts'], 0);
						
		
		//Empty the Inbox
		if(isset($_POST['emptyinbox'])){
		
			$makequery[0][2] = 1;
		
		}
		
		
		//Empty the Sent Items
		if(isset($_POST['emptysentitems'])){
		
			$makequery[1][2] = 1;
		
		}
		
		
		//Empty the Drafts
		if(isset($_POST['emptydrafts'])){
		
			$makequery[2][2] = 1;
		
		}		
		
		
		//The Loop
		for($i = 0; $i <= 2; $i++){
		
			//Query only if it is to be emptied
			if($makequery[$i][2]){
		
				//Make the QUERY
				$qresult = makequery($makequery[$i][0], false);
			
				//No need to error check that it affected
				// any rows as there may be no PM deleted	
				
				//Affected Rows
				$affectedrows = $affectedrows + mysql_affected_rows($conn);
			
			}//End of if($makequery[$i][2])
			
		
		}//End of loop		
		//echo $affectedrows;	
			
				
		/////////////////////////////
		// UPDATE the users PM Count
		/////////////////////////////
		
		if($affectedrows >= 1){
		
			//Make the QUERY
			$qresult = makequery("UPDATE ".$dbtables['users']." 
					SET pm = pm - $affectedrows 
					WHERE id = '".$user['id']."'", false);
					
			if(mysql_affected_rows($conn) < 1){
				
				reporterror($l['pm_empty_folder_error'] ,$l['pm_deleting_error_exp2']);
				
				return false;
				
			}
			
			//Free the resources
			@mysql_free_result($qresult);	
		
		}
		
		//Redirect
		redirect("act=usercp&ucpact=inbox");
		
	}else{
		
		//Show the Form
		$theme['call_theme_func'] = 'emptyfolders_theme';
	
	}
	
	
}//End of function


////////////////////////////////////
// This function will deletes a PM
// A single Delete Call
////////////////////////////////////

function delpm(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
	
	//Check whether the PM system is allowed
	checkpmon();
	
	
	//GET the PM ID
	if(isset($_GET['pm']) && trim($_GET['pm'])!==""){
	
		$pm = (int) inputsec(htmlizer(trim($_GET['pm'])));
		
		$pmid = array($pm);
		
	}else{
	
		//Show a major error and return
		reporterror($l['pm_no_pm_specified'] ,$l['pm_no_pm_specified_exp']);
			
		return false;
		
	}
	
	
	//Get the Folder ID
	if(isset($_GET['folder']) && trim($_GET['folder'])!==""){
	
		$folder = (int) inputsec(htmlizer(trim($_GET['folder'])));
		
	}else{
	
		//Show a major error and return
		reporterror($l['pm_no_folder_specified'] ,$l['pm_no_pm_specified_exp']);
			
		return false;
		
	}	
	
	//Call the function that Deletes the PM
	deletepm($pmid, $folder);
	
	
}//End of function


////////////////////////////////////
// This function will delete PM's
// Parameters:
// 1) Array of PM ID's to delete
// 2) Folder Number
////////////////////////////////////

function deletepm($pmidarray, $pmfolder){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
		
	///////////////////////////////////////////
	// Different Folders Different Requirements
	// 1) Inbox - pm_to
	// 2) Sent - pm_to and pm_from
	// 3) Drafts - pm_to == 0 and pm_from = user
	///////////////////////////////////////////
	
		
	//Set the Num Rows Affected
	$affectedrows = 0;
		
	$makequery = array();
	
	$pmids = implode(', ', $pmidarray);
	
	
	//Inbox
	$makequery[0] = array("DELETE FROM ".$dbtables['pm']." 
					WHERE pm_to = '".$user['id']."'
					AND pm_folder = '0'
					AND pmid IN ($pmids)", $l['pm_no_delete_inbox'], 0);
	
	//Sent Items
	$makequery[1] = array("DELETE FROM ".$dbtables['pm']." 
					WHERE pm_from = '".$user['id']."'
					AND pm_folder = '1'
				AND pmid IN ($pmids)", $l['pm_no_delete_sentitems'], 0);
					
	//Drafts
	$makequery[2] = array("DELETE FROM ".$dbtables['pm']." 
					WHERE pm_from = '".$user['id']."'
					AND pm_folder = '2'
					AND pmid IN ($pmids)", $l['pm_no_delete_drafts'], 0);
						
	
	//Empty the Inbox
	if($pmfolder == 0){
	
		$makequery[0][2] = 1;
		
		$redirect = 'inbox';
	
	}
	
	
	//Empty the Sent Items
	if($pmfolder == 1){
	
		$makequery[1][2] = 1;
		
		$redirect = 'sentitems';
	
	}
	
	
	//Empty the Drafts
	if($pmfolder == 2){
	
		$makequery[2][2] = 1;
		
		$redirect = 'drafts';
	
	}
	
	
	//The $pmids might be empty which gives an error in MySQL
	
	if(empty($pmids)){
	
		//Redirect
		redirect("act=usercp&ucpact=$redirect");
	
	}
	
	
	//The Loop
	for($i = 0; $i <= 2; $i++){
		
		//Query only if it is to be emptied
		if($makequery[$i][2]){
	
			//Make the QUERY
			$qresult = makequery($makequery[$i][0], false);
							
			if(mysql_affected_rows($conn) < 1){
					
				reporterror($l['pm_deleting_error'] ,$l['pm_deleting_error_exp1']);
				
				return false;
				
			}
			
			//Affected Rows
			$affectedrows = $affectedrows + mysql_affected_rows($conn);
						
			//Free the resources
			@mysql_free_result($qresult);			
		
		}//End of if($makequery[$i][2])
		
	
	}//End of loop
	
	
	/////////////////////////////
	// UPDATE the users PM Count
	/////////////////////////////
	
	if($affectedrows >= 1){
		
		//Make the QUERY
		$qresult = makequery("UPDATE ".$dbtables['users']." 
				SET pm = pm - $affectedrows 
				WHERE id = '".$user['id']."'", false);
				
		if(mysql_affected_rows($conn) < 1){
			
			reporterror($l['pm_empty_folder_error'] ,$l['pm_empty_folder_error_exp']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);	
		
	}
			
	//Redirect
	redirect("act=usercp&ucpact=$redirect");
	
	
}//End of function



/////////////////////////////////////
// Counts the Num of PM.s in a folder
/////////////////////////////////////

function countpm(){

global $user, $conn, $dbtables, $logged_in, $globals, $foldercount;

	/* Count the Number of PM's in each Folder */
	
	$foldercount = array();
	
	$countquery = array();
			
	//Inbox
	$countquery[0] = array("SELECT COUNT(*) AS pms 
					FROM ".$dbtables['pm']." 
					WHERE pm_to = '".$user['id']."'
					AND pm_folder = '0'", $l['pm_no_count_inbox']);
	
	//Sent Items
	$countquery[1] = array("SELECT COUNT(*) AS pms 
					FROM ".$dbtables['pm']." 
					WHERE pm_from = '".$user['id']."'
					AND pm_folder = '1'", $l['pm_no_count_sentitems']);
				
	//Drafts
	$countquery[2] = array("SELECT COUNT(*) AS pms 
					FROM ".$dbtables['pm']." 
					WHERE pm_from = '".$user['id']."'
					AND pm_folder = '2'", $l['pm_no_count_drafts']);
					
	
	//The Loop
	for($i = 0; $i <= 2; $i++){
	
		//Make the QUERY
		$qresult = makequery($countquery[$i][0]);
		
		if(mysql_num_rows($qresult) < 1){
	
			//Show a major error and return
			reporterror($l['pm_counting_error'] ,$l['pm_counting_error_exp']);
			
			return false;
				
		}
				
		$tempvar = mysql_fetch_assoc($qresult);
		
		//Add the Num in folders
		$foldercount[$i] = $tempvar['pms'];
		
		
	}//End of loop
		
	/* Ending - Count the Noumber of PM's in each Folder */

}



?>