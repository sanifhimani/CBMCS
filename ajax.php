<?php

	$relay = $_POST["relay"];
	$elapsed_time = $_POST["elapsed_time"];

	$con=mysqli_connect("localhost","sanif","sanifhimani","cbmcs");
	// Check connection
	if (mysqli_connect_errno())
	  {
	  echo "Failed to connect to MySQL: ";
	  }

	// Perform queries 
	//  $sql = "SELECT * FROM sensor_values";
	$sql = "INSERT INTO sensor_values(relay, elapsed_time) VALUES ('".$relay."','".$elapsed_time."')";

	if (!mysqli_query($con,$sql))
	  {
	  echo("Error description: " . mysqli_error($con));
	  }
	  else
	  {
	  	echo "success";
	  }
	  
	  if(isset($_POST["check_box_on"])){
		  $sql = "INSERT INTO borewell_status (borewell_id, button_state) VALUES ('1', '1')";
		  $run_query = mysqli_query($con, $sql);
		  if(mysqli_num_rows($run_query) > 0)
		  {
			echo "success";
		  }
		  else
		  {
			  echo "FAILED";
		  }
	  }
	  
	  if(isset($_POST["check_box_off"])){
		  $sql = "INSERT INTO borewell_status (borewell_id, button_state) VALUES ('1', '0')";
		  $run_query = mysqli_query($con, $sql);
		  if(mysqli_num_rows($run_query) > 0)
		  {
			echo "success";
		  }
		  else
		  {
			  echo "FAILED";
		  }
	  }
?>