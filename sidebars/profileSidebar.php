<?php 
if(isset($_GET['id'])) $id = $_GET['id'];
else if(isset($_COOKIE['mu_id'])) $id = $_COOKIE['mu_id'];
else $id = NULL;

$ui = getUserInfo($id);
$bands = getUserBands($id);
	

if($ui!=false) {
?>
<div id="search-form" class="sidebar-widget">
	<label for="s" class="sidebar-title">SEARCH MUSICIANS<br>
	<input type="text" onkeyup="searchFor(event, this.value, 'musicians');" class="field" autocomplete="off" name="s" id="s" <?php if(isset($_GET['q'])) echo 'value="'.$_GET['q'].'"'; ?>
placeholder="Search" />
	</label>
</div><!-- Search form -->
<?php if(!isset($_GET['id'])) { ?>
<div id="about-me" class="sidebar-widget">
	<div class="sidebar-title">ABOUT</div>
	<div class="sidebar-widget-content">
	<?php 
		echo $ui['info'];
	?>
	</div>
</div><!-- about-me -->
<?php } ?>

<div id="associated-bands" class="sidebar-widget">
	<div class="sidebar-title">ASSOCIATED bands</div>
	<div class="sidebar-widget-content">
	<?php
		if($bands!=false) {
			foreach($bands as $a) {
				$mem = getActMembers($a['id']);
				echo '<a href="" class="sidebar-act">'.$a['name'].'</a>';
				$i=0;
				if($mem!=false&&count($mem)>1) {
					echo '<div class="sidebar-act-members">';
					foreach($mem as $m) {
						echo '<a href="?page=profile&id='.$m['id'].'" class="sidebar-member">'.$m['firstname'].' '.$m['lastname'].'</a>';
						$i++;
						if($i<count($mem)) echo ', ';
					}
					echo '</div>';
				}
			}
		} else {
			echo $ui['firstname']." is not part of any bands.";
		}
	?>
	</div>
</div><!-- associated bands -->

<div id="upcoming-events" class="sidebar-widget">
	<div class="sidebar-title">UPCOMING EVENTS</div>
		<?php
		$evts = getUpcomingEvents();
		if($evts!=false){
			foreach($evts as $e) {
				echo '<div class="upcoming-event">';
				echo $e['name'];
				echo '</div>';
			}
		}
		?>
	<div class="sidebar-widget-content">
	
	</div>
</div><!-- upcoming events -->

<div id="venues" class="sidebar-widget">
	<div class="sidebar-title">VENUES</div>
	<div class="sidebar-widget-content">
	
	</div>
</div>

<div id="manage-profile" class="sidebar-widget">
	<div class="sidebar-title center"><a href="?page=edit">EDIT MY PROFILE</a></div>
</div>
<?php } ?>