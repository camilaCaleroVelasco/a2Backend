<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

    session_start();
    require_once "functions/checkIfAdminFunction.php"; 
    include "includes/dbh.inc.php";

    // Makes sures that the user is an admin
    checkIfAdmin();

    // Get movieID
    $movieID =  $_GET['movie_id'];

    if (!$movieID) {
        echo "movieID not found $movieID";
        exit();
    }

    $overlaps= []; //hold overlapping shows times
    $_SESSION['overlaps'] = $overlaps;
    
    

    try{

        // Check if the button was pressed
        if(isset($_POST['submit'])){
            $dates = $_POST['date'];
            $timesArr = $_POST['times'];
            $roomIDs = $_POST['room_id'];
            

            // Loop through dates
            foreach ($dates as $index => $date) {
                // Get time for each date
                $times = array_filter(explode(',', $timesArr[$index])); // Filter out empty times
                foreach($times as $time) {
                    $roomID = $roomIDs[$index];

                    // Check if the time selected overlaps with an existing showtime in the same room and date
                    $sqlCheckOverlap = "SELECT COUNT(*) FROM Showing WHERE room_id = ? AND showDate = ? AND showTime = ?";
                    $stmtCheckOverlap = $conn->prepare($sqlCheckOverlap);
                    $stmtCheckOverlap->bind_param("iss", $roomID, $date, $time);
                    $stmtCheckOverlap->execute();
                    $stmtCheckOverlap->bind_result($overlapCount);
                    $stmtCheckOverlap->fetch();
                    $stmtCheckOverlap->close();

                    if($overlapCount == 0) {
                        $sqlSchedule = "INSERT INTO Showing (movie_id, room_id, showDate, showTime) VALUES (?, ?, ?, ?)";
                        $stmtSchedule = $conn->prepare($sqlSchedule);
                        if(!$stmtSchedule){
                            echo "Error: " . $conn->error;
                        }
                        $stmtSchedule->bind_param("iiss", $movieID, $roomID, $date, $time);

                        if(!$stmtSchedule->execute()) {
                            echo "Error adding Showtime: " . $stmtSchedule->error;
                        }

                        $stmtSchedule->close();
                    }
                    else {
                        $overlaps[] = "Showtime exists in room $roomID on $date at $time.";
                    }
                }
            }
        }
        if(!empty($overlaps)) {
            // Display a message if there's an overlap
            echo "<script>alert('Overlap Detected:\\n" . implode("\\n", $overlaps) . "');</script>";
            // Redirect back to the form without processing
            echo "<script>window.history.back();</script>";
            exit();
        }
        
        header("Location: adminmovie.php?success=1");
    } catch (Exception $e){
        die("Error: " . $e->getMessage());

    }

