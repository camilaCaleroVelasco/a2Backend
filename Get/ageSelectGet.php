<?php
// DONT NEED FILE - TALK TO CAMILLA

function getMovieID($conn) {
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
        $_SESSION['selectedSeats'] = $_POST['selectedSeats'];
    }

    if (isset($_POST['totalTickets'])) {
        $_SESSION['totalTickets'] = $_POST['totalTickets'];
    }
} else {
    header("Location: index.php"); // Redirect if no movie ID
    }

}