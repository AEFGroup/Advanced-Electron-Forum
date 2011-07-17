<?php

//////////////////////////////////////////////////////////////
//===========================================================
// movetopic.php
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


///////////////////////////////////
// What things are to be changed
// 1 - Topics
// 2 - Posts, Users Post Count
// 3 - Attachments
// 4 - Polls,Options and Voters
// 5 - Notifications
// 6 - Read Topics
///////////////////////////////////

	
function movetopic(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $categories, $forums, $fid, $error, $board, $mother_options, $tree;

	//Load the Language File
	if(!load_lang('movetopic')){
	
		return false;
		
	}
	
	//The name of the file
	$theme['init_theme'] = 'movetopic';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Move Topic Theme';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('movetopic_theme');
	
	//My activity
	$globals['last_activity'] = 'mt';
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	//A error handler ARRAY
	$error = array();
	
	//Other VARS
	
	$topic = '';
	
	$fids = array();
	
	$get_tids = '';
	
	$invalid = array();//Some invalid tid
	
	$tids_str = '';//Clean string of ids
	
	$tids = array();
	
	$topics = array();
	
	$deleted = 0;
	
	$updated = 0;
	
	$posts = array();
	
	$pids = array();
	
	$pids_str = '';//Clean string of ids
	
	$n_posts = 0;
	
	$attachments = array();
	
	$attach_pids = array();//Array of pids having attachments
	
	$poll_tids = array();//Array of tids having polls
	
	$polls = array();
	
	$mother_options = array();
	
	$tree = array();//Board tree for users location
	$tree[] = array('l' => $globals['index_url'],
					'txt' => $l['index']);

	if(isset($_GET['topid']) && trim($_GET['topid'])!==""){
	
		$get_tids = inputsec(htmlizer(trim($_GET['topid'])));
		
		$tids = explode(',', $get_tids);
		
	}else{
	
		//Show a major error and return
		reporterror($l['no_topic_specified_title'], $l['no_topic_specified']);
			
		return false;
		
	}
	
	
	//Clean the tids
	foreach($tids as $k => $v){
		
		//Make it integer
		$tids[$k] = (int) trim($v);
		
		//Check if it is valid
		if(empty($tids[$k])){
		
			$invalid[] = $tids[$k];
		
		}
		
	}
	
	
	//Did we get some invalid ones
	if(!empty($invalid)){
	
		//Show a major error and return
		reporterror($l['invalid_topic_specified_title'], $l['invalid_topic_specified']);
			
		return false;
	
	}
	
	//Make them unique also
	$tids = array_unique($tids);
	
	array_multisort($tids);
	
	$tids_str = implode(', ', $tids);
	
		
	//Bring the topics out
	$qresult = makequery("SELECT tid, topic, t_bid, n_posts, t_mem_id, poll_id, has_attach
			FROM ".$dbtables['topics']."
			WHERE tid IN ($tids_str)");
	
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror($l['no_topic_found_title'], $l['no_topic_found']);
		
		return false;
		
	//Are the number of topics less than the tids 	
	}elseif(mysql_num_rows($qresult) != count($tids)){
	
		//Show a major error and return
		reporterror($l['some_topic_not_found_title'], $l['some_topic_not_found']);
		
		return false;
	
	}
	
	for($i = 1; $i <= mysql_num_rows($qresult); $i++){
		
		$row = mysql_fetch_assoc($qresult);
		
		$topics[$row['tid']] = $row;
				
		$fid = $row['t_bid'];
		
		$fids[] = $row['t_bid'];
		
		$n_posts = $n_posts + ($row['n_posts'] + 1);
		
		//Are there any polls
		if(!empty($row['poll_id'])){
		
			$poll_tids[] =  $row['tid'];
	
		}
					
	}
	
		
	//Free the resources
	@mysql_free_result($qresult);
		
	
	//Check are they of the same forum or no
	if(count(array_unique($fids)) > 1){
	
		//Show a major error and return
		reporterror($l['not_same_forum_title'], $l['not_same_forum']);
		
		return false;
		
	}	
		
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
	
	
	//He is viewing this forum and posting in this
	$globals['viewing_board'] = $board['fid'];
	
		
	foreach($topics as $tk => $tv){
	
		//Who started this post?
		if($logged_in){
			
			if($topics[$tk]['t_mem_id'] == $user['id']){
			
				$i_started = true;
				
			}else{
			
				$i_started = false;
				
			}
			
		}else{
		
			$i_started = false;
			
		}
		
		
		//Can he delete the topics
		if( !(($i_started && $user['can_move_own_topic']) ||
		  (!$i_started && $user['can_move_other_topic'])) ){
	
			//Show a major error and return
			reporterror($l['no_move_permissions_title'], $l['no_move_permissions']);
				
			return false;
		
		}
		
		unset($i_started);
	
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
	
	//The forums theme
	forum_theme();
	
	if(count($topics) == 1){
		
		foreach($topics as $tk => $tv){
		
			$trtid = $tk;
		
		}
		
		//Add the topic also
		$tree[] = array('l' => $globals['index_url'].'tid='.$topics[$trtid]['tid'],
						'txt' => $topics[$trtid]['topic']);
						
		//Add the topic action link also
		$tree[] = array('l' => $globals['index_url'].'act=movetopic&topid='.$topics[$trtid]['tid'],
						'txt' => $l['moving_topics']);
					
	}else{
	
		$tree[] = array('l' => $globals['index_url'].'act=movetopic&topid='.implode(',', $tids),
						'txt' => $l['moving_topics']);
	
	}
	
	
	//Bring the pids out
	$qresult = makequery("SELECT pid, num_attachments
			FROM ".$dbtables['posts']."
			WHERE post_tid IN ($tids_str)");
	
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror($l['no_post_found_title'], $l['no_post_found']);
		
		return false;
		 	
	}
	
	//Loop through the pids
	for($i = 1; $i <= mysql_num_rows($qresult); $i++){
	
		$row = mysql_fetch_assoc($qresult);
		
		$posts[$row['pid']] = $row;
		
		$pids[] = $row['pid'];
		
		//Are there any attachments
		if($row['num_attachments'] >= 1){
		
			$attach_pids[] =  $row['pid'];
	
		}
		
	}
	
	array_multisort($pids);
	
	$pids_str = implode(', ', $pids);
	
	//Free the resources
	@mysql_free_result($qresult);
	
	
	/////////////////////////////////////
	// Find the Forums that can be given
	/////////////////////////////////////
	
	foreach($categories as $c => $cv){
		
		if(isset($forums[$c])){			
			
			foreach($forums[$c] as $f => $fv){
								
				$dasher = "";
				
				for($t = 1; $t < $forums[$c][$f]['board_level']; $t++){
				
					$dasher .= "&nbsp;&nbsp;&nbsp;&nbsp;";
					
				}								
				
				$mother_options[$forums[$c][$f]['fid']] = array($forums[$c][$f]['fid'], 
										$dasher.(($forums[$c][$f]['board_level'] != 0) ? '|--' : '').$forums[$c][$f]['fname']);
										
				$forum_ids[] = $forums[$c][$f]['fid'];
				
			}
		
		}
		
	}
	
	
	if(isset($_POST['movetopic'])){
	
		//Check the forum to which it is to go to
		if(!(isset($_POST['mtfid'])) || trim($_POST['mtfid']) == ""){
		
			$error[] = $l['no_forum_selected'];
			
		}else{
			
			$mtfid = (int) inputsec(htmlizer(trim($_POST['mtfid'])));
			
			//Is it a valid Forum
			if(!in_array($mtfid, $forum_ids)){
			
				$error[] = $l['invalid_forum_selected'];
			
			}
			
			if($mtfid == $fid){
			
				$error[] = $l['same_forum_error'];
			
			}
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'movetopic_theme';
			return false;		
		}
		
		
		//Check the moved link is to be inserted
		if(isset($_POST['movedlink'])){
			
			$movedlink = 1;
			
			//Check the text
			if(!(isset($_POST['movedtext'])) || trim($_POST['movedtext']) == ""){
			
				$error[] = $l['no_moved_link_text'];
				
			}else{
				
				$movedtext = inputsec(htmlizer(trim($_POST['movedtext'])));
				
				//Replace the {board} param
				$movedtext = str_replace('{board}', '[url='.$globals['index_url'].'fid='.$mtfid.']'.$mother_options[$mtfid][1].'[/url]', $movedtext);				
				
			}
			
			//on error call the form
			if(!empty($error)){
				$theme['call_theme_func'] = 'movetopic_theme';
				return false;
			}
			
		}
		
		//return false;	
	
		//If we have reached here it means he can move it now
		
		
		///////////////////////////////////
		// Finally lets start the queries
		// Effects of moving a topic :
		// 1 - Update the topics table
		// 2 - Update the posts table
		// 3 - Update the attachments
		// 4 - Update polls,options and voters
		// 5 - Update forums topic, post count
		//     a)From where it is going
		//     b)Where it is going
		// 6 - Create a moved topic link
		///////////////////////////////////
		
		
		/////////////////////
		// UPDATE the topics
		/////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['topics']."
						SET t_bid = '$mtfid'
						WHERE tid IN ($tids_str)", false);
						
		//How many were deleted ?
		$updated = mysql_affected_rows($conn);
						
		if($updated != count($topics)){
				
			reporterror($l['topic_update_error_title'], $l['topic_update_error']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		
						
		///////////////////
		// UPDATE the post
		///////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['posts']."
						SET post_fid = '$mtfid'
						WHERE post_tid IN ($tids_str)", false);
						
		//How many were deleted ?
		$updated_p = mysql_affected_rows($conn);
						
		if($updated_p != count($pids)){
				
			reporterror($l['update_posts_error_title'], $l['update_posts_error']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);		
		
		
		//////////////////////////
		// UPDATE the attachments
		//////////////////////////
		
		//Get out the attachments
		if(!empty($attach_pids)){
		
			$at_pids_str = implode(', ', $attach_pids);
		
			//Bring the atids out
			$qresult = makequery("UPDATE ".$dbtables['attachments']."
					SET at_fid = '$mtfid'
					WHERE at_pid IN ($at_pids_str)", false);
					
			if(mysql_affected_rows($conn) < 1){
		
				//A mechanism to report error
							
			}
		
		}
		
		
		////////////////////////////////////////
		// UPDATE the polls, options and voters
		////////////////////////////////////////
		//No need to do so as the polls are dependent on the topics
		
		
		/////////////////////////////////
		// INSERT a new moved link topic 
		/////////////////////////////////
		
		if(!empty($movedlink)){
			
			$m_topic = 0;
			
			$m_posts = 0;
			
			foreach($topics as $tk => $tv){
			
				//////////////////////////
				// INSERT the topic first
				//////////////////////////
				
				$qresult = makequery("INSERT INTO ".$dbtables['topics']."
								SET topic = '".$topics[$tk]['topic']."',
								t_bid = '".$board['fid']."',
								t_status = '2',
								t_mem_id = '".($logged_in ? $user['id'] : '-1')."'");
				
				$m_tid = mysql_insert_id($conn);
						
				if( empty($m_tid) ){
					
					reporterror($l['link_topic_error_title'], $l['link_topic_error']);
					
					return false;
					
				}
						
				//Free the resources
				@mysql_free_result($qresult);
				
				
				///////////////////////
				// INSERT the post now
				///////////////////////
				
				$post = str_replace('{link}', '[url]'.$globals['index_url'].'tid='.$topics[$tk]['tid'].'[/url]', $movedtext);	
				
				$qresult = makequery("INSERT INTO ".$dbtables['posts']." 
								SET post_tid = '$m_tid',
								post_fid = '".$board['fid']."',
								ptime = '".time()."',
								poster_id = '".($logged_in ? $user['id'] : '-1')."',
								poster_ip = '".$_SERVER['REMOTE_ADDR']."',
								post = '$post'");
				
				$pid = mysql_insert_id($conn);
						
				if( empty($pid) ){
					
					reporterror($l['link_topic_post_error_title'], $l['link_topic_post_error']);
					
					return false;
					
				}
				
				//UPDATE the topics last, first PID
				$qresult = makequery("UPDATE ".$dbtables['topics']." 
							SET	first_post_id = ".$pid.",
							last_post_id = ".$pid.",
							mem_id_last_post = ".($logged_in ? $user['id'] : '-1')."
							WHERE tid = '".$m_tid."'", false);
				
				$m_topic = $m_topic + 1;
				
				$m_posts = $m_posts + 1;
			
			}
			
			
			//UPDATE the forum topic, posts count
			$qresult = makequery("UPDATE ".$dbtables['forums']." 
						SET ntopic = ntopic + ".$m_topic.",
						nposts = nposts + ".$m_posts."
						WHERE fid = '".$board['fid']."'", false);
							
			if(mysql_affected_rows($conn) < 1){
					
				//Error reporting still to come
				
			}
			
			//Free the resources
			@mysql_free_result($qresult);
			
		
		}
		
		//GET the Last Pid from where its going
		$lastpost = last_post_forum($board['fid']);
		
		//////////////////////////////////////
		// UPDATE the forums topic, post count
		//  a) From where it is going
		//////////////////////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['forums']." 
						SET ntopic = ntopic - ".$updated.",
						nposts = nposts - ".$updated_p.",
						f_last_pid = ".$lastpost['pid']."
						WHERE fid = '".$board['fid']."'", false);
						
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['update_forum_error_title'], $l['update_forum_error']);
			
			return false;
			
		}		
		
		//GET the Last Pid from where its going
		$lastpost = last_post_forum($mtfid);
		
		///////////////////////////////////
		// Update forums topic, post count
		//  b) Where it is going
		///////////////////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['forums']." 
						SET ntopic = ntopic + ".$updated.",
						nposts = nposts + ".$updated_p.",
						f_last_pid = ".$lastpost['pid']."
						WHERE fid = '$mtfid'", false);
						
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['update_dest_forum_error_title'], $l['update_dest_forum_error']);
			
			return false;
			
		}
		
		//Looks like everything went well
		//Redirect
		redirect('fid='.$fid);//IE 7 #redirect not working
		
		return true;
		
	
	}else{
	
		$theme['call_theme_func'] = 'movetopic_theme';
	
	}	
	
	
}	


	
?>