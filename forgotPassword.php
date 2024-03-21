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
     <link href='https://unpkg.com/boxicons@2.1.4/dist/boxicons.js' rel='stylesheet'>
     
</head>
<body>

<header>
    <a href= "index.php">
        <img class="logo" src="images/A2 movies Icon.jpeg" alt="logo">
    </a>
    </header>






    <div class ="wrapper">   <!--Div class for wrapper login starts here -->
        <form action=" "> <!-- will later specify url post-->
            <h1>Forgot Password</h1>
            <p style = "text-align: center;">  Enter Email Address Associated with account.</p>
            
            <!-- Input Box for filling out Email Address-->
             <div class="input-box" >
                <input type="text" placeholder=" Email Address" name= "email-address" required>

                <!-- mail icon from fontawesome -->
                <svg id = "mail-icon" class = "mailicon" xmlns="http://www.w3.org/2000/svg" width ="30" height ="20" fill="#FFFFFF" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                <path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48H48zM0 176V384c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V176L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>
                
            </div>

            <div class = "button-box">
                <button type = "submit" class ="button" id="submit"> Submit </button>
            </div>
          
            
        </form>
    </div>


</body>
</html>
