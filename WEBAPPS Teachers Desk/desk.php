<?php

	session_start();
	
	$grid_size = 3;
	
	if($_SESSION['username']){
		$username = $_SESSION['username'];
	}
	else header('Location: default.php', true, 303);
	//Try to make a page for the "You must be logged in!" message.
	
if(isset($_GET['delete'])) {
		$con = mysql_connect($_SESSION['host'], $_SESSION['user'], $_SESSION['pass']);
		//Close connection when it can't connect to MySQL
		if(!$con) {
			die('Could not connect'. mysql_error());
		}
		
		//Connect to the database
		mysql_select_db($_SESSION['db'], $con);
		
		//Database selection
		$sql = "DELETE FROM card WHERE card_id='".$_GET['cardID']."' LIMIT 1";
		$res = mysql_query($sql) or die(mysql_error());
		header('Location: desk.php?subject='.$_GET['subject'], true, 303);
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
	
    <title>Teacher's Desk</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/dashboard.css" rel="stylesheet">
    <script type="text/JavaScript" src="./js/jquery-2.1.0.min.js"></script>
	
    <script>

    	function allowDrop(ev) {
			ev.preventDefault();
		}

		function drag(ev) {
			ev.dataTransfer.setData("Text", ev.target.id);
			
		}

		function drop(ev) {
			ev.preventDefault();
			var data = ev.dataTransfer.getData("Text");
			var divPanel = document.getElementById(data);
			var divs = divPanel.getElementsByTagName("div");
		
			document.getElementById("holder").value = divs[0].id;
			
			var proceed = confirm("Delete?");
			if(proceed)
				$('form#formHolder').submit();
		}

function fixLocationOfTrashBin() {
  var formHolder = document.getElementById("formHolder");
  formHolder.style.top = (window.innerHeight-60)+"px";
  formHolder.style.right = "10px";
formHolder.style.display = "block";
}
    </script>
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  <style type="text/css">
  	.panel-body.timestamp {
  		margin: 0px; 
  		padding-top: 1px; 
  		font-size: 10px; 
  		height:1em; 
  		border-bottom: 
  		thin solid rgb(226,226,226);
  	}



  </style><style id="holderjs-style" type="text/css"></style></head>

  <body style="background: rgb(249, 249, 255)" onload="fixLocationOfTrashBin()" onresize="fixLocationOfTrashBin()">

    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./desk.php" style='padding: 0px'><img src='./images/TDesk.png' width='180px' alt="Teacher's Desk"></a>
        </div>
<?php
//echo "<div class='navbar-header'>Welcome, ".$_SESSION['username']."!</div>";
?>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
    <!--        <li><a href="./Dashboard Template for Bootstrap.htm">MyDesk</a></li>
            <li><a href="./Dashboard Template for Bootstrap.htm">Settings</a></li>
            <li><a href="./Dashboard Template for Bootstrap.htm">Profile</a></li> -->
   <?php echo "<li class='dropdown'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Welcome ".$username."! <b class='caret'></b></a>
                <ul class='dropdown-menu'>
                  <li><a href='./profile.php'>Profile</p></a></li>
            <!--  <li><a href='#'>Something else here</a></li> -->
                  <li class='divider'></li>
            <!--  <li class='dropdown-header'>Nav header</li> -->
                  <li><a href='#'>MyDesk</a></li>
                  <li><a href='./logout.php'>Log Out</a></li>
                </ul>
              </li>
      <!--      <li><a href='./logout.php'>Log Out</a></li> --> "
	?>

          </ul>
          <form class="navbar-form navbar-right">
            <input type="text" name = "search" class="form-control" placeholder="Search...">
          </form>

        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar" id="sidebar-subj">
          <div class="list-group">
			<!--NAVIGATION BAR GOES HERE-->

			
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
				$sql = "SELECT * FROM subject ORDER BY subject_name";
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

<form method='post' action='desksubmit.php?subject=".$subject." class='input-append'>
<span class='list-group-item addSubject'>
				<input type='text' name='txt-addSubj' class='form-control add-subject' autocomplete='off' required placeholder='Add Subject'/>
				<button class='btn btn-xs btn-info' id='btn_add' type='submit'>+</button>
</span>
			</form>
			
			
			
			
          </div>
<form method="get" action="desksubmit.php" id="formHolder" style='position: fixed; display:none;'>
				<input id="holder" name="holder" style="display:none"></input>
				<img src="images/delete.png" style="margin-top:15px; float:right" ondrop="drop(event)" ondragover="allowDrop(event)"/>
			</form>
        </div>

      </div>
	  <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		
		  <div class="row">
			<!--CARD CREATION-->
			
				
				<div class="col-sm-4">
				  <!--<div class="panel panel-default">-->
					<?php
					if(isset($_GET['subject']))
					  	echo "<form method='post' action='desksubmit.php?subject=".$_GET['subject']."' class='panel panel-success' enctype='multipart/form-data'>";
					else echo "<form method='post' action='desksubmit.php' class='panel panel-success' enctype='multipart/form-data'>";
					?>
						<div class="panel-heading" style="padding:10px">
						  <input type="text" name="card_title" class="form-control cardTitle" placeholder="Title" autocomplete="off" required="" autofocus="">
						</div>
						<div class="panel-body" style="padding:10px">
						  <textarea type="text" name="card_message" class="form-control" placeholder="Message" required="" style="resize:none; height: 70px; margin-bottom:5px"></textarea>
						  <input type="file" name="file" id="file">
						  <button class="btn btn-xs btn-success" type="submit" name="submit" style="float:right">Post</button>
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
			//		$sql = "SELECT * FROM card where card_title = 'd'";
			
				if(isset($_GET['search'])){
					$search = $_GET['search'];
					if($search != "")
					$sql = "SELECT * FROM card WHERE card_title = '". $search. "'";
					else
						$sql = "SELECT * FROM card";

				}
				else{
				 	$sql = "SELECT * FROM card";

				}
				$res = mysql_query($sql);
				$index = 1;
				while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
					if(strpos($row["card_title"], '['.$subject.']') !== false || $subject == "General"){
						$originalDate = $row["date_posted"];
						//$newDate = date("Y-M-d, D H:i:s", strtotime($originalDate));
$newDate = date("D, M d, Y ", strtotime($originalDate));
$time = date("H:i:s", strtotime($originalDate));
						echo "<div class='col-sm-4' >".
								"<div class='panel panel-info' draggable='true' ondragstart='drag(event)' id='cardPost".$row["card_id"]."'>".
									"<div class='panel-heading' style='white-space:nowrap' id='".$row["card_id"]."'>".
										"<span style='display:inline'>"."<a href='card.php?subject=".$subject."&cardID=".$row["card_id"]."' style='display:inline; '><h3 class='panel-title' style='white-space:nowrap; overflow:hidden; text-overflow:ellipsis; width: 100%;'>".$row["card_title"]."</h3></a>";
								if($_SESSION['username'] == $row['card_owner'])
									echo "<span style='float:right' title='".$time."'><span class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'><b class='caret'></b></a><ul class='dropdown-menu'> <li><a href='edit.php?subject=".$subject."&cardID=".$row["card_id"]."'>Edit</a></li> <li><a href='desk.php?subject=".$subject."&cardID=".$row["card_id"]."&delete=1' onclick='return confirm(\"Confirm delete?\")'>Delete</a></li> </ul></span></span></span>";
								else echo "</span>";
								echo "<span style='display:inline'>by ".$row['card_owner']."<span style='float:right' title='".$time."'>".$newDate."</span></span>".
																	"</div>".
									
									"<div class='panel-body' style='height:10em; overflow:auto; padding-top: 10px'>".
										$row["card_message"];
										
									//check for files attached
									$sql2 = "SELECT * FROM file WHERE card_id=".$row['card_id'];
									$res2 = mysql_query($sql2);
									$row2 = mysql_fetch_array($res2, MYSQL_ASSOC);
									if($row2) {
										echo "<br><a href='download.php?file=".$row2['file_name']."&filename=".$row2['orig_name']."'>Download</a>";
									}
									
									echo "</div>".
								"</div>".
							"</div>";
							//id='panel-msg-'".$subject."-".$row["card_id"]."
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