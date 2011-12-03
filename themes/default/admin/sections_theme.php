<?php
//////////////////////////////////////////////////////////////
//===========================================================
// tpp_theme.php(Admin)
//===========================================================
// AEF : Advanced Electron Forum
// Version : 1.0.9
// Inspired by Pulkit and taken over by Electron
// ----------------------------------------------------------
// Started by: Electron, Ronak Gupta, Pulkit Gupta
// Date:       23rd Jan 2006
// Time:       15:00 hrs
// Site:       http://www.anelectron.com/ (Anelectron)
// ----------------------------------------------------------
// Please Read the Terms of use at http://www.anelectron.com
// ----------------------------------------------------------
//===========================================================
// (C)AEF Group All Rights Reserved.
//===========================================================
//////////////////////////////////////////////////////////////

if (!defined('AEF')) {

    die('Hacking Attempt');
}

function core_section(){
	global $theme, $globals, $l;

    //Admin Headers includes Global Headers
    adminhead($theme['init_theme_name']);
	echo '
	<div style="padding: 50px 80px; ">
		<div class="app" style="display: inline;">
			<a href="'.$globals['index_url'].'act=admin&adact=coresection&seadact=optionscenter" style="background-image: url('.$theme['images'].'/admin/options_center.png); ">
			Options Center</a>
		</div>
		<div class="app" style="display: inline;">
			<a href="'.$globals['index_url'].'act=admin&adact=coresection&seadact=pluginscenter" style="background-image: url('.$theme['images'].'/admin/plugins_center.png); ">
			Plugins Center</a>
		</div>
	</div>';

}

function external_section(){
	global $theme, $globals, $l;

    //Admin Headers includes Global Headers
    adminhead($theme['init_theme_name']);
	echo '
	<div style="padding: 50px 80px; ">
		<div class="app" style="display: inline;">
			<a href="'.$globals['index_url'].'act=admin&adact=skin&seadact=manskin" style="background-image: url('.$theme['images'].'/admin/themes_center.png); font-size: 45px;">
			Themes Center</a>
		</div>
		<div class="app" style="display: inline;">
			<a href="'.$globals['index_url'].'act=admin&adact=coresection&seadact=languagescenter" style="background-image: url('.$theme['images'].'/admin/languages_center.png); font-size: 45px;">
			Languages Center</a>
		</div>
	</div>';

}

function content_section(){
	global $theme, $globals, $l;

    //Admin Headers includes Global Headers
    adminhead($theme['init_theme_name']);
	echo '
	<div style="padding: 50px 80px; ">
		<div class="app" style="display: inline;">
			<a href="'.$globals['index_url'].'act=admin&adact=forums" style="background-image: url('.$theme['images'].'/admin/themes_center.png); font-size: 45px;">
			Forums Center</a>
		</div>
		<div class="app" style="display: inline;">
			<a href="'.$globals['index_url'].'act=admin&adact=contentsection&seadact=bbcodescenter" style="background-image: url('.$theme['images'].'/admin/languages_center.png); font-size: 45px;">
			BBCodes Center</a>
		</div>
	</div>';

}

function options_center_theme(){
	global $theme, $globals, $l;
    //Admin Headers includes Global Headers
    adminhead('Options Center');
    echo '
    	<div id="admenu" class="sdmenu">
    		<div style="border:1px solid #CCC">
        		<span>'.$l['cpanel'].'</span>
				<a href="'.$globals['index_url'].'act=admin&adact=conpan&seadact=coreset">
					'.$l['core_settings'].'<span style="color: #888;font-size: 90%;">' . $l['info_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=conpan&seadact=mysqlset">
					'.$l['mysql_conf'].'<span style="color: #888;font-size: 90%;">' . $l['db_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=conpan&seadact=onoff">
					'.$l['maintenance_mode'].'<span style="color: #888;font-size: 90%;">' . $l['status_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=conpan&seadact=mailset">
					'.$l['mail_settings'].'<span style="color: #888;font-size: 90%;">' . $l['mail_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=conpan&seadact=genset">
					'.$l['general_settings'].'<span style="color: #888;font-size: 90%;">' . $l['general_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=conpan&seadact=spamset">
					'.$l['spam_settings'].'<span style="color: #888;font-size: 90%;">' . $l['spam_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=conpan&seadact=shoutboxset">
					'.$l['shoutbox_settings'].'<span style="color: #888;font-size: 90%;">' . $l['sb_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=conpan&seadact=seoset">
					'.$l['seo_settings'].'<span style="color: #888;font-size: 90%;">' . $l['seo_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=users&seadact=proacc">
					'.$l['profile_account'].'<span style="color: #888;font-size: 90%;">' . $l['acc_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=reglog&seadact=regset">
					'.$l['registration_settings'].'<span style="color: #888;font-size: 90%;">' . $l['register_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=reglog&seadact=logset">
					'.$l['log_in_settings'].'<span style="color: #888;font-size: 90%;">' . $l['login_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=reglog&seadact=agerest">
					'.$l['age_restrictions'].'<span style="color: #888;font-size: 90%;">' . $l['agerest_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=users&seadact=avaset">
					'.$l['avatar_settings'].'<span style="color: #888;font-size: 90%;">' . $l['avatar_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=users&seadact=ppicset">
					'.$l['personal_picture'].'<span style="color: #888;font-size: 90%;">' . $l['ppic_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=users&seadact=pmset">
					'.$l['pm_settings'].'<span style="color: #888;font-size: 90%;">' . $l['pm_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=conpan&seadact=banset">
					'.$l['ban_settings'].'<span style="color: #888;font-size: 90%;">' . $l['ipban_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=tpp&seadact=topics">
					'.$l['topic_settings'].'<span style="color: #888;font-size: 90%;">' . $l['topics_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
                <a href="'.$globals['index_url'].'act=admin&adact=tpp&seadact=posts">
                	'.$l['post_settings'].'<span style="color: #888;font-size: 90%;">' . $l['posts_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
                </a>
                <a href="'.$globals['index_url'].'act=admin&adact=tpp&seadact=polls">
                	'.$l['poll_settings'].'<span style="color: #888;font-size: 90%;">' . $l['polls_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
                </a>
				<a href="'.$globals['index_url'].'act=admin&adact=attach&seadact=attset">
					'.$l['attach_settings'].'<span style="color: #888;font-size: 90%;">' . $l['att_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=smileys&seadact=smset">
					'.$l['smiley_settings'].'<span style="color: #888;font-size: 90%;">' . $l['sm_options'] . '
						<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
				<a href="'.$globals['index_url'].'act=admin&adact=skin&seadact=settings&theme_id='.$globals['theme_id'].'">
					'.$l['theme_settings'].'<span style="color: #888;font-size: 90%;">' . $l['skin_options'] . '<span style="float:right; padding: 0;"><img src="' . $theme['images'] . 'right.gif" /></span>
					</span>
				</a>
			</div>
		</div>';
}

function plugins_center_theme(){
	
	global $theme, $globals;

    //Admin Headers includes Global Headers
    adminhead('Plugins Center');

    get_plugin_list();
}

function themes_center_theme(){
	
	global $theme, $globals;

    //Admin Headers includes Global Headers
    adminhead('Plugins Center');

    echo "themes";
}

function languages_center_theme(){
	
	global $theme, $globals;

    //Admin Headers includes Global Headers
    adminhead('Plugins Center');

    echo "lang";
}
