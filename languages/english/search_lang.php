<?php

//////////////////////////////////////////////////////////////
//===========================================================
// search_lang.php(languages/english)
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


$l['cant_search_title'] = 'No Permissions';
$l['cant_search'] = 'Sorry, but you do not have permissions to use the search feature on the board. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['search'] = 'Search';//You are here

//Theme Strings
$l['<title>'] = 'Search';
$l['search_heading'] = 'Search the Board';
$l['find_results'] = 'Find results';
$l['all_words'] = 'with <b>all</b> of the words';
$l['exact_phrase'] = 'with the <b>exact phrase</b>';
$l['atleast_one_word'] = 'with <b>at least one</b> of the words';
$l['without_words'] = '<b>without</b> the words';
$l['search_within'] = 'Search within';
$l['within_posts'] = 'Posts';
$l['within_title'] = 'Topic Title';
$l['posted_started_by'] = '<b>Posted or Started</b> by';
$l['search_where'] = 'Search where';
$l['all_forums'] = 'All Forums';
$l['show_results_as'] = 'Show results as';
$l['show_topics'] = 'Topics';
$l['show_posts'] = 'Posts';
$l['submit_button'] = 'Search';


////////////////////////////////////////////////////////
//Function results() strings - The page showing results
////////////////////////////////////////////////////////

function results_lang(){

global $l, $globals;

$l['no_query'] = 'You did not give anything to search for.';
$l['no_within'] = 'You did not specify what to search within.';
$l['no_where'] = 'You did not specify which forum to search within.';//In which forums - WHERE ?
$l['invalid_where'] = 'Some of the forum you specified to search within are invalid.';
$l['no_showas'] = 'You did not specify in what form the results should be displayed.';

$l['no_page_found_title'] = 'No page found';//When no such page exists
$l['no_page_found'] = 'There is no such page of the searched results. If you have followed a valid link please contact us at <a href="mailto:'.$globals['board_email'].'">'.$globals['board_email'].'</a>.';

$l['no_results'] = 'Your search did not return any result.';


//Theme Strings
$l['<title>'] = 'Search Results';
$l['results_heading'] = 'Search Results';
$l['header_subject'] = 'Topic Subject';
$l['header_forum'] = 'Forum';
$l['header_started_by'] = 'Started By';
$l['header_replies'] = 'Replies';
$l['header_views'] = 'Views';
$l['header_last_post'] = 'Last Post';
$l['topic_contains'] = 'The topic contains';
$l['attachments'] = 'attachments';
$l['profile_of'] = 'View the profile of';
$l['by'] = 'by';
$l['go_to_last_post'] = 'Go to the last post';
$l['posted_on'] = 'Posted on';
$l['prefix_forum'] = 'Forum';
$l['prefix_replies'] = 'Replies';
$l[''] = '';
$l[''] = '';
$l[''] = '';

}


?>