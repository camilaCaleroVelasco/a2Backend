<?php
    require_once "includes/dbh.inc.php";
    require_once "functions/searchFunctions.php";
    include_once 'editProfileProcess.php';

    // Initialize the $results variable
    $results = array();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if search term and filter are provided
        if(isset($_POST["now-playing-button"]) || isset($_POST["coming-soon-button"])) {
            $search = $_SESSION['search'];

            // Filter based on both search term and filter
            if(isset($_POST["coming-soon-button"])) {
                $results = filterMoviesByStatus($conn, "coming soon", $search);
                if($results == false) {
                    $results = filterMoviesByCategory($conn, "coming soon", $search);
                }

            } elseif(isset($_POST["now-playing-button"])) {
                $results = filterMoviesByStatus($conn, "now playing", $search);
                if($results == false) {
                    $results =  $results = filterMoviesByCategory($conn, "now playing", $search);
                }
            }
        }
        // Check if only search term is provided
        elseif(isset($_POST["moviesearch"])) {
            $_SESSION['search'] = $_POST["moviesearch"];

            $search = $_POST["moviesearch"];

            $results = searchMovieTitle($conn, $search);
            //var_dump($results);
            if($results == false) {
                $results = searchMovieCategory($conn,$search);
            }
        }
    } 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA Compatible" content="IE=edge">
    <title>Search Results</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/search.css">
</head>

<body>
    <header>
    <a href= "index.php">
            <img class="logo" src="images/A2 movies Icon.jpeg" alt="logo">
        </a>
        <nav>
            <ul class="nav__links">
            <?php
            if (isset($_SESSION["email"])) {
                echo "<p> Hello, " . $currentFirstName . "</p>";
                echo "<li><a href='editProfile.php'>VIEW PROFILE</a></li>";
                echo "<li><a href='logout.php'>LOGOUT</a></li>";
                if($_SESSION["userType_id"] == 2) {
                    echo "<li><a href='admin.php'>ADMIN</a></li>";
                }
            }
            else {
              echo "<li><a href='login.php'>LOGIN</a></li>";
            }
          ?>
                <li class="search">
                    <form action="search.php" method="POST"> <!-- Specify the action and method for the form -->
                        <input id="search" type="text" name="moviesearch" placeholder="Search Movies">
                    </form>
                </li>
               
            </ul>
        </nav>
    </header>



    <form action="search.php?moviesearch=<?php.$search?>" method="POST"> <!-- Specify the action and method for the form -->
        <div class = "filter-buttons">
            <button type="submit" id="nowPlaying" name="now-playing-button">Now Playing</button>
            <button type="submit" id="comingSoon" name="coming-soon-button">Coming Soon</button>
        </div>
    </form>

    
    <h2 id ="searchHeader">Search results:</h2>


    <section class = "image-section">

        <?php
        if ($results == false) {
            echo "<div>";
            echo "<p> There were no results! </p>";
            echo "</div>";
        } else {
            
            foreach ($results as $row) {
                echo "<div>";
                //direct to movieDetails when button is clicked
                echo "<a href='movieDetails.php?movie_id=" . $row["movie_id"] . "'>";
                //<!---Create the image as a button--->
                echo "<h4>";
                echo "<button class = 'image-button'> <img id='movie' src=" . htmlspecialchars($row["picture"]) . "width='300'
                    height='400'</h4>";
                echo "</a>
                    <br>";
                echo "</div>";
            }
        }
        ?>

    </section>

</body>

</html>