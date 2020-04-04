<?php

function timeToAgo($time, $rcs = 0) {
	$current_time = time();
	$difference = $current_time - $time;
	$units = array('second', 'minute', 'hour', 'day', 'week', 'month', 'year', 'decade');
	$length = array(1, 60, 3600, 86400, 604800, 2630880, 31570560, 315705600);
	for($v = sizeof($length) - 1; ($v >= 0) && (($no = $difference / $length[$v]) <= 1); $v--);
		if($v < 0)
			$v = 0;
	$_time = $current_time - ($difference % $length[$v]);
	$no = floor($no);
	if ($no <> 1)
		$units[$v] .= 's';
	$x = sprintf("%d %s ", $no, $units[$v]);
	if (($rcs == 1) && ($v >= 1) && (($current_time - $_time) > 0))
		$x .= time_ago($_time);
	return $x;
}



function userUuidToName($conn, $uuid) {
	$r = mysqli_query($conn, 'SELECT name FROM users WHERE uuid = '.$uuid.';');
	$rc = mysqli_num_rows($r);
	if($rc > 0) {
		while ($ro = mysqli_fetch_assoc($r)) {
			$name = $ro['name'];
		}
	} else {
		$name = "lookup failed! ".$uuid;
	}
	return $name;
}



function getProjectFile($conn, $projectUuid, $data, $role) {
	if (($data == 'uuid' || $data == 'filetype' || $data == 'all') && ($role == 'art' || $role == 'bounce' || $role == 'stem'))
	{
		if ($data == 'all') {
			$data = 'uuid, filetype'; 
		}
		$sql = 'SELECT '.$data.' FROM projectfiles WHERE (proj_uuid = '.$projectUuid.') AND (role = "'.$role.'");';
		$result = mysqli_query($conn, $sql);
		$resultRows = mysqli_num_rows($result);
		if($resultRows > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				if ($data == 'uuid, filetype') {
					return $row['uuid'].'.'.$row['filetype'];
				}
				return $row[$data];
			}
		}
	}
	return '';
}



function getAudioPlayer($conn, $projectUuid, $projectFileUuid, $name, $filetype, $audio, $user, $date) {
	$download_name = $name." - ".$date.".".$filetype;
	$playerType = 'mpeg';
	switch ($filetype) {
		case 'wav':
			$playerType = 'wav';
			break;
		case 'ogg':
			$playerType = 'ogg';
			break;
	}
	return '
		<div class="panel panel-default">
			<div class="panel-heading">
				<h6 class="panel-title">'.$name.' <span class="badge">'.$filetype.'</span>
					<a class="customlogout glow" href="project.php?uuid='.$projectUuid.'&eid='.$projectFileUuid.'" role="button" style="float:right;">
					<i class="material-icons md-18">edit</i></a>
				</h6>
			</div>
			<div class="panel-body">
				<audio id="player" controls>
					<source src="'.$audio.'" type="audio/'.$playerType.'" />
				</audio>

				<a class="customlogout glow" href="'.$audio.'" role="button" download="'.$download_name.'">
					<i class="material-icons md-18">cloud_download</i></a>

				<a class="customlogout glow" href="project.php?uuid='.$projectUuid.'&did='.$projectFileUuid.'" role="button" style="float:right;">
					<i class="material-icons md-18">delete</i></a>

				<p><i>Uploaded by '.userUuidToName($conn, $user).' <a title="'.$date.'" data-toggle="tooltip" data-placement="bottom">'.timeToAgo(strtotime($date)).'</a>ago</i></p>
			</div>
		</div>
	';
}



function updateDescription($conn, $projectFileUuid, $newDesc) {

$sql = 'UPDATE projectfiles SET description = "'.$newDesc.'" WHERE projectfiles.uuid = '.$projectFileUuid.';';
mysqli_query($conn, $sql);

}



function deleteProject($conn, $uuid) {
	$sqlA = 'SELECT * FROM projectfiles WHERE projectfiles.proj_uuid = '.$uuid.';';
	$resultA = mysqli_query($conn, $sqlA);
	$resultACheck = mysqli_num_rows($resultA);
	if ($resultACheck > 0) {
		while ($row = mysqli_fetch_assoc($resultA)) {
			$fileuuid = $row['uuid'];
			$path = "user-databank/".$fileuuid.".".$row['filetype'];
			deleteProjectFile($conn, $fileuuid, $path);
		}
	}
	$sql = 'DELETE FROM projects WHERE projects.uuid = '.$uuid.';';
	$result = mysqli_query($conn, $sql);
}



function deleteProjectFile($conn, $project_file_uuid, $path_to_file) {
	unlink($path_to_file);
	$sql = 'DELETE FROM projectfiles WHERE projectfiles.uuid = '.$project_file_uuid.';';
	mysqli_query($conn, $sql);
}



function stems($conn, $projectUuid) {
	$sql = 'SELECT * FROM projectfiles WHERE proj_uuid = '.$projectUuid.' AND role = "stem" ORDER BY time_uploaded DESC;';
	$x = mysqli_query($conn, $sql);
	$xR = mysqli_num_rows($x);
	if ($xR > 0) {
		while ($r = mysqli_fetch_assoc($x)) {
			$stem_uuid = $r['uuid'];
			$stem_user_uuid = $r['user_uuid'];
			$stem_description = $r['description'];
			$stem_filetype = $r['filetype'];
			$stem_time = $r['time_uploaded'];
			$path_to_audio = 'user-databank/'.$stem_uuid.'.'.$stem_filetype;
			echo getAudioPlayer($conn, $projectUuid, $stem_uuid, $stem_description, $stem_filetype, $path_to_audio, $stem_user_uuid, $stem_time);
		}
	} else {
		echo "<i>none</i>";
	}
}



function bounce($conn, $projectUuid) {
	$sql = 'SELECT * FROM projectfiles WHERE proj_uuid = '.$projectUuid.' AND role = "bounce" ORDER BY time_uploaded DESC;';
	$x = mysqli_query($conn, $sql);
	$xR = mysqli_num_rows($x);
	if ($xR > 0) {
		while ($r = mysqli_fetch_assoc($x)) {
			$stem_uuid = $r['uuid'];
			$stem_user_uuid = $r['user_uuid'];
			$stem_description = $r['description'];
			$stem_filetype = $r['filetype'];
			$stem_time = $r['time_uploaded'];
			$path_to_audio = 'user-databank/'.$stem_uuid.'.'.$stem_filetype;
			echo getAudioPlayer($conn, $projectUuid, $stem_uuid, $stem_description, $stem_filetype, $path_to_audio, $stem_user_uuid, $stem_time);
		}
	} else {
		echo "<i>none</i>";
	}
}


function getAlert($type, $title, $description, $dismissible) {
	$result = 'Function was called incorrectly';
	$type = strtolower($type);
	$allowed_types = array('primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark');
	if ($dismissible) {
		$dismiss1 = ' alert-dismissible';
		$dismiss2 = '<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>';
	} else {
		$dismiss1 = '';
		$dismiss2 = '';
	}
	if (in_array($type, $allowed_types)) {
		$result = '
			<div class="alert alert-'.$type.$dismiss1.'" role="alert">
				'.$dismiss2.'
				<strong>'.$title.':</strong> '.$description.'
			</div>
		';
	}
	return $result;
}



function getAllAlerts($GETvarName) {
	switch($GETvarName) {
		case 'extension':
			echo getAlert('danger', 'Danger', 'Upload error - <i>illegal extension exception</i>', true);
			break;
		case 'size':
			echo getAlert('danger', 'Danger', 'Upload error - <i>illegal size exception</i>', true);
			break;
		case 'general':
			echo getAlert('danger', 'Danger', 'Upload error - <i>general exception</i>', true);
			break;
		case 'notexist':
			echo getAlert('danger', 'Alert', 'Project does not exist!', true);
			break;
		case 'projdel':
			echo getAlert('info', 'Info', 'Project deleted', true);
			break;
	}
}



function uploadArt($conn, $projUuid) {

if (isset($_POST['submitart'])) {
	$errorcatch = "project.php?uuid=".$projUuid."&";

	$varTimestamp = date("Y-m-d H:i:s", time());

	$file = $_FILES['file'];

	$fileName = $_FILES['file']['name'];
	$fileTmpName = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileError = $_FILES['file']['error'];
	$fileType = $_FILES['file']['type'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	$allowed = array('apng', 'bmp', 'gif', 'jpg', 'jpeg', 'jfif', 'pjpeg', 'pjp', 'png', 'svg');

	$description = $_POST['description'];

	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0) {
			// 25MB upload limit on album art
			if ($fileSize < 25000000) {


				// check if art already exists
				$sql = 'SELECT * FROM projectfiles WHERE projectfiles.proj_uuid = '.$projUuid.' AND role = "art";';
				$result = mysqli_query($conn, $sql);
				$numR = mysqli_num_rows($result);

				$fileUuid = "file uuid was never set";

				if ($numR > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						// art exists, delete the old one first
						unlink('user-databank/'.$row['uuid'].'.'.$row['filetype']);
						$sql = 'DELETE FROM projectfiles WHERE projectfiles.proj_uuid = '.$row['proj_uuid'].' AND role = "'.$row['role'].'";';
						$result3 = mysqli_query($conn, $sql);
					}
				}

				// add new art into sql
				$sql = 'INSERT INTO projectfiles (uuid, proj_uuid, user_uuid, role, description, filetype, time_uploaded) VALUES (NULL, "'.$projUuid.'", "'.$_SESSION['uuid'].'", "art", "'.$description.'", "'.$fileActualExt.'", "'.$varTimestamp.'");';
				$result2 = mysqli_query($conn, $sql);

				// name file from sql uuid, then save
				$fileUuid = mysqli_insert_id($conn);
				$fileNameNew = $fileUuid.".".$fileActualExt;
				$fileDestination = 'user-databank/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
			} else {
				echo "Your file is too large!";
				$errorcatch = $errorcatch."uploaderror=size&";
			}
		} else {
			echo "There was an error uploading your file!";
			$errorcatch = $errorcatch."uploaderror=general&";
		}
	} else {
		echo "You cannot upload files of this type!".$fileExt."why";
		$errorcatch = $errorcatch."uploaderror=extension&";
	}

	$errorcatch = substr($errorcatch, 0, -1);
	header('location: '.$errorcatch);
}
}



function uploadBounce($conn, $projUuid) {

if (isset($_POST['submitbounce'])) {
	$errorcatch = "project.php?uuid=".$projUuid."&";

	$varTimestamp = date("Y-m-d H:i:s", time());

	$file = $_FILES['file'];
	$fileError = $_FILES['file']['error'];
	$fileName = $_FILES['file']['name'];
	$fileTmpName = $_FILES['file']['tmp_name'];
	$fileSize = $_FILES['file']['size'];
	$fileType = $_FILES['file']['type'];

	$fileExt = explode('.', $fileName);
	$fileActualExt = strtolower(end($fileExt));

	$allowed = array('mp3', 'wav', 'ogg');

	$description = $_POST['description'];

	if (in_array($fileActualExt, $allowed)) {
		if ($fileError === 0) {
			// file can be no larger than 256MB (php.ini post_max_size && upload_max_filesize setting)
			if ($fileSize < 256000000) {


				// check if bounce already exists
				$sql = 'SELECT * FROM projectfiles WHERE projectfiles.proj_uuid = '.$projUuid.' AND role = "bounce";';
				$result = mysqli_query($conn, $sql);
				$numR = mysqli_num_rows($result);

				$fileUuid = "file uuid was never set";

				if ($numR > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						// bounce exists, delete the old one first
						unlink('user-databank/'.$row['uuid'].'.'.$row['filetype']);
						$sql = 'DELETE FROM projectfiles WHERE projectfiles.proj_uuid = '.$row['proj_uuid'].' AND role = "'.$row['role'].'";';
						$result3 = mysqli_query($conn, $sql);
					}
				}

				// add new bounce into sql
				$sql = 'INSERT INTO projectfiles (uuid, proj_uuid, user_uuid, role, description, filetype, time_uploaded) VALUES (NULL, "'.$projUuid.'", "'.$_SESSION['uuid'].'", "bounce", "'.$description.'", "'.$fileActualExt.'", "'.$varTimestamp.'");';
				$result2 = mysqli_query($conn, $sql);

				// name file from sql uuid, then save
				$fileUuid = mysqli_insert_id($conn);
				$fileNameNew = $fileUuid.".".$fileActualExt;
				$fileDestination = 'user-databank/'.$fileNameNew;
				move_uploaded_file($fileTmpName, $fileDestination);
			} else {
				echo "Your file is too large!";
				$errorcatch = $errorcatch."uploaderror=size&";
			}
		} else {
			echo "There was an error uploading your file!";
			$errorcatch = $errorcatch."uploaderror=general&";
		}
	} else {
		echo "You cannot upload files of this type!".$fileExt."why";
		$errorcatch = $errorcatch."uploaderror=extension&";
	}

	$errorcatch = substr($errorcatch, 0, -1);
	header('location: '.$errorcatch);
}
}



function updateLyrics($conn, $projUuid) {
	if (isset($_POST['submitlyrics'])) {

		$lyrics = $_POST['lyrics'];

		$sql = 'UPDATE projects SET lyrics = "'.$lyrics.'" WHERE projects.uuid = '.$projUuid.';';
		$result = mysqli_query($conn, $sql);

		header('location: project.php?uuid='.$projUuid);
	}
}



function uploadStems($conn, $projUuid) {

if(isset($_POST['submitstems'])) {
	$varTimestamp = date("Y-m-d H:i:s", time());
	$allowed_types = array('mp3', 'wav', 'ogg');
	$description_pre = $_POST['description'];

	if(!empty(array_filter($_FILES['files']['name']))) {
		foreach ($_FILES['files']['tmp_name'] as $key => $value) {

			$file_tmpname = $_FILES['files']['tmp_name'][$key];
			$file_name = $_FILES['files']['name'][$key];
			$file_size = $_FILES['files']['size'][$key];
			$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);

			$description = $description_pre.' ('.$file_name.')';

			if(in_array(strtolower($file_ext), $allowed_types)) {
				if ($file_size < 256000000) {

					$sql = 'INSERT INTO projectfiles (uuid, proj_uuid, user_uuid, role, description, filetype, time_uploaded) VALUES (NULL, "'.$projUuid.'", "'.$_SESSION['uuid'].'", "stem", "'.$description.'", "'.strtolower($file_ext).'", "'.$varTimestamp.'");';
					$result = mysqli_query($conn, $sql);

					// name file from sql uuid, then save
					$filepath = 'user-databank/'.mysqli_insert_id($conn).'.'.$file_ext;
					move_uploaded_file($file_tmpname, $filepath);
				}
			}
		}
	}
	header('location: project.php?uuid='.$projUuid);
}

}






