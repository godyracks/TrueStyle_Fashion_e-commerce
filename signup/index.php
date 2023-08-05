<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    header("Location:/products");
    die();
}
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;

// Load Composer's autoloader
require '../vendor/autoload.php';

include_once '../assets/setup/db.php';
$msg = "";

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $code = mysqli_real_escape_string($conn, bin2hex(random_bytes(16))); // Generate a random code

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_info WHERE email='{$email}'")) > 0) {
        $msg = "<div class='alert alert-danger' >{$email} - This email address already exists.Kindly Log in.</div>";
    } elseif (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_info WHERE name='{$name}'")) > 0) {
        $msg = "<div class='alert alert-danger'>{$name} - This username already exists. Kindly Log in.</div>";
    } else {
        if ($password === $confirm_password) {
            $hashed_password = mysqli_real_escape_string($conn, password_hash($password, PASSWORD_DEFAULT));
            $sql = "INSERT INTO user_info (name, email, password, is_verified) VALUES ('{$name}', '{$email}', '{$hashed_password}', 0)";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $user_id = mysqli_insert_id($conn); // Get the last inserted user ID

                $token = mysqli_real_escape_string($conn, bin2hex(random_bytes(16))); // Generate a random token
                $token_sql = "INSERT INTO auth_tokens (user_id, token) VALUES ('{$user_id}', '{$token}')";
                $token_result = mysqli_query($conn, $token_sql);

                if ($token_result) {
                    // Create an instance of PHPMailer
                    $mail = new PHPMailer(true);

                    try {
                        // Server settings
                        $mail->SMTPDebug = SMTP::DEBUG_OFF;// disable verbose debug output
                        $mail->isSMTP(); // Send using SMTP
                        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
                        $mail->SMTPAuth = true; // Enable SMTP authentication
                        $mail->Username = 'godfreymatagaro@gmail.com'; // SMTP username
                        $mail->Password = 'mdnpxflcotixeabh'; // SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
                        $mail->Port = 465; // TCP port to connect to

                        // Recipients
                        $mail->setFrom('godfreymatagaro@gmail.com', 'Mailer');
                        $mail->addAddress($email);

                        // Content
                        $mail->isHTML(true); // Set email format to HTML
                        $mail->Subject = 'Verify your email address';
                        $mail->Body = 'Thank you for registering! Please click on the following link to verify your email address: <b><a href="http://localhost/truestylev1/verify/?token=' . $token . '">http://localhost/truestylev1/verify/?token=' . $token . '</a></b>';

                        $mail->send();
                        $msg = "<div class='alert alert-info'>We've sent a verification link to your email address. Please check your inbox.</div>";
                    } catch (Exception $e) {
                        $msg = "<div class='alert alert-danger'>Message could not be sent. Check your internet connection.Mailer Error: {$mail->ErrorInfo}</div>";
                    }
                } else {
                    $msg = "<div class='alert alert-danger'>Something went wrong while generating the verification token.</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Something went wrong while inserting the user record.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
        }
    }
    // if (!$result) {
    //     $error = mysqli_error($conn);
    //     $msg = "<div class='alert alert-danger'>Error: {$error}</div>";
    // }
    //for debugging the register form -----matagaro//
    
}
?>
<?php include_once('../assets/product-page-temp/product-header.php') ?>

<!-- Your sign-up form HTML code -->
<div class="container">
  <div class="login-form">
    <form method="post">
      <h1>Sign Up</h1>
      <p>
        Please fill in this form to create an account. or
        <a href="../login">Login</a>
      </p>
      <?php echo $msg; ?>

      <!-- Rest of your form fields -->
      <label for="user">Username</label>
      <input type="text" placeholder="Enter Username" name="name" required />
      <label for="email">Email</label>
      <input type="email" placeholder="Enter Email" name="email" required />

      <label for="psw">Password</label>
      <input type="password" placeholder="Enter Password" name="password" required />

      <label for="psw-repeat">Repeat Password</label>
      <input type="password" placeholder="Repeat Password" name="confirm-password" required />

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

<!-- Your cart footer -->
<?php include_once('../assets/cart-temp/cart-footer.php'); ?>
