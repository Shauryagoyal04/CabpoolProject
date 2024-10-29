!<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup - JIIT Cab Pooling</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>
    <div class="signup-container">
        <h2>Signup for JIIT Cab Pooling</h2>
        <form action="submit_signup.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="enrollment">Enrollment Number:</label>
            <input type="text" id="enrollment" name="enrollment" required>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required min="17" max="100">

            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <label for="year">Year:</label>
            <select id="year" name="year" required>
                <option value="">Select Year</option>
                <option value="1">1st Year</option>
                <option value="2">2nd Year</option>
                <option value="3">3rd Year</option>
                <option value="4">4th Year</option>
            </select>

            <label for="branch">Branch:</label>
            <select id="branch" name="branch" required>
                <option value="">Select Branch</option>
                <option value="CSE">Computer Science</option>
                <option value="IT">Information Technology</option>
                <option value="ECE">Electronics and Communication</option>
                <option value="EEE">Electrical and Electronics</option>
                <option value="ME">Mechanical</option>
                <!-- Add other branches if needed -->
            </select>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="submit-btn">Sign Up</button>
        </form>
    </div>
</body>
</html>
