<?php 
/****************************************************************************
 * Middlebury Music United 																									*
 * This code is proprietary and property of William S. Potter.							*
 * It has been licensed for use to Middlebury College in this installation.	*
 * Use of this code requires consent from William S. Potter									*
 * will@middpoint.com																												*
 ***************************************************************************/
require_once('LocalSettings.php');
error_reporting(E_ALL); 
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
 	//Acts
	$acts=array();
	$query = "SELECT * FROM useracts WHERE userid='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
	while($row=mysql_fetch_array($result)) {
		$acts[]=$row;
	}
	if(!empty($acts)) {
		foreach($acts as $a) {
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
function getUserActs($id) {
	$acts=array();
	$results=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM useracts WHERE userid='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
	while($row=mysql_fetch_array($result)) {
		$acts[]=$row;
	}
	if(!empty($acts)) {
		foreach($acts as $a) {
			$aid=$a['actid'];
			$query = "SELECT * FROM acts WHERE id='$aid'";
			$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
			$row=mysql_fetch_array($result);
			$results[]=$row;
		}
		return $results;
	} else {
		return false;
	}

}
function getActMembers($id) {
	$members=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM useracts WHERE actid='$id'";
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
	$query = "SELECT * FROM acts WHERE id='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
 	$row=mysql_fetch_array($result);
 	if(!empty($row)) return $row;
 	else return false;
}
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
 
 
 ?>