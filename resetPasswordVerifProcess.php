<?php
    session_start();
    require_once "functions/forgotPasswordFunctions.php";
    require_once "includes/dbh.inc.php";
        if(isset($_POST["submit"])) {

            $pin1 = $_POST["opt1"];
            $pin2 = $_POST["opt2"];
            $pin3 = $_POST["opt3"];
            $pin4 = $_POST["opt4"];
            $email = $_SESSION["resetEmail"];

            if (correctPIN($conn, $email, $pin1, $pin2, $pin3, $pin4)) {
                header("Location: resetPassword.php?email=".$email);
            }
            else {
                header("Location: resetPasswordVerif.php?error=invalidpin");
            }
        }
        else {
            header("Location: resetPasswordVerif.php");
            exit();
        }