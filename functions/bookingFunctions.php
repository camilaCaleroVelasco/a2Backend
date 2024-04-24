<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    require_once "functions/checkIfAdminFunction.php"; 
    include "includes/dbh.inc.php";

    

    // Get the dates available in the DB
    function getDates($conn, $movie_id){
        $sqlDates = "SELECT DISTINCT showDate FROM Showing WHERE movie_id = ?";
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