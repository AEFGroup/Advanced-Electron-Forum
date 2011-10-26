<?php

function profile_theme() {

    global $theme, $user, $globals, $l, $error, $foldercount;

    //The global User CP Headers
    usercphead($l['acc_prof_set']);

    error_handle($error);
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="editprofileform">
        <div class="division">
            <div class="topbar">
                <h3><?php echo $l['acc_gen_prof_set']; ?></h3>
            </div>

            <div>
                <div class="cbgbor">

                    <div width="100%" cellpadding="2" cellspacing="1">

                        <div>
                            <div class="ucpfcbg1" colspan="2" align="center">
                                <img src="<?php echo $theme['images']; ?>usercp/general.gif" />
                            </div>
                        </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:300px; float:left; padding:5px;">
                    <b><?php echo $l['acc_date_birth']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['acc_y_m-d']; ?></font>
                </div>
                <input type="text" maxlength="4" size="4" name="dobyear" value="<?php echo (isset($_POST['dobyear']) ? $_POST['dobyear'] : $user['dobyear']); ?>" /> - <input type="text" maxlength="2" size="2" name="dobmonth" value="<?php echo (isset($_POST['dobmonth']) ? $_POST['dobmonth'] : $user['dobmonth']); ?>" /> - <input type="text" maxlength="2" size="2" name="dobday" value="<?php echo (isset($_POST['dobday']) ? $_POST['dobday'] : $user['dobday']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:300px; float:left; padding:5px;">
                    <b><?php echo $l['acc_custom_title']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['acc_custom_title_exp']; ?></font>
                </div>
                <input type="text" size="45" name="title" value="<?php echo (isset($_POST['title']) ? $_POST['title'] : $user['customtitle']); ?>" maxlength="<?php echo $globals['customtitlelen']; ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:300px; float:left; padding:5px;">
                    <b><?php echo $l['acc_location']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['acc_location_exp']; ?></font>
                </div>
                <input type="text" size="45" name="location" value="<?php echo (isset($_POST['location']) ? $_POST['location'] : $user['location']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:300px; float:left; padding:5px;">
                    <b><?php echo $l['acc_gender']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['acc_gender_exp']; ?></font>
                </div>
                <select name="gender" size="1">
                    <option value="1"  <?php echo ( (isset($_POST['gender']) && (int) $_POST['gender'] == 1) ? 'selected="selected"' : (($user['gender'] == 1) ? 'selected="selected"' : '') ); ?>><?php echo $l['acc_male']; ?></option>
                    <option value="2" <?php echo ( (isset($_POST['gender']) && (int) $_POST['gender'] == 2) ? 'selected="selected"' : (($user['gender'] == 2) ? 'selected="selected"' : '') ); ?>><?php echo $l['acc_female']; ?></option>
                </select>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:300px; float:left; padding:5px;">
                    <b><?php echo $l['acc_private_text']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['acc_private_text_exp']; ?></font>
                </div>
                <input type="text" size="45" name="privatetext" value="<?php echo (isset($_POST['privatetext']) ? $_POST['privatetext'] : $user['users_text']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:300px; float:left; padding:5px;">
                    <b><?php echo $l['acc_icq']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['acc_icq_exp']; ?></font>
                </div>
                <input type="text" size="24" name="icq" value="<?php echo (isset($_POST['icq']) ? $_POST['icq'] : $user['icq']); ?>" />
            </div>


            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:300px; float:left; padding:5px;">
                    <b><?php echo $l['acc_yim']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['acc_yim_exp']; ?></font>
                </div>
                <input type="text" size="24" name="yim" value="<?php echo (isset($_POST['yim']) ? $_POST['yim'] : $user['yim']); ?>" />
            </div>


            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:300px; float:left; padding:5px;">
                    <b><?php echo $l['acc_msn']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['acc_msn_exp']; ?></font>
                </div>
            <input type="text" size="24" name="msn" value="<?php echo (isset($_POST['msn']) ? $_POST['msn'] : $user['msn']); ?>" />
            </div>


            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:300px; float:left; padding:5px;">
                    <b><?php echo $l['acc_aim']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['acc_aim_exp']; ?></font>
                </div>
            <input type="text" size="24" name="aim" value="<?php echo (isset($_POST['aim']) ? $_POST['aim'] : $user['aim']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:300px; float:left; padding:5px;">
                    <b><?php echo $l['acc_gmail']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['acc_gmail_exp']; ?></font>
                </div>
            <input type="text" size="24" name="gmail" value="<?php echo (isset($_POST['gmail']) ? $_POST['gmail'] : $user['gmail']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:300px; float:left; padding:5px;">
                    <b><?php echo $l['acc_www']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['acc_www_exp']; ?></font>
                </div>
                <input type="text" size="45" name="www" value="<?php echo (isset($_POST['www']) ? $_POST['www'] : $user['www']); ?>" />
            </div>

            <input type="submit" name="editprofile" value="<?php echo $l['acc_edit_profile']; ?>" />
            <div style="clear:both;"></div>
        </div>
    </form>

    <?php
    //The global User CP Footers
    usercpfoot();
}

function account_theme() {

    global $theme, $user, $globals, $l, $error;

    //The global User CP Headers
    usercphead($l['acc_edit_acc_set']);

    error_handle($error);
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="editaccountform">

        <div width="100%" cellpadding="0" cellspacing="0">
            <div>
                <div>
                    <div width="100%" cellpadding="0" cellspacing="0"><div>
                            <div class="ucpcbgl"></div>
                            <div class="ucpcbg"><?php echo $l['acc_acc_set']; ?></div>
                            <div class="ucpcbgr"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="cbgbor">

                    <div width="100%" cellpadding="2" cellspacing="1">

                        <div>
                            <div class="ucpfcbg1" colspan="2" align="center">
                                <img src="<?php echo $theme['images']; ?>usercp/account.gif" />
                            </div>
                        </div>


                        <div>
                            <div class="ucpflc" width="30%">
                                <b><?php echo $l['acc_realname']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['acc_realname_exp']; ?></font>
                            </div>
                            <div class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="text" size="45" name="realname" value="<?php echo (isset($_POST['realname']) ? $_POST['realname'] : $user['realname']); ?>" />
                            </div>
                        </div>

                        <div>
                            <div class="ucpflc" width="30%">
                                <b><?php echo $l['acc_usname']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['acc_usname_exp']; ?></font>
                            </div>
                            <div class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="text" size="45" name="username" value=<?php echo '"' . (isset($_POST['username']) ? $_POST['username'] : $user['username']) . '" ' . (empty($globals['change_username']) ? 'disabled="disabled"' : ''); ?> />
                            </div>
                        </div>

                        <div>
                            <div class="ucpflc" width="30%">
                                <b><?php echo $l['acc_new_pass']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['acc_new_pass_exp']; ?></font>
                            </div>
                            <div class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="password" size="30" name="newpass" />
                            </div>
                        </div>

                        <div>
                            <div class="ucpflc" width="30%">
                                <b><?php echo $l['acc_conf_new_pass']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['acc_conf_new_pass_exp']; ?></font>
                            </div>
                            <div class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="password" size="30" name="confirmnewpass" />
                            </div>
                        </div>


                        <div>
                            <div class="ucpflc" width="30%">
                                <b><?php echo $l['acc_sec_qt']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['acc_sec_qt_exp']; ?></font>
                            </div>
                            <div class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="text" size="45" name="secretqt" value="<?php echo (isset($_POST['secretqt']) ? $_POST['secretqt'] : $user['secret_question']); ?>" />
                            </div>
                        </div>


                        <div>
                            <div class="ucpflc" width="30%">
                                <b><?php echo $l['acc_answer']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['acc_answer_exp']; ?></font>
                            </div>
                            <div class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="text" size="30" name="answer" />
                            </div>
                        </div>


                        <div>
                            <div class="ucpflc" width="30%">
                                <b><?php echo $l['acc_email']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['acc_email_exp']; ?></font>
                            </div>
                            <div class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="text" size="45" name="email" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : $user['email']); ?>" />
                            </div>
                        </div>


                        <div>
                            <div class="ucpflc" width="30%">
                                <b><?php echo $l['acc_curr_pass']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['acc_curr_pass_exp']; ?></font>
                            </div>
                            <div class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="password" size="30" name="currentpass" />
                            </div>
                        </div>


                        <div>
                            <div class="ucpflc" colspan="2" align="center">
                                <input type="submit" name="editaccount" value="<?php echo $l['acc_save_ch']; ?>" />
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div>
                <div><img src="<?php echo $theme['images']; ?>cbotsmall.png" width="100%" height="10"></div>
            </div>
        </div>

    </form>

    <?php
    //The global User CP Footers
    usercpfoot();
}

function signature_theme() {

    global $theme, $user, $globals, $l, $error, $smileys, $smileycode, $smileyimages, $popup_emoticons, $dmenus;

    //The global User CP Headers
    usercphead($l['acc_sig_set']);

    error_handle($error);

    //Include the WYSIWYG functions
    include_once($theme['path'] . '/texteditor_theme.php');

    //Iframe for WYSIWYG
    $dmenus[] = '<iframe id="aefwysiwyg" style="width:420px; height:175px; visibility: hidden; left:0px; top:0px; position:absolute; border:1px solid #666666; background:#FFFFFF;" frameborder="0" marginheight="3" marginwidth="3"></iframe>';
    ?>
    <script language="JavaScript" src="<?php echo $theme['url'] . '/js/texteditor.js'; ?>" type="text/javascript">
    </script>

    <script type="text/javascript">
        addonload('init_editor();');
        function init_editor(){
            try_wysiwyg = <?php echo (empty($theme['wysiwyg']) ? 'false' : 'true'); ?>;
            editor = new aef_editor();
            editor.wysiwyg_id = 'aefwysiwyg';
            editor.textarea_id = 'sig';
            if(try_wysiwyg){
                editor.to_wysiwyg(true);//Directly try to pass to WYSIWYG Mode
            }
        };
    </script>

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="editsigform" onsubmit="editor.onsubmit();">

        <div width="100%" cellpadding="0" cellspacing="0">
            <div>
                <div>
                    <div width="100%" cellpadding="0" cellspacing="0"><div>
                            <div class="ucpcbgl"></div>
                            <div class="ucpcbg"><?php echo $l['acc_edit_ur_sig']; ?></div>
                            <div class="ucpcbgr"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="cbgbor">

                    <div width="100%" cellpadding="3" cellspacing="1">

                        <div>
                            <div class="ucpfcbg1" colspan="2" align="center">
                                <img src="<?php echo $theme['images']; ?>usercp/signature.gif" />
                            </div>
                        </div>


                        <div>
                            <div width="23%" class="ucpflc" valign="top"><b><?php echo $l['acc_txt_format']; ?></b></div>
                            <div class="ucpfrc">
                                <?php editor_buttons('editor'); ?>
                            </div>
                        </div>

                        <?php editor_smileys('editor', $globals['usesmileys']); ?>

                        <div>
                            <div class="ucpflc" valign="top"><b><?php echo $l['acc_sig']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['acc_sig_exp']; ?></font></div>
                            <div class="ucpfrc"><textarea name="signature" rows="13" cols="65" onchange="storeCaret(this);" onkeyup="storeCaret(this);" onclick="storeCaret(this);" onselect="storeCaret(this);" id="sig" /><?php echo (isset($_POST['signature']) ? $_POST['signature'] : $user['sig']); ?></textarea>
                            </div>
                        </div>

                        <div>
                            <div class="ucpflc" colspan="2" align="center">
                                <input type="submit" name="editsig" value="<?php echo $l['acc_save_ch']; ?>" />
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div>
                <div><img src="<?php echo $theme['images']; ?>cbotsmall.png" width="100%" height="10"></div>
            </div>
        </div>
    </form>

    <?php
    //The global User CP Footers
    usercpfoot();
}

function avatar_theme() {

    global $theme, $user, $globals, $l, $error, $avatargallery, $onload;

    //Pass to onload to initialize a JS
    $onload['fillup'] = 'fillup()';

    //The global User CP Headers
    usercphead($l['acc_avatar_set']);

    error_handle($error);

    $curpp = urlifyavatar(70);
    ?>

    <!-- Do not edit IE conditional style below -->
    <!--[if gte IE 5.5]>
    <style type="text/css">
    #motioncontainer {
    width:expression(Math.min(this.offsetWidth, maxwidth)+'px');
    }
    </style>
    <![endif]-->
    <!-- End Conditional Style -->
    <link rel="stylesheet" type="text/css" href="<?php echo $theme['url']; ?>/motiongallery.css" />
    <script language="javascript" type="text/javascript" src="<?php echo $theme['url']; ?>/js/motiongallery.js">
    </script>
    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="editavatarform" enctype="multipart/form-data">
        <script type="text/javascript">
            function checkradio(id){
                $(id).checked=true
            }
        </script>

        <div width="100%" cellpadding="0" cellspacing="0">
            <div>
                <div>
                    <div width="100%" cellpadding="0" cellspacing="0"><div>
                            <div class="ucpcbgl"></div>
                            <div class="ucpcbg"><?php echo $l['acc_edit_ur_avatar']; ?></div>
                            <div class="ucpcbgr"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="cbgbor">

                    <div width="100%" cellpadding="2" cellspacing="1">

                        <div>
                            <div class="ucpfcbg1" colspan="3" align="center">
                                <img src="<?php echo $theme['images']; ?>usercp/avatar.gif" />
                            </div>
                        </div>

                        <div>
                            <div class="ucpflc" align="center" colspan="2"><b><?php echo $l['acc_ur_curr_avatar']; ?></b>
                            </div>
                            <div class="ucpfrc" align="center">
                                <img src="<?php echo $curpp[0]; ?>" height="<?php echo $curpp[2]; ?>" width="<?php echo $curpp[1]; ?>" />
                            </div>
                        </div>

                        <div>
                            <div class="ucpflc" align="center" width="3%">
                                <input type="radio" name="avatartype" id="avgallery" value="1" <?php echo ((isset($_POST['avatartype'])) ? (((int) $_POST['avatartype'] == 1) ? 'checked="checked"' : '') : (($user['avatar_type'] == 1) ? 'checked="checked"' : '')); ?> />
                            </div>
                            <div class="ucpflc" width="25%" align="left">
                                <b><?php echo $l['acc_avatar_gall']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['acc_avatar_gall_exp']; ?></font>
                            </div>
                            <div class="ucpfrc" align="left">

                                <div id="motioncontainer" style="position:relative;overflow:hidden;">
                                    <div id="motiongallery" style="position:absolute;left:0;top:0;white-space: nowrap;">

                                        <div id="trueContainer">
                                            <div>
                                                <?php
                                                if (!empty($avatargallery)) {


                                                    foreach ($avatargallery as $ak => $av) {

                                                        echo '<div>
            <a href="javascript:checkradio(\'' . $av['name'] . '\');checkradio(\'avgallery\');"/>
            <img src="' . $globals['avatarurl'] . '/' . $av['name'] . '" border=1>
            </a>
            </div>';
                                                    }
                                                } else {

                                                    echo '<div>' . $l['acc_noimg_avatar_gall'] . '</div>';
                                                }
                                                ?>

                                            </div>

                                            <div>
                                                <?php
                                                if (!empty($avatargallery)) {

                                                    foreach ($avatargallery as $ak => $av) {

                                                        echo '<div>
            <input type="radio" name="avatargalfile" id="' . $av['name'] . '" value="' . $av['name'] . '" ' . ( (isset($_POST['avatartype'])) ? ((isset($_POST['avatargalfile']) && $_POST['avatargalfile'] == $av['name'] && ((int) $_POST['avatartype'] == 1)) ? 'checked="checked"' : '' ) : ((($user['avatar_type'] == 1) && ($av['name'] == $user['avatar'])) ? 'checked="checked"' : '' ) ) . ' />
            </div>';
                                                    }
                                                } else {

                                                    echo '<div>&nbsp;</div>';
                                                }
                                                ?>

                                            </div>

                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <div class="ucpflc" align="center" width="3%">
                                <input type="radio" name="avatartype" id="avurl" value="2" <?php echo ((isset($_POST['avatartype'])) ? (((int) $_POST['avatartype'] == 2) ? 'checked="checked"' : '') : (($user['avatar_type'] == 2) ? 'checked="checked"' : '')); ?> />
                            </div>
                            <div class="ucpflc" width="25%" align="left">
                                <b><?php echo $l['acc_online_img']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['acc_online_img_exp']; ?></font>
                            </div>
                            <div class="ucpfrc" align="left">
                                <input type="text" size="45" name="urlavatar" <?php echo ( (isset($_POST['avatartype']) && (int) $_POST['avatartype'] == 2) && (isset($_POST['urlavatar'])) ? 'value="' . $_POST['urlavatar'] . '"' : (($user['avatar_type'] == 2) ? 'value="' . ($user['avatar']) . '"' : '') ); ?> onfocus="$('avurl').checked = true;" />
                            </div>
                        </div>

                        <div>
                            <div class="ucpflc" align="center">
                                <input type="radio" name="avatartype" id="avupload" value="3" <?php echo ((isset($_POST['avatartype'])) ? (((int) $_POST['avatartype'] == 3) ? 'checked="checked"' : '') : (($user['avatar_type'] == 3) ? 'checked="checked"' : '')); ?> />
                            </div>
                            <div class="ucpflc" align="left">
                                <b><?php echo $l['acc_upl_img']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['acc_upl_img_exp']; ?></font>
                            </div>
                            <div class="ucpfrc" align="left">
                                <?php echo (($user['avatar_type'] == 3) ? '<img src="' . $curpp[0] . '" height="' . $curpp[4] . '" width="' . $curpp[3] . '" />' : ''); ?><br />
                                <input type="file" name="uploadavatar" size="45" onfocus="$('avupload').checked = true;" />
                            </div>
                        </div>

                        <div>
                            <div class="ucpflc" colspan="3" align="center">
                                <input type="submit" name="editavatar" value="<?php echo $l['acc_save_ch']; ?>" />&nbsp;<input type="submit" name="removeavatar" value="<?php echo $l['acc_rem_avatar']; ?>" />
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div>
                <div><img src="<?php echo $theme['images']; ?>cbotsmall.png" width="100%" height="10"></div>
            </div>
        </div>
    </form>

    <?php
    //The global User CP Footers
    usercpfoot();
}

function personalpic_theme() {

    global $theme, $user, $globals, $l, $error;

    //The global User CP Headers
    usercphead($l['acc_perpic_set']);

    error_handle($error);

    $curpp = urlifyppic(70);
    ?>


    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="editppicform" enctype="multipart/form-data">

        <div width="100%" cellpadding="0" cellspacing="0">
            <div>
                <div>
                    <div width="100%" cellpadding="0" cellspacing="0"><div>
                            <div class="ucpcbgl"></div>
                            <div class="ucpcbg"><?php echo $l['acc_edit_ur_perpic']; ?></div>
                            <div class="ucpcbgr"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="cbgbor">

                    <div width="100%" cellpadding="2" cellspacing="1">

                        <div>
                            <div class="ucpfcbg1" colspan="3" align="center">
                                <img src="<?php echo $theme['images']; ?>usercp/personalpicture.gif" />
                            </div>
                        </div>

                        <div>
                            <div class="ucpflc" align="center" colspan="2"><b><?php echo $l['acc_curr_perpic']; ?></b>
                            </div>
                            <div class="ucpfrc" align="center">
                                <img src="<?php echo $curpp[0]; ?>" height="<?php echo $curpp[2]; ?>" width="<?php echo $curpp[1]; ?>" />
                            </div>
                        </div>


                        <div>
                            <div class="ucpflc" align="center" width="3%">
                                <input type="radio" name="ppictype" id="ppicurl" value="1" <?php echo ((isset($_POST['ppictype'])) ? (((int) $_POST['ppictype'] == 1) ? 'checked="checked"' : '') : (($user['ppic_type'] == 1) ? 'checked="checked"' : '')); ?> />
                            </div>
                            <div class="ucpflc" width="25%" align="left">
                                <b><?php echo $l['acc_online_perpic']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['acc_online_perpic_exp']; ?></font>
                            </div>
                            <div class="ucpfrc" align="left">
                                <input type="text" size="45" name="urlppic" <?php echo ( (isset($_POST['ppictype']) && (int) $_POST['ppictype'] == 1) && (isset($_POST['urlppic'])) ? 'value="' . $_POST['urlppic'] . '"' : (($user['ppic_type'] == 1) ? 'value="' . ($user['ppic']) . '"' : '') ); ?> onfocus="$('ppicurl').checked = true;" />
                            </div>
                        </div>

                        <div>
                            <div class="ucpflc" align="center">
                                <input type="radio" name="ppictype" id="ppicupload" value="2" <?php echo ((isset($_POST['ppictype'])) ? (((int) $_POST['ppictype'] == 2) ? 'checked="checked"' : '') : (($user['ppic_type'] == 2) ? 'checked="checked"' : '')); ?> />
                            </div>
                            <div class="ucpflc" align="left">
                                <b><?php echo $l['acc_upl_img']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['acc_upl_img_exp']; ?></font>
                            </div>
                            <div class="ucpfrc" align="left">
                                <?php echo (($user['ppic_type'] == 2) ? '<img src="' . $curpp[0] . '" height="' . $curpp[4] . '" width="' . $curpp[3] . '" />' : ''); ?><br />
                                <input type="file" name="uploadppic" size="45" onfocus="$('ppicupload').checked = true;" />
                            </div>
                        </div>

                        <div>
                            <div class="ucpflc" colspan="3" align="center">
                                <input type="submit" name="editppic" value="<?php echo $l['acc_save_ch']; ?>" />&nbsp;<input type="submit" name="removeppic" value="<?php echo $l['acc_rem_perpic']; ?>" />
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <div>
                <div><img src="<?php echo $theme['images']; ?>cbotsmall.png" width="100%" height="10"></div>
            </div>
        </div>
    </form>


    <?php
    //The global User CP Footers
    usercpfoot();
}
?>