<?php 
/* 
	iphone starttime endtime
	ALL EVENTS BETWEEN

	NAME,DESCRIPTION,STARTTIME,ENDTIME,BANDNAME,VENUENAME,LATITUDE,LONGITUDE
*/
require('libs/libMMU.php');

if(isset($_POST['iphone'])) {	
	header("Content-type: text/xml");
	echo '<?xml version="1.0" encoding="UTF-8" ?>';
	echo '<events>'."\n";
	$db = new DBObject;
	$db->getConnection();

	$starttime = $_POST['starttime'];
	$endtime = $_POST['endtime'];
	
	$query = "SELECT * FROM calendar WHERE starttime BETWEEN '$starttime' AND '$endtime'";
	$result = mysql_query($query,$db->Con) or die("Query $query failed because: ".mysql_error());
	
	while($row = mysql_fetch_array($result)) {
		echo '<event>'."\n";
		echo "\t".'<id>'.$row['id'].'</id>'."\n";
		echo "\t".'<name>'.$row['name'].'</name>'."\n";
		echo "\t".'<description>'.$row['description'].'</description>'."\n";
		echo "\t".'<starttime>'.$row['starttime'].'</starttime>'."\n";
		echo "\t".'<endtime>'.$row['endtime'].'</endtime>'."\n";		
		$subquery = "SELECT * FROM venuecalendar WHERE calendarid = '".$row['id']."'";
		$venueresult = mysql_query($subquery,$db->Con) or die("Query $query failed because: ".mysql_error());
		while($subrow=mysql_fetch_array($venueresult)) {
			$venue = new Venue($subrow['venueid']);
			echo "\t".'<venue>'.$venue->name.'</venue>'."\n";
			echo "\t".'<venueid>'.$venue->id.'</venueid>'."\n";
			echo "\t".'<latitude>'.$venue->latitude.'</latitude>'."\n";
			echo "\t".'<longitude>'.$venue->longitude.'</longitude>'."\n";
		}
		$subquery = "SELECT * FROM bandcalendar WHERE calendarid = '".$row['id']."'";
		$subresult = mysql_query($subquery,$db->Con) or die("Query $query failed because: ".mysql_error());
		while($subrow=mysql_fetch_array($subresult)) {
			$band = new Band($subrow['bandid']);
			echo "\t".'<band>'.$band->name.'</band>'."\n";
		}
		echo '</event>'."\n";
	}
	echo '</events>';
} else {
	
?>
<!DOCTYPE html>
<html>
<head>
	<title>Post StartTime</title>
</head>
<body>
	<form action="mobile.php" method="post">
		<input type="hidden" name="iphone" value="iphone">
		<input type="text" name="starttime" placeholder="Starttime" value="1317136942">
		<input type="text" name="endtime" placeholder="Endtime" value="1317914542">	
		<input type="submit" name="submitform" value="Get Data">	
	</form>
</body>
</html>
<?php } ?>
