<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $movieTitle = $_POST["moviesearch"];
        

        try {
            require_once "includes/databaseConnection.inc.php";
            
            $query = "SELECT * FROM movies WHERE movie_title LIKE :moviesearch;"; //sql

                $stmt = $pdo->prepare($query);
                $stmt->bindValue(':moviesearch', '%' . $movieTitle . '%', PDO::PARAM_STR);               
                 $stmt-> execute();

                $results = $stmt->fetchAll(PDO::FETCH_ASSOC); //data from db is in results
                #var_dump($results);

                $pdo = null;
                $stmt = null;

        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }
    else{
        header("Location: ../index.php");//sends back to the index page so ppl can't get data
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="search.css" rel="stylesheet">
    <script defer src = "script.js"></script>
    <title>Search Results</title>
</head>
<body>
    <section>

        <h3>Search results:</h3>

        <?php

        if(empty($results)) {
            echo "<div>";
            echo "<p> There were no results! </p>";
            echo "</div>";
        }
else {
    foreach ($results as $row) {
        echo "<div>";
    
                    //<!---Create the image as a button--->

                    echo "<h4>";
                    echo "<button> <img id='movie' src=" . htmlspecialchars($row["picture"]) . "width='300'
                    height='400'</h4>" ;
                    echo "</div>";
                }
            }
        ?>

    </section>

</body>
</html>