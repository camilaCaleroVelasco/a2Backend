<?php
    include 'includes/databaseConnection.inc.php';
        $mysqli = new mysqli("localhost","root","","movies");
        $sqlNP = "SELECT * FROM movies WHERE movie_status LIKE '%now playing%'";
        $sqlCS = "SELECT * FROM movies WHERE movie_status LIKE '%coming soon%'";
        $resultNP = mysqli_query( $mysqli, $sqlNP ) or die("bad query: $sql");
        $resultCS = mysqli_query( $mysqli, $sqlCS ) or die("bad query: $sql");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View</title>
    <link rel="stylesheet" href="css/adminmovie.css">
</head>
<body>
    <header>
        <a href="index.php"><img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo"></a>
        <nav>
            <ul class="nav__links">
                <li><a href="adminmovie.php" >MOVIES</a></li>
                <li><a href="admin.php">USERS</a></li>
                <li><a href="login.php">PROMOTIONS</a></li>
            </ul>
        </nav>
    </header>

    
</body>
</html>
