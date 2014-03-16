<?php

	session_start();
	
	if(!$_SESSION['username'])
		die("You must be logged in!");
	//Try to make a page for the "You must be logged in!" message.
	if(isset($_POST['comment_message'])) {
		$con = mysql_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pass']);
		//Close connection when it can't connect to MySQL
		if(!$con) {
			die('Could not connect'. mysql_error());
		}
		
		//Connect to the database
		mysql_select_db($_SESSION['db'], $con);
		
		//Database selection
		//$sql = "SELECT * FROM user WHERE user_name='".$username."' AND user_password='".$password."' LIMIT 1";
		$sql = "INSERT INTO comment (comment_message, comment_owner, comment_card_id, comment_reply) VALUES ('".$_POST['comment_message']."', '".$_SESSION['username']."', '".$_GET['cardID']."', -1)";
		$res = mysql_query($sql) or die(mysql_error());
	}
	
	/*
	if(isset($_POST['comment'])) {
		$con = mysql_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pass']);
		//Close connection when it can't connect to MySQL
		if(!$con) {
			die('Could not connect'. mysql_error());
		}
		
		//Connect to the database
		mysql_select_db($_SESSION['db'], $con);
		
		//Database selection
		//$sql = "SELECT * FROM user WHERE user_name='".$username."' AND user_password='".$password."' LIMIT 1";
		$sql = "INSERT INTO comment (card_title, card_message, card_owner) VALUES ('".$_POST['card_title']."', '".$_POST['card_message']."', '".$_SESSION['username']."')";
		$res = mysql_query($sql) or die(mysql_error());
	}
	*/
?>
<!DOCTYPE html>
<!-- saved from url=(0044)http://getbootstrap.com/examples/dashboard/# -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

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
					$sql = "SELECT card_title FROM card WHERE card_id='".$_GET['cardID']."' LIMIT 1";
					$res = mysql_query($sql);
					while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
						$card_title = $row['card_title'];
						$index = strpos($card_title, "]");
						if($index !== FALSE)
							$card_title = substr($card_title, $index + 1);
						echo "<title>".$card_title."</title>";
					}			
				?>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/dashboard.css" rel="stylesheet">


<script>
function delete(id) {
  alert("delete func");
  document.getElementById("holder").value = id;
  var proceed = confirm("Delete?");
  if(proceed) {
      $('form#formHolder').submit();
      
  }
  
}

function alert2(text) {
  alert(text);
}

function alert3() {
  alert('alert3');
}

</script>
	
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
          <a class="navbar-brand" href="./desk.php">Teacher's Desk</a>
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
				<input type="text" name="txt-addSubj" class="form-control add-subject" required placeholder="Add Subject Group"/>
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

<form method="get" action="desksubmit.php" id="formHolder">
				<input id="holder" name="holder" style="display:none"></input>
				<img src="images/delete.png" style="margin-top:15px; float:right" ondrop="drop(event)" ondragover="allowDrop(event)"/>
			</form>
          </div>
        </div>
      </div>
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
			<div class="row">
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
					$sql = "SELECT * FROM card WHERE card_id=".$_GET['cardID'].";";
					$res = mysql_query($sql);
					
					while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
						echo "<div class='col-sm-8'>".
									"<div class='panel panel-info'>".
										"<div class='panel-heading'>".
											"<h2 class='panel-title' style='display:inline'>".$row["card_title"]."</h2>".
									//		"<button type='button' class='btn btn-link'  onclick= edit();>Edit</button>".
											"<a href='edit.php?subject=".$subject."&cardID=".$row["card_id"]."' ><h3 class='panel-title' style='float: right;'>".'Edit'."</h3></a>".
									"<a href='' onclick=\"alert('potek'); return false;\" id='deleteLink'><h3 class='panel-title' style='float: right'>Delete</h3></a>".
										"</div>".
										"<div class='panel-body'>".
											$row["card_message"].
										"</div>".
									"</div>".
								"</div>";
					}			
					
				?>



			</div>
			<hr>
			<h4>Comments:</h4>
			<div class="row">
				<!--COMMENTS GO HERE-->
				<div class='col-sm-12'>
					<div class='well'>
						<form method="post">
							<textarea type="text" name="comment_message" class="form-control card-msg" placeholder="Comment..." required="" style="resize:none; height: 65px; margin-bottom: 10px"></textarea>
							<button class="btn btn-sm btn-primary" type="submit" name="submit">Post</button>
						</form>
					</div>
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
					$sql = "SELECT * FROM comment WHERE comment_card_id='".$_GET['cardID']."' AND comment_reply=-1";
					$res = mysql_query($sql);
					
					while ($res and $row = mysql_fetch_array($res, MYSQL_ASSOC)) {
						echo "<div class='well'>".
								$row['comment_message'].
							"</div>";
					}			
				?>
			</div>
		</div>
    </div>
	
	<script type="text/javascript">

	function edit(){
		window.location = "edit.php"
	}

	</script>
	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
  

</body></html>					