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
<link rel="stylesheet" type="text/css" href="style.css">

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

if (!$con)
{
	die('Could not connect: ' . mysql_error());
}
mysql_select_db($dbSchema, $con);


?>		
		</div>
		</div>
	</div>
	<?php 
	include_once("Footer.php");
	?>
</body>
</html>