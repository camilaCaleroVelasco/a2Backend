<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "includes/dbh.inc.php";

function getPaymentMethods($user_id, $conn) {
    $paymentMethods = array();
    
    // Loop through payment card tables (paymentcard1, paymentcard2, paymentcard3)
    for ($i = 1; $i <= 3; $i++) {
        $tableName = "paymentcard" . $i;
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
    if (isValidCode($code, $conn)) {
        if (!hasBeenUsed($code, $userID, $conn)) {
            // Add promo code to PromoCodeUse table
            $promoID = getPromoID($code, $conn);
            if ($promoID !== false) {
                if (addPromoCodeUse($promoID, $userID, $conn)) {
                    return "Promo code applied successfully!";
                } else {
                    return "Failed to apply promo code. Please try again later.";
                }
            } else {
                return "Promo code not found.";
            }
        } else {
            return "Promo code has already been used.";
        }
    } else {
        return "Invalid promo code.";
    }
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
