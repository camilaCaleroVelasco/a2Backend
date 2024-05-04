<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

if (isset($_POST["submitCode"])) {
    $code = $_POST["promo_code"];
    require_once "includes/dbh.inc.php";
    require_once "functions/orderSummaryFunctions.php";

    $userID = $_SESSION["users_id"];
    $promoResult = applyPromoCode($code, $userID, $conn);
    $successMessage = $promoResult["message"];
    $isPromoCodeApplied = $promoResult["status"] === "success";
    $discount = $promoResult["discount"];

    // Get movie ID and ticket quantities from the URL parameters
    $movie_id = $_GET["movie_id"];
    $adult = $_GET["adult"];
    $child = $_GET["child"];
    $senior = $_GET["senior"];

    // Encode the message for the URL
    $encodedMessage = urlencode($successMessage);

    // Redirect back to the order summary page with the application status, message, and discount
    header("Location: ordersummary.php?movie_id=$movie_id&adult=$adult&child=$child&senior=$senior&code=$code&status=" . $promoResult["status"] . "&message=$encodedMessage&discount=$discount");
    exit();
}
?>