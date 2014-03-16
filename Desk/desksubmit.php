<?php
	
	session_start();
	
	$grid_size = 3;
	
	if($_SESSION['username'])
		echo "Welcome, ".$_SESSION['username']."! <a href='logout.php'>Log out</a>";
	else die("You must be logged in!");
	//Try to make a page for the "You must be logged in!" message.
	
	if(isset($_POST['card_title'])) {
		$con = mysql_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pass']);
		//Close connection when it can't connect to MySQL
		if(!$con) {
			die('Could not connect'. mysql_error());
		}

		//Connect to the database
		mysql_select_db($_SESSION['db'], $con);

		$time = time();
		$date = date('Y-m-d H:i:s');
//$date = now();

		//Database selection
		//$sql = "SELECT * FROM user WHERE user_name='".$username."' AND user_password='".$password."' LIMIT 1";
		$sql = "INSERT INTO card (card_title, card_message, card_owner, date_posted) VALUES ('".$_POST['card_title']."', '".$_POST['card_message']."', '".$_SESSION['username']."', '".$date."');";
		$res = mysql_query($sql) or die(mysql_error());
		
		//Check if a file exists and is less than 100kB(?) and has the correct file extension
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		if ((($_FILES["file"]["type"] == "image/gif")
			|| ($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/pjpeg")
			|| ($_FILES["file"]["type"] == "image/x-png")
			|| ($_FILES["file"]["type"] == "image/png"))
			&& ($_FILES["file"]["size"] < 100000)
			&& in_array($extension, $allowedExts)) {
			
			if ($_FILES["file"]["error"] > 0) {
				echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
			} else {
				echo "Upload: " . $_FILES["file"]["name"] . "<br>";
				echo "Type: " . $_FILES["file"]["type"] . "<br>";
				echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
				echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

				if (file_exists("upload/" . $_FILES["file"]["name"])) {
					echo $_FILES["file"]["name"] . " already exists. ";
				} else {
					move_uploaded_file($_FILES["file"]["tmp_name"],
					"upload/" . $_FILES["file"]["name"]);
					echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
				}
			}
		}

		// Redirect to prevent re-submitting the form when the user refreshes the page
		header('Location: desk.php', true, 303);
		exit;
		
	}
	else if(isset($_POST['txt-addSubj'])) {
		
		$con = mysql_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pass']);
		//Close connection when it can't connect to MySQL
		if(!$con) {
			die('Could not connect'. mysql_error());
		}
		//Connect to the database
		mysql_select_db($_SESSION['db'], $con);

		$subject = strtoupper($_POST['txt-addSubj']);

		$sql = "INSERT INTO subject (subject_name) VALUES ('".$subject."')";
		$res = mysql_query($sql) or die(mysql_error());
		
		// Redirect to prevent re-submitting the form when the user refreshes the page
		header('Location: desk.php', true, 303);
		exit;
	}
	
	else if(isset($_GET['holder'])) {
		$con = mysql_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pass']);
		//Close connection when it can't connect to MySQL
		if(!$con) {
			die('Could not connect'. mysql_error());
		}
		//Connect to the database
		mysql_select_db($_SESSION['db'], $con);

		$cardID = $_GET['holder'];
		echo "<script>alert($cardID)</script>";

		$sql = "DELETE FROM card WHERE card_id = ".$cardID."";
		mysql_query($sql) or die(mysql_error());
		
		// Redirect to prevent re-submitting the form when the user refreshes the page
		header('Location: desk.php', true, 303);
		exit;
	}
	
	
		
?>			