<?php
/**
 * Check for valid email input.
 * Used in: forgotPasswordProcess.php
 */ 
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

    /**
     * Checks if email exists in the DB
     * Used in: forgotPasswordProcess.php
     */
    function userExists($conn, $email) {
        $sql = "SELECT * FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        $result;
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: forgotPassword.php?error=stmtfailed"); 
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

    /**
     * Generate and update the user's pin in the database.
     * Used in: forgotPasswordProcess.php
     */
    function generatePIN($conn, $email) {
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

        sendPINEmail($email, $pin1, $pin2, $pin3, $pin4);

    }

    /**
     * Ensures user's PIN is unique within the DB
     * Used in: generatePIN($conn, $email)
     * This is a supplimentary function to generatePIN
     */
    function notUniquePIN($conn, $pin1, $pin2, $pin3, $pin4) {
        $sql = "SELECT pwdResetPin1, pwdResetPin2, pwdResetPin3, pwdResetPin4 FROM users WHERE pwdResetPin1 = ? AND pwdResetPin2 = ? AND pwdResetPin3 = ? AND pwdResetPin4 = ?;";
        $stmt = mysqli_stmt_init($conn);
        $result;
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: forgotPassword.php?error=stmtfailed"); 
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

     /**
     * Updates the user's generated PIN in the DB
     * Used in: resetPasswordProcess.php ; generatePIN($conn, $email)
     * This is also a supplimentary function to generatePIN
     */
    function updatePIN($conn, $email, $pin1, $pin2, $pin3, $pin4) {
        $sql = "UPDATE users SET pwdResetPin1 = ?, pwdResetPin2 = ?, pwdResetPin3 = ?, pwdResetPin4 = ? WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: resetPasswordVerif.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "iiiis", $pin1, $pin2, $pin3, $pin4, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    }

    /**
     * Sends pin to user's email to assist with verification when updating password
     * Used in: generatePIN($conn, $email)
     * This is a supplimentary function to generatePIN
     */
    function sendPINEmail($email, $pin1, $pin2, $pin3, $pin4) {
        $mail = require "mailer.php";
        $mail->setFrom("noreply@example.com");
        $mail->addAddress($email);
        $mail->Subject = "Password Reset PIN";
        $mail->Body = <<<END
        To update your password, please type in the following PIN:
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

    /**
     * Verifies that the entered PIN is correct. Returns true if correct, false otherwise.
     * Used in: resetPasswordVerifProcess.php 
     */
    function correctPIN($conn, $email, $pin1, $pin2, $pin3, $pin4) {

        $sql = "SELECT pwdResetPin1, pwdResetPin2, pwdResetPin3, pwdResetPin4 FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        $result;

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: resetPasswordVerif.php?error=stmtfailed");
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

    /**
     * Updates the user's password within the DB.
     * Used in: resetPasswordProcess.php
     */
    function updatePWD($conn, $email, $pwd) {
        $sql = "UPDATE users SET password = ? WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: resetPassword.php?error=stmtfailed"); 
            exit();
        }

        $password_hash = password_hash($pwd, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "ss", $password_hash, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    }