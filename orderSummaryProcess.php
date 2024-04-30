<?php
session_start();
// WORK IN PROGRESS
if(isset($_POST["submit"])) {

    $code = $_POST["promo_code"];

    require_once "includes/dbh.inc.php";
    require_once "functions/orderSummaryFunctions.php";

    if (isValidCode($code, $conn)) {
        if (hasBeenUsed($code, $userID, $conn)) {
            header("Location: "); // ?error=usedCode;
        }
        else {
            header("Location: "); // ?success=true;
        }
    }
    else {
        header("Location: "); // /error=codeNotFound;
    }

}
else {
    header("Location: login.php");
    exit();
}