<?php

function newtopic_theme() {

    global $theme, $globals, $logged_in, $l, $postcodefield, $error, $user, $smileys, $smileycode, $smileyimages, $smileyurl, $board, $dmenus, $onload, $preview;

    //Global Headers
    aefheader($l['<title>']);

    error_handle($error, '90%');

    //Include the WYSIWYG functions
    include_cached($theme['path'] . '/texteditor_theme.php');

    //Iframe for WYSIWYG
    $dmenus[] = '<iframe id="aefwysiwyg" style="width:530px; height:175px; visibility: hidden; left:0px; top:0px; position:absolute; border:1px solid #666666; background:#FFFFFF;" frameborder="0" marginheight="3" marginwidth="3"></iframe>';
    ?>
    <script language="JavaScript" src="<?php echo $theme['url'] . '/js/texteditor.js'; ?>" type="text/javascript"></script>

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
    if (isset($_POST['previewtopic']) && empty($error)) {

        echo '<br /><h3>' . $l['preview_title'] . '</h3><table width="100%" cellpadding="0" cellspacing="0">
    <tr>
    <td>
    <table width="100%" cellpadding="0" cellspacing="0"><tr>
    <td class="pcbgl"></td>
    <td class="pcbg"><b>' . $preview['title'] . (empty($preview['description']) ? '' : ', ' . $preview['description']) . '</b></td>
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

    <a href="' . (!$logged_in ? 'mailto:' . $preview['gposter_email'] : $globals['index_url'] . 'mid=' . $user['id']) . '">
    ' . $preview['username'] . '
    </a>
    </td>

    <td class="postdate" align="right">
    <div style="float:left">
    <img src="' . $theme['images'] . 'postedon.png" title="' . $l['posted_on'] . '">
    ' . $preview['pdate'] . '
    </div>' .
        '</td>
    </tr>';

        echo '<tr>
    <td class="posterinfo" valign="top"><div style="text-align:center;"><b>' .
        $l['this_preview'] . '</b></div>';

        if (!empty($preview['avatarurl'])) {

            echo '<div style="text-align:center;"><img src="' . $preview['avatarurl'][0] . '" width="' . $preview['avatarurl'][1] . '" height="' . $preview['avatarurl'][2] . '" /></div>';
        }

        echo '<div class="pisub">' . $l['prefix_group'] . ' <span ' . (empty($user['mem_gr_colour']) ? '' : 'style="color:' . $user['mem_gr_colour'] . ';"') . '>' . $user['mem_gr_name'] . '</span><br />';

        //If the user group has some images as per Group
        if ($user['image_count']) {

            for ($i = 0; $i < $user['image_count']; $i++) {
                echo '<img src="' . $theme['images'] . $user['image_name'] . '">';
            }

            echo '</div>';
        }

        echo '
    ' . (!empty($user['post_gr_name']) ? '<div class="pisub">' . $l['prefix_post_group'] . ' ' . $user['post_gr_name'] . '</div>' : '') . '
    ' . (!empty($user['posts']) ? '<div class="pisub">' . $l['prefix_posts'] . ' ' . $user['posts'] . '</div>' : '') . '
    <div class="pisub">' . $l['prefix_status'] . ' ' . ($logged_in ? '<img src="' . $theme['images'] . 'online.png" title="' . $l['online'] . '" />' : '<img src="' . $theme['images'] . 'offline.png" title="' . $l['offline'] . '" />') . '</div>
    <div style="text-align:center;"><b>' . $l['this_preview'] . '</b></div>
    </td>
    <td class="post" align="left" valign="top">
    ' . $preview['post'];

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


        <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="topicform" enctype="multipart/form-data" onsubmit="editor.onsubmit();">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0"><tr>
                                <td class="pcbgl"></td>
                                <td class="pcbg" align="left"><?php echo $l['newtopic_heading']; ?></td>
                                <td class="pcbgr"></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="100%" cellpadding="1" cellspacing="1" class="cbgbor">

                            <?php
                            if (!$logged_in) {

                                //When guests are allowed their name
                                echo '<tr>
        <td class="ntlc">' . $l['your_name'] . '</td>
        <td class="ntrc"><input type="text" size="40" maxlength="50" name="gposter_name" ' . ( (isset($_POST['gposter_name'])) ? 'value="' . $_POST['gposter_name'] . '"' : '' ) . ' /></td>
        </tr>';

                                //When guests are allowed their email
                                echo '<tr>
        <td class="ntlc">' . $l['your_email'] . '</td>
        <td class="ntrc"><input type="text" size="40" maxlength="50" name="gposter_email" ' . ( (isset($_POST['gposter_email'])) ? 'value="' . $_POST['gposter_email'] . '"' : '' ) . ' /></td>
        </tr>';
                            }
                            ?>

                            <tr>
                                <td width="18%" class="ntlc"><?php echo $l['newtopic_title']; ?></td>
                                <td class="ntrc"><input type="text" name="toptitle" size="45" <?php echo ( (isset($_POST['toptitle'])) ? 'value="' . $_POST['toptitle'] . '"' : '' ); ?>/></td>
                            </tr>

                            <tr>
                                <td class="ntlc"><?php echo $l['newtopic_desc']; ?></td>
                                <td class="ntrc"><input type="text" name="topdesc" size="45" <?php echo ( (isset($_POST['topdesc'])) ? 'value="' . $_POST['topdesc'] . '"' : '' ); ?>/></td>
                            </tr>

                            <tr>
                                <td class="ntlc"><?php echo $l['newtopic_text_formatting']; ?></td>
                                <td class="ntrc" align="left">
                                    <?php editor_buttons('editor'); ?>
                                </td>
                            </tr>

                            <?php editor_smileys('editor', $globals['usesmileys']); ?>

                            <tr>
                                <td class="ntlc"><?php echo $l['newtopic_post']; ?></td>
                                <td class="ntrc"><textarea name="toppost" id="post" style="width:530px; height:175px;" onchange="storeCaret(this);" onkeyup="storeCaret(this);" onclick="storeCaret(this);" onselect="storeCaret(this);" /><?php echo ( (isset($_POST['toppost'])) ? $_POST['toppost'] : '' ); ?></textarea>
                                    <?php echo $postcodefield; /* The most important thing */ ?>
                                </td>
                            </tr>

                            <?php
                            //Topic Icons
                            echo '<tr>
            <td width="18%" class="ntlc">' . $l['newtopic_topic_icons'] . '</td>
            <td class="ntrc">';

                            //Topic Icons loop
                            foreach ($globals['topic_icons'] as $ik => $iv) {

                                echo '<input type="radio" name="topic_icon" value="' . $ik . '" ' . ( (isset($_POST['topic_icon']) && (int) $_POST['topic_icon'] == $ik ) ? 'checked="checked"' : '' ) . ' />
            <img src="' . $theme['images'] . 'icons/' . $globals['topic_icons'][$ik][0] . '" title="' . $globals['topic_icons'][$ik][1] . '" />&nbsp;&nbsp;&nbsp;';
                            }


                            echo '<br />
            <input type="radio" name="topic_icon" value="0" ' . ( (isset($_POST['topic_icon']) && (int) $_POST['topic_icon'] == 0 ) ? 'checked="checked"' : (!isset($_POST['topic_icon']) ? 'checked="checked"' : '') ) . ' />' . $l['topic_icons_none'] . '&nbsp;&nbsp;&nbsp;';

                            echo '</td></tr>';


                            //If the user has some special Options
                            echo '<tr>
        <td width="18%" class="ntlc">' . $l['newtopic_options'] . '</td>
        <td class="ntrc">
        <table cellpadding="1" cellspacing="1">';

                            echo '<tr>
        <td>
        <input type="checkbox" name="usesmileys" ' . (isset($_POST['usesmileys']) ? 'checked="checked"' : ($globals['usesmileys'] ? 'checked="checked"' : '') ) . ' />
        </td>
        <td>
        ' . $l['options_enable_smileys'] . '</td>
        </tr>';

                            //If the user has permissions to sticky this topic
                            if ($user['can_make_sticky']) {
                                echo '<tr>
            <td>
            <input type="checkbox" name="makesticky" ' . (isset($_POST['makesticky']) ? 'checked="checked"' : '' ) . ' />
            </td>
            <td>
            ' . $l['options_sticky_topic'] . '</td>
            </tr>';
                            }

                            //If the user has permissions to LOCK this topic
                            if ($user['can_lock_own_topic']) {
                                echo '<tr>
            <td>
            <input type="checkbox" name="locktopic" ' . (isset($_POST['locktopic']) ? 'checked="checked"' : '' ) . ' />
            </td>
            <td>
            ' . $l['options_lock_topic'] . '</td>
            </tr>';
                            }

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

                            $notifytopic = ($logged_in ? ( $user['subscribeauto'] == 1 ? true : ($user['subscribeauto'] == 2 ? false : $globals['subscribeauto']) ) : $globals['subscribeauto']);

                            //If the user has permissions to NOTIFY Replies to this topic
                            if ($logged_in && $user['notify_new_posts']) {
                                echo '<tr>
            <td>
            <input type="checkbox" name="notifytopic" ' . (isset($_POST['notifytopic']) ? 'checked="checked"' : ($notifytopic ? 'checked="checked"' : '') ) . ' />
            </td>
            <td>
            ' . $l['options_notify_topic'] . '</td>
            </tr>';
                            }


                            //Can put a poll
                            if (($user['can_post_polls'] || $board['can_post_polls']) &&
                                    $board['allow_poll'] && $globals['enablepolls']) {
                                echo '<tr>
            <td>
            <input type="checkbox" name="postpoll" ' . (isset($_POST['postpoll']) ? 'checked="checked"' : '' ) . ' />
            </td>
            <td>
            ' . $l['options_post_poll'] . '</td>
            </tr>';
                            }


                            echo '</table>
        </td>
        </tr>';


                            //Check if he can attach files
                            if ($user['can_attach'] && $globals['allownewattachment']) {
                                echo '<tr>
            <td width="18%" class="ntlc">' . $l['newtopic_attachments'] . '</td>
            <td class="ntrc">';

                                for ($a = 1; $a <= $globals['maxattachmentpost']; $a++) {

                                    echo '<input name="attachments[]" type="file" size="45" /><br />';
                                }

                                echo '</td>
            </tr>';
                            }
                            ?>

                            <tr>
                                <td colspan="2" class="ntrc" style="text-align:center">
                                    <input type="submit" name="submittopic" value="<?php echo $l['newtopic_submit_button']; ?>"/>
                                    <input type="submit" name="previewtopic" value="<?php echo $l['newtopic_prewiew_button']; ?>"/>
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