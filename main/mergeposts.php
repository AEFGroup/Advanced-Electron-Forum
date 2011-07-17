<?php

//////////////////////////////////////////////////////////////
//===========================================================
// mergeposts.php
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

	
function mergeposts(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $categories, $forums, $fid, $postcodefield, $error, $smileys, $emoticons, $popup_emoticons, $tid, $board, $post_title, $post, $attachments, $posts, $tree;

	//Load the Language File
	if(!load_lang('mergeposts')){
	
		return false;
		
	}
	
	//The name of the file
	$theme['init_theme'] = 'mergeposts';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Merge Posts';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('mergeposts_theme');
	
	//My activity
	$globals['last_activity'] = 'mp';
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	//Post VARS
	$modtime = time();
	
	$modifiers_id = ($logged_in ? $user['id'] : -1);
	
	$post = '';
	
	$use_smileys = 0;
		
	$post_title = '';
	
	$num_attachments = 0;
	
	//A error handler ARRAY
	$error = array();
	
	//Other VARS
	$invalid = array();//Some invalid pid
	
	$get_pids = '';
	
	$pids_str = '';//Clean string of ids
	
	$pids = array();
	
	$posts = array();
	
	$posters = array();
	
	$deleted = 0;
	
	$tree = array();//Board tree for users location
	$tree[] = array('l' => $globals['index_url'],
					'txt' => 'Index');
	

	if(isset($_GET['pid']) && trim($_GET['pid'])!==""){
	
		$get_pids = inputsec(htmlizer(trim($_GET['pid'])));
		
		$pids = explode(',', $get_pids);
		
	}else{
	
		//Show a major error and return
		reporterror($l['no_post_specified_title'], $l['no_post_specified']);
			
		return false;
		
	}
	
	
	//Clean the pids
	foreach($pids as $k => $v){
		
		//Make it integer
		$pids[$k] = (int) trim($v);
		
		//Check if it is valid
		if(empty($pids[$k])){
		
			$invalid[] = trim($v);
		
		}
		
	}
	
	
	//Did we get some invalid ones
	if(!empty($invalid)){
	
		//Show a major error and return
		reporterror($l['invalid_post_specified_title'], 
						lang_vars($l['invalid_post_specified'], array(implode(', ', $invalid))));
			
		return false;
	
	}
	
			
	//Make them unique also
	$pids = array_unique($pids);
	
	array_multisort($pids);
	
	$pids_str = implode(', ', $pids);
	
			
	//Bring the post out
	$qresult = makequery("SELECT t.tid, t.topic, p.pid, p.post_fid, p.ptime, 
			p.poster_id, p.poster_ip, p.post, p.num_attachments, u.username AS poster 
			FROM ".$dbtables['posts']." p
			LEFT JOIN ".$dbtables['topics']." t ON (t.tid = p.post_tid)
			LEFT JOIN ".$dbtables['users']." u ON (u.id = p.poster_id)
			WHERE p.pid IN ($pids_str)");
	
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror($l['no_post_found_title'], $l['no_post_found']);
		
		return false;
	
	//Are the number of posts less than the pids 	
	}elseif(mysql_num_rows($qresult) != count($pids)){
	
		//Show a major error and return
		reporterror($l['some_post_not_found_title'], $l['some_post_not_found']);
		
		return false;
		
	//Is there only one post
	}elseif(mysql_num_rows($qresult) < 2){
	
		//Show a major error and return
		reporterror($l['one_post_specified_title'], $l['one_post_specified']);
			
		return false;
	
	}	
	
	
	for($i = 1; $i <= mysql_num_rows($qresult); $i++){
		
		$row = mysql_fetch_assoc($qresult);
		
		$posts[$row['pid']] = $row;
				
		$fid = $row['post_fid'];
		
		$tid  = $row['tid'];
		
		$topic = $row['topic'];
		
		$tids[] = $row['tid'];
		
		$posters[$row['poster_id']] = array($row['poster_id'], $row['poster_ip']);
		
		//Does any post has an attachment
		if($row['num_attachments']){
		
			$num_attachments = $num_attachments + $row['num_attachments'];
		
		}
				
	
	}
	
		
	//Free the resources
	@mysql_free_result($qresult);
		
	
	//Check are they of the same topic or no
	if(count(array_unique($tids)) > 1){
	
		//Show a major error and return
		reporterror($l['not_same_topic_title'], $l['not_same_topic']);
		
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
	
	
	//He is viewing this topic
	$globals['activity_id'] = $tid;
	
	$globals['activity_text'] = $topic;
	
	
			
	//Can he MERGE the post
	if(!$user['can_merge_posts']){

		//Show a major error and return
		reporterror($l['no_merge_permissions_title'], $l['no_merge_permissions']);
			
		return false;
	
	}
	
	//If we have reached here it means he can merge it now
	
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
	$tree[] = array('l' => $globals['index_url'].'tid='.$tid,
					'txt' => $topic);
					
	//Add the topic action link also
	$tree[] = array('l' => $globals['index_url'].'act=mergeposts&pid='.implode(',', $pids),
					'txt' => $l['merging_post']);
	
	//The forums theme
	forum_theme();	
	
	//Are we to use smileys ?
	if($globals['usesmileys']){
	
		if(!getsmileys()){
		
			return false;
		
		}
	
	}	
	
	
	//Alright I got the command
	if(isset($_POST['mergeposts'])){	
	
		
		//Check the ptime(actually the post in which everything is merged)
		if(!(isset($_POST['ptime'])) || trim($_POST['ptime']) == ""){
		
			$error[] = $l['no_time_selected'];
			
		}else{
			
			$npid = (int) inputsec(htmlizer(trim($_POST['ptime'])));
			
			//Is it a valid post
			if(!in_array($npid, array_keys($posts))){
			
				$error[] = $l['invalid_time_selected'];
			
			}
						
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'mergeposts_theme';
			return false;		
		}
		
		
		//Who sould be the poster
		if(!(isset($_POST['poster_id'])) || trim($_POST['poster_id']) == ""){
		
			$error[] = $l['no_poster'];
			
		}else{
			
			$poster_id = (int) inputsec(htmlizer(trim($_POST['poster_id'])));
			
			//Is it a valid poster
			if(!in_array($poster_id, array_keys($posters))){
			
				$error[] = $l['invalid_poster'];
			
			}
						
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'mergeposts_theme';
			return false;		
		}
		
		
		//check the post itself
		if(!(isset($_POST['post'])) || trim($_POST['post']) == ""){
			
			$error[] = $l['empty_post'];
			
		}else{
			
			//We are not trimming for smileys
			$post = inputsec(htmlizer($_POST['post']));
						
			$post = checkpost($post);
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'mergeposts_theme';
			return false;		
		}
		
		//Check if the damn field Title exists.
		if((isset($_POST['post_title'])) && strlen(trim($_POST['post_title'])) > 0){
		
			$post_title = inputsec(htmlizer(trim($_POST['post_title'])));
			
			$post_title = checktitle($post_title);
			
		}		
		
		
		//Check the smileys
		if(isset($_POST['usesmileys'])){
			
			$use_smileys = 1;
			
		}
		
		
		/////////////////////////////////
		// Finally lets start the queries
		// Effects of recycling a post : 
		// 1 - Update the post that will
		//     remain
		// 2 - Delete the other posts
		// 3 - Update topics table for 
		//	   last_post_id and -n post
		// 4 - Update users post count
		// 5 - Update forums post count
		// 6 - Update attachments
		/////////////////////////////////
		
		
		
		////////////////////////////////////
		// UPDATE the post that will remain
		////////////////////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['posts']."
						SET poster_id = '$poster_id',
						poster_ip = '".$posters[$poster_id][1]."',
						modtime = '".time()."',
						modifiers_id = '$modifiers_id',
						post = '$post',
	num_attachments = num_attachments + ".($num_attachments - $posts[$npid]['num_attachments'])."
						WHERE pid = '$npid'", false);
						
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['merge_error_title'], $l['merge_error']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);		
		
		
		$npids = array();
		
		$npids_str = '';
		
		$posters = array();
		
		//Count the posts and the new pid string
		foreach($posts as $k => $p){
			
			//No Guests
			if($p['poster_id'] != -1){
			
				if(empty($posters[$p['poster_id']])){
				
					$posters[$p['poster_id']]['id'] = $p['poster_id'];
					
					$posters[$p['poster_id']]['count'] = 1;
					
				}else{
								
					$posters[$p['poster_id']]['count'] = $posters[$p['poster_id']]['count'] + 1;
				
				}
			
			}
			
			//For the new string
			if($k != $npid){
			
				$npids[$k] = $k;
			
			}
		
		}		
		
		array_multisort($npids);
	
		$npids_str = implode(', ', $npids);
		
		if($poster_id != -1){
		
			$posters[$poster_id]['count'] = $posters[$poster_id]['count'] - 1;
			
		}		
				
		
		
		////////////////////
		// DELETE the posts
		////////////////////
		
		$qresult = makequery("DELETE FROM ".$dbtables['posts']."
						WHERE pid IN ($npids_str)", false);
						
		//How many were deleted ?
		$deleted = $deleted + mysql_affected_rows($conn);		
		
		//Were things deleted
		if($deleted != (count($npids))){
				
			reporterror($l['del_unrequired_posts_error_title'], $l['del_unrequired_posts_error']);
			
			return false;
			
		}
					
		//Free the resources
		@mysql_free_result($qresult);
		
		//GET the FIRST Pid
		$firstpost = first_post_topic($tid);			
		
		//GET the LAST Pid
		$lastpost = last_post_topic($tid);
		
		////////////////////////////////////////////
		// UPDATE the topics table for last_post_id
		// and -n(n number of posts) post
		////////////////////////////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['topics']." 
						SET n_posts = n_posts - ".$deleted.",
						first_post_id = ".$firstpost['pid'].",
						t_mem_id = ".$firstpost['poster_id'].",
						last_post_id = ".$lastpost['pid'].",
						mem_id_last_post = ".$lastpost['poster_id']."
						WHERE tid = '$tid'", false);
						
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['update_topic_error_title'], $l['update_topic_error']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		
		
		///////////////////////////////
		// UPDATE the users post count
		///////////////////////////////
		
		//Not for guests and should we increase
		if($board['inc_mem_posts']){
			
			//Loop through the posters as there may be many
			foreach($posters as $po => $pov){
			
				$qresult = makequery("UPDATE ".$dbtables['users']." 
								SET posts = posts - ".$pov['count']."
								WHERE id = '".$pov['id']."'", false);
								
				/*if(mysql_affected_rows($conn) < 1){
						
					reporterror('Merge Error' ,'The posts were merged but there were some errors in updating the users post count. Please Contact the <a href="mailto:'.$globals['board_email'].'">Administrator</a>.');
					
					return false;
					
				}*/
							
				//Free the resources
				@mysql_free_result($qresult);
			
			}
					
		}
		
		//GET the Last Pid from where its going
		$lastpost = last_post_forum($board['fid']);
		
		////////////////////////////////
		// UPDATE the forums post count
		////////////////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['forums']." 
						SET nposts = nposts - ".$deleted.",
						f_last_pid = ".$lastpost['pid']."
						WHERE fid = '".$board['fid']."'", false);
						
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['update_forum_error_title'], $l['update_forum_error']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		
		//////////////////////
		// Update attachments
		//////////////////////
		
		if(!empty($num_attachments)){
			
			$qresult = makequery("UPDATE ".$dbtables['attachments']."
						SET at_pid = '$npid'
						WHERE at_pid IN ($pids_str)", false);
						
			//Free the resources
			@mysql_free_result($qresult);
		
		}
		
		
		//Looks like everything went well
		//Redirect
		redirect('tid='.$tid);//IE 7 #redirect not working
		
		return true;
		
		
	}else{
	
		$theme['call_theme_func'] = 'mergeposts_theme';
	
	}
	
	
}

?>