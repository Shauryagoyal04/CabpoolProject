<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("Location: index.php"); // Redirect to login if not set
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cab Sharing Navbar</title>
  <link rel="stylesheet" href="style/main.css">
</head>
<body>

  <?php
  if (isset($_GET['message'])) {
    echo "<div class='joinride-message-box'>" . htmlspecialchars($_GET['message']) . "</div>";
  }
  ?>

  <!-- Success/Error Message Box -->
  <div id="messageBox" class="message-box">
    <span id="messageText"></span>
    <span class="close-message-btn" onclick="closeMessageBox()">&times;</span>
  </div>
  <!-- Navbar -->
  <div class="navbar">
    <!-- Logo on Left -->
    <div class="logo">
      <a href="#" style="color: white; text-decoration: none;">MyLogo</a>
    </div>

    <!-- Right Side: Create Ride Button and Dropdown Menu -->
    <div class="navbar-right">
      <!-- Create Ride Button -->
      <button id="createRideBtn" class="create-ride-btn">Create Ride</button>

      <!-- Dropdown Menu -->
      <div class="dropdown">
        <a href="#" style="color: white; text-decoration: none;">Menu</a>
        <div class="dropdown-content">
          <a href="#">Profile</a>
          <a href="#">My Bookings</a>
          <a href="#">My Rides</a>
          <a href="#">History</a>
        </div>
      </div>
    </div>
  </div>
  <!-- Create Ride Modal -->
<div id="createRideModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <h2>Create a New Ride</h2>
    <form id="rideForm">
      <label for="leaving_from">Leaving From:</label>
      <input type="text" name="leaving_from" id="leaving_from" required>

      <label for="going_to">Going To:</label>
      <input type="text" name="going_to" id="going_to" required>

      <label for="ride_time">Date and Time:</label>
      <input type="datetime-local" name="ride_time" id="ride_time" required>

      <label for="seats_available">Seats Available:</label>
      <input type="number" name="seats_available" id="seats_available" required min="1">

      <button type="button" onclick="submitRideForm()">Submit</button>
    </form>
  </div>
</div>


  <!-- Main Content -->
  <div class="search-bar">
   <input type="text" name="leaving_from" placeholder="Leaving From" />
   <input type="text" name="going_to" placeholder="Going To" />
   <input type="date" name="ride_date" placeholder="Date" />
   <select name="passengers">
     <option value="">Passengers</option>
     <option value="1">1</option>
     <option value="2">2</option>
   </select>
</div>

<!-- Search Button -->
<button class="search-btn" id="search-btn">Search</button>

<div id="rides-container"></div>

 <!-- Upcoming Rides Section -->
 <div class="ride-list">
  <?php
  
  // $username = $_SESSION['username']; // Fetch the logged-in user's name

  $conn = new mysqli("localhost", "root", "", "cabpoolproject");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT id, leaving_from, going_to, owner_name, ride_time, seats_available, rider1_name, rider2_name FROM rides WHERE ride_time >= NOW() AND seats_available>0 ORDER BY ride_time ASC";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      echo "<div class='upcoming-rides-heading'>UPCOMING RIDES</div>";
    while ($row = $result->fetch_assoc()) {
      echo "<div class='ride-card' id='ride-card'>";
      echo "<div class='ride-info'>";
      echo "<span><strong>From:</strong> " . $row["leaving_from"] . "</span>";
      echo "<span><strong>To:</strong> " . $row["going_to"] . "</span>";
      echo "<span class='ride-owner'>Driver: " . $row["owner_name"] . "</span>";
      echo "<span><strong>Time:</strong> " . $row["ride_time"] . "</span>";
      echo "<span><strong>Seats Available:</strong> " . $row["seats_available"] . "</span>";
      echo "</div>";
      
      // Join button form
      
      echo "<form>";
      echo "<input type='hidden' name='ride_id' value='" . $row["id"] . "'>";
      echo "<button type='button' class='join-btn' data-ride-id='" . $row["id"] . "' onclick='confirmJoinRide(this)'>Join Ride</button>";
      echo "</form>";



      echo "</div>";
    }
  } else {
    echo "<p>No upcoming rides available.</p>";
  }

  $conn->close();
  ?>

  </div>
  <script src="javascript/main.js"></script>
</body>
</html>
