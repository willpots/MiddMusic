<?php
require("functions.php");
error_reporting(E_ALL); 
$p=$_POST;
if(isset($p['getDateView'])) {
	header( "content-type: text/html; charset=UTF-8" ); 






} else if(isset($p['getMonthView'])) {
	header( "content-type: text/html; charset=UTF-8" ); 
	$month = $p['month'];
	$calendar = $p['calendar'];
	$today = mktime(0,0,0,date('m'),date('j'),date('Y'));
	$presentmonth = $month;
	while( date('l', $month) != "Sunday" )
	{
		$month = $month - (60*60*24);
	}
	$calstart = $month; ?>
	<div id="month-nav">
		<a class="month-nav unselectable" unselectable="on" onclick="getCalendarMonth('<?php echo strtotime("-1 month", $presentmonth)."','".$calendar;?>')">&larr;</a>
		<a class="month-nav unselectable" unselectable="on" onclick="getCalendarMonth('<?php echo strtotime("+1 month", $presentmonth)."','".$calendar;?>')">&rarr;</a>
	</div>
	<div class="section-title">CALENDAR</div>
	<div class="month-name"><?php echo date('F, Y',$presentmonth); ?></div>
	<div class="month">

	<?php 
	while($calstart <= strtotime("+1 month", $presentmonth))
	{
		$daysleft = 7;
		echo '<div class="week">';
		while($daysleft > 0)
		{
			$endofday = mktime(0,0,0,date('m',$calstart),date('d',$calstart)+1,date('Y',$calstart));
			$events = getEventsBetween($calstart, $endofday, $calendar);
			if($calstart<$presentmonth||$calstart >= strtotime("+1 month", $presentmonth)) {
				echo '<div class="day wrongday" >';
			} else if($calstart != $today) {
				echo '<div class="day" >';
			} else {
				echo '<div class="day today" id="day-'.$calstart.'">';
			}
			echo '<div class="dayno">'.date('j', $calstart).'</div>';
			if($events!=false) {
				foreach($events as $e) {
					echo $e['name'];
				}
			}
			$daysleft--;
			$calstart=$endofday;
			echo '</div>';
		}
		echo '</div>';
	}
	?>
			<div class="clear"></div>
		</div>
	<?php

} else if(1!=1) {





}
?>