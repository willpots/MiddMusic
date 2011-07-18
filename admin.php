<?php  
/***************************************************************************
 * Middlebury Music United 
 * This code is proprietary and property of William S. Potter.
 * It has been licensed for use to Middlebury College in this installation.
 * Use of this code requires consent from William S. Potter
 * wp@punkypond.com
 ***************************************************************************/
include_once("LocalSettings.php");
if(isset($_COOKIE['mu_admin']))
{
?>
<!DOCTYPE html>
<html>
<head>
<title>Middlebury Music United | Home</title>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
	<div id="wrapper">
		<?php 
		include_once("LoginBar.php");
		$con = mysql_connect($dbHost,$dbUser,$dbPass);
		if (!$con)
		{die('Could not connect: ' . mysql_error());}
		mysql_select_db($dbSchema, $con);	
		?>
		<div id="content">
			<div id="header"><a href="index.php"><img src="mmuweb.jpg" alt=""></a></div>
			<div id="maincontent">
				<div id="outerbox">
					<div id="tabrow">
						<a href="admin.php"><div class="<?php if(!isset($_REQUEST['events'])) echo 'selected '; ?>tab">Users</div></a>
						<a href="?events"><div class="<?php if(isset($_REQUEST['events'])) echo 'selected '; ?>tab">Events</div></a>
					</div>
					<div id="innerbox">
					<?php 
					if(isset($_REQUEST['events']))
					{
					
					}
					else
					{
						if(isset($_POST['SUBMITUSERS']))
						{
							$result = mysql_query("SELECT * FROM user");
							while($row = mysql_fetch_array($result))
							{
								$ids[]=$row['id'];
							}
							foreach($ids as $i)
							{
								$valid=0;
								$admin=0;
								if(!empty($_POST[$i]))
								{
									foreach($_POST[$i] as $j)
									{
										if($j=="valid") $valid=1;
										if($j=="admin") $admin=1;
									}
								}
								else
								{
									$valid=0;
									$admin=0;
								}
								mysql_query("UPDATE user SET valid='$valid', admin='$admin' WHERE id='$i'");
							}
							$result = mysql_query("SELECT * FROM user");
							$users = array();
							while($row=mysql_fetch_array($result))
							{
								$username = $row['username'];
								$users[$username]['username']=$username;
								$users[$username]['firstname'] = $row['firstname'];
								$users[$username]['lastname'] = $row['lastname'];
								$users[$username]['id'] = $row['id'];
								$users[$username]['valid'] = $row['valid'];	
								$users[$username]['admin'] = $row['admin'];											
							}
							asort($users);
							$bgcolor = "#eeeeee";
							echo '<p>Changes saved successfully!</p>';
							echo '<form method="post" action="admin.php">';
							echo '<table id="userlisttable" cellspacing="0" width="100%">';
							echo '<tr><td style="text-align:center;" colspan="4"><input type="submit" name="SUBMITUSERS" value="Update Users"></td></tr>';
							echo '<tr><th>Name</th><th>Username</th><th>Active?</th><th>Admin</th></tr>';
							foreach($users as $user)
							{
								echo '<tr style="background-color:'.$bgcolor.';">';
								echo '<td>'.$user['firstname'].' '.$user['lastname'].'</td>';
								echo '<td class="userlistun"><a href="mailto:'.$user['username'].'@middlebury.edu">'.$user['username'].'</a></td>';
								if($user['valid']==1) echo '<td><input type="checkbox" checked="checked" name="'.$user['id'].'[]" value="valid"></td>'; 
								else echo '<td><input type="checkbox" name="'.$user['id'].'[]" value="valid"></td>';
								if($user['admin']==1) echo '<td><input type="checkbox" checked="checked" name="'.$user['id'].'[]" value="admin"></td>'; 
								else echo '<td><input type="checkbox" name="'.$user['id'].'[]" value="admin"></td>';
								echo '</tr>';
								$bgcolor=$bgcolor=="#dddddd"?"#eeeeee":"#dddddd";
							}
							echo '</table>';
							echo '</form>';
						}
						else
						{
							$result = mysql_query("SELECT * FROM user");
							$users = array();
							while($row=mysql_fetch_array($result))
							{
								$username = $row['username'];
								$users[$username]['username']=$username;
								$users[$username]['firstname'] = $row['firstname'];
								$users[$username]['lastname'] = $row['lastname'];
								$users[$username]['id'] = $row['id'];
								$users[$username]['valid'] = $row['valid'];	
								$users[$username]['admin'] = $row['admin'];											
							}
							asort($users);
							$bgcolor = "#eeeeee";
							echo '<form method="post" action="admin.php">';
							echo '<table id="userlisttable" cellspacing="0" width="100%">';
							echo '<tr><td style="text-align:center;" colspan="4"><input type="submit" name="SUBMITUSERS" value="Update Users"></td></tr>';
							echo '<tr><th>Name</th><th>Username</th><th>Active?</th><th>Admin</th></tr>';
							foreach($users as $user)
							{
								echo '<tr style="background-color:'.$bgcolor.';">';
								echo '<td>'.$user['firstname'].' '.$user['lastname'].'</td>';
								echo '<td class="userlistun"><a href="mailto:'.$user['username'].'@middlebury.edu">'.$user['username'].'</a></td>';
								if($user['valid']==1) echo '<td><input type="checkbox" checked="checked" name="'.$user['id'].'[]" value="valid"></td>'; 
								else echo '<td><input type="checkbox" name="'.$user['id'].'[]" value="valid"></td>';
								if($user['admin']==1) echo '<td><input type="checkbox" checked="checked" name="'.$user['id'].'[]" value="admin"></td>'; 
								else echo '<td><input type="checkbox" name="'.$user['id'].'[]" value="admin"></td>';
								echo '</tr>';
								$bgcolor=$bgcolor=="#dddddd"?"#eeeeee":"#dddddd";
							}
							echo '</table>';
							echo '</form>';
						}
					}
					?>
					</div>
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
else
{
?>
<!DOCTYPE html>
<html>
<head>
<title>Middlebury Music United | Home</title>
<link rel="stylesheet" type="text/css" href="style.css">

</head>
<body>
	<div id="wrapper">
		<?php 
		include_once("LoginBar.php");
		?>
		<div id="content">
			<div id="header"><a href="index.php"><img src="mmuweb.jpg" alt=""></a></div>
			<div id="maincontent">
			<p>You must be an admin to view this page!</p>
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