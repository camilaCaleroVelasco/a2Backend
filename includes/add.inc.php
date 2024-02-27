<?php
include_once 'includes/databaseConnection.inc.php';
$movie_title = $_POST[' movie_title'];
$category = $_POST['category'];
$director = $_POST['director'];
$producer = $_POST['producer'];
$synopsis = $_POST['synopsis'];
$reviews = $_POST['reviews'];
$picture = $_POST['picture'];
$video = $_POST['video'];
$rating_code = $_POST['rating_code'];
$movie_status = $_POST['movie_status'];


    $sql = "INSERT INTO Movies(
        movie_title,
        category,
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
        '$director',
        '$producer',
        '$sypnosis',
        '$reviews',
        '$picture',
        '$video',
        '$rating_code',
        '$movie_status'
    );";

$sql = "INSERT INTO Movie_Cast(cast1, cast2, cast3, cast4, cast5)
        VALUES(
        'Liam Hemsworth',
        'Russel Crowe',
        'Luke Hemsworth',
        'Ricky Whittle',
        'Milo Ventimiglia'
    );";
    
    mysqli_query($conn, $sql);
    header("Location: ../adminmovie..php?sigup=sucess");

