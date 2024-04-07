<?php
    if (!isset($_SESSION["email"]) || (isset($_SESSION["email"]) && $_SESSION["userType_id"] != 2)) {

        header("Location: restrictedAccess.php");
        exit();
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
    <link rel="stylesheet" href="css/promotions.css">

</head>

<body>

<header>
    <a href= "index.php">
        <img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo">  <!--clicking a2 movies icon will link back to homepage-->
    </a>
</header>

<div class ="tabs">   <!-- div class tabs starts here-->
    <div class="tabs-sidebar">
        <button class= "tabs-button tabs-button-active" tab-info = "1" > View Promotions </button>
        <button class= "tabs-button " tab-info = "2" > Add Promotions </button>
        <button class= "tabs-button " tab-info = "3" > Edit Promotions </button>
    </div>
    
    <div class = "tabs-content tabs-content-active" tab-info-data = "1" >
        <h1> View Promotions</h1>
        <div id ="view-promotions" class ="view-promotions-container">
            <!-- Promotions will appear with a delete button-->
        </div>
    </div>
    
    <div class = "tabs-content" tab-info-data = "2" >
        <h1> Add Promotions</h1>
        <form id = "promotion-form">
            <div class = "form-input">
                <label for="movie">Movie:</label>
                <input type="text" id="movie" name="movie" placeholder="Enter movie title">
            </div>
            
            <div class ="form-input">
                <label for="discount-name">Content:</label>
                <input type="text" id="discount-name" name="discount-name" placeholder="Enter Promotions name">
            </div>
            
            <div class = "form-input"> 
                <label for="discount-amount">Amount:</label>
                <input type="text" id="discount-amount" name="discount-amount" placeholder="Enter Promotions amount">
            </div>
            <button type="submit" class = "add-promotion-button">Add Promotion</button>
        </form>
    
    </div>


    <div class = "tabs-content" tab-info-data = "3" >
        <h1> Edit Promotions</h1>
        <div id ="edit-promotions-content" class = "edit-promotions-container">
            <!-- Promotions will appear with a delete button-->
        </div>
    </div>
</div>  <!-- div class tabs end here-->

<script src="javascript/promotions.js"></script>


</body>
</html>