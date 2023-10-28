<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

$user_id = $_SESSION['SESSION_EMAIL'];

if (!isset($user_id)) {
    header('location:../../login');
    exit;
}

// Check if the PIN is set for the user
include_once('../../assets/setup/db.php');

$query = "SELECT pin FROM agent_activity WHERE user_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row || empty($row['pin'])) {
    header('location: set_pin.php');
    exit;
}

// Handle withdrawal form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mpesa_number = $_POST['mpesa-phone'];
    $amount_withdrawn = $_POST['amount'];

    // Insert the withdrawal request into the 'withdrawal_requests' table
    $insertQuery = "INSERT INTO withdrawal_requests (user_id, mpesa_number, amount_withdrawn) VALUES (?, ?, ?)";
    $insertStmt = mysqli_prepare($conn, $insertQuery);

    if ($insertStmt) {
        mysqli_stmt_bind_param($insertStmt, "ssd", $user_id, $mpesa_number, $amount_withdrawn);
        mysqli_stmt_execute($insertStmt);

        // Send an email notification
        try {
            // Server settings
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'godfreymatagaro@gmail.com'; // SMTP username
            $mail->Password = 'mdnpxflcotixeabh'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Recipients
            $mail->setFrom('godfreymatagaro@gmail.com', 'Mailer');
            $mail->addAddress($user_id);

            $mail->isHTML(true);
            $mail->Subject = 'Withdrawal Request';
            $mail->Body = "Withdrawal request from user $user_id. Amount: $amount_withdrawn.";

            $mail->send();
            // Email sent successfully
        } catch (Exception $e) {
            // Email not sent
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
?>



<style>
   /* Reset some default styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    color: #333;
}

.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

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

input[type="text"],
input[type="number"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    margin-bottom: 15px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

table th, table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
}

table th {
    background-color: #007BFF;
    color: #fff;
}

button {
    background-color: #007BFF;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
}

button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}


input[type="text"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    margin-bottom: 15px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

table th, table td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: center;
}

table th {
    background-color: #007BFF;
    color: #fff;
}

/* ... (remaining CSS code) ... */

</style>
<?php include_once('../templates/_header.php') ?>
<main>
    <section class="withdrawal-form">
        <h2>Withdraw Funds</h2>
        <form action="" method="POST">
            <!-- <div class="input-group">
                <label for="agent-id">Agent ID:</label>
                 Generate a unique Agent ID using PHP -->
                <!-- <input type="text" id="agent-id" name="agent-id" value="<?php //echo generateAgentID(); ?>" readonly> -->
            <!-- </div> --> 
            <div class="input-group">
                <label for="mpesa-phone">Mpesa Phone Number:</label>
                <input type="text" id="mpesa-phone" name="mpesa-phone" required>
            </div>
            <div class="input-group">
                <label for="amount">Amount to Withdraw:</label>
                <input type="number" id="amount" name="amount" required>
            </div>
            <button type="submit" id="withdraw-button">Withdraw</button>
        </form>
    </section>

    <section class="withdrawal-history">
        <h2>Withdrawal History</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2023-10-28</td>
                    <td>KES 100.00</td>
                    <td>Completed</td>
                </tr>
                <!-- Add more rows for history -->
            </tbody>
        </table>
    </section>
</main>

<script>
    // Function to generate a unique Agent ID
    function generateAgentID() {
        // Generate a random 4-character alphanumeric ID
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let agentID = '';
        for (let i = 0; i < 4; i++) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            agentID += characters.charAt(randomIndex);
        }
        return agentID;
    }

    // Change the button text on form submission
    const withdrawButton = document.getElementById('withdraw-button');
    const form = document.querySelector('form');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        withdrawButton.textContent = 'Request Sent';
        withdrawButton.setAttribute('disabled', 'true');
        // You can add AJAX or other logic here to handle the form submission
    });
</script>

    <?php include_once('../templates/_footer.php'); ?>