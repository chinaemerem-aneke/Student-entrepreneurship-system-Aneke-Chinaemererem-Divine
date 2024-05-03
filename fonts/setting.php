<?php
session_start(); // Start session

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
  header("location: login.php");
  exit;
}

// Include the database configuration file
@include 'config.php';

// Fetch user data based on user ID
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM student_form WHERE id = $user_id";
$result = mysqli_query($conn, $query);

// Check if query was successful
if ($result && mysqli_num_rows($result) > 0) {
  // Fetch user data
  $user_data = mysqli_fetch_assoc($result);
} else {
  // Handle error if user data is not found
  $user_data = array();
}

mysqli_close($conn);

// Error handling for update (optional)
$errors = [];

// Process update form submission (optional)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
  $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
  $department = mysqli_real_escape_string($conn, $_POST['department']);
  $level = mysqli_real_escape_string($conn, $_POST['level']);
  $gender = mysqli_real_escape_string($conn, $_POST['gender']);
  $skill = mysqli_real_escape_string($conn, $_POST['skill']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $phone = mysqli_real_escape_string($conn, $_POST['tel']);

  // Check if email already exists (excluding current user)
  $check_email = "SELECT * FROM student_form WHERE email = '$email' AND id != $user_id";
  $result_email = mysqli_query($conn, $check_email);
  if (mysqli_num_rows($result_email) > 0) {
    $errors[] = "Email already exists!";
  }

  // If no errors, proceed to update data
  if (empty($errors)) {
    $update_query = "UPDATE student_form SET first_name = '$firstname', last_name = '$lastname', department = '$department', level = '$level', gender = '$gender', skill = '$skill', email = '$email', phone = '$phone' WHERE id = $user_id";
    $update_result = mysqli_query($conn, $update_query);
    if ($update_result) {
      // Update successful, refresh page or display success message
      echo '<script>alert("Profile updated successfully!");</script>';
    } else {
      $errors[] = "Failed to update profile: " . mysqli_error($conn);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="css/dashboard.css">

  <title>Update Profile</title>
</head>
<body>


<section id="sidebar" class="hide">
		<a href="index.php" class="brand">
			<i class='bx bx-bulb'></i>
			<p class="text">Student<span>Connect</span></p>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="dashboard.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li class="active">
				<a href="profile.php">
					<i class='bx bxs-user' ></i>
					<span class="text">Profile</span>
				</a>
			</li>
			<li>
				<a href="market.php">
					<i class='bx bxs-shopping-bag-alt' ></i>
					<span class="text">Market</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="log_out.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>

			<a href="#" class="user">
				<img src="images/flower.jpg">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main class="profile-content">
			<div class="head-title">
				<div class="left">
					<h2>My Profile</h2>
				</div>
			</div>

			<div class="user-profile">
				<img src="images/flower.jpg">
			</div>
			<div class="table-data">
				
            <div class="update-form">
                <h2>Edit Profile</h2>
                <?php
                // Display error messages (optional)
                if (!empty($errors)) {
                    echo '<ul class="errors">';
                    foreach ($errors as $error) {
                    echo "<li>$error</li>";
                    }
                    echo '</ul>';
                }
                ?>
            <form action="" method="post" novalidate>
                <div class="form-group">
                    <label for="firstname">First Name:</label>
                    <input type="text" name="firstname" id="firstname" value="<?php echo $user_data['first_name']; ?>">
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" name="lastname" id="lastname" value="<?php echo $user_data['last_name']; ?>">
                </div>
                <div class="form-group">
                    <label for="department">Department:</label>
                    <input type="text" name="department" id="department" value="<?php echo $user_data['department']; ?>">
                </div>
                <div class="form-group">
                    <label for="level">Level:</label>
                    <input type="text" name="level" id="level" value="<?php echo $user_data['level']; ?>">
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select name="gender" id="gender">
                        <option value="Male" <?php if ($user_data['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if ($user_data['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="skill">Skill:</label>
                    <input type="text" name="skill" id="skill" value="<?php echo $user_data['skill']; ?>">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?php echo $user_data['email']; ?>">
                </div>
                <div class="form-group">
                    <label for="tel">Phone Number:</label>
                    <input type="tel" name="tel" id="tel" value="<?php echo $user_data['phone']; ?>">
                </div>
                <div class="form-group">
                    <button type="submit">Update Profile</button>
                </div>
            </form>
        </div>

			</div>
		<!-- </main> -->
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="./js/dashboard.js"></script>
</body>
</html>