<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/signupstyle.css">
    <title>Signup - JIIT Cab Pooling</title>
    
</head>
<body>
    <div class="container">
    <div class="box form-box">
    <?php 
         
         include("php/config.php");
         if(isset($_POST['submit'])){
            $name = $_POST['name'];
            $enrollment_num = $_POST['enrollment_num'];
            $age = $_POST['age'];
            $gender = $_POST['gender'];
            $year = $_POST['year'];
            $email_id = $_POST['email_id'];
            $phone_num = $_POST['phone_num'];
            $password = $_POST['password'];

            //verify the unique enrollment and email

            $verify_enrollment_num = mysqli_query($con,"SELECT enrollment_num FROM user_info WHERE enrollment_num = '$enrollment_num'");
            $verify_emailid = mysqli_query($con,"SELECT email_id FROM user_info WHERE email_id='$email_id'");

            if(mysqli_num_rows($verify_enrollment_num) !=0 )
            {
                echo "<div class='message'>
                      <p>This enrollment number is used, Try another One Please!</p>
                  </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
            }

            else if(mysqli_num_rows($verify_emailid) !=0 )
            {
                echo "<div class='message'>
                      <p>This email is used, Try another One Please!</p>
                  </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Go Back</button>";
            }
            else
            {
                mysqli_query($con,"INSERT INTO user_info(name,enrollment_num,age,gender,year,email_id,phone_num,password,created_at) VALUES('$name','$enrollment_num','$age','$gender','$year','$email_id','$phone_num','$password',NOW())") or die("Erroe Occured");

            echo "<div class='message'>
                      <p>Registration successfully!</p>
                  </div> <br>";
            echo "<a href='index.php'><button class='btn'>Login Now</button>";
            
            
            }
        }else{
         
            ?>

         
    <header>Signup</header><br><br>
    <form action="" method="post">
        <div class="field input">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" autocomplete="off" required>
        </div>
        <div class="field input">
            <label for="enrollment_num">Enrollment Number</label>
            <input type="number" name="enrollment_num" autocomplete="off" id="enrollment_num" required>
        </div>
        <div class="field input">
            <label for="age">Age</label>
            <input type="number" name="age" id="age" autocomplete="off" required>
        </div>
        <div class="field input">
            <label for="gender">Gender</label>
            <input type="text" name="gender" id="gender" autocomplete="off" required>
        </div>
        <div class="field input">
            <label for="year">Year</label>
            <input type="text" name="year" id="year" autocomplete="off" required>
        </div>
        <div class="field input">
            <label for="email_id">Email Id</label>
            <input type="text" name="email_id" id="email_id" autocomplete="off" required>
        </div>
        <div class="field input">
            <label for="phone_num">Phone Number</label>
            <input type="number" name="phone_num" id="phone_num" autocomplete="off" required>
        </div>
        <div class="field input">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" autocomplete="off" required>
        </div>
        <br>
        <div class="field">
                    
            <input type="submit" class="btn" name="submit" value="Register" required>
        </div>
        </div>
        <?php } ?>
        </div>
</body>
</html>
