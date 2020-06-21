<?php

	include('connection.php');
	
	$sql = "SELECT * FROM sensors_data";

	if ($result = mysqli_query($con, $sql)) {
	
	    while ($row = mysqli_fetch_assoc($result)) {
	  	
	  	$borewell_id = $row["borewell_id"];
	  	$temperature = $row["temperature"];
	  	$current = $row["current"];
	  	$water_flow = $row["water_flow"];
	  	$water_level = $row["water_level"];
	  	$water_vol = $row["water_vol"];
	  	
	        //printf ("%s, %s, %s, %s, %s, %s", $row["borewell_id"], $row["temperature"], $row["current"], $row["water_flow"], $row["water_level"], $row["water_vol"]);
	       // printf("<br>");
	    }
	        if($temperature > 65.0)
	        {
	        	$temp_sql = "INSERT INTO borewell_status (borewell_id, button_state) VALUES ('". $borewell_id ."', '0')";
	        	if ($con->query($temp_sql) === TRUE) {
				echo "Temperature Error";
			} else {
				echo "No Error";
			}
	        }
	        else if($water_flow < 0.0)
	        {
	        	$flow_sql = "INSERT INTO borewell_status (borewell_id, button_state) VALUES ('". $borewell_id ."', '0')";
	        	if ($con->query($flow_sql) === TRUE) {
				echo "Flow Error";
			} else {
				echo "No Error";
			}
	        }
	        else if($current > 1024)
	        {
	        	$current_sql = "INSERT INTO borewell_status (borewell_id, button_state) VALUES ('". $borewell_id ."', '0')";
	        	if ($con->query($current_sql) === TRUE) {
				echo "Current Error";
			} else {
				echo "No Error";
			}
	        }
	        else if($water_level == 1)
	        {
	        	$float_sql = "INSERT INTO borewell_status (borewell_id, button_state) VALUES ('". $borewell_id ."', '0')";
	        	if ($con->query($float_sql) === TRUE) {
				echo "Float Error";
			} else {
				echo "No Error";
			}
	        }
	        else 
	        {
	        	echo "Successful";
	        }
	    mysqli_free_result($result);
	}
	
	$con->close();
	
?>