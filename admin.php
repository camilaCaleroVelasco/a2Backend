<?php
    if (!isset($_SESSION["email"]) || (isset($_SESSION["email"]) && $_SESSION["userType_id"] != 2)) {

        header("Location: restrictedAccess.php");
        exit();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <header>
        <a href="index.php"><img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo"></a>
        <nav>
            <ul class="nav__links">
                <li><a href="adminmovie.php" >MOVIES</a></li>
                <li><a href="admin.php">USERS</a></li>
                <li><a href="promotions.php">PROMOTIONS</a></li>
                <li><a href="logout.php" >LOGOUT</a></li>
                </li>
            </ul>
        </nav>
    </header>

    <div class="admin-view">
        <div class="admin-content">
            <h2>Welcome to Admin Panel</h2>
            <p>This is the main screen of the Admin Panel.</p>
            <p>From here, you can manage movies, users, and promotions.</p>
            <p>Please select an option from the navigation bar to proceed.</p>
        </div>
    </div>
</body>
</html>