<?php

//////////////////////////////////////////////////////////////
//===========================================================
// tpp.php(Admin)
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


function tpp(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

	if(!load_lang('admin/tpp')){
		
		return false;
			
	}
	
	//The name of the file
	$theme['init_theme'] = 'admin/tpp';
	
	//The name of the Page
	$theme['init_theme_name'] = 'Admin Center - Manage Topic, Posts and Polls';
	
	//Array of functions to initialize
	$theme['init_theme_func'] = array('tpp_global', 
									'manage_topics_theme', 
									'manage_posts_theme',
									'manage_polls_theme',
									'manage_words_theme',
									'manage_bbc_theme');
	
	//My activity
	$globals['last_activity'] = 'atpp';
	

	//If a second Admin act is set then go by that
	if(isset($_GET['seadact']) && trim($_GET['seadact'])!==""){
	
		$seadact = inputsec(htmlizer(trim($_GET['seadact'])));
	
	}else{
	
		$seadact = "";
		
	}
	

	//The switch handler
	switch($seadact){
	
		//The form for editing Post Settings
		case 'posts':	
		manage_posts();		
		break;
		
		//The form for editing Poll Settings
		case 'polls':	
		manage_polls();
		break;
		
		//The form for setting censored words
		case 'words':	
		manage_words();
		break;
		
		//The form for BBC settings
		case 'bbc':	
		manage_bbc();
		break;
		
		//The form for editing Topic Settings
		case 'topics':
		default :
		manage_topics();			
		break;		
	
	}

}

//Default function to manage Topics
function manage_topics(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error;
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$maxtitlechars = 0;
	
	$mintitlechars = 0;
	
	$maxtopics = 0;
	
	$maxpostsintopics = 0;
	
	$maxreplyhot = 0;
	
	$maxreplyveryhot = 0;
	
	$warnoldtopic = 0;
	
	$prefixsticky = '';
	
	$prefixmoved = '';
	
	$prefixpolls = '';
	
	$disableshoutingtopics = 0;
	
	$prenextopic = 0;
	
	$allow_taf = 0;
	
	$who_read_topic = 0;
	
	//Description Settings
	$disableshoutingdesc = 0;
	
	$mindescchars = 0;
	
	$maxdescchars = 0;
	
	if(isset($_POST['edittopset'])){
		
		
		//Check the Max Number of Characters in a topics Title
		if(!(isset($_POST['maxtitlechars'])) || (trim($_POST['maxtitlechars']) == "")){
			
			$error[] = $l['tpp_no_max_topics_title'];
			
		}else{
		
			$maxtitlechars =(int)inputsec(htmlizer(trim($_POST['maxtitlechars'])));
			
		}
		
		
		//Check the Min Number of Characters in a topics Title
		if(!(isset($_POST['mintitlechars'])) || (trim($_POST['mintitlechars']) == "")){
		
			$error[] = $l['tpp_no_min_topics_title'];
			
		}else{
		
			$mintitlechars =(int)inputsec(htmlizer(trim($_POST['mintitlechars'])));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'manage_topics_theme';
			return false;		
		}
		
		
		//Check the Number of Topics to appear Per Board Page
		if(!(isset($_POST['maxtopics'])) || (trim($_POST['maxtopics']) == "")){
		
			$error[] = $l['tpp_no_num_topics_pp'];
			
		}else{
		
			$maxtopics = (int) inputsec(htmlizer(trim($_POST['maxtopics'])));
			
		}
		
		
		//Check the Number of Posts to appear Per Topic
		if(!(isset($_POST['maxpostsintopics'])) || (trim($_POST['maxpostsintopics']) == "")){
			
			$error[] = $l['tpp_no_num_posts_pt'];
			
		}else{
		
			$maxpostsintopics = (int) inputsec(htmlizer(trim($_POST['maxpostsintopics'])));
			
		}
				
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'manage_topics_theme';
			return false;		
		}
		
		
		//Check the Replies for Hot Topic 
		if(!(isset($_POST['maxreplyhot'])) || (trim($_POST['maxreplyhot']) == "")){
		
			$error[] = $l['tpp_no_replies_hot_topic'];
			
		}else{
		
			$maxreplyhot = (int) inputsec(htmlizer(trim($_POST['maxreplyhot'])));
			
		}
		
		//Check the Replies for Very Hot Topic 
		if(!(isset($_POST['maxreplyveryhot'])) || (trim($_POST['maxreplyveryhot']) == "")){
		
			$error[] = $l['tpp_no_replies_veryhot'];
			
		}else{
		
			$maxreplyveryhot = (int) inputsec(htmlizer(trim($_POST['maxreplyveryhot'])));
			
		}
		
		//Check the Old Topic Warn
		if(!(isset($_POST['warnoldtopic'])) || (trim($_POST['warnoldtopic']) == "")){
		
			$error[] = $l['tpp_no_old_topic_warn'];
			
		}else{
		
			$warnoldtopic = (int) inputsec(htmlizer(trim($_POST['warnoldtopic'])));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'manage_topics_theme';
			return false;		
		}
		
		
		//Check the Prefix for Stickied Topic
		if(!(isset($_POST['prefixsticky'])) || (trim($_POST['prefixsticky']) == "")){
		
			$error[] = $l['tpp_no_prefix_stickied'];
			
		}else{
		
			$prefixsticky = inputsec(htmlizer(trim($_POST['prefixsticky'])));
			
		}
		
		//Check the Prefix for Moved Topic
		if(!(isset($_POST['prefixmoved'])) || (trim($_POST['prefixmoved']) == "")){
		
			$error[] = $l['tpp_no_prefix_moved'];
			
		}else{
		
			$prefixmoved = inputsec(htmlizer(trim($_POST['prefixmoved'])));
			
		}
		
		//Check the Prefix for Poll Topics
		if(!(isset($_POST['prefixpolls'])) || (trim($_POST['prefixpolls']) == "")){
		
			$error[] = $l['tpp_no_prefix_poll'];
			
		}else{
		
			$prefixpolls = inputsec(htmlizer(trim($_POST['prefixpolls'])));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'manage_topics_theme';
			return false;		
		}
		
		
		//Check if Disable Shouting in Topic Titles 
		if(isset($_POST['disableshoutingtopics'])){
			
			$disableshoutingtopics = 1;
			
		}
		
		//Check if Disable Shouting in Topic Titles 
		if(isset($_POST['disableshoutingtopics'])){
			
			$disableshoutingdesc = 1;
			
		}
		
		//Check the Max Number of Characters in a topics description
		if(!(isset($_POST['maxdescchars'])) || (trim($_POST['maxdescchars']) == "")){
			
			$error[] = $l['tpp_no_max_topics_desc'];
			
		}else{
		
			$maxdescchars =(int)inputsec(htmlizer(trim($_POST['maxdescchars'])));
			
		}
		
		
		//Check the Min Number of Characters in a topics description
		if(!(isset($_POST['mindescchars'])) || (trim($_POST['mindescchars']) == "")){
		
			$error[] = $l['tpp_no_min_topics_desc'];
			
		}else{
		
			$mindescchars =(int)inputsec(htmlizer(trim($_POST['mindescchars'])));
			
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'manage_topics_theme';
			return false;		
		}
			
		//Check if Previous - Next Topic Links :
		if(isset($_POST['prenextopic'])){
			
			$prenextopic = 1;
		
		}
		
		//Check if Tell a friend feature is set
		if(isset($_POST['allow_taf'])){
			
			$allow_taf = 1;
		
		}
		
		//Check if Who Read Topic Feature is enabled
		if(isset($_POST['who_read_topic'])){
			
			$who_read_topic = 1;
		
		}				
		
		//The array containing the TOPIC SETTING Changes
		$topsetchanges = array('maxtopics' => $maxtopics,
						'maxpostsintopics' => $maxpostsintopics,
						'maxreplyhot' => $maxreplyhot,
						'maxreplyveryhot' => $maxreplyveryhot,
						'disableshoutingtopics' => $disableshoutingtopics,
						'prenextopic' => $prenextopic,
						'warnoldtopic' => $warnoldtopic,
						'prefixsticky' => $prefixsticky,
						'prefixmoved' => $prefixmoved,
						'prefixpolls' => $prefixpolls,
						'maxtitlechars' => $maxtitlechars,
						'mintitlechars' => $mintitlechars,
						'disableshoutingdesc' => $disableshoutingdesc,
						'maxdescchars' => $maxdescchars,
						'mindescchars' => $mindescchars,
						'allow_taf' => $allow_taf,
						'who_read_topic' => $who_read_topic
						);

		if(!modify_registry($topsetchanges)){
		
			return false;
			
		}
		
		//Redirect
		redirect('act=admin&adact=tpp&seadact=topics');
		
		return true;
				
	}else{
	
		$theme['call_theme_func'] = 'manage_topics_theme';
		
	}


}//End of function

//Default function to manage Topics
function manage_posts(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error;
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$maxpostsintopics = 0;
	
	$maxcharposts = 0;
	
	$mincharposts = 0;
	
	$maxemotpost = 0;
	
	$maximgspost = 0;
	
	$maximgwidthpost = 0;
	
	$maximgheightpost = 0;
	
	$removenestedquotes = 0;
	
	$attachsigtopost = 0;
	
	$embedflashinpost = 0;
	
	$maxflashwidthinpost = 0;
	
	$maxflashheightinpost = 0;
	
	$timepostfromuser = 0;
	
	$allowdynimg = 0;
	
	$last_posts_reply = 0;
	
	
	if(isset($_POST['editpostset'])){
	
		//Check the Number of Posts PT:
		if(!(isset($_POST['maxpostsintopics'])) || (trim($_POST['maxpostsintopics']) == "")){
		
			$error[] = $l['tpp_no_num_posts_pt_subm'];
			
		}else{
		
			$maxpostsintopics = (int) inputsec(htmlizer(trim($_POST['maxpostsintopics'])));
			
		}
		
		//Check the Max Characters per Post :
		if(!(isset($_POST['maxcharposts'])) || (trim($_POST['maxcharposts']) == "")){
		
			$error[] = $l['tpp_no_max_post_subm'];
		
		}else{
		
			$maxcharposts = (int) inputsec(htmlizer(trim($_POST['maxcharposts'])));
		
		}
		
		//Check the Min Characters per Post :
		if(!(isset($_POST['mincharposts'])) || (trim($_POST['mincharposts']) == "")){
		
			$error[] = $l['tpp_no_min_post_subm'];
		
		}else{
		
			$mincharposts = (int) inputsec(htmlizer(trim($_POST['mincharposts'])));
		
		}
		
		
		//Check the Time between Post :
		if(!(isset($_POST['timepostfromuser'])) || (trim($_POST['timepostfromuser']) == "")){
		
			$error[] = $l['tpp_no_time_between_posts'];
		
		}else{
		
			$timepostfromuser = (int) inputsec(htmlizer(trim($_POST['timepostfromuser'])));
		
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'manage_posts_theme';
			return false;		
		}
		
		
		//Check the Max Emoticons Allowed 
		if(!(isset($_POST['maxemotpost'])) || (trim($_POST['maxemotpost']) == "")){
		
			$error[] = $l['tpp_no_max_emoticons'];
			
		}else{
		
			$maxemotpost = (int) inputsec(htmlizer(trim($_POST['maxemotpost'])));
			
		}
		
		
		//Check the Max Images Allowed
		if(!(isset($_POST['maximgspost'])) || (trim($_POST['maximgspost']) == "")){
			
			$error[] = $l['tpp_no_max_images'];
		
		}else{
			
			$maximgspost = (int) inputsec(htmlizer(trim($_POST['maximgspost'])));
			
		}
		
		
		//Check the Max Width of Images
		if(!(isset($_POST['maximgwidthpost'])) || (trim($_POST['maximgwidthpost']) == "")){
		
			$error[] = $l['tpp_no_width_images'];
			
		}else{
		
			$maximgwidthpost = (int) inputsec(htmlizer(trim($_POST['maximgwidthpost'])));
			
		}
		
		
		//Check the Max Height of Images
		if(!(isset($_POST['maximgheightpost'])) || (trim($_POST['maximgheightpost']) == "")){
		
			$error[] = $l['tpp_no_height_images'];
			
		}else{
		
			$maximgheightpost = (int) inputsec(htmlizer(trim($_POST['maximgheightpost'])));
			
		}
		
		
		//Check the Max Width of Flash
		if(!(isset($_POST['maxflashwidthinpost'])) || (trim($_POST['maxflashwidthinpost']) == "")){
		
			$error[] = $l['tpp_no_width_flash'];
			
		}else{
		
			$maxflashwidthinpost = (int) inputsec(htmlizer(trim($_POST['maxflashwidthinpost'])));
			
		}
		
		//Check the Max Height of Flash
		if(!(isset($_POST['maxflashheightinpost'])) || (trim($_POST['maxflashheightinpost']) == "")){
			$error[] = $l['tpp_no_height_flash'];
			
		}else{
		
			$maxflashheightinpost = (int) inputsec(htmlizer(trim($_POST['maxflashheightinpost'])));
			
		}
		
		//Check the last posts while replying
		if(!(isset($_POST['last_posts_reply'])) || (trim($_POST['last_posts_reply']) == "")){
		
			$error[] = $l['tpp_no_num_posts_wr'];
		
		}else{
		
			$last_posts_reply = (int) inputsec(htmlizer(trim($_POST['last_posts_reply'])));
		
		}
		
		//Check if Remove Nested Quotes 
		if(isset($_POST['removenestedquotes'])){
		
			$removenestedquotes = 1;
			
		}
		
		//Check if Attach Sig to Post 
		if(isset($_POST['attachsigtopost'])){
			
			$attachsigtopost = 1;
		
		}
		
		//Check if Allow Flash
		if(isset($_POST['embedflashinpost'])){
			
			$embedflashinpost = 1;
		
		}
		
		//Check if Allow Dynaminc Images
		if(isset($_POST['allowdynimg'])){
			
			$allowdynimg = 1;
		
		}
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'manage_posts_theme';
			return false;		
		}
			
		//The array containing the POST SETTING Changes
		$postssetchanges = array('maxpostsintopics' => $maxpostsintopics,
						'maxcharposts' => $maxcharposts, 
						'mincharposts' => $mincharposts, 
						'maxemotpost' => $maxemotpost,
						'maximgspost' =>$maximgspost,
						'maximgwidthpost' => $maximgwidthpost,
						'maximgheightpost' => $maximgheightpost,
						'removenestedquotes' => $removenestedquotes,
						'attachsigtopost' => $attachsigtopost,
						'embedflashinpost' => $embedflashinpost,
						'maxflashwidthinpost' => $maxflashwidthinpost,
						'maxflashheightinpost' => $maxflashheightinpost,
						'timepostfromuser' => $timepostfromuser,
						'allowdynimg' => $allowdynimg,
						'last_posts_reply' => $last_posts_reply
						);

		if(!modify_registry($postssetchanges)){
		
			return false;
			
		}
		
		//Redirect
		redirect('act=admin&adact=tpp&seadact=posts');
		
		return true;
		
	}else{
	
		$theme['call_theme_func'] = 'manage_posts_theme';
		
	}
	
}//End of function


//Default function to manage Polls
function manage_polls(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error;
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$enablepolls = 0;
	
	$maxpollsintopic = 0;//Still to be given(Future Compatibility)There in registry
	
	$maxoptionspoll = 0;
	
	$maxpollqtlen = 0;
	
	
	//Are we requested to go ahead
	if(isset($_POST['editpollset'])){
		
		
		//Check if Polls are enabled
		if(isset($_POST['enablepolls'])){
			
			$enablepolls = 1;
		
		}
		
		
		//Check the Number of options in a poll:
		if(!(isset($_POST['maxoptionspoll'])) || (trim($_POST['maxoptionspoll']) == "")){
		
			$error[] = $l['tpp_no_max_poll_options'];
			
		}else{
		
			$maxoptionspoll = (int) inputsec(htmlizer(trim($_POST['maxoptionspoll'])));
			
		}
		
		
		//The max poll qt length
		if(!(isset($_POST['maxpollqtlen'])) || (trim($_POST['maxpollqtlen']) == "")){
		
			$error[] = $l['tpp_no_max_poll_qt_length'];
			
		}else{
		
			$maxpollqtlen = (int) inputsec(htmlizer(trim($_POST['maxpollqtlen'])));
			
		}
		
		
		//on error call the form
		if(!empty($error)){
			$theme['call_theme_func'] = 'manage_polls_theme';
			return false;		
		}
		
		
		//The array containing the POLL SETTING Changes
		$pollssetchanges = array('enablepolls' => $enablepolls,
						'maxoptionspoll' => $maxoptionspoll, 
						'maxpollqtlen' => $maxpollqtlen
						);

		if(!modify_registry($pollssetchanges)){
		
			return false;
			
		}
		
		//Redirect
		redirect('act=admin&adact=tpp&seadact=polls');
		
		return true;
		
	
	}else{
	
		$theme['call_theme_func'] = 'manage_polls_theme';
		
	}
	
}


//Default function to manage Censored Words
function manage_words(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error, $from, $to;
	
	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	
	$censor_words_case = 0;
		
	$from = explode('|', $globals['censor_words_from']);
	
	$to = explode('|', $globals['censor_words_to']);
	
	$censor_words_from = '';
	
	$censor_words_to = '';
	
	$words_r = array();
	
	
	//Clean one thing up
	foreach($from as $fk => $fv){
	
		$from[$fk] = str_replace('&bar;', '|', $from[$fk]);
		
		$to[$fk] = str_replace('&bar;', '|', $to[$fk]);
	
	}
	
	//Are we requested to go ahead
	if(isset($_POST['censorwords'])){
		
		
		//Check if Words to be censored are case sensitive
		if(isset($_POST['censor_words_case'])){
			
			$censor_words_case = 1;
		
		}
		
		//Check the Number of options in a poll:
		if((isset($_POST['from']) && is_array($_POST['from']))
		&& (isset($_POST['to']) && is_array($_POST['to']))){
			
			//No trimming
			$p_from = $_POST['from'];
			
			//No trimming
			$p_to = $_POST['to'];
			
			foreach($p_from as $k => $v){
				
				$p_from[$k] = inputsec(htmlizer($p_from[$k]));
				
				$p_to[$k] = inputsec(htmlizer($p_to[$k]));
				
				$temp = trim($v);
				
				//If no value in the from
				if(!empty($temp)){
					
					$p_from[$k] = str_replace('|', '&bar;', $p_from[$k]);
					
					$p_to[$k] = str_replace('|', '&bar;', $p_to[$k]);
					
					if(isset($words_r[$p_from[$k]])){
					
						continue;
					
					}else{
					
						$words_r[$p_from[$k]] = $p_to[$k];
					
					}
					
				}
				
				unset($temp);
			
			}
			
					
			$censor_words_from = implode('|', array_keys($words_r));
			
			$censor_words_to = implode('|', $words_r);
			
		}
		
		
		//The array containing the POLL SETTING Changes
		$censored_words = array('censor_words_case' => $censor_words_case,
						'censor_words_from' => $censor_words_from,
						'censor_words_to' => $censor_words_to
						);

		if(!modify_registry($censored_words)){
		
			return false;
			
		}
		
		//Redirect
		redirect('act=admin&adact=tpp&seadact=words');
		
		return true;
		
	
	}else{
	
		$theme['call_theme_func'] = 'manage_words_theme';
		
	}
	
	
}



//Default function to manage Censored Words
function manage_bbc(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
global $error;

	
	/////////////////////////////
	// Define the necessary VARS
	/////////////////////////////
	
	$error = array();
	$autolink = 0;//Whether to make non-links as links
	$parsebbc = 0;//If no dont parse
	$bbc_hr = 0;//Horizontal Rule
	$bbc_b = 0;//Bold
	$bbc_i = 0;//Italic
	$bbc_u = 0;//Underline
	$bbc_s = 0;//Strike Through
	$bbc_left = 0;//Left Align
	$bbc_right = 0;//Right Align
	$bbc_center = 0;//Center Align
	$bbc_size = 0;//Text Size
	$bbc_font = 0;//Font Face
	$bbc_sup = 0;//Superscript
	$bbc_sub = 0;//Subscript
	$bbc_color = 0;//Colour
	$bbc_url = 0;//Links
	$bbc_ftp = 0;//FTP links
	$bbc_email = 0;//Email Links
	$bbc_img = 0;//Images
	$showimgs = 0;//Show Images
	$bbc_flash = 0;//Flash
	$bbc_code = 0;//Code Block
	$bbc_quote = 0;//Quote Block
	$bbc_php = 0;//PHP Code Block
	$bbc_ul = 0;//Unordered Lists
	$bbc_ol = 0;//Ordered Lists
	$bbc_parseHTML = 0;//Execute HTML if the poster had permissions

	if(isset($_POST['editbbcset'])){
	
		//The array containing the BBC SETTINGS
		$bbcset = array('autolink' => 0,
						'parsebbc' => 0,
						'bbc_hr' => 0,
						'bbc_b' => 0,
						'bbc_i' => 0,
						'bbc_u' => 0,
						'bbc_s' => 0,
						'bbc_left' => 0,
						'bbc_right' => 0,
						'bbc_center' => 0,
						'bbc_size' => 0,
						'bbc_font' => 0,
						'bbc_sup' => 0,
						'bbc_sub' => 0,
						'bbc_color' => 0,
						'bbc_url' => 0,
						'bbc_ftp' => 0,
						'bbc_email' => 0,
						'bbc_img' => 0,
						'showimgs' => 0,
						'bbc_flash' => 0,
						'bbc_code' => 0,
						'bbc_quote' => 0,
						'bbc_php' => 0,
						'bbc_ul' => 0,
						'bbc_ol' => 0,
						'bbc_parseHTML' => 0
						);
		
		//Loop through			
		foreach($bbcset as $k => $v){
		
			//Check if Particular BBC setting is set
			if(isset($_POST[$k])){
				
				$bbcset[$k] = 1;
			
			}
		
		}

		if(!modify_registry($bbcset)){
		
			return false;
			
		}
		
		//Redirect
		redirect('act=admin&adact=tpp&seadact=bbc');
		
		return true;
	
	}else{
	
		$theme['call_theme_func'] = 'manage_bbc_theme';
		
	}
	
	
}

?>
