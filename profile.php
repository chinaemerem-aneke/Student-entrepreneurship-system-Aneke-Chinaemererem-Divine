<?php
session_start(); // Start session

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

// Include the database configuration file
@include_once 'config.php';

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

// Check if success message is present in URL parameters
$success_message = isset($_GET['success_message']) ? $_GET['success_message'] : null;

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='boxicons/css/boxicons.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="css/dashboard.css">
	<link rel="stylesheet" href="css/main.css">

	<title>Student Connect</title>
</head>
<body>

	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="index.html" class="brand">
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
		<ul class="side-menu bottom">
			<li>
                <a href="edit_profile.php">
                    <i class='bx bx-cog'></i>
                    <span class="text">Setting</span>
                </a>
            </li>
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
				<img src="images/profile.svg">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<ul class="breadcrumb">
						<li>
							<a href="#">Home</a>
							<a class="active" href="profile.php"> / Profile</a>
						</li>
					</ul>
				</div>

				<?php
					if ($success_message) {
						echo '<p class="success-msg">' . htmlspecialchars($success_message) . '</p>';
					}
				?>
				
			</div>

			<div class="table-data">
				<!-- <a href="#" class="user-img">
					<img src="img/people.png">
				</a> -->
				<div class="todo">
					<div class="head">
					<h3>My Profile</h3>
					<a href="edit_profile.php">
						<span class="btn-edit">Edit profile <i class='bx bxs-edit-alt'></i></span>
					</a>
					</div>
				
					<ul class="todo-list">
						<li>
							<p>Name: <span><?php echo $user_data['first_name'] . ' ' . $user_data['last_name']; ?></span></p>
						</li>
						<li>
							<p>Reg number: <span><?php echo $user_data['reg_number']; ?></span></p>
						</li>
						<li>
							<p>Department: <span><?php echo $user_data['department']; ?></span></p>
						</li>
						<li>
							<p>Faculty: <span><?php echo $user_data['faculty']; ?></span></p>
						</li>
						<li>
							<p>Level: <span><?php echo $user_data['level']; ?></span></p>
						</li>
						<li>
							<p>Gender: <span><?php echo $user_data['gender']; ?></span></p>
						</li>
						<li>
							<p>Email: <a href=""><?php echo $user_data['email']; ?></a></p>
						</li>
						<li>
							<p>Phone number: <span><?php echo $user_data['phone']; ?></span></p>
						</li>
					</ul>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script defer src="js/dashboard.js"></script>
	<script defer src="js/main.js"></script>

</body>
</html>