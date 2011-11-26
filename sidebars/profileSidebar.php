<?php 
if(isset($_GET['id'])) $id = $_GET['id'];
else if(isset($_COOKIE['mu_id'])) $id = $_COOKIE['mu_id'];
else $id = NULL;
$u = new User($id);
$ui = getUserInfo($id);
$bands = getUserBands($id);
	

if($ui!=false) {
?>
<div id="create-buttons" class="sidebar-widget">
	<a href="?page=create&band" class="create-button">Form a Band</a>
	<a href="?page=edit" class="create-button">Edit my Profile</a>
	<a href="?page=calendar" class="create-button">Create an Event</a>
</div>
<div id="search-form" class="sidebar-widget">
	<label for="s" class="sidebar-title">SEARCH MUSICIANS<br>
	<input type="text" onkeyup="searchFor(event, this.value, 'musicians')" class="field" autocomplete="off" name="s" id="s" <?php if(isset($_GET['q'])) echo 'value="'.$_GET['q'].'"'; ?>
placeholder="Search" />
	</label>
</div><!-- Search form -->
<?php if(!isset($_GET['id'])) { ?>
<div id="about-me" class="sidebar-widget">
	<div class="sidebar-title">ABOUT ME</div>
	<div class="sidebar-widget-content">
	<?php 
		echo viewString($u->info);
	?>
	</div>
</div><!-- about-me -->
<?php } ?>

<div id="associated-bands" class="sidebar-widget">
	<div class="sidebar-title">ASSOCIATED BANDS</div>
	<div class="sidebar-widget-content">
	<?php
		if($bands!=false) {
			foreach($u->bands as $a) {
				echo '<a href="?page=profile&band='.$a->id.'" class="sidebar-act">'.$a->name.'</a>';
				$i=0;
				if($a->users!=false&&count($a->users)>1) {
					echo '<div class="sidebar-act-members">';
					foreach($a->users as $m) {
						$u2 = new User($m);
						echo '<a href="?page=profile&id='.$u2->id.'" class="sidebar-member">'.$u2->firstname.' '.$u2->lastname.'</a>';
						$i++;
						if($i<count($a->users)) echo ', ';
					}
					echo '</div>';
				}
			}
		} else {
			echo $u->firstname." is not part of any bands.";
		}
	?>
	</div>
</div><!-- associated bands -->

<div id="upcoming-events" class="sidebar-widget">
	<div class="sidebar-title">UPCOMING EVENTS</div>
	<div class="sidebar-widget-content">
		<?php
		//$evts = getUpcomingEvents();
		if($u->events!=false){
			foreach($u->events as $e) {
				echo '<div class="upcoming-event">';
				echo '<a class="sidebar-act" href="?page=profile&event='.$e->id.'">'.date('n/j',$e->starttime).' - '.$e->name.'</a>';
				echo '</div>';
			}
		} else {
			echo $u->firstname." is not part of any events.";
		}
		?>	
	</div>
</div><!-- upcoming events -->

<div id="venues" class="sidebar-widget">
	<div class="sidebar-title">VENUES</div>
	<div class="sidebar-widget-content">
		<?php
		$venues = getUserVenues($id);
		if($venues!=false){
			foreach($venues as $e) {
				echo '<div class="upcoming-event">';
				echo '<a class="sidebar-act" href="?page=profile&venue='.$e['id'].'">'.$e['name'].'</a>';
				echo '</div>';
			}
		} else {
			echo $u->firstname." is not associated with any venues.";
		}
		?>
	</div>
</div>
<?php if(isset($_COOKIE['mu_id'])) { ?>
<?php if(isset($_GET['band'])&&($me->canEdit($_GET['band'],'band')||is_admin())) { ?>
<div id="manage-profile" class="sidebar-widget">
	<div class="sidebar-title center"><a href="?page=edit&band=<?php echo $_GET['band']; ?>" class="blue-button">EDIT BAND PROFILE</a></div>
</div>
<?php } else if(isset($_GET['venue'])&&is_admin()) { ?>
<div id="manage-profile" class="sidebar-widget">
	<div class="sidebar-title center"><a href="?page=edit&venue=<?php echo $_GET['venue']; ?>" class="blue-button">EDIT VENUE PROFILE</a></div>
</div>
<?php } else if(isset($_GET['event'])&&($me->canEdit($_GET['event'],'event')||is_admin())) { ?>
<div id="manage-profile" class="sidebar-widget">
	<div class="sidebar-title center"><a href="?page=edit&event=<?php echo $_GET['event']; ?>" class="blue-button">EDIT EVENT DETAILS</a></div>
</div>
<?php } else if(isset($_GET['id'])&&$_GET['id']==$_COOKIE['mu_id']) { ?>
<div id="manage-profile" class="sidebar-widget">
	<div class="sidebar-title center"><a href="?page=edit" class="blue-button">EDIT MY PROFILE</a></div>
</div>
<?php } else { ?>
<div id="manage-profile" class="sidebar-widget">
	<div class="sidebar-title center"><a href="?page=create&band" class="blue-button">FORM A BAND</a></div>
</div>
<?php	}
	}
} else { ?>
<div id="profile-info" class="sidebar-widget">
	<div class="sidebar-title center">Welcome to Midd Music.</div>
	<div class="sidebar-widget-content">We are Midd Music United, formerly the Middlebury Musician's Guild.</div>
</div>
<?php 
$events = getUpcomingEvents();
?>
<div id="upcoming-events" class="sidebar-widget">
	<div class="sidebar-title">UPCOMING EVENTS</div>
	<div class="sidebar-widget-content">
	<?php 
	if(!empty($events)) {
		foreach($events as $event) {
			$e=new Event($event['id']);
			echo '<div>'.date('n/j',$e->starttime).' - <a href="?page=profile&event='.$e->id.'">'.$e->name.'</a></div>';
		}
	}
	?>
	</div>
</div><!-- upcoming events -->

<?php } ?>