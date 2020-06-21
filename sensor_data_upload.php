<?php

	include('connection.php');

	$borewell_id = $_GET['borewell_id'];
	$temperature= $_GET['temperature'];
	$current = $_GET['current'];
	$float = $_GET['float'];
	$flow = $_GET['flow'];
	$vol = $_GET['vol'];
	

	$sql = "INSERT INTO sensors_data (borewell_id, temperature, current, water_flow, water_level, water_vol) VALUES ('" . $borewell_id . "', '" . $temperature. "', '" . $current . "', '". $flow  ."', '". $float ."', '". $vol  ."')";

	if ($con->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error";
	}

	$con->close();
	
?>