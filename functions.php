<?php 
/****************************************************************************
 * Middlebury Music United 																									*
 * This code is proprietary and property of William S. Potter.							*
 * It has been licensed for use to Middlebury College in this installation.	*
 * Use of this code requires consent from William S. Potter									*
 * will@middpoint.com																												*
 ***************************************************************************/
require_once('LocalSettings.php');
 
function getInfo($id, $table) {
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM $table WHERE id='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
 	$row=mysql_fetch_array($result);
 	if(!empty($row)) return $row;
 	else return false;
}
function getUserMessages($id){
	$messages=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM messages WHERE msgto='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
 	while($row=mysql_fetch_array($result)) {
 		$messages[]=$row;
 	}
 	if(!empty($messages)) return $messages;
 	else return false;
} 
 
 
 
 
 
 
 ?>