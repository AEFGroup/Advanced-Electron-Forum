<?php

//////////////////////////////////////////////////////////////
//===========================================================
// tellafriend.php
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

////////////////////////////////
// To email a topic to a friend
////////////////////////////////

function tellafriend(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $topic, $tree, $categories, $forums, $board, $message;
	
	//Load the Language File
	if(!load_lang('tellafriend')){
	
		return false;
		
	}
	
	//Where are we
	$tree = array();//Board tree for users location
	$tree[] = array('l' => $globals['index_url'],
					'txt' => $l['index']);
					
	
	//Is registration allowed
	if(!$globals['allow_taf']){
	
		reporterror($l['taf_disabled_title'], $l['taf_disabled']);
		
		return false;
		
	}
	
	//The name of the file
	$theme['init_theme'] = 'tellafriend';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Tell a friend';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('tellafriend_theme');
	
	
	/////////////////////////////////
	// Do you have the permissions
	if(!$user['can_email_topic']){
	
		reporterror($l['no_taf_permissions_title'], $l['no_taf_permissions']);
		
		return false;
	
	}
	/////////////////////////////////
	
	
	//Which topic to send ?
	if(isset($_GET['topid']) && trim($_GET['topid'])!==""){
	
		$topid = (int) inputsec(htmlizer(trim($_GET['topid'])));
	
	}else{
	
		//Show a major error and return
		reporterror($l['no_topic_specified_title'], $l['no_topic_specified']);
			
		return false;
	
	}
	
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$sendername = '';
	
	$recipientname = '';
	
	$email = '';
	
	$subject = '';
	
	$message = lang_vars( $l['tellafriend_message'], 
							array($topid, (!empty($user['username']) ? $user['username']: '' )) );

	//My activity
	$globals['last_activity'] = 'taf';
	
	
	//Bring the topic info
	$qresult = makequery("SELECT t.*
			FROM ".$dbtables['topics']." t
			WHERE t.tid='$topid'");
			
	//Is there any such topic
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror($l['no_topic_found_title'], $l['no_topic_found']);
			
		return false;
	
	}
	
	$topic = mysql_fetch_assoc($qresult);
	
	
	//Load the board
	if(!default_of_nor(false)){
	
		return false;
	
	}
	
	
	$its_board_level = '';
	
	//This is to find which forum is it that the user is viewing
	foreach($forums as $c => $cv){
	
		//The main forum loop
		foreach($forums[$c] as $f => $v){
			
			if($forums[$c][$f]['fid'] == $topic['t_bid']){
			
				$board = $forums[$c][$f];
				
				$its_board_level = $forums[$c][$f]['board_level'];
				
				break;
				
			}		
			
		}
		
	}//End of main loop
	
	
	//Did we find any board
	if(empty($board)){
	
		//Show a major error and return
		reporterror($l['no_forum_found_title'], $l['no_forum_found']);
			
		return false;
		
	}
	
	
	//Are we to redirect
	if(!empty($board['fredirect'])){
	
		//Redirect
		header("Location: ".$board['fredirect']);
		
		return true;
		
	}
	
	
	//Is he a Moderator then load his permissions
	if(!is_mod()){
		
		return false;
	
	}
	
	
	//He is viewing this topic
	$globals['activity_id'] = $topic['tid'];
	
	$globals['activity_text'] = $topic['topic'];
	
	
	//Lets make the tree
	//First the category
	$tree[] = array('l' => $globals['index_url'].'#cid'.$board['cat_id'],
					'txt' => $categories[$board['cat_id']]['name']);
					
	//Now the forums location
	$cid = $board['cat_id'];
	
	$tree_fid = $board['fid'];
	
	$temp_r = array();
	
	//Insert this board in the temp array
	$temp_r[] = $board['fid'];
	
	while(true){
	
		//Does this board have a parent
		if(!empty($forums[$cid]['fid'.$tree_fid]['par_board_id'])){
		
			$tree_fid = $forums[$cid]['fid'.$tree_fid]['par_board_id'];
			
			$temp_r[] = $tree_fid;
		
		//You dont have a parent
		}else{
		
			break;
		
		}
		
	}

	//Now flip the array
	$temp_r = array_reverse($temp_r);
	
	foreach($temp_r as $v){
	
		$tree[] = array('l' => $globals['index_url'].'fid='.$v,
					'txt' => $forums[$cid]['fid'.$v]['fname']);
	
	}
	
	
	//Add the topic also
	$tree[] = array('l' => $globals['index_url'].'tid='.$topic['tid'],
					'txt' => $topic['topic']);
					
	$tree[] = array('l' => $globals['index_url'].'act=tellafriend&topid='.$topic['t_bid'],
					'txt' => $l['telling_a_friend']);
	
	//The forums theme
	forum_theme();
	
	if(isset($_POST['tellafriend'])){
	
		//Check the sender is there
		if(!(isset($_POST['sendername'])) || strlen(trim($_POST['sendername'])) < 1){
		
			$error[] = $l['no_name'];
			
		}else{
			
			$sendername = inputsec(htmlizer(trim($_POST['sendername'])));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'tellafriend_theme';
			return false;		
		}
		
		
		//Check the Recipients name
		if(!(isset($_POST['recipientname'])) || strlen(trim($_POST['recipientname'])) < 1){
		
			$error[] = $l['no_recipient'];
			
		}else{
			
			$recipientname = inputsec(htmlizer(trim($_POST['recipientname'])));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'tellafriend_theme';
			return false;		
		}
		
		
		//Check the Recipients email address
		if(!(isset($_POST['email'])) || strlen(trim($_POST['email'])) < 1){
		
			$error[] = $l['no_recipient_email'];
			
		}else{
			
			$email = inputsec(htmlizer(trim($_POST['email'])));
			
			//Also confirm its validity
			if(!emailvalidation($email)){
	
				$error[] = $l['recipient_email_invalid'];
			
			}
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'tellafriend_theme';
			return false;		
		}
		
		
		//Check the subject
		if(!(isset($_POST['subject'])) || strlen(trim($_POST['subject'])) < 1){
		
			$error[] = $l['no_subject'];
			
		}else{
			
			$subject = inputsec(htmlizer(trim($_POST['subject'])));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'tellafriend_theme';
			return false;		
		}
		
		
		//Check the message body
		if(!(isset($_POST['message'])) || strlen(trim($_POST['message'])) < 1){
		
			$error[] = $l['no_message'];
			
		}else{
			
			$message = inputsec(htmlizer(trim($_POST['message'])));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'tellafriend_theme';
			return false;		
		}
		
		
		
		///////////////////////////////////////
		// Lets send the email to the reciever
		///////////////////////////////////////
		
		$mail[0]['to'] = $email;
		$mail[0]['subject'] = $subject;
		$mail[0]['message'] = lang_vars( $l['tellafriend_mail'], 
								array($recipientname, $sendername, unhtmlentities($message)) );
		
		//Pass all Mails to the Mail sending function
		aefmail($mail);
		
		//Lets redirect and return
		redirect('tid='.$topid);
				
		return true;
	
	}else{	
	
		$theme['call_theme_func'] = 'tellafriend_theme';
	
	}
	
	
	return true;	
	
}


?>