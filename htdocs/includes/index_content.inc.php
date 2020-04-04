<?php

require_once 'includes/functions.inc.php';

$resultAllProjects = mysqli_query($conn, "SELECT * FROM projects ORDER BY timestamp DESC;");
$resultAllProjectsCheck = mysqli_num_rows($resultAllProjects);

if ($resultAllProjectsCheck > 0) {
	while ($row = mysqli_fetch_assoc($resultAllProjects)) {
		$pUuid = $row['uuid'];
		$uUuid = $row['user_uuid'];
		$pName = $row['name'];
		$pLastUpdated = "Added ".timeToAgo(strtotime($row['timestamp']))." ago";
		
		$pContributors = "";

		$kj = mysqli_query($conn, 'SELECT DISTINCT user_uuid FROM projectfiles WHERE proj_uuid = '.$pUuid.';');
		$kjC = mysqli_num_rows($kj);

		$pConWork = "";
		if ($kjC > 0) {
			while ($kjR = mysqli_fetch_assoc($kj)) {
				$pConWork = $pConWork.userUuidToName($conn, $kjR['user_uuid']).", ";
			}
			$pContributors = substr($pConWork, 0, -2);

		} elseif (!empty($uUuid)) {
			$pContributors = userUuidToName($conn, $uUuid)." (proj)";
		} else {
			$pContributors = "unk";
		}

		$pArt = "";
		$resultArt = mysqli_query($conn, 'SELECT uuid, filetype FROM projectfiles WHERE (proj_uuid = '.$pUuid.') AND (role = "art");');
		$resultArtCheck = mysqli_num_rows($resultArt);
		if($resultArtCheck > 0) {
			while ($rowArt = mysqli_fetch_assoc($resultArt)) {
				$pArt = "user-databank/".$rowArt['uuid'].".".$rowArt['filetype'];
			}
		} else {
			$pArt = "sys/noart.jpg";
		}

		$pBounce = "";
		$resultBounce = mysqli_query($conn, 'SELECT uuid, filetype FROM projectfiles WHERE (proj_uuid = '.$pUuid.') AND (role = "bounce");');
		$resultBounceCheck = mysqli_num_rows($resultBounce);
		if($resultBounceCheck > 0) {
			while ($rowBounce = mysqli_fetch_assoc($resultBounce)) {
				$pBounce = '<audio id="player" controls><source src="user-databank/'.$rowBounce['uuid'].'.'.$rowBounce['filetype'].'" type="audio/mpeg" /></audio>';
			}
		}

		echo '
		<div class="col-lg-6">
			<div class="card bg-dark text-white card-constrain" draggable="false" onmousedown="return false" style="user-drag: none">
				<a class="customtiles" href="project.php?uuid='.$pUuid.'">
					<img src="'.$pArt.'" class="card-img x-card-img" alt="img">
					<div class="card-img-overlay">
						<h3 class="card-title"><i class="material-icons md-18">album</i> '.$pName.'</h3>
						<p class="card-text"><i class="material-icons md-18">person</i> '.$pContributors.'</p>
						<div class="card-audio-player">
							<p class="card-text">'.$pLastUpdated.'</p>
							'.$pBounce.'
						</div>
					</div>
				</a>
			</div>
		</div>
		';
	}
} else {
	echo '<i>none</i>';
}

?>