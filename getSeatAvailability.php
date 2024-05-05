<?php
require_once "includes/dbh.inc.php";
require_once "functions/bookingFunctions.php";

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['date'], $input['time'], $input['movie_id'])) {
    echo json_encode([]);
    exit();
}

$selectedDate = $input['date'];
$selectedTime = $input['time'];
$movie_id = $input['movie_id'];

$showID = getShowId($conn, $selectedDate, $selectedTime, $movie_id);

if (!$showID) {
    echo json_encode([]);
    exit();
}

$_SESSION['showID'] = $showID;

$seatAvailability = getSeatAvailability($conn, $showID);

echo json_encode($seatAvailability);
