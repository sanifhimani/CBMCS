<?php

	include('connection.php');

	$borewell_id = $_GET['unique_id'];
	$latitude = $_GET['latitude'];
	$longitude = $_GET['longitude'];

	$sql = "INSERT INTO borewell_data (borewell_id, latitude, longitude) VALUES ('" . $borewell_id . "', '" . $latitude . "', '" . $longitude . "')";

	if ($con->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error";
	}

	$con->close();
	
?>