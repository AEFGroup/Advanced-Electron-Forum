<?php

//////////////////////////////////////////////////////////////
//===========================================================
// file_functions.php(functions)
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

//////////////////////////////////////
// Writes a file to the filename given
//////////////////////////////////////

function writefile_fn($file, $data, $overwrite) {

    global $conn, $dbtables, $globals, $user, $logged_in;

    $pathinfo = pathinfo($file);

    $folderpath = '';

    $folders = explode('/', $pathinfo['dirname']);

    //Create folders if they are not there
    foreach ($folders as $folder) {

        $folderpath = (!empty($folderpath)) ? $folderpath . '/' . $folder : $folder;

        if (!is_dir($folderpath)) {

            if (!mkdir($folderpath, 0777)) {

                return false;
            }

            //Try to give access
            chmod($folderpath, 0777);
        }
    }

    //Does the file exist
    if (file_exists($file) && empty($overwrite)) {

        return false;
    }


    //Create and Open the file for writing
    if (!$fp = fopen($file, "wb")) {

        return false;
    }

    //Write the contents
    if (fwrite($fp, $data) === FALSE) {

        return false;
    }

    //Close the handle
    fclose($fp);

    return true;
}

function get_web_file_fn($url, $writefilename = '') {

    global $globals;

    $allow_url_open = (int) ini_get('allow_url_fopen');

    if (empty($allow_url_open)) {

        return false;
    }

    //Read the file
    $file = implode('', file($url));

    //Did we get something
    if (empty($file)) {

        return false;
    }

    //Are we to store the file
    if (empty($writefilename)) {

        return $file;

        //Store the file
    } else {

        $fp = fopen($writefilename, "wb"); //This opens the file
        //If its opened then proceed
        if ($fp) {

            if (fwrite($fp, $file) === FALSE) {

                return false;

                //Wrote the file
            } else {

                fclose($fp);

                return true;
            }
        }
    }

    return false;
}

//End of function



/* The below function will list all folders and files within a directory
  It is a recursive function that uses a global array.  The global array was the easiest
  way for me to work with an array in a recursive function
 * This function has no limit on the number of levels down you can search.
 * The array structure was one that worked for me.
  ARGUMENTS:
  $startdir => specify the directory to start from; format: must end in a "/"
  $searchSubdirs => True/false; True if you want to search subdirectories
  $directoriesonly => True/false; True if you want to only return directories
  $maxlevel => "all" or a number; specifes the number of directories down that you want to search
  $level => integer; directory level that the function is currently searching
 */

function filelist_fn($startdir="./", $searchSubdirs=1, $directoriesonly=0, $maxlevel="all", $level=1) {
    //list the directory/file names that you want to ignore
    $ignoredDirectory[] = ".";
    $ignoredDirectory[] = "..";
    $ignoredDirectory[] = "_vti_cnf";
    global $directorylist;    //initialize global array
    if (is_dir($startdir)) {
        if ($dh = opendir($startdir)) {
            while (($file = readdir($dh)) !== false) {
                if (!(array_search($file, $ignoredDirectory) > -1)) {
                    if (filetype($startdir . $file) == "dir") {

                        //build your directory array however you choose;
                        //add other file details that you want.

                        $directorylist[$startdir . $file]['level'] = $level;
                        $directorylist[$startdir . $file]['dir'] = 1;
                        $directorylist[$startdir . $file]['name'] = $file;
                        $directorylist[$startdir . $file]['path'] = $startdir;
                        if ($searchSubdirs) {
                            if ((($maxlevel) == "all") or ($maxlevel > $level)) {
                                filelist($startdir . $file . "/", $searchSubdirs, $directoriesonly, $maxlevel, $level + 1);
                            }
                        }
                    } else {
                        if (!$directoriesonly) {
                            if (in_array(substr(strrchr($file, "."), 1), array('png', 'gif'))) {
                                //  echo substr(strrchr($file, "."), 1);
                                //if you want to include files; build your file array 
                                //however you choose; add other file details that you want.
                                $directorylist[$startdir . $file]['level'] = $level;
                                $directorylist[$startdir . $file]['dir'] = 0;
                                $directorylist[$startdir . $file]['name'] = $file;
                                $directorylist[$startdir . $file]['path'] = $startdir;
                            }
                        }
                    }
                }
            }
            closedir($dh);
        }
    }
    return($directorylist);
}

//Using Example
/* $files = filelist("./smileys/default/",1,0); // call the function
  foreach ($files as $list) {//print array
  echo "Directory: " . $list['dir'] . " => Level: " . $list['level'] . " => Name: " . $list['name'] . " => Path: " . $list['path'] ."<br />";
  } */
?>
