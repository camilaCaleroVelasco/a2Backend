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
    
    $pdo = require __DIR__ . "/includes/databaseConnection.inc.php";

    //Check if email already exists
    $email = $_POST["email-address"];
    $sqlCheckEmail = "SELECT COUNT(*) AS count FROM Users WHERE email = ?";
    $stmtCheckEmail = $pdo->prepare($sqlCheckEmail);
    $stmtCheckEmail->execute([$email]);
    $resultCheckEmail = $stmtCheckEmail->fetch(PDO::FETCH_ASSOC);

    if ($resultCheckEmail['count'] > 0) {
        die("Error: Email already exists.");
    }


    // Retrieve $userStatus_id based on the status name (e.g., 'Active', 'Inactive')
    $userStatusName = 'Active'; //user just created account so active
    $sqlUserStatus = "SELECT userStatus_id FROM UserStatus WHERE status = ?";
    $stmtUserStatus = $pdo->prepare($sqlUserStatus);
    $stmtUserStatus->execute([$userStatusName]);
    $userStatusRow = $stmtUserStatus->fetch(PDO::FETCH_ASSOC);
    if ($userStatusRow) {
        $userStatus_id = $userStatusRow['userStatus_id'];
    } else {
        die("UserStatus not found for status: $userStatusName");
    }

    // Retrieve $userType_id based on the type name (e.g., 'Customer', 'Admin')
    $userTypeName = 'Customer'; //default user creation has to be customer
    $sqlUserType = "SELECT userType_id FROM UserType WHERE type = ?";
    $stmtUserType = $pdo->prepare($sqlUserType);
    $stmtUserType->execute([$userTypeName]);
    $userTypeRow = $stmtUserType->fetch(PDO::FETCH_ASSOC);
    if ($userTypeRow) {
        $userType_id = $userTypeRow['userType_id'];
    } else {
        die("UserType not found for type: $userTypeName");
    }

    // Retrieve $cardType_id based on the card type (e.g., 'Visa', 'MasterCard', 'AmericanExpress')
    $cardTypeName = $_POST["card-type"];
    $sqlCardType = "SELECT cardType_id FROM PaymentCardType WHERE type = ?";
    $stmtCardType = $pdo->prepare($sqlCardType);
    $stmtCardType->execute([$cardTypeName]);
    $cardTypeRow = $stmtCardType->fetch(PDO::FETCH_ASSOC);
    if ($cardTypeRow) {
        $cardType_id = $cardTypeRow['cardType_id'];
    } else {
        die("CardType not found for type: $cardTypeName");
    }

    // Insert into Users table
    $sqlUsers = "INSERT INTO Users (email, password, firstName, lastName, numOfCards, userStatus_id, userType_id)
                VALUES (?, ?, ?, ?, '1', ?, ?)";
    $stmtUsers = $pdo->prepare($sqlUsers);
    if (!$stmtUsers) {
        die("SQL error: " . $pdo->errorInfo()[2]);
    }
    if (!$stmtUsers->execute([$_POST["email-address"], $password_hash, $_POST["first-name"], $_POST["last-name"], $userStatus_id, $userType_id])) {
        die("Error: Failed to execute the Users query.");
    }

    // Check if any rows were affected by the insert operation
    if ($stmtUsers->rowCount() > 0) {
        // Retrieve the last inserted user ID
        $lastUserId = $pdo->lastInsertId();
        
        // Check if payment card information is provided and insert into PaymentCard table
        if (!empty($_POST["card-number"]) && !empty($_POST["expiration-month"]) && !empty($_POST["expiration-year"])) {
            $sqlPaymentCard = "INSERT INTO PaymentCard (cardNum, cardType_id, expMonth, expYear, name, users_id)
                            VALUES (?, ?, ?, ?, ?, ?)";
            $stmtPaymentCard = $pdo->prepare($sqlPaymentCard);
            if (!$stmtPaymentCard) {
                die("SQL error: " . $pdo->errorInfo()[2]);
            }
            if (!$stmtPaymentCard->execute([$_POST["card-number"], $cardType_id, $_POST["expiration-month"], $_POST["expiration-year"], $_POST["first-name"], $lastUserId])) {
                die("Error: Failed to execute the PaymentCard query.");
            }
        }

        // Redirect to the confirmation page if successful
        header("Location: registrationconfirmation.php");
        exit;
    } else {
        die("Error: Failed to execute the Users query.");
    }
        
?>