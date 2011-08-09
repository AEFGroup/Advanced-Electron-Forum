<?php

function topicsub_theme() {

    global $user, $logged_in, $globals, $l, $theme;
    global $subscriptions, $count;

    //The global User CP Headers
    usercphead($l['subsc_topic_subscriptions']);
    ?>
    <script type="text/javascript">
        function gotopage(val){
                    		
            gourl = '<?php echo $globals['index_url']; ?>act=usercp&ucpact=topicsub&tsubpg='
                    		
            //alert (gourl+val);
                    		
            window.location = gourl+val;
                    	
        }
    </SCRIPT>
    <?php
    echo '<select onchange="gotopage(this.value)" name="gotopage" align="right">';

    $num_pages = ceil($count / $globals['numsubinpage']);

    for ($i = 1; $i <= (empty($num_pages) ? 1 : $num_pages); $i++) {

        echo '<option value="' . $i . '" ' . ((isset($_GET['tsubpg']) && trim($_GET['tsubpg']) == $i ) ? 'selected="selected"' : '' ) . ' >' . $i . '</option>';
    }

    echo '</select><br /><br />';

    echo '<form accept-charset="' . $globals['charset'] . '" method="post" action="" name="tsubform">
	
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td>
	<table width="100%" cellpadding="0" cellspacing="0"><tr>
	<td class="ucpcbgl"></td>
	<td class="ucpcbg">' . $l['subsc_topic_subscription'] . '</td>
	<td class="ucpcbgr"></td>		
	</tr>
	</table>
	</td>
	</tr>
	
	<tr>
	<td class="cbgbor">
	
	<table width="100%" cellpadding="2" cellspacing="1">
	<tr>
	<td class="ucpfcbg1" colspan="2" align="center">
	<img src="' . $theme['images'] . 'usercp/topicnotifications.gif" />
	</td>
	</tr>
	<tr>
	<td class="ucpcbg1" align="left" width="5%">
	<input type=checkbox onClick="check(document.getElementsByName(\'list[]\'), this)" value="0">
	</td>
	<td class="ucpcbg1" align="left">
	' . $l['subsc_subject'] . '
	</td>
	</tr>';

    //Check do we have some PM's or no
    if (!empty($subscriptions)) {

        foreach ($subscriptions as $sk => $sv) {

            echo '<tr>
			<td class="pmfwbg" align="left">
			<input type=checkbox name="list[]" value="' . $sv['notify_tid'] . '">
			</td>
			<td class="pmfwbg" align="left">
			<a href="' . $globals['index_url'] . 'tid=' . $sv['notify_tid'] . '">' . $sv['topic'] . '</a>
			</td>
			</tr>';
        }

        echo '<tr>
			<td class="pmfwbg" align="left" colspan="5">
			<input type="submit" name="unsubseltsub" value="' . $l['subsc_unsubscribe_selected'] . '">
			</td>
			</tr>';
    } else {

        echo '<td class="pmfwbg" align="center" colspan="3">
			' . $l['subsc_no_subscribed_topic'] . '
			</td>';
    }

    echo '</table>
	</td>
	</tr>
	
	<tr>
	<td><img src="' . $theme['images'] . 'cbotsmall.png" width="100%" height="10"></td>
	</tr>
	</table>
	</form>';

    echo '<br /><br /><select onchange="gotopage(this.value)" name="gotopage" align="right">';

    $num_pages = ceil($count / $globals['numsubinpage']);

    for ($i = 1; $i <= (empty($num_pages) ? 1 : $num_pages); $i++) {

        echo '<option value="' . $i . '" ' . ((isset($_GET['tsubpg']) && trim($_GET['tsubpg']) == $i ) ? 'selected="selected"' : '' ) . ' >' . $i . '</option>';
    }

    echo '</select>';

    //The global User CP Footers
    usercpfoot();
}

function forumsub_theme() {

    global $user, $logged_in, $globals, $l, $theme;
    global $subscriptions, $count;

    //The global User CP Headers
    usercphead($l['subsc_forum_subscriptions']);
    ?>
    <script type="text/javascript">
        function gotopage(val){
                    		
            gourl = '<?php echo $globals['index_url']; ?>act=usercp&ucpact=forumsub&fsubpg='
                    		
            //alert (gourl+val);
                    		
            window.location = gourl+val;
                    	
        }
    </SCRIPT>
    <?php
    echo '<select onchange="gotopage(this.value)" name="gotopage" align="right">';

    $num_pages = ceil($count / $globals['numsubinpage']);

    for ($i = 1; $i <= (empty($num_pages) ? 1 : $num_pages); $i++) {

        echo '<option value="' . $i . '" ' . ((isset($_GET['fsubpg']) && trim($_GET['fsubpg']) == $i ) ? 'selected="selected"' : '' ) . ' >' . $i . '</option>';
    }

    echo '</select><br /><br />';

    echo '<form accept-charset="' . $globals['charset'] . '" method="post" action="" name="fsubform">
	
	<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
	<td>
	<table width="100%" cellpadding="0" cellspacing="0"><tr>
	<td class="ucpcbgl"></td>
	<td class="ucpcbg">' . $l['subsc_forum_subscriptions'] . '</td>
	<td class="ucpcbgr"></td>		
	</tr>
	</table>
	</td>
	</tr>
	
	<tr>
	<td class="cbgbor">
	
	<table width="100%" cellpadding="2" cellspacing="1">
	<tr>
	<td class="ucpfcbg1" colspan="2" align="center">
	<img src="' . $theme['images'] . 'usercp/forumnotifications.gif" />
	</td>
	</tr>
	<tr>
	<td class="ucpcbg1" align="left" width="5%">
	<input type=checkbox onClick="check(document.getElementsByName(\'list[]\'), this)" value="0">
	</td>
	<td class="ucpcbg1" align="left">
	Forums
	</td>
	</tr>';

    //Check do we have some PM's or no
    if (!empty($subscriptions)) {

        foreach ($subscriptions as $sk => $sv) {

            echo '<tr>
			<td class="pmfwbg" align="left">
			<input type=checkbox name="list[]" value="' . $sv['notify_fid'] . '">
			</td>
			<td class="pmfwbg" align="left">
			<a href="' . $globals['index_url'] . 'fid=' . $sv['notify_fid'] . '">' . $sv['fname'] . '</a>
			</td>
			</tr>';
        }

        echo '<tr>
			<td class="pmfwbg" align="left" colspan="5">
			<input type="submit" name="unsubselfsub" value="' . $l['subsc_unsubscribe_selected'] . '">
			</td>
			</tr>';
    } else {

        echo '<td class="pmfwbg" align="center" colspan="3">
			' . $l['subsc_no_subscribed_forum'] . '
			</td>';
    }

    echo '</table>
	</td>
	</tr>
	
	<tr>
	<td><img src="' . $theme['images'] . 'cbotsmall.png" width="100%" height="10"></td>
	</tr>
	</table>
	</form>';

    echo '<br /><br /><select onchange="gotopage(this.value)" name="gotopage" align="right">';

    $num_pages = ceil($count / $globals['numsubinpage']);

    for ($i = 1; $i <= (empty($num_pages) ? 1 : $num_pages); $i++) {

        echo '<option value="' . $i . '" ' . ((isset($_GET['fsubpg']) && trim($_GET['fsubpg']) == $i ) ? 'selected="selected"' : '' ) . ' >' . $i . '</option>';
    }

    echo '</select>';

    //The global User CP Footers
    usercpfoot();
}
?>