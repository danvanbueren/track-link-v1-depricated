<?php
	ob_start();
	session_start();
	include_once 'includes/dbh.inc.php';
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/signin.css">
	<link rel="stylesheet" type="text/css" href="css/sticky-footer.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="css/custom.css">
	<title>Sign in</title>
</head>
<body>

<div class="container">
	<nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<center>
				<h4>TrackLink [Alpha]</h4>
				<h6>Littleton Artist Portal</h6>
			</center>
		</div>
	</nav>
</div>

<div class="container">
	<form action="" method="post" name="Login_Form" class="form-signin">
		<h2 class="form-signin-heading">Please sign in</h2>
		<label for="inputUsername" class="sr-only">Username</label>
		<input name="Username" type="username" id="inputUsername" class="form-control" placeholder="Username" required autofocus>
		<label for="inputPassword" class="sr-only">Password</label>
		<input name="Password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
		<div class="checkbox">
			<label>
				<input type="checkbox" value="remember-me" checked> Remember me
			</label>
		</div>
		<button name="Submit" value="Login" class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

		<?php
		require 'includes/login_check.inc.php';
		?>

	</form>
</div>

<footer class="footer">
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">System status</h3>
			</div>
			<div class="panel-body">
				<p><?php echo $connStatement; ?></p>
			</div>
		</div>
	</div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>