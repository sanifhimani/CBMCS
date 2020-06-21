<?php 

	include 'connection.php';
	$con = mysqli_connect("localhost","sanif","sanifhimani","cbmcs");

	function login($username, $password)
	{
		$user_id = user_id_from_username($username);
		$username = sanitize($username);
		$password = md5($password);
		$query = "SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `password` = '$password'";
		return (mysqli_result(mysqli_query(mysqli_connect("localhost","sanif", "sanifhimani","cbmcs"), $query), 0, 0) == 1) ? $user_id : false;
	}

	function logged_in()
	{
		return (isset($_SESSION['user_id'])) ? true : false;
	}

	function user_exists($username)
	{
		$username = sanitize($username);
		$query = mysqli_query(mysqli_connect("localhost","sanif", "sanifhimani","cbmcs"), "SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username'");
		return (mysqli_result($query, 0, 0) == 1) ? true : false;
	}

	function user_id_from_username($username)
	{
		$username = sanitize($username);
		$query = mysqli_query(mysqli_connect('localhost', 'sanif', 'sanifhimani', 'cbmcs'), "SELECT `user_id` FROM `users` WHERE `username` = '$username'");
		return mysqli_result($query, 0, 'user_id'); 
	}

	function mysqli_result($result,$row,$field=0) {
	    if ($result===false) return false;
	    if ($row>=mysqli_num_rows($result)) return false;
	    if (is_string($field) && !(strpos($field,".")===false)) {
	        $t_field=explode(".",$field);
	        $field=-1;
	        $t_fields=mysqli_fetch_fields($result);
	        for ($id=0;$id<mysqli_num_fields($result);$id++) {
	            if ($t_fields[$id]->table==$t_field[0] && $t_fields[$id]->name==$t_field[1]) {
	                $field=$id;
	                break;
	            }
	        }
	        if ($field==-1) return false;
	    }
	    mysqli_data_seek($result,$row);
	    $line=mysqli_fetch_array($result);
	    return isset($line[$field])?$line[$field]:false;
	}

	function sanitize($data)
	{
		return mysqli_real_escape_string(mysqli_connect('localhost', 'sanif', 'sanifhimani', 'cbmcs'), $data);
	}

	function output_errors($errors)
	{
		$output = array();
			foreach($errors as $error)
			{
				$output[] = '<li>' . $error . '</li>';
			}
			return '<ul id="errors">' . implode('', $output) . '</ul>';
	}
?>