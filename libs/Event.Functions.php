<?php

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


?>