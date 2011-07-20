<?php
if(isset($_POST["SUBMITLOGIN"]))
{
	include('functions.php');	
	$username = $_POST["username"];
	$password = md5($_POST["password"]);
	$ui = getLogin($username, $password);
	if($ui!=false) {
		$id = $ui['id'];
		$username = $ui['username'];
		$admin = $ui['admin'];
		$valid = $ui['valid'];
		
		$expires = time() + 3600;
		if($valid==1)
		{
			setrawcookie("mu_user", $username, $expires);
			setrawcookie("mu_id", $id, $expires);
		}
		if($admin == 1 && $valid==1)
		{
			setrawcookie("mu_admin", "yes", $expires);
		}
		header('Location: http://middmusic.com/');
	} else {
		header('Location: index.php?page=login&fail');
	}
}	else {?>








<?php
}	
?>