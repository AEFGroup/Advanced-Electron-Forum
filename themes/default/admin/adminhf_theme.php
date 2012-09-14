<?php
//////////////////////////////////////////////////////////////
//===========================================================
// adminhf_theme.php(Admin)
//===========================================================
// AEF : Advanced Electron Forum
// Version : 1.0.10
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

function adminhead($title = '') {

    global $globals, $theme, $onload, $l;

    //Pass to onload to initialize a JS
    $onload['admenu'] = 'init_admenu()';

    //Global Headers
    aefheader($title);
    ?>

    <table width="100%">
        <tr>
            <td width="23%" valign="top">

                <script type="text/javascript" language="javascript">
                    umimages = "<?php echo $theme['images']; ?>";
                </script>

                <link rel="stylesheet" type="text/css" href="<?php echo $theme['url']; ?>/adminstyle.css" />
                <script language="javascript" type="text/javascript" src="<?php echo $theme['url']; ?>/js/slidemenu.js"></script>
                <script type="text/javascript">
                    var admenu;
                    function init_admenu() {
                        admenu = new SDMenu("admenu");
                        admenu.init();
                    }
                </script>

                <div id="admenu" class="sdmenu">
                    <div style="border:1px solid #CCC">
                        <span><?php echo $l['admin_options']; ?></span>
                        <a href="<?php echo $globals['index_url']; ?>act=admin"><?php echo $l['admin_index']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>"><?php echo $l['forum_index']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&seadact=credits"><?php echo $l['credits']; ?></a>
                    </div>

                    <br />

                    <div style="border:1px solid #CCC">
                        <span><?php echo $l['cpanel']; ?></span>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=conpan&seadact=coreset"><?php echo $l['core_settings']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=conpan&seadact=mysqlset"><?php echo $l['mysql_conf']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=conpan&seadact=onoff"><?php echo $l['maintenance_mode']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=conpan&seadact=mailset"><?php echo $l['mail_settings']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=conpan&seadact=genset"><?php echo $l['general_settings']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=conpan&seadact=shoutboxset"><?php echo $l['shoutbox_settings']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=conpan&seadact=seoset"><?php echo $l['seo_settings']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=conpan&seadact=banset"><?php echo $l['ban_settings']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=conpan&seadact=updates"><?php echo $l['updates']; ?></a>
                    </div>

                    <br />

                    <div style="border:1px solid #CCC">
                        <span><?php echo $l['categories']; ?></span>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=categories"><?php echo $l['manage_categories']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=categories&seadact=createcat"><?php echo $l['create_new_category']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=categories&seadact=catreorder"><?php echo $l['reorder_categories']; ?></a>
                    </div>

                    <br />

                    <div style="border:1px solid #CCC">
                        <span><?php echo $l['forums']; ?></span>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=forums"><?php echo $l['manage_forums']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=forums&seadact=createforum"><?php echo $l['create_new_forum']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=forums&seadact=forumreorder"><?php echo $l['reorder_forums']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=fpermissions"><?php echo $l['forum_permissions']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=fpermissions&seadact=createfpermissions"><?php echo $l['new_forum_permissions']; ?>s</a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=moderators"><?php echo $l['moderators']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=recyclebin"><?php echo $l['recycle_bin']; ?></a>
                    </div>

                    <br />

                    <div style="border:1px solid #CCC">
                        <span><?php echo $l['user_settings']; ?></span>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=users&seadact=proacc"><?php echo $l['profile_account']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=users&seadact=avaset"><?php echo $l['avatar_settings']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=users&seadact=ppicset"><?php echo $l['personal_picture']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=users&seadact=pmset"><?php echo $l['pm_settings']; ?></a>
                    </div>

                    <br />

                    <div style="border:1px solid #CCC">
                        <span><?php echo $l['user_groups']; ?></span>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=ug&seadact=manug"><?php echo $l['manage_user_groups']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=ug&seadact=addug&ugid=0"><?php echo $l['add_user_groups']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=ug&seadact=editper"><?php echo $l['user_group_permissions']; ?></a>
                    </div>

                    <br />

                    <div style="border:1px solid #CCC">
                        <span><?php echo $l['themes']; ?></span>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=skin&seadact=manskin"><?php echo $l['theme_manager']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=skin&seadact=import"><?php echo $l['import_themes']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=skin&seadact=uninstall"><?php echo $l['uninstall_themes']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=skin&seadact=settings&theme_id=<?php echo $globals['theme_id']; ?>"><?php echo $l['theme_settings']; ?></a>
                    </div>

                    <br />

                    <div style="border:1px solid #CCC">
                        <span><?php echo $l['registration_login']; ?></span>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=reglog&seadact=regset"><?php echo $l['registration_settings']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=reglog&seadact=agerest"><?php echo $l['age_restrictions']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=reglog&seadact=reserved"><?php echo $l['set_reserved_names']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=reglog&seadact=logset"><?php echo $l['log_in_settings']; ?></a>
                    </div>

                    <br />

                    <div style="border:1px solid #CCC">
                        <span><?php echo $l['account_approvals']; ?></span>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=approvals&seadact=manval"><?php echo $l['manage_validating']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=approvals&seadact=awapp"><?php echo $l['awaiting_approval']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=approvals&seadact=coppaapp"><?php echo $l['coppa_approval']; ?></a>
                    </div>

                    <br />

                    <div style="border:1px solid #CCC">
                        <span><?php echo $l['posts_messages']; ?></span>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=tpp&seadact=topics"><?php echo $l['topic_settings']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=tpp&seadact=posts"><?php echo $l['post_settings']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=tpp&seadact=polls"><?php echo $l['poll_settings']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=tpp&seadact=words"><?php echo $l['words_censorship']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=tpp&seadact=bbc"><?php echo $l['bulletin_board_code']; ?></a>
                    </div>

                    <br />

                    <div style="border:1px solid #CCC">
                        <span><?php echo $l['attach']; ?></span>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=attach&seadact=attset"><?php echo $l['attach_settings']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=attach&seadact=attmime"><?php echo $l['attach_types']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=attach&seadact=addmime"><?php echo $l['add_attach_type']; ?></a>
                    </div>

                    <br />

                    <div style="border:1px solid #CCC">
                        <span><?php echo $l['smileys']; ?></span>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=smileys&seadact=smman"><?php echo $l['manage_smileys']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=smileys&seadact=smset"><?php echo $l['smiley_settings']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=smileys&seadact=smreorder"><?php echo $l['reorder_smileys']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=smileys&seadact=addsm"><?php echo $l['add_a_smiley']; ?></a>
                    </div>

                    <br />

                    <div style="border:1px solid #CCC">
                        <span><?php echo $l['backup']; ?></span>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=backup&seadact=fileback"><?php echo $l['files_folders']; ?></a>
                        <a href="<?php echo $globals['index_url']; ?>act=admin&adact=backup&seadact=dbback"><?php echo $l['forum_database']; ?></a>
                    </div>

                </div>

            </td>

            <td valign="top">

                <?php
            }

//end function adminhead

            function adminfoot() {

                global $globals, $theme;
                ?>

            </td>
        </tr>
    </table>

    <?php
    //Global footers
    aeffooter();
}

//end function adminfoot

function js_reorder() {

    global $theme, $globals, $user;

    /*
      These are JS VARS for this function. Must be defined for working

      //The array id of all the elements to be reordered
      reo_r = new Array(<?php echo implode(', ', array_keys($categories));?>);

      //The id of the table that will hold the elements
      reorder_holder = 'reo_reorder_pos';

      //The prefix of the Dom Drag handle for every element
      reo_ha = 'catha';

      //The prefix of the Dom Drag holder for every element(the parent of every element)
      reo_ho = 'cat';

      //The prefix of the Hidden Input field for the reoder value for every element
      reo_hid = 'cathid'; */
    ?>
    <script type="text/javascript">

        //////////////////////////////////////////////////////////////
        // js_shoutbox
        // By Electron, Ronak Gupta, Pulkit Gupta
        // Please Read the Terms of use at http://www.anelectron.com
        // (C)AEF Group All Rights Reserved.
        //////////////////////////////////////////////////////////////

        function init_reoder(){
            var init_pos = findelpos($(reorder_holder));
            var tot_height = 0;
            var width = $(reorder_holder).offsetWidth;
            var top = init_pos[1];

            //Find the prerequisites
            for(x in reo_r){
                tot_height = tot_height + $(reo_ha+reo_r[x]).offsetHeight + 10;
                $(reo_ha+reo_r[x]).style.width = width+'px';
            }
            $(reorder_holder).style.height = tot_height+'px';//Make it long
            tot_height = (tot_height + init_pos[1]);

            //Initialize the Drag
            for(x in reo_r){
                Drag.init($(reo_ho+reo_r[x]), $(reo_ha+reo_r[x]), init_pos[0], init_pos[0], (init_pos[1]-10), tot_height);
                $(reo_ha+reo_r[x]).onDragEnd = function(){
                    reorder();
                };
                $(reo_ha+reo_r[x]).style.left = init_pos[0]+'px';
                $(reo_ha+reo_r[x]).style.top = top+'px';
                showel(reo_ha+reo_r[x]);
                top = top + $(reo_ha+reo_r[x]).offsetHeight + 10;
            }
        }

        //This will reorder
        function reorder(){
            var reo_arr = new Array();
            var reo_arr_pos = new Array();
            for(x in reo_r){
                var pos = findelpos($(reo_ha+reo_r[x]));
                //A position may be used if x smiley is left over y sm at the same position
                if(is_pos_there(reo_arr_pos, pos[1])){
                    pos[1] = pos[1] + 1;
                }
                reo_arr[x] = pos[1]+'|'+reo_r[x];
                reo_arr_pos[x] = pos[1];
            }
            reo_arr_pos = reo_arr_pos.sort(sortnumber);
            for(x in reo_arr_pos){
                reo_r[x] = find_reokey(reo_arr, reo_arr_pos[x]);
            }

            //Re-position Vars
            var init_pos = findelpos($(reorder_holder));
            var top = init_pos[1];
            //Re-position
            for(x in reo_r){
                $(reo_ha+reo_r[x]).style.top = top+'px';
                top = top + $(reo_ha+reo_r[x]).offsetHeight + 10;
                $(reo_hid+reo_r[x]).value = (parseInt(x) + 1);
            }
        }


        function find_reokey(arr, val){
            var x;
            for(x in arr){
                var r = arr[x].split('|');
                if(r[0] == val){
                    return r[1];
                }
            }
            return null;
        }

        //Tells if the position is already there - Like in_array
        function is_pos_there(arr, val){
            var x;
            for(x in arr){
                if(arr[x] == val){
                    return true;
                }
            }
            return false;
        }
        //Just a sort function
        function sortnumber(a, b){
            return a - b;
        }

    </script>
    <?php
}
?>