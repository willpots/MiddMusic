<?php 
/****************************************************************************
 * Middlebury Music United 													*
 * This code is proprietary and property of William S. Potter.				*
 * It has been licensed for use to Middlebury College in this installation. *
 * Use of this code requires consent from William S. Potter					*
 * will@middpoint.com														*
 ***************************************************************************/
include('functions.php');
?>
<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<link rel="dns-prefetch" href="//ajax.googleapis.com" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title>MiddMusic | <?php if(isset($_GET['page'])) echo ucfirst($_GET['page']); else echo "Home"; ?></title>
	<meta name="description" content="Official Site of Middlebury Music United">
	<meta name="author" content="Will Potter (@willpots)">
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<link rel="shortcut icon" href="/favicon.ico">
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">
	<link rel="stylesheet" href="css/style.css?v=2">
	<link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">
	<script src="js/libs/modernizr-1.7.min.js"></script>
	

</head>
<body>
		<?php if(isset($_GET['page'])) {
			include('page.php');
		} else {
			if(isset($_COOKIE['mu_user'])) {
				include('page.php');			
			} else {
				include('home.php');
			}
		} ?>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script>!window.jQuery && document.write(unescape('%3Cscript src="js/libs/jquery-1.5.1.min.js"%3E%3C/script%3E'))</script>
	<script src="js/plugins.js"></script>
	<script src="js/script.js"></script>
	<?php //Include page specific scripts
		if(isset($_GET['page'])) {
			$page=$_GET['page'];
			if($page=="profile") {
				echo '<script src="js/profile.js"></script>';
			} else if($page=="edit") {
				echo '<script src="js/edit.js"></script>';
			} else if($page=="record"||$page=="practice"||$page=="calendar") {
				echo '<script src="js/calendar.js"></script>';
				echo '<script>getCalendarMonth("'.$month.'","'.$page.'");</script>';			
			} else if($page=="bands"||$page=="musicians"||$page=="venues") {
				echo '<script src="js/directory.js"></script>';
				echo '<script>getSearchResults("'.$q.'","'.$page.'" );</script>';
			} 
		} else {
		
		}
	?>
	<!--[if lt IE 7 ]>
	<script src="js/libs/dd_belatedpng.js"></script>
	<script> DD_belatedPNG.fix('img, .png_bg');</script>
	<![endif]-->
	<script>
		var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']]; // Change UA-XXXXX-X to be your site's ID
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>
</body>
</html>