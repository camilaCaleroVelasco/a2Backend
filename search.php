<?php
    require_once "includes/dbh.inc.php";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $search = $_POST["moviesearch"];
            
        $sql = "SELECT * FROM movies WHERE (movie_title LIKE '%$search%' OR category LIKE '%$search%')"; //sql
        
        $results = mysqli_query( $conn, $sql ) or die("bad query: $sql");

        //echo var_dump($results) . "<br>";
        
    }
    else{
        header("Location: index.php");//sends back to the index page so ppl can't get data
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
    <section>

        <h3>Search results:</h3>

        <?php
            if(empty($results)) {
                echo "<div>";
                echo "<p> There were no results! </p>";
                echo "</div>";
            }
            else {
                while( $row = mysqli_fetch_array( $results) ) {
                    echo "<div>";
                    //direct to movieDetails when button is clicked
                    echo "<a href='movieDetails.php?movie_id=" . $row["movie_id"] . "'>";
                    //<!---Create the image as a button--->
                    echo "<h4>";
                    echo "<button class = 'image-button'> <img id='movie' src=" . htmlspecialchars($row["picture"]) . "width='300'
                    height='400'</h4>" ;
                    echo "</a>
                    <br>";
                    echo "</div>";
                }
            }
        ?>

    </section>

</body>
</html>