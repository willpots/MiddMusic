<?php 
/****************************************************************************
 * Middlebury Music United 																									*
 * This code is proprietary and property of William S. Potter.							*
 * It has been licensed for use to Middlebury College in this installation.	*
 * Use of this code requires consent from William S. Potter									*
 * will@middpoint.com																												*
 ***************************************************************************/
if(isset($_GET['page'])) $page = $_GET['page'];
else $page ="";
?>

<div id="container">
	<div id="header">
		<div id="inner-header">
			<div id="nav-bar">
				<a href="?page=practice" class="<?php if($page=="practice") echo 'selected '; ?>">Practice</a>
				<a href="?page=record" class="<?php if($page=="record") echo 'selected '; ?>">Record</a>
				<a href="?page=calendar" class="<?php if($page=="calendar") echo 'selected '; ?>">Calendar</a>
				<a href="?page=venues" class="<?php if($page=="venues") echo 'selected '; ?>">Venues</a>
				<a href="?page=bands" class="<?php if($page=="bands") echo 'selected '; ?>">Bands/DJs</a>
				<a href="?page=musicians" class="<?php if($page=="musicians") echo 'selected '; ?>">Musicians</a>
				<a href="?page=profile" class="<?php if($page=="profile"||$page=="") echo 'selected '; ?>">Profile</a>
			</div><!-- Nav-Bar -->
			<a id="h-logo" href="/"></a><!-- H-Logo -->
		</div><!-- Inner Header -->
	</div><!-- Header -->
	<div id="main">
		<div id="sidebar">
			<div id="search-form" class="sidebar-widget">
				<label for="s" class="sidebar-title">SEARCH<br>
				<input type="text" class="field" name="s" id="s" placeholder="Search" />
				</label>
			</div><!-- Search form -->
			<?php 
			if($page=="profile") {
				include('sidebars/profileSidebar.php');
			} else if($page=="calendar"||$page=="practice"||$page=="record") {
				include('sidebars/calendarSidebar.php');
			} else if($page=="bands"||$page=="musicians"||$page=="venues") {
				include('sidebars/directorySidebar.php');
			} else {
				include('sidebars/profileSidebar.php');
			}
			
			?>
		</div><!-- Sidebar -->
		<div id="main-content">
			<?php 
			if($page=="profile") {
				include('main/profileMain.php');
			} else if($page=="calendar"||$page=="practice"||$page=="record") {
				include('main/calendarMain.php');
			} else if($page=="bands"||$page=="musicians"||$page=="venues") {
				include('main/directoryMain.php');
			} else {
				include('main/profileMain.php');
			}
			?>
		</div><!-- Main Content -->
		<div class="clear"></div><!-- clear -->
	</div><!-- Main -->
	<div id="footer">
	
	</div>
</div><!-- Container -->