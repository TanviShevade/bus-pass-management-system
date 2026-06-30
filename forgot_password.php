<?php
session_start();
include "config.php";  // Ensure correct database connection

// Include PHPMailer manually
require "PHPMailer/src/PHPMailer.php";
require "PHPMailer/src/SMTP.php";
require "PHPMailer/src/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Generate a random OTP
   $otp = rand(100000, 999999);
        $_SESSION["reset_otp"] = $otp;
        $_SESSION["reset_email"] = $email;

        // Create PHPMailer instance
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tanvishevade25@gmail.com'; // Replace with your Gmail
            $mail->Password = 'uwrw fxiv wvbv pets'; // Replace with your App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('tanvishevade25@gmail.com', 'Bartakke Institute');
            $mail->addAddress($email);
            $mail->Subject = "Password Reset OTP";
            $mail->Body = "Your OTP for password reset is: $otp";

            $mail->send();
            echo "<script>alert('OTP sent to your email. Check inbox/spam folder.'); window.location='reset_password.php';</script>";
        } catch (Exception $e) {
            echo "<script>alert('Error sending email: {$mail->ErrorInfo}');</script>";
        }
    } else {
        echo "<script>alert('Email not found!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center text-" style="color: indianred;">Forgot Password</h2>
        <form method="POST" class="shadow p-4 bg-white">
            <div class="mb-3">
                <label class="form-label">Enter Your Registered Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <button type="submit" class="btn btn- w-100" style="color:white;background-color: indianred;">Send OTP</button>
        </form>
    </div>
</body>
</html>