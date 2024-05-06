<?php
session_start();
require_once 'includes/dbh.inc.php';

// Check if the POST data is present and then assign it to session variables
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['movieId'])) {
        $_SESSION['movieId'] = $_POST['movieId'];
        $movie_id = $_SESSION['movieId'];

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
    }

    if (isset($_POST['selectedSeats'])) {
        // Convert the comma-separated seat IDs into an array
        $_SESSION['selectedSeats'] = explode(',', $_POST['selectedSeats']);
    }

    if (isset($_POST['totalTickets'])) {
        $_SESSION['totalTickets'] = $_POST['totalTickets'];
    }
} else {
    header("Location: index.php"); // Redirect if no POST data
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
        <div class="ticket-type adult"> <!-- Updated class to include "adult" -->
          <div class="icon">
            <i class="material-icons">person</i>
          </div>
          <div class="type-details">
            <div class="type-name">Adult</div>
            <div class="price">$15.00</div>
          </div>
          <div class="quantity">
            <button class="quantity-btn minus">-</button>
            <span class="quantity-value" id="adult-quantity">0</span>
            <button class="quantity-btn plus">+</button>
          </div>
        </div>
        <!-- Child ticket type -->
        <div class="ticket-type child"> <!-- Updated class to include "child" -->
          <div class="icon">
            <i class="material-icons">child_care</i>
          </div>
          <div class="type-details">
            <div class="type-name">Child (Under 12)</div>
            <div class="price">$10.00</div>
          </div>
          <div class="quantity">
            <button class="quantity-btn minus">-</button>
            <span class="quantity-value" id="child-quantity">0</span>
            <button class="quantity-btn plus">+</button>
          </div>
        </div>
        <!-- Senior ticket type -->
        <div class="ticket-type senior"> <!-- Updated class to include "senior" -->
          <div class="icon">
            <i class="material-icons">person_outline</i>
          </div>
          <div class="type-details">
            <div class="type-name">Senior (Age 65+)</div>
            <div class="price">$12.00</div>
          </div>
          <div class="quantity">
            <button class="quantity-btn minus">-</button>
            <span class="quantity-value" id="senior-quantity">0</span>
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
  
  <script>
    document.addEventListener("DOMContentLoaded", function () {
        var adultQuantity = 0;
        var childQuantity = 0;
        var seniorQuantity = 0;
        var totalQuantity = 0;
        var totalTickets = <?php echo isset($_SESSION['totalTickets']) ? intval($_SESSION['totalTickets']) : 0; ?>;

        function updateQuantities() {
            document.getElementById("adult-quantity").textContent = adultQuantity;
            document.getElementById("child-quantity").textContent = childQuantity;
            document.getElementById("senior-quantity").textContent = seniorQuantity;

            totalQuantity = adultQuantity + childQuantity + seniorQuantity;
            document.getElementById("total-quantity").textContent = totalQuantity;

            document.querySelectorAll(".quantity-btn.plus").forEach(function(button) {
                button.disabled = totalQuantity >= totalTickets;
            });

            document.querySelectorAll(".quantity-btn.minus").forEach(function(button) {
                var ticketType = button.closest(".ticket-type");
                var typeQuantity = parseInt(ticketType.querySelector(".quantity-value").textContent);
                button.disabled = typeQuantity === 0;
            });
        }

        document.querySelectorAll(".quantity-btn").forEach(function(button) {
            button.addEventListener("click", function() {
                var ticketType = this.closest(".ticket-type");
                var quantityElement = ticketType.querySelector(".quantity-value");
                var quantity = parseInt(quantityElement.textContent);

                if (this.classList.contains("plus") && totalQuantity < totalTickets) {
                    quantity++;
                } else if (this.classList.contains("minus") && quantity > 0) {
                    quantity--;
                }

                quantityElement.textContent = quantity;

                if (ticketType.classList.contains("adult")) {
                    adultQuantity = quantity;
                } else if (ticketType.classList.contains("child")) {
                    childQuantity = quantity;
                } else if (ticketType.classList.contains("senior")) {
                    seniorQuantity = quantity;
                }

                updateQuantities();
            });
        });

        document.getElementById("continue-btn").addEventListener("click", function () {
            if (totalQuantity === totalTickets) {
                var url = 'ordersummary.php?movie_id=<?php echo $movie["movie_id"]; ?>&adult=' + adultQuantity + '&child=' + childQuantity + '&senior=' + seniorQuantity;
                window.location.href = url;
            } else {
                alert("Please select types for all tickets.");
            }
        });
    });
  </script>
</body>
</html>