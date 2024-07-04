<?php include_once('../assets/product-page-temp/product-header.php') ?>
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

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);

    $token_sql = "SELECT * FROM password_reset_tokens WHERE token='{$token}'";
    $token_result = mysqli_query($conn, $token_sql);

    if (mysqli_num_rows($token_result) > 0) {
        $row = mysqli_fetch_assoc($token_result);
        $user_id = $row['user_id'];

        if (isset($_POST['submit'])) {
            $password = mysqli_real_escape_string($conn, $_POST['password']);
            $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

            if ($password === $confirm_password) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $update_sql = "UPDATE user_info SET password='{$hashed_password}' WHERE id='{$user_id}'";
                $update_result = mysqli_query($conn, $update_sql);

                if ($update_result) {
                    // Delete the used token from the database
                    $delete_sql = "DELETE FROM password_reset_tokens WHERE token='{$token}'";
                    $delete_result = mysqli_query($conn, $delete_sql);

                    if ($delete_result) {
                        $msg = "<div class='alert alert-success'>Your password has been reset successfully. You can now <a href='../login'>login</a> with your new password.</div>";
                    } else {
                        $msg = "<div class='alert alert-danger'>Something went wrong while updating your password. Please try again later.</div>";
                    }
                } else {
                    $msg = "<div class='alert alert-danger'>Something went wrong while updating your password. Please try again later.</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Passwords do not match.</div>";
            }
        }
    } else {
        $msg = "<div class='alert alert-danger'>Invalid password reset token.</div>";
    }
} else {
    $msg = "<div class='alert alert-danger'>No password reset token provided.</div>";
}
?>

<!-- Rest of the HTML code -->

<!-- <br />
<br />
<br />
<br />
<br /> -->
<div class="container">
    <div class="content-wthree">
        <h2>Reset Your Password</h2>
        <?php echo $msg; ?>
        <form action="" method="post">
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="New Password" required>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm New Password" required>
            </div>
            <button name="submit" class="btn btn-primary" type="submit">Reset Password</button>
        </form>
        <div class="clearfix"></div>
    </div>
</div>

<!-- Rest of the HTML code -->
<?php include_once('../assets/cart-temp/cart-footer.php'); ?>