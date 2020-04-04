<?php
if($isEditRequest) {
	$sql = 'SELECT description FROM projectfiles WHERE projectfiles.uuid = '.$editDescFileId.';';
	$result = mysqli_query($conn, $sql);
	$resultRows = mysqli_num_rows($result);
	if($resultRows > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$currentDescription = $row['description'];
		}
	}
echo '
<div class="modal fade" id="edit-desc-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Description</h5>
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="post" name="edit-desc-form">
					<label for="description" class="sr-only">Description</label>
					<input name="description" type="text" id="description" class="form-control" placeholder="Description" value="'.$currentDescription.'" required>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button name="savedescedit" class="btn btn-primary" type="submit">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
';
	if (isset($_POST['savedescedit'])) {
		$postDesc = $_POST['description'];
		if ($currentDescription != $postDesc) {
			$sql = 'UPDATE projectfiles SET description = "'.$postDesc.'" WHERE projectfiles.uuid = '.$editDescFileId.';';
			$result = mysqli_query($conn, $sql);
		}
		header('location: project.php?uuid='.$uuid);
	}
}


if($isDelRequest) {
	$sql = 'SELECT * FROM projectfiles WHERE projectfiles.uuid = '.$delFileId.';';
	$result = mysqli_query($conn, $sql);
	$resultRows = mysqli_num_rows($result);
	if($resultRows > 0) {
		while ($row = mysqli_fetch_assoc($result)) {
			$description = $row['description'];
			$filetype = $row['filetype'];

		}
	}
echo '
<div class="modal fade" id="del-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Confirm deletion</h5>
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="post" name="del-form">
					<h6>This cannot be undone. Are you sure you want to delete '.$description.'?</h6>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button name="deletefile" class="btn btn-danger" type="submit">Delete</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
';
	if (isset($_POST['deletefile'])) {
		$filename = 'user-databank/'.$delFileId.'.'.$filetype;
		unlink($filename);

		$sql = 'DELETE FROM projectfiles WHERE projectfiles.uuid = '.$delFileId.';';
		$result = mysqli_query($conn, $sql);

		header('location: project.php?uuid='.$uuid);
	}
}
?>



<div class="modal fade" id="edit-title-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Title</h5>
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="post" name="edit-title-form">
					<label for="inputTitle" class="sr-only">Title</label>
					<input name="title" type="text" id="inputTitle" class="form-control" placeholder="Title" value="<?php echo $name; ?>" required>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button name="savetitle" class="btn btn-primary" type="submit">Save</button>
						<?php
						if(isset($_POST['savetitle'])){
							$newTitle = $_POST['title'];
							if ($newTitle != $name) {
								$que = 'UPDATE projects SET name = "'.$newTitle.'" WHERE projects.uuid = '.$uuid.';';
								$res = mysqli_query($conn, $que);
								header('refresh: 0');
							}
						}
						?>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="edit-art-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Art</h5>
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="POST" name="edit-art-form" enctype="multipart/form-data">
					<label for="file">Select image</label>
					<input name="file" type="file" id="file" class="form-control" accept="image/*" required>
					<label for="description">Description</label>
					<input name="description" type="text" id="description" class="form-control" placeholder="Description">

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button name="submitart" class="btn btn-primary" type="submit">Save</button>

						<?php

						uploadArt($conn, $uuid);

						?>

					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="edit-bounce-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Bounce</h5>
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="POST" name="edit-bounce-form" enctype="multipart/form-data">
					<label for="file">Select audio</label>
					<input name="file" type="file" id="file" class="form-control" accept="audio/*" required>
					<label for="description">Description</label>
					<input name="description" type="text" id="description" class="form-control" placeholder="Description">

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button name="submitbounce" class="btn btn-primary" type="submit">Save</button>

						<?php

						uploadBounce($conn, $uuid);

						?>

					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="edit-stems-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Stems</h5>
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form action="" method="POST" name="edit-stems-form" enctype="multipart/form-data">
					<label for="file">Select audio</label>
					<input name="files[]" type="file" id="file" class="form-control" accept="audio/*" multiple required>
					<label for="description">Description</label>
					<input name="description" type="text" id="description" class="form-control" placeholder="Description">
					<h6>Note: Description will be applied to all audio files uploaded</h6>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button name="submitstems" class="btn btn-primary" type="submit">Save</button>

						<?php

						uploadStems($conn, $uuid);

						?>

					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="edit-lyrics-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Lyrics</h5>
				<button type="button" class="close" data-dismiss="modal">
					<span>&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="" method="POST" name="edit-lyrics-form" enctype="multipart/form-data">
					<textarea class="form-control" id="lyrics" name="lyrics" rows="25" placeholder="Lyrics"><?php echo $lyrics; ?></textarea>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button name="submitlyrics" class="btn btn-primary" type="submit">Save</button>

						<?php

						updateLyrics($conn, $uuid);

						?>

					</div>
				</form>
			</div>
		</div>
	</div>
</div>