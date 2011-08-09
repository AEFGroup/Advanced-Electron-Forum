<?php

function unread_theme() {

    global $user, $logged_in, $globals, $AEF_SESS, $theme, $l;
    global $unread, $count;

    //The header
    aefheader($l['<title>']);
    ?>
    <script type="text/javascript">
        function gotopage(val){
                    		
            gourl = '<?php echo $globals['index_url']; ?>act=unread&uppg='
                    		
            //alert (gourl+val);
                    		
            window.location = gourl+val;
                    	
        }
    </SCRIPT>
    <?php
    echo '<div align="right"><select onchange="gotopage(this.value)" name="gotopage">';

    $num_pages = ceil($count / $globals['maxtopics']);

    for ($i = 1; $i <= $num_pages; $i++) {

        echo '<option value="' . $i . '" ' . ((isset($_GET['uppg']) && trim($_GET['uppg']) == $i ) ? 'selected="selected"' : '' ) . ' >' . $i . '</option>';
    }

    echo '</select></div><br /><br />';

    //The first row that is Headers
    echo'<table width="100%" cellpadding="0" cellspacing="0">			
	<tr>
	<td>
	<table width="100%" cellpadding="0" cellspacing="0"><tr>
	<td class="tthl"></td>
	<td class="tthc" align="center"><b>' . $l['unread_heading'] . '</b></td>
	<td class="tthr"></td>		
	</tr>
	</table>
	</td>
	</tr>
	
	<tr>
	<td width="100%">
	
	<table width="100%" class="cbgbor" cellpadding="1" cellspacing="1">	
	<tr>
	<td class="ttcbg" colspan="2"></td>
	<td class="ttcbg" width="40%">' . $l['header_subject'] . '</td>
	<td class="ttcbg" width="15%" align="center">' . $l['header_started_by'] . '</td>
	<td class="ttcbg" width="7%" align="center">' . $l['header_replies'] . '</td>
	<td class="ttcbg" width="7%" align="center">' . $l['header_views'] . '</td>
	<td class="ttcbg" width="22%">' . $l['header_last_post_info'] . '</td>
	</tr>';

    if (!empty($unread)) {

        foreach ($unread as $u => $uv) {

            echo '<tr>
		
		<td class="ttimg" width="5%" align="center">
		<img src="' . $theme['images'] . 'topics/' . $unread[$u]['type'] . '.png" />
		</td>
		
		<td class="ttimg" align="center">
		' . ($unread[$u]['type_image'] ? '<img src="' . $theme['images'] . 'icons/' . $globals['topic_icons'][$unread[$u]['type_image']][0] . '" title="' . $globals['topic_icons'][$unread[$u]['type_image']][1] . '" />' : '') . '
		</td>
		
		<td class="ttsub">
		' . ($unread[$u]['is_new'] ? '<img src="' . $theme['images'] . 'topics/new.png"  title="' . $l['new_posts'] . '" />' : '') . '
		' . ($unread[$u]['has_attach'] ? '<img src="' . $theme['images'] . 'topics/attachment.png"  title="' . $l['topic_contains'] . ' ' . $unread[$u]['has_attach'] . ' ' . $l['attachments'] . '" />' : '') . '
		' . (isset($unread[$u]['t_prefix']) ? $unread[$u]['t_prefix'] : '') . '
		<a href="' . $globals['index_url'] . 'tid=' . $unread[$u]['tid'] . '">' . $unread[$u]['topic'] . '</a>
		' . (!empty($unread[$u]['t_description']) ? '<br />' . $unread[$u]['t_description'] : '' ) . '
		' . (isset($unread[$u]['pages']) ? '<br /><div style="float:right">( ' . $unread[$u]['pages'] . ' )</div>' : '' ) . '<br />
		' . $l['in'] . ' <a href="' . $globals['index_url'] . 'fid=' . $unread[$u]['fid'] . '">' . $unread[$u]['fname'] . '</a>
		</td>
		
		<td class="ttstar" align="center">
		' . (empty($unread[$u]['starter']) ? $l['guest'] : '<a href="' . $globals['index_url'] . 'mid=' . $unread[$u]['t_mem_id'] . '" title="' . $l['profile_of'] . ' ' . $unread[$u]['starter'] . '">' . $unread[$u]['starter'] . '</a>' ) . '		
		</td>
		
		<td class="ttrep" align="center">' . $unread[$u]['n_posts'] . '</td>
		
		<td class="ttviews" align="center">' . $unread[$u]['n_views'] . '</td>
		
		<td class="ttlpi">' . $unread[$u]['ptime'] . '<br />
	' . $l['by'] . ' <a href="' . $globals['index_url'] . 'mid=' . $unread[$u]['poster_id'] . '" title="' . $l['profile_of'] . ' ' . $unread[$u]['username'] . '">' . $unread[$u]['username'] . '</a>&nbsp;&nbsp;<a href="' . $globals['index_url'] . 'tid=' . $unread[$u]['tid'] . '&tpg=' . $unread[$u]['last_page'] . '#p' . $unread[$u]['pid'] . '" title="' . $l['go_to_last_post'] . '"><img src="' . $theme['images'] . 'right.gif" /></a>
		</td>	
		</tr>';
        }
    } else {

        echo '<tr>
			<td colspan="7" align="center">
			<br /><b>' . $l['no_topics'] . '</b><br /><br />
			</td>
			</tr>';
    }

    echo '</table>
	</td>			
	</tr>
	<tr>
	<td><img src="' . $theme['images'] . 'cbot.png" width="100%" height="15"></td>
	</tr>
	
	</table>
	<br />';

    echo '<br /><br /><div align="right"><select onchange="gotopage(this.value)" name="gotopage">';

    $num_pages = ceil($count / $globals['maxtopics']);

    for ($i = 1; $i <= $num_pages; $i++) {

        echo '<option value="' . $i . '" ' . ((isset($_GET['uppg']) && trim($_GET['uppg']) == $i ) ? 'selected="selected"' : '' ) . ' >' . $i . '</option>';
    }

    echo '</select></div>';

    echo '<br /><br /><br />
	<table border="0" width="100%" cellspacing="1" cellpadding="4" class="cbor">
		
		<tr>
		<td class="miposts" width="50%">
		
		<table border="0" width="100%" cellspacing="1" cellpadding="2" >
		
		<tr>		
		<td align="left" width="50%">
		<img src="' . $theme['images'] . 'topics/00.png" />&nbsp;&nbsp;' . $l['normal_topic'] . '
		</td>
		<td align="left" width="50%">
		<img src="' . $theme['images'] . 'topics/closed.png" />&nbsp;&nbsp;' . $l['closed_topic'] . '
		</td>
		</tr>
		
		<tr>		
		<td align="left">
		<img src="' . $theme['images'] . 'topics/10.png" />&nbsp;&nbsp;' . $l['hot_topic'] . '
		</td>
		<td align="left">
		<img src="' . $theme['images'] . 'topics/pinned.png" />&nbsp;&nbsp;' . $l['pinned_topic'] . '
		</td>
		</tr>
		
		<tr>		
		<td align="left">
		<img src="' . $theme['images'] . 'topics/01.png" />&nbsp;&nbsp;' . $l['poll_topic'] . '
		</td>
		<td align="left">
		<img src="' . $theme['images'] . 'topics/moved.png" />&nbsp;&nbsp;' . $l['moved_topic'] . '
		</td>
		</tr>
		
		</table>
		
		</td>
		<td class="mifor">
		' . ($logged_in ? '<a href="' . $globals['index_url'] . 'act=markread&mark=board">' . $l['mark_all_read'] . '</a>' : '');

    echo navigator() . '
		</td>
		</tr>
				
		</table>';


    //The defualt footers
    aeffooter();
}
?>
