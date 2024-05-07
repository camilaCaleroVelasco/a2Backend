<?php
  
    //Pull user data with matching email
    function pullCurrentPassword($conn, $email) {
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

    function changePassword($conn, $email, $oldPWD, $newPWD) {

        $emailExists = pullCurrentPassword($conn, $email);

        $pwdHashed = $emailExists["password"];
        $checkpwd = password_verify($oldPWD, $pwdHashed);

        if ($checkpwd == false) {
            header("Location: "); // NEEDS TO BE FILLED OUT
            exit();
        }
        else if ($checkpwd == true) {
            updatePWD($conn, $email, $newPWD);
        }
    }

    function updatePWD($conn, $email, $pwd) {
        $sql = "UPDATE users SET password = ? WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); // needs account activation error link
            exit();
        }

        $password_hash = password_hash($pwd, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "ss", $password_hash, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

    }
