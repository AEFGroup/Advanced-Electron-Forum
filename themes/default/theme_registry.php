<?php

//////////////////////////////////////////////////////////////
//===========================================================
// theme_registry.php
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

////////////////////////////////////
// Theme settings (Themers options)
////////////////////////////////////

/* These theme settings will be used when being installed.
They will also be used whenever a user wants to set some options for this theme.
Similarly whenever the ADMIN wants to change theme settings this file will be used.

It must be in the $theme['registry'] .

To categorise it up it is necesssay to make a parent category 
under $theme['registry'] and then add the settings under that category
e.g. $theme['registry']['general'] is a category and $theme['registry']['general']['name'] is a theme setting.

$theme['registry']['general'] is a compulsory category and 

Foreach Theme setting you can use the following parameters
'type' :  values - 'text', 'checkbox', 'textarea'
				(Compulsory. Just for HTML forms)
'shortexp' : values - e.g 'Theme Name :'
				(Compulsory. Just for HTML forms)
'exp' : values - e.g 'The themes name as it would appear.'
				(Not Compulsory. Just for HTML forms.)
'value' : values - e.g 'Electron' 
				(Compulsory. This will be stored and will finally be used as $theme['name'])
'user' : values - true/false
				(Not Compulsory. If this is passed a user can set his own value for
				that setting too.)
				
				
/////////////////////////////////////////////////////
// Note : 1) 'Not Compulsory' keys are not necessary
// e.g. 'user' key if not set will set user option 
//      false.
// 		Similarly for 'exp', if it is not there then
//      no explanation will be echoed.
/////////////////////////////////////////////////////

NOTE : While installation $regisrty['path'] and $registry['url'] will be passed by default. So you may use it in any other registry key e.g. 'images' .

*/

$theme['registry'] = array();


//General theme Settings
$theme['registry']['general'] = array();
//The Themes name(EVERY theme must have this setting atleast)
$theme['registry']['general']['name'] = array('type' => 'text',
									'shortexp' => 'Theme Name :',
									'exp' => 'The themes name as it would appear.',
									'value' => 'Electron');
//The Themes DIRECTORY PATH
$theme['registry']['general']['path'] = array('type' => 'text',
									'shortexp' => 'Theme Path :',
									'exp' => 'The Themes DIRECTORY PATH.',
									'value' => $registry['path']);
//The Themes URL
$theme['registry']['general']['url'] = array('type' => 'text',
									'shortexp' => 'Theme HTTP URL :',
									'exp' => 'Would be used by the theme for various purposes.',
									'value' => $registry['url']);
// The HTTP URL of the images directory of the Theme(Only this contains a slash at the end)
// This is used by the theme itself and a themer may use his own way if desired
$theme['registry']['general']['images'] = array('type' => 'text',
									'shortexp' => 'Images HTTP URL :',
									'exp' => 'The HTTP URL of the images directory of the Theme.(Only this requires \'/\' at its end)',
									'value' => $registry['url'].'/images/');

//WYSIWYG AEF has it
$theme['registry']['posting']['wysiwyg'] = array('type' => 'checkbox',
									'shortexp' => 'Use WYSIWYG :',
									'exp' => 'Use What You See Is What You Get (Rich Text Editor) while posting.',
									'value' => true,
									'user' => true);

//AEF Has a shout box that is dragable. But we can fix it too
$theme['registry']['shoutbox']['fixshoutbox'] = array('type' => 'checkbox',
									'shortexp' => 'Fix shoutbox :',
									'exp' => 'This will make the shout box a fixed element making it appear always.',
									'value' => false);
									
//AEF Introduces a DOCK
$theme['registry']['JSDock']['showdock'] = array('type' => 'checkbox',
									'shortexp' => 'Show Dock :',
									'exp' => 'This will show a dock at the bottom of the Forum.',
									'value' => true,
									'user' => true);
									
//Header Logo
$theme['registry']['header']['headerimg'] = array('type' => 'text',
									'shortexp' => 'Header :',
									'exp' => 'You can change the Header banner here.',
									'value' => '');

//Header Ads
$theme['registry']['header']['headerads'] = array('type' => 'textarea',
									'shortexp' => 'Ad Code :',
									'exp' => 'Place the Ad code if you want to see ads after the Navigation Tree.(HTML is allowed.)',
									'value' => '');
									
//Show header navigation tree
$theme['registry']['header']['headernavtree'] = array('type' => 'checkbox',
									'shortexp' => 'Show header navigation tree :',
									'exp' => 'This will show a user which page of the Board he is viewing.',
									'value' => true);
									
//Show number of queries
$theme['registry']['footer']['shownumqueries'] = array('type' => 'checkbox',
									'shortexp' => 'Show Number of Queries :',
									'exp' => 'This will show the number of queries used to make a page.',
									'value' => true);

//Show the amount of time required to load the page				
$theme['registry']['footer']['showntimetaken'] = array('type' => 'checkbox',
									'shortexp' => 'Show Time Taken :',
									'exp' => 'This will show the number of seconds taken to make a page.',
									'value' => true);

//Show the amount of time required to load the page				
$theme['registry']['footer']['copyright'] = array('type' => 'text',
									'shortexp' => 'Copyright :',
									'exp' => 'You can add your Copyright at the bottom.(HTML is allowed)',
									'value' => '');

//Footer Ads
$theme['registry']['footer']['footerads'] = array('type' => 'textarea',
									'shortexp' => 'Ad Code :',
									'exp' => 'Place the Ad code if you want to place ads at the bottom of the page.(HTML is allowed.)',
									'value' => '');

//Show header navigation tree
$theme['registry']['footer']['footernavtree'] = array('type' => 'checkbox',
									'shortexp' => 'Show footer navigation tree :',
									'exp' => 'This will show a user which page of the Board he is viewing.',
									'value' => false);

?>