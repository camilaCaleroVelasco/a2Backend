<?php
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
