<?php
ini_set('display_errors', 1); // Debugging
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

include_once 'includes/databaseConnection.inc.php'; 
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

$userSuccess = false;
$billingSuccess = false;
$deliverySuccess = false;

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

    // Fetch the result and store it in variables
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

    } else {
        echo "User not found";
        exit;
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
            }
        }


        if ($userSuccess == true || $billingSuccess == true || $deliverySuccess) {

            // Email Information Changed
            $mail = require __DIR__ . "/mailer.php";
            $mail->setFrom("noreply@example.com");
            $mail->addAddress($_POST["email-address"]);
            $mail->Subject = "Information Changed";
            $mail->Body = <<<END
                Your personal information was changed successfully!
            END;
            try {
                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
                exit;
            }
        }

        // Redirect to the index
        header("Location: index.php");
        exit;
    }
} else {
    echo "Please log in to access this page";
}
?>
