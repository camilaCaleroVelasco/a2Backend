<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["movie_id"]) && isset($_SESSION["email"])) {

    $movie_id = $_GET["movie_id"];
    require_once "includes/dbh.inc.php";
    include "functions/orderSummaryFunctions.php";

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

    // Retrieve ticket variables from URL parameters
    $adult = isset($_GET['adult']) ? intval($_GET['adult']) : 0;
    $child = isset($_GET['child']) ? intval($_GET['child']) : 0;
    $senior = isset($_GET['senior']) ? intval($_GET['senior']) : 0;

    // Retrieve ticket prices
    $ticketPrices = [];
    $ticketTypes = ["child", "adult", "senior"];
    foreach ($ticketTypes as $type) {
        $sql = "SELECT ticketPrice FROM tickettype WHERE ticketType = ?";
        if (mysqli_stmt_prepare($stmt, $sql)) {
            $upperType = strtoupper($type);
            mysqli_stmt_bind_param($stmt, "s", $upperType);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            $ticketPrices[$type] = $row['ticketPrice'];
        }
    }

    $totalPrice = $child * $ticketPrices['child'] +
                  $adult * $ticketPrices['adult'] +
                  $senior * $ticketPrices['senior'];

    $taxRate = 0.07;
    $taxAmount = $totalPrice * $taxRate;
    $totalWithTax = $totalPrice + $taxAmount;

    // Retrieve users_id
    $user_id = $_SESSION["users_id"];

    // Retrieve payment methods
    $paymentMethods = getPaymentMethods($user_id, $conn);
    $hasPaymentMethods = !empty($paymentMethods);

    // Apply promo code
    $discount = isset($_GET['discount']) ? floatval($_GET['discount']) : 0;
    $discountedPrice = $totalWithTax * (1 - $discount / 100);

    $promo_code = isset($_GET['code']) ? $_GET['code'] : '';
    $promo_code_applied = false;

    if (isset($_GET["status"]) && $_GET["status"] == "success") {
        $successMessage = urldecode($_GET["message"]);
        $promo_code_applied = true;
    } elseif (isset($_GET["message"])) {
        $successMessage = urldecode($_GET["message"]);
    }
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
  <header>
  <div class="center">
    <div class="order-summary">
      <div class="head">
        <div class="title"><h3>Order Summary</h3></div>
      </div>
      <div class="ticket-details">
        <h2>Ticket Details</h2>
        <?php
        if ($adult > 0) {
                echo "<div class='ticket'>";
                echo "<p class='ticket-info'>" . $movie['movie_title'] . "</p>";
                echo "<p class='ticket-info'>Date: March 1, 2024</p>";
                echo "<p class='ticket-info'>Time: 11:00 AM</p>";
                echo "<p class='ticket-info'> Adult Ticket x". $adult ."</p>";
                echo "<p class='ticket-info'> <span class='delete-ticket' onclick='deleteTicket(this)'>X</span></p>";
                echo "</div>";
        }
        if ($child > 0) {
                echo "<div class='ticket'>";
                echo "<p class='ticket-info'>" . $movie['movie_title'] . "</p>";
                echo "<p class='ticket-info'>Date: March 1, 2024</p>";
                echo "<p class='ticket-info'>Time: 11:00 AM</p>";
                echo "<p class='ticket-info'> Child Ticket x". $child ."</p>";
                echo "<p class='ticket-info'> <span class='delete-ticket' onclick='deleteTicket(this)'>X</span></p>";
                echo "</div>";
        }
        if ($senior > 0) {
                echo "<div class='ticket'>";
                echo "<p class='ticket-info'>" . $movie['movie_title'] . "</p>";
                echo "<p class='ticket-info'>Date: March 1, 2024</p>";
                echo "<p class='ticket-info'>Time: 11:00 AM</p>";
                echo "<p class='ticket-info'> Senior Ticket x". $senior ."</p>";
                echo "<p class='ticket-info'> <span class='delete-ticket' onclick='deleteTicket(this)'>X</span></p>";
                echo "</div>";
        }

        ?>
    <div class="total">
                    <p><strong>Subtotal: $<span id="subtotal"><?php echo $totalPrice; ?></span></strong></p>
                    <p><strong>Tax (7%): $<span id="tax"><?php echo number_format($taxAmount, 2); ?></span></strong></p>
                    <p><strong>Total Price: $<span id="total-price"><?php echo number_format($totalWithTax, 2); ?></span></strong></p>
                    <?php if ($discount > 0): ?>
                        <p><strong>Discount: - $<span id="discount"><?php echo number_format($totalWithTax - $discountedPrice, 2); ?></span></strong></p>
                    <?php endif; ?>
                    <p><strong>Final Total Price: $<span id="final-price"><?php echo number_format($discountedPrice, 2); ?></span></strong></p>
                </div>
            </div>
            <div class="promo-code">
                <form method="post"
                      action="orderSummaryProcess.php?movie_id=<?php echo $movie_id ?>&adult=<?php echo $adult ?>&child=<?php echo $child ?>&senior=<?php echo $senior ?>&promo_code=<?php echo htmlspecialchars($promo_code); ?>">
                    <label for="promo_code">Promo Code:</label><br>
                    <input type="text" id="promo_code" name="promo_code"
                           value="<?php echo htmlspecialchars($promo_code); ?>"
                           <?php echo $promo_code_applied ? 'readonly' : ''; ?>>
                    <button type="submit" name="submitCode"
                            <?php echo $promo_code_applied ? 'disabled' : ''; ?>>Apply
                    </button>
                    <?php
                    if (!empty($successMessage)) {
                        echo "<p>$successMessage</p>";
                    }
                    ?>
                </form>
            </div>
      <div class="payment-method">
    <label for="payment">Payment Method:</label>
    <select id="payment" name="payment">
    <?php
      $paymentMethods = getPaymentMethods($user_id, $conn);
      // Check if payment methods are available
      if ($hasPaymentMethods) {
          // Loop through payment methods and generate options
          foreach ($paymentMethods as $method) {
              echo "<option value='" . $method . "'>" . $method . "</option>";
          }
      } else {
          // If no payment methods are available, display a default option
          echo "<option value='None'>No Payment Methods Found.</option>";
      }
      ?>
    </select>
</div>
<div class="options">
        <button class="update-order" onclick="goToBooking()">Update Order</button>
        <button class="confirm-order" <?php echo $hasPaymentMethods ? '' : 'disabled'; ?> onclick="goToCheckout()">Complete Checkout</button>
        <?php if (!$hasPaymentMethods): ?>
            <p class="error">Please add a payment method before checking out.</p>
            <a href="editProfile.php"  id="addPayment">Add Payment</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
  <script>
    function deleteTicket(element) {
        if (confirm("Are you sure you want to delete this ticket?")) {
            let ticket = element.parentElement.parentElement; // Get the parent ticket element
            ticket.remove();
            updateTotalPrice(-ticketPrice);
        }
    }

    function updateTotalPrice(amount) {
        let subtotalElement = document.getElementById("subtotal");
        let taxElement = document.getElementById("tax");
        let totalPriceElement = document.getElementById("total-price");
        let discountElement = document.getElementById("discount");
        let finalPriceElement = document.getElementById("final-price");

        let currentSubtotal = parseFloat(subtotalElement.innerText);
        let newSubtotal = currentSubtotal + amount;

        let newTax = newSubtotal * 0.05; // Assuming a tax rate of 5%
        let newTotal = newSubtotal + newTax;

        let currentDiscount = parseFloat(discountElement.innerText);
        let newFinalTotal = newTotal - currentDiscount;

        subtotalElement.innerText = newSubtotal.toFixed(2);
        taxElement.innerText.toFixed(2);
        totalPriceElement.innerText.toFixed(2);
        finalPriceElement.innerText.toFixed(2);
    }

    function goToBooking() {
        <?php
            echo "window.location.href = 'booking.php?movie_id=" . $movie["movie_id"] . "'";
        ?>
    }

    function goToCheckout() {
        if (confirm("Are you sure you want to complete the purchase?")) {
            // Send email confirmation
            sendEmailConfirmation();
            window.location.href = "confirmation.php";
        }
    }

    function sendEmailConfirmation() {
        fetch("sendEmailConfirmation.php", {
            method: "POST"
        }).then(response => {
            if (!response.ok) {
                throw new Error("Failed to send email confirmation.");
            }
            return response.text();
        }).then(data => {
            console.log(data);
        }).catch(error => {
            console.error("Error:", error);
        });
    }

    
  </script>


</html>
