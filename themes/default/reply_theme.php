<?php

function reply_theme() {

    global $fid, $title, $topic, $theme, $globals, $logged_in, $l, $postcodefield, $error, $user, $smileys, $smileycode, $smileyimages, $smileyurl, $board, $i_started, $dmenus, $quotetxt, $qpid, $last_posts, $preview;

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
            editor.textarea_id = 'reply';
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
	
	<a href="' . (!$logged_in ? 'mailto:' . $preview['gposter_email'] : $globals['index_url'] . 'mid=' . $user['id']) . '">
	' . $preview['username'] . '
	</a>
	</td>
	
	<td class="postdate" align="right">
	<div style="float:left">
	<img src="' . $theme['images'] . 'postedon.png" title="' . $l['posted_on'] . '">
	' . $preview['pdate'] . ' | ' . $l['post_num_prefix'] . ': ' . $preview['post_count'] .
        '</div>
	</td>
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

        <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="postform" enctype="multipart/form-data" onsubmit="editor.onsubmit();">
            <br />
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0"><tr>
                                <td class="pcbgl"></td>
                                <td class="pcbg" align="left"><?php echo $l['reply_heading'] . ' ' . $title; ?></td>
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
		<td width="18%" class="rlc">' . $l['your_name'] . '</td>
		<td class="rrc"><input type="text" size="40" maxlength="50" name="gposter_name" ' . ( (isset($_POST['gposter_name'])) ? 'value="' . $_POST['gposter_name'] . '"' : '' ) . ' /></td>
		</tr>';

                                //When guests are allowed their email
                                echo '<tr>
		<td width="18%" class="rlc">' . $l['your_email'] . '</td>
		<td class="rrc"><input type="text" size="40" maxlength="50" name="gposter_email" ' . ( (isset($_POST['gposter_email'])) ? 'value="' . $_POST['gposter_email'] . '"' : '' ) . ' /></td>
		</tr>';
                            }
                            ?>


                            <tr>
                                <td width="18%" class="rlc"><?php echo $l['reply_title']; ?></td>
                                <td class="rrc">
                                    <input type="text" size="45" maxlength="50" name="posttitle" <?php echo ( (isset($_POST['posttitle'])) ? 'value="' . $_POST['posttitle'] . '"' : 'value="' . $title . '"' ); ?> /></td>
                            </tr>	

                            <tr>
                                <td width="18%" class="rlc"><?php echo $l['reply_text_formatting']; ?></td>
                                <td class="rrc">
                                    <?php editor_buttons('editor'); ?>
                                </td>
                            </tr>

                            <?php editor_smileys('editor', $globals['usesmileys']); ?>

                            <tr>
                                <td width="18%" class="rlc"><?php echo $l['reply_post']; ?></td>
                                <td class="rrc"><textarea name="post" rows="13" cols="85" onchange="storeCaret(this);" onkeyup="storeCaret(this);" onclick="storeCaret(this);" onselect="storeCaret(this);" id="reply" /><?php echo ( (isset($_POST['post'])) ? $_POST['post'] : (empty($quotetxt) ? '' : $quotetxt) ); ?></textarea>
                                    <?php echo $postcodefield; /* The most important thing */ ?>
                                </td>
                            </tr>

                            <?php
                            //If the user has some special Options
                            echo '<tr>
		<td width="18%" class="rlc">' . $l['reply_options'] . '</td>
		<td class="rrc">
		<table cellpadding="1" cellspacing="1">
		';

                            echo '<tr>
		<td>
		<input type="checkbox" name="usesmileys" ' . (isset($_POST['usesmileys']) ? 'checked="checked"' : ($globals['usesmileys'] ? 'checked="checked"' : '') ) . ' />
		</td>
		<td>' . $l['options_enable_smileys'] . '</td>
		</tr>';

                            //If the user has permissions to sticky this topic
                            if ($user['can_make_sticky']) {
                                echo '<tr>
			<td>
			<input type="checkbox" name="makesticky" ' . (isset($_POST['makesticky']) ? 'checked="checked"' : '' ) . ' />
			</td>
			<td>' . $l['options_sticky_topic'] . '</td>
			</tr>';
                            }

                            //If the user has permissions to LOCK this topic
                            if (($i_started && $user['can_lock_own_topic']) ||
                                    (!$i_started && $user['can_lock_other_topic'])) {
                                echo '<tr>
			<td>
			<input type="checkbox" name="locktopic" ' . (isset($_POST['locktopic']) ? 'checked="checked"' : '' ) . ' />
			</td>
			<td>' . $l['options_lock_topic'] . '</td>
			</tr>';
                            }

                            //If the user has permissions to ANNOUNCE this topic
                            if ($user['can_announce_topic']) {
                                echo '<tr>
			<td>
			<input type="checkbox" name="announcetopic" ' . (isset($_POST['announcetopic']) ? 'checked="checked"' : '' ) . ' />
			</td>
			<td>' . $l['options_announce_topic'] . '</td>
			</tr>';
                            }

                            $notifytopic = ($logged_in ? ( $user['subscribeauto'] == 1 ? true : ($user['subscribeauto'] == 2 ? false : $globals['subscribeauto']) ) : $globals['subscribeauto']);

                            //If the user has permissions to NOTIFY Replies to this topic
                            if ($logged_in && $user['notify_new_posts']) {
                                echo '<tr>
			<td>
			<input type="checkbox" name="notifytopic" ' . (isset($_POST['notifytopic']) ? 'checked="checked"' : ($notifytopic ? 'checked="checked"' : '') ) . ' />
			</td>
			<td>' . $l['options_notify_topic'] . '</td>
			</tr>';
                            }


                            //If the user has permissions to ANNOUNCE this topic
                            if ($globals['enablepolls'] && $board['allow_poll'] && empty($topic['poll_id'])) {

                                if (($i_started && $user['add_poll_topic_own']) ||
                                        (!$i_started && $user['add_poll_topic_other'])) {

                                    echo '<tr>
			<td>
			<input type="checkbox" name="addpoll" ' . (isset($_POST['addpoll']) ? 'checked="checked"' : '' ) . ' />
			</td>
			<td>' . $l['options_add_poll'] . '</td>
			</tr>';
                                }
                            }


                            echo '</table>
		</td>
		</tr>';


                            //Check if he can attach files
                            if (($user['can_attach'] || $board['can_attach']) && $globals['allownewattachment']) {
                                echo '<tr>
			<td width="18%" class="rlc">' . $l['reply_attachments'] . '</td>			
			<td class="rrc">';

                                for ($a = 1; $a <= $globals['maxattachmentpost']; $a++) {

                                    echo '<input name="attachments[]" type="file" size="45" /><br />';
                                }

                                echo '</td>
			</tr>';
                            }
                            ?>

                            <tr>
                                <td colspan="2" class="rrc" style="text-align:center">

                                    <input type="hidden" name="par_id" value="<?php echo $qpid; ?>" />
                                    <input type="submit" name="submitpost" value="<?php echo $l['reply_submit_button']; ?>"/>
                                    <input type="submit" name="previewpost" value="<?php echo $l['reply_prewiew_button']; ?>"/>
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
    if (!empty($last_posts)) {

        echo '<br /><br /><table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td>
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td class="pcbgl"></td>
			<td class="pcbg" align="left">' . $l['last_posts'] . '</td>
			<td class="pcbgr"></td>		
		</tr>
	</table>
</td>
</tr>';

        foreach ($last_posts as $pk => $pv) {

            echo '<tr>
<td>

<table width="100%" cellpadding="1" cellspacing="1" class="cbgbor">
	<tr>
		<td class="posterbg" width="22%">
			' . (empty($pv['username']) ? $l['guest'] : $pv['username']) . '
		</td>		
		<td class="postdate">
			<img src="' . $theme['images'] . 'postedon.png" title="' . $l['posted_on'] . '">
			' . $pv['pdate'] . '
			' . (($pv['post_count']) ? ' | ' . $l['post_num_prefix'] . ': ' . $pv['post_count'] : '') . '
		</td>	
	</tr>
	
	<tr>
		<td class="post" align="left" valign="top" colspan="2">
			' . $pv['post'] . '
		</td>	
	</tr>
</table>

</td>
</tr>';
        }

        echo '<tr>
<td><img src="' . $theme['images'] . 'cbot.png" width="100%" height="10"></td>
</tr>
</table>';
    }//End of if of Last Posts

    aeffooter(); //footers that have to be there.
}
?>
