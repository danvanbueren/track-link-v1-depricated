<?php

$uqr = mysqli_query($conn, "SELECT * FROM users;");
$uqrRows = mysqli_num_rows($uqr);
if(isset($_POST['Submit'])){
	$matchFound = false;
	if ($uqrRows > 0) {
		while ($row = mysqli_fetch_assoc($uqr)) {
			$uuid = $row['uuid'];
			$name = $row['name'];
			$hash = $row['hash'];
			$role = $row['role'];
			if (($_POST['Username'] == $name) && (password_verify($_POST['Password'], $hash))) {
				$matchFound = true;
				$_SESSION['uuid'] = $uuid;
				$_SESSION['name'] = $name;
				$_SESSION['role'] = $role;
				$_SESSION['Active'] = true;
				header("location:index.php");
				exit;
			}
		}
	}
	if(!$matchFound){
		echo '
		&nbsp;
		<div class="alert alert-danger alert-dismissible" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<strong>Warning!</strong> Incorrect information.
		</div>
		';
	}
}