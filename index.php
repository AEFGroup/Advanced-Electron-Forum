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

define('AEF', 1);

$user = array();
$theme = array();

//This causes some probems
ini_set('magic_quotes_runtime', 0);
ini_set('magic_quotes_sybase', 0);

//Set a error reporting to zero
error_reporting(E_ALL);

//fix errors regarding timezone
if (!ini_get('date.timezone')) {
  ini_set('date.timezone', 'Europe/Berlin');
}

//All imp info like DB username & pass.
include_once('universal.php');

//Some globals vars
include_once('globals.php');

//check if the script is installed or not - SAFAD
if($globals['installed'] == 0) die(header('Location: setup/index.php'));

//Make the connection
$conn = mysql_connect($globals['server'], $globals['user'], $globals['password']);
mysql_select_db($globals['database'], $conn) or die( "Unable to select database");

//A array of DB Tables prefixed with the prefix
include_once($globals['server_url'].'/dbtables.php');

//The necessary functions to run the Board
include_once($globals['mainfiles'].'/functions.php');

//ob_start('aefoutput_buffer');

//Will be available in future versions
//set_error_handler('errorhandler');

$start_time = microtime_float();//the clocks ticking

//////////////////////////////////////////
// Some settings are there in the registry
//////////////////////////////////////////

$qresult = makequery("SELECT r.*
		FROM ".$dbtables['registry']." r");


if((mysql_num_rows($qresult) > 0)){

	for($i = 0; $i < mysql_num_rows($qresult); $i++){
	
		$row = mysql_fetch_assoc($qresult);
		
		$globals[$row['name']] = $row['regval'];
	
	}

}

//Free the resources
@mysql_free_result($qresult);

SEO();

//This is required for UTF-8
if($globals['charset'] == 'UTF-8')	mysql_query('SET NAMES utf8');

if(isset($_GET['tid']) && trim($_GET['tid'])!==""){
$act = 'tid';
$tid = trim($_GET['tid']);

}elseif(isset($_GET['fid']) && trim($_GET['fid'])!==""){
$act = 'fid';
$fid = trim($_GET['fid']);

}elseif(isset($_GET['mid']) && trim($_GET['mid'])!==""){
$act = 'mid';

}elseif(isset($_GET['act']) && trim($_GET['act'])!==""){
$act = trim($_GET['act']);

}else{
$act = "";
}

header("Content-Type:text/html; charset=".$globals['charset']);

//Load the Functions Language File - This will be from the default Lang Folder
load_lang('index');

//Load Session File
include_once($globals['mainfiles'].'/sessions.php');

//Checks a user is logged in
include_once($globals['mainfiles'].'/checklogin.php');

//Is the user Logged In
$logged_in = checklogin();

//ReLoad the Functions Language File as per the users choice
load_lang('index');

//Check the BANNED IPs
BANNED();

//The URL for W3C Validation - Even present before loading themes
$globals['ind'] = str_replace('&', '&amp;', $globals['index_url']);

////////////////////////////////////////
// Is the user allowed to see the forum
////////////////////////////////////////

if($logged_in && !$user['view_forum'] && $act != 'logout'){

	//Report Error
	reporterror($l['cant_view_forum_title'], $l['cant_view_forum']);
	
}


/////////////////////////////////////
// Are we under going maintainenance
// then only Admins are allowed
/////////////////////////////////////

if($globals['maintenance'] && !$user['view_offline_board']){
	
	//During maintainenace what is to be allowed
	if(!in_array($act, array('login', 'sec_conf_image'))){
	
		//Redirect to log in
		redirect('act=login');

	}
	
}


/////////////////////////////////////
// IF only users allowed to view the
// forum then allow registration and
// login activities.
/////////////////////////////////////

if($globals['only_users'] && !$logged_in){
	
	//What is to be allowed in such times
	if(!in_array($act, array('login', 'register', 'sec_conf_image'))){
	
		//Redirect to log in
		redirect('act=login');

	}
	
}

switch($act){
	
	//The admin is calling so include its admin index file that handles administration and all.
	case 'admin':	
	include_once($globals['mainfiles'].'/admin/admin_functions.php');
	include_once($globals['mainfiles'].'/admin/index.php');
	break;
	
	//The default is - you guessed it right - The MainIndex
	default:	
	include_once($globals['mainfiles'].'/MainIndex.php');
	MainIndex();//from MainIndex.php
	break;	
	
	//The news related stuff
	case 'news':
	include_once($globals['mainfiles'].'/news.php');
	news();
	break;
	
	//Show the profile of a user
	case 'mid':
	include_once($globals['mainfiles'].'/profile.php');
	profile();
	break;
	
	//Delete a user - Pending
	case 'deleteuser':
	include_once($globals['mainfiles'].'/deleteuser.php');
	deleteuser();
	break;
	
	//Ban - Unban a user
	case 'ban':
	include_once($globals['mainfiles'].'/ban.php');
	ban();
	break;
	
	//Edit profile a user
	case 'editprofile':
	include_once($globals['mainfiles'].'/editprofile.php');
	editprofile();
	break;
	
	//Show the members list
	case 'members':
	include_once($globals['mainfiles'].'/members.php');
	members();
	break;
	
	//The active users list
	case 'active':
	include_once($globals['mainfiles'].'/active.php');
	active();
	break;
	
	/*//The forums stats
	case 'stats':
	include_once($globals['mainfiles'].'/stats.php');
	stats();
	break;*/
	
	//This is to get a list of unread topics
	case 'unread':
	include_once($globals['mainfiles'].'/unread.php');	
	unread();
	break;
	
	//The boards search engine
	case 'search':
	include_once($globals['mainfiles'].'/search.php');	
	search();
	break;
	
	//Download a attachment
	case 'downloadattach':
	include_once($globals['mainfiles'].'/attachments.php');
	download();
	break;
	
	//Mark all the messages as read
	case 'markread':
	include_once($globals['mainfiles'].'/markread.php');
	markread();
	break;
	
	//this is for registering an account
	case 'register':
	include_once($globals['mainfiles'].'/register.php');
	register();//The main registration function
	break;
	
	//this is for (You know it) to log in
	case 'login':		
	include_once($globals['mainfiles'].'/login.php');
	login();//The main login function
	break;
	
	//This for logging out
	case 'logout':
	include_once($globals['mainfiles'].'/logout.php');
	logout();//This will log you out
	break;
	
	//Image Maker - Validation Image for the Registration
	case 'sec_conf_image':
	include_once($globals['mainfiles'].'/imagemaker.php');
	regimagemaker();//The Cofirmation code is a Parameter
	break;
	
	case 'fid':
	include_once($globals['mainfiles'].'/topics.php');
	topics();//main fuction from topics.php
	break;
	
	case 'notify':
	include_once($globals['mainfiles'].'/notify.php');
	notify();
	break;
	
	case 'tid':
	include_once($globals['mainfiles'].'/posts.php');	
	posts();//main fuction from posts.php
	break;
	
	//To Lock or Unlock a topic
	case 'locktopic':
	include_once($globals['mainfiles'].'/locktopic.php');	
	locktopic();//main fuction from locktopic.php
	break;
	
	//To Pin or Unpin a topic
	case 'pintopic':
	include_once($globals['mainfiles'].'/pintopic.php');	
	pintopic();//main fuction from pintopic.php
	break;
	
	//This is to edit topic
	case 'edittopic':
	include_once($globals['mainfiles'].'/edittopic.php');	
	edittopic();
	break;
	
	//This is to merge topics
	case 'mergetopics':
	include_once($globals['mainfiles'].'/mergetopics.php');	
	mergetopics();
	break;
	
	//This is to edit post
	case 'edit':
	include_once($globals['mainfiles'].'/editpost.php');	
	editpost();
	break;
	
	//This is to merge posts
	case 'mergeposts':
	include_once($globals['mainfiles'].'/mergeposts.php');	
	mergeposts();
	break;
	
	//This is to delete post
	case 'delete':
	include_once($globals['mainfiles'].'/delete.php');	
	delete();
	break;
	
	//Removes the poll
	case 'removepoll':
	include_once($globals['mainfiles'].'/poll.php');	
	removepoll();
	break;
	
	//This is to edit a poll
	case 'editpoll':
	include_once($globals['mainfiles'].'/poll.php');	
	editpoll();
	break;
	
	//This is to post a poll
	case 'postpoll':
	include_once($globals['mainfiles'].'/poll.php');	
	postpoll();
	break;
	
	case 'tellafriend':
	include_once($globals['mainfiles'].'/tellafriend.php');	
	tellafriend();
	break;
	
	//This is just the form for starting a new topic
	case 'topic':
	include_once($globals['mainfiles'].'/newtopic.php');
	newtopic();//main fuction from postatopic.php	
	break;
	
	//This is to delete topic
	case 'deletetopic':
	include_once($globals['mainfiles'].'/deletetopic.php');	
	deletetopic();
	break;
	
	//This is to move a topic
	case 'movetopic':
	include_once($globals['mainfiles'].'/movetopic.php');
	movetopic();
	break;
	
	//This is just the form for starting a new topic
	case 'post':
	include_once($globals['mainfiles'].'/reply.php');	
	reply();
	break;
	
	//This is the Users Control Panel
	case 'usercp':
	include_once($globals['mainfiles'].'/usercp/index.php');	
	usercp();//main fuction from usercp.php
	break;
	
	//Suggest the usernames
	case 'suggest':
	include_once($globals['mainfiles'].'/suggest.php');
	suggest();
	break;
	
	//Shout Box
	case 'shoutbox':
	include_once($globals['mainfiles'].'/shoutbox.php');
	shoutbox();
	break;
	
	//RSS Feeds
	case 'feeds':
	include_once($globals['mainfiles'].'/feeds.php');
	feeds();
	break;
	
	//Calendar
	case 'calendar':
	include_once($globals['mainfiles'].'/calendar.php');
	calendar();
	break;
	
	//Report
	case 'report':
	include_once($globals['mainfiles'].'/report.php');
	report();
	break;
	
	//Special Cases to get past the Switch before entering the Switch
	case 'error_break':
	break;
	
	
}//end of switch
	

//We must try to save the session
save_session();

//I Finished first
$end_time = microtime_float();

//Clean For XSS and Extra Slashes('\') if magic_quotes_gpc is ON 
$_GET = cleanVARS($_GET);
$_POST = cleanVARS($_POST);


///////////////////////////
// Load the theme settings
///////////////////////////

load_theme_settings($globals['theme_id']);

//The URL for W3C Validation
$globals['ind'] = str_replace('&', '&amp;', $globals['index_url']);

///////////////////////////////////////
// Load the theme's headers and footers
///////////////////////////////////////

if(!empty($load_hf) && init_theme('hf', 'Headers and Footers')){
		
	//Finally the file is loaded
	if(init_theme_func(array('aefheader', 
							'aeffooter', 
							'error_handle', 
							'majorerror', 
							'message'), 'Headers and Footers')){
	
		$globals['hf_loaded'] = 1;
	
	}
	
}


/////////////////////////////////////////////////////
// Load the Admin Center theme's headers and footers
/////////////////////////////////////////////////////

if(!empty($load_ahf) && init_theme('admin/adminhf', 'Admin Center Headers and Footers')){
		
	//Finally the file is loaded
	init_theme_func(array('adminhead', 'adminfoot'), 'Admin Center Headers and Footers');
	
}


///////////////////////////////////////
// Load the UserCP headers and footers
///////////////////////////////////////

if(!empty($load_uhf) && init_theme('usercp/usercphf', 'UserCP Headers and Footers')){
		
	//Finally the file is loaded
	init_theme_func(array('usercphead', 'usercpfoot'), 'UserCP Headers and Footers');
	
}


//Are we to load any theme or just pass
if(!empty($theme['init_theme']) && empty($errormessage) 
	&& empty($messagetext) && empty($redirect) && $globals['hf_loaded']){

	//Initialize the theme
	if(init_theme($theme['init_theme'], $theme['init_theme_name'])){
	
		//Initialize the Theme function
		if(init_theme_func($theme['init_theme_func'], $theme['init_theme_name'])){
			
			/////////////////////////
			// Load all other things
			/////////////////////////
		
			//Load the news if there
			if($globals['enablenews']){
			
				include_once($globals['mainfiles'].'/news.php');
				
				$newslinks = newslinks();
			
			}
			
			call_user_func($theme['call_theme_func']);
		
		}
		
	}
	
}


////////////////////////////////////////
// Check is some error triggered before
////////////////////////////////////////

if(!empty($errormessage)){
	
	if($globals['hf_loaded']){
	
		//Call Major Error
		majorerror($errortitle ,$errormessage, $errorheading);
		
	}else{
	
		echo $errormessage;
	
	}

}

if(!empty($messagetext) && empty($errormessage)){
	
	if($globals['hf_loaded']){
	
		//Show Message
		message($messagetitle, $messageheading, $messageicon, $messagetext);
		
	}else{
	
		echo $messagetext;
	
	}

}

@ob_end_flush();

mysql_close($conn);

die();

?>
