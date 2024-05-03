<?php
function getTotalMembersCount() {
    include_once 'config.php';

    $sql = "SELECT COUNT(*) AS total_members FROM members_table";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch total members count
        $row = $result->fetch_assoc();
        $total_members_count = $row["total_members"];
    } else {
        $total_members_count = 0;
    }

    $conn->close();

    return $total_members_count;
}

$total_members_count = getTotalMembersCount(); 
$visitor_count = max(0, $total_members_count - 1); 
?>

