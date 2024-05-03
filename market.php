<?php
session_start(); // Start session

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

@include 'db/get_data.php'; // Include the modified script to fetch data

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
	<link rel="stylesheet" href="css/nav.css">

	<title>StudentConnect</title>
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
			<li>
				<a href="profile.php">
					<i class='bx bxs-user' ></i>
					<span class="text">Profile</span>
				</a>
			</li>
			<li class="active">
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
				<div class="left market-title">
					<h1>Find who you're looking for...</h1>
					<form id="searchForm">
                        <div class="form-input search">
                            <input type="search" id="searchInput" placeholder="Search user or skill...">
                            <button type="button" id="searchButton" class="search-btn"><i class='bx bx-search'></i></button>
                        </div>
                    </form>
				</div>
			</div>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h2>Other Members</h2>
					</div>
					<table id="userTable">
						<thead>
							<tr>
								<th>User</th>
								<th>Skills</th>
								<th>Email</th>
								<th>Phone number</th>
							</tr>
						</thead>

						<tbody>
						<?php foreach ($all_users_market as $user): ?>
							<tr>
								<td><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
								<td>
									<?php 
									// Fetch and display user's skills
									$user_skills_query = "SELECT skill_name FROM user_skills WHERE user_id = ?";
									$stmt = mysqli_prepare($conn, $user_skills_query);
									mysqli_stmt_bind_param($stmt, "i", $user['id']);
									mysqli_stmt_execute($stmt);
									$user_skills_result = mysqli_stmt_get_result($stmt);
									$skills = [];
									while ($row = mysqli_fetch_assoc($user_skills_result)) {
										$skills[] = '<i class="bx bxl-sketch"></i> ' . $row['skill_name'];
									}
									if (!empty($skills)) {
										echo implode('<br>', $skills);
									} else {
										echo "No skill";
									}
									?>
								</td>
								<td><?php echo $user['email']; ?></td>
								<td><?php echo $user['phone']; ?></td>
							</tr>
						<?php endforeach; ?>

						</tbody>
					</table>
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