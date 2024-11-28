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
}
  // Open the modal when Create Ride button is clicked
  document.getElementById("createRideBtn").addEventListener("click", openModal);

  
