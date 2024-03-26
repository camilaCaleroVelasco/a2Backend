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
        <form action= "resetPasswordProcess.php" method="POST">
            <h1>Reset Password</h1>
            <?php
                    // Error messages
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "emptyinput") {
                            echo "<p>Fill in all fields!</p>";
                        }
                        else if ($_GET["error"] == "pwdlength") {
                            echo "<p>New password must be at least 8 characters.</p>";
                        }
                        else if ($_GET["error"] == "pwdChar") {
                            echo "<p>New password must contain at least one letter.</p>";
                        }
                        else if ($_GET["error"] == "pwdNum") {
                            echo "<p>New password must contain at least one number.</p>";
                        }
                        else if ($_GET["error"] == "pwdMismatch") {
                            echo "<p>New password and confirmation password must match.</p>";
                        }
                        else if ($_GET["error"] == "incorrectPWD") {
                            echo "<p>Old password is incorrect.</p>";
                        }
                        
                    }
            ?>

                
          

              <!-- Input Box for filling out Password-->
              <div class=" input-box" >
                <input type= "password" placeholder=" New Password" name= "new-password"  required>
             
                <!-- lock icon from fontawesome -->
                <svg id = "lock-icon" class = "lockicon" xmlns="http://www.w3.org/2000/svg"width ="30" height ="20" fill="#FFFFFF" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                <path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
            </div>  

              

              <!-- Input Box for filling out Password-->
              <div class=" input-box" >
                <input type= "password" placeholder=" Confirm New Password" name= "confirm-new-password"  required>

                <!-- lock icon from fontawesome -->
                <svg id = "lock-icon" class = "lockicon" xmlns="http://www.w3.org/2000/svg"width ="30" height ="20" fill="#FFFFFF" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                <path d="M144 144v48H304V144c0-44.2-35.8-80-80-80s-80 35.8-80 80zM80 192V144C80 64.5 144.5 0 224 0s144 64.5 144 144v48h16c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V256c0-35.3 28.7-64 64-64H80z"/></svg>
            </div>  

            <!-- Button Box for log in-->
            <div class = "button-box">
                <button type = "submit" class ="button" name="submit"> Reset </button>
            </div>

            
                             

        </form>
    </div>


</body>
</html>