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

		//Database selection
		//$sql = "SELECT * FROM user WHERE user_name='".$username."' AND user_password='".$password."' LIMIT 1";
		$sql = "INSERT INTO card (card_title, card_message, card_owner) VALUES ('".$_POST['card_title']."', '".$_POST['card_message']."', '".$_SESSION['username']."')";
		$res = mysql_query($sql) or die(mysql_error());

		// Redirect to prevent re-submitting the form when the user refreshes the page
		header('Location: desk.php'.$page, true, 303);
		exit;
	}
	else if(isset($_POST['txt-addSubj'])) {
		//echo "<script>alert('txt-addSubj');</script>";
		
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
	
?>
<!DOCTYPE html>
<!-- saved from url=(0044)http://getbootstrap.com/examples/dashboard/# -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<style>
		td {
			border: solid 1px black;
		}
	</style>
	
    <title>Dashboard Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/dashboard.css" rel="stylesheet">
    <script type="text/JavaScript" src="./js/jquery-2.1.0.min.js"></script>
	

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style type="text/css"></style><style id="holderjs-style" type="text/css"></style></head>

  <body style="">

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./Dashboard Template for Bootstrap.htm">Teacher's Desk</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="./Dashboard Template for Bootstrap.htm">MyDesk</a></li>
            <li><a href="./Dashboard Template for Bootstrap.htm">Settings</a></li>
            <li><a href="./Dashboard Template for Bootstrap.htm">Profile</a></li>
            <li><a href="./logout.php">Log Out</a></li>
          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <div class="list-group">
			<!--NAVIGATION BAR GOES HERE-->

			<form method="post" action="desk.php" class="input-append">
				<input type="text" name="txt-addSubj" class="form-control add-subject" autocomplete="off" required placeholder="Add Subject Group"/>
				<button class="btn btn-xs btn-info" id="btn_add" type="submit">+</button>
			</form>

			<?php
				if(isset($_GET['subject']))
					$subject = $_GET['subject'];
				else $subject = "General";
				
				$con = mysql_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pass']);
				//Close connection when it can't connect to MySQL
				if(!$con) {
					die('Could not connect'. mysql_error());
				}
				
				//Connect to the database
				mysql_select_db($_SESSION['db'], $con);
				
				//Database selection
				//$sql = "SELECT * FROM user WHERE user_name='".$username."' AND user_password='".$password."' LIMIT 1";
				$sql = "SELECT * FROM subject";
				$res = mysql_query($sql);
				
				if(!$subject || $subject == "General")
					echo "<a href='./desk.php' class='list-group-item active'>General</a>";
				else echo "<a href='./desk.php' class='list-group-item'>General</a>";
				
				while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
					if($row['subject_name'] == $subject)
						echo "<a href='./desk.php?subject=".$row['subject_name']."' class='list-group-item active'>".$row['subject_name']."</a>";
					else echo "<a href='./desk.php?subject=".$row['subject_name']."' class='list-group-item'>".$row['subject_name']."</a>";
				}
			?>
			
			
			<!--<form method="post" style="dispaly:none" name="subjectName" id="form-add-btn" onsubmit="alert('submit')"></form>-->
			
			
          </div>
        </div>
      </div>
	  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		
		  <div class="row">
			<!--CARD CREATION-->
			
				
				<div class="col-sm-4">
				  <!--<div class="panel panel-default">-->
				  	<form method="post" action="desk.php" class="panel panel-info">
						<div class="panel-heading">
						  <input type="text" name="card_title" class="form-control cardTitle" placeholder="Title" autocomplete="off" required="" autofocus="">
						  <button class="btn btn-sm btn-primary" type="submit" name="submit">Post</button>
						</div>
						<div class="panel-body">
						  <textarea type="text" name="card_message" class="form-control" placeholder="Message" required="" style="resize:none"></textarea>
						  
						</div>
					</form>
				  <!--</div>-->
				</div><!-- /.col-sm-4 -->
			
			<!--CARDS GO HERE-->
		    <?php
				
				$con = mysql_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pass']);
				//Close connection when it can't connect to MySQL
				if(!$con) {
					die('Could not connect'. mysql_error());
				}
				
				//Connect to the database
				mysql_select_db($_SESSION['db'], $con);
				 
				//Database selection
				//$sql = "SELECT * FROM user WHERE user_name='".$username."' AND user_password='".$password."' LIMIT 1";
				$sql = "SELECT * FROM card";
				$res = mysql_query($sql);
				$index = 1;
				while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
					if(strpos($row["card_title"], '['.$subject.']') !== false || $subject == "General"){
						
						echo "<div class='col-sm-4'>".
								"<div class='panel panel-info'>".
									"<div class='panel-heading'>".
										"<a href='card.php?subject=".$subject."&cardID=".$row["card_id"]."'><h3 class='panel-title'>".$row["card_title"]."</h3></a>".
									"</div>".
									"<div class='panel-body'>".
										$row["card_message"].
									"</div>".
								"</div>".
							"</div>";
					}
					//echo "ID: ".$row["card_id"]." Title: ".$row["card_title"]." Message: ".$row["card_message"];
				}
				echo "</tr></table>";
			?>
		  </div>
      </div>

    </div>
	
	
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
  

</body></html>
