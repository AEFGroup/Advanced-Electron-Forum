<?php

//////////////////////////////////////////////////////////////
//===========================================================
// posts.php
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

function posts(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $categories, $forums, $active, $activebots, $anonymous, $guests, $board, $poll, $user_group, $post_group, $tid, $tpg, $fid, $title, $topic, $post, $topicpages, $pg, $attachments,$page, $tree;
global $smileys, $smileycode, $smileyimages;
global $postcodefield, $postcode, $pid, $fpid, $users_who_read;
	
	//Load the Language File
	if(!load_lang('posts')){
	
		return false;
		
	}
		
	//The name of the file
	$theme['init_theme'] = 'posts';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Posts';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('posts_theme', 'thread_theme', 'printtopic_theme');
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$topic = array();
	
	$title = '';
	
	$tid = 0;
	
	$post = array();
	
	$active = array();
	
	$activebots = array();
	
	$anonymous = 0;
	
	$guests = 0;
	
	$attachments = array();
	
	$attach = array();
	
	$poll = array();
	
	$polloptions = array();
	
	$adpolloptions = array();
	
	//He is viewing a topic
	$globals['last_activity'] = 't';
	
	$tree = array();//Board tree for users location
	$tree[] = array('l' => $globals['index_url'],
					'txt' => $l['index']);
					
	$boardmoderators = array();//Array of every board moderators
	
	$activeusers = array();//Link array of active users
	
	$mode = '';//The mode that the user is seeing it
	
	$user['is_topic_subscribed'] = 0;
	
	$users_who_read = array();
	
	//Quick Moderation jumper
	if(isset($_POST['withselected']) && !empty($_POST['pids']) && is_array($_POST['pids'])){

		$pids = implode(',', $_POST['pids']);
		
		$withselected = inputsec(htmlizer(trim($_POST['withselected'])));
		
		switch($withselected){
					
			case 'delete':
			$redirect = 'act=delete&pid='.$pids;
			break;
			
			case 'merge':
			$redirect = 'act=mergeposts&pid='.$pids;
			break;
		
		}
		
		if(!empty($redirect)){
		
			redirect($redirect);
			
			return true;
		
		}
	
	}
	
	//Checks the topic id is set or no
	if(trim($_GET['tid']) == "" || !is_numeric(trim($_GET['tid']))){
	
		//Show a major error and return
		reporterror($l['no_topic_specified_title'], $l['no_topic_specified']);
			
		return false;
	
	}else{
	
		$tid = (int) inputsec(htmlizer(trim($_GET['tid'])));
		
		if(empty($tid)){
		
			//Redirect
			redirect('');
			
			return false;
		
		}
	
	}
	
	
	//Are we to show all the topics
	if(isset($_GET['tpg'])){
		
		if(trim($_GET['tpg']) == 'all'){
			
			$page = 'all';
	
		}else{
	
			//Checks the Page to see
			$page = get_page('tpg', $globals['maxpostsintopics']);
		
		}
		
	}else{
	
		//Checks the Page to see
		$page = get_page('tpg', $globals['maxpostsintopics']);
	
	}
	
	
	//////////////////////////////////
	// Modes:
	// ''(empty) - Normal
	// print - Print Topic
	// thread - Threaded Topic
	//////////////////////////////////
	
	if(isset($_GET['nor'])){
		
		$_COOKIE[$globals['cookie_name']]['threaded'] = 'off';
	
		//Remove COOKIE for threaded mode
		@setcookie($globals['cookie_name'].'[threaded]', '', (time()-(60*60*24*365)), '/');
	
	}
	
	//Which mode is it.
	if(isset($_GET['printtopic'])){
	
		$mode = 'print';
	
	}elseif(isset($_GET['threaded']) || (isset($_COOKIE[$globals['cookie_name']]['threaded']) && $_COOKIE[$globals['cookie_name']]['threaded'] == 'on')){
	
		$mode = 'thread';
		
		$page = 'all';
		
		//Set a COOKIE for threaded mode
		@setcookie($globals['cookie_name'].'[threaded]', 'on', (time()+(60*60*24*365)), '/');
	
	}

	
	//Load the board
	if(!default_of_nor(false)){
	
		return false;
	
	}
	

	//Bring the topic info
	$qresult = makequery("SELECT DISTINCT t.*, p.*,ug.mem_gr_name,ug.image_name,ug.image_count, 
			ug.mem_gr_colour, per.allow_html, u.id, u.username, u.email, u.posts, 
			u.u_member_group, u.users_text,	u.avatar, u.avatar_type, u.avatar_width, 
			u.avatar_height, mo.username AS modifier, s.uid AS status, u.location, u.www, 
			u.timezone, u.icq, u.aim, u.yim, u.msn, u.hideemail, u.sig, nf.notify_mid
			FROM ".$dbtables['topics']." t, ".$dbtables['posts']." p
			LEFT JOIN ".$dbtables['users']." u ON (u.id = p.poster_id)
			LEFT JOIN ".$dbtables['user_groups']." ug ON (ug.member_group = u.u_member_group)
			LEFT JOIN ".$dbtables['permissions']." per ON (per.member_group_id = u.u_member_group)
			LEFT JOIN ".$dbtables['users']." mo ON (p.modifiers_id = mo.id)
			LEFT JOIN ".$dbtables['sessions']." s ON (p.poster_id = s.uid)
			LEFT JOIN ".$dbtables['notify_topic']." nf ON (nf.notify_mid = '".($logged_in ? $user['id'] : "-1")."' AND nf.notify_tid = '$tid')
			WHERE t.tid='$tid' AND p.post_tid = '$tid'
			ORDER BY ptime ASC
			".(!is_numeric($page) ? "" : "LIMIT $page, ".$globals['maxpostsintopics']));
			
	if(mysql_num_rows($qresult) < 1){
		
		//Show a major error and return
		reporterror($l['no_topic_page_title'], $l['no_topic_page']);
				
		return false;
	
	}
	
	//Get the posts
	for($p = 0; $p < mysql_num_rows($qresult); $p++){
		
		$row = mysql_fetch_assoc($qresult);
		
		$row['post_count'] = (!is_numeric($page) ? 0 : $page) + $p;
		
		$post[$row['pid']] = $row;
		
		if(!empty($row['notify_mid'])){
		
			$user['is_topic_subscribed'] = 1;
		
		}
		
	}	
	
	//Free the resources
	@mysql_free_result($qresult);	
	
	$tmp = current($post);
	
	$title = $tmp['topic'];
	
	$topic = array('tid' => $tmp['tid'],
				'topic' => $tmp['topic'],
				'description'=> $tmp['t_description'],
				't_bid' => $tmp['t_bid'],
				't_status' => $tmp['t_status'],
				'n_posts' => $tmp['n_posts'],
				'n_views' => $tmp['n_views'],
				'type_image' => $tmp['type_image'],
				't_mem_id' => $tmp['t_mem_id'],
				'poll_id' => $tmp['poll_id'],
				't_sticky' => $tmp['t_sticky'],
				'first_post_id' => $tmp['first_post_id'],
				'last_post_id' => $tmp['last_post_id'],
				'mem_id_last_post' => $tmp['mem_id_last_post'],
				'has_attach' => $tmp['has_attach'],
				);
				
	$fpid = $tmp['pid'];//Thread mode tweak
	
	unset($tmp);
	
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
		reporterror($l['no_forum_title'], $l['no_forum']);
			
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
	
	//Are we to redirect to a previous topic
	if(isset($_GET['previous'])){
	
		//Make the Query
		$qresult =  makequery("SELECT tid FROM `".$dbtables['topics']."`
				WHERE tid < $tid
				AND t_bid = '".$board['fid']."'
				ORDER BY tid DESC				
				LIMIT 0, 1");
				
		if(mysql_num_rows($qresult) > 0){
			
			$previous = mysql_fetch_assoc($qresult);
			
			//Redirect
			redirect('tid='.$previous['tid']);
						
		}
		
	//Are we to redirect to a previous topic
	}elseif(isset($_GET['next'])){
	
		//Make the Query
		$qresult =  makequery("SELECT tid FROM `".$dbtables['topics']."`
				WHERE tid > $tid
				AND t_bid = '".$board['fid']."'
				ORDER BY tid ASC				
				LIMIT 0, 1");
				
		if(mysql_num_rows($qresult) > 0){
			
			$next = mysql_fetch_assoc($qresult);
			
			//Redirect
			redirect('tid='.$next['tid']);
						
		}
	
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
	$tree[] = array('l' => $globals['index_url'].'tid='.$tid,
					'txt' => $topic['topic'],
					'prefix' => $l['prefix_topic']);
	
	/* Update what you got to UPDATE */
	
	/////////////////////////////////////////////////////
	// Note : We have to UPDATE certain things
	// 1 - UPDATE the Views of the Topic
	// 2 - IF Logged In UPDATE/INSERT that the User has 
	//		read the forum in the read_forums table
	// 3 - IF Logged In UPDATE/INSERT that the user has 
	//		read this particular topic
	/////////////////////////////////////////////////////
	
	//UPDATE the Views of the Topic
	$qresult = makequery("UPDATE ".$dbtables['topics']."
			SET n_views = n_views + 1			
			WHERE tid = ".$topic['tid'], false);
	
	
	if(mysql_affected_rows($conn) < 1){
				
		reporterror($l['update_views_error_title'], $l['update_views_error']);
		
		return false;
				
	}
	
		
	///////////////////////////////
	// Save the user read the topic
	///////////////////////////////
	
	if(!read_topic($tid, time())){
	
		return false;
	
	}
	
	///////////////////////////////
	// Save the user read the forum
	///////////////////////////////
	
	if(!read_forum($board['fid'], time())){
	
		return false;
	
	}
	
	/* Ending - Update what you got to UPDATE */
	
	
	//The forums theme
	forum_theme();
	
	
	//Do we have a poll ?
	if($topic['poll_id']){
		
		include_once($globals['mainfiles'].'/poll.php');

		$poll = loadpoll($topic['poll_id']);
		
		//What to show this user - Voting Form, Results OR Nothing
		if(!empty($poll)){
			
			//Is the user submitting Vote or deleting it.
			if(!handle_vote($poll)){
			
				return false;
			
			}
			
			$poll['what_to_show'] = poll_action($poll);
			
			//Show nothing
			if($poll['what_to_show'] == 0){
				
				$poll = array();
			
			}
						
		
		}//End of if(!empty($poll))
		
	
	}
	

	$board_mod = array();
	
	//First Get Out the moderators if any
	if(isset($board['moderators'])){		
			
		foreach($board['moderators'] as $mk => $mv){
		
			$board_mod[] = $board['moderators'][$mk]['mod_mem_id'];
			
		}
		
	}
	
	//Bring the Member Group
	if(!membergroups()){
	
		return false;
	
	}
	
	$showsmileys = showsmileys();
	
	//Are we to use smileys ?
	if($globals['usesmileys'] && $showsmileys){
	
		if(!getsmileys()){
		
			return false;
		
		}
	
	}
	
	
	//First Flip the array
	$post_group = array_reverse($post_group);
	
	//Threaded mode needs post in another style
	if($mode == 'thread'){	
		
		if(isset($_GET['pid'])){
		
			$pid = (int) inputsec(htmlizer(trim($_GET['pid'])));
		
		}
		
		if(empty($pid) || !in_array($pid, array_keys($post))){
		
			$pid = $fpid;
		
		}
		
		$post = threaded_post($post, $pid);
	
	}
	
	//Are sigs to be shown
	$showsigs = ($logged_in ? ( $user['showsigs'] == 1 ? true : ($user['showsigs'] == 2 ? false : $globals['attachsigtopost']) ) : $globals['attachsigtopost']);
	
	$showavatars = ($logged_in ? ( $user['showavatars'] == 1 ? true : ($user['showavatars'] == 2 ? false : $globals['showavatars']) ) : $globals['showavatars']);
	
	//The main loop of the posts
	foreach($post as $pk => $pv){
		
		//Is there any username present
		if(empty($post[$pk]['username'])){
			
			$post[$pk]['mem_gr_name'] = $user_group[-1]['mem_gr_name'];
			
			$post[$pk]['image_name'] = $user_group[-1]['image_name'];
			
			$post[$pk]['image_count'] = $user_group[-1]['image_count'];
			
			$post[$pk]['mem_gr_colour'] = $user_group[-1]['mem_gr_colour'];
			
			$post[$pk]['is_guest'] = 1;
			
			//Has it been posted by any guest
			if(empty($post[$pk]['gposter_name'])){			
				
				$post[$pk]['username'] = $user_group[-1]['mem_gr_name'];				
			
			}else{
			
				$post[$pk]['username'] = $post[$pk]['gposter_name'];
				
				$post[$pk]['email'] = $post[$pk]['gposter_email'];
							
			}
		
		}
		
		//The date
		$post[$pk]['pdate'] = datify($post[$pk]['ptime']);
		
		//The modifying date if any
		$post[$pk]['modtime'] = datify($post[$pk]['modtime']);
		
		
		//Which Post Group Do you Belong ?		
		foreach($post_group as $pgrk => $pgr){
		
			if($post[$pk]['posts'] >= $pgr['post_count']){
			
				$post[$pk]['post_gr_name'] = $pgr['mem_gr_name'];
				break;
			
			}
		
		}
		
		
		//////////////////////////////////////////
		// BBC is quite a headache and puts a load
		//////////////////////////////////////////
				
		//Format the text
		$post[$pk]['post'] = format_text($post[$pk]['post']);
		
		//Links and all
		$post[$pk]['post'] = parse_special_bbc($post[$pk]['post'], $post[$pk]['allow_html']);
		
		//Add the brakes
		$post[$pk]['post'] = parse_br($post[$pk]['post']);
		
		//If user wants to see sig
		if($globals['enablesig'] && $showsigs){
		
			$post[$pk]['sig'] = parse_special_bbc($post[$pk]['sig']);
			
			$post[$pk]['sig'] = format_text($post[$pk]['sig']);
			
			$post[$pk]['sig'] = parse_br($post[$pk]['sig']);
			
			//What about smileys in sigs
			if($globals['usesmileys'] && $showsmileys){
			
				$post[$pk]['sig'] = smileyfy($post[$pk]['sig']);
			
			}
		
		}else{
		
			unset($post[$pk]['sig']);
		
		}
		
		
		// Smileys are so cheerfull
		if($globals['usesmileys'] && $showsmileys){		
						
			if($post[$pk]['use_smileys']){
			
				$post[$pk]['post'] = smileyfy($post[$pk]['post']);
			
			}
			
		}
		
		
		//The if Condition for Board Moderators ( Are they of this Board ??? )
		if(in_array($pv['id'], $board_mod)){
		
			$post[$pk]['mem_gr_name'] = $user_group[3]['mem_gr_name'];
			
			$post[$pk]['image_name'] = $user_group[3]['image_name'];
			
			$post[$pk]['image_count'] = $user_group[3]['image_count'];
			
			$post[$pk]['mem_gr_colour'] = $user_group[3]['mem_gr_colour'];
			
		}
		
		
		//Is the user allowed to see IP Addresses
		if(!$user['view_ip']){
			
			unset($post[$pk]['poster_ip']);
			
		}
		
		//Is avatars allowed globally
		if(!empty($post[$pk]['avatar']) && $globals['showavatars'] && $showavatars){
		
			$avatar = array('avatar' => $post[$pk]['avatar'],
						'avatar_type' => $post[$pk]['avatar_type'],
						'avatar_width' => $post[$pk]['avatar_width'],
						'avatar_height' => $post[$pk]['avatar_height']
						);
						
			$post[$pk]['avatarurl'] = urlifyavatar(100, $avatar);
		
		}
		
		
		//Are there any attachments to load
		if(!empty($post[$pk]['num_attachments'])){
		
			$attach[] = $post[$pk]['pid'];
		
		}
		
		//Are guests allowed to see user details
		if(!$logged_in && !$globals['showmemdetails']){
		
			$post[$pk]['location'] = '';
			
			$post[$pk]['www'] = '';
			
			$post[$pk]['timezone'] = '';
			
			$post[$pk]['icq'] = '';
			
			$post[$pk]['aim'] = '';
			
			$post[$pk]['yim'] = '';
			
			$post[$pk]['msn'] = '';
			
			$post[$pk]['email'] = '';
		
		//So they are allowed but be careful with the email
		}elseif(!$logged_in && $globals['showmemdetails']){
		
			if($post[$pk]['hideemail'] == 1){
			
				$post[$pk]['email'] = '';
			
			}
		
		}
		
		
		//Do logged in user have to see the email
		if($logged_in){
			
			//So is it globally allowed to hide
			if($globals['memhideemail'] && $post[$pk]['hideemail'] == 1 && !$user['can_admin']){
			
				$post[$pk]['email'] = '';
			
			}
		
		}
		
		
		//Editing options
		if($logged_in){
			
			if($post[$pk]['poster_id'] == $user['id']){
			
				$my_post = true;
				
			}else{
			
				$my_post = false;
				
			}
			
		}else{
		
			$my_post = false;
			
		}
		
		
		//Reply Option
		if(($user['can_reply'] || $board['can_reply']) &&
			($board['status'] != 0 || ($board['status'] == 0 && $user['has_priviliges'])) &&
			($topic['t_status'] != 0 || ($topic['t_status'] == 0 && $user['has_priviliges'])) ){
		
			$post[$pk]['can_reply'] = 1;
			
		}
		
		
		//Edit own post
		if($my_post && $user['can_edit_own']){
		
			$post[$pk]['can_edit'] = 1;
			
		}
		
		//Edit others post
		if(!$my_post && $user['can_edit_other']){
		
			$post[$pk]['can_edit'] = 1;
			
		}		
		
		
		//Delete own post
		if($my_post && $user['can_del_own_post']){
		
			$post[$pk]['can_del'] = 1;
			
		}
		
		//Delete others post
		if(!$my_post && $user['can_del_own_post']){
		
			$post[$pk]['can_del'] = 1;
			
		}
		
		
		//Split the topic
		if($user['can_split_topics']){
		
			$post[$pk]['can_split'] = 1;
			
		}
		
		
	}//End of foreach loop
		
	
	if(!empty($attach) && $globals['attachmentmode'] && 
		($user['can_view_attach'] || $board['can_view_attach'])){
		
		$ins = implode(', ', $attach);
		
		//Get the attachments
		$qresult = makequery("SELECT at.*, mt.atmt_icon, mt.atmt_isimage, mt.atmt_ext
				FROM ".$dbtables['attachments']." at
				LEFT JOIN ".$dbtables['attachment_mimetypes']." mt ON (at.at_mimetype_id = mt.atmtid)
				WHERE at.at_pid IN (".$ins.")
				ORDER BY at_pid ASC");
				
		//There may be no such attachments
		
		//Are there any attachments
		if(mysql_num_rows($qresult) > 0){
			
			for($i = 1; $i <= mysql_num_rows($qresult); $i++){
			
				$row = mysql_fetch_assoc($qresult);
				
				//Is the attachment a image
				if($row['atmt_isimage'] && $globals['attachmentshowimage']){
				
					//Resize in relation to width first
					if($row['at_width'] > $globals['attachmentshowimagemaxwidth']){
					
						$shrinkage = $globals['attachmentshowimagemaxwidth']/$row['at_width'];
						
						$row['at_width'] = $globals['attachmentshowimagemaxwidth'];
						
						//If the width was greater then first proportionately resize
						$row['at_height'] = $row['at_height']*$shrinkage;
					
					}
					
					if($row['at_height'] > $globals['attachmentshowimagemaxheight']){
						
						$shrinkage = $globals['attachmentshowimagemaxheight']/$row['at_height'];
						
						//Just resize it
						$row['at_height'] = $globals['attachmentshowimagemaxheight'];
						
						//Resize the width also
						$row['at_width'] = $row['at_width']*$shrinkage;
					
					}
					
					$atimg = '<img src="'.$globals['attachmenturl'].'/'.$row['at_file'].'" width="'.$row['at_width'].'" height="'.$row['at_height'].'" alt="'.$row['at_original_file'].'" /><br />';	
				
				}else{
				
					$atimg = '';
				
				}
				
				if(empty($attachments[$row['at_pid']])){
				
					$attachments[$row['at_pid']] = array();
				
				}
				
				$at_size = number_format(($row['at_size']/1024), 2);
				
				$attachments[$row['at_pid']][] = $atimg.'<img src="'.$globals['url'].'/mimetypes/'.(empty($row['atmt_icon']) ? 'unknown.png' : $row['atmt_icon']).'" alt="'.$row['atmt_ext'].'" />&nbsp;<a href="'.$globals['index_url'].'act=downloadattach&amp;atid='.$row['atid'].'">'.$row['at_original_file'].'</a> ('.$at_size.' KB, '.$l['downloads'].': '.$row['at_downloads'].')';
			
			}
		
		}
	
	}
	
	
	//Who read this topic
	if(!empty($globals['who_read_topic'])){
	
		//Get who is active
		$qresult = makequery("SELECT DISTINCT u.id, u.username, ug.mem_gr_colour
					FROM ".$dbtables['read_topics']." rt
					LEFT JOIN ".$dbtables['users']." u ON (rt.rt_uid = u.id)
					LEFT JOIN ".$dbtables['user_groups']." ug ON (u.u_member_group = 
																ug.member_group)
					WHERE rt.rt_tid = '$tid'
					ORDER BY u.id ASC");
					
		for($i = 1; $i <= mysql_num_rows($qresult); $i++){
			
			$row = mysql_fetch_assoc($qresult);
			
			$users_who_read[$row['id']] = $row;
			
		}
	
	}	
	
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
				WHERE s.last_activity = 't'
				AND activity = '".$topic['tid']."|".$topic['topic']."'
				AND s.time > '$activetime'
				ORDER BY u.username ASC");
	
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
		
			$activeusers[] = $botname.'('.$v.')';
			
		}
	
	}
	
	
	//////////////////////////////////
	// Some topic related permissions
	//////////////////////////////////
	
	//Who started this topic?
	if($logged_in){
			
		if($topic['t_mem_id'] == $user['id']){
		
			$i_started = true;
			
		}else{
		
			$i_started = false;
			
		}
		
	}else{
	
		$i_started = false;
		
	}
	
	
	//Reply Option
	if(($user['can_reply'] || $board['can_reply']) &&
		($board['status'] != 0 || ($board['status'] == 0 && $user['has_priviliges'])) &&
		($topic['t_status'] != 0 || ($topic['t_status'] == 0 && $user['has_priviliges'])) ){
	
		$user['can_reply_to_this_topic'] = 1;
		
		//Old one to be used for processing
		$postcode = (isset($AEF_SESS['nr'.$tid.'postcode']) ? $AEF_SESS['nr'.$tid.'postcode'] : '');
		
		//Now create a new one
		$AEF_SESS['nr'.$tid.'postcode'] = generateRandStr(16);
		
		$postcodefield = '<input type="hidden" value="'.$AEF_SESS['nr'.$tid.'postcode'].'" name="postcode" />';
		
	}
	
	//Lock/Unlock Topic
	if( (($i_started && $user['can_lock_own_topic']) ||
		  (!$i_started && $user['can_lock_other_topic'])) ){
		  
		$user['can_lock_this_topic'] = 1;
		  
	}
	
	
	//Edit Topic
	if( (($i_started && $user['can_edit_own_topic']) ||
		  (!$i_started && $user['can_edit_other_topic'])) ){
		  
		$user['can_edit_this_topic'] = 1;
		  
	}
	
	//Can he delete the topic
	if( (($i_started && $user['can_del_own_topic']) ||
	  (!$i_started && $user['can_del_other_topic'])) ){

		$user['can_del_this_topic'] = 1;
	
	}
	
	
	//Can he delete the topic
	if( (($i_started && $user['can_move_own_topic']) ||
	  (!$i_started && $user['can_move_other_topic'])) ){

		$user['can_move_this_topic'] = 1;
	
	}
		
	
	// Add a poll ?
	if($globals['enablepolls'] && $board['allow_poll'] && empty($topic['poll_id'])){
		
		if(($i_started && $user['add_poll_topic_own']) || 
		   (!$i_started && $user['add_poll_topic_other'])){
		
			$user['can_poll_this_topic'] = 1;
			
			$AEF_SESS['postpoll'] = $tid;
			
			$AEF_SESS['postpoll_t'] = $topic['topic'];
			
		}
		
	}
		
	
	//Later put to check if the polls are disabled or something then dont allow if they have no priviliges.
	
	//Ok if he is not a admin then put a range of testifications
	//pulkit test later
	
		
	/* A list of Permissions to take care of.
 	
	* - Indicates Done
	
	//Reading Topic Related
	*	view_ip
	*	can_email_topic
		can_report_post
	*	can_view_attach
		can_remove_attach	
	
	
	//Polls Related
	*	can_view_poll
	*	can_vote_polls
	*	can_edit_other_poll
	*	can_edit_own_poll
		add_poll_topic_own
		add_poll_topic_other
	*	can_rem_own_poll
	*	can_rem_other_poll
	
	//Other Matter Related
	*	can_edit_own
	*	can_edit_other
	*	can_del_own_post
	*	can_del_other_post
	*	can_reply
	*	can_del_own_topic
	*	can_del_other_topic
		can_merge_topics
		can_merge_posts
	*	can_split_topics
		can_make_sticky
		can_move_own_topic
		can_move_other_topic
		can_lock_own_topic
		can_lock_other_topic
	*	notify_new_posts
		has_priviliges
		
		
	*/
	
	//Are we to print the topic
	if($mode == 'print'){
	
		$theme['call_theme_func'] = 'printtopic_theme';
	
	}elseif($mode == 'thread'){
	
		$theme['call_theme_func'] = 'thread_theme';
	
	}else{
	
		$theme['call_theme_func'] = 'posts_theme';
	
	}	

}



//This will make all the necessary changes to the posts for threaded purposes
function threaded_post($post, $pid){
	
	$r_post = array();//Array of post - TEMP
	
	$posts = array();//Array of post to be returned
	
	$parents = array();//Array of post to reverse
	
	$fp = 0;//First Post
	
	foreach($post as $k => $v){
	
		if(empty($fp)){
		
			$fp = $k;
		
		}
		
		//If the par is not empty and its not the first post and it is a post in this topic
		if(!empty($v['par_id']) && $v['par_id'] != $fp && in_array($v['par_id'], array_keys($post))){
		
			$parents[$v['par_id']][] = $k;
		
		//No parent was found - Push
		}else{
		
			$parents[0][] = $k;
		
		}
	
	}
	
	//r_print($parents);	
	
	foreach($parents as $par => $kid){		
		
		if(!empty($par)){
		
			$kid = array_reverse($kid);
		
		}
		
		foreach($kid as $k => $v){
			
			//If there is a parent found in the posts - Array Splice
			if(in_array('p'.$par, array_keys($r_post))){
			
				//Insert in between
				array_insert($r_post, find_pos($r_post , 'p'.$par), array('p'.$v => $v));
			
			//No parent was found - Push
			}else{
				
				$r_post['p'.$v] = $v;
			
			}
		
		}
	
	}
	
	//r_print($r_post);
	
	foreach($r_post as $k => $v){
	
		$level = 1;		
		
		$par = $post[$v]['par_id'];
		
		//Find the level
		while(true){		
			
			if(!empty($par) && $par != $fp && in_array($par, array_keys($post))){
				
				$par = $post[$par]['par_id'];
				
				$level = $level + 1;
				
				
			}else{
			
				$post[$v]['level'] = $level;
			
				break;
				
			}
		
		}
	
		//Take out the BBC
		$post[$v]['post_thread'] = preg_replace("/\[\/?.*\]/iU", '', $post[$v]['post']);
		
		//Trim it down
		$post[$v]['post_thread'] = wordLimit($post[$v]['post_thread'], $length = 3);
		
		if($v != $pid){
		
			$post[$v]['post'] = $post[$v]['post_thread'];
		
		}

		$posts[$v] = $post[$v];
	
	}
	
	//r_print($posts);
	
	return $posts;

}


?>
