<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

    session_start();
    require_once "functions/checkIfAdminFunction.php"; 
    include "includes/dbh.inc.php";

    // Makes sures that the user is an admin
    checkIfAdmin();

    $movie_id = isset($_GET['movie_id']) ? intval($_GET['movie_id']) : 0;
    echo "Received movie_id: $movie_id";  // Debugging output

    if ($movie_id <= 0) {
        die('Invalid Movie ID.');
    }
    
    // Begin Transaction
    $conn->begin_transaction();

    try{
        // Validate the movie_id
        $validationQuery = "SELECT COUNT(*) AS count FROM Movies WHERE movie_id = ?";
        $stmtValidate = $conn->prepare($validationQuery);
        if (!$stmtValidate) {
            throw new Exception("Failed to prepare validation query: " . $conn->error);
        }
        $stmtValidate->bind_param("i", $movie_id);
        $stmtValidate->execute();
        $stmtValidate->bind_result($count);
        $stmtValidate->fetch();
        $stmtValidate->close();
    
        if ($count == 0) {
            throw new Exception('Movie ID does not exist in the Movies table.');
        }

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
                    $stmtSchedule->bind_param("iss", $movie_id, $date, $time);

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

