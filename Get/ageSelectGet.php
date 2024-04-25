<?php

function getMovieID($conn) {
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["movie_id"]) && isset($_SESSION["email"])) {

        $movie_id = $_GET["movie_id"];
        require_once "includes/dbh.inc.php";

        $sql = "SELECT * FROM movies WHERE movie_id = ?";

        
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: booking.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $movie_id);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt); // Fetch single movie

        
        $movie = mysqli_fetch_assoc($resultData);

        if (!$movie) { // Check if movie found
            echo "<p>Movie not found.</p>";
        }

    } else {
    header("Location: index.php"); // Redirect if no movie ID
    }
    return $movie;

}