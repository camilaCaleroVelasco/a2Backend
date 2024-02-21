document.addEventListener("DOMContentLoaded", function () {
  // Retrieve ticket details from localStorage
  let ticketDetails = JSON.parse(localStorage.getItem("ticketDetails"));

  // Update ticket details on the page
  if (ticketDetails) {
    let ticketDetailsContainer = document.querySelector(".ticket-details");
    ticketDetailsContainer.innerHTML = "";

    ticketDetails.forEach(function (ticket) {
      let ticketElement = document.createElement("div");
      ticketElement.classList.add("ticket");
      ticketElement.innerHTML = `
        <div>Movie: ${ticket.movie}</div>
        <div>Date: ${ticket.date}</div>
        <div>Time: ${ticket.time}</div>
        <div>Seat: ${ticket.seat}</div>
        <hr>
      `;
      ticketDetailsContainer.appendChild(ticketElement);
    });
  }

  // Update total ticket count and price
  updateTotal();

  // Add event listener to the "Update Order" button
  document.querySelector(".update-order").addEventListener("click", function () {
    // Redirect back to the booking page
    window.location.href = "booking.php";
  });

  // Add event listener to the "Delete Ticket" button
  document.querySelector(".delete-ticket").addEventListener("click", function () {
    // Clear ticket details from localStorage
    localStorage.removeItem("ticketDetails");
    // Refresh the page to reflect changes
    window.location.reload();
  });

  // Function to update total ticket count and price
  function updateTotal() {
    let ticketCount = document.querySelectorAll(".ticket").length;
    let totalPrice = ticketCount * 200; // Assuming each ticket costs $200

    document.querySelector(".total-count").textContent = ticketCount;
    document.querySelector(".total-price").textContent = totalPrice;
  }
});