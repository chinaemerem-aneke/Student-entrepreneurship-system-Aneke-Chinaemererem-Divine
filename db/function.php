<?php

// Fetch user's name
$user_id = $_SESSION['user_id'];
$query = "SELECT first_name FROM student_form WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user_name = "";
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $user_name = $row['first_name'];
}


// Function to fetch user skills from the database
function getUserSkills($userId, $conn) {
    $sql = "SELECT skill_name, id FROM user_skills WHERE user_id = $userId";
    $result = mysqli_query($conn, $sql);
    $skills = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $skills[] = $row;
        }
    }
    return $skills;
}

?>
