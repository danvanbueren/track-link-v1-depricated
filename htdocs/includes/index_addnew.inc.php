<?php
	if(isset($_POST['Submit'])){

		$varUserUuid = $_SESSION['uuid'];
		$varName = $_POST['name'];
		$varTimestamp = date("Y-m-d H:i:s", time());

		$sql = 'INSERT INTO projects (uuid, user_uuid, name, lyrics, timestamp) VALUES (NULL, '.$varUserUuid.', "'.$varName.'", "", "'.$varTimestamp.'");';
		$result = mysqli_query($conn, $sql);

		if($result) {
			$last_id = mysqli_insert_id($conn);
			header('location:project.php?uuid='.$last_id);
		} else {
?>

			<script type="text/javascript">
				$(document).ready(function() {
					$('#add-new-modal').modal('show');
				});
			</script>

<?php
		}
	}