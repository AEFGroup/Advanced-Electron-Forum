<?php

//////////////////////////////////////////////////////////////
//===========================================================
// smilies_theme.php(Admin)
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
// (c)Electron Inc.
//===========================================================
//////////////////////////////////////////////////////////////

if(!defined('AEF')){

	die('Hacking Attempt');

}

function smset_theme(){

global $globals, $l, $theme, $error;
	
	//Admin Headers includes Global Headers
	adminhead($l['cp_sm_smiley_set']);
	
	?>
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
	
	<tr>
	<td align="right" width="40%" class="adcbg1">
	<img src="<?php echo $theme['images'];?>admin/smileys.png">
	</td>
	<td align="left" class="adcbg1">
	
	<font class="adgreen"><?php echo $l['smiley_set'];?></font><br />
	
	</td>
	</tr>
	
	<tr>
	<td align="left" colspan="2" class="adbg">
	<?php echo $l['smiley_set_exp'];?>
	</td>
	</tr>
	
	</table>
	<br /><br />
	<?php
	
	error_handle($error, '100%');
	
	?>
	
	<form accept-charset="<?php echo $globals['charset'];?>" action="" method="post" name="smsetform">
	<table width="100%" cellpadding="2" cellspacing="1" class="cbor">
	
		<tr>
		<td class="adcbg" colspan="2">
		<?php echo $l['smiley_set'];?>
		</td>
		</tr>
	
		<tr>
		<td width="35%" class="adbg">
		<b><?php echo $l['use_smileys'];?></b><br />
		<font class="adexp"><?php echo $l['use_smileys_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="usesmileys" <?php echo ($globals['usesmileys'] ? 'checked="checked"' : '');?> />
		</td>
		</tr>
        
        <tr>
		<td width="35%" class="adbg">
		<b><?php echo $l['space_boundary'];?></b><br />
		<font class="adexp"><?php echo $l['space_boundary_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="smiley_space_boundary" <?php echo ($globals['smiley_space_boundary'] ? 'checked="checked"' : '');?> />
		</td>
		</tr>

	</table>
	
	<br /><br />
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
		<tr>
		<td align="center" class="adbg">
		<input type="submit" name="editsmset" value="<?php echo $l['submit'];?>" />
		</td>
		</tr>	
	</table>
	
	</form>
	
	<?php
	
	adminfoot();
	
}


function smman_theme(){

global $globals, $l, $theme, $smileys, $smileyimages;
	
	//Admin Headers includes Global Headers
	adminhead($l['cp_sm_manage_smileys']);
	
	?>
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
	
	<tr>
	<td align="right" width="40%" class="adcbg1">
	<img src="<?php echo $theme['images'];?>admin/smileys.png">
	</td>
	<td align="left" class="adcbg1">
	
	<font class="adgreen"><?php echo $l['manage_smileys'];?></font><br />
	
	</td>
	</tr>
	
	<tr>
	<td align="left" colspan="2" class="adbg">
	<?php echo $l['manage_smileys_exp'];?>
	</td>
	</tr>
	
	</table>
	<br /><br />
	
	<table width="100%" cellpadding="5" cellspacing="1" class="cbor">
	<tr>
	<td class="adcbg" colspan="7">
	<?php echo $l['current_smileys'];?>
	</td>
	</tr>
	
	<tr align="center">
	<td class="adcbg2" width="10%">
	<b><?php echo $l['smiley'];?></b>
	</td>
	<td class="adcbg2" width="15%">
	<b><?php echo $l['code'];?></b>
	</td>
	<td class="adcbg2" width="20%">
	<b><?php echo $l['file_name'];?></b>
	</td>
	<td class="adcbg2" width="20%">
	<b><?php echo $l['emotion'];?></b>
	</td>
	<td class="adcbg2" width="10%">
	<b><?php echo $l['status'];?></b>
	</td>
	<td class="adcbg2" width="10%">
	<b><?php echo $l['edit'];?></b>
	</td>
	<td class="adcbg2" width="15%">
	<b><?php echo $l['delete'];?></b>
	</td>
	</tr>
	
	<?php
	
	if(empty($smileys)){
	
	echo '<tr>
	<td class="adbg" colspan="5">
	'.$l['no_smileys_found'].'
	</td>
	</tr>';
	
	}else{
	
	foreach($smileys as $sk => $sv){
	
	echo '<tr>
	<td class="adbg" align="center">
	'.$smileyimages[$sk].'
	</td>
	<td class="adbg">
	'.$smileys[$sk]['smcode'].'
	</td>
	<td class="adbg">
	'.$smileys[$sk]['smfile'].'
	</td>
	<td class="adbg">
	'.$smileys[$sk]['smtitle'].'
	</td>
	<td class="adbg">
	'.($smileys[$sk]['smstatus'] ? $l['popup'] : $l['form']).'
	</td>
	<td class="adbg" align="center">
	<a href="'.$globals['index_url'].'act=admin&adact=smileys&seadact=editsm&smid='.$smileys[$sk]['smid'].'">'.$l['edit'].'</a>
	</td>
	<td class="adbg" align="center">
	<a href="'.$globals['index_url'].'act=admin&adact=smileys&seadact=delsm&smid='.$smileys[$sk]['smid'].'">'.$l['delete'].'</a>
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
	<input type="button" value="<?php echo $l['add_new_smiley'];?>"  onclick="javascript:window.location='<?php echo $globals['index_url'].'act=admin&adact=smileys&seadact=addsm';?>'" />
	</td>
	</tr>	
	</table>
	
	<?php	
	
	adminfoot();
	
}


function smreorder_theme(){

global $globals, $l, $theme, $smileys, $smileyimages, $error, $onload, $dmenus;
	
	//Pass to onload to initialize a JS
	$onload['smreoder'] = 'init_reoder()';
	
	//Admin Headers includes Global Headers
	adminhead($l['cp_sm_reorder_smileys']);
	
	?>
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
	
	<tr>
	<td align="right" width="40%" class="adcbg1">
	<img src="<?php echo $theme['images'];?>admin/smileys.png">
	</td>
	<td align="left" class="adcbg1">
	
	<font class="adgreen"><?php echo $l['reorder_smileys'];?></font><br />
	
	</td>
	</tr>
	
	<tr>
	<td align="left" colspan="2" class="adbg">
	<?php echo $l['reorder_smileys_exp'];?>
	</td>
	</tr>
	
	</table>
	<br /><br />
	<?php
	
	error_handle($error, '100%');
	
	?>
	
	<form accept-charset="<?php echo $globals['charset'];?>" action="" method="post" name="smreorderform">
	<table width="100%" cellpadding="2" cellspacing="1" class="cbor">
	
		<tr>
		<td class="adcbg" colspan="2">
		<?php echo $l['reorder_smileys'];?>
		</td>
		</tr>

	</table>
    <br /><br />
    
<table width="60%" cellpadding="0" cellspacing="0" align="center" border="0">
<tr><td id="sm_reorder_pos" width="100%"></td></tr>
</table>
	<br /><br />
	<script type="text/javascript">

//The array id of all the elements to be reordered
reo_r = new Array(<?php echo implode(', ', array_keys($smileys));?>);

//The id of the table that will hold the elements
reorder_holder = 'sm_reorder_pos';

//The prefix of the Dom Drag handle for every element
reo_ha = 'smha';

//The prefix of the Dom Drag holder for every element(the parent of every element)
reo_ho = 'sm';

//The prefix of the Hidden Input field for the reoder value for every element
reo_hid = 'smhid';

</script>
<?php js_reorder();?>
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
		<tr>
		<td align="center" class="adbg">
         <?php
	$temp = 1;
	foreach($smileys as $sk => $sv){
	
		//echo '<div class="smreo" id="sm'.$sk.'">&nbsp;'.$smileyimages[$sk].'&nbsp;&nbsp;'.$smileys[$sk]['smtitle'].'</div>';
		
		$dmenus[] = '<div id="sm'.$sk.'">
<table cellpadding="0" cellspacing="0" class="smreo" id="smha'.$sk.'" onmousedown="this.style.zIndex=\'1\'" onmouseup="this.style.zIndex=\'0\'">
<tr><td>
&nbsp;'.$smileyimages[$sk].'&nbsp;&nbsp;'.$smileys[$sk]['smtitle'].'
</td></tr>
</table>
</div>';	
	
	echo '<input type="hidden" name="sm['.$sk.']" value="'.$temp.'" id="smhid'.$sk.'" />';	
	
	$temp = $temp + 1;
	
	}
	
	?>
		<input type="submit" name="smreorder" value="<?php echo $l['re_order'];?>" />
		</td>
		</tr>	
	</table>
	
	</form>
	
	<?php	
	
	adminfoot();
	
} 
    

//Edit smiley
function editsm_theme(){

global $globals, $l, $theme, $error, $smiley, $folders;
	
	//Admin Headers includes Global Headers
	adminhead($l['cp_sm_edit_smileys']);
	
	?>
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
	
	<tr>
	<td align="right" width="40%" class="adcbg1">
	<img src="<?php echo $theme['images'];?>admin/smileys.png">
	</td>
	<td align="left" class="adcbg1">
	
	<font class="adgreen"><?php echo $l['edit_smileys'];?></font><br />
	
	</td>
	</tr>
	
	<tr>
	<td align="left" colspan="2" class="adbg">
	<?php echo $l['edit_smileys_exp'];?>
	</td>
	</tr>
	
	</table>
	<br /><br />
	<?php
	
	error_handle($error, '100%');
	
	?>
	
	<form accept-charset="<?php echo $globals['charset'];?>" action="" method="post" name="editsmform">
	<table width="100%" cellpadding="2" cellspacing="1" class="cbor">
	
		<tr>
		<td class="adcbg" colspan="2">
		<?php echo $l['edit_smileys'];?>
		</td>
		</tr>
	
		<tr>
		<td width="45%" class="adbg">
		<b><?php echo $l['code_'];?></b><br />
		<font class="adexp"><?php echo $l['code_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="smcode" value="<?php echo (empty($_POST['smcode']) ? $smiley['smcode'] : $_POST['smcode']);?>" />
		</td>
		</tr>
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['emotion_'];?></b><br />
		<font class="adexp"><?php echo $l['emotion_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="smtitle" value="<?php echo (empty($_POST['smtitle']) ? $smiley['smtitle'] : $_POST['smtitle']);?>" />
		</td>
		</tr>
		
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['display_in'];?></b><br />
		<font class="adexp"><?php echo $l['display_in_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="smstatus" <?php echo (!$smiley['smstatus'] ? 'checked="checked"' : '');?> />
		</td>
		</tr>
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['folder'];?></b><br />
		<font class="adexp"><?php echo $l['folder_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<select name="smfolder" disabled="disabled">
		<?php
		foreach($folders as $f){		
		echo '<option value="'.$f['name'].'" '.($f['name'] == $smiley['smfolder'] ? 'selected="selected"' : '' ).' >'.$f['name'].'</option>';
		}
		?></select>
		</td>
		</tr>
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['smiley_file'];?></b><br />
		<font class="adexp"><?php echo $l['smiley_file_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="smfile" value="<?php echo $smiley['smfile'];?>"  disabled="disabled" />
		</td>
		</tr>
		
	
	</table>
	
	<br /><br />
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
		<tr>
		<td align="center" class="adbg">
		<input type="submit" name="editsm" value="<?php echo $l['submit'];?>" />
		</td>
		</tr>	
	</table>
	
	</form>
	
	<?php
	
	adminfoot();
	
}


//Add smiley
function addsm_theme(){

global $globals, $l, $theme, $error, $smiley, $folders;
	
	//Admin Headers includes Global Headers
	adminhead($l['cp_sm_add_smileys']);
	
	?>
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
	
	<tr>
	<td align="right" width="40%" class="adcbg1">
	<img src="<?php echo $theme['images'];?>admin/smileys.png">
	</td>
	<td align="left" class="adcbg1">
	
	<font class="adgreen"><?php echo $l['add_smileys'];?></font><br />
	
	</td>
	</tr>
	
	<tr>
	<td align="left" colspan="2" class="adbg">
	<?php echo $l['add_smileys_exp'];?>
	</td>
	</tr>
	
	</table>
	<br /><br />
	<?php
	
	error_handle($error, '100%');
	
	?>
	
	<form accept-charset="<?php echo $globals['charset'];?>" action="" method="post" name="addsmform" enctype="multipart/form-data">
	<table width="100%" cellpadding="2" cellspacing="1" class="cbor">
	
		<tr>
		<td class="adcbg" colspan="2">
		<?php echo $l['add_smileys'];?>
		</td>
		</tr>
	
		<tr>
		<td width="45%" class="adbg">
		<b><?php echo $l['code_'];?></b><br />
		<font class="adexp"><?php echo $l['code_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="smcode" value="<?php echo (empty($_POST['smcode']) ? '' : $_POST['smcode']);?>" />
		</td>
		</tr>
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['emotion_'];?></b><br />
		<font class="adexp"><?php echo $l['emotion_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="smtitle" value="<?php echo (empty($_POST['smtitle']) ? '' : $_POST['smtitle']);?>" />
		</td>
		</tr>
		
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['display_in'];?></b><br />
		<font class="adexp"><?php echo $l['display_in_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="smstatus" checked="checked" />
		</td>
		</tr>
		
		<tr>
		<td class="adbg">
		<b><?php echo $l['folder'];?></b><br />
		<font class="adexp"><?php echo $l['folder_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<select name="smfolder">
		<?php
		foreach($folders as $f){		
		echo '<option value="'.$f['name'].'" '.(isset($_POST['smfolder']) && $_POST['smfolder'] == $f['name'] ? 'selected="selected"' : '' ).' >'.$f['name'].'</option>';
		}
		?></select>
		</td>
		</tr>
		
		<tr>
		<td class="adbg">
		<input type="radio" name="filemethod" value="1" <?php echo (isset($_POST['filemethod']) && trim($_POST['filemethod']) == 1 ? 'checked="checked"' : '' );?> />&nbsp;<b><?php echo $l['smiley_file'];?></b><br />
		<font class="adexp"><?php echo $l['smiley_file_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" size="30"  name="smfile" value="<?php echo (empty($_POST['smfile']) ? '' : $_POST['smfile']);?>" />
		</td>
		</tr>
				 
		<tr>
		<td class="adbg">
		<input type="radio" name="filemethod" value="2" <?php echo (isset($_POST['filemethod']) && trim($_POST['filemethod']) == 2 ? 'checked="checked"' : '' );?>  />&nbsp;<b><?php echo $l['upload_smiley'];?></b><br />
		<font class="adexp"><?php echo $l['upload_smiley_exp'];?></font>
		</td>
		<td class="adbg" align="left">
		&nbsp;&nbsp;&nbsp;&nbsp;<input type="file" size="30"  name="smfile_u" value="<?php echo (empty($_POST['smfile']) ? '' : $_POST['smfile']);?>" />
		</td>
		</tr>
		
	
	</table>
	
	<br /><br />
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
		<tr>
		<td align="center" class="adbg">
		<input type="submit" name="addsm" value="<?php echo $l['submit'];?>" />
		</td>
		</tr>	
	</table>
	
	</form>
	
	<?php
	
	adminfoot();
	
}

?>