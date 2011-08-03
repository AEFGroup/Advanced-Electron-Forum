<?php

//////////////////////////////////////////////////////////////
//===========================================================
// feeds.php
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


////////////////////////
// Handles the FEEDS
////////////////////////

function feeds(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $categories, $forums;

	//Load the Language File
	if(!load_lang('feeds')){
	
		return false;
		
	}
		
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$visible_forums = array();//Array of forum ids that are visible
	
	$feeds = array();//Array of feeds
	
	$str = '';
		
	$title = $globals['sn'];

	$desc = $l['desc_recent'];
	
	$link = $globals['mail_url'];
	
	//Load the board
	if(!default_of_nor(false, false)){
	
		redirect('');
		
		return false;
	
	}
	
	//The main forum loop of a category
	foreach($forums as $c => $cv){
	
		//The main forum loop
		foreach($forums[$c] as $f => $v){
			
			$visible_forums[] = $v['fid'];
			
		}
		
	}
		
	//Stop the output buffer
	$globals['stop_buffer_process'] = true;
	
	//The Topic
	if(isset($_GET['topic']) && is_numeric(trim($_GET['topic']))){
	
		$tid = (int) inputsec(htmlizer(trim($_GET['topic'])));
		
		//Bring the topic out
		$qresult = makequery("SELECT topic, t_description, t_bid, n_posts, n_views
							FROM ".$dbtables['topics']."
							WHERE tid = '$tid'");
							
		if(mysql_num_rows($qresult) > 0){
			
			$topic = mysql_fetch_assoc($qresult);
			
			$title = $topic['topic'];
			
			$desc = $topic['t_description'].' ('.$topic['n_posts'].' '.$l['feed_replies'].', '.$l['feed_read'].' '.$topic['n_views'].' '.$l['times'].')';
			
			$link = $globals['mail_url'].'tid='.$tid;
			
			if(in_array($topic['t_bid'], $visible_forums)){
			
				$board = board($topic['t_bid']);
				
				//Does the Board show RSS Topics
				if(!empty($board['rss_topic'])){
				
					//Bring the posts out
					$qresult = makequery("SELECT *
										FROM ".$dbtables['posts']."
										WHERE post_tid = '$tid'
										ORDER BY ptime DESC
										LIMIT 0, ".$board['rss_topic']);
										
					for($p = 0; $p < mysql_num_rows($qresult); $p++){
					
						$row = mysql_fetch_assoc($qresult);
						
						$row['post_number'] = $topic['n_posts'] - $p;
						
						$row['page'] = ceil($row['post_number']/$globals['maxpostsintopics']);												
						
						$row['post'] = format_text($row['post']);//Format the text	
								
						$row['post'] = parse_special_bbc($row['post'], 0);//Links and all
						
						$row['post'] = parse_br($row['post']);//Add the brakes
						
						// Smileys are so cheerfull
						if($globals['usesmileys'] && showsmileys() && $row['use_smileys']){
							
							$row['post'] = smileyfy($row['post']);
												
						}
						
						$feeds[$row['pid']]['title'] = $row['post_title'];//Title
				
						$feeds[$row['pid']]['link'] = $globals['mail_url'].'tid='.$tid.'&amp;tpg='.$row['page'].'#p'.$row['pid'];//Link - Becareful of HTML Entities
						
						$feeds[$row['pid']]['desc'] = $row['post'];//The content of the item
						
						$feeds[$row['pid']]['category'] = $board['fname'];//The category
						
						$feeds[$row['pid']]['pubDate'] = datify($row['ptime'], true, true, 'D, d M Y H:i:s \G\M\T');//Date
						
					
					}//End of loop
				
				}
			
			}
		
		}		
	
	//The Recent RSS Feeds for a Single Forum
	}elseif(isset($_GET['forum']) && is_numeric(trim($_GET['forum']))){
		
		$fid = (int) inputsec(htmlizer(trim($_GET['forum'])));
		
		if(!empty($fid) && in_array($fid, $visible_forums)){
			
			$board = board($fid);
			
			$title = $board['fname'].' ('.$globals['sn'].')';
			
			$desc = $l['desc_forum'].' '.$board['fname'];
			
			$link = $globals['mail_url'].'fid='.$fid;
			
			//Does the Board show Recent Posts in RSS
			if(!empty($board['rss'])){
			
				//Bring the posts out
				$qresult = makequery("SELECT DISTINCT t.tid, t.topic, t.n_posts, p.pid, p.ptime, 
					p.post, p.use_smileys, u.id, u.username, f.fid, f.fname
					FROM ".$dbtables['posts']." p
					LEFT JOIN ".$dbtables['topics']." t ON (t.tid = p.post_tid)
					LEFT JOIN ".$dbtables['forums']." f ON (f.fid = p.post_fid)
					LEFT JOIN ".$dbtables['users']." u ON (u.id = p.poster_id)
					WHERE p.post_fid = '$fid'
					ORDER BY ptime DESC
					LIMIT 0, ".$board['rss']);
									
				for($p = 0; $p < mysql_num_rows($qresult); $p++){
				
					$row = mysql_fetch_assoc($qresult);
				
					$row['last_page'] = ceil(($row['n_posts'] + 1)/$globals['maxpostsintopics']);									
					
					$row['post'] = format_text($row['post']);//Format the text	
							
					$row['post'] = parse_special_bbc($row['post'], 0);//Links and all
					
					$row['post'] = parse_br($row['post']);//Add the brakes
					
					// Smileys are so cheerfull
					if($globals['usesmileys'] && showsmileys() && $row['use_smileys']){
						
						$row['post'] = smileyfy($row['post']);
											
					}
					
					$feeds[$row['pid']]['title'] = $row['topic'];//Title
				
					$feeds[$row['pid']]['link'] = $globals['mail_url'].'tid='.$row['tid'].'&amp;tpg='.$row['last_page'].'#p'.$row['pid'];//Link - Becareful of HTML Entities
					
					$feeds[$row['pid']]['desc'] = $row['post'];//The content of the item
					
					$feeds[$row['pid']]['category'] = $row['fname'];//The category
					
					$feeds[$row['pid']]['pubDate'] = datify($row['ptime'], true, true, 'D, d M Y H:i:s \G\M\T');//Date
									
				}//End of loop
			
			}
		
		}
	
	//The Recent RSS Feeds
	}elseif(!empty($globals['rss_recent'])){
		
		$visible_forums = implode(', ', $visible_forums);
			
		//Bring the last posts
		$qresult = makequery("SELECT DISTINCT t.tid, t.topic, t.n_posts, p.pid, p.ptime, p.post,
					p.use_smileys, u.id, u.username, f.fid, f.fname
					FROM ".$dbtables['posts']." p
					LEFT JOIN ".$dbtables['topics']." t ON (t.tid = p.post_tid)
					LEFT JOIN ".$dbtables['forums']." f ON (f.fid = p.post_fid)
					LEFT JOIN ".$dbtables['users']." u ON (u.id = p.poster_id)
					WHERE p.post_fid IN (".(empty($visible_forums) ? 0 : $visible_forums).")
					ORDER BY ptime DESC
					LIMIT 0, ".$globals['rss_recent']);
				
		if(mysql_num_rows($qresult) > 0){
			
			//Get the posts
			for($p = 0; $p < mysql_num_rows($qresult); $p++){
				
				$row = mysql_fetch_assoc($qresult);
				
				$row['last_page'] = ceil(($row['n_posts'] + 1)/$globals['maxpostsintopics']);										
				
				$row['post'] = format_text($row['post']);//Format the text	
						
				$row['post'] = parse_special_bbc($row['post'], 0);//Links and all
				
				$row['post'] = parse_br($row['post']);//Add the brakes
				
				// Smileys are so cheerfull
				if($globals['usesmileys'] && showsmileys() && $row['use_smileys']){
					
					$row['post'] = smileyfy($row['post']);
										
				}
				
				
				$feeds[$row['pid']]['title'] = $row['topic'];//Title
				
				$feeds[$row['pid']]['link'] = $globals['mail_url'].'tid='.$row['tid'].'&amp;tpg='.$row['last_page'].'#p'.$row['pid'];//Link - Becareful of HTML Entities
				
				$feeds[$row['pid']]['desc'] = $row['post'];//The content of the item
				
				$feeds[$row['pid']]['category'] = $row['fname'];//The category
				
				$feeds[$row['pid']]['pubDate'] = datify($row['ptime'], true, true, 'D, d M Y H:i:s \G\M\T');//Date
								
			}
		
		}
	
	}
	
	$rss = rssclass();
		
	$str .= $rss->start('1.0', 'UTF-8', '0.92', $title, $link, $desc);
	
	//Are there any feeds
	if(empty($feeds)){
	
		$str .= $rss->item($l['no_feed_title'], $link, $l['no_feed'], $l['no_feed_cat'], datify(time(), true, true, 'D, d M Y H:i:s \G\M\T') );
	
	}else{		
		
		foreach($feeds as $f => $feed){
		
			$str .= $rss->item($feed['title'], $feed['link'], $feed['desc'], $feed['category'], $feed['pubDate']);
		
		}
		
	}
			
	$str .= $rss->close();
	
	echo $str;
	
	return true;

}

?>
