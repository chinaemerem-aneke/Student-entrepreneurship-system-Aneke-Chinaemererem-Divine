<?php
session_start(); // Start session

// Include the database configuration file
@include 'config.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve inputs and escape them to prevent SQL injection
    $regnumber = mysqli_real_escape_string($conn, $_POST['regnumber']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    // Hash the password using MD5 (not recommended for production, consider stronger hashing algorithms like bcrypt)
    $password = md5($password);

    // Prepare SQL query to select user based on registration number and password
    $query = "SELECT * FROM student_form WHERE reg_number = '$regnumber' AND password = '$password'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check if the query was successful and returned at least one row
    if (mysqli_num_rows($result) > 0) {
        // Fetch the user's data
        $row = mysqli_fetch_assoc($result);

        // Set session variables
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['first_name'] . ' ' . $row['last_name']; // Assuming you have firstname and lastname fields

        // Redirect to the dashboard page
        header("location: dashboard.php");
        exit;
    } else {
        // Check if both registration number and password are incorrect
        $query_check_reg = "SELECT * FROM student_form WHERE reg_number = '$regnumber'";
        $result_check_reg = mysqli_query($conn, $query_check_reg);

        $query_check_pass = "SELECT * FROM student_form WHERE password = '$password'";
        $result_check_pass = mysqli_query($conn, $query_check_pass);

        if (mysqli_num_rows($result_check_reg) > 0 || mysqli_num_rows($result_check_pass) > 0) {
            $error = 'Registration number or password is incorrect!';
        } elseif (mysqli_num_rows($result_check_reg) === 0 && mysqli_num_rows($result_check_pass) === 0) {
            $error = 'User does not exist!';
        }
        
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Our customized CSS -->
    <link rel="stylesheet" href="./css/nav.css">
    <link rel="stylesheet" href="./css/main.css">

    <!-- Our Customised Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    
</head>
<body>
    <header>
        <nav class="navbar">
            <a class="logo" href="index.html">Student<span>Connect</span></a>
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.html">Home</a></li>
               
                <li class="nav-item"><a href="login.php">Login</a></li>
                <li class="nav-item"><a href="sign_up.php" class="sign-up">Sign up</a></li>
            </ul>

            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <div class="row">
            <div>
                
            </div>
            <h2>Login</h2>

            <form class="container form login_form" action="login.php" method="post">
                <?php
                    if (isset($error)) {
                        echo '<span class="error-msg">' . $error . '</span>';
                    }
                ?> 
                <label for="regnumber">Registration Number:  
                    <input type="text" id="regnumber" name="regnumber" placeholder="Registration Number" required>
                </label>
                <label for="password">Password: 
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </label>

                <button type="submit" id="login-btn">Login</button>

                <div>
                    <p class="container d-block">Don't have an account? <a href="sign_up.php">Sign Up</a></p>
                </div>
            </form>
        </div>
    </main>
</body>

    <!-- Our Customized Javascript -->
    <script src="./js/nav.js"></script>
    <script src="./js/main.js"></script>
</html>

