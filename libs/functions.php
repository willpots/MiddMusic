<?php 
/********************************************************************************
 * If you are looking for something important, chances are that its here!		*
 * This file contains really epic, crazy shit.									*
 *																				*
 * Middlebury Music United														*
 * This code is proprietary and property of William S. Potter.					*
 * It has been licensed for use to Middlebury College in this installation.		*
 * Use of this code requires consent from William S. Potter						*
 * will@middpoint.com															*
 ********************************************************************************/
require_once('LocalSettings.php');
//Error reporting is on for development, this can be turned off at a later point in time.
error_reporting(E_ALL); 
/*
	Gen Use Functions Below Here ---------------------
*/
function cleanString($string) {
	$string = htmlspecialchars(addslashes(strip_tags($string)));
	return $string;
}

/*
	Instrument/Style Functions Below Here ---------------------
*/

function getAllInstruments() {
	$inst = array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM instruments";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
	while($row = mysql_fetch_array($result)) {
		$inst[]=$row;
	}
	if(!empty($inst))  return $inst;
	else return false; 

}
function getAllMusicStyles() {
	$inst = array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM bandstyles";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
	while($row = mysql_fetch_array($result)) {
		$inst[]=$row;
	}
	if(!empty($inst))  return $inst;
	else return false; 
}
function getVenueTypes(){
	$inst = array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM venuetypes";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
	while($row = mysql_fetch_array($result)) {
		$inst[]=$row;
	}
	if(!empty($inst))  return $inst;
	else return false; 
}
function getInstName($id){
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM instruments WHERE id='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
	while($row=mysql_fetch_array($result)) {
		$name=$row['name'];	
	}
	if($name) return $name;
	else return false; 
}
/*
	Search Functions Go Here -------------------------
*/
function pullSearchQuery($q, $page, $i=0) {
	$g = $i+20;
	$qs = explode(" ",$q);
	$results=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	if($q=="") {
		$query = "SELECT * FROM $page";
		$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
		while($i<$g&&$row=mysql_fetch_array($result)) {
			$results[]=$row;
			$i++;
		}
	} else if(!empty($qs)) {
		foreach($qs as $s) {
			if($page=="user") {
				$query = "SELECT * FROM $page WHERE firstname LIKE '%".$s."%' OR lastname LIKE '%".$s."%'";
			} else {
				$query = "SELECT * FROM $page WHERE name LIKE '%".$s."%'";	
			}
			$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
			while($row = mysql_fetch_array($result)) {
				if(!in_array($row,$results)) {
					$results[]=$row;
				}
			}
			$uids=array();
			$query = "SELECT id FROM instruments WHERE name LIKE '%$q%' ";
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result)) {
				$instid=$row['id']; //Pull Instrument ID
				$result2 = mysql_query("SELECT * FROM userinstruments WHERE instrumentid = '$instid'"); //Pull all users who have that instrument id
				while($row2 = mysql_fetch_array($result2)) {
					$uids[]=$row2['userid'];
				}
			}
			if(!empty($uids)) {
				foreach($uids as $uid) {
					$result3 = mysql_query("SELECT * FROM user WHERE id= '$uid'");
					while($row=mysql_fetch_array($result3)) {
						if(!in_array($row, $results)) {
							$results[]=$row;
						}
					}
				}
			}	
		}
	}
	if(!empty($results))  return $results;
	else return false; 
}
function pullAll($q,$table=null) {
	$results=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	if($table==null||$table=='user') {
		$query = "SELECT id, firstname, lastname FROM user WHERE firstname LIKE '%%".mysql_real_escape_string($q)."%%' OR lastname LIKE '%%".mysql_real_escape_string($q)."%%' LIMIT 10";
		$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
		while($obj = mysql_fetch_array($result)) {
			$a = array('id'=>'u-'.$obj['id'], 'name'=>$obj['firstname'].' '.$obj['lastname']);
		    $results[] = $a;
		}
	}
	if($table==null||$table=='venue') {
		$query = "SELECT id, name FROM venue WHERE name LIKE '%%".mysql_real_escape_string($q)."%%' LIMIT 10";
		$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
		while($obj = mysql_fetch_array($result)) {
			$a = array('id'=>'v-'.$obj['id'], 'name'=>$obj['name']);
		    $results[] = $a;
		}
	}
	if($table==null||$table=='bands') {
		$query = "SELECT id, name FROM bands WHERE name LIKE '%%".mysql_real_escape_string($q)."%%' LIMIT 10";
		$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
		while($obj = mysql_fetch_array($result)) {
			$a = array('id'=>'b-'.$obj['id'], 'name'=>$obj['name']);
		    $results[] = $a;
		}
	}
	if(!empty($results))  return $results;
	else return false; 
}
function searchForUsersWithInst($id) {
	$results=array();
	$uids=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM userinstruments WHERE instrumentid = '$id'";
	$result = mysql_query($query); 
	while($row = mysql_fetch_array($result)) {
		$uids[]=$row['userid'];
	}
	if(!empty($uids)) {
		foreach($uids as $uid) {
			$info = getUserInfo($uid);
			if($info!=false) $results[]=$info;
		}
	}	
	if(!empty($results))  return $results;
	else return false; 	
}
function searchForVenueWithType($id){
	$results=array();
	$uids=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM venue WHERE type='$id'";
	$result = mysql_query($query) or die('Query Error: ' . mysql_error()); 
	while($row = mysql_fetch_array($result)) {
		$results[]=$row;
	}
	if(!empty($results))  return $results;
	else return false; 	
}
function searchForActWithType($id){
	$results=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM bands WHERE type='$id'";
	$result = mysql_query($query) or die('Query Error: ' . mysql_error()); 
	while($row = mysql_fetch_array($result)) {
		$results[]=$row;
	}
	if(!empty($results))  return $results;
	else return false; 	
}
function searchForInst($q){
	$results=array();
	$s = explode(' ',$q);
	foreach($s as $w) {
	 	global $dbHost, $dbUser, $dbPass, $dbSchema;
		$con = mysql_connect($dbHost, $dbUser, $dbPass);
		if(!$con) die('Could not connect: ' . mysql_error());
		mysql_select_db($dbSchema, $con) or die('Could not select database');
		$query = "SELECT * FROM instruments WHERE name LIKE '%".$q."%'";
		$result = mysql_query($query) or die('Query Error: ' . mysql_error()); 
		while($row = mysql_fetch_array($result)) {
			if(!in_array($row,$results)){
				$results[]=$row;
			}
		}
	}
	if(!empty($results))  return $results;
	else return false; 	
}
function searchForBands($q){
	$results=array();
	$s = explode(' ',$q);
	foreach($s as $w) {
	 	global $dbHost, $dbUser, $dbPass, $dbSchema;
		$con = mysql_connect($dbHost, $dbUser, $dbPass);
		if(!$con) die('Could not connect: ' . mysql_error());
		mysql_select_db($dbSchema, $con) or die('Could not select database');
		$query = "SELECT * FROM bands WHERE name LIKE '%".$q."%'";
		$result = mysql_query($query) or die('Query Error: ' . mysql_error()); 
		while($row = mysql_fetch_array($result)) {
			if(!in_array($row,$results)){
				$results[]=$row;
			}
		}
	}
	if(!empty($results))  return $results;
	else return false; 	
}
/*
	Drawing Functions Below Here ---------------------
*/
function drawCalendar($month, $calendar) {
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
				echo '<div class="day wrongday" onclick="getCalendarDay('.$calstart.",'".$calendar.'\')" >';
			} else if($calstart != $today) {
				echo '<div class="day" onclick="getCalendarDay('.$calstart.",'".$calendar.'\')" >';
			} else {
				echo '<div class="day today" onclick="getCalendarDay('.$calstart.",'".$calendar.'\')" id="day-'.$calstart.'">';
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
}
function drawDayView($day,$calendar) {
	$today = $day;
	$eotoday = strtotime("+1 day", $today);
?>
	<div id="month-nav">
		<a class="month-nav unselectable" unselectable="on" onclick="getCalendarDay('<?php echo strtotime("-1 day", $today)."','".$calendar;?>')">&larr;</a>
		<a class="month-nav unselectable" unselectable="on" onclick="getCalendarDay('<?php echo strtotime("+1 day", $today)."','".$calendar;?>')">&rarr;</a>
	</div>
	<div class="section-title">CALENDAR</div>
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
	<p><label for="name">Event Name: <input type="text" name="name" id="name" placeholder="Event Name"></label></p>
	<p><label for="starttime">Start Time: <input type="text" name="starttime" id="starttime" placeholder="Start Time"></label></p>
	<p><label for="endtime">End Time: <input type="text" name="endtime" id="endtime" placeholder="End Time"></label></p>
	<p><label for="description">Description:<br>
		<textarea name="description" id="description" rows="10" cols="70" placeholder="What's happening?"></textarea></label></p>
	<p><label for="bands">Bands/Performers:
		<input type="text" id="bands" name="bands">
		</label>
	</p>
</div>
<?php
}
?>