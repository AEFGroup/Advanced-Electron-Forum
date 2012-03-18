<?php

function report_theme() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error, $topic, $post, $name;

    //The header
    aefheader($l['<title>']);

    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="reportingapost">
        <br />
        <br />
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="cbgl"></td>
                            <td class="cbg" align="left"><?php echo $l['heading']; ?></td>
                            <td class="cbgr"></td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>


                    <table width="100%" cellpadding="2" cellspacing="1" align="center" class="cbgbor">

                        <tr>
                            <td class="etlc" width="30%">
                                <b><?php echo $l['report']; ?></b><br />
                                <span class="ucpfexp"><?php echo $l['report_exp']; ?></span>
                            </td>
                            <td class="etrc">
                                <textarea name="report" rows="10" cols="65"><?php echo ( (isset($_POST['report'])) ? $_POST['report'] : '' ); ?></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td class="etrc" align="center" colspan="2" style="text-align:center">
                                <input type="submit" name="reportpost" value="<?php echo $l['submit']; ?>" />
                            </td>
                        </tr>

                    </table>

                </td>
            </tr>

        </table>

    </form>
    <br /><br /><br />

    <?php
    //The defualt footers
    aeffooter();
}
?>