<?php
// ... Database connection code ...
include('../assets/setup/db.php');

$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

$sql = "SELECT * FROM user_info ORDER BY created_at DESC LIMIT 3 OFFSET $offset";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="user">';
    echo '<img src="./../images/true_logo.png">';
    echo '<h2>' . $row['name'] . '</h2>';
    echo '<p>' . date('M d, Y', strtotime($row['created_at'])) . '</p>';
    echo '</div>';
}

// ... Close database connection ...
mysqli_close($conn);
?>
