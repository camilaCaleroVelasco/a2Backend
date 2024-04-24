<?php
include "classes/seats.php";
class SeatInitializer {
    // Properties
    public $show_id;
    public $seat;


    function initialize_seats($show_id){
        $seat = new seats();
        for ($x = 0; $x < 9; $x++){
            $seat->set_show_id($show_id);
            $seat->set_row('A');
            $seat->set_column($x);
            $seat->set_isAvailable('YES');
            // insert seat into db
            $sql = "INSERT INTO Seats (show_id, seatRow, seatColumn, isAvailable) VALUES (
                $seat->get_show_id, 
                $seat->get_row, 
                $seat->get_column, 
                $seat->get_isAvailable
                )";
            $stmt = mysqli_stmt_init($conn);
            mysqli_prepare($stmt, $sql);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
        for ($x = 0; $x < 9; $x++){
            $seat->set_show_id($show_id);
            $seat->set_row('B');
            $seat->set_column($x);
            $seat->set_isAvailable('YES');
            // insert seat into db
        }
        for ($x = 0; $x < 9; $x++){
            $seat->set_show_id($show_id);
            $seat->set_row('C');
            $seat->set_column($x);
            $seat->set_isAvailable('YES');
            // insert seat into db
        }
        for ($x = 0; $x < 9; $x++){
            $seat->set_show_id($show_id);
            $seat->set_row('D');
            $seat->set_column($x);
            $seat->set_isAvailable('YES');
            // insert seat into db
            
        }
        for ($x = 0; $x < 9; $x++){
            $seat->set_show_id($show_id);
            $seat->set_row('E');
            $seat->set_column($x);
            $seat->set_isAvailable('YES');
            // insert seat into db
        }
        for ($x = 0; $x < 9; $x++){
            $seat->set_show_id($show_id);
            $seat->set_row('F');
            $seat->set_column($x);
            $seat->set_isAvailable('YES');
            // insert seat into db
        }
    }
}