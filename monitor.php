<?php
	include('connection.php');
	
	$borewell_id = $_GET['borewell_id'];
	$latitude = $_GET['lat'];
	$longitude = $_GET['lng'];

	$address = getAddress($latitude,$longitude);
	
	$sql = "SELECT button_state FROM borewell_status s1 WHERE borewell_id = 1 AND update_time = (SELECT MAX(update_time) FROM borewell_status s2 WHERE s1.borewell_id = s2.borewell_id )";
	
		if ($result = mysqli_query($con, $sql)) {
			
			if ($result = $con->query($sql)) {
			if (($row = $result->fetch_row())>0) {
				$status = $row[0];
			}
			else
				echo "E";
		}
	}

	function getAddress($latitude,$longitude){
	    if(!empty($latitude) && !empty($longitude)){
	        //Send request and receive json data by address
	        $geocodeFromLatLong = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false'); 
	        $output = json_decode($geocodeFromLatLong);
	        $status = $output->status;
	        //Get address from json data
	        $address = ($status=="OK")?$output->results[1]->formatted_address:'';
	        //Return address of the given latitude and longitude
	        if(!empty($address)){
	            return $address;
	        }else{
	            return false;
	        }
	    }else{
	        return false;   
	    }
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>CBMCS | Monitor</title>
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<style type="text/css">
	*
	{
		margin: 0px;
		padding:0px;
	}
	html
	{
		height:100%;
	}
	h1
	{
		background-color:#222629;
		text-align:center;
		font-size: 25px;
		font-family: Nunito;
		color:#E85A4F;
		padding-top: 30px;
		padding-bottom: 30px;
	}
	#motor_id
	{
		font-family: Nunito;
		color:#E85A4F;
		font-size: 20px;
		padding-top: 50px;
		padding-left:100px;
		float:left;
	}
	#motor_id .name
	{
		color:#000;
		font-size: 20px;
	}

	#on_off_button
	{
		font-family: Nunito;
		font-size: 20px;
		float:right;
		padding-top: 50px;
		padding-right: 100px;
	}
	#current_class
	{
		background: #222629;
		color:#E85A4F;
	}
	#temp_class
	{
		background: #222629;
		color:#E85A4F;
	}
	#float_class
	{
		background: #222629;
		color:#E85A4F;
	}
	#flow_class
	{
		background: #222629;
		color:#E85A4F;
	}
	#vol_class
	{
		background: #222629;
		color:#E85A4F;
	}

	.switch {
	  position: relative;
	  display: inline-block;
	  width: 60px;
	  height: 34px;
	  vertical-align: middle;
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
	  background-color: #E85A4F;
	}

	input:focus + .slider {
	  box-shadow: 0 0 1px #E85A4F;
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

	#sensor_data_values
	{
		clear:both;
		position: relative;
		width:90%;
		left:5%;
		top:50px;
		text-align: center;
		font-size: 20px;
		font-family: Nunito;
	}

	#sensors
	{
		width:17%;
		height:250px;
		display: inline-block;
		padding-right: 20px;
	}

	#sensors:last-child
	{
		padding-right: 0px;
	}

	#sensor_data_values .sensor_value
	{
		height:250px;
		
	}
	#sensor_data_values .sensor_value #sensor_value_recieved
	{
		line-height: 250px;
		font-size: 80px;
	}

	#sensor_data_values #sensor_name
	{
		display: block;
		padding-top: 20px;
	}
	#footer
	{
		clear: both;
		position: relative;
		top:130px;
		bottom: 0;
		left:0;
		right:0;
		width: 100%;
		text-align: center;
		background: #222629;
		color:#fff;
		padding-top: 20px;
		padding-bottom: 20px;
		font-family: Nunito;
		font-size: 18px;
	}

</style>
</head>
<body>
	<div id="monitor_outside">
		<div id="monitor_inside">
			<?php echo '<h1 id="address">'. $address.'</h1>'; ?>
		</div>
	</div>
	<div id="motor_id"><span class="name">MOTOR ID: </span><?php echo $borewell_id ?></div>
	<div id="on_off_button">
		<span>SWITCH ON/ OFF:</span>
		<label class="switch">
			<input type="checkbox" name="on_off" id="on_off" onclick="on_off(this)" <?php echo ($status == 1 ? 'checked' : '');?>>
			<span class="slider round"></span>
		</label>
	</div>
	<div id="sensor_data_values">

		<div id="sensors">
			<div class="sensor_value" id="current_class">
				<?php
					$current_sql = "SELECT current FROM sensors_data WHERE borewell_id ='".$borewell_id."'";
					if ($result = mysqli_query($con, $current_sql)) {
		
					    while ($row = mysqli_fetch_assoc($result)) {
					  	
					  		$current = $row["current"]/267.55;				  	

					    }
					    echo '<p id="sensor_value_recieved">'.number_format((float)$current, 2, '.', '').'</p>';
					}
					
				?>
			</div>
			<span id="sensor_name">CURRENT</span>
		</div>
		<div id="sensors">
			<div class="sensor_value" id="temp_class">
				<?php
					$temp_sql = "SELECT temperature FROM sensors_data WHERE borewell_id ='".$borewell_id."'";
					if ($result = mysqli_query($con, $temp_sql)) {
		
					    while ($row = mysqli_fetch_assoc($result)) {
					  	
					  		$temp = $row["temperature"];				  	

					    }
					    echo '<p id="sensor_value_recieved">'.$temp.'</p>';
					}
				?>
			</div>
			<span id="sensor_name">TEMPERATURE</span>
		</div>
		<div id="sensors">
			<div class="sensor_value" id="float_class">
				<?php
					$float_sql = "SELECT water_level FROM sensors_data WHERE borewell_id ='".$borewell_id."'";
					if ($result = mysqli_query($con, $float_sql)) {
		
					    while ($row = mysqli_fetch_assoc($result)) {
					  	
					  		$float = $row["water_level"];
					  		if($float == 0)
					  		{
					  			$name = "HIGH";
					  		}			
					  		else
					  		{
					  			$name = "LOW";
					  		}					  	

					    }
					    echo '<p id="sensor_value_recieved">'.$name.'</p>';
					}
				?>
			</div>
			<span id="sensor_name">WATER LEVEL</span>
		</div>
		<div id="sensors">
			<div class="sensor_value" id="flow_class">
				<?php
					$flow_sql = "SELECT water_flow FROM sensors_data WHERE borewell_id ='".$borewell_id."'";
					if ($result = mysqli_query($con, $flow_sql)) {
		
					    while ($row = mysqli_fetch_assoc($result)) {
					  	
					  		$flow = $row["water_flow"];	
					  					  	

					    }
					    echo '<p id="sensor_value_recieved">'.$flow.'</p>';
					}
				?>
			</div>
			<span id="sensor_name">WATER FLOW</span>
		</div>

		<div id="sensors">
			<div class="sensor_value" id="vol_class">
				<?php
					$vol_sql = "SELECT water_vol FROM sensors_data WHERE borewell_id ='".$borewell_id."'";
					if ($result = mysqli_query($con, $vol_sql)) {
		
					    while ($row = mysqli_fetch_assoc($result)) {
					  	
					  		$vol = $row["water_vol"];				  	

					    }
					    echo '<p id="sensor_value_recieved">'.$vol.'</p>';
					}
				?>
			</div>
			<span id="sensor_name">VOLUME FILLED</span>
		</div>

	</div>

	<div id="footer">
		<p>Developed by Prototech</p>
	</div>

</body>
</html>

<script>

	var current_var = "<?php echo $current; ?>";
	var temp = "<?php echo $temperature; ?>";
	var flow = "<?php echo $water_level; ?>";
	var float = "<?php echo $water_flow; ?>";
	var name = "<?php echo $name; ?>";
	
	if(current_var > 1025)
	{
		$('#current_class').css("background", "#ff0000");
		$('#current_class').css("color", "#fff");
	}


	if(temp > 60.0)
	{
		$('#temp_class').css("background", "#ff0000");
		$('#temp_class').css("color", "#fff");
	}
	
	if(flow < 0.0)
	{
		$('#flow_class').css("background", "#ff0000");
		$('#flow_class').css("color", "#fff");
	}
	
	if(name == 'LOW')
	{
		$('#float_class').css("background", "#ff0000");
		$('#float_class').css("color", "#fff");
	}




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

	setTimeout(function(){
   		window.location.reload(1);
	}, 10000);
</script>