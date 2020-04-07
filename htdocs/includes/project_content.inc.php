<?php

require_once 'includes/functions.inc.php';

    $requested_uuid = htmlspecialchars($_GET["uuid"]);

    $sql = 'SELECT * FROM projects WHERE uuid = '.$requested_uuid.';';
    $result = mysqli_query($conn, $sql);
    $resultRows = mysqli_num_rows($result);

    if ($resultRows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $uuid = $row['uuid'];
            $user_uuid = $row['user_uuid'];
            $name = $row['name'];
            $lyrics = $row['lyrics'];
            $timestamp = $row['timestamp'];
        }
    } else {
        echo "Could not find this project...";
        header("location:index.php?alert=notexist");
        exit;
    }

    $art = "user-databank/".getProjectFile($conn, $uuid, 'all', 'art');
    $bounce_filetype = getProjectFile($conn, $uuid, 'filetype', 'bounce');

    $download_name = $name." - ".$timestamp.".".$bounce_filetype;

    // Art handling
    if ($art == "user-databank/") {
        $art = "sys/noart.jpg";
    }