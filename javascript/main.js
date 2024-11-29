// Function to submit the form data using AJAX
function submitRideForm() {
    const form = document.getElementById('rideForm');
    const formData = new FormData(form);
  
    fetch('php/insert_ride.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      showMessageBox(data.message, data.success);
      if (data.success) {
        form.reset();
        closeModal();
      }
    })
    .catch(error => {
      showMessageBox("An error occurred. Please try again.", false);
    });
  }
  
  // Function to show the message box
  function showMessageBox(message, isSuccess) {
    const messageBox = document.getElementById("messageBox");
    const messageText = document.getElementById("messageText");
  
    messageText.textContent = message;
    messageBox.style.display = "block";
    messageBox.classList.toggle("error", !isSuccess);
    // Automatically hide the message box after 3 seconds (3000 ms)
  setTimeout(() => {
    messageBox.style.display = "none";
  }, 3000);
  }
  
  // Function to close the message box
  function closeMessageBox() {
    document.getElementById("messageBox").style.display = "none";
  }
  
  // Function to open the create ride modal
  function openModal() {
    document.getElementById("createRideModal").style.display = "flex";
  }
  
  // Function to close the create ride modal
  function closeModal() {
    document.getElementById("createRideModal").style.display = "none";
  }
  // Function to show confirmation pop-up and send request to join a ride
function confirmJoinRide(button) {
  const rideId = button.getAttribute("data-ride-id");

  // Display a confirmation dialog
  const confirmJoin = confirm("Are you sure you want to join this ride?");
  if (confirmJoin) {
      // Send the ride_id to the server via AJAX
      const formData = new FormData();
      formData.append("ride_id", rideId);

      fetch('php/join_ride.php', {
          method: 'POST',
          body: formData,
      })
      .then(response => response.json())
      .then(data => {
          if (data.success) {
              alert(data.message); // Display success message
              location.reload();   // Reload the page to update ride info
          } else {
              alert(data.message); // Display error message
          }
      })
      .catch(error => {
          alert("An error occurred. Please try again.");
          console.error(error);
      });
  }
}document.querySelector(".search-btn").addEventListener("click", function () {
  // Get values from the search bar
  const leavingFrom = document.querySelector('input[placeholder="Leaving From"]').value;
  const goingTo = document.querySelector('input[placeholder="Going To"]').value;
  const rideDate = document.querySelector('input[placeholder="Date"]').value;
  const passengers = document.querySelector('select').value;

  // Prepare request data
  const requestData = {
      leaving_from: leavingFrom,
      going_to: goingTo,
      ride_date: rideDate,
      passengers: passengers,
  };

  // Send a request to the PHP file to fetch the filtered results
  fetch("php/searchrides.php", {
      method: "POST",
      headers: {
          "Content-Type": "application/json",
      },
      body: JSON.stringify(requestData),
  })
  .then((response) => response.json())
  .then((data) => {
      // Log the data to see if it's being fetched correctly
      console.log(data);

      // Display results or an error message
      const resultsContainer = document.querySelector("#rides-container");
      resultsContainer.innerHTML = ""; // Clear previous results

      if (data.success) {
          displaySearchResults(data.rides);
      } else {
          // Display "No rides found" message
          const resultMessage = document.createElement("div");
          resultMessage.classList.add("result-message");
          resultMessage.innerHTML = `<span><strong>No rides found</strong></span>`;
          resultsContainer.appendChild(resultMessage);

          // Show upcoming rides again if no results found
          hideUpcomingRides();
      }
  })
  .catch((error) => {
      console.error("Error:", error);
  });
});

function displaySearchResults(rides) {
  // Clear previous search results
  const resultsContainer = document.querySelector("#rides-container");
  resultsContainer.innerHTML = ""; // Clear the rides-container

  // Hide upcoming rides when showing search results
  hideUpcomingRides();

  // Check if a .ride-list exists; if not, create one
  let rideList = document.querySelector(".ride-list");
  if (!rideList) {
    rideList = document.createElement("div");
    rideList.classList.add("ride-list");
    resultsContainer.appendChild(rideList); // Append the ride-list to the results container
  } else {
    rideList.innerHTML = ""; // Clear existing rides in ride-list
  }

  // Dynamically create and add the ride cards to the ride list
  rides.forEach((ride) => {
    const rideCard = document.createElement("div");
    rideCard.classList.add("ride-card");

    // Ride Info
    const rideInfo = document.createElement("div");
    rideInfo.classList.add("ride-info");

    rideInfo.innerHTML = `
      <span><strong>From:</strong> ${ride.leaving_from}</span>
      <span><strong>To:</strong> ${ride.going_to}</span>
      <span class='ride-owner'>Driver: ${ride.owner_name}</span>
      <span><strong>Time:</strong> ${ride.ride_time}</span>
      <span><strong>Seats Available:</strong> ${ride.seats_available}</span>
    `;

    // Join Ride Form
    const form = document.createElement("form");
    form.innerHTML = `
      <input type='hidden' name='ride_id' value='${ride.id}'>
      <button type='button' class='join-btn' data-ride-id='${ride.id}' onclick='confirmJoinRide(this)'>Join Ride</button>
    `;

    // Append ride info and form to the ride card
    rideCard.appendChild(rideInfo);
    rideCard.appendChild(form);

    // Append the ride card to the ride list
    rideList.appendChild(rideCard);
  });
}


// Function to hide upcoming rides
function hideUpcomingRides() {
  const heading=document.querySelector('.upcoming-rides-heading');
  heading.style.display='none';
  const upcomingRides = document.querySelectorAll('.ride-card');
  upcomingRides.forEach((ride) => {
    ride.style.display = 'none';
  });
}

// Function to show upcoming rides again
function showUpcomingRides() {
  const heading=document.querySelector('.upcoming-rides-heading');
  heading.style.display='block';
  const upcomingRides = document.querySelectorAll('.ride-card');
  upcomingRides.forEach((ride) => {
    ride.style.display = 'block'; // You can adjust this to the appropriate style for showing rides
  });
}


  // Open the modal when Create Ride button is clicked
  document.getElementById("createRideBtn").addEventListener("click", openModal);

  
