<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();

    include "includes/dbh.inc.php";
    include "functions/orderSummaryFunctions.php";

    $user_id = $_SESSION["users_id"];
    
    // Get the email
    $email = getEmail($user_id, $conn);
    // Send email
    sendEmailConfirmation($email);