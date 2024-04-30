<?php
// Assuming you have a database connection established in your script
require_once "functions/bookingFunctions.php";

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve selectedDate and selectedTime from the request body
    $data = json_decode(file_get_contents("php://input"), true);
    $selectedDate = $data["selectedDate"];
    $selectedTime = $data["selectedTime"];
    $show_id = getShowId($conn,  $selectedDate,$selectedTime);
    //echo var_dump($show_id);
    // Get availability data based on the selected date and time
    $availabilityData = getSeatAvailability($conn, $show_id);

    // Return availability data as JSON
    echo json_encode($availabilityData);
} else {
    // If the request method is not POST, return an error response
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("error" => "Method not allowed"));
}