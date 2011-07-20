<?php 
/****************************************************************************
 * Middlebury Music United 																									*
 * This code is proprietary and property of William S. Potter.							*
 * It has been licensed for use to Middlebury College in this installation.	*
 * Use of this code requires consent from William S. Potter									*
 * will@middpoint.com																												*
 ***************************************************************************/
$page = $_GET['page'];
 ?>

<div id="container">
	<div id="header">
		<div id="inner-header">
			<div id="nav-bar">
				<a href="?page=practice">Practice</a>
				<a href="?page=record">Record</a>
				<a href="?page=calendar">Calendar</a>
				<a href="?page=venues">Venues</a>
				<a href="?page=directory&bands">Bands/DJs</a>
				<a href="?page=directory&musicians">Musicians</a>
				<a href="?page=profile" class="selected">Profile</a>
			</div><!-- Nav-Bar -->
			<a id="h-logo"></a><!-- H-Logo -->
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
			} else if($page=="calendar") {
			
			}
			
			?>
		</div><!-- Sidebar -->
		<div id="main-content">
			<?php 
			if($page=="profile") {
				include('main/profileMain.php');
			} else if($page=="main/calendarMain.php") {
			
			}
			?>
		</div><!-- Main Content -->
		<div class="clear"></div><!-- clear -->
	</div><!-- Main -->
</div><!-- Container -->