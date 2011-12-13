<?php

function aefheader($title = '', $stats_panel = '') {

    global $theme, $user, $logged_in, $globals, $l, $dmenus, $onload, $newslinks, $feeds, $dbtables;

    $title = ((empty($title)) ? $globals['sn'] : $title);

    //Lets echo the top headers
    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=' . $globals['charset'] . '" />
            <meta name="keywords" content="aef, advanced, electron, forum, bulletin, board, software' . (empty($globals['keywords']) ? '' : ', ' . $globals['keywords']) . '" />
            <title>' . $title . '</title>
            <link rel="stylesheet" type="text/css" href="' . $theme['url'] . '/style.css" />
            <link rel="stylesheet" type="text/css" href="' . $theme['url'] . '/jquery-ui.css" />
            <link rel="shortcut icon" href="favicon.ico" />
            ' . ((empty($globals['rss_recent'])) ? '' : '<link rel="alternate" type="application/rss+xml" title="' . $globals['sn'] . ' - ' . $l['rss'] . '" href="' . $globals['ind'] . 'act=feeds" />') . '
            ' . (empty($feeds) ? '' : implode('', $feeds)) . '
            <script language="javascript" src="' . $theme['url'] . '/js/universal.js" type="text/javascript"></script>
            <script language="javascript" src="' . $theme['url'] . '/js/menu.js" type="text/javascript"></script>
            <script language="javascript" src="' . $theme['url'] . '/js/domdrag.js" type="text/javascript"></script>
            <script type="text/javascript" src="' . $theme['url'] . '/js/jquery.min.js"></script>
            <script type="text/javascript" src="' . $theme['url'] . '/js/jquery-ui.min.js"></script>
            <script type="text/javascript">
                var $j = jQuery.noConflict();
                $j(document).ready(function(){
                    $j("#login.trigger").click(function(){
				        $j("#login.panel").toggle("fast");
				        $j(this).toggleClass("active");
				        return false;
                    });
                    $j("#stats.trigger").click(function(){
                        $j("#stats.panel").toggle("fast");
                        $j(this).toggleClass("active");
				        return false;
                    });
                });
            </script>
            <!--[if lt IE 9]>
                <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->
            <!--[if lt IE 8]>
                <script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
            <![endif]-->
            <script language="javascript" type="text/javascript">
                <!-- // --><![CDATA[
                    boardurl = \'' . $globals['url'] . '/\';
                    indexurl = \'' . $globals['index_url'] . '\';
                    imgurl = \'' . $theme['images'] . '\';
                // ]]>
            </script>
        </head>
    <body onload="bodyonload();">';

    echo '<div class="header" id="header">
    <div>
        <div style="float:left;" class="logo_area">
			<a class="logo" href="' . $globals['ind'] . '">
				<img class="default" height="90" src="' . (!empty($theme['headerimg']) ? $theme['headerimg'] : $theme['images'] . 'aeflogo.png') . '" alt="" />
				<img class="hover" height="90" src="' . (!empty($theme['headerimg']) ? $theme['headerimg'] : $theme['images'] . 'aeflogo_hover.png') . '" alt="" />
			</a>
        </div>
        
         <div style="float:right;" class="welcome">';

    if ($logged_in) {
        $uColorRef = makequery("SELECT mem_gr_colour FROM " . $dbtables['user_groups'] . " WHERE member_group = " . $user['u_member_group'] . " LIMIT 1");
        if (mysql_num_rows($uColorRef) == 0) {
            return false;
        }
        $assoc = mysql_fetch_assoc($uColorRef);
        $color = $assoc['mem_gr_colour'];
        mysql_free_result($uColorRef);
        
        switch ($user['avatar_type']){
			case '1':
			$avatar_url = $globals['url'] . '/avatars/' . $user['avatar'];
			break;
			case '2':
			$avatar_url = $user['avatar'];
			break;
			case '3':
			$avatar_url = $globals['url'] . '/uploads/avatars/' . $user['avatar'];
			break;
			default:
			$avatar_url = $globals['url'] . '/avatars/unknown.png';
			break;
		}
        echo $l['welcome'] . ' <b><span style=color:' . $color . '>' . $user['username'] . '</span></b><img src="'. $avatar_url .'" alt="" width="20" height="20">&nbsp;&nbsp;&nbsp;&nbsp;[<span class="logout"><a href="' . $globals['ind'] . 'act=logout">' . $l['nav_logout'] . '</a></span>]&nbsp;&nbsp;';
    } else {
        echo '<b>' . $l['welcome'] . '</b> ' . $l['guest'] . '. ' . $l['please'] . ' <a href="' . $globals['ind'] . 'act=login" title="' . $l['login_title'] . '">' . $l['login'] . '</a> ' . $l['or'] . ' <a href="' . $globals['ind'] . 'act=register" title="' . $l['register_title'] . '">' . $l['register'] . '</a>&nbsp;&nbsp;';
    }

    echo '</div>

    </div>
<br/><br/><br/>
    <div>
<div style="float:right;margin-top:-5px;" class="search_box">
			<form accept-charset="' . $globals['charset'] . '" name="ddsearch" method="get" action="' . $globals['ind'] . '">
			<label id="search_label" class="search_label" for="allwords" style="display: block;" >' . $l['nav_search'] . '</label>
				<input type="text" id="allwords" name="allwords" class="search_input" onclick="document.getElementById(\'search_label\').style.display = \'none\';" onblur="if(this.value == \'\'){document.getElementById(\'search_label\').style.display = \'block\';}" />
				<input type="submit"  name="search" style="display:none;"/>
				<input type="hidden" name="act" value="search" />
				<input type="hidden" name="sact" value="results" />
				<input type="hidden" name="within" value="1" />
				<input type="hidden" name="forums[]" value="0" />
				<input type="hidden" name="showas" value="1" />
			</form>
		</div>
        <div style="float:right;top:5%;">';

    //Array Holding the Options to be imploded
    $opt = array();

    if ($logged_in) {

        if ($user['can_admin']) {

            $opt[] = '<b><a href="' . $globals['ind'] . 'act=admin" onmouseover="dropmenu(this, \'adminopt\')" onmouseout="pullmenu(\'adminopt\')">' . $l['admin'] . '</a></b>';

            echo '<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
createmenu("adminopt", [
[\'<a href="' . $globals['ind'] . 'act=admin&amp;adact=conpan">' . $l['nav_control_panel'] . '<\/a>\'],
[\'<a href="' . $globals['ind'] . 'act=admin&amp;adact=forums">' . $l['nav_manage_forums'] . '<\/a>\'],
[\'<a href="' . $globals['ind'] . 'act=admin&amp;adact=users">' . $l['nav_user_settings'] . '<\/a>\'],
[\'<a href="' . $globals['ind'] . 'act=admin&amp;adact=approvals&amp;seadact=manval">' . $l['nav_account_approvals'] . '<\/a>\'],
[\'<a href="' . $globals['ind'] . 'act=admin&amp;adact=tpp">' . $l['nav_topic_posts'] . '<\/a>\'],
]);
// ]]></script>';
        }

        echo '<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
createmenu("ucpopt", [
[\'<a href="' . $globals['ind'] . 'act=usercp&amp;ucpact=profile">' . $l['nav_profile_settings'] . '<\/a>\'],
[\'<a href="' . $globals['ind'] . 'act=usercp&amp;ucpact=account">' . $l['nav_account_settings'] . '<\/a>\'],
[\'<a href="' . $globals['ind'] . 'act=usercp&amp;ucpact=forumset">' . $l['nav_forum_preferences'] . '<\/a>\']
]);

createmenu("pmopt", [
[\'<a href="' . $globals['ind'] . 'act=usercp&amp;ucpact=inbox">' . $l['nav_inbox'] . '(' . $user['unread_pm'] . ')<\/a>\'],
[\'<a href="' . $globals['ind'] . 'act=usercp&amp;ucpact=writepm">' . $l['nav_compose'] . '<\/a>\'],
[\'<a href="' . $globals['ind'] . 'act=usercp&amp;ucpact=searchpm">' . $l['nav_search_pm'] . '<\/a>\'],
[\'<a href="' . $globals['ind'] . 'act=usercp&amp;ucpact=trackpm">' . $l['nav_track_mesaages'] . '<\/a>\']
]);
// ]]></script>';

        $opt[] = '<b><a href="' . $globals['ind'] . 'act=usercp" style="position:relative;" onmouseover="dropmenu(this, \'ucpopt\')" onmouseout="pullmenu(\'ucpopt\')" >' . $l['usercp'] . '</a></b>
';

        $opt[] = '<a href="' . $globals['ind'] . 'act=usercp&amp;ucpact=inbox"  style="position:relative;" onmouseover="dropmenu(this, \'pmopt\')" onmouseout="pullmenu(\'pmopt\')">' . $l['pms'] . ' (' . $user['unread_pm'] . ')</a>';
    }


    //Can He search
    if (!empty($user['can_search'])) {
        $opt[] = '<a href="' . $globals['ind'] . 'act=search" style="position:relative;" onmouseover="dropmenu(this, \'ddsearch\')" onmouseout="pullmenu(\'ddsearch\')">' . $l['nav_search'] . '</a>';
    }

    //The Calendar
    if (!empty($user['view_calendar'])) {

        $opt[] = '<a href="' . $globals['ind'] . 'act=calendar">' . $l['nav_calendar'] . '</a>';
    }

    //Some General Options
    $quick_links = (empty($globals['enablenews']) ? '' : '[\'<a href="' . $globals['ind'] . 'act=news">' . $l['nav_news'] . '<\/a>\'],' ) . '
' . ((empty($globals['enableshoutbox']) || empty($user['can_shout']) || !empty($theme['fixshoutbox'])) ? '' : '[\'<a href="javascript:show_shoutbox();">' . $l['nav_shout_box'] . '<\/a>\'],' ) . '
' . (empty($logged_in) ? '' : '[\'<a href="' . $globals['ind'] . 'act=unread">' . $l['nav_unread_topics'] . '<\/a>\'],' ) . '
' . (empty($user['view_members']) ? '' : '[\'<a href="' . $globals['ind'] . 'act=members">' . $l['nav_members'] . '<\/a>\'],' ) . '
' . (empty($user['view_active']) ? '' : '[\'<a href="' . $globals['ind'] . 'act=active">' . $l['nav_active'] . '<\/a>\'],' ) . '
' . (empty($logged_in) ? '' : '[\'<a href="' . $globals['ind'] . 'act=markread&amp;mark=board">' . $l['nav_mark_read'] . '<\/a>\'],' );

    if (!empty($quick_links)) {

        $opt[] = '<a href="#" style="position:relative;" onmouseover="dropmenu(this, \'quicklinks\')" onmouseout="pullmenu(\'quicklinks\')">' . $l['quick_links'] . '</a>';
        echo '<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
createmenu("quicklinks", [' . $quick_links . ']);
// ]]></script>';
    }

    //Quick Login
    /*if (empty($logged_in)) {

        $opt[] = '<form accept-charset="' . $globals['charset'] . '" action="' . $globals['ind'] . 'act=login"  method="post" name="loginform">
        <input type="text" size="9" name="username" class="ql" value="' . $l['username'] . '" onfocus="(this.value==\'' . $l['username'] . '\' ? this.value=\'\' : void(0))" />&nbsp;
        <input type="password" size="9" name="password" class="ql" value="' . $l['password'] . '" onfocus="(this.value==\'' . $l['password'] . '\' ? this.value=\'\' : void(0))" />&nbsp;
        <input type="submit" name="login" value="' . $l['sign_in'] . '" class="ql" />
</form>';
    }*/

    //this is the users menu table
    echo '<div style="height:35px;">
                <div style="float:left;">
                    <div style="float:right;" class="navlinks">';

    echo implode('&nbsp;&nbsp;|&nbsp;&nbsp;', $opt);

    echo '</div>
                </div>
            </div>
        </div>
     </div>

    </div><div class="header">';

    echo (empty($theme['headernavtree']) ? '</div>' : tree() . '</div>');


    if (!empty($theme['headerads'])) {

        echo unhtmlentities($theme['headerads']);
    }

    //News
    if (!empty($newslinks)) {

        echo '<br /><table width="100%" cellpadding="2" cellspacing="2" class="newshead">
<tr>
<td width="1%">
<b>' . $l['news_prefix'] . ':</b>
</td>
<td valign="top">';

        foreach ($newslinks as $n => $v) {

            echo '<div id="news' . $n . '" class="newslinks" >' . (empty($v['approved']) ? $l['unapproved_news'] . ' : ' : '' ) . '<a href="' . $globals['ind'] . 'act=news&amp;nid=' . $n . '#n' . $n . '">' . $v['title'] . '</a></div>';
        }

        echo '</td>
</tr>
</table><br />
<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
addonload(\'initnews();\');
nextnews = 3000;
news_r = new Array(\'' . implode('\', \'', array_keys($newslinks)) . '\');
newsindex = 0;

function initnews(){
    if(news_r.length > 1){
        try{hideel(nid);}catch(e){}
        if(typeof(news_r[newsindex]) == "undefined"){
            newsindex = 0;
        }
        nid = "news"+news_r[newsindex];
        showel(nid);
        smoothopaque(nid, 0, 100, 5);
        newsindex++;
        newstimeout = setTimeout(initnews, nextnews);
    }else{
        showel("news"+news_r[newsindex]);
    }
};

// ]]></script>';
    }

    //Shout box
    if (!empty($globals['enableshoutbox']) && !empty($user['can_shout'])) {

        echo '<script language="javascript" src="' . $theme['url'] . '/js/shoutbox.js" type="text/javascript"></script>
        <script language="javascript" type="text/javascript"><!-- // --><![CDATA[
        can_del_shout = ' . (empty($user['can_del_shout']) ? 'false' : 'true') . ';
        // ]]></script>';

        if (empty($theme['fixshoutbox'])) {

            $dmenus[] = '<div id="shoutbox" class="pqr">
<table width="100%" cellspacing="0" cellpadding="0" id="shbhandle">
<tr>
<td class="dwhl"></td>
<td align="left" class="dwhc"><b>' . $l['shout_box'] . '</b></td>
<td align="right" class="dwhc"><a href="javascript:hide_shoutbox()"><img src="' . $theme['images'] . 'close.gif" alt="" /></a></td>
<td class="dwhr"></td>
</tr>
</table>

<table width="100%" cellspacing="0" cellpadding="0" class="dwbody">
<tr>
<td width="100%" valign="top">
<div id="shouts" class="shouts"></div>
</td>
</tr>
<tr>
<td style="padding:4px;">
<input type="text" size="35" id="addshout" onkeydown="handleshoutkeys(event)" />&nbsp;&nbsp;<input type="button" onclick="shout();" value="' . $l['shout'] . '" id="addshoutbut" />&nbsp;&nbsp;<input type="button" onclick="reloadshoutbox();" value="' . $l['reload'] . '" />
</td>
</tr>
</table>
</div>

<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
Drag.init($("shbhandle"), $("shoutbox"));
// ]]></script>';

            //Fix it
        } else {

            echo '<br /><div id="shoutbox">
<table width="100%" cellspacing="0" cellpadding="0">
<tr>
<td class="dwhl"></td>
<td align="left" class="dwhc"><b>' . $l['shout_box'] . '</b></td>
<td align="right" class="dwhc"><a href="javascript:hideshow_fixedshoutbox()" ><img src="' . $theme['images'] . 'expanded.gif" id="shbimgcollapser" alt="" /></a></td>
<td class="dwhr"></td>
</tr>
</table>

<div class="cathide" id="shbcontainer">
<table width="100%" cellspacing="0" cellpadding="0" class="dwbody">
<tr>
<td width="100%" valign="top">
<div id="shouts" class="shouts"></div>
</td>
</tr>
<tr>
<td style="padding:4px;">
<input type="text" size="35" id="addshout" onkeydown="handleshoutkeys(event)" />&nbsp;&nbsp;<input type="button" onclick="shout();" value="' . $l['shout'] . '" id="addshoutbut" />&nbsp;&nbsp;<input type="button" onclick="reloadshoutbox();" value="' . $l['reload'] . '" />
</td>
</tr>
</table>
</div>
</div>
<br />

<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
addonload(\'init_fixedshoutbox();\');
// ]]></script>';
        }
    }

    if (!empty($user['group_message'])) {

        echo '<table width="100%" cellspacing="2" cellpadding="4" class="dwbody">
<tr><td class="dwhc">' . $l['group_message'] . '</td></tr>
<tr><td>' . $user['group_message'] . '</td></tr></table><br />';
    }
    if(!$logged_in){
    ?>
<div id="login" class="panel">
	<form accept-charset="<?php echo $globals['charset']; ?>" action="<?php echo $globals['ind'];?>act=login" method="post" name="loginform">
                           
                            <div>
								<b><?php echo $l['username']; ?></b>
                                <input type="text" size="20" name="username" <?php echo ( (isset($_POST['username'])) ? 'value="' . $_POST['username'] . '"' : '' ); ?> />
                                <br/><b><?php echo $l['password']; ?></b>
                                <input type="password" size="20" name="password" />
								<input type="submit" name="login" value="<?php echo $l['sign_in']; ?>" style="margin-top:-20px;-moz-box-shadow:none;-webkit-box-shadow:none;"/>
							</div>
                </form>
</div>
<div style="clear:both;"></div>

<a id="login" class="trigger" href="#"></a>
<?php
}
//everything will go after this
?>
<div id="stats" class="panel">
<?php echo $stats_panel; ?>
<div style="clear:both;"></div>
</div>
    <a id="stats" class="trigger" href="#"></a>
        
    <div id="main_body">

<?php
		
}

function aeffooter() {

    global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $dmenus, $end_time, $start_time, $onload, $theme;

    echo '</div><br />';

    if (!empty($theme['footerads'])) {

        echo unhtmlentities($theme['footerads']);
    }

    if ($logged_in && !empty($theme['showdock'])) {

        echo '<link rel="stylesheet" href="' . $theme['url'] . '/dock.css" />
                <div class="dock">
                    <ul>
                        <li id="dock_home">
                            <a href="' . $globals['ind'] . '" title="' . $l['dock_home'] . '">
                                <em><span>' . $l['dock_home'] . '</span></em>
                                <img src="' . $theme['images'] . 'home.gif" alt="' . $l['dock_home'] . '" />
                            </a>
                        </li>
                        ' . (empty($user['can_admin']) ? '' : '
                        <li id="dock_admin">
                            <a href="' . $globals['ind'] . 'act=admin" title="' . $l['dock_admin'] . '">
                            <em><span>' . $l['dock_admin'] . '</span></em>
                                <img src="' . $theme['images'] . 'admincp.png" alt="' . $l['dock_admin'] . '" />
                            </a>
                        </li>') . '
                        <li id="dock_profile">
                            <a href="' . $globals['ind'] . 'act=usercp" title="' . $l['dock_profile_settings'] . '">
                            <em><span>' . $l['dock_profile_settings'] . '</span></em>
                                <img src="' . $theme['images'] . 'profile.png" alt="' . $l['dock_profile_settings'] . '" />
                            </a>
                        </li>
                        <li id="dock_inbox">
                            <a href="' . $globals['ind'] . 'act=usercp&amp;ucpact=inbox" title="' . $l['dock_inbox'] . '">
                            <em><span>' . $l['dock_inbox'] . '</span></em>
                                <img src="' . $theme['images'] . 'inbox.png" alt="' . $l['dock_inbox'] . '" />
                            </a>
                        </li>
                        <li id="dock_compse">
                            <a href="' . $globals['ind'] . 'act=usercp&amp;ucpact=writepm" title="' . $l['dock_compose'] . '">
                            <em><span>' . $l['dock_compose'] . '</span></em>
                                <img src="' . $theme['images'] . 'compose.png" alt="' . $l['dock_compose'] . '" />
                            </a>
                        </li>
                        <li id="dock_search">
                            <a href="' . $globals['ind'] . 'act=search" title="' . $l['dock_search'] . '">
                            <em><span>' . $l['dock_search'] . '</span></em>
                                <img src="' . $theme['images'] . 'search.png" alt="' . $l['dock_search'] . '" />
                            </a>
                        </li>
                    </ul>
                </div>';
    }

//Footer Nav tree
    echo (empty($theme['footernavtree']) ? '' : tree() . '<br /><br />');

    $pageinfo = array();

    echo '<br /><div align="center">' . $l['times_are'] . (empty($globals['pgtimezone']) ? '' : ' ' . ($globals['pgtimezone'] > 0 ? '+' : '') . $globals['pgtimezone']) . '. ' . $l['time_is'] . ' ' . datify(time(), false) . '.</div>';

    if (!empty($theme['shownumqueries'])) {

        $pageinfo[] = $l['queries'] . ': ' . $globals['queries'];
    }

    if (!empty($theme['showntimetaken'])) {

        $pageinfo[] = $l['page_time'] . ':' . substr($end_time - $start_time, 0, 5);
    }

    echo '<br />
<table width="100%" cellpadding="5" cellspacing="1" class="bottom">
<tr>
<td align="left">' . ((empty($globals['rss_recent'])) ? '' : '<a href="' . $globals['ind'] . 'act=feeds" title="' . $globals['sn'] . ' - ' . $l['rss'] . '"><img src="' . $theme['images'] . 'feeds.gif" alt="" /></a>&nbsp;&nbsp;') . '' . copyright() . '</td>' . (empty($pageinfo) ? '' : '<td align="right">' . implode('&nbsp;&nbsp;|&nbsp;&nbsp;', $pageinfo) . '</td>') . '
</tr>
</table><br />';

    if (!empty($theme['copyright'])) {

        echo unhtmlentities($theme['copyright']);
    }

    echo '<script language="javascript" type="text/javascript"><!-- // --><![CDATA[
function bodyonload(){
    if(aefonload != \'\'){
        eval(aefonload);
    }
    ' . (empty($onload) ? '' : 'eval(\'' . implode(';', $onload) . '\');') . '
};
// ]]></script>';

    echo (empty($dmenus) ? '' : implode('', $dmenus) ) . '
</body>
</html>';
}

//The tree for navigation
function tree() {

    global $globals, $theme, $tree, $l;

    $links = array();

    if (empty($tree) || !is_array($tree)) {

        $links[] = '<b><a href="' . $globals['ind'] . '">' . $l['index'] . '</a></b>';
    } else {

        foreach ($tree as $k => $v) {

            //& => &amp; for W3C
            //l - means links, txt - The text, prefix is a prefix
            $links[] = (empty($v['prefix']) ? '' : $v['prefix'] ) . '<b><a href="' . str_replace('&', '&amp;', $v['l']) . '">' . $v['txt'] . '</a></b>';
        }
    }

    return '<br /><br />' . $l['you_are_here'] . ': ' . implode('&nbsp;&gt;&nbsp;', $links);
}

function error_handle($error, $table_width = '100%', $center = false) {

    global $l;

    //on error call the form
    if (!empty($error)) {

        echo '
            <div width="' . $table_width . '" class="error" ' . (($center) ? 'align="center"' : '' ) . '>
            ' . $l['following_errors_occured'] . ' :
            <ul type="square">';

        foreach ($error as $ek => $ev) {

            echo '<li>' . $ev . '</li>';
        }


        echo '</ul>
            </div>' . (($center) ? '</center>' : '' ) . '
            <br />';
    }
}

//This will just echo that everything went fine
function success_message($message, $table_width = '100%', $center = false) {

    global $l;

    //on error call the form
    if (!empty($message)) {

        echo '<table width="' . $table_width . '" cellpadding="2" cellspacing="1" class="error" ' . (($center) ? 'align="center"' : '' ) . '>
            <tr>
            <td>
            ' . $l['following_message'] . ' :
            <ul type="square">';

        foreach ($message as $mk => $mv) {

            echo '<li>' . $mv . '</li>';
        }


        echo '</ul>
            </td>
            </tr>
            </table>' . (($center) ? '</center>' : '' ) . '
            <br />';
    }
}

function majorerror($title, $text, $heading = '') {

    global $theme, $globals, $user, $l;

    aefheader(((empty($title)) ? $l['fatal_error'] : $title));
    ?>

    <div width="70%" class="division" align="center">
        <div class="topbar" align="left">
            <h3><?php echo ((empty($heading)) ? $l['following_fatal_error'] . ':' : $heading); ?></h3>
        </div>

        <div class="ucpfcbg1" colspan="2" align="center">
            <img src="<?php echo $theme['images']; ?>sigwrite.png" alt="" />
        </div>
        <div style="clear:both"></div>
        <div class="ucpflc" align="left" style="margin-top: 10px;">
            <?php echo $text; ?><br />
        </div>
    </div>
    <div style="clear:both"></div>

    <?php
    aeffooter();

//We must return
    return true;
}

function message($title, $heading = '', $icon, $text) {

    global $theme, $globals, $user, $l;

    aefheader(((empty($title)) ? $l['board_message'] : $title));
    ?>

    <table width="70%" cellpadding="2" cellspacing="1" class="cbor" align="center" >

        <tr>
            <td class="patcbg" align="left"  >
                <b><?php echo ((empty($heading)) ? $l['following_board_message'] . ':' : $heading); ?></b>
            </td>
        </tr>

        <tr>
            <td class="ucpfcbg1" colspan="2" align="center">
                <img src="<?php echo $theme['images'] . (empty($icon) ? 'info.png' : $icon); ?>" alt="" />
            </td>
        </tr>

        <tr>
            <td class="ucpflc" align="left"><?php echo $text; ?><br />
            </td>
        </tr>

    </table>
    <br /><br /><br />

    <?php
    aeffooter();

//We must return
    return true;
}

function navigator() {

    global $categories, $forums, $logged_in, $l, $board, $user;

    if (empty($forums) || empty($categories)) {

        return '';
    }

    $str = '<br /><br />' .
            $l['jump_to'] . ' : <select id="forumjump" class="jump" onchange="if(this.value) window.location=indexurl+this.value" style="font-size:11px;">';

    $str .= '<option value="">' . $l['select_location'] . ' :</option>';

    //Site Jump
    $str .= '<optgroup label="' . $l['site_links'] . '">
<option value="act=home">' . $l['jump_home'] . '</option>
' . (empty($user['can_admin']) ? '' : '<option value="act=admin">' . $l['jump_admin'] . '</option>' ) . '
' . (empty($logged_in) ? '' : '<option value="act=usercp">' . $l['jump_usercp'] . '</option>' ) . '
' . (empty($logged_in) ? '' : '<option value="act=unread">' . $l['jump_unread'] . '</option>' ) . '
' . (empty($user['view_members']) ? '' : '<option value="act=members">' . $l['jump_members'] . '</option>' ) . '
' . (empty($user['view_active']) ? '' : '<option value="act=active">' . $l['jump_active'] . '</option>' ) . '
' . (empty($user['can_search']) ? '' : '<option value="act=search">' . $l['jump_search'] . '</option>' ) . '
</optgroup>';

    $str .= '<optgroup label="' . $l['forum_jump'] . '">';

    foreach ($categories as $c => $cv) {

        if (isset($forums[$c])) {

            $str .= '<option value="#cid' . $c . '">' . $categories[$c]['name'] . '</option>';

            foreach ($forums[$c] as $f => $fv) {

                $dasher = '&nbsp;&nbsp;';

                for ($t = 0; $t < $forums[$c][$f]['board_level']; $t++) {

                    $dasher .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                }

                $str .= '<option value="fid=' . $forums[$c][$f]['fid'] . '" ' . (!empty($board['fid']) && $board['fid'] == $forums[$c][$f]['fid'] ? 'selected="selected"' : '' ) . '>' . $dasher . '|--' . $forums[$c][$f]['fname'] . '</option>';
            }
        }
    }

    $str .= '</optgroup>';

    $str .= '</select>';

    return $str;
}
?>
