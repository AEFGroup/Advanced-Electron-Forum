<?php

function usercpindex_theme() {

    global $globals, $l, $theme;

    //The global User CP Headers
    usercphead($l['uin_users_cp']);
    ?>
    <table width="100%" cellpadding="4" cellspacing="4" border="0">

        <tr>
            <td width="50%">

                <table width="100%" cellpadding="1" cellspacing="1" onmouseover="this.className='ucpon'" onmouseout="this.className='ucpnor'" class="ucpnor" border="0" onclick="window.location='<?php echo $globals['index_url']; ?>act=usercp&ucpact=profile'">
                    <tr>
                        <td width="30%"><img src="<?php echo $theme['images']; ?>usercp/general.gif" /></td>
                        <td class="ucpicol"><font class="ucpihtxt"><?php echo $l['uin_your_profile']; ?></font><br />
                            <?php echo $l['uin_your_profile_exp']; ?></td>
                    </tr>
                </table>

            </td>

            <td width="50%">

                <table width="100%" cellpadding="1" cellspacing="1" onmouseover="this.className='ucpon'" onmouseout="this.className='ucpnor'" class="ucpnor" border="0" onclick="window.location='<?php echo $globals['index_url']; ?>act=usercp&ucpact=account'">
                    <tr>
                        <td width="30%"><img src="<?php echo $theme['images']; ?>usercp/account.gif" /></td>
                        <td class="ucpicol"><font class="ucpihtxt"><?php echo $l['uin_account_settings']; ?></font><br />
                            <?php echo $l['uin_account_settings_exp']; ?></td>
                    </tr>
                </table>

            </td>
        </tr>

        <tr>
            <td width="50%">

                <table width="100%" cellpadding="1" cellspacing="1" onmouseover="this.className='ucpon'" onmouseout="this.className='ucpnor'" class="ucpnor" border="0" onclick="window.location='<?php echo $globals['index_url']; ?>act=usercp&ucpact=inbox'">
                    <tr>
                        <td width="30%"><img src="<?php echo $theme['images']; ?>usercp/inbox.gif" /></td>
                        <td class="ucpicol"><font class="ucpihtxt"><?php echo $l['uin_inbox']; ?></font><br />
                            <?php echo $l['uin_inbox_exp']; ?></td>
                    </tr>
                </table>

            </td>

            <td width="50%">

                <table width="100%" cellpadding="1" cellspacing="1" onmouseover="this.className='ucpon'" onmouseout="this.className='ucpnor'" class="ucpnor" border="0" onclick="window.location='<?php echo $globals['index_url']; ?>act=usercp&ucpact=writepm'">
                    <tr>
                        <td width="30%"><img src="<?php echo $theme['images']; ?>usercp/compose.gif" /></td>
                        <td class="ucpicol"><font class="ucpihtxt"><?php echo $l['uin_compose_pm']; ?></font><br />
                            <?php echo $l['uin_compose_pm_exp']; ?></td>
                    </tr>
                </table>

            </td>
        </tr>

        <tr>
            <td width="50%">

                <table width="100%" cellpadding="1" cellspacing="1" onmouseover="this.className='ucpon'" onmouseout="this.className='ucpnor'" class="ucpnor" border="0" onclick="window.location='<?php echo $globals['index_url']; ?>act=usercp&ucpact=searchpm'">
                    <tr>
                        <td width="30%"><img src="<?php echo $theme['images']; ?>usercp/searchpm.gif" /></td>
                        <td class="ucpicol"><font class="ucpihtxt"><?php echo $l['uin_search_pm']; ?></font><br />
                            <?php echo $l['uin_search_pm_exp']; ?></td>
                    </tr>
                </table>

            </td>

            <td width="50%">

                <table width="100%" cellpadding="1" cellspacing="1" onmouseover="this.className='ucpon'" onmouseout="this.className='ucpnor'" class="ucpnor" border="0" onclick="window.location='<?php echo $globals['index_url']; ?>act=usercp&ucpact=emptyfolders'">
                    <tr>
                        <td width="30%"><img src="<?php echo $theme['images']; ?>usercp/bin.gif" /></td>
                        <td class="ucpicol"><font class="ucpihtxt"><?php echo $l['uin_recycle_pm']; ?></font><br />
                            <?php echo $l['uin_recycle_pm_exp']; ?></td>
                    </tr>
                </table>

            </td>
        </tr>

        <tr>
            <td width="50%">

                <table width="100%" cellpadding="1" cellspacing="1" onmouseover="this.className='ucpon'" onmouseout="this.className='ucpnor'" class="ucpnor" border="0" onclick="window.location='<?php echo $globals['index_url']; ?>act=usercp&ucpact=emailpmset'">
                    <tr>
                        <td width="30%"><img src="<?php echo $theme['images']; ?>usercp/emailpmsettings.gif" /></td>
                        <td class="ucpicol"><font class="ucpihtxt"><?php echo $l['uin_email_pm_set']; ?></font><br />
                            <?php echo $l['uin_email_pm_set_exp']; ?></td>
                    </tr>
                </table>

            </td>

            <td width="50%">

                <table width="100%" cellpadding="1" cellspacing="1" onmouseover="this.className='ucpon'" onmouseout="this.className='ucpnor'" class="ucpnor" border="0" onclick="window.location='<?php echo $globals['index_url']; ?>act=usercp&ucpact=forumset'">
                    <tr>
                        <td width="30%"><img src="<?php echo $theme['images']; ?>usercp/boardsettings.gif" /></td>
                        <td class="ucpicol"><font class="ucpihtxt"><?php echo $l['uin_forum_set']; ?></font><br />
                            <?php echo $l['uin_forum_set_exp']; ?></td>
                    </tr>
                </table>

            </td>
        </tr>

        <tr>
            <td width="50%">

                <table width="100%" cellpadding="1" cellspacing="1" onmouseover="this.className='ucpon'" onmouseout="this.className='ucpnor'" class="ucpnor" border="0" onclick="window.location='<?php echo $globals['index_url']; ?>act=usercp&ucpact=topicsub'">
                    <tr>
                        <td width="30%"><img src="<?php echo $theme['images']; ?>usercp/topicnotifications.gif" /></td>
                        <td class="ucpicol"><font class="ucpihtxt"><?php echo $l['uin_topic_subscriptions']; ?></font><br />
                            <?php echo $l['uin_topic_subscriptions_exp']; ?></td>
                    </tr>
                </table>

            </td>

            <td width="50%">

                <table width="100%" cellpadding="1" cellspacing="1" onmouseover="this.className='ucpon'" onmouseout="this.className='ucpnor'" class="ucpnor" border="0" onclick="window.location='<?php echo $globals['index_url']; ?>act=usercp&ucpact=forumsub'">
                    <tr>
                        <td width="30%"><img src="<?php echo $theme['images']; ?>usercp/forumnotifications.gif" /></td>
                        <td class="ucpicol"><font class="ucpihtxt"><?php echo $l['uin_forum_subscriptions']; ?></font><br />
                            <?php echo $l['uin_forum_subscriptions_exp']; ?></td>
                    </tr>
                </table>

            </td>
        </tr>

    </table>
    <?php
    //The global User CP Footers
    usercpfoot();
}
?>