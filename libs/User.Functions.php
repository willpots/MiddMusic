<?php
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
function getAssociatedEntities() {
	
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
function getUserVenues($id) {
	$venues=array();
	$results=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM uservenue WHERE userid='$id'";
	$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
	while($row=mysql_fetch_array($result)) {
		$venues[]=$row;
	}
	if(!empty($venues)) {
		foreach($venues as $a) {
			$aid=$a['venueid'];
			$query = "SELECT * FROM venue WHERE id='$aid'";
			$result = mysql_query($query) or die("Couldn't do query because of: ".mysql_error());
			$row=mysql_fetch_array($result);
			$results[]=$row;
		}
		return $results;
	} else {
		return false;
	}
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
?>