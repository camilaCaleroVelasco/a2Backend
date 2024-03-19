<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout</title>
  <!-- Google Fonts and Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Round|Material+Icons+Sharp|Material+Icons+Two+Tone" rel="stylesheet">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <!-- CSS -->
  <link rel="stylesheet" href="css/checkout.css">
  
</head>
<body>
  <div class="center">
    <div class="checkout-form">
      <h2>Checkout</h2>
      <form>
        <div class="form-group">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <textarea id="address" name="address" rows="4" required></textarea>
        </div>
        <div class="form-group">
          <label for="phone">Phone</label>
          <input type="tel" id="phone" name="phone" required>
        </div>
        <div class="form-group">
          <label for="payment-method">Payment Method</label>
          <select id="payment-method" name="payment-method" required>
            <option value="">Select Payment Method</option>
            <option value="credit-card">Debit Card</option>
            <option value="paypal">PayPal</option>
            <option value="paypal">Venmo</option>
          </select>
        </div>
        <div class="buttons">
          <button type="submit" onclick="confirmCheckout()">Confirm</button>
          <button type="button" onclick="cancelCheckout()">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function confirmCheckout() {
      window.location.href = "confirmation.php";
    }

    function cancelCheckout() {
      if (confirm("Are you sure you want to cancel?")) {
        window.location.href = "index.php"; // Redirect to home page
      }
    }
  </script>
</body>
</html>
