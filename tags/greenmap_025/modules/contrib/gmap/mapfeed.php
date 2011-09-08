<?php

require_once '/greenhouse/includes/bootstrap.inc';

// create $mapdata to hold all the information from database
$mapdata = '';

  $query = "SELECT oid, type, latitude, longitude FROM location 
	WHERE type = 'node' ORDER BY oid";
	$result = mysql_query($query);	
	
	$number = mysql_numrows($result);
	$i = 0;
	
	while($number > $i){
	
		$oid = mysql_result($result,$i,"oid");
		$latitude = mysql_result($result,$i,"latitude");
		$longitude = mysql_result($result,$i,"longitude");

	$mapdata .= "<marker lat=\"" . $latitude . "\" lng=\"" . $longitude . "\" message=\"" . $oid . "\"></marker>\n" ;	
  
  // end looping row
  $i++;
  }

$xml = "<markers>\n" . $data . "</markers>";

// write xml data to file

$myFile = "markers.xml";
$fh = fopen($myFile, 'w') or die("can't open xml file");
fwrite($fh, $xml);
fclose($fh);


?>