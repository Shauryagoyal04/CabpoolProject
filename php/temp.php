<?php
header('Content-Type: application/json');
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "cabpoolproject");

$response = ["success" => false, "message" => ""];

if ($conn->connect_error) {
    $response["message"] = "Connection failed: " . $conn->connect_error;
} else {
    if (isset($_POST['ride_id']) && isset($_SESSION['username'])) {
        $rideId = intval($_POST['ride_id']); // Ensure ride ID is an integer
        $username = $conn->real_escape_string($_SESSION['username']); // Escape username for SQL

        // Fetch the ride details
        $rideQuery = "SELECT rider1_name, rider2_name, seats_available FROM rides WHERE id = $rideId";
        $rideResult = $conn->query($rideQuery);

        if ($rideResult->num_rows > 0) {
            $ride = $rideResult->fetch_assoc();

            // Check if seats are available
            if ($ride['seats_available'] > 0) {
                $updateQuery = "";

                if (empty($ride['rider1_name'])) {
                    // Assign the first rider slot
                    $updateQuery = "UPDATE rides 
                                    SET rider1_name = '$username', seats_available = seats_available - 1 
                                    WHERE id = $rideId";
                } elseif (empty($ride['rider2_name'])) {
                    // Assign the second rider slot
                    $updateQuery = "UPDATE rides 
                                    SET rider2_name = '$username', seats_available = seats_available - 1 
                                    WHERE id = $rideId";
                }

                if (!empty($updateQuery)) {
                    if ($conn->query($updateQuery) === TRUE) {
                        // Insert into bookings table
                        $bookingQuery = "INSERT INTO bookings (username, ride_id, status) 
                                         VALUES ('$username', $rideId, 'Upcoming')";

                        if ($conn->query($bookingQuery) === TRUE) {
                            $response["success"] = true;
                            $response["message"] = "Successfully joined the ride!";
                        } else {
                            $response["message"] = "Error adding booking: " . $conn->error;
                        }
                    } else {
                        $response["message"] = "Error updating ride: " . $conn->error;
                    }
                } else {
                    $response["message"] = "Ride is already full.";
                }
            } else {
                $response["message"] = "No seats available in this ride.";
            }
        } else {
            $response["message"] = "Ride not found.";
        }
    } else {
        $response["message"] = "Invalid request. Please log in or check the ride ID.";
    }

    $conn->close();
}

echo json_encode($response);
exit;
