<?php

function profile_theme() {

    global $user, $logged_in, $globals, $AEF_SESS, $theme, $member, $l;

    //The header
    aefheader($l['<title>'] . ' ' . $member['username']);

    $options = array();

    // Give options if they are not of MY account AND
    // it is not the ROOT ADMINS account AND
    // if it is an Admins Account only ROOT ADMIN can ban or delete
    if ($member['id'] != $user['id'] && $member['id'] != 1 &&
            ($member['member_group'] == 1 ? ($user['id'] == 1 ? true : false) : true)) {

        //Can he deleteuser
        if (!empty($user['can_del_other_account'])) {

            $options[] = '<a href="' . $globals['index_url'] . 'act=deleteuser&uid=' . $member['id'] . '"><img src="' . $theme['images'] . 'buttons/deleteuser.png"></a>';
        }

        //Can ban user
        if (!empty($user['can_ban_user'])) {

            if ($member['u_member_group'] == -3) {

                $options[] = '<a href="' . $globals['index_url'] . 'act=ban&do=lift&uid=' . $member['id'] . '"><img src="' . $theme['images'] . 'buttons/removeban.png"></a>';
            } else {

                $options[] = '<a href="' . $globals['index_url'] . 'act=ban&do=put&uid=' . $member['id'] . '"><img src="' . $theme['images'] . 'buttons/banuser.png"></a>';
            }
        }


        //Can he edit others profile
        if (!empty($user['can_edit_other_profile'])) {

            $options[] = '<a href="' . $globals['index_url'] . 'act=editprofile&uid=' . $member['id'] . '"><img src="' . $theme['images'] . 'buttons/editprofile.png"></a>';
        }
    }

    if (!empty($options)) {

        echo '<br />' . implode('&nbsp;&nbsp;', $options);
    }
    ?>
    <br /><br /><br />
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table width="100%" cellpadding="0" cellspacing="0"><tr>
                        <td class="cbgl"></td>
                        <td class="cbg"><?php echo $l['profile_heading'] . ' ' . $member['username']; ?></td>
                        <td class="cbgr"></td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td width="100%">

                <table width="100%" cellpadding="2" cellspacing="0" class="cbgbor">

                    <tr>
                        <td colspan="4" class="ucpflc" align="center">
                            <h1><?php echo $member['username']; ?></h1>
                        </td>
                    </tr>

                    <tr>
                        <td width="15%" class="ucpflc">
                            <b><?php echo $l['avatar']; ?>:</b>
                        </td>

                        <td width="30%" class="ucpfrc" align="center">
                            <?php
                            if (!empty($member['avatarurl'])) {

                                echo '<img src="' . $member['avatarurl'][0] . '" height="' . $member['avatarurl'][2] . '" width="' . $member['avatarurl'][1] . '" />';
                            }
                            ?>
                        </td>

                        <td width="15%" class="ucpflc">
                            <b><?php echo $l['personal_picture']; ?>:</b>
                        </td>

                        <td width="30%" class="ucpfrc" align="center">
                            <?php
                            if (!empty($member['ppicurl'])) {

                                echo '<img src="' . $member['ppicurl'][0] . '" height="' . $member['ppicurl'][2] . '" width="' . $member['ppicurl'][1] . '" />';
                            }
                            ?>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>

        <tr>
            <td><img src="<?php echo $theme['images']; ?>cbot.png" width="100%" height="15"></td>
        </tr>

    </table>

    <br />

    <!--Holding Table-->
    <table width="100%" cellpadding="0" cellspacing="2">

        <tr>

            <td width="50%" valign="top">
                <!--Information Table-->

                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0"><tr>
                                    <td class="cbgl"></td>
                                    <td class="cbg"><?php echo $l['information_heading']; ?></td>
                                    <td class="cbgr"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>

                            <table width="100%" cellpadding="4" cellspacing="1" class="cbgbor">

                                <tr>
                                    <td width="35%" class="ucpflc">
                                        <b><?php echo $l['name']; ?> :</b>
                                    </td>

                                    <td width="65%" class="ucpfrc" align="left">
                                        <?php echo (empty($member['realname']) ? '<i>' . $l['no_info'] . '</i>' : $member['realname']); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="ucpflc">
                                        <b><?php echo $l['date_of_birth']; ?> :</b>
                                    </td>

                                    <td class="ucpfrc" align="left">
                                        <?php echo ($member['birth_date'] == '0000-00-00' ? '<i>' . $l['no_info'] . '</i>' : $member['birth_date']); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="ucpflc">
                                        <b><?php echo $l['gender']; ?> :</b>
                                    </td>

                                    <td class="ucpfrc" align="left">
                                        <?php
                                        if ($member['gender'] == 1)
                                            echo 'Male';
                                        elseif ($member['gender'] == 2)
                                            echo 'Female';
                                        else
                                            echo $l['no_info'];
                                        ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="ucpflc">
                                        <b><?php echo $l['join_date']; ?> :</b>
                                    </td>

                                    <td class="ucpfrc" align="left">
                                        <?php echo datify($member['r_time']); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="ucpflc">
                                        <b><?php echo $l['member_group']; ?> :</b>
                                    </td>

                                    <td class="ucpfrc" align="left">
                                        <?php echo $member['mem_gr_name']; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="ucpflc">
                                        <b><?php echo $l['posts']; ?> :</b>
                                    </td>

                                    <td class="ucpfrc" align="left">
                                        <?php echo $member['posts'] . ' (<a href="' . $globals['index_url'] . 'act=search&sact=results&allwords=&exactphrase=&atleastone=&without=&within=1&starter=' . $member['username'] . '&forums%5B%5D=0&showas=2&search=Search">' . $l['show_posts'] . '</a>)'; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="ucpflc">
                                        <b><?php echo $l['last_active']; ?> :</b>
                                    </td>

                                    <td class="ucpfrc" align="left">
                                        <?php echo (empty($member['lastlogin_1']) ? '<i>' . $l['no_info'] . '</i>' : datify($member['lastlogin_1'])); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="ucpflc">
                                        <b><?php echo $l['users_text']; ?> :</b>
                                    </td>

                                    <td class="ucpfrc" align="left">
                                        <?php echo $member['users_text']; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="ucpflc">
                                        <b><?php echo $l['custom_title']; ?> :</b>
                                    </td>

                                    <td class="ucpfrc" align="left">
                                        <?php echo $member['customtitle']; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="ucpflc">
                                        <b><?php echo $l['location']; ?> :</b>
                                    </td>

                                    <td class="ucpfrc" align="left">
                                        <?php echo $member['location']; ?>
                                    </td>
                                </tr>

                            </table>

                        </td>
                    </tr>


                </table>

            </td>

            <td width="50%" valign="top">

                <!--Contact Table-->

                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0"><tr>
                                    <td class="cbgl"></td>
                                    <td class="cbg"><?php echo $l['contact_heading']; ?></td>
                                    <td class="cbgr"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>

                            <table width="100%" cellpadding="5" cellspacing="1" class="cbgbor" height="100%">

                                <tr>
                                    <td width="35%" class="ucpflc">
                                        <b><?php echo $l['site']; ?> :</b>
                                    </td>

                                    <td width="65%" class="ucpfrc" align="left">
                                        <?php echo (empty($member['www']) ? '<i>' . $l['no_info'] . '</i>' : '<a href="' . $member['www'] . '">' . $member['www'] . '</a>'); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="ucpflc">
                                        <b><?php echo $l['email']; ?> :</b>
                                    </td>

                                    <td class="ucpfrc" align="left">
                                        <?php echo (empty($member['email']) ? '<i>' . $l['no_info'] . '</i>' : '<a href="mailto:' . $member['email'] . '">' . $member['email'] . '</a>'); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="ucpflc">
                                        <b><?php echo $l['personal_message']; ?> :</b>
                                    </td>

                                    <td class="ucpfrc" align="left">
                                        <?php echo ($logged_in ? '<a href="' . $globals['index_url'] . 'act=usercp&ucpact=writepm&to=' . $member['id'] . '"><img src="' . $theme['images'] . 'pmuser.gif" title="Send a PM ' . $member['username'] . '" /></a>' : ''); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="ucpflc">
                                        <b><?php echo $l['msn']; ?> :</b>
                                    </td>

                                    <td class="ucpfrc" align="left">
                                        <?php echo (empty($member['msn']) ? '<i>' . $l['no_info'] . '</i>' : '<a href="http://members.msn.com/' . $member['msn'] . '" target="_blank">' . $member['msn'] . '</a>'); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="ucpflc">
                                        <b><?php echo $l['aim']; ?> :</b>
                                    </td>

                                    <td class="ucpfrc" align="left">
                                        <?php echo (empty($member['aim']) ? '<i>' . $l['no_info'] . '</i>' : $member['aim']); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="ucpflc">
                                        <b><?php echo $l['yim']; ?> :</b>
                                    </td>

                                    <td class="ucpfrc" align="left">
                                        <?php echo (empty($member['yim']) ? '<i>' . $l['no_info'] . '</i>' : $member['yim']); ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="ucpflc">
                                        <b><?php echo $l['gmail']; ?> :</b>
                                    </td>

                                    <td class="ucpfrc" align="left">
                                        <?php echo (empty($member['gmail']) ? '<i>' . $l['no_info'] . '</i>' : $member['gmail']); ?>
                                    </td>
                                </tr>


                                <tr>
                                    <td class="ucpflc">&nbsp;

                                    </td>

                                    <td class="ucpfrc" align="left">&nbsp;

                                    </td>
                                </tr>

                            </table>

                        </td>
                    </tr>

                </table>

            </td>

        </tr>

        <tr>
            <td colspan="2">
                <br />
                <!--Signature Table-->
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table width="100%" cellpadding="0" cellspacing="0"><tr>
                                    <td class="cbgl"></td>
                                    <td class="cbg"><?php echo $l['members_signature_heading']; ?></td>
                                    <td class="cbgr"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table width="100%" cellpadding="5" cellspacing="1" class="cbgbor" height="100%">

                                <tr>
                                    <td class="ucpflc">
                                        <?php echo (empty($member['sig']) ? '<i>' . $l['no_signature'] . '</i>' : $member['sig']); ?>
                                    </td>
                                </tr>

                            </table>

                        </td>
                    </tr>
                    <tr>
                        <td><img src="<?php echo $theme['images']; ?>cbot.png" width="100%" height="15"></td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

    <?php
    //The defualt footers
    aeffooter();
}
?>