document.addEventListener("DOMContentLoaded", function () {
    fetch("php/rides.php")
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                displayMyRides(data.rides);
            } else {
                console.error(data.message);
                document.querySelector("#rides-container").innerHTML = "<p>No rides found.</p>";
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
});

function displayMyRides(rides) {
    const container = document.querySelector("#rides-container");
    container.innerHTML = ""; // Clear previous content

    rides.forEach((ride) => {
        const rideCard = document.createElement("div");
        rideCard.classList.add("ride-card");

        // Determine the class for ride status
        const statusClass = ride.ride_status === "Upcoming" ? "upcoming" : "completed";

        // Build the card HTML structure
        rideCard.innerHTML = `
            <div class="ride-info">
                <span><strong>From:</strong> ${ride.leaving_from}</span>
                <span><strong>To:</strong> ${ride.going_to}</span>
                <span><strong>Time:</strong> ${ride.ride_time}</span>
                <span><strong>Seats Available:</strong> ${ride.seats_available}</span>
                <span><strong>Riders:</strong> ${ride.riders || "No riders yet"}</span>
                <span class="ride-status ${statusClass}">${ride.ride_status}</span>
            </div>
        `;

        container.appendChild(rideCard);
    });
}
