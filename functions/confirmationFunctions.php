<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    function addTicket($conn, $TicketType, $Booking_id, $show_id, $seat_id) {
        //encrypt payment card code here 
        $sql = "INSERT INTO Ticket (ticketType_id, booking_id, show_id, seat_id) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ordersummary.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "iiii", $TicketType, $Booking_id, $show_id, $seat_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    function addBooking($conn, $BookingDate, $BookingTime, $BookingStatus_id, $numberOfSeats, $users_id, $priceTotal) {
        $sql = "INSERT INTO Booking (bookingDate, bookingTime, bookingStatus_id, numberOfSeats, users_id, priceTotal) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ordersummary.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ssiiis", $BookingDate, $BookingTime, $BookingStatus_id, $numberOfSeats, $users_id, $priceTotal);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    function updateSeatAvailability($conn, $seat_id) {
        $sql = "UPDATE Seats SET isAvailable = 'NO' WHERE seat_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ordersummary.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $seat_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    function getSeatId($conn, $seatRow, $seatColumn, $show_id) {

        $sql = "SELECT seat_id FROM Seats WHERE (show_id = ? AND seatRow = ? AND seatColumn = ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ordersummary.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "isi", $show_id, $seatRow, $seatColumn);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($resultData)) {
            $result = $row['seat_id'];
        } else {
            $result = false;
        }
        mysqli_stmt_close($stmt);
        return $result;
    }


    function getBookingId($conn, $BookingDate, $BookingTime, $BookingStatus_id, $numberOfSeats, $users_id, $priceTotal) {
        $sql = "SELECT booking_id FROM Booking WHERE (bookingDate = ? AND bookingTime = ? AND bookingStatus_id = ? 
        AND numberOfSeats = ? AND users_id = ? AND priceTotal = ?)";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ordersummary.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "ssiiis", $BookingDate, $BookingTime, $BookingStatus_id, $numberOfSeats, $users_id, $priceTotal);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($resultData)) {
            $result = $row['booking_id'];
        } else {
            $result = false;
        }
        mysqli_stmt_close($stmt);
        return $result;
    }

    function updateBookingLastFour($conn, $lastFour, $Booking_id) {
        $sql = "UPDATE Booking SET lastFour = ? WHERE booking_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ordersummary.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "ii", $lastFour, $Booking_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }