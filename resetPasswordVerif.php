<?php 
session_start();
$email = $_SESSION["resetEmail"];
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
        <h1> Reset Password</h1> <!-- form class starts here -->
        <?php if (isset($_GET["error"])) {
                if ($_GET["error"] == "invalidpin") {
                    echo "<p>Incorrect PIN. Try again!</p>";
                }
            }
            else {
                echo "<p> Please check your email and enter the 4 digit code that was sent to reset your password.</p>";
            }
        ?>

        <form action = "resetPasswordVerifProcess.php?email=<?php.$email?>" method = "POST" autocomplete = "off">
            
            <div class="code-input">
                <input type="number" name= "opt1"  class= "field-opt"  placeholder = "0"  min = "0" max ="9" required onpaste = "false">
                <input type="number" name= "opt2"  class= "field-opt"  placeholder = "0"  min = "0" max ="9" required onpaste = "false">
                <input type="number" name= "opt3"  class= "field-opt"  placeholder = "0"  min = "0" max ="9" required onpaste = "false">
                <input type="number" name= "opt4"  class= "field-opt"  placeholder = "0"  min = "0" max ="9" required onpaste = "false">
            </div>

            <div class = "button-box">
                <button type = "submit" class ="button" name="submit"> Verify </button>
            </div>
        

        </form>  <!-- form class ends here -->
    
    </div>  <!-- div class wrapper ends here -->
    


</body>
</html>