<?php
//////////////////////////////////////////////////////////////
//===========================================================
// adminlogin_theme.php(Admin)
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

function adminlogin_theme() {

    global $error, $globals, $theme, $user, $l;

    //The header
    aefheader($l['<title>']);

    error_handle($error, '100%');
    ?>

    <form action="" method="post" name="adminloginform" >
        <br />	
        <table width="60%" cellpadding="0" cellspacing="0" align="center">
            <tr>
                <td>
                    <table width="100%" cellpadding="0" cellspacing="0"><tr>
                            <td class="pcbgl"></td>
                            <td class="pcbg" align="left"><?php echo $l['security_login']; ?></td>
                            <td class="pcbgr"></td>		
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>

                    <table width="100%" cellpadding="5" cellspacing="1" class="cbgbor">

                        <tr>
                            <td class="ucpfcbg1" colspan="2" align="center">
                                <img src="<?php echo $theme['images']; ?>admin/login.png" />
                            </td>
                        </tr>

                        <tr>
                            <td width="30%" class="etrc">
                                <b><?php echo $l['username']; ?> :</b>
                            </td>
                            <td class="etrc" align="left">
                                <input type="text" size="40" name="aduser" value="<?php echo $user['username']; ?>" disabled="disabled" />
                            </td>
                        </tr>

                        <tr>
                            <td width="30%" class="etrc">
                                <b><?php echo $l['password']; ?> :</b>
                            </td>
                            <td class="etrc" align="left">
                                <input type="password" size="40" name="adpass" />
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2" class="etrc" style="text-align:center">
                                <input type="submit" name="adminlogin" value="<?php echo $l['submit']; ?>" />
                            </td>
                        </tr>	

                    </table>

                </td>
            </tr>

            <tr>
                <td><img src="<?php echo $theme['images']; ?>cbotsmall.png" width="100%" height="10"></td>
            </tr>

        </table>

    </form>
    <script language="JavaScript" type="text/javascript">
        document.forms.adminloginform.adpass.focus();
    </script>

    <?php
    //The defualt footers
    aeffooter();
}
?>