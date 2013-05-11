<?php 
include('libs/libMMU.php');
if(isset($_GET['page'])) {
	if($_GET['page']=="profile") { //Profile
		include('main/profileMain.php');
	} else if($_GET['page']=="compose") { //Compose
		include('main/composeMain.php');
	} else if($_GET['page']=="login") { //Compose
		include('main/loginMain.php');
	} else if($_GET['page']=="register") { //Register
		include('main/registerMain.php');
	} else if($_GET['page']=="edit") { //Edit (Profile)
		include('main/editMain.php');
	} else if($_GET['page']=="calendar"||$_GET['page']=="practice"||$_GET['page']=="record") { //Calendar Views
		include('main/calendarMain.php');
	} else if($_GET['page']=="bands"||$_GET['page']=="musicians"||$_GET['page']=="venues") { //Directory Views
		include('main/directoryMain.php');
	} else { // Default to Profile View
	include('main/profileMain.php');
	}
}
?>