<?php
	ob_start();
	session_start();
	if($_SESSION['Active'] == false){ header("location:login.php"); exit; }
	require_once 'includes/dbh.inc.php';
	require_once 'includes/header.inc.php';
	require_once 'includes/functions.inc.php';
?>
		<title>TrackLink - User Settings</title>
	</head>
	<body>
		<div class="container-lg">
			<?php
				echo getAlert('warning', 'Alert', 'You are viewing an alpha build of TrackLink! <h6>-> IE/Edge not supported</h6>', true);
				echo getAllAlerts($_GET['alert']);
			?>
			<div class="header clearfix" style="margin-bottom: 5px;">
				<nav>
					<ul class="nav nav-pills pull-right">
						<li role="presentation"><a href="index.php">Projects</a></li>
						<li role="presentation">

							<div class="dropdown">
  								<button class="btn text-muted" type="button" id="dropdownMenuButton" data-toggle="dropdown">
									<i class="material-icons md-36" style="vertical-align: middle;">account_circle</i>
  								</button>
  								<div class="dropdown-menu">
  									<span class="dropdown-header"><?php echo $_SESSION['name'] ?></span>
  									<div class="dropdown-divider"></div>
    								<a class="dropdown-item active" href="settings.php"><i class="material-icons md-18 text-muted" style="vertical-align: middle;">settings</i> Settings</a>
    								<a class="dropdown-item" href="logout.php"><i class="material-icons md-18 text-muted" style="vertical-align: middle;">exit_to_app</i> Logout</a>
  								</div>
							</div>

						</li>
					</ul>
				</nav>
				<h3 class="text-muted"><?php echo getUserConfig('group-name'); ?> Artist Portal</h3>
			</div>

			<div class="row" style="padding: 10px 10px 10px 10px;">
				<div class="col-2">

					<div class="card" style="height:100%;">
						<div class="card-header">
							<h3>Settings</h3>
						</div>
						<div class="card-body">
							<button type="button" class="btn btn-primary active" style="margin:5px 0 5px 0;">Profile</button>
						</div>
					</div>

				</div>
				<div class="col-10">

					<div class="card text-center">
						<div class="card-header">
							<h3>Profile Settings</h3>
						</div>
						<div class="card-body">

							<div class="row">
								<div class="col-6">

									<div class="card">
										<div class="card-header">
											<h5>Change username</h5>
										</div>
										<div class="card-body">
											<form action="" method="post" name="changeusername" class="form-signin">
												<input name="username" type="text" class="form-control" id="username" placeholder="Username" style="margin-top:10px;" autocomplete="off" value="<?php echo $_SESSION['name']; ?>">
												<button name="submit-username" type="submit" class="btn btn-primary" style="margin-top:10px;">Submit</button>
												<?php updateUsername($conn); ?>
											</form>
										</div>
									</div>

								</div>
								<div class="col-6">

									<div class="card">
										<div class="card-header">
											<h5>Change password</h5>
										</div>
										<div class="card-body">
											<form action="" method="post" name="changepassword" class="form-signin">
												<input name="oldpass" type="password" class="form-control" id="oldpass" placeholder="Current password" style="margin-top:10px;" autocomplete="off">
												<input name="newpass" type="password" class="form-control" id="newpass" placeholder="New password" style="margin-top:10px;" autocomplete="off">
												<input name="newpass2" type="password" class="form-control" id="newpass2" placeholder="New password confirm" style="margin-top:10px;" autocomplete="off">
												<button name="submit-password" type="submit" class="btn btn-primary" style="margin-top:10px;">Submit</button>
												<?php updatePassword($conn); ?>
											</form>
										</div>
									</div>

								</div>
							</div>

						</div>
					</div>

				</div>
			</div>

<?php
	require_once 'includes/footer.inc.php';
?>