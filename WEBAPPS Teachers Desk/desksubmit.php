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
		if(isset($_GET['subject']) && $_GET['subject'] != "General")
			$sql = "INSERT INTO card (card_title, card_message, card_owner, date_posted) VALUES ('[".$_GET['subject']."] ".$_POST['card_title']."', '".$_POST['card_message']."', '".$_SESSION['username']."', '".$date."');";
		else $sql = "INSERT INTO card (card_title, card_message, card_owner, date_posted) VALUES ('".$_POST['card_title']."', '".$_POST['card_message']."', '".$_SESSION['username']."', '".$date."');";
		$res = mysql_query($sql) or die(mysql_error());
 
		//Check if a file exists and is less than 100kB(?) and has the correct file extension
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["file"]["name"]);
		$extension = end($temp);
		//if (($_FILES["file"]["type"] == "image/png"))
		if(($_FILES["file"]["size"] < 50000000)
			&& in_array($extension, $allowedExts)) {
			
			$sql = "SELECT * FROM card WHERE card_title='".$_POST['card_title']."' AND card_message='".$_POST['card_message']."' AND card_owner='".$_SESSION['username']."' AND date_posted='".$date."' LIMIT 1;";
			$res = mysql_query($sql) or die(mysql_error());
			
			while ($res and $row = mysql_fetch_array($res, MYSQL_ASSOC)) {
				echo $sql."<br>".$res['card_id'];
				$card_id = $row['card_id'];
				$filename = "card-".$card_id."-".$_FILES["file"]["name"];
			}
			if ($_FILES["file"]["error"] > 0) {
				echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
			} else {
				echo "<br>".$filename."<br>";
				echo "Upload: " . $_FILES["file"]["name"] . "<br>";
				echo "Type: " . $_FILES["file"]["type"] . "<br>";
				echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
				echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";
 
				if (file_exists("upload/" . $_FILES["file"]["name"])) {
					echo $_FILES["file"]["name"] . " already exists. ";
				} else {
					move_uploaded_file($_FILES["file"]["tmp_name"],
					"upload/".$filename);
					echo "Stored in: " . "upload/".$filename;
					
					$sql = "INSERT INTO file (file_name, card_id, orig_name) VALUES ('".$filename."', ".$card_id.", '".$_FILES["file"]["name"]."');";
					$res = mysql_query($sql) or die(mysql_error());
				}
			}
		}
 
		// Redirect to prevent re-submitting the form when the user refreshes the page
		if(isset($_GET['subject']))
			header('Location: desk.php?subject='.$_GET['subject'], true, 303);
		else header('Location: desk.php', true, 303);
//unset($_POST);
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
//unset($_POST);
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
//unset($_GET);
		exit;
	}
 
 
 
?>			