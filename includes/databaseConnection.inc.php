<?php

$dsn = "mysql:host=movies.c1escyq2w908.us-east-1.rds.amazonaws.com;dbname=movies";
$dbusername = "admin";
$dbpassword = "passworda2movies";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);//grabbing the info from database
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //error handling
    return $pdo;
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
