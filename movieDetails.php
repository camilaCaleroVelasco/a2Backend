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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Details</title>
</head>
<body>
    <?php if ($movie) : ?>
        <h2><?php echo $movie['movie_title']; ?></h2>

        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $movie['video']; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    <?php endif; ?>
</body>
</html>
