<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

    session_start();
    require_once "functions/checkIfAdminFunction.php"; 
    require_once "functions/addShowtimesFunctions.php";
    include "includes/dbh.inc.php";

    // Makes sures that the user is an admin
    checkIfAdmin();

    $movieID =  $_GET['movie_id'];

    if (!$movieID) {
        echo "movieID not found $movieID";
        exit();
    }
    

    try{

        // Check if the button was pressed
        if(isset($_POST['submit'])){
            $dates = $_POST['date'];
            $timesArr = $_POST['times'];

            // Loop through dates
            foreach ($dates as $index => $date) {
                // Get time for each date
                $times = explode(',', $timesArr[$index]);
                foreach($times as $time) {
                    $sqlSchedule = "INSERT INTO Showing (movie_id, showDate, showTime) VALUES (?, ?, ?)";
                    $stmtSchedule = $conn->prepare($sqlSchedule);
                    if(!$stmtSchedule){
                        echo "Error: " . $conn->error;
                    }
                    $stmtSchedule->bind_param("iss", $movieID, $date, $time);

                    if(!$stmtSchedule->execute()) {
                        echo "Error adding Showtime: " . $stmtSchedule->error;
                    }

                    $stmtSchedule->close();

                }
            }
        }
        
        // Commit the transaction
        $conn->commit();
        header("Location: adminmovie.php?success=1");
    } catch (Exception $e){
        die("Error: " . $e->getMessage());

    }

