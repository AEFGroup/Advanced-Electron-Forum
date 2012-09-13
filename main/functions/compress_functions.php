<?php

//////////////////////////////////////////////////////////////
//===========================================================
// compress_functions.php(functions)
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

if (!defined('AEF')) {

    die('Hacking Attempt');
}

////////////////////////////////////////////////
// Compresses the path given and returns output
////////////////////////////////////////////////
function compress_fn($path, $name, $method) {

    global $conn, $dbtables, $globals, $user, $logged_in;

    include_once($globals['mainfiles'] . '/classes/archive.php');

    if (!in_array($method, array('zip', 'tar', 'tgz', 'tbz'))) {

        return false;
    }

    //Call the appropriate class
    if ($method == 'zip') {

        $compress = new zip_file($name . '.' . $method);
    } elseif ($method == 'tar') {

        $compress = new tar_file($name . '.' . $method);
    } elseif ($method == 'tgz') {

        $compress = new gzip_file($name . '.' . $method);
    } elseif ($method == 'tbz') {

        $compress = new bzip_file($name . '.' . $method);
    }

    //Set options
    $compress->set_options(array('inmemory' => 1));

    //Add the path
    $compress->add_files($path);

    //Create archive
    $compress->create_archive();

    if (count($compress->error) > 0) {

        return false;
    } else {

        return $compress->archive;
    }
}

//////////////////////////////////////
// Decompresses zip, tgz, tbz2, tar
//////////////////////////////////////

function decompress_fn($file, $destination, $overwrite) {

    global $conn, $dbtables, $globals, $user, $logged_in;

    $pathinfo = pathinfo($file);

    //Is there an extension
    if (empty($pathinfo['extension'])) {

        return false;
    }

    $type = strtolower($pathinfo['extension']);

    //Are you a ZIP
    if ($type == 'zip') {

        if (!decompress_zip($file, $destination, $overwrite)) {

            return false;
        }

        //Tar
    } elseif ($type == 'tar') {

        if (!decompress_tar($file, $destination, $overwrite)) {

            return false;
        }

        //Tar GZ
    } elseif ($type == 'tgz') {

        if (!decompress_tgz($file, $destination, $overwrite)) {

            return false;
        }

        //Tar BZip2
    } elseif ($type == 'tbz') {

        if (!decompress_tbz($file, $destination, $overwrite)) {

            return false;
        }

        //Not supported by us
    } else {

        return false;
    }

    return true;
}

///////////////////////
// Decompresses TAR
///////////////////////

function decompress_tar_fn($file, $destination, $overwrite) {

    global $conn, $dbtables, $globals, $user, $logged_in;

    include_once($globals['mainfiles'] . '/classes/archive.php');

    $tar = new tar_file($file);

    $tar->set_options(array('inmemory' => 1)); //Keep in memory

    $tar->extract_files(); //Extract the files
    //Are there any errors
    if (!empty($tar->error)) {

        return false;
    }

    //Start writing the files only
    foreach ($tar->files as $k => $v) {

        //We need to give only files
        if ($v['type'] != 0) {

            continue;
        } else {
            if (!writefile($destination . '/' . $v['name'], $v['data'], $overwrite)) {

                return false;
            }
        }
    }

    return true;
}

///////////////////////
// Decompresses tar gz
///////////////////////

function decompress_tgz_fn($file, $destination, $overwrite) {

    global $conn, $dbtables, $globals, $user, $logged_in;

    include_once($globals['mainfiles'] . '/classes/archive.php');

    $gzip = new gzip_file($file);

    $gzip->set_options(array('inmemory' => 1)); //Keep in memory

    $gzip->extract_files(); //Extract the files
    //Are there any errors
    if (!empty($gzip->error)) {

        return false;
    }

    //Start writing the files only
    foreach ($gzip->files as $k => $v) {

        //We need to give only files
        if ($v['type'] != 0) {

            continue;
        } else {
            if (!writefile($destination . '/' . $v['name'], $v['data'], $overwrite)) {
                return false;
            }
        }
    }
    return true;
}

///////////////////////
// Decompresses Tar Bz
///////////////////////

function decompress_tbz_fn($file, $destination, $overwrite) {

    global $conn, $dbtables, $globals, $user, $logged_in;

    include_once($globals['mainfiles'] . '/classes/archive.php');

    $tbz = new bzip_file($file);

    $tbz->set_options(array('inmemory' => 1)); //Keep in memory

    $tbz->extract_files(); //Extract the files
    //Are there any errors
    if (!empty($tbz->error)) {

        return false;
    }

    //Start writing the files only
    foreach ($tbz->files as $k => $v) {

        //We need to give only files
        if ($v['type'] != 0) {

            continue;
        } else {

            if (!writefile($destination . '/' . $v['name'], $v['data'], $overwrite)) {

                return false;
            }
        }
    }

    return true;
}

///////////////////////
// Decompresses ZIP
///////////////////////

function decompress_zip_fn($file, $destination, $overwrite) {

    global $conn, $dbtables, $globals, $user, $logged_in;

    include_once($globals['mainfiles'] . '/classes/unzip.php');

    $zip = new SimpleUnzip();

    $zip->ReadFile($file);

    //Are there any files
    if ($zip->Count() == 0) {

        return false;
    }


    //Check each file was extracted properly
    foreach ($zip->Entries as $k => $v) {

        if ($zip->Entries[$k]['error'] != 0) {

            return false; //There was some errors
        } else {

            if (!writefile($destination . '/' . $v['path'] . '/' . $v['name'], $v['data'], $overwrite)) {

                return false;
            }
        }
    }

    return true;
}

?>
