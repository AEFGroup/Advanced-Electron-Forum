<?php
//////////////////////////////////////////////////////////////
//===========================================================
// users_theme.php(Admin)
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

function proacc_theme() {

    global $globals, $l, $theme, $error;

    //Admin Headers includes Global Headers
    adminhead($l['usr_cp_profile_account_set']);
    ?>

    <div class="cbor" align="center">
        <div>
            <img src="<?php echo $theme['images']; ?>admin/users.png">
            <span class="adgreen"><?php echo $l['usr_profile_account_set']; ?></span><br />
        </div>

        <div class="expl">
            <?php echo $l['usr_profile_account_set_exp']; ?>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="proaccform">
        <div class="division">
            <div class="topbar">
                <h3><?php echo $l['usr_profile_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_utext_length']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_utext_length_exp']; ?></span>
                </div>
                <input type="text" size="30"  name="userstextlen" value="<?php echo (empty($_POST['userstextlen']) ? $globals['userstextlen'] : $_POST['userstextlen']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_uwww_length']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_uwww_length_exp']; ?></span>
                </div>
                <input type="text" size="30"  name="wwwlen" value="<?php echo (empty($_POST['wwwlen']) ? $globals['wwwlen'] : $_POST['wwwlen']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_custom_title_length']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_custom_title_length_exp']; ?></span>
                </div>
                <input type="text" size="30"  name="customtitlelen" value="<?php echo (empty($_POST['customtitlelen']) ? $globals['customtitlelen'] : $_POST['customtitlelen']); ?>" />
                </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_locat_length']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_locat_length_exp']; ?></span>
                </div>
                <input type="text" size="30"  name="locationlen" value="<?php echo (empty($_POST['locationlen']) ? $globals['locationlen'] : $_POST['locationlen']); ?>" />
            </div>
            <input type="submit" name="editproacc" value="<?php echo $l['usr_submit']; ?>" />
            <div style="clear:both;"></div>
        </div>

        <br />

        <div class="division">

            <div>
                <div class="topbar">
                    <h3><?php echo $l['usr_account_set']; ?></h3>
                </div>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_real_name_length']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_real_name_length_exp']; ?></span>
                </div>
                <input type="text" size="30"  name="realnamelen" value="<?php echo (empty($_POST['realnamelen']) ? $globals['realnamelen'] : $_POST['realnamelen']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_secret_qt_length']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_secret_qt_length_exp']; ?></span>
                </div>
                <input type="text" size="30"  name="secretqtlen" value="<?php echo (empty($_POST['secretqtlen']) ? $globals['secretqtlen'] : $_POST['secretqtlen']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_secret_answ_max_length']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_secret_answ_max_length_exp']; ?></span>
                </div>
                <input type="text" size="30"  name="secretansmaxlen" value="<?php echo (empty($_POST['secretansmaxlen']) ? $globals['secretansmaxlen'] : $_POST['secretansmaxlen']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_secret_answ_min_length']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_secret_answ_min_length_exp']; ?></span>
                </div>
                <input type="text" size="30"  name="secretansminlen" value="<?php echo (empty($_POST['secretansminlen']) ? $globals['secretansminlen'] : $_POST['secretansminlen']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_allow_uchanges']; ?></b>
                    <span class="adexp"><?php echo $l['usr_allow_uchanges_exp']; ?></span>
                </div>
                <input type="checkbox" name="change_username"    <?php echo ($globals['change_username'] ? 'checked="checked"' : ''); ?> />
            </div>
            <input type="submit" name="editproacc" value="<?php echo $l['usr_submit']; ?>" />
            <div style="clear:both;"></div>
        </div>

        <br />

        <div class="division">
            <div class="topbar">
                    <h3><?php echo $l['usr_sig_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_enable_sig']; ?></b>
                </div>
                <input type="checkbox" name="enablesig"    <?php echo ($globals['enablesig'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_usig_max_length']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_usig_max_length_exp']; ?></span>
                </div>
                <input type="text" size="30"  name="usersiglen" value="<?php echo (empty($_POST['usersiglen']) ? $globals['usersiglen'] : $_POST['usersiglen']); ?>" />
            </div>
            <input type="submit" name="editproacc" value="<?php echo $l['usr_submit']; ?>" />
            <div style="clear:both;"></div>
        </div>
    </form>

    <?php
    adminfoot();
}

function avaset_theme() {

    global $globals, $l, $theme, $error;

    //Admin Headers includes Global Headers
    adminhead($l['usr_cp_avatar_set']);
    ?>

    <div class="cbor" align="center">
        <div>
            <img src="<?php echo $theme['images']; ?>admin/users.png">
            <span class="adgreen"><?php echo $l['usr_avatar_set']; ?></span><br />
        </div>
        <div class="expl">
            <?php echo $l['usr_avatar_set_exp']; ?>
        </div>
    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="avasetform">
        <div class="division">
            <div class="topbar">
                <h3><?php echo $l['usr_avatar_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_show_avatars']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_show_avatars_exp']; ?></span>
                </div>
                <input type="checkbox" name="showavatars" <?php echo ($globals['showavatars'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_avatar_dir']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_avatar_dir_exp']; ?></span>
                </div>
                <input type="text" size="40"  name="avatardir" value="<?php echo (empty($_POST['avatardir']) ? $globals['avatardir'] : $_POST['avatardir']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_avatar_url']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_avatar_url_exp']; ?></span>
                </div>
                <input type="text" size="40"  name="avatarurl" value="<?php echo (empty($_POST['avatarurl']) ? $globals['avatarurl'] : $_POST['avatarurl']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_up_avatar_dir']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_up_avatar_dir_exp']; ?></span>
                </div>
                <input type="text" size="40"  name="uploadavatardir" value="<?php echo (empty($_POST['uploadavatardir']) ? $globals['uploadavatardir'] : $_POST['uploadavatardir']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_up_avatar_url']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_up_avatar_url_exp']; ?></span>
                </div>
                <input type="text" size="40"  name="uploadavatarurl" value="<?php echo (empty($_POST['uploadavatarurl']) ? $globals['uploadavatarurl'] : $_POST['uploadavatarurl']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_up_avatar_max_size']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_up_avatar_max_size_exp']; ?></span>
                </div>
                <input type="text" size="40"  name="uploadavatarmaxsize" value="<?php echo (empty($_POST['uploadavatarmaxsize']) ? $globals['uploadavatarmaxsize'] : $_POST['uploadavatarmaxsize']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_up_avatar_file_type']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_up_avatar_file_type_exp']; ?></span>
                </div>
                <input type="text" size="40"  name="avatartypes" value="<?php echo (empty($_POST['avatartypes']) ? $globals['avatartypes'] : $_POST['avatartypes']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_width_height_avatar']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_width_height_avatar_exp']; ?></span>
                </div>
                <input type="text" size="10"  name="av_width" value="<?php echo (empty($_POST['av_width']) ? $globals['av_width'] : $_POST['av_width']); ?>" /> x <input type="text" size="10"  name="av_height" value="<?php echo (empty($_POST['av_height']) ? $globals['av_height'] : $_POST['av_height']); ?>" />
            </div>
            <input type="submit" name="editavaset" value="<?php echo $l['usr_submit']; ?>" />
            <div style="clear:both;"></div>
        </div>

        <br />
    </form>

    <?php
    adminfoot();
}

function ppicset_theme() {

    global $globals, $l, $theme, $error;

    //Admin Headers includes Global Headers
    adminhead($l['usr_cp_perpic_set']);
    ?>

    <div class="cbor" align="center">

        <div>
            <img src="<?php echo $theme['images']; ?>admin/users.png">
            <span class="adgreen"><?php echo $l['usr_perpic_set']; ?></span><br />
        </div>

        <div>
            <div class="expl">
                <?php echo $l['usr_perpic_set_exp']; ?>
            </div>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="ppicsetform">
        <div class="division">
            <div class="topbar">
                <h3><?php echo $l['usr_perpic_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_up_perpic_dir']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_up_perpic_dir_exp']; ?></span>
                </div>
                <input type="text" size="40"  name="uploadppicdir" value="<?php echo (empty($_POST['uploadppicdir']) ? $globals['uploadppicdir'] : $_POST['uploadppicdir']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_perpic_url']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_perpic_url_exp']; ?></span>
                </div>
                <input type="text" size="40"  name="uploadppicurl" value="<?php echo (empty($_POST['uploadppicurl']) ? $globals['uploadppicurl'] : $_POST['uploadppicurl']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_perpic_max_size']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_perpic_max_size_exp']; ?></span>
                </div>
                <input type="text" size="40"  name="uploadppicmaxsize" value="<?php echo (empty($_POST['uploadppicmaxsize']) ? $globals['uploadppicmaxsize'] : $_POST['uploadppicmaxsize']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_perpic_file_type']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_perpic_file_type_exp']; ?></span>
                </div>
                <input type="text" size="40"  name="ppictypes" value="<?php echo (empty($_POST['ppictypes']) ? $globals['ppictypes'] : $_POST['ppictypes']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_width_height_perpic']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_width_height_perpic_exp']; ?></span>
                </div>
                <input type="text" size="10"  name="ppic_width" value="<?php echo (empty($_POST['ppic_width']) ? $globals['ppic_width'] : $_POST['ppic_width']); ?>" /> x <input type="text" size="10"  name="ppic_height" value="<?php echo (empty($_POST['ppic_height']) ? $globals['ppic_height'] : $_POST['ppic_height']); ?>" />
            </div>
            <input type="submit" name="editppicset" value="<?php echo $l['usr_submit']; ?>" />
            <div style="clear:both;"></div>
        </div>
    </form>

    <?php
    adminfoot();
}

//Pm Settings theme
function pmset_theme() {

    global $globals, $l, $theme, $error;

    //Admin Headers includes Global Headers
    adminhead($l['usr_cp_pm_set']);
    ?>

    <div class="cbor" align="center">
        <div>
            <img src="<?php echo $theme['images']; ?>admin/users.png">
            <span class="adgreen"><?php echo $l['usr_pm_set']; ?></span><br />
        </div>
        <div class="expl">
            <?php echo $l['usr_pm_set_exp']; ?>
        </div>
    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="pmsetform">
        <div class="division">

            <div class="topbar">
                <h3><?php echo $l['usr_pm_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_enable_pm']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_enable_pm_exp']; ?></span>
                </div>
                <input type="checkbox" name="pmon" <?php echo ($globals['pmon'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_notify_new_pm']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_notify_new_pm_exp']; ?></span>
                </div>
                <input type="checkbox" name="notifynewpm" <?php echo ($globals['notifynewpm'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_allow_smileys']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_allow_smileys_exp']; ?></span>
                </div>
                <input type="checkbox" name="pmusesmileys" <?php echo ($globals['pmusesmileys'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_save out_pm']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_save out_pm_exp']; ?></span>
                </div>
                <input type="checkbox" name="pmsaveinsentitems" <?php echo ($globals['pmsaveinsentitems'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['usr_num_pm']; ?></b><br />
                    <span class="adexp"><?php echo $l['usr_num_pm_exp']; ?></span>
                </div>
                <input type="text" size="40"  name="pmnumshowinfolders" value="<?php echo (empty($_POST['pmnumshowinfolders']) ? $globals['pmnumshowinfolders'] : $_POST['pmnumshowinfolders']); ?>" />
            </div>
            <input type="submit" name="editpmset" value="<?php echo $l['usr_submit']; ?>" />
            <div style="clear:both;"></div>
        </div>
    </form>

    <?php
    adminfoot();
}
?>