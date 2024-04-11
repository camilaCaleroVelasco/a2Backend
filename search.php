<?php
   include_once "searchProcess.php";
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