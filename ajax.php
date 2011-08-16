<?php
require("functions.php");
$p=$_POST;
if(isset($p['getDateView'])) {
	header( "content-type: text/html; charset=UTF-8" ); 






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
	
} else if(isset($p['uploadPix'])) {


	$tname=	$_FILES['profilepic']['tmp_name'];
	$name = $_FILES['profilepic']['name'];

	updatePic($_COOKIE['mu_id'],"photos/".$name);
	move_uploaded_file(	$tname, "photos/".$name);
	echo "photos/".$name;



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
		$results = pullSearchQuery($q, $table);

		if($results!=false) {
			foreach($results as $r) {
				echo '<a href="?page=profile&id='.$r['id'].'" class="search-result">'.$r['firstname'].' '.$r['lastname'].'</a>';
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
		$cname = getActTypeName($q);
		echo '<div class="section-title">'.strtoupper($page).' - '.$cname.'</div>';
		echo '<div id="results">';
		$table = "bands";
		$results = searchForActWithType($q);
		if($results!=false) {
			foreach($results as $r) {
				echo '<a href="?page=profile&band='.$r['id'].'" class="search-result">'.$r['name'].'</a>';
			}
		}
	}
	echo '</div>';
} else if(isset($p['userupdate'])) {
	$id = $_COOKIE['mu_id'];
	$firstname=$_POST['firstname'];
	$lastname=$_POST['lastname'];
	$class=$_POST['class'];
	$info=addslashes($_POST['info']);
	updateUser($id, $firstname, $lastname, $class, $info);
	$i = getUserInfo($id);
	?>
		<div class="section-title">EDIT YOUR PROFILE</div>
		<div id="edit-form">
			<div class="right">
				<img id="profilepic" src="<?php echo $i['picture']; ?>" alt="Profile Picture" width="200">
			</div>
			<label for="username">Username: 
				<input type="text" name="username" id="username" value="<?php echo $i['username']; ?>" placeholder="Username" disabled>
			</label>
			<label for="firstname">Firstname: 
				<input type="text" name="firstname" id="firstname" value="<?php echo $i['firstname']; ?>" placeholder="Firstname">
			</label>
			<label for="lastname">Lastname: 
				<input type="text" name="lastname" id="lastname" value="<?php echo $i['lastname']; ?>" placeholder="Lastname">
			</label>
			<label for="class">Class Year:
				<select name="class" id="class">
					<option value="2008" <?php if($i['class']==2008) echo "selected"; ?> >2008</option>
					<option value="2008.5" <?php if($i['class']==2008.5) echo "selected"; ?> >2008.5</option>
					<option value="2009" <?php if($i['class']==2009) echo "selected"; ?> >2009</option>
					<option value="2009.5" <?php if($i['class']==2009.5) echo "selected"; ?> >2009.5</option>
					<option value="2010" <?php if($i['class']==2010) echo "selected"; ?> >2010</option>
					<option value="2010.5" <?php if($i['class']==2010.5) echo "selected"; ?> >2010.5</option>
					<option value="2011" <?php if($i['class']==2011) echo "selected"; ?> >2011</option>
					<option value="2011.5" <?php if($i['class']==2011.5) echo "selected"; ?> >2011.5</option>
					<option value="2012" <?php if($i['class']==2012) echo "selected"; ?> >2012</option>
					<option value="2012.5" <?php if($i['class']==2012.5) echo "selected"; ?> >2012.5</option>
					<option value="2013" <?php if($i['class']==2013) echo "selected"; ?> >2013</option>
					<option value="2013.5" <?php if($i['class']==2013.5) echo "selected"; ?> >2013.5</option>
					<option value="2014" <?php if($i['class']==2014) echo "selected"; ?> >2014</option>
					<option value="2014.5" <?php if($i['class']==2014.5) echo "selected"; ?> >2014.5</option>
					<option value="2015" <?php if($i['class']==2015) echo "selected"; ?> >2015</option>
					<option value="2015.5" <?php if($i['class']==2015.5) echo "selected"; ?> >2015.5</option>
				</select>
			</label>
			<label for="info">Description:<br>
				<textarea rows="15" cols="53" name="info" id="info" placeholder="Describe yourself here..."><?php echo $i['info']; ?></textarea>
			</label>		
			<a class="button" onclick="updateUser()">Update Profile</a>
		</div>		
<?php
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