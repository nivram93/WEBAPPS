<?php

	session_start();

	session_destroy();
	header('Location: default.php');
	//echo "You've been logged out. <a href='default.php'>Click here to go back to the Log In page</a>"

?>