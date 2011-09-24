<?php

function usercphead($title = '') {

    global $globals, $theme, $l, $ucpact;

    //Global Headers
    aefheader($title);

    echo '<link rel="stylesheet" type="text/css" href="' . $theme['url'] . '/usercp.css" />
    <br />
    <div width="100%" cellpadding="0" cellspacing="0" border="0">
    <div>
    <!-- <div width="20%" valign="top" style="padding-right:10px">
    
     <div width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f3f2f2">
      <div>
        <div class="ucpsidehead">
        &nbsp;&nbsp;&nbsp;<img src="" />&nbsp;&nbsp;&nbsp;
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'profile' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=profile">' . $l['general'] . '</a>
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'account' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=account">' . $l['account'] . '</a>
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'signature' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=signature">' . $l['signature'] . '</a>
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'avatar' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=avatar">' . $l['avatar'] . '</a>
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'personalpic' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=personalpic">' . $l['per_pic'] . '</a>
        </div>
      <div>

      <div>
        <div class="ucpsidehead">
        &nbsp;&nbsp;&nbsp;<img src="' . $theme['images'] . 'usercp/pm.gif" />&nbsp;&nbsp;' . $l['messages'] . '
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'inbox' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=inbox">&nbsp;&nbsp;&nbsp;<img src="' . $theme['images'] . 'smallarrow.gif" /> &nbsp;' . $l['inbox'] . '</a>
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'drafts' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=drafts">&nbsp;&nbsp;&nbsp;<img src="' . $theme['images'] . 'smallarrow.gif" /> &nbsp;' . $l['drafts'] . '</a>
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'sentitems' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=sentitems">&nbsp;&nbsp;&nbsp;<img src="' . $theme['images'] . 'smallarrow.gif" /> &nbsp;' . $l['sent_items'] . '</a>
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'writepm' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=writepm">' . $l['compose'] . '</a>
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'emptyfolders' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=emptyfolders">' . $l['empty_folders'] . '</a>
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'searchpm' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=searchpm">' . $l['search'] . '</a>
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'trackpm' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=trackpm">' . $l['track'] . '</a>
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'prunepm' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=prunepm">' . $l['prune'] . '</a>
        </div>
      <div>

      <div>
        <div class="ucpsidehead">
        &nbsp;&nbsp;&nbsp;<img src="' . $theme['images'] . 'usercp/settings.gif" />&nbsp;&nbsp;&nbsp;' . $l['settings'] . '
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'forumset' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=forumset">' . $l['board'] . '</a>
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'emailpmset' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=emailpmset">' . $l['email_pm'] . '</a>
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'themeset' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=themeset&theme_id=' . $globals['theme_id'] . '">' . $l['theme'] . '</a>
        </div>
      <div>

      <div>
        <div class="ucpsidehead">
        &nbsp;&nbsp;&nbsp;<img src="' . $theme['images'] . 'usercp/notifications.gif" />&nbsp;&nbsp;' . $l['notifications'] . '
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'topicsub' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=topicsub">' . $l['topic'] . '</a>
        </div>
      <div>
      <div>
        <div class="' . ($ucpact == 'forumsub' ? 'ucpsidesel' : 'ucpsidelink') . '">
        <a href="' . $globals['index_url'] . 'act=usercp&ucpact=forumsub">' . $l['forum'] . '</a>
        </div>
      <div>
    </div>

    </div> -->

    <div valign="top">

    <div>
    <div>
    <div>
    <div id="top_menu">
        <div id="topmenu_branch">
            <a href="' . $globals['index_url'] . 'act=usercp&ucpact=profile"><img src="' . $theme['images'] . 'usercp/profile.png"></a>
            <p>' . $l['profile'] . '</p>
        </div>
        <div id="topmenu_branch">
            <a href="' . $globals['index_url'] . 'act=usercp&ucpact=inbox"><img src="' . $theme['images'] . 'usercp/pm.png"></a>
            <p>' . $l['messages'] . '</p>
        </div>
        <div id="topmenu_branch">
            <a href="' . $globals['index_url'] . 'act=usercp&ucpact=forumset"><img src="' . $theme['images'] . 'usercp/settings.png"></a>
            <p>' . $l['settings'] . '</p>
        </div>
        <div id="topmenu_branch">
            <a href="' . $globals['index_url'] . 'act=usercp&ucpact=topicsub"><img src="' . $theme['images'] . 'usercp/notifications.png"></a>
            <p>' . $l['notifications'] . '</p>
        </div>
    </div>

    <!-- <div valign="bottom" align="center" ' . (in_array($ucpact, array('profile', 'account', 'signature', 'avatar', 'personalpic')) ? 'class="ucpicosel"' : 'onmouseover="this.className=\'ucpicoon\'" onmouseout="this.className=\'ucpiconor\'" class="ucpiconor" onclick="window.location=\'' . $globals['index_url'] . 'act=usercp&ucpact=profile\'"') . ' width="25%">
    <img src="' . $theme['images'] . 'usercp/profile.gif" /><br />
    <div class="icoexp">' . $l['profile'] . '</div>
    </div> 

    <div valign="bottom" align="center" ' . (in_array($ucpact, array('showpm', 'showsentpm', 'inbox', 'sentitems', 'drafts', 'trackpm', 'writepm', 'searchpm', 'sendsaved', 'prunepm', 'emptyfolders', 'delpm')) ? 'class="ucpicosel"' : 'onmouseover="this.className=\'ucpicoon\'" onmouseout="this.className=\'ucpiconor\'" class="ucpiconor" onclick="window.location=\'' . $globals['index_url'] . 'act=usercp&ucpact=inbox\'"') . ' width="25%">
    <img src="' . $theme['images'] . 'usercp/pm.gif" /><br />
    <div class="icoexp">' . $l['messages'] . '</div>
    </div>

    <div valign="bottom" align="center" ' . (in_array($ucpact, array('emailpmset', 'forumset', 'themeset')) ? 'class="ucpicosel"' : 'onmouseover="this.className=\'ucpicoon\'" onmouseout="this.className=\'ucpiconor\'" class="ucpiconor" onclick="window.location=\'' . $globals['index_url'] . 'act=usercp&ucpact=forumset\'"') . ' width="25%">
    <img src="' . $theme['images'] . 'usercp/settings.gif" /><br />
    <div class="icoexp">' . $l['settings'] . '</div>
    </div>

    <div valign="bottom" align="center" ' . (in_array($ucpact, array('topicsub', 'forumsub')) ? 'class="ucpicosel"' : 'onmouseover="this.className=\'ucpicoon\'" onmouseout="this.className=\'ucpiconor\'" class="ucpiconor" onclick="window.location=\'' . $globals['index_url'] . 'act=usercp&ucpact=topicsub\'"') . ' width="25%">
    <img src="' . $theme['images'] . 'usercp/notifications.gif" /><br />
    <div class="icoexp">' . $l['notifications'] . '</div>
    </div> -->

    </div>
    </div>
    <div class="ucpsubtab">
        <ul align="center">';

    if (in_array($ucpact, array('profile', 'account', 'signature', 'avatar', 'personalpic'))) {

        echo '<li style="display: inline;" class="' . ($ucpact == 'profile' ? 'app_selected' : 'app') . '" align="center">
            <a style="padding: 20px 15px 10px; font-size: 30px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=profile">' . $l['general'] . '</a>
            </li>
            <li style="display: inline;" class="' . ($ucpact == 'account' ? 'app_selected' : 'app') . '" align="center">
            <a style="padding: 20px 15px 10px; font-size: 30px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=account">' . $l['account'] . '</a>
            </li>
            <li style="display: inline;" class="' . ($ucpact == 'signature' ? 'app_selected' : 'app') . '" align="center">
            <a style="padding: 20px 15px 10px; font-size: 30px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=signature">' . $l['signature'] . '</a>
            </li>
            <li style="display: inline;" class="' . ($ucpact == 'avatar' ? 'app_selected' : 'app') . '" align="center">
            <a style="padding: 20px 15px 10px; font-size: 30px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=avatar">' . $l['avatar'] . '</a>
            </li>
            <li style="display: inline;" class="' . ($ucpact == 'personalpic' ? 'app_selected' : 'app') . '" align="center" width="25%">
            <a style="padding: 20px 15px 10px; font-size: 30px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=personalpic">' . $l['per_pic'] . '</a>
            </li>';
    } elseif (in_array($ucpact, array('showpm', 'showsentpm', 'inbox', 'sentitems', 'drafts', 'trackpm', 'writepm', 'searchpm', 'delpm', 'emptyfolders', 'prunepm', 'sendsaved'))) {

        echo '<li style="display: inline;" class="' . ($ucpact == 'inbox' ? 'app_selected' : 'app') . '" align="center">
            <a style="padding: 20px 15px 10px; font-size: 18px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=inbox">' . $l['inbox'] . '</a>
            </li>
            <li style="display: inline;" class="' . ($ucpact == 'drafts' ? 'app_selected' : 'app') . '" align="center">
            <a style="padding: 20px 15px 10px; font-size: 18px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=drafts">' . $l['drafts'] . '</a>
            </li>
            <li style="display: inline;" class="' . ($ucpact == 'sentitems' ? 'app_selected' : 'app') . '" align="center">
            <a style="padding: 20px 15px 10px; font-size: 18px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=sentitems">' . $l['sent_items'] . '</a>
            </li>
            <li style="display: inline;" class="' . ($ucpact == 'writepm' ? 'app_selected' : 'app') . '" align="center">
            <a style="padding: 20px 15px 10px; font-size: 18px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=writepm">' . $l['compose'] . '</a>
            </li>
            <li style="display: inline;" class="' . ($ucpact == 'emptyfolders' ? 'app_selected' : 'app') . '" align="center">
            <a style="padding: 20px 15px 10px; font-size: 18px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=emptyfolders">' . $l['empty_folders'] . '</a>
            </li>
            <li style="display: inline;" class="' . ($ucpact == 'searchpm' ? 'app_selected' : 'app') . '" align="center">
            <a style="padding: 20px 15px 10px; font-size: 18px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=searchpm">' . $l['search'] . '</a>
            </li>
            <li style="display: inline;" class="' . ($ucpact == 'trackpm' ? 'app_selected' : 'app') . '" align="center">
            <a style="padding: 20px 15px 10px; font-size: 18px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=trackpm">' . $l['track'] . '</a>
            </li>
            <li style="display: inline;" class="' . ($ucpact == 'prunepm' ? 'app_selected' : 'app') . '" align="center">
            <a style="padding: 20px 15px 10px; font-size: 18px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=prunepm">' . $l['prune'] . '</a>
            </li>';
    } elseif (in_array($ucpact, array('forumset', 'themeset', 'emailpmset'))) {

        echo '<li style="display: inline;" class="' . ($ucpact == 'forumset' ? 'app_selected' : 'app') . '" align="center">
            <a style="padding: 20px 15px 10px; font-size: 18px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=forumset">' . $l['board'] . '</a>
            </li>
            <li style="display: inline;" class="' . ($ucpact == 'emailpmset' ? 'app_selected' : 'app') . '" align="center">
            <a style="padding: 20px 15px 10px; font-size: 18px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=emailpmset">' . $l['email_pm'] . '</a>
            </li>
            <li style="display: inline;" class="' . ($ucpact == 'themeset' ? 'app_selected' : 'app') . '" align="center">
            <a style="padding: 20px 15px 10px; font-size: 18px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=themeset&theme_id=' . $globals['theme_id'] . '">' . $l['theme'] . '</a>
            </li>';
    } elseif (in_array($ucpact, array('topicsub', 'forumsub'))) {

        echo '<li style="display: inline;" class="' . ($ucpact == 'topicsub' ? 'app_selected' : 'app') . '" align="center" width="15%">
            <a style="padding: 20px 15px 10px; font-size: 18px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=topicsub">' . $l['topic'] . '</a>
            </li>
            <li style="display: inline;" class="' . ($ucpact == 'forumsub' ? 'app_selected' : 'app') . '" align="left">
            <a style="padding: 20px 15px 10px; font-size: 18px;" href="' . $globals['index_url'] . 'act=usercp&ucpact=forumsub">' . $l['forum'] . '</a>
            </li>';
    }

    echo '</div>
    </div>
    </div>
    <br />';
}

//end function User CP head

function usercpfoot() {

    global $globals, $theme;

    echo '</div>
    </div>
    </div><br /><br />';

    //Global footers
    aeffooter();
}

//end function adminfoot
?>