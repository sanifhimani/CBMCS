<?php

	include('connection.php');
	
	$sql = "SELECT button_state FROM borewell_status s1 WHERE borewell_id = 1 AND update_time = (SELECT MAX(update_time) FROM borewell_status s2 WHERE s1.borewell_id = s2.borewell_id )";
	
		if ($result = mysqli_query($con, $sql)) {
			
			if ($result = $con->query($sql)) {
			if (($row = $result->fetch_row())>0) {
				$status = $row[0];
			}
			else
				echo "NO DATA TO DISPLAY";
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<style>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
</head>
<body>

<label class="switch">
		<input type="checkbox" name="on_off" id="on_off" onclick="on_off(this)" <?php echo ($status == 1 ? 'checked' : '');?>>
		<span class="slider round"></span>
</label>

</label>

</body>
</html> 

<script>
	function on_off(checkbox)
	{
		if (checkbox.checked)
		{
			check_box_on();
			
			function check_box_on()
			{
				$.ajax({  
					url		:	"ajax.php",
					method	:	"POST",
					data	:	{check_box_on:1},
					success	: 	function(data){
						
					}
				});
			}
		}
		else
		{
			check_box_off();
			
			function check_box_off()
			{
				$.ajax({  
					url		:	"ajax.php",
					method	:	"POST",
					data	:	{check_box_off:1},
					success	: 	function(data){
						
					}
				});
			}
		}
	}
</script>