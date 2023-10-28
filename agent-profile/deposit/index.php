<?php
session_start();
include_once('../../assets/setup/db.php');

$user_email = $_SESSION['SESSION_EMAIL'];

if (!isset($user_email)) {
    header('location:../../login');
    exit;
}

// Check if the PIN is set for the user
$query = "SELECT pin FROM agent_activity WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $user_email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row || empty($row['pin'])) {
    header('location: set_pin.php');
    exit;
}

// Handle deposit form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $mpesaTransactionId = $_POST['mpesa-transaction-id'];

    // Insert the deposit into the 'agent_deposits' table
    $insertQuery = "INSERT INTO agent_deposits (agent_id, amount, mpesa_transaction_id, status) VALUES (?, ?, ?, 'Pending')";
    $insertStmt = mysqli_prepare($conn, $insertQuery);

    if ($insertStmt) {
        // You need to retrieve the agent_id based on the logged-in user's email, 
        // as it's a foreign key in the 'agent_deposits' table
        $agentId = getAgentIdByEmail($conn, $user_email);

        if ($agentId) {
            mysqli_stmt_bind_param($insertStmt, "ids", $agentId, $amount, $mpesaTransactionId);
            mysqli_stmt_execute($insertStmt);

            // Deposit successfully added
            // You may redirect or display a confirmation message
        } else {
            // Handle the case where agent_id couldn't be retrieved
        }
    }
}

function getAgentIdByEmail($conn, $email) {
    $query = "SELECT id FROM agents WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['id'];
}

?>

<?php include_once('../templates/_header.php'); ?>
<style>
    /* styles.css */


h2 {
    font-size: 24px;
    color: #007BFF;
    margin-bottom: 20px;
}

section {
    margin-bottom: 20px;
}

form {
    text-align: left;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="number"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    margin-bottom: 15px;
}

select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    margin-bottom: 15px;
}

/* Additional CSS styling for buttons, confirmation message, etc. */

</style>
<main>
        <section class="deposit-form">
            <h2>Deposit Information</h2>
            <form action="process_deposit.php" method="POST">
                <div class="input-group">
                    <label for="amount">Amount to Deposit:</label>
                    <input type="number" id="amount" name="amount" required>
                </div>
                <div class="input-group">
                    <label for="payment-method">Payment Method:</label>
                    <select id="payment-method" name="payment-method">
                        <option value="credit-card">Lipa Na M-Pesa</option>
                     
                    </select>
                </div>
                <!-- Additional input fields for payment details based on selected method -->
                <div class="input-group">
                    <!-- Payment details input fields here -->
                </div>
                <div class="input-group">
    <label for="mpesa-transaction-id">M-Pesa Transaction ID:</label>
    <input type="text" id="mpesa-transaction-id" name="mpesa-transaction-id" required>
</div>

                <button type="submit">Deposit</button>
            </form>
            <div class="confirmation">
                <!-- Display deposit confirmation message here -->
            </div>
        </section>

        <section class="deposit-history">
            <h2>Deposit History</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Display deposit history records here -->
                </tbody>
            </table>
        </section>
    </main>
    <?php include_once('../templates/_footer.php'); ?>