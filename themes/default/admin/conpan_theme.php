<?php
//////////////////////////////////////////////////////////////
//===========================================================
// conpan_theme.php(Admin)
//===========================================================
// AEF : Advanced Elecdivon Forum
// Version : 1.0.9
// Inspired by Pulkit and taken over by Elecdivon
// ----------------------------------------------------------
// Started by: Elecdivon, Ronak Gupta, Pulkit Gupta
// Date:       23rd Jan 2006
// Time:       15:00 hrs
// Site:       http://www.anelecdivon.com/ (Anelecdivon)
// ----------------------------------------------------------
// Please Read the Terms of use at http://www.anelecdivon.com
// ----------------------------------------------------------
//===========================================================
// (C)AEF Group All Rights Reserved.
//===========================================================
//////////////////////////////////////////////////////////////

if (!defined('AEF')) {

    die('Hacking Attempt');
}

function spam_set_theme() {
    global $globals, $theme, $l, $error;

    //Admin Headers includes Global Headers
    adminhead($l['spam_settings']);
    ?>

    <div class="cbor" align="center">
        <img src="<?php echo $theme['images']; ?>admin/controlpanel.png">
        <span class="adgreen"><?php echo $l['spam_settings']; ?></span><br />
        <div class="expl">
            <?php echo $l['spam_set_exp']; ?>
        </div>
    </div>
    <br><br>
    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="spamsetform">
        <div class="division">
            <div class="topbar">
                <h3><?php echo $l['spam_settings']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['enable_akismet']; ?></b><br />
                    <span class="adexp"><?php echo $l['enable_akismet_exp']; ?></span>
                </div>
                <input  type="checkbox" name="enable_akismet" <?php echo ($globals['enable_akismet'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['akismet_key']; ?></b><br />
                    <span class="adexp"><?php echo $l['akismet_key_exp']; ?></span>
                </div>
                <input  type="text" size="40"  name="akismet_key" value="<?php echo (empty($_POST['akismet_key']) ? $globals['akismet_key'] : $_POST['akismet_key']); ?>" />
            <input type="submit" name="editspamset" value="<?php echo $l['submit']; ?>" />
            <div style="clear:both;"></div>
            </div>
        </div>
    </form>

    <?php
    error_handle($error, '100%');
    ?>

    <?php
    adminfoot();
}

function coreset_theme() {

    global $globals, $theme, $l, $error;

    //Admin Headers includes Global Headers
    adminhead($l['cp_core_set']);
    ?>

    <div class="cbor">
        <div align="center">
                <img src="<?php echo $theme['images']; ?>admin/controlpanel.png">
                <span class="adgreen"><?php echo $l['core_set']; ?></span><br />
        </div>

        <div class="expl">
                <?php echo $l['core_set_exp']; ?>
        </div>

    </div>


    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="coresetform">
        <div class="division">
            <div>
                <div class="topbar">
                    <h3><?php echo $l['core_set']; ?></h3>
                </div>
            </div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['board_url']; ?></b><br />
                    <span class="adexp"><?php echo $l['board_url_exp']; ?></span>
                </div>
                <input type="text" size="40"  name="url" value="<?php echo (empty($_POST['url']) ? $globals['url'] : $_POST['url']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>

            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['site_name']; ?></b><br />
                    <span class="adexp"><?php echo $l['site_name_exp']; ?></span>
                </div>
                <input type="text" size="30"  name="sn" value="<?php echo (empty($_POST['sn']) ? $globals['sn'] : $_POST['sn']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['board_email']; ?></b><br />
                    <span class="adexp"><?php echo $l['board_email_exp']; ?></span>
                </div>
                <input  type="text" size="30"  name="board_email" value="<?php echo (empty($_POST['board_email']) ? $globals['board_email'] : $_POST['board_email']); ?>" />
            </div>
            
            <div style="clear:both; padding-bottom: 10px;"></div>

            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['aef_folder']; ?></b><br />
                    <span class="adexp"><?php echo $l['aef_folder_exp']; ?></span>
                </div>
                <input  type="text" size="40"  name="server_url" value="<?php echo (empty($_POST['server_url']) ? $globals['server_url'] : $_POST['server_url']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>

            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['aef_main_files']; ?></b><br />
                    <span class="adexp"><?php echo $l['aef_main_files_exp']; ?></span>
                </div>
                <input  type="text" size="40"  name="mainfiles" value="<?php echo (empty($_POST['mainfiles']) ? $globals['mainfiles'] : $_POST['mainfiles']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>

            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['themes_folder']; ?></b><br />
                    <span class="adexp"><?php echo $l['themes_folder_exp']; ?></span>
                </div>
                <input  type="text" size="40"  name="themesdir" value="<?php echo (empty($_POST['themesdir']) ? $globals['themesdir'] : $_POST['themesdir']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>

            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['cookie_name']; ?></b><br />
                    <span class="adexp"><?php echo $l['cookie_name_exp']; ?></span>
                </div>
                <input  type="text" size="30"  name="cookie_name" value="<?php echo (empty($_POST['cookie_name']) ? $globals['cookie_name'] : $_POST['cookie_name']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>

            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['compress_output']; ?></b><br />
                    <span class="adexp"><?php echo $l['compress_output_exp']; ?></span>
                </div>
                <input  type="checkbox" name="gzip" <?php echo ($globals['gzip'] ? 'checked="checked"' : ''); ?> />
            </div>
            <div style="clear:both; padding-bottom: 10px;"></div>

            <div >
                <input type="submit" name="editcoreset" value="<?php echo $l['submit']; ?>" />
            </div>
            <div style="clear:both;"></div>
        </div>
    </form>    

    <?php
    adminfoot();
}

function mysqlset_theme() {

    global $globals, $theme, $l, $error, $message;

    //Admin Headers includes Global Headers
    adminhead($l['cp_mysql']);
    ?>

    <div class="cbor">
        <div align="center">
            <img src="<?php echo $theme['images']; ?>admin/controlpanel.png">
            <span class="adgreen"><?php echo $l['mysql_set']; ?></span><br />
        </div>
        <div class="expl">
            <?php echo $l['mysql_set_exp']; ?>
        </div>
    </div>
    <br><br>
    <?php
    error_handle($error, '100%');

    success_message($message, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="mysqlsetform">
        <div class="division">
            <div class="topbar">
                <h3><?php echo $l['mysql_set']; ?></h3>
            </div>
            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>    
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['server']; ?></b><br />
                    <span class="adexp"><?php echo $l['server_exp']; ?></span>
                </div>
                <input  type="text" size="40"  name="server" value="<?php echo (empty($_POST['server']) ? $globals['server'] : $_POST['server']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['mysql_user']; ?></b><br />
                    <span class="adexp"><?php echo $l['mysql_user_exp']; ?></span>
                </div>
                <input  type="text" size="40"  name="user" value="<?php echo (empty($_POST['user']) ? $globals['user'] : $_POST['user']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['mysql_pass']; ?></b><br />
                    <span class="adexp"><?php echo $l['mysql_pass_exp']; ?></span>
                </div>
                <input  type="password" size="40"  name="password" value="<?php echo (empty($_POST['password']) ? $globals['password'] : $_POST['password']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['mysql_database']; ?></b><br />
                    <span class="adexp"><?php echo $l['mysql_database_exp']; ?></span>
                </div>
                <input  type="text" size="40"  name="database" value="<?php echo (empty($_POST['database']) ? $globals['database'] : $_POST['database']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['mysql_prefix']; ?></b><br />
                    <span class="adexp"><?php echo $l['mysql_prefix_exp']; ?></span>
                </div>
                <input  type="text" size="40"  name="dbprefix" value="<?php echo (empty($_POST['dbprefix']) ? $globals['dbprefix'] : $_POST['dbprefix']); ?>" />
            </div>

            <div align="center"  colspan="2">
                <input type="submit" name="editmysqlset" value="<?php echo $l['submit']; ?>" />
            </div>
            <div style="clear:both;"></div> 
        </div>

    </form>


    <?php
    if ($globals['charset'] != 'UTF-8') {

        echo '<br><br>
            <form accept-charset="' . $globals['charset'] . '" action="" method="post" name="changecharsetform" onsubmit="return confirm(\'' . $l['confirm_utf8'] . '\');">
                <div class="division">
                    <div class="topbar">
                        <h3>UTF-8</h3>
                    </div>
                    <div>
                        ' . $l['utf8_exp'] . '
                        <input type="submit" name="changecharset" value="' . $l['make_utf8'] . '" />
                    </div>
                    <div style="clear:both;"></div>
                </div>
            </form>';
    }

    adminfoot();
}

function onoff_theme() {

    global $globals, $theme, $l, $error;

    //Admin Headers includes Global Headers
    adminhead($l['cp_on_off']);
    ?>

    <div class="cbor">
        <div align="center">
            <img src="<?php echo $theme['images']; ?>admin/controlpanel.png">
            <span class="adgreen"><?php echo $l['board_on_off']; ?></span><br />
        </div>

        <div class="expl" align="center">
            <?php echo $l['board_on_off_exp']; ?>
        </div>
    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="onoffform">
        <div class="division">
            <div class="topbar">
                <h3><?php echo $l['board_on_off']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['turn_board_off']; ?></b><br />
                    <span class="adexp"><?php echo $l['turn_board_off_exp']; ?></span>
                </div>
                <input  type="checkbox" name="maintenance"    <?php echo ($globals['maintenance'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['maintenance_subject']; ?></b>
                </div>
                <input  type="text" size="40"  name="maintenance_subject" value="<?php echo (empty($_POST['maintenance_subject']) ? $globals['maintenance_subject'] : $_POST['maintenance_subject']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['maintenance_message']; ?></b>
                </div>
                    <textarea cols="40" rows="6" name="maintenance_message" ><?php echo (empty($_POST['maintenance_message']) ? $globals['maintenance_message'] : $_POST['maintenance_message']); ?></textarea>
            </div>

            <div>
                <input type="submit" name="editonoff" value="<?php echo $l['submit']; ?>" />
            </div>
           <div style="clear:both;"></div>
        </div>
    </form>

    <?php
    adminfoot();
}

//Board mail settings
function mailset_theme() {

    global $globals, $theme, $l, $error;

    //Admin Headers includes Global Headers
    adminhead($l['cp_mail_set']);
    ?>

    <div class="cbor">

        <div align="center">
            <img src="<?php echo $theme['images']; ?>admin/controlpanel.png">
            <span class="adgreen"><?php echo $l['mail_set']; ?></span><br />
        </div>
        <div class="expl" align="center">
            <?php echo $l['mail_set_exp']; ?>
        </div>
    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="mailsetform">
        <div class="division">
            <div class="topbar">
                    <h3><?php echo $l['mail_set']; ?></h3>
            </div>
            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['mail_delivery_method']; ?></b><br />
                    <span class="adexp"><?php echo $l['mail_delivery_method_exp']; ?></span>
                </div>
                <select name="mail">
                    <option value="1" <?php echo (isset($_POST['mail']) && $_POST['mail'] == 1 ? 'selected="selected"' : ($globals['mail'] == 1 ? 'selected="selected"' : '' )); ?> ><?php echo $l['php_mail']; ?></option>
                    <option value="0" <?php echo (isset($_POST['mail']) && $_POST['mail'] == 0 ? 'selected="selected"' : ($globals['mail'] == 0 ? 'selected="selected"' : '' )); ?> ><?php echo $l['smtp']; ?></option>
                </select>
            </div>
            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['smtp_server']; ?></b>
                </div>
                <input  type="text" size="40"  name="mail_server" value="<?php echo (empty($_POST['mail_server']) ? $globals['mail_server'] : $_POST['mail_server']); ?>" />
            </div>
            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['smtp_port']; ?></b>
                </div>
                <input  type="text" size="40"  name="mail_port" value="<?php echo (empty($_POST['mail_port']) ? $globals['mail_port'] : $_POST['mail_port']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['smtp_username']; ?></b>
                </div>
                <input  type="text" size="40"  name="mail_user" value="<?php echo (empty($_POST['mail_user']) ? $globals['mail_user'] : $_POST['mail_user']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['smtp_pass']; ?></b>
                </div>
                <input  type="text" size="40"  name="mail_pass" value="<?php echo (empty($_POST['mail_pass']) ? $globals['mail_pass'] : $_POST['mail_pass']); ?>" />
            </div>
            <input type="submit" name="editmailset" value="<?php echo $l['submit']; ?>" />
            <div style="clear:both;"></div>
        </div>
    </form>

    <?php
    adminfoot();
}

//Board General settings
function genset_theme() {

    global $globals, $theme, $error, $lang_folders, $l;

    //Admin Headers includes Global Headers
    adminhead($l['cp_gen_set']);
    ?>

    <div class="cbor" align="center">

        <div>
            <img src="<?php echo $theme['images']; ?>admin/controlpanel.png">
            <span class="adgreen"><?php echo $l['gen_set']; ?></span><br />
        </div>

        <div class="expl">
            <?php echo $l['gen_set_exp']; ?>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="gensetform">
        <div class="division">

            <div class="topbar">
                <h3><?php echo $l['gen_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['enable_notifications']; ?></b><br />
                    <span class="adexp"><?php echo $l['enable_notifications_exp']; ?></span>
                </div>
                    <input  type="checkbox" name="notifications"    <?php echo ($globals['notifications'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['subscribe_auto']; ?></b><br />
                    <span class="adexp"><?php echo $l['subscribe_auto_exp']; ?></span>
                </div>
                    <input  type="checkbox" name="subscribeauto"    <?php echo ($globals['subscribeauto'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['session_timeout']; ?></b><br />
                    <span class="adexp"><?php echo $l['session_timeout_exp']; ?></span>
                </div>
                    <input  type="text" size="40"  name="session_timeout" value="<?php echo (empty($_POST['session_timeout']) ? $globals['session_timeout'] : $_POST['session_timeout']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['last_activity_time']; ?></b><br />
                    <span class="adexp"><?php echo $l['last_activity_time_exp']; ?></span>
                </div>
                    <input  type="text" size="40"  name="last_active_span" value="<?php echo (empty($_POST['last_active_span']) ? $globals['last_active_span'] : $_POST['last_active_span']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['make_login_compulsory']; ?></b><br />
                    <span class="adexp"><?php echo $l['make_login_compulsory_exp']; ?></span>
                </div>
                    <input  type="checkbox" name="only_users" <?php echo ($globals['only_users'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['maitain_daily_stats']; ?></b>
                </div>
                    <input  type="checkbox" name="stats" <?php echo ($globals['stats'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['members_hide_email']; ?></b>
                </div>
                    <input  type="checkbox" name="memhideemail" <?php echo ($globals['memhideemail'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['see_member_details']; ?></b>
                </div>
                    <input  type="checkbox" name="showmemdetails" <?php echo ($globals['showmemdetails'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['users_visited_today']; ?></b><br />
                    <span class="adexp"><?php echo $l['users_visited_today_exp']; ?></span>
                </div>
                    <input  type="checkbox" name="users_visited_today" <?php echo ($globals['users_visited_today'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['show_groups']; ?> :</b><br />
                    <span class="adexp"><?php echo $l['show_groups_exp']; ?></span>
                </div>
                    <input  type="checkbox" name="show_groups" <?php echo ($globals['show_groups'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['active_users_list']; ?></b><br />
                    <span class="adexp"><?php echo $l['active_users_list_exp']; ?></span>
                </div>
                    <input  type="text" size="40"  name="maxactivelist" value="<?php echo (empty($_POST['maxactivelist']) ? $globals['maxactivelist'] : $_POST['maxactivelist']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['num_members_list']; ?></b><br />
                    <span class="adexp"><?php echo $l['num_members_list_exp']; ?></span>
                </div>
                    <input  type="text" size="40"  name="maxmemberlist" value="<?php echo (empty($_POST['maxmemberlist']) ? $globals['maxmemberlist'] : $_POST['maxmemberlist']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['num_subscriptions_list']; ?></b><br />
                    <span class="adexp"><?php echo $l['num_subscriptions_list_exp']; ?></span>
                </div>
                    <input  type="text" size="40"  name="numsubinpage" value="<?php echo (empty($_POST['numsubinpage']) ? $globals['numsubinpage'] : $_POST['numsubinpage']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['num_recent_posts']; ?></b><br />
                    <span class="adexp"><?php echo $l['num_recent_posts_exp']; ?></span>
                </div>
                    <input  type="text" size="40"  name="recent_posts" value="<?php echo (empty($_POST['recent_posts']) ? $globals['recent_posts'] : $_POST['recent_posts']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['language']; ?></b><br />
                    <span class="adexp"><?php echo $l['default_language']; ?></span>
                </div>
                    <select name="language" />
                    <?php
                    foreach ($lang_folders as $k => $v) {

                        echo '<option value="' . $v . '" ' . (empty($_POST['language']) && $globals['language'] == $v ? 'selected="selected"' : (divim($_POST['language']) == $v ? 'selected="selected"' : '') ) . '>' . aefucfirst($v) . '</option>';
                    }
                    ?>
                    </select>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['report_posts']; ?> :</b>
                </div>
                    <input  type="checkbox" name="report_posts" <?php echo (isset($_POST['report_posts']) ? 'checked="checked"' : ($globals['report_posts'] ? 'checked="checked"' : '')); ?> />
            </div>

            <div>
                <div  align="center" colspan="2">
                    <br /><b><?php echo $l['board_time_zone']; ?> :</b>
                    &nbsp;&nbsp;&nbsp;&nbsp;<select name="timezone" style="font-size:11px;">
                        <option value="-12" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '-12' ? 'selected="selected"' : ($globals['timezone'] == -12 ? 'selected="selected"' : '')); ?> >(GMT -12:00) Eniwetok, Kwajalein</option>
                        <option value="-11" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '-11' ? 'selected="selected"' : ($globals['timezone'] == -11 ? 'selected="selected"' : '')); ?> >(GMT -11:00) Midway Island, Samoa</option>
                        <option value="-10" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '-10' ? 'selected="selected"' : ($globals['timezone'] == -10 ? 'selected="selected"' : '')); ?> >(GMT -10:00) Hawaii</option>
                        <option value="-9" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '-9' ? 'selected="selected"' : ($globals['timezone'] == -9 ? 'selected="selected"' : '')); ?> >(GMT -9:00) Alaska</option>
                        <option value="-8" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '-8' ? 'selected="selected"' : ($globals['timezone'] == -8 ? 'selected="selected"' : '')); ?> >(GMT -8:00) Pacific Time (US &amp; Canada)</option>
                        <option value="-7" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '-7' ? 'selected="selected"' : ($globals['timezone'] == -7 ? 'selected="selected"' : '')); ?> >(GMT -7:00) Mountain Time (US &amp; Canada)</option>
                        <option value="-6" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '-6' ? 'selected="selected"' : ($globals['timezone'] == -6 ? 'selected="selected"' : '')); ?> >(GMT -6:00) Cendival Time (US &amp; Canada), Mexico City</option>
                        <option value="-5" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '-5' ? 'selected="selected"' : ($globals['timezone'] == -5 ? 'selected="selected"' : '')); ?> >(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
                        <option value="-4" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '-4' ? 'selected="selected"' : ($globals['timezone'] == -4 ? 'selected="selected"' : '')); ?> >(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
                        <option value="-3.5" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '-3.5' ? 'selected="selected"' : ($globals['timezone'] == -3.5 ? 'selected="selected"' : '')); ?> >(GMT -3:30) Newfoundland</option>
                        <option value="-3" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '-3' ? 'selected="selected"' : ($globals['timezone'] == -3 ? 'selected="selected"' : '')); ?> >(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
                        <option value="-2" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '-2' ? 'selected="selected"' : ($globals['timezone'] == -2 ? 'selected="selected"' : '')); ?> >(GMT -2:00) Mid-Atlantic</option>
                        <option value="-1" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '-1' ? 'selected="selected"' : ($globals['timezone'] == -1 ? 'selected="selected"' : '')); ?> >(GMT -1:00 hour) Azores, Cape Verde Islands</option>
                        <option value="0" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '0' ? 'selected="selected"' : ($globals['timezone'] == 0 ? 'selected="selected"' : '')); ?> >(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
                        <option value="1" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '1' ? 'selected="selected"' : ($globals['timezone'] == 1 ? 'selected="selected"' : '')); ?> >(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
                        <option value="2" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '2' ? 'selected="selected"' : ($globals['timezone'] == 2 ? 'selected="selected"' : '')); ?> >(GMT +2:00) Kaliningrad, South Africa</option>
                        <option value="3" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '3' ? 'selected="selected"' : ($globals['timezone'] == 3 ? 'selected="selected"' : '')); ?> >(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
                        <option value="3.5" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '3.5' ? 'selected="selected"' : ($globals['timezone'] == 3.5 ? 'selected="selected"' : '')); ?> >(GMT +3:30) Tehran</option>
                        <option value="4" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '4' ? 'selected="selected"' : ($globals['timezone'] == 4 ? 'selected="selected"' : '')); ?> >(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
                        <option value="4.5" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '4.5' ? 'selected="selected"' : ($globals['timezone'] == 4.5 ? 'selected="selected"' : '')); ?> >(GMT +4:30) Kabul</option>
                        <option value="5" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '5' ? 'selected="selected"' : ($globals['timezone'] == 5 ? 'selected="selected"' : '')); ?> >(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
                        <option value="5.5" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '5.5' ? 'selected="selected"' : ($globals['timezone'] == 5.5 ? 'selected="selected"' : '')); ?> >(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
                        <option value="6" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '6' ? 'selected="selected"' : ($globals['timezone'] == 6 ? 'selected="selected"' : '')); ?> >(GMT +6:00) Almaty, Dhaka, Colombo</option>
                        <option value="7" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '7' ? 'selected="selected"' : ($globals['timezone'] == 7 ? 'selected="selected"' : '')); ?> >(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
                        <option value="8" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '8' ? 'selected="selected"' : ($globals['timezone'] == 8 ? 'selected="selected"' : '')); ?> >(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
                        <option value="9" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '9' ? 'selected="selected"' : ($globals['timezone'] == 9 ? 'selected="selected"' : '')); ?> >(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
                        <option value="9.5" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '9.5' ? 'selected="selected"' : ($globals['timezone'] == 9.5 ? 'selected="selected"' : '')); ?> >(GMT +9:30) Adelaide, Darwin</option>
                        <option value="10" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '10' ? 'selected="selected"' : ($globals['timezone'] == 10 ? 'selected="selected"' : '')); ?> >(GMT +10:00) Eastern Ausdivalia, Guam, Vladivostok</option>
                        <option value="11" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '11' ? 'selected="selected"' : ($globals['timezone'] == 11 ? 'selected="selected"' : '')); ?> >(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
                        <option value="12" <?php echo (isset($_POST['timezone']) && $_POST['timezone'] == '12' ? 'selected="selected"' : ($globals['timezone'] == 12 ? 'selected="selected"' : '')); ?> >(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
                    </select><br />
                    <span class="adexp">The default time zone of the Board.</span>
                </div>
            </div>

            <div>
                <div class="adcbg2" colspan="2">
                    <?php echo $l['forum_settings']; ?>
                </div>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['count_in_board']; ?></b><br />
                    <span class="adexp"><?php echo $l['count_in_board_exp']; ?></span>
                </div>
                <input  type="checkbox" name="countinboardposts" <?php echo (isset($_POST['countinboardposts']) ? 'checked="checked"' : ($globals['countinboardposts'] ? 'checked="checked"' : '')); ?> />
            </div>
            <div style="clear:both;"></div>
            <div>
                <div class="adcbg2" colspan="2">
                    <?php echo $l['news_settings']; ?>
                </div>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['enable_news_system']; ?></b><br />
                    <span class="adexp"><?php echo $l['enable_news_system_exp']; ?></span>
                </div>
                <input  type="checkbox" name="enablenews" <?php echo (isset($_POST['enablenews']) ? 'checked="checked"' : ($globals['enablenews'] ? 'checked="checked"' : '')); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['todays_in_ticker']; ?></b><br />
                    <span class="adexp"><?php echo $l['todays_in_ticker_exp']; ?></span>
                </div>
                <input  type="checkbox" name="todaysnews" <?php echo (isset($_POST['todaysnews']) ? 'checked="checked"' : ($globals['todaysnews'] ? 'checked="checked"' : '')); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['ticked_in_ticker']; ?></b><br />
                    <span class="adexp"><?php echo $l['ticked_in_ticker_exp']; ?></span>
                </div>
                <input  type="checkbox" name="tickednews" <?php echo (isset($_POST['tickednews']) ? 'checked="checked"' : ($globals['tickednews'] ? 'checked="checked"' : '')); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['articles_per_page']; ?></b><br />
                    <span class="adexp"><?php echo $l['articles_per_page_exp']; ?></span>
                </div>
                <input  type="text" size="20"  name="newsperpage" value="<?php echo (empty($_POST['newsperpage']) ? $globals['newsperpage'] : $_POST['newsperpage']); ?>" />
            </div>
            <div style="clear:both;"></div>
            <div>
                <div class="adcbg2" colspan="2">
                    <?php echo $l['rss_settings']; ?>
                </div>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['rss_recent']; ?></b><br />
                    <span class="adexp"><?php echo $l['rss_recent_exp']; ?></span>
                </div>
                <input  type="text" size="20"  name="rss_recent" value="<?php echo (empty($_POST['rss_recent']) ? $globals['rss_recent'] : $_POST['rss_recent']); ?>" />
            </div>
            <input type="submit" name="editgenset" value="<?php echo $l['submit']; ?>" />
            <div style="clear:both;"></div>
        </div>
    </form>

    <?php
    adminfoot();
}

//Shoutbox settings
function shoutboxset_theme() {

    global $globals, $theme, $error, $l;

    //Admin Headers includes Global Headers
    adminhead($l['cp_shout_box_set']);
    ?>

    <div class="cbor" align="center">
        <div>
            <img src="<?php echo $theme['images']; ?>admin/chat.gif">
            <span class="adgreen"><?php echo $l['shout_box']; ?></span><br />
        </div>

        <div class="expl">
            <?php echo $l['shout_box_exp']; ?>
        </div>

    </div>
    <br><br>
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="shoutboxsetform">
        <div class="division">
            <div class="topbar">
                <h3><?php echo $l['shout_box_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['enable_shoutbox']; ?></b><br />
                    <span class="adexp"><?php echo $l['enable_shoutbox_exp']; ?></span>
                </div>
                <input  type="checkbox" name="enableshoutbox" <?php echo (isset($_POST['enableshoutbox']) ? 'checked="checked"' : ($globals['enableshoutbox'] ? 'checked="checked"' : '')); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['num_shouts']; ?></b><br />
                    <span class="adexp"><?php echo $l['num_shouts_exp']; ?></span>
                </div>
                <input  type="text" size="40"  name="shouts" value="<?php echo (empty($_POST['shouts']) ? $globals['shouts'] : $_POST['shouts']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['shout_life']; ?></b><br />
                    <span class="adexp"><?php echo $l['shout_life_exp']; ?></span>
                </div>
                <input  type="text" size="40"  name="shoutboxtime" value="<?php echo (empty($_POST['shoutboxtime']) ? $globals['shoutboxtime'] : $_POST['shoutboxtime']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['enable_smilies']; ?></b><br />
                    <span class="adexp"><?php echo $l['enable_smilies_exp']; ?></span>
                </div>
                    <input  type="checkbox" name="shoutbox_emot" <?php echo (isset($_POST['shoutbox_emot']) ? 'checked="checked"' : ($globals['shoutbox_emot'] ? 'checked="checked"' : '')); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['enable_normal_bbc']; ?></b><br />
                    <span class="adexp"><?php echo $l['enable_normal_bbc_exp']; ?></span>
                </div>
                    <input  type="checkbox" name="shoutbox_nbbc" <?php echo (isset($_POST['shoutbox_nbbc']) ? 'checked="checked"' : ($globals['shoutbox_nbbc'] ? 'checked="checked"' : '')); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['enable_special_bbc']; ?></b><br />
                    <span class="adexp"><?php echo $l['enable_special_bbc_exp']; ?></span>
                </div>
                    <input  type="checkbox" name="shoutbox_sbbc" <?php echo (isset($_POST['shoutbox_sbbc']) ? 'checked="checked"' : ($globals['shoutbox_sbbc'] ? 'checked="checked"' : '')); ?> />
            </div>
            <input type="submit" name="editshoutboxset" value="<?php echo $l['submit']; ?>" />
            <div style="clear:both;"></div>
        </div>

        <br /><br />

        <div class="division">
            <div class="topbar">
                <h3><?php echo $l['delete_all_shouts']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['start_count_again']; ?></b><br />
                    <span class="adexp"><?php echo $l['start_count_again_exp']; ?></span>
                </div>
                <input  type="checkbox" name="divuncatediv" checked="checked" />
            </div>

            <input type="submit" name="delallshouts" value="<?php echo $l['delete']; ?>" />
            <div style="clear:both; padding-bottom: 10px;"></div>
        </div>

    </form>

    <?php
    adminfoot();
}

//Updates
function updates_theme() {

    global $globals, $theme, $error, $info, $l;

    //Admin Headers includes Global Headers
    adminhead($l['cp_update_aef']);
    ?>

    <div width="100%" cellpadding="1" cellspacing="0" class="cbor">

        <div>
            <div align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/updates.gif">
            </div>
            <div style="float:right;" class="adcbg1">

                <span class="adgreen"><?php echo $l['update_aef']; ?></span><br />

            </div>
        </div>

        <div>
            <div style="float:right;" colspan="2" >
                <?php echo $l['update_aef_exp']; ?></b>.
            </div>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="updatesform">
        <div width="100%" cellpadding="5" cellspacing="1" class="cbor">

            <div>
                <div  width="45%">
                    <b><?php echo $l['current_version']; ?></b>

                    &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $globals['version']; ?>
                </div>
            </div>

            <div>
                <div >
                    <b>Latest Version :</b>

                    &nbsp;&nbsp;&nbsp;&nbsp;<?php echo (empty($info['version']) ? $l['not_connect_aef'] : $info['version']); ?>
                </div>
            </div>

            <div>
                <div  colspan="2">
                    <?php echo $info['message']; ?>
                </div>
            </div>

            <div>
                <div  colspan="2" align="center">
                    <input type="submit" name="update" value="<?php echo $l['submit']; ?>" <?php echo (empty($info['link']) ? 'disabled="disabled"' : ''); ?> />
                </div>
            </div>

        </div>

    </form>

    <?php
    adminfoot();
}

//SEO settings
function seoset_theme() {

    global $globals, $theme, $error, $l;

    //Admin Headers includes Global Headers
    adminhead($l['cp_seo_set']);
    ?>

    <div class="cbor">

        <div align="center">
            <img src="<?php echo $theme['images']; ?>admin/spider.gif">
            <span class="adgreen"><?php echo $l['seo']; ?></span><br />
        </div>

        <div class="expl" >
            <?php echo $l['seo_exp']; ?>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="seosetform">
        <div class="division">
            <div class="topbar">
                <h3><?php echo $l['seo_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['title_in_links']; ?> :</b><br />
                    <span class="adexp"><?php echo $l['title_in_links_exp']; ?></span>
                </div>
                    <input  type="checkbox" name="title_in_link" <?php echo (isset($_POST['title_in_link']) ? 'checked="checked"' : ($globals['title_in_link'] ? 'checked="checked"' : '')); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['seo_urls']; ?> :</b><br />
                    <span class="adexp"><?php echo $l['seo_urls_exp']; ?></span>
                </div>
                    <input  type="checkbox" name="seo" <?php echo (isset($_POST['seo']) ? 'checked="checked"' : ($globals['seo'] ? 'checked="checked"' : '')); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['meta']; ?> :</b><br />
                    <span class="adexp"><?php echo $l['meta_exp']; ?></span>
                </div>
                <input  type="text" size="40"  name="keywords" value="<?php echo (empty($_POST['keywords']) ? $globals['keywords'] : $_POST['keywords']); ?>" />
            </div>

            <input type="submit" name="editseoset" value="<?php echo $l['submit']; ?>" />
            <div style="clear:both;"></div>
        </div>

    </form>

    <?php
    adminfoot();
}

//BAN settings
function banset_theme() {

    global $globals, $theme, $error, $l;

    //Admin Headers includes Global Headers
    adminhead($l['cp_ban_set']);
    ?>

    <div class="cbor"align="center">

        <div>
            <img src="<?php echo $theme['images']; ?>admin/ban.gif">
            <span class="adgreen"><?php echo $l['ban_ip']; ?></span><br />
        </div>
        <div>
            <div class="expl" >
                <?php echo $l['ban_ip_exp']; ?>
            </div>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>
    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="bansetform">
        <div class="division" id="ipdiv">
            <div class="topbar">
                    <h3><?php echo $l['ban_set']; ?></h3>
            </div>
            <div>
                <div >
                    <b><?php echo $l['specify_ip']; ?> :</b><br />
                    <span class="adexp"><?php echo $l['specify_ip_exp']; ?></span>
                </div>
            </div>

            <?php
            if (!empty($globals['bannedip']) || !empty($_POST['ips'])) {

                $ips = $globals['bannedip'];

                if (!empty($_POST['ips']) && is_array($_POST['ips'])) {

                    $ips = $_POST['ips'];
                }

                if (is_array($ips)) {

                    foreach ($ips as $v) {

                        if (empty($v))
                            continue;

                        echo '<div id="bannedip">
            <div  align="center"><input type="text" name="ips[]" value="' . $v . '" size="20" /></div>
            </div>';
                    }
                }
            }
            ?>

                <div  align="center">
                    <input type="button" onclick="addrow('ipdiv');" value="<?php echo $l['add_more_ips']; ?>" />&nbsp;&nbsp;
                </div>
                <input type="submit" name="editbanset" value="Submit" />
                <div style="clear:both;"></div>
        </div>
        <script type="text/javascript">
        function addrow(id){
            var t = $(id);
            var lasdivow = (t.getElementById('bannedip').length - 1);
            var x=t.inserdivow(lasdivow);
            var y = x.insertCell(0);
            y.innerHTML = '<input type="text" name="ips[]" size="20" />';
            y.className = "adbg";
            y.align = "center";
        }
    </script>
    </form>

    <?php
    adminfoot();
}
?>
