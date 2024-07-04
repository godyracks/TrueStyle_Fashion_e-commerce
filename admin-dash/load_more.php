<?php
// Establish database connection (you'll need to provide your database credentials here)
include_once('../assets/setup/db.php');
// Get the offset from the query string
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

// Execute SQL query to fetch more orders
$sql = "SELECT * FROM orders ORDER BY order_time DESC LIMIT 4 OFFSET $offset";
$result = mysqli_query($conn, $sql);

// Loop through fetched data and generate table rows
while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['name'] . '</td>';
    echo '<td>' . $row['number'] . '</td>';
    echo '<td>' . $row['method'] . '</td>';
    // ... Add more columns as needed
    echo '</tr>';
}

// Close the database connection
mysqli_close($conn);
?>
