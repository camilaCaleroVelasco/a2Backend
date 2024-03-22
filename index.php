<?php
    include 'includes/databaseConnection.inc.php';
        $mysqli = new mysqli("localhost","root","","movies");
        $sqlNP = "SELECT * FROM movies WHERE movie_status LIKE '%now playing%'";
        $sqlCS = "SELECT * FROM movies WHERE movie_status LIKE '%coming soon%'";
        $resultNP = mysqli_query( $mysqli, $sqlNP ) or die("bad query: $sql");
        $resultCS = mysqli_query( $mysqli, $sqlCS ) or die("bad query: $sql");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA Compatible" content="IE=edge">
    <title>A2 MOVIES</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
  
</head>

<body>
    <header>
        <img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo">  
        <nav>
            <ul class="nav__links">
                <li><a href="adminLogin.php">ADMIN</a></li>
                <li><a href="login.php">LOGIN</a></li> <!-- Link to the login page -->
                <li class="search">
                    <form action="search.php" method="POST"> <!-- Specify the action and method for the form -->
                        <input id="search" type="text" name="moviesearch" placeholder="Search Movies">
                    </form>
                </li>
               
            </ul>
        </nav>
    </header>


    <!-- Creating Container to Hold now showing movies --> 
    <div class = "containter">   <!-- div class container starts here -->
        <div class = "content-holder">
            <div class="now-playing-movies">
                    <h1 class ="movies-type-title"> NOW PLAYING</h1>
                    <div class =" movies-list-wrapper">
                        
                        <div class ="movies-list">
                        <?php while( $row = mysqli_fetch_array( $resultNP ) ) {
                                echo "
                                <div class = 'movies-list-item'>
                                    <!-- Button for Movies-->
                                    <a href='movieDetails.php?movie_id=" . $row["movie_id"] . "'>
                                    <button>
                                        <img class='movies-poster-img' src=" . htmlspecialchars($row["picture"]) . "alt = 'button image'>
                                    </button></a>
                                </div> <!-- movies-list-item-->";
                            };?>
                        </div> <!-- movies-list-->

                        <!-- Icon from Awesome Icons -->
                        <svg id = "arrow-icon" class = "arrowicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width ="150" height = "150"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#023f9f" 
                            d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
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
                                <a href='movieDetails.php?movie_id=" . $row["movie_id"] . "'>
                                <button>
                                    <img class='movies-poster-img' src=" . htmlspecialchars($row["picture"]) . "alt = 'button image'>
                                </button></a>
                                    
                                </div> <!-- movies-list-item -->";
                            }; ?>
                        </div> <!-- movies-list -->
                        <!-- Icon from Awesome Icons -->
                        <svg id = "arrow-icon" class = "arrowicon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" width ="150" height = "150"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#023f9f" 
                            d="M278.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-160 160c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L210.7 256 73.4 118.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l160 160z"/></svg>
                   </div> <!-- movies-list-wrapper -->    
                </div> <!-- now-playing-movies -->
        </div> <!--content-holder -->
    </div>  <!-- div class container ends here -->

<script src="javascript/index.js"></script>

</body>
</html>