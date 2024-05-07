<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    session_start();
    include "includes/dbh.inc.php";
    include "functions/orderHistoryFunctions.php";

    $orderHistory = getHistory($conn, $_SESSION['users_id']);
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

   
    <div class="wrapper"> <!-- div class wrapper starts here -->
        <h1> Order History </h1>

        <div class ="order-history-container">

        <div class="order-history-content">
            <?php 
            foreach($orderHistory as $order){
                echo "<p>" . $order['movie_title'] . "</p>";
                echo "<p> Date: " . $order['showDate'] . "</p>";
                echo "<p> Time: " . $order['showTime'] . "</p>";
                echo "<p> Number of Tickets: " . $order['numberOfSeats'] . "</p>";
                $seatInfoStr = "";
                foreach ($order['seatInfo'] as $seat) {
                    $seatInfoStr .= $seat['seatRow'] . $seat['seatColumn'] . ", ";
                }
                $seatInfoStr = rtrim($seatInfoStr, ", ");
                echo "<p> Selected Seats: " . $seatInfoStr . "</p>";
                echo "<p> Payment Method: XXXX-XXXX-" . $order['lastFour'] . "</p>";
                echo "<p> Total: $" . $order['priceTotal'] . "</p>";


                echo "<br>";
            }
            ?>


        
        </div> <!-- div class wrapper ends here -->
        </div>




</body>

</html>