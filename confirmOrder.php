<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payment']) && $_POST['payment'] != 'None') {
    $_SESSION['selectedPaymentMethod'] = $_POST['payment'];
} else {
    http_response_code(400); // Indicate a bad request or other HTTP status as appropriate
}
?>
