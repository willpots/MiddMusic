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
function getLogin($username, $password) {
	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$result=mysql_query("SELECT * FROM user WHERE username='$username' AND password='$password'", $con) or die("Query $query failed: " . mysql_error());
	if(mysql_num_rows($result)!=1) return false;
	else {
		$row=mysql_fetch_array($result);
		return $row;
	}
}
/*
	User Functions Below Here ---------------------
*/
function getUserInfo($id) {
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM user WHERE id='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
 	$row=mysql_fetch_array($result);
 	if(!empty($row)) return $row;
 	else return false;
}
function getUser($id, $attribute=NULL) {
	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM user WHERE id='$id'";
	$result = mysql_query($query) or die("Query failed: ".mysql_error());
	if(mysql_num_rows($result)==1) {
		$row=mysql_fetch_array($result);
		if($attribute==NULL) {
			return $row;
		} else {
			return $row[$attribute];
		}
	} else {
		return false;
	}
}
function getUserMessages($id){
	$messages=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM messages WHERE usermsgto='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
 	while($row=mysql_fetch_array($result)) {
 		$messages[]=$row;
 	}
 	//bands
	$bands=array();
	$query = "SELECT * FROM userbands WHERE userid='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
	while($row=mysql_fetch_array($result)) {
		$bands[]=$row;
	}
	if(!empty($bands)) {
		foreach($bands as $a) {
			$query = "SELECT * FROM messages WHERE actmsgto='$a'";
			$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
		 	while($row=mysql_fetch_array($result)) {
		 		$messages[]=$row;
		 	}
	 	}
	}
	//Venues
	$venues=array();
	$query = "SELECT * FROM uservenue WHERE userid='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
	while($row=mysql_fetch_array($result)) {
		$venues[]=$row;
	}
	if(!empty($venues)) {
		foreach($venues as $v) {
			$query = "SELECT * FROM messages WHERE actmsgto='$v'";
			$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
		 	while($row=mysql_fetch_array($result)) {
		 		$messages[]=$row;
		 	}
	 	}
	}
 	if(!empty($messages)) return $messages;
 	else return false;
} 
function getUserInstruments($id) {
	$results=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM userinstruments WHERE userid='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
	$instids=array();
	while($row=mysql_fetch_array($result)) {
		$instids[]=$row['instrumentid'];
	}
	if(!empty($instids)) {
		foreach($instids as $i) {
			$query = "SELECT * FROM instruments WHERE id='$i'";
			$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
			while($row=mysql_fetch_array($result)) {
				if(!in_array($row,$results)) {
					$results[]=$row;
				}
			}
		}
		return $results;
	} else return false;
}
function removeInstrument($userid,$instrumentid) {
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "DELETE FROM userinstruments WHERE userid='$userid' AND instrumentid='$instrumentid'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
}
function addInstrument($userid,$instrumentid) {
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "INSERT INTO userinstruments (userid, instrumentid) VALUES ('$userid','$instrumentid')";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
}

function getUserBands($id) {
	$bands=array();
	$results=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM userbands WHERE userid='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
	while($row=mysql_fetch_array($result)) {
		$bands[]=$row;
	}
	if(!empty($bands)) {
		foreach($bands as $a) {
			$aid=$a['bandid'];
			$query = "SELECT * FROM bands WHERE id='$aid'";
			$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
			$row=mysql_fetch_array($result);
			$results[]=$row;
		}
		return $results;
	} else {
		return false;
	}

}
function updateUser($id, $firstname, $lastname, $class, $info) {
	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "UPDATE user SET firstname='$firstname', lastname='$lastname', class='$class', info='$info' WHERE id='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());		
} 
function updatePic($id, $photo) {
	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM user WHERE id='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
	while($row=mysql_fetch_array($result)){ 
		exec('rm '.$row['picture']);
	}	

	$query = "UPDATE user SET picture='$photo' WHERE id='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());		
}
/*
	Act Functions Below Here ---------------------
*/
function getActMembers($id) {
	$members=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM userbands WHERE bandid='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
	while($row=mysql_fetch_array($result)) {
		$members[]=getUserInfo($row['userid']);
	}
	if(!empty($members)) return $members;
	else return false;
} 
function getActInfo($id) {
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM bands WHERE id='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
 	$row=mysql_fetch_array($result);
 	if(!empty($row)) return $row;
 	else return false;
}
function getActTypeName($id){
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM bandstyles WHERE id='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
 	$row=mysql_fetch_array($result);
 	if(!empty($row)) return $row['name'];
 	else return false;
}
/*
	Venue Functions Below Here ---------------------
*/
function getVenueInfo($id) {
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM venue WHERE id='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
 	$row=mysql_fetch_array($result);
 	if(!empty($row)) return $row;
 	else return false;
}
function getVenueTypeName($id){
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM venuetypes WHERE id='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
 	$row=mysql_fetch_array($result);
 	if(!empty($row)) return $row['name'];
 	else return false;
}
/*
	Event Functions Below Here ---------------------
*/
function getEventsBetween($starttime, $endtime, $calendar) {
	$events = array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM $calendar WHERE starttime BETWEEN '$starttime' AND '$endtime'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
	while($row = mysql_fetch_array($result)) {
		$events[]=$row;
	}
	if(!empty($events))  return $events;
	else return false; 
}
function getUpcomingEvents() {
	$start = time();
	$end = strtotime("+2 weeks" , $start);
	$events = array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM calendar WHERE starttime BETWEEN '$start' AND '$end'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
	while($row = mysql_fetch_array($result)) {
		$events[]=$row;
	}
	if(!empty($events))  return $events;
	else return false; 
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
	<p><label for="starttime">Event Name: <input type="text" name="starttime" id="starttime" placeholder="Event Name"></label></p>
</div>


<?php
}
?>