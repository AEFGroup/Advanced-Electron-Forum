<?php

function notloggedin() {//If error occurs
    global $url; //comes from universal.php
    style();
    ?>
    <meta http-equiv="Refresh" content="10;url=<?php echo $url; ?>">
    <table width='100%' height='85%' align='center'>
        <tr>
            <td valign='middle'>
                <table align='center' cellpadding="4" class="fields">
                    <tr>
                        <td width="100%" align="center" >

                            <table width="400" bgcolor="#C4DCFB">
                                <tr>
                                    <td align="center">
                                        <span style="font-size:18px;font-family:Arial, Helvetica, sans-serif;">Error</span>
                                    </td>
                                </tr>
                            </table><br />
                            <span style="font-size:13px;font-family:Arial, Helvetica, sans-serif;">
                            You are not logged in.<br />
                            Please wait while we redirect you. OR <br />
                            <a href="<?php echo $url; ?>">Click Here if you do not wish to wait.</a></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php
}

function loggedout() {//If error occurs while inserting in MySQL.
    global $url; //comes from universal.php
    style();
    ?>
    <meta http-equiv="Refresh" content="7;url=<?php echo $url; ?>">
    <table width='100%' height='85%' align='center'>
        <tr>
            <td valign='middle'>
                <table align='center' cellpadding="4" class="fields">
                    <tr>
                        <td width="100%" align="center" >

                            <table width="400" bgcolor="#C4DCFB">
                                <tr>
                                    <td align="center">
                                        <span style="font-size:18px;font-family:Arial, Helvetica, sans-serif;">Logged Out</span>
                                    </td>
                                </tr>
                            </table><br />
                            <span style="font-size:13px;font-family:Arial, Helvetica, sans-serif;">
                            You have successfully been logged out.<br />
                            Please wait while we redirect you. OR <br />
                            <a href="<?php echo $url; ?>">Click Here if you do not wish to wait.</a></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php
}

function logouterror() {//If error occurs while deleting from MySQL.
    global $url; //comes from universal.php
    style();
    ?>
    <meta http-equiv="Refresh" content="7;url=<?php echo $url; ?>">
    <table width='100%' height='85%' align='center'>
        <tr>
            <td valign='middle'>
                <table align='center' cellpadding="4" class="fields">
                    <tr>
                        <td width="100%" align="center" >

                            <table width="400" bgcolor="#C4DCFB">
                                <tr>
                                    <td align="center">
                                        <span style="font-size:18px;font-family:Arial, Helvetica, sans-serif;">Error</span>
                                    </td>
                                </tr>
                            </table><br />
                            <span style="font-size:13px;font-family:Arial, Helvetica, sans-serif;">
                            There was an error logging you out.<br />
                            Please try to log out after some time. Inconvenience is regreted.<br />
                            Please wait while we redirect you. OR <br />
                            <a href="<?php echo $url; ?>">Click Here if you do not wish to wait.</a></span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <?php
}

function style() {//this function is only for regerror() and inastanact() and so that come after reg
    ?>
    <style type="text/css">
        table.fields {
            border: groove 2px;
            width: 420px
        }
        /*Non-IE Browsers*/
        html>body table.fields {
            border: groove 2px #EADDB5;
            width: 420px
        }
        a:link,
        a:visited,
        a:active{
            background-color: transparent;
            color: #2874D0;
            text-decoration: none;
        }
        a:hover{
            background-color: transparent;
            color: #0C57AB;
            text-decoration: underline;
        }
    </style>
    <?php
}
?>