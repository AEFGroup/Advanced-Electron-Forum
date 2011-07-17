<?php

function emailpmset_theme(){

global $theme, $user, $globals, $l, $error;

	//The global User CP Headers
	usercphead($l['uset_email_pm_pref']);
	
	error_handle($error);

	?>

<form accept-charset="<?php echo $globals['charset'];?>" action="" method="post" name="emailpmset">

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0"><tr>
<td class="ucpcbgl"></td>
<td class="ucpcbg"><?php echo $l['uset_email_pm_pref'];?></td>
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
	<img src="<?php echo $theme['images'];?>usercp/emailpmsettings.gif" />
	</td>
	</tr>
	
	<tr>
	<td class="ucpcbg1" colspan="2" align="center"><b><?php echo $l['uset_email_set'];?></b><br />
	</td>
	</tr>
	
	<tr>
	<td class="ucpflc" width="60%"><b><?php echo $l['uset_recieve_email_admins'];?></b><br />
	<font class="ucpfexp"><?php echo $l['uset_recieve_email_admins_exp'];?></font>
	</td>
	<td class="ucpfrc" align="center">
	<input type="radio" name="adminemail" value="1" <?php echo (($user['adminemail'] == 1) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_yes'];?> &nbsp;&nbsp;
    <input type="radio" name="adminemail" value="2" <?php echo (($user['adminemail'] == 2) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_no'];?> &nbsp;&nbsp;
    <input type="radio" name="adminemail" value="0" <?php echo (($user['adminemail'] == 0) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_default'];?>
	</td>
	</tr>
	
	<tr>
	<td class="ucpflc"><b><?php echo $l['uset_hide_email_members'];?></b><br />
	<font class="ucpfexp"><?php echo $l['uset_hide_email_members_exp'];?></font>
	</td>
	<td class="ucpfrc" align="center">
    <input type="radio" name="hideemail" value="1" <?php echo (($user['hideemail'] == 1) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_yes'];?> &nbsp;&nbsp;
    <input type="radio" name="hideemail" value="2" <?php echo (($user['hideemail'] == 2) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_no'];?> &nbsp;&nbsp;
    <input type="radio" name="hideemail" value="0" <?php echo (($user['hideemail'] == 0) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_default'];?>
	</td>
	</tr>	
	
	<tr>
	<td class="ucpflc"><b><?php echo $l['uset_auto_subscription'];?></b><br />
	<font class="ucpfexp"><?php echo $l['uset_auto_subscription_exp'];?></font>
	</td>
	<td class="ucpfrc" align="center">
    <input type="radio" name="subscribeauto" value="1" <?php echo (($user['subscribeauto'] == 1) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_yes'];?> &nbsp;&nbsp;
    <input type="radio" name="subscribeauto" value="2" <?php echo (($user['subscribeauto'] == 2) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_no'];?> &nbsp;&nbsp;
    <input type="radio" name="subscribeauto" value="0" <?php echo (($user['subscribeauto'] == 0) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_default'];?>
	</td>
	</tr>	
	
	<tr>
	<td class="ucpflc"><b><?php echo $l['uset_send_new_reply'];?></b><br />
	<font class="ucpfexp"><?php echo $l['uset_send_new_reply_exp'];?></font>
	</td>
	<td class="ucpfrc" align="center">
    <input type="radio" name="sendnewreply" value="1" <?php echo (($user['sendnewreply'] == 1) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_yes'];?> &nbsp;&nbsp;
    <input type="radio" name="sendnewreply" value="2" <?php echo (($user['sendnewreply'] == 2) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_no'];?> &nbsp;&nbsp;
    <input type="radio" name="sendnewreply" value="0" <?php echo (($user['sendnewreply'] == 0) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_default'];?>
	</td>
	</tr>		
	
	<tr>
	<td class="ucpcbg1" colspan="2" align="center"><b><?php echo $l['uset_pm_set'];?></b><br />
	</td>
	</tr>	
	
	<tr>
	<td class="ucpflc"><b><?php echo $l['uset_notify_new_pm_email'];?></b><br />
	<font class="ucpfexp"><?php echo $l['uset_notify_new_pm_email_exp'];?></font>
	</td>
	<td class="ucpfrc" align="center">
    <input type="radio" name="pm_email_notify" value="1" <?php echo (($user['pm_email_notify'] == 1) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_yes'];?> &nbsp;&nbsp;
    <input type="radio" name="pm_email_notify" value="2" <?php echo (($user['pm_email_notify'] == 2) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_no'];?> &nbsp;&nbsp;
    <input type="radio" name="pm_email_notify" value="0" <?php echo (($user['pm_email_notify'] == 0) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_default'];?>
	</td>
	</tr>	
	
	<tr>
	<td class="ucpflc"><b><?php echo $l['uset_pop-up_notification_new_pm'];?></b><br />
	<font class="ucpfexp"><?php echo $l['uset_pop-up_notification_new_pm_exp'];?></font>
	</td>
	<td class="ucpfrc" align="center">
    <input type="radio" name="pm_notify" value="1" <?php echo (($user['pm_notify'] == 1) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_yes'];?> &nbsp;&nbsp;
    <input type="radio" name="pm_notify" value="2" <?php echo (($user['pm_notify'] == 2) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_no'];?> &nbsp;&nbsp;
    <input type="radio" name="pm_notify" value="0" <?php echo (($user['pm_notify'] == 0) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_default'];?>
	</td>
	</tr>
	
	<tr>
	<td class="ucpflc"><b><?php echo $l['uset_save_outgoing_pm'];?></b><br />
	<font class="ucpfexp"><?php echo $l['uset_save_outgoing_pm_exp'];?></font>
	</td>
	<td class="ucpfrc" align="center">
    <input type="radio" name="saveoutgoingpm" value="1" <?php echo (($user['saveoutgoingpm'] == 1) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_yes'];?> &nbsp;&nbsp;
    <input type="radio" name="saveoutgoingpm" value="2" <?php echo (($user['saveoutgoingpm'] == 2) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_no'];?> &nbsp;&nbsp;
    <input type="radio" name="saveoutgoingpm" value="0" <?php echo (($user['saveoutgoingpm'] == 0) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_default'];?>
	</td>
	</tr>
	
	<tr>
	<td class="ucpflc" colspan="2" align="center">
	<input type="submit" name="editemailpmset" value="<?php echo $l['uset_save_changes'];?>" />
	<input type="submit" name="defaultemailpmset" value="<?php echo $l['uset_use_default'];?>" />
	</td>
	</tr>
	
</table>

</td>
</tr>

<tr>
<td><img src="<?php echo $theme['images'];?>cbotsmall.png" width="100%" height="10"></td>
</tr>
</table>

</form>

	<?php
	
	//The global User CP Footers
	usercpfoot();


}


function forumset_theme(){

global $theme, $user, $globals, $l, $error, $themes, $lang_folders;

	//The global User CP Headers
	usercphead($l['uset_board_preferences']);
	
	error_handle($error);

	?>

<form accept-charset="<?php echo $globals['charset'];?>" action="" method="post" name="forumset">

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0"><tr>
<td class="ucpcbgl"></td>
<td class="ucpcbg"><?php echo $l['uset_board_preferences'];?></td>
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
	<img src="<?php echo $theme['images'];?>usercp/boardsettings.gif" />
	</td>
	</tr>	
	
	<tr>
	<td class="ucpflc" width="60%"><b><?php echo $l['uset_user_theme'];?></b><br />
	<font class="ucpfexp"><?php echo $l['uset_user_theme_exp'];?></font>
	</td>
	<td class="ucpfrc" align="center">
<script type="text/javascript">
function preview_theme(id){
	redirect_url = '<?php echo $globals['url'].'/index.php?'.getallGET(array('thid'));?>';
	thid = $(id).value;
	if(thid != 0){		
		window.location = redirect_url+'&thid='+thid;
	}
}
</script>
	<select name="user_theme" id="themeselector" >		
	<?php
	
	echo '<option value="0" '.((isset($_POST['user_theme']) && (int)trim($_POST['user_theme']) == 0) ? 'selected="selected"' : ($user['user_theme'] == 0 ? 'selected="selected"' : '' ) ).' >'.$l['uset_use_board_default'].'</option>';
	
	foreach($themes as $tk => $tv){
	
		echo '<option value="'.$themes[$tk]['thid'].'" '.((isset($_POST['user_theme']) && (int)trim($_POST['user_theme']) == $themes[$tk]['thid']) ? 'selected="selected"' : ($user['user_theme'] == $themes[$tk]['thid'] ? 'selected="selected"' : '' ) ).' >'.$themes[$tk]['th_name'].'</option>';
	
	}
	
	?>
	</select>&nbsp;&nbsp;&nbsp;
	<a href="javascript:preview_theme('themeselector')"><b><?php echo $l['uset_preview'];?></b></a>
	</td>
	</tr>	
	
    <tr>
	<td class="ucpflc"><b><?php echo $l['uset_language'];?></b><br />
	<font class="ucpfexp"><?php echo $l['uset_language_exp'];?></font>
	</td>
	<td class="ucpfrc">
	&nbsp;&nbsp;&nbsp;<select name="language" />
	<?php
    
    foreach($lang_folders as $k => $v){

        echo '<option value="'.$v.'" '.(empty($_POST['language']) && $user['language'] == $v ? 'selected="selected"' : (trim($_POST['language']) == $v ? 'selected="selected"' : '') ).'>'.aefucfirst($v).'</option>';
        
    }
    
    ?>
    </select>
	</td>
	</tr>
    
	<tr>
	<td class="ucpflc"><b><?php echo $l['uset_show_sigs'];?></b><br />
	<font class="ucpfexp"><?php echo $l['uset_show_sigs_exp'];?></font>
	</td>
	<td class="ucpfrc" align="center">
    <input type="radio" name="showsigs" value="1" <?php echo (($user['showsigs'] == 1) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_yes'];?> &nbsp;&nbsp;
    <input type="radio" name="showsigs" value="2" <?php echo (($user['showsigs'] == 2) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_no'];?> &nbsp;&nbsp;
    <input type="radio" name="showsigs" value="0" <?php echo (($user['showsigs'] == 0) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_default'];?>
	</td>
	</tr>
	
	<tr>
	<td class="ucpflc"><b><?php echo $l['uset_show_avatars'];?></b><br />
	<font class="ucpfexp"><?php echo $l['uset_show_avatars_exp'];?></font>
	</td>
	<td class="ucpfrc" align="center">
    <input type="radio" name="showavatars" value="1" <?php echo (($user['showavatars'] == 1) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_yes'];?> &nbsp;&nbsp;
    <input type="radio" name="showavatars" value="2" <?php echo (($user['showavatars'] == 2) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_no'];?> &nbsp;&nbsp;
    <input type="radio" name="showavatars" value="0" <?php echo (($user['showavatars'] == 0) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_default'];?>
	</td>
	</tr>	
	
	<tr>
	<td class="ucpflc"><b><?php echo $l['uset_show_smileys'];?></b><br />
	<font class="ucpfexp"><?php echo $l['uset_show_smileys_exp'];?></font>
	</td>
	<td class="ucpfrc" align="center">
    <input type="radio" name="showsmileys" value="1" <?php echo (($user['showsmileys'] == 1) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_yes'];?> &nbsp;&nbsp;
    <input type="radio" name="showsmileys" value="2" <?php echo (($user['showsmileys'] == 2) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_no'];?> &nbsp;&nbsp;
    <input type="radio" name="showsmileys" value="0" <?php echo (($user['showsmileys'] == 0) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_default'];?>
	</td>
	</tr>	
	
	<tr>
	<td class="ucpflc"><b><?php echo $l['uset_fast_reply'];?></b><br />
	<font class="ucpfexp"><?php echo $l['uset_fast_reply_exp'];?></font>
	</td>
	<td class="ucpfrc" align="center">
    <input type="radio" name="autofastreply" value="1" <?php echo (($user['autofastreply'] == 1) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_yes'];?> &nbsp;&nbsp;
    <input type="radio" name="autofastreply" value="2" <?php echo (($user['autofastreply'] == 2) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_no'];?> &nbsp;&nbsp;
    <input type="radio" name="autofastreply" value="0" <?php echo (($user['autofastreply'] == 0) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_default'];?>
	</td>
	</tr>		
	
	<tr>
	<td class="ucpflc"><b><?php echo $l['uset_show_images'];?></b><br />
	<font class="ucpfexp"><?php echo $l['uset_show_images_exp'];?></font>
	</td>
	<td class="ucpfrc" align="center">
    <input type="radio" name="showimgs" value="1" <?php echo (($user['showimgs'] == 1) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_yes'];?> &nbsp;&nbsp;
    <input type="radio" name="showimgs" value="2" <?php echo (($user['showimgs'] == 2) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_no'];?> &nbsp;&nbsp;
    <input type="radio" name="showimgs" value="0" <?php echo (($user['showimgs'] == 0) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_default'];?>
	</td>
	</tr>
	
	<tr>
	<td class="ucpflc"><b><?php echo $l['uset_anony_status'];?></b><br />
	<font class="ucpfexp"><?php echo $l['uset_anony_status_exp'];?></font>
	</td>
	<td class="ucpfrc" align="center">
    <input type="radio" name="i_am_anon" value="1" <?php echo (($user['i_am_anon'] == 1) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_yes'];?> &nbsp;&nbsp;
    <input type="radio" name="i_am_anon" value="2" <?php echo (($user['i_am_anon'] == 2) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_no'];?> &nbsp;&nbsp;
    <input type="radio" name="i_am_anon" value="0" <?php echo (($user['i_am_anon'] == 0) ? 'checked="checked"' : '');?> /> <?php echo $l['uset_default'];?>
	</td>
	</tr>
	
    <tr>
	<td class="ucpflc" colspan="2" align="center">
	<b><?php echo $l['uset_time_zone'];?></b> <select name="timezone" style="font-size:11px">
		<option value="-12" <?php echo (($user['timezone'] == -12) ? 'selected="selected"' : '');?> >(GMT -12:00) Eniwetok, Kwajalein</option>
		<option value="-11" <?php echo (($user['timezone'] == -11) ? 'selected="selected"' : '');?> >(GMT -11:00) Midway Island, Samoa</option>
		<option value="-10" <?php echo (($user['timezone'] == -10) ? 'selected="selected"' : '');?> >(GMT -10:00) Hawaii</option>
		<option value="-9" <?php echo (($user['timezone'] == -9) ? 'selected="selected"' : '');?> >(GMT -9:00) Alaska</option>
		<option value="-8" <?php echo (($user['timezone'] == -8) ? 'selected="selected"' : '');?> >(GMT -8:00) Pacific Time (US &amp; Canada)</option>
		<option value="-7" <?php echo (($user['timezone'] == -7) ? 'selected="selected"' : '');?> >(GMT -7:00) Mountain Time (US &amp; Canada)</option>
		<option value="-6" <?php echo (($user['timezone'] == -6) ? 'selected="selected"' : '');?> >(GMT -6:00) Central Time (US &amp; Canada), Mexico City</option>
		<option value="-5" <?php echo (($user['timezone'] == -5) ? 'selected="selected"' : '');?> >(GMT -5:00) Eastern Time (US &amp; Canada), Bogota, Lima</option>
		<option value="-4" <?php echo (($user['timezone'] == -4) ? 'selected="selected"' : '');?> >(GMT -4:00) Atlantic Time (Canada), Caracas, La Paz</option>
		<option value="-3.5" <?php echo (($user['timezone'] == -3.5) ? 'selected="selected"' : '');?> >(GMT -3:30) Newfoundland</option>
		<option value="-3" <?php echo (($user['timezone'] == -3) ? 'selected="selected"' : '');?> >(GMT -3:00) Brazil, Buenos Aires, Georgetown</option>
		<option value="-2" <?php echo (($user['timezone'] == -2) ? 'selected="selected"' : '');?> >(GMT -2:00) Mid-Atlantic</option>
		<option value="-1" <?php echo (($user['timezone'] == -1) ? 'selected="selected"' : '');?> >(GMT -1:00 hour) Azores, Cape Verde Islands</option>
		<option value="+0" <?php echo (($user['timezone'] == '+0') ? 'selected="selected"' : '');?> >(GMT) Western Europe Time, London, Lisbon, Casablanca</option>
		<option value="1" <?php echo (($user['timezone'] == 1) ? 'selected="selected"' : '');?> >(GMT +1:00 hour) Brussels, Copenhagen, Madrid, Paris</option>
		<option value="2" <?php echo (($user['timezone'] == 2) ? 'selected="selected"' : '');?> >(GMT +2:00) Kaliningrad, South Africa</option>
		<option value="3" <?php echo (($user['timezone'] == 3) ? 'selected="selected"' : '');?> >(GMT +3:00) Baghdad, Riyadh, Moscow, St. Petersburg</option>
		<option value="3.5" <?php echo (($user['timezone'] == 3.5) ? 'selected="selected"' : '');?> >(GMT +3:30) Tehran</option>
		<option value="4" <?php echo (($user['timezone'] == 4) ? 'selected="selected"' : '');?> >(GMT +4:00) Abu Dhabi, Muscat, Baku, Tbilisi</option>
		<option value="4.5" <?php echo (($user['timezone'] == 4.5) ? 'selected="selected"' : '');?> >(GMT +4:30) Kabul</option>
		<option value="5" <?php echo (($user['timezone'] == 5) ? 'selected="selected"' : '');?> >(GMT +5:00) Ekaterinburg, Islamabad, Karachi, Tashkent</option>
		<option value="5.5" <?php echo (($user['timezone'] == 5.5) ? 'selected="selected"' : '');?> >(GMT +5:30) Bombay, Calcutta, Madras, New Delhi</option>
		<option value="6" <?php echo (($user['timezone'] == 6) ? 'selected="selected"' : '');?> >(GMT +6:00) Almaty, Dhaka, Colombo</option>
		<option value="7" <?php echo (($user['timezone'] == 7) ? 'selected="selected"' : '');?> >(GMT +7:00) Bangkok, Hanoi, Jakarta</option>
		<option value="8" <?php echo (($user['timezone'] == 8) ? 'selected="selected"' : '');?> >(GMT +8:00) Beijing, Perth, Singapore, Hong Kong</option>
		<option value="9" <?php echo (($user['timezone'] == 9) ? 'selected="selected"' : '');?> >(GMT +9:00) Tokyo, Seoul, Osaka, Sapporo, Yakutsk</option>
		<option value="9.5" <?php echo (($user['timezone'] == 9.5) ? 'selected="selected"' : '');?> >(GMT +9:30) Adelaide, Darwin</option>
		<option value="10" <?php echo (($user['timezone'] == 10) ? 'selected="selected"' : '');?> >(GMT +10:00) Eastern Australia, Guam, Vladivostok</option>
		<option value="11" <?php echo (($user['timezone'] == 11) ? 'selected="selected"' : '');?> >(GMT +11:00) Magadan, Solomon Islands, New Caledonia</option>
		<option value="12" <?php echo (($user['timezone'] == 12) ? 'selected="selected"' : '');?> >(GMT +12:00) Auckland, Wellington, Fiji, Kamchatka</option>
        <option value="0" <?php echo (empty($user['timezone']) ? 'selected="selected"' : '');?> >Board Default</option>
	</select>
	</td>
	</tr>
    
	<tr>
	<td class="ucpflc" colspan="2" align="center">
	<input type="submit" name="editforumset" value="<?php echo $l['uset_save_changes'];?>" />
	<input type="submit" name="defaultforumset" value="<?php echo $l['uset_use_default'];?>" />
	</td>
	</tr>
	
</table>

</td>
</tr>

<tr>
<td><img src="<?php echo $theme['images'];?>cbotsmall.png" width="100%" height="10"></td>
</tr>
</table>
</form>

	<?php
	
	//The global User CP Footers
	usercpfoot();


}


function themeset_theme(){

global $globals, $l, $theme, $error, $themes, $theme_registry, $onload;
	
	//Admin Headers includes Global Headers
	usercphead($l['uset_user_theme_set']);
	
	error_handle($error);

if(!empty($theme_registry)){

?>

<form accept-charset="<?php echo $globals['charset'];?>" action="" method="post" name="themeset">
<script language="JavaScript" src="<?php echo $theme['url'].'/js/tabber.js';?>" type="text/javascript">
</script>
<script type="text/javascript">
tabs = new tabber;
tabs.tabs = new Array('<?php echo implode('\', \'', array_keys($theme_registry));?>');
tabs.tabwindows = new Array('<?php echo implode('_win\', \'', array_keys($theme_registry));?>_win');
addonload('tabs.init();');
</script>
    
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0"><tr>
<td class="ucpcbgl"></td>
<td class="ucpcbg"><?php echo $l['uset_theme_set'];?></td>
<td class="ucpcbgr"></td>		
</tr>
</table>
</td>
</tr>

<tr>
<td class="cbgbor">

    <table width="100%" cellpadding="2" cellspacing="1">
    
    <tr>
    <td class="ucpflc">
<?php

$categories = array_keys($theme_registry);

foreach($categories as $c){

	echo '<a href="javascript:tabs.tab(\''.$c.'\')" class="tab" id="'.$c.'"><b>'.aefucfirst($c).'</b></a>';

}

?>
</td>
</tr>

<tr>
<td style="padding:0px;">
<?php

foreach($theme_registry as $ck => $cv){

echo '<table width="100%" cellpadding="2" cellspacing="1" class="cbgbor" id="'.$ck.'_win">';

foreach($theme_registry[$ck] as $k => $v){
	
echo '<tr>
	<td width="40%" class="ucpflc">
	<b>'.$theme_registry[$ck][$k]['shortexp'].'</b>
	'.(empty($theme_registry[$ck][$k]['exp']) ? '' : '<br />
	<font class="adexp">'.$theme_registry[$ck][$k]['exp'].'</font>').'
	</td>
	<td class="ucpflc" align="left">        
	&nbsp;&nbsp;&nbsp;&nbsp;'.call_user_func_array('html_'.$theme_registry[$ck][$k]['type'], array($k, $theme_registry[$ck][$k]['value'])).'
	</td>
	</tr>';
		
	}
	
echo '</table>';

}

?>
    </td>
    </tr>

    <tr>
    <td align="center" class="ucpflc">
    <input type="submit" name="editthemeset" value="<?php echo $l['uset_edit_set'];?>" />
    <input type="submit" name="defaultthemeset" value="<?php echo $l['uset_use_default'];?>" />
    </td>
    </tr>	
	</table>    

</td>
</tr>

<tr>
<td><img src="<?php echo $theme['images'];?>cbotsmall.png" width="100%" height="10"></td>
</tr>
</table>
	
	</form>
	
	<?php
	
	}else{
	
		echo '<br /><br /><table width="100%" cellpadding="1" cellspacing="1" class="cbor">
		<tr>
		<td align="left" class="ucpflc">
		'.$l['uset_no_settings_theme'].'
		</td>
		</tr>	
	</table>';
	
	}
	
	usercpfoot();
	
}



function html_text($name, $default){

return '<input type="text" name="'.$name.'" value="'.(empty($_POST[$name]) ? $default : $_POST[$name]).'" size="40" />';

}

function html_checkbox($name, $default){

return '<input type="checkbox" name="'.$name.'" '.(empty($_POST[$name]) ? (empty($default) ? '' : 'checked="checked"') : 'checked="checked"').' />';

}

function html_textarea($name, $default){

return '<textarea name="'.$name.'">'.(empty($_POST[$name]) ? $default : $_POST[$name]).'</textarea>';

}

?>