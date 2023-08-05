
<?php
// Load Composer's autoloader
require '../vendor/autoload.php';

include_once '../assets/setup/db.php';

$msg = '';

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);

    // Check if the token exists in the auth_tokens table
    $token_query = "SELECT * FROM auth_tokens WHERE token = '{$token}'";
    $token_result = mysqli_query($conn, $token_query);

    if (mysqli_num_rows($token_result) > 0) {
        $token_row = mysqli_fetch_assoc($token_result);
        $user_id = $token_row['user_id'];

        // Update the is_verified column in the users table
        $update_query = "UPDATE user_info SET is_verified = 1 WHERE id = {$user_id}";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            // Delete the token from the auth_tokens table
            $delete_query = "DELETE FROM auth_tokens WHERE token = '{$token}'";
            $delete_result = mysqli_query($conn, $delete_query);

            if ($delete_result) {
                $msg = "<div class='alert alert-success'>Your email has been verified successfully. You can now login.</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Something went wrong while deleting the verification token.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Something went wrong while updating the user's verification status.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>Invalid verification token.</div>";
    }
} else {
    $msg = "<div class='alert alert-danger'>Verification token not found.</div>";
}
?>
 <style>
    

        .container3 {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }

    

     
    </style>
    <?php include_once('../assets/product-page-temp/product-header.php') ?>

<!-- Rest of the HTML code -->
<div class="container3">
        <h2>Email Verification</h2>
        <?php echo $msg; ?>
        <p>After Verification, Please click here to login <a href="../login">Login</a></p>
    </div>
   <!-- Your cart footer -->
<?php include_once('../assets/cart-temp/cart-footer.php'); ?>