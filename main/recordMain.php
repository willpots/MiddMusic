<?php 
/****************************************************************************
 * recordMain.php															*
 *																			*
 * Middlebury Music United													*
 * This code is proprietary and property of William S. Potter.				*
 * It has been licensed for use to Middlebury College in this installation.	*
 * Use of this code requires consent from William S. Potter					*
 * will@middpoint.com														*
 ***************************************************************************/
if(isset($_GET['month'])) {
	$month = $_GET['month'];
} else $month = date('n');
if(isset($_GET['day'])) {
	$day = $_GET['day'];
} else $day = date('j');
if(isset($_GET['year'])) {
	$year = $_GET['year'];
} else $year = date('Y');

$month =  mktime(0,0,0,$month,$day,$year);

$calendar = "record";
?>
<div id="calendar">
	<img src="http://middmusic.com/img/loading.gif" alt="Hang on, the calendar is loading!" id="main-loading">
</div>

