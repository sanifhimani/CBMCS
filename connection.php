<?php
$con = mysqli_connect("localhost","sanif","sanifhimani","cbmcs");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>