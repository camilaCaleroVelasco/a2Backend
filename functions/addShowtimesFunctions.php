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

    function getRooms($conn) {
        $sqlRooms = "SELECT room_id, roomTitle, roomNumber FROM Room";
        $result = mysqli_query($conn, $sqlRooms);
        $rooms = [];
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $rooms[] = $row;
            }
        }
        else {
            echo "There was no rooms found";
        }
        return $rooms;
    }

    function getShowTimes($conn) {
        $showTimes = array();

        // Prepare SQL statement to fetch show times for the given room
        $sql = "SELECT showPeriod_id, startTime FROM ShowPeriod";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch and store the show times in an array
        while ($row = $result->fetch_assoc()) {
            $showTimes[$row['showPeriod_id']][] = $row['startTime'];
        }

        // Close the statement and return the show times
        $stmt->close();
        return $showTimes;
    }