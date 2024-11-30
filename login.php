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
    <title>Login- JIIT Cab Pooling</title>
</head>
<body>
      <div class="container">
        <div class="box form-box">
                <?php
        // session_start();
        include("php/config.php");

        if (isset($_POST['submit'])) {
            // Escape the input values to avoid SQL injection
            $email_id = mysqli_real_escape_string($con, $_POST['email_id']);
            $password = mysqli_real_escape_string($con, $_POST['password']);

            // Query to check if the email and password match
            $result = mysqli_query($con, "SELECT * FROM user_info WHERE email_id='$email_id' AND password='$password'") or die("Select Error");

            // Fetch the result as an associative array
            $row = mysqli_fetch_assoc($result);

            // Check if a valid row was returned (both email and password are correct)
            if ($row) {
                $_SESSION['enrollment_num'] = $row['enrollment_num'];
                $_SESSION['valid'] = $row['email_id'];
                $_SESSION['username'] = $row['username'];

                // Redirect to the main page
                header("Location: main.php");
                exit(); // Always call exit() after header redirection
            } else {
                // If no valid row found, display error message
                echo "<div class='message'>
                        <p>Wrong Username or Password</p>
                    </div><br>";
                echo "<a href='index.php'><button class='btn'>Go Back</button></a>";
            }
        }else{
        ?>

            <form action="login.php" method="post">
                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email_id" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    
                    <input type="submit" class="btn" name="submit" value="Login" required>
                </div>
                <div class="links">
                    Don't have account? <a href="signup.php">Sign Up Now</a>
                </div>
            </form>
        </div>
        <?php }?>
      </div>
              </body>
              </html>
 