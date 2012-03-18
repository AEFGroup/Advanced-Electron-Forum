<?php
//////////////////////////////////////////////////////////////
//===========================================================
// forumpermissions.php(Admin)
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

//This is the theme that is for the management of the forums
function fpermissionsmanage_theme() {

    global $globals, $theme, $categories, $l, $forums, $fpermissions, $user_group;

    adminhead($l['cp_forum_perm']);

    ?>
    <script type="text/javascript">
                var $j = jQuery.noConflict();
                $j(document).ready(function() {
                    $j("#tabs").tabs().addClass('ui-tabs-vertical ui-helper-clearfix');
                    $j("#tabs li").removeClass('ui-corner-top').addClass('ui-corner-left');
                });
                
            </script>

    <div class="cbor" style="text-align: center;">
        <img src="<?php echo $theme['images']; ?>admin/forums.png">
        <span class="adgreen"><?php echo $l['forum_perm']; ?></span><br />
        <div class="expl">
                <?php echo $l['forum_perm_exp']; ?>
        </div>

    </div>
    <br /><br />

    <?php

    $fpfid = (int) inputsec(htmlizer(trim($_GET['forum'])));

    $user = $user_group;
    echo '<div id="tabs">
            <ul>';
    foreach($user_group AS $user){
        ?>
        <li><a href="#tabs-<?php echo $user['member_group']; ?>"><?php echo $user['mem_gr_name']; ?></a></li>
        <?php
    }
        ?>
    </ul>
    
    <?php
    foreach($user_group AS $user){
        $fpugid = $user['member_group'];
        ?>
        <div id="tabs-<?php echo $user['member_group']; ?>">
        <form accept-charset="<?php echo $globals['charset']; ?>" action="?act=admin&adact=fpermissions&seadact=editfpermissions" method="post" name="editfpermissions">
        <input type="hidden" name="forum_id" value="<?php echo $_GET['forum'];  ?>" />
        <input type="hidden" name="group_id" value="<?php echo $user['member_group']; ?>" />
        <div class="division">
            <div class="topbar">
                <h3><?php echo $l['edit_forum']; ?> : "<?php echo $user['mem_gr_name']; ?>"</h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['start_topics']; ?></b><br />
                    <span class="adexp"><?php echo $l['start_topics_exp']; ?></span>
                </div>
                <input type="checkbox" name="can_post_topic" <?php echo (isset($_POST['can_post_topic']) ? 'checked="checked"' : (($fpermissions[$fpfid][$fpugid]['can_post_topic']) ? 'checked="checked"' : '') ); ?> />
            </div>
            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['reply_topics']; ?></b><br />
                    <span class="adexp"><?php echo $l['reply_topics_exp']; ?></span>
                </div>
                <input type="checkbox" name="can_reply" <?php echo (isset($_POST['can_reply']) ? 'checked="checked"' : (($fpermissions[$fpfid][$fpugid]['can_reply']) ? 'checked="checked"' : '') ); ?> />
            </div>
            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['vote_polls']; ?></b><br />
                    <span class="adexp"><?php echo $l['vote_polls_exp']; ?></span>
                </div>
                <input type="checkbox" name="can_vote_polls" <?php echo (isset($_POST['can_vote_polls']) ? 'checked="checked"' : (($fpermissions[$fpfid][$fpugid]['can_vote_polls']) ? 'checked="checked"' : '') ); ?> />
            </div>
            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['start_polls']; ?></b><br />
                    <span class="adexp"><?php echo $l['start_polls_exp']; ?></span>
                </div>
                <input type="checkbox" name="can_post_polls" <?php echo (isset($_POST['can_post_polls']) ? 'checked="checked"' : (($fpermissions[$fpfid][$fpugid]['can_post_polls']) ? 'checked="checked"' : '') ); ?> />
            </div>
            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>   
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['attach_files']; ?></b><br />
                    <span class="adexp"><?php echo $l['attach_files_exp']; ?></span>
                </div>
                <input type="checkbox" name="can_attach" <?php echo (isset($_POST['can_attach']) ? 'checked="checked"' : (($fpermissions[$fpfid][$fpugid]['can_attach']) ? 'checked="checked"' : '') ); ?> />
            </div>
            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['download_attach']; ?></b><br />
                    <span class="adexp"><?php echo $l['download_attach_exp']; ?></span>
                </div>
                <input type="checkbox" name="can_view_attach" <?php echo (isset($_POST['can_view_attach']) ? 'checked="checked"' : (($fpermissions[$fpfid][$fpugid]['can_view_attach']) ? 'checked="checked"' : '') ); ?> />
            </div>
            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div class="adbg" >
                    <input type="submit" name="editfpermissions" value="<?php echo $l['submit_changes']; ?>" />&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" name="deletefpermissions" value="<?php echo $l['delete_perm']; ?>" />
                </div>
            </div>
            <div style="clear:both;"></div>

        </div>
    </form>
    </div>
        <?php
    }
    echo '
</div>';
    adminfoot();
}

//End of function
