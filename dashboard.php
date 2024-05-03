<?php
session_start(); // Start the session

// Include config and function files
include_once 'config.php';
include_once 'db/function.php';

// Prevent session fixation attacks
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}

// Check if user is not logged in, then redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check for form submission to add a skill
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_skill'])) {
    $new_skill = trim($_POST['new_skill']);
    if (!empty($new_skill)) {
        // Assume $conn is your database connection
        $query = "INSERT INTO user_skills (user_id, skill_name) VALUES (?, ?)";
        if ($stmt = mysqli_prepare($conn, $query)) {
            mysqli_stmt_bind_param($stmt, "is", $_SESSION['user_id'], $new_skill);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            echo "ERROR: Could not prepare query: $query. " . mysqli_error($conn);
        }
    }
}

// Fetch user skills again in case a new skill was added
$userSkills = getUserSkills($_SESSION['user_id'], $conn);
$skill_number = sizeof($userSkills);


// Check for form submission for skill deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_skill'])) {
    $skill_id = $_POST['skill_id']; // Get skill ID from form input

    $query = "DELETE FROM user_skills WHERE id = ?";
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $skill_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "ERROR: Could not prepare query: $query. " . mysqli_error($conn);
    }
}

$userSkills = getUserSkills($_SESSION['user_id'], $conn);
$skill_number = sizeof($userSkills);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='boxicons/css/boxicons.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/dashboard.css">
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
            <li class="active">
                <a href="dashboard.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="profile.php">
                    <i class='bx bxs-user'></i>
                    <span class="text">Profile</span>
                </a>
            </li>
            <li>
                <a href="market.php">
                    <i class='bx bxs-shopping-bag-alt'></i>
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
                    <i class='bx bxs-log-out-circle'></i>
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
            <i class='bx bx-menu'></i>
            <a href="#" class="profile">
                <img src="images/profile.svg" alt="Profile">
            </a>
        </nav>
        <!-- NAVBAR -->
    <!-- MAIN -->
    <main>
        <div class="head-title">
            <div class="left">
                <h1>Welcome, <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span></h1>
                <ul class="breadcrumb">
                    <li><a href="#">Home</a><a class="active" href="dashboard.php"> / Dashboard</a></li>
                </ul>
            </div>
        </div>

        <ul class="box-info">
                <li>
                    <i class='bx bxs-brain'></i>
                    <span class="text">
                        <h3><?php echo $skill_number; ?></h3>
                        <p>Skill</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3>15</h3>
                        <p>Views</p>
                    </span>
                </li>
                <!-- <li>
                    <i class='bx bxs-dollar-circle'></i>
                    <span class="text">
                        <h3>$2543</h3>
                        <p>Total Sales</p>
                    </span>
                </li> -->
            </ul>

        <div class="table-data">
            <div class="todo">
                <div class="head">
                    <h3>My Skills</h3>
                    <form method="post" action="dashboard.php">
                        <input type="text" name="new_skill" id="new_skill" placeholder="Enter new skill" required>
                        <button type="submit" name="add_skill" class="btn-download">
                            <span class="text">Add Skill</span>
                        </button>
                    </form>
                </div>
                <ul class="todo-list" id="todo-list">
                    <?php foreach ($userSkills as $skill): ?>
                    <li data-skill-id="<?php echo $skill['id']; ?>">
                        <p><?php echo htmlspecialchars($skill['skill_name']); ?></p>
                        <form method="post" action="dashboard.php">
                            <input type="hidden" name="skill_id" value="<?php echo $skill['id']; ?>">
                            <button type="submit" name="delete_skill" class="btn-delete">
                                Delete <i class='bx bx-trash'></i>
                            </button>
                        </form>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </main>
    <!-- MAIN -->

    <script defer src="js/dashboard.js"></script>
</body>
</html>
