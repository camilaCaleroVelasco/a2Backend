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
        }
    }
}