<?php

//////////////////////////////////////////////////////////////
//===========================================================
// index.php
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

function report(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $categories, $forums, $fid, $error, $board, $topic, $tree;

	//Load the Language File
	if(!load_lang('report')){
	
		return false;
		
	}
	
	//The name of the file
	$theme['init_theme'] = 'report';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Report Post Theme';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('report_theme');		
	
	//My activity
	$globals['last_activity'] = 'rp';
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$pid = 0;
	
	$topic = array();
	
	$admins = array();
	
	$tree = array();//Board tree for users location
	$tree[] = array('l' => $globals['index_url'],
					'txt' => $l['index']);
	
	if(isset($_GET['pid']) && trim($_GET['pid'])!=="" && is_numeric(trim($_GET['pid']))){
	
		$pid = (int) inputsec(htmlizer(trim($_GET['pid'])));
				
	}else{
	
		//Show a major error and return
		reporterror($l['no_post_specified_title'], $l['no_post_specified']);
			
		return false;
		
	}
	
	//Bring the topic out
	$qresult = makequery("SELECT t.*, p.*
				FROM ".$dbtables['posts']." p
				LEFT JOIN ".$dbtables['topics']." t ON (t.tid = p.post_tid)
				WHERE p.pid = '$pid'");
				
	if(mysql_num_rows($qresult) < 1){
				
		//Show a major error and return
		reporterror($l['no_post_found'], $l['no_post_found']);
			
		return false;
		
	}
	
	//Fetch the topic
	$topic = mysql_fetch_assoc($qresult);
	
	$fid = $topic['t_bid'];
	
	//Load the board
	if(!default_of_nor(false)){
	
		return false;
	
	}
		
	$its_board_level = '';
	
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
	
	//He is reporting this post
	$globals['activity_id'] = $topic['pid'];
	
	$globals['activity_text'] = (empty($topic['post_title']) ? $topic['topic'] : $topic['post_title']);
	
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
	$tree[] = array('l' => $globals['index_url'].'tid='.$topic['tid'],
					'txt' => $topic['topic']);
	
	//Add the inner topic link also
	$tree[] = array('l' => $globals['index_url'].'act=report&pid='.$pid,
					'txt' => $l['reporting_post']);
	
	
	//The forums theme
	forum_theme();
	
	if(!$globals['report_posts'] || !$user['can_report_post']){
	
		//Show a major error and return
		reporterror($l['no_report_permissions_title'], $l['no_report_permissions']);
			
		return false;
	
	}
	
	/////////////////////////////////////////
	// 1) CHECK IF SUBMIT HAS BEEN DONE
	//		1) SEND PM TO ADMINS
	//		2) UPDATE POST STATUS TO REPORTED
	// THAT SHOULD BE EVERYTHING THEN..
	/////////////////////////////////////////
	
	if (isset($_POST['reportpost'])) {
	
		if(!(isset($_POST['report'])) || strlen(trim($_POST['report'])) < 1){	
		
			$error[] = $l['no_report'];
			
		}else{
		
			$report = inputsec(htmlizer(trim($_POST['report'])));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'report_theme';
			return false;		
		}
		
		
		// GET THE ADMINS FIRST
		$qresult = makequery("SELECT u.id, u.username, u.email
				FROM ".$dbtables['users']." u
				LEFT JOIN ".$dbtables['permissions']." p ON (u.u_member_group = p.member_group_id)
				LEFT JOIN ".$dbtables['user_groups']." ug ON (p.member_group_id = ug.member_group)
				WHERE p.can_admin = '1'");
				
		if(mysql_num_rows($qresult) < 1){
		
			//Show a major error and return
			reporterror($l['report_error_title'], $l['report_error']);
				
			return false;
		
		}else{
		
			for($i = 0; $i < mysql_num_rows($qresult); $i++){
				
				$row = mysql_fetch_assoc($qresult);
				
				$admins[$row['id']] = $row;
				
			}
			
		}
		
		//Calculate the topic page number.
		$qresult = makequery("SELECT pid FROM ".$dbtables['posts']." 
						WHERE post_tid = '".$topic['tid']."'
						ORDER BY pid ASC");
		
		for($i = 1; $i <= mysql_num_rows($qresult); $i++){
			
			$row = mysql_fetch_assoc($qresult);
			
			$pids[$i] = $row['pid'];
		
		}
				
		//Free the resources
		@mysql_free_result($qresult);
		
				
		//Find the post number that this post is of its topic
		$post_num = array_search($pid, $pids);
		
		$tpg = ($post_num/$globals['maxpostsintopics']);
		
		$tpg = ceil($tpg);
		
		
		$body = lang_vars($l['pm_body'], array($globals['index_url'].'tid='.$topic['tid'].'&tpg='.$tpg.'#p'.$pid, $report));
		
		////////////////////////////
		// PM EVERY ADMIN ACCOUNT..
		////////////////////////////
		foreach($admins as $a => $av){
			
			sendpm($a, $l['pm_subject'], $body, false, false);
			
		}
			
		//Redirect
		redirect('tid='.$topic['tid'].'&tpg='.$tpg.'#p'.$pid);
		
		return true;
	
	}else{
		
		//Call our theme forward..
		$theme['call_theme_func'] = 'report_theme';
		
	}

}

?>
