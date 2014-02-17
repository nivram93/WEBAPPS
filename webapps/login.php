<?php
	
	session_start();
	
	$_SESSION['host'] = "localhost";
	$_SESSION['user'] = "root";
	$_SESSION['pass'] = "";
	$_SESSION['db'] = "teachersdesk";
	
	$con = mysql_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pass']);
	//Close connection when it can't connect to MySQL
	if(!$con) {
		die('Could not connect'. mysql_error());
	}
	
	//Connect to the database
	mysql_select_db($_SESSION['db'], $con);
	
	//Checks if a value has been set
	if(isset($_POST['username'])) {
		//Gets the POST value with the user presses Log In/Submit Button
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		
		//Database selection
		//$sql = "SELECT * FROM user WHERE user_name='".$username."' AND user_password='".$password."' LIMIT 1";
		$sql = "SELECT * FROM user WHERE user_name='$username' AND user_password='$password' LIMIT 1";
		$res = mysql_query($sql);
		
		//Checks if a user with the given username and password was found
		if(mysql_num_rows($res) == 1) {
			while($row = mysql_fetch_array($res)) {
				$_SESSION['username'] = $username;
				/*
				$expire = time() + 60; //1 Hour
				setcookie("uid", $row['user_id'], $expire);
				echo "<a href='desk.php'>You have successfully logged in.</a>";*/
				header('Location: desk.php');
				exit;
			}
		} else {
			header('Location: loginfail.php');
			exit;
		}
		header('Location: login.php');
	}
	
	$_SESSION['subject'] = "WEBAPPS";
	mysql_close($con);
?>

<html>
	<head>
		<title>Teacher's Desk</title>
		
		<!-- Bootstrap CSS-->
			<link href="./css/bootstrap.css" rel="stylesheet">
			<link href="./css/signin.css" rel="stylesheet">
	</head>

	<body style="">
		<div class="container">
			<form method="post" action="login.php" class="form-signin" role="form">
				<h2 class="form-signin-heading" style="text-align: center">Teacher's Desk</h2>
				<input type="text" name="username" class="form-control" placeholder="Username" required="" autofocus="" id="input-userid">
				<input type="password" name="password" class="form-control" placeholder="Password" required="" id="input-pass">
				<button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign In</button>
			</form>
		</div>
	</body>
</html>