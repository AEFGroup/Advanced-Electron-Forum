<?php
//////////////////////////////////////////////////////////////
//===========================================================
// usergroups_theme.php(Admin)
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

function manug_theme() {

    global $globals, $l, $theme, $user_group, $post_group;

    //Admin Headers includes Global Headers
    adminhead($l['ugr_cp_ugroups']);
    ?>

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <tr>
            <td align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/usergroups.png">
            </td>
            <td align="left" class="adcbg1">

                <span class="adgreen"><?php echo $l['ugr_ugroups']; ?></span><br />

            </td>
        </tr>

        <tr>
            <td align="left" colspan="2" class="adbg">
                <?php echo $l['ugr_ugroups_exp']; ?>
            </td>
        </tr>

    </table>
    <br /><br />

    <table width="100%" cellpadding="5" cellspacing="1" class="cbor">
        <tr>
            <td class="adcbg" colspan="7">
                <?php echo $l['ugr_ugroups']; ?>
            </td>
        </tr>

        <tr align="center">
            <td class="adcbg2" width="50%">
                <b><?php echo $l['ugr_name']; ?></b>
            </td>
            <td class="adcbg2" width="25%">
                <b><?php echo $l['ugr_stars']; ?></b>
            </td>
            <td class="adcbg2" width="10%">
                <b><?php echo $l['ugr_edit']; ?></b>
            </td>
            <td class="adcbg2" width="15%">
                <b><?php echo $l['ugr_delete']; ?></b>
            </td>
        </tr>

        <?php
        foreach ($user_group as $uk => $uv) {

            echo '<tr>
    <td class="adbg" align="left">
    <span color="' . $user_group[$uk]['mem_gr_colour'] . '">' . $user_group[$uk]['mem_gr_name'] . '</span>
    </td>
    <td class="adbg">';
            for ($i = 1; $i <= $user_group[$uk]['image_count']; $i++) {
                echo '<img src="' . $theme['images'] . $user_group[$uk]['image_name'] . '" />';
            }
            echo '</td>
    <td class="adbg" align="center">
    <a href="' . $globals['index_url'] . 'act=admin&adact=ug&seadact=editug&ugid=' . $user_group[$uk]['member_group'] . '">' . $l['ugr_edit'] . '</a>
    </td>
    <td class="adbg" align="center">
    <a href="' . $globals['index_url'] . 'act=admin&adact=ug&seadact=delug&ugid=' . $user_group[$uk]['member_group'] . '">' . $l['ugr_delete'] . '</a>
    </td>
    </tr>';
        }
        ?>

    </table>
    <br />

    <table width="100%" cellpadding="5" cellspacing="1" class="cbor">
        <tr>
            <td class="adcbg" colspan="7">
                <?php echo $l['ugr_post_groups']; ?>
            </td>
        </tr>

        <tr align="center">
            <td class="adcbg2" width="40%">
                <b><?php echo $l['ugr_name']; ?></b>
            </td>
            <td class="adcbg2" width="25%">
                <b><?php echo $l['ugr_stars']; ?></b>
            </td>
            <td class="adcbg2" width="10%">
                <b>Posts</b>
            </td>
            <td class="adcbg2" width="10%">
                <b><?php echo $l['ugr_edit']; ?></b>
            </td>
            <td class="adcbg2" width="15%">
                <b><?php echo $l['ugr_delete']; ?></b>
            </td>
        </tr>

        <?php
        foreach ($post_group as $pk => $pv) {

            echo '<tr>
    <td class="adbg" align="left">
    <span color="' . $post_group[$pk]['mem_gr_colour'] . '">' . $post_group[$pk]['mem_gr_name'] . '</span>
    </td>
    <td class="adbg">';
            for ($i = 1; $i <= $post_group[$pk]['image_count']; $i++) {
                echo '<img src="' . $theme['images'] . $post_group[$pk]['image_name'] . '" />';
            }
            echo '</td>
    <td class="adbg" align="center">
    ' . $post_group[$pk]['post_count'] . '
    </td>
    <td class="adbg" align="center">
    <a href="' . $globals['index_url'] . 'act=admin&adact=ug&seadact=editug&ugid=' . $post_group[$pk]['member_group'] . '">' . $l['ugr_edit'] . '</a>
    </td>
    <td class="adbg" align="center">
    <a href="' . $globals['index_url'] . 'act=admin&adact=ug&seadact=delug&ugid=' . $post_group[$pk]['member_group'] . '">' . $l['ugr_delete'] . '</a>
    </td>
    </tr>';
        }
        ?>

    </table>
    <br />

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">
        <tr>
            <td align="center" class="adbg">
                <form accept-charset="<?php echo $globals['charset']; ?>" method="get" action="<?php echo $globals['index_url']; ?>" name="addgroup">
                    <input type="hidden" name="seadact" value="addug" />
                    <?php
                    foreach ($_GET as $k => $v) {
                        echo ($k == 'seadact' ? '' : '<input type="hidden" name="' . $k . '" value="' . $v . '" />' );
                    }
                    ?><?php echo $l['ugr_delete']; ?>
                    <select name="ugid">
                        <?php
                        foreach ($user_group as $uk => $uv) {
                            echo '<option value="' . $user_group[$uk]['member_group'] . '">' . $user_group[$uk]['mem_gr_name'] . '</option>';
                        }
                        ?>
                    </select>&nbsp;&nbsp;<input type="submit" value="<?php echo $l['ugr_add_new_ug']; ?>" />
                </form>
            </td>
        </tr>
    </table>

    <?php
    adminfoot();
}

//Edit User Groups
function editug_theme() {

    global $globals, $l, $theme, $error, $user_group;

    //Admin Headers includes Global Headers
    adminhead($l['ugr_cp_edit_ugroups']);
    ?>

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <tr>
            <td align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/usergroups.png">
            </td>
            <td align="left" class="adcbg1">

                <span class="adgreen"><?php echo $l['ugr_edit_ugroups']; ?></span><br />

            </td>
        </tr>

        <tr>
            <td align="left" colspan="2" class="adbg">
                <?php echo $l['ugr_edit_ugroups_exp']; ?>
            </td>
        </tr>

    </table>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="editugform">
        <table width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <tr>
                <td class="adcbg" colspan="2">
                    <?php echo $l['ugr_edit_ugroups']; ?>
                </td>
            </tr>

            <tr>
                <td width="45%" class="adbg">
                    <b><?php echo $l['ugr_ugroup_name']; ?></b><br />
                    <span class="adexp"><?php echo $l['ugr_ugroup_name_exp']; ?></span>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="mem_gr_name" value="<?php echo (empty($_POST['mem_gr_name']) ? $user_group['mem_gr_name'] : $_POST['mem_gr_name']); ?>" />
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><?php echo $l['ugr_ugroup_colour']; ?></b><br />
                    <span class="adexp"><?php echo $l['ugr_ugroup_colour_exp']; ?></span>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="mem_gr_colour" value="<?php echo (empty($_POST['mem_gr_colour']) ? $user_group['mem_gr_colour'] : $_POST['mem_gr_colour']); ?>" />
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><?php echo $l['ugr_ugroup_image']; ?></b><br />
                    <span class="adexp"><?php echo $l['ugr_ugroup_image_exp']; ?></span>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="image_name" value="<?php echo (empty($_POST['image_name']) ? $user_group['image_name'] : $_POST['image_name']); ?>" />
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><?php echo $l['ugr_num_stars']; ?></b><br />
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="image_count" value="<?php echo (empty($_POST['image_count']) ? $user_group['image_count'] : $_POST['image_count']); ?>" />
                </td>
            </tr>


            <?php
            if (!in_array($user_group['member_group'], array(-3, -1, 0, 1, 3))) {
                echo '<tr>
        <td class="adbg">
        <b>' . $l['ugr_post_based'] . '</b><br />
        <span class="adexp">' . $l['ugr_post_based_exp'] . '</span>
        </td>
        <td class="adbg" align="left">
        &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="post_based" ' . (isset($_POST['post_based']) || $user_group['post_count'] != -1 ? 'checked="checked"' : '' ) . ' />
        </td>
        </tr>';
                echo '<tr>
        <td class="adbg">
        <b>' . $l['ugr_num_posts'] . '</b><br />
        <span class="adexp">' . $l['ugr_num_posts_exp'] . '</span>
        </td>
        <td class="adbg" align="left">
        &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="post_count" value="' . (empty($_POST['post_count']) ? $user_group['post_count'] : $_POST['post_count']) . '" />
        </td>
        </tr>';
            }
            ?>

        </table>

        <br /><br />

        <?php
        $admin_per = array('can_admin' => array('yn', $l['ugr_can_admin'], ''),
            'allow_html' => array('yn', $l['ugr_can_html'], $l['ugr_even_js']),
            'view_ip' => array('yn', $l['ugr_view_ips'], ''),
            'view_offline_board' => array('yn', $l['ugr_can_maint'], '')
        );

        $forum_per = array('view_forum' => array('yn', $l['ugr_can_view_f'], ''),
            'can_search' => array('yn', $l['ugr_can_search'], ''),
            'can_email_mem' => array('yn', $l['ugr_can_email_memb'], ''),
            'can_email_friend' => array('yn', $l['ugr_can_email_friend'], $l['ugr_can_email_friend_exp']),
            'view_active' => array('yn', $l['ugr_can_view_act_list'], ''),
            'hide_online' => array('yn', $l['ugr_can_hide_status'], ''),
            'view_anonymous' => array('yn', $l['ugr_can_view_anonys'], ''),
            'view_members' => array('yn', $l['ugr_can_view_memb_list'], ''),
            'view_stats' => array('yn', $l['ugr_can_view_stats'], ''),
            'view_calendar' => array('yn', $l['ugr_can_view_cal'], '')
        );

        $profile_per = array('prefix' => array('inputtext', $l['ugr_prefix'], ''),
            'suffix' => array('inputtext', $l['ugr_suffix'], ''),
            'use_avatar' => array('yn', $l['ugr_can_avatars_fboard'], ''),
            'url_avatar' => array('yn', $l['ugr_can_avatars_url'], ''),
            'upload_avatar' => array('yn', $l['ugr_can_avatars_upload'], ''),
            'can_view_profile' => array('yn', $l['ugr_can_view_memb_profile'], ''),
            'can_edit_own_profile' => array('yn', $l['ugr_can_edit_own_prof'], ''),
            'can_edit_other_profile' => array('yn', $l['ugr_can_edit_other_prof'], ''),
            'can_del_own_account' => array('yn', $l['ugr_can_del_own_account'], ''),
            'can_del_other_account' => array('yn', $l['ugr_can_del_other_account'], ''),
            'can_ban_user' => array('yn', $l['ugr_can_ban'], ''),
        );

        $topic_per = array('can_post_topic' => array('yn', $l['ugr_can_start_topics'], ''),
            'can_edit_own_topic' => array('yn', $l['ugr_can_edit_own_topics'], ''),
            'can_edit_other_topic' => array('yn', $l['ugr_can_edit_other_topics'], ''),
            'can_del_own_topic' => array('yn', $l['ugr_can_del_own_topics'], ''),
            'can_del_other_topic' => array('yn', $l['ugr_can_del_other_topics'], ''),
            'approve_topics' => array('yn', $l['ugr_approve_topics'], $l['ugr_approve_topics_exp']),
            'can_merge_topics' => array('yn', $l['ugr_merge_topics'], ''),
            'can_merge_posts' => array('yn', $l['ugr_merge_posts'], ''),
            'can_split_topics' => array('yn', $l['ugr_split_topics'], ''),
            'can_email_topic' => array('yn', $l['ugr_email_topics_friends'], ''),
            'can_make_sticky' => array('yn', $l['ugr_sticky_topics'], ''),
            'can_move_own_topic' => array('yn', $l['ugr_move_own_topics'], ''),
            'can_move_other_topic' => array('yn', $l['ugr_move_other_topics'], ''),
            'can_lock_own_topic' => array('yn', $l['ugr_lock_own_topics'], ''),
            'can_lock_other_topic' => array('yn', $l['ugr_lock_other_topics'], ''),
            'can_announce_topic' => array('yn', $l['ugr_announ_opics'], ''),
            'notify_new_posts' => array('yn', $l['ugr_subsc_topics'], ''),
            'notify_new_topics' => array('yn', $l['ugr_subsc_forums'], ''),
            'has_priviliges' => array('yn', $l['ugr_has_priv'], '')
        );

        $post_per = array('can_reply' => array('yn', $l['ugr_reply_topics'], ''),
            'can_edit_own' => array('yn', $l['ugr_edit_own_posts'], ''),
            'can_edit_other' => array('yn', $l['ugr_edit_other_posts'], ''),
            'can_del_own_post' => array('yn', $l['ugr_del_own_posts'], ''),
            'can_del_other_post' => array('yn', $l['ugr_del_other_posts'], ''),
            'approve_posts' => array('yn', $l['ugr_approve_posts'], $l['ugr_approve_posts_exp']),
            'can_report_post' => array('yn', $l['ugr_can_report_posts'], '')
        );

        $poll_per = array('can_view_poll' => array('yn', $l['ugr_view_polls'], ''),
            'can_vote_polls' => array('yn', $l['ugr_vote_polls'], ''),
            'can_post_polls' => array('yn', $l['ugr_can_start_polls'], ''),
            'can_edit_own_poll' => array('yn', $l['ugr_edit_own_polls'], ''),
            'can_edit_other_poll' => array('yn', $l['ugr_edit_other_polls'], ''),
            'add_poll_topic_own' => array('yn', $l['ugr_add_poll_self'], ''),
            'add_poll_topic_other' => array('yn', $l['ugr_add_poll_other'], ''),
            'can_rem_own_poll' => array('yn', $l['ugr_rem_poll_self'], ''),
            'can_rem_other_poll' => array('yn', $l['ugr_rem_poll_other'], ''),
        );

        $att_per = array('can_attach' => array('yn', $l['ugr_can_attach_files'], ''),
            'can_view_attach' => array('yn', $l['ugr_down_attach'], ''),
            'can_remove_attach' => array('yn', $l['ugr_rem_attach'], ''),
            'max_attach' => array('inputtext', $l['ugr_max_attach_size'], $l['ugr_in_kb'])
        );

        $news_per = array('can_submit_news' => array('yn', $l['ugr_can_subm_news'], ''),
            'can_approve_news' => array('yn', $l['ugr_can_approv_news'], ''),
            'can_edit_news' => array('yn', $l['ugr_can_edit_news'], ''),
            'can_delete_news' => array('yn', $l['ugr_can_del_news'], '')
        );

        $pm_per = array('can_use_pm' => array('yn', $l['ugr_can_use_pm'], ''),
            'max_stored_pm' => array('inputtext', $l['ugr_max_pm'], $l['ugr_max_pm_exp']),
            'max_mass_pm' => array('inputtext', $l['ugr_num_users_pm'], $l['ugr_max_pm_exp']),
            'can_report_pm' => array('yn', $l['ugr_can_repost_pm'], '')
        );

        $shoutbox_per = array('can_shout' => array('yn', $l['ugr_can_shout'], $l['ugr_can_shout_exp']),
            'can_del_shout' => array('yn', $l['ugr_del_shouts'], $l['ugr_del_shouts_exp'])
        );

        $permissions = array($l['ugr_topic_perms'] => $topic_per,
            $l['ugr_post_perms'] => $post_per,
            $l['ugr_poll_perms'] => $poll_per,
            $l['ugr_attach_perms'] => $att_per,
            $l['ugr_news_perms'] => $news_per,
            $l['ugr_pm_perms'] => $pm_per,
            $l['ugr_admin_perms'] => $admin_per,
            $l['ugr_gen_board_perms'] => $forum_per,
            $l['ugr_prof_opt'] => $profile_per,
            $l['ugr_shoutbox_perms'] => $shoutbox_per
        );

        //No you cant do it for admins
        if ($user_group['member_group'] != 1) {

            echo '<table width="100%" cellpadding="2" cellspacing="1" class="cbor">
        <tr>
        <td class="adcbg" colspan="2">
        ' . $l['ugr_perms'] . '
        </td>
        </tr>';

            foreach ($permissions as $k => $v) {

                echo '<tr>
    <td class="adcbg2" colspan="2">
    ' . $k . '
    </td>
    </tr>';

                foreach ($v as $pk => $pv) {

                    echo '<tr>
    <td class="adbg" width="50%">
    ' . $pv[1] . ' :<br />
    ' . (empty($pv[2]) ? '' : '<span class="adexp">' . $pv[2] . '</span>') . '
    </td>
    <td class="adbg" align="left">
    &nbsp;&nbsp;&nbsp;&nbsp;' . call_user_func($pv[0], $pk) . '
    </td>
    </tr>';
                }
            }

            echo '<tr>
    <td class="adbg" width="50%" valign="top">
    ' . $l['ugr_mess_to_group'] . '
    </td>
    <td class="adbg" align="left">
    &nbsp;&nbsp;&nbsp;&nbsp;<textarea cols="30" rows="5" name="group_message">' . (empty($_POST['group_message']) ? $user_group['group_message'] : $_POST['group_message']) . '</textarea>
    </td>
    </tr>


    </table>
    <br /><br />';
        }
        ?>


        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <tr>
                <td align="center" class="adbg">
                    <input type="submit" name="editug" value="<?php echo $l['ugr_submit']; ?>" />
                </td>
            </tr>
        </table>

    </form>

    <?php
    adminfoot();
}

function yn($name) {

    global $user_group, $l;

    return '<input type="radio" name="' . $name . '" value="1" ' . (isset($_POST[$name]) && $_POST[$name] == 1 ? 'checked="checked"' : ($user_group[$name] == 1 ? 'checked="checked"' : '') ) . ' />&nbsp;' . $l['ugr_yes'] . '&nbsp;&nbsp;<input type="radio" name="' . $name . '" value="0" ' . (isset($_POST[$name]) && $_POST[$name] == 0 ? 'checked="checked"' : (empty($user_group[$name]) ? 'checked="checked"' : '') ) . ' />&nbsp;' . $l['ugr_no'] . '';
}

function inputtext($name) {

    global $user_group;

    return '<input type="text" name="' . $name . '" value="' . (empty($_POST[$name]) ? $user_group[$name] : $_POST[$name]) . '" size="30" />';
}

//Add User Groups
function addug_theme() {

    global $globals, $l, $theme, $error, $user_group;

    //Admin Headers includes Global Headers
    adminhead($l['ugr_cp_add_ugroups']);
    ?>

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <tr>
            <td align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/usergroups.png">
            </td>
            <td align="left" class="adcbg1">

                <span class="adgreen"><?php echo $l['ugr_add_ugroups']; ?></span><br />

            </td>
        </tr>

        <tr>
            <td align="left" colspan="2" class="adbg">
                <?php echo $l['ugr_add_ugroups_exp']; ?>
            </td>
        </tr>

    </table>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="addugform">
        <table width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <tr>
                <td class="adcbg" colspan="2">
                    <?php echo $l['ugr_add_ugroups']; ?>
                </td>
            </tr>

            <tr>
                <td width="45%" class="adbg">
                    <b><?php echo $l['ugr_ugroup_name']; ?></b><br />
                    <span class="adexp"><?php echo $l['ugr_ugroup_name_exp']; ?></span>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="mem_gr_name" value="<?php echo (empty($_POST['mem_gr_name']) ? '' : $_POST['mem_gr_name']); ?>" />
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><?php echo $l['ugr_ugroup_colour']; ?></b><br />
                    <span class="adexp"><?php echo $l['ugr_ugroup_colour_exp']; ?></span>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="mem_gr_colour" value="<?php echo (empty($_POST['mem_gr_colour']) ? '' : $_POST['mem_gr_colour']); ?>" />
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><?php echo $l['ugr_ugroup_image']; ?></b><br />
                    <span class="adexp"><?php echo $l['ugr_ugroup_image_exp']; ?></span>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="image_name" value="<?php echo (empty($_POST['image_name']) ? '' : $_POST['image_name']); ?>" />
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><?php echo $l['ugr_num_stars']; ?></b><br />
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="image_count" value="<?php echo (empty($_POST['image_count']) ? '' : $_POST['image_count']); ?>" />
                </td>
            </tr>


            <tr>
                <td class="adbg">
                    <b><?php echo $l['ugr_post_based']; ?></b><br />
                    <span class="adexp"><?php echo $l['ugr_post_based_exp']; ?></span>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="post_based" <?php echo (isset($_POST['post_based']) ? 'checked="checked"' : '' ) ?> />
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><?php echo $l['ugr_num_posts']; ?></b><br />
                    <span class="adexp"><?php echo $l['ugr_num_posts_exp']; ?></span>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="post_count" value="<?php echo (empty($_POST['post_count']) ? '' : $_POST['post_count']); ?>" />
                </td>
            </tr>

        </table>

        <br /><br />

        <?php
        $admin_per = array('can_admin' => array('yn', $l['ugr_can_admin'], ''),
            'allow_html' => array('yn', $l['ugr_can_html'], $l['ugr_even_js']),
            'view_ip' => array('yn', $l['ugr_view_ips'], ''),
            'view_offline_board' => array('yn', $l['ugr_can_maint'], '')
        );

        $forum_per = array('view_forum' => array('yn', $l['ugr_can_view_f'], ''),
            'can_search' => array('yn', $l['ugr_can_search'], ''),
            'can_email_mem' => array('yn', $l['ugr_can_email_memb'], ''),
            'can_email_friend' => array('yn', $l['ugr_can_email_friend'], $l['ugr_can_email_friend_exp']),
            'view_active' => array('yn', $l['ugr_can_view_act_list'], ''),
            'hide_online' => array('yn', $l['ugr_can_hide_status'], ''),
            'view_anonymous' => array('yn', $l['ugr_can_view_anonys'], ''),
            'view_members' => array('yn', $l['ugr_can_view_memb_list'], ''),
            'view_stats' => array('yn', $l['ugr_can_view_stats'], ''),
            'view_calendar' => array('yn', $l['ugr_can_view_cal'], '')
        );

        $profile_per = array('prefix' => array('inputtext', $l['ugr_prefix'], ''),
            'suffix' => array('inputtext', $l['ugr_suffix'], ''),
            'use_avatar' => array('yn', $l['ugr_can_avatars_fboard'], ''),
            'url_avatar' => array('yn', $l['ugr_can_avatars_url'], ''),
            'upload_avatar' => array('yn', $l['ugr_can_avatars_upload'], ''),
            'can_view_profile' => array('yn', $l['ugr_can_view_memb_profile'], ''),
            'can_edit_own_profile' => array('yn', $l['ugr_can_edit_own_prof'], ''),
            'can_edit_other_profile' => array('yn', $l['ugr_can_edit_other_prof'], ''),
            'can_del_own_account' => array('yn', $l['ugr_can_del_own_account'], ''),
            'can_del_other_account' => array('yn', $l['ugr_can_del_other_account'], ''),
            'can_ban_user' => array('yn', $l['ugr_can_ban'], ''),
        );

        $topic_per = array('can_post_topic' => array('yn', $l['ugr_can_start_topics'], ''),
            'can_edit_own_topic' => array('yn', $l['ugr_can_edit_own_topics'], ''),
            'can_edit_other_topic' => array('yn', $l['ugr_can_edit_other_topics'], ''),
            'can_del_own_topic' => array('yn', $l['ugr_can_del_own_topics'], ''),
            'can_del_other_topic' => array('yn', $l['ugr_can_del_other_topics'], ''),
            'approve_topics' => array('yn', $l['ugr_approve_topics'], $l['ugr_approve_topics_exp']),
            'can_merge_topics' => array('yn', $l['ugr_merge_topics'], ''),
            'can_merge_posts' => array('yn', $l['ugr_merge_posts'], ''),
            'can_split_topics' => array('yn', $l['ugr_split_topics'], ''),
            'can_email_topic' => array('yn', $l['ugr_email_topics_friends'], ''),
            'can_make_sticky' => array('yn', $l['ugr_sticky_topics'], ''),
            'can_move_own_topic' => array('yn', $l['ugr_move_own_topics'], ''),
            'can_move_other_topic' => array('yn', $l['ugr_move_other_topics'], ''),
            'can_lock_own_topic' => array('yn', $l['ugr_lock_own_topics'], ''),
            'can_lock_other_topic' => array('yn', $l['ugr_lock_other_topics'], ''),
            'can_announce_topic' => array('yn', $l['ugr_announ_opics'], ''),
            'notify_new_posts' => array('yn', $l['ugr_subsc_topics'], ''),
            'notify_new_topics' => array('yn', $l['ugr_subsc_forums'], ''),
            'has_priviliges' => array('yn', $l['ugr_has_priv'], '')
        );

        $post_per = array('can_reply' => array('yn', $l['ugr_reply_topics'], ''),
            'can_edit_own' => array('yn', $l['ugr_edit_own_posts'], ''),
            'can_edit_other' => array('yn', $l['ugr_edit_other_posts'], ''),
            'can_del_own_post' => array('yn', $l['ugr_del_own_posts'], ''),
            'can_del_other_post' => array('yn', $l['ugr_del_other_posts'], ''),
            'approve_posts' => array('yn', $l['ugr_approve_posts'], $l['ugr_approve_posts_exp']),
            'can_report_post' => array('yn', $l['ugr_can_report_posts'], '')
        );

        $poll_per = array('can_view_poll' => array('yn', $l['ugr_view_polls'], ''),
            'can_vote_polls' => array('yn', $l['ugr_vote_polls'], ''),
            'can_post_polls' => array('yn', $l['ugr_can_start_polls'], ''),
            'can_edit_own_poll' => array('yn', $l['ugr_edit_own_polls'], ''),
            'can_edit_other_poll' => array('yn', $l['ugr_edit_other_polls'], ''),
            'add_poll_topic_own' => array('yn', $l['ugr_add_poll_self'], ''),
            'add_poll_topic_other' => array('yn', $l['ugr_add_poll_other'], ''),
            'can_rem_own_poll' => array('yn', $l['ugr_rem_poll_self'], ''),
            'can_rem_other_poll' => array('yn', $l['ugr_rem_poll_other'], ''),
        );

        $att_per = array('can_attach' => array('yn', $l['ugr_can_attach_files'], ''),
            'can_view_attach' => array('yn', $l['ugr_down_attach'], ''),
            'can_remove_attach' => array('yn', $l['ugr_rem_attach'], ''),
            'max_attach' => array('inputtext', $l['ugr_max_attach_size'], $l['ugr_in_kb'])
        );

        $news_per = array('can_submit_news' => array('yn', $l['ugr_can_subm_news'], ''),
            'can_approve_news' => array('yn', $l['ugr_can_approv_news'], ''),
            'can_edit_news' => array('yn', $l['ugr_can_edit_news'], ''),
            'can_delete_news' => array('yn', $l['ugr_can_del_news'], '')
        );

        $pm_per = array('can_use_pm' => array('yn', $l['ugr_can_use_pm'], ''),
            'max_stored_pm' => array('inputtext', $l['ugr_max_pm'], $l['ugr_max_pm_exp']),
            'max_mass_pm' => array('inputtext', $l['ugr_num_users_pm'], $l['ugr_max_pm_exp']),
            'can_report_pm' => array('yn', $l['ugr_can_repost_pm'], '')
        );

        $shoutbox_per = array('can_shout' => array('yn', $l['ugr_can_shout'], $l['ugr_can_shout_exp']),
            'can_del_shout' => array('yn', $l['ugr_del_shouts'], $l['ugr_del_shouts_exp'])
        );

        $permissions = array($l['ugr_topic_perms'] => $topic_per,
            $l['ugr_post_perms'] => $post_per,
            $l['ugr_poll_perms'] => $poll_per,
            $l['ugr_attach_perms'] => $att_per,
            $l['ugr_news_perms'] => $news_per,
            $l['ugr_pm_perms'] => $pm_per,
            $l['ugr_admin_perms'] => $admin_per,
            $l['ugr_gen_board_perms'] => $forum_per,
            $l['ugr_prof_opt'] => $profile_per,
            $l['ugr_shoutbox_perms'] => $shoutbox_per
        );

        //No you cant do it for admins
        echo '<table width="100%" cellpadding="2" cellspacing="1" class="cbor">
        <tr>
        <td class="adcbg" colspan="2">
        ' . $l['ugr_perms'] . '
        </td>
        </tr>';

        foreach ($permissions as $k => $v) {

            echo '<tr>
    <td class="adcbg2" colspan="2">
    ' . $k . '
    </td>
    </tr>';

            foreach ($v as $pk => $pv) {

                echo '<tr>
    <td class="adbg" width="50%">
    ' . $pv[1] . ' :<br />
    ' . (empty($pv[2]) ? '' : '<span class="adexp">' . $pv[2] . '</span>') . '
    </td>
    <td class="adbg" align="left">
    &nbsp;&nbsp;&nbsp;&nbsp;' . call_user_func($pv[0], $pk) . '
    </td>
    </tr>';
            }
        }

        echo '<tr>
    <td class="adbg" width="50%" valign="top">
    ' . $l['ugr_mess_to_group'] . '
    </td>
    <td class="adbg" align="left">
    &nbsp;&nbsp;&nbsp;&nbsp;<textarea cols="30" rows="5" name="group_message">' . (empty($_POST['group_message']) ? $user_group['group_message'] : $_POST['group_message']) . '</textarea>
    </td>
    </tr>


    </table>
    <br /><br />';
        ?>


        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <tr>
                <td align="center" class="adbg">
                    <input type="submit" name="addug" value="<?php echo $l['ugr_submit']; ?>" />
                </td>
            </tr>
        </table>

    </form>

    <?php
    adminfoot();
}
?>