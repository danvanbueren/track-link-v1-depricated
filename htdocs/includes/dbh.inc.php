<?php

$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "key1";
$dbName = "tracklink";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

if(!$conn) {
	$connStatement = '<i class="material-icons md-18">link_off</i> Connection failed <i>'.mysqli_connect_error().'</i>';
}else{
	$connStatement = '<i class="material-icons md-18">link</i> Connection established';
}