<?php
//////////////////////////////////////////////////////////////
//===========================================================
// approvals_theme.php(Admin)
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

function manval_theme() {

    global $globals, $theme, $members, $error, $l, $count;

    //Admin Headers includes Global Headers
    adminhead($l['cp_validating']);
    ?>

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <tr>
            <td align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/userapprove.png">
            </td>
            <td align="left" class="adcbg1">

                <span class="adgreen"><?php echo $l['manage_validating']; ?></span><br />

            </td>
        </tr>

        <tr>
            <td align="left" colspan="2" class="adbg">
                <?php echo $l['members_validate_accounts']; ?>
            </td>
        </tr>

    </table>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" method="get" action="<?php echo $globals['index_url']; ?>" name="sortform" >
        <table width="100%" class="cbor" cellpadding="6" cellspacing="1">
            <tr>
                <td>
                    <input type="hidden" name="act" value="admin" />
                    <input type="hidden" name="adact" value="approvals" />
                    <input type="hidden" name="seadact" value="manval" />
                    <input type="hidden" name="mpg" value="<?php echo (empty($_GET['mpg']) ? '' : $_GET['mpg'] ); ?>" />
                    <?php echo $l['sort_by']; ?> <select name="sortby">
                        <option value="1" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 1 ? ' selected="selected"' : ''); ?> ><?php echo $l['user_id']; ?></option>
                        <option value="2" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 2 ? ' selected="selected"' : ''); ?> ><?php echo $l['username']; ?></option>
                        <option value="3" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 3 ? ' selected="selected"' : ''); ?> ><?php echo $l['email']; ?></option>
                        <option value="4" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 4 ? ' selected="selected"' : ''); ?> ><?php echo $l['registration_time']; ?></option>
                    </select>
                    &nbsp;&nbsp;
                    <select name="order">
                        <option value="1" <?php echo (!empty($_GET['order']) && trim($_GET['order']) == 1 ? ' selected="selected"' : ''); ?> ><?php echo $l['ascending']; ?></option>
                        <option value="2" <?php echo (!empty($_GET['order']) && trim($_GET['order']) == 2 ? ' selected="selected"' : ''); ?> ><?php echo $l['descending']; ?></option>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                    <?php echo $l['page']; ?> <select name="mpg">
                        <?php
                        if (empty($count)) {

                            echo '<option value="1" >1</option>';
                        } else {
                            $num_pages = ceil($count / $globals['maxmemberlist']);

                            for ($i = 1; $i <= $num_pages; $i++) {

                                echo '<option value="' . $i . '" ' . ((isset($_GET['mpg']) && trim($_GET['mpg']) == $i ) ? 'selected="selected"' : '' ) . ' >' . $i . '</option>';
                            }
                        }
                        ?>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" value="<?php echo $l['go']; ?>" />
                </td>
            </tr>
        </table>
    </form>

    <br />
    <script type="text/javascript">
        <!-- Begin
        //var checkflag = "false";
        function check(field, checker) {

            //alert(checker);

            if (checker.value == "0") {

                for (i = 0; i < field.length; i++) {

                    field[i].checked = true;}
                //checkflag = "true";
                checker.value = "1";

            }else{

                for (i = 0; i < field.length; i++) {

                    field[i].checked = false;

                }

                //checkflag = "false";
                checker.value = "0";

            }

        }
        //  End -->
    </script>
    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="manvalform">

        <table width="100%" class="cbor" cellpadding="6" cellspacing="1">
            <tr>
                <td align="right">
                    <?php echo $l['with_selected']; ?> <select name="dothis">
                        <option value="1" <?php echo (!empty($_GET['dothis']) && trim($_GET['dothis']) == 1 ? ' selected="selected"' : ''); ?> ><?php echo $l['activate']; ?></option>
                        <option value="2" <?php echo (!empty($_GET['dothis']) && trim($_GET['dothis']) == 2 ? ' selected="selected"' : ''); ?> ><?php echo $l['activate_send_mail']; ?></option>
                        <option value="3" <?php echo (!empty($_GET['dothis']) && trim($_GET['dothis']) == 3 ? ' selected="selected"' : ''); ?> ><?php echo $l['delete']; ?></option>
                        <option value="4" <?php echo (!empty($_GET['dothis']) && trim($_GET['dothis']) == 4 ? ' selected="selected"' : ''); ?> ><?php echo $l['delete_send_mail']; ?></option>
                    </select>&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" value="<?php echo $l['go']; ?>" />
                </td>
            </tr>
        </table>

        <br />

        <?php
        //The first row that is Headers
        echo'<table width="100%" class="cbor" cellpadding="6" cellspacing="1">

    <tr>
    <td class="ttcbg" width="10%" align="center">' . $l['id'] . '</td>
    <td class="ttcbg" width="20%" align="center">' . $l['username'] . '</td>
    <td class="ttcbg" width="35%" align="center">' . $l['email'] . '</td>
    <td class="ttcbg" width="30%" align="center">' . $l['registered_on'] . '</td>
    <td class="ttcbg" width="5%" align="center">
    <input type=checkbox onClick="check(document.getElementsByName(\'uid[]\'), this)" value="0">
    </td>
    </tr>';

        if (empty($members)) {

            echo '<tr>

        <td class="ucpflc" colspan="5">
        ' . $l['no_members_activate_accounts'] . '
        </td>

        </tr>';
        } else {


            foreach ($members as $m => $mv) {

                echo '<tr>

        <td class="ucpflc">
        <a href="' . $globals['index_url'] . 'mid=' . $members[$m]['id'] . '">' . $members[$m]['id'] . '</a>
        </td>

        <td class="ucpflc">
        <a href="' . $globals['index_url'] . 'mid=' . $members[$m]['id'] . '">' . $members[$m]['username'] . '</a>
        </td>

        <td class="ucpflc">
        <a href="mailto:' . $members[$m]['email'] . '">' . $members[$m]['email'] . '</a>
        </td>

        <td class="ucpflc" align="left">
        ' . date("F j, Y", $members[$m]['r_time']) . '
        </td>

        <td class="ucpflc">
        <input type=checkbox name="uid[]" value="' . $members[$m]['id'] . '">
        </td>';

                echo '</tr>';
            }
        }

        echo '</table>
    </form>';

        adminfoot();
    }

    function awapp_theme() {

        global $globals, $theme, $members, $error, $l, $count;

        //Admin Headers includes Global Headers
        adminhead($l['cp_approvals']);
        ?>

        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

            <tr>
                <td align="right" width="40%" class="adcbg1">
                    <img src="<?php echo $theme['images']; ?>admin/userapprove.png">
                </td>
                <td align="left" class="adcbg1">

                    <span class="adgreen"><?php echo $l['users_awaiting_approval']; ?></span><br />

                </td>
            </tr>

            <tr>
                <td align="left" colspan="2" class="adbg">
                    <?php echo $l['require_admins_approval']; ?>
                </td>
            </tr>

        </table>
        <br /><br />
        <?php
        error_handle($error, '100%');
        ?>
        <form accept-charset="<?php echo $globals['charset']; ?>" method="get" action="<?php echo $globals['index_url']; ?>" name="sortform" >
            <table width="100%" class="cbor" cellpadding="6" cellspacing="1">
                <tr>
                    <td>
                        <input type="hidden" name="act" value="admin" />
                        <input type="hidden" name="adact" value="approvals" />
                        <input type="hidden" name="seadact" value="awapp" />
                        <input type="hidden" name="mpg" value="<?php echo (empty($_GET['mpg']) ? '' : $_GET['mpg'] ); ?>" />
                        <?php echo $l['sort_by']; ?> <select name="sortby">
                            <option value="1" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 1 ? ' selected="selected"' : ''); ?> ><?php echo $l['user_id']; ?></option>
                            <option value="2" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 2 ? ' selected="selected"' : ''); ?> ><?php echo $l['username']; ?></option>
                            <option value="3" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 3 ? ' selected="selected"' : ''); ?> ><?php echo $l['email']; ?></option>
                            <option value="4" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 4 ? ' selected="selected"' : ''); ?> ><?php echo $l['registration_time']; ?></option>
                        </select>
                        &nbsp;&nbsp;
                        <select name="order">
                            <option value="1" <?php echo (!empty($_GET['order']) && trim($_GET['order']) == 1 ? ' selected="selected"' : ''); ?> ><?php echo $l['ascending']; ?></option>
                            <option value="2" <?php echo (!empty($_GET['order']) && trim($_GET['order']) == 2 ? ' selected="selected"' : ''); ?> ><?php echo $l['descending']; ?></option>
                        </select>&nbsp;&nbsp;&nbsp;&nbsp;
                        Page : <select name="mpg">
                            <?php
                            if (empty($count)) {

                                echo '<option value="1" >1</option>';
                            } else {
                                $num_pages = ceil($count / $globals['maxmemberlist']);

                                for ($i = 1; $i <= $num_pages; $i++) {

                                    echo '<option value="' . $i . '" ' . ((isset($_GET['mpg']) && trim($_GET['mpg']) == $i ) ? 'selected="selected"' : '' ) . ' >' . $i . '</option>';
                                }
                            }
                            ?>
                        </select>&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="submit" value="<?php echo $l['go']; ?>" />
                    </td>
                </tr>
            </table>
        </form>

        <br />
        <script type="text/javascript">
            <!-- Begin
            //var checkflag = "false";
            function check(field, checker) {

                //alert(checker);

                if (checker.value == "0") {

                    for (i = 0; i < field.length; i++) {

                        field[i].checked = true;}
                    //checkflag = "true";
                    checker.value = "1";

                }else{

                    for (i = 0; i < field.length; i++) {

                        field[i].checked = false;

                    }

                    //checkflag = "false";
                    checker.value = "0";

                }

            }
            //  End -->
        </script>
        <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="awappform">

            <table width="100%" class="cbor" cellpadding="6" cellspacing="1">
                <tr>
                    <td align="right">
                        <?php echo $l['with_selected']; ?> <select name="dothis">
                            <option value="1" <?php echo (!empty($_GET['dothis']) && trim($_GET['dothis']) == 1 ? ' selected="selected"' : ''); ?> ><?php echo $l['activate']; ?></option>
                            <option value="2" <?php echo (!empty($_GET['dothis']) && trim($_GET['dothis']) == 2 ? ' selected="selected"' : ''); ?> ><?php echo $l['activate_send_mail']; ?></option>
                            <option value="3" <?php echo (!empty($_GET['dothis']) && trim($_GET['dothis']) == 3 ? ' selected="selected"' : ''); ?> ><?php echo $l['delete']; ?></option>
                            <option value="4" <?php echo (!empty($_GET['dothis']) && trim($_GET['dothis']) == 4 ? ' selected="selected"' : ''); ?> ><?php echo $l['delete_send_mail']; ?></option>
                        </select>&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="submit" value="<?php echo $l['go']; ?>" />
                    </td>
                </tr>
            </table>

            <br />

            <?php
            //The first row that is Headers
            echo'<table width="100%" class="cbor" cellpadding="6" cellspacing="1">

    <tr>
    <td class="ttcbg" width="10%">' . $l['id'] . '</td>
    <td class="ttcbg" width="20%" align="center">' . $l['username'] . '</td>
    <td class="ttcbg" width="35%" align="center">' . $l['email'] . '</td>
    <td class="ttcbg" width="30%" align="center">' . $l['registered_on'] . '</td>
    <td class="ttcbg" width="5%" align="center">
    <input type=checkbox onClick="check(document.getElementsByName(\'uid[]\'), this)" value="0">
    </td>
    </tr>';

            if (empty($members)) {

                echo '<tr>

        <td class="ucpflc" colspan="5">
        ' . $l['no_approval_required'] . '
        </td>

        </tr>';
            } else {


                foreach ($members as $m => $mv) {

                    echo '<tr>

        <td class="ucpflc">
        <a href="' . $globals['index_url'] . 'mid=' . $members[$m]['id'] . '">' . $members[$m]['id'] . '</a>
        </td>

        <td class="ucpflc">
        <a href="' . $globals['index_url'] . 'mid=' . $members[$m]['id'] . '">' . $members[$m]['username'] . '</a>
        </td>

        <td class="ucpflc">
        <a href="mailto:' . $members[$m]['email'] . '">' . $members[$m]['email'] . '</a>
        </td>

        <td class="ucpflc" align="left">
        ' . date("F j, Y", $members[$m]['r_time']) . '
        </td>

        <td class="ucpflc">
        <input type=checkbox name="uid[]" value="' . $members[$m]['id'] . '">
        </td>';

                    echo '</tr>';
                }
            }

            echo '</table>
    </form>';

            adminfoot();
        }

        function coppaapp_theme() {

            global $globals, $theme, $members, $error, $l, $count;

            //Admin Headers includes Global Headers
            adminhead($l['cp_coppa']);
            ?>

            <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

                <tr>
                    <td align="right" width="40%" class="adcbg1">
                        <img src="<?php echo $theme['images']; ?>admin/userapprove.png">
                    </td>
                    <td align="left" class="adcbg1">

                        <span class="adgreen"><?php echo $l['coppa_users_awaiting_approval']; ?></span><br />

                    </td>
                </tr>

                <tr>
                    <td align="left" colspan="2" class="adbg">
                        <?php echo $l['members_require_coppa_admins_approval']; ?>
                    </td>
                </tr>

            </table>
            <br /><br />
            <?php
            error_handle($error, '100%');
            ?>
            <form accept-charset="<?php echo $globals['charset']; ?>" method="get" action="<?php echo $globals['index_url']; ?>" name="sortform" >
                <table width="100%" class="cbor" cellpadding="6" cellspacing="1">
                    <tr>
                        <td>
                            <input type="hidden" name="act" value="admin" />
                            <input type="hidden" name="adact" value="approvals" />
                            <input type="hidden" name="seadact" value="coppaapp" />
                            <input type="hidden" name="mpg" value="<?php echo (empty($_GET['mpg']) ? '' : $_GET['mpg'] ); ?>" />
                            <?php echo $l['sort_by']; ?> <select name="sortby">
                                <option value="1" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 1 ? ' selected="selected"' : ''); ?> ><?php echo $l['user_id']; ?></option>
                                <option value="2" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 2 ? ' selected="selected"' : ''); ?> ><?php echo $l['username']; ?></option>
                                <option value="3" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 3 ? ' selected="selected"' : ''); ?> ><?php echo $l['email']; ?></option>
                                <option value="4" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 4 ? ' selected="selected"' : ''); ?> ><?php echo $l['registration_time']; ?></option>
                            </select>
                            &nbsp;&nbsp;
                            <select name="order">
                                <option value="1" <?php echo (!empty($_GET['order']) && trim($_GET['order']) == 1 ? ' selected="selected"' : ''); ?> ><?php echo $l['ascending']; ?></option>
                                <option value="2" <?php echo (!empty($_GET['order']) && trim($_GET['order']) == 2 ? ' selected="selected"' : ''); ?> ><?php echo $l['descending']; ?></option>
                            </select>&nbsp;&nbsp;&nbsp;&nbsp;
                            Page : <select name="mpg">
                                <?php
                                if (empty($count)) {

                                    echo '<option value="1" >1</option>';
                                } else {
                                    $num_pages = ceil($count / $globals['maxmemberlist']);

                                    for ($i = 1; $i <= $num_pages; $i++) {

                                        echo '<option value="' . $i . '" ' . ((isset($_GET['mpg']) && trim($_GET['mpg']) == $i ) ? 'selected="selected"' : '' ) . ' >' . $i . '</option>';
                                    }
                                }
                                ?>
                            </select>&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="submit" value="<?php echo $l['go']; ?>" />
                        </td>
                    </tr>
                </table>
            </form>

            <br />
            <script type="text/javascript">
                <!-- Begin
                //var checkflag = "false";
                function check(field, checker) {

                    //alert(checker);

                    if (checker.value == "0") {

                        for (i = 0; i < field.length; i++) {

                            field[i].checked = true;}
                        //checkflag = "true";
                        checker.value = "1";

                    }else{

                        for (i = 0; i < field.length; i++) {

                            field[i].checked = false;

                        }

                        //checkflag = "false";
                        checker.value = "0";

                    }

                }
                //  End -->
            </script>
            <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="coppaappform">

                <table width="100%" class="cbor" cellpadding="6" cellspacing="1">
                    <tr>
                        <td align="right">
                            <?php echo $l['with_selected']; ?> <select name="dothis">
                                <option value="1" <?php echo (!empty($_GET['dothis']) && trim($_GET['dothis']) == 1 ? ' selected="selected"' : ''); ?> ><?php echo $l['activate']; ?></option>
                                <option value="2" <?php echo (!empty($_GET['dothis']) && trim($_GET['dothis']) == 2 ? ' selected="selected"' : ''); ?> ><?php echo $l['activate_send_mail']; ?></option>
                                <option value="3" <?php echo (!empty($_GET['dothis']) && trim($_GET['dothis']) == 3 ? ' selected="selected"' : ''); ?> ><?php echo $l['delete']; ?></option>
                                <option value="4" <?php echo (!empty($_GET['dothis']) && trim($_GET['dothis']) == 4 ? ' selected="selected"' : ''); ?> ><?php echo $l['delete_send_mail']; ?></option>
                            </select>&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="submit" value="<?php echo $l['go']; ?>" />
                        </td>
                    </tr>
                </table>

                <br />

                <?php
                //The first row that is Headers
                echo'<table width="100%" class="cbor" cellpadding="6" cellspacing="1">

    <tr>
    <td class="ttcbg" width="10%">' . $l['id'] . '</td>
    <td class="ttcbg" width="20%" align="center">' . $l['username'] . '</td>
    <td class="ttcbg" width="35%" align="center">' . $l['email'] . '</td>
    <td class="ttcbg" width="30%" align="center">' . $l['registered_on'] . '</td>
    <td class="ttcbg" width="5%" align="center">
    <input type=checkbox onClick="check(document.getElementsByName(\'uid[]\'), this)" value="0">
    </td>
    </tr>';

                if (empty($members)) {

                    echo '<tr>

        <td class="ucpflc" colspan="5">
        ' . $l['no_members_require_coppa'] . '
        </td>

        </tr>';
                } else {


                    foreach ($members as $m => $mv) {

                        echo '<tr>

        <td class="ucpflc">
        <a href="' . $globals['index_url'] . 'mid=' . $members[$m]['id'] . '">' . $members[$m]['id'] . '</a>
        </td>

        <td class="ucpflc">
        <a href="' . $globals['index_url'] . 'mid=' . $members[$m]['id'] . '">' . $members[$m]['username'] . '</a>
        </td>

        <td class="ucpflc">
        <a href="mailto:' . $members[$m]['email'] . '">' . $members[$m]['email'] . '</a>
        </td>

        <td class="ucpflc" align="left">
        ' . date("F j, Y", $members[$m]['r_time']) . '
        </td>

        <td class="ucpflc">
        <input type=checkbox name="uid[]" value="' . $members[$m]['id'] . '">
        </td>';

                        echo '</tr>';
                    }
                }

                echo '</table>
    </form>';

                adminfoot();
            }
            ?>