<?php
session_start();
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "root", "", "cabpoolproject");

$response = ["success" => false, "message" => ""];

// Check database connection
if ($conn->connect_error) {
    $response["message"] = "Connection failed: " . $conn->connect_error;
} else {
    // Fetch ride details from POST request
    $leaving_from = $_POST['leaving_from'];
    $going_to = $_POST['going_to'];
    $ride_time = $_POST['ride_time'];
    $seats_available = $_POST['seats_available'];

    // Fetch logged-in user's username from the session
    if (isset($_SESSION['username'])) {
        $ownername = $_SESSION['username'];

        // Insert ride details into the database
        $sql = "INSERT INTO rides (leaving_from, going_to, ride_time, seats_available, owner_name) 
                VALUES ('$leaving_from', '$going_to', '$ride_time', '$seats_available', '$ownername')";

        if ($conn->query($sql) === TRUE) {
            $response["success"] = true;
            $response["message"] = "New ride created successfully!";
        } else {
            $response["message"] = "Error: " . $conn->error;
        }
    } else {
        $response["message"] = "User not logged in. Please log in to create a ride.";
    }

    $conn->close();
}

// Return response as JSON
echo json_encode($response);
exit;
