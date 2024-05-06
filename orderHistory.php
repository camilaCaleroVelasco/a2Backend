<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();
    include "includes/dbh.inc.php";
    include "functions/orderHistoryFunctions.php";

    $orderHistory = getHistory($conn);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA Compatible" content="IE=edge">
    <title>A2 MOVIES</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Enable back on to put style -->


    <link rel="stylesheet" href="css/register.css">
    <link rel="stylesheet" href="css/currentPromotions.css">

    <link rel="stylesheet" href="css/orderHistory.css">
  
   


</head>

<body>
    <header>
        <a href="index.php">
            <img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo">
            <!--clicking a2 movies icon will link back to homepage-->
        </a>
    </header>

    <!-- Beginning Field for Register Info -->
    <div class="wrapper"> <!-- div class wrapper starts here -->
        <h1> Order History </h1>

        <div class="order-history-content">
            <?php 
            foreach($orderHistory as $order){
                echo "<h2> Movie Name: " . $order['movie_title'] . "</h2>";
                echo "<h2> Date: " . $order['showDate'] . "</h2>";
                echo "<h2> Date: " . $order['showTime'] . "</h2>";
                echo "<h2> Number of Tickets: " . $order['numberOfSeats'] . "</h2>";
                $seatInfoStr = "";
                foreach ($order['seatInfo'] as $seat) {
                    $seatInfoStr .= $seat['seatRow'] . $seat['seatColumn'] . ", ";
                }
                $seatInfoStr = rtrim($seatInfoStr, ", ");
                echo "<h2> Selected Seats: " . $seatInfoStr . "</h2>";
                echo "<h2> Payment Method: XXXX-XXXX-" . $order['lastFour'] . "</h2>";
                echo "<h2> SubTotal: $" . $order['priceTotal'] . "</h2>";


                echo "<br>";
            }
            ?>


        
        </div> <!-- div class wrapper ends here -->


</body>

</html>