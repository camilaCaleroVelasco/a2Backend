<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$successMessage = "";

// WORK IN PROGRESS
if(isset($_POST["submitCode"])) {


    $code = $_POST["promo_code"];
    require_once "includes/dbh.inc.php";
    require_once "functions/orderSummaryFunctions.php";

    $userID = $_SESSION["users_id"];
    $successMessage = applyPromoCode($code, $userID, $conn);

    // Get movie ID and ticket quantities from the URL parameters
    $movie_id = $_GET["movie_id"];
    $adult = $_GET["adult"];
    $child = $_GET["child"];
    $senior = $_GET["senior"];

    // Redirect back to the order summary page with success message
    header("Location: ordersummary.php?movie_id=$movie_id&adult=$adult&child=$child&senior=$senior&code=$code&success=codeAdded");
    exit();
}