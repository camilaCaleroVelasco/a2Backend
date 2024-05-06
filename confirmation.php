<?php
    session_start();
    if (isset($_SESSION['movieId']) && isset($_SESSION["email"]) && isset($_SESSION['showID'])) {

        $movie_id = $_SESSION['movieId'];
        $show_id = $_SESSION['showID'];
        require_once "includes/dbh.inc.php";
        include "functions/orderSummaryFunctions.php";
        include "functions/confirmationFunctions.php";

        // Retrieve movie information
        $sql = "SELECT * FROM movies WHERE movie_id = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: booking.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $movie_id);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $movie = mysqli_fetch_assoc($resultData);

        if (!$movie) {
            echo "<p>Movie not found.</p>";
        }

        // Retrieve show information
        $sql = "SELECT * FROM showing WHERE show_id = ?";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: booking.php?error=stmtfailed");
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $show_id);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);
        $show = mysqli_fetch_assoc($resultData);

        if (!$show) {
            echo "<p>Showing not found.</p>";
        }

        // set variables for confirmation page
        $bookingDate = $_SESSION['bookingDate'];
        $bookingTime = $_SESSION['bookingTime'];
        $bookingStatus_id = 1;
        $priceTotal = $_SESSION['totalPrice'];
        $numberOfSeats = $_SESSION['totalTickets'];
        $users_id = $_SESSION["users_id"];
        $booking_id = getBookingId($conn, $bookingDate, $bookingTime, $bookingStatus_id, $numberOfSeats, $users_id, $priceTotal);
        $adult = $_SESSION['adultTickets'];
        $child = $_SESSION['childTickets'];
        $senior = $_SESSION['seniorTickets'];
        $seats = $_SESSION['selectedSeats'];
        $paymentMethod = $_SESSION['selectedPaymentMethod'];
        
        updateBookingLastFour($conn, $paymentMethod, $booking_id);



        // Clear specific session variables
        unset($_SESSION['selectedSeats']);
        unset($_SESSION['movieId']);
        unset($_SESSION['totalTickets']);
        unset($_SESSION['showID']);
        unset($_SESSION['totalPrice']);
        unset($_SESSION['adultTickets']);
        unset($_SESSION['childTickets']);
        unset($_SESSION['seniorTickets']);
        unset($_SESSION['bookingDate']);
        unset($_SESSION['bookingTime']);
        unset($_SESSION['selectedPaymentMethod']);
    } else {
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Confirmation</title>
  <!-- Google Fonts and Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Round|Material+Icons+Sharp|Material+Icons+Two+Tone" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <!-- CSS -->
  <link rel="stylesheet" href="css/confirmation.css">
  
</head>
<body>
<header>
    <a href="index.php">
      <img class="logo" src="images/A2 movies Icon.jpeg" alt="logo">
    </a>
  </header>
  <div class="center">
    <div class="order-confirmation">
      <h2>Order Confirmed</h2>
      <p>Your order has been confirmed. Thank you for your purchase!</p>
      <!-- Order Details: -->
      <?php 
            // Ticket Info
            echo "<div class='ticket'>";
            echo "<p class='ticket-info'>" . $movie['movie_title'] . "</p>";
            echo "<p class='ticket-info'>Booking ID: " . $booking_id . "</p>";

            $bookingDate = new DateTime($bookingDate);
            $formattedBookingDate = $bookingDate->format('F j, Y'); // e.g., January 1, 2024

            echo "<p class='ticket-info'>Booking Date: " . $formattedBookingDate . "</p>";
            echo "<p class='ticket-info'>Booking Time: " . $bookingTime . "</p>";
            echo "</div>";

            // Format the date
            $date = new DateTime($show['showDate']);
            $formattedDate = $date->format('F j, Y'); // e.g., January 1, 2024

            echo "<div class='ticket'>";
            echo "<p class='ticket-info'>Date: " . $formattedDate . "</p>";
            echo "<p class='ticket-info'>Time: " . $show['showTime'] . "</p>";
            echo "</div>";

            echo "<div class='ticket'>";
            echo "<p class='ticket-info'>Selected Tickets: ";
            if ($adult > 0) {
                    echo "<p class='ticket-info'> Adult Ticket x". $adult ."</p>";
            }
            if ($child > 0) {
                    echo "<p class='ticket-info'> Child Ticket x". $child ."</p>";
            }
            if ($senior > 0) {
                    echo "<p class='ticket-info'> Senior Ticket x". $senior ."</p>";
            }
            echo "</div>";

            // Seat Display
            if (!empty($seats) && is_array($seats)) {
                // Remove 's' from each seat ID and store the result back in the array
                $cleanedSeats = array_map(function($seat) {
                    return substr($seat, 1); // Remove the first character
                }, $seats);
            
                echo "<div class='ticket'>";
                echo "<p class='ticket-info'>Selected Seats: ";
                echo htmlspecialchars(implode(', ', $cleanedSeats)); // Join array elements with a comma and a space
                echo "</p>";
                echo "</div>"; // Close the div
            }

            echo "<p class='ticket-info'> Payment Method: XXXX-XXXX-XXXX-". $paymentMethod ."</p>";

            

        ?>
        <div class="total">
            <p><strong>Final Total Price: $<span id="final-price"><?php echo number_format($priceTotal, 2); ?></span></strong></p>
        </div>
      <button onclick="goToHome()">Back to Home</button>
    </div>
  </div>

  <script>
    function goToHome() {
      window.location.href = "index.php";
    }
  </script>
</body>
</html>