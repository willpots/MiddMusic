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
function viewString($string) {
	$string = nl2br(stripslashes($string));
	return $string;
}
//! Randomizes characters for use in a code
function randomChars() {
	$characters = array("A","B","C","D","E","F","G","H","J",
						"K","L","M","N","P","Q","R","S","T",
						"U","V","W","X","Y","Z","1","2","3",
						"4","5","6","7","8","9","a","b","c",
						"d","e","f","g","h","i","j","k","l",
						"m","n","o","p","q","r","s","t","u",
						"v","w","x","y","z");
	$keys = array();
	$random_chars="";
	//first count of $keys is empty so "1", remaining count is 1-6 = total 7 times
	while(count($keys) < 7) {
	    //"0" because we use this to FIND ARRAY KEYS which has a 0 value
	    //"-1" because were only concerned of number of keys which is 32 not 33
	    //count($characters) = 33
	    $x = mt_rand(0, count($characters)-1);
	    if(!in_array($x, $keys)) {
	       $keys[] = $x;
	    }
	}
	foreach($keys as $key){
	   $random_chars .= $characters[$key];
	}
	$value = hash('sha256',$random_chars);
	return $value;
}

/*
function verifyInviteCode($code) {
	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM user WHERE invitecode='$code'";
	$result = mysql_query($query) or die("Query $query failed: " . mysql_error());
	if(mysql_num_rows($result)!=1) return FALSE;
	else return TRUE;
}
//! Creates an invite code
function createInviteCode() {
	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$chars = randomChars();
	$query = "INSERT INTO user (invitecode) VALUES ('$chars')";
	mysql_query($query) or die("Query $query failed: " . mysql_error());
	return $chars;	
}
*/
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
	$query = "SELECT * FROM venuestyles";
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
			$query = "SELECT id FROM popacts WHERE name LIKE '%$q%' ";
			$result = mysql_query($query);
			while($row = mysql_fetch_array($result)) {
				$popact=$row['id']; //Pull Instrument ID
				$result2 = mysql_query("SELECT * FROM userpopacts WHERE popactid = '$popact'"); //Pull all users who have that instrument id
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
		$query = "SELECT id, firstname, lastname FROM user WHERE firstname LIKE '%%".mysql_real_escape_string($q)."%%' OR lastname LIKE '%%".mysql_real_escape_string($q)."%%' LIMIT 10 ORDER BY lastname DESC";
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
function searchForBandWithType($id){
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
function pullAllEntities() {
	$results=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM user WHERE id != '".$_COOKIE['mu_id']."'";
	$result = mysql_query($query) or die('Query Error: ' . mysql_error()); 
	while($row = mysql_fetch_array($result)) {
		$a=array();
		$a['id']='u-'.$row['id'];
		$a['name']=$row['firstname'].' '.$row['lastname'];
		$results[]=$a;
	}
	$query = "SELECT * FROM bands ";
	$result = mysql_query($query) or die('Query Error: ' . mysql_error()); 
	while($row = mysql_fetch_array($result)) {
		$a=array();
		$a['id']='b-'.$row['id'];
		$a['name']=$row['name'];
		$results[]=$a;
	}
	$query = "SELECT * FROM venue ";
	$result = mysql_query($query) or die('Query Error: ' . mysql_error()); 
	while($row = mysql_fetch_array($result)) {
		$a=array();
		$a['id']='v-'.$row['id'];
		$a['name']=$row['name'];
		$results[]=$a;
	}
	$query = "SELECT * FROM instruments";
	$result = mysql_query($query) or die('Query Error: ' . mysql_error()); 
	while($row = mysql_fetch_array($result)) {
		$a=array();
		$a['id']='i-'.$row['id'];
		$a['name']=ucfirst($row['name']);
		$results[]=$a;
	}
	return $results;
}
function pullAllUsers() {
	$results=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM user ORDER BY lastname ASC";
	$result = mysql_query($query) or die('Query Error: ' . mysql_error()); 
	while($row = mysql_fetch_array($result)) {
		$a=array();
		$a['id']=$row['id'];
		$a['name']=$row['firstname'].' '.$row['lastname'];
		$results[]=$a;
	}
	return $results;
}
function pullAllBands() {
	$results=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM bands ";
	$result = mysql_query($query) or die('Query Error: ' . mysql_error()); 
	while($row = mysql_fetch_array($result)) {
		$a=array();
		$a['id']='b-'.$row['id'];
		$a['name']=$row['name'];
		$results[]=$a;
	}
	return $results;
}
function pullAllVenues() {
	$results=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM venue ";
	$result = mysql_query($query) or die('Query Error: ' . mysql_error()); 
	while($row = mysql_fetch_array($result)) {
		$a=array();
		$a['id']='v-'.$row['id'];
		$a['name']=$row['name'];
		$results[]=$a;
	}
	return $results;
}
function pullAllInstruments() {
	$results=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM instruments ORDER BY name ASC";
	$result = mysql_query($query) or die('Query Error: ' . mysql_error()); 
	while($row = mysql_fetch_array($result)) {
		$a=array();
		$a['id']='i-'.$row['id'];
		$a['name']=$row['name'];
		$results[]=$a;
	}
	return $results;
}
function pullAllPopActs() {
	$results=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM popacts ORDER BY name ASC";
	$result = mysql_query($query) or die('Query Error: ' . mysql_error()); 
	while($row = mysql_fetch_array($result)) {
		$a=array();
		$a['id']=$row['id'];
		$a['name']=$row['name'];
		$results[]=$a;
	}
	return $results;
}
function pullAllGenres() {
	$results=array();
 	global $dbHost, $dbUser, $dbPass, $dbSchema;
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM genres ORDER BY name ASC";
	$result = mysql_query($query) or die('Query Error: ' . mysql_error()); 
	while($row = mysql_fetch_array($result)) {
		$a=array();
		$a['id']='g-'.$row['id'];
		$a['name']=$row['name'];
		$results[]=$a;
	}
	return $results;
}

function masterSearch($query,$type=null,$instrument=null,$popact=null,$genre=null,$influence=null,$spacestyle=null) {
	$results = array();
	$q = explode(" ",$query);
}
/*
	Drawing Functions Below Here ---------------------
*/
?>