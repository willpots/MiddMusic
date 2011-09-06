<?php 
/***************************************************************************
 * calendarMain.php																			*
 *
 * Middlebury Music United																	*
 * This code is proprietary and property of William S. Potter.					*
 * It has been licensed for use to Middlebury College in this installation.*
 * Use of this code requires consent from William S. Potter						*
 * will@middpoint.com																		*
 ***************************************************************************/
 /*
if(isset($_GET['month'])) {
	$month = $_GET['month'];
} else $month = date('n');

if(isset($_GET['year'])) {
	$year = $_GET['year'];
} else $year = date('Y');

$month =  mktime(0,0,0,$month,1,$year);

if(isset($_GET['id'])) $id = $_GET['id'];
else if(isset($_COOKIE['mu_id'])) $id = $_COOKIE['mu_id'];
else $id = NULL;

$ui = getUserInfo($id);
$bands = getUserBands($id);
	


?>
<div id="search-form" class="sidebar-widget">
	<label for="s" class="sidebar-title">SEARCH<br>
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

<div id="about-me" class="sidebar-widget">
	<div class="sidebar-title">UPCOMING PERFORMANCES</div>
	<div class="sidebar-widget-content">

	</div>
</div><!-- about-me -->

<div id="associated-bands" class="sidebar-widget">
	<div class="sidebar-title">ASSOCIATED BANDS</div>
	<div class="sidebar-widget-content">

	</div>
</div><!-- associated bands -->

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
<?php if(isset($_COOKIE['mu_id'])) { ?>
<div id="manage-profile" class="sidebar-widget">
	<div class="sidebar-title center "><a href="?page=<?php echo $page ?>&create" class="button">CREATE AN EVENT</a></div>
</div>
<?php } */
?>
<?php if(isset($_COOKIE['mu_id'])) { ?>
<div id="manage-profile" class="sidebar-widget">
	<div class="sidebar-title center "><a href="?page=<?php echo $page ?>&create" class="blue-button">CREATE AN EVENT</a></div>
</div>

<?php } ?>