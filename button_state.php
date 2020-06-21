<?php

	include('connection.php');

	$button_state= $_GET['button_state'];

	$sql = "INSERT INTO borewell_status(borewell_id, button_state) VALUES ('1', '" . $button_state . "')";

	if ($con->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error";
	}

	$con->close();
	
?>