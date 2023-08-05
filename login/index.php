<?php 
include_once '../assets/setup/db.php';
?>
<?php
//session_start();
if (isset($_SESSION['SESSION_EMAIL'])) {
    // Check if the user is already logged in
    header("Location:../product");
    die();
}


$msg = "";

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['psw']; // Changed from 'password' to 'psw'

    $sql = "SELECT * FROM user_info WHERE email='{$email}'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        $msg = "An error occurred while executing the query: " . mysqli_error($conn);
    } else {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password'];

            if (password_verify($password, $hashed_password)) {
                if ($row['is_verified'] == 1) {
                    if ($email == 'godfreymatagaro@gmail.com') {
                        // Check if the user is an admin
                        $_SESSION['SESSION_EMAIL'] = $email;
                        $_SESSION['SESSION_NAME'] = $row['name'];
                        header("Location:../admin");
                        die();
                    } else {
                        // Normal user
                        $_SESSION['SESSION_EMAIL'] = $email;
                        $_SESSION['SESSION_NAME'] = $row['name'];
                        header("Location:../user-profile");
                        die();
                    }
                } else {
                    $msg = "Your email is not verified yet. Please check your inbox for the verification link.";
                }
            } else {
                $msg = "Invalid email or password.";
            }
        } else {
            $msg = "Invalid email or password.";
        }
    }
}
?>

<?php include_once('../assets/product-page-temp/product-header.php'); ?>

<div class="container">
    <div class="login-form">
        <form method="post">
            <!-- Your form content -->
            <h1>Login</h1>
          <p>
            Already have an account? Login in or
            <a href="../signup">Sign Up</a>
          </p>


            <?php if (!empty($msg)) : ?>
                <div class="dialog active">
                    <div class="dialog-content">
                        <h2>Error</h2>
                        <p><?php echo $msg; ?></p>
                        <button onclick="location.href='../home'">OK</button>
                    </div>
                </div>
            <?php endif; ?>
            <label for="email">Email</label>
            <input type="text" placeholder="Enter Email" name="email" required />

            <label for="psw">Password</label>
            <input type="password" placeholder="Enter Password" name="psw" required />

            <label>
                <input type="checkbox" checked="checked" name="remember" style="margin-bottom: 15px" />
                Remember me
            </label>
            <p><a href="../forgot-password" style="margin-bottom: 15px; display: block; text-align: right;">Forgot Password?</a></p>

            <div class="buttons">
                <button type="button" class="cancelbtn"><a href="../home">Cancel</a></button>
                <button type="submit" class="signupbtn" name="submit">Login</button>
            </div>
            <!-- Rest of your form content -->
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