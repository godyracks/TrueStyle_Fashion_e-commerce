<?php
session_start();
$email = $_SESSION['SESSION_EMAIL'];


if (!isset($user_id)) {
    header('location:../login');
    exit;
}

// Check if the PIN is already set for the user
// Assuming you have a database connection established
include_once('../../assets/setup/db.php');

$query = "SELECT pin FROM agent_activity WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if ($row && !empty($row['pin'])) {
    // PIN is already set, redirect to the withdrawal page or any other desired action
    header('location: ./index.php');
    exit;
}

// PIN is not set, insert a new row with the agent's details and set the PIN
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission to set the PIN
    $pin = $_POST['pin'];

    // Perform necessary validation and sanitization of the PIN

    // Insert a new row in the agent_activity table
    $insertQuery = "INSERT INTO agent_activity (user_id, pin) VALUES (?, ?)";
    $insertStmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($insertStmt, "ss", $email, $pin);
    mysqli_stmt_execute($insertStmt);

    // Redirect to the withdrawal page or any other desired action
    header('location: ./index.php');
    exit;
}
?>

<!-- HTML form to set the PIN -->
<form action="" method="POST">
    <label for="pin">Set your PIN:</label>
    <input type="password" id="pin" name="pin" required>
    <button type="submit">Set PIN</button>
</form>
