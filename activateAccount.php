<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    $token = $_GET["token"];

    $token_hash = hash("sha256", $token);

    // DB connection
    require_once 'includes/dbh.inc.php';

    // Retrieve account_activation_hash
    $sql = "SELECT * FROM Users
            WHERE account_activation_hash = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $token_hash);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    if ($user === false) {
        die("Token not found");
    }

    // Change UserStatus To Active
    // Retrieve userStatus_id for 'Active' status
    $userStatus = 'Active';
    $sqlUserStatus = "SELECT userStatus_id FROM UserStatus WHERE status = ?";
    $stmtStatus = mysqli_prepare($conn, $sqlUserStatus);
    mysqli_stmt_bind_param($stmtStatus, "s", $userStatus);
    mysqli_stmt_execute($stmtStatus);
    $resultStatus = mysqli_stmt_get_result($stmtStatus);
    $userStatusRow = mysqli_fetch_assoc($resultStatus);
    if (!$userStatusRow) { // maybe change?
        die("UserStatus not found for status: $userStatus");
    }
    $userStatus_id = $userStatusRow['userStatus_id'];

    // Update Users table to set account_activation_hash to NULL and userStatus_id to 'Active'
    $sqlUpdate = "UPDATE Users SET account_activation_hash = NULL, userStatus_id = ? WHERE users_id = ?";
    $stmtUpdate = mysqli_prepare($conn, $sqlUpdate);
    mysqli_stmt_bind_param($stmtUpdate, "ii", $userStatus_id, $user["users_id"]);

    // Execute the update query
    if (!mysqli_stmt_execute($stmtUpdate)) {
        die("Failed to activate account: " . mysqli_error($conn));
    }


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA Compatible" content="IE=edge">
    <title>A2 MOVIES</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/registrationconfirmation.css">
   
</head>

<body>
    <header>
        <a href= "index.php">
            <img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo">
        </a> 
    </header>
    
    <div class="wrapper">  <!-- div class wrapper starts here -->
        <h1>Account Activated</h1> <!-- form class starts here -->
        <p>Account activated successfully. You can now
       <a href="login.php">log in</a>.</p>
        
    </div>  <!-- div class wrapper ends here -->
    


</body>
</html>

