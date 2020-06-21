<?php
	include 'connection.php';
	include 'users_validation.php';

	if(empty($_POST) === false)
	{
		$username = $_POST['username'];
		$password = $_POST['password'];

		if(empty($username) === true || empty($password) === true)
		{
			$errors[] = "You need to enter a username and password";
		} 
		else if(user_exists($username) === false)
		{
			$errors[] = "We can't find that username. Have you registered?";
		}
		else
		{
			$login = login($username, $password);
			if($login == false)
			{
				$errors[] = "That Username/ Password combination is incorrect";
			}
			else
			{
				$_SESSION['user_id'] = $login;
				header('Location: main.php');
				exit();
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>CBMCS | Home</title>
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
	#main_inside
	{
		display: table-cell;
    	        vertical-align: middle;
	}
	h1
	{
		text-align:center;
		margin-top:-50px;
		font-size: 40px;
		font-family: Nunito;
		color:#E85A4F;
		margin-bottom: 10px;
	}

	#main_inside ul li
	{
		margin-top:10px;
		text-align:center;
	}

	#main_inside ul li input
	{
		width:300px;
		height:25px;
		font-family: Nunito;
		font-size: 18px;
		padding:5px;
		margin-top:20px;
	}

	#main_inside input:focus
	{
  		outline: 3px solid #E85A4F;    

  	}

	#main_inside ul li input[type=submit]
	{
		width:120px;
		height:40px;
		box-shadow: 5px 5px 5px  #000;
		font-size: 23px;
		padding:5px;
		margin:20px;
		margin-bottom: 20px;
		background-color:#E85A4F;
		border:2px solid #E85A4F;
		font:Nunito;
		color:#fff;
		
	}
	#main_inside ul li input[type=submit]:hover
	{
		cursor: pointer;
	}
	#main_inside a 
	{
		text-align:center;
		text-decoration:none;
		font-size: 22px;
		margin-left: 610px;
		color:#fff;
		font-family: Nunito;
	}

	#main_inside a:hover
	{
		color:#E85A4F;
	}
	#errors_p
	{
		color:#fff;
		font-family: Nunito;
	}
	#footer
      {
        clear: both;
        position: relative;
        top:595px;
        bottom: 0;
        left:0;
        right:0;
        width: 100%;
        text-align: center;
        background: #fff;
        color:#222629;
        padding-top: 20px;
        padding-bottom: 20px;
        font-family: Nunito;
        font-size: 18px;
      }

</style>

<body>
	<div id="main_outside">
		<div id="main_inside">
			<h1>Centralised Borewell Monitoring and Controlling System</h1>
			<span id="errors_p">
				<?php
					if(empty($errors) === false)
					{
						echo output_errors($errors);
					}
				?>
				
			</span>
			<br>
			<br>
			<form action="" method="POST">
				<ul id="login">
					<li>
						<input type="text" placeholder="Username" name="username">
					</li>
					<li>
						<input type="password" placeholder="Password" name="password">
					</li>
					<li>
						<input type="submit" value="Login">
					</li>
				</ul>
			</form>
			<a href="register.php">Register here</a>
		</div>
	</div>
	<div id="footer">
      <p>Developed by Prototech</p>
    </div>
</body>
</html>
