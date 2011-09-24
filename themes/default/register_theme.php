<?php

function mainregister_theme() {

    global $globals, $theme, $error, $l;

    //Global Headers
    aefheader($l['<title>']);

    error_handle($error, '90%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="registerform">
        <div class="division" align="center">

            <div>
                <div class="topbar" align="left">
                    <h3><?php echo $l['register_heading']; ?></h3>
                </div>
            </div>

            <div>
                <div class="ucpfcbg1" colspan="2" align="center">
                    <img src="<?php echo $theme['images']; ?>sigwrite.png" />
                </div>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['username']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['username_exp']; ?></font>
                </div>
                <input type="text" size="45" name="username" <?php echo ( (isset($_POST['username'])) ? 'value="' . $_POST['username'] . '"' : '' ); ?> />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['password']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['password_exp']; ?></font>
                </div>
                <input type="password" size="45" name="password" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['confirm_password']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['confirm_password_exp']; ?></font>
                </div>
                <input type="password" size="45" name="conf_password" />
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['email_address']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['email_address_exp']; ?></font>
                </div>
                <input type="text" size="45" name="email" <?php echo ((isset($_POST['email'])) ? 'value="' . trim($_POST['email']) . '"' : ''); ?> />
            </div>
            <?php
            if ($globals['sec_conf']) {
                echo '<div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                            <b>' . $l['confirmation_code'] . '</b><br />
                            <font class="ucpfexp">' . $l['confirmation_code_exp'] . '</font>
                        </div>
                        <input type="text" size="20" name="sec_conf" /><br><br>
                            <img src="' . $globals['index_url'] . 'act=sec_conf_image">
                            
                    </div>';
            }
            ?>
            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <b><?php echo $l['time_zone']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['time_zone_exp']; ?></font>
                </div>
                <select name="timezone" style="font-size:11px">
                    <option value="-12" class="" >(GMT -12:00) Eniwetok, Kwajalein</option>
                    <option value="-11" class="" >(GMT -11:00) Midway Island, Samoa</option>
                    <option value="-10" class="" >(GMT -10:00) Hawaii</option>
                    <option value="-9" class="" >(GMT -9:00) Alaska</option>
                    <option value="-8" class="" >(GMT -8:00) Pacific Time (US &amp; Canada)</option>
                    <option value="-7" class="" >(GMT -7:00) Mountain Time (US &amp; Canada)</option>
                    <option value="-6" class="" >(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
                    <option value="-5" class="" >(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
                    <option value="-4" class="" >(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
                    <option value="-3.5" class="" >(GMT -3:30) Newfoundland</option>
                    <option value="-3" class="" >(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
                    <option value="-2" class="" >(GMT -2:00) Mid-Atlantic</option>
                    <option value="-1" class="" >(GMT -1:00 hour) Azores, Cape Verde Islands</option>
                    <option value="+0" class="">(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
                    <option value="1" class="" >(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
                    <option value="2" class="" >(GMT +2:00) Kaliningrad, South Africa</option>
                    <option value="3" class="" >(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
                    <option value="3.5" class="" >(GMT +3:30) Tehran</option>
                    <option value="4" class="" >(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
                    <option value="4.5" class="" >(GMT +4:30) Kabul</option>
                    <option value="5" class="" >(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
                    <option value="5.5" class="" >(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
                    <option value="6" class="" >(GMT +6:00) Almaty, Dhaka, Colombo</option>
                    <option value="7" class="" >(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
                    <option value="8" class="" >(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
                    <option value="9" class="" >(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
                    <option value="9.5" class="" >(GMT +9:30) Adelaide, Darwin</option>
                    <option value="10" class="" >(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
                    <option value="11" class="" >(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
                    <option value="12" class="" >(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
                    <option value="0" class="" selected="selected">Board Default</option>
                </select>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="float:left; padding:5px;">
                    <center><b><?php echo $l['registration_terms_header']; ?></b></center><br />
                    <?php echo $l['registration_terms']; ?>
                    <br /><br />
                </div>
            </div>


            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:400px; float:left; padding:5px;">
                    <input type="checkbox" name="iagree" /> <b><?php echo $l['i_agree']; ?></b>
                </div>
            </div>
            <input type="submit" name="register" value="<?php echo $l['submit_button']; ?>"/>
            <div style="clear:both;"></div>
        </div>
    </form>

    <?php
    //Global footers
    aeffooter();
}

//End of function

function validate_theme() {

    global $globals, $theme, $error, $l;

    //Global Headers
    aefheader($l['<title>']);

    error_handle($error);
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="get" name="account_actform">
        <div width="70%" cellpadding="2" cellspacing="1" class="cbor" align="center">

            <div>
                <div class="patcbg" colspan="2" align="left">
                    <?php echo $l['activation_heading']; ?>
                </div>
            </div>

            <div>
                <div class="ucpfcbg1" colspan="2" align="center">
                    <img src="<?php echo $theme['images']; ?>sigwrite.png" />
                </div>
            </div>

            <div>
                <div class="ucpflc" align="left" width="40%">
                    <b><?php echo $l['user_id']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['user_id_exp']; ?></font>
                </div>
                <div class="ucpfrc" align="left"><input type="hidden" name="act" value="register" />
                    <input type="hidden" name="regact" value="validate" />
                    <input type="text" size="20" name="u" <?php echo ( (isset($_GET['u'])) ? 'value="' . $_GET['u'] . '"' : '' ); ?> />
                </div>
            </div>

            <div>
                <div class="ucpflc" align="left">
                    <b><?php echo $l['activation_code']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['activation_code_exp']; ?></font>
                </div>
                <div class="ucpfrc" align="left">
                    <input type="text" size="35" name="code" <?php echo ( (isset($_GET['code'])) ? 'value="' . $_GET['code'] . '"' : '' ); ?> />
                </div>
            </div>

            <div>
                <div class="ucpfrc" align="left" colspan="2">
                    <center><input type="submit" value="<?php echo $l['submit_button']; ?>" /></center>
                </div>
            </div>

        </div>
    </form>

    <?php
    //Global footers
    aeffooter();
}

//End of function

function age_theme() {

    global $globals, $theme, $error, $l;

    //Global Headers
    aefheader($l['<title>']);

    error_handle($error);
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="reg_ageform">
        <div class="division">

            <div class="topbar">
                <h3><?php echo $l['age_heading']; ?></h3>
            </div>

            <div>
                <div class="ucpfcbg1" colspan="3" align="center">
                    <img src="<?php echo $theme['images']; ?>sigwrite.png" />
                </div>
            </div>

            <div style="clear:both; padding-bottom: 10px;"></div>
            <div >
                <div style="width:300px; float:left; padding:5px;">
                    <b><?php echo $l['date_of_birth']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['date_of_birth_exp']; ?></font>
                </div>
                <?php echo $l['month']; ?>:
                <select name="month">
                    <option value="" selected="selected">--</option>
                    <option value="01">January</option>
                    <option value="02">February</option>
                    <option value="03">March</option>
                    <option value="04">April</option>
                    <option value="05">May</option>
                    <option value="06">June</option>
                    <option value="07">July</option>
                    <option value="08">August</option>
                    <option value="09">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>

                <?php echo $l['day']; ?>:
                <select name="day">
                    <option value="" selected="selected">--</option>
                    <?php 
                    for($i=0;$i<32;$i++){
                        echo '<option value="0'.$i.'">'.$i.'</option>';
                    }?>
                </select>
                <?php echo $l['year']; ?>:
                <input type="text" size="10" name="year" />
            </div>
            <input type="submit" name="reg_age" value="<?php echo $l['submit_button']; ?>" />
            <div style="clear:both;"></div>
       </div>
    </form>

    <?php
    //Global footers
    aeffooter();
}

//End of function

function coppa_theme() {

    global $globals, $theme, $error, $l;

    //Global Headers
    aefheader($l['<title>']);

    error_handle($error);
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="coppaform">
        <div width="80%" cellpadding="2" cellspacing="1" class="cbor" align="center">

            <div>
                <div class="patcbg" align="left">
                    <?php echo $l['coppa_heading']; ?>
                </div>
            </div>

            <div>
                <div class="ucpfcbg1" align="center">
                    <img src="<?php echo $theme['images']; ?>sigwrite.png" />
                </div>
            </div>

            <div>
                <div class="ucpflc" align="left">
                    <b><?php echo $l['coppa_policy_heading']; ?> :</b><br />
                    <?php echo $l['coppa_terms']; ?>
                </div>
            </div>

            <div>
                <div class="ucpflc" align="left">
                    <input type="checkbox" name="iagree" /><b><?php echo $l['i_agree']; ?></b>
                </div>
            </div>

            <div>
                <div class="ucpfrc" align="left" colspan="2">
                    <center><input type="submit" name="agreed_coppa" value="<?php echo $l['submit_button']; ?>" /></center>
                </div>
            </div>

        </div>
    </form>

    <?php
    //Global footers
    aeffooter();
}

//End of function

function resendact_theme() {

    global $globals, $theme, $error, $l;

    //Global Headers
    aefheader($l['<title>']);

    error_handle($error);
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="resendactform">
        <div width="70%" cellpadding="2" cellspacing="1" class="cbor" align="center">

            <div>
                <div class="patcbg" align="left" colspan="2">
                    <?php echo $l['resend_heading']; ?>
                </div>
            </div>

            <div>
                <div class="ucpfcbg1" align="center" colspan="2">
                    <img src="<?php echo $theme['images']; ?>sigwrite.png" />
                </div>
            </div>

            <div>
                <div class="ucpflc" align="left" width="30%">
                    <b><?php echo $l['username']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['username_exp']; ?></font>
                </div>
                <div class="ucpfrc" align="left">
                    <input type="text" size="35" name="username" <?php echo ( (isset($_POST['username'])) ? 'value="' . $_POST['username'] . '"' : '' ); ?> />
                </div>
            </div>

            <div>
                <div class="ucpfrc" align="left" colspan="2">
                    <center><input type="submit" name="resendact" value="<?php echo $l['submit_button']; ?>" /></center>
                </div>
            </div>

        </div>
    </form>

    <?php
    //Global footers
    aeffooter();
}

//End of function

function coppaform_theme() {

    global $globals, $theme, $error, $l;

    echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=' . $globals['charset'] . '" />
    <title>' . $l['<title>'] . '</title>
    <link rel="stylesheet" type="text/css" href="' . $theme['url'] . '/style.css" />
    </head>
    <body>';

    echo '<p align="left"><font size="5">' . $globals['sn'] . '</font><br />
    ' . $l['address'] . ' : ' . $globals['age_rest_act_address'] . '.<br />
    ' . $l['telephone'] . ' : ' . $globals['age_rest_act_tele'] . '<br />
    ' . $l['fax'] . ' : ' . $globals['age_rest_act_fax'] . '<br /></p>';

    echo '<p align="right">' . $l['address'] . ' : ________________<br />
     ________________<br />
     ________________<br />
     ________________<br />
     ________________<br />
    ' . $l['date'] . ' : ________________<br /></p>';

    echo '<p align="left"><font size="4">' . $l['subject'] . '</font><br /><br />
    ' . $l['body'] . '</p>';

    echo '<center>' . copyright() . '</center>
<br />
</body>
</html>';
}

//End of function
?>
