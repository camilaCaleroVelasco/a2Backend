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
  <div class="center">
    <div class="order-confirmation">
      <h2>Order Confirmed</h2>
      <p>Your order has been confirmed. Thank you for your purchase!</p>
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
