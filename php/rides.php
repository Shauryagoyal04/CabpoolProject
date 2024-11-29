<?php
session_start();
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "root", "", "cabpoolproject");

$response = ["success" => false, "rides" => []];

// Check database connection
if ($conn->connect_error) {
    $response["message"] = "Connection failed: " . $conn->connect_error;
} else {
    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];  // Get the logged-in username

        // Fetch rides created by the logged-in user
        $sql = "SELECT rides.id, rides.leaving_from, rides.going_to, rides.ride_time, rides.seats_available, 
                       rides.owner_name, GROUP_CONCAT(bookings.user_name SEPARATOR ', ') AS riders
                FROM rides
                LEFT JOIN bookings ON rides.id = bookings.ride_id
                WHERE rides.owner_name = ?
                GROUP BY rides.id
                ORDER BY rides.ride_time DESC";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            // Determine if the ride is completed or upcoming
            $ride_status = (strtotime($row["ride_time"]) < time()) ? "Completed" : "Upcoming";
            $row["ride_status"] = $ride_status;

            $response["rides"][] = $row;
        }

        $response["success"] = true;
        $stmt->close();
    } else {
        $response["message"] = "User not logged in.";
    }

    $conn->close();
}

echo json_encode($response);
exit;
