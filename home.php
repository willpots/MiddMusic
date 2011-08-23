<?php 
/****************************************************************************
 * Middlebury Music United													*
 * This code is proprietary and property of William S. Potter.				*
 * It has been licensed for use to Middlebury College in this installation.	*
 * Use of this code requires consent from William S. Potter					*
 * wp@punkypond.com															*
 ***************************************************************************/
 ?>
<div id="container">
	<header id="fp-header">
			<div id="fp-header-text">Middlebury Musicians Union</div>
	</header>
	<div id="fp-logobar">
		<a id="fp-logo"></a>
	</div><!-- logobar -->
	<div id="fp-main" role="main">
	<section>
		<div id="fp-login">
			<div id="fp-loginline">Login</div>
			<div id="fp-loginbox">
				<form action="login.php" method="post">
				<label for="username">Username</label><br>
				<input type="text" autocomplete="off" name="username" ><br>
				<label for="password">Password</label><br>
				<input type="password" autocomplete="off" name="password" ><br>
				<input type="submit" name="SUBMITLOGIN" value="Log me in!">
				</form>
				<div class="fp-links">
				<a href="?page=musicians" class="fp-content-link">BROWSE PERFORMERS</a>
				<a href="?page=calendar" class="fp-content-link">CALENDAR AND EVENTS</a>
				</div><!-- links -->
			</div><!-- loginbox -->
		</div><!-- login -->
		<div id="fp-signup">
			<div id="fp-signupline">Sign Up</div><!-- signupline -->
			<div id="fp-signupbox">
				<form action="?page=register" method="post">
				<label for="username">Username</label><br>
				<input type="text" autocomplete="off" name="username" placeholder="rliebowitz">@middlebury.edu<br>
				<label for="password">Password</label><br>
				<input type="password" autocomplete="off" name="password" ><br>
				<input type="submit" name="SIGNMEUP" value="Sign me up!">
				</form>
			</div><!-- signupbox -->
		</div><!-- signup -->
	</section>
	
	</div><!-- main -->
	<footer>
	
	</footer>
</div><!-- container -->