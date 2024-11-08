<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cab Sharing Navbar</title>
  <link rel="stylesheet" href="style/main.css">
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <!-- Logo on Left -->
    <div class="logo">
      <a href="#" style="color: white; text-decoration: none;">MyLogo</a>
    </div>

    <!-- Right Side: Create Ride Button and Dropdown Menu -->
    <div class="navbar-right">
      <!-- Create Ride Button -->
      <button class="create-ride-btn">Create Ride</button>

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

  <!-- Main Content -->
  <div class="main-content">
    <!-- Search Bar -->
    <div class="search-bar">
      <input type="text" placeholder="Leaving From">
      <input type="text" placeholder="Going To">
      <input type="date" placeholder="Date">
      <select>
        <option value="">Passengers</option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5+</option>
      </select>
    </div>

    <!-- Search Button -->
    <button class="search-btn">Search</button>
  </div>

 <!-- Upcoming Rides Section -->
 <div class="ride-list">
    <?php
    // PHP to fetch ride data from MySQL and display each ride
    $conn = new mysqli("localhost", "root", "", "cabpoolproject");

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT leaving_from, going_to, owner_name, ride_time, seats_available FROM rides WHERE ride_time >= NOW() ORDER BY ride_time ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo "<div class='ride-card'>";
        echo "<div class='ride-info'>";
        echo "<span><strong>From:</strong> " . $row["leaving_from"] . "</span>";
        echo "<span><strong>To:</strong> " . $row["going_to"] . "</span>";
        echo "<span class='ride-owner'>Driver: " . $row["owner_name"] . "</span>";
        echo "<span><strong>Time:</strong> " . $row["ride_time"] . "</span>";
        echo "<span><strong>Seats Available:</strong> " . $row["seats_available"] . "</span>";
        echo "</div>";
        echo "<button class='join-btn'>Join Ride</button>";
        echo "</div>";
      }
    } else {
      echo "<p>No upcoming rides available.</p>";
    }

    $conn->close();
    ?>
  </div>
</body>
</html>
