<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['email'])) {
    // User is logged in, return success response
    http_response_code(200); // OK
    echo json_encode(array('loggedIn' => true));
} else {
    // User is not logged in, return unauthorized response
    http_response_code(401); // Unauthorized
    echo json_encode(array('loggedIn' => false));
}
?>