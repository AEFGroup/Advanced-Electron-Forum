<?php

function edittopic_theme() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error, $topic;

    //The header
    aefheader($l['<title>']);

    error_handle($error, '90%');
    ?>	

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="edittopicform">

        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0"><tr>
                            <td class="pcbgl"></td>
                            <td class="pcbg" align="left"><?php echo $l['edittopic_heading'] . $topic['topic']; ?></td>
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
                                <img src="<?php echo $theme['images']; ?>write.png" />
                            </td>
                        </tr>

                        <tr>
                            <td width="18%" class="etlc"><?php echo $l['edit_title']; ?></td>
                            <td class="etrc"><input type="text" size="45" name="toptitle" <?php echo ( (isset($_POST['toptitle'])) ? 'value="' . $_POST['toptitle'] . '"' : 'value="' . $topic['topic'] . '"' ); ?>/></td>
                        </tr>

                        <tr>
                            <td width="18%" class="etlc"><?php echo $l['edit_description']; ?></td>
                            <td class="etrc"><input type="text" size="45" name="topdesc" <?php echo ( (isset($_POST['topdesc'])) ? 'value="' . $_POST['topdesc'] . '"' : 'value="' . $topic['t_description'] . '"' ); ?>/></td>
                        </tr>

                        <?php
                        //Topic Icons
                        echo '<tr>
			<td width="18%" class="etlc">' . $l['edit_topic_icons'] . '</td>
			<td class="etrc">';

                        //Topic Icons loop
                        foreach ($globals['topic_icons'] as $ik => $iv) {

                            echo '<input type="radio" name="topic_icon" value="' . $ik . '" ' . ( (isset($_POST['topic_icon']) && (int) $_POST['topic_icon'] == $ik ) ? 'checked="checked"' : ($topic['type_image'] == $ik ? 'checked="checked"' : '' ) ) . ' />
			<img src="' . $theme['images'] . 'icons/' . $globals['topic_icons'][$ik][0] . '" title="' . $globals['topic_icons'][$ik][1] . '" />&nbsp;&nbsp;&nbsp;';
                        }


                        echo '<br />
			<input type="radio" name="topic_icon" value="0" ' . ( (isset($_POST['topic_icon']) && (int) $_POST['topic_icon'] == 0 ) ? 'checked="checked"' : (!isset($_POST['topic_icon']) && empty($topic['type_image']) ? 'checked="checked"' : '') ) . ' />' . $l['topic_icons_none'] . '&nbsp;&nbsp;&nbsp;';

                        echo '</td></tr>';
                        ?>

                        <tr>
                            <td colspan="2" class="etrc" style="text-align:center">
                                <input type="submit" name="edittopic" value="<?php echo $l['edit_submit_button']; ?>"/></td>
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