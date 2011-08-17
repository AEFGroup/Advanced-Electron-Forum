<?php

//////////////////////////////////////////////////////////////
//===========================================================
// plugin.php
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

if (!defined('AEF')) {
    die('Hacking Attempt');
}

function initiate_plugins() {
    global $globals, $dbtables;
    $plugin_dir = $globals['pluginsdir'];
    //first we get list of files
    if ($handle = opendir($plugin_dir)) {
        while (false !== ($file = readdir($handle))) {
            //check file extension
            $file_ext = pathinfo($file, PATHINFO_EXTENSION);
            $file_name = pathinfo($file, PATHINFO_FILENAME);
            
            //make sure we are not looking at . and .. and files that don't end with php ext
            if ($file != '.' && $file != '..' && $file_ext == 'php') {
                //Now we check if the plugin is activated or not
                $qresult = makequery("SELECT *
                    FROM " . $dbtables['plugins'] . "
                    WHERE plg_name = '" . $file . "'
                    AND activated = '1'");
                if (mysql_num_rows($qresult) > 0) {
                    //yes the plugin is activated; include
                    include($plugin_dir . '/' . $file);
                    //initiate
                    ob_start($file_name . "_ob_handler");
                }
            }
        }
        closedir($handle);
    }
}

function get_plugin_info($plugin_file, $check = FALSE) {
    global $globals;
    $file_name = $globals['pluginsdir'] . '/' . $plugin_file;
    //include file while preventing output;to get variables we need only
    ob_start();
    include $file_name;
    ob_end_clean();
    //we first check if the array is declared, and that Name and Version are declared too !
    if (isset($plugin_info) && array_key_exists('Name', $plugin_info) && array_key_exists('Version', $plugin_info)) {
        //yes everything is cool, return now
        if ($check == FALSE) {
            return $plugin_info;
        } else {
            return TRUE;
        }
    } else {
        //something is wrong, inform it !
        return FALSE;
    }
}

function get_plugin_list() {
    global $globals;
    $plugins = array();
    //first we get list of files
    $handle = opendir($globals['pluginsdir']);
    if ($handle != false) {
        while (false !== ($file = readdir($handle))) {
            //check file extension
            $file_ext = pathinfo($file, PATHINFO_EXTENSION);
            $file_name = pathinfo($file, PATHINFO_FILENAME);
            //make sure we are not looking at . and .. and files that don't end with php ext also it must a plugin
            if ($file != '.' && $file != '..' && $file_ext == 'php' && get_plugin_info($file) == TRUE) {
                $plugins[] = $file;
            }
        }
        closedir($handle);
    }
    return $plugins;
}
