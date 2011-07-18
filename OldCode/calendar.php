<?php  
/***************************************************************************
 * Middlebury Music United 
 * This code is proprietary and property of William S. Potter.
 * It has been licensed for use to Middlebury College in this installation.
 * Use of this code requires consent from William S. Potter
 * wp@punkypond.com
 ***************************************************************************/
include_once("LocalSettings.php");
$con = mysql_connect($dbHost,$dbUser,$dbPass);						
if (!$con) die('Could not connect: ' . mysql_error());
mysql_select_db($dbSchema, $con);
?>
<!DOCTYPE html>
<html>
<head>
<title>Middlebury Music United | Calendar</title>
<link rel="stylesheet" type="text/css" href="style.css">

<script>
function show_confirm(eventid,userid)
{
	var b=confirm("Are you sure you want to delete this event?");
	if(b == true)
	{
		var locationstring = '?delete='+eventid+'&u='+userid;
		window.location=locationstring;
	}

}

</script>
</head>
<body>
	<div id="wrapper">
		<?php 
		include_once("LoginBar.php");
		?>
		<div id="content">
			<div id="header"><a href="index.php"><img src="mmuweb.jpg" alt=""></a></div>

			<?php
			//Create User Attending
			if(isset($_REQUEST['attend'])&&isset($_REQUEST['u'])&&isset($_COOKIE['mu_user']))
			{
				$attend = $_REQUEST['attend'];
				$u = $_REQUEST['u'];
				$result = mysql_query("SELECT * FROM userevent WHERE userid='$u' AND eventid='$attend'");
				if(mysql_num_rows($result)==0&&$_REQUEST['u']==$_COOKIE['mu_id'])
				{
					if(mysql_query("INSERT INTO userevent (userid, eventid) VALUES ('$u', '$attend')"))
					{
						echo '<script>window.location=\'?id='.$attend.'\'</script>';
					}
				}
			}
			//Remove User Attending
			elseif(isset($_REQUEST["remove"])&&isset($_REQUEST["u"])&&isset($_COOKIE['mu_user']))
			{
				$remove=$_REQUEST["remove"];
				$u=$_REQUEST["u"];
				if($u == $_COOKIE["mu_id"])
				{
					if(mysql_query("DELETE FROM userevent WHERE eventid='$remove' AND userid='$u'"))
					{
						echo '<script>window.location=\'?id='.$remove.'\'</script>';
					}
				}
			}
			//Delete Event
			elseif(isset($_REQUEST["delete"])&&isset($_REQUEST["u"])&&isset($_COOKIE['mu_id']))
			{
				$delete=$_REQUEST["delete"];
				$u=$_REQUEST["u"];
				if($u == $_COOKIE["mu_id"])
				{
					if(mysql_query("DELETE FROM userevent WHERE eventid='$delete'") && mysql_query("DELETE FROM events WHERE id='$delete'"))
					{
						echo '<script>window.location=\'calendar.php\'</script>';
					}
				}
			}
			//Edit Event/Create Event
			elseif(isset($_REQUEST["edit"])&&isset($_COOKIE["mu_user"]))
			{
				if($_REQUEST["edit"] == "")
				{
					if(isset($_POST['SUBMITEVENT']))
					{
						$name = $_POST['name'];
						$description = $_POST['description'];
						$category = $_POST['category'];
						$createdby = $_COOKIE['mu_user'];
						$location = $_POST['location'];
						
						if($_POST['s_AMPM']='PM')
						{
							if($_POST['s_hour'] != 12) { $s_hour=$_POST['s_hour']+12; }
							else $s_hour = 12;
						}
						if($_POST['s_AMPM']='AM' && $_POST['s_hour']==12)
						{
							$s_hour = 0;
						}
						$starttime = mktime($s_hour, $_POST['s_minute'], 0, $_POST['month'], $_POST['day'], $_POST['year']);
						
						if(mysql_query("INSERT INTO events (name, description, category, createdby, starttime, location) VALUES ('$name', '$description', '$category', '$createdby', '$starttime', '$location')")) echo '<script>window.location = "calendar.php";</script>';
						
					}
					else
					{
						//Create an Event
						echo '<h3>Create an Event</h3>';
						echo '<a href="calendar.php">&crarr;&nbsp;Back to Month</a><br><br>';
						$month = date('n', time());
						$day = date('j', time());
						$year = date('Y', time());
						$hour = date('G', time());
						$minute = date('i', time());
						?>
						<div id="eventform">
						<form action="calendar.php?edit" method="post">
						
						Event Name: <input type="text" size="45" name="name"/><br>
						Month: 	<select name="month">
									<option <?php if($month==1) echo ' selected="selected" '; ?>value="1">January</option>
									<option <?php if($month==2) echo ' selected="selected" '; ?>value="2">February</option>
									<option <?php if($month==3) echo ' selected="selected" '; ?>value="3">March</option>
									<option <?php if($month==4) echo ' selected="selected" '; ?>value="4">April</option>
									<option <?php if($month==5) echo ' selected="selected" '; ?>value="5">May</option>
									<option <?php if($month==6) echo ' selected="selected" '; ?>value="6">June</option>
									<option <?php if($month==7) echo ' selected="selected" '; ?>value="7">July</option>
									<option <?php if($month==8) echo ' selected="selected" '; ?>value="8">August</option>
									<option <?php if($month==9) echo ' selected="selected" '; ?>value="9">September</option>
									<option <?php if($month==10) echo ' selected="selected" '; ?>value="10">October</option>
									<option <?php if($month==11) echo ' selected="selected" '; ?>value="11">November</option>
									<option <?php if($month==12) echo ' selected="selected" '; ?>value="12">December</option>
									</select>
							Day: 	<select name="day">
									<option <?php if($day==1) echo ' selected="selected" '; ?> value="1">1</option>
									<option <?php if($day==2) echo ' selected="selected" '; ?> value="2">2</option>
									<option <?php if($day==3) echo ' selected="selected" '; ?> value="3">3</option>
									<option <?php if($day==4) echo ' selected="selected" '; ?> value="4">4</option>
									<option <?php if($day==5) echo ' selected="selected" '; ?> value="5">5</option>
									<option <?php if($day==6) echo ' selected="selected" '; ?> value="6">6</option>
									<option <?php if($day==7) echo ' selected="selected" '; ?> value="7">7</option>
									<option <?php if($day==8) echo ' selected="selected" '; ?> value="8">8</option>
									<option <?php if($day==9) echo ' selected="selected" '; ?> value="9">9</option>
									<option <?php if($day==10) echo ' selected="selected" '; ?> value="10">10</option>
									<option <?php if($day==11) echo ' selected="selected" '; ?> value="11">11</option>
									<option <?php if($day==12) echo ' selected="selected" '; ?> value="12">12</option>
									<option <?php if($day==13) echo ' selected="selected" '; ?> value="13">13</option>
									<option <?php if($day==14) echo ' selected="selected" '; ?> value="14">14</option>
									<option <?php if($day==15) echo ' selected="selected" '; ?> value="15">15</option>
									<option <?php if($day==16) echo ' selected="selected" '; ?> value="16">16</option>
									<option <?php if($day==17) echo ' selected="selected" '; ?> value="17">17</option>
									<option <?php if($day==18) echo ' selected="selected" '; ?> value="18">18</option>
									<option <?php if($day==19) echo ' selected="selected" '; ?> value="19">19</option>
									<option <?php if($day==20) echo ' selected="selected" '; ?> value="20">20</option>
									<option <?php if($day==21) echo ' selected="selected" '; ?> value="21">21</option>
									<option <?php if($day==22) echo ' selected="selected" '; ?> value="22">22</option>
									<option <?php if($day==23) echo ' selected="selected" '; ?> value="23">23</option>
									<option <?php if($day==24) echo ' selected="selected" '; ?> value="24">24</option>
									<option <?php if($day==25) echo ' selected="selected" '; ?> value="25">25</option>
									<option <?php if($day==26) echo ' selected="selected" '; ?> value="26">26</option>
									<option <?php if($day==27) echo ' selected="selected" '; ?> value="27">27</option>
									<option <?php if($day==28) echo ' selected="selected" '; ?> value="28">28</option>
									<option <?php if($day==29) echo ' selected="selected" '; ?> value="29">29</option>
									<option <?php if($day==30) echo ' selected="selected" '; ?> value="30">30</option>
									<option <?php if($day==31) echo ' selected="selected" '; ?> value="31">31</option>
									</select>
							Year:	<select name="year">
									<option <?php if($year==2011) echo ' selected="selected" '; ?> value="2011">2011</option>
									<option <?php if($year==2012) echo ' selected="selected" '; ?> value="2012">2012</option>
									<option <?php if($year==2013) echo ' selected="selected" '; ?> value="2013">2013</option>
									</select>
									<br>
							Start Time: <select name="s_hour">
									<option <?php if($hour==1||$hour==13) echo ' selected="selected" '; ?> value="1">1</option>
									<option <?php if($hour==2||$hour==14) echo ' selected="selected" '; ?> value="2">2</option>
									<option <?php if($hour==3||$hour==15) echo ' selected="selected" '; ?> value="3">3</option>
									<option <?php if($hour==4||$hour==16) echo ' selected="selected" '; ?> value="4">4</option>
									<option <?php if($hour==5||$hour==17) echo ' selected="selected" '; ?> value="5">5</option>
									<option <?php if($hour==6||$hour==18) echo ' selected="selected" '; ?> value="6">6</option>
									<option <?php if($hour==7||$hour==19) echo ' selected="selected" '; ?> value="7">7</option>
									<option <?php if($hour==8||$hour==20) echo ' selected="selected" '; ?> value="8">8</option>
									<option <?php if($hour==9||$hour==21) echo ' selected="selected" '; ?> value="9">9</option>
									<option <?php if($hour==10||$hour==22) echo ' selected="selected" '; ?> value="10">10</option>
									<option <?php if($hour==11||$hour==23) echo ' selected="selected" '; ?> value="11">11</option>
									<option <?php if($hour==12||$hour==0) echo ' selected="selected" '; ?> value="12">12</option>
									</select>:
									<select name="s_minute">
									<option <?php if($minute==00) echo ' selected="selected" '; ?> value="0">00</option>
									<option <?php if($minute==15) echo ' selected="selected" '; ?> value="15">15</option>
									<option <?php if($minute==30) echo ' selected="selected" '; ?> value="30">30</option>
									<option <?php if($minute==45) echo ' selected="selected" '; ?> value="45">45</option>
									</select>
									<select name="s_AMPM">
									<option <?php if($hour<12) echo ' selected="selected" '; ?>value="AM">AM</option>
									<option <?php if($hour>=12) echo ' selected="selected" '; ?>value="PM">PM</option>
									</select><br>
						Location: <input type="text" size="45" name="location" /><br>
						Description:<br>
						<textarea name="description" rows="10" cols="94"></textarea>
						Category: <select name="category">
								<option value="recording">Recording Studio</option>
								<option value="practice">Practice</option>
								<option value="concert">Concert/Performance</option>
								<option value="audition">Audition</option>
								<option value="other">Other</option>
						</select><br>
						<input type="submit" name="SUBMITEVENT">&nbsp;<input type="button" value="Cancel" onclick="window.location = 'calendar.php'"> 
						</form>
						</div>
					
				<?php
					}				
				}
				else
				{
					if(isset($_POST['SUBMITEVENT']))
					{
						$id = $_REQUEST['edit'];
						$name = $_POST['name'];
						$description = $_POST['description'];
						$category = $_POST['category'];
						$createdby = $_COOKIE['mu_user'];
						$location = $_POST['location'];
						
						if($_POST['s_AMPM']='PM')
						{
							if($_POST['s_hour'] != 12) { $s_hour=$_POST['s_hour']+12; }
							else $s_hour = 12;
						}
						if($_POST['s_AMPM']='AM' && $_POST['s_hour']==12)
						{
							$s_hour = 0;
						}
						$starttime = mktime($s_hour, $_POST['s_minute'], 0, $_POST['month'], $_POST['day'], $_POST['year']);
						
						if(mysql_query("UPDATE events SET name = '$name', description = '$description', category = '$category', location='$location', starttime= '$starttime' WHERE id = '$id'")) echo '<script>window.location = "?id='.$id.'";</script>';
						
					}
					else
					{
						$id = $_REQUEST['edit'];
						$result = mysql_query("SELECT * FROM events WHERE id = '$id'");
						$starttime = 0;
						$createdby = "";
						while($row = mysql_fetch_array($result))
						{
							$name = $row['name'];
							$description = $row['description'];
							$starttime = $row['starttime'];
							$category = $row['category'];
							$location = $row['location'];
							$createdby = $row['createdby'];
						}
						$month = date('n', $starttime);
						$day = date('j', $starttime);
						$year = date('Y', $starttime);
						$hour = date('G', $starttime);
						$minute = date('i', $starttime);
						if(mysql_num_rows($result) == 1 && $createdby == $_COOKIE['mu_user']) 
						{
							//Create an Event
							echo '<h3>Create an Event</h3>';
							echo '<a href="calendar.php">&crarr;&nbsp;Back to Month</a><br><br>';
							?>
							<div id="eventform">
							<form action="calendar.php?edit=<?php echo $id; ?>" method="post">
							Event Name: <input type="text" size="45" name="name" value="<?php echo $name; ?>"/><br>
							Month: 	<select name="month">
									<option <?php if($month==1) echo ' selected="selected" '; ?>value="1">January</option>
									<option <?php if($month==2) echo ' selected="selected" '; ?>value="2">February</option>
									<option <?php if($month==3) echo ' selected="selected" '; ?>value="3">March</option>
									<option <?php if($month==4) echo ' selected="selected" '; ?>value="4">April</option>
									<option <?php if($month==5) echo ' selected="selected" '; ?>value="5">May</option>
									<option <?php if($month==6) echo ' selected="selected" '; ?>value="6">June</option>
									<option <?php if($month==7) echo ' selected="selected" '; ?>value="7">July</option>
									<option <?php if($month==8) echo ' selected="selected" '; ?>value="8">August</option>
									<option <?php if($month==9) echo ' selected="selected" '; ?>value="9">September</option>
									<option <?php if($month==10) echo ' selected="selected" '; ?>value="10">October</option>
									<option <?php if($month==11) echo ' selected="selected" '; ?>value="11">November</option>
									<option <?php if($month==12) echo ' selected="selected" '; ?>value="12">December</option>
									</select>
							Day: 	<select name="day">
									<option <?php if($day==1) echo ' selected="selected" '; ?> value="1">1</option>
									<option <?php if($day==2) echo ' selected="selected" '; ?> value="2">2</option>
									<option <?php if($day==3) echo ' selected="selected" '; ?> value="3">3</option>
									<option <?php if($day==4) echo ' selected="selected" '; ?> value="4">4</option>
									<option <?php if($day==5) echo ' selected="selected" '; ?> value="5">5</option>
									<option <?php if($day==6) echo ' selected="selected" '; ?> value="6">6</option>
									<option <?php if($day==7) echo ' selected="selected" '; ?> value="7">7</option>
									<option <?php if($day==8) echo ' selected="selected" '; ?> value="8">8</option>
									<option <?php if($day==9) echo ' selected="selected" '; ?> value="9">9</option>
									<option <?php if($day==10) echo ' selected="selected" '; ?> value="10">10</option>
									<option <?php if($day==11) echo ' selected="selected" '; ?> value="11">11</option>
									<option <?php if($day==12) echo ' selected="selected" '; ?> value="12">12</option>
									<option <?php if($day==13) echo ' selected="selected" '; ?> value="13">13</option>
									<option <?php if($day==14) echo ' selected="selected" '; ?> value="14">14</option>
									<option <?php if($day==15) echo ' selected="selected" '; ?> value="15">15</option>
									<option <?php if($day==16) echo ' selected="selected" '; ?> value="16">16</option>
									<option <?php if($day==17) echo ' selected="selected" '; ?> value="17">17</option>
									<option <?php if($day==18) echo ' selected="selected" '; ?> value="18">18</option>
									<option <?php if($day==19) echo ' selected="selected" '; ?> value="19">19</option>
									<option <?php if($day==20) echo ' selected="selected" '; ?> value="20">20</option>
									<option <?php if($day==21) echo ' selected="selected" '; ?> value="21">21</option>
									<option <?php if($day==22) echo ' selected="selected" '; ?> value="22">22</option>
									<option <?php if($day==23) echo ' selected="selected" '; ?> value="23">23</option>
									<option <?php if($day==24) echo ' selected="selected" '; ?> value="24">24</option>
									<option <?php if($day==25) echo ' selected="selected" '; ?> value="25">25</option>
									<option <?php if($day==26) echo ' selected="selected" '; ?> value="26">26</option>
									<option <?php if($day==27) echo ' selected="selected" '; ?> value="27">27</option>
									<option <?php if($day==28) echo ' selected="selected" '; ?> value="28">28</option>
									<option <?php if($day==29) echo ' selected="selected" '; ?> value="29">29</option>
									<option <?php if($day==30) echo ' selected="selected" '; ?> value="30">30</option>
									<option <?php if($day==31) echo ' selected="selected" '; ?> value="31">31</option>
									</select>
							Year:	<select name="year">
									<option <?php if($year==2011) echo ' selected="selected" '; ?> value="2011">2011</option>
									<option <?php if($year==2012) echo ' selected="selected" '; ?> value="2012">2012</option>
									<option <?php if($year==2013) echo ' selected="selected" '; ?> value="2013">2013</option>
									</select>
									<br>
							Start Time: <select name="s_hour">
									<option <?php if($hour==1||$hour==13) echo ' selected="selected" '; ?> value="1">1</option>
									<option <?php if($hour==2||$hour==14) echo ' selected="selected" '; ?> value="2">2</option>
									<option <?php if($hour==3||$hour==15) echo ' selected="selected" '; ?> value="3">3</option>
									<option <?php if($hour==4||$hour==16) echo ' selected="selected" '; ?> value="4">4</option>
									<option <?php if($hour==5||$hour==17) echo ' selected="selected" '; ?> value="5">5</option>
									<option <?php if($hour==6||$hour==18) echo ' selected="selected" '; ?> value="6">6</option>
									<option <?php if($hour==7||$hour==19) echo ' selected="selected" '; ?> value="7">7</option>
									<option <?php if($hour==8||$hour==20) echo ' selected="selected" '; ?> value="8">8</option>
									<option <?php if($hour==9||$hour==21) echo ' selected="selected" '; ?> value="9">9</option>
									<option <?php if($hour==10||$hour==22) echo ' selected="selected" '; ?> value="10">10</option>
									<option <?php if($hour==11||$hour==23) echo ' selected="selected" '; ?> value="11">11</option>
									<option <?php if($hour==12||$hour==0) echo ' selected="selected" '; ?> value="12">12</option>
									</select>:
									<select name="s_minute">
									<option <?php if($minute==00) echo ' selected="selected" '; ?> value="0">00</option>
									<option <?php if($minute==15) echo ' selected="selected" '; ?> value="15">15</option>
									<option <?php if($minute==30) echo ' selected="selected" '; ?> value="30">30</option>
									<option <?php if($minute==45) echo ' selected="selected" '; ?> value="45">45</option>
									</select>
									<select name="s_AMPM">
									<option <?php if($hour<12) echo ' selected="selected" '; ?>value="AM">AM</option>
									<option <?php if($hour>=12) echo ' selected="selected" '; ?>value="PM">PM</option>
									</select><br>
	
							Location: <input type="text" size="45" name="location" value="<?php echo $location; ?>" /><br>
							Description:<br>
							<textarea name="description" rows="10" cols="94"><?php echo $description; ?></textarea>
							Category: <select name="category">
									<option <?php if($category=='recording') echo ' selected="selected" '; ?> value="recording">Recording Studio</option>
									<option <?php if($category=='practice') echo ' selected="selected" '; ?> value="practice">Practice</option>
									<option <?php if($category=='concert') echo ' selected="selected" '; ?> value="concert">Concert/Performance</option>
									<option <?php if($category=='audition') echo ' selected="selected" '; ?> value="audition">Audition</option>
									<option <?php if($category=='other') echo ' selected="selected" '; ?> value="other">Other</option>
							</select><br>
							<input type="submit" name="SUBMITEVENT">&nbsp;<input type="button" value="Cancel" onclick="window.location = 'calendar.php'"> 
							</form>
							</div>
						
					<?php
						}
						elseif($createdby != $_COOKIE['mu_user'] || $createdby != "")
						{
							echo '<p>You do not have permission to edit this event!. Please email <a href="mailto:'.$createdby.'@middlebury.edu">'.$createdby.'@midd... to suggest changes.</p>';
						}
						else
						{
							echo '<p>There is no event with that identifier.</p>';
						}
					}				
				}
			}
			//Show Day View
			elseif(isset($_REQUEST['day']))
			{
				$today = $_REQUEST['day'];
				$endofday = mktime(0,0,0,date('m',$today),date('d',$today)+1,date('Y',$today));
				//Show a day view
				echo '<h3>'.date('F j, Y', $_REQUEST['day']).'</h3>';
				echo '<a href="calendar.php">&crarr;&nbsp;Back to Month</a><br><br>';
				if(isset($_COOKIE['mu_user'])) echo '<a class="button" href="?edit">Create Event</a><br><br>';
				$result = mysql_query("SELECT * FROM events WHERE starttime BETWEEN '$today' AND '$endofday'");
				if(mysql_num_rows($result)!=0)
				{
					while($row = mysql_fetch_array($result))
					{
						$times[] = $row['starttime'];
						$i = $row['starttime'];
						$names[$i] = $row['name'];
						$ids[$i] = $row['id'];
					}
					asort($times);
					foreach($times as $time)
					{
						echo '<a href="?id='.$ids[$time].'"><div class="eventdiv">'.date('g:i a',$time).' - '.$names[$time].'</div></a>';
					}
				}
				else
				{
					echo '<p>No Events are scheduled for this day!</p>';
				}
			}
			//Show Event Details
			elseif(isset($_REQUEST['id']))
			{
				$id = $_REQUEST['id'];
				$result = mysql_query("SELECT * FROM events WHERE id = '$id'");
				if(mysql_num_rows($result) == 1)				
				{
					while($row = mysql_fetch_array($result))
					{
						$name = $row['name'];
						$createdby = $row['createdby'];
						$starttime = $row['starttime'];
						$location = $row['location'];
						$category = $row['category'];
						$description = $row['description'];
					}
					echo '<h3>'.$name.'</h3>';
					echo '<a href="calendar.php">&crarr;&nbsp;Back to Month</a><br>';
					echo '<p>Created by <a href="profile.php?u='.$createdby.'">'.$createdby.'</a></p>';
					echo '<div class="eventinfo">';
					echo '<p>Date: '.date('M d, Y', $starttime).'</p>';
					echo '<p>Start Time: '.date('g:i a', $starttime).'</p>';
					echo '<p>Location: '.$location.'</p>';
					echo '<p>Category: '.ucfirst($category).'</p>';
					echo '<p>Description: '.$description.'</p>';
					if(isset($_COOKIE['mu_user']) && $_COOKIE['mu_user'] == $createdby ) echo '<button onclick="window.location = \'?edit='.$id.'\'">Edit Event</button>';
					if(isset($_COOKIE['mu_user']) && $_COOKIE['mu_user'] == $createdby ) echo '<button onclick="show_confirm('.$id.','.$_COOKIE['mu_id'].')">Delete Event</button>';
					echo '<hr>';
					echo '<h4>Who\'s Attending...</h4>';
					$result = mysql_query("SELECT * FROM userevent WHERE eventid = '$id'");
					$userids[] = array();
					while($row = mysql_fetch_array($result))
					{
						$userids[] = $row['userid'];
					}
					$i = 0;
					$yes = 0;
					$uid = -1;
					if(isset($_COOKIE['mu_id']))
					{$uid = $_COOKIE["mu_id"];}
					if($userids)
					{
						foreach($userids as $userid)
						{
							$result = mysql_query("SELECT * FROM user WHERE id = '$userid'");
							echo '<ul>';
							while($row = mysql_fetch_array($result))
							{
								echo '<li>'.$row['firstname'].' '.$row['lastname'].'</li>';
								$i=1;
								if($userid == $uid) $yes = 1;
							}
							echo '</ul>';
						}
						if($i==0 && isset($_COOKIE["mu_id"])) echo '<p>No one is attending yet!</p>';
						if($yes == 1 && isset($_COOKIE["mu_id"])) echo '<button onclick="window.location = \'?remove='.$id.'&u='.$_COOKIE['mu_id'].'\'">Stop Attending this Event</button>';
						elseif(isset($_COOKIE["mu_id"])) echo '<button type="button" onclick="window.location = \'?attend='.$id.'&u='.$_COOKIE['mu_id'].'\'">Attend this Event</button>';
					}
					echo '</div>';
				}
				else
				{
					echo '<p>Could not pull the event record!</p>';
				}
			}
			else
			{?>
				<h3><a href="calendar.php">Calendar</a></h3>
				<div id="calbody">
				<table align="center" cellspacing="0" cellpadding="5">
				<?php
				//Show Month View
				if(isset($_REQUEST['edit'])) echo '<p>You must be logged in to make an event!</p>';
				if(isset($_REQUEST['month'])) $time = $_REQUEST['month'];
				else $time = $_SERVER['REQUEST_TIME'];
				$month = mktime(0,0,0,date('m', $time),1,date('Y', $time));
				$today = mktime(0,0,0,date('m', $_SERVER['REQUEST_TIME']),date('j', $_SERVER['REQUEST_TIME']),date('Y', $_SERVER['REQUEST_TIME']));
				$presentmonth = $month;
				while( date('l', $month) != "Sunday" )
				{
					$month = $month - (60*60*24);
				}
				$calstart = $month;
				echo '<a href="?month='.mktime(0,0,0,date('m', $time)-1,1,date('Y', $time)).'"><<&nbsp;&nbsp;&nbsp;</a>'.date('F Y', $presentmonth).'<a href="?month='.mktime(0,0,0,date('m', $time)+1,1,date('Y', $time)).'">&nbsp;&nbsp;&nbsp;>></a><br><br>';
				if(isset($_COOKIE['mu_user'])) echo '<a class="button" href="?edit">Create Event</a><br><br>';

				?>
				<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>			
				<?php
				while($calstart <= strtotime("+1 month", $presentmonth))
				{
					$daysleft = 7;
					echo '<tr>';
					while($daysleft > 0)
					{
						if($calstart != $today) echo '<td onclick="window.location = \'?day='.$calstart.'\'">'.date('j', $calstart).'<br>';
						else echo '<td onclick="window.location = \'?day='.$calstart.'\'" class="today">'.date('j', $calstart).'<br>'; 
						$endofday = mktime(0,0,0,date('m',$calstart),date('d',$calstart)+1,date('Y',$calstart));
						$daysleft--;
						$result = mysql_query("SELECT * FROM events WHERE starttime BETWEEN '$calstart' AND '$endofday'");
						if(mysql_num_rows($result) != 0)
						{
							while($row = mysql_fetch_array($result))
							{
								echo '<a class="day" href="calendar.php?id='.$row['id'].'">'.$row['name'].'</a><br>';
							}
						}
						$calstart=$endofday;
						echo '</td>';
					}
					echo '</tr>';
				}?>
				</table>
				</div>
			<?php
			}		
			?>
			
		</div>
	</div>
	<?php 
	include_once("Footer.php");
	?>
</body>
</html>