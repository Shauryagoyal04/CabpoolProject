<?php
session_start();
$enrollment_num = isset($_SESSION['enrollment_num']) ? $_SESSION['enrollment_num'] : null;

// If the enrollment_number is not set in the session, show a message and exit
if (!$enrollment_num) {
    echo "No user is logged in.";
    exit();
}
// Database connection
$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "cabpoolproject";   

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details based on enrollment number
$sql = "SELECT * FROM user_info WHERE enrollment_num = '$enrollment_num'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email_id = mysqli_real_escape_string($conn, $_POST['email_id']);
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $phone_num = mysqli_real_escape_string($conn, $_POST['phone_num']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);

    // Update the user details
    $update_sql = "UPDATE user_info SET 
                    name='$name', 
                    email_id='$email_id',  
                    year='$year', 
                    phone_num='$phone_num', 
                    gender='$gender', 
                    age='$age' 
                    WHERE enrollment_num='$enrollment_num'";
                    
    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='profile.php';</script>";
    } else {
        echo "Error updating profile: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
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
        .profile-form {
            display: flex;
            flex-direction: column;
        }
        .profile-form label {
            margin-bottom: 5px;
            color: #555;
        }
        .profile-form input, .profile-form select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            width: 100%;
        }
        .profile-actions {
            text-align: center;
        }
        .profile-actions button, .profile-actions a {
            text-decoration: none;
            background: #007bff;
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .profile-actions button:hover, .profile-actions a:hover {
            background: #0056b3;
        }
        .profile-actions a {
            margin-left: 10px;
            background: #6c757d;
        }
        .profile-actions a:hover {
            background: #5a6268;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h2>Edit Profile</h2>
        </div>
        <form class="profile-form" action="editprofile.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

            <label for="email_id">Email:</label>
            <input type="email" id="email_id" name="email_id" value="<?php echo htmlspecialchars($user['email_id']); ?>" required>

            <label for="year">Year:</label>
            <input type="number" id="year" name="year" value="<?php echo htmlspecialchars($user['year']); ?>" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone_num']); ?>" required>

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?php if ($user['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($user['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                <option value="Other" <?php if ($user['gender'] == 'Other') echo 'selected'; ?>>Other</option>
            </select>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo htmlspecialchars($user['age']); ?>" required>

            <div class="profile-actions">
                <button type="submit">Update Profile</button>
                <a href="profile.php">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
