<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once "functions/checkIfAdminFunction.php"; 
    include "includes/dbh.inc.php";

    

    // Get the dates available in the DB
    function getDates($conn, $movie_id){
        $sqlDates = "SELECT DISTINCT showDate FROM Showing WHERE movie_id = ? ORDER BY showDate ASC";
        $stmtDates = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmtDates, $sqlDates)) {
            header("Location: booking.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmtDates, "i", $movie_id);
        mysqli_stmt_execute($stmtDates);

        $resultDates = mysqli_stmt_get_result($stmtDates);

        $availableDates = array();
        while ($row = mysqli_fetch_assoc($resultDates)) {
            if (isset($row['showDate']) && !empty($row['showDate'])) {
                $dateComponents = explode("-", $row['showDate']);
                $timestamp = mktime(0, 0, 0, $dateComponents[1], $dateComponents[2], $dateComponents[0]);
                $dayOfWeek = date('N', $timestamp); 
                $dayName = date('l', $timestamp);
                if (!empty($row['showDate'])) {
                    $dayName = date('D', strtotime($row['showDate']));
                } else {
                    $dayName = "Unknown";
                }
                $availableDates[] = array(
                    "showDate" => $row['showDate'],
                    "year" => $dateComponents[0],
                    "month" => $dateComponents[1],
                    "day" => $dateComponents[2],
                    "dayOfWeek" => $dayOfWeek,
                    "dayName" => $dayName
                );
            }
        }
        return $availableDates;
    }

    // Get the times available
    function getTimes($conn, $movie_id) {
        $sqlTimes = "SELECT showDate, showTime FROM Showing WHERE movie_id = ?";
        $stmtTimes = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmtTimes, $sqlTimes)) {
            header("Location: booking.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmtTimes, "i", $movie_id);
        mysqli_stmt_execute($stmtTimes);
        $resultTimes = mysqli_stmt_get_result($stmtTimes);

        $availableTimes = array();
        while ($row = mysqli_fetch_assoc($resultTimes)) {
            $showDate = $row['showDate'];
            $showTime = $row['showTime'];
            $availableTimes[$showDate][] = $showTime;
        }

        return $availableTimes;

    }

    // Get the available seats
    function getSeatAvailability($conn, $show_id) {
        $sql = "SELECT * FROM seats WHERE show_id = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: booking.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "i", $show_id);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);

        $bookingAvailability = array();
        while ($row = mysqli_fetch_assoc($results)) {
            $seatRow = $row['seatRow'];
            $seatCol = $row['seatColumn'];
            $isAvailable = $row['isAvailable'];
            $bookingAvailability[$seatRow][$seatCol] = $isAvailable;
        }

        return  $bookingAvailability;

    }


    function getShowTimesByMovieIDAndDate($conn, $movie_id, $date) {
        $sql = "SELECT DISTINCT showTime FROM showing WHERE movie_id = ? AND showDate = ?";
        $stmt = $conn->prepare($sql);
        
        $stmt->bind_param("is", $movie_id, $date);
        $stmt->execute();

        $result = $stmt->get_result();

        $showTimes = array();
        while ($row = $result->fetch_assoc()) {
            $showTimes[] = $row['showTime'];
        }
        $stmt->close();
        
        return $showTimes;
    }

    function getShowId($conn, $showDate, $showTime, $movie_id) {
        $sql = "SELECT show_id FROM Showing WHERE showDate = ? AND showTime = ? AND movie_id = ?";
        $stmt = $conn->prepare($sql);
    
        if (!$stmt) {
            error_log("Statement preparation failed: " . $conn->error);
            header("Location: booking.php?error=stmtfailed");
            exit();
        }
    
        $stmt->bind_param("ssi", $showDate, $showTime, $movie_id);
        $stmt->execute();
    
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    
        $stmt->close();
    
        return $row ? $row['show_id'] : null;
    }
    
    // Helper function to pass parameters by reference
    function refValues($arr){
        $refs = array();
        foreach($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }