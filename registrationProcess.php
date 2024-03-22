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
    $sqlCheck = "SELECT COUNT(*) AS count FROM Users WHERE email = ?";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute([$email]);
    $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($resultCheck['count'] > 0) {
        die("Error: Email already exists.");
    }


    // Retrieve $userStatus_id (Active, Inactive)
    $userStatus = 'Active'; //user just created account so active
    $sqlUserStatus = "SELECT userStatus_id FROM UserStatus WHERE status = ?";
    $stmtStatus = $pdo->prepare($sqlUserStatus);
    $stmtStatus->execute([$userStatus]);
    $userStatusRow = $stmtStatus->fetch(PDO::FETCH_ASSOC);
    if ($userStatusRow) {
        $userStatus_id = $userStatusRow['userStatus_id'];
    } else {
        die("UserStatus not found for status: $userStatus");
    }

    // Retrieve $userType_id (Customer, Admin)
    $userType = 'Customer'; //default user creation has to be customer
    $sqlUserType = "SELECT userType_id FROM UserType WHERE type = ?";
    $stmtUserType = $pdo->prepare($sqlUserType);
    $stmtUserType->execute([$userType]);
    $userTypeRow = $stmtUserType->fetch(PDO::FETCH_ASSOC);
    if ($userTypeRow) {
        $userType_id = $userTypeRow['userType_id'];
    } else {
        die("UserType not found for type: $userType");
    }

    // Retrieve $cardType_id based on card type (Visa, MasterCard, AmericanExpress)
    $cardType = $_POST["card-type"];

    // Default card type in case the specified card type doesn't exist
    $defaultCardType = 'Visa';

    $sqlCardType = "SELECT cardType_id FROM PaymentCardType WHERE type = ?";
    $stmtCardType = $pdo->prepare($sqlCardType);
    $stmtCardType->execute([$cardType]);
    $cardTypeRow = $stmtCardType->fetch(PDO::FETCH_ASSOC);
    if ($cardTypeRow) {
        $cardType_id = $cardTypeRow['cardType_id'];
    } else {
        // Use default card type if the specified card type doesn't exist
        $stmtDefaultCardType = $pdo->prepare($sqlCardType);
        $stmtDefaultCardType->execute([$defaultCardType]);
        $defaultCardTypeRow = $stmtDefaultCardType->fetch(PDO::FETCH_ASSOC);

        if ($defaultCardTypeRow) {
            $cardType_id = $defaultCardTypeRow['cardType_id'];
        } else {
            die("Default CardType not found: $defaultCardType");
        }
    }

    // Encrypt the credit card number
    $encryptedCardNumber = null;
    if (!empty($_POST["card-number"])) {
        $cardNumber = $_POST["card-number"];
        $encryptionKey = 'encription-012df';
        $encryptedCardNumber = openssl_encrypt($cardNumber, 'aes-256-cbc', $encryptionKey, 0, $encryptionKey);
    }



    // Insert into Users table
    $sqlUsers = "INSERT INTO Users (email, password, firstName, lastName, numOfCards, userStatus_id, userType_id)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtUsers = $pdo->prepare($sqlUsers);
    if (!$stmtUsers) {
        die("SQL error: " . $pdo->errorInfo()[2]);
    }

    //Number of cards added
    $numOfCards = 0; // Default value
    $lastUserId = null;
    if (!empty($encryptedCardNumber) && !empty($_POST["expiration-month"]) && !empty($_POST["expiration-year"])) {
        // Check if user has less than 3 cards before incrementing...
        $sqlNumOfCards = "SELECT COUNT(*) AS cardCount FROM PaymentCard WHERE users_id = ?";
        $stmtNumOfCards = $pdo->prepare($sqlNumOfCards);
        $stmtNumOfCards->execute([$lastUserId]);
        $cardCountRow = $stmtNumOfCards->fetch(PDO::FETCH_ASSOC);
        $numOfCards = $cardCountRow['cardCount'] < 3 ? $cardCountRow['cardCount'] + 1 : 3;
    }
    if (!$stmtUsers->execute([$_POST["email-address"], $password_hash, $_POST["first-name"], $_POST["last-name"], $numOfCards, $userStatus_id, $userType_id])) {
        die("Error: Failed to execute the Users query.");
    }


    // Check if any rows were affected by the insert operation
    if ($stmtUsers->rowCount() > 0) {
        // Retrieve the last inserted user ID
        $lastUserId = $pdo->lastInsertId();
        
        // Check if payment card information is provided and insert into PaymentCard table
        if (!empty($encryptedCardNumber) && !empty($_POST["expiration-month"]) && !empty($_POST["expiration-year"])) {
            $sqlPaymentCard = "INSERT INTO PaymentCard (cardNum, cardType_id, expMonth, expYear, name, users_id)
                            VALUES (?, ?, ?, ?, ?, ?)";
            $stmtPaymentCard = $pdo->prepare($sqlPaymentCard);
            if (!$stmtPaymentCard) {
                die("SQL error: " . $pdo->errorInfo()[2]);
            }
            if (!$stmtPaymentCard->execute([$encryptedCardNumber, $cardType_id, $_POST["expiration-month"], $_POST["expiration-year"], $_POST["first-name"], $lastUserId])) {
                die("Error: Failed to execute the PaymentCard query.");
            }
        }
        // Redirect to the confirmation page if successful
        header("Location: registrationconfirmation.php");
        exit;
    } 
    else {
        die("Error: Failed to execute the Users query.");
    } 
        
?>