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

    <div class="cbor" align="center">

        <div>
            <img src="<?php echo $theme['images']; ?>admin/topicposts.png">
            <font class="adgreen"><?php echo $l['tpp_message_set']; ?></font><br />
        </div>
        <div class="expl">
            <?php echo $l['tpp_message_set_exp']; ?>
        </div>

    </div>
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
        <div class="division">
            <div class="topbar">
                <h3><?php echo $l['tpp_topics_set']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_max_char_title']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_max_char_title_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="maxtitlechars"
                                                   <?php echo 'value="' . $globals['maxtitlechars'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_min_char_title']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_min_char_title_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="mintitlechars"
                                                   <?php echo 'value="' . $globals['mintitlechars'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_num_topics_pp']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_num_topics_pp_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="maxtopics"
                                                   <?php echo 'value="' . $globals['maxtopics'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_num_posts_pt']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_num_posts_pt_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="maxpostsintopics"
                                                   <?php echo 'value="' . $globals['maxpostsintopics'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_replies_hot_topic']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_replies_hot_topic_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="maxreplyhot"
                                                   <?php echo 'value="' . $globals['maxreplyhot'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_replies_veryhot_topic']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_replies_veryhot_topic_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="maxreplyveryhot"
                                                   <?php echo 'value="' . $globals['maxreplyveryhot'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_disable_shouting_topic_titles']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_disable_shouting_topic_titles_exp']; ?></font>
                </div>
                <input type="checkbox" name="disableshoutingtopics"
                                                   <?php echo ($globals['disableshoutingtopics']) ? 'checked="checked"' : ''; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_prev_next_topic_links']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_prev_next_topic_links_exp']; ?></font>
                </div>
                <input type="checkbox" name="prenextopic"
                    <?php
                    echo 'value="' . $globals['prenextopic'] . '"';
                    echo ($globals['prenextopic']) ? 'checked="checked"' : '';
                    ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_old_topic_warn']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_old_topic_warn_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="warnoldtopic"
                                                   <?php echo 'value="' . $globals['warnoldtopic'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_pref_stickied_topics']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_pref_stickied_topics_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="prefixsticky"
                                                   <?php echo 'value="' . $globals['prefixsticky'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_pref_moved_topics']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_pref_moved_topics_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="prefixmoved"
                                                   <?php echo 'value="' . $globals['prefixmoved'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_pref_poll_topics']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_pref_poll_topics_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="prefixpolls"
                                                   <?php echo 'value="' . $globals['prefixpolls'] . '"'; ?> />
                
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_disable_shouting_topic_desc']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_disable_shouting_topic_desc_exp']; ?></font>
                </div>
                <input type="checkbox" name="disableshoutingdesc"
                                                   <?php echo ($globals['disableshoutingdesc']) ? 'checked="checked"' : ''; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_max_char_desc']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_max_char_desc_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="maxdescchars"
                                                   <?php echo 'value="' . $globals['maxdescchars'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_min_char_desc']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_min_char_desc_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="mindescchars"
                                                   <?php echo 'value="' . $globals['mindescchars'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_allow_tell_friend']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_allow_tell_friend_exp']; ?></font>
                </div>
                <input type="checkbox" name="allow_taf"
                                                   <?php echo ($globals['allow_taf']) ? 'checked="checked"' : ''; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['who_read_topic']; ?> :</b><br />
                    <font class="adexp"><?php echo $l['who_read_topic_exp']; ?></font>
                </div>
                <input type="checkbox" name="who_read_topic" <?php echo ($globals['who_read_topic']) ? 'checked="checked"' : ''; ?> />
            </div>
            <input type="submit" name="edittopset" value="<?php echo $l['tpp_submit']; ?>" />
            <div style="clear:both;"></div>
        </div>
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

        <div class="division">
            <div class="topbar">
                <h3><?php echo $l['tpp_manage_posts']; ?></h3>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_num_posts_pt']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_num_posts_pt_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="maxpostsintopics"
                                                   <?php echo 'value="' . $globals['maxpostsintopics'] . '"'; ?> />
                
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_max_char_post']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_max_char_post_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="maxcharposts"
                                                   <?php echo 'value="' . $globals['maxcharposts'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_min_char_post']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_min_char_post_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="mincharposts"
                                                   <?php echo 'value="' . $globals['mincharposts'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_time_between_posts']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_time_between_posts_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="timepostfromuser"
                                                   <?php echo 'value="' . $globals['timepostfromuser'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_show_last_posts']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_show_last_posts_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="last_posts_reply"
                                                   <?php echo 'value="' . $globals['last_posts_reply'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_max_emoticons_allow']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_max_emoticons_allow_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="maxemotpost"
                                                   <?php echo 'value="' . $globals['maxemotpost'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_max_images_allow']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_max_images_allow_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="maximgspost"
                                                   <?php echo 'value="' . $globals['maximgspost'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_width_height_image']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_width_height_image_exp']; ?></font>
                </div>
                <input type="text" size="10"  name="maximgwidthpost"
                                                   <?php echo 'value="' . $globals['maximgwidthpost'] . '"'; ?> /> x <input type="text" size="10"  name="maximgheightpost"
                                                   <?php echo 'value="' . $globals['maximgheightpost'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_rem_nested_quotes']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_rem_nested_quotes_exp']; ?></font>
                </div>
                <input type="checkbox" name="removenestedquotes"
                                                   <?php echo ($globals['removenestedquotes']) ? 'checked="checked"' : ''; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_attach_sig_post']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_attach_sig_post_exp']; ?></font>
                </div>
                <input type="checkbox" name="attachsigtopost"
                                                   <?php echo ($globals['attachsigtopost']) ? 'checked="checked"' : ''; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_allow_flash']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_allow_flash_exp']; ?></font>
                </div>
                <input type="checkbox" name="embedflashinpost"
                    <?php
                    echo 'value="' . $globals['embedflashinpost'] . '"';
                    echo ($globals['embedflashinpost']) ? 'checked="checked"' : '';
                    ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_allow_dynamic_images']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_allow_dynamic_images_exp']; ?></font>
                </div>
                <input type="checkbox" name="allowdynimg"
                                                   <?php echo ($globals['allowdynimg']) ? 'checked="checked"' : ''; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_width_height_flash']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_width_height_flash_exp']; ?></font>
                </div>
                <input type="text" size="10"  name="maxflashwidthinpost"
                                                   <?php echo 'value="' . $globals['maxflashwidthinpost'] . '"'; ?> /> x <input type="text" size="10"  name="maxflashheightinpost"
                                                   <?php echo 'value="' . $globals['maxflashheightinpost'] . '"'; ?> />
                <input type="submit" name="editpostset" value="<?php echo $l['tpp_submit']; ?>" />
                <div style="clear:both;"></div>
            </div>

        </div>
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

        <div class="division">

            <div class="topbar">
                <?php echo $l['tpp_polls_set']; ?>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_enable_polls']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_enable_polls_exp']; ?></font>
                </div>
                <input type="checkbox" name="enablepolls"
                                                   <?php echo ($globals['enablepolls']) ? 'checked="checked"' : ''; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_max_options_poll']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_max_options_poll_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="maxoptionspoll"
                                                   <?php echo 'value="' . $globals['maxoptionspoll'] . '"'; ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div>
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['tpp_pollquestion_length']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_pollquestion_length_exp']; ?></font>
                </div>
                <input type="text" size="30"  name="maxpollqtlen"
                                                   <?php echo 'value="' . $globals['maxpollqtlen'] . '"'; ?> />
            </div>
            <input type="submit" name="editpollset" value="<?php echo $l['tpp_submit']; ?>" />
            <div style="clear:both;"></div>
        </div>
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

        <div width="100%" cellpadding="2" cellspacing="1" class="cbor" id="wordstable">

            <div>
                <div class="adcbg" colspan="2">
                    <?php echo $l['tpp_censored_words_set']; ?>
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_case_sens']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_case_sens_exp']; ?></font>
                </div>
                <div width="50%" class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="censor_words_case"
                                                   <?php echo ($globals['censor_words_case']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div class="adcbg2" align="center">
                    <?php echo $l['tpp_convert_from']; ?>
                </div>
                <div class="adcbg2" align="center">
                    <?php echo $l['tpp_to']; ?>
                </div>
            </div>

            <?php
            foreach ($from as $k => $v) {

                echo '<div>
        <div class="adbg" align="center">
        <input type="text" name="from[]" value="' . $from[$k] . '" />
        </div>
        <div class="adbg" align="center">
        <input type="text" name="to[]" value="' . $to[$k] . '" />
        </div>
        </div>';
            }
            ?>

        </div>

        <br /><br />

        <div width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <div>
                <div align="center" class="adbg" width="50%">
                    <input type="button" onclick="addrow('wordstable');" value="<?php echo $l['tpp_add_more']; ?>" />
                </div>
                <div align="center" class="adbg">
                    <input type="submit" name="censorwords" value="<?php echo $l['tpp_submit']; ?>" />
                </div>
            </div>
        </div>

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

        <div width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <div>
                <div class="adcbg" colspan="2">
                    <?php echo $l['tpp_bbc_set']; ?>
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_parse_bbc']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_parse_bbc_exp']; ?></font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="parsebbc"
                                                   <?php echo ($globals['parsebbc']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_autolink_url']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_autolink_url_exp']; ?></font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="autolink"
                                                   <?php echo ($globals['autolink']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_h_rule']; ?></b><br />
                    <font class="adexp">[hr]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_hr"
                                                   <?php echo ($globals['bbc_hr']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_bold']; ?></b><br />
                    <font class="adexp">[b][/b]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_b"
                                                   <?php echo ($globals['bbc_b']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_italics']; ?></b><br />
                    <font class="adexp">[i][/i]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_i"
                                                   <?php echo ($globals['bbc_i']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_underline']; ?></b><br />
                    <font class="adexp">[u][/u]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_u"
                                                   <?php echo ($globals['bbc_u']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>



            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_strike']; ?></b><br />
                    <font class="adexp">[s][/s]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_s"
                                                   <?php echo ($globals['bbc_s']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_left_align']; ?></b><br />
                    <font class="adexp">[left][/left]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_left"
                                                   <?php echo ($globals['bbc_left']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_right_align']; ?></b><br />
                    <font class="adexp">[right][/right]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_right"
                                                   <?php echo ($globals['bbc_right']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_center_align']; ?></b><br />
                    <font class="adexp">[center][/center]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_center"
                                                   <?php echo ($globals['bbc_center']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_font_size']; ?></b><br />
                    <font class="adexp">[size][/size]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_size"
                                                   <?php echo ($globals['bbc_size']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_font_face']; ?></b><br />
                    <font class="adexp">[font][/font]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_font"
                                                   <?php echo ($globals['bbc_font']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_sup_text']; ?></b><br />
                    <font class="adexp">[sup][/sup]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_sup"
                                                   <?php echo ($globals['bbc_sup']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_sub_text']; ?></b><br />
                    <font class="adexp">[sub][/sub]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_sub"
                                                   <?php echo ($globals['bbc_sub']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_colour_text']; ?></b><br />
                    <font class="adexp">[color][/color]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_color"
                                                   <?php echo ($globals['bbc_color']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_anchor_url']; ?></b><br />
                    <font class="adexp">[url][/url]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_url"
                                                   <?php echo ($globals['bbc_url']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_ftp_link']; ?></b><br />
                    <font class="adexp">[ftp][/ftp]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_ftp"
                                                   <?php echo ($globals['bbc_ftp']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_email_link']; ?></b><br />
                    <font class="adexp">[email][/email]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_email"
                                                   <?php echo ($globals['bbc_email']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_inline_image']; ?></b><br />
                    <font class="adexp">[img][/img]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_img"
                                                   <?php echo ($globals['bbc_img']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div class="adbg">
                    <b><?php echo $l['tpp_show_images']; ?></b><br />
                    <font class="adexp"><?php echo $l['tpp_show_images_exp']; ?></font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="showimgs" <?php echo (isset($_POST['showimgs']) ? 'checked="checked"' : ($globals['showimgs'] ? 'checked="checked"' : '')); ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_flash']; ?></b><br />
                    <font class="adexp">[flash][/flash]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_flash"
                                                   <?php echo ($globals['bbc_flash']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_code_block']; ?></b><br />
                    <font class="adexp">[code][/code]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_code"
                                                   <?php echo ($globals['bbc_code']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_quote_text']; ?></b><br />
                    <font class="adexp">[quote][/quote]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_quote"
                                                   <?php echo ($globals['bbc_quote']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_php_code_block']; ?></b><br />
                    <font class="adexp">[php][/php]</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_php"
                                                   <?php echo ($globals['bbc_php']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_unord_list']; ?></b><br />
                    <font class="adexp">[ul][/ul] (<?php echo $l['tpp_implies']; ?> [li][/li])</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_ul"
                                                   <?php echo ($globals['bbc_ul']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>


            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_ord_list']; ?></b><br />
                    <font class="adexp">[ol][/ol] (<?php echo $l['tpp_implies']; ?> [li][/li])</font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_ol"
                                                   <?php echo ($globals['bbc_ol']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>

            <div>
                <div width="50%" class="adbg">
                    <b><?php echo $l['tpp_execute_html']; ?></b><br />
                    <font class="adexp">[parseHTML][/parseHTML]<br />
                    <?php echo $l['tpp_execute_html_exp']; ?></font>
                </div>
                <div class="adbg" align="left">
                    &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="bbc_parseHTML"
                                                   <?php echo ($globals['bbc_parseHTML']) ? 'checked="checked"' : ''; ?> />
                </div>
            </div>


        </div>

        <br /><br />

        <div width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <div>
                <div align="center" class="adbg">
                    <input type="submit" name="editbbcset" value="<?php echo $l['tpp_submit']; ?>" />
                </div>
            </div>
        </div>

    </form>

    <?php
    //Admin footers includes Global footers
    adminfoot();
}

//End of function
?>