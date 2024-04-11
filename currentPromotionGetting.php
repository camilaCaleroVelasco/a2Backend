<?php

    session_start();
    include_once 'includes/dbh.inc.php';

    // Function to check if it is an admin accessing page
    function currentPromotionsAccess() {
            
        if ((!isset($_SESSION["email"])) || (isset($_SESSION["email"]) && $_SESSION["userType_id"] !== 2)) {

            header("Location: restrictedAccess.php");
            exit();
        }
    }
    function displayCurrentPromos($conn) {
        $sqlCurrentPromos = "SELECT * FROM promotion";
        $resultCurrentPromo = mysqli_query($conn, $sqlCurrentPromos);
    
        // Check rows
        if (mysqli_num_rows($resultCurrentPromo) > 0) {
            // Loop over the rows to retrieve data
            while($rows = mysqli_fetch_assoc($resultCurrentPromo)) {
                echo "<h2>" . $rows["promoName"] . "</h2>";
                echo '<div class="promo">';
                echo '<div class="column">';
                echo "<p>Promotion Amount: " . $rows["percentDiscount"] . "</p>";
                echo "<p>Promotion Code: " . $rows["promoCode"] . "</p>";
                echo "<p>Promotion Start Month: " . $rows["startMonth"] . "</p>";
                echo '</div>'; // Close the first column
    
                echo '<div class="column">';
                echo "<p>Promotion Start Day: " . $rows["startDay"] . "</p>";
                echo "<p>Promotion End Month: " . $rows["endMonth"] . "</p>";
                echo "<p>Promotion End Day: " . $rows["endDay"] . "</p>";
                echo '</div>'; // Close the second column
    
                echo '</div>'; // Close the promo div
            }
        }
        else {
            echo "<h2> There are no promotions at the moment.</h2>";
        }
    }