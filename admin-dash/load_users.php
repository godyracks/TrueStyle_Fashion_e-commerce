<?php
// ... Database connection code ...
include('../assets/setup/db.php');

$sql = "SELECT * FROM user_info ORDER BY created_at DESC LIMIT 3";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="user">';
    echo '<img src="../images/true_logo.png">';
    echo '<h2>' . $row['name'] . '</h2>';
    echo '<p>' . date('M d, Y', strtotime($row['created_at'])) . '</p>';
    echo '</div>';
}

// ... Close database connection ...
mysqli_close($conn);
?>
