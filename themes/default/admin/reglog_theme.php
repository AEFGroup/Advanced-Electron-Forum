<?php
//////////////////////////////////////////////////////////////
//===========================================================
// reglog_theme.php(Admin)
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

function regset_theme() {

    global $globals, $l, $theme, $error;

    //Admin Headers includes Global Headers
    adminhead($l['cp_reg_set']);
    ?>

    <div class="cbor" align="center">
        <div>
            <img src="<?php echo $theme['images']; ?>admin/users.png">
            <font class="adgreen"><?php echo $l['reg_set']; ?></font><br />
        </div>

        <div class="expl">
                <?php echo $l['reg_set_exp']; ?>
        </div>
    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="regsetform">
        <div class="division">
            <div class="topbar">
                <h3><?php echo $l['reg_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['new_reg']; ?></b><br />
                    <font class="adexp"><?php echo $l['new_reg_exp']; ?></font>
                </div>
                <input type="checkbox" name="allow_reg"    <?php echo ($globals['allow_reg'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['reg_method']; ?></b><br />
                    <font class="adexp"><?php echo $l['reg_method_exp']; ?></font>
                </div>
                    <select name="reg_method">
                        <option value="1" <?php echo (isset($_POST['reg_method']) && $_POST['reg_method'] == 1 ? 'selected="selected"' : ($globals['reg_method'] == 1 ? 'selected="selected"' : '' )); ?> ><?php echo $l['immediate']; ?></option>
                        <option value="2" <?php echo (isset($_POST['reg_method']) && $_POST['reg_method'] == 2 ? 'selected="selected"' : ($globals['reg_method'] == 2 ? 'selected="selected"' : '' )); ?> ><?php echo $l['by_email']; ?></option>
                        <option value="3" <?php echo (isset($_POST['reg_method']) && $_POST['reg_method'] == 3 ? 'selected="selected"' : ($globals['reg_method'] == 3 ? 'selected="selected"' : '' )); ?> ><?php echo $l['by_admins']; ?></option>
                    </select>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['welcome_email']; ?></b><br />
                    <font class="adexp"><?php echo $l['welcome_email_exp']; ?></font>
                </div>
                <input type="checkbox" name="wel_email"    <?php echo ($globals['wel_email'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['notify_admin']; ?></b><br />
                    <font class="adexp"><?php echo $l['notify_admin_exp']; ?></font>
                </div>
                <input type="checkbox" name="reg_notify" <?php echo ($globals['reg_notify'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['max_uname_length']; ?></b><br />
                    <font class="adexp"><?php echo $l['max_uname_length_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="max_uname" value="<?php echo (empty($_POST['max_uname']) ? $globals['max_uname'] : $_POST['max_uname']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['min_uname_length']; ?></b><br />
                    <font class="adexp"><?php echo $l['min_uname_length_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="min_uname" value="<?php echo (empty($_POST['min_uname']) ? $globals['min_uname'] : $_POST['min_uname']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['max_pass_length']; ?></b><br />
                    <font class="adexp"><?php echo $l['max_pass_length_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="max_pass" value="<?php echo (empty($_POST['max_pass']) ? $globals['max_pass'] : $_POST['max_pass']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['min_pass_length']; ?></b><br />
                    <font class="adexp"><?php echo $l['min_pass_length_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="min_pass" value="<?php echo (empty($_POST['min_pass']) ? $globals['min_pass'] : $_POST['min_pass']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['confirm_code']; ?></b><br />
                    <font class="adexp"><?php echo $l['confirm_code_exp']; ?></font>
                </div>
                <input type="checkbox" name="sec_conf" <?php echo ($globals['sec_conf'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['same_pc_reg']; ?></b><br />
                    <font class="adexp"><?php echo $l['same_pc_reg_exp']; ?></font>
                </div>
                <input type="checkbox" name="samepc_reg" <?php echo ($globals['samepc_reg'] ? 'checked="checked"' : ''); ?> />
            </div>
            <input type="submit" name="editregset" value="<?php echo $l['submit']; ?>" />
            <div style="clear:both;"></div>
        </div>
    </form>

    <?php
    adminfoot();
}

function agerest_theme() {

    global $globals, $l, $theme, $error;

    //Admin Headers includes Global Headers
    adminhead($l['cp_age_rest']);
    ?>

    <div class="cbor" align="center">

        <div>
            <img src="<?php echo $theme['images']; ?>admin/users.png">
            <font class="adgreen"><?php echo $l['age_rest_set']; ?></font><br />
        </div>

        <div class="expl">
            <?php echo $l['age_rest_set_exp']; ?>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="agerestform">
        <div class="division">
            <div class="topbar">
                <h3><?php echo $l['age_rest_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['age']; ?></b><br />
                    <font class="adexp"><?php echo $l['age_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="age_limit" value="<?php echo (empty($_POST['v']) ? $globals['age_limit'] : $_POST['age_limit']); ?>" />
            </div>


            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['action']; ?></b><br />
                    <font class="adexp"><?php echo $l['action_exp']; ?></font>
                </div>
                    <select name="age_rest_act">
                        <option value="1" <?php echo (isset($_POST['age_rest_act']) && $_POST['age_rest_act'] == 1 ? 'selected="selected"' : ''); ?> ><?php echo $l['reject_reg']; ?></option>
                        <option value="2" <?php echo (isset($_POST['age_rest_act']) && $_POST['age_rest_act'] == 2 ? 'selected="selected"' : ''); ?> ><?php echo $l['require_parent_consent']; ?></option>
                    </select>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['address']; ?></b><br />
                    <font class="adexp"><?php echo $l['address_exp']; ?></font>
                </div>
                <textarea name="age_rest_act_address" cols="45" rows="6"><?php echo (empty($_POST['age_rest_act_address']) ? $globals['age_rest_act_address'] : $_POST['age_rest_act_address']); ?></textarea>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['fax']; ?></b><br />
                    <font class="adexp"><?php echo $l['fax_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="age_rest_act_fax" value="<?php echo (empty($_POST['age_rest_act_fax']) ? $globals['age_rest_act_fax'] : $_POST['age_rest_act_fax']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tlfn']; ?></b><br />
                    <font class="adexp"><?php echo $l['tlfn_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="age_rest_act_tele" value="<?php echo (empty($_POST['age_rest_act_tele']) ? $globals['age_rest_act_tele'] : $_POST['age_rest_act_tele']); ?>" />
            </div>
            <input type="submit" name="editagerestset" value="<?php echo $l['submit']; ?>" />
            <div style="clear:both;"></div>
        </div>
    </form>

    <?php
    adminfoot();
}

function reserved_theme() {

    global $globals, $l, $theme, $error;

    //Admin Headers includes Global Headers
    adminhead($l['cp_reserved_names_set']);
    ?>

    <div class="cbor" align="center">

        <div>
            <img src="<?php echo $theme['images']; ?>admin/users.png">
            <font class="adgreen"><?php echo $l['reserved_names_set']; ?></font><br />
        </div>

        <div class="expl">
            <?php echo $l['reserved_names_set_exp']; ?>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="reservedform">
        <div class="division">

            <div class="topbar">
                <h3><?php echo $l['reserved_names_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['reserved_names']; ?></b><br />
                    <font class="adexp"><?php echo $l['reserved_names_exp']; ?></font>
                </div>
                <textarea name="reserved_names" cols="45" rows="6"><?php echo (empty($_POST['reserved_names']) ? $globals['reserved_names'] : $_POST['reserved_names']); ?></textarea>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['match_whole_words']; ?></b><br />
                    <font class="adexp"><?php echo $l['match_whole_words_exp']; ?></font>
                </div>
                <input type="checkbox" name="reserved_match_whole"    <?php echo ($globals['reserved_match_whole'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['case_insens_match']; ?></b><br />
                    <font class="adexp"><?php echo $l['case_insens_match_exp']; ?></font>
                </div>
                <input type="checkbox" name="reserved_match_insensitive"    <?php echo ($globals['reserved_match_insensitive'] ? 'checked="checked"' : ''); ?> />
            </div>
            <input type="submit" name="editreserved" value="<?php echo $l['submit']; ?>" />
            <div style="clear:both;"></div>
        </div>
    </form>

    <?php
    adminfoot();
}

function logset_theme() {

    global $globals, $theme, $l, $error;

    //Admin Headers includes Global Headers
    adminhead($l['cp_login']);
    ?>

    <div class="cbor" align="center">

        <div>
            <img src="<?php echo $theme['images']; ?>admin/users.png">
            <font class="adgreen"><?php echo $l['login_set']; ?></font><br />
        </div>

        <div class="expl">
            <?php echo $l['login_set_exp']; ?>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="logsetform">
        <div class="division">

            <div class="topbar">
                <h3><?php echo $l['login_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['login_attempts']; ?></b><br />
                    <font class="adexp"><?php echo $l['login_attempts_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="login_failed" value="<?php echo (empty($_POST['login_failed']) ? $globals['login_failed'] : $_POST['login_failed']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['anonym_login']; ?></b><br />
                    <font class="adexp"><?php echo $l['anonym_login_exp']; ?></font>
                </div>
                <input type="checkbox" name="anon_login" <?php echo ($globals['anon_login'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['security_code']; ?></b><br />
                    <font class="adexp"><?php echo $l['security_code_exp']; ?></font>
                </div>
                <input type="checkbox" name="fpass_sec_conf" <?php echo ($globals['fpass_sec_conf'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['smart_redirect']; ?> :</b><br />
                    <font class="adexp"><?php echo $l['smart_redirect_exp']; ?></font>
                </div>
                <input type="checkbox" name="smart_redirect" <?php echo ($globals['smart_redirect'] ? 'checked="checked"' : ''); ?> />
            </div>
            <input type="submit" name="editlogset" value="<?php echo $l['submit']; ?>" />
            <div style="clear:both;"></div>
        </div>
    </form>

    <?php
    adminfoot();
}
?>