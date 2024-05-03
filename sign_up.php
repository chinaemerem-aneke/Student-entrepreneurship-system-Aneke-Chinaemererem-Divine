<?php
@include 'config.php'; // Database connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
  $regnumber = mysqli_real_escape_string($conn, $_POST['regnumber']);
  $department = mysqli_real_escape_string($conn, $_POST['department']);
  $level = mysqli_real_escape_string($conn, $_POST['level']);
  $gender = mysqli_real_escape_string($conn, $_POST['gender']);
  $faculty = mysqli_real_escape_string($conn, $_POST['faculty']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $phone = mysqli_real_escape_string($conn, $_POST['tel']);
  $password = md5($_POST['password']); 

  $errors = [];

  // Check if user already exists
  $check_email = "SELECT * FROM student_form WHERE email = '$email'";
  $result_email = mysqli_query($conn, $check_email);
  if (mysqli_num_rows($result_email) > 0) {
    $errors[] = "Email already exists!";
  }

  // Check if registration number already exists
  $check_regnum = "SELECT * FROM student_form WHERE reg_number = '$regnumber'";
  $result_regnum = mysqli_query($conn, $check_regnum);
  if (mysqli_num_rows($result_regnum) > 0) {
    $errors[] = "Registration number already exists!";
  }

  // If no errors, proceed to insert data
  if (empty($errors)) {
    $insert = "INSERT INTO student_form (first_name, last_name, reg_number, department, level, gender, faculty, email, phone, password) VALUES ('$firstname', '$lastname', '$regnumber', '$department', '$level', '$gender', '$faculty', '$email', '$phone', '$password')";
    $insert_result = mysqli_query($conn, $insert);
    if ($insert_result) {
      header('Location: login.php'); // Redirect to login page after successful registration
    } else {
      $errors[] = "Failed to register user: " . mysqli_error($conn);
    }
  }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>

    <link rel="stylesheet" href="./css/nav.css">
    <link rel="stylesheet" href="./css/main.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    
</head>
<body>
    <header>
        <nav class="navbar">
            <a class="logo" href="index.html">Student<span>Connect</span></a>
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.html">Home</a></li>
                <li class="nav-item"><a href="login.php">Login</a></li>
                <li class="nav-item"><a class="sign-up" href="sign_up.php">Sign up</a></li>
            </ul>

            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>
    <main class="main-content row">
    <h2>Create an Account</h2>
    <form class="container form" action="sign_up.php" method="post" onsubmit="return validateForm()">
        <?php
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo '<span class="error-msg">' . $error . '</span>';
                }
            }
        ?>
        <div class="d-grid">
            <label for="firstname">First Name: 
                <input type="text" id="firstname" name="firstname" placeholder="First name" required>
            </label>
            <label for="lastname">Last Name: 
                <input type="text" id="lastname" name="lastname" placeholder="Last name" required>
            </label>
        </div>
        
        <div class="d-grid">
            <label for="regnumber">Registration Number:  
                <input type="text" id="regnumber" name="regnumber" placeholder="Registration number" required>
            </label>
            <label for="department">Department: 
                <input type="text" id="department" name="department" placeholder="Department" required>
            </label>
        </div>

            
        <div class="d-grid">
            <label for="faculty">Faculty:
                <input type="faculty" id="faculty" name="faculty" placeholder="Faculty" required>
            </label>
            <label for="email">Email: 
                <input type="email" id="email" name="email" placeholder="Email" required>
            </label>
        </div>

        <div class="d-grid">
            <label for="level">Level:
                <select id="level" name="level" required>
                    <option value="">Select level</option>
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                    <option value="400">400</option>
                    <option value="500">500</option>
                    <option value="600">600</option>
                </select>
            </label>
            <label for="gender">Gender:
                <select id="gender" name="gender" required>
                    <option value="">Select gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </label>
        </div>

        <div class="d-grid">
            <label for="phone">Phone number: 
                <input type="tel" id="tel" name="tel" placeholder="Phone number" required>
            </label>
            <label for="password">Password: 
                <input type="password" id="password" name="password" placeholder="Password" required>
            </label>
        </div>

        <button type="submit" id="sign-up-btn">Sign Up</button>
        <div>
            <p class="container d-block">Already have an account? <a href="login.php">Login</a></p>
        </div>
    </form>    
</main>

    <!-- <footer class="site-footer">
        <div class="container">
            <p>&copy; 2024 Student Connect. All rights reserved.</p>
        </div>
    </footer> -->
</body>

    <!-- Our Customized Javascript -->
    <script defer src="./js/nav.js"></script>
    <script defer src="./js/main.js"></script>
</html>

