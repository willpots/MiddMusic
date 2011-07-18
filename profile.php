<?php 
/***************************************************************************
 * Middlebury Music United 
 * This code is proprietary and property of William S. Potter.
 * It has been licensed for use to Middlebury College in this installation.
 * Use of this code requires consent from William S. Potter
 * wp@punkypond.com
 ***************************************************************************/
 ?>
<!DOCTYPE html>
<html>
<head>
<title>Middlebury Music United | Profile</title>
<link rel="stylesheet" type="text/css" href="includes/css/style.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="text/javascript" src="includes/js/functions.js"></script>

</head>
<body>
	<div id="wrapper">
		<?php 
		include_once("LoginBar.php");
		?>
		<div id="content">
		<div id="header">
				<a href="index.php"><img src="mmuweb.jpg" alt=""></a>
		</div>
		<div id="mainbody">
<?php  
include_once("LocalSettings.php");
$con = mysql_connect($dbHost,$dbUser,$dbPass);
$no_inst = 1;

if (!$con)
{
	die('Could not connect: ' . mysql_error());
}
mysql_select_db($dbSchema, $con);
if(isset($_REQUEST["edit"])&&isset($_COOKIE['mu_user']))
{
	//Profile Editor Here
	if(isset($_POST["SUBMITPROFILE"]))
	{
		//UPDATE/INSERT THE PROFILE
		$username = $_POST["username"];
		$firstname = $_POST["firstname"];
		$lastname = $_POST["lastname"];
		$num_inst = $_POST["num_inst"];
		$newinst = $_POST["newinst"];
		$id = $_POST["id"];
		$info = $_POST["info"];
		for($i=0;$i<=$num_inst;$i++)
		{
			if(isset($_POST[$i]))
			{
				if($_POST[$i] == "Yes")
				{
					$instruments[] = $i;
				}
			}
		}
		mysql_query("UPDATE user SET firstname = '$firstname', lastname = '$lastname', info = '$info' WHERE username = '$username'");
		$result = mysql_query("SELECT * FROM userinstruments WHERE userid = '$id'");
		while($row = mysql_fetch_array($result))
		{
			$myinsts[] = $row["instrumentid"];
		}
		foreach($instruments as $inst)
		{
			if(!in_array($inst, $myinsts))
			{
				mysql_query("INSERT INTO userinstruments (userid, instrumentid) VALUES ('$id', '$inst')");
			}
		}
		foreach($myinsts as $inst)
		{
			if(!in_array($inst, $instruments))
			{
				mysql_query("DELETE FROM userinstruments WHERE userid = '$id' AND instrumentid = '$inst'");
			}
		}
		if(isset($newinst) && $newinst != "")
		{
			mysql_query("INSERT INTO instruments (name) VALUES ('$newinst')");
			$result = mysql_query("SELECT id FROM instruments WHERE name = '$newinst'");
			while($row = mysql_fetch_array($result))
			{
				$newid = $row["id"];
			}
			mysql_query("INSERT INTO userinstruments (userid, instrumentid) VALUES ('$id', '$newid')");
		}
		
		$mime = array('image/gif' => 'gif',
						'image/jpeg' => 'jpg',
						'image/png' => 'png',
						'image/psd' => 'psd',
						'image/bmp' => 'bmp',
						'image/tiff' => 'tiff',
						'image/tiff' => 'tiff',
						'image/jp2' => 'jp2',
						'image/iff' => 'iff',
						'image/vnd.wap.wbmp' => 'bmp',
						'image/xbm' => 'xbm',
						'image/vnd.microsoft.icon' => 'ico');

		if($_FILES['photo']['name'] != "" && $_FILES['photo']['name'] != NULL )
		{	
			$file = $_FILES['photo'];
			$file_name = $file['name'];	
			$names = explode('.', $file_name);
			$i = count($names) - 1;
			$ext = $names[$i];
	
			if($ext == 'jpc' || $ext == 'jpx' || $ext == 'jb2')
			{
				$extension = $ext;
			}
			if(in_array($ext, $mime))
			{
				$extension = $ext;				
				$extension = $mime[array_search($ext, $mime)];
			}
		
			if(!$extension)
			{
				echo 'You must upload a valid picture!';
			}
			else
			{
				$target_path = "photos/";
				$target_path = $target_path . $username .'.'. $extension; 
							
				if(move_uploaded_file($file["tmp_name"], $target_path))
				{
				    echo '<script type="text/javascript">window.location="profile.php?success"</script>';
					echo '<noscript><p>Changes saved successfully! <a href="profile.php">Return to your profile</a>.</p></noscript>';
				} 
				else
				{
				    echo "There was an error uploading the file, please try again!";
				}
			}
		}
		else
		{
		    echo '<script type="text/javascript">window.location="profile.php?success"</script>';
			echo '<noscript><p>Changes saved successfully! <a href="profile.php">Return to your profile</a>.</p></noscript>';		
		}
	}
	else
	{
		$username = $_COOKIE["mu_user"];
		$query = "SELECT * FROM user WHERE username = '$username'";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
		{
			$id = $row['id'];
			$username = $row['username'];
			$admin = $row['admin'];
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];
			$filepath = $row['picture'];
			$info = $row['info'];
		}
		$query = "SELECT * FROM instruments";
		$result = mysql_query($query);
		while($row = mysql_fetch_array($result))
		{
			$instids[] = $row["id"];
			$p = $row["id"];
			$instnames[$p] = $row["name"];
		}
		$num_inst = max($instids);
		$query = "SELECT * FROM userinstruments WHERE userid = '$id'";
		$result = mysql_query($query);
		$myinst = array();
		while($row = mysql_fetch_array($result))
		{
			$myinst[] = $row["instrumentid"];
		}	
		?>
		<h3>Edit My Profile</h3>
		<form enctype="multipart/form-data" method="post" id="updateform" action="profile.php?edit" >
		Username: <input type="text" readonly="readonly" name="username" value="<?php echo $username; ?>"><br>
		First Name: <input type="text" name="firstname" value="<?php echo $firstname; ?>"><br>
		Last Name: <input type="text" name="lastname" value="<?php echo $lastname; ?>"><br>
		<input type="hidden" name="num_inst" value="<?php echo $num_inst; ?>">
		<input type="hidden" name="id" value="<?php echo $id; ?>">
		About Me:<br />
		<textarea cols="94" rows="10" name="info"><?php echo $info; ?></textarea>
		<input type="hidden" name="MAX_FILE_SIZE" value="100000" /><br />
		Choose a picture to upload: <input name="photo" type="file" /><br />
		<hr>
		<h5 style="text-align:left;">I know:</h5>
		<input type="text" size="30" onkeyup="showResult(this.value, event, <?php echo $id; ?>)" />
		<div id="livesearch"></div>
		<div id="instlist">
		<?php
		foreach($instids as $instrument)
		{
			if(in_array($instrument, $myinst))
			{
				echo '<input type="text" disabled name="'.$instrument.'" value="'.ucfirst($instnames[$instrument]).'"><br>';
			}
		}	
		?>
		
		</div>

		<h5 style="text-align:left;">Instrument not here? Add one:</h5>
		<input type="text" name="newinst" size="45" value=""><br>
		<!--<input type="submit" name="SUBMITPROFILE" value="Save Changes">-->
		</form>
		<?php
	}
}
else
{
	//Profile Viewer Here
	if(isset($_REQUEST["u"]))
	{
		$username = $_REQUEST["u"];
	}
	else
	{
		if(isset($_COOKIE["mu_user"])) $username = $_COOKIE["mu_user"];
		else $username="";
	}
	$query = "SELECT * FROM user WHERE username = '$username'";
	$result = mysql_query($query);
	$num = mysql_num_rows($result);
	if(isset($_COOKIE['mu_user']))	$cur_user = $_COOKIE['mu_user'];
	else $cur_user = "";
	if( $num == "1" )
	{
		while($row = mysql_fetch_array($result))
		{
			$id = $row['id'];
			$username = $row['username'];
			$admin = $row['admin'];
			$firstname = $row['firstname'];
			$lastname = $row['lastname'];
			$filepath = $row['picture'];
			$info = $row["info"];
		}
		$name = $firstname.' '.$lastname;
		$if_picture = TRUE;
		if($result = mysql_query("SELECT * FROM userinstruments WHERE userid = '$id'"))
		{
		
			if(mysql_num_rows($result) !=0)
			{
				while($row = mysql_fetch_array($result))
				{
					$instrumentids[] = $row["instrumentid"];
				}
				foreach($instrumentids as $intid)
				{
					$query = "SELECT * FROM instruments WHERE id = '$intid'";
					$result = mysql_query($query);
					while($row = mysql_fetch_array($result))
					{
						$instruments[] = $row["name"];
					}
				}
			}
			else
			{
				$no_inst = 0;
			}
		}
		else {     die('Invalid query: ' . mysql_error()); }
		if(file_exists($filepath) == FALSE || $filepath == NULL)
		{
			$filepath = "photos/nameless.png";
			$if_picture = FALSE;
		}
		if($username == $cur_user)
		{
			echo '<a href="profile.php?edit"><h3>'.$name.' ('.$username.')</h3></a><br>';
		}
		else
		{
			echo '<h3>'.$name.' ('.$username.')</h3><br>';
		}
		if(isset($_REQUEST["success"])) echo '<p>Profile updated successfully!</p>';
		?>
		<div id="infobox">
		<h4>Info</h4>
		<h5 style="text-align:left;">I know...</h5>
		<?php
		if($no_inst != 0)
		{
			echo '<ul>';
			foreach($instruments as $inst)
			{
				echo '<li>'.ucfirst($inst).'</li>';
			}
			echo '</ul>';
		}
		else
		{
			echo '<p>'.$name.' has not added any instruments</p>';
		}
		?>
		<hr>
		<h5 style="text-align:left;">About Me</h5>
		<?php echo '<p>'.$info.'</p>'; ?>
		<hr>
		<?php echo '<a href="mailto:'.$username.'@middlebury.edu">Email '.$firstname.'</a><br>'; ?>
		<?php if($username == $cur_user) echo '<a href="profile.php?edit">Edit My Profile</a>'; ?>
		</div>
		<div id="profilepic">
			<img src="<?php echo $filepath; ?>" alt="">
			<?php if($if_picture == FALSE && $cur_user == $username) echo '<p><a href="?edit">Upload a Picture</a></p>'; ?>
		</div>
		<?php

	}
	else
	{
		echo '<h3>Username not found! <a href="directory.php">Click here to visit the Directory</a>.</h3>';
	}
}


?>		
		</div>
		</div>
	</div>
	<?php 
	include_once("Footer.php");
	?>
</body>
</html>