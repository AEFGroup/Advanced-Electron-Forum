<?php
//////////////////////////////////////////////////////////////
//===========================================================
// forums_theme.php(Admin)
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
function forum_global() {

    global $globals, $l, $theme, $categories;
    ?>
    <div>
        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=categories&seadact=createcat" style="text-decoration:none; float:left;"><input type="submit" value="<?php echo $l['create_new_category']; ?>"></a>
        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=forums&seadact=createforum" style="text-decoration:none; float:left;"><input type="submit" value="<?php echo $l['create_new_forum']; ?>"></a>
        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=recyclebin" style="text-decoration:none; float:left;"><input type="submit" value="<?php echo $l['recycle_bin']; ?>"></a>
    </div>
    <div style="clear: both;"></div>
    <div class="cbor" align="center">
        <div>
            <img src="<?php echo $theme['images']; ?>admin/forums.png">
            <font class="adgreen"><?php echo $l['board_options']; ?></font><br />
        </div>

        <div class="expl">
            <?php echo $l['board_options_exp']; ?>
        </div>

    </div>
    <br /><br />
    <?php
}

//This is the theme that is for the management of the forums
function forummanage_theme() {

    global $globals, $l, $theme, $categories, $forums;

    adminhead($l['cp_manage_forums']);

    forum_global();

    echo '
        <script type="text/javascript">

            delcatpromptid = \'delcatprompt\';
            cat_id = 0;

            function confirmdelete(cid){
                cat_id = cid;
                if(!isvisible(delcatpromptid)){
                    $(delcatpromptid).style.left=((getwidth()/2)-($(delcatpromptid).offsetWidth/2))+"px";
                    $(delcatpromptid).style.top=(scrolledy()+110)+"px";
                    showel(delcatpromptid);
                    smoothopaque(delcatpromptid, 0, 100, 10);
                }
            };

            function redirectdeletecat(){
                //alert(cat_id);
                window.location = \''. $globals['index_url'] . 'act=admin&adact=categories&seadact=delcat&cid=\'+cat_id;
            }

        </script>
        <div class="division">
            <div class="topbar"><h3>' . $l['edit_boards'] . '</h3></div>';

    //The for loop for the categories
    foreach ($categories as $c => $cv) {

        echo '
            <div class="adcbg2">
                <b>
                    <a href="' . $globals['index_url'] . 'act=admin&adact=categories&seadact=editcat&editcat=' . $categories[$c]['cid'] . '">
                        ' . $categories[$c]['name'] . '
                    </a>
                </b>
                <div style="display: inline; float: right;">
                    <a href="' . $globals['index_url'] . 'act=admin&adact=categories&seadact=editcat&editcat=' . $categories[$c]['cid'] . '">
                        ' . $l['edit_edit'] . '
                    </a> | 
                    <a href="javascript:confirmdelete(' . $categories[$c]['cid'] . ');">
                        ' . $l['edit_delete'] . '
                    </a>
                </div>
            </div>
            ';

        if (isset($forums[$c])) {

            //The for loop for the forums within the category
            foreach ($forums[$c] as $f => $v) {

                $dasher = "";

                for ($t = 0; $t < $forums[$c][$f]['board_level']; $t++) {

                    $dasher .= "&nbsp;&nbsp;&nbsp;&nbsp;";
                }

                echo '
                <div>
                    <div class="adbg" height="' . (($forums[$c][$f]['in_board'] == 1) ? '18' : '25') . '" style="display: inline;">' . $dasher . (($forums[$c][$f]['in_board'] == 1) ? '|--' : '') . $forums[$c][$f]['fname'] . '
                    </div>
                    <div style="display: inline;">
                        <div class="adlinks" align="center">
                            <a href="' . $globals['index_url'] . 'act=admin&adact=forums&seadact=editforum&editforum=' . $forums[$c][$f]['fid'] . '">' . $l['edit_edit'] . '
                            </a> | 
                            <a href="' . $globals['index_url'] . 'act=admin&adact=forums&seadact=deleteforum&forum=' . $forums[$c][$f]['fid'] . '">' . $l['edit_delete'] . '
                            </a> | 
                            <a href="' . $globals['index_url'] . 'act=admin&adact=moderators&seadact=edit&forum=' . $forums[$c][$f]['fid'] . '">' . $l['moderators'] . '</a> | 
                            <a href="'. $globals['index_url'] .'act=admin&adact=fpermissions&forum=' . $forums[$c][$f]['fid'] . '">'. $l['forum_permissions'] .'</a>
                        </div>
                    </div>
                </div>';
            }//End of forums loop
        } else {
            echo '<div>

                <div class="adbg" width="65%" height="18">
                --
                </div>

                <div class="adbg" align="center">
                -
                </div>

                <div class="adbg" align="center">
                -
                </div>

                </div>';
        }
    }//End of Categories loop

    echo '</div>';

    adminfoot();
}

//End of function
//This fuction is to edit a forum
function editforum_theme() {

    global $globals, $l, $theme, $categories, $forums, $board, $orderoptions, $member_group, $mother_options, $currentmother, $error, $samelevel, $themes;

    adminhead($l['cp_edit_forums']);

    forum_global();

    error_handle($error, '100%');
    ?>
    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="editboard">
        <div width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <div>
                <div class="adcbg" colspan="2" style="height:25px">
                    <?php echo $l['general_options']; ?>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['mother_forums']; ?></b>
                </div>
                <div class="adbg">

                    &nbsp;&nbsp;&nbsp;&nbsp;

                    <select onchange="getneworder()" name="editmother" style="font-family:Verdana; font-size:11px" id="fmother">

                        <?php
                        foreach ($mother_options as $i => $iv) {

                            echo '<option value="' . $mother_options[$i][0] . '" ' . ((isset($_POST['editmother']) && trim($_POST['editmother']) == $mother_options[$i][0] ) ? 'selected="selected"' : (($mother_options[$i][0] == $currentmother) ? 'selected="selected"' : '')) . '>
            ' . $mother_options[$i][1] . '
            </option>';
                        }//End of for loop
                        ?>
                    </select>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['order']; ?></b>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <select name="forder" style="font-family:Verdana; font-size:11px" id="forder">

                        <?php
                        //Find the order and make the array
                        for ($o = 1; $o <= count($samelevel); $o++) {

                            echo '<option value="' . $o . '" ' . ((isset($_POST['forder']) && (int) trim($_POST['forder']) == $o ) ? 'selected="selected"' : (($board['forum_order'] == $o) ? 'selected="selected"' : '')) . '>' . $o . '</option>';
                        }
                        ?>
                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <span id="loadstatus">
                    </span>
                    <script language="JavaScript" type="text/javascript">

                        bydefault = '<?php echo $currentmother; ?>';
                        numorder = $('forder').length;
                        defaultorder = <?php echo $board['forum_order']; ?>;
                        //alert(defaultorder);
                        //alert(bydefault);
                        //alert(defaultorder);

                        function LoadStatus(itsinner){
                            $('loadstatus').innerHTML = itsinner;
                        }

                        function getneworder(){
                            mother = $('fmother').value;
                            //alert(mother);
                            //alert(bydefault);
                            if(mother != bydefault){
                                LoadStatus('<img src="<?php echo $theme['images']; ?>admin/loading.gif"><?php echo $l['refresh_order']; ?>');
                                AJAX('<?php echo $globals['index_url']; ?>act=admin&adact=forums&seadact=ajax&motherforum='+mother, 'PrintOrder(re)');
                            }else{
                                //Remove the old order list
                                while ($('forder').length > 0) {
                                    $('forder').remove(0);
                                }
                                //Create the new order list
                                for (var i = 1; i <= numorder; i++) {
                                    var newopt = document.createElement('option');
                                    newopt.text = i;
                                    newopt.value = i;
                                    try{
                                        $('forder').add(newopt, null); // standards compliant; doesn't work in IE
                                    }catch(ex){
                                        $('forder').add(newopt); // IE only
                                    }
                                }
                                //This is to make the default order as selected
                                $('forder').selectedIndex = defaultorder - 1;
                                LoadStatus('');
                            }
                        }

                        function PrintOrder(resp){
                            //Remove the old order list
                            while ($('forder').length > 0) {
                                $('forder').remove(0);
                            }
                            resp = parseInt(resp);
                            //If there is some problem
                            if(isNaN(resp)){
                                LoadStatus('<?php echo $l['retrieve_data']; ?>');
                                var newOption = document.createElement('option');
                                newOption.text = 'Last';
                                newOption.value = 0;
                                try{
                                    $('forder').add(newOption, null); // standards compliant; doesn't work in IE
                                } catch(ex) {
                                    $('forder').add(newOption); // IE only
                                }
                                return false;
                            }
                            //Create the new order list
                            for (var i = 1; i <= resp; i++) {
                                var newOption2 = document.createElement('option');
                                newOption2.text = i;
                                newOption2.value = i;
                                try{
                                    $('forder').add(newOption2, null); // standards compliant; doesn't work in IE
                                } catch(ex) {
                                    $('forder').add(newOption2); // IE only
                                }
                            }
                            //This is to make the last row as selected
                            $('forder').selectedIndex = resp - 1;
                            LoadStatus('');
                            return true;
                        }

                    </script>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['forum_status']; ?></b><br />
                    <?php echo $l['forum_status_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <select name="fstatus" style="font-family:Verdana; font-size:11px">

                        <?php
                        if ($board['status']) {
                            echo '<option value="1" selected="selected">' . $l['active'] . '</option>
                <option value="0">' . $l['locked'] . '</option>';
                        } else {
                            echo '<option value="1">' . $l['active'] . '</option>
                <option value="0" selected="selected">' . $l['locked'] . '</option>';
                        }
                        ?>

                    </select>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['redirect_forum']; ?></b><br />
                    <?php echo $l['url_redirect']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="fredirect" <?php echo ( (isset($_POST['fredirect'])) ? 'value="' . $_POST['fredirect'] . '"' : 'value="' . $board['fredirect'] . '"' ); ?> size="30" />
                </div>
            </div>


            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['forum_icon']; ?></b><br />
                    <?php echo $l['url_image_forum']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="fimage" <?php echo ( (isset($_POST['fimage'])) ? 'value="' . $_POST['fimage'] . '"' : 'value="' . $board['fimage'] . '"' ); ?> size="30" />
                </div>
            </div>


        </div>
        <br />
        <br />

        <div width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <div>
                <div class="adcbg" colspan="2" style="height:25px">
                    <?php echo $l['forum_options']; ?>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['forum_name']; ?></b>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" name="fname" <?php echo ( (isset($_POST['fname'])) ? 'value="' . $_POST['fname'] . '"' : 'value="' . $board['fname'] . '"' ); ?> size="30" />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['forum_description']; ?></b><br />
                    <?php echo $l['forum_description_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <textarea name="fdesc" cols="40" rows="7"><?php echo ( (isset($_POST['fdesc'])) ? $_POST['fdesc'] : $board['description'] ); ?></textarea>

                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['deafult_theme']; ?></b><br />
                    <?php echo $l['deafult_theme_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <select name="ftheme" >

                        <?php
                        echo '<option value="0" ' . ((isset($_POST['ftheme'])) ? (((int) trim($_POST['ftheme']) == 0 ) ? 'selected="selected"' : '' ) : (empty($board['id_skin']) ? 'selected="selected"' : '')) . ' >' . $l['use_board_default'] . '</option>';

                        foreach ($themes as $tk => $tv) {

                            echo '<option value="' . $themes[$tk]['thid'] . '" ' . ((isset($_POST['ftheme']) && (int) trim($_POST['ftheme']) == $tk ) ? 'selected="selected"' : (($board['id_skin'] == $tk && !empty($board['id_skin'])) ? 'selected="selected"' : '')) . ' >' . $themes[$tk]['th_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['rules_title']; ?></b><br />
                    <?php echo $l['rules_title_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" name="frulestitle" <?php echo ( (isset($_POST['frulestitle'])) ? 'value="' . $_POST['frulestitle'] . '"' : 'value="' . $board['frulestitle'] . '"' ); ?> size="40" />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['forum_rules']; ?></b><br />
                    <?php echo $l['forum_rules_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <textarea name="frules" cols="40" rows="5"><?php echo ( (isset($_POST['frules'])) ? $_POST['frules'] : $board['frules'] ); ?></textarea>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['enable_rss_feeds']; ?></b><br />
                    <?php echo $l['enable_rss_feeds_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" size="20"  name="rss" value="<?php echo (empty($_POST['rss']) ? $board['rss'] : $_POST['rss']); ?>" />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['topic_rss_feeds']; ?></b><br />
                    <?php echo $l['topic_rss_feeds_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" size="20"  name="rss_topic" value="<?php echo (empty($_POST['rss_topic']) ? $board['rss_topic'] : $_POST['rss_topic']); ?>" />
                </div>
            </div>
        </div>
        <br />
        <br />

        <div width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <div>
                <div class="adcbg" colspan="2" style="height:25px">
                    <?php echo $l['member_group_set']; ?>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30" valign="top">
                    <br />
                    <b><?php echo $l['member_groups_allow']; ?></b><br />
                    <?php echo $l['member_groups_allow_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;

                    <div>
                        <?php
                        foreach ($member_group['all'] as $m => $mv) {

                            echo '<div>
                <div>
                ' . $member_group['all'][$m]['mem_gr_name'] . '
                </div>
                <div>
                <input type="checkbox" name="member[' . $m . ']" ' . (isset($_POST['member'][$m]) ? 'checked="checked"' : (isset($member_group['presentlyallowed'][$m]) ? 'checked="checked"' : '' ) ) . ' />
                </div>
                </div>';
                        }
                        ?>
                    </div>

                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['increase_member_posts']; ?></b><br />
                    <?php echo $l['increase_member_posts_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="inc_mem_posts" <?php echo (isset($_POST['inc_mem_posts']) ? 'checked="checked"' : (($board['inc_mem_posts']) ? 'checked="checked"' : '') ); ?> />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['override_theme']; ?></b><br />
                    <?php echo $l['override_theme_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="override_skin" <?php echo (isset($_POST['override_skin']) ? 'checked="checked"' : (($board['override_skin']) ? 'checked="checked"' : '') ); ?> />
                </div>
            </div>

        </div>
        <br />
        <br />

        <div width="100%" cellpadding="1" cellspacing="1" class="cbor">

            <div>
                <div class="adcbg" colspan="2" style="height:25px">
                    <?php echo $l['post_settings']; ?>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['allow_polls']; ?></b><br />
                    <?php echo $l['allow_polls_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="allow_poll" <?php echo (isset($_POST['allow_poll']) ? 'checked="checked"' : (($board['allow_poll']) ? 'checked="checked"' : '') ); ?> />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['allow_htm']; ?></b><br />
                    <?php echo $l['allow_htm_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="allow_html" <?php echo (isset($_POST['allow_html']) ? 'checked="checked"' : (($board['allow_html']) ? 'checked="checked"' : '') ); ?> />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['quick_reply']; ?></b><br />
                    <?php echo $l['quick_reply_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="quick_reply" <?php echo (isset($_POST['quick_reply']) ? 'checked="checked"' : (($board['quick_reply']) ? 'checked="checked"' : '') ); ?> />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['quick_topic']; ?></b><br />
                    <?php echo $l['quick_topic_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="quick_topic" <?php echo (isset($_POST['quick_topic']) ? 'checked="checked"' : (($board['quick_topic']) ? 'checked="checked"' : '') ); ?> />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['moderate_topics']; ?></b><br />
                    <?php echo $l['moderate_topics_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="mod_topics" <?php echo (isset($_POST['mod_topics']) ? 'checked="checked"' : (($board['mod_topics']) ? 'checked="checked"' : '') ); ?> />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['moderate_posts']; ?></b><br />
                    <?php echo $l['moderate_posts_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="mod_posts" <?php echo (isset($_POST['mod_posts']) ? 'checked="checked"' : (($board['mod_posts']) ? 'checked="checked"' : '') ); ?> />
                </div>
            </div>

        </div>
        <br />
        <br />

        <div width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <div>
                <div align="center" class="adbg">
                    <input type="submit" name="editboard" value="<?php echo $l['edit_forum']; ?>" />
                </div>
            </div>
        </div>
    </form>

    <?php
    //Admin footers includes Global footers
    adminfoot();
}

//End of function
//This fuction is to create a forum
function createforum_theme() {

    global $globals, $l, $theme, $categories, $forums, $board, $orderoptions, $member_group, $mother_options, $currentmother, $error, $samelevel, $themes, $postcodefield;

    adminhead($l['cp_create_forums']);

    forum_global();

    error_handle($error, '100%');
    ?>
    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="createboard">
        <?php echo $postcodefield; ?>
        <div width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <div>
                <div class="adcbg" colspan="2" style="height:25px">
                    <?php echo $l['general_options']; ?>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['mother_forums']; ?></b>
                </div>
                <div class="adbg">
                    &nbsp;&nbsp;&nbsp;&nbsp;

                    <select onchange="getneworder()" name="fmother" style="font-family:Verdana; font-size:11px" id="fmother">
                        <option value="sm" selected="selected">-----<?php echo $l['select_mother']; ?>-----</option>
                        <?php
                        foreach ($mother_options as $i => $iv) {

                            echo '<option value="' . $mother_options[$i][0] . '" ' . ((isset($_POST['editmother']) && trim($_POST['editmother']) == $mother_options[$i][0] ) ? 'selected="selected"' : '') . '>
            ' . $mother_options[$i][1] . '
            </option>';
                        }//End of for loop
                        ?>
                    </select>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['order']; ?></b>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <select name="forder" style="font-family:Verdana; font-size:11px" id="forder" disabled="disabled">
                        <option value="1">1</option>
                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <span id="loadstatus">
                    </span>
                    <script language="JavaScript" type="text/javascript">
                        bydefault = 'sm';
                        numorder = $('forder').length;
                        defaultorder = '';
                        //alert(defaultorder);
                        //alert(bydefault);
                        //alert(defaultorder);

                        function LoadStatus(itsinner){
                            $('loadstatus').innerHTML = itsinner;
                        }

                        function getneworder(){
                            mother = $('fmother').value;
                            //alert(mother);
                            //alert(bydefault);
                            if(mother != bydefault){
                                LoadStatus('<img src="<?php echo $theme['images']; ?>admin/loading.gif"><?php echo $l['refresh_order']; ?>');
                                AJAX('<?php echo $globals['index_url']; ?>act=admin&adact=forums&seadact=ajax&motherforum='+mother, 'PrintOrder(re)');
                            }else{
                                //Remove the old order list
                                while ($('forder').length > 0) {
                                    $('forder').remove(0);
                                }
                                //Create the new order list
                                for (var i = 1; i <= numorder; i++) {
                                    var newopt = document.createElement('option');
                                    newopt.text = i;
                                    newopt.value = i;
                                    try{
                                        $('forder').add(newopt, null); // standards compliant; doesn't work in IE
                                    }catch(ex){
                                        $('forder').add(newopt); // IE only
                                    }
                                }
                                //This is to make the default order as selected
                                $('forder').disabled = true;
                                LoadStatus('');
                            }
                        };

                        function PrintOrder(resp){
                            //Remove the old order list
                            while ($('forder').length > 0) {
                                $('forder').remove(0);
                            }
                            resp = parseInt(resp);
                            //If there is some problem
                            if(isNaN(resp)){
                                LoadStatus('<?php echo $l['retrieve_data']; ?>');
                                var newopt = document.createElement('option');
                                newopt.text = 'Last';
                                newopt.value = 0;
                                try{
                                    $('forder').add(newopt, null); // standards compliant; doesn't work in IE
                                }catch(ex){
                                    $('forder').add(newopt); // IE only
                                }
                                $('forder').disabled = false;
                                return false;
                            }
                            //Create the new order list
                            for (var i = 1; i <= resp; i++) {
                                var newopt = document.createElement('option');
                                newopt.text = i;
                                newopt.value = i;
                                try{
                                    $('forder').add(newopt, null); // standards compliant; doesn't work in IE
                                }catch(ex){
                                    $('forder').add(newopt); // IE only
                                }
                            }
                            //This is to make the last row as selected
                            $('forder').selectedIndex = resp - 1;
                            $('forder').disabled = false;
                            LoadStatus('');
                        };

                    </script>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['forum_status']; ?></b><br />
                    <?php echo $l['forum_status_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <select name="fstatus" style="font-family:Verdana; font-size:11px">

                        <option value="1" selected><?php echo $l['active']; ?></option>
                        <option value="0"><?php echo $l['locked']; ?></option>

                    </select>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['redirect_forum']; ?></b><br />
                    <?php echo $l['url_redirect']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="fredirect" <?php echo ( (isset($_POST['fredirect'])) ? 'value="' . $_POST['fredirect'] . '"' : '' ); ?> size="30" />
                </div>
            </div>


            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['forum_icon']; ?></b><br />
                    <?php echo $l['url_image_forum']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input name="fimage" <?php echo ( (isset($_POST['fimage'])) ? 'value="' . $_POST['fimage'] . '"' : '' ); ?> size="30" />
                </div>
            </div>

        </div>
        <br />
        <br />

        <div width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <div>
                <div class="adcbg" colspan="2" style="height:25px">
                    <?php echo $l['forum_options']; ?>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['forum_name']; ?></b>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" name="fname" <?php echo ( (isset($_POST['fname'])) ? 'value="' . $_POST['fname'] . '"' : '' ); ?> size="30" />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['forum_description']; ?></b><br />
                    <?php echo $l['forum_description_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <textarea name="fdesc" cols="30" rows="5"><?php echo ( (isset($_POST['fdesc'])) ? $_POST['fdesc'] : '' ); ?></textarea>

                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['deafult_theme']; ?></b><br />
                    <?php echo $l['deafult_theme_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <select name="ftheme" >

                        <?php
                        echo '<option value="0" ' . ((isset($_POST['ftheme'])) ? (((int) trim($_POST['ftheme']) == -1 ) ? 'selected="selected"' : '' ) : '' ) . ' >' . $l['use_board_default'] . '</option>';

                        foreach ($themes as $tk => $tv) {

                            echo '<option value="' . $themes[$tk]['thid'] . '" ' . ((isset($_POST['ftheme']) && (int) trim($_POST['ftheme']) == $tk ) ? 'selected="selected"' : '' ) . ' >' . $themes[$tk]['th_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['rules_title']; ?></b><br />
                    <?php echo $l['rules_title_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" name="frulestitle" <?php echo ( (isset($_POST['frulestitle'])) ? 'value="' . $_POST['frulestitle'] . '"' : '' ); ?> size="40" />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['forum_rules']; ?></b><br />
                    <?php echo $l['forum_rules_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <textarea name="frules" cols="40" rows="5"><?php echo ( (isset($_POST['frules'])) ? $_POST['frules'] : '' ); ?></textarea>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['enable_rss_feeds']; ?></b><br />
                    <?php echo $l['enable_rss_feeds_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" size="20"  name="rss" value="<?php echo (empty($_POST['rss']) ? '0' : $_POST['rss']); ?>" />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['topic_rss_feeds']; ?></b><br />
                    <?php echo $l['topic_rss_feeds_exp']; ?>.
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" size="20"  name="rss_topic" value="<?php echo (empty($_POST['rss_topic']) ? '0' : $_POST['rss_topic']); ?>" />
                </div>
            </div>

        </div>
        <br />
        <br />

        <div width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <div>
                <div class="adcbg" colspan="2" style="height:25px">
                    <?php echo $l['member_group_set']; ?>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30" valign="top">
                    <br />
                    <b><?php echo $l['member_groups_allow']; ?></b><br />
                    <?php echo $l['member_groups_allow_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;

                    <div>
                        <?php
                        foreach ($member_group['all'] as $m => $mv) {

                            echo '<div>
                <div>
                ' . $member_group['all'][$m]['mem_gr_name'] . '
                </div>
                <div>
                <input type="checkbox" name="member[' . $m . ']" ' . (isset($_POST['member'][$m]) ? 'checked="checked"' : '' ) . ' />
                </div>
                </div>';
                        }
                        ?>
                    </div>

                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['increase_member_posts']; ?></b><br />
                    <?php echo $l['increase_member_posts_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="inc_mem_posts" <?php echo (isset($_POST['inc_mem_posts']) ? 'checked="checked"' : 'checked="checked"' ); ?> />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['override_theme']; ?></b><br />
                    <?php echo $l['override_theme_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="override_skin" <?php echo (isset($_POST['override_skin']) ? 'checked="checked"' : '' ); ?> />
                </div>
            </div>

        </div>
        <br />
        <br />

        <div width="100%" cellpadding="1" cellspacing="1" class="cbor">

            <div>
                <div class="adcbg" colspan="2" style="height:25px">
                    <?php echo $l['post_settings']; ?>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['allow_polls']; ?></b><br />
                    <?php echo $l['allow_polls_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="allow_poll" <?php echo (isset($_POST['allow_poll']) ? 'checked="checked"' : 'checked="checked"' ); ?> />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['allow_htm']; ?></b><br />
                    <?php echo $l['allow_htm_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="allow_html" <?php echo (isset($_POST['allow_html']) ? 'checked="checked"' : 'checked="checked"' ); ?> />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['quick_reply']; ?></b><br />
                    <?php echo $l['quick_reply_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="quick_reply" <?php echo (isset($_POST['quick_reply']) ? 'checked="checked"' : '' ); ?> />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['quick_topic']; ?></b><br />
                    <?php echo $l['quick_topic_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="quick_topic" <?php echo (isset($_POST['quick_topic']) ? 'checked="checked"' : '' ); ?> />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['moderate_topics']; ?></b><br />
                    <?php echo $l['moderate_topics_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="mod_topics" <?php echo (isset($_POST['mod_topics']) ? 'checked="checked"' : '' ); ?> />
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['moderate_posts']; ?></b><br />
                    <?php echo $l['moderate_posts_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="checkbox" name="mod_posts" <?php echo (isset($_POST['mod_posts']) ? 'checked="checked"' : '' ); ?> />
                </div>
            </div>

        </div>
        <br />
        <br />

        <div width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <div>
                <div align="center" class="adbg">
                    <input type="submit" name="createboard" value="<?php echo $l['create_forum']; ?>" />
                </div>
            </div>
        </div>
    </form>

    <?php
    //Admin footers includes Global footers
    adminfoot();
}

function ajax_getneworder_theme() {
    
}

//This fuction is to delete a forum
function deleteforum_theme() {

    global $globals, $l, $theme, $categories, $forums, $board, $mother_options, $mother_options_in, $error, $samelevel, $postcodefield;

    adminhead($l['cp_delete_forums']);

    forum_global();

    error_handle($error, '100%');
    ?>
    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="deleteboard">
        <?php echo $postcodefield; ?>
        <div width="100%" cellpadding="1" cellspacing="1" class="cbor">
            <div>
                <div class="adcbg" colspan="2" style="height:25px">
                    <?php echo $l['deleting_options']; ?>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['delete_forums']; ?></b>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" name="forumname" disabled="disabled" value="<?php echo $board['fname']; ?>" size="30" />
                    <!--<select name="deltop" style="font-family:Verdana; font-size:11px" disabled="disabled" >
                                    <option value="1" <?php echo ((isset($_POST['deltop']) && (int) trim($_POST['deltop']) == 1 ) ? 'selected="selected"' : '' ); ?> >Delete Forums</option>
                                    <option value="2" <?php echo ((isset($_POST['deltop']) && (int) trim($_POST['deltop']) == 2 ) ? 'selected="selected"' : '' ); ?> >Shift Topics</option>
                                    </select>-->
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['shift_inboards_to']; ?></b><br />
                    <?php echo $l['shift_inboards_to_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <select name="shiftinto" style="font-family:Verdana; font-size:11px">

                        <?php
                        foreach ($mother_options as $i => $iv) {

                            echo '<option value="' . $mother_options[$i][0] . '" ' . ((isset($_POST['shifttopto']) && trim($_POST['shifttopto']) == $mother_options[$i][0] ) ? 'selected="selected"' : '' ) . '>
            ' . $mother_options[$i][1] . '
            </option>';
                        }//End of for loop
                        ?>
                    </select>
                </div>
            </div>

            <div>
                <div align="center" class="adbg" colspan="2">
                    <input type="submit" name="deleteforum" value="<?php echo $l['confirm_delete']; ?>" />
                </div>
            </div>
        </div>
    </form>

    <?php
    //Admin footers includes Global footers
    adminfoot();
}

function forumreorder_theme() {

    global $globals, $l, $theme, $categories, $error, $onload, $dmenus, $mother_options, $reoforums;

    //Pass to onload to initialize a JS
    if (!empty($reoforums)) {

        $onload['forumreoder'] = 'init_reoder()';
    }

    //Admin Headers includes Global Headers
    adminhead($l['cp_reorder_forums']);
    ?>

    <div width="100%" cellpadding="1" cellspacing="1" class="cbor">

        <div>
            <div align="right" width="40%" class="adcbg1">
                <img src="<?php echo $theme['images']; ?>admin/categories.png">
            </div>
            <div align="left" class="adcbg1">

                <font class="adgreen"><?php echo $l['reorder_forums']; ?></font><br />

            </div>
        </div>

        <div>
            <div align="left" colspan="2" class="adbg">
                <?php echo $l['reorder_forums_exp']; ?>
            </div>
        </div>

    </div>
    <br /><br />
    <?php
    error_handle($error, '100%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action="" method="post" name="forumreorderform">
        <div width="100%" cellpadding="2" cellspacing="1" class="cbor">

            <div>
                <div class="adcbg" colspan="2">
                    <?php echo $l['reorder_forum']; ?>
                </div>
            </div>

            <div>
                <div class="adbg" width="40%" height="30">
                    <b><?php echo $l['select_parent']; ?></b><br />
                    <?php echo $l['select_parent_exp']; ?>
                </div>
                <div class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;
                    <select name="parent" style="font-family:Verdana; font-size:11px" id="parent" onchange="jumptoparent()">
                        <option value="sm" selected="selected">-----<?php echo $l['select_parent_e']; ?>-----</option>
                        <?php
                        foreach ($mother_options as $i => $iv) {

                            echo '<option value="' . $mother_options[$i][0] . '" ' . ((isset($_GET['parent']) && trim($_GET['parent']) == $mother_options[$i][0] ) ? 'selected="selected"' : '' ) . '>
            ' . $mother_options[$i][1] . '
            </option>';
                        }//End of for loop
                        ?>
                    </select>
                    <script type="text/javascript">
                        function jumptoparent(){
                            var par = $('parent').value;
                            window.location = '<?php echo $globals['index_url'] . 'act=admin&adact=forums&seadact=forumreorder&parent='; ?>'+par;
                        }
                    </script>
                </div>
            </div>

        </div>
        <br /><br />

        <?php if (!empty($reoforums)) { ?>

            <div width="60%" cellpadding="0" cellspacing="0" align="center" border="0">
                <div><div id="for_reorder_pos" width="100%"></div></div>
            </div>
            <br /><br />
            <script type="text/javascript">

                //The array id of all the elements to be reordered
                reo_r = new Array(<?php echo implode(', ', array_keys($reoforums)); ?>);

                //The id of the table that will hold the elements
                reorder_holder = 'for_reorder_pos';

                //The prefix of the Dom Drag handle for every element
                reo_ha = 'forha';

                //The prefix of the Dom Drag holder for every element(the parent of every element)
                reo_ho = 'for';

                //The prefix of the Hidden Input field for the reoder value for every element
                reo_hid = 'forhid';

            </script>
            <?php js_reorder(); ?>

            <div width="100%" cellpadding="1" cellspacing="1" class="cbor">
                <div>
                    <div align="center" class="adbg">
                        <?php
                        $temp = 1;
                        foreach ($reoforums as $k => $v) {

                            $dmenus[] = '<div id="for' . $k . '">
<div cellpadding="0" cellspacing="0" class="catreo" id="forha' . $k . '" onmousedown="this.style.zIndex=\'1\'" onmouseup="this.style.zIndex=\'0\'">
<div><div>
&nbsp;&nbsp;' . $v . '
</div></div>
</div>
</div>';

                            echo '<input type="hidden" name="for[' . $k . ']" value="' . $temp . '" id="forhid' . $k . '" />';

                            $temp = $temp + 1;
                        }
                        ?>
                        <input type="submit" name="forumreorder" value="<?php echo $l['re_rder']; ?>" />
                    </div>
                </div>
            </div>

            <?php
        }
        ?>

    </form>

    <?php
    adminfoot();
}
?>