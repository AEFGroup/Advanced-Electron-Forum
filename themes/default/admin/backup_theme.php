<?php
//////////////////////////////////////////////////////////////
//===========================================================
// backup_theme.php(Admin)
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

function fileback_theme() {

    global $globals, $theme, $l, $error;

    //Admin Headers includes Global Headers
    adminhead($l['cp_ff_backup']);
    ?>

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <tr>
            <td align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/fileback.gif">
            </td>
            <td align="left" class="adcbg1">

                <span class="adgreen"><?php echo $l['ff_backup']; ?></span><br />

            </td>
        </tr>

        <tr>
            <td align="left" colspan="2" class="adbg">
                <?php echo $l['ff_backup_exp']; ?>
            </td>
        </tr>

    </table>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="filebackform">
        <table width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <tr>
                <td class="adcbg" colspan="2">
                    <?php echo $l['backup_options']; ?>
                </td>
            </tr>

            <tr>
                <td width="40%" class="adbg">
                    <b><?php echo $l['folder_']; ?></b><br />
                    <span class="adexp"><?php echo $l['folder_exp']; ?></span>
                </td>
                <td class="adbg" align="left">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" size="45"  name="folderpath" value="<?php echo (empty($_POST['folderpath']) ? $globals['server_url'] : $_POST['folderpath']); ?>" />
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><?php echo $l['compression']; ?></b>
                </td>
                <td class="adbg" align="left">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio"  name="compression" value="zip" <?php echo (empty($_POST['compression']) ? 'checked="checked"' : ($_POST['compression'] == 'zip' ? 'checked="checked"' : '')); ?> />&nbsp;<?php echo $l['zip']; ?>&nbsp;&nbsp;
                    <input type="radio"  name="compression" value="tar" <?php echo (isset($_POST['compression']) && $_POST['compression'] == 'tar' ? 'checked="checked"' : ''); ?> />&nbsp;<?php echo $l['tar']; ?>&nbsp;&nbsp;
                    <input type="radio"  name="compression" value="tgz" <?php echo (isset($_POST['compression']) && $_POST['compression'] == 'tgz' ? 'checked="checked"' : ''); ?> />&nbsp;<?php echo $l['gzip']; ?>&nbsp;&nbsp;
                    <input type="radio"  name="compression" value="tbz" <?php echo (isset($_POST['compression']) && $_POST['compression'] == 'tbz' ? 'checked="checked"' : ''); ?> />&nbsp;<?php echo $l['bzip']; ?>&nbsp;&nbsp;
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><?php echo $l['store_locally']; ?></b><br />
                    <span class="adexp"><?php echo $l['store_locally_exp']; ?></span>
                </td>
                <td class="adbg" align="left">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" size="45"  name="localpath" value="<?php echo (empty($_POST['localpath']) ? '' : $_POST['localpath']); ?>" />
                </td>
            </tr>

        </table>

        <br />

        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <tr>
                <td align="center" class="adbg">
                    <input type="submit" name="startfileback" value="<?php echo $l['submit']; ?>" />
                </td>
            </tr>
        </table>

    </form>

    <?php
    adminfoot();
}

function dbback_theme() {

    global $globals, $theme, $error, $l, $dbtables;

    //Admin Headers includes Global Headers
    adminhead($l['cp_database_backup']);
    ?>

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <tr>
            <td align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/db.gif">
            </td>
            <td align="left" class="adcbg1">

                <span class="adgreen"><?php echo $l['database_backup']; ?></span><br />

            </td>
        </tr>

        <tr>
            <td align="left" colspan="2" class="adbg">
                <?php echo $l['database_backup_exp']; ?>
            </td>
        </tr>

    </table>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="dbbackform">
        <table width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <tr>
                <td class="adcbg" colspan="2">
                    <?php echo $l['database_backup_options']; ?>
                </td>
            </tr>

            <tr>
                <td width="40%" class="adbg">
                    <b><?php echo $l['tables']; ?></b><br />
                    <span class="adexp"><?php echo $l['select_tables']; ?></span>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<select name="tables[]" multiple="multiple" size="8" id="tables">
                        <?php
                        $tables = $dbtables;
                        ksort($tables);

                        foreach ($tables as $k => $v) {
                            echo '<option value="' . $k . '" ' . (isset($_POST['tables']) && in_array($k, $_POST['tables']) ? 'selected="selected"' : (empty($_POST['tables']) ? 'selected="selected"' : '')) . '>' . $v . '</option>';
                        }
                        ?>
                    </select><br />
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" onclick="selectall('tables', true);" name="selall" /><?php echo $l['select_all']; ?>&nbsp;&nbsp;&nbsp;&nbsp;
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" onclick="selectall('tables', false);" name="selall" /><?php echo $l['unselect_all']; ?>
                    <script language="JavaScript" type="text/javascript">
                        function selectall(id, val){
                            for(var i = 0; i < $(id).options.length; i++){
                                $(id).options[i].selected = val;
                            }
                        };
                    </script>
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><input type="checkbox" name="structure" <?php echo (isset($_POST['dbback']) ? (isset($_POST['structure']) ? 'checked="checked"' : '' ) : 'checked="checked"'); ?> /><?php echo $l['structure']; ?></b>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="droptable" <?php echo (isset($_POST['dbback']) ? (isset($_POST['droptable']) ? 'checked="checked"' : '' ) : 'checked="checked"'); ?> /><?php echo $l['add_drop_table']; ?><br />
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="ifnotexists" <?php echo (isset($_POST['dbback']) ? (isset($_POST['ifnotexists']) ? 'checked="checked"' : '' ) : 'checked="checked"'); ?> /><?php echo $l['add_if_not_exist']; ?><br />
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="autoincrement" <?php echo (isset($_POST['dbback']) ? (isset($_POST['autoincrement']) ? 'checked="checked"' : '' ) : ''); ?> /><?php echo $l['add_autoincrement']; ?><br />
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="backquotes" <?php echo (isset($_POST['dbback']) ? (isset($_POST['backquotes']) ? 'checked="checked"' : '' ) : 'checked="checked"'); ?> /><?php echo $l['enclose_backquotes']; ?><br />
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><input type="checkbox" name="data" <?php echo (isset($_POST['dbback']) ? (isset($_POST['data']) ? 'checked="checked"' : '' ) : 'checked="checked"'); ?> /><?php echo $l['data']; ?></b>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="delayed" <?php echo (isset($_POST['dbback']) ? (isset($_POST['delayed']) ? 'checked="checked"' : '' ) : ''); ?> /><?php echo $l['use_delayed_inserts']; ?><br />
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="ignore" <?php echo (isset($_POST['dbback']) ? (isset($_POST['ignore']) ? 'checked="checked"' : '' ) : ''); ?> /><?php echo $l['use_ignore_inserts']; ?><br />
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><?php echo $l['compression']; ?></b>
                </td>
                <td class="adbg" align="left">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio"  name="compression" value="none" <?php echo (empty($_POST['compression']) ? 'checked="checked"' : (isset($_POST['compression']) && $_POST['compression'] == 'none' ? 'checked="checked"' : '')); ?> />&nbsp;<?php echo $l['none']; ?>&nbsp;&nbsp;
                    <input type="radio"  name="compression" value="zip" <?php echo (isset($_POST['compression']) && $_POST['compression'] == 'zip' ? 'checked="checked"' : ''); ?> />&nbsp;<?php echo $l['zip']; ?>&nbsp;&nbsp;
                    <input type="radio"  name="compression" value="gzip" <?php echo (isset($_POST['compression']) && $_POST['compression'] == 'gzip' ? 'checked="checked"' : ''); ?> />&nbsp;<?php echo $l['gzip']; ?>&nbsp;&nbsp;
                    <input type="radio"  name="compression" value="bzip" <?php echo (isset($_POST['compression']) && $_POST['compression'] == 'bzip' ? 'checked="checked"' : ''); ?> />&nbsp;<?php echo $l['bzip']; ?>&nbsp;&nbsp;

                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><?php echo $l['store_locally']; ?></b><br />
                    <span class="adexp"><?php echo $l['store_locally_exp']; ?></span>
                </td>
                <td class="adbg" align="left">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" size="45"  name="localpath" value="<?php echo (empty($_POST['localpath']) ? '' : $_POST['localpath']); ?>" />
                </td>
            </tr>

        </table>

        <br />

        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <tr>
                <td align="center" class="adbg">
                    <input type="submit" name="dbback" value="<?php echo $l['submit']; ?>" />
                </td>
            </tr>
        </table>

    </form>

    <?php
    adminfoot();
}
?>