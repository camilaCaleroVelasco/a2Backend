<?php
    if(isset($_POST["submit"])) {

        $email = $_POST["email-address"];
        $pwd = $_POST["password"];

        require_once "includes/dbh.inc.php";
        require_once "includes/functions.inc.php";

        if(emptyInputLogin($email, $pwd) !== false) {
            header("Location: login.php?error=emptyinput");
            exit();
        }

        loginUser($conn,$email, $pwd);
    }
    else {
        header("Location: login.php");
        exit();
    }