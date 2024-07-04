<?php include_once('../model-templates/header.php') ?>

    <!-- Portfolio -->
    <?php include_once('../model-templates/portfolio.php') ?>
    <?php include_once('../model-templates/editorial.php') ?>
    <?php include_once('../model-templates/beauty.php') ?>
    <?php include_once('../model-templates/studio.php') ?>
    <?php
require '../../vendor/autoload.php';

include_once '../../assets/setup/db.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

// require 'path/to/PHPMailer/src/PHPMailer.php';
// require 'path/to/PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Initialize PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Set up SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Replace with your hosting provider's SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'godfreymatagaro@gmail.com';
        $mail->Password   = 'mdnpxflcotixeabh';
        $mail->SMTPSecure =  PHPMailer::ENCRYPTION_SMTPS; // Use TLS or SSL based on your provider's settings
        $mail->Port       = 465; // Use the appropriate port

        // Set up email content
        $mail->setFrom($_POST['email'], $_POST['name']);
        $mail->addAddress('godfreymatagaro@gmail.com');
        $mail->Subject = 'Model Application Form Submission';

        // Build the email body
        $message = "Name: " . $_POST['name'] . "\n";
        $message .= "Email: " . $_POST['email'] . "\n";
        $message .= "Message: " . $_POST['message'];
        $mail->Body = $message;

        // Attach uploaded photos
        if (!empty($_FILES['photos']['name'][0])) {
            foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
                $file_name = $_FILES['photos']['name'][$key];
                $file_tmp = $_FILES['photos']['tmp_name'][$key];
                $mail->addAttachment($file_tmp, $file_name);
            }
        }

        // Send the email
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
 <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container5 {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            resize: vertical;
        }

        input[type="file"] {
            margin-top: 5px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .contact-us{
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
        }
    </style>

<div class="container5">
        <h2 id="models-contact">Contact Us</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="photos">Photos (JPEG or PNG):</label>
            <input type="file" id="photos" name="photos[]" accept="image/jpeg, image/png" multiple required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <input type="submit" value="Submit">
        </form>
    </div>
    <?php include_once('../model-templates/footer.php') ?>
  


    
   