<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once "functions/checkIfAdminFunction.php";
include "includes/dbh.inc.php";

// Checks if user is admin
checkIfAdmin();

if (!$conn) {

    die('Could not connect: ' . mysqli_connect_error());

}

// Get category_id
$category = $_POST['category'];
$sqlCategory = "SELECT category_id FROM moviecategory WHERE category = ?";
$stmtCategory = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmtCategory, $sqlCategory)) {
    header("Location: addMovie.php?error=stmtfailed");
    exit();
}
mysqli_stmt_bind_param($stmtCategory, "s", $category);
mysqli_stmt_execute($stmtCategory);
$resultCategory = mysqli_stmt_get_result($stmtCategory);
$categoryRow = mysqli_fetch_assoc($resultCategory);
$category_id = $categoryRow['category_id'];

// Insert into DB
$movie_title = $_POST['movie_title'];
$director = $_POST['director'];
$producer = $_POST['producer'];
$synopsis = $_POST['synopsis'];
$reviews = $_POST['reviews'];
$picture = $_POST['picture'];
$video = $_POST['video'];
$rating_code = $_POST['rating_code'];
$movie_status = $_POST['movie_status'];
$cast = $_POST['cast'];

$sql = "INSERT INTO movies(
    movie_title,
    category_id,
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
        '$category_id',
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

    echo "Could not insert record: " . mysqli_error($conn);

}

if (isset($success)) {
    header("Location: addMovie.php?success=1");
    exit();
}


