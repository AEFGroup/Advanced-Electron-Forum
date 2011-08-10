<?php

function tellafriend_theme() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error, $topic, $message;

    //The header
    aefheader($l['<title>']);

    error_handle($error, '90%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="tellafriendform">

        <br /><br /><table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0"><tr>
                            <td class="pcbgl"></td>
                            <td class="pcbg" align="left"><?php echo $l['tellafriend_heading']; ?></td>
                            <td class="pcbgr"></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>


                    <table width="100%" cellpadding="2" cellspacing="1" class="cbgbor" align="center">

                        <tr>
                            <td class="ucpfcbg1" colspan="2" align="center">
                                <img src="<?php echo $theme['images']; ?>sigwrite.png" />
                            </td>
                        </tr>

                        <tr>
                            <td class="taflc" width="30%" align="left">
                                <b><?php echo $l['your_name']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['your_name_exp']; ?></font>
                            </td>
                            <td class="tafrc" align="left">
                                <input type="text" size="45" name="sendername" <?php echo ( (isset($_POST['sendername'])) ? 'value="' . $_POST['sendername'] . '"' : ((!empty($user['username'])) ? 'value="' . $user['username'] . '"' : '') ); ?> />
                            </td>
                        </tr>

                        <tr>
                            <td class="taflc" width="30%" align="left">
                                <b><?php echo $l['recipients_name']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['recipients_name_exp']; ?></font>
                            </td>
                            <td class="tafrc" align="left">
                                <input type="text" size="45" name="recipientname" <?php echo ( (isset($_POST['recipientname'])) ? 'value="' . $_POST['recipientname'] . '"' : '' ); ?> />
                            </td>
                        </tr>

                        <tr>
                            <td class="taflc" align="left">
                                <b><?php echo $l['recipients_email']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['recipients_email_exp']; ?></font>
                            </td>
                            <td class="tafrc" align="left">
                                <input type="text" size="45" name="email" <?php echo ((isset($_POST['email'])) ? 'value="' . trim($_POST['email']) . '"' : ''); ?> />
                            </td>
                        </tr>

                        <tr>
                            <td class="taflc" align="left">
                                <b><?php echo $l['subject']; ?></b>
                            </td>
                            <td class="tafrc" align="left">
                                <input type="text" size="45" name="subject" <?php echo ((isset($_POST['subject'])) ? 'value="' . trim($_POST['subject']) . '"' : ((!empty($topic['topic'])) ? 'value="' . $topic['topic'] . '"' : '')); ?> />
                            </td>
                        </tr>

                        <tr>
                            <td class="taflc" align="left" valign="top">
                                <b><?php echo $l['message']; ?></b>
                            </td>
                            <td class="tafrc" align="left">
                                <textarea name="message" cols="70" rows="10"><?php echo ((isset($_POST['message'])) ? trim($_POST['message']) : $message); ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td class="taflc" align="center" colspan="2">
                                <input type="submit" name="tellafriend" value="<?php echo $l['submit_button']; ?>" />
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