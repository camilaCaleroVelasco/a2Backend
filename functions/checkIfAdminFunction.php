<?php

// session_start();

function checkIfAdmin() {
            
    if ((!isset($_SESSION["email"])) || (isset($_SESSION["email"]) && $_SESSION["usertype_id"] !== 2)) {

        header("Location: restrictedAccess.php");
        exit();
    }
}