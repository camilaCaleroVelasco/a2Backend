<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once "functions/checkIfAdminFunction.php"; 
    include "includes/dbh.inc.php";

    // Makes sures that the user is an admin
    checkIfAdmin();

    function getMovieInfoShowtime($conn, $movie_id) {
        $sql = "SELECT * FROM movies WHERE movie_id = ?";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: adminDetails.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $movie_id);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt); // Fetch single movie

        if ($row = mysqli_fetch_assoc($resultData)) {
            return $row;
        }
        else {
            return false;
        }
        mysqli_stmt_close($stmt);
    }

    function getMovieDetailsShowtime($conn) {
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["movie_id"])) {

            $movie_id = (int)$_GET["movie_id"];
            $result = getMovieInfoShowtime($conn, $movie_id);
            return[
                'movieInfo' => $result
            ];
        } 
        // else {
        //     header("Location: index.php"); //Redirect so DB is not accessible
        // }
    }