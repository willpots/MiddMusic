<?php
/***************************************************************************
 * Middlebury Music United 
 * This code is proprietary and property of William S. Potter.
 * It has been licensed for use to Middlebury College in this installation.
 * Use of this code requires consent from William S. Potter
 * wp@punkypond.com
 ***************************************************************************/
require_once('libs/libMMU.php');
if(isset($_POST['SUBMITREGISTER']))
{
	$con = mysql_connect($dbHost,$dbUser,$dbPass);
	if (!$con)
	{
	  	die('Could not connect: ' . mysql_error());
	}
	mysql_select_db($dbSchema, $con);
	if($_POST["password"] != $_POST["password2"]) 
	{
		echo "<p>Passwords do not match. Please try <a href=\"?page=register\">again</a>.</p>";
	}
	else
	{
		$username = $_POST["username"];
		$password = md5($_POST["password"]);
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		$class = $_POST["class"];
				
		$query = "SELECT username FROM user WHERE username = '$username'";
		$result = mysql_query($query) or die(mysql_error());
		if(!mysql_num_rows($result) == 0)
		{
			echo "<p>That username and/or email is/are already being used. Please try <a style=\"text-decoration: underline;\" href=\"?page=register\">again</a>.</p>";
		}
		else
		{
			$sql = "INSERT INTO user (username, password, firstname, lastname, class )
			VALUES ('$username', '$password', '$firstname', '$lastname', '$class' )";

			mysql_query($sql) or die(mysql_error());
			echo "<p>Welcome $username! You have succesfully registered! A confirmation will be sent shortly to ".$username."@middlebury.edu listed. Your username is $username and you can now return <a href=\"/\">home and login</a>.</p>";
		}
		mysql_close($con);
	}
} else {
$p=$_POST;
?>
<form method="post" action="?page=register" onkeyup="validateForm();">
<p>
	<label for="username">Username:<br>
	<input type="text" autocomplete="off" name="username" id="username" class="compose-field" style="width:200px;display:inline-block;" placeholder="Username" value="<?php if(isset($p['username'])) echo $p['username'];?>">@middlebury.edu
	</label>
</p>		
<p>
	<label for="password">Password:<br>
	<input type="password" autocomplete="off" name="password" id="password" class="compose-field" placeholder="Password" value="<?php if(isset($p['password'])) echo $p['password'];?>">
	</label>
</p>
<p>
	<label for="password2">Confirm Password:<br>
	<input type="password" autocomplete="off" name="password2"id="password2" class="compose-field" placeholder="Confirm Password">
	</label>
</p>	
<p>
	<label for="firstname">Firstname:<br>
	<input type="text" autocomplete="off" name="firstname" class="compose-field" placeholder="Firstname">
	</label>
</p>	
<p>
	<label for="lastname">Lastname:<br>
	<input type="text" autocomplete="off" name="lastname" class="compose-field" placeholder="Lastname">
	</label>
</p><p>
	<label for="class">Class Year:<br>
	<input type="text" autocomplete="off" name="class" id="class" class="compose-field" placeholder="Class Year">
	</label>
</p>
<p><input type="submit" value="Register" class="button" id="SUBMITREGISTER" name="SUBMITREGISTER" disabled></p>
</form>	

<?php
}
?>