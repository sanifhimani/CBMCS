<?php

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

$connection=mysqli_connect ('localhost', "sanif", "sanifhimani", "cbmcs");
if (!$connection) {  die('Not connected : ' . mysql_error());}

// Select all the rows in the markers table

$query = "SELECT * FROM borewell_data s1 WHERE update_time = (SELECT MAX(update_time) FROM borewell_data s2 WHERE s1.borewell_id = s2.borewell_id )";
$result = mysqli_query($connection, $query);
if (!$result) {
  die('Invalid query: ' . mysqli_error());
}

header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each

while ($row = @mysqli_fetch_assoc($result)){
  // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id",$row['update_id']);
  $newnode->setAttribute("borewell_id",$row['borewell_id']);
  $newnode->setAttribute("latitude", $row['latitude']);
  $newnode->setAttribute("longitude", $row['longitude']);
}

echo $dom->saveXML();

?>