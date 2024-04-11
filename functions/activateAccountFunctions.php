<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();
    require_once "functions/forgotPasswordFunctions.php";
    require_once "includes/dbh.inc.php";

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