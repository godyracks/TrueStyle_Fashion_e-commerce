<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location:../product");
    die();
}

require '../vendor/autoload.php';
include_once '../assets/setup/db.php';

$msg = "";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "SELECT * FROM user_info WHERE email='{$email}'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];

        // Generate a random token
        $token = mysqli_real_escape_string($conn, bin2hex(random_bytes(16)));

        // Store the token in the database
        $token_sql = "INSERT INTO password_reset_tokens (user_id, token) VALUES ('{$user_id}', '{$token}')";
        $token_result = mysqli_query($conn, $token_sql);

        if ($token_result) {
            // Send the password reset link to the user's email
            $mail = new PHPMailer(true);

            try {
                $mail->SMTPDebug = SMTP::DEBUG_OFF;

                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'godfreymatagaro@gmail.com';
                $mail->Password = 'mdnpxflcotixeabh';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;

                $mail->setFrom('godfreymatagaro@gmail.com', 'Mailer');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Reset your password';
                $mail->Body = 'Please click on the following link to reset your password: <b><a href="http://localhost/truestylev1/reset-password?token=' . $token . '">http://localhost/truestylev1/reset-password?token=' . $token . '</a></b>';

                $mail->send();

                // Display success message as a styled dialog
                $msg = "<div id='success-msg' class='dialog'>
                            <h3 class='dialog-title'>Password Reset Link Sent</h3>
                            <p class='dialog-message'>We've sent a password reset link to your email address. Please check your inbox.</p>
                            <div class='dialog-btn-container'>
                                <button id='dialog-ok' class='dialog-btn'>OK</button>
                            </div>
                        </div>";

            } catch (Exception $e) {
                $msg = "<div class='alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Something went wrong while generating the password reset token.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Invalid email address.</div>";
    }
}
?>


<?php include_once('../assets/product-page-temp/product-header.php') ?>
<style>
  /* Container styling */
.container3 {
    margin-top: 50px;
}

/* Form container */
.content-wthree {
    background: #fff;
    padding: 25px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
}

/* Input container */
.input-container3 {
    display: flex;
    flex-direction: column;
}

.email,
.btn {
    margin-bottom: 10px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Button styling */
.btn {
    background-color: #3498db;
    border: none;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

.btn:hover {
    background-color: #2980b9;
}

/* Styled dialog */
.dialog {
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    display: none;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
}

.dialog-title {
    margin-top: 0;
}

.dialog-btn-container {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.dialog-btn {
    background-color: #3498db;
    border: none;
    color: #fff;
    padding: 5px 10px;
    border-radius: 3px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out;
}

.dialog-btn:hover {
    background-color: #2980b9;
}

/* Clearfix for floating elements */
.clearfix::after {
    content: "";
    display: table;
    clear: both;
}

/* Responsive adjustments */
@media screen and (max-width: 768px) {
    .container3 {
        margin-top: 30px;
    }

    .content-wthree {
        padding: 20px;
    }

    .email,
    .btn {
        padding: 8px;
    }

    .dialog {
        padding: 15px;
        max-width: 80%;
    }
}

</style>

<br>
<br>
<br>
<br>
s
<div class="container3">
    <div class="content-wthree">
        <h2>Forgot Password</h2>
        <?php echo $msg; ?>
        <form action="" method="post">
            <div class="input-container3">
                <input type="email" class="email" name="email" placeholder="Enter Your Email" required>
                <button name="submit" class="btn" type="submit">Reset Password</button>
            </div>
        </form>
        <div class="clearfix"></div>
    </div>
</div>

<!-- Include the jQuery library -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 

<!-- Custom JavaScript -->
<script>
    $(document).ready(function() {
        // Check if the success message is present
        if ($('#success-msg').length > 0) {
            // Display the success message as a styled dialog
            $('.input-container3').addClass('blur');
            $('#success-msg').fadeIn();

            // Redirect to the home page after the user clicks "OK"
            $('#dialog-ok').click(function() {
                window.location.href = '../home';
            });
        }
    });
</script>

<?php include_once('../assets/cart-temp/cart-footer.php'); ?>
