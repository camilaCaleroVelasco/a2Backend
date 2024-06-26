<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once "functions/bookingFunctions.php"; 
require_once "Get/bookingGet.php"; 

$movie = getMovieID($conn);
$movie_id = $movie["movie_id"]; 

$dates = getDates($conn, $movie_id);
$times = getTimes($conn, $movie_id);

// Initialize $showTime variable
$showTime = [];

foreach ($dates as $date) {
    $showDate = $date['showDate'];
    $showTime = getShowTimesByMovieIDAndDate($conn, $movie_id, $showDate);
}

// Prepare dates and times data for JavaScript
$datesJson = json_encode($dates);
$timesJson = json_encode($times);

// Initial seat availability data
if (!empty($showTime)) {
    $initialShowID = getShowId($conn, $dates[0]['showDate'], $showTime[0], $movie_id);
    $initialSeatsJson = json_encode(getSeatAvailability($conn, $initialShowID));
} else {
    $initialSeatsJson = json_encode([]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA Compatible" content="IE=edge">
    <title>Ticket Booking</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/booking.css">
</head>
<body>
<header> <a href="index.php"> <img class="logo" src="images/A2 movies Icon.jpeg" alt="logo"> </a> </header>
    <div class="center">
        <div class="tickets">
            <div class="ticket-selector">
                <div class="head">
                    <div class="title"> <?php echo htmlspecialchars($movie['movie_title']); ?> </div>
                </div>
                <div class="seats">
                    <div class="status">
                        <div class="item">Available</div>
                        <div class="item">Booked</div>
                        <div class= "item">Selected</div>
                    </div>
                    <br>
                    <div class="all-seats">
                        <!-- Seats will be dynamically generated by JavaScript -->
                    </div>
                </div>
                <div class="timings">
                    <div class="dates">
                        <?php
                        if (empty($dates)) {
                            echo "<p> Sorry, There are no show times available</p>";
                        } else {
                            foreach ($dates as $date) {
                                echo "<input type='radio' name='date' id='d{$date['day']}' value='{$date['showDate']}' />";
                                echo "<label class='dates-item' for='d{$date['day']}'>";
                                echo "<div class='day'>{$date['dayName']}</div>";
                                echo "<div class='date'>{$date['day']}</div>";
                                echo "</label>";
                            }
                        }
                        ?>
                    </div>
                    <div class="times">
                        <!-- Times will be dynamically generated by JavaScript -->
                    </div>
                    <br>
                    <div class="ticket-types">
                        <!-- Ticket types if any -->
                    </div>
                    <div class="price">
                        <div class="total">
                            <span><span class="count">0</span> Tickets</span>
                        </div>
                        <button id="bookButton" type="button">Continue</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="seatForm" method="POST" action="ageselect.php">
        <input type="hidden" name="movieId" value="<?php echo $movie_id; ?>">
        <input type="hidden" name="selectedSeats" id="selectedSeats">
        <input type="hidden" name="totalTickets" id="totalTicketsForm">
    </form>

    </body>
    
    <script>
document.addEventListener("DOMContentLoaded", function () {
    const movieId = <?php echo $movie_id; ?>;
    const timesData = JSON.parse('<?php echo $timesJson; ?>');
    const initialSeatsData = JSON.parse('<?php echo $initialSeatsJson; ?>');

    // Set up a default "completely booked" seat layout
    const defaultBookedSeatsData = {};
    const numRows = 6;
    const numCols = 8;
    for (let row = 0; row < numRows; row++) {
        const rowLetter = String.fromCharCode(65 + row);
        defaultBookedSeatsData[rowLetter] = {};
        for (let col = 0; col <= numCols; col++) {
            defaultBookedSeatsData[rowLetter][col] = "NO";
        }
    }

    function updateSeatsUI(seatsData) {
        const seats = document.querySelector(".all-seats");
        seats.innerHTML = ""; // Clear existing seats
        for (const row in seatsData) {
            seats.insertAdjacentHTML("beforeend", `<span class="row-letter">${row}</span>`);
            const rowSeats = seatsData[row];
            for (const col in rowSeats) {
                const isAvailable = rowSeats[col];
                const seatId = `s${row}${col}`;
                const booked = isAvailable === "NO" ? "booked" : "";
                seats.insertAdjacentHTML("beforeend", `
                    <input type="checkbox" name="tickets" id="${seatId}" ${booked ? "disabled" : ""}/>
                    <label for="${seatId}" class="seat ${booked}">${col}</label>
                `);
            }
        }
        attachSeatListeners(); // Attach listeners each time seats are updated
    }

    function attachSeatListeners() {
        const tickets = document.querySelectorAll("input[name='tickets']");
        tickets.forEach(ticket => {
            ticket.addEventListener("change", updateTotalTicketCount);
        });
    }

    function updateTotalTicketCount() {
    const selectedTickets = document.querySelectorAll("input[name='tickets']:checked");
    const totalTickets = selectedTickets.length;
    const totalElement = document.querySelector(".count");
    totalElement.textContent = totalTickets;

    const bookButton = document.getElementById("bookButton");
    bookButton.disabled = totalTickets === 0;
    return totalTickets;
}

document.getElementById("bookButton").addEventListener("click", function () {
    fetch('checkLogin.php')
        .then(response => {
            if (!response.ok) {
                window.location.href = 'login.php?error=notLoggedIn';
            } else {
                const totalTickets = updateTotalTicketCount();
                if (totalTickets > 0) {
                    const selectedSeatsInput = document.getElementById("selectedSeats");
                    const totalTicketsInput = document.getElementById("totalTicketsForm");

                    // Gather selected seat IDs
                    const selectedSeats = Array.from(document.querySelectorAll("input[name='tickets']:checked"))
                        .map(input => input.id);
                    selectedSeatsInput.value = selectedSeats.join(',');
                    totalTicketsInput.value = totalTickets;

                    // Submit form
                    document.getElementById("seatForm").submit();
                } else {
                    alert("Please select at least one ticket.");
                }
            }
        });
});

    function updateSeatAvailability(selectedDate, selectedTime) {
    fetch('getSeatAvailability.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            date: selectedDate,
            time: selectedTime,
            movie_id: movieId,
        }),
    })
    .then(response => response.json())
    .then(seatsData => {
        updateSeatsUI(seatsData); // Update the seat display based on the fetched data
    })
    .catch(error => {
        console.error('Error fetching seat availability:', error);
        updateSeatsUI(defaultBookedSeatsData); // Fallback to the default "all booked" layout
    });
}

document.addEventListener("change", function(event) {
    if (event.target && event.target.matches("input[name='date']")) {
        const selectedDate = event.target.value;
        const availableTimes = timesData[selectedDate] || [];
        const timesContainer = document.querySelector(".times");
        timesContainer.innerHTML = ""; // Clear existing times

        if (availableTimes.length > 0) {
            availableTimes.forEach(time => {
                const timeId = `time-${selectedDate}-${time}`;
                timesContainer.insertAdjacentHTML("beforeend", `
                    <input type='radio' name='time' id='${timeId}' value='${time}' />
                    <label for='${timeId}' class='time'>${time}</label>
                `);
            });
        } else {
            timesContainer.innerHTML = "<p>No available times for this date.</p>";
        }
        updateSeatsUI(defaultBookedSeatsData); // Reset seats until a time is selected
    }

    if (event.target && event.target.matches("input[name='time']")) {
        const selectedDate = document.querySelector("input[name='date']:checked")?.value;
        const selectedTime = event.target.value;
        if (selectedDate && selectedTime) {
            updateSeatAvailability(selectedDate, selectedTime);
        } else {
            updateSeatsUI(defaultBookedSeatsData);
        }
    }
});

    function initializePage() {
        updateSeatsUI(defaultBookedSeatsData); // Start with all seats as booked
    }

    initializePage(); // Call initializePage to set up the page initially
});
</script>


</html>
