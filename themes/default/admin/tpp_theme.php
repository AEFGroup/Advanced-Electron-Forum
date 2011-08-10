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

//A global part to appear
function tpp_global() {

    global $globals, $l, $theme, $categories;
    ?>

    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <tr>
            <td align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/topicposts.png">
            </td>
            <td align="left" class="adcbg1">

                <font class="adgreen"><?php echo $l['tpp_message_set']; ?></font><br />

            </td>
        </tr>

        <tr>
            <td align="left" colspan="2" class="adbg">
                <?php echo $l['tpp_message_set_exp']; ?>
            </td>
        </tr>

    </table>
    <br /><br />
    <?php
}

function manage_topics_theme() {

    global $globals, $theme, $l, $error;

    //Admin Headers includes Global Headers
    adminhead($l['tpp_cp_manage_topics']);

    tpp_global();

    error_handle($error, '100%');
    ?>
    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="topset">
        <table width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <tr>
                <td class="adcbg" colspan="2">
                    <?php echo $l['tpp_topics_set']; ?>
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_max_char_title']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_max_char_title_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="maxtitlechars"
                                                   <?php echo 'value="' . $globals['maxtitlechars'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_min_char_title']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_min_char_title_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="mintitlechars"
                                                   <?php echo 'value="' . $globals['mintitlechars'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_num_topics_pp']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_num_topics_pp_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="maxtopics"
                                                   <?php echo 'value="' . $globals['maxtopics'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_num_posts_pt']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_num_posts_pt_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="maxpostsintopics"
                                                   <?php echo 'value="' . $globals['maxpostsintopics'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_replies_hot_topic']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_replies_hot_topic_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="maxreplyhot"
                                                   <?php echo 'value="' . $globals['maxreplyhot'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_replies_veryhot_topic']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_replies_veryhot_topic_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="maxreplyveryhot"
                                                   <?php echo 'value="' . $globals['maxreplyveryhot'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_disable_shouting_topic_titles']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_disable_shouting_topic_titles_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="disableshoutingtopics"
                                                   <?php echo ($globals['disableshoutingtopics']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_prev_next_topic_links']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_prev_next_topic_links_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="prenextopic"
                    <?php
                    echo 'value="' . $globals['prenextopic'] . '"';
                    echo ($globals['prenextopic']) ? 'checked="checked"' : '';
                    ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_old_topic_warn']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_old_topic_warn_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="warnoldtopic"
                                                   <?php echo 'value="' . $globals['warnoldtopic'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_pref_stickied_topics']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_pref_stickied_topics_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="prefixsticky"
                                                   <?php echo 'value="' . $globals['prefixsticky'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_pref_moved_topics']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_pref_moved_topics_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="prefixmoved"
                                                   <?php echo 'value="' . $globals['prefixmoved'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_pref_poll_topics']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_pref_poll_topics_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="prefixpolls"
                                                   <?php echo 'value="' . $globals['prefixpolls'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_disable_shouting_topic_desc']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_disable_shouting_topic_desc_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="disableshoutingdesc"
                                                   <?php echo ($globals['disableshoutingdesc']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_max_char_desc']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_max_char_desc_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="maxdescchars"
                                                   <?php echo 'value="' . $globals['maxdescchars'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_min_char_desc']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_min_char_desc_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="mindescchars"
                                                   <?php echo 'value="' . $globals['mindescchars'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_allow_tell_friend']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_allow_tell_friend_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="allow_taf"
                                                   <?php echo ($globals['allow_taf']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><?php echo $l['who_read_topic']; ?> :</b><br />
                    <font class="adexp"><?php echo $l['who_read_topic_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="who_read_topic"
                                                   <?php echo ($globals['who_read_topic']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

        </table>

        <br /><br />

        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <tr>
                <td align="center" class="adbg">
                    <input type="submit" name="edittopset" value="<?php echo $l['tpp_submit']; ?>" />
                </td>
            </tr>
        </table>

    </form>

    <?php
    //Admin footers includes Global footers
    adminfoot();
}

//End of function

function manage_posts_theme() {

    global $globals, $theme, $l, $error;

    //Admin Headers includes Global Headers
    adminhead($l['tpp_cp_manage_posts']);

    tpp_global();

    error_handle($error, '100%');
    ?>
    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="postset">

        <table width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <tr>
                <td class="adcbg" colspan="2">
                    <?php echo $l['tpp_manage_posts']; ?>
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_num_posts_pt']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_num_posts_pt_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="maxpostsintopics"
                                                   <?php echo 'value="' . $globals['maxpostsintopics'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_max_char_post']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_max_char_post_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="maxcharposts"
                                                   <?php echo 'value="' . $globals['maxcharposts'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_min_char_post']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_min_char_post_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="mincharposts"
                                                   <?php echo 'value="' . $globals['mincharposts'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_time_between_posts']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_time_between_posts_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="timepostfromuser"
                                                   <?php echo 'value="' . $globals['timepostfromuser'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_show_last_posts']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_show_last_posts_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="last_posts_reply"
                                                   <?php echo 'value="' . $globals['last_posts_reply'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_max_emoticons_allow']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_max_emoticons_allow_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="maxemotpost"
                                                   <?php echo 'value="' . $globals['maxemotpost'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_max_images_allow']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_max_images_allow_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="maximgspost"
                                                   <?php echo 'value="' . $globals['maximgspost'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_width_height_image']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_width_height_image_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="10"  name="maximgwidthpost"
                                                   <?php echo 'value="' . $globals['maximgwidthpost'] . '"'; ?> /> x <input type="text" size="10"  name="maximgheightpost"
                                                   <?php echo 'value="' . $globals['maximgheightpost'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_rem_nested_quotes']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_rem_nested_quotes_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="removenestedquotes"
                                                   <?php echo ($globals['removenestedquotes']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_attach_sig_post']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_attach_sig_post_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="attachsigtopost"
                                                   <?php echo ($globals['attachsigtopost']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_allow_flash']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_allow_flash_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="embedflashinpost"
                    <?php
                    echo 'value="' . $globals['embedflashinpost'] . '"';
                    echo ($globals['embedflashinpost']) ? 'checked="checked"' : '';
                    ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_allow_dynamic_images']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_allow_dynamic_images_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="allowdynimg"
                                                   <?php echo ($globals['allowdynimg']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_width_height_flash']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_width_height_flash_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="10"  name="maxflashwidthinpost"
                                                   <?php echo 'value="' . $globals['maxflashwidthinpost'] . '"'; ?> /> x <input type="text" size="10"  name="maxflashheightinpost"
                                                   <?php echo 'value="' . $globals['maxflashheightinpost'] . '"'; ?> />
                </td>
            </tr>

        </table>

        <br /><br />

        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <tr>
                <td align="center" class="adbg">
                    <input type="submit" name="editpostset" value="<?php echo $l['tpp_submit']; ?>" />
                </td>
            </tr>
        </table>

    </form>

    <?php
    //Admin footers includes Global footers
    adminfoot();
}

//End of function

function manage_polls_theme() {

    global $globals, $theme, $l, $error;

    //Admin Headers includes Global Headers
    adminhead($l['tpp_cp_manage_polls']);

    tpp_global();

    error_handle($error, '100%');
    ?>
    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="pollset">

        <table width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <tr>
                <td class="adcbg" colspan="2">
                    <?php echo $l['tpp_polls_set']; ?>
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_enable_polls']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_enable_polls_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="enablepolls"
                                                   <?php echo ($globals['enablepolls']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_max_options_poll']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_max_options_poll_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="maxoptionspoll"
                                                   <?php echo 'value="' . $globals['maxoptionspoll'] . '"'; ?> />
                </td>
            </tr>

            <tr>
                <td width="35%" class="adbg">
                    <b><?php echo $l['tpp_pollquestion_length']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_pollquestion_length_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="maxpollqtlen"
                                                   <?php echo 'value="' . $globals['maxpollqtlen'] . '"'; ?> />
                </td>
            </tr>

        </table>

        <br /><br />

        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <tr>
                <td align="center" class="adbg">
                    <input type="submit" name="editpollset" value="<?php echo $l['tpp_submit']; ?>" />
                </td>
            </tr>
        </table>

    </form>

    <?php
    //Admin footers includes Global footers
    adminfoot();
}

//End of function

function manage_words_theme() {

    global $globals, $theme, $l, $error, $from, $to;

    //Admin Headers includes Global Headers
    adminhead($l['tpp_cp_manage_censored_words']);

    tpp_global();

    error_handle($error, '100%');
    ?>
    <script type="text/javascript">
        function addrow(id){
            var t = document.getElementById(id);
            var lastRow = t.rows.length;
            var x=t.insertRow(lastRow);
            var y = x.insertCell(0);
            var z = x.insertCell(1);
            y.innerHTML = '<input type="text" name="from[]" />';
            z.innerHTML = '<input type="text" name="to[]" />';
            y.className = "adbg";
            z.className = "adbg";
            y.align = "center";
            z.align = "center";
        }
    </script>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="censorwords">

        <table width="100%" cellpadding="2" cellspacing="1" class="cbor" id="wordstable">

            <tr>
                <td class="adcbg" colspan="2">
                    <?php echo $l['tpp_censored_words_set']; ?>
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_case_sens']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_case_sens_exp']; ?></font>
                </td>
                <td width="50%" class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="censor_words_case"
                                                   <?php echo ($globals['censor_words_case']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td class="adcbg2" align="center">
                    <?php echo $l['tpp_convert_from']; ?>
                </td>
                <td class="adcbg2" align="center">
                    <?php echo $l['tpp_to']; ?>
                </td>
            </tr>

            <?php
            foreach ($from as $k => $v) {

                echo '<tr>
        <td class="adbg" align="center">
        <input type="text" name="from[]" value="' . $from[$k] . '" />
        </td>
        <td class="adbg" align="center">
        <input type="text" name="to[]" value="' . $to[$k] . '" />
        </td>
        </tr>';
            }
            ?>

        </table>

        <br /><br />

        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <tr>
                <td align="center" class="adbg" width="50%">
                    <input type="button" onclick="addrow('wordstable');" value="<?php echo $l['tpp_add_more']; ?>" />
                </td>
                <td align="center" class="adbg">
                    <input type="submit" name="censorwords" value="<?php echo $l['tpp_submit']; ?>" />
                </td>
            </tr>
        </table>

    </form>

    <?php
    //Admin footers includes Global footers
    adminfoot();
}

//End of function

function manage_bbc_theme() {

    global $globals, $l, $theme, $error;

    //Admin Headers includes Global Headers
    adminhead($l['tpp_cp_manage_bbc']);

    tpp_global();

    error_handle($error, '100%');
    ?>
    <form action="" method="post" name="bbcset" accept-charset="UTF-8">

        <table width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <tr>
                <td class="adcbg" colspan="2">
                    <?php echo $l['tpp_bbc_set']; ?>
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_parse_bbc']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_parse_bbc_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="parsebbc"
                                                   <?php echo ($globals['parsebbc']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_autolink_url']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_autolink_url_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="autolink"
                                                   <?php echo ($globals['autolink']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_h_rule']; ?></b><br />
                    <font class="adexp">[hr]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_hr"
                                                   <?php echo ($globals['bbc_hr']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_bold']; ?></b><br />
                    <font class="adexp">[b][/b]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_b"
                                                   <?php echo ($globals['bbc_b']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_italics']; ?></b><br />
                    <font class="adexp">[i][/i]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_i"
                                                   <?php echo ($globals['bbc_i']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_underline']; ?></b><br />
                    <font class="adexp">[u][/u]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_u"
                                                   <?php echo ($globals['bbc_u']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>



            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_strike']; ?></b><br />
                    <font class="adexp">[s][/s]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_s"
                                                   <?php echo ($globals['bbc_s']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_left_align']; ?></b><br />
                    <font class="adexp">[left][/left]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_left"
                                                   <?php echo ($globals['bbc_left']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_right_align']; ?></b><br />
                    <font class="adexp">[right][/right]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_right"
                                                   <?php echo ($globals['bbc_right']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_center_align']; ?></b><br />
                    <font class="adexp">[center][/center]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_center"
                                                   <?php echo ($globals['bbc_center']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_font_size']; ?></b><br />
                    <font class="adexp">[size][/size]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_size"
                                                   <?php echo ($globals['bbc_size']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_font_face']; ?></b><br />
                    <font class="adexp">[font][/font]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_font"
                                                   <?php echo ($globals['bbc_font']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_sup_text']; ?></b><br />
                    <font class="adexp">[sup][/sup]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_sup"
                                                   <?php echo ($globals['bbc_sup']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_sub_text']; ?></b><br />
                    <font class="adexp">[sub][/sub]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_sub"
                                                   <?php echo ($globals['bbc_sub']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_colour_text']; ?></b><br />
                    <font class="adexp">[color][/color]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_color"
                                                   <?php echo ($globals['bbc_color']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_anchor_url']; ?></b><br />
                    <font class="adexp">[url][/url]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_url"
                                                   <?php echo ($globals['bbc_url']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_ftp_link']; ?></b><br />
                    <font class="adexp">[ftp][/ftp]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_ftp"
                                                   <?php echo ($globals['bbc_ftp']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_email_link']; ?></b><br />
                    <font class="adexp">[email][/email]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_email"
                                                   <?php echo ($globals['bbc_email']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_inline_image']; ?></b><br />
                    <font class="adexp">[img][/img]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_img"
                                                   <?php echo ($globals['bbc_img']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td class="adbg">
                    <b><?php echo $l['tpp_show_images']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_show_images_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="showimgs" <?php echo (isset($_POST['showimgs']) ? 'checked="checked"' : ($globals['showimgs'] ? 'checked="checked"' : '')); ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_flash']; ?></b><br />
                    <font class="adexp">[flash][/flash]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_flash"
                                                   <?php echo ($globals['bbc_flash']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_code_block']; ?></b><br />
                    <font class="adexp">[code][/code]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_code"
                                                   <?php echo ($globals['bbc_code']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_quote_text']; ?></b><br />
                    <font class="adexp">[quote][/quote]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_quote"
                                                   <?php echo ($globals['bbc_quote']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_php_code_block']; ?></b><br />
                    <font class="adexp">[php][/php]</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_php"
                                                   <?php echo ($globals['bbc_php']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_unord_list']; ?></b><br />
                    <font class="adexp">[ul][/ul] (<?php echo $l['tpp_implies']; ?> [li][/li])</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_ul"
                                                   <?php echo ($globals['bbc_ul']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>


            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_ord_list']; ?></b><br />
                    <font class="adexp">[ol][/ol] (<?php echo $l['tpp_implies']; ?> [li][/li])</font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_ol"
                                                   <?php echo ($globals['bbc_ol']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>

            <tr>
                <td width="50%" class="adbg">
                    <b><?php echo $l['tpp_execute_html']; ?></b><br />
                    <font class="adexp">[parseHTML][/parseHTML]<br />
                    <?php echo $l['tpp_execute_html_exp']; ?></font>
                </td>
                <td class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_parseHTML"
                                                   <?php echo ($globals['bbc_parseHTML']) ? 'checked="checked"' : ''; ?> />
                </td>
            </tr>


        </table>

        <br /><br />

        <table width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <tr>
                <td align="center" class="adbg">
                    <input type="submit" name="editbbcset" value="<?php echo $l['tpp_submit']; ?>" />
                </td>
            </tr>
        </table>

    </form>

    <?php
    //Admin footers includes Global footers
    adminfoot();
}

//End of function
?>