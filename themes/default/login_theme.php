<?php

function mainlogin_theme() {

    global $globals, $theme, $error, $l;

    //Global Headers
    aefheader($l['<title>']);

    error_handle($error, '90%');
    ?>

    <table width="100%">

        <tr>
            <td valign="top">
                <?php
                if (!empty($globals['maintenance'])) {

                    echo '<b><font size="4" color="red">' . $l['maintenance_mode'] . '</font></b><br />' .
                    (empty($globals['maintenance_subject']) ? '' : '<b>' . $globals['maintenance_subject'] . '</b><br />') . '' . $globals['maintenance_message'] . '<br /><br /><br />';
                }
                ?>
                <img src="<?php echo $theme['images']; ?>fuser.png" style="float:left;" hspace="6" vspace="2" /><b><a href="<?php echo $globals['index_url']; ?>act=login&logact=fuser" style="text-decoration:none;"><font size="4" color="#2874D0"><?php echo $l['forgot_username']; ?></font></a></b><br />
                <?php echo $l['forgot_username_desc']; ?><br /><br /><br />

                <img src="<?php echo $theme['images']; ?>fpass.png" style="float:left;" hspace="6" vspace="2" /><b><a href="<?php echo $globals['index_url']; ?>act=login&logact=fpass" style="text-decoration:none;"><font size="4" color="#2874D0"><?php echo $l['forgot_password']; ?></font></a></b><br />
                <?php echo $l['forgot_password_desc']; ?><br /><br /><br />

                <img src="<?php echo $theme['images']; ?>register.png" style="float:left;" hspace="6" vspace="2" /><b><a href="<?php echo $globals['index_url']; ?>act=register" style="text-decoration:none;"><font size="4" color="#2874D0"><?php echo $l['sign_up']; ?></font></a></b><br />
                <?php echo $l['sign_up_desc']; ?><br /><br /><br />

                <img src="<?php echo $theme['images']; ?>resendact.png" style="float:left;" hspace="6" vspace="2" /><b><a href="<?php echo $globals['index_url']; ?>act=register&regact=resendact" style="text-decoration:none;"><font size="4" color="#2874D0"><?php echo $l['resend_activation']; ?></font></a></b><br /><?php echo $l['resend_activation_desc']; ?><br /><br /><br />
            </td>
            <td width="30%" valign="top">

                <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="loginform">
                    <table width="100%" cellpadding="3" cellspacing="5" class="cbor" align="right" style="background-color: #e8eefa">

                        <tr>
                            <td colspan="2" align="center">
                                <?php echo $l['sign_in_heading']; ?>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" align="center">
                                <img src="<?php echo $theme['images']; ?>login.png" />
                            </td>
                        </tr>

                        <tr>
                            <td width="25%" align="left">
                                <b><?php echo $l['username']; ?></b>
                            </td>
                            <td align="left">
                                <input type="text" size="20" name="username" <?php echo ( (isset($_POST['username'])) ? 'value="' . $_POST['username'] . '"' : '' ); ?> />
                            </td>
                        </tr>

                        <tr>
                            <td align="left">
                                <b><?php echo $l['password']; ?></b>
                            </td>
                            <td align="left">
                                <input type="password" size="20" name="password" />
                            </td>
                        </tr>

                        <tr>
                            <td align="right">
                                <input type="checkbox" name="remember" <?php echo ( (isset($_POST['remember'])) ? 'checked="checked"' : '' ); ?> />
                            </td>
                            <td align="left">
                                <?php echo $l['remember_me']; ?>
                            </td>
                        </tr>

                        <?php
                        if ($globals['anon_login']) {

                            echo '<tr>
    <td align="right">
    <input type="checkbox" name="anonymously" ' . ( (isset($_POST['anonymously'])) ? 'checked="checked"' : '' ) . ' />
    </td>
    <td align="left">
    ' . $l['anon_sign_in'] . '
    </td>
    </tr>';
                        }
                        ?>

                        <tr>
                            <td align="center" colspan="2">
                                <input type="submit" name="login" value="<?php echo $l['sign_in']; ?>"/>
                            </td>
                        </tr>

                    </table>
                </form>

            </td>
        </tr>
    </table>

    <?php
    //Global footers
    aeffooter();
}

//End of function

function fpass_theme() {

    global $globals, $theme, $error, $l;

    //Global Headers
    aefheader($l['<title>']);

    error_handle($error, '90%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="fpassform">
        <table width="50%" cellpadding="3" cellspacing="5" class="cbor" align="center" style="background-color: #e8eefa">

            <tr>
                <td colspan="2" align="center">
                    <?php echo $l['give_username']; ?>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center">
                    <img src="<?php echo $theme['images']; ?>login.png" />
                </td>
            </tr>

            <tr>
                <td width="35%" align="left">
                    <b><?php echo $l['username']; ?></b>
                </td>
                <td align="left">
                    <input type="text" size="20" name="username" <?php echo ( (isset($_POST['username'])) ? 'value="' . $_POST['username'] . '"' : '' ); ?> />
                </td>
            </tr>

            <?php
            if ($globals['fpass_sec_conf']) {

                echo '
    <tr>
    <td align="left" valign="top">
    <b>' . $l['security_code'] . '</b><br />
    <font class="ucpfexp">' . $l['security_code_exp'] . '</font>
    </td>
    <td align="left">
    <img src="' . $globals['index_url'] . 'act=sec_conf_image"><br /><br />
    <input type="text" size="20" name="sec_conf" />
    </td>
    </tr>
    ';
            }
            ?>

            <tr>
                <td align="right">
                    <input type="checkbox" name="answer" <?php echo ( (isset($_POST['answer'])) ? 'checked="checked"' : '' ); ?> />
                </td>
                <td align="left">
                    <?php echo $l['answer_question']; ?>
                </td>
            </tr>

            <tr>
                <td align="center" colspan="2">
                    <input type="submit" name="fpass" value="<?php echo $l['submit']; ?>"/>
                </td>
            </tr>

        </table>
    </form>


    <?php
    //Global footers
    aeffooter();
}

//End of function

function answer_theme() {

    global $globals, $theme, $error, $qt, $l;

    //Global Headers
    aefheader($l['<title>']);

    error_handle($error, '90%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="answerform">
        <table width="50%" cellpadding="3" cellspacing="5" class="cbor" align="center" style="background-color: #e8eefa">

            <tr>
                <td colspan="2" align="center">
                    <?php echo $l['answer_question_below']; ?>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center">
                    <img src="<?php echo $theme['images']; ?>login.png" />
                </td>
            </tr>

            <tr>
                <td align="left" colspan="2">
                    <b><?php echo $qt; ?></b>
                </td>
            </tr>

            <tr>
                <td align="left" width="15%">
                    <?php echo $l['answer']; ?>
                </td>
                <td align="left">
                    <input type="text" name="secretanswer" />
                </td>
            </tr>

            <tr>
                <td align="center" colspan="2">
                    <input type="submit" name="answerqt" value="<?php echo $l['submit_answer']; ?>" />
                </td>
            </tr>

        </table>
    </form>


    <?php
    //Global footers
    aeffooter();
}

//End of function

function reset_theme() {

    global $globals, $theme, $error, $l;

    //Global Headers
    aefheader($l['<title>']);

    error_handle($error, '90%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="resetform">
        <table width="50%" cellpadding="3" cellspacing="5" class="cbor" align="center" style="background-color: #e8eefa">

            <tr>
                <td colspan="2" align="center">
                    <?php echo $l['reset_password_heading']; ?>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center">
                    <img src="<?php echo $theme['images']; ?>login.png" />
                </td>
            </tr>

            <tr>
                <td align="right" width="50%">
                    <b><?php echo $l['new_password']; ?></b>
                </td>
                <td align="left">
                    <input type="password" name="newpass" />
                </td>
            </tr>

            <tr>
                <td align="right">
                    <b><?php echo $l['password_conf']; ?></b>
                </td>
                <td align="left">
                    <input type="password" name="newpassconf" />
                </td>
            </tr>

            <tr>
                <td align="center" colspan="2">
                    <input type="submit" name="reset" value="<?php echo $l['submit_pass']; ?>"/>
                </td>
            </tr>

        </table>
    </form>

    <?php
    //Global footers
    aeffooter();
}

//End of function

function fuser_theme() {

    global $globals, $theme, $error, $l;

    //Global Headers
    aefheader($l['<title>']);

    error_handle($error, '90%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="fuserform">
        <table width="50%" cellpadding="3" cellspacing="5" class="cbor" align="center" style="background-color: #e8eefa">

            <tr>
                <td colspan="2" align="center">
                    <?php echo $l['give_email']; ?>
                </td>
            </tr>

            <tr>
                <td colspan="2" align="center">
                    <img src="<?php echo $theme['images']; ?>login.png" />
                </td>
            </tr>

            <tr>
                <td width="35%" align="left">
                    <b><?php echo $l['email']; ?></b>
                </td>
                <td align="left">
                    <input type="text" size="20" name="email" <?php echo ( (isset($_POST['email'])) ? 'value="' . $_POST['email'] . '"' : '' ); ?> />
                </td>
            </tr>

            <?php
            if ($globals['fpass_sec_conf']) {

                echo '
    <tr>
    <td align="left" valign="top">
    <b>' . $l['security_code'] . '</b><br />
    <font class="ucpfexp">' . $l['security_code_exp'] . '</font>
    </td>
    <td align="left">
    <img src="' . $globals['index_url'] . 'act=sec_conf_image"><br /><br />
    <input type="text" size="20" name="sec_conf" />
    </td>
    </tr>
    ';
            }
            ?>

            <tr>
                <td align="center" colspan="2">
                    <input type="submit" name="fuser" value="<?php echo $l['submit']; ?>" />
                </td>
            </tr>

        </table>
    </form>


    <?php
    //Global footers
    aeffooter();
}

//End of function
?>