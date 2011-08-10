<?php

function mergeposts_theme() {

    global $fid, $title, $topic, $theme, $globals, $logged_in, $l, $postcodefield, $error, $user, $smileys, $smileycode, $smileyimages, $board, $i_started, $posts, $dmenus;

    //Global Headers
    aefheader($l['<title>']);

    error_handle($error, '90%');

    //Include the WYSIWYG functions
    include_once($theme['path'] . '/texteditor_theme.php');

    //Iframe for WYSIWYG
    $dmenus[] = '<iframe id="aefwysiwyg" style="width:530px; height:175px; visibility: hidden; left:0px; top:0px; position:absolute; border:1px solid #666666; background:#FFFFFF;" frameborder="0" marginheight="3" marginwidth="3"></iframe>';
    ?>
    <script language="JavaScript" src="<?php echo $theme['url'] . '/js/texteditor.js'; ?>" type="text/javascript">
    </script>

    <script type="text/javascript">
        addonload('init_editor();');
        function init_editor(){
            try_wysiwyg = <?php echo (empty($theme['wysiwyg']) ? 'false' : 'true'); ?>;
            editor = new aef_editor();
            editor.wysiwyg_id = 'aefwysiwyg';
            editor.textarea_id = 'post';
            if(try_wysiwyg){
                editor.to_wysiwyg(true);//Directly try to pass to WYSIWYG Mode
            }
        };
    </script>

    <center>

        <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="mergepostsform" enctype="multipart/form-data" onsubmit="editor.onsubmit();">
            <br />
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0"><tr>
                                <td class="pcbgl"></td>
                                <td class="pcbg" align="left"><?php echo $l['mergeposts_heading']; ?></td>
                                <td class="pcbgr"></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>

                        <table width="100%" cellpadding="1" cellspacing="1" class="cbgbor">

                            <tr>
                                <td width="22%" class="mplc"><?php echo $l['merged_posts_time']; ?></td>
                                <td class="mprc">
                                    <select name="ptime">
                                        <?php
                                        foreach ($posts as $k => $p) {

                                            echo '<option value="' . $k . '" ' . ((isset($_POST['ptime']) && trim($_POST['ptime']) == $k ) ? 'selected="selected"' : '' ) . '>' . datify($p['ptime']) . '&nbsp;&nbsp;&nbsp;&nbsp;Post&nbsp;-&nbsp;' . $k . '</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td width="22%" class="mplc"><?php echo $l['merged_posts_poster']; ?></td>
                                <td class="mprc">
                                    <select name="poster_id">
                                        <?php
                                        foreach ($posts as $k => $p) {

                                            echo '<option value="' . $p['poster_id'] . '" ' . ((isset($_POST['poster_id']) && trim($_POST['poster_id']) == $p['poster_id'] ) ? 'selected="selected"' : '' ) . ' >' . (empty($p['poster']) ? 'Guest' : $p['poster']) . '&nbsp;&nbsp;&nbsp;&nbsp;Post&nbsp;-&nbsp;' . $k . '</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td class="mplc"><?php echo $l['merge_title']; ?></td>
                                <td class="mprc">
                                    <input type="text" size="45" name="post_title" <?php echo ( (isset($_POST['post_title'])) ? 'value="' . $_POST['post_title'] . '"' : '' ); ?> /></td>
                            </tr>

                            <tr>
                                <td class="mplc"><?php echo $l['merge_text_formatting']; ?></td>
                                <td class="mprc">
                                    <?php editor_buttons('editor'); ?>
                                </td>
                            </tr>

                            <?php editor_smileys('editor', $globals['usesmileys']); ?>

                            <tr>
                                <td class="mplc"><?php echo $l['merge_post']; ?></td>
                                <td class="mprc"><textarea name="post" rows="13" cols="85" id="post" onchange="storeCaret(this);" onkeyup="storeCaret(this);" onclick="storeCaret(this);" onselect="storeCaret(this);" /><?php
                        if (isset($_POST['post'])) {

                            echo $_POST['post'];
                        } else {

                            foreach ($posts as $k => $p) {

                                echo $p['post'] . "\n";
                            }
                        }
                            ?></textarea>
                                </td>
                            </tr>

                            <?php
                            //If the user has some special Options
                            echo '<tr>
        <td class="mplc">' . $l['merge_options'] . '</td>
        <td class="mprc">
        <table cellpadding="1" cellspacing="1">
        ';

                            echo '<tr>
        <td>
        <input type="checkbox" name="usesmileys" ' . (isset($_POST['usesmileys']) ? 'checked="checked"' : ($globals['usesmileys'] ? 'checked="checked"' : '') ) . ' />
        </td>
        <td>' . $l['options_enable_smileys'] . '</td>
        </tr>';

                            echo '</table>
        </td>
        </tr>';
                            ?>

                            <tr>
                                <td colspan="2" class="mprc" style="text-align:center"><input type="submit" name="mergeposts" value="<?php echo $l['merge_submit_button']; ?>"/></td>
                            </tr>
                        </table>

                    </td>
                </tr>

                <tr>
                    <td><img src="<?php echo $theme['images']; ?>cbot.png" width="100%" height="10"></td>
                </tr>

            </table>

        </form>

    </center>

    <?php
    aeffooter(); //footers that have to be there.
}
?>