<?php
 session_start();
 if ((!isset($_SESSION["email"])) || (isset($_SESSION["email"]) && $_SESSION["userType_id"] !== 2)) {

     header("Location: restrictedAccess.php");
     exit();
 }


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["movie_id"])) {

    $movie_id = $_GET["movie_id"];

        require_once "includes/dbh.inc.php";

        $sql = "SELECT * FROM movies WHERE movie_id = ?";

        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: adminDetails.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $movie_id);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt); // Fetch single movie

        $result = mysqli_fetch_assoc($resultData);

        if (!$result) {
            echo "<p>Sorry, movie was not found!.</p>";
        }
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
    <a href="admin.php"><img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo">  
        <nav>
            <ul class="nav__links">
                <li><a href="adminmovie.php" >MOVIES</a></li>
                <li><a href="admin.php">USERS</a></li>
                <li><a href="promotions.php">PROMOTIONS</a></li>
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
        <strong>Category:</strong> <?php echo $result['category'];?>
        <br>
        <strong>Cast:</strong> <?php echo $result['cast'];?></strong>
                    </br>
                    </br>   
                   <i> <?php echo $result['synopsis'];?> </i>
                    </br>
    <?php endif ?>

        <div>
        <!-- direct to movieDetails when button is clicked -->
                <!-- Image button -->
                <h4>
                    <!-- button for booking -->
                    <button id = "detailsbutton"> Edit Details </button>
                    <button id = "detailsbutton"> Edit Showtimes </button>
                    <button id="detailsbutton" onclick="confirmDelete(<?php echo $result['movie_id']; ?>)">DELETE MOVIE</button>
                </h4>
            </a>
        </div>
</body>
</html>