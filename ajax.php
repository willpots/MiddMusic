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
	
} else if(isset($p['getSearchQuery'])) {
	if(isset($p['query'])) $q = $p['query'];
	else $q = "";
	$page = $p['page'];
	$cat = "false";
	
	echo '<div class="section-title">'.strtoupper($page).'</div>';
	echo '<div id="results">';
	if($page=="musicians") {
		$table = "user";
		if($cat=="false") {
			$results = pullSearchQuery($q, $table);
		} else {
			$results = searchForUsersWithInst($q);
		}
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
		$table = "acts";
		$results = pullSearchQuery($q, $table);
		if($results!=false) {
			foreach($results as $r) {
				echo '<a href="?page=profile&band='.$r['id'].'" class="search-result">'.$r['name'].'</a>';
			}
		}
	}
	echo '</div>';
} else if(isset($p['getCategorySearch'])) {




}
?>