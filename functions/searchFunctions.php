<?php

    /**
     * Connects to the DB and searches using given movie title.
     * Returns results if found, false otherwise.
     */
    function searchMovieTitle($conn, $search) {
        $sql = "SELECT * FROM movies WHERE movie_title LIKE '%$search%'";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: search.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        $results = array();

        while ($row = mysqli_fetch_assoc($resultData)) {
            $results[] = $row;
        }

        mysqli_stmt_close($stmt);

        if (!empty($results)) {
            return $results;
        } else {
            return false;
        }
    }

    /**
     * Connects to the DB and searches using given movie category.
     * Returns results if found, false otherwise.
     */
    function searchMovieCategory($conn, $search) {

        $movieCategoryID = getMovieCategoryID($conn, $search);

        if($movieCategoryID == false) {
        return false;
        }

        $sql = "SELECT * FROM movies WHERE category_id = ?";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: search.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $movieCategoryID);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        $results = array();

        while ($row = mysqli_fetch_assoc($resultData)) {
            $results[] = $row;
        }

        mysqli_stmt_close($stmt);

        if (!empty($results)) {
            return $results;
        } else {
            return false;
        }
    }

    /**
     * Connects to the DB and searches using category.
     * Returns category id (int) if found, false otherwise.
     * Used in: filterMoviesByCategory($conn, $status, $search)
     * This is a supplimentary method.
     */
    function getMovieCategoryID($conn, $category) {
        $sql = "SELECT * FROM moviecategory WHERE category LIKE '%$category%'";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: search.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt); // Fetch single movie

        if ($row = mysqli_fetch_assoc($resultData)) {
            return $row['category_id'];
        }
        else {
            return false;
        }
        mysqli_stmt_close($stmt);
    }

     /**
     * Connects to the DB and searches using given movie title with movie status filter.
     * Valid $status entries only include: 'coming soon' and 'now playing'.
     * Returns results if found, false otherwise.
     */
    function filterMoviesByStatus($conn, $status, $search) {
        $sql = "SELECT * FROM movies WHERE (movie_title LIKE '%$search%' AND movie_status LIKE '%$status%')";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: search.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        $results = array();

        while ($row = mysqli_fetch_assoc($resultData)) {
            $results[] = $row;
        }

        mysqli_stmt_close($stmt);

        if (!empty($results)) {
            return $results;
        } else {
            return false;
        }
    }

    /**
     * Connects to the DB and searches using given movie category with movie status filter.
     * Valid $status entries only include: 'coming soon' and 'now playing'.
     * Returns results if found, false otherwise.
     */
    function filterMoviesByCategory($conn, $status, $search) {

        $movieCategoryID = getMovieCategoryID($conn, $search);

        if($movieCategoryID == false) {
        return false;
        }

        $sql = "SELECT * FROM movies WHERE (category_id = ? AND movie_status LIKE '%$status%')";


        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: search.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $movieCategoryID);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        $results = array();

        while ($row = mysqli_fetch_assoc($resultData)) {
            $results[] = $row;
        }

        mysqli_stmt_close($stmt);

        if (!empty($results)) {
            return $results;
        } else {
            return false;
        }
    }


