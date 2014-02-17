<html>
	<head>
		<title>Teacher's Desk</title>
		
		<!-- Bootstrap CSS-->
			<link href="./css/bootstrap.min.css" rel="stylesheet">
			<link href="./css/signin.css" rel="stylesheet">
	</head>
	
	<body style="">
		<div class="container">
			<form method="post" action="login.php" class="form-signin" role="form">
				<h2 class="form-signin-heading" style="text-align: center">Teacher's Desk</h2>

				<!-- WHEN THIS PAGE IS REFRESHED, THE FORM IS RE-SUBMITTED TO login.php IN WHICH YOU WOULD STILL BE REDIRECTED HERE, THE PROBLEM IS THE "Invalid username..." ERROR IS STILL THERE, WHEN THIS PAGE IS REFRESHED IT SHOULD REMOVE THE ERROR MESSAGE, I COULDN'T FIX IT -->

				<h6 style="text-align:center; color:red">Invalid username or password.</h6>
				<input type="text" name="username" class="form-control" placeholder="Username" required="" autofocus="">
				<input type="password" name="password" class="form-control" placeholder="Password" required="">
				<button class="btn btn-lg btn-primary btn-block" type="submit" name="submit">Sign In</button>
			</form>
		</div>
	</body>
</html>