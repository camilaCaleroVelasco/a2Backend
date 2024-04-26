<?php

$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "movies";

// $servername = "movies.c1escyq2w908.us-east-1.rds.amazonaws.com";
// $dBUsername = "admin";
// $dBPassword = "passworda2movies";
// $dBName = "movies";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}

return $conn;

