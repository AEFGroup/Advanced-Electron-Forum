<?php

//////////////////////////////////////////////////////////////
//===========================================================
// recyclebin_theme.php(admin)
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

//A global part to appear
function recyclebin_global(){

global $globals, $theme, $l, $categories;

	?>
	
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
	
	<tr>
	<td align="right" width="40%" class="adcbg1">
	<img src="<?php echo $theme['images'];?>admin/recyclebin.png">
	</td>
	<td align="left" class="adcbg1">
	
	<font class="adgreen"><?php echo $l['recyclebin_set'];?></font><br />
	
	
	
	</td>
	</tr>
	
	<tr>
	<td align="left" colspan="2" class="adbg">
	<?php echo $l['recyclebin_set_exp'];?>
	</td>
	</tr>
	
	</table>
	<br /><br />
	<?php
	
}


//This is the theme that is for the management of the forums
function recyclebin_theme(){

global $globals, $theme, $categories, $l, $forums, $mother_options, $error;
	
	adminhead($l['cp_recyclebin']);
	
	recyclebin_global();
	
	error_handle($error, '100%');
	
	?>
	
	<form accept-charset="<?php echo $globals['charset'];?>" action="" method="post" name="editfpermissions">
	<table width="100%" cellpadding="1" cellspacing="1" class="cbor">
		
		<tr>
		<td class="adcbg" colspan="2" style="height:25px">
		<?php echo $l['recyclebin_set'];?>
		</td>
		</tr>
		
		<tr>
		<td class="adbg" width="40%" height="30">
		<b><?php echo $l['forum'];?></b><br />
		<?php echo $l['forum_exp'];?>
		</td>
		<td class="adbg">&nbsp;&nbsp;&nbsp;&nbsp;		
		<select name="rbfid" style="font-family:Verdana; font-size:11px">
		
		<?php 
		
		echo '<option value="0" '.((isset($_POST['rbfid']) && trim($_POST['rbfid']) == $mother_options[$i][0] ) ? 'selected="selected"' : '').'>
			'.$l['none'].'
			</option>';
			
		foreach($mother_options as $i => $iv){
		
			echo '<option value="'.$mother_options[$i][0].'" '.((isset($_POST['rbfid']) && trim($_POST['rbfid']) == $mother_options[$i][0] ) ? 'selected="selected"' : (($mother_options[$i][0] == (int) $globals['recyclebin']) ? 'selected="selected"' : '' ) ).'>
			'.$mother_options[$i][1].'
			</option>';
			
		}//End of for loop
		
		?>
		</select>
		</td>
		</tr>
		
		<tr>
		<td class="adbg" height="30" colspan="2" align="center">
		<input type="submit" name="setrecyclebin" value="<?php echo $l['submit'];?>" />		
		</td>
		</tr>
			
	</table>
	
	<?php

	adminfoot();

}//End of function


?>