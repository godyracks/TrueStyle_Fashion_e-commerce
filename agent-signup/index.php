<?php
//session_start(); // Initialize the session

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location:/products");
    die();
}

// Load Composer's autoloader
require '../vendor/autoload.php';

include_once '../assets/setup/db.php';

$msg = "";

if (isset($_POST['submit'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $code = bin2hex(random_bytes(16)); // Generate a random code
    $selected_option = $_POST['user-type']; // Get the selected option ("Not Sure," "Yes," or "No")

    // Convert the selected option to "agent" or "user"
    $user_type = ($selected_option === "Yes") ? "agent" : "agent";

    $referral_code = filter_input(INPUT_GET, 'referral_code', FILTER_SANITIZE_STRING); // Get referral code from the URL

    // If you have a valid referral code, get the referrer's user_id
    $referrer_id = null;
    if (!empty($referral_code)) {
        $sql = "SELECT email, referrer_id, level FROM agent_activity WHERE referral_code = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $referral_code);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $referrer_id = $row['email'];
                $referrer_referrer_id = $row['referrer_id'];
                $referrer_level = $row['level'];
            }
        }
    }

    // Validate password
    if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/', $password)) {
        $emailExists = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_info WHERE email='{$email}'"));
        $nameExists = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_info WHERE name='{$name}'"));

        if ($emailExists > 0) {
            $msg = "<div class='alert alert-danger'>{$email} - This email address already exists. Kindly Log in.</div>";
        } elseif ($nameExists > 0) {
            $msg = "<div class='alert alert-danger'>{$name} - This username already exists. Kindly Log in.</div>";
        } else {
            if ($password === $confirm_password) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO user_info (name, email, password, is_verified, user_type) VALUES (?, ?, ?, 0, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $name, $email, $hashed_password, $user_type);

                if ($stmt->execute()) {
                    $user_id = $stmt->insert_id; // Get the last inserted user ID

                    // Insert the user's referral code
                    if (empty($referral_code)) {
                        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        $referral_code = '';
                        for ($i = 0; $i < 10; $i++) {
                            $referral_code .= $characters[random_int(0, strlen($characters) - 1)];
                        }
                        var_dump($referral_code);

                        // Insert a record into the agent_activity table
                        $activity_sql = "INSERT INTO agent_activity (agent_id, email, referral_code, referrer_id, level) VALUES (?, ?, ?, ?, ?)";
                        $activity_stmt = $conn->prepare($activity_sql);

                        if (!empty($referral_code) && !empty($referrer_id)) {
                            $referrer_level += 1;
                            $activity_stmt->bind_param("issii", $user_id, $email, $referral_code, $referrer_id, $referrer_level);
                        } else {
                            $referrer_level = 1;
                            $activity_stmt->bind_param("issii", $user_id, $email, $referral_code, $referrer_id, $referrer_level);
                        }

                        if ($activity_stmt->execute()) {
                            // Agent's activity record successfully inserted

                            if (!empty($referrer_id)) {
                                // If there's a referrer, update their information
                                $update_referrer_sql = "UPDATE agent_activity SET referrer_id = ?, level = ? WHERE agent_id = ?";
                                $update_referrer_stmt = $conn->prepare($update_referrer_sql);
                                $update_referrer_stmt->bind_param("iii", $user_id, $referrer_level, $referrer_id);

                                if ($update_referrer_stmt->execute()) {
                                    // Referrer's information updated
                                } else {
                                    $msg = "<div class='alert alert-danger'>Something went wrong while updating the referrer's information.</div>";
                                }
                            }
                            // You can add additional logic or a success message here if needed
                        } else {
                            $msg = "<div class='alert alert-danger'>Something went wrong while inserting agent activity record.</div>";
                        }
                    }

                    // Generate a random token
                    $token = bin2hex(random_bytes(16));

                    // SQL query to insert the token into the auth_tokens table
                    $token_sql = "INSERT INTO auth_tokens (user_id, token) VALUES (?, ?)";
                    $token_stmt = $conn->prepare($token_sql);
                    $token_stmt->bind_param("is", $user_id, $token);

                    if ($token_stmt->execute()) {
                        // Token successfully inserted
                        // You can add any additional logic or success message here
                    } else {
                        $msg = "<div class='alert alert-danger'>Something went wrong while generating the verification token.</div>";
                    }

                    // Create an instance of PHPMailer
                    $mail = new PHPMailer(true);

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
                        $mail->addAddress($email);

                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Verify your email address';
                        $mail->Body = 'Thank you for registering! Please click on the following link to verify your email address: <b><a href="http://localhost/truestylev1/verify/?token=' . $token . '">http://localhost/truestylev1/verify/?token=' . $token . '</a></b>';

                        $mail->send();
                        $msg = "<div class='alert alert-info'>We've sent a verification link to your email address. Please check your inbox.</div>";
                    } catch (Exception $e) {
                        $msg = "<div class='alert alert-danger'>Message could not be sent. Check your internet connection.Mailer Error: {$mail->ErrorInfo}</div>";
                    }
                } else {
                    $msg = "<div class='alert alert-danger'>Something went wrong while inserting the user record.</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
            }
        }
    } else {
        $msg = "<div class='alert alert-danger'>Password must be at least 6 characters long and contain a mixture of letters, special characters, and numbers.</div>";
    }
}


// Function to generate a sequential four-figure alphanumeric Agent ID

?>


<?php include_once('../assets/product-page-temp/product-header.php') ?>
<style>
    .agent-label {
    font-size: 18px;
    color: #333;
    margin-bottom: 10px;
}

.agent-select {
    font-size: 16px;
    border: 2px solid #333;
    padding: 5px;
    border-radius: 5px;
    background-color: #f0f0f0;
    color: #333;
    width: 150px;
}

/* Style the "Yes" and "No" options differently if needed */
.agent-select option {
    background-color: #f0f0f0;
    color: #333;
}

/* Hover and focus styles for better user interaction */
.agent-select:hover,
.agent-select:focus {
    border-color: #007BFF;
    background-color: #fff;
}

/* Apply transition for smooth animations */
.agent-select {
    transition: border-color 0.3s, background-color 0.3s;
}

</style>

<div class="container">
    <div class="login-form">
        <form method="post">
            <h1>Sign Up</h1>
            <p>
                Please fill in this form to create an account. or
                <a href="../login">Login</a>
            </p>
            <?php echo $msg; ?>

            <label for="user">Username</label>
            <input type="text" placeholder="Enter Username" name="name" required />

            <label for="email">Email</label>
            <input type="email" placeholder="Enter Email" name="email" required />

            <label for="psw">Password</label>
            <input type="password" placeholder="Enter Password" name="password" required />

            <label for="psw-repeat">Repeat Password</label>
            <input type="password" placeholder="Repeat Password" name="confirm-password" required />

            <label for="user-type" class="agent-label">Register as a TrueStyle Agent?</label>
                <select name="user-type" class="agent-select" required>
                    <option value="user">Not Sure</option>
                    <option value="agent">Yes</option>
                    
                </select>



            <label>
                <input type="checkbox" checked="checked" name="remember" style="margin-bottom: 15px" />
                Remember me
            </label>

            <p>
                By creating an account you agree to our
                <a href="#">Terms & Privacy</a>.
            </p>

            <div class="buttons">
                <button type="button" class="cancelbtn"><a href="../home">Cancel</a></button>
                <button type="submit" class="signupbtn" name="submit">Sign Up</button>
            </div>
        </form>
    </div>
</div>
<!-- Your scripts and footer includes -->
<script>
    var modal = document.getElementById('error-modal');
    var okButton = document.getElementById('ok-button');

    okButton.addEventListener('click', function () {
        window.location.href = '../login';
    });

    function displayErrorModal() {
        modal.style.display = 'block';
    }
</script>

<?php include_once('../assets/cart-temp/cart-footer.php'); ?>