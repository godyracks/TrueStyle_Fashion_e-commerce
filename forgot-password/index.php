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


</style>

<br>
<br>
<br>
<br>

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
