<?php

  session_start();
  if($_SESSION['username']){
    $username = $_SESSION['username'];
    echo "Welcome, ".$username."! <a href='logout.php'>Log out</a>";
  }
  $grid_size = 3;
  
 /* if($_SESSION['username'])
    echo "Welcome, ".$_SESSION['username']."! <a href='logout.php'>Log out</a>";
  else die("You must be logged in!");
  //Try to make a page for the "You must be logged in!" message.
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
  
  <style>
    td {
      border: solid 1px black;
    }
  </style>
  
    <title>Profile Settings</title>

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

  <body style="">

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
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <!--        <li><a href="./Dashboard Template for Bootstrap.htm">MyDesk</a></li>
            <li><a href="./Dashboard Template for Bootstrap.htm">Settings</a></li>
            <li><a href="./Dashboard Template for Bootstrap.htm">Profile</a></li> -->
   <?php echo "<li class='dropdown'>
                <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Welcome ".$username."!  <b class='caret'></b></a>
                <ul class='dropdown-menu'>
                  <li><a href='./profile.php'>You are logged in as: <p>".$username."</p></a></li>
            <!--  <li><a href='#'>Something else here</a></li> -->
                  <li class='divider'></li>
            <!--  <li class='dropdown-header'>Nav header</li> -->
                  <li><a href='#'>MyDesk</a></li>
                  <li><a href='#'>Log Out</a></li>
                </ul>
              </li>
      <!--      <li><a href='./logout.php'>Log Out</a></li> --> "
  ?>
          </ul>
         
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
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
        $username = $_SESSION['username'];
        //Connect to the database
        mysql_select_db($_SESSION['db'], $con);
        
       

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
      <!--
      <form method="get" action="desksubmit.php" id="formHolder">
        <input id="holder" name="holder" style="display:none"></input>
        <img src="images/delete.png" style="margin-top:15px; float:right" ondrop="drop(event)" ondragover="allowDrop(event)"/>
      </form>
      -->
      
          </div>
        </div>
      </div>
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        

     
        </div><!-- /.col-sm-4 -->


    <div class="container" id = "signupform"  style = "left: 260px;top: 55px;position: absolute;}">

      <?php
              $sql = "SELECT * FROM user WHERE user_name='".$username."' LIMIT 1";
              $res = mysql_query($sql);
              
              while ($row = mysql_fetch_array($res, MYSQL_ASSOC)) {
                $first = $row['user_first_name'];
                $last = $row['user_last_name'];
                $email = $row['user_email'];
                $password = $row['user_password'];
                echo " <form id = 'registration' method='post'  class='form-signin' role='form' style = 'width: 300px'>
                       <h2 class='form-signin-heading' style = 'right: 150px'>Profile Settings</h2>
                       <p>  First Name <input type='text' name='first'  class='form-control' placeholder='First name' required autofocus value='".$first."'></p>
                       <p>  Last Name<input type='text' name='last' class='form-control' placeholder='Last name' required autofocus  value='".$last."'> </p>
                       <p>  Email Address<input type='email' name='email' class='form-control' placeholder='Email address' required autofocus value='".$email."'></p>
                       <p>  Username<input type='text' name='username' class='form-control' placeholder='Username' required autofocus value='".$username."'></p>
                       <p>  Password<input type='password' name='password' class='form-control' placeholder='Password' required autofocus value='".$password."'></p>
                       <button  class='btn btn-lg btn-primary btn-block' type='submit' onclick= 'return alert2('Changes Saved');' >Submit</button> ";

                }
            if(isset($_POST['username'])) {
              $user = $_POST['username'];
              $pass = $_POST['password'];
              $first = $_POST['first'];
              $last = $_POST['last'];
              $email = $_POST['email'];


              $sql = "UPDATE user
                      SET user_name='".$user."', user_password='".$pass."', user_email='".$email."',user_first_name='".$first."',user_last_name='".$last."' 
                      WHERE user_name='".$username."' LIMIT 1";
              $res = mysql_query($sql);
              echo "<script> alert('Changes saved'); window.location = 'desk.php'</script>";
           //   header('Location: profile.php');
              
            }
      ?>
      <script type="text/javascript">
      function alert2(text) {
        alert(text);
      }</script>
 <!--   <form id = "registration" method="post" class="form-signin" role="form" style = "width: 300px">
     <h2 class="form-signin-heading" style = "right: 150px">Profile Settings</h2>
     <p>  First Name <input type="text" name="first" class="form-control" placeholder="First name" required autofocus ></p>
     <p>  Last Name<input type="text" name="last" class="form-control" placeholder="Last name" required autofocus  > </p>
     <p>  Email Address<input type="email" name="email" class="form-control" placeholder="Email address" required autofocus ></p>
     <p>  Username<input type="text" name="username" class="form-control" placeholder="Username" required autofocus ></p>
     <p>  Password<input type="password" name="password" class="form-control" placeholder="Password" required autofocus ></p>
    <!--  <input type="password" class="form-control" placeholder="Confirm Password" required autofocus> -->

</div>
      <!--  <button class="btn btn-lg btn-primary btn-block" type="submit" onclick = "verify()">Submit</button> 
      <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit" onclick="return verifyPassword(); " >Submit</button>
    </form>

    </div>

  -->