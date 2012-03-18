<?php

function members_theme() {

    global $user, $logged_in, $globals, $AEF_SESS, $theme, $members, $count, $l, $group;

    //The header
    aefheader($l['<title>']);
    ?>
    <script type="text/javascript">
        function gotopage(val){

            gourl = '<?php echo $globals['index_url'] . 'act=members&sortby=' . (empty($_GET['sortby']) ? '' : $_GET['sortby']) . '&order=' . (empty($_GET['order']) ? '' : $_GET['order']) . '&beg=' . (empty($_GET['beg']) ? '' : $_GET['beg']); ?>&mpg=';

            //alert (gourl+val);

            window.location = gourl+val;

        }
    </SCRIPT>
    <?php
    echo '<div align="right"><select onchange="gotopage(this.value)" name="gotopage">';

    $num_pages = ceil($count / $globals['maxmemberlist']);

    for ($i = 1; $i <= $num_pages; $i++) {

        echo '<option value="' . $i . '" ' . ((isset($_GET['mpg']) && trim($_GET['mpg']) == $i ) ? 'selected="selected"' : '' ) . ' >' . $i . '</option>';
    }

    echo '</select></div><br /><br />';
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" method="get" action="<?php echo $globals['index_url']; ?>" name="sortform" >
        <table width="100%" class="cbor" cellpadding="6" cellspacing="1">
            <tr>
                <td>
                    <input type="hidden" name="act" value="members" />
                    <?php echo $l['sort_by']; ?>: <select name="sortby">
                        <option value="1" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 1 ? ' selected="selected"' : ''); ?> ><?php echo $l['sortby_username']; ?></option>
                        <option value="2" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 2 ? ' selected="selected"' : ''); ?> ><?php echo $l['sortby_member_group']; ?></option>
                        <option value="3" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 3 ? ' selected="selected"' : ''); ?> ><?php echo $l['sortby_reg_time']; ?></option>
                        <option value="4" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 4 ? ' selected="selected"' : ''); ?> ><?php echo $l['sortby_num_posts']; ?></option>
                        <option value="5" <?php echo (!empty($_GET['sortby']) && trim($_GET['sortby']) == 5 ? ' selected="selected"' : ''); ?> ><?php echo $l['sortby_online']; ?></option>
                    </select>
                    &nbsp;&nbsp;
                    <select name="order">
                        <option value="1" <?php echo (!empty($_GET['order']) && trim($_GET['order']) == 1 ? ' selected="selected"' : ''); ?> ><?php echo $l['sortby_ascending']; ?></option>
                        <option value="2" <?php echo (!empty($_GET['order']) && trim($_GET['order']) == 2 ? ' selected="selected"' : ''); ?> ><?php echo $l['sortby_descending']; ?></option>
                    </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <?php echo $l['beginning_with']; ?> : <input type="text" name="beg" size="25" value="<?php echo (isset($_GET['beg']) ? $_GET['beg'] : ''); ?>" />
                    &nbsp;&nbsp;
                    <input type="submit" value="<?php echo $l['go']; ?>" />
                </td>
            </tr>
        </table>
    </form>
    <br />

    <?php
    //The first row that is Headers
    echo'<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
    <td>
    <table width="100%" cellpadding="0" cellspacing="0"><tr>
    <td class="tthl"></td>
    <td class="tthc" align="center">' . $l['members_list'] . '</td>
    <td class="tthr"></td>
    </tr>
    </table>
    </td>
    </tr>

    <tr>
    <td width="100%">

    <table width="100%" class="cbgbor" cellpadding="6" cellspacing="1">

    <tr>
    <td class="mlcbg" width="25%">' . $l['username_header'] . '</td>
    <td class="mlcbg" width="20%" align="center">' . $l['group_header'] . '</td>
    <td class="mlcbg" width="25%" align="center">' . $l['date_reg_header'] . '</td>
    <td class="mlcbg" width="15%" align="center">' . $l['posts_header'] . '</td>
    <td class="mlcbg" width="15%" align="center">' . $l['status_header'] . '</td>
    </tr>';

    if (empty($members)) {

        echo '<tr>
            <td class="ucpflc" colspan="5" align="center">
                <b>' . $l['no_result'] . '</b>
            </td>
        </tr>';
    } else {

        foreach ($members as $memberIndex => $memberInstance) {

            echo '<tr>

            <td class="ucpflc">
            <a style="color:' . $memberInstance['mem_gr_colour'] . '" href="' . $globals['index_url'] . 'mid=' . $members[$memberIndex]['id'] . '">' . $members[$memberIndex]['username'] . '</a>
            </td>

            <td class="ucpflc" align="center">
            <span color="' . $members[$memberIndex]['mem_gr_colour'] . '">' . $members[$memberIndex]['mem_gr_name'] . '</span>
            </td>

            <td class="ucpflc" align="left">
            ' . datify($members[$memberIndex]['r_time']) . '
            </td>

            <td class="ucpflc" align="center">
            ' . $members[$memberIndex]['posts'] . '
            </td>

            <td class="ucpflc" align="center">
            <img src="' . (empty($members[$memberIndex]['time']) ? $theme['images'] . 'offline.png' : $theme['images'] . 'online.png' ) . '" title="' . (empty($members[$memberIndex]['time']) ? $l['offline'] : $l['online'] ) . '">
            </td>';

            echo '</tr>';
        }
    }

    echo '</table>
    </td>
    </tr>
    <tr>
    <td><img src="' . $theme['images'] . 'cbot.png" width="100%" height="15"></td>
    </tr>

    </table>
    <br />';

    echo '<br /><br /><div align="right"><select onchange="gotopage(this.value)" name="gotopage">';

    $num_pages = ceil($count / $globals['maxmemberlist']);

    for ($i = 1; $i <= $num_pages; $i++) {

        echo '<option value="' . $i . '" ' . ((isset($_GET['mpg']) && trim($_GET['mpg']) == $i ) ? 'selected="selected"' : '' ) . ' >' . $i . '</option>';
    }

    echo '</select></div>';

    //The defualt footers
    aeffooter();
}
?>