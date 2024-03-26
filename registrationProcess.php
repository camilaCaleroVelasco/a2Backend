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


    # check that password and confirmation password--------------------------------------------------
    if ($_POST["password"] !== $_POST["confirm-password"]) {
        die("Confirmation password must match password");
    }
    
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
    $pdo = require __DIR__ . "/includes/databaseConnection.inc.php";

    $activation_token = bin2hex(random_bytes(16));
    $activation_token_hash = hash("sha256", $activation_token);


    //Check if email already exists--------------------------------------------------
    $email = $_POST["email-address"];
    $sqlCheck = "SELECT COUNT(*) AS count FROM Users WHERE email = ?";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute([$email]);
    $resultCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($resultCheck['count'] > 0) {
        die("Error: Email already exists.");
    }


    // Retrieve $userStatus_id (Active, Inactive)---------------------------------------------------
    $userStatus = 'Inactive'; //user just created account so active
    $sqlUserStatus = "SELECT userStatus_id FROM UserStatus WHERE status = ?";
    $stmtStatus = $pdo->prepare($sqlUserStatus);
    $stmtStatus->execute([$userStatus]);
    $userStatusRow = $stmtStatus->fetch(PDO::FETCH_ASSOC);
    if ($userStatusRow) {
        $userStatus_id = $userStatusRow['userStatus_id'];
    } else {
        die("UserStatus not found for status: $userStatus");
    }

    // Retrieve $userType_id (Customer, Admin)--------------------------------------------------
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

    //Phone Number---------------------------------------------------------------------------
    $phoneNumber = $_POST["phone-number"]; //retieve from POST


    // Retrieve $cardType_id based on card type (Visa, MasterCard, AmericanExpress)-------------------------
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

    // Encrypt the credit card number--------------------------------------------------
    $encryptedCardNumber = null;
    if (!empty($_POST["card-number"])) {
        $cardNumber = $_POST["card-number"];
        $encryptionKey = 'encription-012df';
        $encryptedCardNumber = openssl_encrypt($cardNumber, 'aes-256-cbc', $encryptionKey, 0, $encryptionKey);
    }

    // Insert into BillingAddress table if provided--------------------------------------------------
    $billingAddressId = null;
    if (!empty($_POST["street-address-billing"]) && !empty($_POST["city-billing"]) && !empty($_POST["state-billing"]) && !empty($_POST["zip-code-billing"])) {
        $sqlInsertBillingAddress = "INSERT INTO BillingAddress (billingStreetAddress, billingCity, billingState, billingZipCode) VALUES (?, ?, ?, ?)";
        $stmtInsertBillingAddress = $pdo->prepare($sqlInsertBillingAddress);
        if (!$stmtInsertBillingAddress) {
            die("SQL error: " . $pdo->errorInfo()[2]);
        }

        // Execute the query and handle errors
        try {
            $successInsertBillingAddress = $stmtInsertBillingAddress->execute([$_POST["street-address-billing"], $_POST["city-billing"], $_POST["state-billing"], $_POST["zip-code-billing"]]);

            if (!$successInsertBillingAddress) {
                die("Error: Failed to insert billing address. " . implode(", ", $stmtInsertBillingAddress->errorInfo()));
            }

            // Retrieve the auto-generated billing_id
            $billingAddressId = $pdo->lastInsertId();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        // If delivery address is not provided, assign a default billing_id
        $sqlDefaultBilling = "INSERT INTO BillingAddress (billingStreetAddress, billingCity, billingState, billingZipCode) VALUES (?, ?, ?, ?)";
        $stmtDefaultBilling = $pdo->prepare($sqlDefaultBilling);
        if (!$stmtDefaultBilling) {
            die("SQL error: " . $pdo->errorInfo()[2]);
        }

        // Default billing address values
        $defaultBillingStreet = "Enter Street";
        $defaultBillingCity = "Enter City";
        $defaultBillingState = "Enter State";
        $defaultBillingZipCode = "30601";

        try {
            $successDefaultBilling= $stmtDefaultBilling->execute([$defaultBillingStreet, $defaultBillingCity, $defaultBillingState, $defaultBillingZipCode]);

            if (!$successDefaultBilling) {
                die("Error: Failed to assign default delivery address. " . implode(", ", $stmtDefaultBilling->errorInfo()));
            }

            // Retrieve the auto-generated billing ID
            $billingAddressId = $pdo->lastInsertId();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    // Insert into DeliveryAddress table if provided--------------------------------------------------
    $deliveryAddressId = null;
    if (!empty($_POST["street-address-shipping"]) && !empty($_POST["city-shipping"]) && !empty($_POST["state-shipping"]) && !empty($_POST["zip-code-shipping"])) {
        $sqlInsertDeliveryAddress = "INSERT INTO DeliveryAddress (deliveryStreetAddress, deliveryCity, deliveryState, deliveryZipCode) VALUES (?, ?, ?, ?)";
        $stmtInsertDeliveryAddress = $pdo->prepare($sqlInsertDeliveryAddress);
        if (!$stmtInsertDeliveryAddress) {
            die("SQL error: " . $pdo->errorInfo()[2]);
        }

        // Execute the query and handle errors
        try {
            $successInsertDeliveryAddress = $stmtInsertDeliveryAddress->execute([$_POST["street-address-shipping"], $_POST["city-shipping"], $_POST["state-shipping"], $_POST["zip-code-shipping"]]);

            if (!$successInsertDeliveryAddress) {
                die("Error: Failed to insert delivery address. " . implode(", ", $stmtInsertDeliveryAddress->errorInfo()));
            }

            // Retrieve the auto-generated delivery ID
            $deliveryAddressId = $pdo->lastInsertId();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        // If delivery address is not provided, assign a default delivery_id
        $sqlDefaultDelivery = "INSERT INTO DeliveryAddress (deliveryStreetAddress, deliveryCity, deliveryState, deliveryZipCode) VALUES (?, ?, ?, ?)";
        $stmtDefaultDelivery = $pdo->prepare($sqlDefaultDelivery);
        if (!$stmtDefaultDelivery) {
            die("SQL error: " . $pdo->errorInfo()[2]);
        }

        // Default delivery address values
        $defaultStreet = "Enter Street";
        $defaultCity = "Enter City";
        $defaultState = "Enter State";
        $defaultZipCode = "30601";

        try {
            $successDefaultDelivery = $stmtDefaultDelivery->execute([$defaultStreet, $defaultCity, $defaultState, $defaultZipCode]);

            if (!$successDefaultDelivery) {
                die("Error: Failed to assign default delivery address. " . implode(", ", $stmtDefaultDelivery->errorInfo()));
            }

            // Retrieve the auto-generated delivery ID
            $deliveryAddressId = $pdo->lastInsertId();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    //Promotion---------------------------------------------------------------------------
    // Determine promo subscription based on checkbox status
    $promoSubscription = isset($_POST['subscribe-promos']) ? 1 : 2;



    // Insert into Users table---------------------------------------------------
    $sqlUsers = "INSERT INTO Users (email, password, firstName, lastName, phoneNumber, numOfCards, account_activation_hash, userStatus_id, userType_id, promoSub_id, billing_id, delivery_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtUsers = $pdo->prepare($sqlUsers);
    if (!$stmtUsers) {
        die("SQL error: " . $pdo->errorInfo()[2]);
    }

    //Number of cards added---------------------------------------------------------------------------
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
    // Users execute ---------------------------------------------------------------------------
    if (!$stmtUsers->execute([$_POST["email-address"], $password_hash, $_POST["first-name"], $_POST["last-name"], $phoneNumber, $numOfCards, $activation_token_hash, $userStatus_id, $userType_id, $promoSubscription, $billingAddressId, $deliveryAddressId])) {
        die("Error: Failed to execute the Users query.");
    }


    // Check if any rows were affected by the insert operation
    if ($stmtUsers->rowCount() > 0) {
        // Retrieve the last inserted user ID
        $lastUserId = $pdo->lastInsertId();

        // Check if payment card information is provided and insert into PaymentCard table
        if (!empty($encryptedCardNumber) && !empty($_POST["expiration-month"]) && !empty($_POST["expiration-year"])) {
            $sqlPaymentCard = "INSERT INTO PaymentCard (cardNum, cardType_id, expMonth, expYear, firstName, lastName, users_id)
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtPaymentCard = $pdo->prepare($sqlPaymentCard);
            if (!$stmtPaymentCard) {
                die("SQL error: " . $pdo->errorInfo()[2]);
            }
            if (!$stmtPaymentCard->execute([$encryptedCardNumber, $cardType_id, $_POST["expiration-month"], $_POST["expiration-year"], $_POST["first-name"], $_POST["last-name"], $lastUserId])) {
                die("Error: Failed to execute the PaymentCard query.");
            }
        }

        // Email Verification Process---------------------------------------------------
        $mail = require __DIR__ . "/mailer.php";
        $mail->setFrom("noreply@example.com");
        $mail->addAddress($_POST["email-address"]);
        $mail->Subject = "Account Activation";
        $mail->Body = <<<END
        Click <a href="http://localhost/a2Backend/activateAccount.php?token=$activation_token">here</a> 
        to activate your account. 
        END; // Change URL according to your localhost directory
        try {
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
            exit;
        }


        // Redirect to the confirmation page if successful
        header("Location: registrationconfirmation.php");
        exit;
    } 
    else {
        die("Error: Failed to execute the Users query.");
    } 
        
?>