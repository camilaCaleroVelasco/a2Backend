<?php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["movie_id"])) {

    $movie_id = $_GET["movie_id"];

    try {
        require_once "includes/databaseConnection.inc.php";

        $query = "SELECT * FROM movies WHERE id = :movie_id"; // Corrected query

        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':movie_id', $movie_id, PDO::PARAM_INT); // Correct binding
        $stmt->execute();

        $movie = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch single movie

        if ($movie) { // Check if movie found
            // Display movie details
        } else {
            // Handle movie not found
            echo "<p>Movie not found.</p>";
        }

        $pdo = null;
        $stmt = null;

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php"); // Redirect if no movie ID
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Summary</title>
  <!-- Google Fonts and Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Round|Material+Icons+Sharp|Material+Icons+Two+Tone" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <!-- CSS -->
  <link rel="stylesheet" href="css/ordersummary.css">
</head>
<body>
  <div class="center">
    <div class="order-summary">
      <div class="head">
        <div class="title"><h3>Order Summary</h3></div>
      </div>
      <div class="ticket-details">
        <h2>Ticket Details</h2>
        <div class="ticket">
          <p class="ticket-info"><?php echo $movie['movie_title']; ?></p>
          <p class="ticket-info">Date: March 1, 2024</p>
          <p class="ticket-info">Time: 11:00 AM</p>
          <p class="ticket-info"> <span class="delete-ticket" onclick="deleteTicket(this)">X</span></p>
        </div>
        <div class="ticket">
          <p class="ticket-info"><?php echo $movie['movie_title']; ?></p>
          <p class="ticket-info">Date: March 1, 2024</p>
          <p class="ticket-info">Time: 11:00 AM</p>
          <p class="ticket-info"> <span class="delete-ticket" onclick="deleteTicket(this)">X</span></p>
        </div>
        <div class="total">
          <p><strong>Total Price: $</strong></p>
        </div>
      </div>
      <div class="options">
        <button class="update-order" onclick="goToBooking()">Update Order</button>
        <button class="confirm-order" onclick="goToCheckout()">Confirm & Continue to Checkout</button>
      </div>
    </div>
  </div>

  <script>
    function deleteTicket(element) {
      if (confirm("Are you sure you want to delete this ticket?")) {
        let ticket = element.parentElement.parentElement; // Get the parent ticket element
        ticket.remove();
        updateTotalPrice();
      }
    }

    function updateTotalPrice() {
      let totalPrice = 0;
      document.querySelectorAll('.ticket').forEach(ticket => {
        let priceString = ticket.querySelector('.ticket-info').innerText.split('-')[1].trim();
        totalPrice += parseFloat(priceString.substring(1));
      });
      document.querySelector('.total p strong').innerText = 'Total Price: $' + totalPrice.toFixed(2);
    }

    function goToBooking() {
    <?php
      echo "window.location.href = 'booking.php?movie_id=" . $movie["id"] . "'";
    ?>
    }

    function goToCheckout() {
      window.location.href = "checkout.php";
    }
  </script>
</body>
</html>

