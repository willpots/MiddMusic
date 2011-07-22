<?php 
/***************************************************************************
 * editMain.php																				*
 * 
 * Middlebury Music United 																*
 * This code is proprietary and property of William S. Potter.					*
 * It has been licensed for use to Middlebury College in this installation.*
 * Use of this code requires consent from William S. Potter						*
 * will@middpoint.com																		*
 ***************************************************************************/
if(isset($_COOKIE['mu_id'])) {
	$id=$_COOKIE['mu_id'];
	$i = getUserInfo($id);
	?>
	<div id="edit">
		<div class="section-title">EDIT YOUR PROFILE</div>
		<div id="edit-form">
			<div class="right">
				<img id="profilepic" src="<?php echo $i['picture']; ?>" alt="Profile Picture" width="200">
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
				<textarea rows="15" cols="53" name="info" id="info" placeholder="Describe yourself here..."><?php echo stripslashes($i['info']); ?></textarea>
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