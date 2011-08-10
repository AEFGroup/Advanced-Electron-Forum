<?php

function mainregister_theme() {

    global $globals, $theme, $error, $l;

    //Global Headers
    aefheader($l['<title>']);

    error_handle($error, '90%');
    ?>

    <form accept-charset="<?php echo $globals['charset']; ?>" action=""  method="post" name="registerform">
        <table width="90%" cellpadding="2" cellspacing="1" class="cbor" align="center">

            <tr>
                <td class="patcbg" colspan="2" align="left">
                    <?php echo $l['register_heading']; ?>
                </td>
            </tr>

            <tr>
                <td class="ucpfcbg1" colspan="2" align="center">
                    <img src="<?php echo $theme['images']; ?>sigwrite.png" />
                </td>
            </tr>

            <tr>
                <td class="ucpflc" width="30%" align="left">
                    <b><?php echo $l['username']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['username_exp']; ?></font>
                </td>
                <td class="ucpfrc" align="left">
                    <input type="text" size="45" name="username" <?php echo ( (isset($_POST['username'])) ? 'value="' . $_POST['username'] . '"' : '' ); ?> />
                </td>
            </tr>

            <tr>
                <td class="ucpflc" align="left">
                    <b><?php echo $l['password']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['password_exp']; ?></font>
                </td>
                <td class="ucpfrc" align="left">
                    <input type="password" size="45" name="password" />
                </td>
            </tr>

            <tr>
                <td class="ucpflc" align="left">
                    <b><?php echo $l['confirm_password']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['confirm_password_exp']; ?></font>
                </td>
                <td class="ucpfrc" align="left">
                    <input type="password" size="45" name="conf_password" />
                </td>
            </tr>

            <tr>
                <td class="ucpflc" align="left">
                    <b><?php echo $l['email_address']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['email_address_exp']; ?></font>
                </td>
                <td class="ucpfrc" align="left">
                    <input type="text" size="45" name="email" <?php echo ((isset($_POST['email'])) ? 'value="' . trim($_POST['email']) . '"' : ''); ?> />
                </td>
            </tr>
            <?php
            if ($globals['sec_conf']) {
                echo '<tr>
                        <td class="ucpflc" align="left">
                            <b>' . $l['confirmation_code'] . '</b><br />
                            <font class="ucpfexp">' . $l['confirmation_code_exp'] . '</font>
                        </td>
                        <td class="ucpfrc" align="left">
                            <img src="' . $globals['index_url'] . 'act=sec_conf_image"><br /><br />
                            <input type="text" size="20" name="sec_conf" />
                        </td>
                    </tr>';
            }
            ?>
            <tr>
                <td class="ucpflc" align="left">
                    <b><?php echo $l['time_zone']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['time_zone_exp']; ?></font>
                </td>
                <td class="ucpfrc" align="left">
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
                </td>
            </tr>

            <tr>
                <td class="ucpflc" align="left" colspan="2">
                    <center><b><?php echo $l['registration_terms_header']; ?></b></center><br />
                    <?php echo $l['registration_terms']; ?>
                    <br /><br />
                </td>
            </tr>


            <tr>
                <td class="ucpflc" align="center" colspan="2">
                    <input type="checkbox" name="iagree" /> <b><?php echo $l['i_agree']; ?></b>
                </td>
            </tr>

            <tr>
                <td class="ucpflc" align="center" colspan="2">
                    <input type="submit" name="register" value="<?php echo $l['submit_button']; ?>"/>
                </td>
            </tr>

        </table>
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
        <table width="70%" cellpadding="2" cellspacing="1" class="cbor" align="center">

            <tr>
                <td class="patcbg" colspan="2" align="left">
                    <?php echo $l['activation_heading']; ?>
                </td>
            </tr>

            <tr>
                <td class="ucpfcbg1" colspan="2" align="center">
                    <img src="<?php echo $theme['images']; ?>sigwrite.png" />
                </td>
            </tr>

            <tr>
                <td class="ucpflc" align="left" width="40%">
                    <b><?php echo $l['user_id']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['user_id_exp']; ?></font>
                </td>
                <td class="ucpfrc" align="left"><input type="hidden" name="act" value="register" />
                    <input type="hidden" name="regact" value="validate" />
                    <input type="text" size="20" name="u" <?php echo ( (isset($_GET['u'])) ? 'value="' . $_GET['u'] . '"' : '' ); ?> />
                </td>
            </tr>

            <tr>
                <td class="ucpflc" align="left">
                    <b><?php echo $l['activation_code']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['activation_code_exp']; ?></font>
                </td>
                <td class="ucpfrc" align="left">
                    <input type="text" size="35" name="code" <?php echo ( (isset($_GET['code'])) ? 'value="' . $_GET['code'] . '"' : '' ); ?> />
                </td>
            </tr>

            <tr>
                <td class="ucpfrc" align="left" colspan="2">
                    <center><input type="submit" value="<?php echo $l['submit_button']; ?>" /></center>
                </td>
            </tr>

        </table>
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
        <table width="60%" cellpadding="2" cellspacing="1" class="cbor" align="center">

            <tr>
                <td class="patcbg" colspan="3" align="left">
                    <?php echo $l['age_heading']; ?>
                </td>
            </tr>

            <tr>
                <td class="ucpfcbg1" colspan="3" align="center">
                    <img src="<?php echo $theme['images']; ?>sigwrite.png" />
                </td>
            </tr>

            <tr>
                <td class="ucpflc" width="30%" align="left">
                    <b><?php echo $l['date_of_birth']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['date_of_birth_exp']; ?></font>
                </td>
                <td class="ucpfrc" align="left">
                    <table>
                        <tr>
                            <td>
                                <?php echo $l['month']; ?>:<br />
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
                            </td>
                            <td>
                                <?php echo $l['day']; ?>:<br />
                                <select name="day">
                                    <option value="" selected="selected">--</option>
                                    <option value="01">1</option>
                                    <option value="02">2</option>
                                    <option value="03">3</option>
                                    <option value="04">4</option>
                                    <option value="05">5</option>
                                    <option value="06">6</option>
                                    <option value="07">7</option>
                                    <option value="08">8</option>
                                    <option value="09">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                </select>
                            </td>
                            <td>
                                <?php echo $l['year']; ?>:<br />
                                <input type="text" size="10" name="year" />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td class="ucpfrc" align="left" colspan="2">
                    <center><input type="submit" name="reg_age" value="<?php echo $l['submit_button']; ?>" /></center>
                </td>
            </tr>

        </table>
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
        <table width="80%" cellpadding="2" cellspacing="1" class="cbor" align="center">

            <tr>
                <td class="patcbg" align="left">
                    <?php echo $l['coppa_heading']; ?>
                </td>
            </tr>

            <tr>
                <td class="ucpfcbg1" align="center">
                    <img src="<?php echo $theme['images']; ?>sigwrite.png" />
                </td>
            </tr>

            <tr>
                <td class="ucpflc" align="left">
                    <b><?php echo $l['coppa_policy_heading']; ?> :</b><br />
                    <?php echo $l['coppa_terms']; ?>
                </td>
            </tr>

            <tr>
                <td class="ucpflc" align="left">
                    <input type="checkbox" name="iagree" /><b><?php echo $l['i_agree']; ?></b>
                </td>
            </tr>

            <tr>
                <td class="ucpfrc" align="left" colspan="2">
                    <center><input type="submit" name="agreed_coppa" value="<?php echo $l['submit_button']; ?>" /></center>
                </td>
            </tr>

        </table>
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
        <table width="70%" cellpadding="2" cellspacing="1" class="cbor" align="center">

            <tr>
                <td class="patcbg" align="left" colspan="2">
                    <?php echo $l['resend_heading']; ?>
                </td>
            </tr>

            <tr>
                <td class="ucpfcbg1" align="center" colspan="2">
                    <img src="<?php echo $theme['images']; ?>sigwrite.png" />
                </td>
            </tr>

            <tr>
                <td class="ucpflc" align="left" width="30%">
                    <b><?php echo $l['username']; ?></b><br />
                    <font class="ucpfexp"><?php echo $l['username_exp']; ?></font>
                </td>
                <td class="ucpfrc" align="left">
                    <input type="text" size="35" name="username" <?php echo ( (isset($_POST['username'])) ? 'value="' . $_POST['username'] . '"' : '' ); ?> />
                </td>
            </tr>

            <tr>
                <td class="ucpfrc" align="left" colspan="2">
                    <center><input type="submit" name="resendact" value="<?php echo $l['submit_button']; ?>" /></center>
                </td>
            </tr>

        </table>
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
