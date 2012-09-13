<?php

//////////////////////////////////////////////////////////////
//===========================================================
// backup.php(Admin)
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

function backup() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    if (!load_lang('admin/backup')) {

        return false;
    }

    //The name of the file
    $theme['init_theme'] = 'admin/backup';

    //The name of the Page
    $theme['init_theme_name'] = 'Admin Center - Backup';

    //Array of functions to initialize
    $theme['init_theme_func'] = array('fileback_theme', 'dbback_theme');

    //My activity
    $globals['last_activity'] = 'aback';


    //If a second Admin act is set then go by that
    if (isset($_GET['seadact']) && trim($_GET['seadact']) !== "") {

        $seadact = inputsec(htmlizer(trim($_GET['seadact'])));
    } else {

        $seadact = "";
    }


    //The switch handler
    switch ($seadact) {

        //The form for backing up files
        default:
        case 'fileback':
            fileback();
            break;

        //The form for backing up the database
        case 'dbback':
            dbback();
            break;
    }
}

//Function to backup files and folders
function fileback() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $error;


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $error = array();

    //Profile Settings
    $folderpath = ''; //The folder to backup

    $compression = ''; //The compression method

    $localpath = 0; //The path if we have to write it on the server itself

    if (isset($_POST['startfileback'])) {

        //The folderpath
        if (!(isset($_POST['folderpath'])) || (trim($_POST['folderpath']) == "")) {

            $error[] = $l['no_path'];
        } else {

            $folderpath = inputsec(htmlizer(trim($_POST['folderpath'])));

            $folderpath = rtrim($folderpath, '/\\');

            if (!is_readable($folderpath)) {

                $error[] = $l['no_readable_path'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'fileback_theme';
            return false;
        }


        //The compression method
        if (!(isset($_POST['compression'])) || (trim($_POST['compression']) == "")) {

            $error[] = $l['no_compression'];
        } else {

            $compression = inputsec(htmlizer(trim($_POST['compression'])));

            if (!in_array($compression, array('zip', 'tar', 'tgz', 'tbz'))) {

                $error[] = $l['compression_invalid'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'fileback_theme';
            return false;
        }

        //Are we to store locally
        if (isset($_POST['localpath']) && (trim($_POST['localpath']) != "")) {

            $localpath = inputsec(htmlizer(trim($_POST['localpath'])));

            $localpath = rtrim($localpath, '/\\');

            if (!is_writable($localpath)) {

                $error[] = $l['unaccessible_local_path'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'fileback_theme';
            return false;
        }

        //Try to give some more time
        @set_time_limit(300);

        //Memory limit
        @ini_set('memory_limit', '128M');


        $filename = basename($folderpath) . '(' . date('Y-m-d') . ')';

        $data = compress($folderpath, $filename, $compression);

        //Did it compress
        if (empty($data)) {

            $error[] = $l['errors_compressing_data'];

            //on error call the form
            if (!empty($error)) {
                $theme['call_theme_func'] = 'fileback_theme';
                return false;
            }
        }


        //What to do ? Output the file
        if (empty($localpath)) {

            $globals['stop_buffer_process'] = true;

            //Give the headers
            switch ($compression) {
                case "zip":
                    header("Content-Type: application/zip");
                    break;
                case "tbz":
                    header("Content-Type: application/x-bzip2");
                    break;
                case "tbz":
                    header("Content-Type: application/x-gzip");
                    break;
                case "tar":
                    header("Content-Type: application/x-tar");
                    break;
            }

            //There are so many headers/headaches
            header('Content-Disposition: attachment; filename="' . $filename . '.' . $compression . '"');
            header('Accept-Ranges: bytes');
            header('Content-Encoding: none');
            header("Content-Length: " . aefstrlen($data));
            header("Content-Transfer-Encoding: binary");
            header('Content-Type: application/octetstream');
            header("Cache-Control: no-cache, must-revalidate, private");
            header('Connection: close');
            echo $data;

            //No - Store it
        } else {

            if (writefile($localpath . '/' . $filename . '.' . $compression, $data, 0)) {

                //Give a message
                reportmessage($l['backup_ok'], $l['backup_created_ok'], '', $l['backup_created_ok_exp']);

                return true;
            } else {

                $error[] = $l['errors_writing'];

                //on error call the form
                if (!empty($error)) {
                    $theme['call_theme_func'] = 'fileback_theme';
                    return false;
                }
            }
        }

        return true;
    } else {

        $theme['call_theme_func'] = 'fileback_theme';
    }
}

//Function to manage Avatar settings
function dbback() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $error;


    /////////////////////////////
    // Define the necessary VARS
    /////////////////////////////

    $error = array();

    $tables = array(); //The name of the tables

    $localpath = ''; //Store Locally

    $crlf = "\n"; //MySQL loves \n on all platforms

    $data = '';

    if (isset($_POST['dbback'])) {

        //r_print($_POST);
        //Check the Avatar Directory
        if (!(isset($_POST['tables'])) || !is_array($_POST['tables'])) {

            $error[] = $l['no_tables_specified'];
        } else {

            $tables = $_POST['tables'];

            $keys = array_keys($dbtables);

            foreach ($tables as $k => $v) {

                $tables[$k] = $v = trim($v);

                //Is it a valid table
                if (!in_array($v, $keys)) {

                    $error[] = $l['tables_invalid'];
                    break;
                }
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'dbback_theme';
            return false;
        }


        //The compression method
        if (!(isset($_POST['compression'])) || (trim($_POST['compression']) == "")) {

            $error[] = $l['no_compression'];
        } else {

            $compression = inputsec(htmlizer(trim($_POST['compression'])));

            if (!in_array($compression, array('none', 'zip', 'gzip', 'bzip'))) {

                $error[] = $l['compression_invalid'];
            }
        }


        //Are we to store locally
        if (isset($_POST['localpath']) && (trim($_POST['localpath']) != "")) {

            $localpath = inputsec(htmlizer(trim($_POST['localpath'])));

            $localpath = rtrim($localpath, '/\\');

            if (!is_writable($localpath)) {

                $error[] = $l['unaccessible_local_path'];
            }
        }

        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'dbback_theme';
            return false;
        }

        //Select atlest the Data or structure
        if (!isset($_POST['data']) && !isset($_POST['structure'])) {

            $error[] = $l['select_structure_data'];

            //on error call the form
            if (!empty($error)) {
                $theme['call_theme_func'] = 'dbback_theme';
                return false;
            }
        }


        //Try to give some more time
        @set_time_limit(450);

        //Memory limit
        @ini_set('memory_limit', '128M');


        //////////////////////////////
        // Lets Start making the data
        //////////////////////////////
        //AEF Headers
        $data = '-- ////////////////////////////////////////////////////////////' . $crlf .
                '-- ===========================================================' . $crlf .
                '--  AEF MySQL Export' . $crlf .
                '-- ===========================================================' . $crlf .
                '--  AEF : Advanced Electron Forum ' . $crlf .
                '--  Version : 1.0.4' . $crlf .
                '--  ----------------------------------------------------------' . $crlf .
                '--  Date:           ' . date('jS F, Y') . '' . $crlf .
                '--  Time:           ' . date('g:i a') . '' . $crlf .
                '--  PHP Version:    ' . phpversion() . '' . $crlf .
                '--  MySQL Version:  ' . mysql_get_server_info() . '' . $crlf .
                '--  ----------------------------------------------------------' . $crlf .
                '-- ===========================================================' . $crlf .
                '--  (C)AEF Group All Rights Reserved.' . $crlf .
                '-- ===========================================================' . $crlf .
                '-- ////////////////////////////////////////////////////////////' . $crlf .
                $crlf .
                '-- ----------------------------------------------------------' . $crlf .
                $crlf .
                $crlf;

        foreach ($tables as $k => $v) {

            if (isset($_POST['structure'])) {

                $data .= tablestructure($dbtables[$v], $crlf);
            }

            if (isset($_POST['data'])) {

                $data .= tabledata($dbtables[$v], $crlf);
            }

            //Ending this table
            $data .= $crlf .
                    '-- ----------------------------------------------------------' . $crlf .
                    $crlf;
        }

        $ext = '';
        if ($compression == 'zip') {
            $ext = '.zip';
        } elseif ($compression == 'gzip') {
            $ext = '.gz';
        } elseif ($compression == 'bzip') {
            $ext = '.bz';
        }

        $filename = $globals['database'] . '(' . date('Y-m-d') . ').sql' . $ext;


        //Compress
        if ($compression == 'zip') {

            if (@function_exists('gzcompress')) {

                $zip = zipclass();

                $zip->add_file($data, substr($filename, 0, -4));

                $data = $zip->file();
            } else {

                $error[] = $l['no_zip'];
            }
        } elseif ($compression == 'gzip') {

            if (@function_exists('gzencode')) {

                $data = gzencode($data);
            } else {

                $error[] = $l['no_gzip'];
            }
        } elseif ($compression == 'bzip') {

            if (@function_exists('bzcompress')) {

                $data = bzcompress($data);

                if ($data === -8) {

                    $error[] = $l['no_bzip'];
                }
            } else {

                $error[] = $l['no_bzip'];
            }
        }


        //on error call the form
        if (!empty($error)) {
            $theme['call_theme_func'] = 'dbback_theme';
            return false;
        }


        //What to do ? Output the file
        if (empty($localpath)) {

            $globals['stop_buffer_process'] = true;

            //Give the headers
            switch ($compression) {
                case "zip":
                    header("Content-Type: application/zip");
                    break;
                case "bzip":
                    header("Content-Type: application/x-bzip2");
                    break;
                case "gzip":
                    header("Content-Type: application/x-gzip");
                    break;
                case "none":
                    break;
            }

            //There are so many headers/headaches
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Accept-Ranges: bytes');
            header('Content-Encoding: none');
            header("Content-Length: " . aefstrlen($data));
            header("Content-Transfer-Encoding: binary");
            header('Content-Type: application/octetstream');
            header("Cache-Control: no-cache, must-revalidate, private");
            header('Connection: close');
            echo $data;

            //No - Store it
        } else {

            if (writefile($localpath . '/' . $filename, $data, 0)) {

                //Give a message
                reportmessage($l['backup_ok'], $l['backup_created_ok'], '', $l['backup_created_ok_exp']);

                return true;
            } else {

                $error[] = $l['errors_writing'];

                //on error call the form
                if (!empty($error)) {
                    $theme['call_theme_func'] = 'dbback_theme';
                    return false;
                }
            }
        }

        return true;
    } else {

        $theme['call_theme_func'] = 'dbback_theme';
    }
}

//Creates the tables structure
function tablestructure($table, $crlf) {

    $create_query = '';

    $str = $crlf .
            '-- ' . $crlf .
            '-- Table structure for table ' . backquotes($table) . $crlf .
            '-- ' . $crlf;

    //Put a drop table statement
    if (isset($_POST['droptable'])) {

        $str .= $crlf . 'DROP TABLE IF EXISTS ' . backquotes($table) . ';' . $crlf;
    }

    /* $str .= 'CREATE TABLE';

      //IF NOT EXISTS
      if(isset($_POST['ifnotexists'])){

      $str .= ' IF NOT EXISTS';

      }

      //The table name
      $str .= backquotes($table).' ('.$crlf;

      //Get the fields
      $qresult = makequery("SHOW COLUMNS FROM ".$table, false);

      //Start the loop
      for($i = 1; $i <= mysql_num_rows($qresult); $i++){

      $row = mysql_fetch_assoc($qresult);

      $str .= '  '.backquotes($row['Field']).' '.$row['Type'].($row['Null'] != 'YES' ? ' NOT NULL' : '');

      } */

    //SET backquotes or not
    if (isset($_POST['backquotes'])) {

        $qresult = makequery("SET SQL_QUOTE_SHOW_CREATE = 1", false);
    } else {

        $qresult = makequery("SET SQL_QUOTE_SHOW_CREATE = 0", false);
    }

    //MySQL Can create its own tables
    $qresult = makequery("SHOW CREATE TABLE " . $table);

    if (mysql_num_rows($qresult) > 0) {

        $row = mysql_fetch_row($qresult);

        $create_query = $row[1];

        unset($row);


        //Convert end of line chars to one that we want
        if (strpos($create_query, "(\r\n ")) {

            $create_query = str_replace("\r\n", $crlf, $create_query);
        } elseif (strpos($create_query, "(\n ")) {

            $create_query = str_replace("\n", $crlf, $create_query);
        } elseif (strpos($create_query, "(\r ")) {

            $create_query = str_replace("\r", $crlf, $create_query);
        }


        //Should we use IF NOT EXISTS?
        if (isset($_POST['ifnotexists'])) {

            $create_query = preg_replace('/^CREATE TABLE/', 'CREATE TABLE IF NOT EXISTS', $create_query);
        }
    }

    @mysql_free_result($qresult);

    $str .= $create_query;


    //Autoincrement value
    $qresult = makequery("SHOW TABLE STATUS    LIKE '" . strtr($table, array('_' => '\\_', '%' => '\\%')) . "'", false);

    $row = mysql_fetch_assoc($qresult);

    //remove a possible "AUTO_INCREMENT = value" clause
    //that could be there starting with MySQL 5.0.24
    $str = preg_replace('/AUTO_INCREMENT\s*=\s*([0-9])+/', '', $str);

    if (isset($_POST['autoincrement']) && !empty($row['Auto_increment'])) {

        $auto_increment = ' AUTO_INCREMENT=' . $row['Auto_increment'] . ' ';

        $str .= $auto_increment;
    }

    $str .= ';' . $crlf . $crlf;

    return $str;
}

//Gives the Tables Data of a table
function tabledata($table, $crlf) {

    $data = '';

    $delayed = '';

    $ignore = '';

    if (isset($_POST['delayed'])) {

        $delayed = " DELAYED";
    }

    if (isset($_POST['ignore'])) {

        $ignore = " IGNORE";
    }

    //Get everything from the table
    $qresult = makequery("SELECT /*!40001 SQL_NO_CACHE */ * FROM " . $table);

    //Loop
    for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

        $row = mysql_fetch_assoc($qresult);

        foreach ($row as $k => $v) {

            if (is_numeric($v)) {

                $row[$k] = $v;
            } else {

                $row[$k] = "'" . mysql_real_escape_string($v) . "'";
            }
        }

        $data .= "INSERT " . $delayed . $ignore . "INTO " . backquotes($table) . " VALUES (" . implode(', ', $row) . ");" . $crlf;

        unset($row);
    }

    @mysql_free_result($result);

    //Is the data string empty
    if (empty($data)) {

        return '';
    }

    return $crlf .
    '-- ' . $crlf .
    '-- Data for table ' . backquotes($table) . $crlf .
    '-- ' . $crlf .
    $crlf .
    $data .
    $crlf;
}

function backquotes($string) {

    if (isset($_POST['backquotes'])) {

        $string = '`' . $string . '`';
    }

    return $string;
}

?>
