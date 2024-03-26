<?php
    session_start();
    require_once "includes/functions.inc.php";
    require_once "includes/dbh.inc.php";
    $email = $_SESSION["resetEmail"];
    if(isset($_POST["submit"])) {
        $oldPWD = $_POST["old-password"];
        $newPWD = $_POST["new-password"];
        $confirmPWD = $_POST["confirm-new-password"];

    if (empty($oldPWD) || empty($newPWD)|| empty($confirmPWD)) {
        header("Location: resetPassword.php?error=emptyinput");
    }    
    else if (strlen($newPWD) <= 7) {
        header("Location: resetPassword.php?error=pwdlength");
    }
    else if ( ! preg_match("/[a-z]/i", $newPWD)) {
        header("Location: resetPassword.php?error=pwdChar");
    }
    else if ( ! preg_match("/[0-9]/", $newPWD)) {
        header("Location: resetPassword.php?error=pwdNum");
    }
    else if ($newPWD !== $confirmPWD) {
        header("Location: resetPassword.php?error=pwdMismatch");
    }
    else {
        changePassword($conn, $email, $oldPWD, $newPWD);
        header("Location: login.php?success=pwdupdate");
    }
    
    }