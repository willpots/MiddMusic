<?php 
if(isset($_GET['id'])) $id = $_GET['id'];
else $id = $_COOKIE['mu_id'];

$ui = getUserInfo($id);
$acts = getUserActs($id);
	


?>
<div id="about-me" class="sidebar-widget">
	<div class="sidebar-title">ABOUT</div>
	<div class="sidebar-widget-content">
	<?php 
		echo $ui['info'];
	?>
	</div>
</div><!-- about-me -->

<div id="associated-acts" class="sidebar-widget">
	<div class="sidebar-title">ASSOCIATED ACTS</div>
	<div class="sidebar-widget-content">
	<?php
		if($acts!=false) {
			foreach($acts as $a) {
				$mem = getActMembers($a['id']);
				echo '<a href="" class="sidebar-act">'.$a['name'].'</a>';
				$i=0;
				if($mem!=false&&count($mem)>1) {
					echo '<div class="sidebar-act-members">';
					foreach($mem as $m) {
						echo '<a href="" class="sidebar-member">'.$m['firstname'].' '.$m['lastname'].'</a>';
						$i++;
						if($i<count($mem)) echo ', ';
					}
					echo '</div>';
				}
			}
		} else {
			echo $ui['firstname']." is not part of any acts.";
		}
	?>
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
	<div class="sidebar-title center"><a href="?page=manage&user">MANAGE MY PROFILE</a></div>
</div>
