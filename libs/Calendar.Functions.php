<?php
function drawCalendar($month, $calendar) {
	$today = mktime(0,0,0,date('m'),date('j'),date('Y'));
	$beginweek = $month;
	while( date('l', $beginweek) != "Monday" )
	{
		$beginweek = $beginweek - (60*60*24);
	}
	$calstart = $beginweek; ?>
	<div id="month-nav">
		<a class="month-nav blue-button unselectable" unselectable="on" onclick="getCalendarMonth('<?php echo strtotime("-1 week", $beginweek)."','".$calendar;?>')">&larr;</a>
		<a class="month-nav blue-button unselectable" unselectable="on" onclick="getCalendarMonth('<?php echo strtotime("+1 week", $beginweek)."','".$calendar;?>')">&rarr;</a>
	</div>
	<div class="section-title"><?php echo strtoupper($calendar) ?></div>
	<div class="month-name"><?php echo date('F, Y',$beginweek); ?></div>
	<div class="month">

	<?php 
	$daysleft = 7;
	echo '<div class="week">';
	while($daysleft > 0)
	{
		$endofday = mktime(0,0,0,date('m',$calstart),date('d',$calstart)+1,date('Y',$calstart));
		$events = getEventsBetween($calstart, $endofday, $calendar);
		if($calstart<$beginweek||$calstart >= strtotime("+1 month", $beginweek)) {
			echo '<div class="day wrongday" >';
			//echo '<div class="day wrongday" onclick="getCalendarDay('.$calstart.",'".$calendar.'\')" >';
		} else if($calstart != $today) {
			echo '<div class="day" >';
			//echo '<div class="day" onclick="getCalendarDay('.$calstart.",'".$calendar.'\')" >';
		} else {
			echo '<div class="day today" id="day-'.$calstart.'">';
			//echo '<div class="day today" onclick="getCalendarDay('.$calstart.",'".$calendar.'\')" id="day-'.$calstart.'">';
		}
		echo '<div class="dayno">'.date('j', $calstart).'</div>';
		echo '<span class="">'.date('l',$calstart).'</span>';
		echo '<div class="day-events">';
		if($events!=false) {
			foreach($events as $e) {
				echo '<a class="day-event" href="?page=profile&event='.$e['id'].'">'.date('g:i a', $e['starttime']).' - '.$e['name'].'</a>';
			}
		}
		$daysleft--;
		$calstart=$endofday;
		echo '</div></div>';
	}
	echo '</div>';
	?>
			<div class="clear"></div>
		</div>
	<?php
}
function drawDayView($day,$calendar) {
	$today = $day;
	$eotoday = strtotime("+1 day", $today);
?>
	<div id="month-nav">
		<a class="month-nav blue-button unselectable" unselectable="on" onclick="getCalendarDay('<?php echo strtotime("-1 day", $today)."','".$calendar;?>')">&larr;</a>
		<a class="month-nav blue-button unselectable" unselectable="on" onclick="getCalendarDay('<?php echo strtotime("+1 day", $today)."','".$calendar;?>')">&rarr;</a>
	</div>
	<div class="section-title"><?php echo strtoupper($calendar) ?></div>
	<div class="month-name"><?php echo date('F d, Y',$today); ?></div>
	<div class="day-view">
<?php	
	$events = getEventsBetween($today, $eotoday, $calendar);
	if($events!=false) {
		foreach($events as $e) {
			echo $e['name'];
		}
	} else {
		echo '<p>Nothing is planned for this day!</p>';
	}
				
?>
	</div>
	<a onclick="getEventCreate(<?php echo $today; ?>,'<?php echo $calendar; ?>')" class="button unselectable">Add An Event</a>

<?php
}
function drawEventCreate($day=null,$calendar=null) {

?>
<div class="section-title">CALENDAR</div>
<div class="month-name">Create Event</div>
<div class="event-form">
	<form id="event-create-form" name="eventCreateForm" onkeyup="validateEventForm()">
	<p><label for="name">Event Name: <input type="text" name="name" id="name" class="compose-field" placeholder="Event Name"></label></p>
	<p><label for="starttime">Start Time: <input type="text" name="starttime" class="compose-field" id="starttime" placeholder="Start Time"></label></p>
	<p><label for="endtime">End Time: <input type="text" name="endtime" class="compose-field" id="endtime" placeholder="End Time"></label></p>
	<p><label for="description">Description:<br>
		<textarea name="description" id="description" rows="10" cols="70" class="compose-field" placeholder="What's happening?"></textarea></label></p>
	<p><label for="bands">Bands/Performers:
		<select multiple id="bands" name="bands[]" class="chzn-select" style="width:300px;">
			<option></option>
			<?php
				$a=pullAllBands();
				foreach($a as $b) {
					echo '<option value="'.$b['id'].'">'.$b['name'].'</option>';
				}
			?>
		</select>
		</label>
	</p>
	<?php if($calendar=='calendar') { ?>
	<p><label for="venue">Venue:
		<select id="venue" name="venue" class="chzn-select" style="width:300px;">
			<option></option>
			<?php
				$a=pullAllVenues();
				foreach($a as $b) {
					echo '<option value="'.$b['id'].'">'.$b['name'].'</option>';
				}
			?>
		</select>
		</label>
	</p>
	<?php } ?>
	<input type="button" name="CREATEEVENT" class="button" id="sbutton" onclick="createAnEvent('<?php echo $calendar; ?>')" disabled value="Create Event">
	</form>
</div>
<?php
}
?>