<?php
	ob_start();
	session_start();
	if($_SESSION['Active'] == false){ header("location:login.php"); exit; }
	require_once 'includes/dbh.inc.php';
	require_once 'includes/header.inc.php';
	require_once 'includes/functions.inc.php';
?>
		<title>TrackLink - Littleton</title>
	</head>
	<body>
		<div class="container">
			<?php
				echo getAlert('warning', 'Alert', 'You are viewing an alpha build of TrackLink! <h6>-> IE/Edge not supported</h6>', true);
				echo getAllAlerts(htmlspecialchars($_GET['alert']));
			?>
			<div class="header clearfix" style="margin-bottom: 5px;">
				<nav>
					<ul class="nav nav-pills pull-right">
						<li role="presentation" class="active"><a href="">Projects</a></li>
						<li role="presentation"><a class="customlogout" href="logout.php" role="button"><i class="material-icons md-18">exit_to_app</i> Logout</a></li>
					</ul>
				</nav>
				<h3 class="text-muted">Littleton Artist Portal</h3>
			</div>
			<div style="margin-bottom: 50px;">
				<button style="float: right; margin-top: 15px;" class="btn btn-default btn-sm" type="button" data-toggle="modal" data-target="#add-new-modal">Add new</button>
				</br>
			</div>
			<div class="row marketing">
<?php
	require_once 'includes/index_content.inc.php';
?>
			</div>
<div class="modal fade" id="add-new-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Add New - Project</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="post" name="add-new-form">
					<h5>Project Information</h5>
					<label for="name" class="sr-only">Title</label>
					<input name="name" id="name" class="form-control" placeholder="Title" required autofocus>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button name="Submit" class="btn btn-primary" type="submit">Add</button>
					</div>
					<?php
						require 'includes/index_addnew.inc.php';
					?>
				</form>
			</div>
		</div>
	</div>
</div>

<?php
	require_once 'includes/footer.inc.php';
?>