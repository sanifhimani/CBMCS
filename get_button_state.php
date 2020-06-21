<?php

	include('connection.php');
	
	$sql = "SELECT button_state FROM borewell_status s1 WHERE borewell_id = 1 AND update_time = (SELECT MAX(update_time) FROM borewell_status s2 WHERE s1.borewell_id = s2.borewell_id )";
	
	if ($result = mysqli_query($con, $sql)) {
		
		if ($result = $con->query($sql)) {
		if (($row = $result->fetch_row())>0) {
			$status = $row[0];
			if($status == 0)
				echo "Error";
			else if($status == 1)
				echo "Successful";
		}
		else
			echo "Error";
	}
	}
	
	/*
	if ($result = mysqli_query($con, $sql)) {
	
	    while ($row = mysqli_fetch_assoc($result)) {
	  	
	        printf ("%s, %s, %s, %s, %s, %s, %s", $row["borewell_id"], $row["temperature"], $row["current"], $row["water_flow"], $row["water_level"], $row["button_state"], $row["water_vol"]);
	        printf("<br>");
	    }
	
	    /* free result set */
	    /*mysqli_free_result($result);
	}
	
	if ($result = $con->query($sql)) {
		if (($row = $result->fetch_row())>0) {
			$status = $row[0];
			if($status == 0)
				echo "Error";
			else if($status == 1)
				echo "Successful";
		}
		else
			echo "Error";
	}*/
	
	$con->close();
	
?>