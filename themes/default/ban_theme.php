<?php

function putban_theme() {

    global $user, $logged_in, $globals, $AEF_SESS, $theme, $l, $member, $error;

    //The header
    aefheader($l['<title>']);

    error_handle($error, '60%', true);
    ?>
    <form accept-charset="<?php echo $globals['charset']; ?>" method="post" action="" name="putbanform" >
        <br />	
        <table width="60%" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0"><tr>
                            <td class="pcbgl"></td>
                            <td class="pcbg" align="left"><?php echo $l['ban_heading']; ?></td>
                            <td class="pcbgr"></td>		
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>

                    <table width="100%" cellpadding="5" cellspacing="1" class="cbgbor">

                        <tr>
                            <td class="ucpfcbg1" colspan="2" align="center">
                                <img src="<?php echo $theme['images']; ?>banuser.png" />
                            </td>
                        </tr>

                        <tr>
                            <td width="30%" class="etrc">
                                <b><?php echo $l['user']; ?> :</b>
                            </td>
                            <td class="etrc" align="left">
                                &nbsp;<input type="text" size="40"  name="username" value="<?php echo $member['username']; ?>" disabled="disabled" />
                            </td>
                        </tr>

                        <tr>
                            <td class="etrc">
                                <b><?php echo $l['num_days']; ?> :</b>
                            </td>
                            <td class="etrc" align="left">
                                &nbsp;<input type="text" size="40"  name="days" value="<?php echo (isset($_POST['days']) ? $_POST['days'] : '' ); ?>" />
                            </td>
                        </tr>


                        <tr>
                            <td colspan="2" class="etrc" style="text-align:center">
                                <input type="submit" name="putban" value="<?php echo $l['submit_button']; ?>" />
                            </td>
                        </tr>	

                    </table>

                </td>
            </tr>

            <tr>
                <td><img src="<?php echo $theme['images']; ?>cbotsmall.png" width="100%" height="10"></td>
            </tr>

        </table>

    </form>	
    <?php
    //The defualt footers
    aeffooter();
}
?>