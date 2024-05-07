<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "includes/dbh.inc.php";

function getHistory($conn){
    $sql = "SELECT b.*, s.showDate, s.showTime, s.numOfAvailableSeats, m.movie_title, 
    t.ticketType_id, GROUP_CONCAT(t.seat_id) as seat_id, p.percentDiscount
    FROM Booking b 
    INNER JOIN Ticket t ON b.booking_id = t.booking_id
    INNER JOIN Showing s ON t.show_id = s.show_id
    INNER JOIN movies m ON s.movie_id = m.movie_id
    LEFT JOIN Promotion p ON b.promo_id = p.promo_id
    GROUP BY b.booking_id";
    $result = mysqli_query($conn, $sql);

    $history = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Explode seat IDs into an array
            $seatIds = explode(',', $row['seat_id']);
            $seatInfo = [];
            foreach ($seatIds as $seatId) {
                // Get seat information for each seat ID
                $seatInfo[] = getSeatInfo($conn, $seatId);
            }
            // Add seat information to the row
            $row['seatInfo'] = $seatInfo;
            // Add the row to the history array
            $history[] = $row;
        }
    } else {
        echo "<p>No order history available.</p>";
    }

    // Return the $history array
    return $history;
}

function getSeatInfo($conn, $seat_id){
    $sql = "SELECT seatRow, seatColumn FROM Seats WHERE seat_id = $seat_id";
    $result = mysqli_query($conn, $sql);
    $seatInfo = mysqli_fetch_assoc($result);
    return $seatInfo;
}

