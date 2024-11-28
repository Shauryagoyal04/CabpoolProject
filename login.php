<?php 
   session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/signupstyle.css">
    <title>Login - JIIT Cab Pooling</title>
</head>
<body>
<h2>𐂯RIDESHARE</h2>
    <div class="container">
        <div class="box form-box">
        <header>Login</header>
            <?php
            include("php/config.php");

            if (isset($_POST['submit'])) {
                // Sanitize input values to prevent SQL injection
                $email_id = mysqli_real_escape_string($con, $_POST['email_id']);
                $password = mysqli_real_escape_string($con, $_POST['password']);

                // Query to verify email and password
                $result = mysqli_query($con, "SELECT * FROM user_info WHERE email_id='$email_id' AND password='$password'") or die("Select Error");
                
                // Fetch the result as an associative array
                $row = mysqli_fetch_assoc($result);

                // If a valid row was returned, set session variables
                if ($row) {
                    $_SESSION['valid'] = $row['email_id'];
                    $_SESSION['username'] = $row['username'];  // Setting username for use on other pages

                    // Redirect to main.php after successful login
                    header("Location: main.php");
                    exit(); // Always call exit() after header redirection
                } else {
                    // If credentials are invalid, display an error message
                    echo "<div class='message'>
                            <p>Wrong Username or Password</p>
                          </div><br>";
                    echo "<a href='index.php'><button class='btn'>Go Back</button></a>";
                }
            } else {
            ?>

            <form action="login.php" method="post">
                <div class="field input">
                    <input type="text" name="email_id" id="email" placeholder="Email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <input type="password" name="password" id="password" placeholder="Password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have an account? <a href="signup.php">SignUp</a>
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
</body>
</html>
