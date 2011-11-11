<?php

function MainIndex_theme() {

    global $user, $logged_in, $globals, $AEF_SESS, $theme, $l;
    global $categories, $forums, $active, $anonymous, $guests, $mostactive, $mostactive_ever, $inboards, $latest_mem, $active, $activebots, $pm, $onload, $dmenus, $online_today, $recent_posts, $user_groups;

	//Link array of active users
    $activeusers = array();

    //Build the active users array
    foreach ($active as $i => $v) {

        $activeusers[] = '<a href="' . userlink($active[$i]['id'], $active[$i]['username']) . '" style="color: ' . $active[$i]['mem_gr_colour'] . ';" >' . $active[$i]['username'] . '</a>';
    }

    //Are there any Bots
    foreach ($activebots as $k => $v) {

        $activeusers[] = $v;
    }

    //Online Today
    if (!empty($online_today)) {

        $users_today = array();

        foreach ($online_today as $k => $v) {

            $users_today[] = '<a href="' . userlink($online_today[$k]['id'], $online_today[$k]['username']) . '" style="color: ' . $online_today[$k]['mem_gr_colour'] . ';" >' . $online_today[$k]['username'] . '</a>';
        }
    }

    if (!empty($user_groups)) {

        foreach ($user_groups as $k => $v) {

            $user_groups[$k] = '<a href="' . $globals['ind'] . 'act=members&amp;group=' . $k . '" style="color: ' . $user_groups[$k]['mem_gr_colour'] . ';" >' . $user_groups[$k]['mem_gr_name'] . '</a>';
        }
    }
	//The Statistics Center
    $stats_panel = '<div class="division">
		<div align="center" class="topbar">
			<h3>' . $l['statistics'] . '</h3>
		</div>';

    if (!empty($recent_posts)) {
        $stats_panel .= '
        <div class="secondbar"><img src="' . $theme['images'] . 'postedon.png" alt="" />' . $l['recent_posts'] . '</div>
		<div class="mifor" style="font-size:12px">';
        foreach ($recent_posts as $recentIndex => $recentPost) {
            $stats_panel .= '(' . $recentPost['pdate'] . ') <b><a href="' . topiclink($recentPost['tid'], $recentPost['topic'], $recentPost['last_page']) . '#p' . $recentPost['pid'] . '">' . $recentPost['topic'] . '</a></b> ' . $l['by'] . ' <a style="color:' . $recentPost['mem_gr_colour'] . '" href="' . userlink($recentPost['id'], $recentPost['username']) . '">' . $recentPost['username'] . '</a>   (<a href="' . forumlink($recentPost['fid'], $recentPost['fname']) . '">' . $recentPost['fname'] . '</a>)<br/>';
        }
        $stats_panel .= '</div>';
    }
    $stats_panel .= '<div class="secondbar">
			' . ($user['view_active'] ? '<a href="' . $globals['ind'] . 'act=active"><img src="' . $theme['images'] . 'onlineusers.png" alt="" />' . $l['active_users'] . '</a>' : $l['active_users'] ) . '
		  </div>

		<div class="mifor">
			' . ($guests + count($active) + (empty($anonymous) ? 0 : $anonymous)) . ' ' . $l['online_users'] . ' ' . $l['in_the_past'] . ' ' . $globals['last_active_span'] . ' ' . $l['minutes'] . ' (' . $guests . ' ' . $l['online_guests'] . ', ' . count($active) . ' ' . $l['online_members'] . (($anonymous) ? ', ' . $anonymous . ' ' . $l['online_anonymous'] : '' ) . ')' .
				(!empty($activeusers) ? '<br/>' . implode(', ', $activeusers) : '') . '
			<br/>
			' . $l['most_online_today'] . ' <b>' . $mostactive . '</b>. ' . $l['most_online_ever'] . ' <b>' . $mostactive_ever[0] . '</b> ' . $l['on'] . ' <b>' . datify($mostactive_ever[1]) . '</b>
		</div>';
    if (!empty($online_today)) {
        $stats_panel .= '<div>
				<div colspan="2" class="cbg1" align="left">' . $l['users_online_today'] . ' : ' . count($users_today) . '</div>
			</div>
			<div>
				<div align="center" class="miposts" width="5%">
					<img src="' . $theme['images'] . 'onlineusers.png" alt="" />
				</div>
				<div class="mifor">' . implode(', ', $users_today) . '</div>
			</div>';
    }
    if ($user['view_members']) {
        $stats_panel .= '
			<div class="secondbar"><img src="' . $theme['images'] . 'online.gif" alt="" />' . $l['all_members'] . '</div>
			<div class="mifor"><b><a href="' . $globals['ind'] . 'act=members">' . $l['members'] . '</a></b><br/>
				' . $l['list_of_members'] .
				(!empty($user_groups) ? '<hr />' . $l['user_groups'] . ' : ' . implode(', ', $user_groups) : '') . '
			</div>';
    }

    $stats_panel .= '
			<div class="secondbar"><img src="' . $theme['images'] . 'stats.gif" alt="" />' . $l['board_stats'] . '</div>
			<div>
				<div class="mifor">
					' . $l['total_posts'] . ' <b>' . $globals['tot_posts'] . '</b><br/>
					' . $l['total_topics'] . ' <b>' . $globals['tot_topics'] . '</b><br/>
					' . $l['registered_members'] . ' <b>' . $globals['num_mem'] . '</b><br/>
					' . $l['welcome_new_member'] . ', <b><a href="' . userlink($latest_mem[1], $latest_mem[0]) . '" >' . $latest_mem[0] . '</a></b>
				</div>
			</div></div>';
			
    //The header
    aefheader('', $stats_panel);

    //The main loop of the categories
    foreach ($categories as $c => $cv) {
        if (isset($forums[$c])) {
            if (!empty($categories[$c]['collapsable'])) {
                $js_cat[] = 'cat' . $categories[$c]['cid'];
            }
            //Echo the link and the Category Name
            echo '
            <div class="division">
				<div class="topbar">
					<h3><a href="' . $globals['ind'] . '#cid' . $categories[$c]['cid'] . '" name="cid' . $categories[$c]['cid'] . '" style="text-decoration: none;padding: 10px 10px 0 10px;">' . $categories[$c]['name'] . '</a></h3>
				</div>';
				//The main forum loop of a category
				foreach ($forums[$c] as $f => $v) {
					echo '
					<div class="forums_div">
						<div class="mifor">
							<div class="miforinfo">
								<font class="forlink">';
									if($forums[$c][$f]['fimage']){
										echo '<img src="' . $forums[$c][$f]['fimage'] .'" alt="" />';
									}
									echo '<a href="' . (($forums[$c][$f]['fredirect']) ? $forums[$c][$f]['fredirect'] : forumlink($v['fid'], $v['fname']) ) . '">' . $forums[$c][$f]['fname'] . '</a>';
										if(!$forums[$c][$f]['is_read']){
											echo 'NEW' ;
										}	
								echo '
								</font>
								<font class="desc">
									' . $forums[$c][$f]['description'] . '&nbsp;
								</font>'.$l['heading_topics'].' : '.$forums[$c][$f]['ft_topic'].' & '.$l['heading_posts'].' : '.$forums[$c][$f]['ft_posts'].'';
								//Make the moderators array if there are any
								if (isset($forums[$c][$f]['moderators'])) {
									$boardmoderators[$f] = array();
									foreach ($forums[$c][$f]['moderators'] as $mk => $mv) {
										$boardmoderators[$f][] = $forums[$c][$f]['moderators'][$mk]['username'];
									}
									echo '<img src="' . $theme['images'] . 'onlineusers.png" alt="' . $l['forum_moderators'] .' '. implode(' , ', $boardmoderators[$f]) . '" /> ';
								}
								//Make the In Board array if there are any
								if (isset($forums[$c][$f]['in_boards'])) {
									$inboards[$f] = array();
									foreach ($forums[$c][$f]['in_boards'] as $ik => $iv) {
										$inboards[$f][] = (!empty($iv['is_read']) ? '' : '<b>') . '<a href="' . forumlink($iv['fid'], $iv['fname']) . '">' . $forums[$c][$f]['in_boards'][$ik]['fname'] . '</a>' . (!empty($iv['is_read']) ? '' : '</b>');
									}
									echo '<font class="inbtxt">' . $l['forum_in_boards'] . '</font>';
									echo implode(' , ', $inboards[$f]) . '';
								}
						echo '</div>
						<div class="milp">';
						if (empty($forums[$c][$f]['tid'])) {
							echo $l['no_last_post'];
						} else {
							echo '&nbsp;' . $forums[$c][$f]['pdate'] . '<br/>' .
							$l['in'] . ' <a href="' . topiclink($v['tid'], $v['topic']) . '" title="' . $l['go_to_first_post'] . '">' . $forums[$c][$f]['topic'] . '</a>&nbsp;&nbsp;&nbsp;<a href="' . topiclink($v['tid'], $v['topic'], $v['last_page']) . '#p' . $forums[$c][$f]['pid'] . '" title="' . $l['go_to_last_post'] . '"><img src="' . $theme['images'] . 'right.gif" alt="" /></a><br/>' .
							$l['by'] . ' ' . (empty($forums[$c][$f]['username']) ? (empty($forums[$c][$f]['gposter_name']) ? $l['guest'] : $forums[$c][$f]['gposter_name']) : '<a href="' . userlink($v['poster_id'], $v['username']) . '">' . $forums[$c][$f]['username'] . '</a>');
						}
						echo '</div>
						<div style="clear:both;"></div>
					</div>
				</div>';
				}//end the forums loop
		echo '</div>';
        }//End of IF
    }//End of categories Loop

    echo '<script language="javascript" src="' . $theme['url'] . '/js/slider.js" type="text/javascript"></script>';

    if (!empty($js_cat)) {

        echo '<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
        slider = new slider();
        slider.elements = new Array(\'' . implode('\', \'', $js_cat) . '\');
        addonload(\'slider.init();\');
        // ]]></script>';
    }

	//The row before the Statistics
    echo '<div align="right">' . ($logged_in ? '<a href="' . $globals['ind'] . 'act=markread&amp;mark=board">' . $l['mark_board_read'] . '</a>' : '') . '</div>';


	

    //Do you have an new PM then pop up
    if (!empty($pm)) {
        echo '
        <div id="newpm" style="left:275px;top:200px;position:absolute;width:250px;">
			<div id="newpm_h">
				<div class="dwhl"></div>
				<div align="left" class="dwhc">
					<b>' . $l['new_pm'] . '</b>
				</div>
				<div align="right" class="dwhc">
					<a href="javascript:hideel(\'newpm\')"><img src="' . $theme['images'] . 'close.gif" alt="" /></a>
				</div>
				<div class="dwhr"></div>
			</div>
		</div>
		<div class="dwbody">
			<div style="border-bottom:solid 1px #CCCCCC;">' . $l['pm_subject'] . ' <a href="' . $globals['ind'] . 'act=usercp&amp;ucpact=showpm&amp;pmid=' . $pm['pmid'] . '">' . $pm['pm_subject'] . '</a>
			<div style="border-bottom:solid 1px #CCCCCC;" align="right">
				' . $l['pm_sender'] . ' <a href="' . userlink($pm['id'], $pm['sender']) . '">' . $pm['sender'] . '</a>
			</div>
		</div>
		<div colspan="2">' . $pm['pm_body'] . '</div>
		<div align="left" class="dwb" colspan="2"></div>
		<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
			Drag.init($("newpm_h"), $("newpm"));
		// ]]></script>';
    }

//The defualt footers
    aeffooter();
}
