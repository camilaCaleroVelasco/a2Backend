<?php
// need registration version
function userExists($conn, $email) {
    $sql = "SELECT * FROM users WHERE email = ?;";
    $stmt = mysqli_stmt_init($conn);
    $result;
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: forgotPassword.php?error=stmtfailed"); // change this link
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        $result = true;
    }
    else {
        $result = false;
    }
    mysqli_stmt_close($stmt);
    return $result;
}


  function invalidEmail($email) {
    $result;
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = false;
    }
    else {
        $result = true;
    }
    return $result;
}

    // generate pin for account activation
    function generatePINAccountActivation($conn, $email) {
        //initially generate a PIN
        $pin1 = rand(0,9);
        $pin2 = rand(0,9);
        $pin3 = rand(0,9);
        $pin4 = rand(0,9);

        // check if PIN is unique, if not, keep regenerating
        while (notUniquePIN($conn, $pin1, $pin2, $pin3, $pin4)) {
            $pin1 = rand(0,9);
            $pin2 = rand(0,9);
            $pin3 = rand(0,9);
            $pin4 = rand(0,9);
        }

        updatePIN($conn, $email, $pin1, $pin2, $pin3, $pin4);

        sendPINEmailAccountActivation($email, $pin1, $pin2, $pin3, $pin4);

    }

        // NEED AccountActivation Version
    //Ensures PIN is unique within the DB
    function notUniquePIN($conn, $pin1, $pin2, $pin3, $pin4) {
        $sql = "SELECT pwdResetPin1, pwdResetPin2, pwdResetPin3, pwdResetPin4 FROM users WHERE pwdResetPin1 = ? AND pwdResetPin2 = ? AND pwdResetPin3 = ? AND pwdResetPin4 = ?;";
        $stmt = mysqli_stmt_init($conn);
        $result;
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: forgotPassword.php?error=stmtfailed");  // needs account activation error link
            exit();
        }

        mysqli_stmt_bind_param($stmt, "iiii", $pin1, $pin2, $pin3, $pin4);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            $result = true;
        }
        else {
            $result = false;
        }
        mysqli_stmt_close($stmt);
        return $result;


    }

    // NEED AccountActivation Version
    function updatePIN($conn, $email, $pin1, $pin2, $pin3, $pin4) {
        $sql = "UPDATE users SET pwdResetPin1 = ?, pwdResetPin2 = ?, pwdResetPin3 = ?, pwdResetPin4 = ? WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: resetPasswordVerif.php?error=stmtfailed"); // needs account activation error link
            exit();
        }

        mysqli_stmt_bind_param($stmt, "iiiis", $pin1, $pin2, $pin3, $pin4, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    }

     // NEED AccountActivation Version
    // Check if the attempted PIN is correct
    function correctPIN($conn, $email, $pin1, $pin2, $pin3, $pin4) {

        $sql = "SELECT pwdResetPin1, pwdResetPin2, pwdResetPin3, pwdResetPin4 FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        $result;

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: forgotPassword.php?error=stmtfailed"); // needs account activation error link
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);
        $pinData = mysqli_fetch_assoc($resultData);

        if ($pinData["pwdResetPin1"] == $pin1 && $pinData["pwdResetPin2"] == $pin2 
            && $pinData["pwdResetPin3"] == $pin3 && $pinData["pwdResetPin4"] == $pin4) {
                $result = true;
        }
        else {
            $result = false;
        }
        mysqli_stmt_close($stmt);
        return $result;
    }

    //Pull user data with matching email
    function pullCurrentPassword($conn, $email) {
        $sql = "SELECT * FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: login.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            return $row;
        }
        else {
            $result = false;
        }
        mysqli_stmt_close($stmt);
    }

    function changePassword($conn, $email, $oldPWD, $newPWD) {

        $emailExists = pullCurrentPassword($conn, $email);

        $pwdHashed = $emailExists["password"];
        $checkpwd = password_verify($oldPWD, $pwdHashed);

        if ($checkpwd == false) {
            header("Location: "); // NEEDS TO BE FILLED OUT
            exit();
        }
        else if ($checkpwd == true) {
            updatePWD($conn, $email, $newPWD);
        }
    }

    // NEED AccountActivation Version
    function updatePWD($conn, $email, $pwd) {
        $sql = "UPDATE users SET password = ? WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: resetPassword.php?error=stmtfailed"); // needs account activation error link
            exit();
        }

        $password_hash = password_hash($pwd, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "ss", $password_hash, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    }

    // Send pin to email to activate account
    function sendPINEmailAccountActivation($email, $pin1, $pin2, $pin3, $pin4) {
        $mail = require "mailer.php";
        $mail->setFrom("noreply@example.com");
        $mail->addAddress($email);
        $mail->Subject = "Activate Account PIN";
        $mail->Body = <<<END
        To activate your account, please type in the following PIN:
        <br>
        $pin1 $pin2 $pin3 $pin4
        END; // Change URL according to your localhost directory
        try {
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
            exit();
        }

    }

    function sendEmailEditProfileSuccess($email) {
        $mail = require "mailer.php";
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
            exit();
        }
    }

    function userPaymentCard1Exists($conn, $email) {
        $usersid = getUsersID($conn, $email);
        $result;
        if($usersid == false) {
            header("Location: editProfile.php?error=idnotfound");
            exit();
        }
        else {

        $sql = "SELECT * FROM paymentcard1 WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $usersid);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            $result = true;
        }
        else {
            $result = false;
        }
        mysqli_stmt_close($stmt);
        }
         return $result;
    }

    function getUsersID($conn, $email) {
        $sql = "SELECT * FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        $result;
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editprofile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            $result = $row["users_id"];
        }
        else {
            $result = false;
        }
        mysqli_stmt_close($stmt);
        return $result;
    }

    function addUserPaymentCard1($conn, $usersid, $cardNum, $cardType_id, $expMonth, $expYear, $firstName, $lastName) {
        //encrypt payment card code here 
        $sql = "INSERT INTO paymentcard1 (cardNum, cardType_id, expMonth, expYear,
        firstName, lastName, users_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sissssi", $cardNum, $cardType_id, $expMonth, $expYear, $firstName, $lastName, $usersid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    // function deleteUserPaymentCard1($conn, $usersid) {
    //     $sql = "DELETE FROM paymentcard1 WHERE users_id = ?;";
    //     $stmt = mysqli_stmt_init($conn);
    //     if(!mysqli_stmt_prepare($stmt, $sql)) {
    //         header("Location: editProfile.php?error=stmtfailed"); 
    //         exit();
    //     }

    //     mysqli_stmt_bind_param($stmt, "i", $usersid);
    //     mysqli_stmt_execute($stmt);
    //     mysqli_stmt_close($stmt);
        
    // }

    function userPaymentCard2Exists($conn, $email) {
        $usersid = getUsersID($conn, $email);
        $result;
        if($usersid == false) {
            header("Location: editProfile.php?error=idnotfound");
            exit();
        }
        else {

        $sql = "SELECT * FROM paymentcard2 WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $usersid);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            $result = true;
        }
        else {
            $result = false;
        }
        mysqli_stmt_close($stmt);
        }
         return $result;
    }

    function addUserPaymentCard2($conn, $usersid, $cardNum, $cardType_id, $expMonth, $expYear, $firstName, $lastName) {
        //encrypt payment card code here 
        $sql = "INSERT INTO paymentcard2 (cardNum, cardType_id, expMonth, expYear,
        firstName, lastName, users_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sissssi", $cardNum, $cardType_id, $expMonth, $expYear, $firstName, $lastName, $usersid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // function deleteUserPaymentCard2($conn, $usersid){
    //     $sql = "DELETE FROM paymentcard2 WHERE users_id = ?;";
    //     $stmt = mysqli_stmt_init($conn);
    //     if(!mysqli_stmt_prepare($stmt, $sql)) {
    //         header("Location: editProfile.php?error=stmtfailed"); 
    //         exit();
    //     }

    //     mysqli_stmt_bind_param($stmt, "i", $usersid);
    //     mysqli_stmt_execute($stmt);
    //     mysqli_stmt_close($stmt);  
    // }

    function userPaymentCard3Exists($conn, $email) {
        $usersid = getUsersID($conn, $email);
        $result;
        if($usersid == false) {
            header("Location: editProfile.php?error=idnotfound");
            exit();
        }
        else {

        $sql = "SELECT * FROM paymentcard3 WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $usersid);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            $result = true;
        }
        else {
            $result = false;
        }
        mysqli_stmt_close($stmt);
        }
         return $result;
    }
    
    function addUserPaymentCard3($conn, $usersid, $cardNum, $cardType_id, $expMonth, $expYear, $firstName, $lastName) {
        //encrypt payment card code here 
        $sql = "INSERT INTO paymentcard3 (cardNum, cardType_id, expMonth, expYear,
        firstName, lastName, users_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sissssi", $cardNum, $cardType_id, $expMonth, $expYear, $firstName, $lastName, $usersid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // function deleteUserPaymentCard3($conn, $usersid) {
    //     $sql = "DELETE FROM paymentcard3 WHERE users_id = ?;";
    //     $stmt = mysqli_stmt_init($conn);
    //     if(!mysqli_stmt_prepare($stmt, $sql)) {
    //         header("Location: editProfile.php?error=stmtfailed"); 
    //         exit();
    //     }

    //     mysqli_stmt_bind_param($stmt, "i", $usersid);
    //     mysqli_stmt_execute($stmt);
    //     mysqli_stmt_close($stmt);

    // }

    function getNumOfCardsData($conn, $email) {
        $sql = "SELECT * FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        $result;
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editprofile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            return $row;
        }
        else {
            $result = false;
        }
        mysqli_stmt_close($stmt);

    }

    function getCurrentNumOfCards($conn, $email) {
        $cardNum = getNumOfCardsData($conn, $email);
        return $cardNum["numOfCards"];
    }

    function updateNumCard($conn, $email, $num) {
        $sql = "UPDATE users SET  numOfCards= ? WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: resetPassword.php?error=stmtfailed"); 
            exit();
        }
        
        mysqli_stmt_bind_param($stmt, "is", $num, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    function updateUserPaymentCard1($conn, $usersid, $cardNum, $cardType_id, $expMonth, $expYear, $firstName, $lastName) {
        $sql = "UPDATE paymentcard1 SET cardNum = ?, cardType_id = ?, expMonth = ?, expYear = ?,
        firstName = ?, lastName = ? WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sissssi", $cardNum, $cardType_id, $expMonth, $expYear, $firstName, $lastName, $usersid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    function updateUserPaymentCard2($conn, $usersid, $cardNum, $cardType_id, $expMonth, $expYear, $firstName, $lastName) {
        $sql = "UPDATE paymentcard2 SET cardNum = ?, cardType_id = ?, expMonth = ?, expYear = ?,
        firstName = ?, lastName = ? WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sissssi", $cardNum, $cardType_id, $expMonth, $expYear, $firstName, $lastName, $usersid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    function updateUserPaymentCard3($conn, $usersid, $cardNum, $cardType_id, $expMonth, $expYear, $firstName, $lastName) {
        $sql = "UPDATE paymentcard3 SET cardNum = ?, cardType_id = ?, expMonth = ?, expYear = ?,
        firstName = ?, lastName = ? WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "sissssi", $cardNum, $cardType_id, $expMonth, $expYear, $firstName, $lastName,$usersid );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    // Delete
    function deleteUserPaymentCard1($conn, $usersid) {
        $sql = "UPDATE paymentcard1 SET cardNum = '', cardType_id = 1, expMonth = '', expYear = '',
        firstName = '', lastName = '' WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $usersid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    function deleteUserPaymentCard2($conn, $usersid) {
        $sql = "UPDATE paymentcard2 SET cardNum = '', cardType_id = 1, expMonth = '', expYear = '',
        firstName = '', lastName = '' WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $usersid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    function deleteUserPaymentCard3($conn, $usersid) {
        $sql = "UPDATE paymentcard3 SET cardNum = '', cardType_id = 1, expMonth = '', expYear = '',
        firstName = '', lastName = '' WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $usersid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }



