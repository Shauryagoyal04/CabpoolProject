<?php
header('Content-Type: application/json');
$conn = new mysqli("localhost", "root", "", "cabpoolproject");

$response = ["success" => false, "message" => "", "rides" => []];

// Check connection
if ($conn->connect_error) {
    $response["message"] = "Connection failed: " . $conn->connect_error;
    echo json_encode($response);
    exit;
}

// Get data from the POST request
$data = json_decode(file_get_contents("php://input"), true);

$leavingFrom = $data['leaving_from'] ?? '';
$goingTo = $data['going_to'] ?? '';
$rideDate = $data['ride_date'] ?? '';
$passengers = $data['passengers'] ?? '';

// Prepare SQL query
$sql = "SELECT id, leaving_from, going_to, owner_name, ride_time, seats_available, rider1_name, rider2_name FROM rides WHERE ride_time >= NOW() AND seats_available > 0";

if (!empty($leavingFrom)) {
    $sql .= " AND leaving_from LIKE '%$leavingFrom%'";
}
if (!empty($goingTo)) {
    $sql .= " AND going_to LIKE '%$goingTo%'";
}
if (!empty($rideDate)) {
    $sql .= " AND DATE(ride_time) = '$rideDate'";
}
if (!empty($passengers)) {
    // Assuming "passengers" refers to the available seats
    $sql .= " AND seats_available >= $passengers";
}

$sql .= " ORDER BY ride_time ASC";

// Execute query and fetch results
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $rides = [];
    while ($row = $result->fetch_assoc()) {
        $rides[] = $row;
    }
    $response["success"] = true;
    $response["rides"] = $rides;
} else {
    $response["message"] = "No rides found.";
}

$conn->close();
echo json_encode($response);
exit;
?>
