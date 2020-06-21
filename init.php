<?php
	session_start();
	require 'connection.php';
	require 'users_validation.php';
	if(logged_in() === true)
	{
		$session_user_id = $_SESSION['user_id'];
		$user_data = user_data($session_user_id, 'user_id', 'username', 'password', 'full_name', 'email', 'phone_number');
	}
	$errors = array();
?>