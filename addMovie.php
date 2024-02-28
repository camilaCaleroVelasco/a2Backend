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
    <form action="add.php" method="POST">
        <input type="text" name="movie_title" placeholder="Movie Title">
        <br>
        <input type="text" name="category" placeholder="Movie Category">
        <br>
        <input type="text" name="director" placeholder="Director">
        <br>
        <input type="text" name="producer" placeholder="Producer">
        <br>
        <input type="text" name="synopsis" placeholder="Sypnosis">
        <br>
        <input type="text" name="reviews" placeholder="Reviews">
        <br>
        <input type="text" name="picture" placeholder="Picture link">
        <br>
        <input type="text" name="video" placeholder="Youtube Link">
        <br>
        <input type="text" name="rating_code" placeholder="Rating Code">
        <br>
        <input type="text" name="movie_status" placeholder="Movie Status">
        <br>
        <input type="text" name="cast_1" placeholder="Cast 1">
        <br>
        <input type="text" name="cast_2" placeholder="Cast 2">
        <br>
        <input type="text" name="cast_3" placeholder="Cast 3">
        <br>
        <input type="text" name="cast_4" placeholder="Cast 4">
        <br>
        <input type="text" name="cast_5" placeholder="Cast 5">
        <br>
        <button id = "submit" type="submit" name="submit"> Add </button>
</body>
</html>
