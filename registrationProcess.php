<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

    include_once 'functions/activateAccountFunctions.php';
    include_once 'includes/dbh.inc.php';


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

    
    //Check if email already exists
    $email = $_POST["email-address"];
    $sqlEmailCheck = "SELECT COUNT(*) AS count FROM Users WHERE email = ?";
    $stmtEmailCheck = mysqli_prepare($conn, $sqlEmailCheck);
    mysqli_stmt_bind_param($stmtEmailCheck, "s", $email);
    mysqli_stmt_execute($stmtEmailCheck);
    $resultEmailCheck = mysqli_stmt_get_result($stmtEmailCheck);
    $emailCheckRow = mysqli_fetch_assoc($resultEmailCheck);

    if ($emailCheckRow['count'] > 0) {
        header("Location: register.php?error=emailexists");
        exit();
    }

    // Get $userStatus_id
    $userStatus = 'Inactive'; //user just created account so Inactive
    $sqlUserStatus = "SELECT userStatus_id FROM UserStatus WHERE status = ?";
    $stmtUserStatus = mysqli_prepare($conn, $sqlUserStatus);
    mysqli_stmt_bind_param($stmtUserStatus, "s", $userStatus);
    mysqli_stmt_execute($stmtUserStatus);
    $resultUserStatus = mysqli_stmt_get_result($stmtUserStatus);
    $userStatusRow = mysqli_fetch_assoc($resultUserStatus);
    if ($userStatusRow) {
        $userStatus_id = $userStatusRow['userStatus_id'];
    } else {
        die("UserStatus not found");
        exit();
    }

    // Get $userType_id
    $userType = 'Customer'; // Default user creation has to be customer
    $sqlUserType = "SELECT userType_id FROM UserType WHERE type = ?";
    $stmtUserType = mysqli_prepare($conn, $sqlUserType);
    mysqli_stmt_bind_param($stmtUserType, "s", $userType);
    mysqli_stmt_execute($stmtUserType);
    $resultUserType = mysqli_stmt_get_result($stmtUserType);
    $userTypeRow = mysqli_fetch_assoc($resultUserType);
    if ($userTypeRow) {
        $userType_id = $userTypeRow['userType_id'];
    } else {
        die("UserType not found");
    }

    // Get Phone Number
    $phoneNumber = $_POST["phone-number"];


    // Get $cardType_id 
    $cardType = $_POST["card-type"];
    //$defaultCardType = ''; // Default cardType
    $sqlCardType = "SELECT cardType_id FROM PaymentCardType WHERE type = ?";
    $stmtCardType = mysqli_prepare($conn, $sqlCardType);
    mysqli_stmt_bind_param($stmtCardType, "s", $cardType);
    mysqli_stmt_execute($stmtCardType);
    $resultCardType = mysqli_stmt_get_result($stmtCardType);
    $cardTypeRow = mysqli_fetch_assoc($resultCardType);
    if ($cardTypeRow) {
        $cardType_id = $cardTypeRow['cardType_id'];
    }
    // } else {
    //     // If user does not provide card type assign the default card type
    //     $stmtDefaultCardType = mysqli_prepare($conn, $sqlCardType);
    //     mysqli_stmt_bind_param($stmtDefaultCardType, "s", $defaultCardType);
    //     mysqli_stmt_execute($stmtDefaultCardType);
    //     $resultDefaultCardType = mysqli_stmt_get_result($stmtDefaultCardType);
    //     $defaultCardTypeRow = mysqli_fetch_assoc($resultDefaultCardType);

    //     if ($defaultCardTypeRow) {
    //         $cardType_id = $defaultCardTypeRow['cardType_id'];
    //     } 
    // }

    // Encrypt card number
    $encryptedCardNumber = null;
    if (!empty($_POST["card-number"])) {
        $cardNumber = $_POST["card-number"];
        $lastFour = substr($cardNumber, -4); //store last 4 numbers of the card
        $encryptionKey = 'encription-012df';
        $encryptedCardNumber = openssl_encrypt($cardNumber, 'aes-256-cbc', $encryptionKey, 0, $encryptionKey);
    }

    // Add Billing Address info if provided
    $billingAddressId = null;
    if (!empty($_POST["street-address-billing"]) && !empty($_POST["city-billing"]) && 
        !empty($_POST["state-billing"]) && !empty($_POST["zip-code-billing"])) {
            
        $sqlInsertBillingAddress = "INSERT INTO BillingAddress (billingStreetAddress, billingCity, billingState, billingZipCode) VALUES (?, ?, ?, ?)";
        $stmtInsertBillingAddress = mysqli_prepare($conn, $sqlInsertBillingAddress);
        if (!$stmtInsertBillingAddress) {
            die("SQL error: " . mysqli_error($conn));
        }

        // Handle errors
        try {
            // Execute
            mysqli_stmt_bind_param($stmtInsertBillingAddress, "ssss", $_POST["street-address-billing"], $_POST["city-billing"], $_POST["state-billing"], $_POST["zip-code-billing"]);
            $successInsertBillingAddress = mysqli_stmt_execute($stmtInsertBillingAddress);

            if (!$successInsertBillingAddress) {
                die("Error: Failed to add billing address. " . mysqli_error($conn));
            }

            // Get billing_id
            $billingAddressId = mysqli_insert_id($conn);
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        // Track billing_id even if the user did not provide Billing Address
        $sqlDefaultBilling = "INSERT INTO BillingAddress (billingStreetAddress, billingCity, billingState, billingZipCode) VALUES (?, ?, ?, ?)";
        $stmtDefaultBilling = mysqli_prepare($conn, $sqlDefaultBilling);
        if (!$stmtDefaultBilling) {
            die("SQL error: " . mysqli_error($conn));
        }

        // Default billing address values
        $defaultBillingStreet = "";
        $defaultBillingCity = "";
        $defaultBillingState = "";
        $defaultBillingZipCode = ""; //change to varchar in DB

        // Handle errors
        try {
            // Execute
            mysqli_stmt_bind_param($stmtDefaultBilling, "ssss", $defaultBillingStreet, $defaultBillingCity, $defaultBillingState, $defaultBillingZipCode);
            $successDefaultBilling = mysqli_stmt_execute($stmtDefaultBilling);

            if (!$successDefaultBilling) {
                die("Error: Failed to add default for billing address. " . mysqli_error($conn));
            }

            // Get billing_id
            $billingAddressId = mysqli_insert_id($conn);

        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    // Add Delivery Address info if provided
    $deliveryAddressId = null;
    if (!empty($_POST["street-address-shipping"]) && !empty($_POST["city-shipping"]) && 
        !empty($_POST["state-shipping"]) && !empty($_POST["zip-code-shipping"])) {

        $sqlInsertDeliveryAddress = "INSERT INTO DeliveryAddress (deliveryStreetAddress, deliveryCity, deliveryState, deliveryZipCode) VALUES (?, ?, ?, ?)";
        $stmtInsertDeliveryAddress = mysqli_prepare($conn, $sqlInsertDeliveryAddress);
        if (!$stmtInsertDeliveryAddress) {
            die("SQL error: " . mysqli_error($conn));
        }

        // Handle errors
        try {
            // Execute
            mysqli_stmt_bind_param($stmtInsertDeliveryAddress, "ssss", $_POST["street-address-shipping"], $_POST["city-shipping"], $_POST["state-shipping"], $_POST["zip-code-shipping"]);
            $successInsertDeliveryAddress = mysqli_stmt_execute($stmtInsertDeliveryAddress);

            if (!$successInsertDeliveryAddress) {
                die("Error: Failed to add delivery address. " . mysqli_error($conn));
            }

            // Get delivery_id
            $deliveryAddressId = mysqli_insert_id($conn);

        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    } else {
        // Track delivery_id even if the user did not provide Delivery Address
        $sqlDefaultDelivery = "INSERT INTO DeliveryAddress (deliveryStreetAddress, deliveryCity, deliveryState, deliveryZipCode) VALUES (?, ?, ?, ?)";
        $stmtDefaultDelivery = mysqli_prepare($conn, $sqlDefaultDelivery);

        if (!$stmtDefaultDelivery) {
            die("SQL error: " . mysqli_error($conn));
        }

        // Default delivery address values
        $defaultStreet = "";
        $defaultCity = "";
        $defaultState = "";
        $defaultZipCode = ""; //change to varchar in DB

        // Handle errors
        try {
            // Execute
            mysqli_stmt_bind_param($stmtDefaultDelivery, "ssss", $defaultStreet, $defaultCity, $defaultState, $defaultZipCode);
            $successDefaultDelivery = mysqli_stmt_execute($stmtDefaultDelivery);

            if (!$successDefaultDelivery) {
                die("Error: Failed to add default delivery address. " . mysqli_error($conn));
            }


            // Get delivery_id
            $deliveryAddressId = mysqli_insert_id($conn);

        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }


    // Promo Subscription 
    $promoSubscription = isset($_POST['subscribe-promos']) ? 1 : 2;

    // Add into Users table
    $sqlUsers = "INSERT INTO Users (email, password, firstName, lastName, phoneNumber, userStatus_id, userType_id, promoSub_id, billing_id, delivery_id)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtUsers = mysqli_prepare($conn, $sqlUsers);
    if (!$stmtUsers) {
        die("SQL error: " . mysqli_error($conn));
    }

    // Users execute 
    mysqli_stmt_bind_param($stmtUsers, "sssssiiiii", $_POST["email-address"], $password_hash, $_POST["first-name"], $_POST["last-name"], $phoneNumber, $userStatus_id, $userType_id, $promoSubscription, $billingAddressId, $deliveryAddressId);
    if (!mysqli_stmt_execute($stmtUsers)) {
        die("Error: Failed to insert into Users table. " . mysqli_error($conn));
    }

    // Check if the rows are affected
    if (mysqli_affected_rows($conn) > 0) {
        // Get the last added user_id
        $lastUserId = mysqli_insert_id($conn);

        // Check if payment card was added
        if (!empty($encryptedCardNumber) && !empty($_POST["expiration-month"]) && !empty($_POST["expiration-year"])) {
            // Card 1
            $sqlPaymentCard = "INSERT INTO PaymentCard1 (cardNum, lastFour, cardType_id, expMonth, expYear, firstName, lastName, users_id)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtPaymentCard = mysqli_prepare($conn, $sqlPaymentCard);
            if (!$stmtPaymentCard) {
                die("SQL error: " . mysqli_error($conn));
            }

            // Card 2
            $sqlPaymentCard2 = "INSERT INTO PaymentCard2 (cardNum, lastFour,  cardType_id, expMonth, expYear, firstName, lastName, users_id)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtPaymentCard2 = mysqli_prepare($conn, $sqlPaymentCard2);
            if (!$stmtPaymentCard2) {
                die("SQL error: " . mysqli_error($conn));
            }

            // Card 3
            $sqlPaymentCard3 = "INSERT INTO PaymentCard3 (cardNum, lastFour, cardType_id, expMonth, expYear, firstName, lastName, users_id)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtPaymentCard3 = mysqli_prepare($conn, $sqlPaymentCard3);
            if (!$stmtPaymentCard3) {
                die("SQL error: " . mysqli_error($conn));
            }

            // Default card values
            $defaultCardNum = "";
            $defaultCardType_id = null; 
            $defaultExpMonth = "";
            $defaultExpYear = "";
            $defaultFirstName = "";
            $defaultLastName = "";
            $defaultLastFour = "0";


            
            // Execute add cards
            if (!mysqli_stmt_bind_param($stmtPaymentCard, "siissssi", $encryptedCardNumber, $lastFour, $cardType_id, $_POST["expiration-month"], $_POST["expiration-year"], $_POST["card-first-name1"], $_POST["card-last-name1"], $lastUserId)) {
                die("Error:  Failed to pull PaymentCard1.");
            }
            if (!mysqli_stmt_execute($stmtPaymentCard)) {
                die("Error: Failed to execute the PaymentCard1 query. " . mysqli_error($conn));
            }
            if (!mysqli_stmt_bind_param($stmtPaymentCard2, "siissssi", $defaultCardNum, $defaultLastFour, $defaultCardType_id, $defaultExpMonth, $defaultExpYear, $defaultFirstName, $defaultLastName, $lastUserId)) {
                die("Error: Failed to bind parameters for PaymentCard2.");
            }
            if (!mysqli_stmt_execute($stmtPaymentCard2)) {
                die("Error: Failed to execute the PaymentCard2 query. " . mysqli_error($conn));
            }
            if (!mysqli_stmt_bind_param($stmtPaymentCard3, "siissssi", $defaultCardNum, $defaultLastFour, $defaultCardType_id, $defaultExpMonth, $defaultExpYear, $defaultFirstName, $defaultLastName, $lastUserId)) {
                die("Error: Failed to bind parameters for PaymentCard3.");
            }
            if (!mysqli_stmt_execute($stmtPaymentCard3)) {
                die("Error: Failed to execute the PaymentCard3 query. " . mysqli_error($conn));
            }
        } else {

            // Track the 3 cards if the user does not add payment card

            // Card 1
            $sqlPaymentCard1 = "INSERT INTO PaymentCard1 (cardNum, lastFour, cardType_id, expMonth, expYear, firstName, lastName, users_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtPaymentCard1 = mysqli_prepare($conn, $sqlPaymentCard1);
            if (!$stmtPaymentCard1) {
                die("SQL error: " . mysqli_error($conn));
            }

            // Card 2
            $sqlPaymentCard2 = "INSERT INTO PaymentCard2 (cardNum, lastFour, cardType_id, expMonth, expYear, firstName, lastName, users_id)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtPaymentCard2 = mysqli_prepare($conn, $sqlPaymentCard2);
            if (!$stmtPaymentCard2) {
                die("SQL error: " . mysqli_error($conn));
            }

            // Card 3
            $sqlPaymentCard3 = "INSERT INTO PaymentCard3 (cardNum, lastFour, cardType_id, expMonth, expYear, firstName, lastName, users_id)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtPaymentCard3 = mysqli_prepare($conn, $sqlPaymentCard3);
            if (!$stmtPaymentCard3) {
                die("SQL error: " . mysqli_error($conn));
            }

            
            // Default card values
            $defaultCardNum = ""; 
            $defaultCardType_id = null; 
            $defaultExpMonth = ""; 
            $defaultExpYear = ""; 
            $defaultFirstName = ""; 
            $defaultLastName = "";
            $defaultLastFour ="0";
            
            // Execute add defult cards
            if (!mysqli_stmt_bind_param($stmtPaymentCard1, "siissssi", $defaultCardNum, $defaultLastFour, $defaultCardType_id, $defaultExpMonth, $defaultExpYear, $defaultFirstName, $defaultLastName, $lastUserId)) {
                die("Error: Failed to add default paymentCard1.");
            }
            if (!mysqli_stmt_execute($stmtPaymentCard1)) {
                die("Error: Failed to execute the default PaymentCard1. " . mysqli_error($conn));
            }
            if (!mysqli_stmt_bind_param($stmtPaymentCard2, "siissssi", $defaultCardNum, $defaultLastFour, $defaultCardType_id, $defaultExpMonth, $defaultExpYear, $defaultFirstName, $defaultLastName, $lastUserId)) {
                die("Error: Failed to add default paymentCard2.");
            }
            if (!mysqli_stmt_execute($stmtPaymentCard2)) {
                die("Error: Failed to execute the default PaymentCard2. " . mysqli_error($conn));
            }
            if (!mysqli_stmt_bind_param($stmtPaymentCard3, "siissssi", $defaultCardNum, $defaultLastFour, $defaultCardType_id, $defaultExpMonth, $defaultExpYear, $defaultFirstName, $defaultLastName, $lastUserId)) {
                die("Error: Failed to add default paymentCard3.");
            }
            if (!mysqli_stmt_execute($stmtPaymentCard3)) {
                die("Error: Failed to execute the default PaymentCard3. " . mysqli_error($conn));
            }
        }
        

        // Send PIN
        session_start();
        $email = $_POST["email-address"];
        $_SESSION["resetEmail"] = $email;
//
        if(invalidEmail($email) !== false) {
            header("Location: register.php?error=invalid");
            exit();
        }
//
        else if(userExists($conn, $email) == false) {
            header("Location: register.php?error=missingaccount");
            exit();
        }
//
        else {
            //generates a unique PIN for the user
            generatePINAccountActivation($conn, $email);
            // Redirect 
            header("Location: registrationconfirmation.php?email=".$email);
        }

        
        exit;
    } else {
        die("Error: Failed to insert into Users table.");
    }


    // Close statement
    mysqli_stmt_close($stmtUsers);

    // Close connection
    mysqli_close($conn);
        
?>