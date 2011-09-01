<?php
require_once('libs/libMMU.php');	
if(isset($_POST["SUBMITLOGIN"]))
{
	$username = $_POST["username"];
	$password = md5($_POST["password"]);
	$ui = getLogin($username, $password);
	if($ui!=false) {
		$id = $ui['id'];
		$username = $ui['username'];
		$admin = $ui['admin'];
		$valid = $ui['valid'];
		
		$expires = time() + 60*60*24*31;
		if($admin == 1 && $valid==1) {
			setrawcookie("mu_user", $username, $expires);
			setrawcookie("mu_id", $id, $expires);
			setrawcookie("mu_admin", "yes", $expires);
			header('Location: http://middmusic.com/');
		} else if($valid==1) {
			setrawcookie("mu_user", $username, $expires);
			setrawcookie("mu_id", $id, $expires);
			header('Location: http://middmusic.com/');
		} else {
			header("Location: index.php?page=login&validate=".$username);
		}
	} else {
		header('Location: index.php?page=login&fail');
	}
}	else {?>








<?php
}	
?>