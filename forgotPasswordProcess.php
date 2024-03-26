<?php
    if(isset($_POST["submit"])) {
        session_start();
        $email = $_POST["email-address"];
        $_SESSION["resetEmail"] = $email;

        require_once "includes/dbh.inc.php";
        require_once "includes/functions.inc.php";

        if(invalidEmail($email) !== false) {
            header("Location: forgotPassword.php?error=invalid");
            exit();
        }

        else if(userExists($conn, $email) == false) {
            header("Location: forgotPassword.php?error=missingaccount");
            exit();
        }

        else {
            //generates a unique PIN for the user
            generatePIN($conn, $email);

            header("Location: resetPasswordVerif.php?email=".$email);

        }
    }
    else {
        header("Location: forgotPassword.php?error=");
        exit();
    }




