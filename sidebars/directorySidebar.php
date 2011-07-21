<?php 
/***************************************************************************
 * directorySiderbar.php																	*
 *
 * Middlebury 																					*
 * This code is proprietary and property of William S. Potter.					*
 * It has been licensed for use to Middlebury College in this installation.*
 * Use of this code requires consent from William S. Potter						*
 * will@middpoint.com																		*
 **************************************************************************/
// Alphabetically Sort the Array! Genius!
$page = $_GET['page'];
if(isset($_GET['q'])) $q = $_GET['q'];
else $q = "";
if($page=="musicians") {
	$inst = getAllInstruments();
} else if($page=="bands") {
	$inst = getAllMusicStyles();
} else if($page=="venues") {
	$inst = getVenueTypes();
}
if($inst!=false) {
	foreach($inst as $c=>$key) {
	  $sort_id[] = $key['id'];
	  $sort_name[] = $key['name'];
	}
}
array_multisort( $sort_name, SORT_STRING, $inst);

?>
<div id="instruments" class="sidebar-widget">
	<div class="sidebar-title">INSTRUMENTS/STYLES</div>
	<div class="sidebar-widget-content">
	<?php
	if($inst!=false) {
		foreach($inst as $i) { ?>
			<a href="" id="<?php echo $i['id']; ?>" onclick="getSearchResults(this.id, '<?php echo $page; ?>', 'true')" class="sidebar-child"><?php echo ucfirst($i['name']); ?></a>
			
		<?php
		}
	}
	?>
	</div>
</div><!-- about-me -->

