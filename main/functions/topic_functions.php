<?php

//////////////////////////////////////////////////////////////
//===========================================================
// topic_functions.php(functions)
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

///////////////////////////////////////
// Deletes the array of topic id given
// Note: 1) Assumes the topic exists
//       2) Parameters are to be passed
//          using $param.
// $param (Parameters) (Array):
//   a) 'reduce_user_post_count'
//   b) 'update_forum_topic_post_count'
///////////////////////////////////////

//Load the Language File
if(!load_lang('functions/topic_functions')){

	return false;
	
}

function delete_topics_fn($tids, $param = array()){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
	
	///////////////////////////////////
	// List of main actions to be done
	// 1 - Delete from topics table
	// 2 - Delete from posts table
	// 3 - Delete attachments
	// 4 - Delete polls,options and voters
	// 5 - Delete from notify_topic table
	// 6 - Delete from read_topics table
	// 7 - Update forums topic, post count
	///////////////////////////////////
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////	
	
	$topics = array();
	
	$tids_str = '';//Clean string of topic ids
	
	$pids = array();
	
	$pids_str = '';//Clean string of post ids
	
	$attachments = array();
	
	$attach_pids = array();//Array of pids having attachments
	
	$poll_tids = array();//Array of tids having polls
	
	$fids = array();
	
	//Make them unique also
	$tids = array_unique($tids);
	
	array_multisort($tids);
	
	$tids_str = implode(', ', $tids);
	
	
	//Bring the topics out
	$qresult = makequery("SELECT tid, t_bid, poll_id, has_attach
			FROM ".$dbtables['topics']."
			WHERE tid IN ($tids_str)");
	
	if(mysql_num_rows($qresult) < 1 || (mysql_num_rows($qresult) != count($tids))){
	
		return false;
		
	}
	
	for($i = 1; $i <= mysql_num_rows($qresult); $i++){
		
		$row = mysql_fetch_assoc($qresult);
		
		$topics[$row['tid']] = $row;
		
		if(!in_array($row['t_bid'], $fids)){
		
			$fids[] = $row['t_bid'];
			
		}
		
		//Are there any polls
		if(!empty($row['poll_id'])){
		
			$poll_tids[] =  $row['tid'];
	
		}
					
	}
	
		
	//Free the resources
	@mysql_free_result($qresult);
	
	
	
	//Bring the pids out
	$qresult = makequery("SELECT pid, num_attachments
			FROM ".$dbtables['posts']."
			WHERE post_tid IN ($tids_str)");
	
	//Nearly impossible
	if(mysql_num_rows($qresult) < 1){
	
		return false;
		 	
	}
	
	//Loop through the pids
	for($i = 1; $i <= mysql_num_rows($qresult); $i++){
	
		$row = mysql_fetch_assoc($qresult);
		
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
	
	
	
	///////////////////////////////
	// UPDATE the users post count
	///////////////////////////////
	
	//Not for guests and should we increase
	if(!empty($param['reduce_user_post_count'])){
		
		//Bring the poster count out
		$qresult = makequery("SELECT poster_id AS id, COUNT(ptime) AS num
				FROM ".$dbtables['posts']."
				WHERE post_tid IN ($tids_str) AND poster_id != '-1'
				GROUP BY poster_id");
		
		//Make an empty array
		$posters = array();
		
		for($i = 1; $i <= mysql_num_rows($qresult); $i++){
		
			$row = mysql_fetch_assoc($qresult);
			
			$posters[] = $row;
		
			unset($row);
			
		}
		
		
		//Loop through the posters as there may be many
		foreach($posters as $pk => $pv){			
			
			$qresult = makequery("UPDATE ".$dbtables['users']." 
							SET posts = posts - ".$pv['num']."
							WHERE id = '".$pv['id']."'", false);
							
			/*if(mysql_affected_rows($conn) < 1){
				
				return false;
				
			}*/	
			
		}
				
	}
	
	
	/////////////////////
	// DELETE the topics
	/////////////////////
	
	$qresult = makequery("DELETE FROM ".$dbtables['topics']." 
					WHERE tid IN ($tids_str)", false);
					
	//How many were deleted ?
	$deleted = mysql_affected_rows($conn);
					
	if($deleted != count($tids)){
	
		return false;
		
	}
	
	
	///////////////////
	// DELETE the post
	///////////////////
	
	$qresult = makequery("DELETE FROM ".$dbtables['posts']."
					WHERE post_tid IN ($tids_str)", false);
					
	//How many were deleted ?
	$deleted_p = mysql_affected_rows($conn);
					
	if($deleted_p != count($pids)){
	
		return false;
		
	}
	
	
	//////////////////////////
	// DELETE the attachments
	//////////////////////////
	
	//Get out the attachments
	if(!empty($attach_pids)){
	
		$at_pids_str = implode(', ', $attach_pids);
	
		//Bring the atids out
		$qresult = makequery("SELECT atid, at_file
				FROM ".$dbtables['attachments']."
				WHERE at_pid IN ($at_pids_str)
				ORDER BY at_pid ASC");
			
		//Loop through the table
		for($i = 1; $i <= mysql_num_rows($qresult); $i++){
		
			$row = mysql_fetch_assoc($qresult);
			
			$attachments[$row['atid']] = $row;
			
		}
		
		if(!delete_attach($attachments)){
		
			return false;
		
		}
	
	}
	
	
	////////////////////////////////////////
	// DELETE the polls, options and voters
	////////////////////////////////////////
	
	
	//Get out the attachments
	if(!empty($poll_tids)){
	
		$po_tids_str = implode(', ', $poll_tids);
	
		//Bring the poids out
		$qresult = makequery("SELECT poid
				FROM ".$dbtables['polls']."
				WHERE poll_tid IN ($po_tids_str)
				ORDER BY poid ASC");
			
		//Loop through the table
		for($i = 1; $i <= mysql_num_rows($qresult); $i++){
		
			$row = mysql_fetch_assoc($qresult);
			
			$polls[$row['poid']] = $row['poid'];
			
		}
		
		if(!delete_poll($polls)){
		
			return false;
		
		}
	
	}
	
	
	////////////////////////////
	// DELETE the notifications
	////////////////////////////
	
	$qresult = makequery("DELETE FROM ".$dbtables['notify_topic']." 
					WHERE notify_tid IN ($tids_str)", false);
					
	
	////////////////////////////
	// DELETE from read_topics
	////////////////////////////
	
	$qresult = makequery("DELETE FROM ".$dbtables['read_topics']." 
					WHERE rt_tid IN ($tids_str)", false);
	
	
	///////////////////////////////////////
	// UPDATE the forums topic, post count
	///////////////////////////////////////
	
	if(!empty($param['update_forum_topic_post_count'])){
		
		$fids_str = implode(', ', $fids);
		
		//Bring the topic count out
		$qresult = makequery("SELECT t_bid, COUNT(t_bid) AS ntopic
						FROM ".$dbtables['topics']."
						WHERE t_bid IN ($fids_str)
						GROUP BY t_bid");
		
		//Make an empty array
		$ntopic = array();
		
		for($i = 1; $i <= mysql_num_rows($qresult); $i++){
		
			$row = mysql_fetch_assoc($qresult);
			
			$ntopic[$row['t_bid']] = $row['ntopic'];
		
			unset($row);
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		
		//Bring the post count out
		$qresult = makequery("SELECT post_fid, COUNT(post_fid) AS nposts
						FROM ".$dbtables['posts']."						
						WHERE post_fid IN ($fids_str)
						GROUP BY post_fid");
		
		//Make an empty array
		$nposts = array();
		
		for($i = 1; $i <= mysql_num_rows($qresult); $i++){
		
			$row = mysql_fetch_assoc($qresult);
			
			$nposts[$row['post_fid']] = $row['nposts'];
		
			unset($row);
			
		}
		
		//Free the resources
		@mysql_free_result($qresult);
		
		
		//Loop through the posters as there may be many
		foreach($fids as $f){			
			
			$qresult = makequery("UPDATE ".$dbtables['forums']." 
						SET ntopic = '".(empty($ntopic[$f]) ? 0 : $ntopic[$f])."',
						nposts = '".(empty($nposts[$f]) ? 0 : $nposts[$f])."'
						WHERE fid = '$f'", false);
						
			if(mysql_affected_rows($conn) < 1){
			
				return false;
				
			}
			
		}
		
	}
	
	return true;

}




//////////////////////////////////////////
// Deletes all attachments that are given
// Note: Function will be removed later
//////////////////////////////////////////

function delete_attach($attachments){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$delete_error = array();
	
	$atids = array();
		
	foreach($attachments as $k => $v){
	
		$atids[] = $v['atid'];
	
	}
	
	if(empty($atids)){
	
		return false;
	
	}
	
	$atids_str = implode(', ', $atids);
	
	/////////////////////////
	// DELETE the attachment
	/////////////////////////
	
	$qresult = makequery("DELETE FROM ".$dbtables['attachments']." 
					WHERE atid IN ($atids_str)", false);
					

	
	if(mysql_affected_rows($conn) < 1){
		
		//A mechanism to report error
		$delete_error[] = true;
	
	}
	
	
	//Now lets perform the task of moving and saving in DB
	foreach($attachments as $k => $v){
	
		//Finally lets delete the File
		if(!(@unlink($globals['attachmentdir'].'/'.$v['at_file']))){
		
			//A mechanism to report error
			$delete_error[] = true;
		
		}
		
	}
	
	if(empty($delete_error)){
		
		return true;
	
	}else{
	
		return false;
	
	}

}



//////////////////////////////////////////
// Deletes all polls , options and voters
// Note: Function will be removed later
//////////////////////////////////////////

function delete_poll($poids){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$delete_error = array();
		
	if(empty($poids)){
	
		return false;
	
	}
	
	$poids_str = implode(', ', $poids);
	
	////////////////////
	// DELETE the polls
	////////////////////
	
	$qresult = makequery("DELETE FROM ".$dbtables['polls']." 
					WHERE poid IN ($poids_str)", false);
					

	
	if(mysql_affected_rows($conn) < 1){
		
		//A mechanism to report error
		$delete_error[] = true;
	
	}
	
	
	//////////////////////
	// DELETE the options
	//////////////////////
	
	$qresult = makequery("DELETE FROM ".$dbtables['poll_options']." 
					WHERE poo_poid IN ($poids_str)", false);
					

	
	if(mysql_affected_rows($conn) < 1){
		
		//A mechanism to report error
		$delete_error[] = true;
	
	}
	
	
	//////////////////////
	// DELETE the voters
	//////////////////////
	
	$qresult = makequery("DELETE FROM ".$dbtables['poll_voters']." 
					WHERE pv_poid IN ($poids_str)", false);
					

	
	if(mysql_affected_rows($conn) < 1){
		
		//A mechanism to report error
		$delete_error[] = true;
	
	}
	
	
	if(empty($delete_error)){
		
		return true;
	
	}else{
	
		return false;
	
	}

}



//A function to check the title of the post with the required GLOBAL Settings
function checktitle_fn($title){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error;
	
	//Call the Language function
	checktitle_fn_lang();
	
	//////////////////////////////////
	// Title must undergo following
	// restriction checks
	// 1 - Allow Shouting
	// 2 - Max Length
	// 3 - Min Length
	//////////////////////////////////
	
	//Check the Max Length
	if($globals['maxtitlechars'] && (aefstrlen($title) > $globals['maxtitlechars'])){
	
		$error[] = $l['title_too_long'];
		
		return false;
		
	}
		
	//Check the Min Length
	if($globals['mintitlechars'] && (aefstrlen($title) < $globals['mintitlechars'])){
	
		$error[] = $l['title_too_short'];
		
		return false;
		
	}
		
	//Check the Shouting Stuff in the Title
	if($globals['disableshoutingtopics']){
	
		$title = aefucfirst(aefstrtolower($title));
		
	}
		
	return $title;

}



//A function to check the title of the post with the required GLOBAL Settings
function checkdescription_fn($description){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error;

	//Call the Language function
	checkdescription_fn_lang();
	
	//////////////////////////////////
	// Description must undergo following
	// restriction checks
	// 1 - Allow Shouting
	// 2 - Max Length
	// 3 - Min Length
	//////////////////////////////////	
	
	//Check the Max Length
	if($globals['maxdescchars'] && (aefstrlen($description) > $globals['maxdescchars'])){
	
		$error[] = $l['desc_too_long'];
		
		return false;
		
	}
		
	//Check the Min Length
	if($globals['mindescchars'] && (aefstrlen($description) < $globals['mindescchars'])){
	
		$error[] = $l['desc_too_short'];
		
		return false;
		
	}
		
	//Check the Shouting Stuff in the description
	if($globals['disableshoutingdesc']){
	
		$description = aefucfirst(aefstrtolower($description));
		
	}
		
	return $description;

}



function checkpost_fn($post){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error, $smileys;	

	//Call the Language function
	checkpost_fn_lang();
		
	//////////////////////////////////
	// Post must undergo following
	// restriction checks :
	// 1 - Max Length
	// 2 - Min Length
	// 3 - Max Emoticons
	// 4 - Max Images
	// 5 - Max Flash
	//////////////////////////////////	
	
	$emotused = 0;
	
	$imgused = 0;
	
	$flashused = 0;
	
	//Check the Max Length of the POST
	if($globals['maxcharposts'] && (aefstrlen($post) > $globals['maxcharposts'])){
	
		$error[] = $l['post_too_big'];
		
		return false;
	
	}
	
		
	//Check the Min Length of the POST
	if($globals['mincharposts'] && (aefstrlen($post) < $globals['mincharposts'])){
	
		$error[] = $l['post_too_small'];
		
		return false;
		
	}
	
	
	//How many emoticons did you use ?
	if($globals['maxemotpost'] && !empty($smileys)){
		
		foreach($smileys as $sk => $sv){
			
			$emotused += @substr_count($post, $smileys[$sk]['smcode']);
		
		}
		
		if($emotused > $globals['maxemotpost']){
		
			$error[] = $l['too_many_smileys'];
		
			return false;
			
		}
		
	}
	
	
	//How many Images did you use ?
	if($globals['maximgspost']){
		
		preg_match_all("/\[img(|=([0-9]+),([0-9]+))\](.*?)\[\/img\]/i", $post, $matches);
		
		$imgused = count($matches[1]);
		
		if($imgused > $globals['maximgspost']){
		
			$error[] = $l['too_many_images'];
		
			return false;
			
		}
		
	}
	
	
	//How many Flash did you use ?
	if($globals['maxflashpost']){
		
		preg_match_all("/\[flash=([0-9]+),([0-9]+)\](.*?)\[\/flash\]/i", $post, $matches);
		
		$flashused = count($matches[1]);
		
		if($flashused > $globals['maxflashpost']){
		
			$error[] = $l['too_many_flash'];
		
			return false;
			
		}
		
	}	
		
	return $post;

}

//Marks that the user has read the topic
function read_topic_fn($tid, $view_time){

global $logged_in, $dbtables, $globals, $user, $conn, $l, $board;

	//Call the Language function
	read_topic_fn_lang();
	
	//REPLACE that the user has read the FORUM
	if($logged_in){			
		
		//Well we just need to make a query
	
		/////////////////////////////////
		// REPLACE the users row in table
		/////////////////////////////////
		
		$qresult = makequery("REPLACE INTO ".$dbtables['read_topics']."
					SET rt_uid = '".$user['id']."', 
					rt_tid = '$tid', 
					rt_time = '$view_time'", false);				
		
		if(mysql_affected_rows($conn) < 1){
				
			reporterror($l['read_topic_error_title'], $l['read_topic_error']);
			
			return false;
			
		}
		
		return true;
		
	}else{
	
		return true;
	
	}//End of if($logged_in)

}

//RETURNs the forst post of a topic
function first_post_topic_fn($tid){

global $logged_in, $dbtables, $globals, $user, $conn, $l, $board;
	
	//SELECT the Last post of that TOPIC
	$qresult = makequery("SELECT * FROM ".$dbtables['posts']." 
					WHERE post_tid = '$tid'
					ORDER BY pid ASC
					LIMIT 0, 1");
	
	if(mysql_num_rows($qresult) < 1){
		return array('pid' => 0, 
					'poster_id' => 0);
	}
	
	$row = mysql_fetch_assoc($qresult);
		
	return $row;

}



//RETURNs the last post of a topic
function last_post_topic_fn($tid){

global $logged_in, $dbtables, $globals, $user, $conn, $l, $board;
	
	//SELECT the Last post of that TOPIC
	$qresult = makequery("SELECT * FROM ".$dbtables['posts']." 
					WHERE post_tid = '$tid'
					ORDER BY pid DESC
					LIMIT 0, 1");
	
	if(mysql_num_rows($qresult) < 1){
		return array('pid' => 0, 
					'poster_id' => 0);
	}
	
	$row = mysql_fetch_assoc($qresult);
		
	return $row;

}

?>