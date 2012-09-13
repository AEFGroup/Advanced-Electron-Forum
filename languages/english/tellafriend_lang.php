<?php

//////////////////////////////////////////////////////////////
//===========================================================
// tellafriend_lang.php(languages/english)
//===========================================================
// AEF : Advanced Electron Forum
// Version : 1.0.10
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


$l['taf_disabled_title'] = 'Disabled';
$l['taf_disabled'] = 'This feature has been disabled on the board. Inconvenience is regretted. If you have any questions please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.<br /><br />Thank You!';

$l['no_taf_permissions_title'] = 'Access Denied';
$l['no_taf_permissions'] = 'You do not have the permissions to email a topic of this board to anyone. You may go to the Main Forum Index and use the Boards Facilities. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.<br /><br />Thank You!';

$l['tellafriend_message'] = 'I thought you might be interested in reading this web page:
' . $globals['index_url'] . 'tid=&aefv-1;

From,
&aefv-2;';

$l['no_topic_specified_title'] = 'No topic specified';
$l['no_topic_specified'] = 'Sorry, we were unable to load any topic because the topic id was not specified. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.';

$l['no_topic_found_title'] = 'No Topic Found';
$l['no_topic_found'] = 'Sorry, we were unable to find the topic you specified as it is not existing in our system. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.';

$l['no_forum_found_title'] = 'No forum found';
$l['no_forum_found'] = 'The forum you specified either does not exists or you are not authorised to view the same. If you have followed a valid link please contact us at <a href="mailto:' . $globals['board_email'] . '">' . $globals['board_email'] . '</a>.';

$l['telling_a_friend'] = 'Telling a friend'; //For the 'You are here'
//Posting Errors
$l['no_name'] = 'You did not enter your name.';
$l['no_recipient'] = 'You did not enter the Recipients name.';
$l['no_recipient_email'] = 'You did not enter the Recipients email address.';
$l['recipient_email_invalid'] = 'The Recipients Email Address is invalid.';
$l['no_subject'] = 'The subject of the email was missing.';
$l['no_message'] = 'The message body of the email was missing.';

$l['tellafriend_mail'] = 'Hello &aefv-1;,

You have been sent a message by &aefv-2; from ' . $globals['sn'] . '.
' . $globals['url'] . '/

The message is as follows:

&aefv-3;

------------------------------------------------------------
Please note that ' . $globals['sn'] . ' has no control over the
contents of this message and takes no responsibility for
the same.
------------------------------------------------------------

The ' . $globals['sn'] . ' Team
' . $globals['url'] . '/';

//Theme Strings
$l['<title>'] = 'Email a topic to a friend';
$l['tellafriend_heading'] = 'Tell a friend';
$l['your_name'] = 'Your Name';
$l['your_name_exp'] = 'Enter your name.';
$l['recipients_name'] = 'Recipients Name';
$l['recipients_name_exp'] = 'Enter the persons name whom you want to email this topic.';
$l['recipients_email'] = 'Recipients Email Address';
$l['recipients_email_exp'] = 'Please enter a valid email address for your account.';
$l['subject'] = 'Subject';
$l['message'] = 'Message';
$l['submit_button'] = 'Submit';
?>