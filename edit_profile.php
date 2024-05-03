<?php
session_start(); // Start session

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit;
}

include_once 'config.php';

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

$errors = [];

// Process update form submission (optional)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $faculty = mysqli_real_escape_string($conn, $_POST['faculty']);
    $level = mysqli_real_escape_string($conn, $_POST['level']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // If no errors, proceed to update data
    if (empty($errors)) {
        $update_query = "UPDATE student_form SET department = '$department', faculty = '$faculty', level = '$level' , email = '$email', phone = '$phone' WHERE id = $user_id";
        $update_result = mysqli_query($conn, $update_query);
        if ($update_result) {
            header("location: profile.php?success_message=Profile updated successfully!");
            exit;
        } else {
            $errors[] = "Email already exist!";
        }
    }
}
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

    <title>Edit Profile</title>
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
            <li>
                <a href="market.php">
                    <i class='bx bxs-shopping-bag-alt' ></i>
                    <span class="text">Market</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu bottom">
            <li class="active">
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
                            <a href="profile.php"> / Profile</a>
                            <a class="active" href="#"> / Edit Profile</a>
                        </li>
                    </ul>
                </div>
            
            </div>

            <div class="table-data">
                <div class="todo">
                    <div class="head">
                        <h3>Edit Profile</h3>
                        <?php
                            // Display error messages (optional)
                            if (!empty($errors)) {
                                echo '<ul class="error-msg">';
                                foreach ($errors as $error) {
                                    echo "<li>$error</li>";
                                }
                                echo '</ul>';
                            }
                        ?>
                    </div>

                    <form class="todo-list" action="" method="post">
                        <div>
                            <label for="department">Department:</label>
                            <input type="text" name="department" id="department" value="<?php echo htmlspecialchars($user_data['department']); ?>" required>
						</div>
                        <div>
                            <label for="faculty">Faculty:</label>
                            <input type="text" name="faculty" id="faculty" value="<?php echo htmlspecialchars($user_data['faculty']); ?>" required>
						</div>
						<div>
                            <label for="level">Level:</label>
                            <input type="text" name="level" id="level" value="<?php echo htmlspecialchars($user_data['level']); ?>" required>
						</div>
                        <div>
                            <label for="email">Email:</label>
                            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
						</div>
						<div>
                            <label for="phone">Phone:</label>
                            <input type="tel" name="phone" id="phone" value="<?php echo htmlspecialchars($user_data['phone']); ?>" required>
						</div>

                        <button type="submit" class="update-btn">Update Profile</button>
                    </form>
                </div>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->

    <script defer src="js/dashboard.js"></script>
</body>
</html>
