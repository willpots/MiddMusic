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
	$sb_title = "INSTRUMENTS/STYLES";
} else if($page=="bands") {
	$inst = getAllMusicStyles();
	$sb_title = "GENRES";
} else if($page=="venues") {
	$inst = getVenueTypes();
	$sb_title = "STYLES";
}
if($inst!=false) {
	foreach($inst as $c=>$key) {
	  $sort_id[] = $key['id'];
	  $sort_name[] = $key['name'];
	}
}
array_multisort( $sort_name, SORT_STRING, $inst);

?>
<div id="search-form" class="sidebar-widget">
	<label for="s" class="sidebar-title">SEARCH <?php echo strtoupper($page); ?><br>
	<?php 
	$page=$_GET['page'];
	if($page=="calendar"||$page=="practice"||$page=="record") {
		$sp = "musicians";
	} else {
		$sp = $page;
	} ?>
	<input type="text" onkeyup="searchFor(event, this.value, '<?php echo $sp; ?>');" autocomplete="off" class="field" name="s" id="s" <?php if(isset($_GET['q'])) echo 'value="'.$_GET['q'].'"'; ?>
placeholder="Search" />
	</label>
</div><!-- Search form -->

<div id="instruments" class="sidebar-widget">
	<div class="sidebar-title"><?php echo $sb_title; ?></div>
	<div class="sidebar-widget-content">
	<?php
	if($inst!=false) {
		foreach($inst as $i) { ?>
			<a id="<?php echo 'inst_'.$i['id']; ?>" onclick="getCategoryResults('<?php echo $page."','".$i['id']?>')" class="sidebar-child"><?php echo ucfirst($i['name']); ?></a>
			
		<?php
		}
	}
	?>
	</div>
</div><!-- about-me -->

