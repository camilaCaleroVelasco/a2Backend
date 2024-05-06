<?php

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    session_start();

    include "includes/dbh.inc.php";
    include "functions/orderSummaryFunctions.php";

    $user_id = $_SESSION["users_id"];
    
    // Get the email
    $email = getEmail($user_id, $conn);


    // Retrieve variables from the URL parameters
    $movie_id = $_GET['movie_id'];
    $movie_title = urldecode($_GET['movie_title']);
    $adult = $_GET['adult'];
    $child = $_GET['child'];
    $senior = $_GET['senior'];
    $subtotal = $_GET['subtotal'];
    $taxAmount = $_GET['taxAmount'];
    $totalWithTax = $_GET['totalWithTax'];
    $discount = $_GET['discount'];
    $discountedPrice = $_GET['discountedPrice'];
    // Send email confirmation
    sendEmailConfirmation($email, $movie_title, $adult, $child, $senior, $subtotal, $taxAmount, $totalWithTax, $discount, $discountedPrice);
