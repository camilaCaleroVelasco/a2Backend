<?php
    include_once 'editProfileProcess.php';
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["movie_id"])) {

        $movie_id = $_GET["movie_id"];

        require_once "includes/dbh.inc.php";
        require_once "functions/movieDetailsFunctions.php";

        $result = getMovieInfo($conn, $movie_id);
        $category = getMovieCategory($conn, $result['category_id']);
    } 
    else {
        header("Location: index.php"); //Redirect so DB is not accessible
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
    <link rel="stylesheet" href="css/movieDetails.css">
</head>
<body>
<header>
    <a href="index.php"><img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo"></a>  
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
                session_unset();
                session_destroy();
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
<body>
    <?php if ($result) : ?>
        <h2>
            <?php echo $result['movie_title']; ?>, (<?php echo $result['rating_code']; ?>)
        </h2>

        <iframe width="560" height="315" src="<?php echo $result['video']; ?>" 
            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

        </br>
       <h3> Rating: <?php echo $result['reviews'];?>/5</h3>
    </br>
    <p> 
        <strong>Director:</strong> <?php echo $result['producer'];?></strong>
        </br> 
        <strong> Producer: </strong> <?php echo $result['producer']; ?>
        </br>
        <strong>Category:</strong> <?php echo $category['category'];?>
        <br>
        <strong>Cast:</strong> <?php echo $result['cast'];?></strong>
                    </br>
                    </br>   
                   <i> <?php echo $result['synopsis'];?> </i>
                    </br>
    <?php endif ?>

        <div>
        <!-- direct to movieDetails when button is clicked -->
            <a href="ageselect.php?movie_id=<?php echo $result['movie_id']?>">
                <!-- Image button -->
                <h4>
                    <!-- button for booking -->
                    <button id = "detailsbutton"> BOOK MOVIE </button>
                </h4>
            </a>
        </div>
</body>
</html>
