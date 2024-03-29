<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

    include_once 'includes/databaseConnection.inc.php'; 
    include_once 'includes/functions.inc.php';

    if (empty($_POST["first-name"])) {
        header("Location: register.php?error=firstname");
        exit();
    }

    if (empty($_POST["last-name"])) {
        header("Location: register.php?error=lastname");
        exit();
    }
    
    if ( ! filter_var($_POST["email-address"], FILTER_VALIDATE_EMAIL)) {
        header("Location: register.php?error=invalidemail");
        exit();
    }
    
    if (empty($_POST["phone-number"])) {
        header("Location: register.php?error=phonenumber");
        exit();
    }

    if (strlen($_POST["password"]) <= 7) {
        header("Location: register.php?error=pwdlength");
        exit();
    }
    
    if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
        header("Location: register.php?error=pwdchar");
        exit();
    }
    
    if ( ! preg_match("/[0-9]/", $_POST["password"])) {
        header("Location: register.php?error=pwdnum");
        exit();
    }

    // Check that password == confirmation password
    if ($_POST["password"] !== $_POST["confirm-password"]) {
        header("Location: register.php?error=pwdmismatch");
        exit();
    }
    
    // Hash password
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
    $pdo = require __DIR__ . "/includes/databaseConnection.inc.php";

    // Create Activation token
    $activation_token = bin2hex(random_bytes(16));
    $activation_token_hash = hash("sha256", $activation_token);


    //Check if email already exists
    $email = $_POST["email-address"];
    $sqlEmailCheck = "SELECT COUNT(*) AS count FROM Users WHERE email = ?";
    $stmtEmailCheck = $pdo->prepare($sqlEmailCheck);
    $stmtEmailCheck->execute([$email]);
    $resultEmailCheck = $stmtEmailCheck->fetch(PDO::FETCH_ASSOC);

    if ($resultEmailCheck['count'] > 0) {
        header("Location: register.php?error=emailexists");
        exit();
    }


    // Retrieve $userStatus_id
    $userStatus = 'Inactive'; //user just created account so Inactive
    $sqlUserStatus = "SELECT userStatus_id FROM UserStatus WHERE status = ?";
    $stmtUserStatus = $pdo->prepare($sqlUserStatus);
    $stmtUserStatus->execute([$userStatus]);
    $userStatusRow = $stmtUserStatus->fetch(PDO::FETCH_ASSOC);
    if ($userStatusRow) {
        $userStatus_id = $userStatusRow['userStatus_id'];
    } else {
        die("UserStatus not found for status: $userStatus");
        exit();
    }

    // Retrieve $userType_id
    $userType = 'Customer'; // Default user creation has to be customer
    $sqlUserType = "SELECT userType_id FROM UserType WHERE type = ?";
    $stmtUserType = $pdo->prepare($sqlUserType);
    $stmtUserType->execute([$userType]);
    $userTypeRow = $stmtUserType->fetch(PDO::FETCH_ASSOC);
    if ($userTypeRow) {
        $userType_id = $userTypeRow['userType_id'];
    } else {
        die("UserType not found for type: $userType");
    }

    // Retrieve Phone Number
    $phoneNumber = $_POST["phone-number"];


    // Retrieve $cardType_id 
    $cardType = $_POST["card-type"];
    $defaultCardType = 'Visa'; // Default cardType
    $sqlCardType = "SELECT cardType_id FROM PaymentCardType WHERE type = ?";
    $stmtCardType = $pdo->prepare($sqlCardType);
    $stmtCardType->execute([$cardType]);
    $cardTypeRow = $stmtCardType->fetch(PDO::FETCH_ASSOC);
    if ($cardTypeRow) {
        $cardType_id = $cardTypeRow['cardType_id'];
    } else {
        // If user does not provide card type assign the default card type
        $stmtDefaultCardType = $pdo->prepare($sqlCardType);
        $stmtDefaultCardType->execute([$defaultCardType]);
        $defaultCardTypeRow = $stmtDefaultCardType->fetch(PDO::FETCH_ASSOC);

        if ($defaultCardTypeRow) {
            $cardType_id = $defaultCardTypeRow['cardType_id'];
        } 
    }

    // Encrypt card number
    $encryptedCardNumber = null;
    if (!empty($_POST["card-number"])) {
        $cardNumber = $_POST["card-number"];
        $encryptionKey = 'encription-012df';
        $encryptedCardNumber = openssl_encrypt($cardNumber, 'aes-256-cbc', $encryptionKey, 0, $encryptionKey);
    }

    // Insert Billing Address info if provided
    $billingAddressId = null;
    if (!empty($_POST["street-address-billing"]) && !empty($_POST["city-billing"]) && 
        !empty($_POST["state-billing"]) && !empty($_POST["zip-code-billing"])) {
            
        $sqlInsertBillingAddress = "INSERT INTO BillingAddress (billingStreetAddress, billingCity, billingState, billingZipCode) VALUES (?, ?, ?, ?)";
        $stmtInsertBillingAddress = $pdo->prepare($sqlInsertBillingAddress);
        if (!$stmtInsertBillingAddress) {
            die("SQL error: " . $pdo->errorInfo()[2]);
        }

        // Handle errors
        try {
            // Execute
            $successInsertBillingAddress = $stmtInsertBillingAddress->execute([$_POST["street-address-billing"], $_POST["city-billing"], $_POST["state-billing"], $_POST["zip-code-billing"]]);

            if (!$successInsertBillingAddress) {
                die("Error: Failed to insert billing address. " . implode(", ", $stmtInsertBillingAddress->errorInfo()));
            }

            // Retrieve billing_id
            $billingAddressId = $pdo->lastInsertId();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        // Track billing_id even if the user did not provide Billing Address
        $sqlDefaultBilling = "INSERT INTO BillingAddress (billingStreetAddress, billingCity, billingState, billingZipCode) VALUES (?, ?, ?, ?)";
        $stmtDefaultBilling = $pdo->prepare($sqlDefaultBilling);
        if (!$stmtDefaultBilling) {
            die("SQL error: " . $pdo->errorInfo()[2]);
        }

        // Default billing address values
        $defaultBillingStreet = "";
        $defaultBillingCity = "";
        $defaultBillingState = "";
        $defaultBillingZipCode = "0"; //change to varchar in DB

        // Handle errors
        try {
            // Execute
            $successDefaultBilling= $stmtDefaultBilling->execute([$defaultBillingStreet, $defaultBillingCity, $defaultBillingState, $defaultBillingZipCode]);

            if (!$successDefaultBilling) {
                die("Error: Failed to delivery address. " . implode(", ", $stmtDefaultBilling->errorInfo()));
            }

            // Retrieve billing_id
            $billingAddressId = $pdo->lastInsertId();

        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    // Insert Delivery Address info if provided
    $deliveryAddressId = null;
    if (!empty($_POST["street-address-shipping"]) && !empty($_POST["city-shipping"]) && 
        !empty($_POST["state-shipping"]) && !empty($_POST["zip-code-shipping"])) {

        $sqlInsertDeliveryAddress = "INSERT INTO DeliveryAddress (deliveryStreetAddress, deliveryCity, deliveryState, deliveryZipCode) VALUES (?, ?, ?, ?)";
        $stmtInsertDeliveryAddress = $pdo->prepare($sqlInsertDeliveryAddress);
        if (!$stmtInsertDeliveryAddress) {
            die("SQL error: " . $pdo->errorInfo()[2]);
        }

        // Handle errors
        try {
            // Execute
            $successInsertDeliveryAddress = $stmtInsertDeliveryAddress->execute([$_POST["street-address-shipping"], $_POST["city-shipping"], $_POST["state-shipping"], $_POST["zip-code-shipping"]]);

            if (!$successInsertDeliveryAddress) {
                die("Error: Failed to insert delivery address. " . implode(", ", $stmtInsertDeliveryAddress->errorInfo()));
            }

            // Retrieve delivery_id
            $deliveryAddressId = $pdo->lastInsertId();

        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        // Track delivery_id even if the user did not provide Delivery Address
        $sqlDefaultDelivery = "INSERT INTO DeliveryAddress (deliveryStreetAddress, deliveryCity, deliveryState, deliveryZipCode) VALUES (?, ?, ?, ?)";
        $stmtDefaultDelivery = $pdo->prepare($sqlDefaultDelivery);
        if (!$stmtDefaultDelivery) {
            die("SQL error: " . $pdo->errorInfo()[2]);
        }

        // Default delivery address values
        $defaultStreet = "";
        $defaultCity = "";
        $defaultState = "";
        $defaultZipCode = "0"; //change to varchar in DB

        // Handle errors
        try {
            // Execute
            $successDefaultDelivery = $stmtDefaultDelivery->execute([$defaultStreet, $defaultCity, $defaultState, $defaultZipCode]);

            if (!$successDefaultDelivery) {
                die("Error: Failed to assign default. " . implode(", ", $stmtDefaultDelivery->errorInfo()));
            }

            // Retrieve delivery_id
            $deliveryAddressId = $pdo->lastInsertId();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    // Promo Subscription 
    $promoSubscription = isset($_POST['subscribe-promos']) ? 1 : 2;



    // Insert into Users table
    $sqlUsers = "INSERT INTO Users (email, password, firstName, lastName, phoneNumber, numOfCards, account_activation_hash, userStatus_id, userType_id, promoSub_id, billing_id, delivery_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtUsers = $pdo->prepare($sqlUsers);
    if (!$stmtUsers) {
        die("SQL error: " . $pdo->errorInfo()[2]);
    }

    // //Number of cards added
    // $numOfCards = 0; // Default value
    // $lastUserId = null;
    // if (!empty($encryptedCardNumber) && !empty($_POST["expiration-month"]) && !empty($_POST["expiration-year"])) {
    //     // Check if the user has less than 3 cards
    //     $sqlNumOfCards = "SELECT COUNT(*) AS cardCount FROM PaymentCard1 WHERE users_id = ?";
    //     $stmtNumOfCards = $pdo->prepare($sqlNumOfCards);
    //     $stmtNumOfCards->execute([$lastUserId]);
    //     $cardCountRow = $stmtNumOfCards->fetch(PDO::FETCH_ASSOC);
    //     $numOfCards = $cardCountRow['cardCount'] < 3 ? $cardCountRow['cardCount'] + 1 : 3;
    // }

    // Users execute 
    if (!$stmtUsers->execute([$_POST["email-address"], $password_hash, $_POST["first-name"], $_POST["last-name"], $phoneNumber, $numOfCards, $activation_token_hash, $userStatus_id, $userType_id, $promoSubscription, $billingAddressId, $deliveryAddressId])) {
        die("Error: Failed to pull Users.");
    }


    // Check if the rows are affected
    if ($stmtUsers->rowCount() > 0) {

        // Retrieve the last inserted user_id
        $lastUserId = $pdo->lastInsertId();

        // Check if payment card was added
        if (!empty($encryptedCardNumber) && !empty($_POST["expiration-month"]) && !empty($_POST["expiration-year"])) {
            // Card 1
            $sqlPaymentCard = "INSERT INTO PaymentCard1 (cardNum, cardType_id, expMonth, expYear, firstName, lastName, users_id)
                            VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtPaymentCard = $pdo->prepare($sqlPaymentCard);

            // Card 2
            $sqlPaymentCard2 = "INSERT INTO PaymentCard2 (cardNum, cardType_id, expMonth, expYear, firstName, lastName, users_id)
                                VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtPaymentCard2 = $pdo->prepare($sqlPaymentCard2);
            if (!$stmtPaymentCard2) {
                die("SQL error: " . $pdo->errorInfo()[2]);
            }

            // Card 3
            $sqlPaymentCard3 = "INSERT INTO PaymentCard3 (cardNum, cardType_id, expMonth, expYear, firstName, lastName, users_id)
                                VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtPaymentCard3 = $pdo->prepare($sqlPaymentCard3);
            if (!$stmtPaymentCard3) {
                die("SQL error: " . $pdo->errorInfo()[2]);
            }

            // Default Card
            $defaultCardNum = ""; // Set a default or dummy card number
            $defaultCardType_id = 1; // Set a default card type ID
            $defaultExpMonth = ""; // Set a default expiration month
            $defaultExpYear = ""; // Set a default expiration year
            $defaultFirstName = ""; // Set a default or dummy first name
            $defaultLastName = ""; // Set a default or dummy last name

            if (!$stmtPaymentCard) {
                die("SQL error: " . $pdo->errorInfo()[2]);
            }
            if (!$stmtPaymentCard->execute([$encryptedCardNumber, $cardType_id, $_POST["expiration-month"], $_POST["expiration-year"], $_POST["first-name"], $_POST["last-name"], $lastUserId])) {
                die("Error:  Failed to pull PaymentCard.");
            }

            if (!$stmtPaymentCard2->execute([$defaultCardNum, $defaultCardType_id, $defaultExpMonth, $defaultExpYear, $defaultFirstName, $defaultLastName, $lastUserId])) {
                die("Error: Failed to execute the PaymentCard query.");
            }
            if (!$stmtPaymentCard3->execute([$defaultCardNum, $defaultCardType_id, $defaultExpMonth, $defaultExpYear, $defaultFirstName, $defaultLastName, $lastUserId])) {
                die("Error: Failed to execute the PaymentCard query.");
            }
        } 
        // Track the 3 cards
       
            // Card 1
            $sqlPaymentCard1 = "INSERT INTO PaymentCard1 (cardNum, cardType_id, expMonth, expYear, firstName, lastName, users_id)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtPaymentCard1 = $pdo->prepare($sqlPaymentCard1);
            if (!$stmtPaymentCard1) {
            die("SQL error: " . $pdo->errorInfo()[2]);
            }

            // Card 2
            $sqlPaymentCard2 = "INSERT INTO PaymentCard2 (cardNum, cardType_id, expMonth, expYear, firstName, lastName, users_id)
                                VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtPaymentCard2 = $pdo->prepare($sqlPaymentCard2);
            if (!$stmtPaymentCard2) {
                die("SQL error: " . $pdo->errorInfo()[2]);
            }

            // Card 3
            $sqlPaymentCard3 = "INSERT INTO PaymentCard3 (cardNum, cardType_id, expMonth, expYear, firstName, lastName, users_id)
                                VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmtPaymentCard3 = $pdo->prepare($sqlPaymentCard3);
            if (!$stmtPaymentCard3) {
                die("SQL error: " . $pdo->errorInfo()[2]);
            }

            
            // Default Card
            $defaultCardNum = ""; // Set a default or dummy card number
            $defaultCardType_id = 1; // Set a default card type ID
            $defaultExpMonth = ""; // Set a default expiration month
            $defaultExpYear = ""; // Set a default expiration year
            $defaultFirstName = ""; // Set a default or dummy first name
            $defaultLastName = ""; // Set a default or dummy last name
            
            // Execute the query to insert placeholder card
            if (!$stmtPaymentCard1->execute([$defaultCardNum, $defaultCardType_id, $defaultExpMonth, $defaultExpYear, $defaultFirstName, $defaultLastName, $lastUserId])) {
                die("Error: Failed to execute the PaymentCard query.");
            }
            if (!$stmtPaymentCard2->execute([$defaultCardNum, $defaultCardType_id, $defaultExpMonth, $defaultExpYear, $defaultFirstName, $defaultLastName, $lastUserId])) {
                die("Error: Failed to execute the PaymentCard query.");
            }
            if (!$stmtPaymentCard3->execute([$defaultCardNum, $defaultCardType_id, $defaultExpMonth, $defaultExpYear, $defaultFirstName, $defaultLastName, $lastUserId])) {
                die("Error: Failed to execute the PaymentCard query.");
            }
            
        

        // Email Verification Process
        $name = $_POST["first-name"];
        $path = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
        $path .=$_SERVER["SERVER_NAME"]. dirname($_SERVER["PHP_SELF"]);        
        $mail = require __DIR__ . "/mailer.php";
        $mail->setFrom("noreply@example.com");
        $mail->addAddress($_POST["email-address"]);
        $mail->Subject = "Account Activation";
        $mail->Body = <<<END
        Welcome $name <br>
        Click <a href="$path/activateAccount.php?token=$activation_token">here</a> 
        to activate your account. 
        END; 
        try {
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
            exit;
        }

        

        // Redirect 
        header("Location: registrationconfirmation.php?success=accountCreated");
        exit;
    } 
    else {
        die("Error: Failed pull Users.");
    } 
        
?>