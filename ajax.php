<?php
require("libs/libMMU.php");
$p=$_POST;
if(isset($p['getDateView'])) {
	header( "content-type: text/html; charset=UTF-8" ); 


} else if(isset($p['updatingband'])) {
	$id = $p['id'];
	$b = new Band($id);
	if(!empty($_FILES['profilepic']['name'])) {
		$tname=	$_FILES['profilepic']['tmp_name'];
		$name = $_FILES['profilepic']['name'];
		move_uploaded_file(	$tname, "photos/band_".$id."_".$name);
		$b->picture =  "photos/band_".$id."_".$name;
		echo "Uploaded Picture!";
	}
	$type=$p['type'][0];
	for($i=1;$i<count($p['type']);$i++) {
		$type .= ','.$p['type'][$i];
	}
	$b->name = $p['name'];
	$b->info = $p['info'];
	$b->type = $type;
	$b->users = $p['users'];
	$b->update();	
	echo "true";
	
} else if(isset($p['addpopact'])) {
	$value = cleanString($p['addpopact']);
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "INSERT INTO popacts (name) VALUES ('$value')";
	$result = mysql_query($query,$con) or die(mysql_error());
	$id = mysql_insert_id($con);
	$query = "INSERT INTO userpopacts (userid,popactid) VALUES ('".$_COOKIE['mu_id']."','".$id."')";
	$result = mysql_query($query,$con) or die(mysql_error());
	$u = new User($_COOKIE['mu_id']);
	$acts=pullAllPopActs();
	echo '<select name="popacts[]" multiple id="popacts" class="chzn-select" style="width:500px;">';
	foreach($acts as $a) {
		if(in_array($a['id'],$u->popacts)) {
			echo '<option value="'.$a['id'].'" selected>'.stripslashes($a['name']).'</option>';
		} else {
			echo '<option value="'.$a['id'].'">'.stripslashes($a['name']).'</option>';
		}
	}
	echo '</select>';

} else if(isset($p['deleteevent'])) {
	$id = $p['id'];
	$e = new Event($id);
	if($e->exists==true && in_array($_COOKIE['mu_id'],$e->users) ) {
		$e->delete();
		echo "Deleted Event!";
	} else {
		echo "Couldn't delete event!";
	}

} else if(isset($p['checkemail'])) {
	$username = $p['checkemail'];
	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "SELECT * FROM user WHERE username='$username'";
	$result = mysql_query($query,$con) or die(mysql_error());
	if(mysql_num_rows($result)>0) {
		echo "false";
	} else echo "true";

} else if(isset($p['sendmessage'])) {
	$msgs = $_POST['to'];
	$tostring=':';
	foreach($msgs as $msgto) {
		$tostring .= $msgto.':';
	}
	echo $tostring;
	$m = new Message();
	$m->subject = $_POST['subject'];
	$m->content = $_POST['content'];

	$m->msgto = $tostring;
	$m->msgfrom = ':'.$_POST['from'].':';
	$m->deliver();
	
} else if(isset($p['getMonthView'])) {
	// This is the thing that draws all of the calendars!
	header( "content-type: text/html; charset=UTF-8" ); 
	$month = $p['month'];
	$calendar = $p['calendar'];
	drawCalendar($month, $calendar); //Located in functions.php


} else if(isset($p['getDayView'])) {
	header( "content-type: text/html; charset=UTF-8" ); 
	$day = isset($p['day']) ? $p['day'] : null;
	$calendar = isset($p['calendar']) ? $p['calendar'] : null;
	drawDayView($day, $calendar); //Located in functions.php
	
} else if(isset($p['deleteMessage'])) {
	$id = $p['id'];
	$m = new Message($id);
	$m->delete();

} else if(isset($p['uploadPix'])) {


	$tname=	$_FILES['profilepic']['tmp_name'];
	$name = $_FILES['profilepic']['name'];
	
	updatePic($_COOKIE['mu_id'],"photos/".$_COOKIE['mu_id']."_".$name);
	move_uploaded_file(	$tname, "photos/".$_COOKIE['mu_id']."_".$name);
	echo "photos/".$name;

} else if(isset($p['createAnEvent'])) {
	$calendar = $p['calendar'];
	$name = cleanString($p['name']);
	$starttime = strtotime($p['starttime']);
	$endtime = strtotime($p['endtime']);
	$description = cleanString($p['description']);
	$bands = $p['bands'];

	$con = mysql_connect($dbHost, $dbUser, $dbPass);
	if(!$con) die('Could not connect: ' . mysql_error());
	mysql_select_db($dbSchema, $con) or die('Could not select database');
	$query = "INSERT INTO $calendar (name,starttime,endtime,description) VALUES ('$name','$starttime','$endtime','$description')";
	$result = mysql_query($query,$con) or die(mysql_error());
	$calendarid = mysql_insert_id();
	echo "Calendar ID: ".$calendarid."\n";
	foreach($bands as $b) {
		$bs = explode('-',$b);
		$bandid=$bs[1];
		echo "Band ID: ".$bandid."\n";
		$query = "INSERT INTO band$calendar (bandid,calendarid) VALUES ('$bandid','$calendarid')";
		$result = mysql_query($query,$con) or die(mysql_error());
	}
	$venue = explode('-',$p['venue']);
	$venueid = $venue[1];	
	echo "Venue ID: ".$venueid."\n";
	$query = "INSERT INTO venue$calendar (venueid,calendarid) VALUES ('$venueid','$calendarid')";
	$result = mysql_query($query,$con) or die(mysql_error());
	$query = "INSERT INTO user$calendar (userid,calendarid) VALUES ('".$_COOKIE['mu_id']."','$calendarid')";
	$result = mysql_query($query,$con) or die(mysql_error());

} else if(isset($p['updateEvent'])) {
	$id = $p['id'];
	$name = cleanString($p['name']);
	$starttime = strtotime($p['starttime']);
	$endtime = strtotime($p['endtime']);
	$description = cleanString($p['description']);
	$bands = $p['bands'];
	$venue = $p['venue'];
	//echo "Venue ID: ".$venue;
	$e = new Event($id);
	$e->name = $name;
	$e->starttime = $starttime;
	$e->endtime = $endtime;
	$e->description = $description;
	$bandids=array();
	foreach($bands as $b) {
		$bs = explode('-',$b);
		$bandids[]=$bs[1];
	}
	$e->bands=$bandids;
	$venue = explode('-',$p['venue']);
	$venueid = $venue[1];	
	$e->venueid=$venueid;
	//echo "Venue ID: ".$venueid;
	$e->update();
	echo "successfully!";
} else if(isset($p['getEventCreate'])) {
	header( "content-type: text/html; charset=UTF-8" ); 
	$day = isset($p['day']) ? $p['day'] : null;
	$calendar = isset($p['calendar']) ? $p['calendar'] : null;
	drawEventCreate($day, $calendar); //Located in functions.php
	
} else if(isset($p['getSearchQuery'])) {
	if(isset($p['query'])) $q = $p['query'];
	else $q = "";
	$page = $p['page'];
	
	echo '<div class="section-title">'.strtoupper($page).'</div>';
	echo '<div id="results">';
	if($page=="musicians") {
		$table = "user";
		if($query!="") { 
			$results = pullSearchQuery($q, $table);
		} else {
			//$results = pullSearchQuery($q, $table);
			$results = pullAllUsers();
		}

		if($results!=false) {
			foreach($results as $r) {
				//$r['name'] = $r['firstname'].' '.$r['lastname'];
				if(isset($row['name'])) {
					echo '<a href="?page=profile&id='.$r['id'].'" class="search-result">'.$r['name'].'</a>';
				} else {
					echo '<a href="?page=profile&id='.$r['id'].'" class="search-result">'.$r['firstname'].' '.$r['lastname'].'</a>';
				}
			}
		}
	} else if($page=="venues") {
		$table = "venue";
		$results = pullSearchQuery($q, $table);
		if($results!=false) {
			foreach($results as $r) {
				echo '<a href="?page=profile&venue='.$r['id'].'" class="search-result">'.$r['name'].'</a>';
			}
		}
	} else if($page=="bands") {
		$table = "bands";
		$results = pullSearchQuery($q, $table);
		if($results!=false) {
			foreach($results as $r) {
				echo '<a href="?page=profile&band='.$r['id'].'" class="search-result">'.$r['name'].'</a>';
			}
		}
	}
	echo '</div>';
} else if(isset($p['getCategorySearch'])) {
	$q = $p['cat'];
	$page = $p['page'];
	if($page=="musicians") {
		$cname = getInstName($q);
		echo '<div class="section-title">'.strtoupper($page).' - '.$cname.'</div>';
		echo '<div id="results">';
		$table = "user";
		$results = searchForUsersWithInst($q);
		if($results!=false) {
			foreach($results as $r) {
				echo '<a href="?page=profile&id='.$r['id'].'" class="search-result">'.$r['firstname'].' '.$r['lastname'].'</a>';
			}
		}
	} else if($page=="venues") {
		$cname = getVenueTypeName($q);
		echo '<div class="section-title">'.strtoupper($page).' - '.$cname.'</div>';
		echo '<div id="results">';
		$table = "venue";
		$results = searchForVenueWithType($q);
		if($results!=false) {
			foreach($results as $r) {
				echo '<a href="?page=profile&venue='.$r['id'].'" class="search-result">'.$r['name'].'</a>';
			}
		}
	} else if($page=="bands") {
		$cname = getBandTypeName($q);
		echo '<div class="section-title">'.strtoupper($page).' - '.$cname.'</div>';
		echo '<div id="results">';
		$table = "bands";
		$results = searchForBandWithType($q);
		if($results!=false) {
			foreach($results as $r) {
				echo '<a href="?page=profile&band='.$r['id'].'" class="search-result">'.$r['name'].'</a>';
			}
		}
	}
	echo '</div>';
} else if(isset($p['userupdate'])) {
	$id = $_COOKIE['mu_id'];
	$user = new User($id);
	$firstname=$_POST['firstname'];
	$lastname=$_POST['lastname'];
	$class=$_POST['class'];
	$popacts = $_POST['popacts'];
	$info=cleanString($_POST['info']);
	if(!empty($_FILES['profilepic']['name'])) {
		$tname=	$_FILES['profilepic']['tmp_name'];
		$name = $_FILES['profilepic']['name'];
		move_uploaded_file(	$tname, "photos/user_".$id."_".$name);
		$user->picture =  "photos/user_".$id."_".$name;
		echo "Uploaded Picture!";
	}
	if($p['email_ok']=="yes") {$email_ok=1;}
	else {$email_ok=0;}
	$user->set('email_ok',$email_ok);
	$user->firstname = $firstname;
	$user->lastname = $lastname;
	$user->class = $class;
	$user->info = $info;
	$user->popacts = $popacts;
	$user->update();
		

} else if(isset($p['instrumentSearch'])) {
	$q = $p['q'];
	if($q=="") {
		$results=false;
	} else {
		$results=searchForInst($q);
	}
	if($results==false) {
			echo '<a class="inst-result">Nothing found!</a>';
	} else {
		foreach($results as $r) {
			echo '<a class="inst-result" onclick="addInstrument(this)" id="'.$r['id'].'">'.ucwords(strtolower($r['name'])).'</a>';
		
		}
	}
} else if(isset($p['calBandSearch'])) {
	$q = $p['q'];
	if($q=="") {
		$results=false;
	} else {
		$results=searchForBands($q);
	}
	if($results==false) {
			echo '<a class="band-name">Nothing found!</a>';
	} else {
		foreach($results as $r) {
			echo '<a class="band-name" onclick="calAddBand(this)" id="'.$r['id'].'">'.ucwords(strtolower($r['name'])).'</a>';
		
		}
	}
} else if(isset($p['addInstrument'])) {
	$uid=$_COOKIE['mu_id'];
	$iid=$p['id'];
	addInstrument($uid,$iid);
	$results = getUserInstruments($_COOKIE['mu_id']);	
	if($results!=false) {
		foreach($results as $c=>$key) {
		  $sort_id[] = $key['id'];
		  $sort_name[] = $key['name'];
		}
	}
	array_multisort( $sort_name, SORT_STRING, $results);
?>
	<div class="sidebar-title">YOUR INSTRUMENTS</div>
	<div class="sidebar-widget-content">
	<?php
	if($results!=false) {
		foreach($results as $r) {
			echo '<div class="instrument">';
			echo '<a class="delete-inst" onclick="removeInstrument(this)" id="'.$r['id'].'">X</a>';
			echo '<a>'.ucwords(strtolower($r['name'])).'</a>';
			echo '</div>';		}
	} else {
		echo '<p>You have not added any instruments yet!</p>';
	}
	?>
	</div>
<?php
} else if(isset($p['removeInstrument'])) {
	$uid=$_COOKIE['mu_id'];
	$iid=$p['id'];
	removeInstrument($uid,$iid);
	$results = getUserInstruments($_COOKIE['mu_id']);
	if($results!=false) {
		foreach($results as $c=>$key) {
		  $sort_id[] = $key['id'];
		  $sort_name[] = $key['name'];
		}
	}
	array_multisort( $sort_name, SORT_STRING, $results);

?>
	<div class="sidebar-title">YOUR INSTRUMENTS</div>
	<div class="sidebar-widget-content">
	<?php
	if($results!=false) {
		foreach($results as $r) {
			echo '<div class="instrument">';
			echo '<a class="delete-inst" onclick="removeInstrument(this)" id="'.$r['id'].'">X</a>';
			echo '<a>'.ucwords(strtolower($r['name'])).'</a>';
			echo '</div>';
		}
	} else {
		echo '<p>You have not added any instruments yet!</p>';
	}
	?>
	</div>
<?php
}
?>