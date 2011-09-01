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
if(isset($_COOKIE['mu_id'])&&isset($_GET['band'])) {
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
				<textarea rows="15" cols="50" name="info" id="info" placeholder="Describe your band here..."><?php echo stripslashes($b->info); ?></textarea>
			</label>	
			<label for="type">Type: 
				<select name="type">
				<?php
				foreach($types as $t) {
					if($b->type==$t['id']) {
						echo '<option selected value="'.$t['id'].'">'.$t['name'].'</option>';
					} else {
						echo '<option value="'.$t['id'].'">'.$t['name'].'</option>';
					}
				}
				?>
				</select>
			</label>
 			<input type="button" class="button" name="updateband" onclick="updateBand()" value="Update Band">
		</form>
		</div>
<?php } else if(isset($_COOKIE['mu_id'])&&isset($_GET['event'])) { ?>




<?php
} else if(isset($_COOKIE['mu_id'])) {
	$id=$_COOKIE['mu_id'];
	$i = getUserInfo($id);
?>
	<div id="edit">
		<div class="section-title">EDIT YOUR PROFILE</div>
		<div id="edit-form">
			<div class="right">
				<img id="profilepic" src="<?php if(isset($i['picture'])) echo $i['picture']; else echo "photos/nameless.png";  ?>" alt="Profile Picture" width="200">
				<form id="uploadpic">
					<input type="file" name="profilepic" onchange="uploadImage()">
				</form>
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
				<select name="class" id="class">
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
			<a class="button" onclick="updateUser()" >Update Profile</a>
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