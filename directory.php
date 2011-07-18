<?php  
/***************************************************************************************
 * Middlebury Music United 
 * This code is proprietary and property of William S. Potter.
 * It has been licensed for use to Middlebury College in this installation.
 * Use of this code requires consent from William S. Potter or MiddPoint Development.
 * wp@punkypond.com
 ***************************************************************************************/
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
		if($_GET['search']!="") $search = $_GET['search'];
		if($_GET['instrument']!="") $instrument = $_GET['instrument'];
		?>
		<div id="content">
			<div id="header">
				<a href="index.php"><img src="mmuweb.jpg" alt=""></a>
			</div>
			<div id="mainbody">
			<h3><a href="directory.php">Directory</a></h3>
			<div id="searchdir">
				<form action="?" method="get">
				<input type="search" <?php if(isset($search)) echo 'value="'.$search.'"'; else echo 'placeholder="Name, person, email"'; ?> name="search">
				<input type="search" <?php if(isset($instrument)) echo 'value="'.$instrument.'"'; else echo 'placeholder="Instrument"'; ?> name="instrument">
				<input type="submit" value="Search">
			</form</div>
			<?php
			include_once("LocalSettings.php");
			$con = mysql_connect($dbHost,$dbUser,$dbPass);
			if (!$con)
			{
				die('Could not connect: ' . mysql_error());
			}
			mysql_select_db($dbSchema, $con);

			$diritem = "diritem1";
			echo '<div id="dirnames">';
			if(isset($_GET['sort']))
			{
				
				$sort=$_GET['sort'];
				if($sort=='first')
				{
				
				}
				elseif($sort=='last')
				{
				
				}
			}
			elseif(isset($_GET['search'])||isset($_GET['instrument']))
			{
				
				//NAME SEARCH
				if($_GET['search']!="") {
					
					$query = "SELECT * FROM user WHERE username LIKE '%$search%' OR firstname LIKE '%$search%' OR lastname LIKE '%$search%' ";
					$result = mysql_query($query);
					while($row = mysql_fetch_array($result))
					{
						$usernames3[] = $row["username"];
						$firsts3[$row["username"]] =  $row["firstname"];
						$lasts3[$row["username"]] =  $row["lastname"];			
					}
				}
				// INSTRUMENT SEARCH
				if($_GET['instrument']!="") {
					
					$query = "SELECT id FROM instruments WHERE name LIKE '%$instrument%' ";
					$result = mysql_query($query);
					while($row = mysql_fetch_array($result))
					{
						$instid=$row['id']; //Pull Instrument ID
						$result2 = mysql_query("SELECT * FROM userinstruments WHERE instrumentid = '$instid'"); //Pull all users who have that instrument id
						while($row2 = mysql_fetch_array($result2))
						{
							$userids[]=$row2['userid'];
						}
					}
					if(!empty($userids))
					{
						foreach($userids as $uid)
						{
							$result3 = mysql_query("SELECT * FROM user WHERE id= '$uid'");
							while($row3=mysql_fetch_array($result3))
							{
								$usernames2[]=$row3['username'];
								$firsts2[$row3['username']]=$row3['firstname'];
								$lasts2[$row3['username']]=$row3['lastname'];
							}
						}
					}			
				}
				
				
				
				//Cross Reference the two arrays to see if one of them matches the other one.
				if($_GET['search']!=""&&$_GET['instrument']!=""){
					if(!empty($usernames3))
					{
						foreach($usernames3 as $un)
						{
							if(in_array($un, $usernames2))
							{
								$usernames[]=$un;
								$firsts[$un]=$firsts3[$un];
								$lasts[$un]=$lasts3[$un];
							}
						}
					}
					if(!empty($usernames2))
					{
						foreach($usernames2 as $un)
						{
							if(in_array($un, $usernames3)&&!in_array($un, $usernames))
							{
								$usernames[]=$un;
								$firsts[$un]=$firsts3[$un];
								$lasts[$un]=$lasts3[$un];							
							}
						}
					}
				}
				elseif($_GET['search']!="")
				{
					if(!empty($usernames3))
					{
						foreach($usernames3 as $un)
						{
							$usernames[]=$un;
							$firsts[$un]=$firsts3[$un];
							$lasts[$un]=$lasts3[$un];
						}
					}
				}
				elseif($_GET['instrument']!="")
				{
					if(!empty($usernames2))
					{
						foreach($usernames2 as $un)
						{	
							$usernames[]=$un;
							$firsts[$un]=$firsts2[$un];
							$lasts[$un]=$lasts2[$un];
						}
					}
				}
				
				if(!empty($usernames))
				{
					foreach($usernames as $item)
					{
						echo '<a href="profile.php?u='.$item.'"><div class="diritem '.$diritem.'" >&bull; &nbsp; '.$firsts[$item].' '.$lasts[$item].'</div></a>';
						$diritem = ($diritem == "diritem1" ? "diritem2" : "diritem1");
					}
				}
				else echo '<div class="diritem" >No results found!</div>';
			}
			else
			{
				$query = "SELECT * FROM user";
				$result = mysql_query($query);
				while($row = mysql_fetch_array($result))
				{
					$usernames[] = $row["username"];
					$firsts[$row["username"]] =  $row["firstname"];
					$lasts[$row["username"]] =  $row["lastname"];			
				}
				sort($usernames);
				foreach($usernames as $item)
				{
					echo '<a href="profile.php?u='.$item.'"><div class="diritem '.$diritem.'" >&bull; &nbsp; '.$firsts[$item].' '.$lasts[$item].'</div></a>';
					$diritem = ($diritem == "diritem1" ? "diritem2" : "diritem1");
				}
			}
			echo '</div>';
			?>
			</div>		
		</div>
	</div>
	<?php 
	include_once("Footer.php");
	?>
</body>
</html>