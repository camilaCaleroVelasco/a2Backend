<?php
    session_start();

    require_once "includes/dbh.inc.php";
    require_once "functions/movieDetailsFunctions.php";
    require_once "functions/checkIfAdminFunction.php"; 
    

    // Checks if user is admin
    checkIfAdmin();

    // Gets movieDetails
    function getAdminDetails($conn) {
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["movie_id"])) {

            $movie_id = $_GET["movie_id"];
            $result = getMovieInfo($conn, $movie_id);
            $category = getMovieCategory($conn, $result['category_id']);
            return[
                'movieInfo' => $result,
                'category' => $category
            ];
        } 
        else {
            header("Location: index.php"); //Redirect so DB is not accessible
        }
    }