<?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["movie_id"])) {

        $movie_id = $_GET["movie_id"];
        require_once "includes/dbh.inc.php";

        $sql = "SELECT * FROM movies WHERE movie_id = ?";
            
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: booking.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $movie_id);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt); // Fetch single movie
            
        $movie = mysqli_fetch_assoc($resultData);

        if (!$movie) { // Check if movie found
            echo "<p>Movie not found.</p>";
        }

        // Retrieve ticket variables from URL parameters
        $adult = isset($_GET['adult']) ? intval($_GET['adult']) : 0;
        $child = isset($_GET['child']) ? intval($_GET['child']) : 0;
        $senior = isset($_GET['senior']) ? intval($_GET['senior']) : 0;
    } else {
        header("Location: index.php"); // Redirect if no movie ID
    }

    // Handle submitted promo code
    
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
        <?php
        // Loop through adult, child, and senior variables to generate ticket details
              for ($i = 0; $i < $adult; $i++) {
                echo "<div class='ticket'>";
                echo "<p class='ticket-info'>" . $movie['movie_title'] . "</p>";
                echo "<p class='ticket-info'>Date: March 1, 2024</p>";
                echo "<p class='ticket-info'>Time: 11:00 AM</p>";
                echo "<p class='ticket-info'> Adult Ticket x1</p>";
                echo "<p class='ticket-info'> <span class='delete-ticket' onclick='deleteTicket(this)'>X</span></p>";
                echo "</div>";
              }

            for ($i = 0; $i < $child; $i++) {
                echo "<div class='ticket'>";
                echo "<p class='ticket-info'>" . $movie['movie_title'] . "</p>";
                echo "<p class='ticket-info'>Date: March 1, 2024</p>";
                echo "<p class='ticket-info'>Time: 11:00 AM</p>";
                echo "<p class='ticket-info'> Child Ticket x1</p>";
                echo "<p class='ticket-info'> <span class='delete-ticket' onclick='deleteTicket(this)'>X</span></p>";
                echo "</div>";
            }

            for ($i = 0; $i < $senior; $i++) {
                echo "<div class='ticket'>";
                echo "<p class='ticket-info'>" . $movie['movie_title'] . "</p>";
                echo "<p class='ticket-info'>Date: March 1, 2024</p>";
                echo "<p class='ticket-info'>Time: 11:00 AM</p>";
                echo "<p class='ticket-info'> Senior Ticket x1</p>";
                echo "<p class='ticket-info'> <span class='delete-ticket' onclick='deleteTicket(this)'>X</span></p>";
                echo "</div>";
            }
        ?>
        <div class="total">
          <p><strong>Total Price: $</strong></p>
        </div>
      </div>
      <div class="promo-code">
        <form method="post">
          <label for="promo_code">Promo Code:</label><br>
          <input type="text" id="promo_code" name="promo_code">
          <button type="submit">Apply</button>
        </form>
      </div>
      <div class="payment-method">
        <label for="payment">Payment Method:</label>
        <select id="payment" name="payment">
          <option value="credit_card">Credit Card</option>
          <option value="paypal">PayPal</option>
          <option value="bitcoin">Bitcoin</option>
        </select>
      </div>
      <div class="options">
        <button class="update-order" onclick="goToBooking()">Update Order</button>
        <button class="confirm-order" onclick="goToCheckout()">Complete Checkout</button>
      </div>
    </div>
  </div>
</body>
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
            echo "window.location.href = 'booking.php?movie_id=" . $movie["movie_id"] . "'";
        ?>
    }

    function goToCheckout() {
        if (confirm("Are you sure you want to complete the purchase?")) {
            window.location.href = "confirmation.php";
        }
    }
  </script>


</html>
