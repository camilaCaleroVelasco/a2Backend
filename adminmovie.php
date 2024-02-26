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

    <div class="admin-view">
        <div class="admin-content">
            <h2>Manage Movies</h2>
            <ul class="movie-list">
                <h3>Now Playing</h3>
                <?php
                while($row = mysqli_fetch_assoc($resultNP)){
                    echo 
                        '<li>
                        <span class="movie-info">' . $row['movie_title'] . ' - <a href="#" class="edit-show-time">Edit Show Time</a> | <a href="#" class="edit-detail">Edit Details</a> | <a href="#" class="delete-movie">Delete Movie</a></span>
                        </li>';
                }
                
                ?>
                <h3>Coming Soon</h3>
                <?php
                while($row = mysqli_fetch_assoc($resultCS)){
                    echo 
                        '<li>
                        <span class="movie-info">' . $row['movie_title'] . ' - <a href="#" class="edit-show-time">Edit Show Time</a> | <a href="#" class="edit-detail">Edit Details</a> | <a href="#" class="delete-movie">Delete Movie</a></span>
                        </li>';
                }
                
                ?>
                <!-- Add more movies as needed -->
            </ul>
            <div class="button-box">
                <button type ="add" class="add-movie-btn" id="add">Add Movie</button>
            </div>
            
        </div>
    </div>
    <script>
        document.getElementById("add").addEventListener("click", () => {
            event.preventDefault();
            window.location.href="addMovie.php"; //directs to addMovie.php
        });
    </script>

</body>
</html>

    

