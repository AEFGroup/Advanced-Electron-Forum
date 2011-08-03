<?php

//////////////////////////////////////////////////////////////
//===========================================================
// attachments_theme.php(Admin)
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

if(!defined('AEF')){

	die('Hacking Attempt');

}


function attset_theme(){

global $globals, $theme, $l, $error;
	
	//Admin Headers includes Global Headers
	adminhead($l['cp_attach']);
	
	?>
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
	
	<tr>
	<td align="right" width="40%" class="adcbg1">
	<img src="<?php echo $theme['images'];?>admin/attachments.png">
	</td>
	<td align="left" class="adcbg1">
	
	<font class="adgreen"><?php echo $l['attach_settings'];?></font><br />
	
	</td>
	</tr>
	
	<tr>
	<td align="left" colspan="2" class="adbg">
	<?php echo $l['place_changing'];?>
	</td>
	</tr>
	
	</table>
	<br /><br />
	<?php
	
	error_handle($error, '100%');
	
	?>
	
	<form accept-charset="<?php echo $globals['charset'];?>" action="" method="post" name="attsetform">
	<table width="100%" cellpadding="2" cellspacing="1" class="cbor">
	
		<tr>
		<td class="adcbg" colspan="2">
		<?php echo $l['attach_settings'];?>
		</td>
		</tr>
	
		<tr>
		<td width="45%" class="adbg">
		<b><?php echo $l['allow_downloads'];?></b><br />
		<font class="adexp"><?php echo $l['allow_downloads_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="attachmentmode" <?php echo ($globals['attachmentmode'] ? 'checked="checked"' : '');?> />
		</td>
		</tr>
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['allow_new_attach'];?></b><br />
		<font class="adexp"><?php echo $l['allow_new_attach_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="allownewattachment" <?php echo ($globals['allownewattachment'] ? 'checked="checked"' : '');?> />
		</td>
		</tr>
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['attach_directory'];?></b><br />
		<font class="adexp"><?php echo $l['attach_directory_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="40"  name="attachmentdir" value="<?php echo (empty($_POST['attachmentdir']) ? $globals['attachmentdir'] : $_POST['attachmentdir']);?>" />
		</td>
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['max_attach_per_post'];?></b><br />
		<font class="adexp"><?php echo $l['max_attach_per_post_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="maxattachmentpost" value="<?php echo (empty($_POST['maxattachmentpost']) ? $globals['maxattachmentpost'] : $_POST['maxattachmentpost']);?>" />
		</td>
		</tr>
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['max_size_per_attach'];?></b><br />
		<font class="adexp"><?php echo $l['max_size_ofan_attach'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="maxattachsize" value="<?php echo (empty($_POST['maxattachsize']) ? $globals['maxattachsize'] : $_POST['maxattachsize']);?>" />
		</td>
		</tr>
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['max_size_per_post'];?></b><br />
		<font class="adexp"><?php echo $l['max_size_ofall_post'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="maxattachsizepost" value="<?php echo (empty($_POST['maxattachsizepost']) ? $globals['maxattachsizepost'] : $_POST['maxattachsizepost']);?>" />
		</td>
		</tr>		
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['show_image_attach'];?></b><br />
		<font class="adexp"><?php echo $l['show_image_attach_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="attachmentshowimage" <?php echo ($globals['attachmentshowimage'] ? 'checked="checked"' : '');?> />
		</td>
		</tr>
		
		</tr>
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['attach_url'];?></b><br />
		<font class="adexp"><?php echo $l['url_display_image_attach'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="40"  name="attachmenturl" value="<?php echo (empty($_POST['attachmenturl']) ? $globals['attachmenturl'] : $_POST['attachmenturl']);?>" />
		</td>
		</tr>
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['max_image_width'];?></b><br />
		<font class="adexp"><?php echo $l['max_image_width_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="attachmentshowimagemaxwidth" value="<?php echo (empty($_POST['attachmentshowimagemaxwidth']) ? $globals['attachmentshowimagemaxwidth'] : $_POST['attachmentshowimagemaxwidth']);?>" />
		</td>
		</tr>
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['max_image_height'];?></b><br />
		<font class="adexp"><?php echo $l['max_image_height_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="attachmentshowimagemaxheight" value="<?php echo (empty($_POST['attachmentshowimagemaxheight']) ? $globals['attachmentshowimagemaxheight'] : $_POST['attachmentshowimagemaxheight']);?>" />
		</td>
		</tr>
		
		
	</table>
	
	<br /><br />
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
		<tr>
		<td align="center" class="adbg">
		<input type="submit" name="editattset" value="<?php echo $l['submit'];?>" />
		</td>
		</tr>	
	</table>
	
	</form>
	
	<?php
	
	adminfoot();
	
}

function attmime_theme(){

global $globals, $theme, $l, $mimetypes;
	
	//Admin Headers includes Global Headers
	adminhead($l['cp_attach_types']);
	
	?>
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
	
	<tr>
	<td align="right" width="40%" class="adcbg1">
	<img src="<?php echo $theme['images'];?>admin/attachments.png">
	</td>
	<td align="left" class="adcbg1">
	
	<font class="adgreen"><?php echo $l['attach_types'];?></font><br />
	
	</td>
	</tr>
	
	<tr>
	<td align="left" colspan="2" class="adbg">
	<?php echo $l['attach_types_exp'];?>
	</td>
	</tr>
	
	</table>
	<br /><br />
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
	<tr>
	<td class="adcbg" colspan="5">
	<?php echo $l['allowed_extensions_mimetypes'];?>
	</td>
	</tr>
	
	<tr align="center">
	<td class="adcbg2" height="18" width="10%">
	<b><?php echo $l['icon'];?></b>
	</td>
	<td class="adcbg2" width="25%">
	<b><?php echo $l['extension'];?></b>
	</td>
	<td class="adcbg2" width="35%">
	<b><?php echo $l['mimetype'];?></b>
	</td>
	<td class="adcbg2" width="15%">
	<b><?php echo $l['edit'];?></b>
	</td>
	<td class="adcbg2" width="15%">
	<b><?php echo $l['delete'];?></b>
	</td>
	</tr>
	
	<?php
	
	if(empty($mimetypes)){
	
	echo '<tr>
	<td class="adbg" colspan="5">
	'.$l['no_allowed_extensions_found'].'
	</td>
	</tr>';
	
	}else{
	
	foreach($mimetypes as $mk => $mv){
	
	echo '<tr>
	<td class="adbg" align="center">
	<img src="'.$globals['url'].'/mimetypes/'.$mimetypes[$mk]['atmt_icon'].'">
	</td>
	<td class="adbg">
	.'.$mimetypes[$mk]['atmt_ext'].'
	</td>
	<td class="adbg">
	'.$mimetypes[$mk]['atmt_mimetype'].'
	</td>
	<td class="adbg" align="center">
	<a href="'.$globals['index_url'].'act=admin&adact=attach&seadact=editmime&atmtid='.$mimetypes[$mk]['atmtid'].'">'.$l['edit'].'</a>
	</td>
	<td class="adbg" align="center">
	<a href="'.$globals['index_url'].'act=admin&adact=attach&seadact=delmime&atmtid='.$mimetypes[$mk]['atmtid'].'">'.$l['delete'].'</a>
	</td>
	</tr>';
	
	}		
	
	}
	
	?>
	
	</table>
	<br />
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
	<tr>
	<td align="center" class="adbg">
	<input type="button" value="<?php echo $l['add_new_type'];?>"  onclick="javascript:window.location='<?php echo $globals['index_url'].'act=admin&adact=attach&seadact=addmime';?>'" />
	</td>
	</tr>	
	</table>
	
	<?php	
	
	adminfoot();
	
}

//Edit Mimetypes
function editmime_theme(){

global $globals, $theme, $error, $l, $mimetype;
	
	//Admin Headers includes Global Headers
	adminhead($l['cp_edit_attach_types']);
	
	?>
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
	
	<tr>
	<td align="right" width="40%" class="adcbg1">
	<img src="<?php echo $theme['images'];?>admin/attachments.png">
	</td>
	<td align="left" class="adcbg1">
	
	<font class="adgreen"> <?php echo $l['edit_attach_types'];?></font><br />
	
	</td>
	</tr>
	
	<tr>
	<td align="left" colspan="2" class="adbg">
	<?php echo $l['edit_attach_types_exp'];?>
	</td>
	</tr>
	
	</table>
	<br /><br />
	<?php
	
	error_handle($error, '100%');
	
	?>
	
	<form accept-charset="<?php echo $globals['charset'];?>" action="" method="post" name="editmimeform">
	<table width="100%" cellpadding="2" cellspacing="1" class="cbor">
	
		<tr>
		<td class="adcbg" colspan="2">
		<?php echo $l['edit_attach_types'];?>
		</td>
		</tr>
	
		<tr>
		<td width="45%" class="adbg">
		<b><?php echo $l['extension_'];?></b><br />
		<font class="adexp"><?php echo $l['extension_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="atmt_ext" value="<?php echo (empty($_POST['atmt_ext']) ? $mimetype['atmt_ext'] : $_POST['atmt_ext']);?>" />
		</td>
		</tr>
		
		<tr>
		<td width="45%" class="adbg">
		<b><?php echo $l['mimetype_'];?></b><br />
		<font class="adexp"><?php echo $l['mimetype_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="atmt_mimetype" value="<?php echo (empty($_POST['atmt_mimetype']) ? $mimetype['atmt_mimetype'] : $_POST['atmt_mimetype']);?>" />
		</td>
		</tr>
		
		<tr>
		<td width="45%" class="adbg">
		<b><?php echo $l['file_type_icon'];?></b><br />
		<font class="adexp"><?php echo $l['file_type_icon_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="atmt_icon" value="<?php echo (empty($_POST['atmt_icon']) ? $mimetype['atmt_icon'] : $_POST['atmt_icon']);?>" />
		</td>
		</tr>
		
        <tr>
		<td class="adbg">
		<b><?php echo $l['allow_in_posts'];?></b><br />
		<font class="adexp"><?php echo $l['allow_in_posts_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="atmt_posts" <?php echo (empty($_POST['atmt_posts']) ? (empty($mimetype['atmt_posts']) ? '' : 'checked="checked"') : 'checked="checked"');?> />
		</td>
		</tr>
        
		<tr>
		<td class="adbg">
		<b><?php echo $l['allow_in_avatars'];?></b><br />
		<font class="adexp"><?php echo $l['allow_in_avatars_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="atmt_avatar" <?php echo (empty($_POST['atmt_avatar']) ? (empty($mimetype['atmt_avatar']) ? '' : 'checked="checked"') : 'checked="checked"');?> />
		</td>
		</tr>
        
		<tr>
		<td class="adbg">
		<b><?php echo $l['is_image'];?></b><br />
		<font class="adexp"><?php echo $l['is_image_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="atmt_isimage" <?php echo (empty($_POST['atmt_isimage']) ? (empty($mimetype['atmt_isimage']) ? '' : 'checked="checked"') : 'checked="checked"');?> />
		</td>
		</tr>
        
	</table>
	
	<br /><br />
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
		<tr>
		<td align="center" class="adbg">
		<input type="submit" name="editmime" value="<?php echo $l['submit'];?>" />
		</td>
		</tr>	
	</table>
	
	</form>
	
	<?php
	
	adminfoot();
	
}


//Edit Mimetypes
function addmime_theme(){

global $globals, $theme, $l, $error;
	
	//Admin Headers includes Global Headers
	adminhead($l['cp_add_attach_type']);
	
	?>
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
	
	<tr>
	<td align="right" width="40%" class="adcbg1">
	<img src="<?php echo $theme['images'];?>users.png">
	</td>
	<td align="left" class="adcbg1">
	
	<font class="adgreen"><?php echo $l['add_attach_type'];?></font><br />
	
	</td>
	</tr>
	
	<tr>
	<td align="left" colspan="2" class="adbg">
	<?php echo $l['add_attach_type_exp'];?>
	</td>
	</tr>
	
	</table>
	<br /><br />
	<?php
	
	error_handle($error, '100%');
	
	?>
	
	<form accept-charset="<?php echo $globals['charset'];?>" action="" method="post" name="addmimeform">
	<table width="100%" cellpadding="2" cellspacing="1" class="cbor">
	
		<tr>
		<td class="adcbg" colspan="2">
		<?php echo $l['add_attach_type'];?>
		</td>
		</tr>
	
		<tr>
		<td width="45%" class="adbg">
		<b><?php echo $l['extension_'];?></b><br />
		<font class="adexp"><?php echo $l['extension_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="atmt_ext" value="<?php echo (empty($_POST['atmt_ext']) ? '' : $_POST['atmt_ext']);?>" />
		</td>
		</tr>
		
		<tr>
		<td width="45%" class="adbg">
		<b><?php echo $l['mimetype_'];?></b><br />
		<font class="adexp"><?php echo $l['mimetype_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="atmt_mimetype" value="<?php echo (empty($_POST['atmt_mimetype']) ? '' : $_POST['atmt_mimetype']);?>" />
		</td>
		</tr>
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['file_type_icon'];?></b><br />
		<font class="adexp"><?php echo $l['file_type_icon_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="atmt_icon" value="<?php echo (empty($_POST['atmt_icon']) ? '' : $_POST['atmt_icon']);?>" />
		</td>
		</tr>
        
		<tr>
		<td class="adbg">
		<b><?php echo $l['allow_in_posts'];?></b><br />
		<font class="adexp"><?php echo $l['allow_in_posts_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="atmt_posts" <?php echo (empty($_POST['atmt_posts']) ? '' : 'checked="checked"');?> />
		</td>
		</tr>
        
		<tr>
		<td class="adbg">
		<b><?php echo $l['allow_in_avatars'];?></b><br />
		<font class="adexp"><?php echo $l['allow_in_avatars_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="atmt_avatar" <?php echo (empty($_POST['atmt_avatar']) ? '' : 'checked="checked"');?> />
		</td>
		</tr>
        
		<tr>
		<td class="adbg">
		<b><?php echo $l['is_image'];?></b><br />
		<font class="adexp"><?php echo $l['is_image_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="atmt_isimage" <?php echo (empty($_POST['atmt_isimage']) ? '' : 'checked="checked"');?> />
		</td>
		</tr>
	
	</table>
	
	<br /><br />
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
		<tr>
		<td align="center" class="adbg">
		<input type="submit" name="addmime" value="<?php echo $l['submit'];?>" />
		</td>
		</tr>	
	</table>
	
	</form>
	
	<?php
	
	adminfoot();
	
}


?>