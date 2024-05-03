<?php
// Include necessary files and establish database connection
require_once "functions/bookingFunctions.php";
require_once "includes/dbh.inc.php";

// Check if the show_id parameter is provided in the request
if(isset($_GET['show_id'])) {
    $show_id = $_GET['show_id'];

    // Call the getSeatAvailability function to retrieve seat availability data
    $seatAvailability = getSeatAvailability($conn, $show_id);

    // Return the seat availability data as JSON
    header('Content-Type: application/json');
    echo json_encode($seatAvailability);
} else {
    // If show_id parameter is not provided, return an error response
    http_response_code(400);
    echo json_encode(array("error" => "show_id parameter is missing"));
}

