

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA Compatible" content="IE=edge">
    <title>A2 MOVIES</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  

    <link rel="stylesheet" href="css/login.css">
    
    <link rel="stylesheet" href="css/registrationconfirmation.css">
 
   
    
   
</head>

<body>
    <header>
        <a href= "index.php">
            <img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo">
        </a> 
    </header>
    
    <div class="wrapper">  <!-- div class wrapper starts here -->
        <h1> Verify Account Now!</h1> <!-- form class starts here -->
        <p>  Registration was successful! Please check your email to verify your account.</p>
        <form action = "activateAccount.php?email=<?php $email ?>" method="post"  autocomplete = "off"> 
            
            <div class="code-input">
                <input type="number" name= "opt1"  class= "field-opt"  placeholder = "0"  min = "0" max ="9" required onpaste = "false">
                <input type="number" name= "opt2"  class= "field-opt"  placeholder = "0"  min = "0" max ="9" required onpaste = "false">
                <input type="number" name= "opt3"  class= "field-opt"  placeholder = "0"  min = "0" max ="9" required onpaste = "false">
                <input type="number" name= "opt4"  class= "field-opt"  placeholder = "0"  min = "0" max ="9" required onpaste = "false">
            </div>

            <div class = "button-box">
                <button name="submit" type = "submit" class ="button" id="submit"> Verify </button>
            </div>
        

        </form>  
    
    </div>  <!-- div class wrapper ends here -->
    


</body>
</html>