<?php
//////////////////////////////////////////////////////////////
//===========================================================
// forumpermissions.php(Admin)
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

//A global part to appear
function fpermissions_global() {

    global $globals, $theme, $l, $categories;
    ?>

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <tr>
            <td align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/forums.png">
            </td>
            <td align="left" class="adcbg1">

                <font class="adgreen"><?php echo $l['forum_perm']; ?></font><br />

            </td>
        </tr>

        <tr>
            <td align="left" colspan="2" class="adbg">
                <?php echo $l['forum_perm_exp']; ?>
            </td>
        </tr>

    </table>
    <br /><br />
    <?php
}

//This is the theme that is for the management of the forums
function fpermissionsmanage_theme() {

    global $globals, $theme, $categories, $l, $forums, $fpermissions;

    adminhead($l['cp_forum_perm']);

    fpermissions_global();

    echo '<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
        <tr><td class="adcbg">' . $l['edit_forum'] . '</td></tr>';

    //The for loop for the categories
    foreach ($categories as $c => $cv) {

        echo '<tr>
        <td class="adcbg2" height="18" colspan="3">
        <b>' . $categories[$c]['name'] . '</b>
        </td>
        </tr>';

        if (isset($forums[$c])) {

            //The for loop for the forums within the category
            foreach ($forums[$c] as $f => $v) {

                $dasher = "";

                for ($t = 0; $t < $forums[$c][$f]['board_level']; $t++) {

                    $dasher .= "&nbsp;&nbsp;&nbsp;&nbsp;";
                }

                echo '<tr>

                <td class="adbg" width="65%" height="' . (($forums[$c][$f]['in_board'] == 1) ? '18' : '25') . '" >' . $dasher . (($forums[$c][$f]['in_board'] == 1) ? '|--' : '') . $forums[$c][$f]['fname'];

                //Are there any forumpermission sets for this forum
                if (!empty($fpermissions[$forums[$c][$f]['fid']])) {

                    $fpug = array();

                    foreach ($fpermissions[$forums[$c][$f]['fid']] as $fp => $fv) {

                        $fpug[] = '<a href="' . $globals['index_url'] . 'act=admin&adact=fpermissions&seadact=editfpermissions&fpfid=' . $forums[$c][$f]['fid'] . '&fpug=' . $fv['fpugid'] . '">' . $fv['mem_gr_name'] . '</a>';
                    }

                    echo '&nbsp;-&nbsp;' . (implode(', ', $fpug));
                }

                echo '</td>

                </tr>';
            }//End of forums loop
        } else {
            echo '<tr>

                <td class="adbg" width="65%" height="18">
                ' . $l['short'] . '
                </td>

                </tr>';
        }
    }//End of Categories loop

    echo '</table>';

    adminfoot();
}

//End of function

function editfpermissions_theme() {

    global $globals, $theme, $categories, $forums, $l, $fpermissions, $fpfid, $fpugid;

    adminhead($l['cp_edit_forum']);

    fpermissions_global();
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="editfpermissions">
        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <tr>
                <td class="adcbg" colspan="2" style="height:25px">
                    <?php echo $l['edit_forum']; ?>
                </td>
            </tr>

            <tr>
                <td class="adbg" width="40%" height="30">
                    <b><?php echo $l['start_topics']; ?></b><br />
                    <?php echo $l['start_topics_exp']; ?>
                </td>
                <td class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="can_post_topic" <?php echo (isset($_POST['can_post_topic']) ? 'checked="checked"' : (($fpermissions[$fpfid][$fpugid]['can_post_topic']) ? 'checked="checked"' : '') ); ?> />
                </td>
            </tr>

            <tr>
                <td class="adbg" width="40%" height="30">
                    <b><?php echo $l['reply_topics']; ?></b><br />
                    <?php echo $l['reply_topics_exp']; ?>
                </td>
                <td class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="can_reply" <?php echo (isset($_POST['can_reply']) ? 'checked="checked"' : (($fpermissions[$fpfid][$fpugid]['can_reply']) ? 'checked="checked"' : '') ); ?> />
                </td>
            </tr>

            <tr>
                <td class="adbg" width="40%" height="30">
                    <b><?php echo $l['vote_polls']; ?></b><br />
                    <?php echo $l['vote_polls_exp']; ?>
                </td>
                <td class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="can_vote_polls" <?php echo (isset($_POST['can_vote_polls']) ? 'checked="checked"' : (($fpermissions[$fpfid][$fpugid]['can_vote_polls']) ? 'checked="checked"' : '') ); ?> />
                </td>
            </tr>

            <tr>
                <td class="adbg" width="40%" height="30">
                    <b><?php echo $l['start_polls']; ?></b><br />
                    <?php echo $l['start_polls_exp']; ?>
                </td>
                <td class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="can_post_polls" <?php echo (isset($_POST['can_post_polls']) ? 'checked="checked"' : (($fpermissions[$fpfid][$fpugid]['can_post_polls']) ? 'checked="checked"' : '') ); ?> />
                </td>
            </tr>

            <tr>
                <td class="adbg" width="40%" height="30">
                    <b><?php echo $l['attach_files']; ?></b><br />
                    <?php echo $l['attach_files_exp']; ?>
                </td>
                <td class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="can_attach" <?php echo (isset($_POST['can_attach']) ? 'checked="checked"' : (($fpermissions[$fpfid][$fpugid]['can_attach']) ? 'checked="checked"' : '') ); ?> />
                </td>
            </tr>

            <tr>
                <td class="adbg" width="40%" height="30">
                    <b><?php echo $l['download_attach']; ?></b><br />
                    <?php echo $l['download_attach_exp']; ?>
                </td>
                <td class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="can_view_attach" <?php echo (isset($_POST['can_view_attach']) ? 'checked="checked"' : (($fpermissions[$fpfid][$fpugid]['can_view_attach']) ? 'checked="checked"' : '') ); ?> />
                </td>
            </tr>

            <tr>
                <td class="adbg" height="30" colspan="2" align="center">
                    <input type="submit" name="editfpermissions" value="<?php echo $l['submit_changes']; ?>" />&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" name="deletefpermissions" value="<?php echo $l['delete_perm']; ?>" />
                </td>
            </tr>

        </table>

        <?php
        adminfoot();
    }

    function createfpermissions_theme() {

        global $globals, $theme, $categories, $forums, $fpermissions, $l, $fpfid, $fpugid, $error, $mother_options, $user_group;

        adminhead($l['cp_create_forum']);

        fpermissions_global();

        error_handle($error, '100%');
        ?>

        <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="editfpermissions">
            <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

                <tr>
                    <td class="adcbg" colspan="2" style="height:25px">
                        <?php echo $l['create_forum_perm']; ?>
                    </td>
                </tr>

                <tr>
                    <td class="adbg" width="40%" height="30">
                        <b><?php echo $l['forum']; ?></b><br />
                        <?php echo $l['forum_exp']; ?>
                    </td>
                    <td class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                        <select name="fpfid" style="font-family:Verdana; font-size:11px">

                            <?php
                            foreach ($mother_options as $i => $iv) {

                                echo '<option value="' . $mother_options[$i][0] . '" ' . ((isset($_POST['fpfid']) && trim($_POST['fpfid']) == $mother_options[$i][0] ) ? 'selected="selected"' : '') . '>
            ' . $mother_options[$i][1] . '
            </option>';
                            }//End of for loop
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="adbg" width="40%" height="30">
                        <b><?php echo $l['user_group']; ?></b><br />
                        <?php echo $l['user_group_exp']; ?>
                    </td>
                    <td class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;

                        <select name="fpugid" style="font-family:Verdana; font-size:11px">

                            <?php
                            foreach ($user_group as $ug => $uv) {

                                echo '<option value="' . $ug . '" ' . ((isset($_POST['fpugid']) && trim($_POST['fpugid']) == $ug ) ? 'selected="selected"' : '') . '>
            ' . $user_group[$ug]['mem_gr_name'] . '
            </option>';
                            }//End of for loop
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td class="adbg" width="40%" height="30">
                        <b><?php echo $l['start_topics']; ?></b><br />
                        <?php echo $l['start_topics_exp']; ?>
                    </td>
                    <td class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="can_post_topic" <?php echo (isset($_POST['can_post_topic']) ? 'checked="checked"' : '' ); ?> />
                    </td>
                </tr>

                <tr>
                    <td class="adbg" width="40%" height="30">
                        <b><?php echo $l['reply_topics']; ?></b><br />
                        <?php echo $l['reply_topics_exp']; ?>
                    </td>
                    <td class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="can_reply" <?php echo (isset($_POST['can_reply']) ? 'checked="checked"' : '' ); ?> />
                    </td>
                </tr>

                <tr>
                    <td class="adbg" width="40%" height="30">
                        <b><?php echo $l['vote_polls']; ?></b><br />
                        <?php echo $l['vote_polls_exp']; ?>
                    </td>
                    <td class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="can_vote_polls" <?php echo (isset($_POST['can_vote_polls']) ? 'checked="checked"' : '' ); ?> />
                    </td>
                </tr>

                <tr>
                    <td class="adbg" width="40%" height="30">
                        <b><?php echo $l['start_polls']; ?></b><br />
                        <?php echo $l['start_polls_exp']; ?>
                    </td>
                    <td class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="can_post_polls" <?php echo (isset($_POST['can_post_polls']) ? 'checked="checked"' : '' ); ?> />
                    </td>
                </tr>

                <tr>
                    <td class="adbg" width="40%" height="30">
                        <b><?php echo $l['attach_files']; ?></b><br />
                        <?php echo $l['attach_files_exp']; ?>
                    </td>
                    <td class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="can_attach" <?php echo (isset($_POST['can_attach']) ? 'checked="checked"' : '' ); ?> />
                    </td>
                </tr>

                <tr>
                    <td class="adbg" width="40%" height="30">
                        <b><?php echo $l['download_attach']; ?></b><br />
                        <?php echo $l['download_attach_exp']; ?>
                    </td>
                    <td class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="checkbox" name="can_view_attach" <?php echo (isset($_POST['can_view_attach']) ? 'checked="checked"' : '' ); ?> />
                    </td>
                </tr>

                <tr>
                    <td class="adbg" height="30" colspan="2" align="center">
                        <input type="submit" name="createfpermissions" value="<?php echo $l['create_forum_perm']; ?>" />
                    </td>
                </tr>

            </table>

            <?php
            adminfoot();
        }
        ?>