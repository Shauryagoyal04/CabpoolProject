<?php
session_start();
$username = $_SESSION['username']; // The logged-in user’s name
$ride_id = $_POST['ride_id'];

$conn = new mysqli("localhost", "root", "", "cabpoolproject");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the user can be added to the ride
$sql = "SELECT rider1_name, rider2_name, seats_available FROM rides WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $ride_id);
$stmt->execute();
$stmt->bind_result($rider1, $rider2, $seats_available);
$stmt->fetch();
$stmt->close();

if ($seats_available > 0) {
  if (empty($rider1)) {
    // Assign user to rider1_name
    $update_sql = "UPDATE rides SET rider1_name = ?, seats_available = seats_available - 1 WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $username, $ride_id);
  } elseif (empty($rider2)) {
    // Assign user to rider2_name
    $update_sql = "UPDATE rides SET rider2_name = ?, seats_available = seats_available - 1 WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $username, $ride_id);
  } else {
    // Ride is already full
    header("Location: ./main.php?message=Ride is full");
    exit();
  }
  
  // Execute the update query
  if ($stmt->execute()) {
    header("Location: main.php?message=Successfully joined the ride");
  } else {
    header("Location: main.php?message=Error joining ride");
  }
  $stmt->close();
} else {
  header("Location: main.php?message=Ride is full");
}

$conn->close();
?>
