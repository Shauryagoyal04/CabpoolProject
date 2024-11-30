<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/signupstyle.css">
    <title>Signup - JIIT Cab Pooling</title>
</head>
<body>
    <h2>𐂯RIDESHARE</h2>
    <div class="container">
        <div class="box form-box">
        <?php 
        include("php/config.php");

        if (isset($_POST['submit'])) {
            $enrollment_num = htmlspecialchars($_POST['enrollment_num']);
            $username = htmlspecialchars($_POST['username']);
            $email_id = htmlspecialchars($_POST['email_id']);
            $phone_num = htmlspecialchars($_POST['phone_num']);
            $password = htmlspecialchars($_POST['password']);

            // Validate email and phone number
            if (!filter_var($email_id, FILTER_VALIDATE_EMAIL)) {
                echo "<div class='message'><p>Invalid email format!</p></div><br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                exit();
            }
            if (strlen($phone_num) != 10) {
                echo "<div class='message'><p>Phone number must be 10 digits!</p></div><br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
                exit();
            }

            // Verify email uniqueness
            $verify_emailid = mysqli_query($con, "SELECT email_id FROM user_info WHERE email_id='$email_id'");
            $verify_username = mysqli_query($con, "SELECT username FROM user_info WHERE username='$username'");
            if (mysqli_num_rows($verify_username) != 0) {
                echo "<div class='message'><p>This username is already in use. Try another one!</p></div><br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
            }
            else if (mysqli_num_rows($verify_emailid) != 0) {
                echo "<div class='message'><p>This email is already in use. Try another one!</p></div><br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button></a>";
            } else {
                // Insert user data into the database
                $stmt = $con->prepare("INSERT INTO user_info(username, enrollment_num, email_id, phone_num, password, created_at) VALUES (?, ?, ?,?, ?, NOW())");
                $stmt->bind_param("sssss", $username, $enrollment_num, $email_id, $phone_num, $password);

                if ($stmt->execute()) {
                    echo "<div class='message'><p>Registration successful!</p></div><br>";
                    echo "<a href='index.php'><button class='btn'>Login Now</button></a>";
                } else {
                    echo "<div class='message'><p>Error: " . $stmt->error . "</p></div><br>";
                }
                $stmt->close();
            }
        } else {
        ?>
            <header>SignUp</header>
            <form action="" method="post">
                <div class="field input">
                    <input type="text" name="username" id="username" placeholder="Name" autocomplete="off" required>
                </div>
                <div class="field input">
                    <input type="text" name="enrollment_num" id="enrollment_num" placeholder="Enrollment Number" autocomplete="off" required>
                </div>
                <div class="field input">
                    <input type="email" name="email_id" id="email_id" placeholder="Email" autocomplete="off" required>
                </div>
                <div class="field input">
                    <input type="tel" name="phone_num" id="phone_num" placeholder="Phone Number" autocomplete="off" required>
                </div>
                <div class="field input">
                    <input type="password" name="password" id="password" placeholder="Password" autocomplete="off" required>
                </div>
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register">
                </div>
            </form>
        <?php } ?>
        </div>
    </div>
</body>
</html>
