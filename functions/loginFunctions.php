<?php
    //Check if username is in the database, if found then return data
    function userExistsLogin($conn, $email) {
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
    
    // Check for empty input at login
    function emptyInputLogin($email, $pwd) {
        $result;
        if (empty($email) || empty($pwd)) {
            $result = true;
        }
        else {
            $result = false;
        }
        return $result;
    }

    //Log user into website
    function loginUser($conn, $email, $pwd) {

        $emailExists = userExistsLogin($conn, $email);

        if($emailExists == false) {
            header("Location: login.php?error=incorrectlogin");
            exit();
        }

        $pwdHashed = $emailExists["password"];
        $checkpwd = password_verify($pwd, $pwdHashed);

        if ($checkpwd == false) {
            header("Location: login.php?error=incorrectlogin");
            exit();
        }
        else if ($checkpwd == true) {
            session_start();
            $_SESSION["email"] =  $emailExists["email"];
            $_SESSION["usertype_id"] =  $emailExists["usertype_id"];
            $_SESSION["userstatus_id"] =  $emailExists["userstatus_id"];
            $_SESSION["firstName"] =  $emailExists["firstName"];
            $_SESSION["users_id"] = $emailExists["users_id"];
            $_SESSION["lastName"] = $emailExists["lastName"];
            $_SESSION["phoneNumber"] = $emailExists["phoneNumber"];
            $_SESSION["numOfCards"] = $emailExists["numOfCards"];
            $_SESSION["promoSub_id"] = $emailExists["promoSub_id"];
            $_SESSION["billing_id"] = $emailExists["billing_id"];
            $_SESSION["delivery_id"] = $emailExists["delivery_id"];

                // if user attempting to login is a CUSTOMER and ACTIVE
                if($emailExists["usertype_id"] == 1 && $emailExists["userstatus_id"] == 1) {
                    header("Location: index.php");
                    exit();
                }

                //if user is a CUSTOMER and INACTIVE
                else if ($emailExists["usertype_id"] == 1 && $emailExists["userstatus_id"] == 2) {
                    
                    session_start();
                    session_unset();
                    session_destroy();

                    header("Location: login.php?error=inactive");
                    exit();
                }

                //if user is a CUSTOMER and SUSPENDED
                else if ($emailExists["usertype_id"] == 1 && $emailExists["userstatus_id"] == 3) {
                    
                    session_start();
                    session_unset();
                    session_destroy();

                    header("Location: login.php?error=suspended");
                    exit();
                }

                //if user is an ADMIN and ACTIVE
                else if ($emailExists["usertype_id"] == 2 && $emailExists["userstatus_id"] == 1) {
                    header("Location: admin.php");
                    exit();
                }

                 //if user is an ADMIN and INACTIVE 
                 else if ($emailExists["usertype_id"] == 2 && $emailExists["userstatus_id"] == 2) {
                    
                    session_start();
                    session_unset();
                    session_destroy();

                    header("Location: login.php?error=inactiveAdmin");
                    exit();
                 }
        } 
    }

    // Shows login error and success messages
    function errorCheck() {
        // Error messages
        if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyinput") {
                echo "<p>Fill in all fields!</p>";
            }
            else if ($_GET["error"] == "incorrectlogin") {
                echo "<p>Login is incorrect!</p>";
            }
            else if ($_GET["error"] == "inactive") {
                echo "<p>Please verify your account</p>";
            }
            else if ($_GET["error"] == "suspended") {
                echo "<p>Your account is suspended.</p>";
            }
            else if ($_GET["error"] == "inactiveAdmin") {
                echo "<p>Please contact an active Admin for assistance.</p>";
            }
            else if ($_GET["error"] == "stmtfailed") {
                echo "<p>FATIAL CONNECTION ERROR.</p>";
            }
            else if($_GET["error"] == "notLoggedIn") {
                echo "<p> To continue making selections, please login.";
            }
        }
        if (isset($_GET["success"])) {
            if ($_GET["success"] == "pwdupdate") {
                session_unset();
                echo "<p>Your password has been updated successfully. Please login.</p>";
            }
        }
    }
