<?php


//////////////////////////////////////////////////////////////
//===========================================================
// mergetopics.php
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

	
function mergetopics(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
	
	//Load the Language File
	if(!load_lang('mergetopics')){
	
		return false;
		
	}
	
	//The name of the file
	$theme['init_theme'] = 'mergetopics';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Merge Topics';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('select_theme', 'merge_theme');
	
	//My activity
	$globals['last_activity'] = 'met';
	
	
	//What are we to do
	if(isset($_GET['do']) && trim($_GET['do'])!==""){
	
		$do = inputsec(htmlizer(trim($_GET['do'])));
		
	}else{
	
		$do = "";
		
	}
	
	
	switch($do){
	
		//He wants to select one by one
		case 'select': default:
		select();
		break;
		
		//He wants to merge
		case 'merge':
		merge();
		break;
		
	}

}



//The first time to select other topics to merge.
function select(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $categories, $forums, $fid, $error, $tid, $board, $starters, $topics, $mother_options;
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$ftid = 0;
	
	
	//Initial/First Topic
	if(isset($_GET['ftid']) && trim($_GET['ftid'])!==""){
	
		$ftid = (int) inputsec(htmlizer(trim($_GET['ftid'])));
		
	}else{
	
		//Show a major error and return
		reporterror('No Topic specified' ,'Sorry, we were unable to process your request because no topic was specified. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.');
			
		return false;
		
	}
	
	
	//Bring the topics out
	$qresult = makequery("SELECT t.tid, t.topic, t.t_bid, u.username AS starter
			FROM ".$dbtables['topics']." t
			LEFT JOIN ".$dbtables['users']." u ON (u.id = t.t_mem_id)
			WHERE tid = '$ftid'");
	
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror('No Topic Found' ,'Sorry, we were unable to process your request because the topic you submitted was not found in the database. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.');
		
		return false;
	
	}
	
	$topic = mysql_fetch_assoc($qresult);
	
	$fid = $topic['t_bid'];
		
	//Free the resources
	@mysql_free_result($qresult);	
	
	
	//Load the boards
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
		reporterror('No forum found' ,'The forum you specified either does not exists or you are not authorised to view the same. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.');
			
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
		
	
	///////////////////////////////
	// Note: A moderator can merge 
	// topics only in his forum.
	///////////////////////////////
	
	//Can he MERGE the topics
	if(!$user['can_merge_topics']){

		//Show a major error and return
		reporterror('Access Denied' ,'Sorry, you are not allowed to merge the topics as you do not have the permissions to do so. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.');
			
		return false;
	
	}
	
	
	/////////////////////////////////////
	// Find the Forums that can be given
	/////////////////////////////////////
	
	if($user['member_group'] != 3){
	
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
	
	}
	
	$theme['call_theme_func'] = 'select_theme';

}



//This is the main function that will merge it up
function merge(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $categories, $forums, $fid, $error, $tid, $board, $starters, $topics, $tree;
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	//Post VARS
	$modtime = time();
	
	$modifiers_id = ($logged_in ? $user['id'] : -1);
	
	$num_attachments = 0;
	
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
	
	$n_views = 0;
	
	$poll_id = 0;
	
	$has_attach = 0;
	
	$poll_tids = array();//Array of tids having polls
	
	$starter = array();
	
	$attachments = array();
	
	$attach_pids = array();//Array of pids having attachments
	
	$tree = array();//Board tree for users location
	$tree[] = array('l' => $globals['index_url'],
					'txt' => $l['index']);
	
	//Destination forum
	if(isset($_GET['forum']) && trim($_GET['forum'])!==""){
	
		$fid = inputsec(htmlizer(trim($_GET['forum'])));
		
	}else{
	
		//Show a major error and return
		reporterror($l['no_forum_specified_title'], $l['no_forum_specified']);
			
		return false;
		
	}
	
	//Load the boards
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
		
	
	///////////////////////////////
	// Note: A moderator can merge 
	// topics only in his forum.
	///////////////////////////////
	
	//Can he MERGE the topics
	if(!$user['can_merge_topics']){

		//Show a major error and return
		reporterror($l['no_merge_permissions_title'], $l['no_merge_permissions']);
			
		return false;
	
	}
	
	
	//Get the tids to merge
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
		
			$invalid[] = trim($v);
		
		}
		
	}
	
	
	//Did we get some invalid ones
	if(!empty($invalid)){
	
		//Show a major error and return
		reporterror($l['invalid_topic_specified_title'], 
					lang_vars($l['invalid_topic_specified'], array(implode(', ', $invalid))));
			
		return false;
	
	}
	
	//Make them unique also
	$tids = array_unique($tids);
	
	array_multisort($tids);
	
	$tids_str = implode(', ', $tids);
	
	
	//Bring the topics out
	$qresult = makequery("SELECT t.tid, t.topic, t.t_bid, t.n_posts, t.n_views, 
			t.t_mem_id AS starter, t.poll_id, t.has_attach, u.username
			FROM ".$dbtables['topics']." t
			LEFT JOIN ".$dbtables['users']." u ON (u.id = t.t_mem_id)
			WHERE tid IN ($tids_str)");
	
	if(mysql_num_rows($qresult) < 1){
	
		//Show a major error and return
		reporterror($l['no_topic_found_title'], $l['no_topic_found']);
		
		return false;
	
	//Are the number of posts less than the tids 	
	}elseif(mysql_num_rows($qresult) != count($tids)){
	
		//Show a major error and return
		reporterror($l['some_topic_not_found_title'], $l['some_topic_not_found']);
		
		return false;
		
	//Is there only one topic
	}elseif(mysql_num_rows($qresult) < 2){
	
		//Show a major error and return
		reporterror($l['one_topic_specified_title'], $l['one_topic_specified']);
			
		return false;
	
	}	
	
	
	for($i = 1; $i <= mysql_num_rows($qresult); $i++){
		
		$row = mysql_fetch_assoc($qresult);
		
		$topics[$row['tid']] = $row;
		
		$fids[] = $row['t_bid'];
		
		$n_views = $n_views + $row['n_views'];
		
		$starters[$row['starter']] = $row['starter'];
		
		//Are there any polls
		if(!empty($row['poll_id'])){
		
			$poll_tids[] =  $row['tid'];
			
			$poll_id = $row['poll_id'];
	
		}
		
		//Does any topic have an attachment
		if($row['has_attach']){
		
			$has_attach = $has_attach + $row['has_attach'];
		
		}
					
	}
	
		
	//Free the resources
	@mysql_free_result($qresult);
		
	
	//Check are they of the same forum or no(For Moderators only)
	if($user['member_group'] == 3){
		
		foreach($fids as $f){
			
			//If any one topics forums id is not the same as moderators fid
			if($f != $fid){
			
				$report = true;
			
			}
		
		}
		
		if(!empty($report)){
		
			//Show a major error and return
			reporterror($l['not_same_forum_title'], $l['not_same_forum']);
			
			return false;
		
		}
		
	}
	
	
	//One poll allowed only
	if(count($poll_tids) > 1){
	
		//Show a major error and return
		reporterror($l['too_many_polls_title'], $l['too_many_polls']);
			
		return false;
	
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
	
	
	//Add the link also
	$tree[] = array('l' => $globals['index_url'].'act=mergetopics&do=merge&forum='.$fid.'&topid='.implode(',', $tids),
					'txt' => $l['merging_topics']);
	
	
	//Alright I got the command
	if(isset($_POST['merge'])){	
	
		
		//Check the title(actually the topic in which everything is merged)
		if(!(isset($_POST['topic'])) || trim($_POST['topic']) == ""){
		
			$error[] = $l['no_title_selected'];
			
		}else{
			
			$ntid = (int) inputsec(htmlizer(trim($_POST['topic'])));
			
			//Is it a valid topic
			if(!in_array($ntid, array_keys($topics))){
			
				$error[] = $l['invalid_title_selected'];
			
			}
						
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'merge_theme';
			return false;		
		}
		
		
		//Check the starter
		if(!(isset($_POST['t_mem_id'])) || trim($_POST['t_mem_id']) == ""){
		
			$error[] = $l['no_starter'];
			
		}else{
			
			$t_mem_id = (int) inputsec(htmlizer(trim($_POST['t_mem_id'])));
			
			//Is it a valid starter
			if(!in_array($t_mem_id, $starters)){
			
				$error[] = $l['invalid_starter'];
			
			}
						
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'merge_theme';
			return false;		
		}
		
		
		/////////////////////////////////
		// Finally lets start the queries
		// Effects of recycling a post : 
		// 1 - Update the topic that will
		//     remain
		// 2 - Delete the other topics
		// 3 - Update the posts for topic
		//     and forum
		// 4 - Update the attachments
		// 5 - Update the polls	
		// 6 - Update forums topic, post count
		//     a)From where it is going
		//     b)Where it is going
		// 7 - Delete read_topics
		// 8 - Delete notify_topic
		/////////////////////////////////
		
		
		$ntids = array();
		
		$ntids_str = '';
		
		$fids = array();
		
		//Count the posts and the new pid string
		foreach($topics as $k => $t){
			
			//For the new string
			if($k != $ntid){
			
				$ntids[$k] = $k;
			
			}
			
			if(empty($fids[$t['t_bid']])){
			
				$fids[$t['t_bid']]['fid'] = $t['t_bid'];
				
				$fids[$t['t_bid']]['nposts'] = $t['n_posts'] + 1;
				
				$fids[$t['t_bid']]['ntopic'] = 1;
				
			}else{
				
				$fids[$t['t_bid']]['nposts'] = $fids[$t['t_bid']]['nposts'] + ($t['n_posts'] + 1);
				
				$fids[$t['t_bid']]['ntopic'] = $fids[$t['t_bid']]['ntopic'] + 1;
				
			}
		
		}		
		
		array_multisort($ntids);
	
		$ntids_str = implode(', ', $ntids);
		
		
		////////////////////
		// DELETE the topics
		////////////////////
		
		$qresult = makequery("DELETE FROM ".$dbtables['topics']."
						WHERE tid IN ($ntids_str)", false);
						
		//How many were deleted ?
		$deleted = $deleted + mysql_affected_rows($conn);		
		
		//Were things deleted
		if($deleted != (count($ntids))){
				
			reporterror($l['del_unrequired_topic_error_title'], $l['del_unrequired_topic_error']);
			
			return false;
			
		}
					
		//Free the resources
		@mysql_free_result($qresult);
		
		
		////////////////////
		// UPDATE the posts
		////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['posts']."
						SET post_tid = '$ntid',
						post_fid = '$fid'
						WHERE pid IN ($pids_str)", false);
						
		
		//Were things updated			
		//if($updated != (count($posts) - ($topics[$ntid]['n_posts'] + 1))){
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['update_posts_error_title'], $l['update_posts_error']);
			
			return false;
			
		}
				
		
		//GET the FIRST Pid
		$firstpost = first_post_topic($ntid);			
		
		//GET the LAST Pid
		$lastpost = last_post_topic($ntid);
			
		////////////////////
		// UPDATE the topic 
		////////////////////
		
		$qresult = makequery("UPDATE  ".$dbtables['topics']." 
						SET t_bid = '$fid',
						n_posts =  '".(count($posts) - 1)."',
						n_views = '".$n_views."',
						t_mem_id = '$t_mem_id',
						poll_id = '$poll_id',
						has_attach = '$has_attach',
						first_post_id = ".$firstpost['pid'].",
						last_post_id = ".$lastpost['pid'].",
						mem_id_last_post = ".$lastpost['poster_id']."
						WHERE tid = '$ntid'");
		
					
		if( mysql_affected_rows($conn) < 1 ){
			
			reporterror($l['topic_update_error_title'], $l['topic_update_error']);
			
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
		
			$qresult = makequery("UPDATE ".$dbtables['attachments']."
					SET at_fid = '$fid'
					WHERE at_pid IN ($at_pids_str)", false);
					
			if(mysql_affected_rows($conn) < 1){
		
				//A mechanism to report error
							
			}
		
		}
		
		
		////////////////////////////////////////
		// UPDATE the polls, options and voters
		////////////////////////////////////////
		
		$qresult = makequery("UPDATE ".$dbtables['polls']." 
						SET poll_tid = '$ntid'
						WHERE poid = '$poll_id'", false);
						
		if(mysql_affected_rows($conn) < 1){
				
			//Error reporting system still to come
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		
		
		////////////////////////////////
		// UPDATE the forums post count
		//  a)From where it is going
		////////////////////////////////
		
		foreach($fids as $k => $f){			
		
			//GET the Last Pid from where its going
			$lastpost = last_post_forum($f['fid']);
		
			$qresult = makequery("UPDATE ".$dbtables['forums']." 
							SET nposts = nposts - ".$f['nposts'].",
							ntopic = ntopic - ".$f['ntopic'].",
							f_last_pid = ".$lastpost['pid']."
							WHERE fid = '".$f['fid']."'", false);
							
			if(mysql_affected_rows($conn) < 1){
					
				reporterror($l['update_forum_error_title'], $l['update_forum_error']);
				
				return false;
				
			}
			
			//Free the resources
			@mysql_free_result($qresult);
			
		}
		
				
		//GET the Last Pid to where its going
		$lastpost = last_post_forum($fid);
		
		////////////////////////////////
		// UPDATE the forums post count
		//  b)Where it is going(topic also)
		////////////////////////////////		
		
		$qresult = makequery("UPDATE ".$dbtables['forums']." 
						SET nposts = nposts + ".(count($posts)).",
						ntopic = ntopic + 1,
						f_last_pid = ".$lastpost['pid']."
						WHERE fid = '$fid'", false);
						
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['update_dest_forum_error_title'], $l['update_dest_forum_error']);
			
			return false;
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		
		////////////////////////////
		// DELETE read_topics table
		////////////////////////////		
		
		$qresult = makequery("DELETE FROM ".$dbtables['read_topics']." 
						WHERE rt_tid IN ($tids_str)", false);
						
		if(mysql_affected_rows($conn) < 1){
				
			//Error reporting system still to come
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		
		////////////////////////////
		// DELETE notify_topic table
		////////////////////////////		
		
		$qresult = makequery("DELETE FROM ".$dbtables['notify_topic']." 
						WHERE notify_tid IN ($tids_str)", false);
						
		if(mysql_affected_rows($conn) < 1){
				
			//Error reporting system still to come
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		
		//Looks like everything went well
		//Redirect
		redirect('tid='.$ntid);//IE 7 #redirect not working
		
		return true;
	
		
	}else{
	
		$theme['call_theme_func'] = 'merge_theme';
	
	}
	
}	
	
	
	
?>