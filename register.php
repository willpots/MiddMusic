<?php
/***************************************************************************
 * Middlebury Music United 
 * This code is proprietary and property of William S. Potter.
 * It has been licensed for use to Middlebury College in this installation.
 * Use of this code requires consent from William S. Potter
 * wp@punkypond.com
 ***************************************************************************/
include_once("SiteFunctions.php");
include_once("LocalSettings.php");
if(isset($_POST['SUBMITREGISTER']))
{
	$con = mysql_connect($dbHost,$dbUser,$dbPass);
	if (!$con)
	{
	  	die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($dbSchema, $con);
	if($_POST["email"] != $_POST["email2"])
	{
		echo "<p>Email accounts do not match. Please try <a href=\"register.php\">again</a>.</p>";	
	}
	elseif($_POST["password"] != $_POST["password2"]) 
	{
		echo "<p>Passwords do not match. Please try <a href=\"register.php\">again</a>.</p>";
	}
	elseif(emailCheck($_POST["email"], $emailDomain) == FALSE)
	{
		echo "<p>You must register with a middlebury.edu email address. Please try <a href=\"register.php\">again</a>.</p>";
	}
	else
	{
		$email = $_POST["email"];
		$pieces = explode('@', $email);
		$username = $pieces[0];
		$password = md5($_POST["password"]);
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		$class = $_POST["class"];
				
		$query = "SELECT username FROM user WHERE username = '$username' OR email = '$email' ";
		$result = mysql_query($query) or die(mysql_error());
		if(!mysql_num_rows($result) == 0)
		{
			echo "<p>That username and/or email is/are already being used. Please try <a style=\"text-decoration: underline;\" href=\"register.php\">again</a>.</p>";
		}
		else
		{
			$sql = "INSERT INTO user (username, password, firstname, lastname, class, email )
			VALUES ('$username', '$password', '$firstname', '$lastname', '$class', '$email' )";

			mysql_query($sql) or die(mysql_error());
			echo "<p>Welcome $username! You have succesfully registered! A confirmation will be sent shortly to your email address listed. Your username is $username and you can now return <a href=\"index.php\">home and login</a>.</p>";
		}
		mysql_close($con);
	}
}
else
{
?>
	<html>
	
	<head>
	<title>Middlebury Music United | Register</title>
	<link rel="stylesheet" type="text/css" href="includes/css/style.css">
	</head>
	<body>
		<div id="loginbar">
			<?php //Login Bar
			include("LoginBar.php");
			?>
		</div>
		<div id="wrapper">
			<div id="header">
				<a href="index.php"><img src="mmuweb.jpg" alt=""></a>
			</div>

			<div id="content">
				<div id="mainbody">
				<form name="register" action="register.php" method="post">
				<table align="center" style="text-align:center;">
				<tr><td colspan="2">To register for the Middlebury Music United, fill out the below information.</td></tr>
				<tr><td colspan="2">Please use your Middlebury Email account.</td></tr>
				<tr></tr>
				<tr><td>Middlebury Email: </td><td> <input type="text" name="email"></td></tr>
				<tr><td>Confirm Email: </td><td> <input type="text" name="email2"></td></tr>
				<tr><td>Desired Password: </td><td> <input type="password" name="password"></td></tr>
				<tr><td>Confirm Password: </td><td> <input type="password" name="password2"></td></tr>
				<tr><td>First Name: </td><td> <input type="text" name="firstname"></td></tr>
				<tr><td>Last Name: </td><td> <input type="text" name="lastname"></td></tr>
				<tr><td>Class Year</td><td>
				<select name="class">
					<?php 
					$date = 1960;
					$olddate = 2014;
					while($olddate >= $date)
					{
						echo '<option value="'.$olddate.'">'.$olddate.'</option>';
						echo '<option value="'.$olddate.'.5">'.$olddate.'.5</option>';
						$olddate--;
					}
					?>
				</select>
				</td></tr>
				<tr><td colspan="2"><input type="submit" name="SUBMITREGISTER" value="Register"></td></tr>
				</table>
				</form>
				</div>
			</div>
		</div>
	<?php 
	include_once("Footer.php");
	?>
	</body>
	</html> 
		<?php

}		
?>