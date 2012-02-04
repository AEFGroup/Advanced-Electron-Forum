<?php

//////////////////////////////////////////////////////////////
//===========================================================
// functions.php
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

//Time calculation
function microtime_float() {

    list($usec, $sec) = explode(" ", microtime());

    return ((float) $usec + (float) $sec);
}

//If $format is given then TODAY feature is overided
function datify($timestamp, $today = true, $adjust = true, $format = false) {

    global $l, $user, $globals;

    //Are we to adjust time - By default yes
    if (!empty($adjust)) {

        $timestamp = max(0, $timestamp - ( (date('Z', time()) / 3600) - $globals['pgtimezone']) * 3600);
    }

    if (!empty($format)) {

        return date($format, $timestamp);
    }

    $todaytime = max(0, time() - ( (date('Z', time()) / 3600) - $globals['pgtimezone']) * 3600);

    //The date thingy
    if ($today && date("F j, Y", $timestamp) == date("F j, Y", $todaytime)) {

        $time = date("g:i a", $timestamp);

        return $l['today'] . $time;
    } else {

        return date("F j, Y, g:i a", $timestamp);
    }
}

function getage($DOB) {

    $birth = explode("-", $DOB);

    $age = date("Y") - $birth[0];

    if (($birth[1] > date("m")) || ($birth[1] == date("m") && date("d") < $birth[2])) {

        $age -= 1;
    }

    return $age;
}

//generates random strings
function generateRandStr($length) {

    $randstr = "";

    for ($i = 0; $i < $length; $i++) {

        $randnum = mt_rand(0, 61);

        if ($randnum < 10) {

            $randstr .= chr($randnum + 48);
        } elseif ($randnum < 36) {

            $randstr .= chr($randnum + 55);
        } else {

            $randstr .= chr($randnum + 61);
        }
    }

    return strtolower($randstr);
}

///////////////////////////////////
// Presently takes care of Slashes
///////////////////////////////////

function inputsec($string) {

    if (!get_magic_quotes_gpc()) {

        $string = addslashes($string);
    } else {

        $string = stripslashes($string);
        $string = addslashes($string);
    }

    return $string;
}

////////////////////////////
// Takes care of characters
////////////////////////////

function htmlizer($string) {

    global $globals;

    $string = htmlentities($string, ENT_QUOTES, $globals['charset']);

    $string = preg_replace('/(&amp;#(\d{1,7}|x[0-9a-fA-F]{1,6});)/e', 'entity_check(\\2);', $string);

    return $string;
}

//Only allowed entities
function entity_check($string) {

    //Convert Hexadecimal to Decimal
    $num = ((substr($string, 0, 1) === 'x') ? hexdec(substr($string, 1)) : (int) $string);

    //Squares and Spaces - return nothing
    $string = (($num > 0x10FFFF || ($num >= 0xD800 && $num <= 0xDFFF) || $num < 0x20) ? '' : '&#' . $num . ';');

    return $string;
}

function cleanVARS($var) {

    if (is_string($var)) {

        $var = array($var);
    }

    foreach ($var as $k => $v) {

        //Is it an array
        if (is_array($v)) {

            $var[$k] = cleanVARS($v);
            continue;
        }

        //Solves the Slash Problem in posts
        if (get_magic_quotes_gpc()) {

            $v = stripslashes($v);
        }

        $v = htmlizer($v);

        $var[$k] = $v;
    }

    return $var;
}

////////////////////////////////
// This is used to make a query
// whenever required.
////////////////////////////////

function makequery($query, $count = true) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;

    $result = mysql_query($query, $conn);

    if (!$result) {

        //Didnt get anyresult - DIE
        die('Could not make the Query.<br /><br /><br />' . $query . '<br /><br />MySQL Error No : ' . mysql_errno($conn) . '<br /><br />MySQL Error : ' . mysql_error($conn));
    }

    if ($count) {

        $globals['queries']++;
    }

    $globals['output_queries'] = 0;
    if (!empty($globals['output_queries'])) {

        echo 'Queries:&nbsp;' . $query . '<br /><br />';
    }

    return $result;
}

////////////////////////////////
// Checks a username is there in
// the database or not.
// Returns true if there in DB
// Returns False if not there
////////////////////////////////

function usernameindb($username) {

    global $user, $globals, $theme, $conn, $dbtables;

    $qresult = makequery("SELECT username FROM " . $dbtables['users'] . "
                    WHERE username = '$username'");

    if (!$qresult || (mysql_num_rows($qresult) < 1)) {

        //Not Found
        return false;
    } else {

        //Found
        return true;
    }

    //Free the resources
    mysql_free_result($qresult);
}

////////////////////////////////
// Checks a email is there in
// the database or not.
// Returns true if there in DB
// Returns False if not there
////////////////////////////////

function emailindb($email) {

    global $user, $globals, $theme, $conn, $dbtables;

    //We must check its validity
    if (!emailvalidation($email)) {

        return false;
    }

    $qresult = makequery("SELECT email FROM " . $dbtables['users'] . "
                    WHERE email = '$email'");

    if (!$qresult || (mysql_num_rows($qresult) < 1)) {

        //Not Found
        return false;
    } else {

        //Found
        return true;
    }

    //Free the resources
    mysql_free_result($qresult);
}

////////////////////////////////
// Confirms the validity of a
// email address.
// Returns true if valid
// Returns False if invalid
////////////////////////////////

function emailvalidation($email) {

    if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([.])+([a-zA-Z0-9\._-]+)+$/", $email)) {

        return false;
    } else {

        return true;
    }
}

////////////////////////////////
// Sends email(s) using PHP's
// mail() function or SMTP.
// $array stands for mail(s).
// It loops on the basis of
// number of elements in it.
////////////////////////////////

function aefmail($array) {

    global $user, $globals, $theme, $conn, $dbtables;

    include_cached($globals['mainfiles'] . '/functions/mail_functions.php');

    return aefmail_fn($array);
}

//A funtion to insert an array within a array after a particular position
function array_insert(&$array, $position, $insert_array) {

    $first_array = array_splice($array, 0, $position);

    $array = array_merge($first_array, $insert_array, $array);
}

//This is complementary to the function array_insert() as it finds the position of a key
function find_pos($array, $index) {

    $keys = array_keys($array);

    $key = array_search($index, $keys);

    return $key + 1;
}

//A required function to draw all the boards
function default_of_nor($newposts = true, $get_mod = true) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/forum_functions.php');

    ///////////////////////////////////////////
    // Note : To remove the bug when no forums
    // or categories existed this function will
    // always return true .
    ///////////////////////////////////////////
    getcatsandforums_fn($newposts, $get_mod);

    return true;
}

//End of function
//A funtion that returns the boards
function board($fid) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/forum_functions.php');

    return board_fn($fid);
}

//End of function
//Draw out the Member Groups
function membergroups() {

    global $globals, $dbtables, $conn, $user_group, $post_group, $l;

    //Bring the User Groups
    $qresult = makequery("SELECT *
            FROM " . $dbtables['user_groups'] . "
            ORDER BY post_count ASC, member_group ASC");

    //Where are the User Groups ?
    if (mysql_num_rows($qresult) < 1) {

        //Show a major error and die
        reporterror($l['no_ug_found_title'], $l['no_ug_found']);

        return false;
    }

    for ($i = 0; $i < mysql_num_rows($qresult); $i++) {

        $row[$i] = mysql_fetch_assoc($qresult);

        //If it is a post group and not a Special Group
        if ($row[$i]['post_count'] != -1) {

            $post_group[$row[$i]['member_group']] = $row[$i];

            //It is a Special Group
        } else {

            $user_group[$row[$i]['member_group']] = $row[$i];
        }
    }


    return true;
}

function getsmileys() {

    global $globals, $theme, $dbtables, $conn, $smileys, $smileycode, $smileyimages, $smileyurl;

    //Make the Query
    $qresult = makequery("SELECT * FROM `" . $dbtables['smileys'] . "`
                ORDER BY smorder ASC");

    //There may be no smileys
    //The array containing the Smileys
    $smileys = array();

    $smileycode = array();

    $smileyimages = array();

    //The for loop to draw out the Smileys
    for ($s = 1; $s <= mysql_num_rows($qresult); $s++) {

        $row = mysql_fetch_assoc($qresult);

        $i = $row['smid'];

        $smileys[$i] = $row;

        $smileycode[$i] = $smileys[$i]['smcode'];

        $smileyimages[$i] = '<img src="' . $globals['url'] . '/smileys/' . $smileys[$i]['smfolder'] . '/' . $smileys[$i]['smfile'] . '" alt="' . $smileys[$i]['smcode'] . '" />';

        $smileyurl[$i] = $globals['url'] . '/smileys/' . $smileys[$i]['smfolder'] . '/' . $smileys[$i]['smfile'];
    }

    return true;
}

//Later improve and remove getsmileys everywhere
function smileyfy($text) {

    global $globals, $theme, $dbtables, $conn, $smileys, $smileycode, $smileyimages;

    if (empty($smileycode)) {

        if (!getsmileys()) {

            return $text;
        }
    }

    $boundary = '';

    $code = $smileycode;

    $image = $smileyimages;

    if (!empty($globals['smiley_space_boundary'])) {

        $boundary = ' ';
    }

    foreach ($code as $sk => $sv) {

        $code[$sk] = $boundary . $code[$sk] . $boundary;

        $image[$sk] = $boundary . $image[$sk] . $boundary;
    }

    $text = str_replace($code, $image, $text);

    return $text;
}

//A function to check the title of the post with the required GLOBAL Settings
function checktitle($title) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/topic_functions.php');

    return checktitle_fn($title);
}

//Checks the description of the topic with the required GLOBAL Settings
function checkdescription($description) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/topic_functions.php');

    return checkdescription_fn($description);
}

//Checks the posts compliance
function checkpost($post) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/topic_functions.php');

    return checkpost_fn($post);
}

function read_topic($tid, $view_time) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/topic_functions.php');

    return read_topic_fn($tid, $view_time);
}

function first_post_topic($tid) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/topic_functions.php');

    return first_post_topic_fn($tid);
}

function last_post_topic($tid) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/topic_functions.php');

    return last_post_topic_fn($tid);
}

function read_forum($fid, $view_time) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/forum_functions.php');

    return read_forum_fn($fid, $view_time);
}

//Checks whether the user is a moderator
function is_mod() {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/forum_functions.php');

    return is_mod_fn();
}

function last_post_forum($fid) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/forum_functions.php');

    return last_post_forum_fn($fid);
}

/* Here are two functions to trim a string down to a certain size.

  "wordLimit" trims a string down to a certain number of words, and adds an ellipsis after the last word, or returns the string if the limit is larger than the number of words in the string.

  "stringLimit" trims a string down to a certain number of characters, and adds an ellipsis after the last word, without truncating any words in the middle (it will instead leave it out), or returns the string if the limit is larger than the string size. The length of a string will INCLUDE the length of the ellipsis. */

function wordLimit($string, $length = 50, $ellipsis = '...') {

    return count($words = preg_split('/\s+/', ltrim($string), $length + 1)) > $length ?
            rtrim(aefsubstr($string, 0, aefstrlen($string) - aefstrlen(end($words)))) . $ellipsis :
            $string;
}

function stringLimit($string, $length = 50, $ellipsis = '...') {

    return aefstrlen($fragment = aefsubstr($string, 0, $length + 1 - aefstrlen($ellipsis))) < aefstrlen($string) + 1 ? preg_replace('/\s*\S*$/', '', $fragment) . $ellipsis : $string;
}

function format_text($text) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/bbc_functions.php');

    $text = normal_bbc($text);

    return $text;
}

function parse_special_bbc($text, $allow_html=0) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/bbc_functions.php');

    $text = special_bbc($text, $allow_html);

    return $text;
}

function parse_br($text) {

    global $globals;

    //Lets hit ENTER
    $text = str_replace("\n", '<br />', $text);

    //If TABS
    $text = str_replace("    ", '    ', $text);

    //If excess space
    $text = str_replace("  ", '&nbsp; ', $text);

    include_cached($globals['mainfiles'] . '/functions/bbc_functions.php');

    $text = censor_words($text);

    //Remove AEF Sessions if anywhere
    $text = preg_replace('/(\?|&amp;|;|&)as=([0-9a-zA-Z]){32}(&amp;|;|&|$)?/i', '$1$3', $text);

    return $text;
}

//To remove htmlentities for PHP Code block
function unhtmlentities($string) {

    // replace numeric entities
    $string = preg_replace('~&#x([0-9a-f]+);~ei', 'chr(hexdec("\\1"))', $string);

    $string = preg_replace('~&#([0-9]+);~e', 'chr("\\1")', $string);

    // replace literal entities
    $trans_tbl = get_html_translation_table(HTML_ENTITIES);

    $trans_tbl = array_flip($trans_tbl);

    return strtr($string, $trans_tbl);
}

//Color the PHP code
function xhtmlHighlightString($str, $return=false) {

    $str = unhtmlentities($str, ENT_QUOTES);

    if (function_exists('stripslash')) {

        $str = stripslash($str);
    }

    $str = trim($str);

    $open = $close = false;

    if (!(strpos(substr($str, 0, 3), '<?') === false))
        $open = true;

    if (!(strpos(substr($str, -3), '?>') === false))
        $close = true;

    // adds required PHP tags (at least with vers. 5.0.5 this is required)
    // xml is not THAT important ;-)
    if (strpos($str, '?>') === false) {

        $str = "<?php " . $str . " ?>";
        $r1 = '#&lt;\?.*?(php)?.*?&nbsp;#s';
        $r2 = '#\?&gt;#s';
    } elseif (strpos($str, '<?') !== false) {

        $r1 = '--';
        $str = str_replace('<? ', '<?php ', $str);
    }

    //trim some extra enters(\n)
    $str = trim($str);

    $hlt = highlight_string(stripslashes($str), true);

    if ($r1 == '--')
        $str = preg_replace('#(&lt;\?.*?)(php)?(.*?&nbsp;)#s', '\\1\\3', $str);

    $fon = str_replace(array('<span ', '</span>'), array('<span ', '</span>'), $hlt);

    $ret = preg_replace('#color="(.*?)"#', 'style="color: \\1"', $fon);

    //Remove the OPEN PHP TAG
    if (empty($open))
        $ret = substr_replace($ret, '', strpos($ret, '&lt;?php'), 8);

    //Remove the CLOSE PHP TAG
    if (empty($close))
        $ret = substr_replace($ret, '', (strrpos($ret, '?&gt;')), 5);

    $ret = '<div class="codeblock"><div class="codehead">PHP Code</div><div class="code">' . $ret . '</div></div>';

    if ($return) {

        return $ret;
    } else {

        echo $ret;

        return true;
    }
}

////////////////////////////////////////////////
// Returns the Numeric Value of results Per Page
// Parameter:
// 1) The GET VAR to check
// 2) The Number of Results allowed per Page
////////////////////////////////////////////////
function get_page($get, $resperpage) {

    if (isset($_GET[$get]) && !(strlen(trim($_GET[$get])) < 1) && !(trim($_GET[$get]) < 1)) {

        $pg = (int) trim($_GET[$get]);

        $pg = $pg - 1;

        $page = ($pg * $resperpage);
    } else {

        $page = 0;
    }

    return $page;
}

//This function just redirects to the Location specified and dies
//Primary Base $globals['index_url']
function redirect($location, $header = true) {

    global $globals, $redirect;

    $redirect = true;

    if ($header) {

        //Redirect
        header("Location: " . $globals['index_url'] . $location);
    } else {

        echo '<meta http-equiv="Refresh" content="0;url=' . $globals['index_url'] . $location . '">';
    }

    //We must not die here as AEF_SESSIONS are saved in the end
}

////////////////////////////////////
// Processes password and returns
// Encryted one as stored in DB
////////////////////////////////////


function encrypt_password($password) {

    $password = md5(trim($password));

    return $password;
}

/////////////////////////////////////
// This function gets the files in a
// Specified folder
/////////////////////////////////////

function getdirfiles($startdir="./", $searchSubdirs=1, $directoriesonly=0, $filetypearray = array(), $maxlevel="all", $level=1) {

    $filearray = $filetypearray;

    /* echo '<pre>';
      print_r($filearray);
      echo '</pre>'; */

    //list the directory/file names that you want to ignore
    $ignoredDirectory[] = ".";
    $ignoredDirectory[] = "..";
    $ignoredDirectory[] = "_vti_cnf";

    //initialize global array
    global $directorylist, $filetypearray;

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

                                getdirfiles($startdir . $file . "/", $searchSubdirs, $directoriesonly, $filearray, $maxlevel, $level + 1);
                            }
                        }
                    } else {

                        if (!$directoriesonly) {

                            /* echo empty($filearray);
                              echo '<pre>';
                              print_r($filearray);
                              echo '</pre>'; */

                            if (empty($filearray)) {

                                //if you want to include files; build your file array
                                //however you choose; add other file details that you want.
                                $directorylist[$startdir . $file]['level'] = $level;
                                $directorylist[$startdir . $file]['dir'] = 0;
                                $directorylist[$startdir . $file]['name'] = $file;
                                $directorylist[$startdir . $file]['path'] = $startdir;
                            } else {

                                if (in_array(substr(strrchr($file, "."), 1), $filearray)) {

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
            }

            closedir($dh);
        }
    }


    return($directorylist);
}

///////////////////////////////////
// This function is used to upload
// attachments in posts.
///////////////////////////////////

function attach($fid, $tid, $pid) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/attachment_functions.php');

    return attach_fn($fid, $tid, $pid);
}

///////////////////////////////////
// Deletes a attachment from posts
// 5th param is for updating post
// for attachments.
///////////////////////////////////

function dettach($fid, $tid, $pid, $attachments, $update = true) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/attachment_functions.php');

    return dettach_fn($fid, $tid, $pid, $attachments, $update);
}

//////////////////////////////////////////
// Returns the extension for the filename
//////////////////////////////////////////

function get_extension($fname) {

    $temp_r = explode('.', $fname);

    $ext = $temp_r[count($temp_r) - 1];

    return $ext;
}

///////////////////////////////////////////////
// This will return the URL of the users avatar
///////////////////////////////////////////////

function urlifyavatar($resize=100, $avatar = array()) {

    global $user, $globals;

    $av = array(0 => '',
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0,);

    if (empty($avatar)) {

        $avatar = array('avatar' => $user['avatar'],
            'avatar_type' => $user['avatar_type'],
            'avatar_width' => $user['avatar_width'],
            'avatar_height' => $user['avatar_height'],
        );
    }

    //The Avatar is from the Gallery
    if ($avatar['avatar_type'] == 1) {

        $av[0] = $globals['avatarurl'] . '/' . $avatar['avatar'];

        //It is a URL Avatar
    } elseif ($avatar['avatar_type'] == 2) {

        $av[0] = $avatar['avatar'];

        //The Avatar is Uploaded
    } elseif ($avatar['avatar_type'] == 3) {

        $av[0] = $globals['uploadavatarurl'] . '/' . $avatar['avatar'];
    }

    //The actual width
    $av[1] = $avatar['avatar_width'];

    //The actual height
    $av[2] = $avatar['avatar_height'];

    //The resized width if asked
    $av[3] = ($avatar['avatar_width'] * ($resize / 100));

    //The resized height if asked
    $av[4] = ($avatar['avatar_height'] * ($resize / 100));

    return $av;
}

///////////////////////////////////////////////
// This will return the URL of the users PPic
///////////////////////////////////////////////

function urlifyppic($resize=100, $pic = array()) {

    global $user, $globals;

    if (empty($pic)) {

        $pic = array('ppic' => $user['ppic'],
            'ppic_type' => $user['ppic_type'],
            'ppic_width' => $user['ppic_width'],
            'ppic_height' => $user['ppic_height']
        );
    }

    $pp = array(0 => '',
        1 => 0,
        2 => 0,
        3 => 0,
        4 => 0);

    //The Personal Picture is a URL
    if ($pic['ppic_type'] == 1) {

        $pp[0] = $pic['ppic'];

        //The Personal Picture is Uploaded
    } elseif ($pic['ppic_type'] == 2) {

        $pp[0] = $globals['uploadppicurl'] . '/' . $pic['ppic'];
    }

    //The actual width
    $pp[1] = $pic['ppic_width'];

    //The actual height
    $pp[2] = $pic['ppic_height'];

    //The resized width if asked
    $pp[3] = ($pic['ppic_width'] * ($resize / 100));

    //The resized height if asked
    $pp[4] = ($pic['ppic_height'] * ($resize / 100));

    return $pp;
}

function can_gzip() {

    global $isbot;

    if (headers_sent() || connection_aborted() || !empty($isbot)) {

        return 0;
    }

    if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) {

        return 'x-gzip';
    }


    if (strpos($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) {

        return 'gzip';
    }

    //By default return false
    return 0;
}

function aefoutput_buffer($buffer) {

    global $globals, $redirect;

    //Are we to redirect
    if (!empty($redirect)) {

        return;
    }

    if (!empty($globals['stop_buffer_process'])) {

        return $buffer;
    }

    //Check the SESSION STUFF for saving in the end
    if (!preg_match("/" . preg_quote(unhtmlentities(strrev(';tg&a/;tl&.cnI nortcelE;tg&;touq&moc.nortcelena.www//:ptth;touq&=ferh a;tl& 9002-7002 ;ypoc;pma& ;tg&a/;tl&9.0.1 FEA yB derewoP;tg&;touq&moc.nortcelena.www//:ptth;touq&=ferh a;tl&')), "/") . "/", $buffer)) {

        return;
    }

    //The gzip stuff
    if ($globals['gzip']) {

        //Do we have the extensions
        if (extension_loaded('zlib') && ini_get('zlib.output_compression') !== '1' && can_gzip()) {

            $buffer = ob_gzhandler($buffer, 1);
        }
    }

    return $buffer;
}

//////////////////////////////////////
// Loads the Language file specified
// Extension is not required
//////////////////////////////////////

function load_lang($file) {

    global $theme, $globals, $l, $user;

    $file = $file . '_lang.php';

    $language = $globals['language'];

    //If the user has his lang preference and is allowed by this Board
    if (!empty($user['language']) && $globals['choose_language']) {

        $language = $user['language'];
    }
    //if possible, use the cached file 
    if(file_exists($globals['cachedir'] . '/' . $file)){
        include_once($globals['cachedir'] . '/' . $file);
        return true;
    }
    $path = $globals['server_url'] . '/languages/' . $language . '/' . $file;

    //If this location is there and it did not load
    if (empty($file) || !include_once($path)) {

        //Try to load the Default
        if (!include_once($globals['server_url'] . '/languages/english/' . $file)) {

            //If not there reporterror is triggered.
            reporterror('', 'Unable to load the language files.');

            return false;
        }
    }

    return true;
}

// Replaces the AEF Variables with the supplied ones
function lang_vars($str, $array) {

    $string = '';

    $str = preg_replace('/&aefv-(\d{1,2});/i', '&aefv-\\1;', $str); //Capital ones may be there

    $count = 0;

    foreach ($array as $v) {

        $count++;

        $str = str_replace('&aefv-' . $count . ';', $v, $str);
    }

    return $str;
}

///////////////////////////////////
// This should be called first to
// Initialize the theme file.
// $file - Just the name and not trailing '_theme.php'
// $theme_file_name - The Name for major error
///////////////////////////////////

function init_theme($file, $theme_file_name) {

    global $theme, $globals, $l;

    //if possible, use the cached file 
    if(file_exists($globals['cachedir'] . '/' . $file)){
        include_once($globals['cachedir'] . '/' . $file);
        return true;
    }
    //If this location is there and it did not load
    if (empty($theme[$file]) || !include_once($theme[$file])) {

        //Note:If the theme file was not loaded we have
        //used the $file directly as in the default theme
        //the array index of the theme is the same as the
        //file name which may not be the case of other themes
        //Try to load the Default
        if (!include_once($globals['themesdir'] . '/default/' . $file . '_theme.php')) {

            //If not there reporterror is triggered.
            reporterror($l['init_theme_error_t'], lang_vars($l['init_theme_error'], array($theme_file_name)));

            return false;
        }
    }

    return true;
}

///////////////////////////////////
// This should be called to check
// all the necessary function of a theme
// $function_r - The array of the functions
// $theme_file_name - The Name for major error
///////////////////////////////////

function init_theme_func($function_r, $theme_file_name) {

    global $theme, $globals, $act, $load_hf, $l;

    $count = count($function_r);
    for ($i = 0; $i < $count; $i++) {

        //echo $function_r[$i].function_exists($function_r[$i]).'<br />';

        if (!(function_exists($function_r[$i]))) {

            //If not there reporterror is triggered.
            reporterror($l['init_theme_func_error_t'], lang_vars($l['init_theme_func_error'], array($theme_file_name)));

            return false;
        }
    }

    return true;
}

//////////////////////////////////////
// This is to load a theme's settings
// Call howmany ever times required
//////////////////////////////////////

function load_theme_settings($id) {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $act, $load_hf;

    $skins = array();

    $skin = array();

    $load_hf = true;

    $uid = ($logged_in ? $user['id'] : -1);

    $qresult = makequery("SELECT * FROM " . $dbtables['themes'] . " t
                        LEFT JOIN " . $dbtables['theme_registry'] . " tr ON (tr.thid = t.thid
                                                                AND tr.uid IN (0, " . $uid . "))
                        WHERE t.thid IN (1, " . $id . ")");

    if (mysql_num_rows($qresult) < 1) {

        return false;
    }

    for ($i = 1; $i <= mysql_num_rows($qresult); $i++) {

        $row = mysql_fetch_assoc($qresult);

        $skins[$row['thid']][$row['uid']] = $row;
    }

    if (!empty($skins[$id][0]['theme_registry'])) {

        $skin = aefunserialize($skins[$id][0]['theme_registry']);
    } else {

        //Just to stop errors
        $skin['path'] = '';
    }

    //Now pass the theme_registry
    $theme = array_merge($theme, $skin);

    //if possible, use the cached file 
    if(file_exists($globals['cachedir'] . '/theme_settings.php')){
        include_once($globals['cachedir'] . '/theme_settings.php');
    }
    else{
        //Contains all the necessary theme Variables of every theme file.
        if (!include_once($theme['path'] . '/theme_settings.php')) {

            $id = 1;

            if (!empty($skins[$id][0]['theme_registry'])) {

                $skin = aefunserialize($skins[$id][0]['theme_registry']);
            } else {

                $skin['path'] = '';
            }

            //Now pass the theme_registry
            $theme = array_merge($theme, $skin);

            //Try to load the Default
            if (!include_once($theme['path'] . '/theme_settings.php')) {

                //If not there reporterror is triggered.
                reporterror('', $l['load_theme_settings_error']);

                $load_hf = false;

                return false;
            }
        }
    }
    //User preferences
    if (!empty($skins[$id][$uid]['theme_registry'])) {

        $user_pref = aefunserialize($skins[$id][$uid]['theme_registry']);

        if (!empty($user_pref)) {

            $theme = array_merge($theme, $user_pref);
        }
    }

    return true;
}

//////////////////////////////////////
// Loads the theme's registry
// file and returns the registry array
//////////////////////////////////////

function theme_registry($theme_id, $uservar = false) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/theme_functions.php');

    return theme_registry_fn($theme_id, $uservar);
}

function showsmileys() {

    global $globals, $user, $logged_in;

    return ($logged_in ? ( $user['showsmileys'] == 1 ? true : ($user['showsmileys'] == 2 ? false : $globals['usesmileys']) ) : $globals['usesmileys']);
}

function reporterror($title, $text, $heading = '', $icon = '') {

    global $theme, $globals, $act, $errortitle, $errormessage, $errorheading, $erroricon;

    $act = 'error_break';

    $errortitle = $title;

    $errormessage = $text;

    $errorheading = $heading;

    $erroricon = $icon;

    $globals['stop_buffer_process'] = true;

    return true;
}

function reportmessage($title, $heading, $icon, $text) {

    global $theme, $globals, $act, $messagetitle, $messagetext, $messageheading, $messageicon;

    $act = 'error_break';

    $messagetitle = $title;

    $messagetext = $text;

    $messageheading = $heading;

    $messageicon = $icon;

    return true;
}

function copyright() {

    /////////////////////////////////////////////////////
    // DO NOT remove this section and also DO NOT EDIT it
    // IF YOU CHANGE IT IN ANY WAY IT WOULD VIOLATE YOUR
    // LICENCE TO USE AEF.
    /////////////////////////////////////////////////////

    return '<a href="http://www.anelectron.com">Powered By AEF 1.1.0 Preview</a> &copy; 2007-2011 <a href="http://www.anelectron.com">AEF Group.</a> All rights reserved';
}

//Returns a string of all $_GET values
function getallGET($notreq) {

    $to_return = array();

    foreach ($_GET as $k => $v) {

        if (!in_array($k, $notreq)) {

            $to_return[] = $k . '=' . $v;
        }
    }

    return implode('&', $to_return);
}

function errorhandler($errno, $errmsg, $filename, $linenum, $vars) {

    // timestamp for the error entry
    $dt = date("Y-m-d H:i:s");

    // define an assoc array of error string
    // in reality the only entries we should
    // consider are E_WARNING, E_NOTICE, E_USER_ERROR,
    // E_USER_WARNING and E_USER_NOTICE
    $errortype = array(
        E_ERROR => "Error",
        E_WARNING => "Warning",
        E_PARSE => "Parsing Error",
        E_NOTICE => "Notice",
        E_CORE_ERROR => "Core Error",
        E_CORE_WARNING => "Core Warning",
        E_COMPILE_ERROR => "Compile Error",
        E_COMPILE_WARNING => "Compile Warning",
        E_USER_ERROR => "User Error",
        E_USER_WARNING => "User Warning",
        E_USER_NOTICE => "User Notice",
            //E_STRICT          => "Runtime Notice"
    );
    // set of errors for which a var trace will be saved
    $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

    $err = "<errorentry>\n";
    $err .= "\t<datetime>" . $dt . "</datetime>\n";
    $err .= "\t<errornum>" . $errno . "</errornum>\n";
    $err .= "\t<errortype>" . $errortype[$errno] . "</errortype>\n";
    $err .= "\t<errormsg>" . $errmsg . "</errormsg>\n";
    $err .= "\t<scriptname>" . $filename . "</scriptname>\n";
    $err .= "\t<scriptlinenum>" . $linenum . "</scriptlinenum>\n";

    if (in_array($errno, $user_errors)) {
        $err .= "\t<vartrace>" . wddx_serialize_value($vars, "Variables") . "</vartrace>\n";
    }
    $err .= "</errorentry><br />";

    // for testing
    echo $err;
}

//Will delete all topics of whose id is given
function delete_topics($tids, $param = array()) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/topic_functions.php');

    return delete_topics_fn($tids, $param);
}

//Will delete all forums of whose id is given
function delete_forums($fids) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/forum_functions.php');

    return delete_forums_fn($fids);
}

//Will delete all categories of whose id is given
function delete_categories($cids) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/category_functions.php');

    return delete_categories_fn($cids);
}

//A Function to reorder the First Level board of the given parent
function reorderchildren($par, $cat) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/forum_functions.php');

    return reorderchildren_fn($par, $cat);
}

//End of function
//A Function to compress files and folders
function compress($path, $name, $method) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/compress_functions.php');

    return compress_fn($path, $name, $method);
}

//End of functions
//This function will find the extension and try to decomress zip, tar, tgz, tbz
function decompress($file, $destination, $overwrite = 0) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/compress_functions.php');

    return decompress_fn($file, $destination, $overwrite);
}

//End of function
//A Function to unzip a zip flie
function decompress_zip($file, $destination, $overwrite = 0) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/compress_functions.php');

    return decompress_zip_fn($file, $destination, $overwrite);
}

//End of function
//A Function to decompress a TGZ flie
function decompress_tgz($file, $destination, $overwrite = 0) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/compress_functions.php');

    return decompress_tgz_fn($file, $destination, $overwrite);
}

//End of function
//A Function to decompress a TAR flie
function decompress_tar($file, $destination, $overwrite = 0) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/compress_functions.php');

    return decompress_tar_fn($file, $destination, $overwrite);
}

//End of function
//A Function to decompress a TBZIP2 flie
function decompress_tbz($file, $destination, $overwrite = 0) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/compress_functions.php');

    return decompress_tbz_fn($file, $destination, $overwrite);
}

//End of functions
//A Function that creates a file for the given data
function writefile($file, $data, $overwrite = 0) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/file_functions.php');

    return writefile_fn($file, $data, $overwrite);
}

//End of function
//A Function that lists files and folders in a folder
function filelist($startdir="./", $searchSubdirs=1, $directoriesonly=0, $maxlevel="all", $level=1) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/file_functions.php');

    return filelist_fn($startdir, $searchSubdirs, $directoriesonly, $maxlevel, $level);
}

//End of function
//A Function that returns the ZIP Class
function zipclass() {

    global $globals;

    include_cached($globals['mainfiles'] . '/classes/zip.php');

    return new zip();
}

/**
 * Gets the akismet class
 * @global array $globals The array of global constants
 * @return Akismet The akismet class
 */
function akismetclass() {
    
    global $globals;
    
    include_cached($globals['mainfiles'] . '/classes/akismet.php');
    
    return new Akismet();
    
}

//End of function
//A function to load a file from the net
function get_web_file($url, $writefilename = '') {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/file_functions.php');

    return get_web_file_fn($url, $writefilename);
}

//End of function
//A Function that returns the RSS Class
function rssclass() {

    global $globals;

    include_cached($globals['mainfiles'] . '/classes/rss.php');

    return new rss();
}

////////////////////////////////////
//A Function to send PM
// Parameters:
// 1) $to - To whom is it addressed
// 2) $subject - Subject of the PM
// 3) $body - The body of the PM
// 4) $track - Whether to track it
// 5) $saveinsentitems - Save it or no.
/////////////////////////////////////
function sendpm($to, $subject, $body, $track, $saveinsentitems) {

    global $globals;

    include_cached($globals['mainfiles'] . '/functions/pm_functions.php');

    return sendpm_fn($to, $subject, $body, $track, $saveinsentitems);
}

function aefunserialize($str) {

    $str = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.aefstrlen('$2').':\"$2\";'", $str);

    $var = unserialize($str);

    //If it is still empty false
    if (empty($var)) {

        return false;
    } else {

        return $var;
    }
}

function forum_theme() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $board;

    if (empty($board)) {

        return;
    }

    //Does the forum have its own theme
    if (!empty($board['id_skin']) &&
            ((!empty($user['user_theme']) && !empty($board['override_skin'])) || empty($user['user_theme']))) {

        $globals['theme_id'] = $board['id_skin'];
    }
}

//Escapes a string only if it hasnt been escaped(Smart Escape)
function aefaddslashes($str) {

    if (!empty($str) &&
            substr_count($str, '\\') > 1 &&
            substr_count($str, '\\\\') < 1) {

        $str = addslashes($str);
    }

    return $str;
}

function r_print($array) {

    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function SEO() {

    global $globals;

    //IS SEO on ??
    if (!$globals['seo']) {

        return false;
    }

    //Do we have Apache
    if (substr_count(php_sapi_name(), 'apache') < 1) {

        return false;
    }

    //Do we have a REQUEST_URI to match
    if (empty($_SERVER['REQUEST_URI']))
        return false;

    //Is there anything passed through index.php
    if (substr_count($_SERVER['REQUEST_URI'], '/index.php?') > 0)
        return false;

    $_GET = array(); //Better keep this empty
    //Is it a topic
    if (preg_match('/\-t(\d{1,20})(\-pg\d{1,20})?\.html$/is', $_SERVER['REQUEST_URI'], $matches)) {

        $_GET['tid'] = $matches[1];

        if (!empty($matches[2]))
            $_GET['tpg'] = str_replace('-pg', '', $matches[2]);

        //No its a Forum
    }elseif (preg_match('/\-f(\d{1,20})(\-pg\d{1,20})?\.html$/is', $_SERVER['REQUEST_URI'], $matches)) {

        $_GET['fid'] = $matches[1];

        if (!empty($matches[2]))
            $_GET['bpg'] = str_replace('-pg', '', $matches[2]);

        //Could it be a member
    }elseif (preg_match('/\-m(\d{1,20})\.html$/is', $_SERVER['REQUEST_URI'], $matches)) {

        $_GET['mid'] = $matches[1];
    }
}

function seotext($text) {

    $text = preg_replace('/\s/', '_', $text);
    $text = str_replace('?', '%3F', $text);
    return $text;
}

//Make a users link
function userlink($id, $name) {

    global $globals;

    if (empty($globals['title_in_link']))
        $name = '';

    if (substr($globals['index_url'], -1) == '?'
            && substr_count(php_sapi_name(), 'apache') > 0
            && !empty($globals['seo'])) {
        return $globals['index'] . (empty($name) ? 'user' : seotext($name)) . '-m' . $id . '.html';
    } else {
        return $globals['ind'] . 'mid=' . $id . (empty($name) ? '' : '&amp;username=' . seotext($name));
    }
}

//$noseo is for anything to be apended after the links - So NO SEO
function forumlink($id, $name, $pg = 0, $noseo = false) {

    global $globals;

    if (empty($globals['title_in_link']))
        $name = '';

    if (substr($globals['index_url'], -1) == '?'
            && substr_count(php_sapi_name(), 'apache') > 0
            && !empty($globals['seo'])
            && empty($noseo)) {
        return $globals['index'] . (empty($name) ? 'forum' : seotext($name)) . '-f' . $id . (empty($pg) || $pg == 1 ? '' : '-pg' . $pg) . '.html';
    } else {
        return $globals['ind'] . 'fid=' . $id . (empty($pg) || $pg == 1 ? '' : '&amp;bpg=' . $pg) . (empty($name) ? '' : '&amp;fname=' . seotext($name)) . (empty($noseo) ? '' : $noseo);
    }
}

function topiclink($id, $name, $pg = 0) {

    global $globals;

    if (empty($globals['title_in_link']))
        $name = '';

    if (substr($globals['index_url'], -1) == '?'
            && substr_count(php_sapi_name(), 'apache') > 0
            && !empty($globals['seo'])
            && is_numeric($pg)) {
        return $globals['index'] . (empty($name) ? 'topic' : seotext($name)) . '-t' . $id . (empty($pg) || $pg == 1 ? '' : '-pg' . $pg) . '.html';
    } else {
        return $globals['ind'] . 'tid=' . $id . (empty($pg) || $pg == 1 ? '' : '&amp;tpg=' . $pg) . (empty($name) ? '' : '&amp;title=' . seotext($name));
    }
}

function BANNED() {

    global $globals, $l, $user;

    $globals['bannedip'] = aefunserialize($globals['bannedip']);

    if (empty($globals['bannedip']) || empty($_SERVER['REMOTE_ADDR']) || $user['can_admin'])
        return false;

    $ip = explode('.', $_SERVER['REMOTE_ADDR']);

    foreach ($globals['bannedip'] as $k => $v) {

        $banned = explode('.', $v);

        $matches = 0;

        foreach ($banned as $bk => $bv) {

            $temp = explode('-', $bv);

            //Make it a range
            if (count($temp) == 1)
                $temp[1] = $temp[0];

            //Compare
            if ($ip[$bk] >= min($temp) && $ip[$bk] <= max($temp))
                $matches += 1;
        }

        //If all 4 parts MATCHED you are BANNED!
        if ($matches == 4) {
            reporterror($l['ip_banned_title'], $l['ip_banned']);
            return false;
        }
    }
}

//UTF-8 String Length
function aefstrlen($string) {

    global $globals;

    return strlen(utf8_decode($string));
}

//Functions for UTF-8
function aefsubstr($string, $start, $length = NULL) {

    global $globals;

    $r = preg_split('/(.)/' . ($globals['charset'] == 'UTF-8' ? 'u' : ''), $string, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

    if ($length === NULL) {
        return implode('', array_slice($r, $start));
    } else {
        return implode('', array_slice($r, $start, $length));
    }
}

//String to lower case
function aefstrtolower($string) {

    global $globals, $lower_upper, $upper_lower;

    if ($globals['charset'] != 'UTF-8')
        return strtolower($string);

    if (function_exists('mb_strtolower'))
        return mb_strtolower($string, $globals['charset']);

    include_cached($globals['mainfiles'] . '/functions/utf8_functions.php');

    return aefstrtolower_fn($string);
}

//String to upper case
function aefstrtoupper($string) {

    global $globals, $upper_lower, $lower_upper;

    if ($globals['charset'] != 'UTF-8')
        return strtoupper($string);

    if (function_exists('mb_strtoupper'))
        return mb_strtoupper($string, $globals['charset']);

    include_cached($globals['mainfiles'] . '/functions/utf8_functions.php');

    return aefstrtoupper_fn($string);
}

//Make the first charater upper case
function aefucfirst($string) {

    global $globals;

    if ($globals['charset'] != 'UTF-8')
        return ucfirst($string);

    return aefstrtoupper(aefsubstr($string, 0, 1)) . aefsubstr($string, 1);
}

//String Position
function aefstrpos($haystack, $needle, $offset = 0) {

    $c = 0;

    $length = NULL;

    while (is_null($length) || $length < $offset) {

        $pos = strpos($haystack, $needle, $offset + $c);

        if ($pos === false)
            return false;

        $length = aefstrlen(substr($haystack, 0, $pos));

        if ($length < $offset)
            $c = $pos - $length;
    }

    return $length;
}

/////////////////////
// POSTING Functions
/////////////////////

function POST($name, $e) {

    global $error;

    //Check the POSTED NAME was posted
    if (!isset($_POST[$name]) || strlen(trim($_POST[$name])) < 1) {

        $error[$name] = $e;
    } else {

        return inputsec(htmlizer(trim($_POST[$name])));
    }
}

//OPTIONAL Post
function optPOST($name, $default = '') {

    global $error;

    //Check the POSTED NAME was posted
    if (isset($_POST[$name])) {

        return inputsec(htmlizer(trim($_POST[$name])));
    } else {

        return $default;
    }
}

//Checkbox
function checkbox($name) {

    global $error;

    //Check the Checkbox posted
    if (isset($_POST[$name])) {

        return true;
    } else {

        return false;
    }
}

function GET($name, $e) {

    global $error;

    //Check the POSTED NAME was posted
    if (!isset($_GET[$name]) || strlen(trim($_GET[$name])) < 1) {

        $error[$name] = $e;
    } else {

        return inputsec(htmlizer(trim($_GET[$name])));
    }
}

//OPTIONAL GET
function optGET($name, $default = '') {

    global $error;

    //Check the GETED NAME was GETed
    if (isset($_GET[$name])) {

        return inputsec(htmlizer(trim($_GET[$name])));
    } else {

        return $default;
    }
}
//Cache System
function include_cached($filename){
    global $globals, $l, $theme;
    $file_name = $globals['cachedir'] . '/' . $filename;
    //first of all we check if the file exists in the cache_dir
    if(file_exists($file_name)){
        //now we just include it! !
        include_once($file_name);
    }
    else{
        //nothing is changed just include the original one
        include_once($filename);
    }
    $GLOBALS += get_defined_vars();
}