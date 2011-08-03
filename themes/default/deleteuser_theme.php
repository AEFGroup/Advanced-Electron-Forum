<?php

function deleteuser_theme(){

global $user, $logged_in, $globals, $AEF_SESS, $theme, $member, $error;

	//The header
	aefheader('Delete a User');	
	
	error_handle($error, '60%', true);
	
	?>
<form accept-charset="<?php echo $globals['charset'];?>" method="post" action="" name="deleteuserform" >
<br />	
<table width="60%" cellpadding="0" cellspacing="0" align="center">
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0"><tr>
<td class="pcbgl"></td>
<td class="pcbg" align="left">Delete user</td>
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
<img src="<?php echo $theme['images'];?>deleteuser.png" />
</td>
</tr>
	
<tr>
<td width="40%" class="etrc">
<b>User :</b>
</td>
<td class="etrc" align="left">
&nbsp;<input type="text" size="40"  name="username" value="<?php echo $member['username'];?>" disabled="disabled" />
</td>
</tr>

<!--<tr>
<td class="etrc">
<b>Topics and Posts :</b><br />
Delete the topics and the replies made by this user.
</td>
<td class="etrc" align="left">
&nbsp;<input type="checkbox" name="deletetopicsposts" <?php echo (isset($_POST['deletetopicsposts']) ? 'checked="checked"' : '' );?> />
</td>
</tr>-->


<tr>
<td colspan="2" class="etrc" style="text-align:center">
<input type="submit" name="deleteuser" value="Delete User" />
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
	
	//The defualt footers
	aeffooter();


}


?>