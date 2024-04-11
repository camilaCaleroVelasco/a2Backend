<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

require_once 'includes/dbh.inc.php';
require_once 'functions/cardFunctions.php';
require_once 'functions/emailsFunctions.php';

$userSuccess = false;
$billingSuccess = false;
$deliverySuccess = false;
$subscriptionSucess = false;
$changePWDSuccess = false;

// Check if user is logged in
if (isset($_SESSION["users_id"])) {
    $users_id = $_SESSION["users_id"];

    // Get the current Users information including billing address
    $sql = "SELECT Users.*, BillingAddress.*, DeliveryAddress.*
            FROM Users 
            LEFT JOIN BillingAddress ON Users.billing_id = BillingAddress.billing_id 
            LEFT JOIN DeliveryAddress ON Users.delivery_id = DeliveryAddress.delivery_id 
            WHERE users_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $users_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Get current values and store it
    if ($row = mysqli_fetch_assoc($result)) {
        // Current User info
        $currentEmail = $row['email'];
        $currentFirstName = $row['firstName'];
        $currentLastName = $row['lastName'];
        $currentPhoneNumber = $row['phoneNumber'];
        // Current Billing Info
        $currentBillingStreetAddress = $row['billingStreetAddress'];
        $currentBillingCity = $row['billingCity'];
        $currentBillingState = $row['billingState'];
        $currentBillingZipCode = $row['billingZipCode'];
        $currentBillingId = $row['billing_id'];
        // Current Delivery Info
        $currentDeliveryStreetAddress = $row['deliveryStreetAddress'];
        $currentDeliveryCity = $row['deliveryCity'];
        $currentDeliveryState = $row['deliveryState'];
        $currentDeliveryZipCode = $row['deliveryZipCode'];
        $currentDeliveryId = $row['delivery_id'];
        // Current Promo Subscription
        $currentPromoSubId = $row['promoSub_id'];

        mysqli_stmt_close($stmt);


        // Get the current paymentcard1 information including billing address
        $sql1 = "SELECT * FROM paymentcard1 WHERE users_id = ?";
        $stmt1 = mysqli_prepare($conn, $sql1);
        mysqli_stmt_bind_param($stmt1, "i", $users_id);
        mysqli_stmt_execute($stmt1);
        $result1 = mysqli_stmt_get_result($stmt1);
        
        if ($row = mysqli_fetch_assoc($result1)) {
            // Current PaymentCard 1
            $currentCard1FirstName = $row['firstName'];
            $currentCard1LastName = $row['lastName'];
            $currentCard1CardType = $row['cardType_id'];
            $currentCard1ExpMonth = $row['expMonth'];
            $currentCard1ExpYear = $row['expYear'];

            mysqli_stmt_close($stmt1);

            // Get the current paymentcard2 information including billing address
            $sql = "SELECT * FROM paymentcard2 WHERE users_id = ?";
            $stmt2 = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt2, "i", $users_id);
            mysqli_stmt_execute($stmt2);
            $result2 = mysqli_stmt_get_result($stmt2);

            if ($row = mysqli_fetch_assoc($result2)) {
                 // Current PaymentCard 2
                $currentCard2FirstName = $row['firstName'];
                $currentCard2LastName = $row['lastName'];
                $currentCard2CardType = $row['cardType_id'];
                $currentCard2ExpMonth = $row['expMonth'];
                $currentCard2ExpYear = $row['expYear'];
                mysqli_stmt_close($stmt2);

                // Get the current paymentcard2 information including billing address
                $sql = "SELECT * FROM paymentcard3 WHERE users_id = ?;";
                $stmt3 = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt3, "i", $users_id);
                mysqli_stmt_execute($stmt3);
                $result3 = mysqli_stmt_get_result($stmt3);

                if ($row = mysqli_fetch_assoc($result3)) {
                     // Current PaymentCard 3
                    $currentCard3FirstName = $row['firstName'];
                    $currentCard3LastName = $row['lastName'];
                    $currentCard3CardType = $row['cardType_id'];
                    $currentCard3ExpMonth = $row['expMonth'];
                    $currentCard3ExpYear = $row['expYear'];
                    mysqli_stmt_close($stmt3);
                }
            }
        }
        
    } 
    // If the form was submitted
    if (isset($_POST['submit'])) {
        
        // Check if user information was submitted
        if (!empty($_POST['first-name']) || !empty($_POST['last-name']) || !empty($_POST['email-address']) || !empty($_POST['phone-number'])) {
            // Update user information
            $updateFirstName = mysqli_real_escape_string($conn, $_POST['first-name']);
            $updateLastName = mysqli_real_escape_string($conn, $_POST['last-name']);
            $updateEmail = mysqli_real_escape_string($conn, $_POST['email-address']);
            $updatePhoneNumber = mysqli_real_escape_string($conn, $_POST['phone-number']);

            $sqlUpdateUser = "UPDATE Users SET email=?, firstName=?, lastName=?, phoneNumber=? WHERE users_id=?";
            $stmtUpdateUser = mysqli_prepare($conn, $sqlUpdateUser);
            mysqli_stmt_bind_param($stmtUpdateUser, "ssssi", $updateEmail, $updateFirstName, $updateLastName, $updatePhoneNumber, $users_id);
            mysqli_stmt_execute($stmtUpdateUser);

            if (mysqli_stmt_affected_rows($stmtUpdateUser) > 0) {
                $userSuccess = true;
                echo "User information updated successfully<br>";
                echo "Form submitted successfully<br>";
                var_dump($_POST); // Check form data

            }
        }
        

        // Check if billing address has changed
        if (!empty($_POST['street-address-billing']) || !empty($_POST['city-billing']) || !empty($_POST['state-billing']) || !empty($_POST['zip-code-billing'])) {
            // Update billing address
            $updateBillingStreetAddress = mysqli_real_escape_string($conn, $_POST['street-address-billing']);
            $updateBillingCity = mysqli_real_escape_string($conn, $_POST['city-billing']);
            $updateBillingState = mysqli_real_escape_string($conn, $_POST['state-billing']);
            $updateBillingZipCode = mysqli_real_escape_string($conn, $_POST['zip-code-billing']);

            $sqlUpdateBilling = "UPDATE BillingAddress SET billingStreetAddress=?, billingCity=?, billingState=?, billingZipCode=? WHERE billing_id=?";
            $stmtUpdateBilling = mysqli_prepare($conn, $sqlUpdateBilling);
            mysqli_stmt_bind_param($stmtUpdateBilling, "ssssi", $updateBillingStreetAddress, $updateBillingCity, $updateBillingState, $updateBillingZipCode, $currentBillingId);
            mysqli_stmt_execute($stmtUpdateBilling);

            if (mysqli_stmt_affected_rows($stmtUpdateBilling) > 0) {
                $billingSuccess = true;
                echo "Billing address updated successfully<br>";
                echo "Form submitted successfully<br>";
                var_dump($_POST); // Check form data

            }
        }

        // Check if delivery address has changed
        if (!empty($_POST['street-address-shipping']) || !empty($_POST['city-shipping']) || !empty($_POST['state-shipping']) || !empty($_POST['zip-code-shipping'])) {
            // Update delivery address
            $updateDeliveryStreetAddress = mysqli_real_escape_string($conn, $_POST['street-address-shipping']);
            $updateDeliveryCity = mysqli_real_escape_string($conn, $_POST['city-shipping']);
            $updateDeliveryState = mysqli_real_escape_string($conn, $_POST['state-shipping']);
            $updateDeliveryZipCode = mysqli_real_escape_string($conn, $_POST['zip-code-shipping']);

            $sqlUpdateDelivery = "UPDATE DeliveryAddress SET deliveryStreetAddress=?, deliveryCity=?, deliveryState=?, deliveryZipCode=? WHERE delivery_id=?";
            $stmtUpdateDelivery = mysqli_prepare($conn, $sqlUpdateDelivery);
            mysqli_stmt_bind_param($stmtUpdateDelivery, "ssssi", $updateDeliveryStreetAddress, $updateDeliveryCity, $updateDeliveryState, $updateDeliveryZipCode, $currentDeliveryId);
            mysqli_stmt_execute($stmtUpdateDelivery);

            if (mysqli_stmt_affected_rows($stmtUpdateDelivery) > 0) {
                $deliverySuccess = true;
                echo "Delivery address updated successfully<br>";
            } else {
                // If the query fails, print the error
                echo "Error updating delivery address: " . mysqli_error($conn);
                echo "Form submitted successfully<br>";
                var_dump($_POST); // Check form data

            }
        }

        
        // Check if the checkbox is checked
        $promoSubs = isset($_POST['subscribe-promos']) ? 1 : 2;
        
        // Update the promotional subscription status in the database
        $sqlUpdatePromoSub = "UPDATE Users SET promoSub_id = ? WHERE users_id = ?";
        $stmtUpdatePromoSub = mysqli_prepare($conn, $sqlUpdatePromoSub);
        mysqli_stmt_bind_param($stmtUpdatePromoSub, "ii", $promoSubs, $users_id);
        mysqli_stmt_execute($stmtUpdatePromoSub);

        if (mysqli_stmt_affected_rows($stmtUpdatePromoSub) > 0) {
            // Subscription status updated successfully
            $subscriptionSucess = true;
            echo "Promotional subscription status updated successfully<br>";
        } else {
            // Error updating subscription status
            echo "Error updating promotional subscription status: " . mysqli_error($conn);
        }

        // Check if password is changed
        $email = $_SESSION["email"];
        if (!empty($_POST["old-password"]) || !empty($_POST["new-password"]) || !empty($_POST["new-confirm-password"])) {

            $oldPWD = $_POST["old-password"];
            $newPWD = $_POST["new-password"];
            $confirmPWD = $_POST["new-confirm-password"];
  
            if (strlen($newPWD) <= 7) {
                header("Location: editProfile.php?error=pwdlength");
            }
            else if ( ! preg_match("/[a-z]/i", $newPWD)) {
                header("Location: editProfile.php?error=pwdChar");
            }
            else if ( ! preg_match("/[0-9]/", $newPWD)) {
                header("Location: editProfile.php?error=pwdNum");
            }
            else if ($newPWD !== $confirmPWD) {
                header("Location: editProfile.php?error=pwdMismatch");
            }
            else {
                changePassword($conn, $email, $oldPWD, $newPWD);
                $changePWDSuccess = true;
            }
        }

        //Check if paymentcard1 was updated
        if(!empty($_POST["card-first-name1"]) ||  !empty($_POST["card-last-name1"]) || !empty($_POST["card-type1"]) || !empty($_POST["card-number1"]) 
        || !empty($_POST["expiration-month1"]) || !empty($_POST["expiration-year1"])) {

            $firstName = $_POST["card-first-name1"];
            $lastName = $_POST["card-last-name1"];
            $cardType = $_POST["card-type1"];
            $cardNumber = $_POST["card-number1"];
            $encryptionKey = 'encription-012df';
            $encryptedCardNumber = openssl_encrypt($cardNumber, 'aes-256-cbc', $encryptionKey, 0, $encryptionKey);
            $expMonth = $_POST["expiration-month1"];
            $expYear = $_POST["expiration-year1"];
            $email = $_SESSION["email"];

                if (!userPaymentCard1Exists($conn, $email)) {
                    $usersid = getUsersID($conn, $email);
                    addUserPaymentCard1($conn, $usersid, $encryptedCardNumber, $cardType, $expMonth, $expYear, $firstName, $lastName);
                    updateNumCard($conn, $email, 1);
                }
                else if (userPaymentCard1Exists($conn, $email) ) {
                    $usersid = getUsersID($conn, $email);
                    updateUserPaymentCard1($conn, $usersid, $encryptedCardNumber, $cardType, $expMonth, $expYear, $firstName, $lastName);
                }
        }
        
        
        //Check if paymentcard2 was updated
        if(!empty($_POST["card-first-name2"]) ||  !empty($_POST["card-last-name2"]) || !empty($_POST["card-type2"]) || !empty($_POST["card-number2"]) 
                || !empty($_POST["expiration-month2"]) || !empty($_POST["expiration-year2"])) {
        
            $firstName = $_POST["card-first-name2"];
            $lastName = $_POST["card-last-name2"];
            $cardType = $_POST["card-type2"];
            $cardNumber = $_POST["card-number2"];
            $encryptionKey = 'encription-012df';
            $encryptedCardNumber = openssl_encrypt($cardNumber, 'aes-256-cbc', $encryptionKey, 0, $encryptionKey);
            $expMonth = $_POST["expiration-month2"];
            $expYear = $_POST["expiration-year2"];
            $email = $_SESSION["email"];
                if (!userPaymentCard2Exists($conn, $email)) {
                    $usersid = getUsersID($conn, $email);
                    addUserPaymentCard2($conn, $usersid, $encryptedCardNumber, $cardType, $expMonth, $expYear, $firstName, $lastName);
                    updateNumCard($conn, $email, 2);
                    header("Location: editProfile.php?success=paymentAdded");
                }
                else if (userPaymentCard2Exists($conn, $email) ) {
                $usersid = getUsersID($conn, $email);
                updateUserPaymentCard2($conn, $usersid, $encryptedCardNumber, $cardType, $expMonth, $expYear, $firstName, $lastName);
                header("Location: editProfile.php?success=paymentAdded");
                }
        }

        //Check if paymentcard3 was updated
        if(!empty($_POST["card-first-name3"]) ||  !empty($_POST["card-last-name3"]) || !empty($_POST["card-type3"]) || !empty($_POST["card-number3"]) 
                || !empty($_POST["expiration-month3"]) || !empty($_POST["expiration-year3"])) {
        
            $firstName = $_POST["card-first-name3"];
            $lastName = $_POST["card-last-name3"];
            $cardType = $_POST["card-type3"];
            $cardNumber = $_POST["card-number3"];
            $encryptionKey = 'encription-012df';
            $encryptedCardNumber = openssl_encrypt($cardNumber, 'aes-256-cbc', $encryptionKey, 0, $encryptionKey);
            $expMonth = $_POST["expiration-month3"];
            $expYear = $_POST["expiration-year3"];
            $email = $_SESSION["email"];
            
                if (!userPaymentCard3Exists($conn, $email)) {
                    $usersid = getUsersID($conn, $email);
                    addUserPaymentCard3($conn, $usersid, $encryptedCardNumber, $cardType, $expMonth, $expYear, $firstName, $lastName);
                    updateNumCard($conn, $email, 3);
                }
                else if (userPaymentCard3Exists($conn, $email) ) {
                $usersid = getUsersID($conn, $email);
                updateUserPaymentCard3($conn, $usersid, $encryptedCardNumber, $cardType, $expMonth, $expYear, $firstName, $lastName);
                }
        }

        

        if ($userSuccess == true || $billingSuccess == true || $deliverySuccess == true ||
         $subscriptionSucess == true || $changePWDSuccess == true) {

            // Created a function inside of functions that has the emailing 
            sendEmailEditProfileSuccess($email);
        }

        // Redirect
        header("Location: editProfile.php?success=editProfileUpdate");
        exit;
    }
} 
// Delete Card option
if (isset($_POST['delete1'])) {
    deleteUserPaymentCard1($conn, $_SESSION['users_id']);
    sendEmailEditProfileSuccess($email);
    header("Location: editProfile.php?success=editProfileUpdate");
    exit;

}
if (isset($_POST['delete2'])) {
    deleteUserPaymentCard2($conn, $_SESSION['users_id']);
    sendEmailEditProfileSuccess($email);
    header("Location: editProfile.php?success=editProfileUpdate");
    exit;

}
if (isset($_POST['delete3'])) {
    deleteUserPaymentCard3($conn, $_SESSION['users_id']);
    sendEmailEditProfileSuccess($email);
    header("Location: editProfile.php?success=editProfileUpdate");
    exit;

}
?>
