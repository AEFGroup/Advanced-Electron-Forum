<?php
//////////////////////////////////////////////////////////////
//===========================================================
// adminindex_theme.php(Admin)
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

function adminindex_theme() {

    global $globals, $adnews, $l, $theme, $onload;

    //Pass to onload to initialize a JS
    $onload['aefinfo'] = 'load_aef_info()';

    //Admin Headers includes Global Headershttp://www.anelectron.com/aefinfo.js
    adminhead($l['<title>']);
    ?><script language="javascript" type="text/javascript" src="http://www.anelectron.com/aefinfo.js"></script>
    <script type="text/javascript">
        function load_aef_info(){
            $('aefnews').style.width = $('aefnewsholder').offsetWidth;
            //The news
            if(typeof(aef_news) == 'undefined'){
                $('aefnews').innerHTML = '<?php echo $l['conect_to_aef']; ?>';
            }else{
                var newsstr = '';
                for(x in aef_news){
                    newsstr = newsstr+'<div class="aefnewshead">'+aef_news[x][0]+'</div>'+'<div class="aefnewsblock">'+aef_news[x][1]+'</div><br />';
                }
                $('aefnews').innerHTML = newsstr;
            }
            //The current version
            if(typeof(aef_latest_version) == 'undefined'){
                $('newaefversion').innerHTML = '<i><?php echo $l['no_info']; ?></i>';
            }else{
                $('newaefversion').innerHTML = aef_latest_version;
            }
        }
    </script>
    <table width="100%" cellpadding="0" cellspacing="5" border="0">
        <tr>

            <td width="60%">

                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0"><tr>
                                    <td class="tthl"></td>
                                    <td class="tthc" align="left"><b><?php echo $l['news']; ?></b></td>
                                    <td class="tthr"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td width="100%" class="cbgbor" height="125" valign="top" id="aefnewsholder">
                            <div class="aefnews" id="aefnews"></div>
                        </td>
                    </tr>
                </table>

            </td>

            <td>

                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0"><tr>
                                    <td class="tthl"></td>
                                    <td class="tthc" align="left"><b><?php echo $l['board_info']; ?></b></td>
                                    <td class="tthr"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td width="100%" style="line-height:180%;" class="cbgbor" height="125" valign="top">
                            <div class="aefnews"><b><?php echo $l['php_version']; ?></b> : <?php echo phpversion(); ?><br />
                                <b><?php echo $l['mysql_version']; ?></b> : <?php echo mysql_get_server_info(); ?><br />
                                <b><?php echo $l['aef_version']; ?></b> : <?php echo $globals['version']; ?><br />
                                <b><?php echo $l['latest_aef_version']; ?></b> : <span id="newaefversion"></span>
                            </div>
                        </td>
                    </tr>
                </table>

            </td>

        </tr>
    </table>

    <table width="100%" cellpadding="4" cellspacing="10">
        <tr>

            <td width="10%" valign="top">
                <img src="<?php echo $theme['images']; ?>admin/support.png">
            </td>

            <td width="40%" valign="top">
                <font class="adgreen"><?php echo $l['support']; ?></font><br />
                <table cellpadding="0" cellspacing="0" class="adlink">
                    <tr><td><a href="http://www.anelectron.com/"><?php echo $l['anelectron_com']; ?></a></td></tr>
                    <tr><td><a href="http://faq.anelectron.com/"><?php echo $l['faq']; ?></a></td></tr>
                </table>
            </td>

            <td width="10%">
                <img src="<?php echo $theme['images']; ?>admin/controlpanel.png">
            </td>

            <td width="40%" valign="top">
                <font class="adgreen"><?php echo $l['control_panel']; ?></font><br />
                <table cellpadding="0" cellspacing="0" class="adlink">
                    <tr><td><a href="<?php echo $globals['index_url']; ?>act=admin&adact=conpan&seadact=coreset"><?php echo $l['core_settings']; ?></a></td></tr>
                    <tr><td><a href="<?php echo $globals['index_url']; ?>act=admin&adact=conpan&seadact=mysqlset"><?php echo $l['mysql_config']; ?></a></td></tr>
                </table>
            </td>

        </tr>

        <tr>

            <td width="10%" valign="top">
                <img src="<?php echo $theme['images']; ?>admin/categories.png">
            </td>

            <td width="40%" valign="top">
                <font class="adgreen"><?php echo $l['categories']; ?></font><br />
                <table cellpadding="0" cellspacing="0" class="adlink">
                    <tr><td><a href="<?php echo $globals['index_url']; ?>act=admin&adact=categories"><?php echo $l['manage_categories']; ?></a></td></tr>
                    <tr><td><a href="<?php echo $globals['index_url']; ?>act=admin&adact=categories&seadact=createcat"><?php echo $l['create_new']; ?></a></td></tr>
                </table>
            </td>

            <td width="10%">
                <img src="<?php echo $theme['images']; ?>admin/forums.png">
            </td>

            <td width="40%" valign="top">
                <font class="adgreen"><?php echo $l['forums']; ?></font><br />
                <table cellpadding="0" cellspacing="0" class="adlink">
                    <tr><td><a href="<?php echo $globals['index_url']; ?>act=admin&adact=forums"><?php echo $l['manage_forums']; ?></a></td></tr>
                    <tr><td><a href="<?php echo $globals['index_url']; ?>act=admin&adact=fpermissions"><?php echo $l['forum_permissions']; ?></a></td></tr>
                </table>
            </td>

        </tr>


        <tr>

            <td width="10%" valign="top">
                <img src="<?php echo $theme['images']; ?>admin/users.png">
            </td>

            <td width="40%" valign="top">
                <font class="adgreen"><?php echo $l['users']; ?></font><br />
                <table cellpadding="0" cellspacing="0" class="adlink">
                    <tr><td><a href="<?php echo $globals['index_url']; ?>act=admin&adact=users&seadact=proacc"><?php echo $l['profile_account']; ?></a></td></tr>
                    <tr><td><a href="<?php echo $globals['index_url']; ?>act=admin&adact=ug&seadact=manug"><?php echo $l['manage_user_groups']; ?></a></td></tr>
                </table>
            </td>

            <td width="10%">
                <img src="<?php echo $theme['images']; ?>admin/emailpm.png">
            </td>

            <td width="40%" valign="top">
                <font class="adgreen"><?php echo $l['email_pm']; ?></font><br />
                <table cellpadding="0" cellspacing="0" class="adlink">
                    <tr><td><a href="<?php echo $globals['index_url']; ?>act=admin&adact=conpan&seadact=mailset"><?php echo $l['mail_settings']; ?></a></td></tr>
                    <tr><td><a href="<?php echo $globals['index_url']; ?>act=admin&adact=users&seadact=pmset"><?php echo $l['pm_settings']; ?></a></td></tr>
                </table>
            </td>

        </tr>

        <tr>

            <td width="10%" valign="top">
                <img src="<?php echo $theme['images']; ?>admin/topicposts.png">
            </td>

            <td width="40%" valign="top">
                <font class="adgreen"><?php echo $l['topics_posts']; ?></font><br />
                <table cellpadding="0" cellspacing="0" class="adlink">
                    <tr><td><a href="<?php echo $globals['index_url']; ?>act=admin&adact=tpp&seadact=topics"><?php echo $l['topic_settings']; ?></a></td></tr>
                    <tr><td><a href="<?php echo $globals['index_url']; ?>act=admin&adact=tpp&seadact=posts"><?php echo $l['post_settings']; ?></a></td></tr>
                </table>
            </td>

            <td width="10%">
                <img src="<?php echo $theme['images']; ?>admin/smileys.png">
            </td>

            <td width="40%" valign="top">
                <font class="adgreen"><?php echo $l['smileys']; ?></font><br />
                <table cellpadding="0" cellspacing="0" class="adlink">
                    <tr><td><a href="<?php echo $globals['index_url']; ?>act=admin&adact=smileys&seadact=smman"><?php echo $l['manage_smileys']; ?></a></td></tr>
                    <tr><td><a href="<?php echo $globals['index_url']; ?>act=admin&adact=smileys&seadact=smset"><?php echo $l['smiley_settings']; ?></a></td></tr>
                </table>
            </td>

        </tr>

    </table>
    <?php
    //Admin footers includes Global footers
    adminfoot();
}

function credits_theme() {

    global $globals, $adnews, $l, $theme, $onload;

    //Admin Headers includes Global Headershttp://www.anelectron.com/aefinfo.js
    adminhead($l['<title>']);
    ?>

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <tr>
            <td align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/credits.gif">
            </td>
            <td align="left" class="adcbg1">

                <font class="adgreen"><?php echo $l['credtits_thanks']; ?></font><br />

            </td>
        </tr>

        <tr>
            <td align="left" colspan="2" class="adbg">
                <?php echo $l['credtits_exp']; ?>
            </td>
        </tr>

    </table>
    <br /><br />

    <table width="100%" cellpadding="2" cellspacing="1" class="cbor">

        <tr>
            <td class="adcbg">
                <?php echo $l['thanks']; ?>
            </td>
        </tr>

        <tr>
            <td class="adbg" align="center">
                <?php echo $l['you']; ?>
            </td>
        </tr>

        <tr>
            <td class="adbg" align="center">
                <font size="4"><a href="http://www.anelectron.com/board/">AEF Community</a></font>
            </td>
        </tr>

        <tr>
            <td class="adbg">
                <?php echo $l['founder']; ?> - <a href="http://www.anelectron.com/board/index.php?mid=1">electron</a>, <a href="http://www.anelectron.com/board/index.php?mid=2">pulkit</a>, <a href="http://www.anelectron.com/board/index.php?mid=4721">SAFAD</a>
            </td>
        </tr>

        <tr>
            <td class="adbg">
                <?php echo $l['uni_mod']; ?> - <a href="http://www.anelectron.com/board/index.php?mid=145">jlhaslip</a>
            </td>
        </tr>

        <tr>
            <td class="adbg">
                <?php echo $l['developer']; ?> - <a href="http://www.anelectron.com/board/index.php?mid=225">elwizard</a>, <a href="http://www.anelectron.com/board/index.php?mid=366">Lewtheo</a>, <a href="http://www.anelectron.com/board/index.php?mid=14088">Cruz Bishop</a>
            </td>
        </tr>

        <tr>
            <td class="adbg">
                <?php echo $l['themers']; ?> - <a href="http://www.anelectron.com/board/index.php?mid=638">husmen73</a>, <a href="http://www.anelectron.com/board/index.php?mid=847">Joshy</a>, <a href="http://www.anelectron.com/board/index.php?mid=1428">Armando_G</a>
            </td>
        </tr>

        <tr>
            <td class="adbg">
                <?php echo $l['docs']; ?> - <a href="http://www.anelectron.com/board/index.php?mid=344">kab012345</a>
            </td>
        </tr>

        <tr>
            <td class="adbg">
                <?php echo $l['manager']; ?> - <a href="http://www.anelectron.com/board/index.php?mid=1433">CarlF</a>
            </td>
        </tr>

    </table>
    <?php
    //Admin footers includes Global footers
    adminfoot();
}
?>