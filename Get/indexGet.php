<?php

    // session_start(); not needed beacuse editProfileProcess added
    //include_once 'editProfileProcess.php';
    
    

    function getMovies($conn){
        require_once "includes/dbh.inc.php";
        
        $sqlNP = "SELECT * FROM movies WHERE movie_status LIKE '%now playing%'";
        $sqlCS = "SELECT * FROM movies WHERE movie_status LIKE '%coming soon%'";
        $resultNP = mysqli_query( $conn, $sqlNP ) or die("bad query: $sql");
        $resultCS = mysqli_query( $conn, $sqlCS ) or die("bad query: $sql");

        return[
            'nowPlaying' => $resultNP,
            'comingSoon' => $resultCS
        ];
    }

   