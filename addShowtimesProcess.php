<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

    session_start();
    require_once "functions/checkIfAdminFunction.php"; 
    include "includes/dbh.inc.php";
    include "functions/addShowtimesFunctions.php";
    include "classes/seatinitializer.php";



    // Makes sures that the user is an admin
    checkIfAdmin();

    // Get movieID
    $movieID =  $_GET['movie_id'];
    if (!$movieID) {
        echo "movieID not found $movieID";
        exit();
    }

    // Overlapping variables
    $overlaps= []; //hold overlapping shows times
    $_SESSION['overlaps'] = $overlaps;
    
    

    try{

        // Check if the button was pressed
        if(isset($_POST['submit'])){
            // Variables
            $dates = $_POST['date'];
            $roomIDs = $_POST['room_id'];
            $showPeriodID = $_POST['times'];
            $timesArr = $_POST['times'];

            // Check if the date picked has not passed yet
            foreach($dates as $date) {
                if(!isDateValid($date)) {
                    echo '<script>alert("Error: Date ' . $date . ' has already passed!");</script>';
                    // Redirect back to the form without processing
                    echo "<script>window.history.back();</script>";
                    exit();
                    
                }
            }

            // Delete passed dates from the database
            deletePassedDate($conn, $movieID);

            // Loop through dates
            foreach ($dates as $index => $date) {
                // Get time for each date
                $times = array_filter(explode(',', $timesArr[$index])); // Filter out empty times

                foreach($times as $time) {
                    $roomID = $roomIDs[$index];

                    // Check if date and time overlaps
                    list($isOverlap, $overlapCount) = checkOverlap($conn, $date, $roomID, $time);
                    
                    if($isOverlap) {
                        $overlaps[] = "Showtime exists in room $roomID on $date at $time.";
                    } 
                    else {
                        // Get the showPeriod_id for the selected time
                        $sqlFetchShowPeriodID = "SELECT showPeriod_id FROM ShowPeriod WHERE startTime = ?";
                        $stmtFetchShowPeriodID = $conn->prepare($sqlFetchShowPeriodID);
                        $stmtFetchShowPeriodID->bind_param("s", $time);
                        $stmtFetchShowPeriodID->execute();
                        $stmtFetchShowPeriodID->bind_result($showPeriodID);
                        $stmtFetchShowPeriodID->fetch();
                        $stmtFetchShowPeriodID->close();
                        
                        $sqlSchedule = "INSERT INTO Showing (movie_id, room_id, showPeriod_id, showDate, showTime) VALUES (?, ?, ?, ?, ?)";
                        $stmtSchedule = $conn->prepare($sqlSchedule);
                        if(!$stmtSchedule){
                            echo "Error: " . $conn->error;
                        }
                        $stmtSchedule->bind_param("iiiss", $movieID, $roomID, $showPeriodID, $date, $time);

                        if(!$stmtSchedule->execute()) {
                            echo "Error adding Showtime: " . $stmtSchedule->error;
                        }

                        $stmtSchedule->close();

                        // Initialize seats
                        $show_id = $conn->insert_id;
                        $seatInitializer = new SeatInitializer();
                        $seatInitializer->initialize_seats($conn, $show_id);
                    }
                }
            }
        }
        if(!empty($overlaps)) {
            echo "<script>alert('Overlap Detected:\\n" . implode("\\n", $overlaps) . "');</script>";
            // Redirect back to the form without processing
            echo "<script>window.history.back();</script>";
            exit();
        }
        
        header("Location: adminmovie.php?success=1");
    } catch (Exception $e){
        die("Error: " . $e->getMessage());

    }