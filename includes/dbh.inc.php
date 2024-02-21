<?php

$dsn = "mysql:host=localhost;dbname=movies";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);//grabbing the info from database
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //error handling
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
