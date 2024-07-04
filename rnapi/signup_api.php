<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require '../vendor/autoload.php';

include_once '../assets/setup/db.php';

header('Content-Type: application/json');

$response = array(); // Initialize the response array

if (isset($_POST['submit'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];
    $code = bin2hex(random_bytes(16)); // Generate a random code

    // Validate password
    if (preg_match('/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{6,}$/', $password)) {
        if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_info WHERE email='{$email}'")) > 0) {
            $response['error'] = "{$email} - This email address already exists. Kindly Log in.";
        } elseif (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user_info WHERE name='{$name}'")) > 0) {
            $response['error'] = "{$name} - This username already exists. Kindly Log in.";
        } else {
            if ($password === $confirm_password) {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO user_info (name, email, password, is_verified) VALUES (?, ?, ?, 0)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss", $name, $email, $hashed_password);

                if ($stmt->execute()) {
                    $user_id = $stmt->insert_id; // Get the last inserted user ID

                    $token = bin2hex(random_bytes(16)); // Generate a random token
                    $token_sql = "INSERT INTO auth_tokens (user_id, token) VALUES (?, ?)";
                    $token_stmt = $conn->prepare($token_sql);
                    $token_stmt->bind_param("is", $user_id, $token);

                    if ($token_stmt->execute()) {
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
                            $response['message'] = "We've sent a verification link to your email address. Please check your inbox.";
                        } catch (Exception $e) {
                            $response['error'] = "Message could not be sent. Check your internet connection. Mailer Error: {$mail->ErrorInfo}";
                        }
                    } else {
                        $response['error'] = "Something went wrong while generating the verification token.";
                    }
                } else {
                    $response['error'] = "Something went wrong while inserting the user record.";
                }
            } else {
                $response['error'] = "Password and Confirm Password do not match";
            }
        }
    } else {
        $response['error'] = "Password must be at least 6 characters long and contain a mixture of letters, special characters, and numbers.";
    }
} else {
    $response['error'] = "Invalid request. 'submit' parameter missing.";
}

echo json_encode($response);
?>
