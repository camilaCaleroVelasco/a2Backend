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
    ################ add payment stuff and promo
    # check that password and confirmation password
    if ($_POST["password"] !== $_POST["confirm-password"]) {
        die("Confirmation password must match password");
    }
    
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
    $pdo = require __DIR__ . "/includes/databaseConnection.inc.php";
    
    $sql = "INSERT INTO Users (type, email, password, firstName, lastName)
            VALUES ('customer', ?, ?, ?, ?)";
            
    $stmt = $pdo->prepare($sql);
    
    if ( ! $stmt) {
        die("SQL error: " . $pdo->errorInfo()[2]);
    }
    
    // Execute the prepared statement with provided parameters
    if (!$stmt->execute([$_POST["email-address"], $password_hash, $_POST["first-name"], $_POST["last-name"]])) {
        // If execution fails, display an error message
        die("Error: Failed to execute the query.");
    }

    // Check if any rows were affected by the insert operation
    if ($stmt->rowCount() > 0) {
        // Redirect to the confirmation page if successful
        header("Location: registrationconfirmation.php");
        exit;
    } else {
        // If no rows were affected, display an error message
        die("Error: Failed to execute the query.");
    }
        
?>