<?php
session_start();
$user_id = $_SESSION['SESSION_EMAIL'];

if (!isset($user_id)) {
    header('location:../../login');
    exit;
}

// Check if the PIN is set for the user
// Assuming you have a database connection established
include_once('../../assets/setup/db.php');

$query = "SELECT pin FROM agent_activity WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row || empty($row['pin'])) {
    // PIN is not set, redirect to the PIN setting page or any other desired action
    header('location: set_pin.php');
    exit;
}

// PIN is set, display the detailed withdrawal information
// Add your code to display the withdrawal details here
?>
