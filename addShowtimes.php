<?php
    session_start();
    
    require_once "functions/checkIfAdminFunction.php"; 
    require_once "functions/addShowtimesFunctions.php";
    // Checks if user is admin
    checkIfAdmin();
    $details = getMovieDetailsShowtime($conn);
    $result = $details['movieInfo'];

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Showtimes</title>
    <link rel="stylesheet" href="css/showtime.css">
</head>
<body>
    <header>
        <a href="admin.php"><img class="logo" src="images/A2 Movies Icon.jpeg" alt="logo"></a>
        <nav>
            <ul class="nav__links">
                <li><a href="adminmovie.php">MOVIES</a></li>
                <li><a href="admin.php">USERS</a></li>
                <li><a href="login.php">PROMOTIONS</a></li>
            </ul>
        </nav>
    </header>

    <!-- Popup for selecting times -->
    <?php for($i = 0; $i < 5; $i++): ?>
        <div id="popup<?php echo $i; ?>" class="popup">
            <div class="popup-content">
                <span class="close" onclick="closePopup(<?php echo $i; ?>)">&times;</span>
                <h3>Select Times</h3>
                <input type="time" id="popupTime1_<?php echo $i; ?>" required>
                <input type="time" id="popupTime2_<?php echo $i; ?>" required>
                <input type="time" id="popupTime3_<?php echo $i; ?>" required>
                <input type="time" id="popupTime4_<?php echo $i; ?>" required>
               
                <button onclick="saveTimes(<?php echo $i; ?>)">Save Times</button>
            </div>
        </div>
    <?php endfor; ?>

    <form id="showtimesForm" action="addShowtimesProcess.php?movie_id=<?php echo htmlspecialchars($result['movie_id']); ?>" method="POST">
        
        <h2>
            <?php 
            echo $result['movie_title'];
             ?>
        </h2>
        
        
        <br>
        <!-- Showtimes -->
        <div id="showtimesContainer">
            <!-- Showtime templates -->
            <?php for($i = 0; $i < 5; $i++): ?>
                <div class="showtime">
                    <input type="date" name="date[]" required>
                    <input type="hidden" name="times[]" value="">
                    <button type="button" class="select-times-button" onclick="showPopup(<?php echo $i; ?>)">Select Times</button>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Save button -->
        <button id="submit" type="submit" name="submit">Save Showtimes</button>

    </form>
    <script>
        var currentShowtime;

        function showPopup(index) {
            currentShowtime = document.querySelectorAll('.showtime')[index];
            document.getElementById('popup' + index).style.display = 'block';
        }

        function closePopup(index) {
            document.getElementById('popup' + index).style.display = 'none';
        }

        function saveTimes(index) {
            var popupTimes = [
                document.getElementById('popupTime1_' + index).value,
                document.getElementById('popupTime2_' + index).value,
                document.getElementById('popupTime3_' + index).value,
                document.getElementById('popupTime4_' + index).value,
                // document.getElementById('popupTime5_' + index).value,
                // document.getElementById('popupTime6_' + index).value
            ];

            var timesInput = currentShowtime.querySelector('input[type="hidden"]');
            timesInput.value = popupTimes.join(',');

            closePopup(index);
        }
    </script>
</body>
</html>
