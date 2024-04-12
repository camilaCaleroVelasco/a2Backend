<?php

session_start();
require_once "functions/checkIfAdminFunction.php"; 
include "includes/dbh.inc.php";

// Checks if user is admin
checkIfAdmin();

if (!$conn) {  

  die('Could not connect: '.mysqli_connect_error());  

}  

$movie_title = $_POST['movie_title'];
$category = $_POST['category'];
$director = $_POST['director'];
$producer = $_POST['producer'];
$synopsis = $_POST['synopsis'];
$reviews = $_POST['reviews'];
$picture = $_POST['picture'];
$video = $_POST['video'];
$rating_code = $_POST['rating_code'];
$movie_status = $_POST['movie_status'];
$cast = $_POST['cast'];

$sql = "INSERT INTO Movies(
    movie_title,
    category,
    cast,
    director,
    producer,
    synopsis,
    reviews,
    picture,
    video,
    rating_code,
    movie_status
)
VALUES (
        '$movie_title',
        '$category',
        '$cast',
        '$director',
        '$producer',
        '$synopsis',
        '$reviews',
        '$picture',
        '$video',
        '$rating_code',
        '$movie_status'
    );";

if (mysqli_query($conn, $sql)) {

    $success = 1;

} else {  

    echo "Could not insert record: ". mysqli_error($conn);  

}  
   
if (isset($success)) {
 
    header("Location: addMovie.php?success=1");
    exit();
} 

