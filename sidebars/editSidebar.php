<?php 
/***************************************************************************
 * editSidebar.php																			*
 *
 * Middlebury 																					*
 * This code is proprietary and property of William S. Potter.					*
 * It has been licensed for use to Middlebury College in this installation.*
 * Use of this code requires consent from William S. Potter						*
 * will@middpoint.com																		*
 **************************************************************************/
// Alphabetically Sort the Array! Genius!
$results = getUserInstruments($_COOKIE['mu_id']);
if($results!=false) {
	foreach($results as $c=>$key) {
	  $sort_id[] = $key['id'];
	  $sort_name[] = $key['name'];
	}
	array_multisort( $sort_name, SORT_STRING, $results);
}

?>
<div id="search-form" class="sidebar-widget">
	<label for="s" class="sidebar-title">ADD INSTRUMENTS<br>

	<input type="text" onkeyup="instrumentSearch(event,this.value)" autocomplete="off" class="field" name="s" id="s" <?php if(isset($_GET['q'])) echo 'value="'.$_GET['q'].'"'; ?>
placeholder="Instrument" />
	</label>
	<div id="inst-search-results"></div>
</div><!-- Search form -->

<div id="instrument-list" class="sidebar-widget">
	<div class="sidebar-title">YOUR INSTRUMENTS</div>
	<div class="sidebar-widget-content">
	<?php
	if($results!=false) {
		foreach($results as $r) {
			echo '<div class="instrument">';
			echo '<a class="delete-inst" onclick="removeInstrument(this)" id="'.$r['id'].'">X</a>';
			echo '<a>'.ucwords(strtolower($r['name'])).'</a>';
			echo '</div>';
		}
	} else {
		echo '<p>You have not added any instruments yet!</p>';
	}
	?>
	</div>
</div><!-- instrument-list -->
<div id="band-list" class="sidebar-widget">
	<div class="sidebar-title">YOUR BANDS</div>
	<div class="sidebar-widget-content">
	<?php
	foreach($me->bands as $b) {
		echo '<a class="edit-sidebar-band" href="?page=edit&band='.$b->id.'">'.$b->name.'</a>';
	}
	?>
	</div>
</div><!-- instrument-list -->
