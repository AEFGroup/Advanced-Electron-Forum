<?php


function movetopic_theme(){

global $user, $conn, $dbtables, $logged_in, $globals, $l, $AEF_SESS, $theme, $error, $topic, $mother_options;

	//The header
	aefheader($l['<title>']);	
	
	error_handle($error, '90%', true);
	
	?>	
	
<form accept-charset="<?php echo $globals['charset'];?>" action=""  method="post" name="movetopicform">
<br />

<table width="90%" cellpadding="0" cellspacing="0" align="center">
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0"><tr>
<td class="pcbgl"></td>
<td class="pcbg" align="left"><?php echo $l['movetopics_heading'];?></td>
<td class="pcbgr"></td>		
</tr>
</table>
</td>
</tr>

<tr>
<td>

<table width="100%" cellpadding="2" cellspacing="1" class="cbgbor">
	
	<tr>
	<td class="ucpfcbg1" colspan="2" align="center">
	<img src="<?php echo $theme['images'];?>move.png" />
	</td>
	</tr>
	
	<tr>
	<td width="35%" class="mtlc"><?php echo $l['move_to'];?></td>
	<td class="mtrc"><select name="mtfid" style="font-family:Verdana; font-size:11px">
		
	<?php 
	
	foreach($mother_options as $i => $iv){
	
		echo '<option value="'.$mother_options[$i][0].'" '.((isset($_POST['mtfid']) && trim($_POST['mtfid']) == $mother_options[$i][0] ) ? 'selected="selected"' : '' ).'>
		'.$mother_options[$i][1].'
		</option>';
		
	}//End of for loop
	
	?>
	</select>
	</td>
	</tr>
	
	<tr>
	<td width="35%" class="mtlc"><?php echo $l['move_leave_link'];?></td>
	<td class="mtrc">
	<input type="checkbox" name="movedlink" checked="checked" />
	</td>
	</tr>
	
	<tr>
	<td width="35%" class="mtlc"><?php echo $l['move_link_text'];?></td>
	<td class="mtrc">
	<textarea name="movedtext" cols="50" rows="10"><?php echo $l['move_link_text_text'];?></textarea>
	</td>
	</tr>
	
	<tr>
	<td colspan="2" class="mtrc" style="text-align:center">
	<input type="submit" name="movetopic" value="<?php echo $l['move_submit_button'];?>"/></td>
	</tr>
	
</table>

</td>
</tr>

<tr>
<td><img src="<?php echo $theme['images'];?>cbot.png" width="100%" height="10"></td>
</tr>

</table>

</form>
<br /><br /><br />

	<?php
		
	//The defualt footers
	aeffooter();

}

?>