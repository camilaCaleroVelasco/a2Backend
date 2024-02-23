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
                <li>
                    <span class="movie-info">Movie 1 - <a href="#" class="edit-show-time">Edit Show Time</a> | <a href="#" class="edit-detail">Edit Details</a> | <a href="#" class="delete-movie">Delete Movie</a></span>
                </li>
                <li>
                    <span class="movie-info">Movie 2 - <a href="#" class="edit-show-time">Edit Show Time</a> | <a href="#" class="edit-detail">Edit Details</a> | <a href="#" class="delete-movie">Delete Movie</a></span>
                </li>
                <!-- Add more movies as needed -->
            </ul>
            <button class="add-movie-btn">Add Movie</button>
        </div>
    </div>
</body>
</html>

