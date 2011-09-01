<?php
/****************************************************************************
 * Middlebury Music United													*
 * This code is proprietary and property of William S. Potter.				*
 * It has been licensed for use to Middlebury College in this installation. *
 * Use of this code requires consent from William S. Potter					*
 * will@middpoint.com														*
 ***************************************************************************/
if(isset($_GET['page'])) $page = $_GET['page'];
else $page ="";
?>

<div id="container">
	<div id="header">
		<div id="inner-header">
			<div id="nav-bar">
				<?php if(isset($_COOKIE['mu_id'])) { ?>
				<a href="?page=practice" class="<?php if($page=="practice") echo 'selected '; ?>">Practice</a>
				<a href="?page=record" class="<?php if($page=="record") echo 'selected '; ?>">Record</a>
				<?php } ?>
				<a href="?page=calendar" class="<?php if($page=="calendar") echo 'selected '; ?>">Calendar</a>
				<a href="?page=venues" class="<?php if($page=="venues") echo 'selected '; ?>">Venues</a>
				<a href="?page=bands" class="<?php if($page=="bands") echo 'selected '; ?>">Bands/DJs</a>
				<a href="?page=musicians" class="<?php if($page=="musicians") echo 'selected '; ?>">Musicians</a>
				<?php if(isset($_COOKIE['mu_id'])) { ?>
				<a href="?page=profile&id=<?php echo $_COOKIE['mu_id']; ?>" class="<?php if($page=="profile"||$page=="") echo 'selected '; ?>">Profile</a>
				<?php } ?>
			</div><!-- Nav-Bar -->
			<a id="h-logo" href="?page=profile"></a><!-- H-Logo -->
		</div><!-- Inner Header -->
	</div><!-- Header -->
	<div id="main">
		<div id="sidebar">
			<?php
if($page=="profile") {
	include('sidebars/profileSidebar.php');
} else if($page=="compose") {

} else if($page=="edit") {
		include('sidebars/editSidebar.php');
	} else if($page=="calendar"||$page=="practice"||$page=="record") {
		//include('sidebars/calendarSidebar.php');
	} else if($page=="bands"||$page=="musicians"||$page=="venues") {
		include('sidebars/directorySidebar.php');
	} else {
	include('sidebars/profileSidebar.php');
}

?>
		</div><!-- Sidebar -->
		<div id="main-content">
			<?php
if($page=="profile") { //Profile
	include('main/profileMain.php');
} else if($page=="compose") { //Compose
	include('main/composeMain.php');
} else if($page=="login") { //Compose
	include('main/loginMain.php');
} else if($page=="register") { //Register
	include('main/registerMain.php');
} else if($page=="edit") { //Edit (Profile)
	include('main/editMain.php');
} else if($page=="calendar"||$page=="practice"||$page=="record") { //Calendar Views
	include('main/calendarMain.php');
} else if($page=="bands"||$page=="musicians"||$page=="venues") { //Directory Views
	include('main/directoryMain.php');
} else { // Default to Profile View
include('main/profileMain.php');
} 
?>
		</div><!-- Main Content -->
		<div class="clear"></div><!-- clear -->
	</div><!-- Main -->
	<div id="footer">
		Copyright &copy; 2011 <a href="//twitter.com/willpots">Will Potter</a>. Licensed for Exclusive Use by Middlebury Music United.
	</div>
</div><!-- Container -->