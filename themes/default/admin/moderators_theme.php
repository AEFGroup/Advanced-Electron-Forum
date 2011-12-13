<?php
//////////////////////////////////////////////////////////////
//===========================================================
// moderators_theme.php(admin)
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

function editmoderators_theme() {

    global $globals, $theme, $categories, $l, $forums, $error, $board;

    adminhead($l['cp_edit_forum_perm']);

    error_handle($error, '100%');

    //Are there any moderators for this forum
    if (!empty($board['moderators'])) {

        $mods = array();

        foreach ($board['moderators'] as $mo => $mov) {

            $mods[] = $mov['username'];
        }
    }
    ?>
    <div class="cbor" style="text-align: center;">
        <img src="<?php echo $theme['images']; ?>admin/users.png">
        <span class="adgreen"><?php echo $l['mods_options']; ?></span><br />

        <div class="expl">
            <?php echo $l['mods_options_exp']; ?>
        </div>

    </div>
    <br /><br />
    <script language="JavaScript" src="<?php echo $theme['url'] . '/js/suggest.js'; ?>" type="text/javascript"></script>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="editmoderators">
        <div class="division">
            <div class="topbar">
                <h3><?php echo '' . $l['edit_mods_of'] . '\'' . $board['fname'] . '\'.'; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['mods_usernames']; ?></b><br />
                    <span class="adexp"><?php echo $l['mods_usernames_exp']; ?></span>
                </div>
                <input type="text" name="modusernames" <?php echo (isset($_POST['modusernames']) ? 'value="' . $_POST['modusernames'] . '"' : ((!empty($mods)) ? 'value="' . (implode('; ', $mods)) . '"' : '' ) ); ?> size="40" onkeyup="handlesuggest(event, 'modusernames')" onkeydown="handlekeys(event)" autocomplete=off style="position:absolute" onblur="setTimeout(hidesuggest, 1000);" suggesturl="<?php echo $globals['index_url']; ?>act=suggest" id="modusernames" />
            </div>
            <div style="clear:both;"></div>
            <input type="submit" name="editmoderators" value="<?php echo $l['submit_changes']; ?>" />
            <input type="submit" name="deletemoderators" value="<?php echo $l['delete_mods']; ?>" />
            <div style="clear:both;"></div>
        </div>

        <?php
        adminfoot();
    }