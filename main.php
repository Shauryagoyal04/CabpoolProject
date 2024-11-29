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
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

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
   <!-- Navbar -->
   <div class="navbar">
    <!-- Logo on Left -->
    <div class="logo">
      <a href="#" style="color: white; text-decoration: none;">RideShare</a>
    </div>

    <!-- Right Side: Options -->
    <div class="navbar-right">
      <a href="bookings.php" class="nav-link">My Bookings</a>
      <a href="myrides.php" class="nav-link">My Rides</a>
      <a href="#" class="nav-link">Profile</a>
    </div>
  </div>
  <!-- Create Ride Modal -->
<div id="createRideModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" onclick="closeModal()">&times;</span>
    <header>Create a New Ride</header>
    <form id="rideForm">
      <div class="field input">
      <input type="text" name="leaving_from" id="leaving_from" placeholder="Leaving from" required>
      </div>
      <div class="field input">
      <input type="text" name="going_to" id="going_to" placeholder="Going to" required>
      </div>
      <div class="field input">
      <input type="datetime-local" name="ride_time" id="ride_time" placeholder="Date and time" required>
      </div>
      <div class="field input">
      <input type="number" name="seats_available" id="seats_available" placeholder="Seats Available" required min="1">
      </div>
      <button type="button" class= "btn"onclick="submitRideForm()">Submit</button>
    </form>
  </div>
</div>


<div class="main-content">
  <div class="search-bar">
    <input type="text" name="leaving_from" class="leaving" placeholder="Leaving From" />
    <input type="text" name="going_to" placeholder="Going To" />
    <input type="datetime-local" name="ride_date" placeholder="Date" />
    <select name="passengers">
      <option value="">Passengers</option>
      <option value="1">1</option>
      <option value="2">2</option>
    </select>
    <button class="search-btn">Search</button>
  </div>
  <div class="buttons-container">
    
    <button  id="createRideBtn" class="create-ride-btn">Create Ride</button>
  </div>
</div>


<div id="rides-container"></div>
    <div class='upcoming-rides-heading'>Upcoming Rides</div>
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
      
    while ($row = $result->fetch_assoc()) {
      echo "<div class='ride-card' id='ride-card'>";
      echo "<div class='ride-info'>";
      echo "<span><strong>From:</strong> " . $row["leaving_from"] . "</span>";
      echo "<span><strong>To:</strong> " . $row["going_to"] . "</span>";
      echo "<span class='ride-owner'>Owner: " . $row["owner_name"] . "</span>";
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
