<?php
// Start the session
session_start();

// Get the user's email from the session
$user_email = $_SESSION['SESSION_EMAIL'];

// Check if the user is logged in
if (!isset($user_email)) {
    header('location:../../login');
    exit;
}

// Include the database connection
include_once('../../assets/setup/db.php');

// Define the SQL query to retrieve the PIN and agent_id for the user
$query = "SELECT pin, agent_id FROM agent_activity WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);

// Check if the query preparation was successful
if ($stmt) {
    // Bind the user's email to the query
    mysqli_stmt_bind_param($stmt, "s", $user_email);

    // Execute the query and get the result
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the result into an associative array
    $row = mysqli_fetch_assoc($result);

    // Check if the user has a PIN set
    if ($row && !empty($row['pin'])) {
        // PIN is already set, redirect to the desired action (e.g., withdrawal page)
        header('location: ./index.php');
        exit;
    }

    // If the agent_id is empty, generate and insert it
    if (empty($row['agent_id'])) {
        $agent_id = generateAgentID($conn);
        insertAgentID($conn, $user_email, $agent_id);
    }
}

// If the user doesn't have a PIN set, handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the PIN from the form submission
    $pin = $_POST['pin'];

    // Hash the PIN for security
    $hashed_pin = password_hash($pin, PASSWORD_DEFAULT);

    // Check if a row already exists for the user in agent_activity
    $existing_query = "SELECT user_id FROM agent_activity WHERE user_id = ?";
    $existing_stmt = mysqli_prepare($conn, $existing_query);

    // Check if the query preparation was successful
    if ($existing_stmt) {
        mysqli_stmt_bind_param($existing_stmt, "s", $user_email);
        mysqli_stmt_execute($existing_stmt);
        $existing_result = mysqli_stmt_get_result($existing_stmt);

        // Check if a row already exists for the user
        if ($existing_result->num_rows > 0) {
            // Update the existing row with the hashed PIN
            $updateQuery = "UPDATE agent_activity SET pin = ? WHERE user_id = ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);

            // Check if the query preparation was successful
            if ($updateStmt) {
                mysqli_stmt_bind_param($updateStmt, "ss", $hashed_pin, $user_email);
                mysqli_stmt_execute($updateStmt);
            }
        } else {
            // Insert a new row in the agent_activity table with the hashed PIN
            $insertQuery = "INSERT INTO agent_activity (user_id, pin) VALUES (?, ?)";
            $insertStmt = mysqli_prepare($conn, $insertQuery);

            // Check if the query preparation was successful
            if ($insertStmt) {
                mysqli_stmt_bind_param($insertStmt, "ss", $user_email, $hashed_pin);
                mysqli_stmt_execute($insertStmt);
            }
        }

        // Redirect to the desired action (e.g., withdrawal page)
        header('location: ./index.php');
        exit;
    }
}

// Function to generate a sequential four-figure alphanumeric Agent ID
function generateAgentID($conn) {
    $sql = "SELECT MAX(agent_id) AS max_id FROM agents";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $max_id = $row['max_id'];

        if ($max_id !== null) {
            $max_id = (int) substr($max_id, -4);
        } else {
            $max_id = 0;
        }

        $new_id = $max_id + 1;
        $agentID = str_pad($new_id, 4, '0', STR_PAD_LEFT);
        return $agentID;
    }
    return '';
}

// Function to insert the agent ID into the agents table
function insertAgentID($conn, $user_email, $agent_id) {
    $insertQuery = "INSERT INTO agents (user_id, agent_id) VALUES (?, ?)";
    $insertStmt = mysqli_prepare($conn, $insertQuery);

    if ($insertStmt) {
        mysqli_stmt_bind_param($insertStmt, "ss", $user_email, $agent_id);
        mysqli_stmt_execute($insertStmt);
    }
}
?>

<!-- HTML form to set the PIN -->
<form action="" method="POST">
    <label for="pin">Set your PIN:</label>
    <input type="password" id="pin" name="pin" required>
    <button type="submit">Set PIN</button>
</form>

<script>
function redirectToWithdrawal() {
    window.location.href = '../withdrawal/index.php';
}
</script>
