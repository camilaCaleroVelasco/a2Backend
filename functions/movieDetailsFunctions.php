<?php

// Connect to DB andfind movie info, if not found return false
function getMovieInfo($conn, $movie_id) {
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

function getMovieCategory($conn, $category_id) {
    $sql = "SELECT * FROM moviecategory WHERE category_id = ?";

    $stmt = mysqli_stmt_init($conn);

    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: adminDetails.php?error=stmtfailed"); 
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $category_id);
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
