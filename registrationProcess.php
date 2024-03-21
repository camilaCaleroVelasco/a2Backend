<?php

    include_once 'includes/databaseConnection.inc.php'; 

    if (empty($_POST["first-name"])) {
        die("First Name is required");
    }

    if (empty($_POST["last-name"])) {
        die("Last Name is required");
    }
    
    if ( ! filter_var($_POST["email-address"], FILTER_VALIDATE_EMAIL)) {
        die("Valid email is required");
    }
    
    if (empty($_POST["phone-number"])) {
        die("Phone Number is required");
    }

    if (strlen($_POST["password"]) <= 7) {
        die("Password must be at least 8 characters");
    }
    
    if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
        die("Password must contain at least one letter");
    }
    
    if ( ! preg_match("/[0-9]/", $_POST["password"])) {
        die("Password must contain at least one number");
    }
    
    # check that password and confirmation password
    if ($_POST["password"] !== $_POST["confirm-password"]) {
        die("Confirmation password must match password");
    }
    
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
    $mysqli = require __DIR__ . "/includes/databaseConnection.inc.php";
    
    $sql = "INSERT INTO Users (email, password, firstName, lastName)
            VALUES (?, ?, ?, ?)";
            
    $stmt = $mysqli->stmt_init();
    
    if ( ! $stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }
    
    $stmt->bind_param("ssss", $_POST["email-address"], $password_hash, $_POST["first-name"], $_POST["last-name"]);
   
    $stmt->execute();

if ($stmt->affected_rows > 0) { // Check if any rows were affected
    header("Location: ../registrationconfirmation.php");
    exit;
} else {
    die("Error: Failed to execute the query.");
}
    
?>