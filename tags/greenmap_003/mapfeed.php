<?php

require_once 'includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);

// create $mapdata to hold all the information from database
$mapdata = '';

  $query = "SELECT location.oid, location.latitude, location.longitude, node.nid, node.type, node.title, node.status, node.moderate, node.vid 
    FROM location, node 
	WHERE location.oid=node.vid AND node.type = 'content_map' AND node.status='1' AND node.moderate='0' ORDER BY location.oid";
	$result = mysql_query($query);	
	
	$number = mysql_numrows($result);
	$i = 0;
	
	while($number > $i){
	
		$oid = mysql_result($result,$i,"location.oid");
		$latitude = mysql_result($result,$i,"location.latitude");
		$longitude = mysql_result($result,$i,"location.longitude");
		$title = mysql_result($result,$i,"node.title");

	$mapdata .= "<marker lat=\"" . $latitude . "\" lng=\"" . $longitude . "\" message=\"" . $title . "\"></marker>\n" ;
	echo $latitude;
	echo "hello world"; 	
  
  // end looping row
  $i++;
  }

$xml = "<markers>\n" . $mapdata . "</markers>";
echo $xml;

// write xml data to file

$myFile = "modules/contrib/gmap/markers.xml";
$fh = fopen($myFile, 'w') or die("can't open xml file");
fwrite($fh, $xml);
fclose($fh);


?>