<?php
//session_start(); // Initialize the session

include_once '../assets/setup/db.php';

$msg = "";

if (isset($_SESSION['SESSION_EMAIL'])) {
    // Check if the user is already logged in
    header("Location:../product");
    die();
}

if (isset($_POST['submit'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['psw'];

    // Validate and sanitize the password
    if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/', $password)) {
        // Password meets the policy requirements
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("SELECT * FROM user_info WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            $msg = "An error occurred while executing the query.";
        } else {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $hashed_password_db = $row['password'];

                if (password_verify($password, $hashed_password_db)) {
                    if ($row['is_verified'] == 1) {
                        $adminEmails = array('godfreymatagaro@gmail.com', 'gmatagaro4@gmail.com', 'yetanotheradmin@example.com');
                
                        if (in_array($email, $adminEmails)) {
                            $_SESSION['SESSION_EMAIL'] = $email;
                            $_SESSION['SESSION_NAME'] = $row['name'];
                            header("Location:../admin");
                            die();
                        } else {
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
    } else {
        $msg = "Password must be at least 6 characters long and contain a mixture of letters, special characters, and numbers.";
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
                Already have an account? Login or
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
            <input type="email" placeholder="Enter Email" name="email" required />

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
