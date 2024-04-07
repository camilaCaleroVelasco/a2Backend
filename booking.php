<?php

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["movie_id"])) {

    $movie_id = $_GET["movie_id"];
        require_once "includes/dbh.inc.php";

        $sql = "SELECT * FROM movies WHERE movie_id = ?";

        
        $stmt = mysqli_stmt_init($conn);

        if(!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: booking.php?error=stmtfailed"); 
            exit();
        }

        mysqli_stmt_bind_param($stmt, "i", $movie_id);
        mysqli_stmt_execute($stmt);

        $resultData = mysqli_stmt_get_result($stmt); // Fetch single movie

        
        $movie = mysqli_fetch_assoc($resultData);

        if (!$movie) { // Check if movie found
            echo "<p>Movie not found.</p>";
        }

} else {
    header("Location: index.php"); // Redirect if no movie ID
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA Compatible" content="IE=edge">
  <title>Ticket Booking</title>
  <!--Google Fonts and Icons-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Round|Material+Icons+Sharp|Material+Icons+Two+Tone" rel="stylesheet" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/booking.css">

</head>
<body>
  <div class="center">
    <div class="tickets">
      <div class="ticket-selector">
        <div class="head">
          <div class="title"> <?php echo $movie['movie_title']; echo "</div>"; ?>
        </div>
        <div class="seats">
          <div class="status">
            <div class="item">Available</div>
            <div class="item">Booked</div>
            <div class="item">Selected</div>
          </div>
          <div class="all-seats">
            <input type="checkbox" name="tickets" id="s1" />
          </div>
        </div>
        <div class="timings">
          <div class="dates">
            <input type="radio" name="date" id="d1" checked />
            <label for="d1" class="dates-item">
              <div class="day">Fri</div>
              <div class="date">1</div>
            </label>
            <input type="radio" id="d2" name="date" />
            <label class="dates-item" for="d2">
              <div class="day">Sat</div>
              <div class="date">2</div>
            </label>
            <input type="radio" id="d3" name="date" />
            <label class="dates-item" for="d3">
              <div class="day">Sun</div>
              <div class="date">3</div>
            </label>
            <input type="radio" id="d4" name="date" />
            <label class="dates-item" for="d4">
              <div class="day">Mon</div>
              <div class="date">4</div>
            </label>
            <input type="radio" id="d5" name="date" />
            <label class="dates-item" for="d5">
              <div class="day">Tue</div>
              <div class="date">5</div>
            </label>
            <input type="radio" id="d6" name="date" />
            <label class="dates-item" for="d6">
              <div class="day">Wed</div>
              <div class="date">6</div>
            </label>
            <input type="radio" id="d7" name="date" />
            <label class="dates-item" for="d7">
              <div class="day">Thu</div>
              <div class="date">7</div>
            </label>
          </div>
          <div class="times">
              <input type="radio" name="time" id="t1" checked />
              <label for="t1" class="time">11:00</label>
              <input type="radio" id="t2" name="time" />
              <label for="t2" class="time"> 2:00 </label>
              <input type="radio" id="t3" name="time" />
              <label for="t3" class="time"> 4:30 </label>
              <input type="radio" id="t4" name="time" />
              <label for="t4" class="time"> 6:30 </label>
              <input type="radio" id="t5" name="time" />
              <label for="t5" class="time"> 8:00 </label>
              <input type="radio" id="t6" name="time" />
              <label for="t6" class="time"> 10:30 </label>
          </div>
          <br>
          <br>
          <div class="ticket-types">
  <div class="type">
    <span>Adult ($15)</span>
    <button class="minus" data-type="adult">-</button>
    <span  data-type="adult">0</span>
    <button class="plus" data-type="adult">+</button>
  </div>
  <div class="type">
    <span>Child ($10)</span>
    <button class="minus" data-type="child">-</button>
    <span  data-type="child">0</span>
    <button class="plus" data-type="child">+</button>
  </div>
  <div class="type">
    <span>Senior ($12) </span>
    <button class="minus" data-type="senior">-</button>
    <span data-type="senior">0</span>
    <button class="plus" data-type="senior">+</button>
  </div>
</div>

      </div>

      <div class="price">
        <div class="total">
          <span><span class="count">0</span> Tickets</span>
        </div>
        <button id="bookButton" type="button">Continue</button>
      </div>
    </div>

    
  </div>
 <script>
 document.addEventListener("DOMContentLoaded", function () {
    // Function to update individual ticket count
    function updateTicketCount(type, count) {
        let countElement = document.querySelector(`span[data-type='${type}']`);
        countElement.textContent = count;
    }

    // Function to update total ticket count
    function updateTotalTicketCount() {
        let totalTickets = 0;
        document.querySelectorAll("input[name='tickets']:checked").forEach((checkbox) => {
            totalTickets++;
        });
        document.querySelector(".count").textContent = totalTickets;
        return totalTickets;
    }

    // Function to enable/disable plus buttons based on total ticket count
    function updatePlusButtonsState(totalTickets) {
        let plusButtons = document.querySelectorAll(".plus");
        plusButtons.forEach((button) => {
            let type = button.dataset.type;
            let count = parseInt(document.querySelector(`span[data-type='${type}']`).textContent);
            if (count >= totalTickets) {
                button.disabled = true;
            } else {
                button.disabled = false;
            }
        });
    }

    // Event listener for plus and minus buttons
    document.querySelectorAll(".plus").forEach(button => {
        button.addEventListener("click", function () {
            let type = this.dataset.type;
            let increment = 1;
            let countElement = document.querySelector(`span[data-type='${type}']`);
            let currentCount = parseInt(countElement.textContent);
            let newCount = currentCount + increment;
            if (newCount >= 0) {
                countElement.textContent = newCount;
                let totalTickets = updateTotalTicketCount();
                updatePlusButtonsState(totalTickets);
            }
        });
    });

    // Event listener for minus buttons
document.querySelectorAll(".minus").forEach(button => {
    button.addEventListener("click", function () {
        let type = this.dataset.type;
        let decrement = 1; // You can adjust this if you want to decrement by a different value
        let countElement = document.querySelector(`span[data-type='${type}']`);
        let currentCount = parseInt(countElement.textContent);
        let newCount = currentCount - decrement; // Subtract the decrement value
        if (newCount >= 0) { // Make sure count doesn't go negative
            countElement.textContent = newCount;
            let totalTickets = updateTotalTicketCount();
            updatePlusButtonsState(totalTickets); // Update the plus buttons state
        }
    });
});

    // Generate seat checkboxes
    let seats = document.querySelector(".all-seats");
    let rowLetters = ['A', 'B', 'C', 'D', 'E', 'F']; // Letters for rows
    for (let row = 0; row < rowLetters.length; row++) {
        for (let col = 1; col <= 10; col++) { // Assuming 10 columns
            let seatNumber = rowLetters[row] + col; // Generating seat number
            let randint = Math.floor(Math.random() * 2);
            let booked = randint === 1 ? "booked" : "";
            seats.insertAdjacentHTML(
                "beforeend",
                `<input type="checkbox" name="tickets" id="s${seatNumber}" />
                <label for="s${seatNumber}" class="seat ${booked}">${seatNumber}</label>`
            );
        }
    }

    // Add event listener to the "Book" button
    document.getElementById("bookButton").addEventListener("click", function () {
        <?php
        echo "window.location.href = 'ordersummary.php?movie_id=" . $movie["movie_id"] . "'";
        ?>
    });

    // Disable booked seats
    let bookedSeats = document.querySelectorAll('.seat.booked');
    bookedSeats.forEach(seat => {
        let checkbox = seat.previousElementSibling;
        checkbox.disabled = true;
    });

    // Handle ticket selection
    let tickets = seats.querySelectorAll("input");
    tickets.forEach((ticket) => {
        ticket.addEventListener("change", () => {
            let totalTickets = updateTotalTicketCount();
            updatePlusButtonsState(totalTickets);
        });
    });

    // Initialize plus buttons state
    let totalTickets = updateTotalTicketCount();
    updatePlusButtonsState(totalTickets);

});

</script>

</body>
</html>