<?php 
if(isset($_GET['code'])) {
	$code = $_GET['code'];

	$u = new User(null,$code);
	if($u->confirmed==true) {
		echo '<p>Great! Your account is now confirmed. Please log in using your username ( [username]@middlebury.edu) and password that you chose at registration.</p>';
		include('loginMain.php');
	} else {
		echo '<p>Sorry, the code you entered is not valid!</p>';
	
	}
} else { 		

echo '<p>Sorry, the link you clicked is not valid!</p>';

}

?>