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
        <div class="division" style="width: 600px; margin: 0 auto 0 auto;">
            <div class="topbar">
                <h3><?php echo $l['security_login']; ?></h3>
            </div>
            <div class="cbgbor">
                <div class="ucpfcbg1" align="center">
                    <img src="<?php echo $theme['images']; ?>admin/login.png" />
                </div>
            </div>
            <div style="padding-left: 10px;">
                <b><?php echo $l['username']; ?> :</b>
            </div>
            <div style="padding-left: 10px;" align="left">
                <input type="text" size="40" name="aduser" value="<?php echo $user['username']; ?>" disabled="disabled" />
            </div>
            <div style="padding-left: 10px;">
                <b><?php echo $l['password']; ?> :</b>
            </div>
            <div style="padding-left: 10px;" align="left">
                <input type="password" size="40" name="adpass" />
            </div>
            <div style="padding-left: 10px;" style="text-align:center">
                <input type="submit" name="adminlogin" value="<?php echo $l['submit']; ?>" />
            </div>
            <img src="<?php echo $theme['images']; ?>cbotsmall.png" width="100%" height="10">
        </div>
    </form>
    <script language="JavaScript" type="text/javascript">
        document.forms.adminloginform.adpass.focus();
    </script>

    <?php
    //The defualt footers
    aeffooter();
}
?>