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
		<div id="logins">
			<?php if(isset($_COOKIE['mu_user'])) {
				echo '<a href="logout.php">Log Out</a>';
			} else {	
				echo '<a href="?page=login">Log In</a>';
				echo '<a href="?page=register">Register</a>';
			}?>
		</div>
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
				<a href="?page=profile&id=<?php echo $_COOKIE['mu_id']; ?>" class="<?php if($page=="profile") echo 'selected '; ?>">Profile</a>
				<a href="/" class="<?php if($page=="") echo 'selected '; ?>">Home</a>
				<?php } ?>
			</div><!-- Nav-Bar -->
			<a id="h-logo" href="/"></a><!-- H-Logo -->
		</div><!-- Inner Header -->
	</div><!-- Header -->
	<div id="main">
		<div id="sidebar">
			<div style="padding:10px; 0px; font-weight:bold;">
				<script src="http://widgets.twimg.com/j/2/widget.js"></script>
				<script>
				new TWTR.Widget({
				  version: 2,
				  type: 'profile',
				  rpp: 4,
				  interval: 30000,
				  width: 'auto',
				  height: 300,
				  theme: {
				    shell: {
				      background: '#336896',
				      color: '#ffffff'
				    },
				    tweets: {
				      background: '#eeeeee',
				      color: '#333333',
				      links: '#336896'
				    }
				  },
				  features: {
				    scrollbar: true,
				    loop: false,
				    live: true,
				    behavior: 'all'
				  }
				}).render().setUser('middmusic').start();
				</script>			
			</div>
		</div><!-- Sidebar -->
		<div id="main-content">
			<div id="content" class="home-content">
				<div class="large-section-title">Welcome!</div>
				<p>Middlebury Music United is an organizations for student musicians at Middlebury College. This website provides profiles for all student musicians, bands and Djs, a calendar of student shows on campus and tools for musicians to network and book time in our practice space and recording studio.</p>
				<p>If you’re a musician at midd, please <a href="?page=register">sign up</a>.</p>
				<p>Everyone else, feel free to browse performers or see the <a href="?page=calendar">full events calendar</a>.</p>
				<p>Thanks for stopping by. Please let us know if you have any questions, comments or ideas.</p>
				<div class="large-section-title">Upcoming Events</div>
				<?php 
					$evts = getUpcomingEvents();
					if(!empty($evts)) {
						foreach($evts as $e) {
							$ev = new Event($e['id']);
							$v = new Venue($ev->venueid);
							//print_r($ev);
							echo '<p><a href="?page=profile&event='.$ev->id.'" style="font-weight:bold;">'.$ev->name.'</a> at '.$v->name.', '.date('F j, Y h:m a',$ev->starttime).'. '.$ev->description.'</p>';
						}
					} else {
						echo '<p>No upcoming events!</p>';
					}
				?>
			</div>
		</div><!-- Main Content -->
		<div class="clear"></div><!-- clear -->
	</div><!-- Main -->
	<div id="footer">
		Middlebury Music United. Copyright &copy; 2011 <a href="//twitter.com/willpots" target="_blank" title="@willpots">Will Potter</a>.
	</div>
</div><!-- Container -->