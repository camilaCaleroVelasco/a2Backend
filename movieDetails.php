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
    <meta http-equiv="X-UA Compatible" content="IE=edge">
    <title>Movie Details</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<header>
    <a href="index.php"><img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo">  
        <nav>
            <ul class="nav__links">
                <li><a href="admin.php">ADMIN</a></li>
                <li><a href="login.php">LOGIN</a></li> <!-- Link to the login page -->
                <li class="search">
                    <form action="search.php" method="POST"> <!-- Specify the action and method for the form -->
                        <input id="search" type="text" name="moviesearch" placeholder="Search Movies">
                    </form>
                </li>
               
            </ul>
        </nav>
    </header>
<body>
    <?php if ($movie) : ?>
        <h2><?php echo $movie['movie_title']; ?></h2>

            <iframe width="560" height="315" src="<?php echo $movie['video']; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    <?php endif ?>
    <?php 
    echo "<div>";
    //direct to movieDetails when button is clicked
    echo "<a href='booking.php?movie_id=" . $movie["id"] . "'>";
    //<!---Create the image as a button--->
    echo "<h4>";
    echo "<button class = 'bookingButton'> Book Movie </h4>" ;
    echo "</a>
    <br>";
  
    echo "</div>";
    ?>
</body>
</html>
