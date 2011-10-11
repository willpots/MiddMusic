<?php 




function is_logged_in() {
	if(isset($_COOKIE['mu_id'])) {
		return true;
	} else {
		return false;
	}
}

function is_admin() {
	if(isset($_COOKIE['mu_admin'])) {
		return true;
	} else {
		return false;
	}
}





// String Stuff
function cleanString($string) {
	$string = htmlspecialchars(addslashes(strip_tags($string)));
	return $string;
}
function viewString($string) {
	$string = nl2br(stripslashes($string));
	return $string;
}




?>