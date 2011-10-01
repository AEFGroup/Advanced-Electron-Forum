<?php
//////////////////////////////////////////////////////////////
//===========================================================
// skin_theme.php(Admin)
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
function skin_headers(){
    global $globals, $l;
    ?>
    <div>
        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=skin&seadact=manskin" style="text-decoration:none; float:left;"><input type="submit" value="<?php echo $l['theme_manager']; ?>"></a>
        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=skin&seadact=import" style="text-decoration:none; float:left;"><input type="submit" value="<?php echo $l['import_themes']; ?>"></a>
        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=skin&seadact=uninstall" style="text-decoration:none; float:left;"><input type="submit" value="<?php echo $l['uninstall_themes']; ?>"></a>
        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=skin&seadact=settings&theme_id=<?php echo $globals['theme_id']; ?>" style="text-decoration:none; float:left;"><input type="submit" value="<?php echo $l['theme_settings']; ?>"></a>
    </div>
    <div style="clear: both;"></div>
    <?php

}
function manskin_theme() {

    global $globals, $theme, $l, $error, $themes;

    //Admin Headers includes Global Headers
    adminhead($l['cp_theme_manager_set']);
    skin_headers();
    ?>

    <div class="cbor" align="center">

        <div>
            <img src="<?php echo $theme['images']; ?>admin/themes.png">
            <font class="adgreen"><?php echo $l['theme_manager_set']; ?></font><br />
        </div>

        <div class="expl">
            <?php echo $l['theme_manager_set_exp']; ?>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');

    ?>
    
    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="manskinform">
        <div class="division">

            <div class="topbar">
                <h3><?php echo $l['theme_manager_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['default_skin']; ?></b><br />
                    <font class="adexp"><?php echo $l['default_skin_exp']; ?></font>
                </div>
                <select name="theme_id">
                    <?php
                    foreach ($themes as $k => $v) {
                        echo '<option value="' . $themes[$k]['thid'] . '" ' . (isset($_POST['theme_id']) && $_POST['theme_id'] == $themes[$k]['thid'] ? 'selected="selected"' : ($globals['theme_id'] == $themes[$k]['thid'] ? 'selected="selected"' : '' )) . ' >' . $themes[$k]['th_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['choose_skin']; ?></b><br />
                    <font class="adexp"><?php echo $l['choose_skin_exp']; ?></font>
                </div>
                <input type="checkbox" name="choose_theme"    <?php echo ($globals['choose_theme'] ? 'checked="checked"' : ''); ?> />
            </div>

            <input type="submit" name="editskin" value="<?php echo $l['submit']; ?>" />
            <div style="clear:both;"></div>
        </div>

        <br /><br />

        <div class="division">

            <div class="topbar">
                <h3><?php echo $l['reset_paths']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['base_path']; ?></b><br />
                    <font class="adexp"><?php echo $l['base_path_exp']; ?></font>
                </div>
                <input type="text" size="45"  name="path" value="<?php echo (empty($_POST['path']) ? $globals['themesdir'] : $_POST['path']); ?>" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['base_url']; ?></b><br />
                    <font class="adexp"><?php echo $l['base_url_exp']; ?></font>
                </div>
                <input type="text" size="45"  name="url" value="<?php echo (empty($_POST['url']) ? $globals['url'] . '/themes' : $_POST['url']); ?>" />
            </div>
            <input type="submit" name="resetpaths" value="<?php echo $l['paths_urls']; ?>" />
            <div style="clear:both;"></div>
        </div>

    </form>

    <script language="javascript" src="http://www.anelectron.com/themes.php" type="text/javascript"></script>

    <?php
    adminfoot();
}

function import_theme() {

    global $globals, $l, $theme, $error;

    //Admin Headers includes Global Headers
    adminhead($l['cp_import_skin']);
    skin_headers();
    ?>

    <div class="cbor" align="center">
        <div>
            <img src="<?php echo $theme['images']; ?>admin/themes.png">
            <font class="adgreen"><?php echo $l['import_skin']; ?></font><br />
        </div>

        <div class="expl">
            <?php echo $l['import_skin_exp']; ?>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');

    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="importform" enctype="multipart/form-data">
        <div class="division">

            <div class="topbar">
                <h3><?php echo $l['import_skin']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['from_folder']; ?></b><br />
                    <font class="adexp"><?php echo $l['from_folder_exp']; ?></font>
                </div>
                
                    <input type="radio" name="importtype" id="fromfolder" value="1" <?php echo ((isset($_POST['importtype']) && ((int) $_POST['importtype'] == 1)) ? 'checked="checked"' : ''); ?> />
                <br>
                    <input type="text" size="45"  name="folderpath" value="<?php echo (empty($_POST['th_path']) ? $globals['themesdir'] . '/' : $_POST['th_path']); ?>" onfocus="$('fromfolder').checked = true;" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['from_web']; ?></b><br />
                    <font class="adexp"><?php echo $l['from_web_exp']; ?></font>
                </div>
                <input type="radio" name="importtype" id="fromweb" value="2" <?php echo ((isset($_POST['importtype']) && ((int) $_POST['importtype'] == 2)) ? 'checked="checked"' : ''); ?> />
                <br>
                <input type="text" size="40"  name="weburl" value="<?php echo (empty($_POST['weburl']) ? '' : $_POST['weburl']); ?>" onfocus="$('fromweb').checked = true;" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['from_file_server']; ?></b><br />
                    <font class="adexp"><?php echo $l['from_file_server_exp']; ?></font>
                </div>
                <input type="radio" name="importtype" id="fromfile" value="3" <?php echo ((isset($_POST['importtype']) && ((int) $_POST['importtype'] == 3)) ? 'checked="checked"' : ''); ?> />
                <br>
                <input type="text" size="40"  name="filepath" value="<?php echo (empty($_POST['filepath']) ? $globals['themesdir'] . '/' : $_POST['filepath']); ?>" onfocus="$('fromfile').checked = true;" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                <b><?php echo $l['from_file_pc']; ?></b><br />
                    <font class="adexp"><?php echo $l['from_file_pc_exp']; ?></font>
                </div>
                <input type="radio" name="importtype" id="fromcomp" value="4" <?php echo ((isset($_POST['importtype']) && ((int) $_POST['importtype'] == 4)) ? 'checked="checked"' : ''); ?> />
                <br>
                <input type="file" size="35"  name="uploadtheme" onfocus="$('fromcomp').checked = true;" />
            </div>
            <input type="submit" name="importskin" value="<?php echo $l['import']; ?>" />
            <div style="clear:both;"></div>
        </div>

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

    <div class="cbor" align="center">

        <div>
            <img src="<?php echo $theme['images']; ?>admin/themes.png">
            <font class="adgreen"><?php echo $l['uninstall_skin_set']; ?></font><br />
        </div>

        <div class="expl">
            <?php echo $l['uninstall_skin_set_exp']; ?>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="uninstallform">
        <div class="division">

            <div class="topbar">
                <h3><?php echo $l['uninstall_skin_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>    
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['uninst_skin']; ?></b><br />
                    <font class="adexp"><?php echo $l['uninst_skin_exp']; ?></font>
                </div>
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
            </div>
            <input type="submit" name="uninstallskin" value="<?php echo $l['submit']; ?>" />
            <div style="clear:both;"></div>
        </div>
    </form>

    <?php
    adminfoot();
}

function settings_theme() {

    global $globals, $l, $theme, $error, $themes, $theme_registry, $onload;

    //Admin Headers includes Global Headers
    adminhead($l['cp_edit_skin_set']);
    ?>

    <div class="cbor" align="center">

        <div>
            <img src="<?php echo $theme['images']; ?>admin/themes.png">
            <font class="adgreen"><?php echo $l['edit_skin_set']; ?></font><br />
        </div>

        <div class="expl">
            <?php echo $l['edit_skin_set_exp']; ?>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="settingsform">
        <div class="division">
            <div class="topbar">
                <h3><?php echo $l['edit_skin_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['edit_set']; ?></b><br />
                    <font class="adexp"><?php echo $l['edit_set_exp']; ?></font>
                </div>
                <div align="left">
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
                </div>
                <div style="clear:both;"></div>
            </div>

        </div>
        <script language="JavaScript" src="<?php echo $theme['url'] . '/js/tabber.js'; ?>" type="text/javascript">
        </script>
        <script type="text/javascript">
            tabs = new tabber;
            tabs.tabs = new Array('<?php echo implode('\', \'', array_keys($theme_registry)); ?>');
            tabs.tabwindows = new Array('<?php echo implode('_win\', \'', array_keys($theme_registry)); ?>_win');
            addonload('tabs.init();');
        </script>

        <br /><br />
        <div class="division">

            <div class="topbar">
                    <h3><?php echo $l['sett']; ?></h3>
            </div>

            <div align="center">
                <div class="adbg">
                    <?php
                    $categories = array_keys($theme_registry);

                    foreach ($categories as $c) {

                        echo '<a href="javascript:tabs.tab(\'' . $c . '\')" class="tab" id="' . $c . '"><b>' . ucfirst($c) . '</b></a>';
                    }
                    ?>
                </div>
            </div>

            <div>
                <div style="padding:0px;">
                    <?php
                    foreach ($theme_registry as $ck => $cv) {

                        echo '<div width="100%" cellpadding="2" cellspacing="1" class="cbgbor" id="' . $ck . '_win">';

                        foreach ($theme_registry[$ck] as $k => $v) {

                            echo '
                                <div style="clear:both; padding-bottom: 10px;"></div>
                                <div >
                                    <div style="width:400px; float:left; padding:5px;">
                                    <b>' . $theme_registry[$ck][$k]['shortexp'] . '</b>
                                    ' . (empty($theme_registry[$ck][$k]['exp']) ? '' : '<br />
                                    <font class="adexp">' . $theme_registry[$ck][$k]['exp'] . '</font>') . '
                                    </div>
                                    <div>
                                        ' . call_user_func_array('html_' . $theme_registry[$ck][$k]['type'], array($k, $theme_registry[$ck][$k]['value'])) . '
                                    </div>
                                </div>';
                        }
                        echo '<div style="clear:both;"></div></div>';
                    }
                    ?>
                </div>
            </div>
            <input type="submit" name="editsettings" value="<?php echo $l['edit_sett']; ?>" />
            <div style="clear:both;"></div>
        </div>
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
