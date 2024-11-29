document.addEventListener("DOMContentLoaded", function () {
    fetch("php/mybookings.php")
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                displayMyBookings(data.bookings);
            } else {
                console.error(data.message);
                document.querySelector("#bookings-container").innerHTML = "<p>No bookings found.</p>";
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
});
function displayMyBookings(bookings) {
    const container = document.querySelector("#bookings-container");
    container.innerHTML = ""; // Clear previous content

    bookings.forEach((booking) => {
        const rideCard = document.createElement("div");
        rideCard.classList.add("ride-card");

        // Determine the class for ride status
        const statusClass = booking.status === "upcoming" ? "upcoming" : "completed";

        // Build the card HTML structure
        rideCard.innerHTML = `
            <div class="ride-info">
                <span><strong>From:</strong> ${booking.leaving_from}</span>
                <span><strong>To:</strong> ${booking.going_to}</span>
                <span><strong>Owner:</strong> ${booking.owner_name}</span>
                <span><strong>Time:</strong> ${booking.ride_time}</span>
                <span><strong>Seats Available:</strong> ${booking.seats_available}</span>
                <span class="ride-status ${statusClass}">${booking.status}</span>
            </div>
        `;

        // Add the rating section only for completed rides
        if (booking.status === "completed") {
            if (booking.rated === 1) {
                // If the user has already rated, display the rating
                rideCard.innerHTML += `
                    <div class="rating-section">
                        <span><strong>Your Rating:</strong> ${booking.rating}</span>
                    </div>
                `;
            } else {
                // If not rated, show the rating form
                rideCard.innerHTML += `
                    <div class="rating-section">
                        <h4>Rate the Owner</h4>
                        <form>
                            <label>
                                <input type="radio" name="rating_${booking.id}" value="1"> 1
                            </label>
                            <label>
                                <input type="radio" name="rating_${booking.id}" value="2"> 2
                            </label>
                            <label>
                                <input type="radio" name="rating_${booking.id}" value="3"> 3
                            </label>
                            <label>
                                <input type="radio" name="rating_${booking.id}" value="4"> 4
                            </label>
                            <label>
                                <input type="radio" name="rating_${booking.id}" value="5"> 5
                            </label>
                            <button type="button" class="btn" onclick="submitRating(${booking.id}, this)">Submit Rating</button>
                        </form>
                    </div>
                `;
            }
        }

        container.appendChild(rideCard);
    });
}



function submitRating(rideId) {
    const ratingElement = document.querySelector(`input[name="rating_${rideId}"]:checked`);
    if (ratingElement) {
        const selectedRating = ratingElement.value;

        // Send the rating to the server using a POST request
        fetch('php/rate-owner.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `rating=${selectedRating}&ride_id=${rideId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Replace the rating form with the submitted rating
                const ratingSection = ratingElement.closest(".rating-section");
                ratingSection.innerHTML = `
                    <span><strong>Your Rating:</strong> ${selectedRating}</span>
                `;
                alert("Rating submitted successfully!");
            } else {
                alert(data.message);  // Show error message from server
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while submitting the rating.");
        });
    } else {
        alert("Please select a rating.");
    }
}



