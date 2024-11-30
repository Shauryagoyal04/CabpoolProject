<?php
session_start();
$enrollment_num = isset($_SESSION['enrollment_num']) ? $_SESSION['enrollment_num'] : null;

if (!$enrollment_num) {
    echo "No user is logged in. Session enrollment number is empty.";
    exit();
}



// Database connection
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "cabpoolproject";   

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
} else {
    
}

// Sanitize input
$enrollment_num = $conn->real_escape_string($enrollment_num);

// SQL query
$sql = "SELECT *
        
            
        FROM user_info 
        WHERE enrollment_num = '$enrollment_num'";



$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
   
} else {
    echo "Query executed but no user found. Rows returned: " . ($result ? $result->num_rows : 0);
    exit();
}

$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .profile-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-header h2 {
            margin: 0;
            color: #333;
        }
        .profile-header p {
            color: #666;
            font-size: 14px;
        }
        .profile-details {
            list-style-type: none;
            padding: 0;
        }
        .profile-details li {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .profile-details li:last-child {
            border-bottom: none;
        }
        .profile-details strong {
            color: #333;
        }
        .profile-details span {
            color: #555;
        }
        .profile-actions {
            text-align: center;
            margin-top: 20px;
        }
        .profile-actions a {
            display: inline-block;
            text-decoration: none;
            background: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            transition: background 0.3s ease;
        }
        .profile-actions a:hover {
            background: #0056b3;
        }
        .profile-actions a + a {
            margin-left: 10px;
            background: #6c757d;
        }
        .profile-actions a + a:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h2>Profile Details</h2>
            <p>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</p>
        </div>
        <ul class="profile-details">
            <li>
                <strong>Enrollment Number:</strong>
                <span><?php echo htmlspecialchars($user['enrollment_num']); ?></span>
            </li>
            <li>
                <strong>Email:</strong>
                <span><?php echo htmlspecialchars($user['email_id']); ?></span>
    </li>
            
            
            <li>
                <strong>Phone:</strong>
                <span><?php echo htmlspecialchars($user['phone_num']); ?></span>
            </li>
           
            <li>
    <strong>Rating:</strong>
    <span><?php echo htmlspecialchars(number_format($user['rating'], 2)); ?></span>
</li>

        </ul>
        <div class="profile-actions">
            <a href="main.php">Back to Main Page</a>
            <a href="php/editprofile.php">edit profile</a>
            <a href="php/logout.php">logout</a>
        </div>
    </div>
</body>
</html>
