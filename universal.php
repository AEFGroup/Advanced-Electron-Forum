<?php

//////////////////////////////////////////////////////////////
//===========================================================
// universal.php
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

/* Database Connection */

$globals['user'] = '';
$globals['password'] = '';
$globals['database'] = '';
$globals['dbprefix'] = '';
$globals['server'] = '';

/* Ending - Database Connection */

/* Core Settings */

$globals['url'] = 'http://' . (empty($_SERVER['HTTP_HOST']) ? $_SERVER['SERVER_NAME'] : $_SERVER['HTTP_HOST']) . substr($_SERVER['PHP_SELF'], 0, -16);
$globals['server_url'] = '';
$globals['mainfiles'] = '';
$globals['themesdir'] = '';
$globals['installed'] = '';


/* Ending - Core Settings */
