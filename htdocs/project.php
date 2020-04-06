<?php
ob_start();
session_start();
if($_SESSION['Active'] == false){
	header("location:login.php");
	exit;
}
require_once 'includes/dbh.inc.php';
require_once 'includes/project_content.inc.php';
require_once 'includes/functions.inc.php';
require_once 'includes/header.inc.php';
$resultAllProjects = mysqli_query($conn, "SELECT * FROM projects WHERE ;");
$resultAllProjectsCheck = mysqli_num_rows($resultAllProjects);
?>
<title>TrackLink - <?php echo $name; ?></title>
</head>
<body>
	<div class="container-lg">
		<?php
			echo getAlert('warning', 'Alert', 'You are viewing an alpha build of TrackLink! <h6>-> IE/Edge not supported</h6>', true);
			echo getAllAlerts(htmlspecialchars($_GET['uploaderror']));

			$editDescFileId = $_GET['eid'];
			$isEditRequest = is_numeric($editDescFileId);

			if($isEditRequest) {

				echo "
				<script type='text/javascript'>
					$(document).ready(function(){
						$('#edit-desc-modal').modal('show');
					});
				</script>";
			}

			$delFileId = $_GET['did'];
			$isDelRequest = is_numeric($delFileId);

			if($isDelRequest) {

				echo "
				<script type='text/javascript'>
					$(document).ready(function(){
						$('#del-modal').modal('show');
					});
				</script>";
			}
		?>
		<div class="header clearfix">
			<nav>
				<ul class="nav nav-pills pull-right">
					<li role="presentation"><a href="index.php">Projects</a></li>
					<li role="presentation"><a class="customlogout" href="logout.php" role="button"><i class="material-icons md-18">exit_to_app</i> Logout</a></li>
				</ul>
			</nav>
			<h3 class="text-muted"><?php echo getUserConfig('group-name'); ?> Artist Portal</h3>
		</div>
<div class="card bg-dark text-white card-constrain-lg">
	<img class="card-img x-card-img-lg" src="<?php echo $art ?>" alt="Background">
	<div class="card-img-overlay">
		<div class="col-lg-3">
		<a href="<?php echo $art ?>"><img class="card-img-showcase" src="<?php echo $art ?>" alt="Album art"></a>
		</div>
		<div class="col-lg-9" style="padding-left: 40px;">
			<div class="col-lg-6">
					<h3 class="card-title"><?php echo $name; ?></h3>
					<h6 class="card-text">Created <?php echo date($timestamp); ?></h6>
					<h6 class="card-text">Owner: <?php echo userUuidToName($conn, $user_uuid); ?></h6></br>
				</div>
				<div class="col-lg-6">
					<div class="btn-group" style="float: right; margin-top: 15px;">
						<a class="btn btn-secondary dropdown-toggle" role="button" data-toggle="dropdown">Update</a>
						<div class="dropdown-menu">
							<button class="dropdown-item" href="" type="button" name="title" data-toggle="modal" data-target="#edit-title-modal">Edit title</button>
							<button class="dropdown-item" href="" type="button" name="art" data-toggle="modal" data-target="#edit-art-modal">Edit art</button>
							<button class="dropdown-item" href="" type="button" name="bounce" data-toggle="modal" data-target="#edit-bounce-modal">Edit bounce</button>
							<button class="dropdown-item" href="" type="button" name="bounce" data-toggle="modal" data-target="#edit-lyrics-modal">Edit lyrics</button>
							<div class="dropdown-divider"></div>
							<button class="dropdown-item" href="" type="button" name="bounce" data-toggle="modal" data-target="#edit-stems-modal">Add stems</button>
						</div>
					</div>
				</div>
		</div>
	</div>
</div>
<?php if($_SESSION['role'] == 'admin') { ?>
<form method="post">
<button type="submit" name="deleteproject" class="btn btn-danger btn-sm" style="margin-bottom: 15px;">Delete project</button>
<?php if(isset($_POST['deleteproject'])) {
deleteProject($conn, $uuid);
header('location:index.php?alert=projdel&name='.$name);
} ?> </form> <?php } ?>
<div class="container projectmid">
	<div class="col-lg-6">
		<div class="well">
			<h4>Bounce</h4>
<?php bounce($conn, $uuid); ?>
		</div>
		<div class="well">
			<h4>Stems</h4>
<?php stems($conn, $uuid); ?>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="well">
			<h4>
				Lyrics
			</h4>
			<p style="white-space: pre-wrap;">
<?php
if ($lyrics == "") {
	echo "<i>none</i>";
} else {
	echo $lyrics;
}
?>
			</p>
		</div>
	</div>
</div>

<?php
require_once 'includes/project_modals.inc.php';
require_once 'includes/footer.inc.php';
?>