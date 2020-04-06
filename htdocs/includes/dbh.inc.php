<?php

require_once 'functions.inc.php';

$dbServername = getUserConfig('sql-server-name');
$dbUsername = getUserConfig('sql-username');
$dbPassword = getUserConfig('sql-password');
$dbName = getUserConfig('sql-database');

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

if(!$conn) {
	$connStatement = '<i class="material-icons md-18">link_off</i> Connection failed - check your configuration! </br><i>'.mysqli_connect_error().'</i>';
}else{
	$connStatement = '<i class="material-icons md-18">link</i> Connection established';
}