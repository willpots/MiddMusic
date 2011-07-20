<?php 
/****************************************************************************
 * calendarMain.php																													*
 *
 * Middlebury Music United 																									*
 * This code is proprietary and property of William S. Potter.							*
 * It has been licensed for use to Middlebury College in this installation.	*
 * Use of this code requires consent from William S. Potter									*
 * will@middpoint.com																												*
 ***************************************************************************/
if(isset($_GET['month'])) {
	$month = $_GET['month'];
} else $month = date('n');

if(isset($_GET['year'])) {
	$year = $_GET['year'];
} else $year = date('Y');

$month =  mktime(0,0,0,$month,1,$year);

if(isset($_GET['id'])) $id = $_GET['id'];
else $id = $_COOKIE['mu_id'];

$ui = getUserInfo($id);
$acts = getUserActs($id);
	


?>
<div id="about-me" class="sidebar-widget">
	<div class="sidebar-title">UPCOMING PERFORMANCES</div>
	<div class="sidebar-widget-content">

	</div>
</div><!-- about-me -->

<div id="associated-acts" class="sidebar-widget">
	<div class="sidebar-title">ASSOCIATED ACTS</div>
	<div class="sidebar-widget-content">

	</div>
</div><!-- associated acts -->

<div id="upcoming-events" class="sidebar-widget">
	<div class="sidebar-title">UPCOMING EVENTS</div>
	<div class="sidebar-widget-content">
	
	</div>
</div><!-- upcoming events -->

<div id="venues" class="sidebar-widget">
	<div class="sidebar-title">VENUES</div>
	<div class="sidebar-widget-content">
	
	</div>
</div>

<div id="manage-profile" class="sidebar-widget">
	<div class="sidebar-title center"><a href="?page=create&event">CREATE AN EVENT</a></div>
</div>
