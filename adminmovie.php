<?php

// Check if success parameter is set and display alert
if(isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<script>alert('Showtimes successfully added');</script>";
}


    require_once "Get/adminMovieGet.php";
    require_once "includes/dbh.inc.php";
    $movie = adminMovieGet($conn);
    $resultNP = $movie['nowPlaying'];
    $resultCS = $movie['comingSoon'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <header>
        <a href="admin.php"><img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo"></a>
        <nav>
            <ul class="nav__links">
                <li><a href="adminmovie.php" >MOVIES</a></li>
                <li><a href="admin.php">USERS</a></li>
                <li><a href="promotions.php">PROMOTIONS</a></li>
            </ul>
        </nav>
    </header>

    <div class = "containter">   <!-- div class container starts here -->
        <div class = "content-holder">
            <div class="now-playing-movies"> 
               
            <div class="now-playing-header">
    <h1 class="movies-type-title">NOW PLAYING</h1>
    <button id="add-movie-button">Add Movie +</button>
</div>
                    <div class =" movies-list-wrapper">
                        <div class ="movies-list">
                        <?php while( $row = mysqli_fetch_array( $resultNP ) ) {
                                echo "
                                <div class = 'movies-list-item'>
                                    <!-- Button for Movies-->
                                    <a href='adminDetails.php?movie_id=" . $row["movie_id"] . "'>
                                    <button>
                                        <img class='movies-poster-img' src=" . htmlspecialchars($row["picture"]) . "alt = 'button image'>
                                    </button></a>
                                </div> <!-- movies-list-item-->";
                            };?>
                        </div> <!-- movies-list-->

                        <!-- Icon from Awesome Icons -->
                        <svg id = "arrow-icon" class = "arrowicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width ="150" height = "150"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#023f9f" 
                            d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
                        <svg id = "arrow-icon-back" class = "arrowiconback" xmlns="http://www.w3.org/2000/svg" viewBox = "0 0 320 512" width ="150" height = "150"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#023f9f"
                            d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>

                       

                        </div> <!-- movies-list-wrapper -->   
                        </div> <!--now-playing-movies -->


                <div class="now-playing-movies">
                    <h1 class ="movies-type-title"> COMING SOON</h1>
                    <div class ="movies-list-wrapper">
                        <div class ="movies-list">
                            <?php while( $row = mysqli_fetch_array( $resultCS ) ) {
                                echo "
                                <div class = 'movies-list-item'>

                                <!-- Button for Movies-->
                                <a href='adminDetails.php?movie_id=" . $row["movie_id"] . "'>
                                <button>
                                    <img class='movies-poster-img' src=" . htmlspecialchars($row["picture"]) . "alt = 'button image'>
                                </button></a>
                                    
                                </div> <!-- movies-list-item -->";
                            }; ?>
                        </div> <!-- movies-list -->
                        <!-- Icon from Awesome Icons -->
                        <svg id = "arrow-icon" class = "arrowicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width ="150" height = "150"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#023f9f" 
                            d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
                         <svg id = "arrow-icon-back" class = "arrowiconback" xmlns="http://www.w3.org/2000/svg" viewBox = "0 0 320 512" width ="150" height = "150"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#023f9f"
                            d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l160 160c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 246.6 118.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-160 160z"/></svg>

                   </div> <!-- movies-list-wrapper -->    
                </div> <!-- now-playing-movies -->
        </div> <!--content-holder -->
    </div>  <!-- div class container ends here -->

<script src="javascript/index.js"></script>
    <!-- <script>
        document.getElementById("add").addEventListener("click", () => {
            event.preventDefault();
            window.location.href="addMovie.php"; //directs to addMovie.php
        });
    </script> -->

</body>
<script>
        document.getElementById("add-movie-button").addEventListener("click", () => {
            window.location.href = "addMovie.php"; // Directs to addMovie.php
        });
    </script>
</html>

    

