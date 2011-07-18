<?php
/***************************************************************************
 * Middlebury Music United 
 * This code is proprietary and property of William S. Potter.
 * It has been licensed for use to Middlebury College in this installation.
 * Use of this code requires consent from William S. Potter
 * wp@punkypond.com
 ***************************************************************************/
if (isset($_COOKIE["mu_user"])) 
{
	echo "<div id=\"login\"><table><tr>";
	echo '<div id="navbar">';
	echo '<a href="index.php"><img src="mmuweb.gif" height="15px" alt=""></a>';
	//echo '<a href="index.php">Home</a>';
	echo '<a href="profile.php">My Profile</a>';
	echo '<a href="calendar.php">Calendar</a>';
	echo '<a href="directory.php">Directory</a>';
	echo '</div><div id="rightlinks">';
	echo "Welcome " . $_COOKIE["mu_user"] . "!&nbsp";
	if(isset($_COOKIE["mu_admin"])) echo '<a href="admin.php">Admin Home</a>';
	echo '<a href="profile.php?edit">Edit My Profile</a>';
	echo '<a href="logout.php?p='.$_SERVER['PHP_SELF'].'" >Log Out</a></div>';
	echo "</tr></table></div>";
}	
else 
{
	echo "<div id=\"login\">";
	echo '<div id="navbar">';
	echo '<a href="index.php"><img src="mmuweb.gif" height="15px" alt=""></a>';
	//echo '<a href="index.php">Home</a>';
	echo '<a href="calendar.php">Calendar</a>';
	echo '<a href="directory.php">Directory</a>';
	echo '</div>'; 
	echo "<table><tr>";
	echo '<form name="LOGIN" action="login.php" method="post"><input type="hidden" name="cur_page" value="'.$_SERVER['PHP_SELF'].'"><td>Username: <input type="text" name="username" /></td>'; 
	echo '<td>Password: <input type="password" name="password" /> <input type="submit" name="SUBMITLOGIN" value="Login" /> </form></td>'; 
	echo '<form name="REGISTER" action="register.php" ><input type="hidden" name="cur_page" value="'.$_SERVER['PHP_SELF'].'"><td><input type="submit" value="Register" /> </form></td>';
	echo "</tr></table></div>";
}
?>