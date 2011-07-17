<?php

//////////////////////////////////////////////////////////////
//===========================================================
// topics.php
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
// Topics Status Number Meanings
// 0 - Locked
// 1 - Normal
// 2 - Moved Link
///////////////////////////////////

/*	A list of Permissions to take care of.
* - Indicates Done
*	can_post_topic
*	can_post_polls //This is to start a Poll
*	notify_new_topics //Board Notificatons are allowedto this Group
	has_priviliges //Basically stands for certain priviliges a Moderator enjoys
*/

function topics(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $categories, $forums, $active, $activebots, $anonymous, $guests, $its_in_boards, $board, $topics, $sortby, $sortbylink, $order, $page, $tree, $postcodefield;

	//Load the Language File
	if(!load_lang('topics')){
	
		return false;
		
	}
	
	//The name of the file
	$theme['init_theme'] = 'topics';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Topics';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('topics_theme');	
								
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$topics = array();
	
	$ins = '';//Just for the query
		
	$active = array();
	
	$activebots = array();
	
	$anonymous = 0;
	
	$guests = 0;
	
	//He is viewing a forum
	$globals['last_activity'] = 'f';
	
	$tree = array();//Board tree for users location
	$tree[] = array('l' => $globals['index_url'],
					'txt' => $l['index']);
	
	$boardmoderators = array();//Array of every board moderators
	
	$inboards = array();//Array of every boards in_boards
	
	$activeusers = array();//Link array of active users
	
	$user['is_forum_subscribed'] = 0;
	
	//Array keys to sort the board
	$sort = array(1 => 't.topic',//Subject
					2 => 't.t_mem_id',//Starter
					3 => 't.n_posts',//Replies
					4 => 't.n_views',//Views
					5 => 'p.pid');//time
	
	$orderby = array(1 => 'ASC',
					2 => 'DESC');
	
	//Checks the Forum id is set or no
	if(!isset($_GET['fid']) && trim($_GET['fid'])!==""){
	
		//Show a major error and return
		reporterror($l['no_forum_specified_title'], $l['no_forum_specified']);
			
		return false;
	
	}else{
	
		$fid = (int) inputsec(htmlizer(trim($_GET['fid'])));
	
	}
	
	//Checks the Page to see
	$page = get_page('bpg', $globals['maxtopics']);
	
	
	//////////////////////////////////////
	// You must take care of every GET VAR
	// in a GET FORM.
	//////////////////////////////////////
	
	
	//Checks to sort the Forum by............
	if(isset($_GET['sortby']) && trim($_GET['sortby']) != "" && is_numeric(trim($_GET['sortby']))){
		
		$sortbytmp = (int) inputsec(htmlizer(trim($_GET['sortby'])));
		
		if(array_key_exists($sortbytmp, $sort)){
		
			$sortby = $sort[$sortbytmp];
			
			$sortbylink = $sortbytmp;
		
		}else{
		
			$sortby = $sort[5];
		
		}
	
	}else{
		
		$sortby = $sort[5];
		
	}
	
	
	//ASCENDING or DESCENDING
	if(isset($_GET['order']) && trim($_GET['order']) != "" && is_numeric(trim($_GET['order']))){
		
		$ordertmp = (int) inputsec(htmlizer(trim($_GET['order'])));
		
		if(array_key_exists($ordertmp, $orderby)){
			
			$order = $orderby[$ordertmp];			
			
		}else{
		
			$order = $orderby[2];
		
		}
	
	}else{
		
		$order = $orderby[2];
		
	}
	
	
	//Load the board
	if(!default_of_nor()){
	
		return false;
	
	}
	
	
	//Beneath all VARS are to handle and store the IN_Boards of the editing forum
	$its_in_boards = array();
	
	$its_board_level = "";
	
	$trap_in = false;
	
	//This is to find which forum is it that the user is viewing
	foreach($forums as $c => $cv){
	
		//The main forum loop
		foreach($forums[$c] as $f => $v){
						
			if($forums[$c][$f]['board_level'] == $its_board_level || 
				$forums[$c][$f]['board_level'] < $its_board_level ){
				
				$trap_in = false;
				
			}
			
			if($trap_in && $forums[$c][$f]['board_level'] == ($its_board_level + 1)){
			
				$its_in_boards[] = $forums[$c][$f];
			
			}
			
			if($forums[$c][$f]['fid'] == $fid){
			
				$board = $forums[$c][$f];
				
				$its_board_level = $forums[$c][$f]['board_level'];
				
				$trap_in = true;
				
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
	
	//Is the board locked
	if($board['status'] == 0){
	
		
	
	}
	
	//Are there any rules
	if(!empty($board['frules'])){
		
		$board['frules'] = unhtmlentities($board['frules']);
		
		if(!empty($board['frulestitle'])){
		
			$board['frulestitle'] = $board['frulestitle'];
		
		}else{
		
			$board['frulestitle'] = $l['forum_rules'];
		
		}
		
	}
	
	
	//He is viewing this forum
	$globals['activity_id'] = $fid;
	
	$globals['activity_text'] = $board['fname'];
	
	
	//Now a Quick Moderation fix
	if(isset($_POST['withselected']) && !empty($_POST['tids']) && is_array($_POST['tids'])){

		$tids = implode(',', $_POST['tids']);
		
		$withselected = inputsec(htmlizer(trim($_POST['withselected'])));
		
		switch($withselected){
		
			case 'pin':
			$redirect = 'act=pintopic&do=1&topid='.$tids;
			break;
			
			case 'unpin':
			$redirect = 'act=pintopic&do=0&topid='.$tids;
			break;
			
			case 'lock':
			$redirect = 'act=locktopic&do=0&topid='.$tids;
			break;
			
			case 'unlock':
			$redirect = 'act=locktopic&do=1&topid='.$tids;
			break;
			
			case 'merge':
			$redirect = 'act=mergetopics&do=merge&forum='.$fid.'&topid='.$tids;
			break;
			
			case 'move':
			$redirect = 'act=movetopic&topid='.$tids;
			break;
			
			case 'delete':
			$redirect = 'act=deletetopic&topid='.$tids;
			break;
			
		
		}
		
		if(!empty($redirect)){
		
			redirect($redirect);//IE 7 #redirect not working
			
			return true;
		
		}
	
	}
	
	
	//Lets make the tree
	//First the category
	$tree[] = array('l' => $globals['index_url'].'#cid'.$board['cat_id'],
					'txt' => $categories[$board['cat_id']]['name']);
					
	//Now the forums location
	$cid = $board['cat_id'];
	
	$tree_fid = $fid;
	
	$temp_r = array();
	
	//Insert this board in the temp array
	$temp_r[] = $fid;
	
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
	
	
	//Put in the inboards
	$board['in_boards'] = $its_in_boards;
	
	//The loop of the inboards which have inboards
	foreach($board['in_boards'] as $i => $iv){
		
		$board['in_boards'][$i]['description'] = unhtmlentities($board['in_boards'][$i]['description']);
		
		//The last posted topics last page calculation
		$tmp = ceil(($iv['n_posts'] + 1)/$globals['maxpostsintopics']);
		//echo $tmp;

		//Insert the page number
		$board['in_boards'][$i]['last_page'] = $tmp;
									
		
		//Datify the time stamp
		$board['in_boards'][$i]['pdate'] = datify($iv['ptime']);
		
		
		
	}//End of main loop
	
	//Is he a Moderator then load his permissions
	if(!is_mod()){
		
		return false;
	
	}
		
	//Just for the query
	$uid = ($logged_in ? $user['id'] : -1);
	
	//Get out the topics in this board
	$qresult = makequery("SELECT DISTINCT t.*,p.*, ts.username AS starter, u.username, 
			rt.rt_time, mr.mr_time, rb.rb_time, nf.notify_mid
			FROM ".$dbtables['topics']." t
			LEFT JOIN ".$dbtables['posts']." p ON (t.tid = p.post_tid AND p.pid = t.last_post_id) 
			LEFT JOIN ".$dbtables['users']." ts ON (ts.id = t.t_mem_id)
			LEFT JOIN ".$dbtables['users']." u ON (u.id = p.poster_id)
			LEFT JOIN ".$dbtables['read_topics']." rt ON (t.tid = rt.rt_tid AND 
															rt.rt_uid = '".$uid."')
			LEFT JOIN ".$dbtables['mark_read']." mr ON (p.post_fid = mr.mr_fid AND 
															mr.mr_uid = '".$uid."')
			LEFT JOIN ".$dbtables['read_board']." rb ON (rb.rb_uid = '".$uid."')
			LEFT JOIN ".$dbtables['notify_forum']." nf ON (nf.notify_mid = '".($logged_in ? $user['id'] : "-1")."' AND nf.notify_fid = '$fid')
			WHERE t.t_bid = '$fid'
			ORDER BY t.t_sticky DESC, ".$sortby." ".$order."
			LIMIT $page, ".$globals['maxtopics']);
		
	if(mysql_num_rows($qresult) < 1){
		
		//If it is not the first page - then you specified an invalid link
		if($page > 0){
	
			//Show a major error and return
			reporterror($l['no_forum_page_title'], $l['no_forum_page']);
				
			return false;
			
		}
	
	//Lets bring out the topics
	}else{	
		
		//Alright boys the result is out lets put it in the topics array()
		for($t=1; $t <= mysql_num_rows($qresult); $t++){
		
			$topics[$t] = mysql_fetch_assoc($qresult);
			
			if(!empty($topics[$t]['notify_mid'])){
		
				$user['is_forum_subscribed'] = 1;
			
			}
			
		}		
		
		//Free the resources
		@mysql_free_result($qresult);		
			
		unset($row);		
		
	}
	
	///////////////////////////////
	// Save the user read the forum
	///////////////////////////////
	
	if(!read_forum($board['fid'], time())){
	
		return false;
	
	}
		
	//The forums theme
	forum_theme();

	
	//$tv is used because it prevents errors on unset of a topic
	foreach($topics as $t => $tv){
				
		
		//////////////////////////////////////
		// Find out is the topic new for user
		//////////////////////////////////////
		
		$is_new = 0;				
			
		if($logged_in){
		
			$tmp_r = array($topics[$t]['ptime']);
			
			//If I read the topic before
			if(isset($topics[$t]['rt_time']) && 
				!empty($topics[$t]['rt_time'])){
			
				$tmp_r[] = $topics[$t]['rt_time'];
			
			}
			
			
			//If i marked the whole forum as read before
			if(isset($topics[$t]['mr_time']) && 
				!empty($topics[$t]['mr_time'])){
			
				$tmp_r[] = $topics[$t]['mr_time'];
			
			}
			
			//If i marked the whole Board as read before
			if(isset($topics[$t]['rb_time']) && 
				!empty($topics[$t]['rb_time'])){
			
				$tmp_r[] = $topics[$t]['rb_time'];
			
			}
			
			//If the max is the new post time only and I did not post last
			if((max($tmp_r) == $topics[$t]['ptime']) && 
				($topics[$t]['poster_id'] != $user['id'])){
			
				$is_new = 1;
			
			}
		
		}
			
		//Push it in the array
		@$topics[$t]['is_new'] = $is_new;
			
		
		//The date thingy
		$topics[$t]['ptime'] = datify($topics[$t]['ptime']);
		
		
		//The last page calculation
		$tmp = ceil(($topics[$t]['n_posts'] + 1)/$globals['maxpostsintopics']);
		//echo $tmp;
		
		//Push it in the array
		@$topics[$t]['last_page'] = $tmp;
		
		
		
		/////////////////////////////
		// Show the number of pages
		/////////////////////////////
		
		if($tmp > 1){
			
			$top_pages = array();
			
			for($i = 1; $i <= (($tmp > 5) ? 5 : $tmp); $i++){
			
				$top_pages[] = '<a href="'.topiclink($tv['tid'], $tv['topic'], $i).'" >'.$i.'</a>';
			
			}
		
			if($tmp > 5){
				
				$top_pages[] = ' . . . ';
				
				$top_pages[] = '<a href="'.topiclink($tv['tid'], $tv['topic'], $tmp).'" >'.$tmp.'</a>';
			
			}
			
			$topics[$t]['pages'] = implode(' ', $top_pages);
					
		}
		
		
		/////////////////////////////////
		// Decide about the topic icons
		// It is a four digit number.
		// Meaning of number by position
		// 1 - Hot(1) or Normal(0)
		// 2 - Poll(1) or Topic(0)
		/////////////////////////////////
		
		//Is it a hot or a normal topic
		if($topics[$t]['n_posts'] >= $globals['maxreplyhot']){
			
			$topics[$t]['type'] = '1';			
			
		}else{
		
			$topics[$t]['type'] = '0';
		
		}
		
		
		//Is it a poll or just a topic
		if($topics[$t]['poll_id']){
		
			$topics[$t]['type'] .= '1';
			
		}else{
		
			$topics[$t]['type'] .= '0';
		
		}
		
		
		//Is it locked or no
		if($topics[$t]['t_status'] == 0){
		
			$topics[$t]['type'] = 'closed';
			
		}
		
		
		//Is it stickied
		if ($topics[$t]['t_sticky']){
		
			$topics[$t]['type'] = 'pinned';
			
		}
			
		
		//But if it is moved just moved
		if($topics[$t]['t_status'] == 2){
		
			$topics[$t]['type'] = 'moved';
		
		}
		
		
		/////////////////////////////
		// Give the necessary prefix
		/////////////////////////////
		
		//Is it a poll or just a topic
		if($topics[$t]['poll_id']){
		
			$topics[$t]['t_prefix'] = $globals['prefixpolls'];
			
		}
		
		
		//Is it stickied
		if ($topics[$t]['t_sticky']){
		
			$topics[$t]['t_prefix'] = $globals['prefixsticky'];
			
		}
			
		
		//But if it is moved just moved
		if($topics[$t]['t_status'] == 2){
		
			$topics[$t]['t_prefix'] = $globals['prefixmoved'];
		
		}
		
		
		//If a post is made by a guest then no username will be there
		if(empty($topics[$t]['username'])){
		
			$topics[$t]['username'] = $l['guest'];
		
		}
		
				
	}//end for loop
		
	//Get the second of the day start
	$timestamp = mktime(0, 0, 0);
	
	//Active time limit
	$activetime = time() - ($globals['last_active_span']*60);
	
	//Get who is active
	$qresult = makequery("SELECT DISTINCT s.uid, s.ip, u.id, u.username, s.anonymous, 
				ug.mem_gr_colour
				FROM ".$dbtables['sessions']." s
				LEFT JOIN ".$dbtables['users']." u ON (s.uid = u.id)
				LEFT JOIN ".$dbtables['user_groups']." ug ON (u.u_member_group = 
															ug.member_group)
				WHERE s.last_activity = 'f'
				AND activity = '$fid|".$board['fname']."'
				AND s.time > '$activetime'
				ORDER BY s.time DESC, u.username ASC");
	
	//Where is everybody ?
	if(mysql_num_rows($qresult) > 0){	
		
		$totalactive = mysql_num_rows($qresult);
		
		for($i = 1; $i <= $totalactive; $i++){
			
			$row = mysql_fetch_assoc($qresult);
			
			//Is the user a Guest
			if(!empty($row['id'])){
				
				//So he is anonymous - should we show him ?
				if($row['anonymous'] && !$user['view_anonymous']){
				
					$anonymous = $anonymous + 1;
				
				}else{
				
					$active[$row['id']] = $row;
				
				}
				
			}else{
			
				$guests = $guests + 1;
				
				//Is it a bot
				if($row['uid'] < -100){
				
					if(empty($activebots[$row['uid']])){
					
						$activebots[$row['uid']] = 1;
					
					}else{
					
						$activebots[$row['uid']] += 1;
						
					}
				
				}
			
			}
			
		}		
	
	}
	
	//Now due to late saving of sessions
	if($logged_in && empty($active[$user['id']])){
	
		$active[] = array('uid' => $user['id'],
							'id' => $user['id'], 
							'username' => $user['username'],
							'anonymous' => $user['anonymous'], 
							'mem_gr_colour' => $user['mem_gr_colour']);
	
	}elseif(!$logged_in && $guests < 1){
	
		$guests = $guests + 1;
	
	}
	
	foreach($activebots as $k => $v){
			
		$botname = botname($k);
		
		if(!empty($botname)){
		
			$activebots[$k] = $botname.'('.$v.')';
			
		}else{
		
			unset($activebots[$k]);
		
		}
	
	}
	
	$postcodefield = '<input type="hidden" value="'.generateRandStr(16).'" name="postcode" />';
	
	$theme['call_theme_func'] = 'topics_theme';
	
}


?>