<?php

function select_theme() {

    global $fid, $theme, $globals, $logged_in, $error, $user, $board, $starters, $topics, $mother_options;

    //Global Headers
    aefheader('Merge Topics');
    ?>
    <script language="JavaScript" type="text/javascript">
        var req;

        function LoadStatus(itsinner){
            document.getElementById("loadstatus").innerHTML = itsinner;
        }

        function getnewtopics(){

            metfid = document.getElementById("metfid").value;

            LoadStatus('<img src="<?php echo $theme['images']; ?>admin/loading.gif"> Refreshing Order List ...');

            LoadOrder('<?php echo $globals['index_url']; ?>act=admin&adact=forums&seadact=ajax&motherforum='+mother,1);


        }

        function ajax(url,mode){
            req = false
            // branch for native XMLHttpRequest object
            if(window.XMLHttpRequest) {
                try {
                    req = new XMLHttpRequest();
                } catch(e) {
                    req = false;
                }
                // branch for IE/Windows ActiveX version
            }
            else if(window.ActiveXObject) {
                try {
                    req = new ActiveXObject("Msxml2.XMLHTTP");
                } catch(e) {
                    try {
                        req = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch(e) {
                        req = false;
                    }
                }
            }
            function modeprocess(){
                switch(mode){
                    case 1:
                        return PrintOrder;
                        break;
                }
            }

            if(req) {
                req.onreadystatechange = modeprocess();
                req.open("GET", url, true);
                req.send("");

            } else {
                LoadStatus('Unable to Retrieve Data.');
            }

        }

        function PrintOrder() {
            // only if req shows "loaded"
            if (req.readyState==4) {
                //only if OK
                if (req.status == 200) {
                    // only if "OK"...processing statements go here..
                    re = req.responseText // result of the req object
                    //alert(re);

                    while (forder.length> 0) {
                        forder.remove(0);
                    }

                    //finallists = "";

                    for (var i = 1; i <= re; i++) {
                        //finallists += "<option value="+i+">"+i+"</option>"
                        var OptNew = document.createElement('option');
                        OptNew.text = i;
                        OptNew.value = i;
                        try {
                            forder.add(OptNew, null); // standards compliant; doesn't work in IE
                        }
                        catch(ex) {
                            forder.add(OptNew); // IE only
                        }
                    }

                    //This is to make the last row as selected
                    forder.selectedIndex = re - 1;

                    LoadStatus('');

                    //alert(forder.innerHTML);

                } else {
                    LoadStatus('Unable to Retrieve Data.');
                }
            }
        }


    </script>
    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="get" name="metselectform">
        <table width="100%" cellpadding="1" cellspacing="5">

            <tr>
                <td width="50%" valign="top" align="center">

                    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

                        <tr>
                            <td class="patcbg" colspan="2" align="left">
                                Select the topics to merge
                            </td>
                        </tr>


                        <?php
                        if (!empty($mother_options)) {

                            echo '<tr>
<td width="20%" class="rlc">Forum: </td>
<td class="rrc">
<select name="metfid" style="font-family:Verdana; font-size:11px">';

                            foreach ($mother_options as $i => $iv) {

                                echo '<option value="' . $mother_options[$i][0] . '" ' . ((isset($_POST['metfid']) && trim($_POST['metfid']) == $mother_options[$i][0] ) ? 'selected="selected"' : '' ) . '>
            ' . $mother_options[$i][1] . '
            </option>';
                            }//End of for loop

                            echo '</select>
</td>
</tr>';
                        }
                        ?>



                    </table>

                </td>

                <td width="50%" valign="top" align="center">

                    <table width="100%" cellpadding="1" cellspacing="1" class="cbor">

                        <tr>
                            <td class="patcbg" colspan="2" align="left">
                                The topics to be merged
                            </td>
                        </tr>

                    </table>

                </td>

            </tr>
        </table>
    </form>


    <?php
}

function merge_theme() {

    global $fid, $theme, $globals, $logged_in, $l, $error, $user, $board, $starters, $topics;

    //Global Headers
    aefheader($l['<title>']);

    error_handle($error, '90%', true);
    ?>

    <center>

        <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="mergetopicsform">
            <br />
            <table width="90%" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table width="100%" cellpadding="0" cellspacing="0"><tr>
                                <td class="pcbgl"></td>
                                <td class="pcbg" align="left"><?php echo $l['mergetopics_heading']; ?></td>
                                <td class="pcbgr"></td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table width="100%" cellpadding="1" cellspacing="1" class="cbgbor">

                            <tr>
                                <td class="metlc" width="25%"><?php echo $l['merge_title']; ?></td>
                                <td class="metrc">
                                    <select name="topic">
                                        <?php
                                        foreach ($topics as $k => $t) {

                                            echo '<option value="' . $k . '" ' . ((isset($_POST['topic']) && trim($_POST['topic']) == $k ) ? 'selected="selected"' : '' ) . ' >' . $t['topic'] . '&nbsp;&nbsp;&nbsp;&nbsp;Topic&nbsp;-&nbsp;' . $k . '</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td class="metlc"><?php echo $l['merge_starter']; ?></td>
                                <td class="metrc">
                                    <select name="t_mem_id">
                                        <?php
                                        foreach ($topics as $k => $t) {

                                            echo '<option value="' . $t['starter'] . '" ' . ((isset($_POST['t_mem_id']) && trim($_POST['t_mem_id']) == $t['starter'] ) ? 'selected="selected"' : '' ) . ' >' . (empty($t['username']) ? 'Guest' : $t['username']) . '&nbsp;&nbsp;&nbsp;&nbsp;Topic&nbsp;-&nbsp;' . $k . '</option>';
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>

                            <tr>
                                <td class="metlc"><?php echo $l['merge_destination']; ?></td>
                                <td class="metrc">
                                    <input type="text" value="<?php echo $board['fname']; ?>" disabled="disabled" />
                                </td>
                            </tr>


                            <tr>
                                <td colspan="2" class="metrc" style="text-align:center"><input type="submit" name="merge" value="<?php echo $l['merge_submit_button']; ?>"/></td>
                            </tr>
                        </table>

                    </td>
                </tr>

                <tr>
                    <td><img src="<?php echo $theme['images']; ?>cbot.png" width="100%" height="10"></td>
                </tr>

            </table>
            <br />
        </form>

    </center>

    <?php
    aeffooter(); //footers that have to be there.
}
?>