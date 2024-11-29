<?php
session_start();
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "root", "", "cabpoolproject");

$response = ["success" => false, "message" => ""];

if ($conn->connect_error) {
    $response["message"] = "Connection failed: " . $conn->connect_error;
} else {
    // Check if the user is logged in and required data is provided
    if (isset($_SESSION['username']) && isset($_POST['ride_id']) && isset($_POST['rating'])) {
        $username = $_SESSION['username']; // Current user
        $rideId = intval($_POST['ride_id']); // Ride ID
        $rating = floatval($_POST['rating']); // Rating value

        // Validate that the user is part of the ride
        $bookingQuery = "SELECT bookings.id, rides.owner_name 
                         FROM bookings 
                         INNER JOIN rides ON bookings.ride_id = rides.id 
                         WHERE bookings.ride_id = $rideId AND bookings.user_name = '$username'";
        $bookingResult = $conn->query($bookingQuery);

        if ($bookingResult && $bookingResult->num_rows > 0) {
            $booking = $bookingResult->fetch_assoc();
            $owner = $booking['owner_name'];

            // Update the rating in the `user_info` table for the owner
            $updateOwnerQuery = "UPDATE user_info 
                                 SET rating = rating + $rating, number_of_ratings = number_of_ratings + 1
                                 WHERE username = '$owner'";
            if ($conn->query($updateOwnerQuery) === TRUE) {
                // Update the `rated` column and store the rating in the `bookings` table
                $updateBookingQuery = "UPDATE bookings 
                                       SET rated = 1, rating = $rating 
                                       WHERE ride_id = $rideId AND user_name = '$username'";
                if ($conn->query($updateBookingQuery) === TRUE) {
                    $response["success"] = true;
                    $response["message"] = "Rating submitted successfully!";
                } else {
                    $response["message"] = "Error updating booking rating: " . $conn->error;
                }
            } else {
                $response["message"] = "Error updating owner rating: " . $conn->error;
            }
        } else {
            $response["message"] = "No matching booking found or user not part of the ride.";
        }
    } else {
        $response["message"] = "Invalid request. Please provide ride ID and rating.";
    }
    $conn->close();
}

echo json_encode($response);
exit;
