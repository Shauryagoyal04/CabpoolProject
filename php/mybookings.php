<?php
session_start();
header('Content-Type: application/json');
date_default_timezone_set('Asia/Kolkata');

// Database connection
$conn = new mysqli("localhost", "root", "", "cabpoolproject");

$response = ["success" => false, "bookings" => []];

// Check database connection
if ($conn->connect_error) {
    $response["message"] = "Connection failed: " . $conn->connect_error;
} else {
    // Check if the user is logged in
    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];  // Get the logged-in username

        // Fetch rides booked by the user
        $sql = "SELECT rides.id, rides.leaving_from, rides.going_to, rides.ride_time, rides.owner_name, 
                       rides.seats_available, bookings.status, bookings.rated, bookings.rating 
                FROM rides
                INNER JOIN bookings ON rides.id = bookings.ride_id
                WHERE bookings.user_name = '$username'
                ORDER BY rides.ride_time DESC";

        $result = $conn->query($sql);

        // Check if query was successful
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                // Determine if the ride is completed or upcoming
                $rideTime = strtotime($row["ride_time"]);
                $currentTime = time();

                if ($rideTime < $currentTime && $row["status"] !== "completed") {
                    // Update status in the database if not already completed
                    $updateStatusQuery = "UPDATE rides SET status = 'completed' WHERE id = " . $row["id"];
                    $conn->query($updateStatusQuery);
                    $row["status"] = "completed";
                } else {
                    $row["status"] = "upcoming";
                }

                // Add ride information to response
                $response["bookings"][] = $row;
            }
            $response["success"] = true;
        } else {
            $response["message"] = "Error fetching bookings: " . $conn->error;
        }
    } else {
        $response["message"] = "User not logged in.";
    }

    $conn->close();
}

echo json_encode($response);
exit;
