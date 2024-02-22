<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA Compatible" content="IE=edge">
    <title>A2 MOVIES</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Enable to put style on page --> 
    <link rel="stylesheet" href="css/main.css"> 
    <link rel="stylesheet" href="css/editProfile.css">   
    
</head>

<body>

    <header>
    <a href= "index.php">
        <img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo">
    </a>
    </header>
    

    <!-- Beginning Field for tabs in edit Profile section-->
    <div class ="editProfiletabs">
        <input type= "radio" id ="change-password-tab" name="editProfiletabs" checked="checked">
        <label for="change-password-tab">Change Password</label>
        <div class="tab">

            

            <!-- Beginning Field for change password Info -->

             <div class ="wrapper">   <!--Div class for wrapper change password starts here -->
                <form action=" "> <!-- will later specify url post-->
                    <h1>Edit Password</h1>
                    
                    <!-- Input Box for filling out Old Passowrd-->
                    <div class="input-box" >
                        <input type="password" placeholder=" Old Password" required>  
                    </div>
                    <!-- Input Box for filling out  New Password-->
                    <div class=" input-box" >
                        <input type= "password" placeholder=" New Password" required>
                    </div>
                    <!-- Button Box for change-->
                    <div class = "button-box">
                        <button type = "submit" class ="button"> Change Password</button>
                    </div>
                </form>
            </div> <!--Div class for wrapper change password ends  here -->
        </div>
        
        <input type= "radio" id="change-payment-tab" name="editProfiletabs">
        <label for="change-payment-tab">Change Payment</label>
        <div class="tab">

            <!-- Beginning Field for change payment Info -->
           
            <div class ="wrapper-2">   <!--Div class for wrapper  payement info starts here -->
                
                <form action=" ">
                <h2> Edit Payment</h2>
                
                <!-- Input Box for filling out First Name -->
                <div class="input-box" >
                    <input type="text" placeholder="First Name" required>
                </div>
                
                <!-- Input Box for filling out Last name-->
                <div class=" input-box" >
                    <input type= "text" placeholder="Last Name" required>
                </div> 
            
                  
                <!-- Input Box for filling out Card Number-->
                <div class="input-box" >
                    <input type="text" placeholder="Card Number" required>  
                </div>
                
                <!-- Input Box for filling expiration Month/Year of card-->
                <div class=" input-box" >
                    <input type= "date" placeholder="MM/YY" required>
                </div> 
                
                 <!-- Input Box for filling out CVC number-->
                 <div class=" input-box" >
                    <input type= "text" placeholder=" CVC" required>
                </div>
                <!-- Button Box for log in-->
                <div class = "button-box">
                    <button type = "submit" class ="button"> Edit Payment </button>
                </div>
            </form>
        
        </div> <!--Div class for wrapper payment info ends  here -->


           
        

    </div>
    </div>







</body>
</html>
