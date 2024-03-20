<?php

    if (empty($_POST["first-name"])) {
        die("First Name is required");
    }

    if (empty($_POST["last-name"])) {
        die("Last Name is required");
    }
    
    if ( ! filter_var($_POST["email-address"], FILTER_VALIDATE_EMAIL)) {
        die("Valid email is required");
    }
    
    if (empty($_POST["phone-number"])) {
        die("Phone Number is required");
    }

    if (strlen($_POST["password"]) <= 7) {
        die("Password must be at least 8 characters");
    }
    
    if ( ! preg_match("/[a-z]/i", $_POST["password"])) {
        die("Password must contain at least one letter");
    }
    
    if ( ! preg_match("/[0-9]/", $_POST["password"])) {
        die("Password must contain at least one number");
    }
    
    # check that password and confirmation password
    if ($_POST["password"] !== $_POST["confirm-password"]) {
        die("Confirmation password must match password");
    }
    
    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
    
    $mysqli = require __DIR__ . "includes/databaseConnection.inc.php";
    
    $sql = "INSERT INTO Users (firstName, lastName, email, password, promotion)
            VALUES (?, ?, ?, ?, ?)";
            
    $stmt = $mysqli->stmt_init();
    
    if ( ! $stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }
    
    $stmt->bind_param("ssss",
                      $_POST["first-name"],
                      $_POST["last-name"],
                      $_POST["email"],
                      $password_hash);
                      
    if ($stmt->execute()) {
    
        header("Location: registrationconfirmation.php");
        exit;
        
    } else {
        
        if ($mysqli->errno === 1062) {
            die("email already exists");
        } else {
            die($mysqli->error . " " . $mysqli->errno);
        }
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
        
        <div class=" wrapper">
            <h1> Registration was Successful!</h1>
            <p> Please check your email and click the link to verify your account.</p>  
            <img class="logo-check" src="images/checkIcon.jpeg" alt="logo-check">  
        </div>
    


</body>
</html>