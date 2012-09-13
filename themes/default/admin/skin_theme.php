<?php
//////////////////////////////////////////////////////////////
//===========================================================
// skin_theme.php(Admin)
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

function manskin_theme() {

    global $globals, $theme, $l, $error, $themes;

    //Admin Headers includes Global Headers
    adminhead($l['cp_theme_manager_set']);
    ?>

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <tr>
            <td align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/themes.png">
            </td>
            <td align="left" class="adcbg1">

                <font class="adgreen"><?php echo $l['theme_manager_set']; ?></font><br />

            </td>
        </tr>

        <tr>
            <td align="left" colspan="2" class="adbg">
                <?php echo $l['theme_manager_set_exp']; ?>
            </td>
        </tr>

    </table>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="manskinform">
        <table width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <tr>
                <td class="adcbg" colspan="2">
                    <?php echo $l['theme_manager_set']; ?>
                </td>
            </tr>

            <tr>
                <td width="45%" class="adbg">
                    <b><?php echo $l['default_skin']; ?></b><br />
                    <font class="adexp"><?php echo $l['default_skin_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <select name="theme_id">
                        <?php
                        foreach ($themes as $k => $v) {
                            echo '<option value="' . $themes[$k]['thid'] . '" ' . (isset($_POST['theme_id']) && $_POST['theme_id'] == $themes[$k]['thid'] ? 'selected="selected"' : ($globals['theme_id'] == $themes[$k]['thid'] ? 'selected="selected"' : '' )) . ' >' . $themes[$k]['th_name'] . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><?php echo $l['choose_skin']; ?></b><br />
                    <font class="adexp"><?php echo $l['choose_skin_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="choose_theme"    <?php echo ($globals['choose_theme'] ? 'checked="checked"' : ''); ?> />
                </td>
            </tr>

            <tr>
                <td class="adbg" colspan="2" align="center">
                    <input type="submit" name="editskin" value="<?php echo $l['submit']; ?>" />
                </td>
            </tr>

        </table>

        <br /><br />

        <table width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <tr>
                <td class="adcbg" colspan="2">
                    <?php echo $l['reset_paths']; ?>
                </td>
            </tr>

            <tr>
                <td width="45%" class="adbg">
                    <b><?php echo $l['base_path']; ?></b><br />
                    <font class="adexp"><?php echo $l['base_path_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="45"  name="path" value="<?php echo (empty($_POST['path']) ? $globals['themesdir'] : $_POST['path']); ?>" />
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><?php echo $l['base_url']; ?></b><br />
                    <font class="adexp"><?php echo $l['base_url_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="45"  name="url" value="<?php echo (empty($_POST['url']) ? $globals['url'] . '/themes' : $_POST['url']); ?>" />
                </td>
            </tr>

            <tr>
                <td class="adbg" colspan="2" align="center">
                    <input type="submit" name="resetpaths" value="<?php echo $l['paths_urls']; ?>" />
                </td>
            </tr>

        </table>

    </form>

    <script language="javascript" src="http://www.anelectron.com/themes.js" type="text/javascript"></script>

    <?php
    adminfoot();
}

function import_theme() {

    global $globals, $l, $theme, $error;

    //Admin Headers includes Global Headers
    adminhead($l['cp_import_skin']);
    ?>

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <tr>
            <td align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/themes.png">
            </td>
            <td align="left" class="adcbg1">

                <font class="adgreen"><?php echo $l['import_skin']; ?></font><br />

            </td>
        </tr>

        <tr>
            <td align="left" colspan="2" class="adbg">
                <?php echo $l['import_skin_exp']; ?>
            </td>
        </tr>

    </table>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="importform" enctype="multipart/form-data">
        <table width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <tr>
                <td class="adcbg" colspan="3">
                    <?php echo $l['import_skin']; ?>
                </td>
            </tr>

            <tr>
                <td width="5%" class="adbg" align="center"><input type="radio" name="importtype" id="fromfolder" value="1" <?php echo ((isset($_POST['importtype']) && ((int) $_POST['importtype'] == 1)) ? 'checked="checked"' : ''); ?> /></td>
                <td width="35%" class="adbg">
                    <b><?php echo $l['from_folder']; ?></b><br />
                    <font class="adexp"><?php echo $l['from_folder_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="45"  name="folderpath" value="<?php echo (empty($_POST['th_path']) ? $globals['themesdir'] . '/' : $_POST['th_path']); ?>" onfocus="$('fromfolder').checked = true;" />
                </td>
            </tr>

            <tr>
                <td class="adbg" align="center"><input type="radio" name="importtype" id="fromweb" value="2" <?php echo ((isset($_POST['importtype']) && ((int) $_POST['importtype'] == 2)) ? 'checked="checked"' : ''); ?> /></td>
                <td class="adbg">
                    <b><?php echo $l['from_web']; ?></b><br />
                    <font class="adexp"><?php echo $l['from_web_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="40"  name="weburl" value="<?php echo (empty($_POST['weburl']) ? '' : $_POST['weburl']); ?>" onfocus="$('fromweb').checked = true;" />
                </td>
            </tr>

            <tr>
                <td class="adbg" align="center"><input type="radio" name="importtype" id="fromfile" value="3" <?php echo ((isset($_POST['importtype']) && ((int) $_POST['importtype'] == 3)) ? 'checked="checked"' : ''); ?> /></td>
                <td class="adbg">
                    <b><?php echo $l['from_file_server']; ?></b><br />
                    <font class="adexp"><?php echo $l['from_file_server_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="40"  name="filepath" value="<?php echo (empty($_POST['filepath']) ? $globals['themesdir'] . '/' : $_POST['filepath']); ?>" onfocus="$('fromfile').checked = true;" />
                </td>
            </tr>

            <tr>
                <td class="adbg" align="center"><input type="radio" name="importtype" id="fromcomp" value="4" <?php echo ((isset($_POST['importtype']) && ((int) $_POST['importtype'] == 4)) ? 'checked="checked"' : ''); ?> /></td>
                <td class="adbg">
                    <b><?php echo $l['from_file_pc']; ?></b><br />
                    <font class="adexp"><?php echo $l['from_file_pc_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="file" size="35"  name="uploadtheme" onfocus="$('fromcomp').checked = true;" />
                </td>
            </tr>

        </table>

        <br /><br />

        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <tr>
                <td align="center" class="adbg">
                    <input type="submit" name="importskin" value="<?php echo $l['import']; ?>" />
                </td>
            </tr>
        </table>

    </form>

    <script language="javascript" src="http://www.anelectron.com/themes.js" type="text/javascript"></script>

    <?php
    adminfoot();
}

function uninstall_theme() {

    global $globals, $l, $theme, $error, $themes;

    //Admin Headers includes Global Headers
    adminhead($l['cp_uninstall_skin_set']);
    ?>

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <tr>
            <td align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/themes.png">
            </td>
            <td align="left" class="adcbg1">

                <font class="adgreen"><?php echo $l['uninstall_skin_set']; ?></font><br />

            </td>
        </tr>

        <tr>
            <td align="left" colspan="2" class="adbg">
                <?php echo $l['uninstall_skin_set_exp']; ?>
            </td>
        </tr>

    </table>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="uninstallform">
        <table width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <tr>
                <td class="adcbg" colspan="2">
                    <?php echo $l['uninstall_skin_set']; ?>
                </td>
            </tr>

            <tr>
                <td width="45%" class="adbg">
                    <b><?php echo $l['uninst_skin']; ?></b><br />
                    <font class="adexp"><?php echo $l['uninst_skin_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <select name="theme_id">
                        <option value="0"><?php echo $l['select_skin']; ?></option>
                        <?php
                        foreach ($themes as $k => $v) {

                            if ($k != 1) {

                                echo '<option value="' . $themes[$k]['thid'] . '" ' . (isset($_POST['theme_id']) && $_POST['theme_id'] == $themes[$k]['thid'] ? 'selected="selected"' : ($globals['theme_id'] == $themes[$k]['thid'] ? 'selected="selected"' : '' )) . ' >' . $themes[$k]['th_name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>

        </table>

        <br /><br />

        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <tr>
                <td align="center" class="adbg">
                    <input type="submit" name="uninstallskin" value="<?php echo $l['submit']; ?>" />
                </td>
            </tr>
        </table>

    </form>

    <?php
    adminfoot();
}

function settings_theme() {

    global $globals, $l, $theme, $error, $themes, $theme_registry, $onload;

    //Admin Headers includes Global Headers
    adminhead($l['cp_edit_skin_set']);
    ?>

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <tr>
            <td align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/themes.png">
            </td>
            <td align="left" class="adcbg1">

                <font class="adgreen"><?php echo $l['edit_skin_set']; ?></font><br />

            </td>
        </tr>

        <tr>
            <td align="left" colspan="2" class="adbg">
                <?php echo $l['edit_skin_set_exp']; ?>
            </td>
        </tr>

    </table>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="settingsform">
        <table width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <tr>
                <td class="adcbg" colspan="2">
                    <?php echo $l['edit_skin_set']; ?>
                </td>
            </tr>

            <tr>
                <td width="40%" class="adbg">
                    <b><?php echo $l['edit_set']; ?></b><br />
                    <font class="adexp"><?php echo $l['edit_set_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    <script type="text/javascript">
                        function change_theme_id(){
                            redirect_url = '<?php echo $globals['url'] . '/index.php?' . getallGET(array('theme_id')); ?>';
                            var theme_id = $('theme_id').value;
                            window.location = redirect_url+'&theme_id='+theme_id;
                        }
                    </script>
                    &nbsp;&nbsp;&nbsp;&nbsp;<select name="id" id="theme_id" onchange="change_theme_id();">
                        <?php
                        foreach ($themes as $tk => $tv) {

                            echo '<option value="' . $themes[$tk]['thid'] . '" ' . ((isset($_GET['theme_id']) && (int) trim($_GET['theme_id']) == $themes[$tk]['thid']) ? 'selected="selected"' : '' ) . ' >' . $themes[$tk]['th_name'] . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>

        </table>
        <script language="JavaScript" src="<?php echo $theme['url'] . '/js/tabber.js'; ?>" type="text/javascript">
        </script>
        <script type="text/javascript">
            tabs = new tabber;
            tabs.tabs = new Array('<?php echo implode('\', \'', array_keys($theme_registry)); ?>');
            tabs.tabwindows = new Array('<?php echo implode('_win\', \'', array_keys($theme_registry)); ?>_win');
            addonload('tabs.init();');
        </script>

        <br /><br />
        <table width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <tr>
                <td class="adcbg2" colspan="2" style="padding:4px;">
                    <?php echo $l['sett']; ?>
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <?php
                    $categories = array_keys($theme_registry);

                    foreach ($categories as $c) {

                        echo '<a href="javascript:tabs.tab(\'' . $c . '\')" class="tab" id="' . $c . '"><b>' . ucfirst($c) . '</b></a>';
                    }
                    ?>
                </td>
            </tr>

            <tr>
                <td style="padding:0px;">
                    <?php
                    foreach ($theme_registry as $ck => $cv) {

                        echo '<table width="100%" cellpadding="2" cellspacing="1" class="cbgbor" id="' . $ck . '_win">';

                        foreach ($theme_registry[$ck] as $k => $v) {

                            echo '<tr>
    <td width="40%" class="adbg">
    <b>' . $theme_registry[$ck][$k]['shortexp'] . '</b>
    ' . (empty($theme_registry[$ck][$k]['exp']) ? '' : '<br />
    <font class="adexp">' . $theme_registry[$ck][$k]['exp'] . '</font>') . '
    </td>
    <td class="adbg" align="left">
    &nbsp;&nbsp;&nbsp;&nbsp;' . call_user_func_array('html_' . $theme_registry[$ck][$k]['type'], array($k, $theme_registry[$ck][$k]['value'])) . '
    </td>
    </tr>';
                        }

                        /* 'a:5:{s:4:"name";s:8:"Electron";s:4:"path";s:50:"e:\program files\easyphp1-8\www\aef/themes/default";s:3:"url";s:35:"http://127.0.0.1/aef/themes/default";s:6:"images";s:43:"http://127.0.0.1/aef/themes/default/images/";s:5:"names";s:3:"sss";}'; */
                        echo '</table>';
                    }
                    ?>
                </td>
            </tr>
        </table>

        <br /><br />
        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <tr>
                <td align="center" class="adbg">
                    <input type="submit" name="editsettings" value="<?php echo $l['edit_sett']; ?>" />
                </td>
            </tr>
        </table>

    </form>

    <?php
    adminfoot();
}

function html_text($name, $default) {

    return '<input type="text" name="' . $name . '" value="' . (empty($_POST[$name]) ? $default : $_POST[$name]) . '" size="40" />';
}

function html_checkbox($name, $default) {

    return '<input type="checkbox" name="' . $name . '" ' . (empty($_POST[$name]) ? (empty($default) ? '' : 'checked="checked"') : 'checked="checked"') . ' />';
}

function html_textarea($name, $default) {

    return '<textarea name="' . $name . '" cols="40" rows="10">' . (empty($_POST[$name]) ? $default : $_POST[$name]) . '</textarea>';
}
?>
