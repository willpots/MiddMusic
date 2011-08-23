<?php
include("libs/libMMU.php");
if(isset($_GET['bands'])) {
	$q=$_GET['bands'];
	$results = pullAll($q,'bands');
	$a = json_encode($results);
	echo $a;
} else if(isset($_GET['venue'])) {
	$q=$_GET['venue'];
	$results = pullAll($q,'venue');
	$a = json_encode($results);
	echo $a;
} else {
	$q=$_GET['q'];
	$results = pullAll($q);
	$a = json_encode($results);
	echo $a;
}
?>