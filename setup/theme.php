<?php

function aefheader($title = '') {
    ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
            <title><?php echo ((empty($title)) ? 'AEF' : $title); ?></title>
            <style type="text/css">
                body{
                    font-family:Verdana, Arial, Helvetica, sans-serif;
                    font-size:12px;
                    margin:0px;
                }
                img{
                    border: 0px solid #000;
                    vertical-align: middle;
                }

                a:link,
                a:visited,
                a:active{
                    background-color: transparent;
                    color: #2182F8;
                    text-decoration: underline;
                }

                a:hover{
                    background-color: transparent;
                    color: #1E55E8;
                    text-decoration: underline;
                }

                .setup a:link,.setup a:visited,.setup a:active{
                    font-weight:bold;
                    text-decoration:none;
                    padding: 5px;
                    margin:0px;
                    color:#666666;border: 1px solid  #CCCCCC;
                }
                .setup a:hover{
                    font-weight:bold;
                    text-decoration:none;
                    padding: 5px;
                    margin:0px;
                    border: 1px solid #66ADF4;color: #333333;
                }

                .setup{
                    padding:3px;
                }

                .pcbg{
                    background-image: url(images/pcbg.gif);
                    font-weight: bold;font-size:12px;color: #FFFFFF;height:24px;
                }
                /* PCBG Left */
                .pcbgl{
                    background:url(images/pcbgl.gif);
                    width:3px;
                }
                /* PCBG Right */
                .pcbgr{
                    background:url(images/pcbgr.gif);
                    width:3px;
                }
                .topbg{background-image:url(images/topbg.gif);
                }

                .cbgbor{
                    border:solid 1px #CCCCCC;
                }

                .rc, .lc{
                    background-color: rgb(240, 240, 240);
                }

                .exp{
                    font-size:11px;
                    color:#666666;
                }

                .error{
                    background-color: rgb(230, 230, 230);
                }
            </style>
        </head>
        <body>
            <table width="100%" border="0" cellpadding="3" cellspacing="1" style="border-bottom:1px solid #CCCCCC;">
                <tr>
                    <td width="25%" align="center" valign="top" style="border-right:1px solid #CCCCCC; padding-top:150px; background:url(images/bg.png) repeat-x #dcff60;">
                        <img src="images/electron.png" />
                    </td>
                    <td align="left" valign="top" style="padding: 20px 10px 0px 30px;">
                        <?php
                    }

                    function aeffooter() {
                        ?></td>
                </tr>
            </table>

            <br /><br /><table width="100%" cellpadding="5" cellspacing="1" style="background: #CCCCCC;">
                <tr>
                    <td align="center"><?php echo copyright(); ?></td>
                </tr>
            </table>
            <br />
        </body>
    </html><?php
                }

                function not_writable_theme() {

                    aefheader('AEF Setup');
                        ?>
    The universal.php file is not writable and the setup could not CHMOD.<br />
    Please CHMOD it to 0777 for the setup of your AEF board. You may later revert it back to 0655.<br /><br />
    After CHMOD just access this page again to start the setup. <br /><br />
    
    <strong>Linux users: Please read this next note</strong><br /><br />
    
    If you keep seeing this message afterwards, you may have a problem with SELinux (Security module)<br />
    Please try opening a terminal, going into su/sudo mode, and typing "setenforce 0"<br />
    If this fixes the problem, please consult the relevant person on how to permit attribute modification<br /><br />
    
    This is known to happen with Red Hat Enterprise Linux and Fedora
    <?php
    aeffooter();
}

function locked_theme() {

    aefheader('AEF Setup');
    ?>
    The installation script is locked, please remove "lock" file from "/setup" directory before you can continue the setup
    <?php
    aeffooter();
}

function startsetup() {

    aefheader('AEF Setup');
    ?><h1>Thank you for downloading AEF</h1>
    <br /><br />
    AEF 1.0.10 requires <b>PHP 5.0.0</b> or higher and <b>MySQL 4.0</b> or higher.
    <br /><br />
    You will also need the following MySQL information:<br />
    <ul>
        <li>Username
            <li>Password
                <li>Database Name
                    <li>Hostname
                        </ul>
                        <br />
                        Click the <b>Install</b> button to start the setup for your new AEF Board.
                        <br /><br /><br /><br />
                        <div class="setup"><a href="?act=setup">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Install&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/right.gif" />&nbsp;&nbsp;</a></div>
                        <br /><br /><br /><br /><br /><br />
                        <?php
                        aeffooter();
                    }

                    function setup_theme() {

                        global $url, $path, $error;

                        //Clean For XSS and Extra Slashes('\') if magic_quotes_gpc is ON
                        $_GET = cleanVARS($_GET);
                        $_POST = cleanVARS($_POST);

                        aefheader('AEF Setup');

                        error_handle($error, '100%', true);
                        ?>

                        <form action="" method="post" name="setupform">
                            <br />
                            <table width="100%" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0"><tr>
                                                <td class="pcbgl"></td>
                                                <td class="pcbg" align="left">Board Settings</td>
                                                <td class="pcbgr"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td>

                                        <table width="100%" cellpadding="5" cellspacing="1" class="cbgbor">

                                            <tr>
                                                <td class="topbg" colspan="2" align="center">
                                                    <img src="images/settings.png" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="40%" class="rc">
                                                    <b>Board Name :</b>
                                                </td>
                                                <td class="lc" align="left">
                                                    &nbsp;<input type="text" size="40"  name="sn" value="<?php echo ( (isset($_POST['sn'])) ? $_POST['sn'] : 'My Board' ); ?>" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="rc">
                                                    <b>Board Email :</b>
                                                </td>
                                                <td class="lc" align="left">
                                                    &nbsp;<input type="text" size="40" name="board_email" value="<?php echo ( (isset($_POST['board_email'])) ? $_POST['board_email'] : '' ); ?>" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="rc">
                                                    <b>URL :</b>
                                                </td>
                                                <td class="lc" align="left">
                                                    &nbsp;<input type="text" size="40" name="url" value="<?php echo ( (isset($_POST['url'])) ? $_POST['url'] : $url ); ?>" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="rc">
                                                    <b>Board Directory :</b>
                                                </td>
                                                <td class="lc" align="left">
                                                    &nbsp;<input type="text" size="40" name="server_url" value="<?php echo ( (isset($_POST['server_url'])) ? $_POST['server_url'] : $path ); ?>" />
                                                </td>
                                            </tr>

                                        </table>

                                    </td>
                                </tr>

                                <tr>
                                    <td><img src="images/cbotsmall.png" width="100%" height="10"></td>
                                </tr>

                            </table>

                            <br />
                            <table width="100%" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0"><tr>
                                                <td class="pcbgl"></td>
                                                <td class="pcbg" align="left">MySQL Settings</td>
                                                <td class="pcbgr"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td>

                                        <table width="100%" cellpadding="5" cellspacing="1" class="cbgbor">

                                            <tr>
                                                <td class="topbg" colspan="2" align="center">
                                                    <img src="images/mysql.png" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="40%" class="rc">
                                                    <b>MySQL Host :</b><br />
                                                    <font class="exp">This is usually localhost.</font>
                                                </td>
                                                <td class="lc" align="left">
                                                    &nbsp;<input type="text" size="30"  name="server" value="<?php echo ( (isset($_POST['server'])) ? $_POST['server'] : 'localhost' ); ?>" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="rc">
                                                    <b>MySQL Database Name :</b>
                                                </td>
                                                <td class="lc" align="left">
                                                    &nbsp;<input type="text" size="30"  name="database" value="<?php echo ( (isset($_POST['database'])) ? $_POST['database'] : '' ); ?>" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="rc">
                                                    <b>MySQL Username :</b>
                                                </td>
                                                <td class="lc" align="left">
                                                    &nbsp;<input type="text" size="30"  name="user" value="<?php echo ( (isset($_POST['user'])) ? $_POST['user'] : '' ); ?>" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="rc">
                                                    <b>MySQL Password :</b>
                                                </td>
                                                <td class="lc" align="left">
                                                    &nbsp;<input type="password" size="30"  name="password" value="<?php echo ( (isset($_POST['password'])) ? $_POST['password'] : '' ); ?>" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="rc">
                                                    <b>MySQL Table Prefix :</b><br />
                                                    <font class="exp">The prefix for every table of your board.</font>
                                                </td>
                                                <td class="lc" align="left">
                                                    &nbsp;<input type="text" size="30"  name="dbprefix" value="<?php echo ( (isset($_POST['dbprefix'])) ? $_POST['dbprefix'] : 'aef_' ); ?>" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="rc">
                                                    <b>Use UTF-8 Character Set :</b><br />
                                                    <font class="exp">Use if you are going to work with multiple languages.</font>
                                                </td>
                                                <td class="lc" align="left">
                                                    &nbsp;<input type="checkbox"  name="utf8" checked="checked" />
                                                </td>
                                            </tr>

                                        </table>

                                    </td>
                                </tr>

                                <tr>
                                    <td><img src="images/cbotsmall.png" width="100%" height="10"></td>
                                </tr>

                            </table>

                            <br />
                            <table width="100%" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td>
                                        <table width="100%" cellpadding="0" cellspacing="0"><tr>
                                                <td class="pcbgl"></td>
                                                <td class="pcbg" align="left">Root Admin Account</td>
                                                <td class="pcbgr"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td>

                                        <table width="100%" cellpadding="5" cellspacing="1" class="cbgbor">

                                            <tr>
                                                <td class="topbg" colspan="2" align="center">
                                                    <img src="images/users.png" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td width="40%" class="rc">
                                                    <b>Username :</b>
                                                </td>
                                                <td class="lc" align="left">
                                                    &nbsp;<input type="text" size="30"  name="ad_username" value="<?php echo ( (isset($_POST['ad_username'])) ? $_POST['ad_username'] : '' ); ?>" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="rc">
                                                    <b>Password :</b>
                                                </td>
                                                <td class="lc" align="left">
                                                    &nbsp;<input type="password" size="30"  name="ad_pass" value="" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="rc">
                                                    <b>Confirm Password :</b>
                                                </td>
                                                <td class="lc" align="left">
                                                    &nbsp;<input type="password" size="30"  name="ad_pass_conf" value="" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="rc">
                                                    <b>Your email :</b>
                                                </td>
                                                <td class="lc" align="left">
                                                    &nbsp;<input type="text" size="30"  name="ad_email" value="<?php echo ( (isset($_POST['ad_email'])) ? $_POST['ad_email'] : '' ); ?>" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="rc" colspan="2" align="center">
                                                    <input type="submit" size="30" name="setup" value="Submit" />
                                                </td>
                                            </tr>

                                        </table>

                                    </td>
                                </tr>

                                <tr>
                                    <td><img src="images/cbotsmall.png" width="100%" height="10"></td>
                                </tr>

                            </table>

                        </form>
                        <?php
                        aeffooter();
                        //echo '<pre>';print_r($_SERVER);
                    }

                    function aftersetup() {

                        global $url;

                        aefheader('AEF Setup');
                        ?><h1>Congratulations, the board was installed successfully</h1>
                        <br /><br />
                        Thank you for using AEF.<br /><br /><br />
                        If you need any support you can always count on us. Just drop in at our <a href="http://www.anelectron.com/board">Support Board</a>.
                        <br /><br />
                        You can also customize AEF by installing new themes. If you know PHP or MySQL you could help us develop AEF. And if you are good at HTML or Java Scripting then try and make a theme.
                        <br /><br />
                        In the meantime lets go check your new Board.
                        <br /><br /><br /><br />
                        <div class="setup"><a href="<?php echo $url; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Lets see the new Board&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/right.gif" />&nbsp;&nbsp;</a></div>
                        <br /><br />
                        <div class="setup"><a href="<?php echo $url . '/setup/index.php?act=removesetup'; ?>" target="_blank">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Remove setup folder&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="images/right.gif" />&nbsp;&nbsp;</a><font class="exp">&nbsp;(Opens a new window)</div>
                        <br /><br /><br /><br /><br /><br />
                        <?php
                        //Try to open a lockfile handle
                        $handle = @fopen("lock", 'w');
                        
                        //See if it doesn't work
                        if (!$handle) {
                            echo "Installation lock file could not be made.";
                            echo "<h2>Please remove the setup folder immediately!";
                        } else fclose($handle);
                        
                        aeffooter();
                    }

                    function error_handle($error, $table_width = '100%', $center = false) {

                        //on error call the form
                        if (!empty($error)) {

                            echo '<table width="' . $table_width . '" cellpadding="2" cellspacing="1" class="error" ' . (($center) ? 'align="center"' : '' ) . '>
            <tr>
            <td>
            The Following Errors were found :
            <ul type="square">';

                            foreach ($error as $ek => $ev) {

                                echo '<li>' . $ev . '</li>';
                            }


                            echo '</ul>
            </td>
            </tr>
            </table>' . (($center) ? '</center>' : '' ) . '
            <br />';
                        }
                    }
                    ?>
