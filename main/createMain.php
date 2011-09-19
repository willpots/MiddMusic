<?php if(isset($_GET['band'])) { ?>
	<?php if(isset($_POST['submitupdate'])) { 
		global $dbHost, $dbUser, $dbPass, $dbSchema;
		$con = mysql_connect($dbHost, $dbUser, $dbPass);
		if(!$con) die('Could not connect: ' . mysql_error());
		mysql_select_db($dbSchema, $con) or die('Could not select database');
		$picture=null;
		$name = cleanString($_POST['name']);
		$info = cleanString($_POST['info']);
		if(!empty($_FILES['profilepic']['name'])) {
			$tname=	$_FILES['profilepic']['tmp_name'];
			$name = $_FILES['profilepic']['name'];
			move_uploaded_file(	$tname, "photos/band_".$_COOKIE['mu_id']."_".$name);
			$picture =  "photos/band_".$_COOKIE['mu_id']."_".$name;
			echo "Uploaded Picture!";
		}

		$type=$_POST['type'][0];
		for($i=1;$i<count($_POST['type']);$i++) {
			$type .= ','.$_POST['type'];
		}
		$query = "INSERT INTO bands (name,info,picture,type) VALUES ('$name','$info','$picture','$type') ";
		$result = mysql_query($query) or die("Query $query failed.".mysql_error());
		$id = mysql_insert_id($con);
		$query = "INSERT INTO userbands (userid,bandid) VALUES ('".$_COOKIE['mu_id']."','".$id."')";
		mysql_query($query) or die("Query $query failed.".mysql_error());
	
		foreach($_POST['users'] as $u) {
			$query = "INSERT INTO userbands (userid,bandid) VALUES ('".$u."','".$id."')";
			mysql_query($query) or die("Query $query failed.".mysql_error());
		}

	?>
	<p>Band created successfully! Check out the new <a href="?page=profile&band=<?php echo $id; ?>">profile page</a>.</p>
	<?php } else { ?>
		<div class="section-title">CREATE NEW BAND</div>
		<div id="edit-form">
			<form id="updateBand" action="?page=create&band" method="post">
			<input type="hidden" name="id" value="">
			<div class="right">
				Upload a picture:
				<br><input type="file" name="profilepic">
			</div>
			<label for="name">Band Name: 
				<input type="text" name="name" id="name" value="" placeholder="Name">
			</label>
			<label for="info">Description:<br>
				<textarea rows="15" cols="50" name="info" id="info" placeholder="Describe your band here..."></textarea>
			</label>	
			<label for="type">Type: <br>
				<select name="type[]" multiple id="type" class="chzn-select" style="width:500px;">
				<?php
				$types = getBandTypes();
				foreach($types as $t) {
					echo '<option value="'.$t['id'].'">'.$t['name'].'</option>';
				}
				?>
				</select>
			</label>
			<label for="users">Other members (Not necessary for one person bands): <br>
				<select name="users[]" multiple id="users" class="chzn-select" style="width:500px;">
				<?php
				$users = pullAllUsers();
				foreach($users as $us) {
					if($us['id']!=$_COOKIE['mu_id']) {
						echo '<option value="'.$us['id'].'">'.$us['name'].'</option>';
					}
				}
				?>
				</select>
			</label>
			<input type="submit" class="button" name="submitupdate" value="Create Band">
		</form>
		</div>
	<?php } ?>
<?php } ?>