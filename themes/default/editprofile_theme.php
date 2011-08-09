<?php

function editprofile_theme() {

    global $user, $logged_in, $globals, $AEF_SESS, $theme, $l, $member, $error, $user_group;

    //The header
    aefheader($l['<title>'] . ' ' . $member['username']);

    error_handle($error);
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="editprofileform">

        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0"><tr>
                            <td class="ucpcbgl"></td>
                            <td class="ucpcbg"><?php echo $l['edit_heading'] . ' ' . $member['username']; ?></td>
                            <td class="ucpcbgr"></td>		
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td class="cbgbor">

                    <table width="100%" cellpadding="2" cellspacing="1">

                        <tr>
                            <td class="ucpfcbg1" colspan="2" align="center">
                                <img src="<?php echo $theme['images']; ?>usersprofile.png" />
                            </td>
                        </tr>

                        <tr>
                            <td class="ucpflc" width="30%">
                                <b><?php echo $l['members_username']; ?>* :</b>
                            </td>
                            <td class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="text" size="45" name="username" value="<?php echo (isset($_POST['username']) ? $_POST['username'] : $member['username']); ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td class="ucpflc" width="30%">
                                <b><?php echo $l['email_address']; ?>* :</b><br />
                                <font class="ucpfexp"><?php echo $l['email_address_exp']; ?></font>
                            </td>
                            <td class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="text" size="45" name="email" value="<?php echo (isset($_POST['email']) ? $_POST['email'] : $member['email']); ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td class="ucpflc" width="30%">
                                <b><?php echo $l['user_group']; ?>* :</b><br />
                                <font class="ucpfexp"><?php echo $l['user_group_exp']; ?></font>
                            </td>
                            <td class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<select name="u_member_group" style="font-family:Verdana; font-size:11px">

                                    <?php
                                    foreach ($user_group as $ug => $uv) {

                                        echo '<option value="' . $ug . '" ' . ((isset($_POST['u_member_group']) && trim($_POST['u_member_group']) == $ug ) ? 'selected="selected"' : ($member['u_member_group'] == $ug ? 'selected="selected"' : '')) . '>
		' . $user_group[$ug]['mem_gr_name'] . '
		</option>';
                                    }//End of for loop
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="ucpflc" width="30%">
                                <b><?php echo $l['real_name']; ?> :</b><br />
                                <font class="ucpfexp"><?php echo $l['real_name_exp']; ?></font>
                            </td>
                            <td class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="text" size="45" name="realname" value="<?php echo (isset($_POST['realname']) ? $_POST['realname'] : $member['realname']); ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td class="ucpflc" width="30%">
                                <b><?php echo $l['custom_title']; ?> :</b>
                            </td>
                            <td class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="text" size="45" name="title" value="<?php echo (isset($_POST['title']) ? $_POST['title'] : $member['customtitle']); ?>" maxlength="<?php echo $globals['customtitlelen']; ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td class="ucpflc" width="30%">
                                <b><?php echo $l['location']; ?> :</b><br />
                                <font class="ucpfexp"><?php echo $l['location_exp']; ?></font>
                            </td>
                            <td class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="text" size="45" name="location" value="<?php echo (isset($_POST['location']) ? $_POST['location'] : $member['location']); ?>" />
                            </td>
                        </tr>


                        <tr>
                            <td class="ucpflc" width="30%">
                                <b><?php echo$l['gender']; ?> :</b><br />
                                <font class="ucpfexp"><?php echo $l['gender_exp']; ?></font>
                            </td>
                            <td class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<select name="gender" size="1">
                                    <option value="1"  <?php echo ( (isset($_POST['gender']) && (int) $_POST['gender'] == 1) ? 'selected="selected"' : (($member['gender'] == 1) ? 'selected="selected"' : '') ); ?>><?php echo $l['male']; ?></option>
                                    <option value="2" <?php echo ( (isset($_POST['gender']) && (int) $_POST['gender'] == 2) ? 'selected="selected"' : (($member['gender'] == 2) ? 'selected="selected"' : '') ); ?>><?php echo $l['female']; ?></option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="ucpflc" width="30%">
                                <b><?php echo $l['private_text']; ?> :</b><br />
                                <font class="ucpfexp"><?php echo $l['private_text_exp']; ?></font>
                            </td>
                            <td class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="text" size="45" name="privatetext" value="<?php echo (isset($_POST['privatetext']) ? $_POST['privatetext'] : $member['users_text']); ?>" />
                            </td>
                        </tr>	

                        <tr>
                            <td class="ucpflc" width="30%">
                                <b><?php echo $l['icq']; ?> :</b>
                            </td>
                            <td class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="text" size="24" name="icq" value="<?php echo (isset($_POST['icq']) ? $_POST['icq'] : $member['icq']); ?>" />
                            </td>
                        </tr>	


                        <tr>
                            <td class="ucpflc" width="30%">
                                <b><?php echo $l['yim']; ?> :</b>
                            </td>
                            <td class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="text" size="24" name="yim" value="<?php echo (isset($_POST['yim']) ? $_POST['yim'] : $member['yim']); ?>" />
                            </td>
                        </tr>


                        <tr>
                            <td class="ucpflc" width="30%">
                                <b><?php echo $l['msn']; ?> :</b>
                            </td>
                            <td class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="text" size="24" name="msn" value="<?php echo (isset($_POST['msn']) ? $_POST['msn'] : $member['msn']); ?>" />
                            </td>
                        </tr>


                        <tr>
                            <td class="ucpflc" width="30%">
                                <b><?php echo $l['aim']; ?> :</b>
                            </td>
                            <td class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="text" size="24" name="aim" value="<?php echo (isset($_POST['aim']) ? $_POST['aim'] : $member['aim']); ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td class="ucpflc" width="30%">

                                <b><?php echo $l['www']; ?> :</b>
                            </td>
                            <td class="ucpflc">
                                &nbsp;&nbsp;&nbsp;<input type="text" size="45" name="www" value="<?php echo (isset($_POST['www']) ? $_POST['www'] : $member['www']); ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td class="ucpflc" valign="top"><b><?php echo $l['signature']; ?></b><br />
                                <font class="ucpfexp"><?php echo $l['signature_exp']; ?></font></td>
                            <td class="ucpfrc">
                                &nbsp;&nbsp;&nbsp;<textarea name="sig" rows="8" cols="55" /><?php echo (isset($_POST['sig']) ? $_POST['sig'] : $member['sig']); ?></textarea>
                            </td>
                        </tr>


                        <tr>
                            <td class="ucpflc" colspan="2" align="center">
                                <input type="submit" name="editprofile" value="<?php echo $l['submit_button']; ?>" />
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>

            <tr>
                <td><img src="<?php echo $theme['images'] . 'cbotsmall.png'; ?>" width="100%" height="10"></td>
            </tr>

        </table>


    </form>

    <?php
    //The defualt footers
    aeffooter();
}
?>