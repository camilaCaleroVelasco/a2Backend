<?php
    session_start();
    
    require_once "functions/checkIfAdminFunction.php"; 
    require_once "functions/addShowtimesFunctions.php";
    // Checks if user is admin
    checkIfAdmin();
    $details = getMovieDetailsShowtime($conn);
    $result = $details['movieInfo'];
    $rooms = getRooms($conn);
    $showTimes = getShowTimes($conn);

    

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
                <select id="popupTime_<?php echo $i; ?>_1" required>
                    <option value="" selected disabled>Select Time</option>
                    <?php foreach ($showTimes as $times): ?>
                        <?php foreach ($times as $time): ?>
                            <option value="<?php echo htmlspecialchars($time); ?>">
                                <?php echo htmlspecialchars($time); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                    
                </select>

                <select id="popupTime_<?php echo $i; ?>_2" required>
                    <option value="" selected disabled>Select Time</option>
                    <?php foreach ($showTimes as $times): ?>
                        <?php foreach ($times as $time): ?>
                            <option value="<?php echo htmlspecialchars($time); ?>">
                                <?php echo htmlspecialchars($time); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </select>

                <select id="popupTime_<?php echo $i; ?>_3" required>
                    <option value="" selected disabled>Select Time</option>
                    <?php foreach ($showTimes as $times): ?>
                        <?php foreach ($times as $time): ?>
                            <option value="<?php echo htmlspecialchars($time); ?>">
                                <?php echo htmlspecialchars($time); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </select>

                <select id="popupTime_<?php echo $i; ?>_4" required>
                    <option value="" selected disabled>Select Time</option>
                    <?php foreach ($showTimes as $times): ?>
                        <?php foreach ($times as $time): ?>
                            <option value="<?php echo htmlspecialchars($time); ?>">
                                <?php echo htmlspecialchars($time); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </select>
            
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

                    <select name="room_id[]" onchange="selectRoom(<?php echo $i; ?>)">
                        <option value="" selected disabled> Select Room </option>
                        <?php foreach($rooms as $room): ?>
                            <option value="<?php echo htmlspecialchars($room['room_id']); ?>">
                                <?php echo htmlspecialchars($room['roomTitle']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                </div>
            <?php endfor; ?>
            <!-- Dropdown to choose room -->
            
        </div>

        <!-- Save button -->
        <button id="submit" type="submit" name="submit">Save Showtimes</button>

    </form>

    <!-- Display overlaps -->
    <?php if (!empty($overlaps)): ?>
        <div id="overlapsContainer">
            <h3>Overlapping Showtimes:</h3>
            <ul>
                <?php foreach($overlaps as $overlap): ?>
                    <li><?php echo $overlap; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

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
                document.getElementById('popupTime_' + index + '_1').value,
                document.getElementById('popupTime_' + index + '_2').value,
                document.getElementById('popupTime_' + index + '_3').value,
                document.getElementById('popupTime_' + index + '_4').value
            ];
            
            var timesInput = currentShowtime.querySelector('input[type="hidden"]');
            timesInput.value = popupTimes.join(',');

            closePopup(index);
        }

        function selectRoom(index) {
            selectedRooms[index] = currentShowtime.querySelector('select[name="room_id[]"]').value;

        }


    </script>
</body>
</html>
