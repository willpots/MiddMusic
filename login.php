<?php
/***************************************************************************
 * Middlebury Music United 
 * This code is proprietary and property of William S. Potter.
 * It has been licensed for use to Middlebury College in this installation.
 * Use of this code requires consent from William S. Potter
 * wp@punkypond.com
 ***************************************************************************/
if(isset($_POST["SUBMITLOGIN"]))
{
	include('functions.php');	
	$username = $_POST["username"];
	$password = md5($_POST["password"]);
	$con = mysql_connect($dbHost,$dbUser,$dbPass);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($dbSchema, $con);		  	
	$query = "SELECT * FROM user WHERE username = '$username' and password= '$password' ";
	$result = mysql_query($query);
	$num = mysql_num_rows($result);
	if( $num == "1" )
	{
		while($row = mysql_fetch_array($result))
		{
			$id = $row['id'];
			$username = $row['username'];
			$admin = $row['admin'];
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];
			$valid = $row['valid'];
		}
		$name = $firstname.' '.$lastname;
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
		echo '<html><head><meta http-equiv="refresh" content="0;url='.$sitename.$_POST['cur_page'].'" /></head></html>';
		mysql_free_result($result);
		mysql_close($con);
	}
	else
	{ //Login Splash Page Now
	?>
	<html>
	
	<head>
	<title>Middlebury Music United | Login</title>
	<link rel="stylesheet" href="style.css" type="text/css">
	</head>
	<body>
	<div id="wrapper">
		<div id="loginbar">
			<?php //Login Bar
			include("LoginBar.php");
			?>
		</div>
			<div id="header">
				<a href="index.php"><img src="mmuweb.jpg" alt=""></a>
			</div>

		<div id="content">
			<div id="maincontent">
				<div id="mainbody">
				<form name="login" action="login.php" method="post">
				<table align="center" style="text-align:center;">
				<input type="hidden" name="cur_page" value="<?php echo $_POST['cur_page']; ?>">
				<tr><td>Sorry, we could not find that username or the password you entered was incorrect. Please try again or <a style="text-decoration:none;" href="register.php">register</a>.</td></tr>
				<tr></tr>
				<tr><td>Username: <input type="text" name="username"></td></tr>
				<tr><td>Password: <input type="password" name="password"></td></tr>
				<tr><td><input type="submit" name="SUBMITLOGIN" value="Login"></td></tr>
				</table>
				</form>
				</div>
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

}
else
{
	if(isset($_COOKIE['mu_user']))
	{
	?>
		<html>
		
		<head>
		<title>Middlebury Music United | Login</title>
		<link rel="stylesheet" href="style.css" type="text/css">
		</head>
		<body>
			<div id="loginbar">
				<?php //Login Bar
				include("LoginBar.php");
				?>
			</div>
			<div id="wrapper">
	
				<div id="content">
					<div id="header">
					<h1><a href="index.php">Middlebury Music United</a></h1>
					</div>
					<div id="mainbody">
					<form name="login" action="login.php" method="post">
					<table align="center" style="text-align:center;">
					<tr><td>Please login or <a style="text-decoration:none;" href="register.php">register</a>.</td></tr>
					<tr></tr>
					<tr><td>Username: <input type="text" name="username"></td></tr>
					<tr><td>Password: <input type="password" name="password"></td></tr>
					<tr><td><input type="submit" name="SUBMITLOGIN" value="Login"></td></tr>
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
	else
	{
	echo '<html><head><meta http-equiv="refresh" content="0;'.$sitename.'/profile.php"></head></html>';
	}
}		
?>