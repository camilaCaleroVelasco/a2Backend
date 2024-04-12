<?php

    // gets the user Id
    function getUsersID($conn, $email) {
        $sql = "SELECT * FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        $result;
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editprofile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            $result = $row["users_id"];
        }
        else {
            $result = false;
        }
        mysqli_stmt_close($stmt);
        return $result;
    }

    // Check if card 1 exists
    function userPaymentCard1Exists($conn, $email) {
        $usersid = getUsersID($conn, $email);
        $result;
        if($usersid == false) {
            header("Location: editProfile.php?error=idnotfound");
            exit();
        }
        else {

        $sql = "SELECT * FROM paymentcard1 WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $usersid);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            $result = true;
        }
        else {
            $result = false;
        }
        mysqli_stmt_close($stmt);
        }
        return $result;
    }

    // Add card 1
    function addUserPaymentCard1($conn, $usersid, $cardNum, $lastFour, $cardType_id, $expMonth, $expYear, $firstName, $lastName) {
        //encrypt payment card code here 
        $sql = "INSERT INTO paymentcard1 (cardNum, lastFour, cardType_id, expMonth, expYear,
        firstName, lastName, users_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "siissssi", $cardNum, $lastFour, $cardType_id, $expMonth, $expYear, $firstName, $lastName, $usersid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    //  Check if card 2 exists
    function userPaymentCard2Exists($conn, $email) {
        $usersid = getUsersID($conn, $email);
        $result;
        if($usersid == false) {
            header("Location: editProfile.php?error=idnotfound");
            exit();
        }
        else {

        $sql = "SELECT * FROM paymentcard2 WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $usersid);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            $result = true;
        }
        else {
            $result = false;
        }
        mysqli_stmt_close($stmt);
        }
         return $result;
    }

    // adds card 2
    function addUserPaymentCard2($conn, $usersid, $cardNum, $lastFour, $cardType_id, $expMonth, $expYear, $firstName, $lastName) {
        //encrypt payment card code here 
        $sql = "INSERT INTO paymentcard2 (cardNum, lastFour, cardType_id, expMonth, expYear,
        firstName, lastName, users_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "siissssi", $cardNum, $lastFour, $cardType_id, $expMonth, $expYear, $firstName, $lastName, $usersid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    //  Check if card 3 exists
    function userPaymentCard3Exists($conn, $email) {
        $usersid = getUsersID($conn, $email);
        $result;
        if($usersid == false) {
            header("Location: editProfile.php?error=idnotfound");
            exit();
        }
        else {

        $sql = "SELECT * FROM paymentcard3 WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $usersid);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            $result = true;
        }
        else {
            $result = false;
        }
        mysqli_stmt_close($stmt);
        }
         return $result;
    }

    // adds card 3
    function addUserPaymentCard3($conn, $usersid, $cardNum, $lastFour, $cardType_id, $expMonth, $expYear, $firstName, $lastName) {
        //encrypt payment card code here 
        $sql = "INSERT INTO paymentcard3 (cardNum, lastFour, cardType_id, expMonth, expYear,
        firstName, lastName, users_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "siissssi", $cardNum, $lastFour, $cardType_id, $expMonth, $expYear, $firstName, $lastName, $usersid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // gets the number of cards DB
    function getNumOfCardsData($conn, $email) {
        $sql = "SELECT * FROM users WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        $result;
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editprofile.php?error=stmtfailed"); 
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

    // gets Number of cards
    function getCurrentNumOfCards($conn, $email) {
        $cardNum = getNumOfCardsData($conn, $email);
        return $cardNum["numOfCards"];
    }

    //
    function updateNumCard($conn, $email, $num) {
        $sql = "UPDATE users SET  numOfCards= ? WHERE email = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: resetPassword.php?error=stmtfailed"); 
            exit();
        }
        
        mysqli_stmt_bind_param($stmt, "is", $num, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    //
    function updateUserPaymentCard1($conn, $usersid, $cardNum, $lastFour,  $cardType_id, $expMonth, $expYear, $firstName, $lastName) {
        $sql = "UPDATE paymentcard1 SET cardNum = ?, lastFour = ?, cardType_id = ?, expMonth = ?, expYear = ?,
        firstName = ?, lastName = ? WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "siissssi", $cardNum, $lastFour, $cardType_id, $expMonth, $expYear, $firstName, $lastName, $usersid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    //
    function updateUserPaymentCard2($conn, $usersid, $cardNum, $lastFour, $cardType_id, $expMonth, $expYear, $firstName, $lastName) {
        $sql = "UPDATE paymentcard2 SET cardNum = ?, lastFour = ?, cardType_id = ?, expMonth = ?, expYear = ?,
        firstName = ?, lastName = ? WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) { 
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "siissssi", $cardNum, $lastFour, $cardType_id, $expMonth, $expYear, $firstName, $lastName, $usersid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    //
    function updateUserPaymentCard3($conn, $usersid, $cardNum, $lastFour, $cardType_id, $expMonth, $expYear, $firstName, $lastName) {
        $sql = "UPDATE paymentcard3 SET cardNum = ?, lastFour = ?, cardType_id = ?, expMonth = ?, expYear = ?,
        firstName = ?, lastName = ? WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "siissssi", $cardNum, $lastFour, $cardType_id, $expMonth, $expYear, $firstName, $lastName,$usersid );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    // Delete functions
    //
    function deleteUserPaymentCard1($conn, $usersid) {
        $sql = "UPDATE paymentcard1 SET cardNum = '', lastFour ='0', cardType_id = null, expMonth = '', expYear = '',
        firstName = '', lastName = '' WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $usersid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    //
    function deleteUserPaymentCard2($conn, $usersid) {
        $sql = "UPDATE paymentcard2 SET cardNum = '', lastFour = '0', cardType_id = null, expMonth = '', expYear = '',
        firstName = '', lastName = '' WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $usersid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    //
    function deleteUserPaymentCard3($conn, $usersid) {
        $sql = "UPDATE paymentcard3 SET cardNum = '', lastFour ='0', cardType_id = null, expMonth = '', expYear = '',
        firstName = '', lastName = '' WHERE users_id = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: editProfile.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $usersid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }






