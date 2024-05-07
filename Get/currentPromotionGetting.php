<?php

    session_start();
    include_once 'includes/dbh.inc.php';
    require_once "functions/checkIfAdminFunction.php"; 
    
    // Checks if user is admin
    checkIfAdmin();

    function displayCurrentPromos($conn) {
        $sqlCurrentPromos = "SELECT * FROM Promotion";
        $resultCurrentPromo = mysqli_query($conn, $sqlCurrentPromos);
    
        //Check rows
        if (mysqli_num_rows($resultCurrentPromo) > 0) {
            // Loop over the rows to retrieve data
            while($rows = mysqli_fetch_assoc($resultCurrentPromo)) {
                echo "<h2>" . $rows["promoName"] . "</h2>";
                echo '<div class="promo">';
                echo "<p>"  . $rows["promoCode"] . "</p>";
                echo "<p>". $rows["percentDiscount"] . "%" ."</p>";
                echo "<p>" . $rows["startMonth"] . "/" . $rows["startDay"] . " - " . $rows["endMonth"] . "/" . $rows["endDay"] . "</p>";
                echo '</div>'; // Close the promo div
                
            
      
            }
         
        }
        else {
            echo "<h2> There are no promotions at the moment.</h2>";
        }
    }