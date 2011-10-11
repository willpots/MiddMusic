<?php 
/****************************************************************************
 * editMain.php																*
 * 																			*
 * Middlebury Music United 													*
 * This code is proprietary and property of William S. Potter.				*
 * It has been licensed for use to Middlebury College in this installation. *
 * Use of this code requires consent from William S. Potter					*
 * will@middpoint.com														*
 ***************************************************************************/
 
/*********** BANDS **************/
if(isset($_COOKIE['mu_id'])&&isset($_GET['band'])) {
	if($me->canEdit($_GET['band'],'band')||is_admin()) {
	$id=$_GET['band'];
	$b = new Band($id);
	$types = getBandTypes();
?>
		<div class="section-title">EDIT <?php echo strtoupper($b->name) ?>'S PROFILE</div>
		<div id="edit-form">
			<form id="updateBand">
			<input type="hidden" name="id" value="<?php echo $b->id; ?>">
			<div class="right">
				<img id="profilepic" src="<?php if(isset($b->picture)) echo $b->picture; else echo "photos/nameless.png"; ?>" alt="Profile Picture" width="200">
				<br><input type="file" name="profilepic">
			</div>
			<label for="name">Band Name: 
				<input type="text" name="name" id="name" value="<?php echo $b->name; ?>" placeholder="Name">
			</label>
			<label for="info">Description:<br>
				<textarea rows="15" cols="45" name="info" id="info" placeholder="Describe your band here..."><?php echo stripslashes($b->info); ?></textarea>
			</label>	
			<label for="type">Type: <br>
				<select name="type[]" multiple id="type" class="chzn-select" style="width:500px;">
				<?php
				foreach($types as $t) {
					foreach($b->type as $c) {
						if($c==$t['id']) {
							echo '<option selected value="'.$t['id'].'">'.$t['name'].'</option>';
						} else {
							echo '<option value="'.$t['id'].'">'.$t['name'].'</option>';
						}
					}
				}
				?>
				</select>
			</label>
			<label for="users">
				<select name="users[]" multiple id="users" class="chzn-select" style="width:500px;">
				<?php
				$users = pullAllUsers();
				foreach($users as $us) {
					if(in_array($us['id'],$b->users)) {
						echo '<option selected value="'.$us['id'].'">'.$us['name'].'</option>';
					} else {
						echo '<option value="'.$us['id'].'">'.$us['name'].'</option>';
					}
				}
				?>
				</select>
			</label>
		</form>
		<input type="button" class="button" name="updateband" onclick="updateBand()" value="Update Band">
		</div>
<?php	} else { ?>
	<p>You cannot edit that band. You are not a member.</p>
<?php	
	}
/*********** EVENTS **************/
} else if(isset($_COOKIE['mu_id'])&&isset($_GET['event'])) { 

$event = $_GET['event'];
$e=new Event($event);
if($e->exists==true && (in_array($_COOKIE['mu_id'],$e->users||is_admin())) ) {
?>


<div class="section-title">CALENDAR</div>
<div class="month-name">Create Event</div>
<div class="event-form">
	<form id="event-create-form" name="updateEventForm" onkeyup="validateEventForm()">
	<p><label for="name">Event Name: 
			<input type="text" 
					name="name" 
					id="name" 
					value="<?php echo $e->name; ?>" 
					class="compose-field" 
					placeholder="Event Name">
	</label></p>
	<p><label for="starttime">Start Time: 
			<input type="text" 
					name="starttime" 
					class="compose-field" 
					id="starttime" 
					value="<?php echo date("m/d/Y h:i a",$e->starttime); ?>"
					placeholder="Start Time">
	</label></p>
	<p><label for="endtime">End Time: 
			<input type="text" 
					name="endtime" 
					class="compose-field" 
					id="endtime" 
					value="<?php echo date("m/d/Y h:i a",$e->endtime); ?>"
					placeholder="End Time">
	</label></p>
	<p><label for="description">Description:<br>
		<textarea name="description" id="description" rows="10" cols="70" class="compose-field" placeholder="What's happening?"><?php echo stripslashes($e->description); ?></textarea></label></p>
	<p><label for="bands">Bands/Performers:<br>
		<select multiple id="bands" name="bands[]" class="chzn-select" onchange="validateEventForm()" style="width:412px;">
			<option></option>
			<?php
				$a=pullAllBands();
				foreach($a as $b) {
					$c = explode('-',$b['id']);
					$c = $c[1];
					if(in_array($c,$e->bands)) {
						echo '<option value="'.$b['id'].'" selected>'.$b['name'].'</option>';
					} else {
						echo '<option value="'.$b['id'].'">'.$b['name'].'</option>';
					}
				}
			?>
		</select>
		</label>
	</p>
	<p><label for="venue">Venue:<br>
		<select id="venue" name="venue" class="chzn-select" onchange="validateEventForm()" style="width:412px;">
			<option></option>
			<?php
				$a=pullAllVenues();
				foreach($a as $b) {
					$c = explode('-',$b['id']);
					$c = $c[1];
					if($c==$e->venueid) {
						echo '<option value="'.$b['id'].'" selected>'.$b['name'].'</option>';
					} else {
						echo '<option value="'.$b['id'].'">'.$b['name'].'</option>';
					}
				}
			?>
		</select>
		</label>
	</p>
	</form>
	<input type="button" name="UPDATEEVENT" class="button" id="sbutton" onclick="updateEvent('<?php echo $event; ?>')" disabled value="Update Event">
	<input type="button" name="DELETEEVENT" class="button" id="DELETEEVENT" onclick="deleteEvent('<?php echo $event; ?>')" value="Delete Event">
	<script>
		$('#starttime').datetimepicker({
			ampm: true
		});
		$('#endtime').datetimepicker({
			ampm: true
		});
		validateEventForm();
	</script>
</div>



<?php } else if($e->exists==true) { ?>
	<p>Sorry you do not have permission to edit that event!</p>
<?php } else { ?>
	<p>The event you are looking for does not exist!</p>
<?php }
/*********** USERS **************/
} else if(isset($_COOKIE['mu_id'])) {
	$id=$_COOKIE['mu_id'];
	$i = getUserInfo($id);
	$u = new User($id);
?>
	<div id="edit">
		<div class="section-title"><a href="?page=profile&id=<?php echo $u->id; ?>" style="text-decoration:none;">&larr;</a> | EDIT YOUR PROFILE</div>
		<div id="edit-form">
			<form id="updateUser" name="updateUser">
			<div class="right" style="width:200px;">
				<img id="profilepic" src="<?php if(isset($i['picture'])) echo $u->picture; else echo "photos/nameless.png";  ?>" alt="Profile Picture" width="200">
				<input type="file" name="profilepic">
			</div>
			<label for="username">Username: 
				<input type="text" name="username" id="username" value="<?php echo $i['username']; ?>" placeholder="Username" disabled>
			</label>
			<label for="firstname">Firstname: 
				<input type="text" name="firstname" id="firstname" value="<?php echo $i['firstname']; ?>" placeholder="Firstname">
			</label>
			<label for="lastname">Lastname: 
				<input type="text" name="lastname" id="lastname" value="<?php echo $i['lastname']; ?>" placeholder="Lastname">
			</label>
			<label for="class">Class Year:
				<select name="class" id="class" class="chzn-select">
					<option value="2008" <?php if($i['class']==2008) echo "selected"; ?> >2008</option>
					<option value="2008.5" <?php if($i['class']==2008.5) echo "selected"; ?> >2008.5</option>
					<option value="2009" <?php if($i['class']==2009) echo "selected"; ?> >2009</option>
					<option value="2009.5" <?php if($i['class']==2009.5) echo "selected"; ?> >2009.5</option>
					<option value="2010" <?php if($i['class']==2010) echo "selected"; ?> >2010</option>
					<option value="2010.5" <?php if($i['class']==2010.5) echo "selected"; ?> >2010.5</option>
					<option value="2011" <?php if($i['class']==2011) echo "selected"; ?> >2011</option>
					<option value="2011.5" <?php if($i['class']==2011.5) echo "selected"; ?> >2011.5</option>
					<option value="2012" <?php if($i['class']==2012) echo "selected"; ?> >2012</option>
					<option value="2012.5" <?php if($i['class']==2012.5) echo "selected"; ?> >2012.5</option>
					<option value="2013" <?php if($i['class']==2013) echo "selected"; ?> >2013</option>
					<option value="2013.5" <?php if($i['class']==2013.5) echo "selected"; ?> >2013.5</option>
					<option value="2014" <?php if($i['class']==2014) echo "selected"; ?> >2014</option>
					<option value="2014.5" <?php if($i['class']==2014.5) echo "selected"; ?> >2014.5</option>
					<option value="2015" <?php if($i['class']==2015) echo "selected"; ?> >2015</option>
					<option value="2015.5" <?php if($i['class']==2015.5) echo "selected"; ?> >2015.5</option>
				</select>
			</label>
			<label for="info">Description:<br>
				<textarea rows="15" cols="50" name="info" id="info" placeholder="Describe yourself here..."><?php echo stripslashes($i['info']); ?></textarea>
			</label>
			<label for="popacts">I Like... <br>
				<div id="popacts-container">
				<select name="popacts[]" multiple id="popacts" class="chzn-select" style="width:500px;">
					<?php 
						$acts=pullAllPopActs();
						foreach($acts as $a) {
							if(in_array($a['id'],$u->popacts)) {
								echo '<option value="'.$a['id'].'" selected>'.stripslashes($a['name']).'</option>';
							} else {
								echo '<option value="'.$a['id'].'">'.stripslashes($a['name']).'</option>';
							}
						}
					?>
				</select>
				</div>
			</label>	
			<label>Or add you own... (Correct spelling please.)<br>
				<input name="popacts[]" type="text" id="addpopact" style="width:500px;" onkeyup="addPopAct(event);" placeholder="Add a new Band">
			</label>
			<div class="section-title">Email Settings</div>
				<label>Send me MMU Email Notifications? <input type="checkbox" name="email_ok" value="yes" <?php if($u->email_ok==1) echo "checked"; ?>>
			</label>
			</form>
			<p>
			<button class="button" onclick="updateMyProfile()">Update Profile</button>	
			</p>
		</div>
	</div>
<?php
 } else { ?>
<div id="edit">
	<div class="section-title">EDIT YOUR PROFILE</div>
	<div id="edit-form">
		<p>You must have an account to edit a profile! Try going to <a href="/">the home page</a> and signing up on the form there!</p>
	
	
	
	</div>
</div>


<?php } ?>