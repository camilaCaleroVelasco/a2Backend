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
        <div class="title">Order Summary</div>
      </div>
      <div class="ticket-details">
        <h2>Ticket Details</h2>
        <div class="ticket">
          <p class="ticket-info">Movie: Avengers: Endgame</p>
          <p class="ticket-info">Date: February 13, 2024</p>
          <p class="ticket-info">Time: 11:00 AM</p>
          <p class="ticket-info">Adult Ticket x 2 - $30.00 <span class="delete-ticket" onclick="deleteTicket(this)">X</span></p>
        </div>
        <div class="ticket">
          <p class="ticket-info">Movie: Avengers: Endgame</p>
          <p class="ticket-info">Date: February 13, 2024</p>
          <p class="ticket-info">Time: 11:00 AM</p>
          <p class="ticket-info">Child Ticket x 1 - $15.00 <span class="delete-ticket" onclick="deleteTicket(this)">X</span></p>
        </div>
        <div class="total">
          <p><strong>Total Price: $45.00</strong></p>
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
      window.location.href = "booking.php";
    }

    function goToCheckout() {
      window.location.href = "checkout.php";
    }
  </script>
</body>
</html>

