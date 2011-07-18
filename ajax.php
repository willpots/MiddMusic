<?php
require("LocalSettings.php");
header( "content-type: application/xml; charset=ISO-8859-15" ); 
$uids=array();
$u = $_GET['u'];
$con = mysql_connect($dbHost, $dbUser, $dbPass);
mysql_select_db($dbSchema, $con);

$results = mysql_query("SELECT * FROM instruments");
while($row = mysql_fetch_array($results))
{
	$names[] = ucfirst($row['name']);
	$ids[] = $row['id'];
}

mysql_free_result($results);

$results = mysql_query("SELECT * FROM userinstruments WHERE userid= '$u' ");
while($row = mysql_fetch_array($results))
{
	$uids[] = $row['instrumentid'];
}
mysql_close($con);

//get the q parameter from URL
$q=strtolower($_GET["q"]);
$len=strlen($q);

$dom = new DOMDocument('1.0', 'ISO-8859-1');
$query = $dom->createElement('query');
$dom->appendChild($query);
if ($len>0)
{
	
	for($i=0; $i<count($names); $i++)
	{
		$name=$names[$i];
		$id=$ids[$i];
		
		if(!in_array($id,$uids))
		{
			if (stripos($name,$q) || strtolower(substr($name,0,$len)) == $q)
			{
				$element = $dom->createElement('inst', $name);
				$element->setAttribute('id',$id);
				$query->appendChild($element);
			}
		}
	}
}

echo $dom->saveXML(); 

?> 