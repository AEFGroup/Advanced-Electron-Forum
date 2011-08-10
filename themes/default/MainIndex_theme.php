<?php

function MainIndex_theme() {

    global $user, $logged_in, $globals, $AEF_SESS, $theme, $l;
    global $categories, $forums, $active, $anonymous, $guests, $mostactive, $mostactive_ever, $inboards, $latest_mem, $active, $activebots, $pm, $onload, $dmenus, $online_today, $recent_posts, $user_groups;

    //The header
    aefheader();

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

    //The main loop of the categories
    foreach ($categories as $c => $cv) {

        if (isset($forums[$c])) {

            if (!empty($categories[$c]['collapsable'])) {

                $js_cat[] = 'cat' . $categories[$c]['cid'];
            }

            //Echo the link and the Category Name
            echo '<br /><table width="100%" cellpadding="0" cellspacing="0" >
    <tr>
    <td>
    <table width="100%" cellpadding="0" cellspacing="0"><tr>
    <td class="cbgl"></td>
    <td class="cbg">
    <a href="' . $globals['ind'] . '#cid' . $categories[$c]['cid'] . '" name="cid' . $categories[$c]['cid'] . '">' . $categories[$c]['name'] . '</a>
    </td>
    <td class="cbg" align="right">
    <a href="javascript:slider.slide(\'cat' . $c . '\')" ><img id="icat' . $categories[$c]['cid'] . '" src="' . $theme['images'] . 'expanded.gif" alt="" /></a>
    </td>
    <td class="cbgr"></td>
    </tr>
    </table>
    </td>
    </tr>

    <tr>
    <td width="100%">
    <div id="cat' . $categories[$c]['cid'] . '" class="cathide">
    <table width="100%" cellpadding="2" cellspacing="1" class="cbgbor" id="tcat' . $categories[$c]['cid'] . '">
    <tr align="center">
    <td class="cbg1" width="6%">&nbsp;</td>
    <td class="cbg1" width="48%">' . $l['heading_board'] . '</td>
    <td class="cbg1" width="10%">' . $l['heading_topics'] . '</td>
    <td class="cbg1" width="9%">' . $l['heading_posts'] . '</td>
    <td class="cbg1" width="27%">' . $l['heading_last_post'] . '</td>
    </tr>';

            //The main forum loop of a category
            foreach ($forums[$c] as $f => $v) {

                echo '<tr>
    <td class="miimg" align="center">
    <img src="' . (($forums[$c][$f]['fimage']) ? $forums[$c][$f]['fimage'] : (($forums[$c][$f]['is_read']) ? $theme['images'] . 'not.png' : $theme['images'] . 'new.png')) . '" alt="" />
    </td>

    <td class="mifor">
    <font class="forlink">
    <a href="' . (($forums[$c][$f]['fredirect']) ? $forums[$c][$f]['fredirect'] : forumlink($v['fid'], $v['fname']) ) . '">' . $forums[$c][$f]['fname'] . '</a>
    </font><br />
    <font class="desc">
    ' . $forums[$c][$f]['description'] . '&nbsp;
    </font><br />';

                //Make the moderators array if there are any
                if (isset($forums[$c][$f]['moderators'])) {

                    $boardmoderators[$f] = array();

                    foreach ($forums[$c][$f]['moderators'] as $mk => $mv) {

                        $boardmoderators[$f][] = '<a href="' . userlink($mv['id'], $mv['username']) . '">' . $forums[$c][$f]['moderators'][$mk]['username'] . '</a>';
                    }

                    echo '<div style="padding-top:4px;padding-bottom:2px;"><font class="modtxt">' . $l['forum_moderators'] . ' </font>';

                    echo implode(' , ', $boardmoderators[$f]) . '</div>';
                }

                //Make the In Board array if there are any
                if (isset($forums[$c][$f]['in_boards'])) {

                    $inboards[$f] = array();

                    foreach ($forums[$c][$f]['in_boards'] as $ik => $iv) {

                        $inboards[$f][] = (!empty($iv['is_read']) ? '' : '<b>') . '<a href="' . forumlink($iv['fid'], $iv['fname']) . '">' . $forums[$c][$f]['in_boards'][$ik]['fname'] . '</a>' . (!empty($iv['is_read']) ? '' : '</b>');
                    }

                    echo '<div style="padding-top:3px;"><font class="inbtxt">' . $l['forum_in_boards'] . '</font>';

                    echo implode(' , ', $inboards[$f]) . '</div>';
                }

                echo '</td>

    <td class="mitop">
    ' . $forums[$c][$f]['ft_topic'] . '
    </td>

    <td class="miposts">
    ' . $forums[$c][$f]['ft_posts'] . '</td>

    <td class="milp">';

                if (empty($forums[$c][$f]['tid'])) {

                    echo $l['no_last_post'];
                } else {

                    echo '&nbsp;' . $forums[$c][$f]['pdate'] . '<br />' .
                    $l['in'] . ' <a href="' . topiclink($v['tid'], $v['topic']) . '" title="' . $l['go_to_first_post'] . '">' . $forums[$c][$f]['topic'] . '</a>&nbsp;&nbsp;&nbsp;<a href="' . topiclink($v['tid'], $v['topic'], $v['last_page']) . '#p' . $forums[$c][$f]['pid'] . '" title="' . $l['go_to_last_post'] . '"><img src="' . $theme['images'] . 'right.gif" alt="" /></a><br />' .
                    $l['by'] . ' ' . (empty($forums[$c][$f]['username']) ? (empty($forums[$c][$f]['gposter_name']) ? $l['guest'] : $forums[$c][$f]['gposter_name']) : '<a href="' . userlink($v['poster_id'], $v['username']) . '">' . $forums[$c][$f]['username'] . '</a>');
                }

                echo '</td>
    </tr>';
            }//end the forums loop
            //The end of the table
            echo '
    </table>
    </div>

    </td>
    </tr>
    <tr>
    <td><img src="' . $theme['images'] . 'cbot.png" width="100%" height="15" alt="" /></td>
    </tr>

    </table>';
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
    echo '<br /><br />
<table border="0" width="100%" cellspacing="0" cellpadding="5" class="cbor">
<tr>
<td align="left">
<img src="' . $theme['images'] . '/new.png" border="0" align="middle" alt="" /> ' . $l['new_posts'] . ' &nbsp;&nbsp;&nbsp;<img src="' . $theme['images'] . '/not.png" border="0" align="middle" alt="" /> ' . $l['no_new_posts'] . '
</td>
<td align="right">' . ($logged_in ? '<a href="' . $globals['ind'] . 'act=markread&amp;mark=board">' . $l['mark_board_read'] . '</a>' : '') . '
</td>
</tr>
</table>';


//The Statistics Center
    echo '<br /><br />
<table border="0" width="100%" cellspacing="1" cellpadding="4" class="cbor">

<tr>
<td align="center" colspan="2" class="cbg">' . $l['statistics'] . '</td>
</tr>';

    if (!empty($recent_posts)) {

        echo '<tr>
<td colspan="2" class="cbg1" align="left">
' . $l['recent_posts'] . '
</td>
</tr>

<tr>
<td align="center" class="miposts" width="5%">
<img src="' . $theme['images'] . 'postedon.png" alt="" />
</td>
<td class="mifor" style="font-size:12px">';

        foreach ($recent_posts as $rk => $rv) {

            echo '(' . $rv['pdate'] . ') <b><a href="' . topiclink($rv['tid'], $rv['topic'], $rv['last_page']) . '#p' . $rv['pid'] . '">' . $rv['topic'] . '</a></b> ' . $l['by'] . ' <a href="' . userlink($rv['id'], $rv['username']) . '">' . $rv['username'] . '</a>   (<a href="' . forumlink($rv['fid'], $rv['fname']) . '">' . $rv['fname'] . '</a>)<br />';
        }

        echo '</td>
</tr>';
    }

    echo '<tr>
<td colspan="2" class="cbg1" align="left">
' . ($user['view_active'] ? '<a href="' . $globals['ind'] . 'act=active">' . $l['active_users'] . '</a>' : $l['active_users'] ) . '
</td>
</tr>

<tr>
<td align="center" class="miposts" width="5%">
<img src="' . $theme['images'] . 'onlineusers.png" alt="" />
</td>
<td class="mifor">
' . ($guests + count($active) + (empty($anonymous) ? 0 : $anonymous)) . ' ' . $l['online_users'] . ' ' . $l['in_the_past'] . ' ' . $globals['last_active_span'] . ' ' . $l['minutes'] . ' (' . $guests . ' ' . $l['online_guests'] . ', ' . count($active) . ' ' . $l['online_members'] . (($anonymous) ? ', ' . $anonymous . ' ' . $l['online_anonymous'] : '' ) . ')' .
    (!empty($activeusers) ? '<hr />' . implode(', ', $activeusers) : '') . '
<hr />
' . $l['most_online_today'] . ' <b>' . $mostactive . '</b>. ' . $l['most_online_ever'] . ' <b>' . $mostactive_ever[0] . '</b> ' . $l['on'] . ' <b>' . datify($mostactive_ever[1]) . '</b>

</td>
</tr>';

    if (!empty($online_today)) {

        echo '<tr>
<td colspan="2" class="cbg1" align="left">' . $l['users_online_today'] . ' : ' . count($users_today) . '</td>
</tr>

<tr>
<td align="center" class="miposts" width="5%">
<img src="' . $theme['images'] . 'onlineusers.png" alt="" />
</td>
<td class="mifor">' . implode(', ', $users_today) . '</td>
</tr>';
    }

    if ($user['view_members']) {

        echo '<tr>
<td colspan="2" class="cbg1" align="left">' . $l['all_members'] . '</td>
</tr>
<tr>
<td align="center" class="miposts" width="5%"><img src="' . $theme['images'] . 'online.gif" alt="" /></td>
<td class="mifor"><b><a href="' . $globals['ind'] . 'act=members">' . $l['members'] . '</a></b><br />
' . $l['list_of_members'] .
        (!empty($user_groups) ? '<hr />' . $l['user_groups'] . ' : ' . implode(', ', $user_groups) : '') . '</td>
</tr>';
    }

    echo '<tr>
<td colspan="2" class="cbg1" align="left">' . $l['board_stats'] . '</td>
</tr>

<tr>
<td align="center" class="miposts" width="5%">
<img src="' . $theme['images'] . 'stats.gif" alt="" />
</td>
<td class="mifor">
' . $l['total_posts'] . ' <b>' . $globals['tot_posts'] . '</b><br />
' . $l['total_topics'] . ' <b>' . $globals['tot_topics'] . '</b><br />
' . $l['registered_members'] . ' <b>' . $globals['num_mem'] . '</b><br />
' . $l['welcome_new_member'] . ', <b><a href="' . userlink($latest_mem[1], $latest_mem[0]) . '" >' . $latest_mem[0] . '</a></b>
</td>
</tr>

</table>';

    //Do you have an new PM then pop up
    if (!empty($pm)) {

        echo '<div id="newpm" style="left:275px;top:200px;position:absolute;width:250px;">

<table width="100%" id="newpm_h" cellspacing="0" cellpadding="0">
<tr>
<td class="dwhl"></td>
<td align="left" class="dwhc"><b>' . $l['new_pm'] . '</b></td>
<td align="right" class="dwhc"><a href="javascript:hideel(\'newpm\')"><img src="' . $theme['images'] . 'close.gif" alt="" /></a></td>
<td class="dwhr"></td>
</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="5" class="dwbody">

<tr>
<td style="border-bottom:solid 1px #CCCCCC;">' . $l['pm_subject'] . ' <a href="' . $globals['ind'] . 'act=usercp&amp;ucpact=showpm&amp;pmid=' . $pm['pmid'] . '">' . $pm['pm_subject'] . '</a>
</td>

<td style="border-bottom:solid 1px #CCCCCC;" align="right">
' . $l['pm_sender'] . ' <a href="' . userlink($pm['id'], $pm['sender']) . '">' . $pm['sender'] . '</a>
</td>
</tr>

<tr>
<td colspan="2">' . $pm['pm_body'] . '</td>
</tr>

<tr>
<td align="left" class="dwb" colspan="2"></td>
</tr>

</table>
</div>

<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
    Drag.init($("newpm_h"), $("newpm"));
// ]]></script>';
    }

//The defualt footers
    aeffooter();
}

?>