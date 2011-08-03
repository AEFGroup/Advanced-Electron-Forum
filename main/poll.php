<?php

//////////////////////////////////////////////////////////////
//===========================================================
// poll.php
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

//Load the Language File
if(!load_lang('poll')){

	return false;
	
}	

function loadpoll($poid){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $tid, $pg, $board, $topic;

	//Check that polls are allowed Globally and in this Board
	if(!$globals['enablepolls'] || !(empty($board) ? true : $board['allow_poll'])){
		
		return false;
		
	}
	
	//Is the user allowed to see ?
	if(!$user['can_view_poll']){
		
		return false;
		
	}	
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	
	$user_voted = 0;//Has the User Voted $VAR	
	
	$total_votes = 0;//The Total number of votes
	
	
	//Load the poll with its options and Left join the user has voted if Logged In		
	$qresult = makequery("SELECT po.*, poo.*".($logged_in ? ", pv.*" : "")."
			FROM ".$dbtables['polls']." po
			LEFT JOIN ".$dbtables['poll_options']." poo ON (po.poid = poo.poo_poid)
			".($logged_in ? "LEFT JOIN ".$dbtables['poll_voters']." pv ON (
										pv.pv_mid = '".$user['id']."' 
										AND pv.pv_pooid = poo.pooid 
										AND pv.pv_poid = po.poid)" : "")."
			WHERE  po.poid = '".$poid."'
			ORDER BY poo.pooid ASC");

	
	if(mysql_num_rows($qresult) < 1){
			
		return false;
		
	}

	
	//Put the options in the array
	for($p=1; $p <= mysql_num_rows($qresult); $p++){
	
		$poll_opt[$p] = mysql_fetch_assoc($qresult);
		
		$options[$p] = array('pooid' => $poll_opt[$p]['pooid'],
							'poo_option' => $poll_opt[$p]['poo_option'],
							'poo_votes' => $poll_opt[$p]['poo_votes']
							);
		
		
		//Calculate the total votes
		$total_votes = $total_votes + $poll_opt[$p]['poo_votes'];
		
		
		//Check has the user voted (Only if he is logged in)
		if($logged_in && $poll_opt[$p]['pv_mid']){
		
			$user_voted = $poll_opt[$p]['pooid'];
		
		}
		
	}
		
		
	//Lets build the poll array - TEMPORARILY
	$poll = array('poid' => $poll_opt[1]['poid'],
				'qt' => $poll_opt[1]['poll_qt'],
				'mid' => $poll_opt[1]['poll_mid'],
				'locked' => $poll_opt[1]['poll_locked'],
				'tid' => $poll_opt[1]['poll_tid'],
				'expiry' => $poll_opt[1]['poll_expiry'],//Must be whole No.
				'expired' => 0,
				'change_vote' => $poll_opt[1]['poll_change_vote'],
				'started' => $poll_opt[1]['poll_started'],
				'votes' => $total_votes,
				'user_voted' => (isset($AEF_SESS['poll_voted']) && $AEF_SESS['poll_voted'] ? $AEF_SESS['poll_voted'] : $user_voted),
				'show_when' => $poll_opt[1]['poll_show_when'],
				'what_to_show' => 0,
				'options' => $options
				);	
	
	
	//Check has it expired
	if($poll['expiry']){
				
		$expiry_time = ($poll['started'] + (60*60*24*$poll['expiry']));
		
		$poll['expired'] = (time() > $expiry_time) ? 1 : 0;
		
		$poll['expires_on'] = $expiry_time;
	
	}else{
		
		//If the expiry is not set show_when cannot be 2
		if($poll['show_when'] == 2){
		
			$poll['show_when'] = 0;
		
		}
	
	}
	
	
	///////////////////////////
	// Did I start this poll ?
	///////////////////////////
	
	if($logged_in){
		
		if($poll['mid'] == $user['id']){
		
			$i_started = true;
			
		}else{
		
			$i_started = false;
			
		}
		
	}else{
	
		$i_started = false;
		
	}
	
	$poll['i_started'] = $i_started;	

	
	//Unset unimportant $VARS
	unset($options);
	unset($poll_opt);
	
	
	//OK so no errors - Lets RETURN True
	return $poll;
	
}


function poll_action(&$poll){

global $user, $board;
	
	
///////////////////////////////////////////
// Things to consider in this fuction : 
// 1) Is poll Locked
// 2) Has the poll expired
// 3) Is the user allowed to CHANGE the vote
///////////////////////////////////////////


///////////////////////////////////////////
// List of things that show different parts
// of the POLL :
// 0 - Nothing
// 1 - Voting Form
// 2 - The Poll Results
// 3 - The results will be displayed after 
//	   the poll has expired
///////////////////////////////////////////
	

///////////////////////////////////////////
// The Number meanings of poll_show_when
// 0 - Show any time if asked
// 1 - Show only after someone has voted
// 2 - Show the results after it has expired
///////////////////////////////////////////


	//Has he requested to see the poll
	if(isset($_GET['spollres']) && ($poll['show_when'] == 0)){
		
		return 2;
	
	}
	
	
	//If the user has not voted
	if((!$poll['user_voted']) && ($user['can_vote_polls'] || $board['can_vote_polls']) && 
		!$poll['expired'] && !$poll['locked']){
		
		return 1;
			
	}
		
	
	//Finally Check that should we return SHOW the RESULTS
	if($poll['user_voted'] && $poll['expiry'] && ($poll['show_when'] == 2) && !$poll['expired']){
		
		return 3;
	
	//You may see the poll
	}else{
	
		return 2;
	
	}
	
	return 0;

}


function handle_vote($poll){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $tid, $pg, $board;

	//Call the Language function
	handle_vote_lang();
	
	if(isset($_POST['vote_poll'])){
				
		//Check if the user is allowed to vote
		if((!$poll['user_voted']) && ($user['can_vote_polls'] || $board['can_vote_polls']) && 
			!$poll['expired'] && !$poll['locked']){
		
			//Has the user even voted the option
			if(isset($_POST['uservote'])){
			
				$votedoption = (int) inputsec(htmlizer(trim($_POST['uservote'])));
			
			}else{
			
				reporterror($l['no_option_title'], $l['no_option']);
		
				return false;
			
			}
			
			//The VAR that tells the OPTION ID is there in this poll
			$matched = 0;
			
		
			foreach($poll['options'] as $opk => $opt){
			
				if($opt['pooid'] == $votedoption){
				
					$matched = 1;	
					break;
				
				}
			
			}
			
			if(!$matched){
			
				reporterror($l['invalid_option_title'], $l['invalid_option']);
		
				return false;
			
			}
			
		
			if($matched){
			
				//If the user is logged in only then we record his vote
				if($logged_in){
				
					$qresult = makequery("INSERT INTO ".$dbtables['poll_voters']."
						SET pv_mid = '".$user['id']."', pv_pooid = '$votedoption', 
						pv_poid = '".$poll['poid']."'");
					
					if(mysql_affected_rows($conn) < 1){
			
						reporterror($l['vote_error_title'], $l['vote_error']);
						
						return false;
						
					}
				
				}else{
				
					//Set a Session so that the guest does not keep on voting
					$AEF_SESS['poll_voted'] = 1;
				
				}
				
				$qresult = makequery("UPDATE ".$dbtables['poll_options']."
						SET poo_votes = poo_votes + 1
						WHERE pooid = '$votedoption'
						AND poo_poid = '".$poll['poid']."'", false);	
									
				if(mysql_affected_rows($conn) < 1){
			
					reporterror($l['update_poll_error_title'], $l['update_poll_error']);
					
					return false;
						
				}
			
			}			
				
			//Redirect
			redirect('tid='.$tid.'&tpg='.$pg.'&spollres');
			
			return true;
		
		}else{
					
			reporterror($l['no_vote_permissions_title'], $l['no_vote_permissions']);
			
			return false;
		
		}//End of Check if the user is allowed to vote
	
	
	}elseif(isset($_GET['deletevote'])){
		
		//Can he delete his vote
		if($poll['user_voted'] && $logged_in && $poll['change_vote']){
			
			
			////////////////////////////////
			// SELECT what had he voted for
			////////////////////////////////
			
			$qresult = makequery("SELECT * FROM ".$dbtables['poll_voters']."
						WHERE pv_mid = '".$user['id']."'
						AND pv_poid = '".$poll['poid']."'");
			
			if(mysql_num_rows($qresult) < 1){
					
				//Show a major error and return
				reporterror($l['did_not_vote_title'], $l['did_not_vote']);
				
				return false;
				
			}
			
			$row = mysql_fetch_assoc($qresult);
			
			//Free the resources
			@mysql_free_result($qresult);
			
			
			///////////////////////////////
			// DELETE the users vote first
			///////////////////////////////
			
			$qresult = makequery("DELETE FROM ".$dbtables['poll_voters']."
						WHERE pv_mid = '".$user['id']."'
						AND pv_poid = '".$poll['poid']."'", false);
					
			if(mysql_affected_rows($conn) < 1){
	
				reporterror($l['delete_vote_error_title'], $l['delete_vote_error']);
				
				return false;
				
			}
			
			
			///////////////////////////
			// UPDATE the Poll results
			///////////////////////////
			
			$qresult = makequery("UPDATE ".$dbtables['poll_options']."
						SET poo_votes = poo_votes - 1
						WHERE pooid = '".$row['pv_pooid']."'
						AND poo_poid = '".$poll['poid']."'", false);	
									
			if(mysql_affected_rows($conn) < 1){
		
				reporterror($l['update_poll_delvote_title'], $l['update_poll_delvote']);
				
				return false;
					
			}
			
			
			//Redirect
			redirect('tid='.$tid.'&tpg='.$pg.'&spollres');
			
			return true;
		
		//No you cant delete vote
		}else{
		
			reporterror($l['cant_delete_vote_title'], $l['cant_delete_vote']);
			
			return false;
		
		}
	
	}else{
	
		return true;
	
	}
	
}


//////////////////
// REMOVES a poll
//////////////////

function removepoll(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $tid, $pg, $board, $topic;

	//Call the Language function
	removepoll_lang();
	
	//Which forum to notify ?
	if(isset($_GET['poid']) && trim($_GET['poid'])!=="" && is_numeric(trim($_GET['poid']))){
	
		$poid = (int) inputsec(htmlizer(trim($_GET['poid'])));
	
	}else{
	
		//Show a major error and return
		reporterror($l['no_poll_specified_title'], $l['no_poll_specified']);
			
		return false;
	
	}
	
	$poll = loadpoll($poid);
	
	
	//Can he Remove the poll
	if( !(($poll['i_started'] && $user['can_rem_own_poll']) ||
	  (!$poll['i_started'] && $user['can_rem_other_poll'])) ){

		//Show a major error and return
		reporterror($l['no_remove_permissions_title'], $l['no_remove_permissions']);
			
		return false;
	
	}
	
	///////////////////////////////////////
	// When a poll is deleted the following
	// 1 - Delete it from the polls table
	// 2 - Delete its options
	// 3 - Delete its votes and voters
	// 4 - Update the topic poll_id = 0 
	///////////////////////////////////////
	
	
	/////////////////////////////////
	// Delete it from the polls table
	/////////////////////////////////
	
	$qresult = makequery("DELETE FROM ".$dbtables['polls']."
				WHERE poid = '$poid'", false);
			
	if(mysql_affected_rows($conn) < 1){

		reporterror($l['remove_poll_error_title'], $l['remove_poll_error']);
		
		return false;
		
	}
	
	
	/////////////////////////////////////////////////
	// Delete its options from the poll_options table
	/////////////////////////////////////////////////
	
	$qresult = makequery("DELETE FROM ".$dbtables['poll_options']."
				WHERE poo_poid = '$poid'", false);
			
	if(mysql_affected_rows($conn) < 1){

		reporterror($l['remove_options_error_title'], $l['remove_options_error']);
		
		return false;
		
	}
	
	
	//////////////////////////////
	// Delete its votes and voters
	//////////////////////////////
		
	$qresult = makequery("DELETE FROM ".$dbtables['poll_voters']."
				WHERE pv_poid = '$poid'", false);
				
	if((mysql_affected_rows($conn) < 1) && ($poll['votes'] > 0)){

		reporterror($l['remove_vote_error_title'], $l['remove_vote_error']);
		
		return false;
		
	}
	
	
	////////////////////
	// UPDATE the topic
	////////////////////
		
	$qresult = makequery("UPDATE ".$dbtables['topics']."
				SET poll_id = '0'
				WHERE tid = '".$poll['tid']."'", false);
			
	if(mysql_affected_rows($conn) < 1){

		reporterror($l['update_topic_error_title'], $l['update_topic_error']);
		
		return false;
		
	}
	
	//Redirect
	redirect('tid='.$poll['tid']);
	
	return true;

}


////////////////////////////////////////
// Allows to edit a poll and its results
////////////////////////////////////////

function editpoll(){


global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $pg, $error, $poll, $board, $categories, $forums, $tree;

	//Call the Language function
	editpoll_lang();
	
	//The name of the file
	$theme['init_theme'] = 'poll';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Poll';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('editpoll_theme');	
	
	//Editing a poll
	$globals['last_activity'] = 'ep';
	
	
	//Some VARS
	$tree = array();//Board tree for users location
	$tree[] = array('l' => $globals['index_url'],
					'txt' => $l['index']);
	
	
	//Which poll to edit ?
	if(isset($_GET['poid']) && trim($_GET['poid'])!=="" && is_numeric(trim($_GET['poid']))){
	
		$poid = (int) inputsec(htmlizer(trim($_GET['poid'])));
	
	}else{
	
		//Show a major error and return
		reporterror($l['no_poll_specified_title'], $l['no_poll_specified']);
			
		return false;
	
	}
	
	
	//Load the board
	if(!default_of_nor(false)){
	
		return false;
	
	}
	
	
	//We need the forums ID
	$qresult = makequery("SELECT t.t_bid, t.topic FROM ".$dbtables['polls']." p
					LEFT JOIN ".$dbtables['topics']." t ON (p.poll_tid = t.tid)");
					
	if(mysql_num_rows($qresult) < 1){
		
		//Show a major error and return
		reporterror($l['no_poll_forum_found_title'], $l['no_poll_forum_found']);
			
		return false;
		
	}
	
	$temp = mysql_fetch_assoc($qresult);
	
	$fid = $temp['t_bid'];
	
	//This is for activity purpose
	$topic = $temp['topic'];
	
	//This is to find which forum is it that the user is viewing
	foreach($forums as $c => $cv){
	
		//The main forum loop
		foreach($forums[$c] as $f => $v){
			
			if($forums[$c][$f]['fid'] == $fid){
			
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
	
	
	$poll = loadpoll($poid);	
	
	//He is viewing this topic
	$globals['activity_id'] = $poll['tid'];
	
	$globals['activity_text'] = $topic;
	
	
	//Can he EDIT the results
	if( !(($poll['i_started'] && $user['can_edit_own_poll']) ||
	  (!$poll['i_started'] && $user['can_edit_other_poll'])) ){

		//Show a major error and return
		reporterror($l['no_edit_permissions_title'], $l['no_edit_permissions']);
			
		return false;
	
	}
	
	
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
	
	
	//Add the topic link
	$tree[] = array('l' => $globals['index_url'].'tid='.$poll['tid'],
					'txt' => $topic);
	
	//Add the inner topic link also
	$tree[] = array('l' => $globals['index_url'].'act=editpoll&poid='.$poll['poid'],
					'txt' => $l['editing_poll']);
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$question = '';
	
	$locked = 0;
	
	$change_vote = 0;
	
	$expiry = 0;
	
	$show_when = 0;
	
	$options = array();
	
	
	if(isset($_POST['editpoll'])){
		
		//Check the poll question
		if(!(isset($_POST['question'])) || strlen(trim($_POST['question'])) < 1){
		
			$error[] = $l['no_question'];
			
		}else{
		
			$question = inputsec(htmlizer(trim($_POST['question'])));
			
			//Check the length
			if(aefstrlen($question) > $globals['maxpollqtlen']){
			
				$error[] = lang_vars($l['question_too_long'], array($globals['maxpollqtlen']));
			
			}
		
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'editpoll_theme';
			return false;		
		}
		
		
		// Are we to lock the poll ?
		if(isset($_POST['locked'])){
		
			$locked = 1;
		
		}
		
		
		// Can the voters change vote
		if(isset($_POST['change_vote'])){
		
			$change_vote = 1;
		
		}
		
		
		// When are you to expire ?
		if(!(isset($_POST['expiry'])) || strlen(trim($_POST['expiry'])) < 1){
		
			$error[] = $l['no_expiry'];
			
		}else{
			
			$expiry = (int) inputsec(htmlizer(trim($_POST['expiry'])));
					
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'editpoll_theme';
			return false;		
		}
		
		
		// When to show the polls results ?
		if(!isset($_POST['show_when'])){
		
			$error[] = $l['no_show_when'];
			
		}else{
			
			$show_when = (int) inputsec(htmlizer(trim($_POST['show_when'])));
					
			if(!in_array($show_when, array(0, 1, 2))){
			
				$error[] = $l['invalid_show_when'];
			
			}
			
			//Check the expiry option
			if(empty($expiry) && $show_when == 2){
			
				$error[] = $l['show_after_what_expiry'];
			
			}
					
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'editpoll_theme';
			return false;		
		}
		
		
		//The poll options
		if(!isset($_POST['options']) || empty($_POST['options']) || !is_array($_POST['options'])){
		
			$error[] = $l['no_options'];
			
		}else{
		
			$options = $_POST['options'];
			
			$update = array();
			
			$insert = array();
			
			$delete = array();
			
			foreach($options as $ok => $ov){
				
				// First lets do some cleaning
				$options[$ok]['name'] = inputsec(htmlizer(trim($options[$ok]['name'])));
			
				$options[$ok]['votes'] = inputsec(htmlizer(trim($options[$ok]['votes'])));
				
				if(isset($options[$ok]['pooid'])){
				
					$options[$ok]['pooid'] = inputsec(htmlizer(trim($options[$ok]['pooid'])));
				
				}
				
				
				//Is the option a old one
				if(!empty($options[$ok]['pooid']) && !empty($options[$ok]['name'])){
					
					$update[] = $options[$ok];
				
				//Old one that is to be deleted
				}elseif(!empty($options[$ok]['pooid']) && empty($options[$ok]['name'])){
				
					$delete[] = $options[$ok];
					
				//It is a new one
				}elseif(empty($options[$ok]['pooid']) && !empty($options[$ok]['name'])){
				
					$insert[] = $options[$ok];
				
				}
			
			}
			
			//on error call the form
			if(!empty($error)){
				$theme['call_theme_func'] = 'editpoll_theme';
				return false;		
			}			
			
			if((count($update) + count($insert)) < 2){
			
				$error[] = $l['atleast_two_options'];
			
			}			
		
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'editpoll_theme';
			return false;		
		}
				
		///////////////////////
		// UPDATE the Poll
		// However there may be
		// no changes.
		///////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['polls']."
				SET poll_qt = '$question',
				poll_locked = '$locked',
				poll_expiry = '$expiry',
				poll_change_vote = '$change_vote',
				poll_show_when = '$show_when'
				WHERE poid = '".$poll['poid']."'", false);
			
		
		/////////////////////////////////
		// Lets UPDATE the Poll Options
		/////////////////////////////////
		
		foreach($update as $uk => $uv){
		
			$qresult = makequery("UPDATE ".$dbtables['poll_options']."
				SET poo_option = '".$uv['name']."',
				poo_votes = '".$uv['votes']."'
				WHERE pooid = '".$uv['pooid']."'", false);		
		
		}
		
		
		/////////////////////////////////
		// Lets DELETE the Poll Options
		/////////////////////////////////
		
		foreach($delete as $dk => $dv){
		
			$qresult = makequery("DELETE FROM ".$dbtables['poll_options']."
				WHERE pooid = '".$dv['pooid']."'", false);
				
			if(mysql_affected_rows($conn) < 1){

				reporterror($l['delete_options_error_title'], $l['delete_options_error']);
				
				return false;
				
			}	
		
		}
		
		
		/////////////////////////////////
		// Lets INSERT the Poll Options
		/////////////////////////////////
		
		foreach($insert as $ik => $iv){
		
			$qresult = makequery("INSERT INTO ".$dbtables['poll_options']."
				SET poo_option = '".$iv['name']."',
				poo_votes = '".$iv['votes']."',
				poo_poid = '".$poll['poid']."'");
				
			if(mysql_affected_rows($conn) < 1){

				reporterror($l['insert_options_error_title'], $l['insert_options_error']);
				
				return false;
				
			}	
		
		}
		
		
		//Redirect
		redirect('tid='.$poll['tid']);
		
		return true;
	
	}else{
	
		$theme['call_theme_func'] = 'editpoll_theme';
	
	}


}


////////////////////////////////////////
// Allows to add a poll and its results
////////////////////////////////////////

function postpoll(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $pg, $error, $poll, $board, $categories, $forums, $tree;

	//Call the Language function
	postpoll_lang();
	
	//The name of the file
	$theme['init_theme'] = 'poll';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Poll';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('postpoll_theme');		
	
	//Posting a poll
	$globals['last_activity'] = 'pp';
	
	//Some VARS
	$tree = array();//Board tree for users location
	$tree[] = array('l' => $globals['index_url'],
					'txt' => $l['index']);
	
	
	////////////////////////////////////////
	// Note: We are not checking any 
	// permissions because the AEF_SESS will
	// be set only if he had the permissions
	// to do so.
	////////////////////////////////////////
	
	if(empty($AEF_SESS['postpoll'])){
	
		reporterror($l['no_topic_specified_title'], $l['no_topic_specified']);
		
		return false;
	
	}
		
	
	$tid = $AEF_SESS['postpoll'];
	
	
	//Load the board
	if(!default_of_nor(false)){
	
		return false;
	
	}
	
	
	//We need the forums ID
	$qresult = makequery("SELECT t.t_bid, t.topic FROM ".$dbtables['topics']." t
					WHERE t.tid = '$tid'");
					
	if(mysql_num_rows($qresult) < 1){
		
		//Show a major error and return
		reporterror($l['no_poll_forum_found_title'], $l['no_poll_forum_found']);
			
		return false;
		
	}
	
	$temp = mysql_fetch_assoc($qresult);
	
	$fid = $temp['t_bid'];
	
	//This is for activity purpose
	$topic = $temp['topic'];
	
	//This is to find which forum is it that the user is viewing
	foreach($forums as $c => $cv){
	
		//The main forum loop
		foreach($forums[$c] as $f => $v){
			
			if($forums[$c][$f]['fid'] == $fid){
			
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
	
	
	//Add the topic link
	$tree[] = array('l' => $globals['index_url'].'tid='.$tid,
					'txt' => $topic);
	
	//Add the inner topic link also
	$tree[] = array('l' => $globals['index_url'].'act=postpoll',
					'txt' => $l['adding_poll']);
	
	//He is viewing this topic
	$globals['activity_id'] = $tid;
	
	$globals['activity_text'] = $AEF_SESS['postpoll_t'];
	
		
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	// Poll Vars
	$question = '';
	
	$locked = 0;
	
	$change_vote = 0;
	
	$expiry = 0;
	
	$show_when = 0;
	
	$options = array();
	
	$member = ($logged_in ? $user['id'] : '-1' );
	
	
	if(isset($_POST['postpoll'])){

		
		//Check the poll question
		if(!(isset($_POST['question'])) || strlen(trim($_POST['question'])) < 1){
		
			$error[] = $l['no_question'];
			
		}else{
		
			$question = inputsec(htmlizer(trim($_POST['question'])));
			
			//Check the length
			if(aefstrlen($question) > $globals['maxpollqtlen']){
			
				$error[] = lang_vars($l['question_too_long'], array($globals['maxpollqtlen']));
			
			}
		
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'postpoll_theme';
			return false;		
		}
		
		
		// Are we to lock the poll ?
		if(isset($_POST['locked'])){
		
			$locked = 1;
		
		}
		
		
		// Can the voters change vote
		if(isset($_POST['change_vote'])){
		
			$change_vote = 1;
		
		}
		
		
		// When are you to expire ?
		if(!(isset($_POST['expiry'])) || strlen(trim($_POST['expiry'])) < 1){
		
			$error[] = $l['no_expiry'];
			
		}else{
		
			$expiry = (int) inputsec(htmlizer(trim($_POST['expiry'])));
					
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'postpoll_theme';
			return false;		
		}
		
		
		// When to show the polls results ?
		if(!isset($_POST['show_when'])){
		
			$error[] = $l['no_show_when'];
			
		}else{
			
			$show_when = (int) inputsec(htmlizer(trim($_POST['show_when'])));
					
			if(!in_array($show_when, array(0, 1, 2))){
			
				$error[] = $l['invalid_show_when'];
			
			}
			
			//Check the expiry option
			if(empty($expiry) && $show_when == 2){
			
				$error[] = $l['show_after_what_expiry'];
			
			}
					
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'postpoll_theme';
			return false;		
		}
		
		
		//The poll options
		if(!isset($_POST['options']) || empty($_POST['options']) || !is_array($_POST['options'])){
		
			$error[] = $l['no_options'];
			
		}else{
		
			$options = $_POST['options'];
			
			$insert = array();
			
			foreach($options as $ok => $ov){
				
				// First lets do some cleaning
				$options[$ok]['name'] = inputsec(htmlizer(trim($options[$ok]['name'])));
			
				if(!empty($options[$ok]['name'])){
				
					$insert[] = $options[$ok];
				
				}
			
			}
			
			
			//There must be atleast two options
			if(count($insert) < 2){
			
				$error[] = $l['atleast_two_options'];
			
			}
						
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'postpoll_theme';
			return false;		
		}
		
		
		///////////////////
		// INSERT the Poll
		///////////////////
		
		$qresult = makequery("INSERT INTO ".$dbtables['polls']."
				SET poll_qt = '$question',
				poll_mid = '$member',
				poll_locked = '$locked',
				poll_tid = '$tid',
				poll_expiry = '$expiry',
				poll_change_vote = '$change_vote',
				poll_started = '".time()."',
				poll_show_when = '$show_when'");
		
		$poid = mysql_insert_id($conn);
				
		if( empty($poid) ){
			
			reporterror($l['add_poll_error_title'], $l['add_poll_error']);
			
			return false;
			
		}
				
		//Free the resources
		@mysql_free_result($qresult);
		
		
		
		/////////////////////////////////
		// Lets INSERT the Poll Options
		/////////////////////////////////
		
		foreach($insert as $ik => $iv){
		
			$qresult = makequery("INSERT INTO ".$dbtables['poll_options']."
				SET poo_option = '".$iv['name']."',
				poo_poid = '$poid'");
				
			if(mysql_affected_rows($conn) < 1){

				reporterror($l['insert_options_error_title'], $l['insert_options_error']);
				
				return false;
				
			}
			
			//Free the resources
			@mysql_free_result($qresult);
		
		}
		
		
		///////////////////////////////////////
		// UPDATE the topics table for poll_id
		///////////////////////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['topics']." 
						SET poll_id = '$poid'
						WHERE tid = '$tid'", false);
						
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['update_poll_error_title'], $l['update_poll_error']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		
		//Redirect
		redirect('tid='.$tid);
		
		unset($AEF_SESS['postpoll']);
		unset($AEF_SESS['postpoll_t']);
		
		return true;
	
	}else{
	
		$theme['call_theme_func'] = 'postpoll_theme';
	
	}


}




?>
