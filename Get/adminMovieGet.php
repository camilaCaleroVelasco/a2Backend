<?php

session_start();
require_once "includes/dbh.inc.php";
require_once "functions/checkIfAdminFunction.php"; 

// Checks if user is admin
checkIfAdmin();

function adminMovieGet($conn, $sql) {
    $sqlNP = "SELECT * FROM movies WHERE movie_status LIKE '%now playing%'";
    $sqlCS = "SELECT * FROM movies WHERE movie_status LIKE '%coming soon%'";
    $resultNP = mysqli_query( $conn, $sqlNP ) or die("bad query: $sql");
    $resultCS = mysqli_query( $conn, $sqlCS ) or die("bad query: $sql");

    return [
        'nowPlaying' => $resultNP,
        'comingSoon' => $resultCS
    ];
}
        