<?php

	session_start();

	session_destroy();
	header('Location: login.php');
	//echo "You've been logged out. <a href='login.php'>Click here to go back to the Log In page</a>"

?>