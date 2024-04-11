<?php
    require_once "functions/activateAccountFunctions.php";
    activationPin($conn);
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