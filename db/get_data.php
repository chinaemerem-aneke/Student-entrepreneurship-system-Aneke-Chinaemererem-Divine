<?php
session_start(); // Start session

// Include the database configuration file
@include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page or display an error message
    header("location: login.php");
    exit; // Stop further execution
}

// Fetch user data for profile page
$stmt_profile = $conn->prepare("SELECT * FROM student_form WHERE id = ?");
$stmt_profile->bind_param("i", $_SESSION['user_id']);
$stmt_profile->execute();
$result_profile = $stmt_profile->get_result();

// Initialize an array to store user data for profile page
$user_data_profile = [];

// Check if query was successful and fetch user data
if ($result_profile && $result_profile->num_rows > 0) {
    $user_data_profile = $result_profile->fetch_assoc();
}

// Close statement
$stmt_profile->close();

// Fetch all users for market page excluding the currently logged-in user
$stmt_market = $conn->prepare("SELECT sf.*, GROUP_CONCAT(us.skill_name) AS skills FROM student_form sf LEFT JOIN user_skills us ON sf.id = us.user_id WHERE sf.id != ? GROUP BY sf.id");
$stmt_market->bind_param("i", $_SESSION['user_id']);
$stmt_market->execute();
$result_market = $stmt_market->get_result();

// Initialize an array to store all user data for market page
$all_users_market = [];

// Check if query was successful and fetch all user data
if ($result_market && $result_market->num_rows > 0) {
    while ($row = $result_market->fetch_assoc()) {
        $all_users_market[] = $row;
    }
}

// Close statement
$stmt_market->close();

