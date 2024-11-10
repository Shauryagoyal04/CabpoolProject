<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "root", "", "cabpoolproject");

$response = ["success" => false, "message" => ""];

if ($conn->connect_error) {
    $response["message"] = "Connection failed: " . $conn->connect_error;
} else {
    $owner_name = $_POST['owner_name'];
    $enrollment_num = $_POST['enrollment_num'];
    $leaving_from = $_POST['leaving_from'];
    $going_to = $_POST['going_to'];
    $ride_time = $_POST['ride_time'];
    $seats_available = $_POST['seats_available'];

    $sql = "INSERT INTO rides (owner_name, enrollment_num, leaving_from, going_to, ride_time, seats_available) 
            VALUES ('$owner_name', '$enrollment_num', '$leaving_from', '$going_to', '$ride_time', '$seats_available')";

    if ($conn->query($sql) === TRUE) {
        $response["success"] = true;
        $response["message"] = "New ride created successfully!";
    } else {
        $response["message"] = "Error: " . $conn->error;
    }

    $conn->close();
}

echo json_encode($response);
exit;
