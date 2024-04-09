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
                echo "<br></br>";
                echo "<p> Promotion Amount: " . $rows["percentDiscount"] . "</p>";
                echo "<br></br>";
                echo "<p> Promotion Code: " . $rows["promoCode"] . "</p>";
                echo "<br></br>";
                echo "<p> Promotion Start Month: " . $rows["startMonth"] . "</p>";
                echo "<br></br>";
                echo "<p> Promotion Start Day: " . $rows["startDay"] . "</p>";
                echo "<br></br>";
                echo "<p> Promotion End Month: " . $rows["endMonth"] . "</p>";
                echo "<br></br>";
                echo "<p> Promotion End Day: " . $rows["endDay"] . "</p>";

            }
        }
        else{
            echo "There are no promotions at the moment.";
        }
    }