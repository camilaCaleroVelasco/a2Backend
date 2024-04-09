<?php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["movie_id"])) {

    $movie_id = $_GET["movie_id"];

    try {
        require_once "includes/databaseConnection.inc.php";

        $query = "SELECT * FROM movies WHERE movie_id = :movie_id"; // Corrected query

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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Select Ticket Type</title>
  <!-- Google Fonts and Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Round|Material+Icons+Sharp|Material+Icons+Two+Tone" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <!-- External CSS file -->
  <link rel="stylesheet" href="css/ageselect.css">
  
</head>
<body>
  <!-- Centered container -->
  <div class="center">
    <!-- Tickets container -->
    <div class="tickets">
      <!-- Title section -->
      <div class="head">
        <div class="title">Select Ticket Type</div>
      </div>
      <!-- Ticket types section -->
      <div class="ticket-types">
        <!-- Adult ticket type -->
        <div class="ticket-type">
          <div class="icon">
            <i class="material-icons">person</i>
          </div>
          <div class="type-details">
            <div class="type-name">Adult</div>
            <div class="price">$15.00</div>
          </div>
          <div class="quantity">
            <button class="quantity-btn minus">-</button>
            <span class="quantity-value">0</span>
            <button class="quantity-btn plus">+</button>
          </div>
        </div>
        <!-- Child ticket type -->
        <div class="ticket-type">
          <div class="icon">
            <i class="material-icons">child_care</i>
          </div>
          <div class="type-details">
            <div class="type-name">Child (Under 12)</div>
            <div class="price">$10.00</div>
          </div>
          <div class="quantity">
            <button class="quantity-btn minus">-</button>
            <span class="quantity-value">0</span>
            <button class="quantity-btn plus">+</button>
          </div>
        </div>
        <!-- Senior ticket type -->
<div class="ticket-type">
  <div class="icon">
    <i class="material-icons">person_outline</i>
  </div>
  <div class="type-details">
    <div class="type-name">Senior (Age 65+)</div>
    <div class="price">$12.00</div>
  </div>
  <div class="quantity">
    <button class="quantity-btn minus">-</button>
    <span class="quantity-value">0</span>
    <button class="quantity-btn plus">+</button>
  </div>
</div>
      </div>
      <!-- Continue button -->
      <div class="options">
        <button id="continue-btn">Continue</button>
      </div>
  </div>
</div>
  <!-- JavaScript -->
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        // Add event listener to continue button
        document.getElementById("continue-btn").addEventListener("click", function () {
            <?php
            echo "window.location.href = 'booking.php?movie_id=" . $movie["movie_id"] . "'";
            ?>
        });

        // Add event listeners to plus and minus buttons
        document.querySelectorAll(".quantity-btn").forEach(function(button) {
            button.addEventListener("click", function() {
                var quantityElement = this.parentNode.querySelector(".quantity-value");
                var quantity = parseInt(quantityElement.textContent);
                
                if (this.classList.contains("plus")) {
                    quantity++;
                } else {
                    quantity = Math.max(0, quantity - 1); // Ensure quantity doesn't go below zero
                }

                quantityElement.textContent = quantity;
            });
        });
    });
</script>
</body>
</html>