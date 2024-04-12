<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();
    require_once "includes/dbh.inc.php";


    /**
     * Check for valid email input.
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
     */
    function userExists($conn, $email) {
        $sql = "SELECT * FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        $result;
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: register.php?error=stmtfailed"); 
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
     */
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

    /**
     * Ensures user's PIN is unique within the DB
     */
    function notUniquePIN($conn, $pin1, $pin2, $pin3, $pin4) {
        $sql = "SELECT pwdResetPin1, pwdResetPin2, pwdResetPin3, pwdResetPin4 FROM users WHERE pwdResetPin1 = ? AND pwdResetPin2 = ? AND pwdResetPin3 = ? AND pwdResetPin4 = ?;";
        $stmt = mysqli_stmt_init($conn);
        $result;
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: register.php?error=stmtfailed"); 
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
     */
    function updatePIN($conn, $email, $pin1, $pin2, $pin3, $pin4) {
        $sql = "UPDATE users SET pwdResetPin1 = ?, pwdResetPin2 = ?, pwdResetPin3 = ?, pwdResetPin4 = ? WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: register.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "iiiis", $pin1, $pin2, $pin3, $pin4, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    }

    /**
     * Send pin to email to activate account
     */
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

    /**
     * Verifies that the entered PIN is correct. Returns true if correct, false otherwise.
     */
    function correctPIN($conn, $email, $pin1, $pin2, $pin3, $pin4) {

        $sql = "SELECT pwdResetPin1, pwdResetPin2, pwdResetPin3, pwdResetPin4 FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        $result;

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: registrationconfirmation.php?error=stmtfailed");
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
     * 
     */
    function activationPin($conn) {
    
        if(isset($_POST["submit"])) {

            // pin and email values
            $pin1 = $_POST["opt1"];
            $pin2 = $_POST["opt2"];
            $pin3 = $_POST["opt3"];
            $pin4 = $_POST["opt4"];
            $email = $_SESSION["resetEmail"];

            // if the email and pin are valid then update userstatus to active
            if (correctPIN($conn, $email, $pin1, $pin2, $pin3, $pin4)) {
                updatePIN($conn, $email, NULL, NULL, NULL, NULL);
                $userStatus_id = 1;
                $sqlUpdateStatus = "UPDATE Users SET userStatus_id = ? WHERE email = ?";
                $stmtUpdateStatus = mysqli_prepare($conn, $sqlUpdateStatus);
                mysqli_stmt_bind_param($stmtUpdateStatus, "is", $userStatus_id, $email);
                if (!mysqli_stmt_execute($stmtUpdateStatus)) {
                    // If not valid
                    header("Location: registrationconfirmation.php?error=updateerror");
                    exit();
                
                // } else {
                //     // If valid direct to login
                //     header("Location: login.php?email=".$email);
                //     exit();
        }
            }
            // Invalid Pin
            else {
                header("Location: registrationconfirmation.php?error=invalidpin");
            }
        }
        else {
            header("Location: registrationconfirmation.php");
            exit();
        }
        
    }

    // Shows login error and success messages
    function errorCheck() {
        // Error messages
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "updateerror") {
                echo "<p>Error: DB CONNECTION ERROR</p>";
            }
            else if ($_GET["error"] == "invalidpin") {
                echo "<p>Incorrect PIN!</p>";
            }
        }
        else {
            echo "<p>  Registration was successful! Please check your email to verify your account.</p>";
        }
    }