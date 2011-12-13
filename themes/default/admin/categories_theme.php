<?php
//////////////////////////////////////////////////////////////
//===========================================================
// categories_theme.php(Admin)
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

function cat_global() {

    global $globals, $theme, $l, $categories;
    ?>

    <div class="cbor" align="center">
        <img src="<?php echo $theme['images']; ?>admin/categories.png">
        <span class="adgreen"><?php echo $l['cat_options']; ?></span><br />

        <div class="expl">
            <?php echo $l['cat_options_exp']; ?>
        </div>

    </div>
    <br /><br />
    <?php
}

function editcat_theme() {

    global $globals, $theme, $categories, $editcat, $l, $orderoptions, $error, $editcategory;

    //Admin Headers includes Global Headers
    adminhead($l['cp_edit_cat']);

    cat_global();

    error_handle($error, '100%');
    ?>
    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="editcat">

        <div class="division">

            <div class="topbar">
                <h3><?php echo $l['edit_cat']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['order']; ?></b><br />
                    <span class="adexp"><?php echo $l['order_exp']; ?></span>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<select name="catorder">
                        <?php echo implode('', $orderoptions); ?>
                    </select>
                </div>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['category_name']; ?></b><br />
                    <span class="adexp"><?php echo $l['category_name_exp']; ?></span>
                </div>
                <input type="text" size="50" maxlength="" name="catname"
                                                   <?php echo ( (isset($_POST['catname'])) ? 'value="' . $_POST['catname'] . '"' : 'value="' . $editcategory['name'] . '"' ); ?>/>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['collapsable']; ?></b><br />
                    <span class="adexp"><?php echo $l['collapsable_exp']; ?></span>
                </div>
                <input type="checkbox" name="catcollapse" <?php
                    if ($editcategory['collapsable']) {
                        echo 'checked';
                    }
                    ?>/>
            </div>
            <input type="submit" name="edit_cat" value="<?php echo $l['edit_cat']; ?>"/>
            <div style="clear: both;"></div>
        </div>
    </form>
    <?php
    //Admin footers includes Global footers
    adminfoot();
}

function createcat_theme() {

    global $globals, $theme, $categories, $l, $orderoptions, $error;

    //Admin Headers includes Global Headers
    adminhead($l['cp_create_cat']);

    cat_global();

    error_handle($error, '100%');
    ?>
    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="editcat">
        <div class="division">

            <div class="topbar">
                <h3><?php echo $l['create_a_cat']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['order']; ?></b><br />
                    <span class="adexp"><?php echo $l['order_exp']; ?></span>
                </div>
                <select name="catorder">
                        <?php echo implode('', $orderoptions); ?>
                    </select>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['category_name']; ?></b><br />
                    <span class="adexp"><?php echo $l['category_name_exp']; ?></span>
                </div>
                <input type="text" size="50" maxlength="" name="catname" <?php echo ( (isset($_POST['catname'])) ? 'value="' . $_POST['catname'] . '"' : '' ); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['collapsable']; ?></b><br />
                    <span class="adexp"><?php echo $l['collapsable_exp']; ?></span>
                </div>
                <input type="checkbox" name="catcollapse" checked />
            </div>
            <input type="submit" name="createcat" value="<?php echo $l['create_cat']; ?>"/>
            <div style="clear:both;"></div>
        </div>
    </form>
    <?php
    //Admin footers includes Global footers
    adminfoot();
}
