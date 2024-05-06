<?php

function errorCheck() {
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "pwdmismatch") {
            echo "<h2>Confirmation password must match password.</h2>";
        } else if ($_GET["error"] == "emailexists") {
            echo "<h2>Error: Email already exists.</h2>";
        } else if ($_GET["error"] == "firstname") {
            echo "<h2>First Name is required.</h2>";
        } else if ($_GET["error"] == "lastname") {
            echo "<h2>Last Name is required.</h2>";
        } else if ($_GET["error"] == "invalidemail") {
            echo "<h2>Valid email is required.</h2>";
        } else if ($_GET["error"] == "phonenumber") {
            echo "<h2>Phone number is required.</h2>";
        } else if ($_GET["error"] == "pwdlength") {
            echo "<h2>Password must be at least 8 characters.</h2>";
        } else if ($_GET["error"] == "pwdchar") {
            echo "<h2>Password must contain at least one letter.</h2>";
        } else if ($_GET["error"] == "pwdnum") {
            echo "<h2>Password must contain at least one number</h2>";
        } else if ($_GET["error"] == "cardlength1") {
            echo "<h2>Card 1 must be 12 digits.</h2>";
        } else if ($_GET["error"] == "cardexp1") {
            echo "<h2>Card 1 is expired.</h2>";
        } else if ($_GET["error"] == "expyear1") {
            echo "<h2>Card 1 year is not valid.</h2>";
        } else if ($_GET["error"] == "expmonth1") {
            echo "<h2>Card 1 month is not valid.</h2>";
        } else if ($_GET["error"] == "cardlength2") {
            echo "<h2>Card 2 must be 12 digits.</h2>";
        } else if ($_GET["error"] == "cardexp2") {
            echo "<h2>Card 2 is expired.</h2>";
        } else if ($_GET["error"] == "expyear2") {
            echo "<h2>Card 2 year is not valid.</h2>";
        } else if ($_GET["error"] == "expmonth2") {
            echo "<h2>Card 2 month is not valid.</h2>";
        } else if ($_GET["error"] == "cardlength3") {
            echo "<h2>Card 3 must be 12 digits.</h2>";
        } else if ($_GET["error"] == "cardexp3") {
            echo "<h2>Card 3 is expired.</h2>";
        } else if ($_GET["error"] == "expyear3") {
            echo "<h2>Card 3 year is not valid.</h2>";
        } else if ($_GET["error"] == "expmonth3") {
            echo "<h2>Card 3 month is not valid.</h2>";
        }
    }
}