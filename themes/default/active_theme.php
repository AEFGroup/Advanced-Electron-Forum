<?php


function active_theme(){

global $user, $logged_in, $globals, $AEF_SESS, $l, $theme, $active, $count;

	//The header
	aefheader($l['<title>']);
	
	?>
	<script type="text/javascript">
	function gotopage(val){
		
		gourl = '<?php echo $globals['index_url'];?>act=active&acpg='
		
		//alert (gourl+val);
		
		window.location = gourl+val;
	
	}
	</SCRIPT>
	<?php
	echo '<div align="right"><select onchange="gotopage(this.value)" name="gotopage">';
	
	$num_pages = ceil($count/$globals['maxactivelist']);
	
	for($i = 1; $i <= $num_pages; $i++){
	
		echo '<option value="'.$i.'" '.((isset($_GET['acpg']) && trim($_GET['acpg']) == $i ) ? 'selected="selected"' : '' ).' >'.$i.'</option>';
	
	}
	
	echo '</select></div><br /><br />';
	
	//The first row that is Headers
	echo'<table width="100%" cellpadding="0" cellspacing="0">			
	<tr>
	<td>
	<table width="100%" cellpadding="0" cellspacing="0"><tr>
	<td class="tthl"></td>
	<td class="tthc" align="center">'.$l['active_users'].'</td>
	<td class="tthr"></td>		
	</tr>
	</table>
	</td>
	</tr>
	
	<tr>
	<td width="100%">
	
	<table width="100%" class="cbgbor" cellpadding="1" cellspacing="1">
	
	<tr>
	<td class="aclcbg" width="30%">'.$l['username_header'].'</td>
	<td class="aclcbg" width="15%" align="center">'.$l['time_header'].'</td>
	<td class="aclcbg" width="40%" align="center">'.$l['activity_header'].'</td>
	</tr>';
	
	foreach($active as $a => $av){
	
		echo '<tr>
		
		<td class="ttsub">
		'.(empty($active[$a]['username']) ? 'Guest' : (($active[$a]['uid'] < -100) ? $active[$a]['username'] : '<a href="'.$globals['index_url'].'mid='.$active[$a]['id'].'">'.$active[$a]['username'].'</a>' ) ).'	
		'.(empty($active[$a]['ip']) ? '' : '<br /><div style="float:right">( '.$active[$a]['ip'].' )</div>').'	
		</td>
		
		<td class="ttstar" align="center">
		'.$active[$a]['time'].'
		</td>
		
		<td class="ttrep" align="left">
		'.$active[$a]['activity'].'
		</td>
		</tr>';
		
		}
	
	echo '</table>
	</td>			
	</tr>
	<tr>
	<td><img src="'.$theme['images'].'cbot.png" width="100%" height="15"></td>
	</tr>
	
	</table>
	<br />';
	
	echo '<br /><br /><div align="right"><select onchange="gotopage(this.value)" name="gotopage">';
	
	$num_pages = ceil($count/$globals['maxactivelist']);
	
	for($i = 1; $i <= $num_pages; $i++){
	
		echo '<option value="'.$i.'" '.((isset($_GET['acpg']) && trim($_GET['acpg']) == $i ) ? 'selected="selected"' : '' ).' >'.$i.'</option>';
	
	}
	
	echo '</select></div>';
	
	//The defualt footers
	aeffooter();

}

?>