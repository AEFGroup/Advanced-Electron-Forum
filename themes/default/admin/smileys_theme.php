<?php
//////////////////////////////////////////////////////////////
//===========================================================
// smilies_theme.php(Admin)
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

function smset_theme() {

    global $globals, $l, $theme, $error;

    //Admin Headers includes Global Headers
    adminhead($l['cp_sm_smiley_set']);
    ?>

    <div class="cbor" align="center">

        <div>
            <img src="<?php echo $theme['images']; ?>admin/smileys.png">
            <font class="adgreen"><?php echo $l['smiley_set']; ?></font><br />
        </div>

        <div class="expl">
                <?php echo $l['smiley_set_exp']; ?>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="smsetform">
        <div class="division">

            <div class="topbar">
                <h3><?php echo $l['smiley_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['use_smileys']; ?></b><br />
                    <font class="adexp"><?php echo $l['use_smileys_exp']; ?></font>
                </div>
                <input type="checkbox" name="usesmileys" <?php echo ($globals['usesmileys'] ? 'checked="checked"' : ''); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['space_boundary']; ?></b><br />
                    <font class="adexp"><?php echo $l['space_boundary_exp']; ?></font>
                </div>
                <input type="checkbox" name="smiley_space_boundary" <?php echo ($globals['smiley_space_boundary'] ? 'checked="checked"' : ''); ?> />
            </div>
            <input type="submit" name="editsmset" value="<?php echo $l['submit']; ?>" />
            <div style="clear:both;"></div>
        </div>
    </form>

    <?php
    adminfoot();
}

function smman_theme() {

    global $globals, $l, $theme, $smileys, $smileyimages;

    //Admin Headers includes Global Headers
    adminhead($l['cp_sm_manage_smileys']);
    ?>

    <div width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <div>
            <div align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/smileys.png">
            </div>
            <div align="left" class="adcbg1">

                <font class="adgreen"><?php echo $l['manage_smileys']; ?></font><br />

            </div>
        </div>

        <div>
            <div align="left" colspan="2" class="adbg">
                <?php echo $l['manage_smileys_exp']; ?>
            </div>
        </div>

    </div>
    <br /><br />

    <div width="100%" cellpadding="5" cellspacing="1" class="cbor">
        <div>
            <div class="adcbg" colspan="7">
                <?php echo $l['current_smileys']; ?>
            </div>
        </div>

        <div align="center">
            <div class="adcbg2" width="10%">
                <b><?php echo $l['smiley']; ?></b>
            </div>
            <div class="adcbg2" width="15%">
                <b><?php echo $l['code']; ?></b>
            </div>
            <div class="adcbg2" width="20%">
                <b><?php echo $l['file_name']; ?></b>
            </div>
            <div class="adcbg2" width="20%">
                <b><?php echo $l['emotion']; ?></b>
            </div>
            <div class="adcbg2" width="10%">
                <b><?php echo $l['status']; ?></b>
            </div>
            <div class="adcbg2" width="10%">
                <b><?php echo $l['edit']; ?></b>
            </div>
            <div class="adcbg2" width="15%">
                <b><?php echo $l['delete']; ?></b>
            </div>
        </div>

        <?php
        if (empty($smileys)) {

            echo '<div>
    <div class="adbg" colspan="5">
    ' . $l['no_smileys_found'] . '
    </div>
    </div>';
        } else {

            foreach ($smileys as $sk => $sv) {

                echo '<div>
    <div class="adbg" align="center">
    ' . $smileyimages[$sk] . '
    </div>
    <div class="adbg">
    ' . $smileys[$sk]['smcode'] . '
    </div>
    <div class="adbg">
    ' . $smileys[$sk]['smfile'] . '
    </div>
    <div class="adbg">
    ' . $smileys[$sk]['smtitle'] . '
    </div>
    <div class="adbg">
    ' . ($smileys[$sk]['smstatus'] ? $l['popup'] : $l['form']) . '
    </div>
    <div class="adbg" align="center">
    <a href="' . $globals['index_url'] . 'act=admin&adact=smileys&seadact=editsm&smid=' . $smileys[$sk]['smid'] . '">' . $l['edit'] . '</a>
    </div>
    <div class="adbg" align="center">
    <a href="' . $globals['index_url'] . 'act=admin&adact=smileys&seadact=delsm&smid=' . $smileys[$sk]['smid'] . '">' . $l['delete'] . '</a>
    </div>
    </div>';
            }
        }
        ?>

    </div>
    <br />
    <div width="100%" cellpadding="1" cellspacing="1" class="cbor">
        <div>
            <div align="center" class="adbg">
                <input type="button" value="<?php echo $l['add_new_smiley']; ?>"  onclick="javascript:window.location='<?php echo $globals['index_url'] . 'act=admin&adact=smileys&seadact=addsm'; ?>'" />
            </div>
        </div>
    </div>

    <?php
    adminfoot();
}

function smreorder_theme() {

    global $globals, $l, $theme, $smileys, $smileyimages, $error, $onload, $dmenus;

    //Pass to onload to initialize a JS
    $onload['smreoder'] = 'init_reoder()';

    //Admin Headers includes Global Headers
    adminhead($l['cp_sm_reorder_smileys']);
    ?>

    <div width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <div>
            <div align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/smileys.png">
            </div>
            <div align="left" class="adcbg1">

                <font class="adgreen"><?php echo $l['reorder_smileys']; ?></font><br />

            </div>
        </div>

        <div>
            <div align="left" colspan="2" class="adbg">
                <?php echo $l['reorder_smileys_exp']; ?>
            </div>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="smreorderform">
        <div width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <div>
                <div class="adcbg" colspan="2">
                    <?php echo $l['reorder_smileys']; ?>
                </div>
            </div>

        </div>
        <br /><br />

        <div width="60%" cellpadding="0" cellspacing="0" align="center" border="0">
            <div><div id="sm_reorder_pos" width="100%"></div></div>
        </div>
        <br /><br />
        <script type="text/javascript">

            //The array id of all the elements to be reordered
            reo_r = new Array(<?php echo implode(', ', array_keys($smileys)); ?>);

            //The id of the table that will hold the elements
            reorder_holder = 'sm_reorder_pos';

            //The prefix of the Dom Drag handle for every element
            reo_ha = 'smha';

            //The prefix of the Dom Drag holder for every element(the parent of every element)
            reo_ho = 'sm';

            //The prefix of the Hidden Input field for the reoder value for every element
            reo_hid = 'smhid';

        </script>
        <?php js_reorder(); ?>
        <div width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <div>
                <div align="center" class="adbg">
                    <?php
                    $temp = 1;
                    foreach ($smileys as $sk => $sv) {

                        //echo '<div class="smreo" id="sm'.$sk.'">&nbsp;'.$smileyimages[$sk].'&nbsp;&nbsp;'.$smileys[$sk]['smtitle'].'</div>';

                        $dmenus[] = '<div id="sm' . $sk . '">
<div cellpadding="0" cellspacing="0" class="smreo" id="smha' . $sk . '" onmousedown="this.style.zIndex=\'1\'" onmouseup="this.style.zIndex=\'0\'">
<div><div>
&nbsp;' . $smileyimages[$sk] . '&nbsp;&nbsp;' . $smileys[$sk]['smtitle'] . '
</div></div>
</div>
</div>';

                        echo '<input type="hidden" name="sm[' . $sk . ']" value="' . $temp . '" id="smhid' . $sk . '" />';

                        $temp = $temp + 1;
                    }
                    ?>
                    <input type="submit" name="smreorder" value="<?php echo $l['re_order']; ?>" />
                </div>
            </div>
        </div>

    </form>

    <?php
    adminfoot();
}

//Edit smiley
function editsm_theme() {

    global $globals, $l, $theme, $error, $smiley, $folders;

    //Admin Headers includes Global Headers
    adminhead($l['cp_sm_edit_smileys']);
    ?>

    <div width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <div>
            <div align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/smileys.png">
            </div>
            <div align="left" class="adcbg1">

                <font class="adgreen"><?php echo $l['edit_smileys']; ?></font><br />

            </div>
        </div>

        <div>
            <div align="left" colspan="2" class="adbg">
                <?php echo $l['edit_smileys_exp']; ?>
            </div>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="editsmform">
        <div width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <div>
                <div class="adcbg" colspan="2">
                    <?php echo $l['edit_smileys']; ?>
                </div>
            </div>

            <div>
                <div width="45%" class="adbg">
                    <b><?php echo $l['code_']; ?></b><br />
                    <font class="adexp"><?php echo $l['code_exp']; ?></font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="smcode" value="<?php echo (empty($_POST['smcode']) ? $smiley['smcode'] : $_POST['smcode']); ?>" />
                </div>
            </div>

            <div>
                <div class="adbg">
                    <b><?php echo $l['emotion_']; ?></b><br />
                    <font class="adexp"><?php echo $l['emotion_exp']; ?></font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="smtitle" value="<?php echo (empty($_POST['smtitle']) ? $smiley['smtitle'] : $_POST['smtitle']); ?>" />
                </div>
            </div>


            <div>
                <div class="adbg">
                    <b><?php echo $l['display_in']; ?></b><br />
                    <font class="adexp"><?php echo $l['display_in_exp']; ?></font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="smstatus" <?php echo (!$smiley['smstatus'] ? 'checked="checked"' : ''); ?> />
                </div>
            </div>

            <div>
                <div class="adbg">
                    <b><?php echo $l['folder']; ?></b><br />
                    <font class="adexp"><?php echo $l['folder_exp']; ?></font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<select name="smfolder" disabled="disabled">
                        <?php
                        foreach ($folders as $f) {
                            echo '<option value="' . $f['name'] . '" ' . ($f['name'] == $smiley['smfolder'] ? 'selected="selected"' : '' ) . ' >' . $f['name'] . '</option>';
                        }
                        ?></select>
                </div>
            </div>

            <div>
                <div class="adbg">
                    <b><?php echo $l['smiley_file']; ?></b><br />
                    <font class="adexp"><?php echo $l['smiley_file_exp']; ?></font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="smfile" value="<?php echo $smiley['smfile']; ?>"  disabled="disabled" />
                </div>
            </div>


        </div>

        <br /><br />

        <div width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <div>
                <div align="center" class="adbg">
                    <input type="submit" name="editsm" value="<?php echo $l['submit']; ?>" />
                </div>
            </div>
        </div>

    </form>

    <?php
    adminfoot();
}

//Add smiley
function addsm_theme() {

    global $globals, $l, $theme, $error, $smiley, $folders;

    //Admin Headers includes Global Headers
    adminhead($l['cp_sm_add_smileys']);
    ?>

    <div width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <div>
            <div align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/smileys.png">
            </div>
            <div align="left" class="adcbg1">

                <font class="adgreen"><?php echo $l['add_smileys']; ?></font><br />

            </div>
        </div>

        <div>
            <div align="left" colspan="2" class="adbg">
                <?php echo $l['add_smileys_exp']; ?>
            </div>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="addsmform" enctype="multipart/form-data">
        <div width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <div>
                <div class="adcbg" colspan="2">
                    <?php echo $l['add_smileys']; ?>
                </div>
            </div>

            <div>
                <div width="45%" class="adbg">
                    <b><?php echo $l['code_']; ?></b><br />
                    <font class="adexp"><?php echo $l['code_exp']; ?></font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="smcode" value="<?php echo (empty($_POST['smcode']) ? '' : $_POST['smcode']); ?>" />
                </div>
            </div>

            <div>
                <div class="adbg">
                    <b><?php echo $l['emotion_']; ?></b><br />
                    <font class="adexp"><?php echo $l['emotion_exp']; ?></font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="smtitle" value="<?php echo (empty($_POST['smtitle']) ? '' : $_POST['smtitle']); ?>" />
                </div>
            </div>


            <div>
                <div class="adbg">
                    <b><?php echo $l['display_in']; ?></b><br />
                    <font class="adexp"><?php echo $l['display_in_exp']; ?></font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="smstatus" checked="checked" />
                </div>
            </div>

            <div>
                <div class="adbg">
                    <b><?php echo $l['folder']; ?></b><br />
                    <font class="adexp"><?php echo $l['folder_exp']; ?></font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<select name="smfolder">
                        <?php
                        foreach ($folders as $f) {
                            echo '<option value="' . $f['name'] . '" ' . (isset($_POST['smfolder']) && $_POST['smfolder'] == $f['name'] ? 'selected="selected"' : '' ) . ' >' . $f['name'] . '</option>';
                        }
                        ?></select>
                </div>
            </div>

            <div>
                <div class="adbg">
                    <input type="radio" name="filemethod" value="1" <?php echo (isset($_POST['filemethod']) && trim($_POST['filemethod']) == 1 ? 'checked="checked"' : '' ); ?> />&nbsp;<b><?php echo $l['smiley_file']; ?></b><br />
                    <font class="adexp"><?php echo $l['smiley_file_exp']; ?></font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="smfile" value="<?php echo (empty($_POST['smfile']) ? '' : $_POST['smfile']); ?>" />
                </div>
            </div>

            <div>
                <div class="adbg">
                    <input type="radio" name="filemethod" value="2" <?php echo (isset($_POST['filemethod']) && trim($_POST['filemethod']) == 2 ? 'checked="checked"' : '' ); ?>  />&nbsp;<b><?php echo $l['upload_smiley']; ?></b><br />
                    <font class="adexp"><?php echo $l['upload_smiley_exp']; ?></font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="file" size="30"  name="smfile_u" value="<?php echo (empty($_POST['smfile']) ? '' : $_POST['smfile']); ?>" />
                </div>
            </div>


        </div>

        <br /><br />

        <div width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <div>
                <div align="center" class="adbg">
                    <input type="submit" name="addsm" value="<?php echo $l['submit']; ?>" />
                </div>
            </div>
        </div>

    </form>

    <?php
    adminfoot();
}
?>