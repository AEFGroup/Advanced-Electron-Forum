<?php

function monthview_theme(){

global $globals, $cal, $dbtables, $user, $l, $theme;
global $days, $month, $year, $day, $birthdays, $today;	
						
	//Next and Previous Months
	$nextmonth = $month + 1;
	$nextyear = $year;
	$prevyear = $year;
			
	if($nextmonth == 13){	
		$nextmonth = '01';
		$nextyear = $year + 1;
	}elseif($nextmonth < 10){
		$nextmonth = '0'.$nextmonth;
	}
		
	$prevmonth = $month - 1;
	
	if($prevmonth == 00){	
		$prevmonth = 12;
		$prevyear = $year - 1;
	}elseif($prevmonth < 10){
		$prevmonth = '0'.$prevmonth;
	}
	
	//The headers
	aefheader($l['<title>']);		
	
	echo '<link rel="stylesheet" type="text/css" href="'.$theme['url'].'/calendar.css" />
	<br />
<table width="100%" cellpadding="0" cellspacing="0" border="0">

<tr>
<td>

<table width="100%" cellpadding="0" cellspacing="0">

<tr>
<td class="cbgl"></td>
<td class="cbg">'.$l['months'][$month].' - '.$year.'</td>
<td class="cbgr"></td>
</tr>

</table>

</td>
</tr>
		
<tr>
<td>


<table width="100%" cellpadding="1" cellspacing="0" align="center" class="cbgbor">
	
	<tr>';

	//The calendar days
	for($x = 0; $x < 7; $x++){
	
		echo '<td class="cbg1" align="center" width="14%">'.$l['days'][$x].'</td>';
		
	}
		
	echo '</tr>		
	<tr>';	
	
	$offset = datify(mktime( 0, 0, 0, $month, 1, $year), false, false, 'w');
	
	//$week = datify(mktime( 0, 0, 0, $month, 1, $year), false, false, 'W');
	
	//Empty Days in Previous Month
	for($t=0; $t < $offset; $t++){		
		
		echo '<td class="daybox">&nbsp;</td>';
		
	}
	
	//Loop through the days
	for($d = 1; $d <= $days; $d++){
		
		//Start a New row for a new week
		if($offset == 0){
		
			echo '<tr>';
		
		}
		
		$thisday = datify(mktime(0, 0, 0, $month, $d, $year), false, false, 'Ymd');
		
		echo '<td valign="top" class="'.($thisday == $today ? 'todaybox' : 'daybox').'">
			<div class="'.($thisday == $today ? 'topdayon' : 'topday').'">'.$d.'</div>';
			
		//Any Happy Birthdays on this day!!!
		if(!empty($birthdays[$d])) {
		
			echo '<div class="bdays">'.$l['birthdays'].' : ';

			foreach ($birthdays[$d] as $b => $bd) {
								
				echo '<a href="'.$globals['index_url'].'mid='.$bd['id'].'">'.$bd['username'].'('.$bd['age'].')</a><br />';
			
			}
			
			echo '</div>';
		
		//If there is nothing
		}else{
		
			echo '<br /><br />';
			
		}
		
		$offset++;

		//Is it the end of the week ?
		if($offset > 6){
		
			$offset = 0;
			
			if($days != $d){
			
				echo '</tr>';
				
			}
					
		}
		
	}//End of the loop
	
	if($offset > 0){
	
		$offset = 7 - $offset;
		
	}
	
	
	//The next month Rows
	for($t = 0; $t < $offset; $t++){
	
		echo '<td class="daybox">&nbsp;</td>';
		
	}
		
	echo '</tr>
	<tr>
	<td class="nextprev" align="left" colspan="3">
		&nbsp;&nbsp;&laquo; <a href="'.$globals['index_url'].'act=calendar&date='.$prevyear.$prevmonth.'01">'.$l['months'][$prevmonth].' '.$prevyear.'</a>
	</td>
	<td class="nextprev" align="center">
		<a href="'.$globals['index_url'].'act=calendar&date='.$year.$month.'01">'.$l['months'][$month].' '.$year.'</a>
	</td>
	<td class="nextprev" align="right" colspan="3">
		<a href="'.$globals['index_url'].'act=calendar&date='.$nextyear.$nextmonth.'01">'.$l['months'][$nextmonth].' '.$nextyear.' &raquo;</a>&nbsp;&nbsp;
	</td>
	</tr>
	
	<tr>
	<td class="currentmonth" colspan="7" align="center">
		<a href="'.$globals['index_url'].'act=calendar">'.$l['current_month'].'</a>
	</td>
	</tr>
	</table>

</td>
</tr>

<tr>
<td><img src="'.$theme['images'].'/cbot.png" height="15" width="100%"></td>
</tr>

</table>';	
		
	//The defualt footers
	aeffooter();

}

?>