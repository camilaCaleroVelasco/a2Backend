<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "seats.php";

class SeatInitializer {
    // Properties
    public $show_id;
    public $seat;


    function initialize_seats($conn, $show_id){
        $seat = new seat();
        // Save rows in an array
        $rows = ['A', 'B', 'C', 'D', 'E', 'F'];

        // Loop over the rows and insert them in the db
        foreach($rows as $row) {
            // Doing this will prevent the repetition for each row
            for($x = 0; $x < 9; $x++) {
                $seat->set_show_id($show_id);
                $seat->set_row($row);
                $seat->set_column($x);
                $seat->set_isAvailable('YES');
                // insert seat into db
                $sql = "INSERT INTO Seats (show_id, seatRow, seatColumn, isAvailable) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                mysqli_stmt_prepare($stmt, $sql);
                $show_id2 = $seat->get_show_id();
                $getRow = $seat->get_row();
                $column = $seat->get_column();
                $available = $seat->get_isAvailable();
                mysqli_stmt_bind_param($stmt, "isss", $show_id2,$getRow, $column, $available);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        }
    }
}