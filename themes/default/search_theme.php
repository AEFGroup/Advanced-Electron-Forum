<?php

function search_theme() {

    global $theme, $user, $globals, $l, $error, $found, $mother_options;

    //The header
    aefheader($l['<title>']);

    error_handle($error);
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="<?php echo $globals['index_url'] . 'act=search&sact=results' ?>" method="get" name="search" >
        <br />
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0"><tr>
                            <td class="pcbgl"></td>
                            <td class="pcbg" align="left"><?php echo $l['search_heading']; ?><input type="hidden" name="act" value="search" /><input type="hidden" name="sact" value="results" /></td>
                            <td class="pcbgr"></td>		
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>

                    <table width="100%" cellpadding="4" cellspacing="1" class="cbgbor">

                        <tr>
                            <td class="ucpfcbg1" align="center" colspan="2">
                                <img src="<?php echo $theme['images']; ?>searchpm.png" />
                            </td>
                        </tr>

                        <tr>
                            <td class="slc" align="left" colspan="2">

                                <table width="100%" height="100%">
                                    <tr>
                                        <td rowspan="4" width="20%" valign="top"><b><?php echo $l['find_results']; ?> </b></td>
                                        <td width="30%"><?php echo $l['all_words']; ?></td>
                                        <td><input type="text" name="allwords" <?php echo 'value="' . ((isset($_POST['allwords'])) ? $_POST['allwords'] : '') . '"'; ?> size="40" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $l['exact_phrase']; ?></b></td>
                                        <td><input type="text" name="exactphrase" <?php echo 'value="' . ((isset($_POST['exactphrase'])) ? $_POST['exactphrase'] : '') . '"'; ?> size="40" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $l['atleast_one_word']; ?></td>
                                        <td><input type="text" name="atleastone" <?php echo 'value="' . ((isset($_POST['atleastone'])) ? $_POST['atleastone'] : '') . '"'; ?> size="40" /></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $l['without_words']; ?></td>
                                        <td><input type="text" name="without" <?php echo 'value="' . ((isset($_POST['without'])) ? $_POST['without'] : '') . '"'; ?> size="40" /></td>
                                    </tr>
                                </table>

                            </td>
                        </tr>

                        <tr>
                            <td class="slc" align="left" width="50%"><b><?php echo $l['search_within']; ?></b></td>
                            <td class="src"><input type="radio" name="within" value="1" <?php echo ((isset($_POST['within']) && trim($_POST['within']) == 1) ? 'checked="checked"' : (empty($_POST['within']) ? 'checked="checked"' : '') ); ?> /><?php echo $l['within_posts']; ?><br />
                                <input type="radio" name="within" value="2" <?php echo ((isset($_POST['within']) && trim($_POST['within']) == 2) ? 'checked="checked"' : ''); ?> /><?php echo $l['within_title']; ?></td> 
                        </tr>

                        <tr>
                            <td class="slc" align="left"><?php echo $l['posted_started_by']; ?></td>
                            <td class="src"><input type="text" name="starter" <?php echo 'value="' . ((isset($_POST['starter'])) ? $_POST['starter'] : '') . '"'; ?> size="35" /></td> 
                        </tr>

                        <tr>
                            <td class="slc" align="left"><b><?php echo $l['search_where']; ?></b> </td>
                            <td class="src">
                                <select name="forums[]" multiple="multiple" size="10" >
                                    <option value="0" selected="selected"><?php echo $l['all_forums']; ?></option>
                                    <?php
                                    foreach ($mother_options as $i => $iv) {

                                        echo '<option value="' . $mother_options[$i][0] . '">
	' . $mother_options[$i][1] . '
	</option>';
                                    }//End of for loop
                                    ?>
                                </select>
                            </td> 
                        </tr>

                        <tr>
                            <td class="slc" align="left"><b><?php echo $l['show_results_as']; ?></b></td>
                            <td class="src"><input type="radio" name="showas" value="1" <?php echo ((isset($_POST['showas']) && trim($_POST['showas']) == 1) ? 'checked="checked"' : (empty($_POST['showas']) ? 'checked="checked"' : '') ); ?> /><?php echo $l['show_topics']; ?><br />
                                <input type="radio" name="showas" value="2" <?php echo ((isset($_POST['showas']) && trim($_POST['showas']) == 2) ? 'checked="checked"' : ''); ?> /><?php echo $l['show_posts']; ?></td> 
                        </tr>

                        <tr>
                            <td class="src" colspan="5" align="center">
                                <input type="submit" name="search" value="<?php echo $l['submit_button']; ?>" />
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

    <?php
    //The defualt footers
    aeffooter();
}

function results_theme() {

    global $theme, $user, $globals, $l, $error, $found, $mother_options, $count, $showas, $fids_str;

    //The header
    aefheader($l['<title>']);

    error_handle($error);
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="get" name="search">

    </form>

    <script type="text/javascript">
        function gotopage(val){
            		
            gourl = '<?php echo $globals['index_url'] . 'act=search&sact=results&allwords=' . $_GET['allwords'] . '&exactphrase=' . (empty($_GET['exactphrase']) ? '' : $_GET['exactphrase']) . '&atleastone=' . (empty($_GET['atleastone']) ? '' : $_GET['atleastone']) . '&without=' . (empty($_GET['without']) ? '' : $_GET['without']) . '&starter=' . (empty($_GET['starter']) ? '' : $_GET['starter']) . '&within=' . $_GET['within'] . '&showas=' . $_GET['showas'] . '&forums=' . $fids_str . '&spg='; ?>';
            		
            //alert (gourl);
            		
            window.location = gourl+val;
            	
        }
    </SCRIPT>
    <?php
    echo '<div align="right"><select onchange="gotopage(this.value)" name="gotopage">';

    $num_pages = ceil($count / $globals['maxtopics']);

    for ($i = 1; $i <= $num_pages; $i++) {

        echo '<option value="' . $i . '" ' . ((isset($_GET['spg']) && trim($_GET['spg']) == $i ) ? 'selected="selected"' : '' ) . ' >' . $i . '</option>';
    }

    echo '</select></div><br /><br />';

    if ($showas == 1) {

        echo '<table width="100%" cellpadding="0" cellspacing="0">			
	<tr>
	<td>
	<table width="100%" cellpadding="0" cellspacing="0"><tr>
	<td class="tthl"></td>
	<td class="tthc" align="center">' . $l['results_heading'] . ' :</td>
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
	<td class="ttcbg" width="30%">' . $l['header_subject'] . '</td>
	<td class="ttcbg" width="15%" align="center">' . $l['header_forum'] . '</td>
	<td class="ttcbg" width="15%" align="center">' . $l['header_started_by'] . '</td>
	<td class="ttcbg" width="6%" align="center">' . $l['header_replies'] . '</td>
	<td class="ttcbg" width="5%" align="center">' . $l['header_views'] . '</td>
	<td class="ttcbg" width="22%">' . $l['header_last_post'] . '</td>
	</tr>';

        foreach ($found as $f => $fv) {

            echo '<tr>
	
	<td class="ttimg" width="5%" align="center">
	<img src="' . $theme['images'] . 'topics/' . $found[$f]['type'] . '.png" />
	</td>
	
	<td class="ttimg" align="center">
	' . ($found[$f]['type_image'] ? '<img src="' . $theme['images'] . 'icons/' . $globals['topic_icons'][$found[$f]['type_image']][0] . '" title="' . $globals['topic_icons'][$found[$f]['type_image']][1] . '" />' : '') . '
	</td>
	
	<td class="ttsub">
	' . ($found[$f]['has_attach'] ? '<img src="' . $theme['images'] . 'topics/attachment.png"  title="' . $l['topic_contains'] . ' ' . $found[$f]['has_attach'] . ' ' . $l['attachments'] . '" />' : '') . '
	' . (isset($found[$f]['t_prefix']) ? $found[$f]['t_prefix'] : '') . '
	<a href="' . $globals['index_url'] . 'tid=' . $found[$f]['tid'] . '">' . $found[$f]['topic'] . '</a>
	' . (!empty($found[$f]['t_description']) ? '<br />' . $found[$f]['t_description'] : '' ) . '
	' . (isset($found[$f]['pages']) ? '<br /><div style="float:right">( ' . $found[$f]['pages'] . ' )</div>' : '' ) . '
	</td>
	
	<td class="ttsub" align="center">
	<a href="' . $globals['index_url'] . 'fid=' . $found[$f]['fid'] . '">' . $found[$f]['fname'] . '</a>
	</td>		
	
	<td class="ttstar" align="center">
	' . (empty($found[$f]['starter']) ? $l['guest'] : '<a href="' . $globals['index_url'] . 'mid=' . $found[$f]['t_mem_id'] . '" title="' . $l['profile_of'] . ' ' . $found[$f]['starter'] . '">' . $found[$f]['starter'] . '</a>' ) . '		
	</td>
	
	<td class="ttrep" align="center">' . $found[$f]['n_posts'] . '</td>
	
	<td class="ttviews" align="center">' . $found[$f]['n_views'] . '</td>
	
	<td class="ttlpi">' . $found[$f]['ptime'] . '<br />
	' . $l['by'] . ' <a href="' . $globals['index_url'] . 'mid=' . $found[$f]['poster_id'] . '" title="' . $l['profile_of'] . ' ' . $found[$f]['username'] . '">' . $found[$f]['username'] . '</a>&nbsp;&nbsp;<a href="' . $globals['index_url'] . 'tid=' . $found[$f]['tid'] . '&tpg=' . $found[$f]['last_page'] . '#p' . $found[$f]['pid'] . '" title="' . $l['go_to_last_post'] . '"><img src="' . $theme['images'] . 'right.gif" /></a>
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
    } else {

        foreach ($found as $f => $fv) {

            echo'<br /><table width="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td>
	<table width="100%" cellpadding="0" cellspacing="0"><tr>
	<td class="pcbgl"></td>
	<td class="pcbg"><a href="' . $globals['index_url'] . 'tid=' . $found[$f]['tid'] . '">' . $found[$f]['topic'] . '</a>' . (empty($found[$f]['t_description']) ? '' : ',&nbsp;' . $found[$f]['t_description']) . '</td>
	<td class="pcbgr"></td>		
	</tr>
	</table>
	</td>
	</tr>
	
	<tr>
	<td>
	
	<table width="100%" cellpadding="1" cellspacing="0" class="cbgbor">
		
	<tr>
	<td class="posterbg" width="20%">
	' . (isset($found[$f]['is_guest']) ? '<b>' . $l['guest'] . '</b>' : '<a href="' . $globals['index_url'] . 'mid=' . $found[$f]['poster_id'] . '">' . $found[$f]['username'] . '</a>' ) . '
	</td>
	
	<td class="postdate" align="left">
	<a name="p' . $found[$f]['pid'] . '"></a>
	<img src="' . $theme['images'] . 'postedon.png" title="' . $l['posted_on'] . '">
	' . $found[$f]['ptime'] . '</td>
	</tr>';

            echo '<tr>
	<td class="post" colspan="2">
	' . $found[$f]['post'] . '
	</td>
	</tr>
	
	<tr>
	<td class="ptcbg1" colspan="2" align="left" style="padding:5px;">
	' . $l['prefix_forum'] . ': <a href="' . $globals['index_url'] . 'fid=' . $found[$f]['fid'] . '">' . $found[$f]['fname'] . '</a>
	&nbsp;&nbsp;' . $l['prefix_replies'] . ': ' . $found[$f]['n_posts'] . '&nbsp;&nbsp;Views: ' . $found[$f]['n_views'] . '
	</td>
	</tr>';

            echo '</table>
	</td>
	</tr>
	
	<tr>
	<td><img src="' . $theme['images'] . 'cbot.png" width="100%" height="10"></td>
	</tr>
	</table>';
        }
    }

    echo '<br /><div align="right"><select onchange="gotopage(this.value)" name="gotopage">';

    $num_pages = ceil($count / $globals['maxtopics']);

    for ($i = 1; $i <= $num_pages; $i++) {

        echo '<option value="' . $i . '" ' . ((isset($_GET['spg']) && trim($_GET['spg']) == $i ) ? 'selected="selected"' : '' ) . ' >' . $i . '</option>';
    }

    echo '</select></div>';

    //The defualt footers
    aeffooter();
}
?>