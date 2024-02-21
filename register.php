<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA Compatible" content="IE=edge">
    <title>A2 MOVIES</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Enable back on to put style -->
     <link rel="stylesheet" href="css/main.css"> 
     <link rel="stylesheet" href="css/register.css"> 

</head>

<body>
    <header>
        <a href= "index.php">
            <img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo">  <!--clicking a2 movies icon will link back to homepage-->
        </a> 
    </header>




    <!-- Beginning Field for Register Info -->
    <div class ="wrapper">   <!--Div class for wrapper login starts here -->
        <form action="registrationconfirmation.php">  <!--link to confirmation page when formed is filled out -->
            <h2>Register</h2>


            <!-- Input Box for filling out Email Address-->
            <div class="input-box" >              
                <input type="text" placeholder="First Name" required>  
            </div>
            <!-- Input Box for filling out Password-->
            <div class=" input-box" >
                <input type= "text" placeholder=" Last Name" required>
            </div> 
            
            <!-- Input Box for filling out Email Address-->
             <div class="input-box" >
                <input type="text" placeholder=" Email Address" required>  
            </div>
            <!-- Input Box for filling out Password-->
            <div class=" input-box" >  
                <input type= "password" placeholder=" Password" required>
            </div> 
            
             <!-- Input Box for filling out confirm password-->
            <div class=" input-box" >
                <input type= "password" placeholder=" Confirm Password" required>
            </div>  
            
            <!-- Button Box for log in-->
            <div class = "button-box">
                 <button type = "submit" class ="button"> Register </button>
            </div>

        </form>
    </div> <!--Div class for wrapper login ends  here -->

</body>
</html>