<?php

function editpost_theme() {

    global $fid, $post_title, $post, $theme, $globals, $logged_in, $l, $postcodefield, $error, $user, $smileys, $smileycode, $smileyimages, $board, $i_started, $attachments, $dmenus, $preview;

    //Global Headers
    aefheader($l['<title>']);

    error_handle($error, '90%');

    //Include the WYSIWYG functions
    include_once($globals['themesdir'] . '/default/texteditor_theme.php');

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

    <?php
    //If user pressed a preview button, just display it
    if (isset($_POST['previewpost']) && empty($error)) {

        echo '<br /><h3>' . $l['preview_title'] . '</h3><table width="100%" cellpadding="0" cellspacing="0">
    <tr>
    <td>
    <table width="100%" cellpadding="0" cellspacing="0"><tr>
    <td class="pcbgl"></td>
    <td class="pcbg"><b>' . $preview['title'] . '</b></td>
    <td class="pcbgr"></td>
    </tr>
    </table>
    </td>
    </tr>

    <tr>
    <td class="cbgbor">
    <table width="100%" cellpadding="1" cellspacing="0">
    <tr>
    <td class="posterbg" width="22%">

    <a href="' . (!empty($post['is_guest']) ? 'mailto:' . $post['gposter_email'] : $globals['index_url'] . 'mid=' . $post['poster_id']) . '">
    ' . $post['username'] . '
    </a>
    </td>

    <td class="postdate" align="right">
    <div style="float:left">
    <img src="' . $theme['images'] . 'postedon.png" title="' . $l['posted_on'] . '">
    ' . $preview['pdate'] . '
    </div>
    </td>
    </tr>';

        echo '<tr>
    <td class="posterinfo" valign="top"><div style="text-align:center;"><b>' .
        $l['this_preview'] . '</b></div>';

        if (!empty($preview['avatarurl'])) {

            echo '<div style="text-align:center;"><img src="' . $preview['avatarurl'][0] . '" width="' . $preview['avatarurl'][1] . '" height="' . $preview['avatarurl'][2] . '" /></div>';
        }

        echo '<div class="pisub">' . $l['prefix_group'] . ' <span ' . (empty($post['mem_gr_colour']) ? '' : 'style="color:' . $post['mem_gr_colour'] . ';"') . '>' . $post['mem_gr_name'] . '</span><br />';

        //If the user group has some images as per Group
        if ($post['image_count']) {

            for ($i = 0; $i < $post['image_count']; $i++) {
                echo '<img src="' . $theme['images'] . $post['image_name'] . '">';
            }

            echo '</div>';
        }

        echo '
    ' . (!empty($post['post_gr_name']) ? '<div class="pisub">' . $l['prefix_post_group'] . ' ' . $post['post_gr_name'] . '</div>' : '') . '
    ' . (!empty($post['posts']) ? '<div class="pisub">' . $l['prefix_posts'] . ' ' . $post['posts'] . '</div>' : '') . '
    <div style="text-align:center;"><b>' . $l['this_preview'] . '</b></div>
    </td>
    <td class="post" align="left" valign="top">
    ' . $preview['post']
        . ($logged_in ? '<br /><br />' . $l['edited_by'] . ' <b>' . $user['username'] . '</b> : ' . $post['modtime'] : '');

        if (!empty($preview['sig'])) {

            echo '<br /><br />-----------------------<br />' . $preview['sig'];
        }

        echo '</td>
    </tr>';

        echo '<tr>
    <td class="ptip">
    &nbsp;
    </td>
    <td class="specialrow">
    <div style="text-align:center;"><b>' . $l['this_preview'] . '</b></div>
    </td>
    </tr>

    </table>

    </td>
    </tr>

    <tr>
    <td><img src="' . $theme['images'] . 'cbot.png" width="100%" height="10"></td>
    </tr>
    </table>
    <br />';
    }
    ?>

    <center>

        <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="editpostform" enctype="multipart/form-data" onsubmit="editor.onsubmit();">

            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0"><tr>
                                <td class="pcbgl"></td>
                                <td class="pcbg" align="left"><?php echo $l['editpost_heading'] . $post_title; ?></td>
                                <td class="pcbgr"></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>

                        <table width="100%" cellpadding="1" cellspacing="1" class="cbgbor">

                            <?php
                            //Was this by a guest
                            if (!empty($post['gposter_name'])) {

                                //When guests are allowed their name
                                echo '<tr>
        <td width="18%" class="erlc">' . $l['your_name'] . '</td>
        <td class="errc"><input type="text" size="40" maxlength="50" name="gposter_name" ' . ( (isset($_POST['gposter_name'])) ? 'value="' . $_POST['gposter_name'] . '"' : 'value="' . $post['gposter_name'] . '"' ) . ' /></td>
        </tr>';

                                //When guests are allowed their email
                                echo '<tr>
        <td width="18%" class="erlc">' . $l['your_email'] . '</td>
        <td class="errc"><input type="text" size="40" maxlength="50" name="gposter_email" ' . ( (isset($_POST['gposter_email'])) ? 'value="' . $_POST['gposter_email'] . '"' : 'value="' . $post['gposter_email'] . '"' ) . ' /></td>
        </tr>';
                            }
                            ?>


                            <tr>
                                <td width="18%" class="erlc"><?php echo $l['edit_title']; ?></td>
                                <td class="errc">
                                    <input type="text" size="45" maxlength="50" name="posttitle" <?php echo ( (isset($_POST['posttitle'])) ? 'value="' . $_POST['posttitle'] . '"' : 'value="' . $post_title . '"' ); ?> /></td>
                            </tr>

                            <tr>
                                <td width="18%" class="erlc"><?php echo $l['edit_text_formatting']; ?></td>
                                <td class="errc">
                                    <?php editor_buttons('editor'); ?>
                                </td>
                            </tr>

                            <?php editor_smileys('editor', $globals['usesmileys']); ?>

                            <tr>
                                <td width="18%" class="erlc"><?php echo $l['edit_post']; ?></td>
                                <td class="errc"><textarea name="post" rows="13" cols="85" id="post" onchange="storeCaret(this);" onkeyup="storeCaret(this);" onclick="storeCaret(this);" onselect="storeCaret(this);" /><?php echo ( (isset($_POST['post'])) ? $_POST['post'] : $post['post'] ); ?></textarea>
                                    <?php echo $postcodefield; /* The most important thing */ ?>
                                </td>
                            </tr>

                            <?php
                            //If the user has some special Options
                            echo '<tr>
        <td width="18%" class="erlc">' . $l['edit_options'] . '</td>
        <td class="errc">
        <table cellpadding="1" cellspacing="1">
        ';

                            $usesmileys = $post['use_smileys'];

                            echo '<tr>
        <td>
        <input type="checkbox" name="usesmileys" ' . (isset($_POST['usesmileys']) ? 'checked="checked"' : ($usesmileys ? 'checked="checked"' : '') ) . ' />
        </td>
        <td>
        ' . $l['options_enable_smileys'] . '</td>
        </tr>';

                            //Some options are removed as they are more appropriate to be in the topic itself.
                            //e.g. can_make_sticky, lock topic, notify topic, add a poll
                            //If the user has permissions to ANNOUNCE this topic
                            if ($user['can_announce_topic']) {
                                echo '<tr>
            <td>
            <input type="checkbox" name="announcetopic" ' . (isset($_POST['announcetopic']) ? 'checked="checked"' : '' ) . ' />
            </td>
            <td>
            ' . $l['options_announce_topic'] . '</td>
            </tr>';
                            }

                            echo '</table>
        </td>
        </tr>';


                            if (!empty($attachments) && $user['can_remove_attach']) {

                                echo '<tr>
            <td width="18%" class="erlc">' . $l['edit_attached_files'] . '</td>
            <td class="errc">
            ' . $l['uncheck_remove_attachments'] . '<br /><br />';

                                foreach ($attachments as $at => $av) {

                                    echo '<input type="checkbox" name="attached[' . $av['atid'] . ']" value="' . $av['atid'] . '" checked="checked" ><img src="' . $globals['url'] . '/mimetypes/' . (empty($av['atmt_icon']) ? 'unknown.png' : $av['atmt_icon']) . '" />&nbsp;' . $av['at_original_file'] . ' (' . $av['at_size'] . ' ' . $l['attachment_kb'] . ', ' . $l['attachment_downloads'] . $av['at_downloads'] . ')<br />';
                                }

                                echo '<br /></td>
            </tr>';
                            }


                            //Check if he can attach files
                            if ($user['can_attach'] && $globals['allownewattachment']) {

                                echo '<tr>
            <td width="18%" class="erlc">' . $l['edit_attachments'] . '</td>
            <td class="errc">';

                                for ($a = 1; $a <= $globals['maxattachmentpost']; $a++) {

                                    echo '<input name="attachments[]" type="file" size="45" /><br />';
                                }

                                echo '</td>
            </tr>';
                            }
                            ?>

                            <tr>
                                <td colspan="2" class="errc" style="text-align:center">
                                    <input type="submit" name="editpost" value="<?php echo $l['edit_submit_button']; ?>"/>
                                    <input type="submit" name="previewpost" value="<?php echo $l['edit_prewiew_button']; ?>"/>
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

    </center>

    <?php
    aeffooter(); //footers that have to be there.
}
?>