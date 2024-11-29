<?php
session_start();
header('Content-Type: application/json');

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$conn = new mysqli("localhost", "root", "", "cabpoolproject");

$response = ["success" => false, "message" => ""];

if ($conn->connect_error) {
    $response["message"] = "Connection failed: " . $conn->connect_error;
} else {
    // Check if the user is logged in
    if (isset($_SESSION['username']) && isset($_POST['ride_id']) && isset($_POST['rating'])) {
        $username = $_SESSION['username']; // Current user
        $rideId = intval($_POST['ride_id']); // Ride ID
        $rating = floatval($_POST['rating']); // Rating value

        // Fetch the owner of the ride
        $ownerQuery = "SELECT owner_name FROM rides WHERE id = $rideId";
        $ownerResult = $conn->query($ownerQuery);

        if ($ownerResult && $ownerResult->num_rows > 0) {
            $owner = $ownerResult->fetch_assoc()['owner_name'];

            // Update the user's rating in user_info table
            $updateQuery = "UPDATE user_info 
                            SET rating = rating + $rating, number_of_ratings = number_of_ratings + 1
                            WHERE username = '$owner'";
            if ($conn->query($updateQuery) === TRUE) {
                $response["success"] = true;
                $response["message"] = "Rating submitted successfully!";
            } else {
                $response["message"] = "Error updating rating: " . $conn->error;
            }
        } else {
            $response["message"] = "Ride owner not found.";
        }
    } else {
        $response["message"] = "Invalid request. Please provide ride ID and rating.";
    }

    $conn->close();
}

echo json_encode($response);
exit;
