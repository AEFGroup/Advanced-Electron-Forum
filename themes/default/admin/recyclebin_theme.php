<?php
//////////////////////////////////////////////////////////////
//===========================================================
// recyclebin_theme.php(admin)
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
function recyclebin_theme() {

    global $globals, $theme, $categories, $l, $forums, $mother_options, $error;

    adminhead($l['cp_recyclebin']);

    error_handle($error, '100%');
    ?>
    <div class="cbor" style="text-align: center;">
        <img src="<?php echo $theme['images']; ?>admin/recyclebin.png">
        <span class="adgreen"><?php echo $l['recyclebin_set']; ?></span><br />

        <div class="expl">
            <?php echo $l['recyclebin_set_exp']; ?>
        </div>

    </div>
    </br></br>
    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="editfpermissions">
        <div class="division">

            <div class="topbar">
                <h3><?php echo $l['recyclebin_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['forum']; ?></b><br />
                    <span class="adexp"><?php echo $l['forum_exp']; ?></span>
                </div>
                <select name="rbfid" style="font-family:Verdana; font-size:11px">
                    <?php
                        echo '<option value="0" ' . ((isset($_POST['rbfid']) && trim($_POST['rbfid']) == $mother_options[$i][0] ) ? 'selected="selected"' : '') . '>' . $l['none'] . '</option>';
                        foreach ($mother_options as $i => $iv) {
                            echo '<option value="' . $mother_options[$i][0] . '" ' . ((isset($_POST['rbfid']) && trim($_POST['rbfid']) == $mother_options[$i][0] ) ? 'selected="selected"' : (($mother_options[$i][0] == (int) $globals['recyclebin']) ? 'selected="selected"' : '' ) ) . '>' . $mother_options[$i][1] . '</option>';
                        }//End of for loop
                        ?>
                </select>
            </div>
            <input type="submit" name="setrecyclebin" value="<?php echo $l['submit']; ?>" />
            <div style="clear:both;"></div>
        </div>

        <?php
        adminfoot();
    }

//End of function
    ?>