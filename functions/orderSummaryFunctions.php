<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "includes/dbh.inc.php";

function getPaymentMethods($user_id, $conn) {
    $paymentMethods = array();
    
    // Loop through payment card tables (PaymentCard1, PaymentCard2, PaymentCard3)
    for ($i = 1; $i <= 3; $i++) {
        $tableName = "PaymentCard" . $i;
        $sql = "SELECT lastFour FROM $tableName WHERE users_id = ? AND cardNum IS NOT NULL AND cardNum != ''";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ordersummary.php?error=stmtfailed"); 
            exit();
        }
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($resultData)) {
        $paymentMethods[] = $row['lastFour'];
    }

    mysqli_stmt_close($stmt);
}

return $paymentMethods;
}

function applyPromoCode($code, $userID, $conn) {
    $result = ["status" => "failure", "message" => "Unknown error.", "discount" => 0];

    if (isValidCode($code, $conn)) {
        if (!hasBeenUsed($code, $userID, $conn)) {
            // Retrieve the promotion details
            $sql = "SELECT percentDiscount FROM promotion 
                    WHERE promoCode = ? 
                    AND CURDATE() BETWEEN 
                        STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', startMonth, '-', startDay), '%Y-%c-%e') 
                        AND 
                        STR_TO_DATE(CONCAT(YEAR(CURDATE()), '-', endMonth, '-', endDay), '%Y-%c-%e')";

            $stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $code);
                mysqli_stmt_execute($stmt);
                $resultData = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($resultData);
                if ($row) {
                    // Add promo code to PromoCodeUse table
                    $promoID = getPromoID($code, $conn);
                    if ($promoID !== false && addPromoCodeUse($promoID, $userID, $conn)) {
                        $result["status"] = "success";
                        $result["message"] = "Promo code applied successfully!";
                        $result["discount"] = $row['percentDiscount'];
                    } else {
                        $result["message"] = "Failed to apply promo code. Please try again later.";
                    }
                } else {
                    $result["message"] = "Promo code not found or expired.";
                }
            }
        } else {
            $result["message"] = "Promo code has already been used.";
        }
    } else {
        $result["message"] = "Invalid promo code.";
    }

    return $result;
}

function isValidCode($code, $conn) {
    $sql = "SELECT * FROM Promotion WHERE promoCode = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $code);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    return mysqli_num_rows($result) > 0;
}

function hasBeenUsed($code, $userID, $conn) {
    $promoID = getPromoID($code, $conn);
    if ($promoID !== false) {
        $sql = "SELECT * FROM PromoCodeUse WHERE promo_id = ? AND user_id = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            return true;
        }

        mysqli_stmt_bind_param($stmt, "ii", $promoID, $userID);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        return mysqli_num_rows($result) > 0;
    } else {
        return true;
    }
}

function getPromoID($code, $conn) {
    $sql = "SELECT promo_id FROM Promotion WHERE promoCode = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "s", $code);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row['promo_id'];
    } else {
        return false;
    }
}

function addPromoCodeUse($promoID, $userID, $conn) {
    $sql = "INSERT INTO PromoCodeUse (promo_id, user_id) VALUES (?, ?)";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return false;
    }

    mysqli_stmt_bind_param($stmt, "ii", $promoID, $userID);

    return mysqli_stmt_execute($stmt);
}

function sendEmailConfirmation($email, $movie_title, $adult, $child, $senior, $selected_seats, $date, $time,  $subtotal, $taxAmount, $totalWithTax, $discount, $discountedPrice, $paymentMethod) {
    $mail = require "mailer.php";
    $mail->setFrom("noreply@example.com");
    $mail->addAddress($email);
    $mail->Subject = "Order Confirmation";
        $body = "<h2>Thank you for your purchase!</h2>";
        $body .= "<h3>Order Details:</h3>";
        $body .= "<h4>Movie: $movie_title <br><br>";
        $body .= "Date: $date <br>";
        $body .= "Time: $time <br><br>";
        
        $body .= "Seats Selected: $selected_seats <br><br>";
        
        if ($adult > 0) {
            $body .= "Adult Tickets: $adult <br>";
        }
        if ($child > 0) {
            $body .= "Child Tickets: $child <br>";
        }
        if ($senior > 0) {
            $body .= "Senior Tickets: $senior <br>";
        }

        $body .= "<br>";
        $body .= "Subtotal: $$subtotal <br>";
        $body .= "Tax (7%): $$taxAmount <br>";
        $body .= "Total Price: $$totalWithTax <br>";
        // Add discount information if applicable
        if ($discount > 0) {
            $body .= "Discount: $discount % <br>";
        }

        $body .= "Payment: $paymentMethod <br>";

        $body .= "Final Total Price: $$discountedPrice </h4><br>";
        
        $mail->Body = $body;

    try {
        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        exit();
    }

}

function getEmail($user_id, $conn) {
    $email = null;
    $sql = "SELECT email FROM Users WHERE users_id = ?";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);

        // Get result
        $result = mysqli_stmt_get_result($stmt);

        // Get email from result
        if ($row = mysqli_fetch_assoc($result)) {
            $email = $row['email'];
        }
        // Close
        mysqli_stmt_close($stmt);
    }
    return $email;

}

function updateBooking($conn) {

}