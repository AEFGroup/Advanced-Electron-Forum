<?php

function editpoll_theme() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $pg, $error, $poll;

    //The header
    aefheader($l['<title>']);

    error_handle($error, '90%', true);
    ?>	

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="editpollform">
        <br />
        <table width="90%" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0"><tr>
                            <td class="pcbgl"></td>
                            <td class="pcbg" align="left"><?php echo $l['edit_poll_heading']; ?></td>
                            <td class="pcbgr"></td>		
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>

                    <table width="100%" cellpadding="2" cellspacing="1" class="cbgbor">

                        <tr>
                            <td class="ucpfcbg1" colspan="2" align="center">
                                <img src="<?php echo $theme['images']; ?>poll.png" />
                            </td>
                        </tr>

                        <tr>
                            <td class="polc" width="30%" align="left">
                                <b><?php echo $l['poll_question']; ?></b>
                            </td>
                            <td class="porc" align="left">
                                <input type="text" size="45" name="question" <?php echo ( (isset($_POST['question'])) ? 'value="' . $_POST['question'] . '"' : 'value="' . $poll['qt'] . '"'); ?> />
                            </td>
                        </tr>

                        <tr>
                            <td class="polc" align="left">
                                <b><?php echo $l['lock_voting']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['lock_voting_exp']; ?></font>
                            </td>
                            <td class="porc" align="left">
                                <input type="checkbox" size="45" name="locked" <?php echo ( (isset($_POST['locked'])) ? 'checked="checked"' : ($poll['locked'] ? 'checked="checked"' : '') ); ?> />
                            </td>
                        </tr>

                        <tr>
                            <td class="polc" align="left">
                                <b><?php echo $l['can_change_vote']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['can_change_vote_exp']; ?></font>
                            </td>
                            <td class="porc" align="left">
                                <input type="checkbox" size="45" name="change_vote" <?php echo ( (isset($_POST['change_vote'])) ? 'checked="checked"' : ($poll['change_vote'] ? 'checked="checked"' : '') ); ?> />
                            </td>
                        </tr>

                        <tr>
                            <td class="polc" align="left">
                                <b><?php echo $l['expires_in']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['expires_in_exp']; ?></font>
                            </td>
                            <td class="porc" align="left">
                                <input type="text" size="10" name="expiry" <?php echo ( (isset($_POST['expiry'])) ? 'value="' . $_POST['expiry'] . '"' : ($poll['expiry'] ? 'value="' . $poll['expiry'] . '"' : 'value="0"') ); ?> />
                            </td>
                        </tr>

                        <tr>
                            <td class="polc" align="left" valign="top">
                                <b><?php echo $l['show_poll_results']; ?></b>
                            </td>
                            <td class="porc" align="left">
                                <input type="radio" name="show_when" value="0" <?php echo ( (isset($_POST['show_when']) && $_POST['show_when'] == 0) ? 'checked="checked"' : (($poll['show_when'] == 0) ? 'checked="checked"' : '') ); ?> /> <?php echo $l['show_anyone']; ?><br />
                                <input type="radio" name="show_when" value="1" <?php echo ( (isset($_POST['show_when']) && $_POST['show_when'] == 1) ? 'checked="checked"' : (($poll['show_when'] == 1) ? 'checked="checked"' : '') ); ?> /> <?php echo $l['show_after_vote']; ?><br />
                                <input type="radio" name="show_when" value="2" <?php echo ( (isset($_POST['show_when']) && $_POST['show_when'] == 2) ? 'checked="checked"' : (($poll['show_when'] == 2) ? 'checked="checked"' : '') ); ?> /> <?php echo $l['show_after_expiry']; ?><br />
                            </td>
                        </tr>

                        <tr>
                            <td class="polc" align="left" valign="top">
                                <b><?php echo $l['poll_options']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['poll_options_exp']; ?></font>
                            </td>
                            <td class="porc" align="left">
                                <?php
                                $i = 1;

                                foreach ($poll['options'] as $ok => $ov) {

                                    echo $i . ' : <input type="text" size="20" name="options[' . $i . '][name]" ' . ( (isset($_POST['options'][$i]['name'])) ? 'value="' . $_POST['options'][$i]['name'] . '"' : 'value="' . $ov['poo_option'] . '"' ) . ' />&nbsp;&nbsp;&nbsp;<input type="text" size="7" name="options[' . $i . '][votes]" ' . ( (isset($_POST['options'][$i]['votes'])) ? 'value="' . $_POST['options'][$i]['votes'] . '"' : 'value="' . $ov['poo_votes'] . '"' ) . ' /><input type="hidden" name="options[' . $i . '][pooid]" value="' . $ov['pooid'] . '" /><br />';

                                    $i++;
                                }

                                echo '<br />' . $l['additional_options'] . '<br />';

                                for ($i = $i; $i <= $globals['maxoptionspoll']; $i++) {

                                    echo $i . ' : <input type="text" size="20" name="options[' . $i . '][name]" ' . ( (isset($_POST['options'][$i]['name'])) ? 'value="' . $_POST['options'][$i]['name'] . '"' : '' ) . ' />&nbsp;&nbsp;&nbsp;<input type="text" size="7" name="options[' . $i . '][votes]" ' . ( (isset($_POST['options'][$i]['votes'])) ? 'value="' . $_POST['options'][$i]['votes'] . '"' : '' ) . ' /><br />';
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="polc" align="center" colspan="2">
                                <input type="submit" name="editpoll" value="<?php echo $l['submit_button']; ?>" />
                            </td>
                        </tr>

                    </table>

                </td>
            </tr>

            <tr>
                <td><img src="<?php echo $theme['images']; ?>cbot.png" width="100%" height="10"></td>
            </tr>

        </table>

    </form>
    <br /><br /><br />

    <?php
    //The defualt footers
    aeffooter();
}

function postpoll_theme() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme;
    global $pg, $error, $poll;

    //The header
    aefheader($l['<title>']);

    error_handle($error, '90%', true);
    ?>	

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="postpollform">
        <br />
        <table width="90%" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0"><tr>
                            <td class="pcbgl"></td>
                            <td class="pcbg" align="left"><?php echo $l['add_poll_heading']; ?></td>
                            <td class="pcbgr"></td>		
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>

                    <table width="100%" cellpadding="2" cellspacing="1" class="cbgbor">


                        <tr>
                            <td class="ucpfcbg1" colspan="2" align="center">
                                <img src="<?php echo $theme['images']; ?>poll.png" />
                            </td>
                        </tr>

                        <tr>
                            <td class="polc" width="30%" align="left">
                                <b><?php echo $l['poll_question']; ?></b>
                            </td>
                            <td class="porc" align="left">
                                <input type="text" size="45" name="question" <?php echo ( (isset($_POST['question'])) ? 'value="' . $_POST['question'] . '"' : 'value="' . $poll['qt'] . '"'); ?> />
                            </td>
                        </tr>

                        <tr>
                            <td class="polc" align="left">
                                <b><?php echo $l['lock_voting']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['lock_voting_exp']; ?></font>
                            </td>
                            <td class="porc" align="left">
                                <input type="checkbox" size="45" name="locked" <?php echo ( (isset($_POST['locked'])) ? 'checked="checked"' : ($poll['locked'] ? 'checked="checked"' : '') ); ?> />
                            </td>
                        </tr>

                        <tr>
                            <td class="polc" align="left">
                                <b><?php echo $l['can_change_vote']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['can_change_vote_exp']; ?></font>
                            </td>
                            <td class="porc" align="left">
                                <input type="checkbox" size="45" name="change_vote" <?php echo ( (isset($_POST['change_vote'])) ? 'checked="checked"' : ($poll['change_vote'] ? 'checked="checked"' : '') ); ?> />
                            </td>
                        </tr>

                        <tr>
                            <td class="polc" align="left">
                                <b><?php echo $l['expires_in']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['expires_in_exp']; ?></font>
                            </td>
                            <td class="porc" align="left">
                                <input type="text" size="10" name="expiry" <?php echo ( (isset($_POST['expiry'])) ? 'value="' . $_POST['expiry'] . '"' : ($poll['expiry'] ? 'value="' . $poll['expiry'] . '"' : 'value="0"') ); ?> />
                            </td>
                        </tr>

                        <tr>
                            <td class="polc" align="left" valign="top">
                                <b><?php echo $l['show_poll_results']; ?></b>
                            </td>
                            <td class="porc" align="left">
                                <input type="radio" name="show_when" value="0" <?php echo ( (isset($_POST['show_when']) && $_POST['show_when'] == 0) ? 'checked="checked"' : (($poll['show_when'] == 0) ? 'checked="checked"' : '') ); ?> /> <?php echo $l['show_anyone']; ?><br />
                                <input type="radio" name="show_when" value="1" <?php echo ( (isset($_POST['show_when']) && $_POST['show_when'] == 1) ? 'checked="checked"' : (($poll['show_when'] == 1) ? 'checked="checked"' : '') ); ?> /> <?php echo $l['show_after_vote']; ?><br />
                                <input type="radio" name="show_when" value="2" <?php echo ( (isset($_POST['show_when']) && $_POST['show_when'] == 2) ? 'checked="checked"' : (($poll['show_when'] == 2) ? 'checked="checked"' : '') ); ?> /> <?php echo $l['show_after_expiry']; ?><br />
                            </td>
                        </tr>

                        <tr>
                            <td class="polc" align="left" valign="top">
                                <b><?php echo $l['poll_options']; ?></b>
                            </td>
                            <td class="porc" align="left">
                                <?php
                                for ($i = 1; $i <= $globals['maxoptionspoll']; $i++) {

                                    echo $i . ' : <input type="text" size="20" name="options[' . $i . '][name]" ' . ( (isset($_POST['options'][$i]['name'])) ? 'value="' . $_POST['options'][$i]['name'] . '"' : '' ) . ' /><br />';
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="polc" align="center" colspan="2">
                                <input type="submit" name="postpoll" value="<?php echo $l['submit_button']; ?>" />
                            </td>
                        </tr>

                    </table>

                </td>
            </tr>

            <tr>
                <td><img src="<?php echo $theme['images']; ?>cbot.png" width="100%" height="10"></td>
            </tr>

        </table>

    </form>
    <br /><br /><br />

    <?php
    //The defualt footers
    aeffooter();
}
?>