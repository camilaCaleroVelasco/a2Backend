<?php
    //Check if username is in the database, is fo then return data
    function userExists($conn, $email) {
        $sql = "SELECT * FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup.php?error=stmtfailed"); // MIGHT CHANGE
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

        $emailExists = userExists($conn, $email);

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
            $_SESSION["userType_id"] =  $emailExists["userType_id"];
            $_SESSION["userStatus_id"] =  $emailExists["userStatus_id"];
            $_SESSION["firstName"] =  $emailExists["firstName"];

                // if user attempting to login is a CUSTOMER and ACTIVE
                if($emailExists["userType_id"] == 1 && $emailExists["userStatus_id"] == 1) {
                    header("Location: index.php");
                    exit();
                }

                //if user is a CUSTOMER and INACTIVE
                else if ($emailExists["userType_id"] == 1 && $emailExists["userStatus_id"] == 2) {
                    
                    session_start();
                    session_unset();
                    session_destroy();

                    header("Location: login.php?error=inactive");
                    exit();
                }

                //if user is a CUSTOMER and SUSPENDED
                else if ($emailExists["userType_id"] == 1 && $emailExists["userStatus_id"] == 3) {
                    
                    
                    session_start();
                    session_unset();
                    session_destroy();

                    header("Location: login.php?error=suspended");
                    exit();
                }

                //if user is an ADMIN and ACTIVE
                else if ($emailExists["userType_id"] == 2 && $emailExists["userStatus_id"] == 1) {
                    header("Location: admin.php");
                    exit();
                }

                 //if user is an ADMIN and INACTIVE 
                 else if ($emailExists["userType_id"] == 2 && $emailExists["userStatus_id"] == 2) {
                    
                    session_start();
                    session_unset();
                    session_destroy();

                    header("Location: login.php?error=inactiveAdmin");
                    exit();
                 }
        } 
    }