<?php
    require_once "includes/dbh.inc.php";
    require_once "functions/confirmationFunctions.php";
    session_start();

    if (isset($_SESSION['selectedSeats'], $_SESSION['movieId'], $_SESSION['totalPrice'], $_SESSION['totalTickets'], $_SESSION['showID'])) { 
    
        // set variables for booking
            $bookingDate = date("Y-m-d");
            $_SESSION['bookingDate'] = $bookingDate;

            // Set the timezone to your specific region
            date_default_timezone_set('America/New_York');  // Change this to your timezone
            $bookingTime = date('h:i a');

            $_SESSION['bookingTime'] = $bookingTime;
            $bookingStatus_id = 1;
            $numberOfSeats = $_SESSION['totalTickets'];
            $users_id = $_SESSION["users_id"];
            $priceTotal = $_SESSION['totalPrice'];
            
            addBooking($conn, $bookingDate, $bookingTime, $bookingStatus_id, $numberOfSeats, $users_id, $priceTotal);
            $booking_id = getBookingId($conn, $bookingDate, $bookingTime, $bookingStatus_id, $numberOfSeats, $users_id, $priceTotal);

        // Add tickets to database

            // set variables for tickets
            $show_id = $_SESSION['showID'];
            $adultTickets = $_SESSION['adultTickets'];
            $childTickets = $_SESSION['childTickets'];
            $seniorTickets = $_SESSION['seniorTickets'];


            foreach ($_SESSION['selectedSeats'] as $seat) {
                // Debug output
                //echo "Processing seat: $seat<br>";
            
                // Extract the row part (e.g., 'A')
                $seatRow= substr($seat, 1, 1);
                
                // Extract the seat number part (e.g., '1') and cast it to an integer
                $seatColumn = (int) substr($seat, 2);
            
                // Debug output
                //echo "Extracted row: $seatRow, column: $seatColumn<br>";
            
                $seat_id = getSeatId($conn, $seatRow, $seatColumn, $show_id);
                // Debug output
                //echo "Seat ID fetched: $seat_id<br>";

                if ( $childTickets > 0 ) {
                    addTicket($conn, 1, $booking_id, $show_id, $seat_id);
                    $childTickets--;
                } else if ( $adultTickets > 0 ) {
                    addTicket($conn, 2, $booking_id, $show_id, $seat_id);
                    $adultTickets--;
                } else if ( $seniorTickets > 0 ) {
                    addTicket($conn, 3, $booking_id, $show_id, $seat_id);
                    $seniorTickets--;
                }
                updateSeatAvailability($conn, $seat_id);
            }

        // Navigate to confirmation page
        header("Location: confirmation.php");

    } else {
        header("Location: index.php");
    }

