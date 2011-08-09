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

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <tr>
            <td align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/categories.png">
            </td>
            <td align="left" class="adcbg1">

                <font class="adgreen"><?php echo $l['cat_options']; ?></font><br />

            </td>
        </tr>

        <tr>
            <td align="left" colspan="2" class="adbg">
                <?php echo $l['cat_options_exp']; ?>
            </td>
        </tr>

    </table>
    <br /><br />
    <?php
}

//This is the theme that is for the management of the Categories
function catmanage_theme() {

    global $globals, $theme, $l, $categories, $dmenus;

    //Admin Headers includes Global Headers
    adminhead($l['cp_manage_board_cat']);

    cat_global();

    $dmenus[] = '<div id="delcatprompt" class="pqr">
<table width="100%" cellspacing="0" cellpadding="0" id="delcatpromptha">
<tr>
<td class="dwhl"></td>
<td align="left" class="dwhc"><b>' . $l['shout_box'] . '</b></td>
<td align="right" class="dwhc"><a href="javascript:hideel(\'delcatprompt\')"><img src="' . $theme['images'] . 'close.gif"></a></td>
<td class="dwhr"></td>
</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="4" class="dwbody">
<tr>
<td width="100%" valign="top">
' . $l['delete_cat'] . '
</td>
</tr>
<tr>
<td style="padding:4px;" align="center">
<input type="button" onclick="redirectdeletecat();" value="' . $l['yes'] . '">&nbsp;&nbsp;<input type="button" onclick="hideel(\'delcatprompt\');" value="' . $l['no'] . '">
</td>
</tr>
</table>
</div>

<script type="text/javascript">
Drag.init($("delcatpromptha"), $("delcatprompt"));
</script>';
    ?>
    <script type="text/javascript">

        delcatpromptid = 'delcatprompt';
        cat_id = 0;

        function confirmdelete(cid){
            cat_id = cid;
            if(!isvisible(delcatpromptid)){
                $(delcatpromptid).style.left=((getwidth()/2)-($(delcatpromptid).offsetWidth/2))+"px";
                $(delcatpromptid).style.top=(scrolledy()+110)+"px";
                showel(delcatpromptid);
                smoothopaque(delcatpromptid, 0, 100, 10);
            }
        };

        function redirectdeletecat(){
            //alert(cat_id);
            window.location = '<?php echo $globals['index_url'] . 'act=admin&adact=categories&seadact=delcat&cid='; ?>'+cat_id;
        }

    </script>

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <tr>
            <td class="cbg" colspan="3"><?php echo $l['modify_cat']; ?></td>
        </tr>
        <?php
        foreach ($categories as $c => $cv) {

            echo '
		<tr>
		<td class="adbg" width="55%" height="30">
		<b>
		<a href="' . $globals['index_url'] . 'act=admin&adact=categories&seadact=editcat&editcat=' . $categories[$c]['cid'] . '">
		' . $categories[$c]['name'] . '<br />		
		</a>
		</b>
		</td>
		
		<td class="adbg" align="center">
		<a href="' . $globals['index_url'] . 'act=admin&adact=categories&seadact=editcat&editcat=' . $categories[$c]['cid'] . '">
		' . $l['edit'] . '
		</a>
		</td>
		
		<td class="adbg" align="center">
		<a href="javascript:confirmdelete(' . $categories[$c]['cid'] . ');">
		' . $l['delete'] . '
		</a>
		</td>
		
		</tr>';
        }
        ?>
    </table>
    <?php
    //Admin footers includes Global footers
    adminfoot();
}

function editcat_theme() {

    global $globals, $theme, $categories, $editcat, $l, $orderoptions, $error, $editcategory;

    //Admin Headers includes Global Headers
    adminhead($l['cp_edit_cat']);

    cat_global();

    error_handle($error, '100%');
    ?>
    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="editcat">

        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

            <tr>
                <td colspan="2" class="adcbg" align="center"><b><?php echo $l['edit_cat']; ?></b></td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['order']; ?></b><br />
                    <?php echo $l['order_exp']; ?>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<select name="catorder">
                        <?php echo implode('', $orderoptions); ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['category_name']; ?></b><br />
                    <?php echo $l['category_name_exp']; ?>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="50" maxlength="" name="catname" 
                                                   <?php echo ( (isset($_POST['catname'])) ? 'value="' . $_POST['catname'] . '"' : 'value="' . $editcategory['name'] . '"' ); ?>/>
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['collapsable']; ?></b><br />
                    <?php echo $l['collapsable_exp']; ?>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="catcollapse" 
                    <?php
                    if ($editcategory['collapsable']) {
                        echo 'checked';
                    }
                    ?>/>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="adbg" align="center">
                    <input type="submit" name="edit_cat" value="<?php echo $l['edit_cat']; ?>"/>
                </td>
            </tr>

        </table>
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
        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

            <tr>
                <td colspan="2" class="adcbg" align="center">
                    <b><?php echo $l['create_a_cat']; ?></b>
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['order']; ?></b><br />
                    <?php echo $l['order_exp']; ?>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<select name="catorder">
                        <?php echo implode('', $orderoptions); ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['category_name']; ?></b><br />
                    <?php echo $l['category_name_exp']; ?>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="50" maxlength="" name="catname" <?php echo ( (isset($_POST['catname'])) ? 'value="' . $_POST['catname'] . '"' : '' ); ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['collapsable']; ?></b><br />
                    <?php echo $l['collapsable_exp']; ?>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="catcollapse" checked />
                </td>
            </tr>

            <tr>
                <td colspan="2" class="adbg" align="center">
                    <input type="submit" name="createcat" value="<?php echo $l['create_cat']; ?>"/>
                </td>
            </tr>

        </table>
    </form>
    <?php
    //Admin footers includes Global footers
    adminfoot();
}

function catreorder_theme() {

    global $globals, $theme, $categories, $l, $error, $onload, $dmenus;

    //Pass to onload to initialize a JS
    $onload['catreoder'] = 'init_reoder()';

    //Admin Headers includes Global Headers
    adminhead($l['cp_reorder_cat']);
    ?>

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <tr>
            <td align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/categories.png">
            </td>
            <td align="left" class="adcbg1">

                <font class="adgreen"><?php echo $l['reorder_cat']; ?></font><br />

            </td>
        </tr>

        <tr>
            <td align="left" colspan="2" class="adbg">
                <?php echo $l['reorder_cat_exp']; ?>
            </td>
        </tr>

    </table>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="catreorderform">
        <table width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <tr>
                <td class="adcbg" colspan="2">
                    <?php echo $l['reorder_cat']; ?>
                </td>
            </tr>

        </table>
        <br /><br />

        <table width="60%" cellpadding="0" cellspacing="0" align="center" border="0">
            <tr><td id="cat_reorder_pos" width="100%"></td></tr>
        </table>
        <br /><br />
        <script type="text/javascript">

            //The array id of all the elements to be reordered
            reo_r = new Array(<?php echo implode(', ', array_keys($categories)); ?>);

            //The id of the table that will hold the elements
            reorder_holder = 'cat_reorder_pos';

            //The prefix of the Dom Drag handle for every element
            reo_ha = 'catha';

            //The prefix of the Dom Drag holder for every element(the parent of every element)
            reo_ho = 'cat';

            //The prefix of the Hidden Input field for the reoder value for every element
            reo_hid = 'cathid';

        </script>
        <?php js_reorder(); ?>

        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <tr>
                <td align="center" class="adbg">
                    <?php
                    $temp = 1;
                    foreach ($categories as $ck => $cv) {

                        $dmenus[] = '<div id="cat' . $ck . '">
<table cellpadding="0" cellspacing="0" class="catreo" id="catha' . $ck . '" onmousedown="this.style.zIndex=\'1\'" onmouseup="this.style.zIndex=\'0\'">
<tr><td>
&nbsp;&nbsp;' . $categories[$ck]['name'] . '
</td></tr>
</table>
</div>';

                        echo '<input type="hidden" name="cat[' . $ck . ']" value="' . $temp . '" id="cathid' . $ck . '" />';

                        $temp = $temp + 1;
                    }
                    ?>
                    <input type="submit" name="catreorder" value="<?php echo $l['re_order']; ?>" />
                </td>
            </tr>	
        </table>

    </form>

    <?php
    adminfoot();
}
?>