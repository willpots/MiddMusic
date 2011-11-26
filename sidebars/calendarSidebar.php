<?php 
/****************************************************************************
 * calendarMain.php															*
 *																			*
 * Middlebury Music United													*
 * This code is proprietary and property of William S. Potter.				*
 * It has been licensed for use to Middlebury College in this installation.	*
 * Use of this code requires written consent from William S. Potter.		*
 * will@willpots.com														*
 ***************************************************************************/
?>
<?php 
$events = getUpcomingEvents();
?>
<?php if(isset($_COOKIE['mu_id'])) { ?>
<div id="create-buttons" class="sidebar-widget">
	<a href="?page=create&band" class="create-button">Form a Band</a>
	<a href="?page=edit" class="create-button">Edit my Profile</a>
	<a href="?page=calendar" class="create-button">Create an Event</a>
</div>
<?php } ?>

<div id="upcoming-events" class="sidebar-widget">
	<div class="sidebar-title">UPCOMING EVENTS</div>
	<div class="sidebar-widget-content">
	<?php 
	if(!empty($events)) {
		foreach($events as $event) {
			$e=new Event($event['id']);
			echo '<div>'.date('n/j',$e->starttime).' - <a href="?page=profile&event='.$e->id.'">'.$e->name.'</a></div>';
		}
	} else {
		echo '<div>There are no planned events as of now. Be the first to <a href="?page=calendar&create">create one</a>!</div>';
	}
	?>
	</div>
</div><!-- upcoming events -->

<?php if(isset($_COOKIE['mu_id'])&&$page=="calendar") { ?>
<div id="create-event" class="sidebar-widget">
	<div class="sidebar-title center "><a href="?page=<?php echo $page ?>&create" class="blue-button">CREATE AN EVENT</a></div>
</div>

<?php } ?>


<?php if(isset($_COOKIE['mu_id'])&&$page=="record") { ?>
<div id="create-event" class="sidebar-widget">
	<div class="sidebar-title center "><a href="?page=<?php echo $page ?>&create" class="blue-button">BOOK RECORDING TIME</a></div>
</div>

<?php } ?>


<?php if(isset($_COOKIE['mu_id'])&&$page=="practice") { ?>
<div id="create-event" class="sidebar-widget">
	<div class="sidebar-title center "><a href="?page=<?php echo $page ?>&create" class="blue-button">BOOK PRACTICE TIME</a></div>
</div>

<?php } ?>