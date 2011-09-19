<?php if(isset($_GET['fail'])) { ?>	
	<div>
	<p>Sorry, we did not find a username or password that matched your input.</p>
	<form action="login.php" method="post">
	<label for="username">Username</label><br>
	<input type="text" autocomplete="off" name="username" placeholder="rliebowitz">@middlebury.edu<br>
	<label for="password">Password</label><br>
	<input type="password" autocomplete="off" name="password" ><br><br>
	<input type="submit" class="button" name="SUBMITLOGIN" value="Log me in!">
	</form>
	</div>
<?php } else if(isset($_GET['validate'])) { 
$username = $_GET['validate'];
?>
	<div>
	<p>Sorry, <?php echo $username; ?>@middlebury.edu is not confirmed. Please check your email for the confirmation message. If you have not received a message,
	try your Spam folder. Sometimes, our emails have a nasty habit of getting caught by Google!</p>
	</div>
<?php } else { ?>
	<div>
	<form action="login.php" method="post">
	<label for="username">Username</label><br>
	<input type="text" autocomplete="off" name="username" placeholder="rliebowitz">@middlebury.edu<br>
	<label for="password">Password</label><br>
	<input type="password" autocomplete="off" name="password" ><br><br>
	<input type="submit" class="button" name="SUBMITLOGIN" value="Log me in!">
	</form>
	</div>
<?php } ?>