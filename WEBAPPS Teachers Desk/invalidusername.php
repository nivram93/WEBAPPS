
<?php

  session_start();

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
    $firstname = $_POST['first'];
    $lastname = $_POST['last'];
    $email = $_POST['email'];
    
    $_SESSION['firstname'] = $firstname;
    $_SESSION['lastname'] = $firstname;
    $_SESSION['email'] = $firstname;
    
    $sql = "SELECT * FROM user WHERE user_name='$username' LIMIT 1";
    $res = mysql_query($sql);
    
    //Checks if the username is valid
    if(mysql_num_rows($res) == 0) {
      //Database selection
      //$sql = "SELECT * FROM user WHERE user_name='".$username."' AND user_password='".$password."' LIMIT 1";
      $sql = "INSERT INTO user (user_name, user_password, user_first_name, user_last_name, user_email) VALUES ('".$username."', '".$password."', '".$firstname."', '".$lastname."', '".$email."');";
      $res = mysql_query($sql);

      header('Location: login.php');
      exit;
    } else {
      header('Location: invalidusername.php?error=TRUE');
      exit;
    }
    if(isset($_GET['error']) && $_GET['error'] == 'TRUE') {
      echo "<style>#error_message { visibility: visible; }</style>";
    } else {
        echo "<style>#error_message { visibility: hidden; }</style>";
    }
    
  }
?>



<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Registration</title>

    <!-- Bootstrap core CSS -->
     <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!DOCTYPE html>
<!-- saved from url=(0044)http://getbootstrap.com/examples/dashboard/# -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/dashboard.css" rel="stylesheet">
  
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
          <a class="navbar-brand" href="login.php">Teacher's Desk</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="./Dashboard Template for Bootstrap.htm">Sign In</a></li>
            </ul>
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Username">
          </form>
          <form class="navbar-form navbar-right">
            <input type="password" class="form-control" placeholder="Password">
          </form>
        </div>
      </div>
    </div>

   

    <div class="container" id = "signupform" style = "left: 480px;top: 90px;position: absolute;}">

		<form id = "registration" method="post" class="form-signin" role="form">
		 <h2 class="form-signin-heading" style = "right: 150px">Sign up now!</h2>
	   <p>	<input type="text" name="first" class="form-control" placeholder="First name" required autofocus ></p>
	   <p>	<input type="text" name="last" class="form-control" placeholder="Last name" required autofocus  > </p>
	   <p>  <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus ></p>
     <p> 	<input type="text" name="username" class="form-control" placeholder="Username" required autofocus ></p>
     <h6 id="error_message" style=" color:red;">Username is taken</h6>
     <p>	<input type="password" name="password" class="form-control" placeholder="Password" required autofocus ></p>
		<!--	<input type="password" class="form-control" placeholder="Confirm Password" required autofocus> -->


			<!--  <button class="btn btn-lg btn-primary btn-block" type="submit" onclick = "verify()">Submit</button> --> 
			<button class="btn btn-lg btn-primary btn-block" name="submit" type="submit" onclick="return verifyPassword(); " >Submit</button>
		</form>

    </div> <!-- /container -->

 <!--   <script type="text/javascript">

      function verifyPassword(){
          var password = document.getElementById('password');
          var verifypass = document.getElementById('verify password');

            var bool = true;
            if(password.value != verifypass.value){
              verifypass.setAttribute('style', 'background-color: pink');
              password.setAttribute('style', 'background-color: pink');
              
              bool = false;
              
            }
            else {
                verifypass.setAttribute('style', 'background-color: white');
              password.setAttribute('style', 'background-color: white');
              bool = true;
              
            }

            return bool;
      }
    </script>
-->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="js/verify.js"></script>
  </body>
</html>