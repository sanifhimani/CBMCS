<?php 

	include 'connection.php';
	include 'users_validation.php';
	$errors = array();

	if(empty($_POST) === false)
	{
		$required_fields = array('username','password','password_again','full_name','email','phone_number','township','no_of_motors');
		foreach($_POST as $key=>$value)
		{
			if(empty($value) && in_array($key, $required_fields) === true)
			{
				$errors[] = "Fields with '*' are required";
				break 1;
			}
		}
		
		if(empty($errors) === true)
		{
			if(user_exists($_POST['username']) === true)
			{
				$errors[] = "Sorry, the username '" . $_POST['username'] . "' is already taken";
			}
			if(preg_match("/\\s/", $_POST['username']) == true)
			{
				$errors[] = "Your username must not contain any spaces.";
			}
			if(strlen($_POST['password']) < 6)
			{
				$errors[] = "Your password must be at least 6 characters";
			}
			if($_POST['password'] !== $_POST['password_again'])
			{
				$errors[] = "Your passwords do not match";
			}
			if(!preg_match("/^[_a-z0-9-]+(\.[a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/", $_POST['email']))
			{
				$errors[] = $_POST['email'] . " is not a valid email address";
			}
			if(email_exists($_POST['email']) === true)
			{
				$errors[] = "Sorry, the email '" . $_POST['email'] . "' is already in use";
			}
		}
		
	}
							if(isset($_GET['success']) && empty($_GET['success']))
							{
								echo '
									<h1>You have registered successfully.</h1>
								';
							}
							else
							{
								if(empty($_POST) === false && empty($errors) === true)
								{
									$register_data = array(
										'username' => $_POST['username'],
										'password' => $_POST['password'],
										'full_name' => $_POST['full_name'],
										'email' => $_POST['email'],
										'phone' => $_POST['phone_number'],
									);
									
									register_user($register_data);
									header('Location: register.php?success');
									exit();
								}
								else if(empty($errors) === false)
								{
									echo output_errors($errors);
								}
							}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>CBMCS | Register</title>
		<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	</head>
	<style type="text/css">

		*
	{
		margin: 0px;
		padding:0px;
		
	}

	#main_outside
	{
		display: table;
	    position: absolute;
	    height: 100%;
	    width: 100%;
	    background-color:#222629;
	}

	#main_outside h1
	{
		font-family: Nunito;
		font-size: 50px;
		text-align: center;
		color:#E85A4F;
		margin:50px;
	}


	#main_inside ul li
	{
		text-align: center;
		padding:5px;
	}

	#main_inside ul li input
	{
			text-align:center;
			width:350px;
			height:50px;
			font-family: Nunito;
			font-size: 25px;
	}

	#main_inside input:focus
	{
  		outline: 3px solid #E85A4F;    

  	}
  	#main_inside ul li input[type=submit]
	{
		width:130px;
		height:50px;
		box-shadow: 5px 5px 5px  #000;
		font-size: 23px;
		padding:5px;
		margin:20px;
		margin-bottom: 20px;
		background-color:#E85A4F;
		border:2px solid #E85A4F;
		font:Nunito;
		color:white;
		
	}	



	</style>
	<body>
		<div id="main_outside">
			<div id="main_inside">
				<h1>Register</h1>

				<form action="" method="post">
							<ul>
								<li>
									<input type="text" id="full_name" name="full_name" style="text-transform: capitalize;" placeholder="Full Name*">
								</li>
								<li>
									<input type="text" id="email" name="email" placeholder="Email*">
								</li>
								<li>
									<input type="text" name="phone_number" placeholder="Phone Number*">
								</li>
								<li>
									<input type="text" id="username" name="username" placeholder="Username*">
								</li>
								<li>
									<input type="password" id="password" name="password" placeholder="Password*">
								</li>
								<li>
									<input type="password" id="password_again" name="password_again" placeholder="Re-enter Password*">
								</li>
								<li>
									<input type="submit" value="Register">
								</li>
							</ul>
				</form>
			</div>
		</div>
	</body>
</html>