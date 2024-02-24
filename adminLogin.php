<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA Compatible" content="IE=edge">
    <title>A2 MOVIES</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Enable to put style on page -->
     <link rel="stylesheet" href="css/login.css"> 
     <link rel="stylesheet" href="css/main.css"> 
 
</head>

<body>

    <header>
    <a href= "index.php">
        <img class="logo" src="images/A2 Movies Icon 2.png" alt="logo">
    </a>
    </header>



    <!-- Beginning Field for Login Info -->
    <div class ="wrapper">   <!--Div class for wrapper login starts here -->
        <form action=" "> <!-- will later specify url post-->
            <h1>Admin Login</h1>
            
            <!-- Input Box for filling out Email Address-->
             <div class="input-box" >
                <input type="text" placeholder=" Email Address" required>  
            </div>
            <!-- Input Box for filling out Password-->
            <div class=" input-box" >
                <input type= "password" placeholder=" Password" required>
            </div>  

            <!-- Button Box for log in-->
            <div class = "button-box">
                <button type = "submit" class ="button" onclick="admin.php"> Login </button>
                
            </div>
    
        </form>
    </div> <!--Div class for wrapper login ends  here -->

</body>
</html>


